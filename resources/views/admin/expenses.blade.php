@extends('layouts.app')

@section('title', 'Atur Pengeluaran - Admin Dashboard')

@section('content')

@push('styles')
<style>
/* ══ EXPENSES — ICE Design System ══ */
@keyframes slideInRight {
    from { opacity: 0; transform: translateX(80px); }
    to   { opacity: 1; transform: translateX(0); }
}
@keyframes modalIn {
    from { opacity: 0; transform: scale(0.96); }
    to   { opacity: 1; transform: scale(1); }
}

/* ── PAGE SHELL ── */
.exp-shell {
    background:
        radial-gradient(900px 500px at 90% -10%, rgba(227,30,36,0.05), transparent 60%),
        radial-gradient(900px 500px at -10% 10%, rgba(6,15,46,0.04), transparent 60%),
        #FAFBFE;
    min-height: calc(100vh - 200px);
    padding: 3rem 0 5rem;
}
.exp-container {
    max-width: 1440px;
    margin: 0 auto;
    padding: 0 2rem;
}

/* ── FLASH NOTIF ── */
#flash-notif {
    position: fixed; top: 2rem; right: 2rem; z-index: 99999;
    background: #060F2E; color: white;
    padding: 1rem 1.5rem; border-radius: 14px;
    box-shadow: 0 20px 50px rgba(6,15,46,0.35);
    font-size: 0.875rem; font-weight: 600;
    display: flex; align-items: center; gap: 1rem; max-width: 400px;
    animation: slideInRight 0.4s cubic-bezier(0.34,1.56,0.64,1);
    border: 1px solid rgba(255,255,255,0.1);
}
#flash-notif .fn-icon {
    width: 40px; height: 40px;
    background: rgba(255,255,255,0.1);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
#flash-notif .fn-icon.success { background: rgba(22,163,74,0.25); }
#flash-notif .fn-icon.error   { background: rgba(227,30,36,0.25); }
#flash-notif .fn-body  { flex: 1; line-height: 1.4; }
#flash-notif .fn-title { font-size: 0.68rem; opacity: 0.7; margin-bottom: 2px; text-transform: uppercase; letter-spacing: 0.05em; }
#flash-notif .fn-close {
    background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);
    color: white; cursor: pointer; width: 30px; height: 30px; border-radius: 7px;
    display: flex; align-items: center; justify-content: center; font-size: 1.1rem; transition: all 0.2s;
}
#flash-notif .fn-close:hover { background: rgba(227,30,36,0.6); }

