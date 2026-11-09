<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Sport;
use App\Models\Venue;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class VenueController extends Controller
{
    /**
     * Menampilkan daftar venue milik Owner.
     */
    public function index(Request $request): View
    {
        $venues = $request->user()
            ->venues()
            ->with([
                'sport',
                'images' => function ($query) {
                    $query->orderByDesc('is_primary')
                        ->orderBy('display_order');
                },
            ])
            ->latest()
            ->paginate(10);

        return view('owner.venues.index', compact('venues'));
    }

        /**
     * Menampilkan form pendaftaran venue.
     */
    public function create(): View
    {
        $sports = Sport::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('owner.venues.create', compact('sports'));
    }

/**
 * Menyimpan venue baru milik Owner beserta foto.
 */
public function store(Request $request): RedirectResponse
{
    // 1. Validasi data venue dan foto.
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:180'],

        'sport_id' => [
            'required',
            Rule::exists('sports', 'id')
                ->where('is_active', true),
        ],

        'description' => ['nullable', 'string'],
        'address' => ['required', 'string'],

        'village' => ['nullable', 'string', 'max:100'],
        'district' => ['nullable', 'string', 'max:100'],
        'city' => ['required', 'string', 'max:100'],
        'province' => ['required', 'string', 'max:100'],
        'postal_code' => ['nullable', 'string', 'max:10'],

        'latitude' => [
            'nullable',
            'numeric',
            'between:-90,90',
        ],

        'longitude' => [
            'nullable',
            'numeric',
            'between:-180,180',
        ],

        'whatsapp_number' => [
            'nullable',
            'string',
            'max:25',
        ],

        'instagram_url' => [
            'nullable',
            'url',
            'max:255',
        ],

        'venue_type' => [
            'required',
            Rule::in(['indoor', 'outdoor', 'mixed']),
        ],

        // Maksimal 5 foto, masing-masing maksimal 2 MB.
        'images' => ['nullable', 'array', 'max:5'],
        'images.*' => [
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:2048',
        ],
    ]);

    // 2. Membuat slug unik.
    $baseSlug = Str::slug($validated['name']);
    $slug = $baseSlug;
    $counter = 1;

    while (Venue::where('slug', $slug)->exists()) {
        $slug = $baseSlug . '-' . $counter;
        $counter++;
    }

    // Menyiapkan daftar file untuk keperluan cleanup jika gagal.
    $uploadedFiles = [];

    try {
        // 3. Menyimpan venue dan data fotonya dalam transaksi database.
        DB::transaction(function () use (
            $request,
            $validated,
            $slug,
            &$uploadedFiles
        ) {
            $venue = $request->user()->venues()->create([
                'sport_id' => $validated['sport_id'],
                'name' => $validated['name'],
                'slug' => $slug,
                'description' => $validated['description'] ?? null,
                'address' => $validated['address'],
                'village' => $validated['village'] ?? null,
                'district' => $validated['district'] ?? null,
                'city' => $validated['city'],
                'province' => $validated['province'],
                'postal_code' => $validated['postal_code'] ?? null,
                'latitude' => $validated['latitude'] ?? null,
                'longitude' => $validated['longitude'] ?? null,
                'whatsapp_number' => $validated['whatsapp_number'] ?? null,
                'instagram_url' => $validated['instagram_url'] ?? null,
                'venue_type' => $validated['venue_type'],

                // Status awal ditentukan oleh sistem.
                'verification_status' => 'pending',
                'venue_status' => 'inactive',
            ]);

            // 4. Menyimpan foto venue.
            $images = $request->file('images', []);

            foreach ($images as $index => $image) {

                $path = $image->store(
                    'venues/' . $venue->id,
                    'public'
                );

                if (!$path) {
                    throw new \RuntimeException(
                        'Gagal menyimpan foto venue.'
                    );
                }

                $uploadedFiles[] = $path;

                // 5. Mencatat foto ke tabel venue_images.
                $venue->images()->create([
                    'image_path' => $path,
                    'caption' => $venue->name,
                    'is_primary' => $index === 0,
                    'display_order' => $index + 1,
                ]);
            }
        });
    } catch (\Throwable $e) {

        // Menghapus file jika transaksi database gagal.
        Storage::disk('public')->delete($uploadedFiles);

        throw $e;
    }

    return redirect()
        ->route('owner.venues.index')
        ->with(
            'success',
            'Venue berhasil didaftarkan dan menunggu verifikasi Admin.'
        );
}
/**
 * Menampilkan detail venue milik Owner.
 */
