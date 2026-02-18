<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Hadir - {{ $event->title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
        }

        .header p {
            margin: 5px 0 0;
            font-size: 14px;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .status-hadir {
            color: green;
            font-weight: bold;
        }

        .status-belum {
            color: gray;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <div class="header">
        <h1>Daftar Hadir Peserta</h1>
        <p>{{ $event->title }}</p>
        <p>Tanggal: {{ $event->start_date->format('d M Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                <th>Nama Peserta</th>
                <th>Email</th>
                <th>No HP</th>
                <th>L/P</th>
                <th>Status</th>
                <th>Waktu Hadir</th>
            </tr>
        </thead>
        <tbody>
            @foreach($participants as $index => $participant)
                @php
                    $attendance = $participant->attendances->when(isset($filterDate) && $filterDate, function ($q) use ($filterDate) {
                        return $q->whereDate('attended_at', $filterDate);
                    })->first();
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $participant->name }}</td>
                    <td>{{ $participant->email }}</td>
                    <td>{{ $participant->phone }}</td>
                    <td style="text-align: center;">{{ $participant->gender }}</td>
                    <td>
                        @if($attendance)
                            <span class="status-hadir">Hadir</span>
                        @else
                            <span class="status-belum">Belum Hadir</span>
                        @endif
                    </td>
                    <td>
                        {{ $attendance ? $attendance->attended_at->format('H:i') : '-' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>