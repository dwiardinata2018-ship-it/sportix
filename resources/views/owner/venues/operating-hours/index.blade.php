<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jam Operasional - Sportix</title>
</head>
<body>

    <h1>Jam Operasional Venue</h1>

    <h2>{{ $venue->name }}</h2>

    <p>Berikut adalah jadwal operasional venue Anda.</p>

    <a href="{{ route('owner.venues.show', $venue->id) }}">
        Kembali ke Detail Venue
    </a>
    <a href="{{ route('owner.venues.operating-hours.edit', $venue->id) }}">
        Edit Jam Operasional
    </a>
    <hr>

    <h3>Jadwal Mingguan</h3>

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

        $hoursByDay = $operatingHours->keyBy('weekday');
    @endphp

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Hari</th>
                <th>Jam Buka</th>
                <th>Jam Tutup</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($days as $number => $day)
                @php
                    $hour = $hoursByDay->get($number);
                @endphp

                <tr>
                    <td>{{ $day }}</td>

                    <td>
                        @if ($hour && !$hour->is_closed)
                            {{ substr($hour->open_time, 0, 5) }}
                        @else
                            -
                        @endif
                    </td>

                    <td>
                        @if ($hour && !$hour->is_closed)
                            {{ substr($hour->close_time, 0, 5) }}
                        @else
                            -
                        @endif
                    </td>

                    <td>
                        @if (!$hour || $hour->is_closed)
                            Tutup
                        @else
                            Buka
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>