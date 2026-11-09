<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OwnerController extends Controller
{
    // Menampilkan daftar seluruh akun Owner.
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $owners = User::where('role', 'owner')
            ->with('ownerProfile')
            ->withCount('venues')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $totalOwners = User::where('role', 'owner')->count();

        $activeOwners = User::where('role', 'owner')
            ->where('account_status', 'active')
            ->count();

        $inactiveOwners = User::where('role', 'owner')
            ->where('account_status', 'inactive')
            ->count();

        $verifiedOwners = User::where('role', 'owner')
            ->whereHas('ownerProfile', function ($query) {
                $query->where('verification_status', 'verified');
            })
            ->count();

        $pendingOwners = User::where('role', 'owner')
            ->whereHas('ownerProfile', function ($query) {
                $query->where('verification_status', 'pending');
            })
            ->count();

        return view('admin.owners.index', compact(
            'owners',
            'search',
            'totalOwners',
            'activeOwners',
            'inactiveOwners',
            'verifiedOwners',
            'pendingOwners'
        ));
    }

    // Menampilkan detail akun Owner.
    public function show(User $owner): View
    {
        abort_unless($owner->role === 'owner', 404);

        $owner->load([
            'ownerProfile.verifier',
            'venues.sport'
        ]);

        return view('admin.owners.show', compact('owner'));
    }

    // Mengaktifkan atau menonaktifkan akun Owner.
    public function updateStatus(User $owner): RedirectResponse
    {
        // Memastikan akun yang diubah benar-benar Owner.
        abort_unless($owner->role === 'owner', 404);

        // Mengubah status akun.
        $owner->account_status = $owner->account_status === 'active'
            ? 'inactive'
            : 'active';

        $owner->save();

        // Menentukan pesan berdasarkan status terbaru.
        $message = $owner->account_status === 'active'
            ? 'Akun Owner berhasil diaktifkan.'
            : 'Akun Owner berhasil dinonaktifkan.';

        return redirect()
            ->route('admin.owners.show', $owner->id)
            ->with('success', $message);
    }

    // Menampilkan dokumen identitas Owner secara privat.
    public function showDocument(User $owner): StreamedResponse
    {
        abort_unless($owner->role === 'owner', 404);

        $profile = $owner->ownerProfile;

        abort_unless(
            $profile && $profile->identity_document_path,
            404
        );

        $path = $profile->identity_document_path;

        abort_unless(Storage::disk('local')->exists($path), 404);

        return Storage::disk('local')->response($path);
    }


    // Menyetujui verifikasi profil Owner.
    public function verify(User $owner): RedirectResponse
    {
        abort_unless($owner->role === 'owner', 404);

        $profile = $owner->ownerProfile;

        if (!$profile) {
            return back()->with('error', 'Owner belum melengkapi profil usaha.');
        }

        if (!$profile->business_name || !$profile->identity_number || !$profile->identity_document_path) {
            return back()->with('error', 'Profil belum lengkap. Nama usaha, NIK, dan dokumen identitas wajib tersedia.');
        }

        if (!Storage::disk('local')->exists($profile->identity_document_path)) {
            return back()->with('error', 'Dokumen identitas tidak ditemukan. Owner harus mengunggah ulang dokumen.');
        }

        $profile->verification_status = 'verified';
        $profile->verification_notes = null;
        $profile->verified_by = auth()->id();
        $profile->verified_at = now();
        $profile->save();

        return redirect()
            ->route('admin.owners.show', $owner->id)
            ->with('success', 'Profil Owner berhasil diverifikasi.');
    }


    // Menolak verifikasi profil Owner.
    public function reject(Request $request, User $owner): RedirectResponse
    {
        abort_unless($owner->role === 'owner', 404);

        $validated = $request->validate([
            'verification_notes' => ['required', 'string', 'max:2000'],
        ], [
            'verification_notes.required' => 'Alasan penolakan wajib diisi.',
            'verification_notes.max' => 'Alasan penolakan maksimal 2000 karakter.',
        ]);

        $profile = $owner->ownerProfile;

        if (!$profile) {
            return back()->with('error', 'Owner belum memiliki profil usaha.');
        }

        $profile->verification_status = 'rejected';
        $profile->verification_notes = $validated['verification_notes'];
        $profile->verified_by = auth()->id();
        $profile->verified_at = null;
        $profile->save();

        return redirect()
            ->route('admin.owners.show', $owner->id)
            ->with('success', 'Verifikasi profil Owner berhasil ditolak.');
    }
}
