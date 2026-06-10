@extends('layouts.app')
@section('title', 'Laporan Keuangan - Admin Dashboard')
@section('content')
@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300&display=swap');

/* ══ ICE Design System — Reports ══ */
:root {
  --red:          #E31E24;
  --red-hover:    #C7181D;
  --red-deep:     #A0121A;
  --red-glow:     rgba(227,30,36,0.22);
  --navy-900:     #060F2E;
  --navy-800:     #0A1A4A;
  --navy-700:     #0D2260;
  --navy-600:     #102B78;
  --navy-500:     #1438A0;
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
  --teal:         #0891b2;
  --shadow-xs:    0 1px 4px rgba(9,24,60,0.06);
  --shadow-sm:    0 2px 8px rgba(9,24,60,0.08);
  --shadow-md:    0 8px 24px rgba(9,24,60,0.10);
  --shadow-lg:    0 16px 48px rgba(9,24,60,0.12);
  --shadow-xl:    0 32px 80px rgba(9,24,60,0.14);
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
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(28px); }
  to   { opacity: 1; transform: translateY(0); }
}

/* ── PAGE SHELL ── */
.rp-shell {
  font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
  background: var(--surface);
  min-height: calc(100vh - 200px);
  padding: 3rem 0 5rem;
}
.rp-container {
  max-width: 1440px;
  margin: 0 auto;
  padding: 0 2rem;
}

