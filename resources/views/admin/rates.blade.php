@extends('layouts.app')
@section('title', 'Shipping Rates - Admin Dashboard')
@section('content')
@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300&display=swap');

/* ══ ICE Design System — Rates ══ */
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
@keyframes slideUp {
  from { opacity: 0; transform: translateY(10px); }
  to   { opacity: 1; transform: translateY(0); }
}
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(28px); }
  to   { opacity: 1; transform: translateY(0); }
}

/* ── PAGE SHELL ── */
.rt-shell {
  font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
  background: var(--surface);
  min-height: calc(100vh - 200px);
  padding: 3rem 0 5rem;
}
.rt-container {
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
  background: rgba(22,163,74,0.25); border-radius: 10px;
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
.rt-hero {
  position: relative;
  overflow: hidden;
  border-radius: 24px;
  margin-bottom: 2rem;
  box-shadow: 0 20px 60px rgba(6,15,46,0.30);
  min-height: 190px;
  display: flex;
  align-items: center;
}
.rt-hero-canvas {
  position: absolute; inset: 0; z-index: 0;
  background:
    radial-gradient(ellipse 100% 80% at 100% 0%,  rgba(20,56,160,0.55) 0%, transparent 55%),
    radial-gradient(ellipse 70%  60% at 0%  100%, rgba(227,30,36,0.10) 0%, transparent 50%),
    radial-gradient(ellipse 60%  70% at 55% 50%,  rgba(11,26,74,0.9)   0%, transparent 70%),
    linear-gradient(168deg, var(--navy-900) 0%, #0B1C55 45%, #091640 100%);
}
.rt-hero-canvas::after {
  content: '';
  position: absolute; inset: 0;
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.035'/%3E%3C/svg%3E");
  pointer-events: none; mix-blend-mode: overlay; opacity: 0.5;
}
.rt-hero-grid {
  position: absolute; inset: 0; z-index: 0;
  background-image: radial-gradient(circle, rgba(255,255,255,0.055) 1px, transparent 1px);
  background-size: 44px 44px;
  mask-image: radial-gradient(ellipse 90% 80% at 50% 50%, black 40%, transparent 80%);
}
.rt-hero-lines {
  position: absolute; inset: 0; z-index: 0; overflow: hidden;
}
.rt-hero-lines::before,
.rt-hero-lines::after {
  content: ''; position: absolute; top: 0; bottom: 0; width: 1px;
}
.rt-hero-lines::before {
  right: 34%;
  background: linear-gradient(to bottom, transparent 0%, rgba(227,30,36,0.35) 25%, rgba(227,30,36,0.15) 70%, transparent 100%);
}
.rt-hero-lines::after {
  left: 52%;
  background: linear-gradient(to bottom, transparent 10%, rgba(59,174,224,0.12) 40%, rgba(59,174,224,0.06) 75%, transparent 100%);
}
.rt-hero-glow {
  position: absolute; z-index: 0; border-radius: 50%; filter: blur(80px); pointer-events: none;
}
.rt-hero-glow-1 {
  width: 600px; height: 600px; top: -200px; right: -80px;
  background: radial-gradient(circle, rgba(20,56,160,0.4) 0%, transparent 65%);
}
.rt-hero-glow-2 {
  width: 350px; height: 350px; bottom: -100px; left: 0;
  background: radial-gradient(circle, rgba(227,30,36,0.12) 0%, transparent 65%);
}
.rt-hero-inner {
  position: relative; z-index: 2;
  width: 100%;
  padding: 2.5rem;
  display: flex; align-items: center; justify-content: space-between;
  gap: 2rem; flex-wrap: wrap;
}
.rt-hero-text { flex: 1; min-width: 260px; }
.rt-hero-eyebrow {
  display: inline-flex; align-items: center; gap: 0.6rem;
  margin-bottom: 1.1rem;
  padding: 0.4rem 1rem 0.4rem 0.55rem;
  border-radius: 99px;
  border: 1px solid rgba(227,30,36,0.3);
  background: rgba(227,30,36,0.07);
  backdrop-filter: blur(10px);
}
.rt-hero-eyebrow-dot {
  width: 22px; height: 22px; border-radius: 50%;
  background: linear-gradient(135deg, var(--red), var(--red-deep));
  display: flex; align-items: center; justify-content: center; flex-shrink: 0;
  box-shadow: 0 4px 12px rgba(227,30,36,0.4);
}
.rt-hero-eyebrow-dot svg { width: 11px; height: 11px; color: #fff; }
.rt-hero-eyebrow span {
  font-size: 0.68rem; font-weight: 800; letter-spacing: 0.12em;
  text-transform: uppercase; color: rgba(255,255,255,0.75);
  padding-right: 0.3rem;
}
.rt-hero h1 {
  font-size: clamp(1.75rem, 3.5vw, 2.4rem);
  font-weight: 900; line-height: 1.05;
  margin: 0 0 0.5rem; color: #fff;
  letter-spacing: -0.03em;
}
.rt-hero p {
  font-size: 0.95rem; color: rgba(255,255,255,0.55); margin: 0;
  font-weight: 400; line-height: 1.6;
}
.rt-hero-actions { display: flex; gap: 0.75rem; flex-wrap: wrap; align-items: center; }
.btn-hero-red {
  display: inline-flex; align-items: center; gap: 8px;
  background: var(--red); color: white;
  padding: 0.875rem 1.75rem; border-radius: 10px;
  font-weight: 700; font-size: 0.92rem; text-decoration: none;
  box-shadow: 0 8px 28px rgba(227,30,36,0.4), inset 0 1px 0 rgba(255,255,255,0.12);
  transition: all 0.25s var(--ease-out); border: none; cursor: pointer; flex-shrink: 0;
  white-space: nowrap;
}
.btn-hero-red:hover { background: var(--red-hover); transform: translateY(-2px); box-shadow: 0 14px 36px rgba(227,30,36,0.5); color: white; }
.btn-hero-red svg { width: 16px; height: 16px; flex-shrink: 0; }
.btn-hero-ghost {
  display: inline-flex; align-items: center; gap: 8px;
  background: rgba(255,255,255,0.1); color: white;
  padding: 0.875rem 1.75rem; border-radius: 10px;
  font-weight: 700; font-size: 0.92rem; text-decoration: none;
  border: 1px solid rgba(255,255,255,0.2);
  transition: all 0.25s var(--ease-out); cursor: pointer; flex-shrink: 0;
  white-space: nowrap;
}
.btn-hero-ghost:hover { background: rgba(255,255,255,0.18); transform: translateY(-2px); color: white; }
.btn-hero-ghost svg { width: 16px; height: 16px; }

/* ── STATS ── */
.rt-stats {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 1.25rem; margin-bottom: 2rem;
}
.r-stat {
  background: var(--white); border: 1px solid var(--border); border-radius: 18px;
  padding: 1.4rem; transition: all 0.3s var(--ease-out);
  position: relative; overflow: hidden;
}
.r-stat:hover { transform: translateY(-4px); box-shadow: var(--shadow-lg); border-color: var(--border-2); }
.r-stat::before {
  content: ''; position: absolute; top: 0; left: 0;
  width: 100%; height: 3px;
  background: var(--rs-accent, var(--navy-900));
}
.r-stat[data-accent="amber"]  { --rs-accent: #f59e0b; }
.r-stat[data-accent="purple"] { --rs-accent: #7c3aed; }
.r-stat[data-accent="red"]    { --rs-accent: var(--red); }
.r-stat[data-accent="sky"]    { --rs-accent: #0ea5e9; }
.r-stat[data-accent="navy"]   { --rs-accent: var(--navy-900); }
.r-stat-head {
  display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;
}
.r-stat-icon {
  width: 44px; height: 44px; border-radius: 12px;
  background: color-mix(in srgb, var(--rs-accent) 10%, transparent);
  color: var(--rs-accent);
  display: inline-flex; align-items: center; justify-content: center;
}
.r-stat-icon svg { width: 22px; height: 22px; }
.r-stat-tag {
  font-size: 0.68rem; font-weight: 800; padding: 0.25rem 0.55rem;
  border-radius: 99px;
  background: color-mix(in srgb, var(--rs-accent) 10%, transparent);
  color: var(--rs-accent); text-transform: uppercase; letter-spacing: 0.05em;
}
.r-stat-label { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-muted); margin: 0 0 0.4rem; }
.r-stat-val   { font-size: 1.85rem; font-weight: 900; color: var(--text-primary); line-height: 1; letter-spacing: -0.02em; }
.r-stat-sub   { font-size: 0.78rem; color: var(--text-2); margin-top: 0.35rem; }

/* ── FILTER CARD ── */
.r-filter-card {
  background: var(--white); border: 1px solid var(--border); border-radius: 18px;
  padding: 1.375rem; margin-bottom: 1.5rem;
  box-shadow: var(--shadow-xs);
}
.r-filter-row  { display: flex; flex-wrap: wrap; gap: 1.25rem; align-items: flex-end; }
.r-filter-group { display: flex; flex-direction: column; gap: 0.5rem; flex: 1; min-width: 200px; }
.r-filter-lbl  {
  font-size: 0.68rem; font-weight: 800; color: var(--text-muted);
  text-transform: uppercase; letter-spacing: 0.1em;
}
.r-filter-input {
  padding: 9px 14px; border: 1.5px solid var(--border);
  border-radius: 9px; font-size: 0.875rem;
  background: var(--surface); color: var(--text-primary);
  font-family: inherit; transition: all 0.2s; outline: none;
  box-sizing: border-box; width: 100%;
}
.r-filter-input:focus { border-color: var(--navy-900); box-shadow: 0 0 0 3px rgba(6,15,46,0.08); background: var(--white); }
.r-filter-input::placeholder { color: var(--text-muted); }
.btn-filter {
  padding: 10px 20px; background: var(--navy-900); color: white;
  border: none; border-radius: 9px; font-weight: 700;
  font-size: 0.875rem; cursor: pointer; transition: all 0.18s;
  font-family: inherit; white-space: nowrap;
  display: inline-flex; align-items: center; gap: 6px;
}
.btn-filter:hover { background: var(--navy-800); transform: translateY(-1px); }
.btn-filter svg { width: 14px; height: 14px; }
.btn-reset-filter {
  padding: 10px 16px; background: var(--surface); color: var(--text-2);
  border: 1.5px solid var(--border); border-radius: 9px;
  font-weight: 700; font-size: 0.875rem; cursor: pointer;
  transition: all 0.18s; font-family: inherit; text-decoration: none;
  display: inline-flex; align-items: center; gap: 6px; white-space: nowrap;
}
.btn-reset-filter:hover { border-color: var(--navy-900); color: var(--navy-900); }
.filter-result-bar {
  margin-top: 0.875rem; font-size: 0.8rem; color: var(--text-2);
  font-weight: 600; display: flex; align-items: center; gap: 0.5rem;
  padding-top: 0.875rem; border-top: 1px solid var(--border);
}
.filter-result-bar a { color: var(--text-muted); text-decoration: none; }
.filter-result-bar a:hover { color: var(--red); }

/* ── COUNTRY MANAGEMENT CARD ── */
.r-card {
  background: var(--white); border: 1px solid var(--border);
  border-radius: 18px; overflow: hidden; margin-bottom: 1.5rem;
  box-shadow: var(--shadow-xs);
}
.r-card-header {
  padding: 1rem 1.4rem; display: flex; justify-content: space-between; align-items: center;
  border-bottom: 1px solid var(--border); background: var(--surface); flex-wrap: wrap; gap: 0.5rem;
}
.r-card-header-left { display: flex; align-items: center; gap: 0.6rem; }
.r-card-header-icon {
  width: 32px; height: 32px; border-radius: 9px;
  background: rgba(6,15,46,0.06); color: var(--navy-900);
  display: inline-flex; align-items: center; justify-content: center;
}
.r-card-header-icon svg { width: 16px; height: 16px; }
.r-card-header h3 { margin: 0; font-size: 1rem; font-weight: 800; color: var(--text-primary); letter-spacing: -0.01em; }
.r-card-header-meta { font-size: 0.78rem; color: var(--text-muted); font-weight: 600; }
.r-card-body { padding: 1.375rem; }

/* Country search */
.country-search-input {
  width: 100%; padding: 9px 14px; margin-bottom: 1rem;
  border: 1.5px solid var(--border); border-radius: 9px;
  font-size: 0.875rem; background: var(--surface); color: var(--text-primary);
  font-family: inherit; transition: all 0.2s; outline: none; box-sizing: border-box;
}
.country-search-input:focus { border-color: var(--navy-900); box-shadow: 0 0 0 3px rgba(6,15,46,0.08); background: var(--white); }
.country-search-input::placeholder { color: var(--text-muted); }
.country-grid {
  display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 0.5rem; max-height: 280px; overflow-y: auto; padding-right: 4px;
}
.country-item {
  display: flex; justify-content: space-between; align-items: center;
  padding: 0.55rem 0.875rem; background: var(--surface);
  border: 1px solid var(--border); border-radius: 9px; transition: all 0.18s;
}
.country-item:hover { border-color: var(--border-2); background: var(--surface-2); }
.country-name { font-size: 0.8rem; font-weight: 600; color: var(--text-primary); }
.country-actions { display: flex; gap: 0.35rem; }

/* ── VENDOR TABS ── */
.vendor-tabs-card {
  background: var(--white); border: 1px solid var(--border);
  border-radius: 18px; overflow: hidden;
  box-shadow: var(--shadow-xs);
}
.vendor-tab-nav {
  display: grid;
  border-bottom: 1px solid var(--border);
  background: var(--surface);
}
.vendor-tab-btn {
  display: flex; flex-direction: column; align-items: center; justify-content: center;
  gap: 0.2rem; padding: 1.1rem 1rem;
  background: none; border: none; border-bottom: 3px solid transparent;
  cursor: pointer; font-family: inherit;
  transition: all 0.22s; position: relative;
}
.vendor-tab-btn:not(:last-child) { border-right: 1px solid var(--border); }
.vendor-tab-btn:hover { background: var(--surface-2); }
.vt-label { font-size: 0.9rem; font-weight: 900; color: var(--text-muted); letter-spacing: -0.02em; transition: color 0.2s; }
.vt-sub   { font-size: 0.6rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; }
.vt-count {
  font-size: 0.68rem; font-weight: 700; color: var(--text-muted);
  background: var(--white); border: 1px solid var(--border);
  padding: 0.1rem 0.5rem; border-radius: 20px; transition: all 0.2s;
}

/* Tab active states */
.vendor-tab-btn[data-v="PRIORITY"].active  { border-bottom-color: #f59e0b; background: #fffbeb; }
.vendor-tab-btn[data-v="PRIORITY"].active .vt-label { color: #92400e; }
.vendor-tab-btn[data-v="PRIORITY"].active .vt-count { background: #fef3c7; color: #92400e; border-color: #fcd34d; }
.vendor-tab-btn[data-v="fedex"].active     { border-bottom-color: #7c3aed; background: #f5f3ff; }
.vendor-tab-btn[data-v="fedex"].active .vt-label { color: #4c1d95; }
.vendor-tab-btn[data-v="fedex"].active .vt-count { background: #ede9fe; color: #4c1d95; border-color: #c4b5fd; }
.vendor-tab-btn[data-v="REGULER"].active   { border-bottom-color: var(--red); background: #fff5f5; }
.vendor-tab-btn[data-v="REGULER"].active .vt-label { color: #991b1b; }
.vendor-tab-btn[data-v="REGULER"].active .vt-count { background: #fee2e2; color: #991b1b; border-color: #fca5a5; }
.vendor-tab-btn[data-v="US REGULER"].active { border-bottom-color: var(--navy-900); background: var(--surface-2); }
.vendor-tab-btn[data-v="US REGULER"].active .vt-label { color: var(--navy-900); }
.vendor-tab-btn[data-v="US REGULER"].active .vt-count { background: var(--border); color: var(--navy-900); border-color: var(--border-2); }
.vendor-tab-btn[data-v="FAST ASIAN"].active { border-bottom-color: #0ea5e9; background: #f0f9ff; }
.vendor-tab-btn[data-v="FAST ASIAN"].active .vt-label { color: #0369a1; }
.vendor-tab-btn[data-v="FAST ASIAN"].active .vt-count { background: #e0f2fe; color: #0369a1; border-color: #bae6fd; }
.vendor-panel { display: none; }
.vendor-panel.active { display: block; animation: slideUp 0.25s ease both; }

/* Vendor banner */
.vendor-banner {
  display: flex; align-items: center; justify-content: space-between;
  padding: 1rem 1.4rem; border-bottom: 1px solid var(--border);
  flex-wrap: wrap; gap: 0.75rem; background: var(--surface);
}
.vendor-banner-left { display: flex; align-items: center; gap: 1rem; }
.vendor-pill {
  display: inline-flex; align-items: center;
  padding: 0.35rem 1rem; border-radius: 8px;
  font-weight: 900; font-size: 0.88rem; letter-spacing: -0.01em;
}
.vendor-entry-count {
  font-size: 0.78rem; font-weight: 700; color: var(--text-muted);
  background: var(--white); border: 1px solid var(--border);
  padding: 0.3rem 0.875rem; border-radius: 8px;
}
.vendor-tagline { font-size: 0.8rem; color: var(--text-2); font-weight: 600; }
.vendor-route   { font-size: 0.72rem; color: var(--text-muted); margin-top: 2px; }

/* ── TABLE ── */
.r-table-wrap { overflow-x: auto; }
.r-tbl { width: 100%; border-collapse: collapse; }
.r-tbl thead tr { background: var(--navy-900); }
.r-tbl th {
  padding: 0.85rem 1rem; font-size: 0.68rem; font-weight: 800;
  color: rgba(255,255,255,0.85); text-align: left;
  letter-spacing: 0.1em; white-space: nowrap;
  border-bottom: 1px solid var(--border);
}
.r-tbl td {
  padding: 0.9rem 1rem; font-size: 0.85rem; color: var(--text-2);
  border-bottom: 1px solid var(--border); vertical-align: middle; font-weight: 500;
}
.r-tbl tr:last-child td { border-bottom: none; }
.r-tbl tbody tr { transition: background 0.15s; }
.r-tbl tbody tr:hover td { background: var(--surface-2); }

/* Badges */
.tracking-code {
  font-family: 'JetBrains Mono', 'SF Mono', 'Courier New', monospace;
  font-size: 0.78rem; font-weight: 700;
  background: rgba(6,15,46,0.06); color: var(--navy-900);
  padding: 0.3rem 0.6rem; border-radius: 7px;
  border: 1px solid var(--border); display: inline-block; white-space: nowrap;
}
.chip-origin {
  font-size: 0.8rem; font-weight: 600; color: var(--text-2);
  background: var(--surface); padding: 0.25rem 0.65rem;
  border-radius: 6px; border: 1px solid var(--border);
}
.weight-val {
  font-family: 'JetBrains Mono', 'SF Mono', monospace;
  font-weight: 700; color: var(--navy-900);
}
.price-val  { font-weight: 800; color: #15803d; }
.modal-val  { font-weight: 700; color: #b45309; }

/* Action buttons */
.act-btns { display: flex; gap: 5px; align-items: center; }
.btn-sm {
  padding: 5px 10px; font-size: 0.72rem; font-weight: 700;
  border-radius: 7px; display: inline-flex; align-items: center;
  gap: 4px; line-height: 1; justify-content: center;
  text-decoration: none; transition: all 0.18s; border: none; cursor: pointer;
}
.btn-edit-sm       { background: var(--navy-900); color: white; }
.btn-edit-sm:hover { background: var(--navy-800); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(6,15,46,0.3); color: white; }
.btn-del-sm        { background: rgba(227,30,36,0.08); color: var(--red); border: 1px solid rgba(227,30,36,0.2); }
.btn-del-sm:hover  { background: var(--red); color: white; }
.btn-add-sm        { background: rgba(22,163,74,0.1); color: #15803d; border: 1px solid rgba(22,163,74,0.25); }
.btn-add-sm:hover  { background: #16a34a; color: white; }
.btn-sm svg { width: 12px; height: 12px; }

/* Empty state */
.r-empty { padding: 3.5rem 1.5rem; text-align: center; color: var(--text-muted); }
.r-empty-icon {
  width: 64px; height: 64px; margin: 0 auto 1rem;
  border-radius: 16px; background: var(--surface-2);
  display: inline-flex; align-items: center; justify-content: center; color: var(--navy-900);
}
.r-empty-icon svg { width: 28px; height: 28px; }
.r-empty h4 { font-size: 1rem; font-weight: 800; color: var(--text-primary); margin: 0 0 0.4rem; }
.r-empty p  { margin: 0; font-size: 0.85rem; }

/* ── PAGINATION ── */
.pg-footer {
  display: flex; align-items: center; justify-content: space-between;
  padding: 0.875rem 1.4rem;
  border-top: 1px solid var(--border);
  background: var(--surface);
  flex-wrap: wrap; gap: 0.75rem;
  border-radius: 0 0 18px 18px;
}
.pg-info { font-size: 0.8rem; color: var(--text-muted); font-weight: 600; }
.pg-info strong { color: var(--text-primary); }
.pg-controls { display: flex; align-items: center; gap: 0.35rem; flex-wrap: wrap; }
.pg-btn {
  display: inline-flex; align-items: center; gap: 0.3rem;
  padding: 0.38rem 0.75rem; border-radius: 7px;
  font-size: 0.78rem; font-weight: 700;
  border: 1.5px solid var(--border);
  background: var(--white); color: var(--text-2);
  cursor: pointer; transition: all 0.18s;
  font-family: inherit; line-height: 1;
}
.pg-btn svg { width: 13px; height: 13px; }
.pg-btn:hover:not(:disabled) { border-color: var(--border-2); background: var(--surface-2); color: var(--navy-900); }
.pg-btn:disabled { opacity: 0.4; cursor: not-allowed; }
.pg-num {
  display: inline-flex; align-items: center; justify-content: center;
  width: 30px; height: 30px; border-radius: 7px;
  font-size: 0.78rem; font-weight: 700;
  border: 1.5px solid var(--border);
  background: var(--white); color: var(--text-2);
  cursor: pointer; transition: all 0.18s;
  font-family: inherit;
}
.pg-num:hover { border-color: var(--border-2); background: var(--surface-2); color: var(--navy-900); }
.pg-num.active { background: var(--navy-900); color: #fff; border-color: var(--navy-900); box-shadow: 0 3px 10px rgba(6,15,46,0.25); }

/* ── MODAL ── */
.modal-overlay {
  display: none; position: fixed; inset: 0; z-index: 9999;
  background: rgba(6,15,46,0.6); backdrop-filter: blur(4px);
  justify-content: center; align-items: center; padding: 1rem;
}
.modal-overlay.open { display: flex; }
.modal-box {
  background: var(--white); border-radius: 20px;
  width: 100%; max-width: 480px; max-height: 90vh;
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
.modal-input {
  width: 100%; padding: 10px 14px; border-radius: 10px;
  border: 1.5px solid var(--border); font-size: 0.875rem;
  background: var(--surface); color: var(--text-primary);
  font-family: inherit; box-sizing: border-box;
  transition: border-color 0.2s, box-shadow 0.2s; outline: none;
}
.modal-input:focus { border-color: var(--navy-900); box-shadow: 0 0 0 3px rgba(6,15,46,0.08); background: var(--white); }
.modal-input[readonly] { background: var(--surface-2); color: var(--text-muted); cursor: not-allowed; }
.modal-input-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
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
.btn-modal-save.green-save { background: #16a34a; }
.btn-modal-save.green-save:hover { background: #15803d; box-shadow: 0 8px 24px rgba(22,163,74,0.3); }
.btn-modal-save svg { width: 15px; height: 15px; }

/* ── RESPONSIVE ── */
@media (max-width: 1200px) { .rt-stats { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 768px) {
  .rt-container { padding: 0 1.25rem; }
  .rt-shell { padding: 1.5rem 0 3rem; }
  .rt-hero-inner { padding: 1.75rem 1.5rem; }
  .rt-stats { grid-template-columns: 1fr 1fr; gap: 1rem; }
  .r-filter-row { gap: 0.75rem; }
  .modal-input-grid { grid-template-columns: 1fr; }
  .vt-sub { display: none; }
  .pg-footer { flex-direction: column; align-items: flex-start; }
}
@media (max-width: 480px) { .rt-stats { grid-template-columns: 1fr; } }
</style>
@endpush

<div class="rt-shell">
  <div class="rt-container">

    {{-- ═══ FLASH NOTIF ═══ --}}
    @if(session('success'))
    <div id="flash-notif">
      <div class="fn-icon">
        <svg width="18" height="18" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24">
          <polyline points="20 6 9 17 4 12"/>
        </svg>
      </div>
      <div class="fn-body">
        <div class="fn-title">Berhasil</div>
        {{ session('success') }}
      </div>
      <button class="fn-close" onclick="this.parentElement.remove()">&times;</button>
    </div>
    <script>setTimeout(() => document.getElementById('flash-notif')?.remove(), 5000);</script>
    @endif

    {{-- ═══ HERO ═══ --}}
    <section class="rt-hero">
      <div class="rt-hero-canvas"></div>
      <div class="rt-hero-grid"></div>
      <div class="rt-hero-lines"></div>
      <div class="rt-hero-glow rt-hero-glow-1"></div>
      <div class="rt-hero-glow rt-hero-glow-2"></div>
      <div class="rt-hero-inner">
        <div class="rt-hero-text">
          <div class="rt-hero-eyebrow">
            <div class="rt-hero-eyebrow-dot">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <circle cx="12" cy="12" r="10"/>
                <path d="M2 12h20M12 2a15.3 15.3 0 010 20M12 2a15.3 15.3 0 000 20"/>
              </svg>
            </div>
            <span>Admin Panel</span>
          </div>
          <h1>Shipping Rates</h1>
          <p>Kelola tarif pengiriman per vendor &amp; negara tujuan.</p>
        </div>
        @if(auth()->user()->role === 'dev')
        <div class="rt-hero-actions">
          <button onclick="openModal('addCountryModal')" class="btn-hero-ghost">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
              <circle cx="12" cy="12" r="10"/>
              <path d="M12 8v8M8 12h8"/>
            </svg>
            Tambah Negara
          </button>
          <a href="{{ route('admin.rates.reset') }}" class="btn-hero-red"
             onclick="return confirm('Reset semua rates? Tindakan ini tidak dapat dibatalkan.')">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <polyline points="3 6 5 6 21 6"/>
              <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
              <path d="M10 11v6M14 11v6M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
            </svg>
            Reset Semua
          </a>
        </div>
        @endif
      </div>
    </section>

    {{-- ═══ STATS ═══ --}}
    <section class="rt-stats">
      <div class="r-stat reveal" data-accent="amber">
        <div class="r-stat-head">
          <div class="r-stat-icon">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
            </svg>
          </div>
          <span class="r-stat-tag">Priority</span>
        </div>
        <p class="r-stat-label">PRIORITY Rates</p>
        <div class="r-stat-val">{{ number_format($vendorCounts['PRIORITY'] ?? 0) }}</div>
        <div class="r-stat-sub">Entri tarif express</div>
      </div>
      <div class="r-stat reveal reveal-d1" data-accent="purple">
        <div class="r-stat-head">
          <div class="r-stat-icon">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <rect x="1" y="3" width="15" height="13" rx="1"/>
              <path d="M16 8h4l3 5v3h-7V8z"/>
            </svg>
          </div>
          <span class="r-stat-tag">FedEx</span>
        </div>
        <p class="r-stat-label">FedEx Rates</p>
        <div class="r-stat-val">{{ number_format($vendorCounts['fedex'] ?? 0) }}</div>
        <div class="r-stat-sub">International priority</div>
      </div>
      <div class="r-stat reveal reveal-d2" data-accent="red">
        <div class="r-stat-head">
          <div class="r-stat-icon">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10"/>
              <path d="M2 12h20M12 2a15.3 15.3 0 010 20M12 2a15.3 15.3 0 000 20"/>
            </svg>
          </div>
          <span class="r-stat-tag">Reguler</span>
        </div>
        <p class="r-stat-label">REGULER Rates</p>
        <div class="r-stat-val">{{ number_format($vendorCounts['REGULER'] ?? 0) }}</div>
        <div class="r-stat-sub">Asia Pacific leader</div>
      </div>
      <div class="r-stat reveal reveal-d3" data-accent="sky">
        <div class="r-stat-head">
          <div class="r-stat-icon">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
              <polyline points="9 22 9 12 15 12 15 22"/>
            </svg>
          </div>
          <span class="r-stat-tag">US</span>
        </div>
        <p class="r-stat-label">US REGULER Rates</p>
        <div class="r-stat-val">{{ number_format($vendorCounts['US REGULER'] ?? 0) }}</div>
        <div class="r-stat-sub">United States postal</div>
      </div>
    </section>

    {{-- ═══ COUNTRY MANAGEMENT (dev only) ═══ --}}
    @if(auth()->user()->role === 'dev')
    <div class="r-card reveal">
      <div class="r-card-header">
        <div class="r-card-header-left">
          <div class="r-card-header-icon">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10"/>
              <path d="M2 12h20M12 2a15.3 15.3 0 010 20M12 2a15.3 15.3 0 000 20"/>
            </svg>
          </div>
          <h3>Manajemen Negara</h3>
        </div>
        <span class="r-card-header-meta">{{ $totalCountries }} negara terdaftar</span>
      </div>
      <div class="r-card-body">
        <input type="text" id="countrySearchInput" class="country-search-input"
               placeholder="Cari negara tujuan...">
        <div class="country-grid" id="countryList">
          @foreach($countries as $c)
          <div class="country-item">
            <span class="country-name">{{ $c->country_name }}</span>
            <div class="country-actions">
              <button onclick="openEditCountry({{ $c->id }}, '{{ addslashes($c->country_name) }}')"
                      class="btn-sm btn-edit-sm">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                  <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                  <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4z"/>
                </svg>
                Edit
              </button>
              <button onclick="deleteCountry({{ $c->id }}, '{{ addslashes($c->country_name) }}')"
                      class="btn-sm btn-del-sm">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                  <polyline points="3 6 5 6 21 6"/>
                  <path d="M19 6l-1 14H6L5 6"/>
                  <path d="M10 11v6M14 11v6M9 6V4h6v2"/>
                </svg>
                Hapus
              </button>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
    @endif

    {{-- ═══ FILTER ═══ --}}
    <div class="r-filter-card reveal">
      <form method="GET" action="{{ route('admin.rates') }}">
        <div class="r-filter-row">
          <div class="r-filter-group">
            <span class="r-filter-lbl">Negara Tujuan</span>
            <input type="text" name="search" value="{{ $search }}"
                   class="r-filter-input" placeholder="Ketik nama negara...">
          </div>
          <div style="display:flex; gap:0.5rem; align-items:flex-end;">
            <button type="submit" class="btn-filter">
              <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
              </svg>
              Cari
            </button>
            @if($search)
            <a href="{{ route('admin.rates') }}" class="btn-reset-filter">Reset</a>
            @endif
          </div>
        </div>
        @if($search)
        <div class="filter-result-bar">
          <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
          </svg>
          Hasil untuk: <strong>"{{ $search }}"</strong>
          &mdash; <a href="{{ route('admin.rates') }}">Hapus filter</a>
        </div>
        @endif
      </form>
    </div>

    {{-- ═══ VENDOR TABS ═══ --}}
    <div class="vendor-tabs-card reveal">
      <nav class="vendor-tab-nav" style="grid-template-columns: repeat({{ count($vendorRates) }}, 1fr);">
        @foreach($vendorRates as $vendor => $rates)
        <button class="vendor-tab-btn {{ $loop->first ? 'active' : '' }}"
                data-v="{{ $vendor }}" onclick="switchTab('{{ $vendor }}')">
          <span class="vt-label">{{ $vendor }}</span>
          <span class="vt-sub">
            @php
              $subs = ['PRIORITY' => 'Express', 'fedex' => 'Intl Priority', 'REGULER' => 'Asia Pacific', 'US REGULER' => 'US Postal', 'FAST ASIAN' => 'Fast Asia'];
              echo $subs[$vendor] ?? 'Rates';
            @endphp
          </span>
          <span class="vt-count">{{ number_format($vendorCounts[$vendor] ?? 0) }}</span>
        </button>
        @endforeach
      </nav>

      @foreach($vendorRates as $vendor => $rates)
      @php
        $vendorKey = Str::slug($vendor);
        $pillStyles = [
          'PRIORITY'   => 'background:rgba(245,158,11,0.1);color:#92400e;border:1px solid rgba(245,158,11,0.3);',
          'fedex'      => 'background:rgba(124,58,237,0.1);color:#4c1d95;border:1px solid rgba(124,58,237,0.25);',
          'REGULER'    => 'background:rgba(227,30,36,0.08);color:#991b1b;border:1px solid rgba(227,30,36,0.2);',
          'US REGULER' => 'background:rgba(6,15,46,0.07);color:#060F2E;border:1px solid #DDE6F5;',
          'FAST ASIAN' => 'background:rgba(14,165,233,0.08);color:#0369a1;border:1px solid rgba(14,165,233,0.2);',
        ];
        $taglines = [
          'PRIORITY'   => 'Express Worldwide Delivery',
          'fedex'      => 'International Priority',
          'REGULER'    => 'Asia Pacific Leader',
          'US REGULER' => 'United States Postal Service',
          'FAST ASIAN' => 'Fast Asian Delivery',
        ];
      @endphp
      <div class="vendor-panel {{ $loop->first ? 'active' : '' }}" id="panel-{{ $vendor }}">
        <div class="vendor-banner">
          <div class="vendor-banner-left">
            <span class="vendor-pill" style="{{ $pillStyles[$vendor] ?? '' }}">{{ $vendor }}</span>
            <div>
              <div class="vendor-tagline">{{ $taglines[$vendor] ?? $vendor }}</div>
              <div class="vendor-route">Indonesia &rarr; International</div>
            </div>
          </div>
          <span class="vendor-entry-count" id="banner-count-{{ $vendorKey }}">
            {{ count($rates) }} data
          </span>
        </div>
        <div class="r-table-wrap">
          <table class="r-tbl">
            <thead>
              <tr>
                <th>#</th>
                <th>Asal</th>
                <th>Tujuan</th>
                <th>Berat (kg)</th>
                <th>Harga (IDR)</th>
                <th>Modal (IDR)</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody id="tbody-{{ $vendorKey }}">
              @forelse($rates as $i => $r)
              <tr class="rate-row" data-idx="{{ $i }}">
                <td class="row-num" style="color:var(--border-2);font-weight:700;">{{ $i + 1 }}</td>
                <td><span class="chip-origin">{{ $r->origin_country }}</span></td>
                <td><span class="tracking-code">{{ $r->destination_country }}</span></td>
                <td><span class="weight-val">{{ number_format($r->weight_kg, 2, ',', '.') }} kg</span></td>
                <td class="price-val">Rp {{ number_format($r->price, 0, ',', '.') }}</td>
                <td class="modal-val">Rp {{ number_format($r->modal ?? 0, 0, ',', '.') }}</td>
                @if(auth()->user()->role === 'dev')
                <td>
                  <div class="act-btns">
                    <button onclick="openEditRate('{{ $vendor }}', {{ $r->id }}, {{ $r->weight_kg }}, {{ $r->price }}, {{ $r->modal ?? 0 }}, '{{ addslashes($r->destination_country) }}')"
                            class="btn-sm btn-edit-sm">
                      <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4z"/>
                      </svg>
                      Edit
                    </button>
                  </div>
                </td>
                @else
                <td><span style="color:var(--border-2);font-size:0.75rem;font-weight:500;">—</span></td>
                @endif
              </tr>
              @empty
              <tr>
                <td colspan="7">
                  <div class="r-empty">
                    <div class="r-empty-icon">
                      <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                      </svg>
                    </div>
                    <h4>Belum ada data rates</h4>
                    <p>Coba ubah filter pencarian atau tambah rates untuk vendor ini.</p>
                  </div>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        @if(count($rates) > 0)
        <div class="pg-footer" id="pg-footer-{{ $vendorKey }}">
          <div class="pg-info" id="pg-info-{{ $vendorKey }}"></div>
          <div class="pg-controls" id="pg-controls-{{ $vendorKey }}"></div>
        </div>
        @endif
      </div>
      @endforeach
    </div>

  </div>{{-- /container --}}
</div>{{-- /shell --}}

{{-- ══════════════════ MODAL EDIT RATE ══════════════════ --}}
<div id="editRateModal" class="modal-overlay" onclick="handleOverlayClick(event,'editRateModal')">
  <div class="modal-box">
    <div class="modal-hdr">
      <h3>
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
          <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4z"/>
        </svg>
        Edit Rate
      </h3>
      <button class="modal-hdr-close" onclick="closeModal('editRateModal')">&times;</button>
    </div>
    <form method="POST" action="{{ route('admin.rates.update') }}">
      @csrf
      <input type="hidden" name="vendor"  id="er_vendor">
      <input type="hidden" name="rate_id" id="er_id">
      <div class="modal-body">
        <div class="modal-field">
          <label class="modal-label">Negara Tujuan</label>
          <input type="text" id="er_country" class="modal-input" readonly>
        </div>
        <div class="modal-field">
          <label class="modal-label">Berat (kg)</label>
          <input type="number" name="weight_kg" id="er_weight" step="0.01" min="0"
                 class="modal-input" required>
        </div>
        <div class="modal-input-grid">
          <div class="modal-field">
            <label class="modal-label">Harga / kg (IDR)</label>
            <input type="number" name="price" id="er_price" step="any" min="0"
                   class="modal-input" required>
          </div>
          <div class="modal-field">
            <label class="modal-label">Modal / kg (IDR)</label>
            <input type="number" name="modal" id="er_modal" step="any" min="0"
                   class="modal-input" required>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="closeModal('editRateModal')" class="btn-modal-cancel">Batal</button>
        <button type="submit" class="btn-modal-save">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
            <polyline points="17 21 17 13 7 13 7 21"/>
            <polyline points="7 3 7 8 15 8"/>
          </svg>
          Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</div>

{{-- ══════════════════ MODAL ADD COUNTRY ══════════════════ --}}
<div id="addCountryModal" class="modal-overlay" onclick="handleOverlayClick(event,'addCountryModal')">
  <div class="modal-box">
    <div class="modal-hdr">
      <h3>
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <circle cx="12" cy="12" r="10"/>
          <path d="M12 8v8M8 12h8"/>
        </svg>
        Tambah Negara
      </h3>
      <button class="modal-hdr-close" onclick="closeModal('addCountryModal')">&times;</button>
    </div>
    <form method="POST" action="{{ route('admin.rates.add-country') }}">
      @csrf
      <div class="modal-body">
        <div class="modal-field">
          <label class="modal-label">Nama Negara</label>
          <input type="text" name="country_name" class="modal-input" required
                 placeholder="Contoh: Brazil">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="closeModal('addCountryModal')" class="btn-modal-cancel">Batal</button>
        <button type="submit" class="btn-modal-save green-save">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path d="M12 5v14M5 12h14"/>
          </svg>
          Tambah Negara
        </button>
      </div>
    </form>
  </div>
</div>

{{-- ══════════════════ MODAL EDIT COUNTRY ══════════════════ --}}
<div id="editCountryModal" class="modal-overlay" onclick="handleOverlayClick(event,'editCountryModal')">
  <div class="modal-box">
    <div class="modal-hdr">
      <h3>
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
          <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4z"/>
        </svg>
        Edit Negara
      </h3>
      <button class="modal-hdr-close" onclick="closeModal('editCountryModal')">&times;</button>
    </div>
    <form method="POST" action="{{ route('admin.rates.update-country') }}">
      @csrf
      <input type="hidden" name="country_id" id="ec_id">
      <div class="modal-body">
        <div class="modal-field">
          <label class="modal-label">Nama Negara</label>
          <input type="text" name="country_name" id="ec_name" class="modal-input" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="closeModal('editCountryModal')" class="btn-modal-cancel">Batal</button>
        <button type="submit" class="btn-modal-save">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
            <polyline points="17 21 17 13 7 13 7 21"/>
            <polyline points="7 3 7 8 15 8"/>
          </svg>
          Update Negara
        </button>
      </div>
    </form>
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

/* ── TAB SWITCHER ── */
function switchTab(v) {
  document.querySelectorAll('.vendor-tab-btn').forEach(b => b.classList.remove('active'));
  document.querySelectorAll('.vendor-panel').forEach(p => p.classList.remove('active'));
  document.querySelector(`.vendor-tab-btn[data-v="${v}"]`).classList.add('active');
  document.getElementById(`panel-${v}`).classList.add('active');
}

/* ── MODALS ── */
function openModal(id)  { document.getElementById(id).classList.add('open'); document.body.style.overflow = 'hidden'; }
function closeModal(id) { document.getElementById(id).classList.remove('open'); document.body.style.overflow = ''; }
function handleOverlayClick(e, id) { if (e.target === document.getElementById(id)) closeModal(id); }
document.addEventListener('keydown', e => {
  if (e.key === 'Escape') document.querySelectorAll('.modal-overlay.open').forEach(m => {
    m.classList.remove('open'); document.body.style.overflow = '';
  });
});

function openEditRate(vendor, id, weight, price, modal, country) {
  document.getElementById('er_vendor').value  = vendor;
  document.getElementById('er_id').value      = id;
  document.getElementById('er_weight').value  = weight;
  document.getElementById('er_price').value   = price;
  document.getElementById('er_modal').value   = modal;
  document.getElementById('er_country').value = country;
  openModal('editRateModal');
}
function openEditCountry(id, name) {
  document.getElementById('ec_id').value   = id;
  document.getElementById('ec_name').value = name;
  openModal('editCountryModal');
}
function deleteCountry(id, name) {
  if (!confirm(`Hapus "${name}"? Semua rates terkait juga akan dihapus.`)) return;
  const f = document.createElement('form');
  f.method = 'POST';
  f.action = "{{ route('admin.rates.delete-country') }}";
  f.innerHTML = `<input type="hidden" name="_token" value="{{ csrf_token() }}">
                 <input type="hidden" name="action" value="delete_country">
                 <input type="hidden" name="country_id" value="${id}">`;
  document.body.appendChild(f);
  f.submit();
}

/* ── PAGINATION ── */
const PG_SIZE = 50;
const pgState = {};

function pgInit(slug) {
  const tbody = document.getElementById('tbody-' + slug);
  if (!tbody) return;
  const rows = Array.from(tbody.querySelectorAll('tr.rate-row'));
  if (rows.length === 0) return;
  pgState[slug] = { page: 0, total: rows.length };
  pgRender(slug);
}

function pgRender(slug) {
  const tbody = document.getElementById('tbody-' + slug);
  if (!tbody || !pgState[slug]) return;
  const rows       = Array.from(tbody.querySelectorAll('tr.rate-row'));
  const state      = pgState[slug];
  const totalPages = Math.ceil(state.total / PG_SIZE);
  const start      = state.page * PG_SIZE;
  const end        = Math.min(start + PG_SIZE, state.total);

  rows.forEach((row, i) => {
    row.style.display = (i >= start && i < end) ? '' : 'none';
    const numCell = row.querySelector('.row-num');
    if (numCell) numCell.textContent = i + 1;
  });

  const info = document.getElementById('pg-info-' + slug);
  if (info) info.innerHTML = `Menampilkan <strong>${start + 1}–${end}</strong> dari <strong>${state.total}</strong> data`;

  const ctrl   = document.getElementById('pg-controls-' + slug);
  const footer = document.getElementById('pg-footer-' + slug);
  if (footer) footer.style.display = totalPages <= 1 ? 'none' : 'flex';
  if (!ctrl || totalPages <= 1) return;

  let pages = [];
  if (totalPages <= 7) {
    pages = Array.from({length: totalPages}, (_, i) => i);
  } else {
    const cur = state.page;
    if (cur <= 3)               pages = [0, 1, 2, 3, 4, '…', totalPages - 1];
    else if (cur >= totalPages - 4) pages = [0, '…', totalPages - 5, totalPages - 4, totalPages - 3, totalPages - 2, totalPages - 1];
    else                        pages = [0, '…', cur - 1, cur, cur + 1, '…', totalPages - 1];
  }

  let html = `<button class="pg-btn" onclick="pgGo('${slug}', ${state.page - 1})" ${state.page === 0 ? 'disabled' : ''}>
    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg>Prev
  </button>`;
  pages.forEach(p => {
    if (p === '…') {
      html += `<span style="padding:0 .25rem; color:var(--text-muted); font-size:.85rem; align-self:center;">…</span>`;
    } else {
      html += `<button class="pg-num ${p === state.page ? 'active' : ''}" onclick="pgGo('${slug}', ${p})">${p + 1}</button>`;
    }
  });
  html += `<button class="pg-btn" onclick="pgGo('${slug}', ${state.page + 1})" ${state.page >= totalPages - 1 ? 'disabled' : ''}>
    Next<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg>
  </button>`;
  ctrl.innerHTML = html;
}

function pgGo(slug, page) {
  if (!pgState[slug]) return;
  const totalPages = Math.ceil(pgState[slug].total / PG_SIZE);
  if (page < 0 || page >= totalPages) return;
  pgState[slug].page = page;
  pgRender(slug);
  const panel = document.getElementById('tbody-' + slug);
  if (panel) panel.closest('.vendor-panel').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

/* ── INIT ── */
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('tbody[id^="tbody-"]').forEach(tbody => {
    const slug = tbody.id.replace('tbody-', '');
    pgInit(slug);
  });
  const inp = document.getElementById('countrySearchInput');
  if (inp) {
    inp.addEventListener('input', function () {
      const q = this.value.toUpperCase();
      document.querySelectorAll('#countryList .country-item').forEach(el => {
        el.style.display = el.querySelector('.country-name').textContent.toUpperCase().includes(q) ? '' : 'none';
      });
    });
  }
});
</script>
@endsection
