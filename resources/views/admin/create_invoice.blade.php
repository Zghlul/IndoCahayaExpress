@if ($errors->any())
    <div style="background:#fee2e2; border-left:4px solid #dc2626; padding:12px; margin-bottom:20px; border-radius:8px; font-family:'Plus Jakarta Sans',system-ui,sans-serif;">
        <strong>Terjadi kesalahan:</strong>
        <ul style="margin:5px 0 0 20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('error'))
    <div style="background:#fee2e2; border-left:4px solid #dc2626; padding:12px; margin-bottom:20px; border-radius:8px; font-family:'Plus Jakarta Sans',system-ui,sans-serif;">
        {{ session('error') }}
    </div>
@endif

@if(session('flash_inv'))
    <div style="background:#d1fae5; border-left:4px solid #059669; padding:12px; margin-bottom:20px; border-radius:8px; font-family:'Plus Jakarta Sans',system-ui,sans-serif;">
        {{ session('flash_inv') }}
    </div>
@endif

@extends('layouts.app')
@section('title', 'Buat Invoice Baru')
@section('content')

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap');

/* ══ ICE Design System — Create Invoice ══ */
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
  --ease-out:     cubic-bezier(0.22, 1, 0.36, 1);
}

/* ── KEYFRAMES ── */
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(24px); }
  to   { opacity: 1; transform: translateY(0); }
}
@keyframes spin {
  to { transform: rotate(360deg); }
}
@keyframes summaryIn {
  from { opacity: 0; transform: translateY(12px) scale(0.98); }
  to   { opacity: 1; transform: translateY(0) scale(1); }
}

/* ── PAGE SHELL ── */
.inv-shell {
  font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
  background: var(--surface-2);
  min-height: calc(100vh - 200px);
  padding: 0 0 5rem;
  color: var(--text-primary);
}