/* ── HERO ── */
.rp-hero {
  position: relative;
  overflow: hidden;
  border-radius: 24px;
  margin-bottom: 2rem;
  box-shadow: 0 20px 60px rgba(6,15,46,0.30);
  min-height: 170px;
  display: flex;
  align-items: center;
}
.rp-hero-canvas {
  position: absolute; inset: 0; z-index: 0;
  background:
    radial-gradient(ellipse 100% 80% at 100% 0%,  rgba(20,56,160,0.55) 0%, transparent 55%),
    radial-gradient(ellipse 70%  60% at 0%  100%, rgba(227,30,36,0.10) 0%, transparent 50%),
    radial-gradient(ellipse 60%  70% at 55% 50%,  rgba(11,26,74,0.9)   0%, transparent 70%),
    linear-gradient(168deg, var(--navy-900) 0%, #0B1C55 45%, #091640 100%);
}
.rp-hero-canvas::after {
  content: '';
  position: absolute; inset: 0;
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.035'/%3E%3C/svg%3E");
  pointer-events: none; mix-blend-mode: overlay; opacity: 0.5;
}
.rp-hero-grid {
  position: absolute; inset: 0; z-index: 0;
  background-image: radial-gradient(circle, rgba(255,255,255,0.055) 1px, transparent 1px);
  background-size: 44px 44px;
  mask-image: radial-gradient(ellipse 90% 80% at 50% 50%, black 40%, transparent 80%);
}
.rp-hero-lines {
  position: absolute; inset: 0; z-index: 0; overflow: hidden;
}
.rp-hero-lines::before,
.rp-hero-lines::after {
  content: ''; position: absolute; top: 0; bottom: 0; width: 1px;
}
.rp-hero-lines::before {
  right: 34%;
  background: linear-gradient(to bottom, transparent 0%, rgba(227,30,36,0.35) 25%, rgba(227,30,36,0.15) 70%, transparent 100%);
}
.rp-hero-lines::after {
  left: 52%;
  background: linear-gradient(to bottom, transparent 10%, rgba(59,174,224,0.12) 40%, rgba(59,174,224,0.06) 75%, transparent 100%);
}
.rp-hero-glow {
  position: absolute; z-index: 0; border-radius: 50%; filter: blur(80px); pointer-events: none;
}
.rp-hero-glow-1 {
  width: 600px; height: 600px; top: -200px; right: -80px;
  background: radial-gradient(circle, rgba(20,56,160,0.4) 0%, transparent 65%);
}
.rp-hero-glow-2 {
  width: 350px; height: 350px; bottom: -100px; left: 0;
  background: radial-gradient(circle, rgba(227,30,36,0.12) 0%, transparent 65%);
}
.rp-hero-inner {
  position: relative; z-index: 2;
  width: 100%;
  padding: 2.5rem;
  display: flex; align-items: center; justify-content: space-between;
  gap: 2rem; flex-wrap: wrap;
}
.rp-hero-text { flex: 1; min-width: 260px; }
.rp-hero-eyebrow {
  display: inline-flex; align-items: center; gap: 0.6rem;
  margin-bottom: 1.1rem;
  padding: 0.4rem 1rem 0.4rem 0.55rem;
  border-radius: 99px;
  border: 1px solid rgba(227,30,36,0.3);
  background: rgba(227,30,36,0.07);
  backdrop-filter: blur(10px);
}
.rp-hero-eyebrow-dot {
  width: 22px; height: 22px; border-radius: 50%;
  background: linear-gradient(135deg, var(--red), var(--red-deep));
  display: flex; align-items: center; justify-content: center; flex-shrink: 0;
  box-shadow: 0 4px 12px rgba(227,30,36,0.4);
}
.rp-hero-eyebrow-dot svg { width: 11px; height: 11px; color: #fff; }
.rp-hero-eyebrow span {
  font-size: 0.68rem; font-weight: 800; letter-spacing: 0.12em;
  text-transform: uppercase; color: rgba(255,255,255,0.75);
  padding-right: 0.3rem;
}
.rp-hero h1 {
  font-size: clamp(1.75rem, 3.5vw, 2.4rem);
  font-weight: 900; line-height: 1.05;
  margin: 0 0 0.5rem; color: #fff;
  letter-spacing: -0.03em;
}
.rp-hero p {
  font-size: 0.95rem; color: rgba(255,255,255,0.55); margin: 0;
  font-weight: 400; line-height: 1.6;
}
.rp-period-badge {
  display: inline-flex; align-items: center; gap: 6px;
  background: rgba(255,255,255,0.10);
  color: rgba(255,255,255,0.9);
  border: 1px solid rgba(255,255,255,0.2);
  padding: 0.55rem 1.1rem; border-radius: 99px;
  font-size: 0.75rem; font-weight: 800; text-transform: uppercase;
  letter-spacing: 0.08em; flex-shrink: 0; white-space: nowrap; align-self: center;
  backdrop-filter: blur(10px);
}
.rp-period-badge svg { width: 13px; height: 13px; }

/* ── STATS ── */
.rp-stats {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 1.25rem; margin-bottom: 2rem;
}
.o-stat {
  background: var(--white); border: 1px solid var(--border); border-radius: 18px;
  padding: 1.4rem; transition: all 0.3s var(--ease-out);
  position: relative; overflow: hidden;
}
.o-stat:hover { transform: translateY(-4px); box-shadow: var(--shadow-lg); border-color: var(--border-2); }
.o-stat::before {
  content: ''; position: absolute; top: 0; left: 0;
  width: 100%; height: 3px;
  background: var(--os-accent, var(--navy-900));
}
.o-stat[data-accent="navy"]  { --os-accent: var(--navy-900); }
.o-stat[data-accent="green"] { --os-accent: var(--green); }
.o-stat[data-accent="teal"]  { --os-accent: var(--teal); }
.o-stat[data-accent="red"]   { --os-accent: var(--red); }
.o-stat-head {
  display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;
}
.o-stat-icon {
  width: 44px; height: 44px; border-radius: 12px;
  background: color-mix(in srgb, var(--os-accent) 10%, transparent);
  color: var(--os-accent);
  display: inline-flex; align-items: center; justify-content: center;
}
.o-stat-icon svg { width: 22px; height: 22px; }
.o-stat-tag {
  font-size: 0.68rem; font-weight: 800; padding: 0.25rem 0.55rem;
  border-radius: 99px;
  background: color-mix(in srgb, var(--os-accent) 10%, transparent);
  color: var(--os-accent); text-transform: uppercase; letter-spacing: 0.05em;
}
.o-stat-label { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-muted); margin: 0 0 0.4rem; }
.o-stat-val    { font-size: 1.85rem; font-weight: 900; color: var(--text-primary); line-height: 1; letter-spacing: -0.02em; }
.o-stat-val-sm { font-size: 1.2rem;  font-weight: 900; color: var(--text-primary); line-height: 1.2; letter-spacing: -0.01em; }
.o-stat-val-sm.green { color: var(--green); }
.o-stat-val-sm.teal  { color: var(--teal); }
.o-stat-val-sm.red   { color: var(--red); }
.o-stat-sub    { font-size: 0.78rem; color: var(--text-2); margin-top: 0.35rem; }

/* ── FILTER CARD ── */
.rp-filter-card {
  background: var(--white); border: 1px solid var(--border); border-radius: 18px;
  padding: 1.5rem; margin-bottom: 2rem;
  box-shadow: var(--shadow-xs);
}
.rp-filter-hdr {
  display: flex; align-items: center; justify-content: space-between;
  gap: 0.75rem; margin-bottom: 1.375rem;
  padding-bottom: 1rem; border-bottom: 1px solid var(--border);
  flex-wrap: wrap;
}
.rp-filter-hdr h3 {
  font-size: 1rem; font-weight: 800; color: var(--text-primary);
  margin: 0; display: flex; align-items: center; gap: 0.6rem;
}
.rp-filter-hdr-icon {
  width: 30px; height: 30px; border-radius: 8px;
  background: rgba(6,15,46,0.06); color: var(--navy-900);
  display: inline-flex; align-items: center; justify-content: center;
}
.rp-filter-hdr-icon svg { width: 15px; height: 15px; }
.rp-actions { display: flex; gap: 0.75rem; flex-wrap: wrap; align-items: center; }
.rp-btn-action {
  display: inline-flex; align-items: center; gap: 6px;
  padding: 0.6rem 1.1rem; border-radius: 9px;
  font-size: 0.8rem; font-weight: 700;
  text-decoration: none; transition: all 0.18s;
  border: none; cursor: pointer; font-family: inherit; white-space: nowrap;
}
.rp-btn-action svg { width: 14px; height: 14px; }
.rp-btn-action:hover { transform: translateY(-1px); }
.rp-btn-action.navy  { background: var(--navy-900); color: white; box-shadow: 0 4px 14px rgba(6,15,46,0.25); }
.rp-btn-action.navy:hover  { background: var(--navy-800); color: white; }
.rp-btn-action.green { background: var(--green); color: white; box-shadow: 0 4px 14px rgba(22,163,74,0.25); }
.rp-btn-action.green:hover { background: #15803d; color: white; }
.rp-btn-action.red   { background: var(--red); color: white; box-shadow: 0 4px 14px rgba(227,30,36,0.25); }
.rp-btn-action.red:hover   { background: var(--red-hover); color: white; }
.rp-date-badge {
  background: var(--surface); border: 1px solid var(--border); border-radius: 9px;
  padding: 0.55rem 1rem; font-size: 0.82rem; font-weight: 700; color: var(--text-2);
  display: flex; align-items: center; gap: 0.4rem;
}
.rp-date-badge svg { width: 14px; height: 14px; color: var(--text-muted); }

/* Filter grid */
.rp-filter-grid {
  display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
  gap: 1rem; align-items: end;
}
.rp-fg label {
  display: block; font-size: 0.68rem; font-weight: 800;
  color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.4rem;
}
.rp-fg input, .rp-fg select {
  width: 100%; padding: 10px 14px; border-radius: 9px;
  border: 1.5px solid var(--border); font-size: 0.875rem;
  background: var(--surface); color: var(--text-primary); font-family: inherit;
  transition: all 0.2s; box-sizing: border-box;
}
.rp-fg input:focus, .rp-fg select:focus {
  border-color: var(--navy-900); box-shadow: 0 0 0 3px rgba(6,15,46,0.08); outline: none; background: var(--white);
}
.rp-btn-filter {
  padding: 10px 20px; background: var(--navy-900); color: white;
  border: none; border-radius: 9px; font-weight: 700;
  font-size: 0.875rem; cursor: pointer; transition: all 0.18s;
  font-family: inherit; white-space: nowrap;
  display: inline-flex; align-items: center; gap: 6px; width: 100%;
  justify-content: center;
}
.rp-btn-filter svg { width: 14px; height: 14px; }
.rp-btn-filter:hover { background: var(--navy-800); transform: translateY(-1px); }

/* ── CHART CARD ── */
.rp-chart-card {
  background: var(--white); border: 1px solid var(--border); border-radius: 18px;
  padding: 2rem; margin-bottom: 2rem;
  box-shadow: var(--shadow-xs);
}
.rp-chart-hdr {
  display: flex; align-items: center; justify-content: space-between;
  margin-bottom: 1.5rem; padding-bottom: 1rem;
  border-bottom: 1px solid var(--border); flex-wrap: wrap; gap: 0.75rem;
}
.rp-chart-hdr-left { display: flex; align-items: center; gap: 0.6rem; }
.rp-chart-hdr-icon {
  width: 34px; height: 34px; border-radius: 10px;
  background: rgba(6,15,46,0.06); color: var(--navy-900);
  display: inline-flex; align-items: center; justify-content: center;
}
.rp-chart-hdr-icon svg { width: 17px; height: 17px; }
.rp-chart-hdr h3 { font-size: 1rem; font-weight: 800; color: var(--text-primary); margin: 0; letter-spacing: -0.01em; }
.rp-chart-tabs {
  display: flex; gap: 4px;
  background: var(--surface-2); padding: 4px; border-radius: 10px; border: 1px solid var(--border);
}
.rp-tab {
  padding: 0.4rem 1rem; border: none; background: transparent;
  color: var(--text-muted); font-size: 0.8rem; font-weight: 700;
  border-radius: 7px; cursor: pointer; transition: all 0.2s; font-family: inherit;
}
.rp-tab.active { background: var(--navy-900); color: white; box-shadow: 0 2px 8px rgba(6,15,46,0.2); }
.rp-tab:hover:not(.active) { background: var(--white); color: var(--text-primary); }
.rp-chart-subtitle {
  font-size: 0.82rem; font-weight: 700; color: var(--text-muted);
  margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;
}
.rp-chart-subtitle svg { width: 14px; height: 14px; }

/* Bar chart */
.rp-bars {
  display: grid; gap: 0.375rem; height: 200px;
  align-items: end; padding: 0.75rem 0;
}
.rp-bar-wrap { display: flex; flex-direction: column; align-items: center; height: 100%; justify-content: flex-end; }
.rp-bar {
  width: 100%; background: var(--navy-900);
  border-radius: 4px 4px 0 0; min-height: 4px;
  transition: all 0.3s cubic-bezier(0.4,0,0.2,1); cursor: pointer;
  opacity: 0.85;
}
.rp-bar:hover { transform: translateY(-4px) scale(1.06); box-shadow: 0 8px 20px rgba(6,15,46,0.25); opacity: 1; }
.rp-bar.has-value { background: linear-gradient(180deg, var(--navy-900) 0%, #1e3a8a 100%); }
.rp-bar.empty { background: var(--border); opacity: 1; }
.rp-bar.empty:hover { transform: none; box-shadow: none; }
.rp-bar-lbl {
  font-size: 0.58rem; color: var(--text-muted); margin-top: 0.35rem;
  font-weight: 700; text-transform: uppercase; letter-spacing: 0.02em;
}
.rp-chart-footer {
  display: flex; justify-content: space-between;
  margin-top: 1.5rem; padding-top: 1.25rem;
  border-top: 1px solid var(--border); flex-wrap: wrap; gap: 1rem;
}
.rp-chart-stat { display: flex; flex-direction: column; gap: 0.25rem; }
.rp-chart-stat-lbl { font-size: 0.68rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.06em; }
.rp-chart-stat-val { font-size: 1.25rem; font-weight: 900; color: var(--navy-900); letter-spacing: -0.02em; }

/* ── TABLE CARD ── */
.rp-card {
  background: var(--white); border: 1px solid var(--border);
  border-radius: 18px; overflow: hidden; margin-bottom: 2rem;
}
.rp-card-header {
  padding: 1.1rem 1.4rem; display: flex; justify-content: space-between; align-items: center;
  border-bottom: 1px solid var(--border); background: var(--surface); flex-wrap: wrap; gap: 0.5rem;
}
.rp-card-header-left { display: flex; align-items: center; gap: 0.6rem; }
.rp-card-header-icon {
  width: 32px; height: 32px; border-radius: 9px;
  background: rgba(6,15,46,0.06); color: var(--navy-900);
  display: inline-flex; align-items: center; justify-content: center;
}
.rp-card-header-icon svg { width: 16px; height: 16px; }
.rp-card-header h3 { margin: 0; font-size: 1rem; font-weight: 800; color: var(--text-primary); letter-spacing: -0.01em; }
.rp-card-meta { font-size: 0.78rem; color: var(--text-muted); font-weight: 600; }
.rp-table-wrap { overflow-x: auto; }
.rp-tbl { width: 100%; border-collapse: collapse; }
.rp-tbl thead tr { background: var(--navy-900); }
.rp-tbl th {
  padding: 0.85rem 1rem; font-size: 0.68rem; font-weight: 800;
  color: rgba(255,255,255,0.85); text-align: left;
  letter-spacing: 0.1em; white-space: nowrap;
  border-bottom: 1px solid var(--border);
}
.rp-tbl td {
  padding: 0.95rem 1rem; font-size: 0.85rem; color: var(--text-2);
  border-bottom: 1px solid var(--border); vertical-align: middle; font-weight: 500;
}
.rp-tbl tr:last-child td { border-bottom: none; }
.rp-tbl tbody tr { transition: background 0.15s; }
.rp-tbl tbody tr:hover td { background: var(--surface-2); }

/* Badges */
.rp-period-code {
  font-family: 'JetBrains Mono', 'SF Mono', 'Courier New', monospace;
  font-size: 0.78rem; font-weight: 700;
  background: rgba(6,15,46,0.06); color: var(--navy-900);
  padding: 0.3rem 0.6rem; border-radius: 7px;
  border: 1px solid var(--border); white-space: nowrap;
  display: inline-flex; align-items: center; gap: 5px;
}
.rp-period-code svg { width: 11px; height: 11px; opacity: 0.6; }
.rp-order-badge {
  background: var(--surface-2); color: var(--text-2); border: 1px solid var(--border);
  padding: 0.25rem 0.6rem; border-radius: 7px;
  font-size: 0.75rem; font-weight: 700; display: inline-block;
}
.rp-profit-pos { font-weight: 800; color: var(--green); }
.rp-profit-neg { font-weight: 800; color: #b91c1c; }
.rp-income-val  { font-weight: 800; color: var(--text-primary); }
.rp-modal-val   { color: var(--text-muted); }

/* Empty */
.rp-empty { padding: 3.5rem 1.5rem; text-align: center; color: var(--text-muted); }
.rp-empty-icon {
  width: 64px; height: 64px; margin: 0 auto 1rem;
  border-radius: 16px; background: var(--surface-2);
  display: inline-flex; align-items: center; justify-content: center; color: var(--navy-900);
}
.rp-empty-icon svg { width: 28px; height: 28px; }
.rp-empty h4 { font-size: 1rem; font-weight: 800; color: var(--text-primary); margin: 0 0 0.4rem; }
.rp-empty p  { margin: 0; font-size: 0.85rem; }

/* ── RESPONSIVE ── */
@media (max-width: 1100px) { .rp-stats { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 768px) {
  .rp-container { padding: 0 1.25rem; }
  .rp-shell { padding: 1.5rem 0 3rem; }
  .rp-hero-inner { padding: 1.75rem 1.5rem; }
  .rp-stats { grid-template-columns: 1fr 1fr; gap: 1rem; }
  .rp-filter-grid { grid-template-columns: 1fr; }
  .rp-chart-card { padding: 1.25rem; }
  .rp-tbl th, .rp-tbl td { padding: 8px 10px; font-size: 0.78rem; }
}
@media (max-width: 480px) { .rp-stats { grid-template-columns: 1fr; } }
</style>
@endpush

<div class="rp-shell">
  <div class="rp-container">

    {{-- ═══ HERO ═══ --}}
    <section class="rp-hero">
      <div class="rp-hero-canvas"></div>
      <div class="rp-hero-grid"></div>
      <div class="rp-hero-lines"></div>
      <div class="rp-hero-glow rp-hero-glow-1"></div>
      <div class="rp-hero-glow rp-hero-glow-2"></div>
      <div class="rp-hero-inner">
        <div class="rp-hero-text">
          <div class="rp-hero-eyebrow">
            <div class="rp-hero-eyebrow-dot">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/>
              </svg>
            </div>
            <span>Admin Dashboard</span>
          </div>
          <h1>Laporan Keuangan</h1>
          <p>Analisis lengkap penjualan, keuntungan, dan biaya operasional.</p>
        </div>
        <div class="rp-period-badge">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
          </svg>
          {{ $periodType }}: {{ $periodName }}
        </div>
      </div>
    </section>

    {{-- ═══ STATS ═══ --}}
    <section class="rp-stats">
      <div class="o-stat reveal" data-accent="navy">
        <div class="o-stat-head">
          <div class="o-stat-icon">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 7h13M10 21a1 1 0 100-2 1 1 0 000 2zm7 0a1 1 0 100-2 1 1 0 000 2z"/>
            </svg>
          </div>
          <span class="o-stat-tag">Total</span>
        </div>
        <p class="o-stat-label">Total Orders</p>
        <div class="o-stat-val">{{ number_format($totalOrders) }}</div>
        <div class="o-stat-sub">Seluruh transaksi</div>
      </div>

      <div class="o-stat reveal reveal-d1" data-accent="green">
        <div class="o-stat-head">
          <div class="o-stat-icon">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <line x1="12" y1="1" x2="12" y2="23"/>
              <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
            </svg>
          </div>
          <span class="o-stat-tag">IDR</span>
        </div>
        <p class="o-stat-label">Total Revenue</p>
        <div class="o-stat-val-sm green">{{ rupiah($totalIncome) }}</div>
        <div class="o-stat-sub">Pendapatan kotor</div>
      </div>

      <div class="o-stat reveal reveal-d2" data-accent="teal">
        <div class="o-stat-head">
          <div class="o-stat-icon">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
              <polyline points="17 6 23 6 23 12"/>
            </svg>
          </div>
          <span class="o-stat-tag">Gross</span>
        </div>
        <p class="o-stat-label">Gross Profit</p>
        <div class="o-stat-val-sm teal">{{ rupiah($totalProfit) }}</div>
        <div class="o-stat-sub">Sebelum pengeluaran</div>
      </div>

      <div class="o-stat reveal reveal-d3" data-accent="{{ $netProfit >= 0 ? 'green' : 'red' }}">
        <div class="o-stat-head">
          <div class="o-stat-icon">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <line x1="12" y1="1" x2="12" y2="23"/>
              <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
            </svg>
          </div>
          <span class="o-stat-tag">Net</span>
        </div>
        <p class="o-stat-label">Net Profit</p>
        <div class="o-stat-val-sm {{ $netProfit >= 0 ? 'green' : 'red' }}">
          {{ rupiah($netProfit) }}
        </div>
        <div class="o-stat-sub">Setelah pengeluaran</div>
      </div>
    </section>

    {{-- ═══ FILTER CARD ═══ --}}
    <div class="rp-filter-card reveal">
      <div class="rp-filter-hdr">
        <h3>
          <div class="rp-filter-hdr-icon">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
            </svg>
          </div>
          Filter Laporan
        </h3>
        <div class="rp-actions">
          @if(in_array(auth()->user()->role, ['dev','owner']))
          <a href="{{ route('admin.expenses') }}" class="rp-btn-action red">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path d="M9 14l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Atur Pengeluaran
          </a>
          <a href="{{ route('admin.reports.export', request()->query()) }}" class="rp-btn-action green">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
              <polyline points="7 10 12 15 17 10"/>
              <line x1="12" y1="15" x2="12" y2="3"/>
            </svg>
            Export Excel
          </a>
          @endif
          <div class="rp-date-badge">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
            </svg>
            {{ date('d F Y') }}
          </div>
        </div>
      </div>
      <form method="GET" action="{{ route('admin.reports') }}">
        <div class="rp-filter-grid">
          <div class="rp-fg">
            <label>Filter Periode</label>
            <select name="filter_type" onchange="toggleFilterOptions()">
              <option value="" {{ empty($filterType) ? 'selected' : '' }}>Semua Data</option>
              <option value="daily"   {{ $filterType === 'daily'   ? 'selected' : '' }}>Harian</option>
              <option value="weekly"  {{ $filterType === 'weekly'  ? 'selected' : '' }}>Mingguan</option>
              <option value="monthly" {{ $filterType === 'monthly' ? 'selected' : '' }}>Bulanan</option>
              <option value="yearly"  {{ $filterType === 'yearly'  ? 'selected' : '' }}>Tahunan</option>
            </select>
          </div>
          <div id="date-group" class="rp-fg" style="display:{{ $filterType === 'daily' ? 'block' : 'none' }};">
            <label>Pilih Tanggal</label>
            <input type="date" name="date" value="{{ old('date', $date) }}">
          </div>
          <div id="week-group" class="rp-fg" style="display:{{ $filterType === 'weekly' ? 'block' : 'none' }};">
            <label>Minggu</label>
            <select name="week">
              <option value="">Pilih Minggu</option>
              @for($w = 1; $w <= 53; $w++)
                <option value="{{ $w }}" {{ $week == $w ? 'selected' : '' }}>Minggu ke-{{ $w }}</option>
              @endfor
            </select>
          </div>
          <div id="month-group" class="rp-fg" style="display:{{ $filterType === 'monthly' ? 'block' : 'none' }};">
            <label>Bulan</label>
            <select name="month">
              <option value="">Pilih Bulan</option>
              @for($m = 1; $m <= 12; $m++)
                <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>{{ date('F', mktime(0,0,0,$m,1)) }}</option>
              @endfor
            </select>
          </div>
          <div class="rp-fg">
            <label>Tahun</label>
            <select name="year">
              <option value="">Pilih Tahun</option>
              @for($y = 2020; $y <= date('Y')+1; $y++)
                <option value="{{ $y }}" {{ ($year == $y || (empty($year) && $y == date('Y'))) ? 'selected' : '' }}>{{ $y }}</option>
              @endfor
            </select>
          </div>
          <div class="rp-fg">
            <label>&nbsp;</label>
            <button type="submit" class="rp-btn-filter">
              <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
              </svg>
              Terapkan Filter
            </button>
          </div>
        </div>
      </form>
    </div>

    {{-- ═══ CHART CARD ═══ --}}
    <div class="rp-chart-card reveal">
      <div class="rp-chart-hdr">
        <div class="rp-chart-hdr-left">
          <div class="rp-chart-hdr-icon">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/>
            </svg>
          </div>
          <h3>Grafik Penjualan</h3>
        </div>
        <div class="rp-chart-tabs">
          <button onclick="showChart('monthly')" id="tab-monthly" class="rp-tab active">Bulanan</button>
          <button onclick="showChart('yearly')"  id="tab-yearly"  class="rp-tab">Tahunan</button>
        </div>
      </div>

      {{-- Chart: Daily in current month --}}
      <div id="chart-monthly">
        <p class="rp-chart-subtitle">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
          </svg>
          Penjualan Harian &mdash; {{ date('F Y') }}
        </p>
        <div class="rp-bars" style="grid-template-columns:repeat({{ $daysInMonth }},1fr);">
          @foreach($dailyData as $d)
            @php $height = $maxDailyRev > 0 ? min(($d['rev'] / $maxDailyRev) * 100, 100) : 0; @endphp
            <div class="rp-bar-wrap">
              <div class="rp-bar {{ $d['rev'] > 0 ? 'has-value' : 'empty' }}"
                   style="height:{{ max($height, 2) }}%"
                   title="{{ $d['title'] }}: {{ rupiah($d['rev']) }} ({{ $d['ord'] }} order)"></div>
              <span class="rp-bar-lbl">{{ $d['lbl'] }}</span>
            </div>
          @endforeach
        </div>
        <div class="rp-chart-footer">
          <div class="rp-chart-stat">
            <span class="rp-chart-stat-lbl">Revenue Bulan Ini</span>
            <span class="rp-chart-stat-val">{{ rupiah($currentMonthRev) }}</span>
          </div>
          <div class="rp-chart-stat">
            <span class="rp-chart-stat-lbl">Order Bulan Ini</span>
            <span class="rp-chart-stat-val">{{ number_format($currentMonthOrd) }}</span>
          </div>
          <div class="rp-chart-stat">
            <span class="rp-chart-stat-lbl">Rata-rata / Hari</span>
            <span class="rp-chart-stat-val">{{ rupiah($daysInMonth > 0 ? $currentMonthRev / $daysInMonth : 0) }}</span>
          </div>
        </div>
      </div>

      {{-- Chart: Monthly in current year --}}
      <div id="chart-yearly" style="display:none;">
        <p class="rp-chart-subtitle">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
          </svg>
          Penjualan Bulanan &mdash; {{ $currentYear }}
        </p>
        <div class="rp-bars" style="grid-template-columns:repeat(12,1fr);">
          @foreach($monthlyData as $m)
            @php $height = $maxMonthlyRev > 0 ? min(($m['rev'] / $maxMonthlyRev) * 100, 100) : 0; @endphp
            <div class="rp-bar-wrap">
              <div class="rp-bar {{ $m['rev'] > 0 ? 'has-value' : 'empty' }}"
                   style="height:{{ max($height, 2) }}%"
                   title="{{ $m['lbl'] }}: {{ rupiah($m['rev']) }} ({{ $m['ord'] }} order)"></div>
              <span class="rp-bar-lbl">{{ $m['lbl'] }}</span>
            </div>
          @endforeach
        </div>
        <div class="rp-chart-footer">
          <div class="rp-chart-stat">
            <span class="rp-chart-stat-lbl">Revenue Tahun Ini</span>
            <span class="rp-chart-stat-val">{{ rupiah($currentYearRev) }}</span>
          </div>
          <div class="rp-chart-stat">
            <span class="rp-chart-stat-lbl">Order Tahun Ini</span>
            <span class="rp-chart-stat-val">{{ number_format($currentYearOrd) }}</span>
          </div>
          <div class="rp-chart-stat">
            <span class="rp-chart-stat-lbl">Rata-rata / Bulan</span>
            <span class="rp-chart-stat-val">{{ rupiah($currentYearRev / 12) }}</span>
          </div>
        </div>
      </div>
    </div>

    {{-- ═══ DETAIL TABLE ═══ --}}
    <div class="rp-card reveal">
      <div class="rp-card-header">
        <div class="rp-card-header-left">
          <div class="rp-card-header-icon">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
            </svg>
          </div>
          <h3>Detail Per {{ in_array($filterType, ['daily','weekly','monthly']) ? 'Hari' : 'Bulan' }}</h3>
        </div>
        <span class="rp-card-meta">{{ count($rows) }} periode &nbsp;&bull;&nbsp; Terbaru</span>
      </div>
      <div class="rp-table-wrap">
        <table class="rp-tbl">
          <thead>
            <tr>
              <th>Periode</th>
              <th>Total Order</th>
              <th>Total Income</th>
              <th>Total Modal</th>
              <th>Keuntungan</th>
            </tr>
          </thead>
          <tbody>
            @forelse($rows as $row)
              <tr>
                <td>
                  <span class="rp-period-code">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
                    </svg>
                    {{ $row->period }}
                  </span>
                </td>
                <td><span class="rp-order-badge">{{ number_format($row->total) }} order</span></td>
                <td><span class="rp-income-val">{{ rupiah($row->income) }}</span></td>
                <td><span class="rp-modal-val">{{ rupiah($row->modal) }}</span></td>
                <td>
                  <span class="{{ $row->profit >= 0 ? 'rp-profit-pos' : 'rp-profit-neg' }}">
                    {{ rupiah($row->profit) }}
                  </span>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5">
                  <div class="rp-empty">
                    <div class="rp-empty-icon">
                      <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/>
                      </svg>
                    </div>
                    <h4>Tidak ada data laporan</h4>
                    <p>Coba ubah filter atau pilih periode yang berbeda.</p>
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

<script>
// ── SCROLL REVEAL ──
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

// ── CHART TABS ──
function showChart(type) {
  document.getElementById('chart-monthly').style.display = type === 'monthly' ? 'block' : 'none';
  document.getElementById('chart-yearly').style.display  = type === 'yearly'  ? 'block' : 'none';
  document.getElementById('tab-monthly').classList.toggle('active', type === 'monthly');
  document.getElementById('tab-yearly').classList.toggle('active',  type === 'yearly');
}

// ── FILTER TOGGLE ──
function toggleFilterOptions() {
  const t = document.querySelector('select[name="filter_type"]').value;
  document.getElementById('date-group').style.display  = t === 'daily'   ? 'block' : 'none';
  document.getElementById('week-group').style.display  = t === 'weekly'  ? 'block' : 'none';
  document.getElementById('month-group').style.display = t === 'monthly' ? 'block' : 'none';
}
document.addEventListener('DOMContentLoaded', toggleFilterOptions);
</script>
@endsection
