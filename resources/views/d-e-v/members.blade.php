@extends('layouts.app')
@section('title', 'Kelola Member - Admin Dashboard')
@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300&display=swap');

/* ══ ICE Design System — Members ══ */
:root {
  --red:          #E31E24;
  --red-hover:    #C7181D;
  --red-deep:     #A0121A;
  --navy-900:     #060F2E;
  --navy-800:     #0A1A4A;
  --white:        #FFFFFF;
  --surface:      #FAFBFE;
  --surface-2:    #F1F5FC;
  --border:       #DDE6F5;
  --border-2:     #C8D6EE;
  --text-primary: #09183C;
  --text-2:       #3D5478;
  --text-muted:   #7A93B8;
  --green:        #16A34A;
  --amber:        #f59e0b;
  --amber-dark:   #d97706;
  --purple:       #7c3aed;
  --shadow-xs:    0 1px 4px rgba(9,24,60,0.06);
  --shadow-sm:    0 2px 8px rgba(9,24,60,0.08);
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
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(28px); }
  to   { opacity: 1; transform: translateY(0); }
}

/* ── PAGE SHELL ── */
.mem-shell {
  font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
  background: var(--surface);
  min-height: calc(100vh - 200px);
  padding: 3rem 0 5rem;
}
.mem-container {
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
.mem-hero {
  position: relative;
  overflow: hidden;
  border-radius: 24px;
  margin-bottom: 2rem;
  box-shadow: 0 20px 60px rgba(6,15,46,0.30);
  min-height: 170px;
  display: flex;
  align-items: center;
}
.mem-hero-canvas {
  position: absolute; inset: 0; z-index: 0;
  background:
    radial-gradient(ellipse 100% 80% at 100% 0%,  rgba(20,56,160,0.55) 0%, transparent 55%),
    radial-gradient(ellipse 70%  60% at 0%  100%, rgba(227,30,36,0.10) 0%, transparent 50%),
    radial-gradient(ellipse 60%  70% at 55% 50%,  rgba(11,26,74,0.9)   0%, transparent 70%),
    linear-gradient(168deg, var(--navy-900) 0%, #0B1C55 45%, #091640 100%);
}
.mem-hero-canvas::after {
  content: '';
  position: absolute; inset: 0;
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.035'/%3E%3C/svg%3E");
  pointer-events: none; mix-blend-mode: overlay; opacity: 0.5;
}
.mem-hero-grid {
  position: absolute; inset: 0; z-index: 0;
  background-image: radial-gradient(circle, rgba(255,255,255,0.055) 1px, transparent 1px);
  background-size: 44px 44px;
  mask-image: radial-gradient(ellipse 90% 80% at 50% 50%, black 40%, transparent 80%);
}
.mem-hero-lines {
  position: absolute; inset: 0; z-index: 0; overflow: hidden;
}
.mem-hero-lines::before,
.mem-hero-lines::after {
  content: ''; position: absolute; top: 0; bottom: 0; width: 1px;
}
.mem-hero-lines::before {
  right: 34%;
  background: linear-gradient(to bottom, transparent 0%, rgba(227,30,36,0.35) 25%, rgba(227,30,36,0.15) 70%, transparent 100%);
}
.mem-hero-lines::after {
  left: 52%;
  background: linear-gradient(to bottom, transparent 10%, rgba(59,174,224,0.12) 40%, rgba(59,174,224,0.06) 75%, transparent 100%);
}
.mem-hero-glow {
  position: absolute; z-index: 0; border-radius: 50%; filter: blur(80px); pointer-events: none;
}
.mem-hero-glow-1 {
  width: 600px; height: 600px; top: -200px; right: -80px;
  background: radial-gradient(circle, rgba(20,56,160,0.4) 0%, transparent 65%);
}
.mem-hero-glow-2 {
  width: 350px; height: 350px; bottom: -100px; left: 0;
  background: radial-gradient(circle, rgba(227,30,36,0.12) 0%, transparent 65%);
}
.mem-hero-inner {
  position: relative; z-index: 2;
  width: 100%;
  padding: 2.5rem;
  display: flex; align-items: center; justify-content: space-between;
  gap: 2rem; flex-wrap: wrap;
}
.mem-hero-text { flex: 1; min-width: 260px; }
.mem-hero-eyebrow {
  display: inline-flex; align-items: center; gap: 0.6rem;
  margin-bottom: 1.1rem;
  padding: 0.4rem 1rem 0.4rem 0.55rem;
  border-radius: 99px;
  border: 1px solid rgba(227,30,36,0.3);
  background: rgba(227,30,36,0.07);
  backdrop-filter: blur(10px);
}
.mem-hero-eyebrow-dot {
  width: 22px; height: 22px; border-radius: 50%;
  background: linear-gradient(135deg, var(--red), var(--red-deep));
  display: flex; align-items: center; justify-content: center; flex-shrink: 0;
  box-shadow: 0 4px 12px rgba(227,30,36,0.4);
}
.mem-hero-eyebrow-dot svg { width: 11px; height: 11px; color: #fff; }
.mem-hero-eyebrow span {
  font-size: 0.68rem; font-weight: 800; letter-spacing: 0.12em;
  text-transform: uppercase; color: rgba(255,255,255,0.75);
  padding-right: 0.3rem;
}
.mem-hero h1 {
  font-size: clamp(1.75rem, 3.5vw, 2.4rem);
  font-weight: 900; line-height: 1.05;
  margin: 0 0 0.5rem; color: #fff;
  letter-spacing: -0.03em;
}
.mem-hero p {
  font-size: 0.95rem; color: rgba(255,255,255,0.55); margin: 0;
  font-weight: 400; line-height: 1.6;
}
.btn-add-member {
  display: inline-flex; align-items: center; gap: 8px;
  background: var(--red); color: white;
  padding: 1rem 1.75rem; border-radius: 12px;
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-weight: 700; font-size: 0.92rem; text-decoration: none;
  box-shadow: 0 8px 24px rgba(227,30,36,0.35);
  transition: all 0.2s var(--ease-out); border: none; cursor: pointer; flex-shrink: 0;
}
.btn-add-member:hover {
  background: var(--red-hover); transform: translateY(-2px);
  box-shadow: 0 12px 32px rgba(227,30,36,0.45); color: white;
}
.btn-add-member svg { width: 16px; height: 16px; }

/* ── STATS ── */
.mem-stats {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 1.25rem; margin-bottom: 2rem;
}
.m-stat {
  background: var(--white); border: 1px solid var(--border); border-radius: 18px;
  padding: 1.4rem; transition: all 0.3s var(--ease-out);
  position: relative; overflow: hidden;
}
.m-stat:hover { transform: translateY(-4px); box-shadow: var(--shadow-lg); border-color: var(--border-2); }
.m-stat::before {
  content: ''; position: absolute; top: 0; left: 0;
  width: 100%; height: 3px;
  background: var(--ms-accent, var(--navy-900));
}
.m-stat[data-accent="navy"]   { --ms-accent: var(--navy-900); }
.m-stat[data-accent="amber"]  { --ms-accent: var(--amber); }
.m-stat[data-accent="purple"] { --ms-accent: var(--purple); }
.m-stat[data-accent="green"]  { --ms-accent: var(--green); }
.m-stat-head {
  display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;
}
.m-stat-icon {
  width: 44px; height: 44px; border-radius: 12px;
  background: color-mix(in srgb, var(--ms-accent) 10%, transparent);
  color: var(--ms-accent);
  display: inline-flex; align-items: center; justify-content: center;
}
.m-stat-icon svg { width: 22px; height: 22px; }
.m-stat-tag {
  font-size: 0.68rem; font-weight: 800; padding: 0.25rem 0.55rem;
  border-radius: 99px;
  background: color-mix(in srgb, var(--ms-accent) 10%, transparent);
  color: var(--ms-accent); text-transform: uppercase; letter-spacing: 0.05em;
}
.m-stat-label {
  font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
  letter-spacing: 0.1em; color: var(--text-muted); margin: 0 0 0.4rem;
}
.m-stat-val          { font-size: 1.85rem; font-weight: 900; color: var(--text-primary); line-height: 1; letter-spacing: -0.02em; }
.m-stat-val.amber    { color: var(--amber-dark); }
.m-stat-val.purple   { color: var(--purple); }
.m-stat-val.green    { color: var(--green); }

/* ── FILTER CARD ── */
.m-filter-card {
  background: var(--white); border: 1px solid var(--border); border-radius: 16px;
  padding: 1.375rem; margin-bottom: 1.5rem;
  box-shadow: var(--shadow-xs);
}
.m-filter-lbl {
  font-size: 0.68rem; font-weight: 800; color: var(--text-muted);
  text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.6rem; display: block;
}
.m-filter-tabs { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 1.25rem; }
.m-tab {
  padding: 6px 16px; border-radius: 8px; border: 1.5px solid var(--border);
  font-size: 0.8rem; font-weight: 700; color: var(--text-muted);
  text-decoration: none; background: var(--surface);
  transition: all 0.18s; display: inline-block; white-space: nowrap; cursor: pointer;
}
.m-tab:hover { border-color: var(--navy-900); color: var(--navy-900); background: var(--surface-2); }
.mt-all    { background: var(--navy-900) !important; color: #fff !important; border-color: var(--navy-900) !important; }
.mt-user   { background: #475569 !important; color: #fff !important; border-color: #475569 !important; }
.mt-admin  { background: #1d4ed8 !important; color: #fff !important; border-color: #1d4ed8 !important; }
.mt-dev    { background: var(--purple)    !important; color: #fff !important; border-color: var(--purple) !important; }
.mt-owner  { background: var(--amber-dark) !important; color: #fff !important; border-color: var(--amber-dark) !important; }

.m-search-row  { display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap; }
.m-search-wrap { position: relative; flex: 1; min-width: 0; max-width: 420px; }
.m-search-wrap svg { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); width: 15px; height: 15px; pointer-events: none; }
.m-search-wrap input {
  width: 100%; padding: 10px 14px 10px 38px;
  border: 1.5px solid var(--border); border-radius: 9px;
  font-size: 0.875rem; background: var(--surface); color: var(--text-primary);
  font-family: inherit; transition: all 0.2s; box-sizing: border-box;
}
.m-search-wrap input:focus { border-color: var(--navy-900); box-shadow: 0 0 0 3px rgba(6,15,46,0.08); outline: none; background: var(--white); }
.m-search-wrap input::placeholder { color: var(--text-muted); }
.btn-m-reset {
  padding: 10px 16px; background: var(--surface); color: var(--text-2);
  border: 1.5px solid var(--border); border-radius: 9px;
  font-weight: 700; font-size: 0.875rem; cursor: pointer;
  transition: all 0.18s; font-family: inherit; text-decoration: none;
  display: inline-flex; align-items: center; white-space: nowrap; flex-shrink: 0;
}
.btn-m-reset:hover { border-color: var(--navy-900); color: var(--navy-900); }

/* ── TABLE CARD ── */
.m-card {
  background: var(--white); border: 1px solid var(--border);
  border-radius: 18px; overflow: hidden; margin-bottom: 1.5rem;
}
.m-card-header {
  padding: 1.1rem 1.4rem; display: flex; justify-content: space-between; align-items: center;
  border-bottom: 1px solid var(--border); background: var(--surface); flex-wrap: wrap; gap: 0.5rem;
}
.m-card-header-left { display: flex; align-items: center; gap: 0.6rem; }
.m-card-header-icon {
  width: 32px; height: 32px; border-radius: 9px;
  background: rgba(6,15,46,0.06); color: var(--navy-900);
  display: inline-flex; align-items: center; justify-content: center;
}
.m-card-header-icon svg { width: 16px; height: 16px; }
.m-card-header h3 { margin: 0; font-size: 1rem; font-weight: 800; color: var(--text-primary); letter-spacing: -0.01em; }
.m-card-header-meta { font-size: 0.78rem; color: var(--text-muted); font-weight: 600; }

/* ── TABLE ── */
.m-table-wrap { overflow-x: auto; }
.m-tbl { width: 100%; border-collapse: collapse; }
.m-tbl thead tr { background: var(--navy-900); }
.m-tbl th {
  padding: 0.85rem 1rem; font-size: 0.68rem; font-weight: 800;
  color: rgba(255,255,255,0.85); text-align: left;
  letter-spacing: 0.1em; white-space: nowrap;
}
.m-tbl th.center { text-align: center; }
.m-tbl td {
  padding: 0.9rem 1rem; font-size: 0.85rem; color: var(--text-2);
  border-bottom: 1px solid var(--border); vertical-align: middle; font-weight: 500;
}
.m-tbl tr:last-child td { border-bottom: none; }
.m-tbl tbody tr { transition: background 0.15s; }
.m-tbl tbody tr:hover td { background: var(--surface-2); }
.m-tbl tbody tr.row-selected td { background: rgba(6,15,46,0.04) !important; }

/* Checkbox */
.cb-cell { text-align: center; width: 44px; }
.cb-cell input[type="checkbox"] { width: 16px; height: 16px; accent-color: var(--navy-900); cursor: pointer; }
#check-all { accent-color: #fff; }

/* Member avatar */
.mem-avatar {
  width: 38px; height: 38px; border-radius: 50%;
  background: linear-gradient(135deg, var(--navy-900), #1e3a8a);
  color: white; font-size: 0.8rem; font-weight: 800;
  display: inline-flex; align-items: center; justify-content: center;
  flex-shrink: 0; box-shadow: 0 2px 6px rgba(6,15,46,0.2);
}
.mem-name-badge {
  font-size: 0.6rem; background: rgba(6,15,46,0.08); color: var(--navy-900);
  padding: 2px 7px; border-radius: 5px; font-weight: 700;
}

/* Role pills */
.role-pill {
  display: inline-flex; align-items: center; gap: 5px;
  padding: 0.3rem 0.7rem; border-radius: 99px; font-size: 0.7rem;
  font-weight: 800; text-transform: uppercase; letter-spacing: 0.04em;
  white-space: nowrap; border: 1px solid;
}
.role-pill::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
.rp-owner { background: rgba(253,230,138,0.4); color: #92400e; border-color: rgba(245,158,11,0.3); }
.rp-admin { background: rgba(219,234,254,0.6); color: #1d4ed8; border-color: rgba(59,130,246,0.25); }
.rp-dev   { background: rgba(237,233,254,0.6); color: #6d28d9; border-color: rgba(139,92,246,0.25); }
.rp-user  { background: rgba(241,245,252,0.8); color: #475569; border-color: rgba(71,85,105,0.15); }

/* Action buttons */
.act-btns { display: flex; gap: 5px; align-items: center; flex-wrap: nowrap; }
.btn-sm {
  padding: 5px 10px; font-size: 0.72rem; font-weight: 700;
  border-radius: 7px; display: inline-flex; align-items: center;
  gap: 4px; line-height: 1; justify-content: center;
  text-decoration: none; transition: all 0.18s; border: none; cursor: pointer;
}
.btn-sm svg { width: 11px; height: 11px; }
.btn-edit-sm       { background: var(--navy-900); color: white; border: none; }
.btn-edit-sm:hover { background: var(--navy-800); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(6,15,46,0.3); }
.btn-del-sm        { background: rgba(227,30,36,0.06); color: #b91c1c; border: 1px solid rgba(227,30,36,0.2); }
.btn-del-sm:hover  { background: var(--red); color: white; border-color: var(--red); transform: translateY(-1px); }

/* Empty state */
.m-empty { padding: 3.5rem 1.5rem; text-align: center; color: var(--text-muted); }
.m-empty-icon {
  width: 64px; height: 64px; margin: 0 auto 1rem;
  border-radius: 16px; background: var(--surface-2);
  display: inline-flex; align-items: center; justify-content: center; color: var(--navy-900);
}
.m-empty-icon svg { width: 28px; height: 28px; }
.m-empty h4 { font-size: 1rem; font-weight: 800; color: var(--text-primary); margin: 0 0 0.4rem; }
.m-empty p  { margin: 0; font-size: 0.85rem; }

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
.mem-pagination {
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
  width: 100%; max-width: 580px; max-height: 90vh;
  display: flex; flex-direction: column;
  box-shadow: 0 30px 80px -10px rgba(6,15,46,0.4), 0 0 0 1px rgba(255,255,255,0.05);
  border: 1px solid var(--border); overflow: hidden;
  animation: modalIn 0.25s cubic-bezier(0.34,1.2,0.64,1) both;
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
.modal-input-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
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
.modal-pw-hint { font-weight: 400; color: var(--border-2); text-transform: none; letter-spacing: 0; }
.modal-err {
  display: flex; align-items: center; gap: 0.75rem;
  padding: 0.75rem 1rem; border-radius: 10px; margin-bottom: 1rem;
  background: rgba(227,30,36,0.06); border: 1px solid rgba(227,30,36,0.2); color: #b91c1c;
  font-size: 0.875rem; font-weight: 600;
}
.modal-err svg { width: 16px; height: 16px; flex-shrink: 0; }
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

/* ── RESPONSIVE ── */
@media (max-width: 1200px) { .mem-stats { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 768px) {
  .mem-container { padding: 0 1.25rem; }
  .mem-shell { padding: 1.5rem 0 3rem; }
  .mem-hero-inner { padding: 1.75rem 1.5rem; }
  .mem-stats { grid-template-columns: 1fr 1fr; gap: 1rem; }
  .modal-input-grid { grid-template-columns: 1fr; }
}
@media (max-width: 480px) { .mem-stats { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')

{{-- ═══ FLASH NOTIF ═══ --}}
@if(session('flash_members'))
<div id="flash-notif">
  <div class="fn-icon">
    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
      <polyline points="20 6 9 17 4 12"/>
    </svg>
  </div>
  <div class="fn-body">
    <div class="fn-title">Berhasil</div>
    {{ session('flash_members') }}
  </div>
  <button class="fn-close" onclick="this.parentElement.remove()">&times;</button>
</div>
<script>setTimeout(() => document.getElementById('flash-notif')?.remove(), 4500);</script>
@endif

<div class="mem-shell">
  <div class="mem-container">

    {{-- ═══ HERO ═══ --}}
    <section class="mem-hero">
      <div class="mem-hero-canvas"></div>
      <div class="mem-hero-grid"></div>
      <div class="mem-hero-lines"></div>
      <div class="mem-hero-glow mem-hero-glow-1"></div>
      <div class="mem-hero-glow mem-hero-glow-2"></div>
      <div class="mem-hero-inner">
        <div class="mem-hero-text">
          <div class="mem-hero-eyebrow">
            <div class="mem-hero-eyebrow-dot">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
              </svg>
            </div>
            <span>Admin Dashboard</span>
          </div>
          <h1>Kelola Member</h1>
          <p>Manajemen akun pengguna dan hak akses sistem.</p>
        </div>
        <button class="btn-add-member" onclick="openMemberModal()">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path d="M5 12h14"/><path d="M12 5v14"/>
          </svg>
          Tambah Member
        </button>
      </div>
    </section>

    {{-- ═══ STATS ═══ --}}
    <section class="mem-stats">
      <div class="m-stat reveal" data-accent="navy">
        <div class="m-stat-head">
          <div class="m-stat-icon">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
              <circle cx="9" cy="7" r="4"/>
              <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
          </div>
          <span class="m-stat-tag">All</span>
        </div>
        <p class="m-stat-label">Total Member</p>
        <div class="m-stat-val">{{ number_format($stats['total'] ?? 0) }}</div>
      </div>

      <div class="m-stat reveal reveal-d1" data-accent="amber">
        <div class="m-stat-head">
          <div class="m-stat-icon">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
          </div>
          <span class="m-stat-tag">Admin</span>
        </div>
        <p class="m-stat-label">Admin</p>
        <div class="m-stat-val amber">{{ number_format($stats['admins'] ?? 0) }}</div>
      </div>

      <div class="m-stat reveal reveal-d2" data-accent="purple">
        <div class="m-stat-head">
          <div class="m-stat-icon">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <polyline points="16 18 22 12 16 6"/>
              <polyline points="8 6 2 12 8 18"/>
            </svg>
          </div>
          <span class="m-stat-tag">Dev</span>
        </div>
        <p class="m-stat-label">Developer</p>
        <div class="m-stat-val purple">{{ number_format($stats['devs'] ?? 0) }}</div>
      </div>

      <div class="m-stat reveal reveal-d3" data-accent="green">
        <div class="m-stat-head">
          <div class="m-stat-icon">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
              <circle cx="12" cy="7" r="4"/>
            </svg>
          </div>
          <span class="m-stat-tag">User</span>
        </div>
        <p class="m-stat-label">User</p>
        <div class="m-stat-val green">{{ number_format($stats['users_count'] ?? 0) }}</div>
      </div>
    </section>

    {{-- ═══ FILTER CARD ═══ --}}
    <div class="m-filter-card reveal">
      <span class="m-filter-lbl">Filter Role</span>
      <div class="m-filter-tabs">
        <a href="{{ route('d-e-v.members', array_merge(request()->query(), ['role' => '', 'page' => 1])) }}"
           class="m-tab {{ !request('role') ? 'mt-all' : '' }}">Semua</a>
        <a href="{{ route('d-e-v.members', array_merge(request()->query(), ['role' => 'user', 'page' => 1])) }}"
           class="m-tab {{ request('role') === 'user' ? 'mt-user' : '' }}">User</a>
        <a href="{{ route('d-e-v.members', array_merge(request()->query(), ['role' => 'admin', 'page' => 1])) }}"
           class="m-tab {{ request('role') === 'admin' ? 'mt-admin' : '' }}">Admin</a>
        <a href="{{ route('d-e-v.members', array_merge(request()->query(), ['role' => 'dev', 'page' => 1])) }}"
           class="m-tab {{ request('role') === 'dev' ? 'mt-dev' : '' }}">Developer</a>
        <a href="{{ route('d-e-v.members', array_merge(request()->query(), ['role' => 'owner', 'page' => 1])) }}"
           class="m-tab {{ request('role') === 'owner' ? 'mt-owner' : '' }}">Owner</a>
      </div>
      <form method="GET" action="{{ route('d-e-v.members') }}" class="m-search-row">
        <input type="hidden" name="role" value="{{ request('role') }}">
        <div class="m-search-wrap">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
          </svg>
          <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau email...">
        </div>
        @if(request('q') || request('role'))
          <a href="{{ route('d-e-v.members') }}" class="btn-m-reset">Reset</a>
        @endif
      </form>
    </div>

    {{-- ═══ BULK FORM + TABLE ═══ --}}
    <form method="POST" id="bulk-form" action="{{ route('admin.members.bulk-delete') }}">
      @csrf
      <input type="hidden" name="bulk_delete" value="1">

      <div class="m-card reveal">
        <div class="m-card-header">
          <div class="m-card-header-left">
            <div class="m-card-header-icon">
              <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
              </svg>
            </div>
            <h3>Daftar Member</h3>
          </div>
          <span class="m-card-header-meta">
            {{ $users->total() }} member &nbsp;&bull;&nbsp; Hal. {{ $users->currentPage() }}/{{ $users->lastPage() }}
          </span>
        </div>

        <div class="m-table-wrap">
          <table class="m-tbl">
            <thead>
              <tr>
                <th class="center" style="width:44px;">
                  <input type="checkbox" id="check-all" style="width:16px;height:16px;">
                </th>
                <th>#</th>
                <th>Member</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($users as $index => $user)
                @php $isMe = ($user->id == auth()->id()); @endphp
                <tr data-id="{{ $user->id }}">
                  <td class="cb-cell">
                    @if(!$isMe)
                      <input type="checkbox" name="selected_ids[]" value="{{ $user->id }}" class="row-cb" style="width:16px;height:16px;">
                    @endif
                  </td>
                  <td style="color:var(--border-2);font-weight:700;">{{ $users->firstItem() + $index }}</td>
                  <td>
                    <div style="display:flex;align-items:center;gap:12px;">
                      <div class="mem-avatar">{{ strtoupper(mb_substr($user->name, 0, 2)) }}</div>
                      <div>
                        <div style="font-weight:700;color:var(--text-primary);display:flex;align-items:center;gap:6px;">
                          {{ e($user->name) }}
                          @if($isMe)
                            <span class="mem-name-badge">Anda</span>
                          @endif
                        </div>
                        <div style="font-size:0.75rem;color:var(--text-muted);">ID #{{ $user->id }}</div>
                      </div>
                    </div>
                  </td>
                  <td>{{ e($user->email) }}</td>
                  <td>
                    @php
                      $roleClass = match($user->role) {
                        'owner' => 'rp-owner',
                        'admin' => 'rp-admin',
                        'dev'   => 'rp-dev',
                        default => 'rp-user'
                      };
                    @endphp
                    <span class="role-pill {{ $roleClass }}">{{ ucfirst($user->role ?? 'user') }}</span>
                  </td>
                  <td style="white-space:nowrap;">
                    <div class="act-btns">
                      <button type="button" class="btn-sm btn-edit-sm"
                        onclick="openMemberModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}', '{{ $user->role ?? 'user' }}')">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                          <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                          <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                        Edit
                      </button>
                      @if(!$isMe)
                        <a href="{{ route('admin.members.delete', $user->id) }}"
                           class="btn-sm btn-del-sm"
                           onclick="return confirm('Hapus member {{ addslashes($user->name) }}? Tindakan ini tidak bisa dibatalkan.')">
                          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <polyline points="3 6 5 6 21 6"/>
                            <path d="M19 6l-1 14H6L5 6"/>
                            <path d="M10 11v6M14 11v6"/>
                            <path d="M9 6V4h6v2"/>
                          </svg>
                          Hapus
                        </a>
                      @endif
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6">
                    <div class="m-empty">
                      <div class="m-empty-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                          <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                          <circle cx="9" cy="7" r="4"/>
                          <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                          <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                      </div>
                      <h4>Tidak ada member ditemukan</h4>
                      <p>Coba ubah filter atau kata kunci pencarian.</p>
                    </div>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        {{-- Pagination --}}
        @if($users->lastPage() > 1)
        <div class="mem-pagination">
          @if($users->currentPage() > 1)
            <a href="{{ $users->appends(request()->query())->previousPageUrl() }}" class="pg">&larr;</a>
          @endif
          @for($p = 1; $p <= $users->lastPage(); $p++)
            @if($p == $users->currentPage())
              <span class="pg active">{{ $p }}</span>
            @elseif($p == 1 || $p == $users->lastPage() || abs($p - $users->currentPage()) <= 1)
              <a href="{{ $users->appends(request()->query())->url($p) }}" class="pg">{{ $p }}</a>
            @elseif(abs($p - $users->currentPage()) == 2)
              <span class="pg dots">…</span>
            @endif
          @endfor
          @if($users->currentPage() < $users->lastPage())
            <a href="{{ $users->appends(request()->query())->nextPageUrl() }}" class="pg">&rarr;</a>
          @endif
        </div>
        @endif
      </div>

      {{-- ─ BULK TOOLBAR ─ --}}
      <div id="bulk-toolbar">
        <div class="tb-left">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
          </svg>
          <span id="selected-count" class="tb-count">0</span> member dipilih
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

  </div>{{-- /container --}}
</div>{{-- /shell --}}

{{-- ══════════════════ MODAL MEMBER ══════════════════ --}}
<div id="memberModal" class="modal-overlay" onclick="handleOverlayClick(event)">
  <div class="modal-box">
    <div class="modal-hdr">
      <h3 id="modal-title">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
          <circle cx="8.5" cy="7" r="4"/>
          <line x1="20" y1="8" x2="20" y2="14"/>
          <line x1="23" y1="11" x2="17" y2="11"/>
        </svg>
        Tambah Member Baru
      </h3>
      <button class="modal-hdr-close" onclick="closeMemberModal()">&times;</button>
    </div>
    <form id="memberForm" method="POST" action="{{ route('admin.members.save') }}">
      @csrf
      <input type="hidden" name="edit_id" id="modal-edit-id" value="0">
      <div class="modal-body">
        @if($errors->any())
        <div class="modal-err">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="8" x2="12" y2="12"/>
            <line x1="12" y1="16" x2="12.01" y2="16"/>
          </svg>
          {{ $errors->first() }}
        </div>
        @endif
        <div class="modal-input-grid">
          <div class="modal-field">
            <label class="modal-label">Nama Lengkap</label>
            <input type="text" name="name" id="modal-name" class="modal-input"
                   value="{{ old('name', $editUser ? $editUser->name : '') }}"
                   required placeholder="Nama lengkap member">
          </div>
          <div class="modal-field">
            <label class="modal-label">Email</label>
            <input type="email" name="email" id="modal-email" class="modal-input"
                   value="{{ old('email', $editUser ? $editUser->email : '') }}"
                   required placeholder="email@example.com">
          </div>
          <div class="modal-field">
            <label class="modal-label">
              Password
              <span id="modal-pw-hint" class="modal-pw-hint"> — kosongkan jika tidak diubah</span>
            </label>
            <input type="password" name="password" class="modal-input"
                   id="modal-password" placeholder="Minimal 6 karakter">
          </div>
          <div class="modal-field">
            <label class="modal-label">Role</label>
            <select name="role" id="modal-role" class="modal-select">
              <option value="user"  {{ old('role', $editUser ? $editUser->role : '') == 'user'  ? 'selected' : '' }}>User</option>
              <option value="admin" {{ old('role', $editUser ? $editUser->role : '') == 'admin' ? 'selected' : '' }}>Admin</option>
              <option value="dev"   {{ old('role', $editUser ? $editUser->role : '') == 'dev'   ? 'selected' : '' }}>Developer</option>
              <option value="owner" {{ old('role', $editUser ? $editUser->role : '') == 'owner' ? 'selected' : '' }}>Owner</option>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-modal-cancel" onclick="closeMemberModal()">Batal</button>
        <button type="submit" name="save_member" class="btn-modal-save" id="modal-save-btn">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/>
            <polyline points="17 21 17 13 7 13 7 21"/>
            <polyline points="7 3 7 8 15 8"/>
          </svg>
          Simpan Member
        </button>
      </div>
    </form>
  </div>
</div>

<script>
// ── SCROLL REVEAL ──
document.addEventListener('DOMContentLoaded', () => {
  const els = document.querySelectorAll('.reveal');
  if (!els.length) return;
  const io = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('is-visible'); io.unobserve(e.target); } });
  }, { threshold: 0.1 });
  els.forEach(el => io.observe(el));
});

// ── CHECKBOX & BULK ──
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
  if (!n) return;
  if (confirm(`Hapus ${n} member? Tindakan ini tidak bisa dibatalkan.`)) {
    document.getElementById('bulk-form').submit();
  }
}

// ── MEMBER MODAL ──
function openMemberModal(id, name, email, role) {
  const modal   = document.getElementById('memberModal');
  const isEdit  = !!id;
  const titleEl = document.getElementById('modal-title');
  const pwHint  = document.getElementById('modal-pw-hint');
  const saveBtn = document.getElementById('modal-save-btn');

  const editIcon = `<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="width:18px;height:18px;opacity:0.8"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>`;
  const addIcon  = `<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="width:18px;height:18px;opacity:0.8"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>`;

  document.getElementById('modal-edit-id').value  = id || 0;
  document.getElementById('modal-name').value     = name  || '';
  document.getElementById('modal-email').value    = email || '';
  document.getElementById('modal-password').value = '';
  document.getElementById('modal-role').value     = role  || 'user';

  if (isEdit) {
    titleEl.innerHTML = editIcon + ` Edit Member — ${name}`;
    pwHint.style.display = 'inline';
    saveBtn.childNodes[saveBtn.childNodes.length - 1].textContent = ' Update Member';
  } else {
    titleEl.innerHTML = addIcon + ' Tambah Member Baru';
    pwHint.style.display = 'none';
    saveBtn.childNodes[saveBtn.childNodes.length - 1].textContent = ' Simpan Member';
  }
  modal.classList.add('open');
}
function closeMemberModal() {
  document.getElementById('memberModal').classList.remove('open');
}
function handleOverlayClick(e) {
  if (e.target === document.getElementById('memberModal')) closeMemberModal();
}

// Auto-open modal if validation errors or edit param
@if($errors->any() || $showForm)
  openMemberModal(
    {{ $editUser ? $editUser->id : 0 }},
    '{{ addslashes($editUser ? $editUser->name : old('name', '')) }}',
    '{{ addslashes($editUser ? $editUser->email : old('email', '')) }}',
    '{{ $editUser ? $editUser->role : old('role', 'user') }}'
  );
@endif
</script>
@endsection
