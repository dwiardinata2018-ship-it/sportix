<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Jam Operasional - Sportix</title>
</head>
<body>

    <h1>Edit Jam Operasional</h1>

    <h2>{{ $venue->name }}</h2>

    <p>Atur jam buka dan jam tutup venue untuk setiap hari.</p>

    <a href="{{ route('owner.venues.operating-hours.index', $venue->id) }}">
        Kembali ke Jadwal Operasional
    </a>

    @if ($errors->any())
        <div style="color: red;">
            <strong>Terjadi kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <hr>

    <form method="POST"
          action="{{ route('owner.venues.operating-hours.update', $venue->id) }}">

        @csrf
        @method('PUT')

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

        @foreach ($days as $number => $day)
            @php
                $hour = $operatingHours->get($number);

                $isClosed = old(
                    "hours.$number.is_closed",
                    $hour ? (int) $hour->is_closed : 0
                );

                $openTime = old(
                    "hours.$number.open_time",
                    $hour ? substr($hour->open_time, 0, 5) : '08:00'
                );

                $closeTime = old(
                    "hours.$number.close_time",
                    $hour ? substr($hour->close_time, 0, 5) : '22:00'
                );
            @endphp

            <div style="border: 1px solid #ccc; padding: 15px; margin-bottom: 10px;">

                <h3>{{ $day }}</h3>

                <input type="hidden"
                       name="hours[{{ $number }}][weekday]"
                       value="{{ $number }}">

                <label>
                    <input type="hidden"
                        name="hours[{{ $number }}][is_closed]"
                        value="0">

                    <input type="checkbox"
                        name="hours[{{ $number }}][is_closed]"
                        value="1"
                        {{ $isClosed ? 'checked' : '' }}
                        onchange="toggleDay({{ $number }})">

                    Tutup pada hari ini
                </label>

                <br><br>

                <label for="open_{{ $number }}">Jam Buka:</label>

                <input type="time"
                       id="open_{{ $number }}"
                       name="hours[{{ $number }}][open_time]"
                       value="{{ $openTime }}"
                       {{ $isClosed ? 'disabled' : '' }}>

                <br><br>

                <label for="close_{{ $number }}">Jam Tutup:</label>

                <input type="time"
                       id="close_{{ $number }}"
                       name="hours[{{ $number }}][close_time]"
                       value="{{ $closeTime }}"
                       {{ $isClosed ? 'disabled' : '' }}>

            </div>
        @endforeach

        <button type="submit">Simpan Jadwal</button>

    </form>

    <script>
        function toggleDay(day) {
            const checkbox = document.querySelector(
                `input[name="hours[${day}][is_closed]"]`
            );

            const openTime = document.getElementById(`open_${day}`);
            const closeTime = document.getElementById(`close_${day}`);

            openTime.disabled = checkbox.checked;
            closeTime.disabled = checkbox.checked;
        }
    </script>

</body>
</html>