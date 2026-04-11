@extends('layouts.kasir')

@section('title', 'Jadwal Lapangan')

@section('content')

    <style>
        .title {
            font-size: 20px;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .subtitle {
            font-size: 12px;
            color: gray;
            margin-bottom: 20px;
        }

        .table-box {
            background: #ddd;
            padding: 15px;
            border-radius: 8px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 700px;
            border-collapse: collapse;
            background: #ccc;
        }

        th,
        td {
            border: 1px solid #888;
            padding: 10px;
            text-align: center;
            white-space: nowrap;
        }

        th {
            background: #bfbfbf;
        }

        .kosong {
            background: #63e26c;
            color: white;
            padding: 5px 12px;
            border-radius: 4px;
            display: inline-block;
        }

        .booking {
            background: #ff6b6b;
            color: white;
            padding: 5px 12px;
            border-radius: 4px;
            display: inline-block;
        }

        .nonaktif {
            color: #999;
            font-weight: bold;
        }

        .empty-box {
            background: #f39c12;
            color: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
        }
    </style>

    <div class="title">Jadwal Lapangan</div>
    <div class="subtitle">Tampilan Detail Lapangan Yang Tersedia</div>

    <form method="GET" style="margin-bottom:15px;">
        <input type="date" name="tanggal" min="{{ date('Y-m-d') }}" value="{{ $tanggal }}">
        <button type="submit">Filter</button>
    </form>

    <div class="table-box">

        @if (count($lapangans) > 0 && count($jadwal) > 0)
            <table>
                <tr>
                    <th>Jam</th>
                    @foreach ($lapangans as $lap)
                        <th>{{ $lap->nama }}</th>
                    @endforeach
                </tr>

                @foreach ($jadwal as $row)
                    <tr>
                        <td>{{ $row['jam'] }}</td>

                        @foreach ($row['lapangans'] as $lap)
                            <td>
                                {{-- di luar jam operasional --}}
                                @if ($lap['booked'] === null)
                                    <span class="nonaktif">-</span>

                                    {{-- sudah dibooking -> tampil nama customer merah --}}
                                @elseif (is_string($lap['booked']) && $lap['booked'] !== '')
                                    <span class="booking">{{ $lap['booked'] }}</span>

                                    {{-- jam tersedia --}}
                                @else
                                    <span class="kosong">Kosong</span>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </table>
        @else
            <div class="empty-box">
                ⚠️ Belum ada data jadwal atau lapangan tersedia
            </div>
        @endif

    </div>

@endsection
