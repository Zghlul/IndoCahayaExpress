@extends('layouts.app')
@section('title', 'Kelola Invoice - Admin Dashboard')
@section('content')
@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300&family=DM+Serif+Display:ital@0;1&display=swap');

/* ══ ICE Design System — Invoices ══ */
:root {
  --red:          #E31E24;
  --red-hover:    #C7181D;
  --red-deep:     #A0121A;
  --navy-900:     #060F2E;
  --navy-800:     #0A1A4A;
  --navy-700:     #0D2260;
  --navy-600:     #102B78;
  --white:        #FFFFFF;
  --surface:      #FAFBFE;
  --surface-2:    #F1F5FC;
  --surface-3:    #E8EFF9;
  --border:       #DDE6F5;
  --border-2:     #C8D6EE;
  --text-primary: #09183C;
  --text-2:       #3D5478;
  --text-muted:   #7A93B8;
  --text-faint:   #AAB9D0;
  --green:        #16A34A;
  --amber:        #D97706;
  --shadow-xs:    0 1px 4px rgba(9,24,60,0.06);
  --shadow-sm:    0 2px 8px rgba(9,24,60,0.08);
  --shadow-md:    0 8px 24px rgba(9,24,60,0.10);
  --shadow-lg:    0 16px 48px rgba(9,24,60,0.12);
  --ease-out:     cubic-bezier(0.22, 1, 0.36, 1);
  --ease-spring:  cubic-bezier(0.34, 1.56, 0.64, 1);
}

/* ── KEYFRAMES ── */
@keyframes slideInRight {
  from { opacity: 0; transform: translateX(80px); }
  to   { opacity: 1; transform: translateX(0); }
}
@keyframes modalIn {
  from { opacity: 0; transform: scale(0.96); }
  to   { opacity: 1; transform: scale(1); }
}

/* ── SCROLL REVEAL (from animations.css) ── */
.reveal, .reveal-left, .reveal-right {
  opacity: 0;
  transition: opacity 0.65s cubic-bezier(0.4,0,0.2,1), transform 0.65s cubic-bezier(0.4,0,0.2,1);
}
.reveal       { transform: translateY(28px); }
.reveal-left  { transform: translateX(-28px); }
.reveal-right { transform: translateX(28px); }
.reveal.is-visible, .reveal-left.is-visible, .reveal-right.is-visible {
  opacity: 1; transform: translate(0);
}
.reveal-d1 { transition-delay: 0.10s; }
.reveal-d2 { transition-delay: 0.20s; }
.reveal-d3 { transition-delay: 0.30s; }
.reveal-d4 { transition-delay: 0.40s; }

/* ── PAGE SHELL ── */
.ki-shell {
  font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
  background: var(--surface);
  min-height: calc(100vh - 200px);
  padding: 3rem 0 5rem;
}
.ki-container {
  max-width: 1440px;
  margin: 0 auto;   
  padding: 0 2rem;
}

/* ── FLASH NOTIF ── */
#flash-notif {
  position: fixed; top: 2rem; right: 2rem; z-index: 99999;
  background: var(--navy-900); color: white;
  padding: 1rem 1.5rem; border-radius: 14px;
  box-shadow: 0 20px 50px rgba(6,15,46,0.35);
  font-size: 0.875rem; font-weight: 600;
  display: flex; align-items: center; gap: 1rem; max-width: 400px;
  animation: slideInRight 0.4s var(--ease-spring);
  border: 1px solid rgba(255,255,255,0.1);
}
#flash-notif .fn-icon {
  width: 40px; height: 40px;
  background: rgba(255,255,255,0.1); border-radius: 10px;
  display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
#flash-notif .fn-body  { flex: 1; line-height: 1.4; }
#flash-notif .fn-title { font-size: 0.68rem; opacity: 0.7; margin-bottom: 2px; text-transform: uppercase; letter-spacing: 0.05em; }
#flash-notif .fn-close {
  background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);
  color: white; cursor: pointer; width: 30px; height: 30px; border-radius: 7px;
  display: flex; align-items: center; justify-content: center; font-size: 1.1rem; transition: all 0.2s;
}
#flash-notif .fn-close:hover { background: rgba(227,30,36,0.6); }

