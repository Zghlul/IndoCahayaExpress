@extends('layouts.app')

@section('title', 'Invoice Saya')

@section('content')

@push('styles')
<style>
/* ══ MY INVOICES — ICE Design System (aligned with dashboard.blade) ══ */
.inv-shell {
    background:
        radial-gradient(900px 500px at 90% -10%, rgba(227,30,36,0.05), transparent 60%),
        radial-gradient(900px 500px at -10% 10%, rgba(6,15,46,0.04), transparent 60%),
        #FAFBFE;
    min-height: calc(100vh - 200px);
    padding: 3rem 0 5rem;
}
.inv-container {
    max-width: 1440px;
    margin: 0 auto;
    padding: 0 2rem;
}

/* ── HERO ── */
.inv-hero {
    background: linear-gradient(135deg, #060F2E 0%, #0A1A4A 100%);
    border-radius: 24px;
    padding: 2.5rem;
    color: #fff;
    position: relative;
    overflow: hidden;
    margin-bottom: 2rem;
    box-shadow: 0 20px 60px rgba(6,15,46,0.25);
}
.inv-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
    background-size: 40px 40px;
    pointer-events: none;
}
.inv-hero::after {
    content: '';
    position: absolute;
    top: -100px; right: -100px;
    width: 360px; height: 360px;
    background: radial-gradient(circle, rgba(227,30,36,0.3) 0%, transparent 70%);
    pointer-events: none;
}
.inv-hero-inner {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 2rem;
    flex-wrap: wrap;
}
.inv-hero-text { flex: 1; min-width: 260px; }
.inv-hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.7rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.15em;
    color: rgba(255,255,255,0.65);
    padding: 0.4rem 0.85rem;
    border: 1px solid rgba(255,255,255,0.18);
    border-radius: 99px;
    background: rgba(255,255,255,0.05);
    margin-bottom: 1.25rem;
}
.inv-hero-eyebrow::before {
    content: '';
    width: 6px; height: 6px;
    border-radius: 50%;
    background: #f59e0b;
    box-shadow: 0 0 8px rgba(245,158,11,0.7);
}
.inv-hero h1 {
    font-size: clamp(1.75rem, 3.5vw, 2.25rem);
    font-weight: 900;
    line-height: 1.1;
    margin: 0 0 0.5rem;
    color: #fff;
    letter-spacing: -0.02em;
}
.inv-hero p {
    font-size: 0.95rem;
    color: rgba(255,255,255,0.65);
    margin: 0;
}
.inv-hero p strong { color: rgba(255,255,255,0.9); }
.inv-readonly-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(245,158,11,0.15);
    color: #fbbf24;
    border: 1px solid rgba(245,158,11,0.35);
    padding: 0.5rem 1rem;
    border-radius: 99px;
    font-size: 0.75rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    white-space: nowrap;
    flex-shrink: 0;
}
.inv-readonly-badge svg { width: 13px; height: 13px; }

