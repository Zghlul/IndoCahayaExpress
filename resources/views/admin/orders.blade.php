@extends('layouts.app')
@section('title', 'Orders - Admin Dashboard')
@section('content')
@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300&family=DM+Serif+Display:ital@0;1&display=swap');

/* ══ ICE Design System — Orders ══ */
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
@keyframes live-pulse {
  0%, 100% { opacity: 1; transform: scale(1); }
  50%       { opacity: 0.45; transform: scale(0.75); }
}
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(28px); }
  to   { opacity: 1; transform: translateY(0); }
}

/* ── PAGE SHELL ── */
.ord-shell {
  font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
  background: var(--surface);
  min-height: calc(100vh - 200px);
  padding: 3rem 0 5rem;
}
.ord-container {
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

/* ── HERO ── */
.ord-hero {
  position: relative;
  overflow: hidden;
  border-radius: 24px;
  margin-bottom: 2rem;
  box-shadow: 0 20px 60px rgba(6,15,46,0.30);
  min-height: 190px;
  display: flex;
  align-items: center;
}
.ord-hero-canvas {
  position: absolute; inset: 0; z-index: 0;
  background:
    radial-gradient(ellipse 100% 80% at 100% 0%,  rgba(20,56,160,0.55) 0%, transparent 55%),
    radial-gradient(ellipse 70%  60% at 0%  100%, rgba(227,30,36,0.10) 0%, transparent 50%),
    radial-gradient(ellipse 60%  70% at 55% 50%,  rgba(11,26,74,0.9)   0%, transparent 70%),
    linear-gradient(168deg, var(--navy-900) 0%, #0B1C55 45%, #091640 100%);
}
.ord-hero-canvas::after {
  content: '';
  position: absolute; inset: 0;
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.035'/%3E%3C/svg%3E");
  pointer-events: none; mix-blend-mode: overlay; opacity: 0.5;
}
.ord-hero-grid {
  position: absolute; inset: 0; z-index: 0;
  background-image: radial-gradient(circle, rgba(255,255,255,0.055) 1px, transparent 1px);
  background-size: 44px 44px;
  mask-image: radial-gradient(ellipse 90% 80% at 50% 50%, black 40%, transparent 80%);
}
.ord-hero-lines {
  position: absolute; inset: 0; z-index: 0; overflow: hidden;
}
.ord-hero-lines::before,
.ord-hero-lines::after {
  content: ''; position: absolute; top: 0; bottom: 0; width: 1px;
}
.ord-hero-lines::before {
  right: 34%;
  background: linear-gradient(to bottom, transparent 0%, rgba(227,30,36,0.35) 25%, rgba(227,30,36,0.15) 70%, transparent 100%);
}
.ord-hero-lines::after {
  left: 52%;
  background: linear-gradient(to bottom, transparent 10%, rgba(59,174,224,0.12) 40%, rgba(59,174,224,0.06) 75%, transparent 100%);
}
.ord-hero-glow {
  position: absolute; z-index: 0; border-radius: 50%; filter: blur(80px); pointer-events: none;
}
.ord-hero-glow-1 {
  width: 600px; height: 600px; top: -200px; right: -80px;
  background: radial-gradient(circle, rgba(20,56,160,0.4) 0%, transparent 65%);
}
.ord-hero-glow-2 {
  width: 350px; height: 350px; bottom: -100px; left: 0;
  background: radial-gradient(circle, rgba(227,30,36,0.12) 0%, transparent 65%);
}
.ord-hero-inner {
  position: relative; z-index: 2;
  width: 100%;
  padding: 2.5rem;
  display: flex; align-items: center; justify-content: space-between;
  gap: 2rem; flex-wrap: wrap;
}
.ord-hero-text { flex: 1; min-width: 260px; }
.ord-hero-eyebrow {
  display: inline-flex; align-items: center; gap: 0.6rem;
  margin-bottom: 1.1rem;
  padding: 0.4rem 1rem 0.4rem 0.55rem;
  border-radius: 99px;
  border: 1px solid rgba(227,30,36,0.3);
  background: rgba(227,30,36,0.07);
  backdrop-filter: blur(10px);
}
.ord-hero-eyebrow-dot {
  width: 22px; height: 22px; border-radius: 50%;
  background: linear-gradient(135deg, var(--red), var(--red-deep));
  display: flex; align-items: center; justify-content: center; flex-shrink: 0;
  box-shadow: 0 4px 12px rgba(227,30,36,0.4);
}
.ord-hero-eyebrow-dot svg { width: 11px; height: 11px; color: #fff; }
.ord-hero-eyebrow span {
  font-size: 0.68rem; font-weight: 800; letter-spacing: 0.12em;
  text-transform: uppercase; color: rgba(255,255,255,0.75);
  padding-right: 0.3rem;
}
.ord-hero h1 {
  font-size: clamp(1.75rem, 3.5vw, 2.4rem);
  font-weight: 900; line-height: 1.05;
  margin: 0 0 0.5rem; color: #fff;
  letter-spacing: -0.03em;
}
.ord-hero p {
  font-size: 0.95rem; color: rgba(255,255,255,0.55); margin: 0;
  font-weight: 400; line-height: 1.6;
}

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
.ord-stats {
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
.o-stat[data-accent="amber"] { --os-accent: var(--amber); }
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
.o-stat-label {
  font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
  letter-spacing: 0.1em; color: var(--text-muted); margin: 0 0 0.4rem;
}
.o-stat-val    { font-size: 1.85rem; font-weight: 900; color: var(--text-primary); line-height: 1; letter-spacing: -0.02em; }
.o-stat-val.green { color: var(--green); }
.o-stat-val.amber { color: var(--amber); }
.o-stat-val-sm { font-size: 1.2rem; font-weight: 900; color: var(--green); line-height: 1.2; letter-spacing: -0.01em; }
.o-stat-sub    { font-size: 0.78rem; color: var(--text-2); margin-top: 0.35rem; }

/* ══════════════════════════════════════════
   ── FILTER CARD (COMPACT REDESIGN) ──
═══════════════════════════════════════════ */
.o-filter-card {
  background: var(--white);
  border: 1px solid var(--border);
  border-radius: 18px;
  padding: 1rem 1.25rem;
  margin-bottom: 1.5rem;
  box-shadow: var(--shadow-xs);
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

/* Filter row: label inline + tabs, two groups side by side */
.o-filter-inline-row {
  display: flex;
  gap: 1rem;
  align-items: flex-start;
  flex-wrap: wrap;
}
.o-filter-inline-group {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  flex-wrap: wrap;
  flex: 1;
  min-width: 0;
}
.o-filter-lbl {
  font-size: 0.68rem; font-weight: 800; color: var(--text-muted);
  text-transform: uppercase; letter-spacing: 0.1em;
  white-space: nowrap; flex-shrink: 0;
}
.o-filter-divider {
  width: 1px;
  align-self: stretch;
  background: var(--border);
  flex-shrink: 0;
}
.o-filter-tabs { display: flex; gap: 4px; flex-wrap: wrap; }
.o-tab {
  padding: 4px 11px; border-radius: 6px; border: 1.5px solid var(--border);
  font-size: 0.75rem; font-weight: 700; color: var(--text-muted);
  text-decoration: none; background: var(--surface);
  transition: all 0.15s; display: inline-block; white-space: nowrap; line-height: 1.6;
}
.o-tab:hover { border-color: var(--navy-900); color: var(--navy-900); background: var(--surface-2); }
.ta-all       { background: var(--navy-900) !important; color: #fff !important; border-color: var(--navy-900) !important; }
.ta-svc       { background: var(--red) !important; color: #fff !important; border-color: var(--red) !important; }
.ta-shipped   { background: #1e40af !important; color: #fff !important; border-color: #1e40af !important; }
.ta-processing{ background: #d97706 !important; color: #fff !important; border-color: #d97706 !important; }
.ta-pending   { background: #0284c7 !important; color: #fff !important; border-color: #0284c7 !important; }
.ta-delivered { background: #16a34a !important; color: #fff !important; border-color: #16a34a !important; }
.ta-cancelled { background: #dc2626 !important; color: #fff !important; border-color: #dc2626 !important; }

/* Search row */
.o-search-row  { display: flex; gap: 0.625rem; align-items: center; flex-wrap: wrap; }
.o-search-wrap { position: relative; flex: 1; min-width: 0; max-width: 400px; }
.o-search-wrap svg {
  position: absolute; left: 10px; top: 50%; transform: translateY(-50%);
  color: var(--text-muted); width: 14px; height: 14px; pointer-events: none;
}
.o-search-wrap input {
  width: 100%; padding: 9px 12px 9px 34px;
  border: 1.5px solid var(--border); border-radius: 8px;
  font-size: 0.84rem; background: var(--surface); color: var(--text-primary);
  font-family: inherit; transition: all 0.2s; box-sizing: border-box;
}
.o-search-wrap input:focus {
  border-color: var(--navy-900); box-shadow: 0 0 0 3px rgba(6,15,46,0.08);
  outline: none; background: var(--white);
}
.o-search-wrap input::placeholder { color: var(--text-muted); }

.o-date-grp { display: flex; gap: 5px; align-items: center; flex-shrink: 0; }
.o-date-grp input[type="date"] {
  padding: 8px 10px; border: 1.5px solid var(--border);
  border-radius: 8px; font-size: 0.78rem;
  background: var(--surface); color: var(--text-primary);
  font-family: inherit; transition: all 0.2s;
}
.o-date-grp input[type="date"]:focus { border-color: var(--navy-900); outline: none; background: var(--white); }
.o-date-sep { font-size: 0.75rem; color: var(--text-muted); white-space: nowrap; }

.btn-search {
  padding: 9px 18px; background: var(--navy-900); color: white;
  border: none; border-radius: 8px; font-weight: 700;
  font-size: 0.84rem; cursor: pointer; transition: all 0.18s;
  font-family: inherit; white-space: nowrap; flex-shrink: 0;
  display: inline-flex; align-items: center; gap: 5px;
}
.btn-search svg { width: 13px; height: 13px; }
.btn-search:hover { background: var(--navy-800); transform: translateY(-1px); }

.btn-reset {
  padding: 9px 14px; background: var(--surface); color: var(--text-2);
  border: 1.5px solid var(--border); border-radius: 8px;
  font-weight: 700; font-size: 0.84rem; cursor: pointer;
  transition: all 0.18s; font-family: inherit; text-decoration: none;
  display: inline-flex; align-items: center; gap: 4px;
  white-space: nowrap; flex-shrink: 0;
}
.btn-reset svg { width: 13px; height: 13px; }
.btn-reset:hover { border-color: var(--red); color: var(--red); }

/* ── TABLE CARD ── */
.o-card {
  background: var(--white); border: 1px solid var(--border);
  border-radius: 18px; overflow: hidden; margin-bottom: 1.5rem;
}
.o-card-header {
  padding: 1.1rem 1.4rem; display: flex; justify-content: space-between; align-items: center;
  border-bottom: 1px solid var(--border); background: var(--surface); flex-wrap: wrap; gap: 0.5rem;
}
.o-card-header-left { display: flex; align-items: center; gap: 0.6rem; }
.o-card-header-icon {
  width: 32px; height: 32px; border-radius: 9px;
  background: rgba(6,15,46,0.06); color: var(--navy-900);
  display: inline-flex; align-items: center; justify-content: center;
}
.o-card-header-icon svg { width: 16px; height: 16px; }
.o-card-header h3 { margin: 0; font-size: 1rem; font-weight: 800; color: var(--text-primary); letter-spacing: -0.01em; }
.o-card-header-meta { font-size: 0.78rem; color: var(--text-muted); font-weight: 600; }

/* ── TABLE ── */
.o-table-wrap { overflow-x: auto; }
.o-tbl { width: 100%; border-collapse: collapse; }
.o-tbl thead tr { background: var(--navy-900); }
.o-tbl th {
  padding: 0.85rem 1rem; font-size: 0.68rem; font-weight: 800;
  color: rgba(255,255,255,0.85); text-align: left;
  letter-spacing: 0.1em; white-space: nowrap;
  border-bottom: 1px solid var(--border);
}
.o-tbl th.center { text-align: center; }
.o-tbl td {
  padding: 0.9rem 1rem; font-size: 0.85rem; color: var(--text-2);
  border-bottom: 1px solid var(--border); vertical-align: middle; font-weight: 500;
}
.o-tbl tr:last-child td { border-bottom: none; }
.o-tbl tbody tr { transition: background 0.15s; }
.o-tbl tbody tr:hover td { background: var(--surface-2); }
.o-tbl tbody tr.row-selected td { background: rgba(6,15,46,0.04) !important; }

/* Checkbox */
.cb-cell { text-align: center; width: 44px; }
.cb-cell input[type="checkbox"] { width: 16px; height: 16px; accent-color: var(--navy-900); cursor: pointer; }
#check-all { accent-color: #fff; }

/* Tracking badge */
.tracking-code {
  font-family: 'JetBrains Mono', 'SF Mono', 'Courier New', monospace;
  font-size: 0.78rem; font-weight: 700;
  background: rgba(6,15,46,0.06); color: var(--navy-900);
  padding: 0.3rem 0.6rem; border-radius: 7px;
  border: 1px solid var(--border); display: inline-block; white-space: nowrap;
}

/* Service badges */
.svc-badge {
  display: inline-block;
  padding: 0.25rem 0.7rem;
  border-radius: 20px;
  font-size: 0.7rem;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.03em;
  border: 1px solid;
}
.svc-PRIORITY    { background: rgba(245,158,11,0.12); border-color: rgba(245,158,11,0.4); color: #92400e; }
.svc-FedEx       { background: rgba(168,85,247,0.1);  border-color: rgba(168,85,247,0.35); color: #6b21a5; }
.svc-REGULER     { background: rgba(59,130,246,0.1);  border-color: rgba(59,130,246,0.3); color: #1e3a8a; }
.svc-US-REGULER  { background: rgba(20,184,166,0.1);  border-color: rgba(20,184,166,0.35); color: #115e59; }
.svc-FAST-ASIAN  { background: rgba(6,182,212,0.1);   border-color: rgba(6,182,212,0.35); color: #155e75; }
.svc-FLASH       { background: rgba(239,68,68,0.1);   border-color: rgba(239,68,68,0.35); color: #991b1b; }
.svc-FLASH-AUSSY { background: rgba(34,197,94,0.1);   border-color: rgba(34,197,94,0.35); color: #166534; }
.svc-badge:not([class*="svc-"]) { background: #f1f5f9; border-color: #cbd5e1; color: #334155; }

/* Status badges */
.st-badge {
  display: inline-flex; align-items: center; gap: 0.35rem;
  padding: 0.3rem 0.7rem; border-radius: 99px; font-size: 0.7rem;
  font-weight: 800; text-transform: uppercase; letter-spacing: 0.04em;
  white-space: nowrap; border: 1px solid;
}
.st-badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
.st-Shipped    { background: rgba(30,64,175,0.08);  color: #1d4ed8; border-color: rgba(30,64,175,0.2); }
.st-Processing { background: rgba(217,119,6,0.1);   color: #b45309; border-color: rgba(217,119,6,0.2); }
.st-Pending    { background: rgba(2,132,199,0.08);  color: #0369a1; border-color: rgba(2,132,199,0.2); }
.st-Delivered  { background: rgba(22,163,74,0.08);  color: #15803d; border-color: rgba(22,163,74,0.2); }
.st-Cancelled  { background: rgba(220,38,38,0.08);  color: #b91c1c; border-color: rgba(220,38,38,0.2); }

/* Action buttons */
.act-btns { display: flex; gap: 5px; align-items: center; flex-wrap: nowrap; }
.btn-sm {
  padding: 5px 10px; font-size: 0.72rem; font-weight: 700;
  border-radius: 7px; display: inline-flex; align-items: center;
  gap: 4px; line-height: 1; justify-content: center;
  text-decoration: none; transition: all 0.18s; border: none; cursor: pointer;
}
.btn-edit-sm      { background: var(--navy-900); color: white; }
.btn-edit-sm:hover { background: var(--navy-800); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(6,15,46,0.3); }
.btn-eye-sm       { background: var(--surface-2); color: var(--text-2); border: 1px solid var(--border); }
.btn-eye-sm:hover { background: var(--border); color: var(--text-primary); }
.btn-delivered-sm { background: rgba(22,163,74,0.1); color: #15803d; border: 1px solid rgba(22,163,74,0.25); }
.btn-delivered-sm:hover { background: #16a34a; color: white; }
.btn-locked-sm    { background: var(--surface-2); color: var(--border-2); border: 1px solid var(--border); cursor: not-allowed; opacity: 0.6; }
.inv-link-btn       { background: var(--red); color: white; }
.inv-link-btn:hover { background: var(--red-hover); transform: translateY(-1px); color: white; }
.inv-link-btn.paid  { background: #16a34a; }
.inv-link-btn.paid:hover { background: #15803d; }
.price-cell { font-weight: 800; color: var(--text-primary); }

/* Empty state */
.o-empty { padding: 3.5rem 1.5rem; text-align: center; color: var(--text-muted); }
.o-empty-icon {
  width: 64px; height: 64px; margin: 0 auto 1rem;
  border-radius: 16px; background: var(--surface-2);
  display: inline-flex; align-items: center; justify-content: center; color: var(--navy-900);
}
.o-empty-icon svg { width: 28px; height: 28px; }
.o-empty h4 { font-size: 1rem; font-weight: 800; color: var(--text-primary); margin: 0 0 0.4rem; }
.o-empty p  { margin: 0; font-size: 0.85rem; }

/* ── BULK TOOLBAR ── */
#bulk-toolbar {
  display: none; position: sticky; bottom: 2rem;
  background: var(--navy-900); color: white;
  border-radius: 14px; padding: 1rem 1.5rem;
  margin-top: 1rem; align-items: center; justify-content: space-between;
  gap: 1rem; flex-wrap: wrap;
  box-shadow: 0 12px 40px rgba(6,15,46,0.35);
  border: 1px solid rgba(255,255,255,0.08); z-index: 100;
}
#bulk-toolbar.visible { display: flex; }
.tb-left { display: flex; align-items: center; gap: 0.75rem; font-size: 0.875rem; font-weight: 600; }
.tb-left svg { width: 18px; height: 18px; }
.tb-count {
  background: rgba(255,255,255,0.12); padding: 3px 12px;
  border-radius: 99px; font-weight: 800;
  border: 1px solid rgba(255,255,255,0.2);
}
.btn-bulk-del {
  display: inline-flex; align-items: center; gap: 6px;
  padding: 8px 18px; border-radius: 9px;
  background: var(--red); color: white; font-size: 0.875rem; font-weight: 700;
  border: none; cursor: pointer; transition: all 0.18s;
}
.btn-bulk-del:hover { background: var(--red-hover); transform: translateY(-1px); }
.btn-bulk-cancel {
  display: inline-flex; align-items: center; gap: 6px;
  padding: 8px 16px; border-radius: 9px;
  background: rgba(255,255,255,0.1); color: white;
  font-size: 0.875rem; font-weight: 700;
  border: 1px solid rgba(255,255,255,0.2); cursor: pointer; transition: all 0.18s;
}
.btn-bulk-cancel:hover { background: rgba(255,255,255,0.2); }

/* ── PAGINATION ── */
.ord-pagination {
  display: flex; justify-content: center; gap: 0.35rem;
  padding: 1rem 1.4rem; border-top: 1px solid var(--border);
  background: var(--surface); flex-wrap: wrap; border-radius: 0 0 18px 18px;
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

/* ── MODAL ── */
.modal-overlay {
  display: none; position: fixed; inset: 0; z-index: 9999;
  background: rgba(6,15,46,0.6); backdrop-filter: blur(4px);
  justify-content: center; align-items: center; padding: 1rem;
}
.modal-overlay.open { display: flex; }
.modal-box {
  background: var(--white); border-radius: 20px;
  width: 100%; max-width: 620px; max-height: 90vh;
  display: flex; flex-direction: column;
  box-shadow: 0 30px 80px -10px rgba(6,15,46,0.4), 0 0 0 1px rgba(255,255,255,0.05);
  border: 1px solid var(--border); overflow: hidden;
  animation: modalIn 0.25s var(--ease-spring) both;
}
.modal-box > form { flex: 1 1 auto; display: flex; flex-direction: column; min-height: 0; overflow: hidden; }
.modal-hdr {
  display: flex; justify-content: space-between; align-items: center;
  padding: 1.25rem 1.5rem;
  background: var(--navy-900);
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
.modal-hdr-close:hover { background: var(--red); border-color: transparent; color: white; }
.modal-body {
  flex: 1 1 auto; overflow-y: auto; min-height: 0;
  padding: 1.375rem 1.5rem;
}
.modal-field { margin-bottom: 1.1rem; }
.modal-field:last-child { margin-bottom: 0; }
.modal-label {
  display: block; font-size: 0.68rem; font-weight: 800;
  color: var(--text-muted); text-transform: uppercase;
  letter-spacing: 0.08em; margin-bottom: 0.4rem;
}
.modal-input, .modal-select {
  width: 100%; padding: 10px 14px; border-radius: 10px;
  border: 1.5px solid var(--border); font-size: 0.875rem;
  background: var(--surface); color: var(--text-primary);
  font-family: inherit; box-sizing: border-box;
  transition: border-color 0.2s, box-shadow 0.2s; outline: none;
}
.modal-input:focus, .modal-select:focus {
  border-color: var(--navy-900); box-shadow: 0 0 0 3px rgba(6,15,46,0.08); background: var(--white);
}
.modal-input[readonly] { background: var(--surface-2); color: var(--text-muted); cursor: not-allowed; }
.modal-input-grid   { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
.modal-input-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; }
.modal-footer {
  padding: 1rem 1.5rem 1.5rem; display: flex; gap: 0.75rem;
  border-top: 1px solid var(--border); background: var(--surface);
}
.btn-modal-cancel {
  flex: 1; padding: 11px;
  background: var(--white); color: var(--text-2);
  border: 1.5px solid var(--border); border-radius: 10px;
  font-weight: 700; font-size: 0.875rem; cursor: pointer;
  font-family: inherit; transition: all 0.18s;
}
.btn-modal-cancel:hover { border-color: var(--navy-900); color: var(--navy-900); }
.btn-modal-save {
  flex: 2; padding: 11px;
  background: var(--navy-900); color: white;
  border: none; border-radius: 10px;
  font-weight: 700; font-size: 0.875rem;
  cursor: pointer; font-family: inherit; transition: all 0.18s;
  display: flex; align-items: center; justify-content: center; gap: 6px;
}
.btn-modal-save:hover { background: var(--navy-800); transform: translateY(-1px); box-shadow: 0 8px 24px rgba(6,15,46,0.3); }
.btn-modal-save svg { width: 15px; height: 15px; }

#reset-price-btn {
  background: var(--surface-2); border: 1.5px solid var(--border);
  border-radius: 10px; padding: 0 16px;
  font-weight: 700; font-size: 0.75rem;
  color: var(--navy-900); cursor: pointer; transition: all 0.2s;
  height: 42px; display: inline-flex; align-items: center; gap: 6px;
}
#reset-price-btn:hover {
  background: var(--red); border-color: var(--red); color: white; transform: translateY(-1px);
}
#reset-price-btn:active { transform: translateY(1px); }

/* Detail grid */
.detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0.875rem; }
.detail-grid .detail-item.full { grid-column: 1 / -1; }
.detail-item-label {
  font-size: 0.68rem; font-weight: 800; color: var(--text-muted);
  text-transform: uppercase; letter-spacing: 0.07em; margin-bottom: 0.3rem;
}
.detail-item-value {
  background: var(--surface); padding: 9px 13px;
  border-radius: 9px; border: 1.5px solid var(--border);
  font-size: 0.875rem; color: var(--text-primary); font-weight: 500;
  min-height: 38px; display: flex; align-items: center;
}
.detail-item-value.mono {
  font-family: 'JetBrains Mono', 'SF Mono', monospace;
  font-size: 0.8rem; color: var(--navy-900);
  background: rgba(6,15,46,0.04); border-color: rgba(6,15,46,0.12);
}

#weight-warning {
  margin-top: 6px; padding: 8px 12px;
  background: rgba(245,158,11,0.08);
  border: 1px solid rgba(245,158,11,0.3);
  border-radius: 8px; color: #b45309; font-size: 0.78rem; font-weight: 600;
}

.section-label-chip {
  display: inline-flex; align-items: center; gap: 0.45rem;
  background: rgba(227,30,36,0.07);
  border: 1px solid rgba(227,30,36,0.14);
  color: var(--red);
  border-radius: 99px;
  padding: 0.35rem 0.9rem;
  font-size: 0.67rem; font-weight: 800;
  letter-spacing: 0.1em; text-transform: uppercase;
  margin-bottom: 0;
}
.section-label-chip svg { width: 10px; height: 10px; }

/* ── RESPONSIVE ── */
@media (max-width: 1200px) { .ord-stats { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 768px) {
  .ord-container { padding: 0 1.25rem; }
  .ord-shell { padding: 1.5rem 0 3rem; }
  .ord-hero-inner { padding: 1.75rem 1.5rem; }
  .ord-stats { grid-template-columns: 1fr 1fr; gap: 1rem; }
  .o-filter-card { padding: 0.875rem 1rem; }
  .o-filter-inline-row { flex-direction: column; gap: 0.625rem; }
  .o-filter-divider { display: none; }
  .modal-input-grid { grid-template-columns: 1fr; }
  .detail-grid { grid-template-columns: 1fr; }
  .detail-grid .detail-item.full { grid-column: 1; }
  .modal-input-grid-3 { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 480px) { .ord-stats { grid-template-columns: 1fr; } }
</style>
@endpush

<div class="ord-shell">
  <div class="ord-container">

    @if(session('success') || session('error'))
    <div id="flash-notif">
      <div class="fn-icon">
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

    {{-- ═══ HERO ═══ --}}
    <section class="ord-hero">
      <div class="ord-hero-canvas"></div>
      <div class="ord-hero-grid"></div>
      <div class="ord-hero-lines"></div>
      <div class="ord-hero-glow ord-hero-glow-1"></div>
      <div class="ord-hero-glow ord-hero-glow-2"></div>
      <div class="ord-hero-inner">
        <div class="ord-hero-text">
          <div class="ord-hero-eyebrow">
            <div class="ord-hero-eyebrow-dot">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 5v3h-7V8z"/>
              </svg>
            </div>
            <span>Admin Dashboard</span>
          </div>
          <h1>Daftar Pengiriman</h1>
          <p>Kelola semua shipment dan buat invoice untuk customer.</p>
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
    <section class="ord-stats">
      <div class="o-stat reveal" data-accent="navy">
        <div class="o-stat-head">
          <div class="o-stat-icon">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
          </div>
          <span class="o-stat-tag">Total</span>
        </div>
        <p class="o-stat-label">Total Pengiriman</p>
        <div class="o-stat-val">{{ number_format($stats['total'] ?? 0) }}</div>
        <div class="o-stat-sub">Semua shipment</div>
      </div>
      <div class="o-stat reveal reveal-d1" data-accent="green">
        <div class="o-stat-head">
          <div class="o-stat-icon">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
          </div>
          <span class="o-stat-tag">IDR</span>
        </div>
        <p class="o-stat-label">Total Pendapatan</p>
        <div class="o-stat-val-sm">Rp {{ number_format($stats['revenue'] ?? 0, 0, ',', '.') }}</div>
        <div class="o-stat-sub">Akumulasi seluruh order</div>
      </div>
      <div class="o-stat reveal reveal-d2" data-accent="amber">
        <div class="o-stat-head">
          <div class="o-stat-icon">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
          </div>
          <span class="o-stat-tag">Pending</span>
        </div>
        <p class="o-stat-label">Menunggu</p>
        <div class="o-stat-val amber">{{ number_format($stats['pending'] ?? 0) }}</div>
        <div class="o-stat-sub">Perlu ditindaklanjuti</div>
      </div>
      <div class="o-stat reveal reveal-d3" data-accent="red">
        <div class="o-stat-head">
          <div class="o-stat-icon">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
          </div>
          <span class="o-stat-tag">Done</span>
        </div>
        <p class="o-stat-label">Selesai</p>
        <div class="o-stat-val green">{{ number_format($stats['delivered'] ?? 0) }}</div>
        <div class="o-stat-sub">Terkirim ke penerima</div>
      </div>
    </section>

    {{-- ═══ FILTER (COMPACT) ═══ --}}
    <div class="o-filter-card reveal">

      {{-- Row 1: Layanan + divider + Status, semua inline --}}
      <div class="o-filter-inline-row">
        <div class="o-filter-inline-group">
          <span class="o-filter-lbl">Layanan</span>
          <div class="o-filter-tabs">
            <a href="{{ route('orders', array_merge(request()->query(), ['service' => 'all', 'page' => 1])) }}"
               class="o-tab {{ request('service', 'all') === 'all' ? 'ta-all' : '' }}">Semua</a>
            @php $services = ['PRIORITY', 'FedEx', 'US REGULER', 'REGULER', 'FAST ASIAN', 'FLASH', 'FLASH AUSSY']; @endphp
            @foreach($services as $svc)
              <a href="{{ route('orders', array_merge(request()->query(), ['service' => $svc, 'page' => 1])) }}"
                 class="o-tab {{ request('service') === $svc ? 'ta-svc' : '' }}">{{ $svc }}</a>
            @endforeach
          </div>
        </div>

        <div class="o-filter-divider"></div>

        <div class="o-filter-inline-group" style="flex: 0 0 auto;">
          <span class="o-filter-lbl">Status</span>
          <div class="o-filter-tabs">
            @foreach(['all' => 'Semua', 'Shipped' => 'Shipped', 'Processing' => 'Processing', 'Pending' => 'Pending', 'Delivered' => 'Delivered', 'Cancelled' => 'Cancelled'] as $val => $label)
              <a href="{{ route('orders', array_merge(request()->query(), ['status' => $val, 'page' => 1])) }}"
                 class="o-tab {{ request('status', 'all') === $val ? 'ta-'.strtolower($val) : '' }}">{{ $label }}</a>
            @endforeach
          </div>
        </div>
      </div>

      {{-- Row 2: Search + Date + Buttons --}}
      <form method="GET" action="{{ route('orders') }}" class="o-search-row">
        <input type="hidden" name="service" value="{{ request('service') }}">
        <input type="hidden" name="status"  value="{{ request('status') }}">

        <div class="o-search-wrap">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
          </svg>
          <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari tracking, negara, pengirim/penerima...">
        </div>

        <div class="o-date-grp">
          <input type="date" name="date_from" value="{{ request('date_from') }}">
          <span class="o-date-sep">—</span>
          <input type="date" name="date_to" value="{{ request('date_to') }}">
        </div>

        <button type="submit" class="btn-search">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
          </svg>
          Cari
        </button>

        @if(request('search') || request('date_from') || request('date_to') || (request('service') && request('service') !== 'all') || (request('status') && request('status') !== 'all'))
          <a href="{{ route('orders') }}" class="btn-reset">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
              <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
              <path d="M3 3v5h5"/>
            </svg>
            Reset
          </a>
        @endif
      </form>

    </div>

    {{-- ═══ TABLE ═══ --}}
    <form method="POST" id="bulk-form" action="{{ route('orders.bulk-delete') }}">
      @csrf
      <input type="hidden" name="bulk_delete" value="1">
      <input type="hidden" name="_service"   value="{{ request('service') }}">
      <input type="hidden" name="_status"    value="{{ request('status') }}">
      <input type="hidden" name="_search"    value="{{ request('search') }}">
      <input type="hidden" name="_date_from" value="{{ request('date_from') }}">
      <input type="hidden" name="_date_to"   value="{{ request('date_to') }}">

      <div class="o-card reveal">
        <div class="o-card-header">
          <div class="o-card-header-left">
            <div class="o-card-header-icon">
              <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
              </svg>
            </div>
            <h3>Pengiriman</h3>
          </div>
          <span class="o-card-header-meta">{{ $shipments->total() }} ditemukan &nbsp;&bull;&nbsp; Hal. {{ $shipments->currentPage() }}/{{ $shipments->lastPage() }}</span>
        </div>

        <div class="o-table-wrap">
          <table class="o-tbl">
            <thead>
              <tr>
                <th class="center" style="width:44px;">
                  <input type="checkbox" id="check-all" style="width:16px;height:16px;">
                </th>
                <th>#</th>
                <th>Tracking No.</th>
                <th>Pengirim</th>
                <th>Penerima</th>
                <th>Negara</th>
                <th>Layanan</th>
                <th>Harga</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Invoice</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($shipments as $s)
                @php
                  $i = ($shipments->currentPage() - 1) * $shipments->perPage() + $loop->iteration;
                  $svcKey = 'svc-' . str_replace(' ', '-', ($s->service ?? 'REGULER'));
                  $stKey  = 'st-' . ($s->status_pengerjaan ?? 'Pending');
                @endphp
                <tr data-id="{{ $s->id }}">
                  <td class="cb-cell">
                    <input type="checkbox" name="selected_ids[]" value="{{ $s->id }}" class="row-cb" style="width:16px;height:16px;">
                  </td>
                  <td style="color:var(--border-2);font-weight:700;">{{ $i }}</td>
                  <td><span class="tracking-code">{{ $s->tracking_number }}</span></td>
                  <td><strong style="color:var(--text-primary);">{{ $s->nama_customer ?? '—' }}</strong></td>
                  <td>{{ $s->nama_penerima ?? '—' }}</td>
                  <td>{{ $s->negara }}</td>
                  <td><span class="svc-badge {{ $svcKey }}">{{ $s->service ?? 'Reguler' }}</span></td>
                  <td><span class="price-cell">Rp {{ number_format($s->charge_idr, 0, ',', '.') }}</span></td>
                  <td><span class="st-badge {{ $stKey }}">{{ $s->status_pengerjaan }}</span></td>
                  <td style="color:var(--text-muted);white-space:nowrap;">{{ date('d M Y', strtotime($s->created_at)) }}</td>
                  <td>
                    @if($s->invoice)
                      @php $isPaid = $s->invoice->status === 'Paid'; @endphp
                      <a href="{{ route('invoice.detail', hashid_encode($s->invoice->id)) }}"
                         class="btn-sm inv-link-btn {{ $isPaid ? 'paid' : '' }}">
                        <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                          <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                          <polyline points="14 2 14 8 20 8"/>
                        </svg>
                      </a>
                    @else
                      <span style="color:var(--border-2);font-size:0.85rem;">—</span>
                    @endif
                  </td>
                  <td style="white-space:nowrap;">
                    <div class="act-btns">
                      @if(strtolower($s->status_pengerjaan) === 'pending')
                        <button type="button" class="btn-sm btn-edit-sm"
                          onclick="openEdit(
                            {{ $s->id }},
                            '{{ addslashes($s->tracking_number) }}',
                            {{ $s->user_id ?? 0 }},
                            '{{ addslashes($s->service) }}',
                            {{ $s->charge_idr }},
                            '{{ addslashes($s->status_pengerjaan) }}',
                            '{{ addslashes($s->negara) }}',
                            {{ $s->berat_fisik ?? 0 }},
                            {{ $s->panjang ?? 0 }},
                            {{ $s->lebar ?? 0 }},
                            {{ $s->tinggi ?? 0 }}
                          )">
                          <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                          </svg>
                        </button>
                      @else
                        <button class="btn-sm btn-locked-sm" disabled title="Status sudah {{ $s->status_pengerjaan }}">
                          <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                          </svg>
                        </button>
                      @endif

                      <button type="button" class="btn-sm btn-eye-sm"
                        onclick="openDetailModal(
                          {{ $s->id }},
                          '{{ addslashes($s->nama_penerima) }}',
                          '{{ addslashes($s->email_penerima ?? '') }}',
                          '{{ addslashes($s->receiver_city ?? '') }}',
                          '{{ addslashes($s->receiver_zip ?? '') }}',
                          '{{ addslashes($s->alamat_penerima ?? '') }}',
                          '{{ addslashes($s->nama_customer ?? '') }}',
                          '{{ addslashes($s->content ?? '') }}',
                          '{{ $s->declare_value_usd ?? 0 }}',
                          '{{ addslashes($s->vat_number ?? '') }}',
                          '{{ addslashes($s->panjang ?? 0) }}',
                          '{{ addslashes($s->lebar ?? 0) }}',
                          '{{ addslashes($s->tinggi ?? 0) }}',
                          '{{ $s->berat_fisik ?? 0 }}',
                          '{{ addslashes($s->volumetrik ?? 0) }}'
                        )">
                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                          <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                          <circle cx="12" cy="12" r="3"/>
                        </svg>
                      </button>

                      @if(!in_array(strtolower($s->status_pengerjaan), ['delivered', 'cancelled']))
                        <button type="button" class="btn-sm btn-delivered-sm"
                          onclick="markDelivered({{ $s->id }})" title="Tandai Delivered">
                          <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <polyline points="20 6 9 17 4 12"/>
                          </svg>
                        </button>
                      @endif
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="12">
                    <div class="o-empty">
                      <div class="o-empty-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                          <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                        </svg>
                      </div>
                      <h4>Tidak ada pengiriman</h4>
                      <p>Coba ubah filter atau kata kunci pencarian.</p>
                    </div>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        {{-- Pagination --}}
        @if($shipments->lastPage() > 1)
        <div class="ord-pagination">
          @if($shipments->currentPage() > 1)
            <a href="{{ $shipments->appends(request()->query())->previousPageUrl() }}" class="pg">&larr;</a>
          @endif
          @for($p = 1; $p <= $shipments->lastPage(); $p++)
            @if($p == $shipments->currentPage())
              <span class="pg active">{{ $p }}</span>
            @elseif($p == 1 || $p == $shipments->lastPage() || abs($p - $shipments->currentPage()) <= 1)
              <a href="{{ $shipments->appends(request()->query())->url($p) }}" class="pg">{{ $p }}</a>
            @elseif(abs($p - $shipments->currentPage()) == 2)
              <span class="pg dots">…</span>
            @endif
          @endfor
          @if($shipments->currentPage() < $shipments->lastPage())
            <a href="{{ $shipments->appends(request()->query())->nextPageUrl() }}" class="pg">&rarr;</a>
          @endif
        </div>
        @endif
      </div>

      {{-- BULK TOOLBAR --}}
      <div id="bulk-toolbar">
        <div class="tb-left">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
          <span id="selected-count" class="tb-count">0</span> pengiriman dipilih
        </div>
        <div style="display:flex;gap:0.75rem;">
          <button type="button" class="btn-bulk-cancel" onclick="clearSelection()">Batal</button>
          <button type="button" class="btn-bulk-del" onclick="confirmBulkDelete()">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <polyline points="3 6 5 6 21 6"/>
              <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
            </svg>
            Hapus yang Dipilih
          </button>
        </div>
      </div>
    </form>

  </div>
</div>

{{-- ═══ MODAL EDIT ═══ --}}
<div id="editModal" class="modal-overlay" onclick="handleOverlayClick(event,'editModal')">
  <div class="modal-box">
    <div class="modal-hdr">
      <h3>
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
          <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
        </svg>
        Edit Shipment
      </h3>
      <button class="modal-hdr-close" onclick="closeModal()">&times;</button>
    </div>
    <form id="editForm" method="POST" action="{{ route('orders.update') }}">
      @csrf
      <input type="hidden" name="id" id="edit_id">
      <div class="modal-body">
        <div class="modal-field">
          <label class="modal-label">Tracking Number</label>
          <input type="text" name="tracking_number" id="edit_tracking" class="modal-input">
        </div>
        <div class="modal-input-grid">
          <div class="modal-field">
            <label class="modal-label">User ID</label>
            <input type="text" name="user_id" id="edit_user" class="modal-input" readonly>
          </div>
          <div class="modal-field">
            <label class="modal-label">Layanan</label>
            <select name="service" id="edit_service" class="modal-select">
              <option value="">Memuat...</option>
            </select>
          </div>
        </div>
        <div class="modal-field">
          <label class="modal-label">Negara Tujuan</label>
          <select name="negara" id="edit_negara" class="modal-select">
            @foreach($countries as $c)
              <option value="{{ $c->country_name }}">{{ $c->country_name }}</option>
            @endforeach
          </select>
        </div>
        <div class="modal-input-grid-3">
          <div class="modal-field">
            <label class="modal-label">Panjang (cm)</label>
            <input type="number" step="0.01" name="panjang" id="edit_panjang" class="modal-input">
          </div>
          <div class="modal-field">
            <label class="modal-label">Lebar (cm)</label>
            <input type="number" step="0.01" name="lebar" id="edit_lebar" class="modal-input">
          </div>
          <div class="modal-field">
            <label class="modal-label">Tinggi (cm)</label>
            <input type="number" step="0.01" name="tinggi" id="edit_tinggi" class="modal-input">
          </div>
        </div>
        <div class="modal-input-grid-3">
          <div class="modal-field">
            <label class="modal-label">Berat Fisik (kg)</label>
            <input type="number" step="0.001" name="berat_fisik" id="edit_berat_fisik" class="modal-input">
          </div>
          <div class="modal-field">
            <label class="modal-label">Berat Volumetrik (kg)</label>
            <input type="text" id="edit_volumetrik" class="modal-input" readonly style="background:#f1f5f9;">
          </div>
          <div class="modal-field">
            <label class="modal-label">Berat Dibebankan (kg)</label>
            <input type="text" id="edit_berat_dibebankan" class="modal-input" readonly style="background:#f1f5f9;">
          </div>
        </div>
        <div class="modal-field">
          <label class="modal-label">Harga (IDR)</label>
          <div style="display:flex; gap:8px; align-items:stretch;">
            <input type="text" name="charge_idr" id="edit_price" class="modal-input" style="flex:1; margin:0;" inputmode="numeric" pattern="[0-9.]*">
            <button type="button" id="reset-price-btn">&#8635; Auto</button>
          </div>
          <div id="weight-warning" style="display:none;"></div>
          <div id="manual-price-indicator" style="display:none;"></div>
        </div>
        <div class="modal-field">
          <label class="modal-label">Status</label>
          <select name="status" id="edit_status" class="modal-select">
            <option value="Pending">Pending</option>
            <option value="Processing">Processing</option>
            <option value="Delivered">Delivered</option>
            <option value="Cancelled">Cancelled</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-modal-cancel" onclick="closeModal()">Batal</button>
        <button type="submit" class="btn-modal-save">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <polyline points="20 6 9 17 4 12"/>
          </svg>
          Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</div>

{{-- ═══ MODAL DETAIL ═══ --}}
<div id="detailModal" class="modal-overlay" onclick="handleOverlayClick(event,'detailModal')">
  <div class="modal-box">
    <div class="modal-hdr">
      <h3>
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
          <circle cx="12" cy="12" r="3"/>
        </svg>
        Detail Pengiriman
      </h3>
      <button class="modal-hdr-close" onclick="closeDetailModal()">&times;</button>
    </div>
    <div class="modal-body">
      <div class="detail-grid">
        <div class="detail-item">
          <div class="detail-item-label">Nama Penerima</div>
          <div id="detail_nama_penerima" class="detail-item-value">-</div>
        </div>
        <div class="detail-item">
          <div class="detail-item-label">Email Penerima</div>
          <div id="detail_email_penerima" class="detail-item-value">-</div>
        </div>
        <div class="detail-item">
          <div class="detail-item-label">Kota</div>
          <div id="detail_kota" class="detail-item-value">-</div>
        </div>
        <div class="detail-item">
          <div class="detail-item-label">Kode Pos</div>
          <div id="detail_kodepos" class="detail-item-value mono">-</div>
        </div>
        <div class="detail-item full">
          <div class="detail-item-label">Alamat Penerima</div>
          <div id="detail_alamat" class="detail-item-value">-</div>
        </div>
        <div class="detail-item">
          <div class="detail-item-label">Nama Pengirim</div>
          <div id="detail_pengirim" class="detail-item-value">-</div>
        </div>
        <div class="detail-item">
          <div class="detail-item-label">Isi Paket</div>
          <div id="detail_isi" class="detail-item-value">-</div>
        </div>
        <div class="detail-item">
          <div class="detail-item-label">Panjang (cm)</div>
          <div id="detail_panjang" class="detail-item-value mono">-</div>
        </div>
        <div class="detail-item">
          <div class="detail-item-label">Lebar (cm)</div>
          <div id="detail_lebar" class="detail-item-value mono">-</div>
        </div>
        <div class="detail-item">
          <div class="detail-item-label">Tinggi (cm)</div>
          <div id="detail_tinggi" class="detail-item-value mono">-</div>
        </div>
        <div class="detail-item">
          <div class="detail-item-label">Berat Fisik (kg)</div>
          <div id="detail_berat_fisik" class="detail-item-value mono">-</div>
        </div>
        <div class="detail-item">
          <div class="detail-item-label">Berat Volumetrik (kg)</div>
          <div id="detail_volumetrik" class="detail-item-value mono">-</div>
        </div>
        <div class="detail-item">
          <div class="detail-item-label">Harga Barang (USD)</div>
          <div id="detail_harga" class="detail-item-value mono">-</div>
        </div>
        <div class="detail-item">
          <div class="detail-item-label">VAT Number</div>
          <div id="detail_vat" class="detail-item-value mono">-</div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn-modal-cancel" onclick="closeDetailModal()">Tutup</button>
    </div>
  </div>
</div>

<script>
// ==================== SCROLL REVEAL ====================
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

function formatPrice(value) {
  if (!value) return '';
  let num = value.toString().replace(/[^0-9]/g, '');
  if (num === '') return '';
  return parseInt(num, 10).toLocaleString('id-ID');
}
function unformatPrice(value) {
  if (!value) return '';
  return value.toString().replace(/\./g, '');
}
function setFormattedPrice(element, rawValue) {
  element.value = formatPrice(rawValue);
}

// ==================== CHECKBOX & BULK ====================
const checkAll = document.getElementById('check-all');
const toolbar  = document.getElementById('bulk-toolbar');
const countEl  = document.getElementById('selected-count');
const rowCbs   = () => document.querySelectorAll('.row-cb');

function updateToolbar() {
  const checked = document.querySelectorAll('.row-cb:checked');
  const n = checked.length;
  countEl.textContent = n;
  toolbar.classList.toggle('visible', n > 0);
  rowCbs().forEach(cb => cb.closest('tr').classList.toggle('row-selected', cb.checked));
  if (checkAll) {
    checkAll.indeterminate = n > 0 && n < rowCbs().length;
    checkAll.checked = n === rowCbs().length && n > 0;
  }
}
if (checkAll) {
  checkAll.addEventListener('change', () => { rowCbs().forEach(cb => cb.checked = checkAll.checked); updateToolbar(); });
}
rowCbs().forEach(cb => cb.addEventListener('change', updateToolbar));

function clearSelection() {
  if (checkAll) checkAll.checked = false;
  rowCbs().forEach(cb => cb.checked = false);
  updateToolbar();
}
function confirmBulkDelete() {
  const n = document.querySelectorAll('.row-cb:checked').length;
  if (confirm(`Hapus ${n} pengiriman? Tindakan ini tidak dapat dibatalkan.`)) {
    document.getElementById('bulk-form').submit();
  }
}
function handleOverlayClick(e, id) {
  if (e.target.id === id) document.getElementById(id).classList.remove('open');
}

// ==================== MODAL EDIT ====================
let isManualPrice = false;
let lastAutoPrice = 0;
let originalService = '';

function updateManualModeUI() {
  const resetBtn   = document.getElementById('reset-price-btn');
  const indicator  = document.getElementById('manual-price-indicator');
  const priceInput = document.getElementById('edit_price');
  if (isManualPrice) {
    if (indicator) indicator.style.display = 'block';
    priceInput.style.backgroundColor = '#FFF9E6';
    resetBtn.style.opacity = '0.7';
  } else {
    if (indicator) indicator.style.display = 'none';
    priceInput.style.backgroundColor = 'var(--surface)';
    resetBtn.style.opacity = '1';
  }
}
function resetToAutoPrice() { isManualPrice = false; updateManualModeUI(); recalculatePrice(); }

function updateWeights() {
  const beratFisik = parseFloat(document.getElementById('edit_berat_fisik').value) || 0;
  const panjang    = parseFloat(document.getElementById('edit_panjang').value) || 0;
  const lebar      = parseFloat(document.getElementById('edit_lebar').value) || 0;
  const tinggi     = parseFloat(document.getElementById('edit_tinggi').value) || 0;
  const service    = document.getElementById('edit_service').value;
  const volumetrik = (panjang * lebar * tinggi) / 5000;
  let beratDibebankan = service === 'REGULER' ? beratFisik : Math.max(beratFisik, volumetrik);
  const volField    = document.getElementById('edit_volumetrik');
  const weightField = document.getElementById('edit_berat_dibebankan');
  if (volField)    volField.value    = volumetrik.toFixed(3);
  if (weightField) weightField.value = beratDibebankan.toFixed(3);
}

function computeCurrentWeight() {
  const beratFisik = parseFloat(document.getElementById('edit_berat_fisik').value) || 0;
  const panjang    = parseFloat(document.getElementById('edit_panjang').value) || 0;
  const lebar      = parseFloat(document.getElementById('edit_lebar').value) || 0;
  const tinggi     = parseFloat(document.getElementById('edit_tinggi').value) || 0;
  const service    = document.getElementById('edit_service').value;
  const volumetrik = (panjang * lebar * tinggi) / 5000;
  return service === 'REGULER' ? beratFisik : Math.max(beratFisik, volumetrik);
}

function recalculatePrice() {
  const service    = document.getElementById('edit_service').value;
  const negara     = document.getElementById('edit_negara').value;
  const berat      = computeCurrentWeight();
  const warning    = document.getElementById('weight-warning');
  const priceInput = document.getElementById('edit_price');
  if (!service || !negara) { if (warning) warning.style.display = 'none'; return; }
  if (berat <= 0) { if (!isManualPrice) priceInput.value = ''; if (warning) warning.style.display = 'none'; return; }
  if (isManualPrice) { if (warning) warning.style.display = 'none'; return; }
  priceInput.disabled = true; priceInput.style.opacity = '0.6';
  fetch('{{ route("orders.calculate-price") }}', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
    body: JSON.stringify({ service, negara, berat })
  })
  .then(r => r.json())
  .then(data => {
    priceInput.disabled = false; priceInput.style.opacity = '1';
    if (data.out_of_range) {
      priceInput.value = '';
      if (warning) {
        warning.textContent = `Berat ${berat.toFixed(2)} kg melebihi maksimum rates (maks: ${data.max_weight} kg).`;
        warning.style.display = 'block';
      }
    } else {
      if (warning) warning.style.display = 'none';
      priceInput.value = data.price ? formatPrice(data.price) : '';
      lastAutoPrice = data.price ?? 0;
    }
  })
  .catch(error => {
    console.error('Gagal hitung harga:', error);
    priceInput.disabled = false; priceInput.style.opacity = '1';
    if (warning) { warning.textContent = 'Gagal mengambil harga dari server.'; warning.style.display = 'block'; }
  });
}

function attachPriceManualListener() {
  const priceInput = document.getElementById('edit_price');
  priceInput.addEventListener('input', function() {
    if (window._suppressManualPrice) return;
    isManualPrice = true; updateManualModeUI();
  });
}

function refreshAvailableServices() {
  const negara         = document.getElementById('edit_negara').value;
  const weight         = computeCurrentWeight();
  const physicalWeight = parseFloat(document.getElementById('edit_berat_fisik').value) || 0;
  if (!negara || weight <= 0) return;
  fetch('{{ route("orders.available-services") }}', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
    body: JSON.stringify({ negara, weight, physical_weight: physicalWeight })
  })
  .then(r => r.json())
  .then(data => {
    const services     = data.services || [];
    const serviceSelect = document.getElementById('edit_service');
    serviceSelect.innerHTML = '';
    if (services.length === 0) {
      const opt = document.createElement('option');
      opt.value = ''; opt.textContent = 'Tidak ada vendor tersedia';
      serviceSelect.appendChild(opt);
    } else {
      services.forEach(svc => {
        const opt = document.createElement('option');
        opt.value = svc; opt.textContent = svc;
        serviceSelect.appendChild(opt);
      });
      if (originalService && services.includes(originalService)) {
        serviceSelect.value = originalService;
      } else if (services.length > 0) {
        serviceSelect.value = services[0];
        if (originalService && originalService !== services[0]) {
          showFlashMessage(`Layanan "${originalService}" tidak tersedia, diganti ke "${services[0]}".`, 'warning');
        }
      }
    }
    updateWeights();
    recalculatePrice();
  })
  .catch(err => console.error('Gagal mengambil daftar vendor', err));
}

function openEdit(id, tracking, user, service, price, status, negara, berat_fisik, panjang, lebar, tinggi) {
  isManualPrice = false; originalService = service; updateManualModeUI();
  window._suppressManualPrice = true;
  document.getElementById('edit_id').value          = id;
  document.getElementById('edit_tracking').value    = tracking;
  document.getElementById('edit_user').value        = user;
  document.getElementById('edit_status').value      = status;
  document.getElementById('edit_negara').value      = negara;
  document.getElementById('edit_berat_fisik').value = berat_fisik;
  document.getElementById('edit_panjang').value     = panjang;
  document.getElementById('edit_lebar').value       = lebar;
  document.getElementById('edit_tinggi').value      = tinggi;
  document.getElementById('edit_price').value       = formatPrice(price);
  window._suppressManualPrice = false;
  updateWeights();
  document.getElementById('editModal').classList.add('open');
  refreshAvailableServices();
}
function closeModal() { document.getElementById('editModal').classList.remove('open'); }

document.addEventListener('DOMContentLoaded', function() {
  const refreshFields = ['edit_negara', 'edit_berat_fisik', 'edit_panjang', 'edit_lebar', 'edit_tinggi'];
  refreshFields.forEach(id => {
    const el = document.getElementById(id);
    if (el) {
      el.addEventListener('input', function() {
        updateWeights();
        if (!isManualPrice) recalculatePrice();
      });
    }
  });
  const serviceSelect = document.getElementById('edit_service');
  if (serviceSelect) {
    serviceSelect.addEventListener('change', function() {
      updateWeights();
      if (isManualPrice) {
        if (confirm('Anda mengubah layanan. Harga manual akan diabaikan. Gunakan harga otomatis?')) {
          resetToAutoPrice();
        }
      } else {
        recalculatePrice();
      }
    });
  }
  attachPriceManualListener();
  const resetBtn = document.getElementById('reset-price-btn');
  if (resetBtn) resetBtn.addEventListener('click', resetToAutoPrice);
});

document.getElementById('edit_price').addEventListener('blur', function() {
  const raw = this.value;
  const unformatted = unformatPrice(raw);
  if (unformatted !== '') this.value = formatPrice(unformatted);
});

document.getElementById('editForm').addEventListener('submit', function(e) {
  const priceInput = document.getElementById('edit_price');
  const rawValue   = priceInput.value;
  priceInput.value = unformatPrice(rawValue);
  e.preventDefault();
  if (!confirm('Simpan perubahan pada shipment ini?')) return;
  const form     = this;
  const formData = new FormData(form);
  const shipmentId = document.getElementById('edit_id').value;
  fetch(form.action, {
    method: 'POST',
    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
    body: formData
  })
  .then(r => r.json())
  .then(res => {
    if (res.success) {
      const row = document.querySelector(`tr[data-id="${shipmentId}"]`);
      if (row) {
        const newTracking = document.getElementById('edit_tracking').value;
        const newService  = document.getElementById('edit_service').value;
        const newNegara   = document.getElementById('edit_negara').value;
        const newPrice    = document.getElementById('edit_price').value;
        const newStatus   = document.getElementById('edit_status').value;
        row.querySelector('td:nth-child(3) .tracking-code').textContent = newTracking;
        const svcCell = row.querySelector('td:nth-child(7) .svc-badge');
        svcCell.textContent = newService;
        svcCell.className = `svc-badge svc-${newService.replace(/ /g,'-')}`;
        row.querySelector('td:nth-child(6)').textContent = newNegara;
        row.querySelector('td:nth-child(8) .price-cell').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(newPrice);
        const stCell = row.querySelector('td:nth-child(9) .st-badge');
        stCell.textContent = newStatus;
        const statusMap = { Pending:'st-Pending', Processing:'st-Processing', Delivered:'st-Delivered', Cancelled:'st-Cancelled', Shipped:'st-Shipped' };
        stCell.className = `st-badge ${statusMap[newStatus] || ''}`;
      }
      closeModal();
      showFlashMessage('Perubahan berhasil disimpan', 'success');
    } else {
      alert('Gagal menyimpan perubahan.');
    }
  })
  .catch(err => { console.error(err); alert('Terjadi kesalahan jaringan.'); });
});

function showFlashMessage(message, type) {
  const old = document.getElementById('flash-notif');
  if (old) old.remove();
  const notif = document.createElement('div');
  notif.id = 'flash-notif';
  notif.innerHTML = `
    <div class="fn-icon">
      <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
        ${type === 'success' ? '<polyline points="20 6 9 17 4 12"/>' : '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>'}
      </svg>
    </div>
    <div class="fn-body">
      <div class="fn-title">${type === 'success' ? 'Berhasil' : 'Peringatan'}</div>
      ${message}
    </div>
    <button class="fn-close" onclick="this.parentElement.remove()">&times;</button>
  `;
  document.body.appendChild(notif);
  setTimeout(() => notif.remove(), 4000);
}

function markDelivered(id) {
  if (!confirm('Tandai pengiriman ini sebagai Delivered?')) return;
  fetch('{{ route("orders.mark-delivered") }}', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
    body: JSON.stringify({ id })
  }).then(r => r.json()).then(data => { if (data.success) location.reload(); else alert('Gagal.'); });
}

function openDetailModal(id, nama_penerima, email, kota, kodepos, alamat, pengirim, isi, harga, vat, panjang, lebar, tinggi, berat_fisik, volumetrik) {
  document.getElementById('detail_nama_penerima').innerText  = nama_penerima || '-';
  document.getElementById('detail_email_penerima').innerText = email         || '-';
  document.getElementById('detail_kota').innerText           = kota          || '-';
  document.getElementById('detail_kodepos').innerText        = kodepos       || '-';
  document.getElementById('detail_alamat').innerText         = alamat        || '-';
  document.getElementById('detail_pengirim').innerText       = pengirim      || '-';
  document.getElementById('detail_isi').innerText            = isi           || '-';
  document.getElementById('detail_harga').innerText          = '$ ' + (parseFloat(harga) || 0).toLocaleString('id-ID');
  document.getElementById('detail_vat').innerText            = vat           || '-';
  document.getElementById('detail_panjang').innerText        = panjang       || '0';
  document.getElementById('detail_lebar').innerText          = lebar         || '0';
  document.getElementById('detail_tinggi').innerText         = tinggi        || '0';
  document.getElementById('detail_berat_fisik').innerText    = (parseFloat(berat_fisik)  || 0).toFixed(2) + ' kg';
  document.getElementById('detail_volumetrik').innerText     = (parseFloat(volumetrik)   || 0).toFixed(2) + ' kg';
  document.getElementById('detailModal').classList.add('open');
}
function closeDetailModal() { document.getElementById('detailModal').classList.remove('open'); }
</script>
@endsection
