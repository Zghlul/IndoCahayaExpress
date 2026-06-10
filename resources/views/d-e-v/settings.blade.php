@extends('layouts.app')
@section('title', 'Pengaturan Sistem - Indo Cahaya Express')
@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300&display=swap');

/* ══ ICE Design System — Settings ══ */
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
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(28px); }
  to   { opacity: 1; transform: translateY(0); }
}
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(6px); }
  to   { opacity: 1; transform: translateY(0); }
}

/* ── PAGE SHELL ── */
.st-shell {
  font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
  background: var(--surface);
  min-height: calc(100vh - 200px);
  padding: 3rem 0 5rem;
}
.st-container {
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
  width: 40px; height: 40px; background: rgba(255,255,255,0.1);
  border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;
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
.st-hero {
  position: relative;
  overflow: hidden;
  border-radius: 24px;
  margin-bottom: 2rem;
  box-shadow: 0 20px 60px rgba(6,15,46,0.30);
  min-height: 190px;
  display: flex;
  align-items: center;
}
.st-hero-canvas {
  position: absolute; inset: 0; z-index: 0;
  background:
    radial-gradient(ellipse 100% 80% at 100% 0%,  rgba(20,56,160,0.55) 0%, transparent 55%),
    radial-gradient(ellipse 70%  60% at 0%  100%, rgba(227,30,36,0.10) 0%, transparent 50%),
    radial-gradient(ellipse 60%  70% at 55% 50%,  rgba(11,26,74,0.9)   0%, transparent 70%),
    linear-gradient(168deg, var(--navy-900) 0%, #0B1C55 45%, #091640 100%);
}
.st-hero-canvas::after {
  content: '';
  position: absolute; inset: 0;
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.035'/%3E%3C/svg%3E");
  pointer-events: none; mix-blend-mode: overlay; opacity: 0.5;
}
.st-hero-grid {
  position: absolute; inset: 0; z-index: 0;
  background-image: radial-gradient(circle, rgba(255,255,255,0.055) 1px, transparent 1px);
  background-size: 44px 44px;
  mask-image: radial-gradient(ellipse 90% 80% at 50% 50%, black 40%, transparent 80%);
}
.st-hero-lines {
  position: absolute; inset: 0; z-index: 0; overflow: hidden;
}
.st-hero-lines::before,
.st-hero-lines::after {
  content: ''; position: absolute; top: 0; bottom: 0; width: 1px;
}
.st-hero-lines::before {
  right: 34%;
  background: linear-gradient(to bottom, transparent 0%, rgba(227,30,36,0.35) 25%, rgba(227,30,36,0.15) 70%, transparent 100%);
}
.st-hero-lines::after {
  left: 52%;
  background: linear-gradient(to bottom, transparent 10%, rgba(59,174,224,0.12) 40%, rgba(59,174,224,0.06) 75%, transparent 100%);
}
.st-hero-glow {
  position: absolute; z-index: 0; border-radius: 50%; filter: blur(80px); pointer-events: none;
}
.st-hero-glow-1 {
  width: 600px; height: 600px; top: -200px; right: -80px;
  background: radial-gradient(circle, rgba(20,56,160,0.4) 0%, transparent 65%);
}
.st-hero-glow-2 {
  width: 350px; height: 350px; bottom: -100px; left: 0;
  background: radial-gradient(circle, rgba(227,30,36,0.12) 0%, transparent 65%);
}
.st-hero-inner {
  position: relative; z-index: 2;
  width: 100%;
  padding: 2.5rem;
}
.st-hero-eyebrow {
  display: inline-flex; align-items: center; gap: 0.6rem;
  margin-bottom: 1.1rem;
  padding: 0.4rem 1rem 0.4rem 0.55rem;
  border-radius: 99px;
  border: 1px solid rgba(227,30,36,0.3);
  background: rgba(227,30,36,0.07);
  backdrop-filter: blur(10px);
}
.st-hero-eyebrow-dot {
  width: 22px; height: 22px; border-radius: 50%;
  background: linear-gradient(135deg, var(--red), var(--red-deep));
  display: flex; align-items: center; justify-content: center; flex-shrink: 0;
  box-shadow: 0 4px 12px rgba(227,30,36,0.4);
}
.st-hero-eyebrow-dot svg { width: 11px; height: 11px; color: #fff; }
.st-hero-eyebrow span {
  font-size: 0.68rem; font-weight: 800; letter-spacing: 0.12em;
  text-transform: uppercase; color: rgba(255,255,255,0.75);
  padding-right: 0.3rem;
}
.st-hero h1 {
  font-size: clamp(1.6rem, 3vw, 2.4rem);
  font-weight: 900; color: #fff;
  letter-spacing: -0.03em; margin: 0 0 0.5rem; line-height: 1.05;
}
.st-hero p { font-size: 0.95rem; color: rgba(255,255,255,0.55); margin: 0; font-weight: 400; line-height: 1.6; }

/* ── LAYOUT ── */
.st-layout {
  display: flex;
  gap: 1.5rem;
  align-items: flex-start;
}

/* ── SIDEBAR ── */
.st-sidebar {
  width: 252px;
  flex-shrink: 0;
  background: var(--white);
  border: 1px solid var(--border);
  border-radius: 18px;
  overflow: hidden;
  position: sticky;
  top: 1.5rem;
  box-shadow: var(--shadow-sm);
}
.st-sidebar-hdr {
  padding: 1rem 1.25rem;
  background: var(--navy-900);
}
.st-sidebar-hdr h3 {
  font-size: 0.7rem; font-weight: 800; text-transform: uppercase;
  letter-spacing: 0.12em; color: rgba(255,255,255,0.75); margin: 0;
  display: flex; align-items: center; gap: 0.5rem;
}
.st-sidebar-hdr h3 svg { width: 14px; height: 14px; opacity: 0.7; }
.st-nav { display: flex; flex-direction: column; padding: 0.4rem 0; }
.st-nav a {
  display: flex; align-items: center; gap: 0.65rem;
  padding: 0.75rem 1.25rem;
  font-size: 0.82rem; font-weight: 600;
  color: var(--text-2); text-decoration: none;
  border-left: 3px solid transparent;
  transition: all 0.15s;
}
.st-nav a svg { width: 16px; height: 16px; color: var(--text-muted); flex-shrink: 0; transition: color 0.15s; }
.st-nav a.active {
  background: rgba(227,30,36,0.05);
  border-left-color: var(--red);
  color: var(--red); font-weight: 700;
}
.st-nav a.active svg { color: var(--red); }
.st-nav a:hover:not(.active) {
  background: var(--surface-2); border-left-color: var(--border-2); color: var(--navy-900);
}
.st-nav a:hover:not(.active) svg { color: var(--navy-900); }
.st-nav-sep {
  height: 1px; background: var(--border); margin: 0.3rem 1.25rem;
}
.st-nav a.danger-link { color: #dc2626; }
.st-nav a.danger-link svg { color: #dc2626; }
.st-nav a.danger-link.active { background: rgba(220,38,38,0.05); border-left-color: #dc2626; }
.st-nav a.danger-link:hover:not(.active) { background: rgba(220,38,38,0.04); border-left-color: #fca5a5; color: #b91c1c; }
.st-nav a.danger-link:hover svg { color: #b91c1c; }

/* ── MAIN PANEL ── */
.st-main { flex: 1; min-width: 0; }
.st-panel {
  display: none;
  background: var(--white);
  border: 1px solid var(--border);
  border-radius: 18px;
  overflow: hidden;
  box-shadow: var(--shadow-sm);
  animation: fadeIn 0.2s ease both;
}
.st-panel.active { display: block; }

/* Panel header */
.st-panel-hdr {
  padding: 1.3rem 1.75rem;
  border-bottom: 1px solid var(--border);
  background: var(--surface);
  display: flex; align-items: center; gap: 0.85rem;
}
.st-panel-hdr-icon {
  width: 36px; height: 36px; border-radius: 10px;
  background: rgba(6,15,46,0.07); color: var(--navy-900);
  display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.st-panel-hdr-icon svg { width: 18px; height: 18px; }
.st-panel-hdr-txt h2 { font-size: 1rem; font-weight: 800; color: var(--text-primary); margin: 0 0 2px; letter-spacing: -0.01em; }
.st-panel-hdr-txt p  { font-size: 0.75rem; color: var(--text-muted); margin: 0; }
.st-panel-body { padding: 1.75rem; }

/* ── FORM ELEMENTS ── */
.st-form-grid {
  display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.1rem;
}
.st-fg { display: flex; flex-direction: column; gap: 0.35rem; }
.st-fg.full { grid-column: span 2; }
.st-fg label {
  font-size: 0.68rem; font-weight: 800; text-transform: uppercase;
  letter-spacing: 0.08em; color: var(--text-muted);
}
.st-fg input,
.st-fg select,
.st-fg textarea {
  padding: 10px 14px; border-radius: 10px;
  border: 1.5px solid var(--border); font-family: inherit;
  font-size: 0.85rem; background: var(--surface); color: var(--text-primary);
  transition: all 0.2s; box-sizing: border-box; outline: none;
  width: 100%;
}
.st-fg input:focus,
.st-fg select:focus,
.st-fg textarea:focus {
  border-color: var(--navy-900); box-shadow: 0 0 0 3px rgba(6,15,46,0.08); background: var(--white);
}
.st-fg textarea { resize: vertical; line-height: 1.5; }
.st-fg .hint { font-size: 0.7rem; color: var(--text-muted); }

/* Divider */
.st-divider { border: none; border-top: 1px solid var(--border); margin: 1.5rem 0; }

/* ── TOGGLE ROWS ── */
.toggle-row {
  display: flex; justify-content: space-between; align-items: center;
  padding: 1rem 0; border-bottom: 1px solid var(--border);
}
.toggle-row:last-of-type { border-bottom: none; }
.toggle-info h4 { font-size: 0.85rem; font-weight: 700; color: var(--text-primary); margin: 0 0 3px; }
.toggle-info p  { font-size: 0.75rem; color: var(--text-muted); margin: 0; }
.toggle-switch {
  position: relative; width: 46px; height: 24px; flex-shrink: 0;
}
.toggle-switch input { opacity: 0; width: 0; height: 0; }
.toggle-slider {
  position: absolute; cursor: pointer; inset: 0;
  background: var(--border-2); border-radius: 34px; transition: 0.25s;
}
.toggle-slider::before {
  content: ""; position: absolute;
  height: 18px; width: 18px; left: 3px; bottom: 3px;
  background: white; border-radius: 50%; transition: 0.25s;
  box-shadow: 0 1px 3px rgba(0,0,0,0.15);
}
.toggle-switch input:checked + .toggle-slider { background: var(--red); }
.toggle-switch input:checked + .toggle-slider::before { transform: translateX(22px); }

/* ── SAVE BUTTON ── */
.btn-st-save {
  display: inline-flex; align-items: center; gap: 7px;
  background: var(--navy-900); color: white;
  padding: 0.75rem 1.75rem; border-radius: 10px;
  font-weight: 700; font-size: 0.875rem; border: none;
  cursor: pointer; font-family: inherit; transition: all 0.18s; margin-top: 1.5rem;
  box-shadow: 0 4px 14px rgba(6,15,46,0.2);
}
.btn-st-save:hover { background: var(--navy-800); transform: translateY(-1px); box-shadow: 0 8px 24px rgba(6,15,46,0.3); }
.btn-st-save svg { width: 15px; height: 15px; }

/* ── INFO GRID (sysinfo) ── */
.info-grid {
  display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;
}
.info-card {
  background: var(--surface); border: 1px solid var(--border);
  border-radius: 12px; padding: 1rem 1.25rem;
  transition: all 0.2s var(--ease-out);
}
.info-card:hover { border-color: var(--border-2); box-shadow: var(--shadow-md); }
.info-card-label {
  font-size: 0.68rem; font-weight: 800; text-transform: uppercase;
  letter-spacing: 0.08em; color: var(--text-muted); margin-bottom: 0.35rem;
}
.info-card-value {
  font-size: 0.9rem; font-weight: 700; color: var(--text-primary);
  word-break: break-all;
}

/* ── DANGER ZONE ── */
.danger-card {
  background: rgba(220,38,38,0.03); border: 1px solid rgba(220,38,38,0.15);
  border-radius: 14px; overflow: hidden;
}
.danger-row {
  display: flex; justify-content: space-between; align-items: center;
  padding: 1.1rem 1.5rem; gap: 1rem; flex-wrap: wrap;
  border-bottom: 1px solid rgba(220,38,38,0.1);
}
.danger-row:last-child { border-bottom: none; }
.danger-row-info h4 { font-size: 0.875rem; font-weight: 700; color: var(--text-primary); margin: 0 0 3px; }
.danger-row-info p  { font-size: 0.78rem; color: var(--text-muted); margin: 0; }
.btn-danger {
  display: inline-flex; align-items: center; gap: 6px;
  padding: 8px 16px; background: rgba(220,38,38,0.07);
  color: #b91c1c; border: 1px solid rgba(220,38,38,0.25);
  border-radius: 8px; font-weight: 700; font-size: 0.8rem;
  cursor: pointer; font-family: inherit; transition: all 0.18s; white-space: nowrap;
}
.btn-danger:hover { background: #dc2626; color: white; border-color: #dc2626; }
.btn-danger svg { width: 13px; height: 13px; }

/* ── RESPONSIVE ── */
@media (max-width: 900px) {
  .st-layout { flex-direction: column; }
  .st-sidebar { width: 100%; position: static; }
  .st-nav { flex-direction: row; flex-wrap: wrap; padding: 0.5rem; gap: 0.25rem; }
  .st-nav a { border-left: none; border-bottom: 2px solid transparent; border-radius: 8px; padding: 0.5rem 0.85rem; }
  .st-nav a.active { border-left-color: transparent; border-bottom-color: var(--red); background: rgba(227,30,36,0.05); }
  .st-nav-sep { display: none; }
}
@media (max-width: 600px) {
  .st-container { padding: 0 1.25rem; }
  .st-shell { padding: 1.5rem 0 3rem; }
  .st-hero-inner { padding: 1.5rem; }
  .st-form-grid { grid-template-columns: 1fr; }
  .st-fg.full { grid-column: span 1; }
  .info-grid { grid-template-columns: 1fr; }
  .st-panel-body { padding: 1.25rem; }
}
</style>
@endpush

@section('content')

{{-- ═══ FLASH NOTIF ═══ --}}
@if(session('flash_settings'))
<div id="flash-notif">
  <div class="fn-icon">
    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
      <polyline points="20 6 9 17 4 12"/>
    </svg>
  </div>
  <div class="fn-body">
    <div class="fn-title">Tersimpan</div>
    {{ session('flash_settings') }}
  </div>
  <button class="fn-close" onclick="this.parentElement.remove()">&times;</button>
</div>
<script>setTimeout(() => document.getElementById('flash-notif')?.remove(), 4500);</script>
@endif

<div class="st-shell">
  <div class="st-container">

    {{-- ═══ HERO ═══ --}}
    <section class="st-hero">
      <div class="st-hero-canvas"></div>
      <div class="st-hero-grid"></div>
      <div class="st-hero-lines"></div>
      <div class="st-hero-glow st-hero-glow-1"></div>
      <div class="st-hero-glow st-hero-glow-2"></div>
      <div class="st-hero-inner">
        <div class="st-hero-eyebrow">
          <div class="st-hero-eyebrow-dot">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <circle cx="12" cy="12" r="3"/>
              <path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/>
            </svg>
          </div>
          <span>Pengaturan</span>
        </div>
        <h1>Pengaturan Sistem</h1>
        <p>Kelola konfigurasi website, maintenance mode, SMTP, tarif, keamanan, dan lainnya.</p>
      </div>
    </section>

    @php
      $activeTab = request('tab', 'general');
      $settings = [
        'site_name'            => $settings['site_name']            ?? 'Indo Cahaya Express',
        'site_tagline'         => $settings['site_tagline']         ?? 'Fast & Reliable',
        'site_email'           => $settings['site_email']           ?? 'indocahayaexpress@gmail.com',
        'site_phone'           => $settings['site_phone']           ?? '+62 812 3456 7890',
        'site_address'         => $settings['site_address']         ?? 'Perum. Citra Indah Bukit Amarilis Blok AR 00 no. 010',
        'maintenance_mode'     => $settings['maintenance_mode']     ?? '0',
        'smtp_host'            => $settings['smtp_host']            ?? '',
        'smtp_port'            => $settings['smtp_port']            ?? '587',
        'smtp_user'            => $settings['smtp_user']            ?? '',
        'smtp_pass'            => $settings['smtp_pass']            ?? '',
        'smtp_encryption'      => $settings['smtp_encryption']      ?? 'tls',
        'mail_from_name'       => $settings['mail_from_name']       ?? '',
        'mail_from_email'      => $settings['mail_from_email']      ?? '',
        'default_currency'     => $settings['default_currency']     ?? 'IDR',
        'weight_unit'          => $settings['weight_unit']          ?? 'kg',
        'dimension_unit'       => $settings['dimension_unit']       ?? 'cm',
        'max_weight'           => $settings['max_weight']           ?? '70',
        'insurance_rate'       => $settings['insurance_rate']       ?? '0.5',
        'fuel_surcharge'       => $settings['fuel_surcharge']       ?? '5',
        'war_risk_percent'     => $settings['war_risk_percent']     ?? '32',
        'ddp_percent'          => $settings['ddp_percent']          ?? '19',
        'session_lifetime'     => $settings['session_lifetime']     ?? '120',
        'max_login_attempts'   => $settings['max_login_attempts']   ?? '5',
        'lockout_duration'     => $settings['lockout_duration']     ?? '30',
        'require_email_verify' => $settings['require_email_verify'] ?? '0',
        'two_factor_admin'     => $settings['two_factor_admin']     ?? '0',
        'google_maps_key'      => $settings['google_maps_key']      ?? '',
        'recaptcha_site_key'   => $settings['recaptcha_site_key']   ?? '',
        'recaptcha_secret_key' => $settings['recaptcha_secret_key'] ?? '',
        'whatsapp_api_token'   => $settings['whatsapp_api_token']   ?? '',
        'whatsapp_number'      => $settings['whatsapp_number']      ?? '',
        'exchange_rate_api_url'=> $settings['exchange_rate_api_url']?? '',
      ];
    @endphp

    {{-- ═══ LAYOUT ═══ --}}
    <div class="st-layout">

      {{-- ─── SIDEBAR ─── --}}
      <aside class="st-sidebar reveal">
        <div class="st-sidebar-hdr">
          <h3>
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="3"/>
              <path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/>
            </svg>
            Konfigurasi
          </h3>
        </div>
        <nav class="st-nav">
          <a href="?tab=general" class="{{ $activeTab == 'general' ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
              <polyline points="9 22 9 12 15 12 15 22"/>
            </svg>
            General
          </a>
          <a href="?tab=smtp" class="{{ $activeTab == 'smtp' ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
              <polyline points="22,6 12,13 2,6"/>
            </svg>
            Email / SMTP
          </a>
          <a href="?tab=shipping" class="{{ $activeTab == 'shipping' ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <rect x="1" y="3" width="15" height="13" rx="1"/>
              <path d="M16 8h4l3 5v3h-7V8z"/>
              <circle cx="5.5" cy="18.5" r="2.5"/>
              <circle cx="18.5" cy="18.5" r="2.5"/>
            </svg>
            Shipping
          </a>
          <a href="?tab=security" class="{{ $activeTab == 'security' ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
            Security
          </a>
          <a href="?tab=api" class="{{ $activeTab == 'api' ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <polyline points="16 18 22 12 16 6"/>
              <polyline points="8 6 2 12 8 18"/>
            </svg>
            API &amp; Integrasi
          </a>
          <a href="?tab=sysinfo" class="{{ $activeTab == 'sysinfo' ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <rect x="2" y="3" width="20" height="14" rx="2"/>
              <line x1="8" y1="21" x2="16" y2="21"/>
              <line x1="12" y1="17" x2="12" y2="21"/>
            </svg>
            System Info
          </a>
          <div class="st-nav-sep"></div>
          <a href="?tab=danger" class="danger-link {{ $activeTab == 'danger' ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
              <line x1="12" y1="9" x2="12" y2="13"/>
              <line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
            Danger Zone
          </a>
        </nav>
      </aside>

      {{-- ─── MAIN PANELS ─── --}}
      <div class="st-main">

        {{-- ════ GENERAL ════ --}}
        <div class="st-panel {{ $activeTab == 'general' ? 'active' : '' }}">
          <div class="st-panel-hdr">
            <div class="st-panel-hdr-icon">
              <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                <polyline points="9 22 9 12 15 12 15 22"/>
              </svg>
            </div>
            <div class="st-panel-hdr-txt">
              <h2>General Settings</h2>
              <p>Informasi dasar website, kontak, dan maintenance mode</p>
            </div>
          </div>
          <div class="st-panel-body">
            <form method="POST" action="{{ route('admin.settings.save') }}">
              @csrf
              <input type="hidden" name="action" value="save_general">
              <div class="st-form-grid">
                <div class="st-fg">
                  <label>Site Name</label>
                  <input type="text" name="site_name" value="{{ $settings['site_name'] }}" placeholder="Indo Cahaya Express">
                </div>
                <div class="st-fg">
                  <label>Tagline</label>
                  <input type="text" name="site_tagline" value="{{ $settings['site_tagline'] }}" placeholder="Fast & Reliable Shipping">
                </div>
                <div class="st-fg">
                  <label>Admin Email</label>
                  <input type="email" name="site_email" value="{{ $settings['site_email'] }}" placeholder="admin@example.com">
                </div>
                <div class="st-fg">
                  <label>Phone / WhatsApp</label>
                  <input type="text" name="site_phone" value="{{ $settings['site_phone'] }}" placeholder="0812xxxxxxxx">
                </div>
                <div class="st-fg full">
                  <label>Alamat Kantor</label>
                  <textarea name="site_address" rows="3" placeholder="Jl. Contoh No. 1, Jakarta">{{ $settings['site_address'] }}</textarea>
                </div>
              </div>
              <hr class="st-divider">
              <div class="toggle-row">
                <div class="toggle-info">
                  <h4>Maintenance Mode</h4>
                  <p>Aktifkan untuk menonaktifkan akses publik sementara</p>
                </div>
                <label class="toggle-switch" id="maintenanceToggleWrap">
                  <input type="checkbox" id="maintenanceToggle" {{ $settings['maintenance_mode'] == '1' ? 'checked' : '' }}>
                  <span class="toggle-slider"></span>
                </label>
              </div>
              <button type="submit" class="btn-st-save">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                  <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/>
                  <polyline points="17 21 17 13 7 13 7 21"/>
                  <polyline points="7 3 7 8 15 8"/>
                </svg>
                Simpan General
              </button>
            </form>
          </div>
        </div>

        {{-- ════ SMTP ════ --}}
        <div class="st-panel {{ $activeTab == 'smtp' ? 'active' : '' }}">
          <div class="st-panel-hdr">
            <div class="st-panel-hdr-icon">
              <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                <polyline points="22,6 12,13 2,6"/>
              </svg>
            </div>
            <div class="st-panel-hdr-txt">
              <h2>Email / SMTP Settings</h2>
              <p>Konfigurasi pengiriman email otomatis dari sistem</p>
            </div>
          </div>
          <div class="st-panel-body">
            <form method="POST" action="{{ route('admin.settings.save') }}">
              @csrf
              <input type="hidden" name="action" value="save_smtp">
              <div class="st-form-grid">
                <div class="st-fg">
                  <label>SMTP Host</label>
                  <input type="text" name="smtp_host" value="{{ $settings['smtp_host'] }}" placeholder="smtp.gmail.com">
                </div>
                <div class="st-fg">
                  <label>SMTP Port</label>
                  <input type="text" name="smtp_port" value="{{ $settings['smtp_port'] }}" placeholder="587">
                </div>
                <div class="st-fg">
                  <label>SMTP Username</label>
                  <input type="text" name="smtp_user" value="{{ $settings['smtp_user'] }}" placeholder="user@gmail.com">
                </div>
                <div class="st-fg">
                  <label>SMTP Password</label>
                  <input type="password" name="smtp_pass" value="{{ $settings['smtp_pass'] }}" placeholder="••••••••">
                </div>
                <div class="st-fg">
                  <label>Encryption</label>
                  <select name="smtp_encryption">
                    <option value="tls"  {{ $settings['smtp_encryption'] == 'tls'  ? 'selected' : '' }}>TLS</option>
                    <option value="ssl"  {{ $settings['smtp_encryption'] == 'ssl'  ? 'selected' : '' }}>SSL</option>
                    <option value="none" {{ $settings['smtp_encryption'] == 'none' ? 'selected' : '' }}>None</option>
                  </select>
                </div>
                <div class="st-fg">
                  <label>From Name</label>
                  <input type="text" name="mail_from_name" value="{{ $settings['mail_from_name'] }}" placeholder="Indo Cahaya Express">
                </div>
                <div class="st-fg full">
                  <label>From Email</label>
                  <input type="email" name="mail_from_email" value="{{ $settings['mail_from_email'] }}" placeholder="noreply@indocahayaexpress.com">
                </div>
              </div>
              <button type="submit" class="btn-st-save">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                  <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/>
                  <polyline points="17 21 17 13 7 13 7 21"/>
                  <polyline points="7 3 7 8 15 8"/>
                </svg>
                Simpan SMTP
              </button>
            </form>
          </div>
        </div>

        {{-- ════ SHIPPING ════ --}}
        <div class="st-panel {{ $activeTab == 'shipping' ? 'active' : '' }}">
          <div class="st-panel-hdr">
            <div class="st-panel-hdr-icon">
              <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <rect x="1" y="3" width="15" height="13" rx="1"/>
                <path d="M16 8h4l3 5v3h-7V8z"/>
                <circle cx="5.5" cy="18.5" r="2.5"/>
                <circle cx="18.5" cy="18.5" r="2.5"/>
              </svg>
            </div>
            <div class="st-panel-hdr-txt">
              <h2>Shipping Settings</h2>
              <p>Satuan berat, mata uang, asuransi, fuel surcharge, war risk, dan DDP</p>
            </div>
          </div>
          <div class="st-panel-body">
            <form method="POST" action="{{ route('admin.settings.save') }}">
              @csrf
              <input type="hidden" name="action" value="save_shipping">
              <div class="st-form-grid">
                <div class="st-fg">
                  <label>Default Currency</label>
                  <select name="default_currency">
                    <option value="IDR" {{ $settings['default_currency'] == 'IDR' ? 'selected' : '' }}>IDR — Rupiah</option>
                    <option value="USD" {{ $settings['default_currency'] == 'USD' ? 'selected' : '' }}>USD — US Dollar</option>
                  </select>
                </div>
                <div class="st-fg">
                  <label>Weight Unit</label>
                  <select name="weight_unit">
                    <option value="kg"  {{ $settings['weight_unit'] == 'kg'  ? 'selected' : '' }}>Kilogram (kg)</option>
                    <option value="lbs" {{ $settings['weight_unit'] == 'lbs' ? 'selected' : '' }}>Pounds (lbs)</option>
                  </select>
                </div>
                <div class="st-fg">
                  <label>Dimension Unit</label>
                  <select name="dimension_unit">
                    <option value="cm" {{ $settings['dimension_unit'] == 'cm' ? 'selected' : '' }}>Centimeter (cm)</option>
                    <option value="in" {{ $settings['dimension_unit'] == 'in' ? 'selected' : '' }}>Inch (in)</option>
                  </select>
                </div>
                <div class="st-fg">
                  <label>Max Weight per Package</label>
                  <input type="number" step="any" name="max_weight" value="{{ $settings['max_weight'] }}" placeholder="70">
                  <span class="hint">Maksimum berat per paket (kg)</span>
                </div>
                <div class="st-fg">
                  <label>War Risk Charge (%)</label>
                  <input type="number" step="0.01" name="war_risk_percent" value="{{ $settings['war_risk_percent'] }}" placeholder="32">
                  <span class="hint">Dikenakan untuk layanan REGULER (persen dari ongkir)</span>
                </div>
                <div class="st-fg">
                  <label>DDP Percent (%)</label>
                  <input type="number" step="0.01" name="ddp_percent" value="{{ $settings['ddp_percent'] }}" placeholder="19">
                  <span class="hint">Bea masuk untuk pengiriman ke US/Canada (persen dari nilai barang)</span>
                </div>
              </div>
              <button type="submit" class="btn-st-save">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                  <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/>
                  <polyline points="17 21 17 13 7 13 7 21"/>
                  <polyline points="7 3 7 8 15 8"/>
                </svg>
                Simpan Shipping
              </button>
            </form>
          </div>
        </div>

        {{-- ════ SECURITY ════ --}}
        <div class="st-panel {{ $activeTab == 'security' ? 'active' : '' }}">
          <div class="st-panel-hdr">
            <div class="st-panel-hdr-icon">
              <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
              </svg>
            </div>
            <div class="st-panel-hdr-txt">
              <h2>Security Settings</h2>
              <p>Session, login attempts, verifikasi email, dan 2FA</p>
            </div>
          </div>
          <div class="st-panel-body">
            <form method="POST" action="{{ route('admin.settings.save') }}">
              @csrf
              <input type="hidden" name="action" value="save_security">
              <div class="st-form-grid">
                <div class="st-fg">
                  <label>Session Lifetime (menit)</label>
                  <input type="number" name="session_lifetime" value="{{ $settings['session_lifetime'] }}" placeholder="120">
                </div>
                <div class="st-fg">
                  <label>Max Login Attempts</label>
                  <input type="number" name="max_login_attempts" value="{{ $settings['max_login_attempts'] }}" placeholder="5">
                </div>
                <div class="st-fg">
                  <label>Lockout Duration (menit)</label>
                  <input type="number" name="lockout_duration" value="{{ $settings['lockout_duration'] }}" placeholder="30">
                </div>
              </div>
              <hr class="st-divider">
              <div class="toggle-row">
                <div class="toggle-info">
                  <h4>Require Email Verification</h4>
                  <p>Member baru harus verifikasi email sebelum bisa login</p>
                </div>
                <label class="toggle-switch">
                  <input type="checkbox" name="require_email_verify" value="1" {{ $settings['require_email_verify'] == '1' ? 'checked' : '' }}>
                  <span class="toggle-slider"></span>
                </label>
              </div>
              <div class="toggle-row">
                <div class="toggle-info">
                  <h4>Two-Factor Auth for Admin / Dev</h4>
                  <p>Wajibkan 2FA untuk role admin dan developer</p>
                </div>
                <label class="toggle-switch">
                  <input type="checkbox" name="two_factor_admin" value="1" {{ $settings['two_factor_admin'] == '1' ? 'checked' : '' }}>
                  <span class="toggle-slider"></span>
                </label>
              </div>
              <button type="submit" class="btn-st-save">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                  <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/>
                  <polyline points="17 21 17 13 7 13 7 21"/>
                  <polyline points="7 3 7 8 15 8"/>
                </svg>
                Simpan Security
              </button>
            </form>
          </div>
        </div>

        {{-- ════ API ════ --}}
        <div class="st-panel {{ $activeTab == 'api' ? 'active' : '' }}">
          <div class="st-panel-hdr">
            <div class="st-panel-hdr-icon">
              <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <polyline points="16 18 22 12 16 6"/>
                <polyline points="8 6 2 12 8 18"/>
              </svg>
            </div>
            <div class="st-panel-hdr-txt">
              <h2>API &amp; Integrations</h2>
              <p>Google Maps, reCAPTCHA, WhatsApp API, dan Exchange Rate API</p>
            </div>
          </div>
          <div class="st-panel-body">
            <form method="POST" action="{{ route('admin.settings.save') }}">
              @csrf
              <input type="hidden" name="action" value="save_api">
              <div class="st-form-grid">
                <div class="st-fg full">
                  <label>Exchange Rate API URL</label>
                  <input type="text" name="exchange_rate_api_url" value="{{ $settings['exchange_rate_api_url'] }}"
                         placeholder="https://api.exchangerate-api.com/v4/latest/USD">
                  <span class="hint">URL API untuk mendapatkan kurs USD/IDR. Biarkan kosong untuk fallback default.</span>
                </div>
                <div class="st-fg full">
                  <label>Google Maps API Key</label>
                  <input type="text" name="google_maps_key" value="{{ $settings['google_maps_key'] }}" placeholder="AIzaSy...">
                </div>
                <div class="st-fg">
                  <label>reCAPTCHA Site Key</label>
                  <input type="text" name="recaptcha_site_key" value="{{ $settings['recaptcha_site_key'] }}" placeholder="6Lc...">
                </div>
                <div class="st-fg">
                  <label>reCAPTCHA Secret Key</label>
                  <input type="text" name="recaptcha_secret_key" value="{{ $settings['recaptcha_secret_key'] }}" placeholder="6Lc...">
                </div>
                <div class="st-fg">
                  <label>WhatsApp API Token</label>
                  <input type="text" name="whatsapp_api_token" value="{{ $settings['whatsapp_api_token'] }}" placeholder="Bearer token...">
                </div>
                <div class="st-fg">
                  <label>WhatsApp Number</label>
                  <input type="text" name="whatsapp_number" value="{{ $settings['whatsapp_number'] }}" placeholder="628123456789">
                  <span class="hint">Format internasional tanpa tanda +</span>
                </div>
              </div>
              <button type="submit" class="btn-st-save">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                  <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/>
                  <polyline points="17 21 17 13 7 13 7 21"/>
                  <polyline points="7 3 7 8 15 8"/>
                </svg>
                Simpan API
              </button>
            </form>
          </div>
        </div>

        {{-- ════ SYSTEM INFO ════ --}}
        <div class="st-panel {{ $activeTab == 'sysinfo' ? 'active' : '' }}">
          <div class="st-panel-hdr">
            <div class="st-panel-hdr-icon">
              <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <rect x="2" y="3" width="20" height="14" rx="2"/>
                <line x1="8" y1="21" x2="16" y2="21"/>
                <line x1="12" y1="17" x2="12" y2="21"/>
              </svg>
            </div>
            <div class="st-panel-hdr-txt">
              <h2>System Information</h2>
              <p>Informasi server, PHP, dan database</p>
            </div>
          </div>
          <div class="st-panel-body">
            <div class="info-grid">
              <div class="info-card">
                <div class="info-card-label">PHP Version</div>
                <div class="info-card-value">{{ phpversion() }}</div>
              </div>
              <div class="info-card">
                <div class="info-card-label">Server Software</div>
                <div class="info-card-value">{{ $_SERVER['SERVER_SOFTWARE'] ?? 'N/A' }}</div>
              </div>
              <div class="info-card">
                <div class="info-card-label">Database</div>
                <div class="info-card-value" style="color:var(--green);">
                  <span style="display:inline-flex;align-items:center;gap:5px;">
                    <span style="width:7px;height:7px;border-radius:50%;background:var(--green);display:inline-block;"></span>
                    Connected
                  </span>
                </div>
              </div>
              <div class="info-card">
                <div class="info-card-label">Server Time</div>
                <div class="info-card-value">{{ date('d M Y H:i:s') }}</div>
              </div>
              <div class="info-card">
                <div class="info-card-label">Memory Usage</div>
                <div class="info-card-value">{{ round(memory_get_usage() / 1024 / 1024, 2) }} MB</div>
              </div>
              <div class="info-card">
                <div class="info-card-label">Memory Limit</div>
                <div class="info-card-value">{{ ini_get('memory_limit') }}</div>
              </div>
              <div class="info-card">
                <div class="info-card-label">Max Upload Size</div>
                <div class="info-card-value">{{ ini_get('upload_max_filesize') }}</div>
              </div>
              <div class="info-card">
                <div class="info-card-label">Document Root</div>
                <div class="info-card-value">{{ $_SERVER['DOCUMENT_ROOT'] ?? '/' }}</div>
              </div>
            </div>
          </div>
        </div>

        {{-- ════ DANGER ZONE ════ --}}
        <div class="st-panel {{ $activeTab == 'danger' ? 'active' : '' }}">
          <div class="st-panel-hdr">
            <div class="st-panel-hdr-icon" style="background:rgba(220,38,38,0.07);color:#dc2626;">
              <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                <line x1="12" y1="9" x2="12" y2="13"/>
                <line x1="12" y1="17" x2="12.01" y2="17"/>
              </svg>
            </div>
            <div class="st-panel-hdr-txt">
              <h2>Danger Zone</h2>
              <p>Aksi yang tidak bisa di-undo — harap berhati-hati</p>
            </div>
          </div>
          <div class="st-panel-body">
            <div class="danger-card">
              <div class="danger-row">
                <div class="danger-row-info">
                  <h4>Clear Application Cache</h4>
                  <p>Hapus semua file cache sementara dari server</p>
                </div>
                <form method="POST" action="{{ route('admin.settings.clear-cache') }}"
                      onsubmit="return confirm('Yakin ingin menghapus semua cache?')">
                  @csrf
                  <button type="submit" class="btn-danger">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <polyline points="3 6 5 6 21 6"/>
                      <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                      <path d="M10 11v6M14 11v6"/>
                    </svg>
                    Clear Cache
                  </button>
                </form>
              </div>
              <div class="danger-row">
                <div class="danger-row-info">
                  <h4>Reset All Settings</h4>
                  <p>Kembalikan semua konfigurasi ke nilai default bawaan</p>
                </div>
                <form method="POST" action="{{ route('admin.settings.reset') }}"
                      onsubmit="return confirm('RESET semua pengaturan ke default? Tindakan ini tidak bisa di-undo!')">
                  @csrf
                  <button type="submit" class="btn-danger">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <polyline points="1 4 1 10 7 10"/>
                      <path d="M3.51 15a9 9 0 1 0 .49-3.37"/>
                    </svg>
                    Reset Settings
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>

      </div>{{-- /st-main --}}
    </div>{{-- /st-layout --}}
  </div>{{-- /st-container --}}
</div>{{-- /st-shell --}}

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

// ==================== MAINTENANCE TOGGLE ====================
document.addEventListener('DOMContentLoaded', function() {
  const sidebarToggle = document.getElementById('maintenanceToggle');
  if (!sidebarToggle) return;

  sidebarToggle.addEventListener('change', function(e) {
    const isChecked = e.target.checked;
    const newMode   = isChecked ? '1' : '0';
    sidebarToggle.disabled = true;

    fetch('{{ route("admin.maintenance.toggle") }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Accept': 'application/json'
      },
      body: JSON.stringify({ mode: newMode })
    })
    .then(response => {
      const ct = response.headers.get('content-type');
      if (!ct || !ct.includes('application/json')) {
        return response.text().then(text => {
          throw new Error('Server error. Cek console.');
        });
      }
      return response.json();
    })
    .then(data => {
      if (data.success) {
        showFlash('Mode maintenance ' + (data.mode == '1' ? 'diaktifkan' : 'dinonaktifkan'), 'success');
      } else {
        throw new Error(data.message || 'Gagal mengubah mode');
      }
    })
    .catch(error => {
      e.target.checked = !isChecked;
      showFlash(error.message, 'error');
    })
    .finally(() => { sidebarToggle.disabled = false; });
  });

  function showFlash(message, type) {
    const existing = document.getElementById('flash-notif');
    if (existing) existing.remove();
    const notif = document.createElement('div');
    notif.id = 'flash-notif';
    notif.innerHTML = `
      <div class="fn-icon">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
          ${type === 'success'
            ? '<polyline points="20 6 9 17 4 12"/>'
            : '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>'}
        </svg>
      </div>
      <div class="fn-body">
        <div class="fn-title">${type === 'success' ? 'Berhasil' : 'Gagal'}</div>
        ${message}
      </div>
      <button class="fn-close" onclick="this.parentElement.remove()">&times;</button>
    `;
    document.body.appendChild(notif);
    setTimeout(() => notif.remove(), 4000);
  }
});
</script>
@endsection
