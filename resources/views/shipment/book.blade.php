@extends('layouts.app')

@section('title', 'Book Shipment - Indo Cahaya Express')

@section('content')
@php
    use Illuminate\Support\Facades\DB;

    // Ambil parameter dari URL (dari calculator)
    $vendor     = request()->query('vendor');
    $price      = request()->query('price');
    $weight     = request()->query('weight');
    $length     = request()->query('length');
    $width      = request()->query('width');
    $height     = request()->query('height');
    $countryName= request()->query('country'); // nama negara dari calculator

    $from_calc  = ($price !== null && $weight !== null); // apakah berasal dari kalkulator

    $country_id   = 0;
    $country_name = '';

    if ($from_calc && $countryName) {
        $country = DB::table('countries')->where('country_name', $countryName)->first();
        if ($country) {
            $country_id   = $country->id;
            $country_name = $country->country_name;
        }
    }

    // Hitung volumetrik dan berat chargeable (sama seperti ship.php)
    $volumetric = ($length && $width && $height) ? round(($length * $width * $height) / 5000, 2) : 0;
    $chargeable = ($weight && $volumetric) ? max((float)$weight, $volumetric) : (float)$weight;

    // Data user yang login (Laravel Auth)
    $user = Auth::user();
@endphp

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300&family=DM+Serif+Display:ital@0;1&display=swap');

