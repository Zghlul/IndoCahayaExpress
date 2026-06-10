@extends('layouts.app')
@section('title', 'Dashboard Saya')
@section('content')

@php
    // ── Hitung statistik tambahan dari koleksi shipments ──
    $allShipments    = $shipments instanceof \Illuminate\Pagination\AbstractPaginator
                        ? $shipments->getCollection()
                        : collect($shipments);
    $pendingCount    = $allShipments->filter(fn($s) => strtolower($s->status_pengerjaan ?? 'pending') === 'pending')->count();
    $processingCount = $allShipments->filter(fn($s) => strtolower($s->status_pengerjaan ?? '') === 'processing')->count();
    $deliveredCount  = $allShipments->filter(fn($s) => strtolower($s->status_pengerjaan ?? '') === 'delivered')->count();
    $cancelledCount  = $allShipments->filter(fn($s) => strtolower($s->status_pengerjaan ?? '') === 'cancelled')->count();
    $avgSpent        = ($totalShipments ?? 0) > 0
                        ? ($totalSpent ?? 0) / $totalShipments
                        : 0;
    // Top destinations
    $topCountries = $allShipments
        ->filter(fn($s) => !empty($s->negara))
        ->groupBy('negara')
        ->map(fn($g) => $g->count())
        ->sortDesc()
        ->take(5);
    // Monthly trend (6 bulan terakhir)
    $monthly = collect(range(5, 0))->map(function ($i) use ($allShipments) {
        $month = now()->subMonths($i);
        $label = $month->format('M');
        $count = $allShipments->filter(function ($s) use ($month) {
            return $s->created_at && \Carbon\Carbon::parse($s->created_at)->isSameMonth($month);
        })->count();
        $spend = $allShipments->filter(function ($s) use ($month) {
            return $s->created_at && \Carbon\Carbon::parse($s->created_at)->isSameMonth($month);
        })->sum('charge_idr');
        return ['label' => $label, 'count' => $count, 'spend' => (int) $spend];
    });
    $chartLabels = $monthly->pluck('label')->toJson();
    $chartCounts = $monthly->pluck('count')->toJson();
    $chartSpends = $monthly->pluck('spend')->toJson();
@endphp

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<style>
/* ══ DASHBOARD — aligned with invoices.blade design tokens ══ */
.db-shell {
    background:
        radial-gradient(900px 500px at 90% -10%, rgba(227,30,36,0.05), transparent 60%),
        radial-gradient(900px 500px at -10% 10%, rgba(6,15,46,0.04), transparent 60%),
        #FAFBFE;
    min-height: calc(100vh - 200px);
    padding: 3rem 0 5rem;
}
.db-container {
    max-width: 1440px;
    margin: 0 auto;
    padding: 0 2rem;
}

