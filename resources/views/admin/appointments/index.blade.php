@extends('layouts.admin')

@section('title', 'Daftar Appointment')

@section('content')

    <div class="admin-topbar">
        <div>
            <h1 class="admin-page-title">Daftar Appointment</h1>
            <p class="admin-page-sub">Kelola dan pantau semua pengajuan demo ClinicalLog</p>
        </div>
    </div>

    <div class="glass-card glass" style="overflow-x:auto;">
        @if ($appointments->isEmpty())
            <div style="text-align:center;padding:48px 0;color:var(--text-dim);">
                <i data-lucide="calendar" style="width:48px;height:48px;margin:0 auto 16px;display:block;opacity:.5;"></i>
                <h3 style="font-size:16px;font-weight:600;color:var(--text-primary);">Belum Ada Appointment</h3>
                <p style="font-size:13px;margin-top:6px;">Pengajuan demo dari landing page akan muncul di sini.</p>
            </div>
        @else
            <div class="table-responsive">
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
                    <tbody>
                        @foreach ($appointments as $app)
                            <tr>
                                <td>
                                    <div style="font-weight:600;color:var(--text-primary);">{{ $app->name }}</div>
                                    <div style="font-size:12px;color:var(--text-dim);margin-top:2px;">Diterima: {{ $app->created_at->format('d M Y H:i') }}</div>
                                </td>
                                <td>{{ $app->institution }}</td>
                                <td>
                                    <div>
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $app->whatsapp) }}" target="_blank" 
                                           style="color:#34d399;text-decoration:none;display:inline-flex;align-items:center;gap:4px;font-weight:600;">
                                            <i data-lucide="phone" style="width:14px;height:14px;"></i>
                                            {{ $app->whatsapp }}
                                        </a>
                                    </div>
                                    <div style="font-size:12px;color:var(--text-dim);margin-top:2px;">{{ $app->email }}</div>
                                </td>
                                <td>
                                    <div style="font-weight:500;color:var(--text-primary);">{{ \Carbon\Carbon::parse($app->demo_date)->format('d M Y') }}</div>
                                    <div style="font-size:12px;color:var(--text-dim);margin-top:2px;">Pukul {{ substr($app->demo_time, 0, 5) }} WIB</div>
                                </td>
                                <td style="max-width:200px;white-space:normal;font-size:13px;line-height:1.4;">
                                    {{ $app->notes ?? '-' }}
                                </td>
                                <td>
                                    <form action="{{ route('admin.appointments.updateStatus', $app->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" 
                                                style="padding:6px 12px;border-radius:8px;font-size:13px;font-weight:600;background:{{ $app->status === 'done' ? 'rgba(52,211,153,.1)' : ($app->status === 'cancelled' ? 'rgba(248,113,113,.1)' : 'rgba(245,158,11,.1)') }};color:{{ $app->status === 'done' ? '#34d399' : ($app->status === 'cancelled' ? '#f87171' : '#f59e0b') }};border:1px solid {{ $app->status === 'done' ? 'rgba(52,211,153,.2)' : ($app->status === 'cancelled' ? 'rgba(248,113,113,.2)' : 'rgba(245,158,11,.2)') }};outline:none;cursor:pointer;">
                                            <option value="pending" {{ $app->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="done" {{ $app->status === 'done' ? 'selected' : '' }}>Selesai</option>
                                            <option value="cancelled" {{ $app->status === 'cancelled' ? 'selected' : '' }}>Batal</option>
                                        </select>
                                    </form>
                                </td>
                                <td style="text-align:right;">
                                    <form action="{{ route('admin.appointments.destroy', $app->id) }}" method="POST" style="display:inline-block;" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus appointment ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon danger" title="Hapus">
                                            <i data-lucide="trash-2" style="width:14px;height:14px;"></i>
                                        </button>
                                    </form>
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