/* ── HERO (full canvas/grid/glow layers — identical to home.blade.php) ── */
.ki-hero {
  position: relative;
  overflow: hidden;
  border-radius: 24px;
  margin-bottom: 2rem;
  box-shadow: 0 20px 60px rgba(6,15,46,0.30);
  min-height: 190px;
  display: flex;
  align-items: center;
}
.ki-hero-canvas {
  position: absolute; inset: 0; z-index: 0;
  background:
    radial-gradient(ellipse 100% 80% at 100% 0%,  rgba(20,56,160,0.55) 0%, transparent 55%),
    radial-gradient(ellipse 70%  60% at 0%  100%, rgba(227,30,36,0.10) 0%, transparent 50%),
    radial-gradient(ellipse 60%  70% at 55% 50%,  rgba(11,26,74,0.9)   0%, transparent 70%),
    linear-gradient(168deg, var(--navy-900) 0%, #0B1C55 45%, #091640 100%);
}
.ki-hero-canvas::after {
  content: '';
  position: absolute; inset: 0;
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.035'/%3E%3C/svg%3E");
  pointer-events: none; mix-blend-mode: overlay; opacity: 0.5;
}
.ki-hero-grid {
  position: absolute; inset: 0; z-index: 0;
  background-image: radial-gradient(circle, rgba(255,255,255,0.055) 1px, transparent 1px);
  background-size: 44px 44px;
  mask-image: radial-gradient(ellipse 90% 80% at 50% 50%, black 40%, transparent 80%);
}
.ki-hero-lines {
  position: absolute; inset: 0; z-index: 0; overflow: hidden;
}
.ki-hero-lines::before,
.ki-hero-lines::after {
  content: ''; position: absolute; top: 0; bottom: 0; width: 1px;
}
.ki-hero-lines::before {
  right: 34%;
  background: linear-gradient(to bottom, transparent 0%, rgba(227,30,36,0.35) 25%, rgba(227,30,36,0.15) 70%, transparent 100%);
}
.ki-hero-lines::after {
  left: 52%;
  background: linear-gradient(to bottom, transparent 10%, rgba(59,174,224,0.12) 40%, rgba(59,174,224,0.06) 75%, transparent 100%);
}
.ki-hero-glow {
  position: absolute; z-index: 0; border-radius: 50%; filter: blur(80px); pointer-events: none;
}
.ki-hero-glow-1 {
  width: 600px; height: 600px; top: -200px; right: -80px;
  background: radial-gradient(circle, rgba(20,56,160,0.4) 0%, transparent 65%);
}
.ki-hero-glow-2 {
  width: 350px; height: 350px; bottom: -100px; left: 0;
  background: radial-gradient(circle, rgba(227,30,36,0.12) 0%, transparent 65%);
}
.ki-hero-inner {
  position: relative; z-index: 2;
  width: 100%;
  padding: 2.5rem;
  display: flex; align-items: center; justify-content: space-between;
  gap: 2rem; flex-wrap: wrap;
}
.ki-hero-text { flex: 1; min-width: 260px; }

/* Hero eyebrow — dot badge style (same as home.blade.php) */
.ki-hero-eyebrow {
  display: inline-flex; align-items: center; gap: 0.6rem;
  margin-bottom: 1.1rem;
  padding: 0.4rem 1rem 0.4rem 0.55rem;
  border-radius: 99px;
  border: 1px solid rgba(227,30,36,0.3);
  background: rgba(227,30,36,0.07);
  backdrop-filter: blur(10px);
}
.ki-hero-eyebrow-dot {
  width: 22px; height: 22px; border-radius: 50%;
  background: linear-gradient(135deg, var(--red), var(--red-deep));
  display: flex; align-items: center; justify-content: center; flex-shrink: 0;
  box-shadow: 0 4px 12px rgba(227,30,36,0.4);
}
.ki-hero-eyebrow-dot svg { width: 11px; height: 11px; color: #fff; }
.ki-hero-eyebrow span {
  font-size: 0.68rem; font-weight: 800; letter-spacing: 0.12em;
  text-transform: uppercase; color: rgba(255,255,255,0.75);
  padding-right: 0.3rem;
}
.ki-hero h1 {
  font-size: clamp(1.75rem, 3.5vw, 2.4rem);
  font-weight: 900; line-height: 1.05;
  margin: 0 0 0.5rem; color: #fff; letter-spacing: -0.03em;
}
.ki-hero p {
  font-size: 0.95rem; color: rgba(255,255,255,0.55); margin: 0;
  font-weight: 400; line-height: 1.6;
}

/* btn-new-inv — matches btn-hero-primary from home.blade.php */
.btn-new-inv {
  display: inline-flex; align-items: center; gap: 0.55rem;
  padding: 1rem 2rem;
  background: var(--red); color: #fff;
  border-radius: 10px;
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-weight: 700; font-size: 0.92rem; letter-spacing: 0.01em;
  text-decoration: none; border: none; cursor: pointer; flex-shrink: 0;
  box-shadow: 0 8px 28px rgba(227,30,36,0.4), inset 0 1px 0 rgba(255,255,255,0.12);
  transition: all 0.25s var(--ease-out);
  white-space: nowrap;
}
.btn-new-inv svg { width: 16px; height: 16px; flex-shrink: 0; }
.btn-new-inv:hover {
  background: var(--red-hover); transform: translateY(-2px);
  box-shadow: 0 14px 36px rgba(227,30,36,0.5); color: white;
}
.btn-new-inv:active { transform: translateY(0); }

/* ── STATS ── */
.ki-stats {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 1.25rem; margin-bottom: 2rem;
}
.ki-stat {
  background: var(--white); border: 1px solid var(--border); border-radius: 18px;
  padding: 1.4rem; transition: all 0.3s var(--ease-out);
  position: relative; overflow: hidden;
}
.ki-stat:hover { transform: translateY(-4px); box-shadow: var(--shadow-lg); border-color: var(--border-2); }
.ki-stat::before {
  content: ''; position: absolute; top: 0; left: 0;
  width: 100%; height: 3px;
  background: var(--ks-accent, var(--navy-900));
}
.ki-stat[data-accent="navy"]  { --ks-accent: var(--navy-900); }
.ki-stat[data-accent="amber"] { --ks-accent: var(--amber); }
.ki-stat[data-accent="green"] { --ks-accent: var(--green); }
.ki-stat[data-accent="red"]   { --ks-accent: var(--red); }
.ki-stat-head {
  display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;
}
.ki-stat-icon {
  width: 44px; height: 44px; border-radius: 12px;
  background: color-mix(in srgb, var(--ks-accent) 10%, transparent);
  color: var(--ks-accent);
  display: inline-flex; align-items: center; justify-content: center;
}
.ki-stat-icon svg { width: 22px; height: 22px; }
.ki-stat-tag {
  font-size: 0.68rem; font-weight: 800; padding: 0.25rem 0.55rem;
  border-radius: 99px;
  background: color-mix(in srgb, var(--ks-accent) 10%, transparent);
  color: var(--ks-accent); text-transform: uppercase; letter-spacing: 0.05em;
}
.ki-stat-label {
  font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
  letter-spacing: 0.1em; color: var(--text-muted); margin: 0 0 0.4rem;
}
.ki-stat-val    { font-size: 1.85rem; font-weight: 900; color: var(--text-primary); line-height: 1; letter-spacing: -0.02em; }
.ki-stat-val.amber { color: var(--amber); }
.ki-stat-val.green { color: var(--green); }
.ki-stat-val-sm { font-size: 1.2rem; font-weight: 900; color: var(--text-primary); line-height: 1.2; letter-spacing: -0.01em; }
.ki-stat-sub    { font-size: 0.78rem; color: var(--text-2); margin-top: 0.35rem; }

/* ── FILTER CARD ── */
.ki-filter-card {
  background: var(--white); border: 1px solid var(--border); border-radius: 18px;
  padding: 1rem 1.375rem; margin-bottom: 1.375rem;
  display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;
  box-shadow: var(--shadow-xs);
}
.ki-filter-tabs { display: flex; gap: 6px; flex-wrap: wrap; flex-shrink: 0; }
.ki-filter-tab {
  padding: 7px 18px; border-radius: 8px;
  border: 1.5px solid var(--border); font-size: 0.8rem; font-weight: 700;
  color: var(--text-muted); text-decoration: none; background: var(--surface);
  transition: all 0.18s; display: inline-block; white-space: nowrap;
}
.ki-filter-tab:hover { border-color: var(--navy-900); color: var(--navy-900); background: var(--surface-2); }
.ki-ft-all    { background: var(--navy-900) !important; color: #fff !important; border-color: var(--navy-900) !important; }
.ki-ft-unpaid { background: var(--amber) !important;   color: #fff !important; border-color: var(--amber) !important; }
.ki-ft-paid   { background: var(--green) !important;   color: #fff !important; border-color: var(--green) !important; }

.ki-search-form { display: flex; gap: 8px; align-items: center; flex: 1; min-width: 0; flex-wrap: nowrap; }
.ki-search-wrap { position: relative; flex: 1; min-width: 0; }
.ki-search-wrap svg { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); width: 15px; height: 15px; pointer-events: none; }
.ki-search-wrap input {
  width: 100%; padding: 9px 14px 9px 38px;
  border: 1.5px solid var(--border); border-radius: 9px;
  font-size: 0.875rem; background: var(--surface); color: var(--text-primary);
  font-family: inherit; transition: all 0.2s; box-sizing: border-box;
}
.ki-search-wrap input:focus { border-color: var(--navy-900); box-shadow: 0 0 0 3px rgba(6,15,46,0.08); outline: none; background: var(--white); }
.ki-search-wrap input::placeholder { color: var(--text-muted); }
.ki-btn-search {
  padding: 9px 18px; background: var(--navy-900); color: white;
  border: none; border-radius: 9px; font-weight: 700;
  font-size: 0.875rem; cursor: pointer; transition: all 0.18s;
  font-family: inherit; white-space: nowrap; flex-shrink: 0;
}
.ki-btn-search:hover { background: var(--navy-800); transform: translateY(-1px); }
.ki-btn-reset {
  padding: 9px 14px; background: var(--surface); color: var(--text-2);
  border: 1.5px solid var(--border); border-radius: 9px; font-weight: 700;
  font-size: 0.875rem; cursor: pointer; font-family: inherit;
  text-decoration: none; display: inline-flex; align-items: center;
  white-space: nowrap; flex-shrink: 0; transition: all 0.18s;
}
.ki-btn-reset:hover { border-color: var(--navy-900); color: var(--navy-900); }
.ki-filter-count {
  margin-left: auto; font-size: 0.78rem; color: var(--text-muted); font-weight: 700;
  white-space: nowrap; flex-shrink: 0;
  background: var(--surface-2); padding: 0.3rem 0.65rem;
  border-radius: 99px; border: 1px solid var(--border);
}

/* ── TABLE CARD ── */
.ki-card {
  background: var(--white); border: 1px solid var(--border);
  border-radius: 18px; overflow: hidden; margin-bottom: 1.5rem;
}
.ki-card-header {
  padding: 1.1rem 1.4rem; display: flex; justify-content: space-between; align-items: center;
  border-bottom: 1px solid var(--border); background: var(--surface);
}
.ki-card-header-left { display: flex; align-items: center; gap: 0.6rem; }
.ki-card-header-icon {
  width: 32px; height: 32px; border-radius: 9px;
  background: rgba(6,15,46,0.06); color: var(--navy-900);
  display: inline-flex; align-items: center; justify-content: center;
}
.ki-card-header-icon svg { width: 16px; height: 16px; }
.ki-card-header h3 { margin: 0; font-size: 1rem; font-weight: 800; color: var(--text-primary); letter-spacing: -0.01em; }
.ki-card-header-meta { font-size: 0.78rem; color: var(--text-muted); font-weight: 600; }

/* ── TABLE ── */
.ki-table-wrap { overflow-x: auto; }
.ki-tbl { width: 100%; border-collapse: collapse; }
.ki-tbl thead tr { background: var(--navy-900); }
.ki-tbl th {
  padding: 0.85rem 1rem; font-size: 0.68rem; font-weight: 800;
  color: rgba(255,255,255,0.85); text-align: left;
  letter-spacing: 0.1em; white-space: nowrap;
  border-bottom: 1px solid var(--border);
}
.ki-tbl th.right { text-align: right; }
.ki-tbl td {
  padding: 0.95rem 1rem; font-size: 0.85rem; color: var(--text-2);
  border-bottom: 1px solid var(--border); vertical-align: middle; font-weight: 500;
}
.ki-tbl tr:last-child td { border-bottom: none; }
.ki-tbl tbody tr { transition: background 0.15s; }
.ki-tbl tbody tr:hover td { background: var(--surface-2); }

/* Badges */
.ki-num-badge {
  font-family: 'JetBrains Mono', 'SF Mono', 'Courier New', monospace;
  font-size: 0.78rem; font-weight: 700;
  background: rgba(6,15,46,0.06); color: var(--navy-900);
  padding: 0.3rem 0.6rem; border-radius: 7px;
  border: 1px solid var(--border); white-space: nowrap; display: inline-block;
}
.ki-pkg-badge {
  display: inline-flex; align-items: center; gap: 4px;
  background: var(--surface-2); color: var(--text-2);
  padding: 0.25rem 0.6rem; border-radius: 7px;
  font-size: 0.75rem; font-weight: 700; border: 1px solid var(--border);
}
.ki-badge {
  display: inline-flex; align-items: center; gap: 0.35rem;
  padding: 0.3rem 0.7rem; border-radius: 99px; font-size: 0.7rem;
  font-weight: 800; text-transform: uppercase; letter-spacing: 0.04em;
  white-space: nowrap; border: 1px solid;
}
.ki-badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
.ki-badge.paid   { background: rgba(22,163,74,0.08);  color: #15803d; border-color: rgba(22,163,74,0.2); }
.ki-badge.unpaid { background: rgba(217,119,6,0.1);   color: #b45309; border-color: rgba(217,119,6,0.2); }
.ki-price-bold { font-weight: 800; color: var(--text-primary); }
.ki-ddp-val    { font-weight: 700; color: #b45309; }

/* ── ACTION BUTTONS ── */
.ki-act-btns { display: flex; gap: 5px; align-items: center; flex-wrap: wrap; }
.ki-btn {
  padding: 5px 11px; border-radius: 7px; font-size: 0.72rem; font-weight: 700;
  border: none; cursor: pointer; transition: all 0.18s;
  display: inline-flex; align-items: center; justify-content: center;
  gap: 4px; text-decoration: none; white-space: nowrap;
  line-height: 1; height: 30px; box-sizing: border-box;
}
.ki-btn:hover { transform: translateY(-1px); }
.ki-btn-edit      { background: var(--navy-900); color: white; }
.ki-btn-edit:hover { background: var(--navy-800); box-shadow: 0 4px 12px rgba(6,15,46,0.3); color: white; }
.ki-btn-paid      { background: rgba(22,163,74,0.1); color: #15803d; border: 1px solid rgba(22,163,74,0.25) !important; }
.ki-btn-paid:hover { background: #16a34a; color: white; }
.ki-btn-del       { background: rgba(220,38,38,0.08); color: #b91c1c; border: 1px solid rgba(220,38,38,0.2) !important; }
.ki-btn-del:hover { background: #dc2626; color: white; }

/* Empty state */
.ki-empty { padding: 3.5rem 1.5rem; text-align: center; color: var(--text-muted); }
.ki-empty-icon {
  width: 64px; height: 64px; margin: 0 auto 1rem;
  border-radius: 16px; background: var(--surface-2);
  display: inline-flex; align-items: center; justify-content: center; color: var(--navy-900);
}
.ki-empty-icon svg { width: 28px; height: 28px; }
.ki-empty h4 { font-size: 1rem; font-weight: 800; color: var(--text-primary); margin: 0 0 0.4rem; }
.ki-empty p  { margin: 0; font-size: 0.85rem; }

/* ── PAGINATION ── */
.ki-pagination {
  display: flex; justify-content: center; gap: 0.35rem;
  padding: 1rem 1.4rem; border-top: 1px solid var(--border);
  background: var(--surface); flex-wrap: wrap;
  border-radius: 0 0 18px 18px;
}
.pg {
  display: inline-flex; align-items: center; justify-content: center;
  min-width: 34px; height: 34px; padding: 0 0.65rem;
  border-radius: 8px; font-size: 0.82rem; font-weight: 700;
  color: var(--text-2); background: var(--white); border: 1px solid var(--border);
  text-decoration: none; transition: all 0.15s;
}
.pg:hover  { border-color: var(--navy-900); color: var(--navy-900); }
.pg.active { background: var(--navy-900); color: #fff; border-color: var(--navy-900); }
.pg.dots   { cursor: default; border-color: transparent; background: transparent; color: var(--text-muted); }

/* ── RESPONSIVE ── */
@media (max-width: 1100px) { .ki-stats { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 768px) {
  .ki-container { padding: 0 1.25rem; }
  .ki-shell { padding: 1.5rem 0 3rem; }
  .ki-hero-inner { padding: 1.75rem 1.5rem; }
  .ki-stats { grid-template-columns: 1fr 1fr; gap: 1rem; }
  .ki-filter-card { flex-direction: column; align-items: stretch; }
  .ki-search-form { flex-wrap: wrap; }
  .ki-filter-count { margin-left: 0; }
  .ki-tbl th, .ki-tbl td { padding: 8px 10px; font-size: 0.75rem; }
  .ki-act-btns { flex-wrap: wrap; }
}
@media (max-width: 480px) { .ki-stats { grid-template-columns: 1fr; } }
</style>
@endpush

{{-- ── FLASH NOTIF ── --}}
@if(session('flash_inv') || session('success') || session('error'))
<div id="flash-notif">
  <div class="fn-icon">
    <svg width="18" height="18" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24">
      @if(session('error'))
        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
      @else
        <polyline points="20 6 9 17 4 12"/>
      @endif
    </svg>
  </div>
  <div class="fn-body">
    <div class="fn-title">{{ session('error') ? 'Gagal' : 'Berhasil' }}</div>
    {{ session('flash_inv') ?? session('success') ?? session('error') }}
  </div>
  <button class="fn-close" onclick="this.parentElement.remove()">&times;</button>
</div>
<script>setTimeout(() => document.getElementById('flash-notif')?.remove(), 5000);</script>
@endif

<div class="ki-shell">
  <div class="ki-container">

    {{-- ═══ HERO (with full canvas/grid/glow layers) ═══ --}}
    <section class="ki-hero">
      <div class="ki-hero-canvas"></div>
      <div class="ki-hero-grid"></div>
      <div class="ki-hero-lines"></div>
      <div class="ki-hero-glow ki-hero-glow-1"></div>
      <div class="ki-hero-glow ki-hero-glow-2"></div>
      <div class="ki-hero-inner">
        <div class="ki-hero-text">
          <div class="ki-hero-eyebrow">
            <div class="ki-hero-eyebrow-dot">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
              </svg>
            </div>
            <span>Admin Dashboard</span>
          </div>
          <h1>Kelola Invoice</h1>
          <p>Pantau dan kelola semua invoice pengiriman ICE Logistics</p>
        </div>
        <a href="{{ route('create-invoice') }}" class="btn-new-inv">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
            <polyline points="14 2 14 8 20 8"/>
            <line x1="12" y1="11" x2="12" y2="17"/>
            <line x1="9" y1="14" x2="15" y2="14"/>
          </svg>
          Buat Invoice Baru
        </a>
      </div>
    </section>

    {{-- ═══ STATS ═══ --}}
    <section class="ki-stats">
      <div class="ki-stat reveal" data-accent="navy">
        <div class="ki-stat-head">
          <div class="ki-stat-icon">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
              <polyline points="14 2 14 8 20 8"/>
            </svg>
          </div>
          <span class="ki-stat-tag">Total</span>
        </div>
        <p class="ki-stat-label">Total Invoice</p>
        <div class="ki-stat-val">{{ number_format($stats['total'] ?? 0) }}</div>
        <div class="ki-stat-sub">Semua invoice</div>
      </div>
      <div class="ki-stat reveal reveal-d1" data-accent="amber">
        <div class="ki-stat-head">
          <div class="ki-stat-icon">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10"/>
              <line x1="12" y1="8" x2="12" y2="12"/>
              <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
          </div>
          <span class="ki-stat-tag">Pending</span>
        </div>
        <p class="ki-stat-label">Belum Lunas</p>
        <div class="ki-stat-val amber">{{ number_format($stats['total_unpaid'] ?? 0) }}</div>
        <div class="ki-stat-sub">Perlu ditindaklanjuti</div>
      </div>
      <div class="ki-stat reveal reveal-d2" data-accent="green">
        <div class="ki-stat-head">
          <div class="ki-stat-icon">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <polyline points="20 6 9 17 4 12"/>
            </svg>
          </div>
          <span class="ki-stat-tag">Paid</span>
        </div>
        <p class="ki-stat-label">Total Lunas</p>
        <div class="ki-stat-val-sm" style="color:var(--green);">{{ rupiah($stats['total_lunas'] ?? 0) }}</div>
        <div class="ki-stat-sub">Sudah diterima</div>
      </div>
      <div class="ki-stat reveal reveal-d3" data-accent="red">
        <div class="ki-stat-head">
          <div class="ki-stat-icon">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <line x1="12" y1="1" x2="12" y2="23"/>
              <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
            </svg>
          </div>
          <span class="ki-stat-tag">IDR</span>
        </div>
        <p class="ki-stat-label">Total Nilai</p>
        <div class="ki-stat-val-sm">{{ rupiah($stats['total_nilai'] ?? 0) }}</div>
        <div class="ki-stat-sub">Akumulasi seluruh invoice</div>
      </div>
    </section>

    {{-- ═══ FILTER & SEARCH ═══ --}}
    <div class="ki-filter-card reveal">
      <div class="ki-filter-tabs">
        <a href="{{ route('admin.invoices.index', array_merge(request()->query(), ['status' => 'all', 'page' => 1])) }}"
           class="ki-filter-tab {{ ($filterStatus ?? 'all') === 'all' ? 'ki-ft-all' : '' }}">Semua</a>
        <a href="{{ route('admin.invoices.index', array_merge(request()->query(), ['status' => 'Unpaid', 'page' => 1])) }}"
           class="ki-filter-tab {{ ($filterStatus ?? 'all') === 'Unpaid' ? 'ki-ft-unpaid' : '' }}">Belum Lunas</a>
        <a href="{{ route('admin.invoices.index', array_merge(request()->query(), ['status' => 'Paid', 'page' => 1])) }}"
           class="ki-filter-tab {{ ($filterStatus ?? 'all') === 'Paid' ? 'ki-ft-paid' : '' }}">Lunas</a>
      </div>
      <form method="GET" action="{{ route('admin.invoices.index') }}" class="ki-search-form">
        <input type="hidden" name="status" value="{{ $filterStatus ?? 'all' }}">
        <div class="ki-search-wrap">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
          </svg>
          <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nomor invoice atau nama customer...">
        </div>
        <button type="submit" class="ki-btn-search">Cari</button>
        @if(($search ?? '') || ($filterStatus ?? 'all') !== 'all')
          <a href="{{ route('admin.invoices.index') }}" class="ki-btn-reset">Reset</a>
        @endif
      </form>
      <div class="ki-filter-count">{{ $totalRows ?? 0 }} ditemukan</div>
    </div>

    {{-- ═══ TABLE ═══ --}}
    <div class="ki-card reveal">
      <div class="ki-card-header">
        <div class="ki-card-header-left">
          <div class="ki-card-header-icon">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/>
              <line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/>
              <line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/>
            </svg>
          </div>
          <h3>Daftar Invoice</h3>
        </div>
        <span class="ki-card-header-meta">Halaman {{ $currentPage ?? 1 }} / {{ $totalPages ?? 1 }}</span>
      </div>

      <div class="ki-table-wrap">
        <table class="ki-tbl">
          <thead>
            <tr>
              <th style="width:36px;">#</th>
              <th>Nomor Invoice</th>
              <th>Customer</th>
              <th class="right">Paket</th>
              <th class="right">Subtotal</th>
              <th class="right">DDP</th>
              <th class="right">Grand Total</th>
              <th>Status</th>
              <th>Tanggal</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($invoices as $inv)
              <tr>
                <td style="color:var(--border-2);font-weight:700;">{{ (($currentPage ?? 1) - 1) * 15 + $loop->iteration }}</td>
                <td><span class="ki-num-badge">{{ $inv->nomor_inv }}</span></td>
                <td><strong style="color:var(--text-primary);">{{ $inv->nama_customer }}</strong></td>
                <td class="right"><span class="ki-pkg-badge">{{ $inv->jumlah_paket }} pkt</span></td>
                <td class="right" style="font-weight:600;">{{ rupiah($inv->subtotal) }}</td>
                <td class="right">
                  @if($inv->ddp > 0)
                    <span class="ki-ddp-val">{{ rupiah($inv->ddp) }}</span>
                  @else
                    <span style="color:var(--border-2);">—</span>
                  @endif
                </td>
                <td class="right"><span class="ki-price-bold">{{ rupiah($inv->grand_total) }}</span></td>
                <td>
                  @if($inv->status === 'Paid')
                    <span class="ki-badge paid">Lunas</span>
                  @else
                    <span class="ki-badge unpaid">Belum Lunas</span>
                  @endif
                </td>
                <td style="color:var(--text-muted);font-size:0.8rem;white-space:nowrap;">
                  {{ $inv->created_at->format('d M Y') }}
                </td>
                <td>
                  <div class="ki-act-btns">
                    {{-- Edit --}}
                    <a href="{{ route('invoice.detail', hashid_encode($inv->id)) }}" class="ki-btn ki-btn-edit">
                      <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                      </svg>
                      Edit
                    </a>
                    {{-- Tandai Lunas --}}
                    @if($inv->status === 'Unpaid')
                    <form method="POST" action="{{ route('invoices.mark-paid', hashid_encode($inv->id)) }}" style="display:inline-flex;margin:0;">
                      @csrf
                      <input type="hidden" name="action" value="mark_paid">
                      <button type="submit" class="ki-btn ki-btn-paid" title="Tandai Lunas">
                        <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                          <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Lunas
                      </button>
                    </form>
                    @endif
                    {{-- Hapus --}}
                    <a href="{{ route('invoices.delete', hashid_encode($inv->id)) }}"
                       class="ki-btn ki-btn-del"
                       onclick="return confirm('Hapus invoice {{ $inv->nomor_inv }}?\nSemua item invoice akan ikut terhapus.')"
                       title="Hapus">
                      <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                        <path d="M10 11v6M14 11v6"/>
                      </svg>
                    </a>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="10">
                  <div class="ki-empty">
                    <div class="ki-empty-icon">
                      <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="9" y1="13" x2="15" y2="13"/>
                        <line x1="9" y1="17" x2="13" y2="17"/>
                      </svg>
                    </div>
                    <h4>Tidak ada invoice</h4>
                    <p>Coba ubah filter atau buat invoice baru.</p>
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{-- Pagination --}}
      @if(($totalPages ?? 1) > 1)
      <div class="ki-pagination">
        @if(($currentPage ?? 1) > 1)
          <a href="{{ route('admin.invoices.index', array_merge(request()->query(), ['page' => ($currentPage ?? 1) - 1])) }}" class="pg">&larr;</a>
        @endif
        @for($p = 1; $p <= $totalPages; $p++)
          @if($p == ($currentPage ?? 1))
            <span class="pg active">{{ $p }}</span>
          @elseif($p == 1 || $p == $totalPages || abs($p - ($currentPage ?? 1)) <= 1)
            <a href="{{ route('admin.invoices.index', array_merge(request()->query(), ['page' => $p])) }}" class="pg">{{ $p }}</a>
          @elseif(abs($p - ($currentPage ?? 1)) == 2)
            <span class="pg dots">…</span>
          @endif
        @endfor
        @if(($currentPage ?? 1) < $totalPages)
          <a href="{{ route('admin.invoices.index', array_merge(request()->query(), ['page' => ($currentPage ?? 1) + 1])) }}" class="pg">&rarr;</a>
        @endif
      </div>
      @endif
    </div>

  </div>{{-- /container --}}
</div>{{-- /shell --}}

<script>
// Scroll Reveal
document.addEventListener('DOMContentLoaded', () => {
  const els = document.querySelectorAll('.reveal, .reveal-left, .reveal-right');
  if (!els.length) return;
  const io = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) { e.target.classList.add('is-visible'); io.unobserve(e.target); }
    });
  }, { threshold: 0.1 });
  els.forEach(el => io.observe(el));
});
</script>
@endsection