/* ── HERO ── */
.exp-hero {
    background: linear-gradient(135deg, #060F2E 0%, #0A1A4A 100%);
    border-radius: 24px;
    padding: 2.5rem;
    color: #fff;
    position: relative;
    overflow: hidden;
    margin-bottom: 2rem;
    box-shadow: 0 20px 60px rgba(6,15,46,0.25);
}
.exp-hero::before {
    content: '';
    position: absolute; inset: 0;
    background-image:
        linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
    background-size: 40px 40px;
    pointer-events: none;
}
.exp-hero::after {
    content: '';
    position: absolute; top: -100px; right: -100px;
    width: 360px; height: 360px;
    background: radial-gradient(circle, rgba(227,30,36,0.28) 0%, transparent 70%);
    pointer-events: none;
}
.exp-hero-inner {
    position: relative; z-index: 1;
    display: flex; align-items: center; justify-content: space-between;
    gap: 2rem; flex-wrap: wrap;
}
.exp-hero-text { flex: 1; min-width: 260px; }
.exp-hero-eyebrow {
    display: inline-flex; align-items: center; gap: 0.5rem;
    font-size: 0.7rem; font-weight: 800; text-transform: uppercase;
    letter-spacing: 0.15em; color: rgba(255,255,255,0.6);
    padding: 0.4rem 0.85rem;
    border: 1px solid rgba(255,255,255,0.18); border-radius: 99px;
    background: rgba(255,255,255,0.05); margin-bottom: 1.25rem;
}
.exp-hero-eyebrow::before {
    content: ''; width: 6px; height: 6px; border-radius: 50%;
    background: #E31E24; box-shadow: 0 0 8px rgba(227,30,36,0.7);
}
.exp-hero h1 {
    font-size: clamp(1.75rem, 3.5vw, 2.25rem);
    font-weight: 900; line-height: 1.1;
    margin: 0 0 0.5rem; color: #fff; letter-spacing: -0.02em;
}
.exp-hero p { font-size: 0.95rem; color: rgba(255,255,255,0.6); margin: 0; }
.btn-export {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(255,255,255,0.1); color: white;
    padding: 0.75rem 1.5rem; border-radius: 12px;
    font-weight: 700; font-size: 0.9rem; text-decoration: none;
    border: 1px solid rgba(255,255,255,0.2);
    transition: all 0.2s; flex-shrink: 0;
}
.btn-export:hover { background: rgba(255,255,255,0.18); transform: translateY(-2px); color: white; }
.btn-export svg { width: 16px; height: 16px; }
.btn-add-exp {
    display: inline-flex; align-items: center; gap: 8px;
    background: #E31E24; color: white;
    padding: 0.75rem 1.5rem; border-radius: 12px;
    font-weight: 700; font-size: 0.9rem; text-decoration: none;
    box-shadow: 0 8px 24px rgba(227,30,36,0.35);
    transition: all 0.2s; border: none; cursor: pointer; flex-shrink: 0;
}
.btn-add-exp:hover { background: #C41920; transform: translateY(-2px); box-shadow: 0 12px 32px rgba(227,30,36,0.45); color: white; }
.btn-add-exp svg { width: 16px; height: 16px; }

/* ── STATS ── */
.exp-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1.25rem; margin-bottom: 2rem;
}
.e-stat {
    background: #fff; border: 1px solid #DDE6F5; border-radius: 18px;
    padding: 1.4rem; transition: all 0.3s cubic-bezier(0.22,1,0.36,1);
    position: relative; overflow: hidden;
}
.e-stat:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(9,24,60,0.10); border-color: #C8D6EE; }
.e-stat::before {
    content: ''; position: absolute; top: 0; left: 0;
    width: 100%; height: 3px;
    background: var(--es-accent, #060F2E);
}
.e-stat[data-accent="navy"]  { --es-accent: #060F2E; }
.e-stat[data-accent="red"]   { --es-accent: #E31E24; }
.e-stat[data-accent="amber"] { --es-accent: #f59e0b; }
.e-stat[data-accent="blue"]  { --es-accent: #3b82f6; }
.e-stat[data-accent="purple"]{ --es-accent: #7c3aed; }
.e-stat[data-accent="green"] { --es-accent: #16a34a; }
.e-stat-head {
    display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;
}
.e-stat-icon {
    width: 44px; height: 44px; border-radius: 12px;
    background: color-mix(in srgb, var(--es-accent) 10%, transparent);
    color: var(--es-accent);
    display: inline-flex; align-items: center; justify-content: center;
}
.e-stat-icon svg { width: 22px; height: 22px; }
.e-stat-tag {
    font-size: 0.68rem; font-weight: 800; padding: 0.25rem 0.55rem;
    border-radius: 99px;
    background: color-mix(in srgb, var(--es-accent) 10%, transparent);
    color: var(--es-accent); text-transform: uppercase; letter-spacing: 0.05em;
}
.e-stat-label {
    font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.1em; color: #7A93B8; margin: 0 0 0.4rem;
}
.e-stat-val     { font-size: 1.85rem; font-weight: 900; color: #09183C; line-height: 1; letter-spacing: -0.02em; }
.e-stat-val-sm  { font-size: 1.1rem; font-weight: 900; color: #09183C; line-height: 1.2; letter-spacing: -0.01em; }
.e-stat-sub     { font-size: 0.78rem; color: #3D5478; margin-top: 0.35rem; }

/* ── FILTER CARD ── */
.e-filter-card {
    background: #fff; border: 1px solid #DDE6F5; border-radius: 16px;
    padding: 1.375rem; margin-bottom: 1.5rem;
    box-shadow: 0 2px 8px rgba(9,24,60,0.05);
}
.e-filter-row  { display: flex; flex-wrap: wrap; gap: 1.25rem; align-items: flex-end; }
.e-filter-group { display: flex; flex-direction: column; gap: 0.5rem; }
.e-filter-lbl  {
    font-size: 0.68rem; font-weight: 800; color: #7A93B8;
    text-transform: uppercase; letter-spacing: 0.1em;
}
.e-filter-select, .e-filter-input {
    padding: 9px 14px; border: 1.5px solid #DDE6F5;
    border-radius: 9px; font-size: 0.875rem;
    background: #FAFBFE; color: #09183C;
    font-family: inherit; transition: all 0.2s; outline: none;
    min-width: 160px;
}
.e-filter-select:focus, .e-filter-input:focus {
    border-color: #060F2E; box-shadow: 0 0 0 3px rgba(6,15,46,0.08); background: #fff;
}
.btn-filter {
    padding: 10px 20px; background: #060F2E; color: white;
    border: none; border-radius: 9px; font-weight: 700;
    font-size: 0.875rem; cursor: pointer; transition: all 0.18s;
    font-family: inherit; white-space: nowrap; display: inline-flex; align-items: center; gap: 6px;
}
.btn-filter:hover { background: #0A1A4A; transform: translateY(-1px); }
.btn-filter svg { width: 14px; height: 14px; }
.btn-reset-filter {
    padding: 10px 16px; background: #FAFBFE; color: #3D5478;
    border: 1.5px solid #DDE6F5; border-radius: 9px;
    font-weight: 700; font-size: 0.875rem; cursor: pointer;
    transition: all 0.18s; font-family: inherit; text-decoration: none;
    display: inline-flex; align-items: center; gap: 6px; white-space: nowrap;
}
.btn-reset-filter:hover { border-color: #060F2E; color: #060F2E; }

/* ── CATEGORY TABLE CARD ── */
.e-card {
    background: #fff; border: 1px solid #DDE6F5;
    border-radius: 18px; overflow: hidden; margin-bottom: 1.5rem;
}
.e-card-header {
    padding: 1rem 1.4rem; display: flex; justify-content: space-between; align-items: center;
    border-bottom: 1px solid #DDE6F5; flex-wrap: wrap; gap: 0.5rem;
}
.e-card-header-left { display: flex; align-items: center; gap: 0.75rem; }
.e-card-header-icon {
    width: 34px; height: 34px; border-radius: 9px;
    display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.e-card-header-icon svg { width: 17px; height: 17px; }
.e-card-header h3 { margin: 0; font-size: 0.95rem; font-weight: 800; color: #09183C; letter-spacing: -0.01em; }
.e-card-header-total {
    font-size: 0.875rem; font-weight: 800; color: #09183C;
    background: #F1F5FC; border: 1px solid #DDE6F5;
    padding: 0.3rem 0.85rem; border-radius: 99px;
}

/* Category accent colors */
.e-card[data-cat="operasional"] .e-card-header { background: rgba(245,158,11,0.05); }
.e-card[data-cat="operasional"] .e-card-header-icon { background: rgba(245,158,11,0.12); color: #d97706; }
.e-card[data-cat="gaji"]        .e-card-header { background: rgba(59,130,246,0.05); }
.e-card[data-cat="gaji"]        .e-card-header-icon { background: rgba(59,130,246,0.12); color: #2563eb; }
.e-card[data-cat="marketing"]   .e-card-header { background: rgba(124,58,237,0.05); }
.e-card[data-cat="marketing"]   .e-card-header-icon { background: rgba(124,58,237,0.12); color: #7c3aed; }
.e-card[data-cat="admin"]       .e-card-header { background: rgba(22,163,74,0.05); }
.e-card[data-cat="admin"]       .e-card-header-icon { background: rgba(22,163,74,0.12); color: #16a34a; }
.e-card[data-cat="lainnya"]     .e-card-header { background: rgba(6,15,46,0.03); }
.e-card[data-cat="lainnya"]     .e-card-header-icon { background: rgba(6,15,46,0.07); color: #3D5478; }

/* ── TABLE ── */
.e-table-wrap { overflow-x: auto; }
.e-tbl { width: 100%; border-collapse: collapse; }
.e-tbl thead tr { background: #060F2E; }
.e-tbl th {
    padding: 0.85rem 1rem; font-size: 0.68rem; font-weight: 800;
    color: rgba(255,255,255,0.85); text-align: left;
    letter-spacing: 0.1em; white-space: nowrap;
}
.e-tbl td {
    padding: 0.9rem 1rem; font-size: 0.85rem; color: #3D5478;
    border-bottom: 1px solid #DDE6F5; vertical-align: middle; font-weight: 500;
}
.e-tbl tr:last-child td { border-bottom: none; }
.e-tbl tbody tr { transition: background 0.15s; }
.e-tbl tbody tr:hover td { background: #F1F5FC; }

/* Sub-type badge */
.subtype-badge {
    display: inline-block; padding: 0.25rem 0.65rem;
    border-radius: 7px; font-size: 0.72rem; font-weight: 800;
    border: 1px solid; white-space: nowrap;
}
.subtype-operasional { background: rgba(245,158,11,0.08); color: #b45309; border-color: rgba(245,158,11,0.25); }
.subtype-gaji        { background: rgba(59,130,246,0.08); color: #1d4ed8; border-color: rgba(59,130,246,0.2); }
.subtype-marketing   { background: rgba(124,58,237,0.08); color: #6d28d9; border-color: rgba(124,58,237,0.2); }
.subtype-admin       { background: rgba(22,163,74,0.08);  color: #15803d; border-color: rgba(22,163,74,0.2); }
.subtype-lainnya     { background: rgba(6,15,46,0.06);    color: #3D5478; border-color: rgba(6,15,46,0.12); }

/* Amount cell */
.amount-cell { font-weight: 800; color: #09183C; white-space: nowrap; }

/* Action buttons */
.act-btns { display: flex; gap: 5px; align-items: center; }
.btn-sm {
    padding: 5px 10px; font-size: 0.72rem; font-weight: 700;
    border-radius: 7px; display: inline-flex; align-items: center;
    gap: 4px; line-height: 1; justify-content: center;
    text-decoration: none; transition: all 0.18s; border: none; cursor: pointer;
}
.btn-edit-sm       { background: #060F2E; color: white; }
.btn-edit-sm:hover { background: #0A1A4A; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(6,15,46,0.3); color: white; }
.btn-del-sm        { background: rgba(227,30,36,0.08); color: #E31E24; border: 1px solid rgba(227,30,36,0.2); }
.btn-del-sm:hover  { background: #E31E24; color: white; }
.btn-sm svg { width: 12px; height: 12px; }

/* Empty state */
.e-empty { padding: 3rem 1.5rem; text-align: center; color: #7A93B8; }
.e-empty-icon {
    width: 56px; height: 56px; margin: 0 auto 1rem;
    border-radius: 14px; background: #F1F5FC;
    display: inline-flex; align-items: center; justify-content: center; color: #060F2E;
}
.e-empty-icon svg { width: 24px; height: 24px; }
.e-empty p { margin: 0; font-size: 0.85rem; }

/* ── MODAL ── */
.modal-overlay {
    display: none; position: fixed; inset: 0; z-index: 9999;
    background: rgba(6,15,46,0.6); backdrop-filter: blur(4px);
    justify-content: center; align-items: center; padding: 1rem;
}
.modal-overlay.open { display: flex; }
.modal-box {
    background: #fff; border-radius: 20px;
    width: 100%; max-width: 580px; max-height: 90vh;
    display: flex; flex-direction: column;
    box-shadow: 0 30px 80px -10px rgba(6,15,46,0.4), 0 0 0 1px rgba(255,255,255,0.05);
    border: 1px solid #DDE6F5; overflow: hidden;
    animation: modalIn 0.25s cubic-bezier(0.34,1.2,0.64,1) both;
}
.modal-box > form { flex: 1 1 auto; display: flex; flex-direction: column; min-height: 0; overflow: hidden; }
.modal-hdr {
    display: flex; justify-content: space-between; align-items: center;
    padding: 1.25rem 1.5rem;
    background: #060F2E;
    border-bottom: 1px solid rgba(255,255,255,0.08);
}
.modal-hdr h3 {
    margin: 0; font-size: 1rem; font-weight: 800; color: #fff;
    display: flex; align-items: center; gap: 0.6rem; letter-spacing: -0.01em;
}
.modal-hdr h3 svg { width: 18px; height: 18px; opacity: 0.8; }
.modal-hdr-close {
    width: 32px; height: 32px;
    background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15);
    border-radius: 8px; color: rgba(255,255,255,0.8); cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem; transition: all 0.18s; line-height: 1;
}
.modal-hdr-close:hover { background: #E31E24; border-color: transparent; color: white; }
.modal-body {
    flex: 1 1 auto; overflow-y: auto; min-height: 0;
    padding: 1.375rem 1.5rem;
}
.modal-field { margin-bottom: 1.1rem; }
.modal-field:last-child { margin-bottom: 0; }
.modal-label {
    display: block; font-size: 0.68rem; font-weight: 800;
    color: #7A93B8; text-transform: uppercase;
    letter-spacing: 0.08em; margin-bottom: 0.4rem;
}
.modal-input, .modal-select, .modal-textarea {
    width: 100%; padding: 10px 14px; border-radius: 10px;
    border: 1.5px solid #DDE6F5; font-size: 0.875rem;
    background: #FAFBFE; color: #09183C;
    font-family: inherit; box-sizing: border-box;
    transition: border-color 0.2s, box-shadow 0.2s; outline: none;
}
.modal-input:focus, .modal-select:focus, .modal-textarea:focus {
    border-color: #060F2E; box-shadow: 0 0 0 3px rgba(6,15,46,0.08); background: #fff;
}
.modal-textarea { resize: vertical; min-height: 90px; }
.modal-input-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
.modal-footer {
    padding: 1rem 1.5rem 1.5rem; display: flex; gap: 0.75rem;
    border-top: 1px solid #DDE6F5; background: #FAFBFE;
}
.btn-modal-cancel {
    flex: 1; padding: 11px;
    background: #fff; color: #3D5478;
    border: 1.5px solid #DDE6F5; border-radius: 10px;
    font-weight: 700; font-size: 0.875rem; cursor: pointer;
    font-family: inherit; transition: all 0.18s;
}
.btn-modal-cancel:hover { border-color: #060F2E; color: #060F2E; }
.btn-modal-save {
    flex: 2; padding: 11px;
    background: #060F2E; color: white;
    border: none; border-radius: 10px;
    font-weight: 700; font-size: 0.875rem;
    cursor: pointer; font-family: inherit; transition: all 0.18s;
    display: flex; align-items: center; justify-content: center; gap: 6px;
}
.btn-modal-save:hover { background: #0A1A4A; transform: translateY(-1px); box-shadow: 0 8px 24px rgba(6,15,46,0.3); }
.btn-modal-save svg { width: 15px; height: 15px; }

/* ── RESPONSIVE ── */
@media (max-width: 1200px) { .exp-stats { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 768px) {
    .exp-container { padding: 0 1.25rem; }
    .exp-shell { padding: 1.5rem 0 3rem; }
    .exp-hero { padding: 1.75rem 1.5rem; border-radius: 18px; }
    .exp-stats { grid-template-columns: 1fr 1fr; gap: 1rem; }
    .e-filter-card { padding: 1rem; }
    .e-filter-row { gap: 0.75rem; }
    .modal-input-grid { grid-template-columns: 1fr; }
    .exp-hero-inner { flex-direction: column; align-items: flex-start; }
    .exp-hero-actions { display: flex; gap: 0.75rem; flex-wrap: wrap; }
}
@media (max-width: 480px) { .exp-stats { grid-template-columns: 1fr; } }
</style>
@endpush

<div class="exp-shell">
    <div class="exp-container">

        {{-- FLASH NOTIF --}}
        @if(session('success') || session('error'))
        <div id="flash-notif">
            <div class="fn-icon {{ session('success') ? 'success' : 'error' }}">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    @if(session('success'))
                        <polyline points="20 6 9 17 4 12"/>
                    @else
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    @endif
                </svg>
            </div>
            <div class="fn-body">
                <div class="fn-title">{{ session('success') ? 'Berhasil' : 'Gagal' }}</div>
                {{ session('success') ?? session('error') }}
            </div>
            <button class="fn-close" onclick="this.parentElement.remove()">&times;</button>
        </div>
        <script>setTimeout(() => document.getElementById('flash-notif')?.remove(), 4500);</script>
        @endif

        {{-- HERO --}}
        <section class="exp-hero">
            <div class="exp-hero-inner">
                <div class="exp-hero-text">
                    <span class="exp-hero-eyebrow">Finance</span>
                    <h1>Atur Pengeluaran</h1>
                    <p>Kelola dan pantau semua pengeluaran operasional bisnis.</p>
                </div>
                <div class="exp-hero-actions" style="display:flex;gap:0.75rem;flex-wrap:wrap;">
                    <a href="{{ route('admin.expenses.export', request()->query()) }}" class="btn-export">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                            <polyline points="7 10 12 15 17 10"/>
                            <line x1="12" y1="15" x2="12" y2="3"/>
                        </svg>
                        Export Excel
                    </a>
                    <button type="button" class="btn-add-exp" onclick="openFormModal()">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <line x1="12" y1="5" x2="12" y2="19"/>
                            <line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                        Tambah Pengeluaran
                    </button>
                </div>
            </div>
        </section>

        {{-- STATS --}}
        <section class="exp-stats">
            <div class="e-stat" data-accent="red">
                <div class="e-stat-head">
                    <div class="e-stat-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="1" x2="12" y2="23"/>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                        </svg>
                    </div>
                    <span class="e-stat-tag">Total</span>
                </div>
                <p class="e-stat-label">Total Pengeluaran</p>
                <div class="e-stat-val-sm">{{ rupiah($totalExpenses) }}</div>
                <div class="e-stat-sub">Akumulasi semua kategori</div>
            </div>

            <div class="e-stat" data-accent="navy">
                <div class="e-stat-head">
                    <div class="e-stat-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/>
                            <line x1="8" y1="21" x2="16" y2="21"/>
                            <line x1="12" y1="17" x2="12" y2="21"/>
                        </svg>
                    </div>
                    <span class="e-stat-tag">Jumlah</span>
                </div>
                <p class="e-stat-label">Total Transaksi</p>
                <div class="e-stat-val">{{ $expenses->count() }}</div>
                <div class="e-stat-sub">Entri pengeluaran tercatat</div>
            </div>

            <div class="e-stat" data-accent="amber">
                <div class="e-stat-head">
                    <div class="e-stat-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                        </svg>
                    </div>
                    <span class="e-stat-tag">Avg</span>
                </div>
                <p class="e-stat-label">Rata-rata</p>
                <div class="e-stat-val-sm">{{ rupiah($expenses->count() > 0 ? $totalExpenses / $expenses->count() : 0) }}</div>
                <div class="e-stat-sub">Per transaksi</div>
            </div>

            <div class="e-stat" data-accent="blue">
                <div class="e-stat-head">
                    <div class="e-stat-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                    </div>
                    <span class="e-stat-tag">Filter</span>
                </div>
                <p class="e-stat-label">Periode</p>
                <div class="e-stat-val" style="font-size:1.2rem;">
                    {{ $filterMonth ? date('M', mktime(0,0,0,$filterMonth,1)) : 'Semua' }}
                    {{ $filterYear ?? date('Y') }}
                </div>
                <div class="e-stat-sub">{{ $filterCategory ? ucfirst($filterCategory) : 'Semua kategori' }}</div>
            </div>
        </section>

        {{-- FILTER --}}
        <div class="e-filter-card">
            <form method="GET" action="{{ route('admin.expenses') }}">
                <div class="e-filter-row">
                    <div class="e-filter-group">
                        <span class="e-filter-lbl">Bulan</span>
                        <select name="month" class="e-filter-select">
                            <option value="">Semua Bulan</option>
                            @for($m = 1; $m <= 12; $m++)
                                <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}"
                                    {{ $filterMonth == str_pad($m, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                    {{ date('F', mktime(0,0,0,$m,1)) }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="e-filter-group">
                        <span class="e-filter-lbl">Tahun</span>
                        <select name="year" class="e-filter-select">
                            @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                                <option value="{{ $y }}" {{ $filterYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="e-filter-group">
                        <span class="e-filter-lbl">Kategori</span>
                        <select name="category" class="e-filter-select">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ $filterCategory == $cat ? 'selected' : '' }}>
                                    {{ ucfirst($cat) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="e-filter-group">
                        <span class="e-filter-lbl">Tipe</span>
                        <select name="type" class="e-filter-select">
                            <option value="">Semua Tipe</option>
                            @foreach($types as $key => $label)
                                <option value="{{ $key }}" {{ $filterType == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="e-filter-group" style="justify-content:flex-end;">
                        <span class="e-filter-lbl">&nbsp;</span>
                        <div style="display:flex;gap:0.5rem;">
                            <button type="submit" class="btn-filter">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
                                </svg>
                                Filter
                            </button>
                            <a href="{{ route('admin.expenses') }}" class="btn-reset-filter">Reset</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- CATEGORY TABLES --}}
        @php
            $operasional = $expenses->where('category', 'operasional');
            $gaji        = $expenses->where('category', 'gaji');
            $marketing   = $expenses->where('category', 'marketing');
            $admin       = $expenses->where('category', 'admin');
            $lainnya     = $expenses->where('category', 'lainnya');
        @endphp

        {{-- Biaya Operasional --}}
        <div class="e-card" data-cat="operasional">
            <div class="e-card-header">
                <div class="e-card-header-left">
                    <div class="e-card-header-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/>
                        </svg>
                    </div>
                    <h3>Biaya Operasional</h3>
                </div>
                <span class="e-card-header-total">{{ rupiah($totalPerCategory['operasional'] ?? 0) }}</span>
            </div>
            <div class="e-table-wrap">
                <table class="e-tbl">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th>Deskripsi</th>
                            <th>Tipe</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($operasional as $expense)
                        <tr>
                            <td style="white-space:nowrap;color:#7A93B8;">{{ date('d M Y', strtotime($expense->expense_date)) }}</td>
                            <td>
                                <select style="background:rgba(245,158,11,0.07);color:#b45309;border:1px solid rgba(245,158,11,0.25);padding:4px 10px;border-radius:7px;font-size:0.72rem;font-weight:700;outline:none;cursor:pointer;">
                                    <option>Listrik & Internet</option>
                                    <option>Sewa Kantor</option>
                                    <option>ATK & Stationery</option>
                                    <option>Maintenance</option>
                                    <option>Lainnya</option>
                                </select>
                            </td>
                            <td>{{ $expense->description }}</td>
                            <td><span class="subtype-badge {{ $expense->type == 'fixed' ? 'subtype-gaji' : 'subtype-operasional' }}">{{ $expense->type == 'fixed' ? 'Tetap' : 'Harian' }}</span></td>
                            <td class="amount-cell">{{ rupiah($expense->amount) }}</td>
                            <td>
                                <div class="act-btns">
                                    <a href="{{ route('admin.expenses', ['edit' => $expense->id]) }}" class="btn-sm btn-edit-sm">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    <a href="{{ route('admin.expenses.delete', $expense->id) }}" class="btn-sm btn-del-sm"
                                       onclick="return confirm('Hapus pengeluaran ini?')">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <polyline points="3 6 5 6 21 6"/>
                                            <path d="M19 6l-1 14H6L5 6"/>
                                            <path d="M10 11v6"/><path d="M14 11v6"/>
                                            <path d="M9 6V4h6v2"/>
                                        </svg>
                                        Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">
                                <div class="e-empty">
                                    <div class="e-empty-icon">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/>
                                        </svg>
                                    </div>
                                    <p>Belum ada biaya operasional.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Gaji Karyawan --}}
        <div class="e-card" data-cat="gaji">
            <div class="e-card-header">
                <div class="e-card-header-left">
                    <div class="e-card-header-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                    <h3>Gaji Karyawan</h3>
                </div>
                <span class="e-card-header-total">{{ rupiah($totalPerCategory['gaji'] ?? 0) }}</span>
            </div>
            <div class="e-table-wrap">
                <table class="e-tbl">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Karyawan / Jabatan</th>
                            <th>Deskripsi</th>
                            <th>Tipe</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($gaji as $expense)
                        <tr>
                            <td style="white-space:nowrap;color:#7A93B8;">{{ date('d M Y', strtotime($expense->expense_date)) }}</td>
                            <td>
                                <select style="background:rgba(59,130,246,0.07);color:#1d4ed8;border:1px solid rgba(59,130,246,0.2);padding:4px 10px;border-radius:7px;font-size:0.72rem;font-weight:700;outline:none;cursor:pointer;">
                                    <option>Manager</option>
                                    <option>Staff Admin</option>
                                    <option>Staff Operasional</option>
                                    <option>Marketing</option>
                                    <option>Driver / Kurir</option>
                                    <option>Freelance</option>
                                </select>
                            </td>
                            <td>{{ $expense->description }}</td>
                            <td><span class="subtype-badge {{ $expense->type == 'fixed' ? 'subtype-gaji' : 'subtype-operasional' }}">{{ $expense->type == 'fixed' ? 'Tetap' : 'Harian' }}</span></td>
                            <td class="amount-cell">{{ rupiah($expense->amount) }}</td>
                            <td>
                                <div class="act-btns">
                                    <a href="{{ route('admin.expenses', ['edit' => $expense->id]) }}" class="btn-sm btn-edit-sm">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    <a href="{{ route('admin.expenses.delete', $expense->id) }}" class="btn-sm btn-del-sm"
                                       onclick="return confirm('Hapus data gaji ini?')">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <polyline points="3 6 5 6 21 6"/>
                                            <path d="M19 6l-1 14H6L5 6"/>
                                            <path d="M10 11v6"/><path d="M14 11v6"/>
                                            <path d="M9 6V4h6v2"/>
                                        </svg>
                                        Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">
                                <div class="e-empty">
                                    <div class="e-empty-icon">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                                        </svg>
                                    </div>
                                    <p>Belum ada data gaji.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Biaya Marketing --}}
        <div class="e-card" data-cat="marketing">
            <div class="e-card-header">
                <div class="e-card-header-left">
                    <div class="e-card-header-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                        </svg>
                    </div>
                    <h3>Biaya Marketing</h3>
                </div>
                <span class="e-card-header-total">{{ rupiah($totalPerCategory['marketing'] ?? 0) }}</span>
            </div>
            <div class="e-table-wrap">
                <table class="e-tbl">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jenis Marketing</th>
                            <th>Deskripsi</th>
                            <th>Tipe</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($marketing as $expense)
                        <tr>
                            <td style="white-space:nowrap;color:#7A93B8;">{{ date('d M Y', strtotime($expense->expense_date)) }}</td>
                            <td>
                                <select style="background:rgba(124,58,237,0.07);color:#6d28d9;border:1px solid rgba(124,58,237,0.2);padding:4px 10px;border-radius:7px;font-size:0.72rem;font-weight:700;outline:none;cursor:pointer;">
                                    <option>Iklan Online</option>
                                    <option>Google Ads</option>
                                    <option>Social Media Ads</option>
                                    <option>Event / Promo</option>
                                    <option>Brosur / Flyer</option>
                                    <option>Giveaway</option>
                                </select>
                            </td>
                            <td>{{ $expense->description }}</td>
                            <td><span class="subtype-badge {{ $expense->type == 'fixed' ? 'subtype-gaji' : 'subtype-operasional' }}">{{ $expense->type == 'fixed' ? 'Tetap' : 'Harian' }}</span></td>
                            <td class="amount-cell">{{ rupiah($expense->amount) }}</td>
                            <td>
                                <div class="act-btns">
                                    <a href="{{ route('admin.expenses', ['edit' => $expense->id]) }}" class="btn-sm btn-edit-sm">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    <a href="{{ route('admin.expenses.delete', $expense->id) }}" class="btn-sm btn-del-sm"
                                       onclick="return confirm('Hapus biaya marketing ini?')">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <polyline points="3 6 5 6 21 6"/>
                                            <path d="M19 6l-1 14H6L5 6"/>
                                            <path d="M10 11v6"/><path d="M14 11v6"/>
                                            <path d="M9 6V4h6v2"/>
                                        </svg>
                                        Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">
                                <div class="e-empty">
                                    <div class="e-empty-icon">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                                        </svg>
                                    </div>
                                    <p>Belum ada biaya marketing.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Biaya Admin --}}
        <div class="e-card" data-cat="admin">
            <div class="e-card-header">
                <div class="e-card-header-left">
                    <div class="e-card-header-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
                            <polyline points="10 9 9 9 8 9"/>
                        </svg>
                    </div>
                    <h3>Biaya Admin</h3>
                </div>
                <span class="e-card-header-total">{{ rupiah($totalPerCategory['admin'] ?? 0) }}</span>
            </div>
            <div class="e-table-wrap">
                <table class="e-tbl">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jenis Admin</th>
                            <th>Deskripsi</th>
                            <th>Tipe</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admin as $expense)
                        <tr>
                            <td style="white-space:nowrap;color:#7A93B8;">{{ date('d M Y', strtotime($expense->expense_date)) }}</td>
                            <td>
                                <select style="background:rgba(22,163,74,0.07);color:#15803d;border:1px solid rgba(22,163,74,0.2);padding:4px 10px;border-radius:7px;font-size:0.72rem;font-weight:700;outline:none;cursor:pointer;">
                                    <option>Bank Admin</option>
                                    <option>Notaris / Legal</option>
                                    <option>Akuntan</option>
                                    <option>Pos & Pengiriman</option>
                                    <option>Telepon / Internet</option>
                                    <option>Software / License</option>
                                </select>
                            </td>
                            <td>{{ $expense->description }}</td>
                            <td><span class="subtype-badge {{ $expense->type == 'fixed' ? 'subtype-gaji' : 'subtype-operasional' }}">{{ $expense->type == 'fixed' ? 'Tetap' : 'Harian' }}</span></td>
                            <td class="amount-cell">{{ rupiah($expense->amount) }}</td>
                            <td>
                                <div class="act-btns">
                                    <a href="{{ route('admin.expenses', ['edit' => $expense->id]) }}" class="btn-sm btn-edit-sm">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    <a href="{{ route('admin.expenses.delete', $expense->id) }}" class="btn-sm btn-del-sm"
                                       onclick="return confirm('Hapus biaya admin ini?')">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <polyline points="3 6 5 6 21 6"/>
                                            <path d="M19 6l-1 14H6L5 6"/>
                                            <path d="M10 11v6"/><path d="M14 11v6"/>
                                            <path d="M9 6V4h6v2"/>
                                        </svg>
                                        Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">
                                <div class="e-empty">
                                    <div class="e-empty-icon">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                        </svg>
                                    </div>
                                    <p>Belum ada biaya admin.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pengeluaran Lainnya --}}
        <div class="e-card" data-cat="lainnya">
            <div class="e-card-header">
                <div class="e-card-header-left">
                    <div class="e-card-header-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="8" x2="12" y2="12"/>
                            <line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                    </div>
                    <h3>Pengeluaran Lainnya</h3>
                </div>
                <span class="e-card-header-total">{{ rupiah($totalPerCategory['lainnya'] ?? 0) }}</span>
            </div>
            <div class="e-table-wrap">
                <table class="e-tbl">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Kategori</th>
                            <th>Deskripsi</th>
                            <th>Tipe</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lainnya as $expense)
                        <tr>
                            <td style="white-space:nowrap;color:#7A93B8;">{{ date('d M Y', strtotime($expense->expense_date)) }}</td>
                            <td>
                                <select style="background:rgba(6,15,46,0.05);color:#3D5478;border:1px solid rgba(6,15,46,0.12);padding:4px 10px;border-radius:7px;font-size:0.72rem;font-weight:700;outline:none;cursor:pointer;">
                                    <option>Makan / Katering</option>
                                    <option>Transportasi</option>
                                    <option>Renovasi</option>
                                    <option>IT Equipment</option>
                                    <option>Hadiah / Bonus</option>
                                    <option>Darurat / Contingency</option>
                                </select>
                            </td>
                            <td>{{ $expense->description }}</td>
                            <td><span class="subtype-badge {{ $expense->type == 'fixed' ? 'subtype-gaji' : 'subtype-operasional' }}">{{ $expense->type == 'fixed' ? 'Tetap' : 'Harian' }}</span></td>
                            <td class="amount-cell">{{ rupiah($expense->amount) }}</td>
                            <td>
                                <div class="act-btns">
                                    <a href="{{ route('admin.expenses', ['edit' => $expense->id]) }}" class="btn-sm btn-edit-sm">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    <a href="{{ route('admin.expenses.delete', $expense->id) }}" class="btn-sm btn-del-sm"
                                       onclick="return confirm('Hapus pengeluaran ini?')">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <polyline points="3 6 5 6 21 6"/>
                                            <path d="M19 6l-1 14H6L5 6"/>
                                            <path d="M10 11v6"/><path d="M14 11v6"/>
                                            <path d="M9 6V4h6v2"/>
                                        </svg>
                                        Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">
                                <div class="e-empty">
                                    <div class="e-empty-icon">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <circle cx="12" cy="12" r="10"/>
                                            <line x1="12" y1="8" x2="12" y2="12"/>
                                        </svg>
                                    </div>
                                    <p>Belum ada pengeluaran lainnya.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>{{-- /container --}}
</div>{{-- /shell --}}

{{-- MODAL --}}
<div id="expenseModal" class="modal-overlay {{ $editExpense ? 'open' : '' }}" onclick="handleOverlayClick(event, 'expenseModal')">
    <div class="modal-box">
        <div class="modal-hdr">
            <h3>
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <line x1="12" y1="1" x2="12" y2="23"/>
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                </svg>
                {{ $editExpense ? 'Edit Pengeluaran' : 'Tambah Pengeluaran Baru' }}
            </h3>
            <button class="modal-hdr-close" onclick="closeExpenseModal()">&times;</button>
        </div>
        <form method="POST" action="{{ route('admin.expenses.save') }}">
            @csrf
            <input type="hidden" name="edit_id" value="{{ $editExpense ? $editExpense->id : 0 }}">
            <div class="modal-body">
                <div class="modal-input-grid">
                    <div class="modal-field">
                        <label class="modal-label">Kategori</label>
                        <select name="category" class="modal-select" required>
                            <option value="">Pilih Kategori</option>
                            <option value="gaji"        {{ $editExpense && $editExpense->category == 'gaji'        ? 'selected' : '' }}>Gaji Karyawan</option>
                            <option value="operasional" {{ $editExpense && $editExpense->category == 'operasional' ? 'selected' : '' }}>Biaya Operasional</option>
                            <option value="marketing"   {{ $editExpense && $editExpense->category == 'marketing'   ? 'selected' : '' }}>Marketing</option>
                            <option value="admin"       {{ $editExpense && $editExpense->category == 'admin'       ? 'selected' : '' }}>Biaya Admin</option>
                            <option value="lainnya"     {{ $editExpense && $editExpense->category == 'lainnya'     ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>
                    <div class="modal-field">
                        <label class="modal-label">Tanggal</label>
                        <input type="date" name="expense_date" class="modal-input" required
                               value="{{ $editExpense ? $editExpense->expense_date : date('Y-m-d') }}">
                    </div>
                </div>
                <div class="modal-field">
                    <label class="modal-label">Tipe Pengeluaran</label>
                    <select name="type" class="modal-select" required>
                        <option value="daily" {{ $editExpense && $editExpense->type == 'daily' ? 'selected' : '' }}>Harian</option>
                        <option value="fixed" {{ $editExpense && $editExpense->type == 'fixed' ? 'selected' : '' }}>Tetap (Bulanan)</option>
                    </select>
                </div>
                <div class="modal-field">
                    <label class="modal-label">Jumlah (Rp)</label>
                    <input type="number" name="amount" class="modal-input" placeholder="0" step="0.01" required
                           value="{{ $editExpense ? $editExpense->amount : '' }}">
                </div>
                <div class="modal-field">
                    <label class="modal-label">Deskripsi</label>
                    <textarea name="description" class="modal-textarea" placeholder="Deskripsi pengeluaran..." required>{{ $editExpense ? $editExpense->description : '' }}</textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" onclick="closeExpenseModal()">Batal</button>
                <button type="submit" name="save_expense" class="btn-modal-save">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/>
                        <polyline points="7 3 7 8 15 8"/>
                    </svg>
                    {{ $editExpense ? 'Update Pengeluaran' : 'Simpan Pengeluaran' }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openFormModal() {
    document.getElementById('expenseModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeExpenseModal() {
    document.getElementById('expenseModal').classList.remove('open');
    document.body.style.overflow = '';
}
function handleOverlayClick(e, id) {
    if (e.target === document.getElementById(id)) closeExpenseModal();
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeExpenseModal(); });
</script>

@endsection