/* ── UNPAID BANNER ── */
.inv-unpaid-banner {
    background: #fff;
    border: 1.5px solid #fcd34d;
    border-left: 4px solid #f59e0b;
    border-radius: 14px;
    padding: 1.125rem 1.5rem;
    margin-bottom: 1.75rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
    box-shadow: 0 4px 16px rgba(245,158,11,0.1);
}
.inv-unpaid-banner svg { width: 20px; height: 20px; color: #d97706; flex-shrink: 0; }
.inv-unpaid-banner-text strong {
    font-size: 0.9375rem;
    font-weight: 800;
    color: #92400e;
    display: block;
    margin-bottom: 0.15rem;
}
.inv-unpaid-banner-text span { font-size: 0.8125rem; color: #b45309; }
.inv-unpaid-banner-amount {
    margin-left: auto;
    font-size: 1.25rem;
    font-weight: 900;
    color: #92400e;
    white-space: nowrap;
    background: rgba(245,158,11,0.1);
    padding: 0.4rem 0.85rem;
    border-radius: 8px;
}

/* ── STATS GRID ── */
.inv-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1.25rem;
    margin-bottom: 2rem;
}
.inv-stat {
    background: #fff;
    border: 1px solid #DDE6F5;
    border-radius: 18px;
    padding: 1.4rem;
    transition: all 0.3s cubic-bezier(0.22,1,0.36,1);
    position: relative;
    overflow: hidden;
}
.inv-stat:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 40px rgba(9,24,60,0.10);
    border-color: #C8D6EE;
}
.inv-stat::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 3px;
    background: var(--inv-accent, #060F2E);
    opacity: 0.85;
}
.inv-stat[data-accent="navy"]  { --inv-accent: #060F2E; }
.inv-stat[data-accent="amber"] { --inv-accent: #f59e0b; }
.inv-stat[data-accent="green"] { --inv-accent: #16a34a; }
.inv-stat[data-accent="red"]   { --inv-accent: #E31E24; }
.inv-stat-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;
}
.inv-stat-icon {
    width: 44px; height: 44px;
    border-radius: 12px;
    background: color-mix(in srgb, var(--inv-accent) 10%, transparent);
    color: var(--inv-accent);
    display: inline-flex;
    align-items: center;
    justify-content: center;
}
.inv-stat-icon svg { width: 22px; height: 22px; }
.inv-stat-tag {
    font-size: 0.68rem;
    font-weight: 800;
    padding: 0.25rem 0.55rem;
    border-radius: 99px;
    background: color-mix(in srgb, var(--inv-accent) 10%, transparent);
    color: var(--inv-accent);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.inv-stat-label {
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: #7A93B8;
    margin: 0 0 0.4rem;
}
.inv-stat-value {
    font-size: 1.85rem;
    font-weight: 900;
    color: #09183C;
    line-height: 1.1;
    letter-spacing: -0.02em;
}
.inv-stat-value.amber { color: #d97706; }
.inv-stat-value-sm {
    font-size: 1.2rem;
    font-weight: 900;
    color: #09183C;
    line-height: 1.2;
    letter-spacing: -0.01em;
}
.inv-stat-sub {
    font-size: 0.78rem;
    color: #3D5478;
    margin-top: 0.35rem;
}

/* ── FILTER CARD ── */
.inv-filter-card {
    background: #fff;
    border: 1px solid #DDE6F5;
    border-radius: 14px;
    padding: 1rem 1.375rem;
    margin-bottom: 1.375rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
    box-shadow: 0 2px 8px rgba(9,24,60,0.05);
}
.inv-filter-tabs { display: flex; gap: 6px; flex-wrap: wrap; flex-shrink: 0; }
.inv-filter-tab {
    padding: 7px 18px;
    border-radius: 8px;
    border: 1.5px solid #DDE6F5;
    font-size: 0.8rem;
    font-weight: 700;
    color: #7A93B8;
    text-decoration: none;
    background: #FAFBFE;
    transition: all 0.18s;
    display: inline-block;
    white-space: nowrap;
}
.inv-filter-tab:hover {
    border-color: #060F2E;
    color: #060F2E;
    background: #F1F5FC;
}
.inv-ft-all {
    background: #060F2E !important;
    color: #fff !important;
    border-color: #060F2E !important;
}
.inv-ft-unpaid {
    background: #f59e0b !important;
    color: #fff !important;
    border-color: #f59e0b !important;
}
.inv-ft-paid {
    background: #16a34a !important;
    color: #fff !important;
    border-color: #16a34a !important;
}
.inv-search-form { display: flex; gap: 8px; align-items: center; flex: 1; min-width: 0; }
.inv-search-wrap { position: relative; flex: 1; min-width: 0; }
.inv-search-wrap svg {
    position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
    color: #7A93B8; width: 15px; height: 15px; pointer-events: none;
}
.inv-search-wrap input {
    width: 100%; padding: 9px 14px 9px 38px;
    border: 1.5px solid #DDE6F5; border-radius: 9px;
    font-size: 0.875rem; background: #FAFBFE; color: #09183C;
    font-family: inherit; transition: all 0.2s; box-sizing: border-box;
}
.inv-search-wrap input:focus {
    border-color: #060F2E;
    box-shadow: 0 0 0 3px rgba(6,15,46,0.08);
    outline: none;
    background: #fff;
}
.inv-search-wrap input::placeholder { color: #7A93B8; }
.inv-btn-search {
    padding: 9px 18px;
    background: #060F2E;
    color: #fff;
    border: none;
    border-radius: 9px;
    font-weight: 700;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.18s;
    font-family: inherit;
    white-space: nowrap;
}
.inv-btn-search:hover { background: #0A1A4A; }
.inv-btn-reset {
    padding: 9px 14px;
    background: #FAFBFE;
    color: #3D5478;
    border: 1.5px solid #DDE6F5;
    border-radius: 9px;
    font-weight: 700;
    font-size: 0.875rem;
    cursor: pointer;
    font-family: inherit;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    white-space: nowrap;
    transition: all 0.18s;
}
.inv-btn-reset:hover { border-color: #060F2E; color: #060F2E; }
.inv-filter-count {
    margin-left: auto;
    font-size: 0.78rem;
    color: #7A93B8;
    font-weight: 700;
    white-space: nowrap;
    background: #F1F5FC;
    padding: 0.3rem 0.65rem;
    border-radius: 99px;
    border: 1px solid #DDE6F5;
}

/* ── TABLE CARD ── */
.inv-card {
    background: #fff;
    border: 1px solid #DDE6F5;
    border-radius: 18px;
    overflow: hidden;
    margin-bottom: 1.5rem;
}
.inv-card-header {
    padding: 1.1rem 1.4rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #DDE6F5;
    background: #FAFBFE;
}
.inv-card-header-left {
    display: flex;
    align-items: center;
    gap: 0.6rem;
}
.inv-card-header-icon {
    width: 32px; height: 32px;
    border-radius: 9px;
    background: rgba(6,15,46,0.06);
    color: #060F2E;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}
.inv-card-header-icon svg { width: 16px; height: 16px; }
.inv-card-header h3 {
    margin: 0;
    font-size: 1rem;
    font-weight: 800;
    color: #09183C;
    letter-spacing: -0.01em;
}
.inv-card-header-meta {
    font-size: 0.78rem;
    color: #7A93B8;
    font-weight: 600;
}

/* ── TABLE ── */
.inv-table-wrap { overflow-x: auto; }
.inv-table {
    width: 100%;
    border-collapse: collapse;
}
.inv-table th {
    text-align: left;
    padding: 0.85rem 1rem;
    font-size: 0.68rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: rgba(255,255,255,0.85);
    background: #060F2E;
    border-bottom: 1px solid #DDE6F5;
    white-space: nowrap;
}
.inv-table th.right { text-align: right; }
.inv-table td {
    padding: 0.95rem 1rem;
    font-size: 0.85rem;
    color: #3D5478;
    border-bottom: 1px solid #DDE6F5;
    vertical-align: middle;
    font-weight: 500;
}
.inv-table tr:last-child td { border-bottom: none; }
.inv-table tbody tr { transition: background 0.15s; }
.inv-table tbody tr:hover td { background: #F1F5FC; }

/* Badges */
.inv-num-badge {
    font-family: 'JetBrains Mono', 'SF Mono', 'Courier New', monospace;
    font-size: 0.78rem;
    font-weight: 700;
    background: rgba(6,15,46,0.06);
    padding: 0.3rem 0.6rem;
    border-radius: 7px;
    color: #060F2E;
    border: 1px solid #DDE6F5;
    white-space: nowrap;
    display: inline-block;
}
.inv-pkg-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: #F1F5FC;
    color: #3D5478;
    padding: 0.25rem 0.6rem;
    border-radius: 7px;
    font-size: 0.75rem;
    font-weight: 700;
    border: 1px solid #DDE6F5;
}
.inv-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.3rem 0.7rem;
    border-radius: 99px;
    font-size: 0.7rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    white-space: nowrap;
}
.inv-badge::before {
    content: '';
    width: 6px; height: 6px;
    border-radius: 50%;
    background: currentColor;
}
.inv-badge.paid   { background: rgba(22,163,74,0.1);  color: #15803d; }
.inv-badge.unpaid { background: rgba(245,158,11,0.12); color: #b45309; }
.inv-cell-price {
    font-weight: 800;
    color: #09183C;
}

/* View btn */
.inv-btn-view {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 6px 14px;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 700;
    background: #060F2E;
    color: #fff;
    text-decoration: none;
    transition: all 0.18s;
    border: none;
    cursor: pointer;
    white-space: nowrap;
}
.inv-btn-view:hover {
    background: #0A1A4A;
    transform: translateY(-1px);
    box-shadow: 0 6px 14px rgba(6,15,46,0.25);
    color: #fff;
}
.inv-btn-view svg { width: 12px; height: 12px; }

/* Empty state */
.inv-empty {
    text-align: center;
    padding: 3.5rem 1.5rem;
    color: #7A93B8;
}
.inv-empty-icon {
    width: 64px; height: 64px;
    margin: 0 auto 1rem;
    border-radius: 16px;
    background: #F1F5FC;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #060F2E;
}
.inv-empty-icon svg { width: 28px; height: 28px; }
.inv-empty h4 { font-size: 1rem; font-weight: 800; color: #09183C; margin: 0 0 0.4rem; }
.inv-empty p { margin: 0; font-size: 0.85rem; }

/* Pagination */
.inv-pagination {
    display: flex;
    justify-content: center;
    gap: 0.35rem;
    padding: 1rem 1.4rem;
    border-top: 1px solid #DDE6F5;
    background: #FAFBFE;
    flex-wrap: wrap;
}
.pg {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 34px;
    height: 34px;
    padding: 0 0.65rem;
    border-radius: 8px;
    font-size: 0.82rem;
    font-weight: 700;
    color: #3D5478;
    background: #fff;
    border: 1px solid #DDE6F5;
    text-decoration: none;
    transition: all 0.15s;
}
.pg:hover  { border-color: #060F2E; color: #060F2E; }
.pg.active { background: #060F2E; color: #fff; border-color: #060F2E; }
.pg.dots   { cursor: default; border-color: transparent; background: transparent; color: #7A93B8; }

/* ── RESPONSIVE ── */
@media (max-width: 1100px) { .inv-stats { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 768px) {
    .inv-container { padding: 0 1.25rem; }
    .inv-shell { padding: 1.5rem 0 3rem; }
    .inv-hero { padding: 1.75rem 1.5rem; border-radius: 18px; }
    .inv-stats { grid-template-columns: 1fr 1fr; gap: 1rem; }
    .inv-filter-card { flex-direction: column; align-items: stretch; }
    .inv-search-form { flex-wrap: wrap; }
    .inv-filter-count { margin-left: 0; }
}
@media (max-width: 480px) { .inv-stats { grid-template-columns: 1fr; } }
</style>
@endpush

<div class="inv-shell">
    <div class="inv-container">

        {{-- ═══ HERO ═══ --}}
        <section class="inv-hero">
            <div class="inv-hero-inner">
                <div class="inv-hero-text">
                    <span class="inv-hero-eyebrow">Riwayat Tagihan</span>
                    <h1>Invoice Saya</h1>
                    <p>Tagihan pengiriman atas nama <strong>{{ Auth::user()->name }}</strong></p>
                </div>
                <div class="inv-readonly-badge">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    Hanya Bisa Dilihat
                </div>
            </div>
        </section>

        {{-- ═══ UNPAID BANNER ═══ --}}
        @if(($stats->total_unpaid ?? 0) > 0)
        <div class="inv-unpaid-banner">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <div class="inv-unpaid-banner-text">
                <strong>Tagihan Belum Lunas</strong>
                <span>Anda memiliki {{ $stats->total_unpaid }} invoice yang belum dibayar. Silakan hubungi admin.</span>
            </div>
            <div class="inv-unpaid-banner-amount">Rp {{ number_format($stats->nilai_unpaid ?? 0, 0, ',', '.') }}</div>
        </div>
        @endif

        {{-- ═══ STATS ═══ --}}
        <section class="inv-stats">
            <div class="inv-stat" data-accent="navy">
                <div class="inv-stat-head">
                    <div class="inv-stat-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    </div>
                    <span class="inv-stat-tag">Total</span>
                </div>
                <p class="inv-stat-label">Total Invoice</p>
                <div class="inv-stat-value">{{ number_format($stats->total ?? 0) }}</div>
                <div class="inv-stat-sub">Semua invoice Anda</div>
            </div>

            <div class="inv-stat" data-accent="amber">
                <div class="inv-stat-head">
                    <div class="inv-stat-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    </div>
                    <span class="inv-stat-tag">Pending</span>
                </div>
                <p class="inv-stat-label">Belum Lunas</p>
                <div class="inv-stat-value amber">{{ number_format($stats->total_unpaid ?? 0) }}</div>
                <div class="inv-stat-sub">Perlu segera dilunasi</div>
            </div>

            <div class="inv-stat" data-accent="green">
                <div class="inv-stat-head">
                    <div class="inv-stat-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    <span class="inv-stat-tag">Paid</span>
                </div>
                <p class="inv-stat-label">Total Lunas</p>
                <div class="inv-stat-value-sm">Rp {{ number_format($stats->nilai_paid ?? 0, 0, ',', '.') }}</div>
                <div class="inv-stat-sub">Total sudah dibayar</div>
            </div>

            <div class="inv-stat" data-accent="red">
                <div class="inv-stat-head">
                    <div class="inv-stat-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    </div>
                    <span class="inv-stat-tag">IDR</span>
                </div>
                <p class="inv-stat-label">Total Tagihan</p>
                <div class="inv-stat-value-sm">Rp {{ number_format($stats->total_nilai ?? 0, 0, ',', '.') }}</div>
                <div class="inv-stat-sub">Akumulasi seluruh invoice</div>
            </div>
        </section>

        {{-- ═══ FILTER ═══ --}}
        <div class="inv-filter-card">
            <div class="inv-filter-tabs">
                <a href="{{ request()->fullUrlWithQuery(['status' => 'all', 'page' => 1]) }}"
                   class="inv-filter-tab {{ $status === 'all' ? 'inv-ft-all' : '' }}">Semua</a>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'Unpaid', 'page' => 1]) }}"
                   class="inv-filter-tab {{ $status === 'Unpaid' ? 'inv-ft-unpaid' : '' }}">Belum Lunas</a>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'Paid', 'page' => 1]) }}"
                   class="inv-filter-tab {{ $status === 'Paid' ? 'inv-ft-paid' : '' }}">Lunas</a>
            </div>
            <form method="GET" class="inv-search-form">
                <input type="hidden" name="status" value="{{ $status }}">
                <div class="inv-search-wrap">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari nomor invoice...">
                </div>
                <button type="submit" class="inv-btn-search">Cari</button>
                @if($search || $status !== 'all')
                    <a href="{{ route('my.invoices') }}" class="inv-btn-reset">Reset</a>
                @endif
            </form>
            <div class="inv-filter-count">{{ $totalRows }} ditemukan</div>
        </div>

        {{-- ═══ TABLE ═══ --}}
        <div class="inv-card">
            <div class="inv-card-header">
                <div class="inv-card-header-left">
                    <div class="inv-card-header-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                    </div>
                    <h3>Daftar Invoice</h3>
                </div>
                <span class="inv-card-header-meta">Halaman {{ $page }} / {{ $totalPages }}</span>
            </div>

            <div class="inv-table-wrap">
                <table class="inv-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nomor Invoice</th>
                            <th class="right">Paket</th>
                            <th class="right">Subtotal</th>
                            <th class="right">DDP</th>
                            <th class="right">Grand Total</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $idx => $inv)
                            <tr>
                                <td style="color:#7A93B8;font-weight:600;">{{ (($page-1)*15) + $idx+1 }}</td>
                                <td><span class="inv-num-badge">{{ $inv->nomor_inv }}</span></td>
                                <td class="right"><span class="inv-pkg-badge">{{ $inv->jumlah_paket }} pkt</span></td>
                                <td class="right">Rp {{ number_format($inv->subtotal, 0, ',', '.') }}</td>
                                <td class="right">
                                    @if($inv->ddp > 0)
                                        <span class="inv-cell-price">Rp {{ number_format($inv->ddp, 0, ',', '.') }}</span>
                                    @else
                                        <span style="color:#C8D6EE;">—</span>
                                    @endif
                                </td>
                                <td class="right"><span class="inv-cell-price">Rp {{ number_format($inv->grand_total, 0, ',', '.') }}</span></td>
                                <td>
                                    @if($inv->status === 'Paid')
                                        <span class="inv-badge paid">Lunas</span>
                                    @else
                                        <span class="inv-badge unpaid">Belum Lunas</span>
                                    @endif
                                </td>
                                <td style="color:#7A93B8;">{{ date('d M Y', strtotime($inv->created_at)) }}</td>
                                <td>
                                    <a href="{{ route('invoice.detail', hashid_encode($inv->id)) }}"
                                       class="inv-btn-view" target="_blank">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        Lihat
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9">
                                    <div class="inv-empty">
                                        <div class="inv-empty-icon">
                                            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="9" y1="13" x2="15" y2="13"/><line x1="9" y1="17" x2="13" y2="17"/></svg>
                                        </div>
                                        <h4>Tidak ada invoice ditemukan</h4>
                                        <p>Coba ubah filter atau kata kunci pencarian Anda.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($totalPages > 1)
            <div class="inv-pagination">
                @if($page > 1)
                    <a href="{{ request()->fullUrlWithQuery(['page' => $page-1]) }}" class="pg">&larr;</a>
                @endif
                @for($p = 1; $p <= $totalPages; $p++)
                    @if($p == $page)
                        <span class="pg active">{{ $p }}</span>
                    @elseif($p == 1 || $p == $totalPages || abs($p - $page) <= 1)
                        <a href="{{ request()->fullUrlWithQuery(['page' => $p]) }}" class="pg">{{ $p }}</a>
                    @elseif(abs($p - $page) == 2)
                        <span class="pg dots">…</span>
                    @endif
                @endfor
                @if($page < $totalPages)
                    <a href="{{ request()->fullUrlWithQuery(['page' => $page+1]) }}" class="pg">&rarr;</a>
                @endif
            </div>
            @endif
        </div>

    </div>{{-- /container --}}
</div>{{-- /shell --}}

@endsection
