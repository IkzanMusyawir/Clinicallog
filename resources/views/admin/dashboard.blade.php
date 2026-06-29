@extends('layouts.admin')

@section('title', 'Dashboard')

@push('head')
<style>
    .stat-anim { animation: statIn .4s cubic-bezier(.4,0,.2,1) both; }
    .stat-anim:nth-child(1) { animation-delay: .04s; }
    .stat-anim:nth-child(2) { animation-delay: .10s; }
    .stat-anim:nth-child(3) { animation-delay: .16s; }
    .stat-anim:nth-child(4) { animation-delay: .22s; }
    @keyframes statIn {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .card-anim { animation: statIn .4s cubic-bezier(.4,0,.2,1) .28s both; }

    @keyframes blink {
        0%,100% { opacity: 1; }
        50%      { opacity: .4; }
    }
    .live-dot { animation: blink 2s infinite; }
</style>
@endpush

@section('content')

    @php
        $stats = [
            ['label'=>'Total Fitur',    'value'=>$totalFeatures ?? 0,    'icon'=>'layers',          'ibg'=>'#eff6ff','ic'=>'#2563eb','decor'=>'#2563eb','trend'=>'Fitur aktif','up'=>true],
            ['label'=>'Pengguna',       'value'=>$totalUsers ?? 0,       'icon'=>'users',           'ibg'=>'#ecfdf5','ic'=>'#059669','decor'=>'#059669','trend'=>'Terdaftar', 'up'=>true],
            ['label'=>'Appointment',    'value'=>$totalAppointments ?? 0,'icon'=>'calendar-check',  'ibg'=>'#f5f3ff','ic'=>'#7c3aed','decor'=>'#7c3aed','trend'=>'Total',     'up'=>null],
            ['label'=>'Institusi',      'value'=>$totalInstitutions ?? 0,'icon'=>'building-2',      'ibg'=>'#fff7ed','ic'=>'#d97706','decor'=>'#d97706','trend'=>'Terdaftar', 'up'=>true],
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
                <i data-lucide="eye"></i> Lihat Website
            </a>
            <a href="{{ route('admin.features.create') }}" class="adm-btn-primary btn-sm">
                <i data-lucide="plus"></i> Tambah Fitur
            </a>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="adm-stat-grid" style="margin-bottom:20px;">
        @foreach ($stats as $s)
        <div class="adm-stat-card stat-anim">
            <div class="adm-stat-card-top">
                <div class="adm-stat-icon" style="background:{{ $s['ibg'] }};color:{{ $s['ic'] }};">
                    <i data-lucide="{{ $s['icon'] }}"></i>
                </div>
                <div class="adm-stat-trend {{ $s['up'] ? 'up' : 'neutral' }}">
                    @if($s['up'])<i data-lucide="trending-up" style="width:10px;height:10px;"></i>@endif
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

        {{-- Recent Features --}}
        <div class="adm-card">
            <div class="adm-card-header">
                <div style="display:flex;align-items:center;gap:8px;">
                    <i data-lucide="layers" style="width:15px;height:15px;color:#2563eb;"></i>
                    <span class="adm-card-title">Fitur Terbaru</span>
                </div>
                <a href="{{ route('admin.features.index') }}" class="adm-card-link">Lihat semua →</a>
            </div>

            @if(isset($recentFeatures) && $recentFeatures->count())
                <div class="adm-table-wrap">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Nama Fitur</th>
                                <th>Tanggal Dibuat</th>
                                <th style="width:50px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentFeatures as $f)
                            <tr>
                                <td>{{ $f->title }}</td>
                                <td style="font-size:12.5px;color:#9ca3af;">{{ $f->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.features.edit', $f->id) }}" class="adm-btn-icon" title="Edit">
                                        <i data-lucide="edit-2"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="adm-empty">
                    <i data-lucide="inbox"></i>
                    <p>Belum ada fitur. <a href="{{ route('admin.features.create') }}">Tambah sekarang</a></p>
                </div>
            @endif
        </div>

        {{-- Quick Actions --}}
        <div class="adm-card">
            <div class="adm-card-header">
                <div style="display:flex;align-items:center;gap:8px;">
                    <i data-lucide="zap" style="width:15px;height:15px;color:#d97706;"></i>
                    <span class="adm-card-title">Aksi Cepat</span>
                </div>
            </div>
            <div class="adm-card-body">
                @php
                    $actions = [
                        ['href'=>route('admin.features.create'),      'icon'=>'plus-circle',    'ibg'=>'#eff6ff','ic'=>'#2563eb', 'label'=>'Tambah Fitur Baru'],
                        ['href'=>route('admin.landing.edit'),         'icon'=>'edit-3',         'ibg'=>'#ecfdf5','ic'=>'#059669', 'label'=>'Edit Landing Page'],
                        ['href'=>route('admin.appointments.index'),   'icon'=>'calendar-check', 'ibg'=>'#f5f3ff','ic'=>'#7c3aed', 'label'=>'Kelola Appointment'],
                        ['href'=>route('admin.users.index'),          'icon'=>'users',          'ibg'=>'#fff7ed','ic'=>'#d97706', 'label'=>'Kelola Pengguna'],
                        ['href'=>route('home'),                       'icon'=>'globe',          'ibg'=>'#f0fdf4','ic'=>'#059669', 'label'=>'Lihat Website Live', 'ext'=>true],
                    ];
                @endphp
                @foreach($actions as $a)
                <a href="{{ $a['href'] }}" class="adm-quick-action" @if(!empty($a['ext'])) target="_blank" rel="noopener" @endif>
                    <div class="adm-quick-action-icon" style="background:{{ $a['ibg'] }};color:{{ $a['ic'] }};">
                        <i data-lucide="{{ $a['icon'] }}"></i>
                    </div>
                    <span>{{ $a['label'] }}</span>
                    <i data-lucide="{{ !empty($a['ext']) ? 'external-link' : 'arrow-right' }}" class="adm-arrow" style="width:14px;height:14px;"></i>
                </a>
                @endforeach
            </div>
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
