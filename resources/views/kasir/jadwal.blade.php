@extends('layouts.kasir')

@section('title', 'Jadwal Lapangan')

@section('content')

    <style>
        .title {
            font-size: 20px;
            margin-bottom: 5px;
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
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #ccc;
        }

        th,
        td {
            border: 1px solid #888;
            padding: 10px;
            text-align: center;
        }

        th {
            background: #bfbfbf;
        }

        .kosong {
            background: #63e26c;
            color: white;
            padding: 5px 12px;
            border-radius: 4px;
        }

        .booking {
            background: #ff6b6b;
            color: white;
            padding: 5px 12px;
            border-radius: 4px;
        }
    </style>

    <div class="title">Jadwal Lapangan Hari Ini</div>
    <div class="subtitle">Tampilan Detail Lapangan Yang Tersedia</div>

    <div class="table-box">

        <table>
            <tr>
                <th>Jam</th>
                <th>Lapangan A</th>
                <th>Lapangan B</th>
                <th>Lapangan C</th>
                <th>Lapangan D</th>
            </tr>

            @for ($i = 0; $i < 15; $i++)
                <tr>
                    <td>{{ 8 + $i }}.00</td>

                    <td><span class="kosong">Kosong</span></td>

                    <td>
                        @if ($i % 3 == 0)
                            <span class="booking">Booking</span>
                        @else
                            <span class="kosong">Kosong</span>
                        @endif
                    </td>

                    <td><span class="kosong">Kosong</span></td>

                    <td>
                        @if ($i % 4 == 0)
                            <span class="booking">Booking</span>
                        @else
                            <span class="kosong">Kosong</span>
                        @endif
                    </td>
                </tr>
            @endfor

        </table>

    </div>

@endsection