:root {
  --red:           #E31E24;
  --red-hover:     #C7181D;
  --red-deep:      #A0121A;
  --red-glow:      rgba(227,30,36,0.22);
  --navy-900:      #060F2E;
  --navy-800:      #0A1A4A;
  --navy-700:      #0D2260;
  --navy-600:      #102B78;
  --navy-500:      #1438A0;
  --navy-400:      #2550C8;
  --white:         #FFFFFF;
  --surface:       #FAFBFE;
  --surface-2:     #F1F5FC;
  --surface-3:     #E8EFF9;
  --border:        #DDE6F5;
  --border-2:      #C8D6EE;
  --text-primary:  #09183C;
  --text-2:        #3D5478;
  --text-muted:    #7A93B8;
  --text-faint:    #AAB9D0;
  --sky:           #3BAEE0;
  --green:         #16A34A;
  --shadow-xs:     0 1px 4px rgba(9,24,60,0.06);
  --shadow-sm:     0 2px 8px rgba(9,24,60,0.08);
  --shadow-md:     0 8px 24px rgba(9,24,60,0.10);
  --shadow-lg:     0 16px 48px rgba(9,24,60,0.12);
  --shadow-card:   0 4px 20px rgba(9,24,60,0.07), 0 1px 4px rgba(9,24,60,0.04);
  --ease-out:      cubic-bezier(0.22, 1, 0.36, 1);
  --ease-spring:   cubic-bezier(0.34, 1.56, 0.64, 1);
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

.book-page {
  font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
  color: var(--text-primary);
  background: var(--surface);
  line-height: 1.6;
  overflow-x: hidden;
}

.book-page .container {
  max-width: 1440px;
  margin: 0 auto;
  padding: 0 3rem;
  width: 100%;
}

/* ══════════════════════════════════════════
   PAGE HERO
══════════════════════════════════════════ */
.page-hero {
  position: relative;
  background: var(--navy-900);
  overflow: hidden;
  padding: 5rem 0 4rem;
}
.page-hero-canvas {
  position: absolute; inset: 0; z-index: 0;
  background:
    radial-gradient(ellipse 80% 60% at 100% 0%,   rgba(20,56,160,0.50) 0%, transparent 55%),
    radial-gradient(ellipse 50% 50% at 0%   100%, rgba(227,30,36,0.08) 0%, transparent 50%),
    linear-gradient(168deg, #060F2E 0%, #0B1C55 45%, #091640 100%);
}
.page-hero-grid {
  position: absolute; inset: 0; z-index: 0;
  background-image: radial-gradient(circle, rgba(255,255,255,0.05) 1px, transparent 1px);
  background-size: 44px 44px;
  mask-image: radial-gradient(ellipse 90% 80% at 50% 50%, black 40%, transparent 80%);
}
.page-hero-line {
  position: absolute; top: 0; bottom: 0; z-index: 0;
  width: 1px; right: 38%;
  background: linear-gradient(to bottom, transparent 0%, rgba(227,30,36,0.3) 25%, rgba(227,30,36,0.12) 70%, transparent 100%);
}
.page-hero-inner {
  position: relative; z-index: 2;
  display: flex; flex-direction: column; align-items: flex-start;
}
.page-hero-badge {
  display: inline-flex; align-items: center; gap: 0.55rem;
  margin-bottom: 1.6rem;
  padding: 0.45rem 1rem 0.45rem 0.5rem;
  border-radius: 99px;
  border: 1px solid rgba(227,30,36,0.3);
  background: rgba(227,30,36,0.07);
  backdrop-filter: blur(10px);
}
.page-hero-badge-dot {
  width: 24px; height: 24px; border-radius: 50%;
  background: linear-gradient(135deg, var(--red), var(--red-deep));
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
  box-shadow: 0 4px 12px rgba(227,30,36,0.4);
}
.page-hero-badge-dot svg { width: 12px; height: 12px; color: #fff; }
.page-hero-badge span {
  font-size: 0.68rem; font-weight: 800;
  letter-spacing: 0.12em; text-transform: uppercase;
  color: rgba(255,255,255,0.72); padding-right: 0.2rem;
}
.page-hero-heading {
  font-size: clamp(2.4rem, 4vw, 3.8rem);
  font-weight: 900;
  line-height: 1.05;
  letter-spacing: -0.04em;
  color: #fff;
  margin-bottom: 1rem;
}
.page-hero-heading .accent {
  font-family: 'DM Serif Display', serif;
  font-style: italic;
  font-weight: 400;
  color: var(--red);
  text-shadow:
    0 0 30px rgba(227,30,36,0.8),
    0 0 60px rgba(227,30,36,0.45),
    0 0 100px rgba(227,30,36,0.2);
}
.page-hero-sub {
  font-size: 1rem;
  color: rgba(255,255,255,0.5);
  max-width: 480px;
  line-height: 1.75;
}
.page-hero-crumb {
  display: flex; align-items: center; gap: 0.5rem;
  margin-bottom: 1.8rem;
  font-size: 0.75rem; font-weight: 600;
  color: rgba(255,255,255,0.35);
}
.page-hero-crumb a { color: rgba(255,255,255,0.5); text-decoration: none; transition: color 0.2s; }
.page-hero-crumb a:hover { color: rgba(255,255,255,0.85); }
.page-hero-crumb svg { width: 12px; height: 12px; }

/* ══════════════════════════════════════════
   BOOK WRAP
══════════════════════════════════════════ */
.book-wrap {
  padding: 3.5rem 0 5rem;
}

/* ══════════════════════════════════════════
   STEPPER
══════════════════════════════════════════ */
.ship-stepper {
  max-width: 860px; margin: 0 auto 2.5rem;
  display: flex; align-items: center; justify-content: center;
}
.step-item { display: flex; align-items: center; flex: none; }
.step-dot  { display: flex; align-items: center; gap: 10px; flex-shrink: 0; }
.step-circle {
  width: 40px; height: 40px; border-radius: 50%;
  border: 2px solid var(--border-2);
  background: var(--white);
  color: var(--text-muted);
  font-size: 0.85rem; font-weight: 800;
  display: flex; align-items: center; justify-content: center;
  transition: all 0.3s var(--ease-out); flex-shrink: 0;
  box-shadow: var(--shadow-xs);
}
.step-circle svg { width: 16px; height: 16px; }
.step-label {
  font-size: 0.8rem; font-weight: 700;
  color: var(--text-muted);
  white-space: nowrap; transition: color 0.3s;
  letter-spacing: 0.01em;
}
.step-line {
  flex: 1; height: 2px;
  background: var(--border);
  margin: 0 14px; min-width: 60px;
  transition: background 0.35s;
}
.step-item.active .step-circle {
  border-color: var(--red);
  background: var(--red); color: white;
  box-shadow: 0 4px 16px rgba(227,30,36,0.35);
}
.step-item.active .step-label { color: var(--red); }
.step-item.done .step-circle  {
  border-color: var(--green);
  background: var(--green); color: white;
}
.step-item.done .step-label   { color: var(--green); }
.step-item.done + .step-line  { background: var(--green); }

/* ══════════════════════════════════════════
   VALIDATION ALERT
══════════════════════════════════════════ */
.validation-alert {
  max-width: 860px; margin: 0 auto 1.2rem;
  background: #fef2f2;
  border: 1.5px solid rgba(227,30,36,0.25);
  border-radius: 14px; padding: 1rem 1.4rem;
  display: flex; align-items: center; gap: 0.75rem;
  font-size: 0.825rem; font-weight: 600; color: var(--red);
}
.validation-alert svg { width: 18px; height: 18px; flex-shrink: 0; }
.validation-alert.hidden { display: none; }

/* ══════════════════════════════════════════
   SHIP CARD
══════════════════════════════════════════ */
.ship-card {
  max-width: 860px; margin: 0 auto 1.5rem;
  background: var(--white);
  border-radius: 22px;
  box-shadow: var(--shadow-card);
  border: 1px solid var(--border);
  overflow: hidden;
}
.ship-card-header {
  background: linear-gradient(155deg, var(--navy-800) 0%, var(--navy-700) 100%);
  padding: 1.5rem 2rem; color: white;
  display: flex; align-items: center; gap: 1rem;
  position: relative; overflow: hidden;
}
.ship-card-header::before {
  content: '';
  position: absolute; inset: 0;
  background-image: radial-gradient(circle, rgba(255,255,255,0.04) 1px, transparent 1px);
  background-size: 24px 24px;
  pointer-events: none;
}
.ship-card-header::after {
  content: '';
  position: absolute;
  bottom: -40px; right: -40px;
  width: 160px; height: 160px; border-radius: 50%;
  background: radial-gradient(circle, rgba(227,30,36,0.22) 0%, transparent 65%);
  pointer-events: none;
}
.ship-card-header svg {
  width: 22px; height: 22px; flex-shrink: 0;
  position: relative; z-index: 1;
}
.ship-card-header h3 {
  font-size: 1.05rem; font-weight: 800;
  margin: 0; line-height: 1.2;
  letter-spacing: -0.015em;
  position: relative; z-index: 1;
}
.ship-card-header p {
  font-size: 0.8rem; opacity: 0.55; margin: 0.25rem 0 0;
  position: relative; z-index: 1;
}
.ship-card-body { padding: 2rem 2rem; }

/* ══════════════════════════════════════════
   ONGKIR BANNER
══════════════════════════════════════════ */
.ongkir-banner {
  background: linear-gradient(155deg, var(--navy-800) 0%, var(--navy-700) 100%);
  border-radius: 16px; padding: 1.4rem 1.8rem;
  display: flex; align-items: center; justify-content: space-between;
  flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem;
  position: relative; overflow: hidden;
}
.ongkir-banner::after {
  content: '';
  position: absolute; bottom: -30px; right: -30px;
  width: 160px; height: 160px; border-radius: 50%;
  background: radial-gradient(circle, rgba(227,30,36,0.25) 0%, transparent 65%);
  pointer-events: none;
}
.ongkir-banner-left { color: white; position: relative; z-index: 1; }
.ob-label  {
  font-size: 0.65rem; font-weight: 800;
  opacity: 0.6; letter-spacing: 0.1em;
  text-transform: uppercase;
}
.ob-price  {
  font-size: 1.9rem; font-weight: 900;
  letter-spacing: -0.04em; line-height: 1.1;
  color: #fff; margin-top: 0.1rem;
}
.ob-detail {
  font-size: 0.75rem; opacity: 0.5; margin-top: 0.2rem;
}
.ongkir-banner-right {
  display: flex; gap: 0.55rem; flex-wrap: wrap;
  position: relative; z-index: 1;
}
.ob-chip {
  background: rgba(255,255,255,0.1);
  border: 1px solid rgba(255,255,255,0.2);
  border-radius: 10px; padding: 0.45rem 1rem;
  color: white; font-size: 0.75rem; font-weight: 700;
  white-space: nowrap;
}

/* ══════════════════════════════════════════
   FORM GRID
══════════════════════════════════════════ */
.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
.form-grid .full { grid-column: 1 / -1; }

.sf-group { display: flex; flex-direction: column; gap: 0.4rem; }
.sf-group label {
  font-size: 0.75rem; font-weight: 700;
  color: var(--text-primary); letter-spacing: 0.01em;
  display: flex; align-items: center; gap: 0.3rem;
}
.sf-group label span.req { color: var(--red); }

.locked-badge {
  display: inline-flex; align-items: center; gap: 0.25rem;
  font-size: 0.62rem; font-weight: 700; color: var(--text-muted);
  background: var(--surface-2); border: 1px solid var(--border);
  border-radius: 6px; padding: 0.15rem 0.5rem; margin-left: 0.4rem;
}
.locked-badge svg { width: 10px; height: 10px; }

.sf-group input:not([type="checkbox"]),
.sf-group select,
.sf-group textarea {
  width: 100%;
  padding: 0.85rem 1.1rem;
  border-radius: 12px;
  border: 1.5px solid var(--border);
  background: var(--surface);
  font-size: 0.9rem; font-weight: 500;
  color: var(--text-primary);
  font-family: 'Plus Jakarta Sans', sans-serif;
  outline: none;
  transition: all 0.2s var(--ease-out);
}
.sf-group select { cursor: pointer; }
.sf-group input:not([type="checkbox"]):focus,
.sf-group select:focus,
.sf-group textarea:focus {
  border-color: var(--red);
  background: var(--white);
  box-shadow: 0 0 0 3px rgba(227,30,36,0.08);
}
.sf-group input:not([type="checkbox"]):hover,
.sf-group select:hover { border-color: var(--border-2); }
.sf-group textarea { resize: vertical; min-height: 80px; }
.sf-group input:not([type="checkbox"])[readonly] {
  background: var(--surface-2);
  cursor: not-allowed; color: var(--text-muted);
}

.phone-wrap { display: flex; gap: 0.6rem; }
.phone-wrap select { width: 118px; flex-shrink: 0; }
.phone-wrap input  { flex: 1; }

.step-panel         { display: none; }
.step-panel.active  { display: block; }

/* ══════════════════════════════════════════
   NAVIGATION BUTTONS
══════════════════════════════════════════ */
.ship-nav {
  max-width: 860px; margin: 0 auto 3rem;
  display: flex; justify-content: space-between; align-items: center; gap: 0.75rem;
}
.ship-nav.justify-end { justify-content: flex-end; }

.btn-back {
  display: inline-flex; align-items: center; gap: 0.55rem;
  padding: 0.85rem 1.6rem; border-radius: 12px;
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 0.875rem; font-weight: 700;
  background: var(--white); color: var(--text-muted);
  border: 1.5px solid var(--border);
  cursor: pointer; text-decoration: none;
  transition: all 0.25s var(--ease-out);
}
.btn-back:hover {
  border-color: var(--border-2); color: var(--text-primary);
  transform: translateY(-2px); box-shadow: var(--shadow-sm);
}

.btn-next,
.btn-submit {
  display: inline-flex; align-items: center; gap: 0.55rem;
  padding: 0.9rem 2rem; border-radius: 12px;
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 0.9rem; font-weight: 700;
  background: var(--red); color: white;
  border: none; cursor: pointer;
  transition: all 0.25s var(--ease-out);
  box-shadow: 0 8px 24px rgba(227,30,36,0.35), inset 0 1px 0 rgba(255,255,255,0.12);
  letter-spacing: 0.01em;
}
.btn-next:hover,
.btn-submit:hover {
  background: var(--red-hover);
  transform: translateY(-2px);
  box-shadow: 0 14px 36px rgba(227,30,36,0.45);
}
.btn-next:active,
.btn-submit:active { transform: translateY(0); }
.btn-next svg, .btn-submit svg, .btn-back svg { width: 16px; height: 16px; }

/* ══════════════════════════════════════════
   FORM VALIDATION STATES
══════════════════════════════════════════ */
.sf-group.has-error input:not([type="checkbox"]),
.sf-group.has-error select,
.sf-group.has-error textarea {
  border-color: var(--red) !important;
  background: #fff5f5 !important;
  box-shadow: 0 0 0 3px rgba(227,30,36,0.08) !important;
}
.sf-group .error-msg {
  display: none;
  font-size: 0.7rem; font-weight: 600; color: var(--red);
  margin-top: 0.1rem;
}
.sf-group.has-error .error-msg { display: block; }

/* ══════════════════════════════════════════
   TERMS CARD
══════════════════════════════════════════ */
.terms-card {
  max-width: 860px; margin: 0 auto 1.5rem;
  background: var(--white);
  border-radius: 22px;
  box-shadow: var(--shadow-card);
  border: 1px solid var(--border);
  overflow: hidden;
}
.terms-inner {
  padding: 1.5rem 2rem;
  background: linear-gradient(135deg, rgba(10,26,74,0.03) 0%, rgba(227,30,36,0.02) 100%);
  border-radius: 22px;
}
.terms-check-wrap {
  display: flex; align-items: center; gap: 1rem;
  padding: 1rem 1.4rem;
  border-radius: 14px;
  border: 1.5px solid var(--border);
  background: var(--white);
  cursor: pointer; transition: all 0.25s var(--ease-out);
  user-select: none;
}
.terms-check-wrap:hover {
  border-color: var(--navy-600);
  background: rgba(10,26,74,0.02);
  box-shadow: 0 2px 12px rgba(9,24,60,0.08);
}
.custom-check-box {
  width: 24px; height: 24px; min-width: 24px;
  border-radius: 7px;
  border: 1.5px solid var(--border-2);
  background: var(--white);
  display: flex; align-items: center; justify-content: center;
  transition: all 0.25s var(--ease-spring); flex-shrink: 0;
}
.custom-check-box svg {
  width: 14px; height: 14px; stroke: white;
  opacity: 0; transform: scale(0.4) rotate(-10deg);
  transition: all 0.25s var(--ease-spring);
}
#termsCheckbox:checked ~ .terms-check-wrap .custom-check-box,
.terms-check-wrap.is-checked .custom-check-box {
  background: linear-gradient(135deg, var(--navy-800), var(--red));
  border-color: transparent;
  box-shadow: 0 4px 12px rgba(9,24,60,0.3);
}
#termsCheckbox:checked ~ .terms-check-wrap .custom-check-box svg,
.terms-check-wrap.is-checked .custom-check-box svg {
  opacity: 1; transform: scale(1) rotate(0deg);
}
#termsCheckbox:checked ~ .terms-check-wrap,
.terms-check-wrap.is-checked {
  border-color: var(--green);
  background: rgba(22,163,74,0.04);
  box-shadow: 0 2px 12px rgba(22,163,74,0.12);
}
#termsCheckbox {
  position: absolute; opacity: 0;
  width: 0; height: 0; pointer-events: none;
}
.terms-check-text {
  font-size: 0.875rem; color: var(--text-2);
  line-height: 1.6; font-weight: 500; flex: 1;
}
.terms-check-text a {
  color: var(--red); font-weight: 700; text-decoration: none;
  transition: opacity 0.2s;
}
.terms-check-text a:hover { opacity: 0.75; }

/* ══════════════════════════════════════════
   RESPONSIVE
══════════════════════════════════════════ */
@media (max-width: 768px) {
  .book-page .container { padding: 0 1.5rem; }
  .page-hero { padding: 4rem 0 3rem; }
  .page-hero-heading { font-size: clamp(2rem, 6vw, 3rem); }
}
@media (max-width: 640px) {
  .book-page .container { padding: 0 1.25rem; }
  .form-grid { grid-template-columns: 1fr; }
  .form-grid .full { grid-column: 1; }
  .ship-card-body { padding: 1.5rem 1.25rem; }
  .step-label { display: none; }
  .step-line  { margin: 0 8px; min-width: 28px; }
  .ongkir-banner { flex-direction: column; }
  .phone-wrap { flex-direction: column; }
  .phone-wrap select { width: 100%; }
}
</style>

<div class="book-page">

  {{-- ══ BOOK FORM ══ --}}
  <div class="book-wrap">
    <div class="container">

      {{-- Stepper --}}
      <div class="ship-stepper" id="stepper">
        <div class="step-item active" id="step-item-1">
          <div class="step-dot">
            <div class="step-circle" id="sc-1">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path d="M17.657 16.657L13.414 20.9a2 2 0 0 1-2.827 0l-4.244-4.243a8 8 0 1 1 11.314 0z"/>
                <path d="M15 11a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
              </svg>
            </div>
            <span class="step-label">Receiver Details</span>
          </div>
        </div>
        <div class="step-line" id="line-1"></div>
        <div class="step-item" id="step-item-2">
          <div class="step-dot">
            <div class="step-circle" id="sc-2">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <rect x="2" y="7" width="20" height="14" rx="2"/>
                <path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/>
              </svg>
            </div>
            <span class="step-label">Shipment Details</span>
          </div>
        </div>
      </div>

      {{-- Alert validasi global --}}
      <div class="validation-alert hidden" id="validationAlert">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16" stroke-width="3" stroke-linecap="round"/>
        </svg>
        <span id="validationMsg">Harap lengkapi semua kolom yang wajib diisi sebelum melanjutkan.</span>
      </div>

      <form method="POST" action="{{ route('shipment.store') }}" id="shipForm" class="manual-loading">
        @csrf

        {{-- ══ STEP 1 — RECEIVER ══ --}}
        <div class="step-panel active" id="panel-1">
          <div class="ship-card">
            <div class="ship-card-header">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M17.657 16.657L13.414 20.9a2 2 0 0 1-2.827 0l-4.244-4.243a8 8 0 1 1 11.314 0z"/>
                <path d="M15 11a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
              </svg>
              <div>
                <h3 style="color:white">Receiver Details</h3>
                <p>Informasi penerima paket</p>
              </div>
            </div>
            <div class="ship-card-body">
              <div class="form-grid">
                <div class="sf-group" id="grp-receiver_name">
                  <label>Receiver Name <span class="req">*</span></label>
                  <input type="text" name="receiver_name" placeholder="Contoh: Farel" required value="{{ old('receiver_name') }}">
                  <span class="error-msg">Nama penerima wajib diisi.</span>
                </div>
                <div class="sf-group" id="grp-receiver_company">
                  <label>Company Name</label>
                  <input type="text" name="receiver_company" placeholder="Contoh: ICE Express" value="{{ old('receiver_company') }}">
                </div>
                <div class="sf-group" id="grp-receiver_email">
                  <label>Email Address <span class="req">*</span></label>
                  <input type="email" name="receiver_email" placeholder="Contoh: indocahayaexpress@email.com" required value="{{ old('receiver_email') }}">
                  <span class="error-msg">Email penerima wajib diisi.</span>
                </div>

                {{-- COUNTRY FIELD dengan locked badge jika dari kalkulator --}}
                <div class="sf-group" id="grp-receiver_country">
                  <label>
                    Country / Negara Tujuan <span class="req">*</span>
                    @if($from_calc)
                    <span class="locked-badge">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                      Terkunci
                    </span>
                    @endif
                  </label>
                  @if($from_calc && $country_name)
                    <input type="text" value="{{ $country_name }}" readonly>
                    <input type="hidden" name="receiver_country" value="{{ $country_id }}">
                  @else
                    <select name="receiver_country" required>
                      <option value="">-- Pilih Negara --</option>
                      @foreach($countries as $c)
                        <option value="{{ $c->id }}" {{ old('receiver_country') == $c->id ? 'selected' : '' }}>{{ $c->country_name }}</option>
                      @endforeach
                    </select>
                  @endif
                  <span class="error-msg">Negara tujuan wajib dipilih.</span>
                </div>

                <div class="sf-group" id="grp-receiver_city">
                  <label>City / Kota <span class="req">*</span></label>
                  <input type="text" name="receiver_city" placeholder="Contoh: New York" required value="{{ old('receiver_city') }}">
                  <span class="error-msg">Kota penerima wajib diisi.</span>
                </div>
                <div class="sf-group" id="grp-receiver_zip">
                  <label>Zip Code <span class="req">*</span></label>
                  <input type="text" name="receiver_zip" placeholder="Contoh: 50000" required value="{{ old('receiver_zip') }}">
                  <span class="error-msg">Zip code wajib diisi.</span>
                </div>
                <div class="sf-group" id="grp-receiver_address1">
                  <label>Address Line 1 <span class="req">*</span></label>
                  <input type="text" name="receiver_address1" placeholder="Contoh: 1234 Main St," required value="{{ old('receiver_address1') }}">
                  <span class="error-msg">Alamat wajib diisi.</span>
                </div>
                <div class="sf-group">
                  <label>Address Line 2</label>
                  <input type="text" name="receiver_address2" placeholder="Contoh: Unit 3B (opsional)" value="{{ old('receiver_address2') }}">
                </div>
                <div class="sf-group" id="grp-receiver_phone">
                  <label>Phone Number <span class="req">*</span></label>
                  <div class="phone-wrap">
                    <select name="receiver_phone_code">
                      <option value="+62">+62 ID</option>
                      <option value="+1">+1 US/CA</option>
                      <option value="+44">+44 UK</option>
                      <option value="+65">+65 SG</option>
                      <option value="+60">+60 MY</option>
                      <option value="+61">+61 AU</option>
                      <option value="+81">+81 JP</option>
                      <option value="+86">+86 CN</option>
                      <option value="+91">+91 IN</option>
                    </select>
                    <input type="tel" name="receiver_phone" placeholder="Contoh: 123456789" required pattern="[0-9]*" value="{{ old('receiver_phone') }}">
                  </div>
                  <span class="error-msg">Nomor telepon penerima wajib diisi.</span>
                </div>
              </div>
            </div>
          </div>
          <div class="ship-nav justify-end">
            <button type="button" class="btn-next" onclick="goStep(2)">
              Lanjut
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
            </button>
          </div>
        </div>

        {{-- ══ STEP 2 — SHIPMENT DETAILS ══ --}}
        <div class="step-panel" id="panel-2">
          <div class="ship-card">
            <div class="ship-card-header">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <rect x="2" y="7" width="20" height="14" rx="2"/>
                <path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/>
              </svg>
              <div>
                <h3>Shipment Details</h3>
                <p>Detail paket dan layanan pengiriman</p>
              </div>
            </div>
            <div class="ship-card-body">

              {{-- Banner Ongkir (hanya tampil jika berasal dari calculator) --}}
              @if($from_calc && $price)
              <div class="ongkir-banner">
                <div class="ongkir-banner-left">
                  <div class="ob-label">ESTIMASI ONGKIR</div>
                  <div class="ob-price">Rp {{ number_format($price, 0, ',', '.') }}</div>
                  <div class="ob-detail">{{ number_format($chargeable, 2) }} kg &times; tarif / kg</div>
                </div>
                <div class="ongkir-banner-right">
                  <div class="ob-chip">{{ $country_name }}</div>
                  <div class="ob-chip">{{ $vendor }}</div>
                  <div class="ob-chip">{{ $weight }} kg</div>
                </div>
              </div>
              @endif

              <div class="form-grid">
                {{-- Berat Aktual --}}
                <div class="sf-group" id="grp-weight">
                  <label>
                    Berat Aktual (kg) <span class="req">*</span>
                    @if($from_calc)
                    <span class="locked-badge">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                      Terkunci
                    </span>
                    @endif
                  </label>
                  <input type="number" name="weight" step="0.1" min="0.1"
                         placeholder="Contoh: 2.5"
                         value="{{ old('weight', $weight) }}"
                         {{ $from_calc ? 'readonly' : '' }}
                         required>
                  <span class="error-msg">Berat aktual wajib diisi.</span>
                </div>

                {{-- Berat Volumetrik (readonly) --}}
                <div class="sf-group">
                  <label>Berat Volumetrik (kg)</label>
                  <input type="number" name="volumetric_weight" step="0.01" id="volWeight"
                         value="{{ old('volumetric_weight', $volumetric) }}" readonly>
                </div>

                {{-- Panjang --}}
                <div class="sf-group" id="grp-length">
                  <label>
                    Panjang (cm) <span class="req">*</span>
                    @if($from_calc)
                    <span class="locked-badge">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                      Terkunci
                    </span>
                    @endif
                  </label>
                  <input type="number" name="length" step="0.1" min="1"
                         placeholder="Contoh: 30"
                         value="{{ old('length', $length) }}"
                         {{ $from_calc ? 'readonly' : 'oninput="calcVol()"' }}
                         required>
                  <span class="error-msg">Panjang wajib diisi.</span>
                </div>

                {{-- Lebar --}}
                <div class="sf-group" id="grp-width">
                  <label>
                    Lebar (cm) <span class="req">*</span>
                    @if($from_calc)
                    <span class="locked-badge">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                      Terkunci
                    </span>
                    @endif
                  </label>
                  <input type="number" name="width" step="0.1" min="1"
                         placeholder="Contoh: 20"
                         value="{{ old('width', $width) }}"
                         {{ $from_calc ? 'readonly' : 'oninput="calcVol()"' }}
                         required>
                  <span class="error-msg">Lebar wajib diisi.</span>
                </div>

                {{-- Tinggi --}}
                <div class="sf-group" id="grp-height">
                  <label>
                    Tinggi (cm) <span class="req">*</span>
                    @if($from_calc)
                    <span class="locked-badge">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                      Terkunci
                    </span>
                    @endif
                  </label>
                  <input type="number" name="height" step="0.1" min="1"
                         placeholder="Contoh: 15"
                         value="{{ old('height', $height) }}"
                         {{ $from_calc ? 'readonly' : 'oninput="calcVol()"' }}
                         required>
                  <span class="error-msg">Tinggi wajib diisi.</span>
                </div>

                {{-- Service (vendor) hidden --}}
                <input type="hidden" name="service" value="{{ old('service', $vendor) }}">

                {{-- Deskripsi --}}
                <div class="sf-group" id="grp-content_description">
                  <label>Deskripsi Isi Paket <span class="req">*</span></label>
                  <input type="text" name="content_description" placeholder="Contoh: Pakaian, Elektronik, Dokumen" required value="{{ old('content_description') }}">
                  <span class="error-msg">Deskripsi isi paket wajib diisi.</span>
                </div>

                {{-- Jumlah Item --}}
                <div class="sf-group" id="grp-item_qty">
                  <label>Jumlah Item <span class="req">*</span></label>
                  <input type="number" name="item_qty" min="1" placeholder="Contoh: 3" required value="{{ old('item_qty') }}">
                  <span class="error-msg">Jumlah item wajib diisi.</span>
                </div>

                {{-- Harga Barang --}}
                <div class="sf-group" id="grp-item_value">
                  <label>Harga Barang (USD) <span class="req">*</span></label>
                  <input type="number" name="item_value" min="0" placeholder="Contoh: 100" required value="{{ old('item_value') }}">
                  <span class="error-msg">Harga barang wajib diisi.</span>
                </div>

                {{-- VAT & Catatan --}}
                <div class="sf-group" id="grp-vat_number">
                  <label>Tax ID / VAT / EIN Number</label>
                  <input type="text" name="vat_number" placeholder="Contoh: GB123456789" value="{{ old('vat_number') }}">
                </div>
                <div class="sf-group" id="grp-notes">
                  <label>Catatan Tambahan</label>
                  <input type="text" name="notes" placeholder="Contoh: Fragile, handle with care" value="{{ old('notes') }}">
                </div>

                {{-- Hidden fields untuk data kalkulator --}}
                <input type="hidden" name="price"      value="{{ old('price', $price) }}">
                <input type="hidden" name="country_id" value="{{ old('country_id', $country_id) }}">
                <input type="hidden" name="user_id"    value="{{ $user->id ?? '' }}">
              </div>
            </div>
          </div>

          {{-- Terms & Conditions --}}
          <div class="terms-card">
            <div class="terms-inner">
              <div class="sf-group" id="grp-terms">
                <input type="checkbox" name="terms_accepted" id="termsCheckbox">
                <label class="terms-check-wrap" for="termsCheckbox" id="termsWrap">
                  <div class="custom-check-box" id="customCheckBox">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                      <polyline points="20 6 9 17 4 12"/>
                    </svg>
                  </div>
                  <span class="terms-check-text">
                    Bersedia jika ada penambahan <a href="{{ route('faq') }}" target="_blank" onclick="event.stopPropagation()">tarif (FRDM)</a> sesuai ketentuan yang berlaku
                  </span>
                </label>
                <span class="error-msg" style="margin-top: 6px; padding-left: 4px;">Anda harus menyetujui ketentuan FRDM untuk melanjutkan.</span>
              </div>
            </div>
          </div>

          <div class="ship-nav">
            <button type="button" class="btn-back" onclick="goStep(1)">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
              Kembali
            </button>
            <button type="submit" class="btn-submit" id="submitBtn">
              Lanjutkan
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
            </button>
          </div>
        </div>
      </form>

    </div>
  </div>

</div>

<script>
function syncCheckbox() {
    const cb   = document.getElementById('termsCheckbox');
    const wrap = document.getElementById('termsWrap');
    const grp  = document.getElementById('grp-terms');
    if (cb.checked) {
        wrap.classList.add('is-checked');
        grp.classList.remove('has-error');
        grp.querySelector('.error-msg').style.display = 'none';
    } else {
        wrap.classList.remove('is-checked');
    }
}
document.getElementById('termsCheckbox').addEventListener('change', syncCheckbox);

document.getElementById('shipForm').addEventListener('submit', function(e) {
    const termsCheckbox = document.getElementById('termsCheckbox');
    const termsGrp      = document.getElementById('grp-terms');
    const termsErrorMsg = termsGrp.querySelector('.error-msg');
    if (!termsCheckbox.checked) {
        e.preventDefault();
        termsGrp.classList.add('has-error');
        termsErrorMsg.style.display = 'block';
        termsGrp.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return;
    } else {
        termsGrp.classList.remove('has-error');
        termsErrorMsg.style.display = 'none';
    }
    // === TAMPILKAN LOADING MANUAL SETELAH VALIDASI SUKSES ===
    if (typeof showGlobalLoading !== 'undefined') showGlobalLoading();
    // Form akan submit secara normal
});

function validatePanel(panelId) {
    const panel = document.getElementById(panelId);
    let isValid = true;
    const fields = panel.querySelectorAll('input[required]:not([type="checkbox"]), select[required], textarea[required]');
    fields.forEach(function(field) {
        if (field.readOnly) return;
        const grpId = 'grp-' + field.name;
        const grp = document.getElementById(grpId);
        const val = field.value.trim();
        if (field.type === 'email' && val) {
            const emailOk = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val);
            if (!emailOk) {
                if (grp) {
                    grp.classList.add('has-error');
                    const msg = grp.querySelector('.error-msg');
                    if (msg) msg.textContent = 'Format email tidak valid.';
                }
                isValid = false;
                return;
            }
        }
        if (!val) {
            if (grp) grp.classList.add('has-error');
            isValid = false;
        } else {
            if (grp) grp.classList.remove('has-error');
        }
    });
    const selects = panel.querySelectorAll('select[required]');
    selects.forEach(function(sel) {
        if (!sel.value) {
            const grp = document.getElementById('grp-' + sel.name);
            if (grp) grp.classList.add('has-error');
            isValid = false;
        } else {
            const grp = document.getElementById('grp-' + sel.name);
            if (grp) grp.classList.remove('has-error');
        }
    });
    const alert = document.getElementById('validationAlert');
    const msg   = document.getElementById('validationMsg');
    if (!isValid) {
        alert.classList.remove('hidden');
        msg.textContent = 'Harap lengkapi semua kolom yang wajib diisi (ditandai merah) sebelum melanjutkan.';
        alert.scrollIntoView({ behavior: 'smooth', block: 'center' });
    } else {
        alert.classList.add('hidden');
    }
    fields.forEach(function(field) {
        field.addEventListener('input', function() {
            const grp = document.getElementById('grp-' + field.name);
            if (grp && field.value.trim()) grp.classList.remove('has-error');
        });
        field.addEventListener('change', function() {
            const grp = document.getElementById('grp-' + field.name);
            if (grp && field.value) grp.classList.remove('has-error');
        });
    });
    return isValid;
}

function goStep(n) {
    if (n === 2) {
        if (!validatePanel('panel-1')) return;
    }
    document.querySelectorAll('.step-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.step-item').forEach(i => i.classList.remove('active', 'done'));
    document.getElementById('panel-' + n).classList.add('active');
    document.getElementById('step-item-' + n).classList.add('active');
    for (let i = 1; i < n; i++) {
        document.getElementById('step-item-' + i).classList.add('done');
        if (document.getElementById('line-' + i))
            document.getElementById('line-' + i).style.background = '#22c55e';
    }
    for (let i = n; i <= 1; i++) {
        if (document.getElementById('line-' + i))
            document.getElementById('line-' + i).style.background = 'var(--border)';
    }
    document.getElementById('validationAlert').classList.add('hidden');
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function calcVol() {
    @if(!$from_calc)
    const l = parseFloat(document.querySelector('[name=length]').value)  || 0;
    const w = parseFloat(document.querySelector('[name=width]').value)   || 0;
    const h = parseFloat(document.querySelector('[name=height]').value)  || 0;
    if (l && w && h) document.getElementById('volWeight').value = ((l * w * h) / 5000).toFixed(2);
    @endif
}

window.addEventListener('DOMContentLoaded', function() {
    calcVol();
});
</script>
@endsection
