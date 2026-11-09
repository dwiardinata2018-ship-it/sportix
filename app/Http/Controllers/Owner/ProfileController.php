<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\OwnerProfile;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    // Menampilkan halaman profil Owner.
    public function edit(Request $request): View
    {
        $profile = $request->user()->ownerProfile;

        return view('owner.profile.edit', compact('profile'));
    }

    // Menyimpan atau memperbarui profil Owner.
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'business_name' => ['required', 'string', 'max:150'],
            'identity_number' => ['required', 'string', 'max:50'],
            'identity_document' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:2048',
            ],
        ]);

        $owner = $request->user();

        $profile = OwnerProfile::firstOrNew([
            'user_id' => $owner->id,
        ]);

        // Menyimpan dokumen identitas secara privat.
        if ($request->hasFile('identity_document')) {
            // Hapus dokumen lama jika tersedia.
            if ($profile->identity_document_path) {
                Storage::disk('local')->delete(
                    $profile->identity_document_path
                );
            }

            $path = $request->file('identity_document')
                ->store('owner-documents/' . $owner->id, 'local');

            $profile->identity_document_path = $path;
        }

        // Memperbarui data profil.
        $profile->business_name = $validated['business_name'];
        $profile->identity_number = $validated['identity_number'];

        // Setiap pengiriman atau perubahan data perlu diverifikasi ulang.
        $profile->verification_status = 'pending';
        $profile->verification_notes = null;
        $profile->verified_by = null;
        $profile->verified_at = null;

        $profile->save();

        return redirect()
            ->route('owner.profile.edit')
            ->with('success', 'Profil berhasil disimpan dan menunggu verifikasi Admin.');
    }
}