public function show(Request $request, int $id): View
{
    $venue = $request->user()
        ->venues()
        ->with([
            'sport',
            'images',
            'units',
            'facilities',
            'operatingHours',
            'pricingRules',
        ])
        ->findOrFail($id);

    return view('owner.venues.show', compact('venue'));
}
/**
 * Menampilkan form edit venue milik Owner.
 */
public function edit(Request $request, int $id): View
{
    $venue = $request->user()
        ->venues()
        ->with('images')
        ->findOrFail($id);

    $sports = Sport::where('is_active', true)
        ->orderBy('name')
        ->get();

    return view('owner.venues.edit', compact(
        'venue',
        'sports'
    ));
}


/**
 * Memperbarui informasi venue milik Owner.
 */
public function update(Request $request, int $id): RedirectResponse
{
    $venue = $request->user()
        ->venues()
        ->findOrFail($id);

        $existingImageCount = $venue->images()->count();

        $remainingImageSlots = max(0, 5 - $existingImageCount);

    $validated = $request->validate([
        'name' => ['required', 'string', 'max:180'],

        'sport_id' => [
            'required',
            Rule::exists('sports', 'id')
                ->where('is_active', true),
        ],

        'description' => ['nullable', 'string'],
        'address' => ['required', 'string'],
        'village' => ['nullable', 'string', 'max:100'],
        'district' => ['nullable', 'string', 'max:100'],
        'city' => ['required', 'string', 'max:100'],
        'province' => ['required', 'string', 'max:100'],
        'postal_code' => ['nullable', 'string', 'max:10'],

        'latitude' => ['nullable', 'numeric', 'between:-90,90'],
        'longitude' => ['nullable', 'numeric', 'between:-180,180'],

        'whatsapp_number' => ['nullable', 'string', 'max:25'],
        'instagram_url' => ['nullable', 'url', 'max:255'],

        'venue_type' => [
            'required',
            Rule::in(['indoor', 'outdoor', 'mixed']),
        ],

        'images' => [
                    'nullable',
                    'array',
                    'max:' . $remainingImageSlots,
                ],
        'images.*' => [
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:2048',
        ],
    ]);

    $venue->update([
        'name' => $validated['name'],
        'sport_id' => $validated['sport_id'],
        'description' => $validated['description'] ?? null,
        'address' => $validated['address'],
        'village' => $validated['village'] ?? null,
        'district' => $validated['district'] ?? null,
        'city' => $validated['city'],
        'province' => $validated['province'],
        'postal_code' => $validated['postal_code'] ?? null,
        'latitude' => $validated['latitude'] ?? null,
        'longitude' => $validated['longitude'] ?? null,
        'whatsapp_number' => $validated['whatsapp_number'] ?? null,
        'instagram_url' => $validated['instagram_url'] ?? null,
        'venue_type' => $validated['venue_type'],
    ]);
    // Menambahkan foto baru jika Owner mengunggah foto.
    $images = $request->file('images', []);

    foreach ($images as $index => $image) {

        $path = $image->store(
            'venues/' . $venue->id,
            'public'
        );

        if (!$path) {
            throw new \RuntimeException(
                'Gagal menyimpan foto venue.'
            );
        }

        $venue->images()->create([
            'image_path' => $path,
            'caption' => $venue->name,
            'is_primary' => $existingImageCount === 0 && $index === 0,
            'display_order' => $existingImageCount + $index + 1,
        ]);
    }

    return redirect()
        ->route('owner.venues.show', $venue->id)
        ->with('success', 'Informasi venue berhasil diperbarui.');
}

