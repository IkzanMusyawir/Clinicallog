@extends('layouts.admin')

@section('title', 'Kelola Pengguna')

@section('content')

    <div class="admin-topbar">
        <div>
            <h1 class="admin-page-title">Kelola Pengguna</h1>
            <p class="admin-page-sub">{{ $users->total() ?? $users->count() }} pengguna terdaftar</p>
        </div>
    </div>

    <div class="glass-card glass">
        @if ($users->count())
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width:56px;">Inisial</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Terdaftar Sejak</th>
                            <th style="width:100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="users-table">
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    <div
                                        style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#0369A1,#22D3EE);display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:#fff;">
                                        {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                                    </div>
                                </td>
                                <td>
                                    <span style="font-weight: 600;">{{ $user->name }}</span>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at ? $user->created_at->format('d M Y H:i') : '-' }}</td>
                                <td>
                                    @if ($user->is_admin)
                                        <span style="font-size:12px;color:#22c55e;font-weight:600;">Admin</span>
                                    @else
                                        <button type="button" onclick="deleteUser({{ $user->id }}, this, '{{ route('admin.users.destroy', $user) }}')" style="background:rgba(239,68,68,.12);border:none;color:#ef4444;padding:4px 12px;border-radius:6px;cursor:pointer;font-size:13px;font-weight:600;">Hapus</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if (method_exists($users, 'links'))
                <div style="margin-top:20px;padding-top:16px;border-top:1px solid rgba(255,255,255,.06);">
                    {{ $users->links() }}
                </div>
            @endif
        @else
            <div style="text-align:center;padding:64px 20px;">
                <div
                    style="width:64px;height:64px;border-radius:18px;background:rgba(3,105,161,.15);margin:0 auto 16px;display:flex;align-items:center;justify-content:center;">
                    <i data-lucide="users" style="width:28px;height:28px;color:#60a5fa;"></i>
                </div>
                <h3 style="font-size:18px;font-weight:700;color:#f0f6ff;margin-bottom:8px;">Belum ada pengguna</h3>
                <p style="font-size:14px;color:#64748b;">Belum ada data pengguna yang tersedia.</p>
            </div>
        @endif
    </div>

@endsection

@push('scripts')
<script>
function deleteUser(id, btn, url) {
    if (!confirm('Yakin ingin menghapus pengguna ini?')) return;
    btn.disabled = true;
    btn.textContent = '...';
    ajaxAction(url, 'DELETE', {}, {
        onSuccess: function (res) {
            btn.closest('tr').remove();
            var countEl = document.querySelector('.admin-page-sub');
            if (countEl) {
                var m = countEl.textContent.match(/(\d+)/);
                if (m) countEl.textContent = countEl.textContent.replace(m[1], parseInt(m[1]) - 1);
            }
            var tbody = document.querySelector('#users-table');
            if (tbody && !tbody.querySelector('tr')) location.reload();
        },
        onError: function () {
            btn.disabled = false;
            btn.textContent = 'Hapus';
        }
    });
}
</script>
@endpush
