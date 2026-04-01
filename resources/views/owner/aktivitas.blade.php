@extends('layouts.owner')

@section('title', 'Log Aktivitas')

@section('content')

    <div class="page-title">Log Aktivitas</div>

    <div class="box">

        {{-- FILTER --}}
        <form method="GET" action="{{ route('owner.aktivitas') }}">
            <div class="filter-box" style="flex-wrap:wrap; gap:10px; margin-bottom:20px;">

                <select name="role" style="padding:8px; border:1px solid #ccc; border-radius:5px;">
                    <option value="">Semua Role</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="kasir" {{ request('role') == 'kasir' ? 'selected' : '' }}>Kasir</option>
                    <option value="owner" {{ request('role') == 'owner' ? 'selected' : '' }}>Owner</option>
                </select>

                <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                    style="padding:8px; border:1px solid #ccc; border-radius:5px;">

                <button type="submit" class="btn btn-blue">🔍 Filter</button>

                @if (request('role') || request('tanggal'))
                    <a href="{{ route('owner.aktivitas') }}" class="btn"
                        style="background:#ccc; color:#333; border-radius:5px; text-decoration:none; padding:5px 10px;">
                        ✖ Reset
                    </a>
                @endif

            </div>
        </form>

        {{-- LOG LIST --}}
        @forelse ($logs as $log)
            <div style="border-bottom:1px solid #ddd; padding:12px 5px; display:flex; align-items:flex-start; gap:15px;">

                {{-- Icon role --}}
                <div style="font-size:22px;">
                    @if ($log->user?->role == 'admin')
                        🔴
                    @elseif($log->user?->role == 'kasir')
                        🔵
                    @elseif($log->user?->role == 'owner')
                        🟢
                    @else
                        ⚪
                    @endif
                </div>

                <div style="flex:1;">
                    <div>
                        <b>{{ $log->user?->nama ?? 'Unknown' }}</b>
                        <span
                            style="background:#e0e0e0; padding:2px 8px; border-radius:10px; font-size:12px; margin-left:5px;">
                            {{ ucfirst($log->user?->role ?? '-') }}
                        </span>
                    </div>
                    <div style="margin-top:3px;">{{ $log->activity }}</div>
                    <small style="color:#999;">
                        🕐 {{ \Carbon\Carbon::parse($log->created_at)->translatedFormat('l, d F Y H:i') }}
                    </small>
                </div>

            </div>
        @empty
            <div style="text-align:center; color:#999; padding:30px;">
                Belum ada aktivitas tercatat.
            </div>
        @endforelse

    </div>

@endsection
