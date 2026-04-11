@extends('layouts.owner')

@section('title', 'Log Aktivitas')

@section('content')

    <script>
        setTimeout(function() {
            window.location.reload();
        }, 5000);
    </script>

    <meta http-equiv="refresh" content="5">

    <style>
        .page-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #2d3748;
        }

        .filter-box {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 20px;
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .filter-box input,
        .filter-box select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            outline: none;
        }

        .btn-filter {
            background: #4f74c8;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .stats-box {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .stat-card h2 {
            margin: 0;
            font-size: 28px;
            color: #2d3748;
        }

        .stat-card p {
            margin-top: 5px;
            color: #666;
            font-size: 13px;
        }

        .log-box {
            background: white;
            border-radius: 10px;
            overflow: visible;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f5f7fb;
            padding: 14px;
            text-align: left;
            font-size: 13px;
            color: #2d3748;
        }

        td {
            padding: 14px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
            vertical-align: top;
        }

        .badge {
            padding: 5px 10px;
            border-radius: 20px;
            color: white;
            font-size: 12px;
            display: inline-block;
        }

        .admin {
            background: #e53e3e;
        }

        .kasir {
            background: #3182ce;
        }

        .owner {
            background: #38a169;
        }

        .pagination-box {
            padding: 15px;
        }

        @media (max-width: 768px) {
            .stats-box {
                grid-template-columns: repeat(2, 1fr);
            }

            .filter-box {
                flex-direction: column;
            }

            .filter-box input,
            .filter-box select,
            .btn-filter {
                width: 100%;
            }

            table {
                font-size: 12px;
            }
        }
    </style>

    <div class="page-title">📋 Log Aktivitas</div>

    {{-- FILTER --}}
    <form method="GET" class="filter-box">
        <input type="text" name="search" placeholder="Cari nama / aktivitas..." value="{{ request('search') }}">

        <select name="role">
            <option value="">Semua Role</option>
            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="kasir" {{ request('role') == 'kasir' ? 'selected' : '' }}>Kasir</option>
            <option value="owner" {{ request('role') == 'owner' ? 'selected' : '' }}>Owner</option>
        </select>

        <input type="date" name="tanggal" value="{{ request('tanggal') }}">

        <button type="submit" class="btn-filter">Filter</button>

        @if (request()->filled('search') || request()->filled('role') || request()->filled('tanggal'))
            <a href="{{ route('owner.aktivitas') }}" class="btn-filter" style="background: #6c757d;">Reset</a>
        @endif
    </form>

    {{-- STATISTIK --}}
    <div class="stats-box">
        <div class="stat-card">
            <h2>{{ $totalLogs }}</h2>
            <p>Total Log</p>
        </div>

        <div class="stat-card">
            <h2>{{ $totalAdmin }}</h2>
            <p>Admin</p>
        </div>

        <div class="stat-card">
            <h2>{{ $totalKasir }}</h2>
            <p>Kasir</p>
        </div>

        <div class="stat-card">
            <h2>{{ $totalOwner }}</h2>
            <p>Owner</p>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="log-box">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama User</th>
                    <th>Role</th>
                    <th>Aktivitas</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($logs as $log)
                    <tr>
                        <td>
                            @if (method_exists($logs, 'currentPage'))
                                {{ ($logs->currentPage() - 1) * $logs->perPage() + $loop->iteration }}
                            @else
                                {{ $loop->iteration }}
                            @endif
                        </td>
                        <td>{{ $log->user->nama ?? 'Unknown' }}</td>
                        <td>
                            <span class="badge {{ $log->user->role ?? 'owner' }}">
                                {{ ucfirst($log->user->role ?? '-') }}
                            </span>
                        </td>
                        <td>{{ $log->activity }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($log->created_at)->translatedFormat('d F Y H:i:s') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;">Belum ada aktivitas</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
