@extends('layouts.owner')

@section('content')
    <h3>Log Aktivitas</h3>

    <div class="box">

        @foreach (['Admin', 'Kasir', 'Owner'] as $role)
            <div style="border-bottom:1px solid #ccc; padding:10px;">
                <b>{{ $role }}</b><br>
                Melakukan aktivitas sistem<br>
                <small>24 Mei 2026</small>
            </div>
        @endforeach

    </div>
@endsection