/* ── HERO ── */
.db-hero {
    background: linear-gradient(135deg, #060F2E 0%, #0A1A4A 100%);
    border-radius: 24px;
    padding: 2.5rem 2.5rem;
    color: #fff;
    position: relative;
    overflow: hidden;
    margin-bottom: 2rem;
    box-shadow: 0 20px 60px rgba(6,15,46,0.25);
}
.db-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
    background-size: 40px 40px;
    pointer-events: none;
}
.db-hero::after {
    content: '';
    position: absolute;
    top: -100px; right: -100px;
    width: 360px; height: 360px;
    background: radial-gradient(circle, rgba(227,30,36,0.35) 0%, transparent 70%);
    pointer-events: none;
}
.db-hero-inner {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 2rem;
    flex-wrap: wrap;
}
.db-hero-text {
    flex: 1;
    min-width: 260px;
}
.db-hero-eyebrow {
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
.db-hero-eyebrow::before {
    content: '';
    width: 6px; height: 6px;
    border-radius: 50%;
    background: #22c55e;
    box-shadow: 0 0 8px rgba(34,197,94,0.7);
}
.db-hero h1 {
    font-family: 'DM Serif Display', serif;
    font-size: clamp(1.75rem, 3.5vw, 2.5rem);
    font-weight: 400;
    line-height: 1.1;
    margin: 0 0 0.5rem;
    color: #fff;
    letter-spacing: -0.01em;
}
.db-hero h1 em {
    color: #fff;
    background: linear-gradient(90deg, #fff 0%, rgba(255,255,255,0.7) 100%);
    -webkit-background-clip: text;
    background-clip: text;
}
.db-hero p {
    font-size: 0.95rem;
    color: rgba(255,255,255,0.65);
    margin: 0;
    max-width: 480px;
}
.db-hero-avatar {
    width: 72px; height: 72px;
    border-radius: 50%;
    background: linear-gradient(135deg, #E31E24, #C7181D);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-weight: 900;
    font-size: 1.65rem;
    box-shadow: 0 12px 32px rgba(227,30,36,0.4), inset 0 1px 0 rgba(255,255,255,0.2);
    border: 3px solid rgba(255,255,255,0.15);
    flex-shrink: 0;
}

/* ── STATS GRID ── */
.db-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1.25rem;
    margin-bottom: 2rem;
}
.db-stat {
    background: #fff;
    border: 1px solid #DDE6F5;
    border-radius: 18px;
    padding: 1.4rem;
    transition: all 0.3s cubic-bezier(0.22,1,0.36,1);
    position: relative;
    overflow: hidden;
}
.db-stat:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 40px rgba(9,24,60,0.10);
    border-color: #C8D6EE;
}
.db-stat::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 3px;
    background: var(--accent, #060F2E);
    opacity: 0.85;
}
.db-stat[data-accent="navy"]  { --accent: #060F2E; }
.db-stat[data-accent="red"]   { --accent: #E31E24; }
.db-stat[data-accent="green"] { --accent: #16a34a; }
.db-stat[data-accent="amber"] { --accent: #f59e0b; }
.db-stat-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;
}
.db-stat-icon {
    width: 44px; height: 44px;
    border-radius: 12px;
    background: color-mix(in srgb, var(--accent) 10%, transparent);
    color: var(--accent);
    display: inline-flex;
    align-items: center;
    justify-content: center;
}
.db-stat-icon svg { width: 22px; height: 22px; }
.db-stat-trend {
    font-size: 0.68rem;
    font-weight: 800;
    padding: 0.25rem 0.55rem;
    border-radius: 99px;
    background: color-mix(in srgb, var(--accent) 10%, transparent);
    color: var(--accent);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.db-stat-label {
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: #7A93B8;
    margin: 0 0 0.4rem;
}
.db-stat-value {
    font-size: 1.85rem;
    font-weight: 900;
    color: #09183C;
    line-height: 1.1;
    letter-spacing: -0.02em;
}
.db-stat-sub {
    font-size: 0.78rem;
    color: #3D5478;
    margin-top: 0.35rem;
}

/* ── QUICK ACTIONS ── */
.db-actions {
    display: flex;
    gap: 0.75rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}
.db-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.25rem;
    border-radius: 10px;
    font-weight: 700;
    font-size: 0.875rem;
    text-decoration: none;
    transition: all 0.25s cubic-bezier(0.22,1,0.36,1);
    border: 1.5px solid transparent;
    cursor: pointer;
    font-family: inherit;
}
.db-btn svg { width: 16px; height: 16px; }
.db-btn-primary {
    background: #E31E24;
    color: #fff;
    box-shadow: 0 6px 16px rgba(227,30,36,0.3), inset 0 1px 0 rgba(255,255,255,0.15);
}
.db-btn-primary:hover {
    background: #C7181D;
    transform: translateY(-2px);
    box-shadow: 0 10px 22px rgba(227,30,36,0.4);
}
.db-btn-secondary {
    background: #060F2E;
    color: #fff;
}
.db-btn-secondary:hover {
    background: #0A1A4A;
    transform: translateY(-2px);
}
.db-btn-outline {
    background: #fff;
    color: #060F2E;
    border-color: #C8D6EE;
}
.db-btn-outline:hover {
    border-color: #060F2E;
    background: #F1F5FC;
}

/* ── GRID LAYOUT ── */
.db-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 1.5rem;
    margin-bottom: 2rem;
}
@media (max-width: 960px) { .db-grid { grid-template-columns: 1fr; } }

/* ── CARDS ── */
.db-card {
    background: #fff;
    border: 1px solid #DDE6F5;
    border-radius: 18px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}
.db-card-header {
    padding: 1.1rem 1.4rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #DDE6F5;
    background: #FAFBFE;
}
.db-card-header-left {
    display: flex;
    align-items: center;
    gap: 0.6rem;
}
.db-card-header-icon {
    width: 32px; height: 32px;
    border-radius: 9px;
    background: rgba(6,15,46,0.06);
    color: #060F2E;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}
.db-card-header-icon svg { width: 16px; height: 16px; }
.db-card-header h3 {
    margin: 0;
    font-size: 1rem;
    font-weight: 800;
    color: #09183C;
    letter-spacing: -0.01em;
}
.db-card-header-meta {
    font-size: 0.78rem;
    color: #7A93B8;
    font-weight: 600;
}
.db-card-body { padding: 1.4rem; flex: 1; }

/* ── CHART ── */
.db-chart-wrap {
    position: relative;
    height: 280px;
}

/* ── COUNTRIES LIST ── */
.db-country-list {
    display: flex;
    flex-direction: column;
    gap: 0.85rem;
}
.db-country {
    display: flex;
    align-items: center;
    gap: 0.85rem;
}
.db-country-flag {
    width: 36px; height: 36px;
    border-radius: 10px;
    background: #F1F5FC;
    border: 1px solid #DDE6F5;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #060F2E;
    flex-shrink: 0;
}
.db-country-flag svg { width: 16px; height: 16px; }
.db-country-info { flex: 1; min-width: 0; }
.db-country-name {
    font-size: 0.85rem;
    font-weight: 700;
    color: #09183C;
    margin: 0 0 0.35rem;
}
.db-country-bar {
    height: 6px;
    background: #F1F5FC;
    border-radius: 999px;
    overflow: hidden;
}
.db-country-fill {
    height: 100%;
    background: linear-gradient(90deg, #E31E24, #C7181D);
    border-radius: 999px;
    transition: width 0.6s cubic-bezier(0.22,1,0.36,1);
}
.db-country-count {
    font-size: 0.85rem;
    font-weight: 800;
    color: #09183C;
}

/* ── STATUS BREAKDOWN ── */
.db-status-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.85rem;
}
.db-status-item {
    background: #F1F5FC;
    border-radius: 12px;
    padding: 0.85rem;
    border-left: 3px solid #7A93B8;
}
.db-status-item.pending    { border-left-color: #f59e0b; }
.db-status-item.processing { border-left-color: #3b82f6; }
.db-status-item.delivered  { border-left-color: #16a34a; }
.db-status-item.cancelled  { border-left-color: #ef4444; }
.db-status-label {
    font-size: 0.7rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: #7A93B8;
    margin-bottom: 0.25rem;
}
.db-status-val {
    font-size: 1.4rem;
    font-weight: 900;
    color: #09183C;
}

/* ── TABLE ── */
.db-table-wrap { overflow-x: auto; }
.db-table {
    width: 100%;
    border-collapse: collapse;
}
.db-table th {
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
.db-table th.right { text-align: right; }
.db-table td {
    padding: 0.95rem 1rem;
    font-size: 0.85rem;
    color: #3D5478;
    border-bottom: 1px solid #DDE6F5;
    vertical-align: middle;
    font-weight: 500;
}
.db-table tr:last-child td { border-bottom: none; }
.db-table tbody tr { transition: background 0.15s; }
.db-table tbody tr:hover td { background: #F1F5FC; }
.db-tracking {
    font-family: 'JetBrains Mono', ui-monospace, SFMono-Regular, Menlo, monospace;
    background: rgba(6,15,46,0.06);
    padding: 0.3rem 0.55rem;
    border-radius: 6px;
    font-size: 0.78rem;
    font-weight: 700;
    color: #060F2E;
    border: 1px solid #DDE6F5;
}
.db-cell-recipient {
    font-weight: 700;
    color: #09183C;
}
.db-cell-price {
    font-weight: 800;
    color: #09183C;
}
.db-badge {
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
.db-badge::before {
    content: '';
    width: 6px; height: 6px;
    border-radius: 50%;
    background: currentColor;
}
.db-badge.pending    { background: rgba(245,158,11,0.12); color: #b45309; }
.db-badge.processing { background: rgba(59,130,246,0.12); color: #1d4ed8; }
.db-badge.delivered  { background: rgba(22,163,74,0.12);  color: #15803d; }
.db-badge.cancelled  { background: rgba(239,68,68,0.12);  color: #b91c1c; }
.db-btn-icon {
    width: 32px; height: 32px;
    border-radius: 8px;
    background: transparent;
    border: 1px solid #C8D6EE;
    color: #3D5478;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.15s;
}
.db-btn-icon:hover {
    border-color: #ef4444;
    color: #ef4444;
    background: rgba(239,68,68,0.06);
}
.db-btn-icon.disabled {
    opacity: 0.4;
    cursor: not-allowed;
    pointer-events: none;
}
.db-btn-icon svg { width: 14px; height: 14px; }

/* ── EMPTY STATE ── */
.db-empty {
    text-align: center;
    padding: 3.5rem 1.5rem;
    color: #7A93B8;
}
.db-empty-icon {
    width: 64px; height: 64px;
    margin: 0 auto 1rem;
    border-radius: 16px;
    background: #F1F5FC;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #060F2E;
}
.db-empty-icon svg { width: 28px; height: 28px; }
.db-empty h4 {
    font-size: 1rem;
    font-weight: 800;
    color: #09183C;
    margin: 0 0 0.4rem;
}
.db-empty p {
    margin: 0 0 1.2rem;
    font-size: 0.85rem;
}

/* ── PAGINATION ── */
.db-table-foot {
    padding: 1rem 1.4rem;
    border-top: 1px solid #DDE6F5;
    background: #FAFBFE;
}
.db-table-foot .pagination {
    display: flex;
    justify-content: center;
    gap: 0.35rem;
    margin: 0;
    padding: 0;
    list-style: none;
    flex-wrap: wrap;
}
.db-table-foot .pagination a,
.db-table-foot .pagination span {
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
.db-table-foot .pagination a:hover {
    border-color: #060F2E;
    color: #060F2E;
}
.db-table-foot .pagination .active span {
    background: #060F2E;
    color: #fff;
    border-color: #060F2E;
}
.db-table-foot .pagination .disabled span {
    opacity: 0.4;
}

/* ── RESPONSIVE ── */
@media (max-width: 768px) {
    .db-container { padding: 0 1.25rem; }
    .db-hero { padding: 1.75rem 1.5rem; border-radius: 18px; }
    .db-hero-avatar { width: 60px; height: 60px; font-size: 1.4rem; }
    .db-stat-value { font-size: 1.5rem; }
    .db-card-body { padding: 1rem; }
}
</style>
@endpush

<div class="db-shell">
    <div class="db-container">

        {{-- ═══ HERO ═══ --}}
        <section class="db-hero">
            <div class="db-hero-inner">
                <div class="db-hero-text">
                    <span class="db-hero-eyebrow">Live Dashboard</span>
                    <h1>Halo, <em>{{ explode(' ', Auth::user()->name)[0] }}</em></h1>
                    <p>Pantau performa pengiriman, kelola order, dan lihat aktivitas terbaru — semua dalam satu tempat.</p>
                </div>
                <div class="db-hero-avatar">
                    {{ strtoupper(mb_substr(Auth::user()->name, 0, 1)) }}
                </div>
            </div>
        </section>

        {{-- ═══ STATS ═══ --}}
        <section class="db-stats">
            <div class="db-stat" data-accent="navy">
                <div class="db-stat-head">
                    <div class="db-stat-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                    </div>
                    <span class="db-stat-trend">Total</span>
                </div>
                <p class="db-stat-label">Total Pengiriman</p>
                <div class="db-stat-value">{{ number_format($totalShipments ?? 0) }}</div>
                <div class="db-stat-sub">Sejak akun dibuat</div>
            </div>

            <div class="db-stat" data-accent="red">
                <div class="db-stat-head">
                    <div class="db-stat-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    </div>
                    <span class="db-stat-trend">IDR</span>
                </div>
                <p class="db-stat-label">Total Pengeluaran</p>
                <div class="db-stat-value">Rp {{ number_format($totalSpent ?? 0, 0, ',', '.') }}</div>
                <div class="db-stat-sub">Akumulasi seluruh order</div>
            </div>

            <div class="db-stat" data-accent="green">
                <div class="db-stat-head">
                    <div class="db-stat-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                    <span class="db-stat-trend">Done</span>
                </div>
                <p class="db-stat-label">Terkirim</p>
                <div class="db-stat-value">{{ number_format($deliveredCount) }}</div>
                <div class="db-stat-sub">Paket sukses sampai tujuan</div>
            </div>

            <div class="db-stat" data-accent="amber">
                <div class="db-stat-head">
                    <div class="db-stat-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <span class="db-stat-trend">Avg</span>
                </div>
                <p class="db-stat-label">Rata-rata / Order</p>
                <div class="db-stat-value">Rp {{ number_format($avgSpent, 0, ',', '.') }}</div>
                <div class="db-stat-sub">Nilai per pengiriman</div>
            </div>
        </section>

        {{-- ═══ QUICK ACTIONS ═══ --}}
        <div class="db-actions">
            <a href="{{ route('calculator') }}" class="db-btn db-btn-primary">
                <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Buat Pengiriman
            </a>
            <a href="{{ route('tracking.index') }}" class="db-btn db-btn-secondary">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                Lacak Pengiriman
            </a>
            <a href="{{ route('calculator') }}" class="db-btn db-btn-outline">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="4" y="2" width="16" height="20" rx="2"/><line x1="8" y1="6" x2="16" y2="6"/><line x1="16" y1="14" x2="16" y2="18"/><path d="M8 10h.01M12 10h.01M16 10h.01M8 14h.01M12 14h.01M8 18h.01M12 18h.01"/></svg>
                Cek Tarif
            </a>
            <a href="{{ route('invoices') }}" class="db-btn db-btn-outline">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Invoice Saya
            </a>
        </div>

        {{-- ═══ CHART + STATUS BREAKDOWN ═══ --}}
        <div class="db-grid">
            {{-- Chart --}}
            <div class="db-card">
                <div class="db-card-header">
                    <div class="db-card-header-left">
                        <div class="db-card-header-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
                        </div>
                        <h3>Tren Pengiriman 6 Bulan Terakhir</h3>
                    </div>
                    <span class="db-card-header-meta">Bulanan</span>
                </div>
                <div class="db-card-body">
                    <div class="db-chart-wrap">
                        <canvas id="dbChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- Status Breakdown --}}
            <div class="db-card">
                <div class="db-card-header">
                    <div class="db-card-header-left">
                        <div class="db-card-header-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                        </div>
                        <h3>Status Order</h3>
                    </div>
                </div>
                <div class="db-card-body">
                    <div class="db-status-grid">
                        <div class="db-status-item pending">
                            <div class="db-status-label">Pending</div>
                            <div class="db-status-val">{{ $pendingCount }}</div>
                        </div>
                        <div class="db-status-item processing">
                            <div class="db-status-label">Processing</div>
                            <div class="db-status-val">{{ $processingCount }}</div>
                        </div>
                        <div class="db-status-item delivered">
                            <div class="db-status-label">Delivered</div>
                            <div class="db-status-val">{{ $deliveredCount }}</div>
                        </div>
                        <div class="db-status-item cancelled">
                            <div class="db-status-label">Cancelled</div>
                            <div class="db-status-val">{{ $cancelledCount }}</div>
                        </div>
                    </div>

                    {{-- Top Destinations --}}
                    @if($topCountries->isNotEmpty())
                    <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px dashed #DDE6F5;">
                        <div class="db-card-header-left" style="margin-bottom: 1rem;">
                            <div class="db-card-header-icon">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            </div>
                            <h3 style="font-size: 0.9rem;">Top Negara Tujuan</h3>
                        </div>
                        @php $maxCount = $topCountries->max() ?: 1; @endphp
                        <div class="db-country-list">
                            @foreach($topCountries as $country => $count)
                                <div class="db-country">
                                    <div class="db-country-flag">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                                    </div>
                                    <div class="db-country-info">
                                        <p class="db-country-name">{{ $country }}</p>
                                        <div class="db-country-bar">
                                            <div class="db-country-fill" style="width: {{ ($count / $maxCount) * 100 }}%;"></div>
                                        </div>
                                    </div>
                                    <span class="db-country-count">{{ $count }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ═══ SHIPMENTS TABLE ═══ --}}
        <div class="db-card">
            <div class="db-card-header">
                <div class="db-card-header-left">
                    <div class="db-card-header-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 7h13M10 21a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm7 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/></svg>
                    </div>
                    <h3>Riwayat Pengiriman</h3>
                </div>
                <span class="db-card-header-meta">{{ $shipments->total() }} pengiriman</span>
            </div>
            <div class="db-table-wrap">
                <table class="db-table">
                    <thead>
                        <tr>
                            <th>No. Resi</th>
                            <th>Penerima</th>
                            <th>Negara</th>
                            <th>Layanan</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th style="text-align:right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($shipments as $s)
                            @php $status = strtolower($s->status_pengerjaan ?? 'pending'); @endphp
                            <tr>
                                <td><span class="db-tracking">{{ $s->tracking_number }}</span></td>
                                <td><span class="db-cell-recipient">{{ $s->nama_penerima ?? '-' }}</span></td>
                                <td>{{ $s->negara ?? '-' }}</td>
                                <td>{{ $s->service ?? '-' }}</td>
                                <td><span class="db-cell-price">Rp {{ number_format($s->charge_idr, 0, ',', '.') }}</span></td>
                                <td><span class="db-badge {{ $status }}">{{ ucfirst($s->status_pengerjaan ?? 'Pending') }}</span></td>
                                <td style="color:#7A93B8;">{{ date('d M Y', strtotime($s->created_at)) }}</td>
                                <td style="text-align:right;">
                                    @if($status === 'pending')
                                        <button onclick="deleteShipment({{ $s->id }}, '{{ addslashes($s->tracking_number) }}')" class="db-btn-icon" title="Hapus Pengiriman">
                                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 6h18M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m3 0v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6h14zM10 11v6M14 11v6"/></svg>
                                        </button>
                                    @else
                                        <span class="db-btn-icon disabled" title="Tidak bisa dihapus">
                                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <div class="db-empty">
                                        <div class="db-empty-icon">
                                            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                                        </div>
                                        <h4>Belum ada pengiriman</h4>
                                        <p>Mulai kirim paket pertama Anda sekarang juga.</p>
                                        <a href="{{ route('calculator') }}" class="db-btn db-btn-primary">
                                            <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                            Buat Pengiriman Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($shipments->hasPages())
                <div class="db-table-foot">
                    {{ $shipments->links() }}
                </div>
            @endif
        </div>

    </div>{{-- /container --}}
</div>{{-- /shell --}}

@push('scripts')
<script>
// ── DELETE shipment ──
function deleteShipment(id, trackingNumber) {
    if (!confirm('Hapus pengiriman ' + trackingNumber + '?\n\nTindakan ini tidak dapat dibatalkan.')) return;
    const btn = event.target.closest('button');
    const originalHTML = btn.innerHTML;
    btn.disabled = true;
    fetch('{{ url("/shipment") }}/' + id, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const row = btn.closest('tr');
            row.style.transition = 'opacity 0.3s, transform 0.3s';
            row.style.opacity = '0';
            row.style.transform = 'translateX(-20px)';
            setTimeout(() => row.remove(), 300);
        } else {
            alert('Error: ' + data.message);
            btn.innerHTML = originalHTML;
            btn.disabled = false;
        }
    })
    .catch(() => {
        alert('Terjadi kesalahan.');
        btn.innerHTML = originalHTML;
        btn.disabled = false;
    });
}

// ── CHART ──
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('dbChart');
    if (!ctx || typeof Chart === 'undefined') return;

    const labels = {!! $chartLabels !!};
    const counts = {!! $chartCounts !!};
    const spends = {!! $chartSpends !!};

    const c2d = ctx.getContext('2d');
    const gradRed = c2d.createLinearGradient(0, 0, 0, 280);
    gradRed.addColorStop(0, 'rgba(227,30,36,0.35)');
    gradRed.addColorStop(1, 'rgba(227,30,36,0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Pengiriman',
                    data: counts,
                    borderColor: '#E31E24',
                    backgroundColor: gradRed,
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#E31E24',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    yAxisID: 'y'
                },
                {
                    label: 'Pengeluaran (Rp)',
                    data: spends,
                    borderColor: '#060F2E',
                    backgroundColor: 'rgba(6,15,46,0.05)',
                    borderWidth: 2,
                    borderDash: [6, 4],
                    tension: 0.4,
                    fill: false,
                    pointBackgroundColor: '#060F2E',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: {
                    position: 'top',
                    align: 'end',
                    labels: {
                        boxWidth: 12,
                        boxHeight: 12,
                        font: { family: 'Plus Jakarta Sans', size: 12, weight: '700' },
                        color: '#3D5478',
                        usePointStyle: true,
                        pointStyle: 'circle',
                        padding: 16
                    }
                },
                tooltip: {
                    backgroundColor: '#060F2E',
                    titleColor: '#fff',
                    bodyColor: 'rgba(255,255,255,0.85)',
                    titleFont: { family: 'Plus Jakarta Sans', size: 13, weight: '800' },
                    bodyFont: { family: 'Plus Jakarta Sans', size: 12 },
                    padding: 12,
                    cornerRadius: 10,
                    borderColor: 'rgba(255,255,255,0.1)',
                    borderWidth: 1,
                    displayColors: true,
                    boxPadding: 6,
                    callbacks: {
                        label: function (ctx) {
                            const v = ctx.parsed.y;
                            if (ctx.dataset.yAxisID === 'y1') {
                                return ' ' + ctx.dataset.label + ': Rp ' + v.toLocaleString('id-ID');
                            }
                            return ' ' + ctx.dataset.label + ': ' + v;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: {
                        font: { family: 'Plus Jakarta Sans', size: 11, weight: '600' },
                        color: '#7A93B8'
                    }
                },
                y: {
                    position: 'left',
                    beginAtZero: true,
                    grid: { color: 'rgba(221,230,245,0.6)', drawBorder: false },
                    ticks: {
                        font: { family: 'Plus Jakarta Sans', size: 11, weight: '600' },
                        color: '#7A93B8',
                        precision: 0
                    },
                    title: {
                        display: true,
                        text: 'Jumlah Order',
                        font: { family: 'Plus Jakarta Sans', size: 11, weight: '700' },
                        color: '#3D5478'
                    }
                },
                y1: {
                    position: 'right',
                    beginAtZero: true,
                    grid: { display: false },
                    ticks: {
                        font: { family: 'Plus Jakarta Sans', size: 11, weight: '600' },
                        color: '#7A93B8',
                        callback: function (v) {
                            if (v >= 1000000) return 'Rp ' + (v / 1000000).toFixed(1) + 'jt';
                            if (v >= 1000) return 'Rp ' + (v / 1000).toFixed(0) + 'rb';
                            return 'Rp ' + v;
                        }
                    },
                    title: {
                        display: true,
                        text: 'Pengeluaran',
                        font: { family: 'Plus Jakarta Sans', size: 11, weight: '700' },
                        color: '#3D5478'
                    }
                }
            }
        }
    });
});
</script>
@endpush

@endsection
