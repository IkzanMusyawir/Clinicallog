@extends('layouts.admin')

@section('title', 'Daftar Appointment')

@section('content')

<style>
    /* ── Custom Status Dropdown ── */
    .status-dropdown {
        position: relative;
        display: inline-block;
    }

    .status-trigger {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 7px 14px;
        border-radius: 20px;
        font-size: 12.5px;
        font-weight: 600;
        cursor: pointer;
        border: 1.5px solid transparent;
        transition: background-color .3s cubic-bezier(.4, 0, .2, 1),
            color .3s cubic-bezier(.4, 0, .2, 1),
            border-color .3s cubic-bezier(.4, 0, .2, 1),
            box-shadow .3s cubic-bezier(.4, 0, .2, 1),
            transform .15s cubic-bezier(.4, 0, .2, 1);
        user-select: none;
        white-space: nowrap;
        min-width: 105px;
    }

    .status-trigger:hover {
        transform: translateY(-1px);
    }

    .status-trigger .status-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        flex-shrink: 0;
        transition: background-color .3s cubic-bezier(.4, 0, .2, 1),
            box-shadow .3s cubic-bezier(.4, 0, .2, 1);
    }

    .status-trigger .status-chevron {
        width: 14px;
        height: 14px;
        transition: transform .25s cubic-bezier(.4, 0, .2, 1);
        opacity: .6;
        flex-shrink: 0;
    }

    .status-dropdown.open .status-trigger .status-chevron {
        transform: rotate(180deg);
    }

    /* Status colors */
    .status-trigger.pending {
        background: #fffbeb;
        color: #d97706;
        border-color: #fde68a;
    }

    .status-trigger.pending:hover {
        box-shadow: 0 4px 12px rgba(245, 158, 11, .15);
    }

    .status-trigger.pending .status-dot {
        background: #f59e0b;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, .2);
    }

    .status-trigger.done {
        background: #ecfdf5;
        color: #059669;
        border-color: #a7f3d0;
    }

    .status-trigger.done:hover {
        box-shadow: 0 4px 12px rgba(16, 185, 129, .15);
    }

    .status-trigger.done .status-dot {
        background: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, .2);
    }

    .status-trigger.cancelled {
        background: #fef2f2;
        color: #dc2626;
        border-color: #fecaca;
    }

    .status-trigger.cancelled:hover {
        box-shadow: 0 4px 12px rgba(239, 68, 68, .1);
    }

    .status-trigger.cancelled .status-dot {
        background: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, .2);
    }

    /* Dropdown Panel */
    .status-menu {
        position: absolute;
        top: calc(100% + 6px);
        right: 0;
        min-width: 160px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, .12), 0 2px 8px rgba(0, 0, 0, .06);
        z-index: 9999;
        opacity: 0;
        pointer-events: none;
        transform: scale(.95) translateY(-4px);
        transform-origin: top right;
        transition: opacity .2s cubic-bezier(.4, 0, .2, 1),
            transform .2s cubic-bezier(.4, 0, .2, 1);
        padding: 5px;
        overflow: hidden;
    }

    .status-dropdown.open .status-menu,
    .status-menu.open {
        opacity: 1;
        pointer-events: auto;
        transform: scale(1);
    }

    .status-option {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 12px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        color: #475569;
        cursor: pointer;
        transition: background .18s ease, color .18s ease,
            transform .15s cubic-bezier(.34, 1.56, .64, 1),
            box-shadow .15s ease;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
        font-family: inherit;
        position: relative;
        overflow: hidden;
    }

    .status-option:hover {
        transform: translateX(3px);
    }

    .status-option:active {
        transform: translateX(1px) scale(.98);
    }

    /* Ripple element injected by JS */
    .opt-ripple {
        position: absolute;
        border-radius: 50%;
        transform: scale(0);
        animation: optRipple .45s cubic-bezier(.4, 0, .2, 1) forwards;
        pointer-events: none;
        opacity: .35;
    }

    @keyframes optRipple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }

    .status-option .opt-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
        transition: transform .2s cubic-bezier(.34, 1.56, .64, 1);
    }

    .status-option:hover .opt-dot {
        transform: scale(1.3);
    }

    .status-option .opt-check {
        width: 14px;
        height: 14px;
        margin-left: auto;
        opacity: 0;
        color: currentColor;
        flex-shrink: 0;
        transition: opacity .2s ease, transform .2s cubic-bezier(.34, 1.56, .64, 1);
        transform: scale(.5);
    }

    .status-option.selected .opt-check {
        opacity: 1;
        transform: scale(1);
    }

    /* Picked state — flash highlight before close */
    .status-option.picking {
        transform: scale(.97) translateX(0) !important;
        transition: transform .12s ease !important;
    }

    /* Option variant hover colors */
    .status-option.opt-pending:hover {
        background: #fffbeb;
        color: #d97706;
    }

    .status-option.opt-pending.selected {
        background: #fffbeb;
        color: #d97706;
        font-weight: 600;
    }

    .status-option.opt-pending .opt-dot {
        background: #f59e0b;
    }

    .status-option.opt-pending .opt-ripple {
        background: #f59e0b;
    }

    .status-option.opt-done:hover {
        background: #ecfdf5;
        color: #059669;
    }

    .status-option.opt-done.selected {
        background: #ecfdf5;
        color: #059669;
        font-weight: 600;
    }

    .status-option.opt-done .opt-dot {
        background: #10b981;
    }

    .status-option.opt-done .opt-ripple {
        background: #10b981;
    }

    .status-option.opt-cancelled:hover {
        background: #fef2f2;
        color: #dc2626;
    }

    .status-option.opt-cancelled.selected {
        background: #fef2f2;
        color: #dc2626;
        font-weight: 600;
    }

    .status-option.opt-cancelled .opt-dot {
        background: #ef4444;
    }

    .status-option.opt-cancelled .opt-ripple {
        background: #ef4444;
    }
