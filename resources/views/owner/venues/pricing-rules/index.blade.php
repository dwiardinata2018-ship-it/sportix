
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Aturan Harga - Sportix</title>
</head>
<body>

    <h1>Aturan Harga Venue</h1>

    <h2>{{ $venue->name }}</h2>

    <a href="{{ route('owner.venues.show', $venue->id) }}">
        Kembali ke Detail Venue
    </a>

    <hr>

    {{-- Notifikasi berhasil --}}
    @if (session('success'))
        <p style="color: green;">
            {{ session('success') }}
        </p>
    @endif

    <h3>Daftar Harga</h3>

    <a href="{{ route('owner.venues.pricing-rules.create', $venue->id) }}">
        + Tambah Aturan Harga
    </a>

    <br><br>

    @if ($pricingRules->isEmpty())
        <p>Belum ada aturan harga untuk venue ini.</p>
    @else
        <table border="1" cellpadding="10">
            <thead>
                <tr>
                    <th>Nama Aturan</th>
                    <th>Unit</th>
                    <th>Hari</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                    <th>Harga per Jam</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($pricingRules as $rule)
                    <tr>
                        <td>{{ $rule->name }}</td>

                        <td>
                            {{ $rule->unit?->name ?? 'Semua Unit' }}
                        </td>

                        <td>
                            @php
                                $days = [
                                    1 => 'Senin',
                                    2 => 'Selasa',
                                    3 => 'Rabu',
                                    4 => 'Kamis',
                                    5 => 'Jumat',
                                    6 => 'Sabtu',
                                    7 => 'Minggu',
                                ];
                            @endphp

                            {{ $rule->weekday
                                ? ($days[$rule->weekday] ?? '-')
                                : 'Semua Hari' }}
                        </td>

                        <td>{{ $rule->start_time ?? 'Sepanjang Hari' }}</td>

                        <td>{{ $rule->end_time ?? 'Sepanjang Hari' }}</td>

                        <td>
                            Rp{{ number_format($rule->price_per_hour, 0, ',', '.') }}
                        </td>

                        <td>
                            {{ $rule->is_active ? 'Aktif' : 'Nonaktif' }}
                        </td>

                        <td>
                            {{-- Tombol Edit --}}
                            <a href="{{ route(
                                'owner.venues.pricing-rules.edit',
                                [$venue->id, $rule->id]
                            ) }}">
                                Edit
                            </a>

                            {{-- Tombol Hapus --}}
                            <form method="POST"
                                  action="{{ route(
                                      'owner.venues.pricing-rules.destroy',
                                      [$venue->id, $rule->id]
                                  ) }}"
                                  onsubmit="return confirm('Yakin ingin menghapus aturan harga ini?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</body>
</html>
