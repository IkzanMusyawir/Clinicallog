@extends('layouts.admin')

@section('title', 'Dashboard')

@push('head')
<style>
    .card-anim { animation: statIn .4s cubic-bezier(.4,0,.2,1) .28s both; }
</style>
@endpush

@section('content')

    @php
        $stats = [
            ['label'=>'Total Fitur',    'value'=>$totalFeatures ?? 0,    'icon'=>'layers',          'ibg'=>'#eff6ff','ic'=>'#0369A1','decor'=>'#0369A1','trend'=>'Fitur aktif','up'=>true],
            ['label'=>'Pengguna',       'value'=>$totalUsers ?? 0,       'icon'=>'users',           'ibg'=>'#ecfdf5','ic'=>'#059669','decor'=>'#059669','trend'=>'Terdaftar', 'up'=>true],
            ['label'=>'Appointment',    'value'=>$totalAppointments ?? 0,'icon'=>'calendar-check',  'ibg'=>'#f5f3ff','ic'=>'#7c3aed','decor'=>'#7c3aed','trend'=>'Total',     'up'=>null],

        ];
    @endphp

    {{-- Page Header --}}
    <div class="adm-page-header">
        <div>
            <h1 class="adm-page-title">Dashboard</h1>
            <p class="adm-page-subtitle">
                Halo, <strong>{{ auth()->user()->name ?? 'Admin' }}</strong> — {{ now()->translatedFormat('l, d F Y') }}
            </p>
        </div>
        <div class="adm-page-actions">
            <a href="{{ route('home') }}" target="_blank" rel="noopener" class="adm-btn-secondary btn-sm">
                <x-icon name="eye"/> Lihat Website
            </a>
            <a href="{{ route('admin.landing.edit') }}#features" class="adm-btn-primary btn-sm">
                <x-icon name="plus"/> Tambah Fitur
            </a>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="adm-stat-grid" style="margin-bottom:20px;">
        @foreach ($stats as $s)
        <div class="adm-stat-card stat-anim">
            <div class="adm-stat-card-top">
                <div class="adm-stat-icon" style="background:{{ $s['ibg'] }};color:{{ $s['ic'] }};">
                    <x-icon name="{{ $s['icon'] }}"/>
                </div>
                <div class="adm-stat-trend {{ $s['up'] ? 'up' : 'neutral' }}">
                    @if($s['up'])<x-icon name="trending-up"/>@endif
                    {{ $s['trend'] }}
                </div>
            </div>
            <div class="adm-stat-num">{{ number_format($s['value']) }}</div>
            <div class="adm-stat-label">{{ $s['label'] }}</div>
            <div class="adm-stat-decor" style="background:{{ $s['decor'] }};"></div>
        </div>
        @endforeach
    </div>

    {{-- Main Grid --}}
    <div class="adm-grid-2-1 card-anim" style="margin-bottom:16px;">

        {{-- Recent Appointments --}}
        <div class="adm-card">
            <div class="adm-card-header">
                <div style="display:flex;align-items:center;gap:8px;">
                    <x-icon name="calendar-check" style="color:#7c3aed;"/>
                    <span class="adm-card-title">Appointment Terbaru</span>
                </div>
                <a href="{{ route('admin.appointments.index') }}" class="adm-card-link">Lihat semua →</a>
            </div>

            @if(isset($recentAppointments) && $recentAppointments->count())
                <div class="adm-table-wrap">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Institusi</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentAppointments as $a)
                            <tr>
                                <td>{{ $a->name }}</td>
                                <td style="font-size:12.5px;color:#9ca3af;">{{ $a->institution }}</td>
                                <td>
                                    @php
                                        $statusMap = ['pending' => ['label' => 'Pending', 'class' => 'adm-badge-yellow'], 'done' => ['label' => 'Selesai', 'class' => 'adm-badge-green'], 'cancelled' => ['label' => 'Batal', 'class' => 'adm-badge-red']];
                                        $s = $statusMap[$a->status] ?? ['label' => $a->status, 'class' => 'badge-default'];
                                    @endphp
                                    <span class="adm-badge {{ $s['class'] }}">{{ $s['label'] }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="adm-empty">
                    <x-icon name="inbox"/>
                    <p>Belum ada appointment.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- System Bar --}}
    <div class="adm-card card-anim" style="animation-delay:.35s;">
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:14px;padding:16px 22px;">
            <div style="display:flex;align-items:center;gap:8px;">
                <span class="live-dot" style="width:8px;height:8px;border-radius:50%;background:#10b981;display:inline-block;box-shadow:0 0 8px rgba(16,185,129,.5);"></span>
                <span style="font-size:13px;font-weight:600;color:#0f172a;">Sistem berjalan normal</span>
                <span style="font-size:12px;color:#94a3b8;">ClinicalLog CMS v1.0</span>
            </div>
            <div style="display:flex;align-items:center;gap:18px;">
                @foreach([['Laravel', app()->version()], ['PHP', PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION], ['Env', ucfirst(app()->environment())]] as $info)
                <div style="text-align:center;">
                    <div style="font-size:10.5px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:.06em;">{{ $info[0] }}</div>
                    <div style="font-size:13px;font-weight:700;color:#0f172a;">{{ $info[1] }}</div>
                </div>
                @if(!$loop->last)<div style="width:1px;height:26px;background:#e2e8f0;"></div>@endif
                @endforeach
            </div>
        </div>
    </div>

@endsection