</style>

<div class="admin-topbar">
    <div>
        <h1 class="admin-page-title">Daftar Appointment</h1>
        <p class="admin-page-sub">Kelola dan pantau semua pengajuan demo ClinicalLog</p>
    </div>
</div>

<div class="glass-card glass" style="overflow: visible;">
    @if ($appointments->isEmpty())
    <div style="text-align:center;padding:48px 0;color:var(--text-dim);">
        <x-icon name="calendar" style="margin:0 auto 16px;display:block;opacity:.5;"/>
        <h3 style="font-size:16px;font-weight:600;color:var(--text-primary);">Belum Ada Appointment</h3>
        <p style="font-size:13px;margin-top:6px;">Pengajuan demo dari landing page akan muncul di sini.</p>
    </div>
    @else
    <div class="table-responsive" style="overflow-x:auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Pemohon</th>
                    <th>Institusi</th>
                    <th>WhatsApp & Email</th>
                    <th>Jadwal Rencana</th>
                    <th>Catatan</th>
                    <th>Status</th>
                    <th style="text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody id="appointments-table-body">
                @foreach ($appointments as $app)
                <tr>
                    <td>
                        <div style="font-weight:600;color:var(--text-primary);">{{ $app->name }}</div>
                        <div style="font-size:12px;color:var(--text-dim);margin-top:2px;">Diterima: {{
                            $app->created_at->format('d M Y H:i') }}</div>
                    </td>
                    <td>{{ $app->institution }}</td>
                    <td>
                        <div>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $app->whatsapp) }}" target="_blank"
                                style="color:#34d399;text-decoration:none;display:inline-flex;align-items:center;gap:4px;font-weight:600;">
                                <x-icon name="phone"/>
                                {{ $app->whatsapp }}
                            </a>
                        </div>
                        <div style="font-size:12px;color:var(--text-dim);margin-top:2px;">{{ $app->email }}</div>
                    </td>
                    <td>
                        <div style="font-weight:500;color:var(--text-primary);">{{
                            \Carbon\Carbon::parse($app->demo_date)->format('d M Y') }}</div>
                        <div style="font-size:12px;color:var(--text-dim);margin-top:2px;">Pukul {{
                            substr($app->demo_time, 0, 5) }} WIB</div>
                    </td>
                    <td style="max-width:200px;white-space:normal;font-size:13px;line-height:1.4;">
                        {{ $app->notes ?? '-' }}
                    </td>
                    <td>
                        {{-- Custom Status Dropdown --}}
                        <div class="status-dropdown" data-id="{{ $app->id }}">
                            <div class="status-trigger {{ $app->status }}" onclick="toggleStatus(this)">
                                <span class="status-dot"></span>
                                <span class="status-text">{{ $app->status === 'pending' ? 'Pending' : ($app->status ===
                                    'done' ? 'Selesai' : 'Batal') }}</span>
                                <svg class="status-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </div>
                            <div class="status-menu">
                                <button type="button"
                                    class="status-option opt-pending {{ $app->status === 'pending' ? 'selected' : '' }}"
                                    data-value="pending" onclick="pickStatus(this)">
                                    <span class="opt-dot"></span>
                                    Pending
                                    <svg class="opt-check" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </button>
                                <button type="button"
                                    class="status-option opt-done {{ $app->status === 'done' ? 'selected' : '' }}"
                                    data-value="done" onclick="pickStatus(this)">
                                    <span class="opt-dot"></span>
                                    Selesai
                                    <svg class="opt-check" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </button>
                                <button type="button"
                                    class="status-option opt-cancelled {{ $app->status === 'cancelled' ? 'selected' : '' }}"
                                    data-value="cancelled" onclick="pickStatus(this)">
                                    <span class="opt-dot"></span>
                                    Batal
                                    <svg class="opt-check" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </td>
                    <td style="text-align:right; display:flex; gap:6px; justify-content:flex-end; border-left: none;">
                        <button type="button" class="btn-icon" title="Salin Info Pemohon"
                            onclick="copyAppointmentInfo({
                                name: '{{ addslashes($app->name) }}',
                                institution: '{{ addslashes($app->institution) }}',
                                whatsapp: '{{ addslashes($app->whatsapp) }}',
                                email: '{{ addslashes($app->email) }}',
                                date: '{{ \Carbon\Carbon::parse($app->demo_date)->format('d M Y') }}',
                                time: '{{ substr($app->demo_time, 0, 5) }}',
                                notes: '{{ addslashes($app->notes ?? '-') }}'
                            }, this)">
                            <x-icon name="copy"/>
                        </button>
                        <button type="button" class="btn-icon danger" title="Hapus"
                            onclick="deleteAppointment('{{ route('admin.appointments.destroy', $app->id) }}', this)">
                            <x-icon name="trash-2"/>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top:20px;">
        {{ $appointments->links() }}
    </div>
    @endif
</div>

@endsection