@extends('layouts.admin')

@section('title', 'Daftar Appointment')

@section('content')

<div class="admin-topbar">
    <div>
        <h1 class="admin-page-title">Daftar Appointment</h1>
        <p class="admin-page-sub">{{ $appointments->total() ?? $appointments->count() }} pengajuan demo</p>
    </div>
</div>

<div class="glass-card glass" style="overflow:visible;">
    @if ($appointments->isEmpty())
    <div style="text-align:center;padding:48px 0;color:var(--text-dim);">
        <x-icon name="calendar" style="margin:0 auto 16px;display:block;opacity:.5;"/>
        <h3 style="font-size:16px;font-weight:600;color:var(--text-primary);">Belum Ada Appointment</h3>
        <p style="font-size:13px;margin-top:6px;">Pengajuan demo dari landing page akan muncul di sini.</p>
    </div>
    @else
    <div class="table-responsive" style="overflow:auto;max-height:70vh;">
        <table class="admin-table">
            <thead style="position:sticky;top:0;z-index:2;background:#f8fafc;">
                <tr>
                    <th style="min-width:160px;">Pemohon</th>
                    <th style="min-width:130px;">Institusi</th>
                    <th style="min-width:170px;">Kontak</th>
                    <th style="min-width:130px;">Jadwal</th>
                    <th style="min-width:140px;">Catatan</th>
                    <th style="min-width:120px;">Status</th>
                    <th style="width:80px;text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody id="appointments-table-body">
                @foreach ($appointments as $app)
                <tr>
                    <td>
                        <div style="font-weight:600;color:var(--text-primary);">{{ $app->name }}</div>
                        <div style="font-size:12px;color:#94a3b8;margin-top:2px;">{{ $app->created_at->format('d M Y H:i') }}</div>
                    </td>
                    <td>{{ $app->institution }}</td>
                    <td>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $app->whatsapp) }}" target="_blank" style="color:#22c55e;text-decoration:none;font-weight:600;font-size:13px;">{{ $app->whatsapp }}</a>
                        <div style="font-size:12px;color:#94a3b8;margin-top:2px;">{{ $app->email }}</div>
                    </td>
                    <td>
                        <div style="font-weight:500;color:var(--text-primary);">{{\Carbon\Carbon::parse($app->demo_date)->format('d M Y')}}</div>
                        <div style="font-size:12px;color:#94a3b8;margin-top:2px;">{{ substr($app->demo_time, 0, 5) }} WIB</div>
                    </td>
                    <td style="max-width:200px;white-space:normal;font-size:13px;line-height:1.4;color:#64748b;">
                        {{ $app->notes ?? '-' }}
                    </td>
                    <td>
                        <span class="status-select {{ $app->status }}">
                            <span class="status-dot"></span>
                            <select onchange="updateAppointmentStatus({{ $app->id }}, this.value, this)">
                                <option value="pending" {{ $app->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="done" {{ $app->status === 'done' ? 'selected' : '' }}>Selesai</option>
                                <option value="cancelled" {{ $app->status === 'cancelled' ? 'selected' : '' }}>Batal</option>
                            </select>
                            <span class="status-text">{{ $app->status === 'pending' ? 'Pending' : ($app->status === 'done' ? 'Selesai' : 'Batal') }}</span>
                        </span>
                    </td>
                    <td style="text-align:right;white-space:nowrap;">
                        <button type="button" class="btn-icon" title="Salin Info" onclick="copyAppointmentInfo({name:'{{ addslashes($app->name) }}',institution:'{{ addslashes($app->institution) }}',whatsapp:'{{ addslashes($app->whatsapp) }}',email:'{{ addslashes($app->email) }}',date:'{{\Carbon\Carbon::parse($app->demo_date)->format('d M Y')}}',time:'{{ substr($app->demo_time, 0, 5) }}',notes:'{{ addslashes($app->notes ?? '-') }}'}, this)">
                            <x-icon name="copy"/>
                        </button>
                        <button type="button" class="btn-icon danger" title="Hapus" onclick="deleteAppointment('{{ route('admin.appointments.destroy', $app->id) }}', this)">
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
