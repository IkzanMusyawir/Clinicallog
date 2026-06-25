@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

    {{-- Topbar --}}
    <div class="admin-topbar">
        <div>
            <h1 class="admin-page-title">Dashboard</h1>
            <p class="admin-page-sub">Selamat datang kembali, {{ auth()->user()->name ?? 'Admin' }}</p>
        </div>
        <div style="display:flex;gap:10px;">
            <a href="{{ route('admin.features.create') }}" class="btn-primary btn-sm">
                <i data-lucide="plus" style="width:14px;height:14px;"></i>
                Tambah Fitur
            </a>
        </div>
    </div>

    {{-- Stat cards --}}
    <div class="stat-grid">
        @php
            $stats = [
                [
                    'label' => 'Total Fitur',
                    'value' => $totalFeatures ?? 0,
                    'icon' => 'layers',
                    'color' => 'rgba(37,99,235,.25)',
                    'icolor' => '#60a5fa',
                ],
                [
                    'label' => 'Pengguna Aktif',
                    'value' => $totalUsers ?? 0,
                    'icon' => 'users',
                    'color' => 'rgba(6,182,212,.25)',
                    'icolor' => '#22d3ee',
                ],
                [
                    'label' => 'Total Appointment',
                    'value' => $totalAppointments ?? 0,
                    'icon' => 'calendar',
                    'color' => 'rgba(129,140,248,.25)',
                    'icolor' => '#818cf8',
                ],
                [
                    'label' => 'Institusi',
                    'value' => $totalInstitutions ?? 0,
                    'icon' => 'building',
                    'color' => 'rgba(52,211,153,.25)',
                    'icolor' => '#34d399',
                ],
            ];
        @endphp
        @foreach ($stats as $s)
            <div class="stat-card glass">
                <div class="stat-card-icon" style="background:{{ $s['color'] }};">
                    <i data-lucide="{{ $s['icon'] }}" style="width:20px;height:20px;color:{{ $s['icolor'] }};"></i>
                </div>
                <div class="stat-card-num">{{ $s['value'] }}</div>
                <div class="stat-card-lbl">{{ $s['label'] }}</div>
            </div>
        @endforeach
    </div>

    {{-- Quick actions + Recent features --}}
    <div class="dashboard-grid">

        {{-- Quick Actions --}}
        <div class="glass-card glass">
            <h2 style="font-size:15px;font-weight:700;margin-bottom:18px;">Aksi Cepat</h2>
            <div style="display:flex;flex-direction:column;gap:8px;">
                <a href="{{ route('admin.features.create') }}" class="admin-nav-link"
                    style="background:rgba(37,99,235,.15);border:1px solid rgba(37,99,235,.25);color:#93c5fd;">
                    <i data-lucide="plus-circle"></i> Tambah Fitur Baru
                </a>
                <a href="{{ route('admin.landing.edit') }}" class="admin-nav-link">
                    <i data-lucide="edit-3"></i> Edit Landing Page
                </a>
                <a href="{{ route('home') }}" class="admin-nav-link" target="_blank">
                    <i data-lucide="eye"></i> Lihat Website
                </a>
            </div>
        </div>

        {{-- Recent features --}}
        <div class="glass-card glass">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;">
                <h2 style="font-size:15px;font-weight:700;">Fitur Terbaru</h2>
                <a href="{{ route('admin.features.index') }}"
                    style="font-size:13px;color:#60a5fa;text-decoration:none;">Lihat semua →</a>
            </div>
            @if (isset($recentFeatures) && $recentFeatures->count())
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Nama Fitur</th>
                                <th>Dibuat</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentFeatures as $f)
                                <tr>
                                    <td>{{ $f->title }}</td>
                                    <td>{{ $f->created_at->format('d M Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.features.edit', $f->id) }}" class="btn-icon">
                                            <i data-lucide="edit-2" style="width:13px;height:13px;"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="text-align:center;padding:40px 20px;color:#64748b;">
                    <i data-lucide="inbox" style="width:36px;height:36px;margin:0 auto 12px;display:block;opacity:.5;"></i>
                    <p style="font-size:14px;">Belum ada fitur. <a href="{{ route('admin.features.create') }}"
                            style="color:#60a5fa;">Tambah sekarang</a></p>
                </div>
            @endif
        </div>

    </div>

@endsection