/* ── TOP NAV ── */
.inv-topnav {
  background: linear-gradient(168deg, var(--navy-900) 0%, #0B1C55 50%, #091640 100%);
  border-bottom: 1px solid rgba(255,255,255,0.07);
  box-shadow: 0 4px 24px rgba(6,15,46,0.4);
  position: sticky; top: 0; z-index: 100;
}
.inv-topnav-inner {
  max-width: 860px; margin: 0 auto;
  padding: 0 24px;
  display: flex; align-items: center; justify-content: space-between;
  height: 60px;
}
.inv-topnav-brand { display: flex; align-items: center; gap: 12px; }
.inv-topnav-icon {
  width: 36px; height: 36px; border-radius: 10px;
  background: rgba(227,30,36,0.18);
  border: 1px solid rgba(227,30,36,0.3);
  display: flex; align-items: center; justify-content: center;
}
.inv-topnav-icon svg { width: 16px; height: 16px; }
.inv-topnav-title {
  color: #fff; font-weight: 800; font-size: 0.95rem; letter-spacing: -0.01em;
}
.inv-btn-back {
  display: inline-flex; align-items: center; gap: 6px;
  color: rgba(255,255,255,0.75); font-size: 0.78rem; font-weight: 700;
  text-decoration: none; padding: 7px 14px; border-radius: 8px;
  border: 1px solid rgba(255,255,255,0.15);
  background: rgba(255,255,255,0.07);
  transition: all 0.18s;
}
.inv-btn-back:hover { background: rgba(255,255,255,0.14); color: #fff; }
.inv-btn-back svg { width: 13px; height: 13px; }

/* ── CONTAINER ── */
.inv-container { max-width: 860px; margin: 0 auto; padding: 32px 24px 0; }

/* ── HERO ── */
.inv-hero {
  position: relative; overflow: hidden; border-radius: 24px;
  margin-bottom: 28px; min-height: 150px;
  display: flex; align-items: center;
  box-shadow: 0 20px 60px rgba(6,15,46,0.30);
}
.inv-hero-canvas {
  position: absolute; inset: 0; z-index: 0; border-radius: 24px;
  background:
    radial-gradient(ellipse 100% 80% at 100% 0%,  rgba(20,56,160,0.55) 0%, transparent 55%),
    radial-gradient(ellipse 70%  60% at 0%  100%, rgba(227,30,36,0.10) 0%, transparent 50%),
    radial-gradient(ellipse 60%  70% at 55% 50%,  rgba(11,26,74,0.9)   0%, transparent 70%),
    linear-gradient(168deg, var(--navy-900) 0%, #0B1C55 45%, #091640 100%);
}
.inv-hero-canvas::after {
  content: '';
  position: absolute; inset: 0; border-radius: 24px;
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.03'/%3E%3C/svg%3E");
  pointer-events: none; mix-blend-mode: overlay; opacity: 0.5;
}
.inv-hero-grid {
  position: absolute; inset: 0; z-index: 1; border-radius: 24px;
  background-image: radial-gradient(circle, rgba(255,255,255,0.055) 1px, transparent 1px);
  background-size: 44px 44px;
  -webkit-mask-image: radial-gradient(ellipse 90% 80% at 50% 50%, black 40%, transparent 80%);
  mask-image: radial-gradient(ellipse 90% 80% at 50% 50%, black 40%, transparent 80%);
}
.inv-hero-lines {
  position: absolute; inset: 0; z-index: 1; overflow: hidden; border-radius: 24px;
}
.inv-hero-lines::before,
.inv-hero-lines::after {
  content: ''; position: absolute; top: 0; bottom: 0; width: 1px;
}
.inv-hero-lines::before {
  right: 34%;
  background: linear-gradient(to bottom, transparent 0%, rgba(227,30,36,0.35) 25%, rgba(227,30,36,0.15) 70%, transparent 100%);
}
.inv-hero-lines::after {
  left: 52%;
  background: linear-gradient(to bottom, transparent 10%, rgba(59,174,224,0.12) 40%, rgba(59,174,224,0.06) 75%, transparent 100%);
}
.inv-hero-glow {
  position: absolute; z-index: 0; border-radius: 50%; filter: blur(80px); pointer-events: none;
}
.inv-hero-glow-1 {
  width: 500px; height: 500px; top: -180px; right: -60px;
  background: radial-gradient(circle, rgba(20,56,160,0.35) 0%, transparent 65%);
}
.inv-hero-glow-2 {
  width: 300px; height: 300px; bottom: -100px; left: 0;
  background: radial-gradient(circle, rgba(227,30,36,0.10) 0%, transparent 65%);
}
.inv-hero-inner {
  position: relative; z-index: 2; width: 100%;
  padding: 2.25rem 2.5rem;
  display: flex; align-items: center; justify-content: space-between;
  gap: 24px; flex-wrap: wrap;
}
.inv-hero-eyebrow {
  display: inline-flex; align-items: center; gap: 8px; margin-bottom: 14px;
  padding: 5px 14px 5px 7px; border-radius: 99px;
  border: 1px solid rgba(227,30,36,0.3);
  background: rgba(227,30,36,0.07);
  backdrop-filter: blur(10px);
}
.inv-hero-eyebrow-dot {
  width: 22px; height: 22px; border-radius: 50%; flex-shrink: 0;
  background: linear-gradient(135deg, var(--red), var(--red-deep));
  display: flex; align-items: center; justify-content: center;
  box-shadow: 0 4px 12px rgba(227,30,36,0.4);
}
.inv-hero-eyebrow-dot svg { width: 11px; height: 11px; color: #fff; }
.inv-hero-eyebrow span {
  font-size: 0.68rem; font-weight: 800; letter-spacing: 0.12em;
  text-transform: uppercase; color: rgba(255,255,255,0.75);
}
.inv-hero h1 {
  font-size: clamp(1.5rem, 3vw, 2rem); font-weight: 900;
  line-height: 1.05; margin: 0 0 6px; color: #fff; letter-spacing: -0.03em;
}
.inv-hero p {
  font-size: 0.88rem; color: rgba(255,255,255,0.5); margin: 0; line-height: 1.6;
}
.inv-period-badge {
  display: inline-flex; align-items: center; gap: 7px;
  background: rgba(255,255,255,0.10); color: rgba(255,255,255,0.9);
  border: 1px solid rgba(255,255,255,0.18); padding: 8px 16px;
  border-radius: 99px; font-size: 0.72rem; font-weight: 800;
  letter-spacing: 0.08em; text-transform: uppercase; white-space: nowrap;
  backdrop-filter: blur(10px); flex-shrink: 0; align-self: center;
}
.inv-period-badge svg { width: 13px; height: 13px; }

/* ── CARDS ── */
.inv-card {
  background: var(--white); border-radius: 18px; margin-bottom: 20px;
  border: 1px solid var(--border);
  box-shadow: var(--shadow-xs); overflow: hidden;
  animation: fadeInUp 0.5s var(--ease-out) both;
}
.inv-card:nth-child(1) { animation-delay: 0.05s; }
.inv-card:nth-child(2) { animation-delay: 0.12s; }
.inv-card:nth-child(3) { animation-delay: 0.19s; }

.inv-card-header {
  padding: 14px 22px; display: flex; align-items: center; justify-content: space-between;
  border-bottom: 1px solid var(--border); background: var(--surface);
}
.inv-card-header-left { display: flex; align-items: center; gap: 10px; }
.inv-card-header-icon {
  width: 32px; height: 32px; border-radius: 9px;
  display: flex; align-items: center; justify-content: center;
}
.inv-card-header-icon svg { width: 15px; height: 15px; }
.inv-card-header-icon.navy { background: rgba(6,15,46,0.06); color: var(--navy-900); }
.inv-card-header-icon.red  { background: rgba(227,30,36,0.07); border: 1px solid rgba(227,30,36,0.15); color: var(--red); }
.inv-card-title {
  margin: 0; font-size: 0.9rem; font-weight: 800;
  color: var(--text-primary); letter-spacing: -0.01em;
}
.inv-card-title span { color: var(--text-muted); font-weight: 600; }
.inv-card-body { padding: 24px; }

/* ── FORMS ── */
.inv-label {
  display: block; font-size: 0.67rem; font-weight: 800;
  color: var(--text-muted); text-transform: uppercase;
  letter-spacing: 0.08em; margin-bottom: 7px;
}
.inv-label .req { color: var(--red); }
.inv-input, .inv-select {
  width: 100%; padding: 10px 14px; border-radius: 9px;
  border: 1.5px solid var(--border); font-size: 0.875rem;
  background: var(--surface); color: var(--text-primary);
  font-family: inherit; font-weight: 500;
  transition: all 0.2s; box-sizing: border-box;
}
.inv-select {
  appearance: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%237A93B8' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 12px center;
  background-size: 12px;
  padding-right: 36px; cursor: pointer;
}
.inv-input:focus, .inv-select:focus {
  border-color: var(--navy-900);
  box-shadow: 0 0 0 3px rgba(6,15,46,0.08);
  outline: none; background: var(--white);
}
.inv-input[readonly] {
  background: var(--white); color: var(--text-2);
  font-weight: 600; cursor: not-allowed;
}
.inv-invoice-placeholder {
  padding: 10px 14px; border-radius: 9px;
  border: 1.5px dashed var(--border-2);
  background: var(--surface-2);
  font-size: 0.83rem; color: var(--text-faint);
  font-style: italic; display: flex; align-items: center;
  gap: 8px; min-height: 42px; box-sizing: border-box;
}
.inv-invoice-placeholder svg { width: 13px; height: 13px; color: var(--border-2); flex-shrink: 0; }

/* Grid helpers */
.inv-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 20px; }
.inv-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px; }

/* Customer detail box */
.inv-detail-box {
  background: #EEF3FF; border-radius: 12px;
  padding: 16px; border: 1px solid var(--border-2);
}

/* ── SHIPMENT ITEMS ── */
.inv-shipments { display: flex; flex-direction: column; gap: 10px; }
.inv-shipment-item {
  border: 1.5px solid var(--border); border-radius: 12px;
  padding: 14px 16px; background: var(--surface);
  cursor: pointer; transition: all 0.2s var(--ease-out);
}
.inv-shipment-item:hover {
  border-color: var(--border-2);
  transform: translateY(-2px);
  box-shadow: var(--shadow-sm);
}
.inv-shipment-item.selected {
  border-color: var(--navy-900);
  background: #EEF3FF;
}
.inv-shipment-inner {
  display: flex; align-items: flex-start; gap: 14px;
}
input[type="checkbox"].inv-cb {
  accent-color: var(--navy-900);
  width: 17px; height: 17px;
  cursor: pointer; flex-shrink: 0; margin-top: 3px;
}
.inv-shipment-content { flex: 1; min-width: 0; }
.inv-shipment-top {
  display: flex; align-items: center;
  justify-content: space-between; margin-bottom: 6px;
  flex-wrap: wrap; gap: 8px;
}
.inv-shipment-name { font-size: 0.9rem; color: var(--text-primary); font-weight: 800; }
.inv-shipment-price { font-size: 0.9rem; font-weight: 800; color: var(--green); }
.inv-shipment-meta { display: flex; align-items: center; flex-wrap: wrap; gap: 6px; }
.inv-tracking-tag {
  font-family: 'JetBrains Mono', 'SF Mono', 'Courier New', monospace;
  font-size: 0.72rem; font-weight: 700;
  background: var(--surface-3); color: var(--navy-900);
  padding: 3px 8px; border-radius: 6px;
  border: 1px solid var(--border-2); letter-spacing: 0.04em;
}
.inv-shipment-item.selected .inv-tracking-tag {
  background: rgba(6,15,46,0.08);
}
.inv-meta-text { font-size: 0.75rem; color: var(--text-2); font-weight: 600; }
.inv-meta-sep  { font-size: 0.75rem; color: var(--text-faint); }
.inv-svc-badge {
  font-size: 0.7rem; font-weight: 700; padding: 2px 7px;
  border-radius: 5px; border: 1px solid;
}
.inv-svc-badge.express { background: rgba(8,145,178,0.08); color: #0891b2; border-color: rgba(8,145,178,0.2); }
.inv-svc-badge.reguler { background: rgba(6,15,46,0.06); color: var(--text-2); border-color: var(--border); }

/* Badge untuk biaya tambahan */
.inv-ddp-badge {
  font-size: 0.67rem; font-weight: 800; padding: 2px 7px; border-radius: 5px;
  background: rgba(217,119,6,0.08); color: var(--amber);
  border: 1px solid rgba(217,119,6,0.2);
}
.inv-warrisk-badge {
  font-size: 0.67rem; font-weight: 800; padding: 2px 7px; border-radius: 5px;
  background: rgba(220,38,38,0.08); color: #b91c1c;
  border: 1px solid rgba(220,38,38,0.2);
}
.inv-tes-badge {
  font-size: 0.67rem; font-weight: 800; padding: 2px 7px; border-radius: 5px;
  background: rgba(245,158,11,0.08); color: #b45309;
  border: 1px solid rgba(245,158,11,0.2);
}

/* ── EMPTY / LOADING ── */
.inv-empty {
  text-align: center; padding: 40px 24px;
}
.inv-empty-icon {
  width: 56px; height: 56px; border-radius: 14px;
  background: var(--surface-2); display: flex; align-items: center;
  justify-content: center; margin: 0 auto 14px; color: var(--border-2);
}
.inv-empty-icon svg { width: 24px; height: 24px; }
.inv-empty h4 { margin: 0 0 5px; font-weight: 800; color: var(--text-2); font-size: 0.9rem; }
.inv-empty p  { margin: 0; font-size: 0.82rem; color: var(--text-faint); }
.inv-loading   { text-align: center; padding: 32px; color: var(--text-muted); }
.inv-spinner   {
  display: inline-block; width: 20px; height: 20px; margin-bottom: 10px;
  border: 2.5px solid var(--border); border-top-color: var(--navy-900);
  border-radius: 50%; animation: spin 0.8s linear infinite;
}
.inv-loading p { margin: 0; font-size: 0.83rem; font-weight: 600; }

/* ── SUMMARY BOX ── */
.inv-summary {
  margin-top: 20px; border-radius: 14px;
  border: 1.5px solid var(--border-2);
  background: linear-gradient(135deg, #EEF3FF 0%, var(--surface-3) 100%);
  overflow: hidden; display: none;
  animation: summaryIn 0.35s var(--ease-out) both;
}
.inv-summary.show { display: block; }
.inv-summary-header {
  padding: 12px 18px; border-bottom: 1px solid var(--border-2);
  display: flex; align-items: center; gap: 8px;
  background: rgba(6,15,46,0.03);
}
.inv-summary-header svg { width: 14px; height: 14px; color: var(--navy-900); }
.inv-summary-header span {
  font-size: 0.68rem; font-weight: 800; color: var(--navy-900);
  text-transform: uppercase; letter-spacing: 0.1em;
}
.inv-summary-body { padding: 16px 18px; }
.inv-summary-row {
  display: flex; justify-content: space-between; align-items: center;
  padding: 8px 0; border-bottom: 1px solid rgba(9,24,60,0.07);
}
.inv-summary-row:last-of-type { border-bottom: none; }
.inv-summary-label { font-size: 0.83rem; color: var(--text-2); font-weight: 500; }
.inv-summary-value { font-size: 0.83rem; font-weight: 700; color: var(--text-primary); }
.inv-summary-value.amber { color: var(--amber); }
.inv-summary-grand {
  display: flex; justify-content: space-between; align-items: center;
  padding: 14px 16px; margin-top: 10px; border-radius: 10px;
  background: var(--navy-900);
}
.inv-summary-grand-label {
  font-size: 0.88rem; font-weight: 800; color: rgba(255,255,255,0.8);
  letter-spacing: 0.04em; text-transform: uppercase;
}
.inv-summary-grand-value {
  font-size: 1.15rem; font-weight: 900; color: #fff; letter-spacing: -0.02em;
}

/* ── SUBMIT ── */
.inv-submit-btn {
  width: 100%; padding: 15px 24px;
  background: linear-gradient(135deg, var(--navy-900) 0%, var(--navy-600) 50%, var(--navy-500) 100%);
  color: #fff; border: none; border-radius: 14px;
  font-family: inherit; font-weight: 800; font-size: 0.95rem;
  cursor: pointer; letter-spacing: -0.01em;
  display: flex; align-items: center; justify-content: center; gap: 9px;
  transition: all 0.25s var(--ease-out);
  box-shadow: 0 8px 28px rgba(6,15,46,0.3);
}
.inv-submit-btn:hover  { transform: translateY(-2px); box-shadow: 0 12px 36px rgba(6,15,46,0.4); }
.inv-submit-btn:active { transform: translateY(0); }
.inv-submit-btn:disabled {
  background: var(--border-2); color: var(--text-muted);
  cursor: not-allowed; box-shadow: none; transform: none;
}
.inv-submit-btn svg { width: 17px; height: 17px; }
.inv-submit-hint {
  text-align: center; margin: 10px 0 0;
  font-size: 0.78rem; color: var(--text-faint); font-weight: 500;
}

/* ── INFO CARD (KETERANGAN BIAYA TAMBAHAN) ── */
.inv-info-card {
  background: #fff;
  border-radius: 16px;
  border: 1px solid var(--border);
  padding: 14px 20px;
  margin: 24px 0 16px;
  box-shadow: var(--shadow-xs);
}
.inv-info-title {
  font-size: 0.7rem;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  color: var(--text-muted);
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 10px;
}
.inv-info-title svg {
  width: 14px;
  height: 14px;
}
.inv-info-list {
  list-style: none;
  margin: 0;
  padding: 0;
  display: flex;
  flex-wrap: wrap;
  gap: 12px;
}
.inv-info-list li {
  font-size: 0.78rem;
  color: var(--text-2);
  display: flex;
  align-items: center;
  gap: 6px;
}
.inv-info-list li strong {
  font-weight: 800;
  color: var(--navy-700);
}
.inv-info-badge {
  width: 20px;
  height: 20px;
  border-radius: 6px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  background: rgba(6,15,46,0.06);
}

/* ── RESPONSIVE ── */
@media (max-width: 640px) {
  .inv-grid-2, .inv-grid-3 { grid-template-columns: 1fr; }
  .inv-hero-inner { padding: 1.75rem 1.5rem; }
  .inv-container { padding: 20px 16px 0; }
  .inv-card-body { padding: 18px 16px; }
  .inv-info-list { flex-direction: column; gap: 6px; }
}
</style>
@endpush

<div class="inv-shell">

  {{-- ═══ TOP NAV ═══ --}}
  <div class="inv-topnav">
    <div class="inv-topnav-inner">
      <div class="inv-topnav-brand">
        <div class="inv-topnav-icon">
          <svg fill="none" viewBox="0 0 24 24" stroke="#E31E24" stroke-width="2.5">
            <rect x="5" y="2" width="14" height="20" rx="2"/>
            <line x1="9" y1="9" x2="15" y2="9"/>
            <line x1="9" y1="13" x2="15" y2="13"/>
          </svg>
        </div>
        <span class="inv-topnav-title">Buat Invoice Baru</span>
      </div>
      <a href="{{ route('admin.invoices.index') }}" class="inv-btn-back">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <polyline points="15 18 9 12 15 6"/>
        </svg>
        Kembali ke Daftar
      </a>
    </div>
  </div>

  <div class="inv-container">

    {{-- ═══ HERO ═══ --}}
    <div class="inv-hero">
      <div class="inv-hero-canvas"></div>
      <div class="inv-hero-grid"></div>
      <div class="inv-hero-lines"></div>
      <div class="inv-hero-glow inv-hero-glow-1"></div>
      <div class="inv-hero-glow inv-hero-glow-2"></div>
      <div class="inv-hero-inner">
        <div>
          <div class="inv-hero-eyebrow">
            <div class="inv-hero-eyebrow-dot">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <rect x="5" y="2" width="14" height="20" rx="2"/>
                <line x1="9" y1="9" x2="15" y2="9"/>
                <line x1="9" y1="13" x2="15" y2="13"/>
              </svg>
            </div>
            <span>Admin Dashboard</span>
          </div>
          <h1>Buat Invoice Baru</h1>
          <p>Pilih pengirim dan shipment untuk dimasukkan ke invoice.</p>
        </div>
        <div class="inv-period-badge">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <line x1="4" y1="9" x2="20" y2="9"/>
            <line x1="4" y1="15" x2="20" y2="15"/>
            <line x1="10" y1="3" x2="8" y2="21"/>
            <line x1="16" y1="3" x2="14" y2="21"/>
          </svg>
          Format: INV/YYMMDD/XXXX
        </div>
      </div>
    </div>

    {{-- ═══ FORM ═══ --}}
    <form id="invoiceForm" method="POST" action="{{ route('invoices.store') }}">
      @csrf

      {{-- ── CARD 1: PENGIRIM ── --}}
      <div class="inv-card">
        <div class="inv-card-header">
          <div class="inv-card-header-left">
            <div class="inv-card-header-icon navy">
              <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M20 7H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                <polyline points="16 3 12 7 8 3"/>
              </svg>
            </div>
            <h2 class="inv-card-title">Pengirim <span>(Shipper)</span></h2>
          </div>
        </div>
        <div class="inv-card-body">
          <div class="inv-grid-2">
            {{-- Customer select --}}
            <div>
              <label class="inv-label">
                Nama / Email Pengirim <span class="req">*</span>
              </label>
              <select name="user_id" id="sel_customer" class="inv-select" required>
                <option value="">— Pilih Pengirim —</option>
                @foreach($customers as $c)
                  <option value="{{ $c->id }}"
                          data-name="{{ $c->name }}"
                          data-phone="{{ $c->phone ?? '' }}"
                          data-email="{{ $c->email }}"
                          data-company="{{ $c->company_name ?? '' }}">
                    {{ $c->name }} ({{ $c->email }})
                  </option>
                @endforeach
              </select>
            </div>
            {{-- Invoice number --}}
            <div>
              <label class="inv-label">Nomor Invoice</label>
              <div class="inv-invoice-placeholder">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <line x1="4" y1="9" x2="20" y2="9"/><line x1="4" y1="15" x2="20" y2="15"/>
                  <line x1="10" y1="3" x2="8" y2="21"/><line x1="16" y1="3" x2="14" y2="21"/>
                </svg>
                Digenerate otomatis setelah simpan
              </div>
            </div>
          </div>

          {{-- Customer detail (readonly) --}}
          <div id="customer-detail" style="display:none;">
            <div class="inv-detail-box">
              <div class="inv-grid-3">
                <div>
                  <label class="inv-label">Perusahaan</label>
                  <input type="text" id="company_display" class="inv-input" readonly>
                </div>
                <div>
                  <label class="inv-label">No. Telepon</label>
                  <input type="text" id="phone_display" class="inv-input" readonly>
                </div>
                <div>
                  <label class="inv-label">Email Pengirim</label>
                  <input type="text" id="email_display" class="inv-input" readonly>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- ── CARD 2: SHIPMENTS ── --}}
      <div class="inv-card" id="shipments-card" style="display:none;">
        <div class="inv-card-header">
          <div class="inv-card-header-left">
            <div class="inv-card-header-icon red">
              <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                <circle cx="12" cy="10" r="3"/>
              </svg>
            </div>
            <h2 class="inv-card-title">Pilih Penerima <span>/ Shipment</span></h2>
          </div>
          <span id="selected-badge" style="display:none; font-size:0.72rem; font-weight:800; padding:4px 10px; border-radius:99px; background:rgba(6,15,46,0.07); color:#060F2E; letter-spacing:0.04em;"></span>
        </div>
        <div class="inv-card-body">
          <p style="margin:0 0 18px; font-size:0.82rem; color:var(--text-muted); line-height:1.6;">
            Centang shipment yang akan dimasukkan ke invoice ini. Setiap baris = 1 penerima.
          </p>
          <div id="shipments-list">
            <div class="inv-loading">
              <div class="inv-spinner"></div>
              <p>Memuat shipment...</p>
            </div>
          </div>

          {{-- Summary --}}
          <div class="inv-summary" id="summary-box">
            <div class="inv-summary-header">
              <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <polyline points="9 11 12 14 22 4"/>
                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
              </svg>
              <span>Ringkasan Invoice</span>
            </div>
            <div class="inv-summary-body">
              <div class="inv-summary-row">
                <span class="inv-summary-label">Jumlah Paket</span>
                <span class="inv-summary-value" id="sum-paket">0</span>
              </div>
              <div class="inv-summary-row">
                <span class="inv-summary-label">Subtotal Ongkir</span>
                <span class="inv-summary-value" id="sum-subtotal">Rp 0</span>
              </div>
              <div class="inv-summary-row" id="ddp-row" style="display:none;">
                <span class="inv-summary-label">DDP {{ $ddpPercent ?? 19 }}% (US)</span>
                <span class="inv-summary-value amber" id="sum-ddp">Rp 0</span>
              </div>
              <div class="inv-summary-row" id="aramex-surcharge-row" style="display:none;">
                <span class="inv-summary-label">Temporary Emergency Surcharge (TES)</span>
                <span class="inv-summary-value amber" id="sum-surcharge">Rp 0</span>
              </div>
              <div class="inv-summary-row" id="warrisk-row" style="display:none;">
                <span class="inv-summary-label">War Risk Charge (32%)</span>
                <span class="inv-summary-value amber" id="sum-warrisk">Rp 0</span>
              </div>
              <div class="inv-summary-grand">
                <span class="inv-summary-grand-label">Grand Total</span>
                <span class="inv-summary-grand-value" id="sum-grand">Rp 0</span>
              </div>
            </div>
          </div>

          <input type="hidden" name="subtotal"    id="h_subtotal">
          <input type="hidden" name="ddp"         id="h_ddp">
          <input type="hidden" name="aramex_surcharge" id="h_aramex_surcharge">
          <input type="hidden" name="war_risk"    id="h_war_risk">
          <input type="hidden" name="grand_total" id="h_grand">
        </div>
      </div>

      {{-- ── KETERANGAN BIAYA TAMBAHAN ── --}}
      <div class="inv-info-card">
        <div class="inv-info-title">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="8" x2="12" y2="12"/>
            <line x1="12" y1="16" x2="12.01" y2="16"/>
          </svg>
          Catatan Biaya Tambahan
        </div>
        <ul class="inv-info-list">
          <li><span class="inv-info-badge">📦</span> <strong>DDP</strong> : 19% dari nilai barang – untuk layanan <strong>REGULER</strong> ke <strong>United States</strong>.</li>
          <li><span class="inv-info-badge">⚡</span> <strong>TES</strong> : <em>Temporary Emergency Surcharge</em> – untuk layanan <strong>FLASH</strong> ke luar kawasan tertentu (Aramex).</li>
          <li><span class="inv-info-badge">⚠️</span> <strong>War Risk</strong> : 32% dari <strong>harga ongkir</strong> – untuk layanan <strong>REGULER</strong> (SGPost).</li>
        </ul>
      </div>

      {{-- ── SUBMIT ── --}}
      <div class="inv-card" style="padding:0; overflow:visible; background:transparent; border:none; box-shadow:none;">
        <button type="submit" class="inv-submit-btn" id="btnSave" disabled>
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
            <polyline points="17 21 17 13 7 13 7 21"/>
            <polyline points="7 3 7 8 15 8"/>
          </svg>
          Buat Invoice
        </button>
        <p class="inv-submit-hint" id="submit-hint">Pilih pengirim terlebih dahulu</p>
      </div>

    </form>
  </div>{{-- /container --}}
</div>{{-- /shell --}}

<script>
const USD_TO_IDR  = {{ $usdRate ?? 15000 }};
const DDP_PERCENT = {{ $ddpPercent ?? 19 }};
const WAR_RISK_PERCENT = 32; // Persen dari ongkir, bukan dari declare value
const DDP_COUNTRIES = ['united states','united states of america','usa','united states of america & territories'];
const ARAMEX_EXCEPTION_COUNTRIES = [
    'afghanistan', 'armenia', 'azerbaijan', 'brunei',
    'cambodia', 'china', 'hong kong', 'indonesia',
    'japan', 'kazakhstan', 'kyrgyzstan', 'laos',
    'macau', 'malaysia', 'mongolia', 'myanmar',
    'philippines', 'singapore', 'south korea', 'taiwan',
    'tajikistan', 'thailand', 'timor-leste', 'turkmenistan',
    'uzbekistan', 'vietnam', 'australia', 'new zealand',
    'fiji'
];
let shipmentsData = [];

/* ── Load shipments ── */
function loadShipments(userId) {
  const card    = document.getElementById('shipments-card');
  const detail  = document.getElementById('customer-detail');
  const btnSave = document.getElementById('btnSave');
  const hint    = document.getElementById('submit-hint');

  if (!userId) {
    card.style.display   = 'none';
    detail.style.display = 'none';
    btnSave.disabled     = true;
    hint.textContent     = 'Pilih pengirim terlebih dahulu';
    return;
  }

  const opt = document.querySelector('#sel_customer option:checked');
  document.getElementById('phone_display').value   = opt.dataset.phone   || '';
  document.getElementById('email_display').value   = opt.dataset.email   || '';
  document.getElementById('company_display').value = opt.dataset.company || '';
  detail.style.display = 'block';
  card.style.display   = 'block';

  document.getElementById('shipments-list').innerHTML =
    '<div class="inv-loading"><div class="inv-spinner"></div><p>Memuat shipment...</p></div>';
  document.getElementById('summary-box').classList.remove('show');

  fetch('/ajax/shipments-by-customer?user_id=' + encodeURIComponent(userId))
    .then(r => r.json())
    .then(data => {
      shipmentsData = data;
      if (!data.length) {
        document.getElementById('shipments-list').innerHTML = `
          <div class="inv-empty">
            <div class="inv-empty-icon">
              <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
              </svg>
            </div>
            <h4>Tidak ada shipment tersedia</h4>
            <p>Pengirim ini belum memiliki shipment aktif.</p>
          </div>`;
        hint.textContent = 'Tidak ada shipment tersedia untuk pengirim ini';
        return;
      }
      hint.textContent = 'Pilih minimal 1 shipment untuk melanjutkan';
      document.getElementById('shipments-list').innerHTML =
        '<div class="inv-shipments">' + data.map(s => `
          <div class="inv-shipment-item" id="item-${s.id}" onclick="clickItem(${s.id})">
            <div class="inv-shipment-inner">
              <input type="checkbox" class="inv-cb" name="shipment_ids[]" value="${s.id}"
                     data-charge="${s.charge_idr}" data-negara="${s.negara}"
                     data-declare="${s.declare_value_usd}" data-service="${s.service}"
                     data-weight="${parseFloat(s.berat_dibebankan)}"
                     onchange="updateSummary(); toggleStyle(${s.id}, this.checked)"
                     onclick="event.stopPropagation()" id="cb-${s.id}">
              <div class="inv-shipment-content">
                <div class="inv-shipment-top">
                  <span class="inv-shipment-name">${escHtml(s.nama_penerima) || '(Penerima kosong)'}</span>
                  <span class="inv-shipment-price">Rp ${Number(s.charge_idr).toLocaleString('id-ID')}</span>
                </div>
                <div class="inv-shipment-meta">
                  <span class="inv-tracking-tag">${escHtml(s.tracking_number)}</span>
                  <span class="inv-meta-text">${escHtml(s.negara)}</span>
                  <span class="inv-meta-sep">•</span>
                  <span class="inv-svc-badge ${s.service === 'EXPRESS' ? 'express' : 'reguler'}">${escHtml(s.service)}</span>
                  <span class="inv-meta-sep">•</span>
                  <span class="inv-meta-text">${parseFloat(s.berat_dibebankan).toFixed(2)} kg</span>
                  <span class="inv-meta-sep">•</span>
                  <span class="inv-meta-text" style="color:var(--text-muted)">${escHtml(s.content)}</span>
                  ${(s.service === 'REGULER' && DDP_COUNTRIES.includes((s.negara||'').toLowerCase()))
                    ? `<span class="inv-ddp-badge">DDP ${DDP_PERCENT}%</span>` : ''}
                  ${(s.service === 'REGULER') ? `<span class="inv-warrisk-badge">War Risk ${WAR_RISK_PERCENT}%</span>` : ''}
                  ${(s.service === 'FLASH' && !ARAMEX_EXCEPTION_COUNTRIES.includes((s.negara||'').toLowerCase())) ? `<span class="inv-tes-badge">TES</span>` : ''}
                </div>
              </div>
            </div>
          </div>`).join('') + '</div>';
    })
    .catch(() => {
      document.getElementById('shipments-list').innerHTML = `
        <div class="inv-empty">
          <div class="inv-empty-icon">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
              <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/>
              <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
          </div>
          <h4>Gagal memuat data</h4>
          <p>Cek koneksi dan coba lagi.</p>
        </div>`;
    });
}

function clickItem(id) {
  const cb = document.getElementById('cb-' + id);
  if (cb) { cb.checked = !cb.checked; toggleStyle(id, cb.checked); updateSummary(); }
}

function toggleStyle(id, checked) {
  const el = document.getElementById('item-' + id);
  if (el) el.classList.toggle('selected', checked);
  const total = document.querySelectorAll('input[name="shipment_ids[]"]:checked').length;
  const badge = document.getElementById('selected-badge');
  if (total > 0) { badge.style.display = 'inline'; badge.textContent = total + ' dipilih'; }
  else { badge.style.display = 'none'; }
}

function updateSummary() {
    const cbs  = document.querySelectorAll('input[name="shipment_ids[]"]:checked');
    const box  = document.getElementById('summary-box');
    const btn  = document.getElementById('btnSave');
    const hint = document.getElementById('submit-hint');

    if (!cbs.length) {
        box.classList.remove('show');
        btn.disabled = true;
        hint.textContent = 'Pilih minimal 1 shipment untuk melanjutkan';
        return;
    }

    let subtotal = 0, totalDDP = 0, totalAramexSurcharge = 0, totalWarRisk = 0;
    cbs.forEach(cb => {
        const charge = parseFloat(cb.dataset.charge) || 0;
        subtotal += charge;
        const negara  = (cb.dataset.negara  || '').toLowerCase();
        const service = cb.dataset.service || '';
        const berat   = parseFloat(cb.dataset.weight) || 0;
        const declare = parseFloat(cb.dataset.declare) || 0;

        // DDP (REGULER ke US)
        if (service === 'REGULER' && DDP_COUNTRIES.includes(negara)) {
            totalDDP += Math.round(declare * USD_TO_IDR * (DDP_PERCENT / 100));
        }

        // Aramex surcharge (TES)
        if (service === 'FLASH' && !ARAMEX_EXCEPTION_COUNTRIES.includes(negara)) {
            if (berat <= 2) {
                totalAramexSurcharge += 100000;
            } else {
                const roundedWeight = Math.ceil(berat);
                totalAramexSurcharge += 50000 * roundedWeight;
            }
        }

        // WAR RISK: 32% dari HARGA ONGKIR (charge_idr) untuk layanan REGULER
        if (service === 'REGULER') {
            totalWarRisk += Math.round(charge * (WAR_RISK_PERCENT / 100));
        }
    });

    const grand = subtotal + totalDDP + totalAramexSurcharge + totalWarRisk;

    document.getElementById('sum-paket').textContent    = cbs.length + ' item';
    document.getElementById('sum-subtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
    document.getElementById('sum-ddp').textContent      = 'Rp ' + totalDDP.toLocaleString('id-ID');
    document.getElementById('sum-surcharge').textContent = 'Rp ' + totalAramexSurcharge.toLocaleString('id-ID');
    document.getElementById('sum-warrisk').textContent  = 'Rp ' + totalWarRisk.toLocaleString('id-ID');
    document.getElementById('sum-grand').textContent    = 'Rp ' + grand.toLocaleString('id-ID');

    document.getElementById('ddp-row').style.display = totalDDP > 0 ? 'flex' : 'none';
    document.getElementById('aramex-surcharge-row').style.display = totalAramexSurcharge > 0 ? 'flex' : 'none';
    document.getElementById('warrisk-row').style.display = totalWarRisk > 0 ? 'flex' : 'none';

    document.getElementById('h_subtotal').value = subtotal;
    document.getElementById('h_ddp').value      = totalDDP;
    document.getElementById('h_aramex_surcharge').value = totalAramexSurcharge;
    document.getElementById('h_war_risk').value = totalWarRisk;
    document.getElementById('h_grand').value    = grand;

    box.classList.add('show');
    btn.disabled = false;
    hint.style.display = 'none';
}

function escHtml(str) {
  if (!str) return '';
  return str.replace(/[&<>]/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;'}[m]));
}

document.getElementById('sel_customer').addEventListener('change', function () {
  loadShipments(this.value);
});
</script>

@endsection