/**
 * Menghapus foto venue milik Owner.
 */
public function destroyImage(
    Request $request,
    int $id,
    int $imageId
): RedirectResponse {

    // Memastikan venue adalah milik Owner yang sedang login.
    $venue = $request->user()
        ->venues()
        ->findOrFail($id);

    // Memastikan foto tersebut benar-benar milik venue.
    $image = $venue->images()
        ->findOrFail($imageId);

    // Menyimpan informasi foto sebelum dihapus.
    $imagePath = $image->image_path;
    $wasPrimary = $image->is_primary;

    // Menghapus data foto dari database.
    $image->delete();

    // Menghapus file foto dari penyimpanan.
    Storage::disk('public')->delete($imagePath);

    // Jika foto utama dihapus, pilih foto lain sebagai utama.
    if ($wasPrimary) {
        $newPrimaryImage = $venue->images()
            ->orderBy('display_order')
            ->orderBy('id')
            ->first();

        if ($newPrimaryImage) {
            $newPrimaryImage->update([
                'is_primary' => true,
            ]);
        }
    }

    return redirect()
        ->route('owner.venues.edit', $venue->id)
        ->with('success', 'Foto venue berhasil dihapus.');
}
/**
 * Mengatur foto utama venue.
 */
public function setPrimaryImage(
    Request $request,
    int $id,
    int $imageId
): RedirectResponse {

    // Memastikan venue adalah milik Owner yang sedang login.
    $venue = $request->user()
        ->venues()
        ->findOrFail($id);

    // Memastikan foto tersebut milik venue yang dipilih.
    $image = $venue->images()
        ->findOrFail($imageId);

    // Mengatur foto utama dalam satu transaksi database.
    DB::transaction(function () use ($venue, $image) {

        // Mengubah seluruh foto venue menjadi bukan foto utama.
        $venue->images()->update([
            'is_primary' => false,
        ]);

        // Menjadikan foto yang dipilih sebagai foto utama.
        $image->update([
            'is_primary' => true,
        ]);
    });

    return redirect()
        ->route('owner.venues.edit', $venue->id)
        ->with('success', 'Foto utama berhasil diperbarui.');
        
}
/**
 * Mengaktifkan atau menonaktifkan venue milik Owner.
 */
public function updateStatus(Request $request, int $id): RedirectResponse
{
    // Memastikan venue merupakan milik Owner yang sedang login.
    $venue = $request->user()
        ->venues()
        ->findOrFail($id);

    // Venue harus sudah diverifikasi oleh Admin.
    if ($venue->verification_status !== 'verified') {
        return back()->with(
            'error',
            'Venue belum diverifikasi Admin sehingga belum dapat diaktifkan atau dinonaktifkan.'
        );
    }

    // Venue yang ditangguhkan Admin tidak boleh diubah oleh Owner.
    if ($venue->venue_status === 'suspended') {
        return back()->with(
            'error',
            'Venue sedang ditangguhkan oleh Admin. Hubungi Admin untuk informasi lebih lanjut.'
        );
    }

    // Owner hanya boleh memilih active atau inactive.
    $validated = $request->validate([
        'venue_status' => [
            'required',
            Rule::in(['active', 'inactive']),
        ],
    ]);

    // Memperbarui status venue.
    $venue->update([
        'venue_status' => $validated['venue_status'],
    ]);

    $message = $validated['venue_status'] === 'active'
        ? 'Venue berhasil diaktifkan dan dapat ditampilkan kepada pengguna.'
        : 'Venue berhasil dinonaktifkan dan disembunyikan dari pengguna.';

    return back()->with('success', $message);
}
}