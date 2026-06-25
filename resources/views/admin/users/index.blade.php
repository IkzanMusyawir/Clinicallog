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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    <div
                                        style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#2563eb,#06b6d4);display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:#fff;">
                                        {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                                    </div>
                                </td>
                                <td>
                                    <span style="font-weight: 600;">{{ $user->name }}</span>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at ? $user->created_at->format('d M Y H:i') : '-' }}</td>
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
                    style="width:64px;height:64px;border-radius:18px;background:rgba(37,99,235,.15);margin:0 auto 16px;display:flex;align-items:center;justify-content:center;">
                    <i data-lucide="users" style="width:28px;height:28px;color:#60a5fa;"></i>
                </div>
                <h3 style="font-size:18px;font-weight:700;color:#f0f6ff;margin-bottom:8px;">Belum ada pengguna</h3>
                <p style="font-size:14px;color:#64748b;">Belum ada data pengguna yang tersedia.</p>
            </div>
        @endif
    </div>

@endsection
