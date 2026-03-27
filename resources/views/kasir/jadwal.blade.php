@extends('layouts.kasir')

@section('title', 'Jadwal Lapangan')

@section('content')

    <div class="title">Jadwal Lapangan</div>

    <div class="jadwal-container">

        <table>
            <thead>
                <tr>
                    <th>Jam</th>
                    <th>Lapangan A</th>
                    <th>Lapangan B</th>
                    <th>Lapangan C</th>
                    <th>Lapangan D</th>
                </tr>
            </thead>

            <tbody>
                @for ($i = 8; $i <= 12; $i++)
                    <tr>
                        <td>{{ $i }}.00</td>

                        <td><span class="status kosong">Kosong</span></td>
                        <td><span class="status kosong">Kosong</span></td>
                        <td><span class="status kosong">Kosong</span></td>
                        <td>
                            @if ($i == 10)
                                <span class="status booking">Booking</span>
                            @else
                                <span class="status kosong">Kosong</span>
                            @endif
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>

    </div>

    <style>
        .title {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .jadwal-container {
            background: #eee;
            padding: 15px;
            border-radius: 10px;
        }

        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
            background: #ddd;
        }

        th,
        td {
            border: 1px solid #999;
            padding: 10px;
            text-align: center;
        }

        th {
            background: #bbb;
        }

        /* STATUS */
        .status {
            padding: 5px 10px;
            border-radius: 6px;
            color: white;
            font-size: 12px;
        }

        .kosong {
            background: #4cd964;
        }

        .booking {
            background: #ff3b30;
        }
    </style>

@endsection
