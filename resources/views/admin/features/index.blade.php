@extends('layouts.admin')

@section('title', 'Kelola Fitur')

@section('content')

    <div class="admin-topbar">
        <div>
            <h1 class="admin-page-title">Kelola Fitur</h1>
            <p class="admin-page-sub">{{ $features->total() ?? $features->count() }} fitur tersedia</p>
        </div>
        <a href="{{ route('admin.features.create') }}" class="btn-primary btn-sm">
            <i data-lucide="plus" style="width:14px;height:14px;"></i>
            Tambah Fitur
        </a>
    </div>

    <div class="glass-card glass">
        @if ($features->count())
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width:50px;">No</th>
                            <th style="width:56px;">Icon</th>
                            <th>Nama Fitur</th>
                            <th>Deskripsi</th>
                            <th style="width:100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($features as $feature)
                            <tr>
                                <td>
                                    <div style="width:32px;height:32px;border-radius:8px;background:rgba(37,99,235,.1);display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:#60a5fa;">
                                        {{ $feature->sort_order }}
                                    </div>
                                </td>
                                <td>
                                    @if ($feature->icon_name)
                                        <div
                                            style="width:40px;height:40px;border-radius:10px;background:rgba(37,99,235,.15);border:1px solid rgba(37,99,235,.2);display:flex;align-items:center;justify-content:center;">
                                            <i data-lucide="{{ $feature->icon_name }}" style="width:20px;height:20px;color:#60a5fa;"></i>
                                        </div>
                                    @elseif ($feature->icon)
                                        <div
                                            style="width:40px;height:40px;border-radius:10px;background:rgba(37,99,235,.15);border:1px solid rgba(37,99,235,.2);display:flex;align-items:center;justify-content:center;overflow:hidden;">
                                            <img src="{{ asset('storage/' . $feature->icon) }}" alt=""
                                                style="width:24px;height:24px;object-fit:contain;">
                                        </div>
                                    @else
                                        <div
                                            style="width:40px;height:40px;border-radius:10px;background:rgba(37,99,235,.1);border:1px solid rgba(37,99,235,.15);display:flex;align-items:center;justify-content:center;">
                                            <i data-lucide="image" style="width:16px;height:16px;color:#64748b;"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $feature->title }}</td>
                                <td style="max-width:340px;">
                                    <span
                                        style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                                        {{ $feature->description }}
                                    </span>
                                </td>
                                <td>
                                    <div style="display:flex;gap:6px;">
                                        <a href="{{ route('admin.features.edit', $feature->id) }}" class="btn-icon"
                                            title="Edit">
                                            <i data-lucide="edit-2" style="width:13px;height:13px;"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.features.destroy', $feature->id) }}"
                                            onsubmit="return confirm('Hapus fitur ini?')" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon danger" title="Hapus">
                                                <i data-lucide="trash-2" style="width:13px;height:13px;"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if (method_exists($features, 'links'))
                <div style="margin-top:20px;padding-top:16px;border-top:1px solid rgba(255,255,255,.06);">
                    {{ $features->links() }}
                </div>
            @endif
        @else
            <div style="text-align:center;padding:64px 20px;">
                <div
                    style="width:64px;height:64px;border-radius:18px;background:rgba(37,99,235,.15);margin:0 auto 16px;display:flex;align-items:center;justify-content:center;">
                    <i data-lucide="layers" style="width:28px;height:28px;color:#60a5fa;"></i>
                </div>
                <h3 style="font-size:18px;font-weight:700;color:#f0f6ff;margin-bottom:8px;">Belum ada fitur</h3>
                <p style="font-size:14px;color:#64748b;margin-bottom:20px;">Tambahkan fitur pertama ClinicalLog sekarang.
                </p>
                <a href="{{ route('admin.features.create') }}" class="btn-primary">
                    <i data-lucide="plus" style="width:14px;height:14px;"></i>
                    Tambah Fitur Pertama
                </a>
            </div>
        @endif
    </div>

@endsection
