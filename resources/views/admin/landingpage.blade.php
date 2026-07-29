@extends('layouts.admin')

@section('title', 'Edit Landing Page')

@push('head')
<style>
    @keyframes panelFadeIn {
        from {
            opacity: 0;
            transform: translateY(12px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .cms-panel-animate {
        animation: panelFadeIn .3s cubic-bezier(.22, 1, .36, 1) both;
    }
    .cms-panel {
        scroll-margin-top: 90px;
    }
    .cms-panel-loading {
        text-align: center;
        padding: 60px 20px;
        color: #94a3b8;
    }
</style>
@endpush

@section('content')

<div class="admin-topbar">
    <div>
        <h1 class="admin-page-title">Edit Landing Page</h1>
        <p class="admin-page-sub">Kelola semua konten halaman utama website Anda</p>
    </div>
    <a href="{{ route('home') }}" class="btn-secondary btn-sm" target="_blank">
        <x-icon name="eye"/>
        Preview Website
    </a>
</div>

<form id="landingPageForm" method="POST" action="{{ route('admin.landing.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    @include('admin.landing.panels.hero')

    <div class="cms-panel" id="panel-navigation" style="display:none;">@include('admin.landing.panels.navigation')</div>
    <div class="cms-panel" id="panel-about" style="display:none;">@include('admin.landing.panels.about')</div>
    <div class="cms-panel" id="panel-features" style="display:none;">@include('admin.landing.panels.features')</div>
    <div class="cms-panel" id="panel-benefits" style="display:none;">@include('admin.landing.panels.benefits')</div>
    <div class="cms-panel" id="panel-dashboard_tab" style="display:none;">@include('admin.landing.panels.dashboard_tab')</div>
    <div class="cms-panel" id="panel-steps" style="display:none;">@include('admin.landing.panels.steps')</div>
    <div class="cms-panel" id="panel-testimonials" style="display:none;">@include('admin.landing.panels.testimonials')</div>
    <div class="cms-panel" id="panel-pricing" style="display:none;">@include('admin.landing.panels.pricing')</div>
    <div class="cms-panel" id="panel-cta" style="display:none;">@include('admin.landing.panels.cta')</div>
    <div class="cms-panel" id="panel-footer" style="display:none;">@include('admin.landing.panels.footer')</div>

    {{-- Save Button --}}
    <div class="cms-save-bar glass-card glass"
        style="padding: 10px 18px; margin-top: 10px; box-shadow: 0 -10px 30px rgba(15, 23, 42, 0.04);">
        <div class="flex flex-col sm:flex-row gap-2.5">
            <button type="submit" class="btn-primary w-full sm:w-auto flex-1"
                style="padding: 10px 20px; font-size: 13px;">
                <x-icon name="save"/>
                Simpan Semua Perubahan
            </button>
            <a href="{{ route('home') }}" class="btn-secondary w-full sm:w-auto flex-1" target="_blank"
                style="text-align:center; padding: 10px 20px; font-size: 13px;">
                <x-icon name="external-link"/>
                Preview Website
            </a>
        </div>
    </div>
</form>

<form id="delete-feature-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@endsection
