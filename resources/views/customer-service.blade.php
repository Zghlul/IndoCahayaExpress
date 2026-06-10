@extends('layouts.app')

@section('title', 'Customer Service - Indo Cahaya Express')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300&family=DM+Serif+Display:ital@0;1&display=swap');

:root {
  --red: #E31E24; --red-hover: #C7181D; --red-deep: #A0121A;
  --navy-900: #060F2E; --navy-800: #0A1A4A; --navy-700: #0D2260; --navy-600: #102B78; --navy-500: #1438A0;
  --white: #FFFFFF; --surface: #FAFBFE; --surface-2: #F1F5FC; --surface-3: #E8EFF9;
  --border: #DDE6F5; --border-2: #C8D6EE;
  --text-primary: #09183C; --text-2: #3D5478; --text-muted: #7A93B8; --text-faint: #AAB9D0;
  --green: #16A34A;
  --shadow-sm: 0 2px 8px rgba(9,24,60,0.08);
  --shadow-md: 0 8px 24px rgba(9,24,60,0.10);
  --shadow-lg: 0 16px 48px rgba(9,24,60,0.12);
  --shadow-card: 0 4px 20px rgba(9,24,60,0.07), 0 1px 4px rgba(9,24,60,0.04);
  --ease-out: cubic-bezier(0.22, 1, 0.36, 1);
  --ease-spring: cubic-bezier(0.34, 1.56, 0.64, 1);
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { overflow-x: hidden; scroll-behavior: smooth; }
body::-webkit-scrollbar { display: none; }
body { scrollbar-width: none; }

.cs-page {
  font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
  color: var(--text-primary);
  background: var(--white);
  line-height: 1.6;
}

.container {
  max-width: 1440px; margin: 0 auto;
  padding: 0 2rem; width: 100%;
}

/* TOAST */
.cs-toast {
  position: fixed; top: 24px; right: 24px; z-index: 9999;
  display: flex; align-items: center; gap: 12px;
  background: var(--white); border-radius: 16px;
  padding: 1rem 1.25rem;
  box-shadow: var(--shadow-lg), 0 0 0 1px var(--border);
  border: 1px solid var(--border);
  min-width: 280px; max-width: 360px;
  transform: translateX(120%);
  transition: transform 0.4s var(--ease-spring);
}
.cs-toast.show { transform: translateX(0); }
.cs-toast.hide { transform: translateX(120%); transition: transform 0.3s ease; }
.cs-toast-icon {
  width: 36px; height: 36px; border-radius: 10px; flex-shrink: 0;
  background: rgba(22,163,74,0.1); color: var(--green);
  display: flex; align-items: center; justify-content: center;
}
.cs-toast-icon svg { width: 18px; height: 18px; }
.cs-toast-title { font-size: 0.875rem; font-weight: 700; color: var(--text-primary); }
.cs-toast-sub   { font-size: 0.75rem; color: var(--text-muted); margin-top: 2px; }

/* HERO */
.hero {
  position: relative; min-height: 70vh;
  display: flex; align-items: center;
  overflow: hidden; background: var(--navy-900);
}
.hero-bg {
  position: absolute; inset: 0;
  background:
    radial-gradient(ellipse 100% 80% at 100% 0%, rgba(20,56,160,0.55) 0%, transparent 55%),
    radial-gradient(ellipse 70% 60% at 0% 100%, rgba(227,30,36,0.10) 0%, transparent 50%),
    radial-gradient(ellipse 60% 70% at 55% 50%, rgba(11,26,74,0.9) 0%, transparent 70%),
    linear-gradient(168deg, #060F2E 0%, #0B1C55 45%, #091640 100%);
  z-index: 0;
}
.hero-grid {
  position: absolute; inset: 0;
  background-image: radial-gradient(circle, rgba(255,255,255,0.055) 1px, transparent 1px);
  background-size: 44px 44px;
  mask-image: radial-gradient(ellipse 90% 80% at 50% 50%, black 40%, transparent 80%);
  z-index: 0;
}
.hero-lines {
  position: absolute; inset: 0; z-index: 0; overflow: hidden;
}
.hero-lines::before {
  content: ''; position: absolute; top: 0; bottom: 0; right: 25%; width: 1px;
  background: linear-gradient(to bottom, transparent 0%, rgba(227,30,36,0.35) 30%, rgba(227,30,36,0.15) 70%, transparent 100%);
}
.hero .container { position: relative; z-index: 2; }
.hero-inner {
  display: flex; flex-direction: column; align-items: center;
  text-align: center; padding: 3rem 0 6rem;
}
.hero-eyebrow {
  display: inline-flex; align-items: center; gap: 0.6rem;
  margin-bottom: 2rem; padding: 0.45rem 1.1rem 0.45rem 0.55rem;
  border-radius: 99px;
  border: 1px solid rgba(227,30,36,0.3);
  background: rgba(227,30,36,0.07);
  backdrop-filter: blur(10px);
}
.eyebrow-dot {
  width: 26px; height: 26px; border-radius: 50%;
  background: linear-gradient(135deg, var(--red), var(--red-deep));
  display: flex; align-items: center; justify-content: center;
  box-shadow: 0 4px 12px rgba(227,30,36,0.4);
}
.eyebrow-dot svg { width: 13px; height: 13px; color: #fff; }
.hero-eyebrow span {
  font-size: 0.7rem; font-weight: 800;
  letter-spacing: 0.12em; text-transform: uppercase;
  color: rgba(255,255,255,0.75); padding-right: 0.3rem;
}
.hero-title {
  font-size: clamp(2.5rem, 5vw, 4.2rem);
  font-weight: 900; line-height: 0.98;
  letter-spacing: -0.04em; color: #fff;
  margin-bottom: 1.5rem;
}
.hero-title .line-accent {
  display: block;
  font-family: 'DM Serif Display', serif;
  font-style: italic; font-weight: 400;
  color: var(--red); font-size: 1.08em;
  letter-spacing: -0.025em; line-height: 1.05;
  margin: 0.05em 0;
    text-shadow:
    0 0 40px rgba(227,30,36,0.85),
    0 0 80px rgba(227,30,36,0.55),
    0 0 130px rgba(227,30,36,0.28),
    0 0 220px rgba(227,30,36,0.12);
}
.hero-title .line-light {
  display: block;
  color: rgba(255,255,255,0.38); font-size: 0.62em;
  font-weight: 500; letter-spacing: -0.01em;
  font-family: 'Plus Jakarta Sans', sans-serif;
  margin-top: 0.15em; line-height: 1.3;
}
.hero-desc {
  font-size: 1rem; color: rgba(255,255,255,0.55);
  max-width: 600px; line-height: 1.8; margin-bottom: 2rem;
}
.hero-pills {
  display: flex; gap: 0.75rem; flex-wrap: wrap; justify-content: center;
}
.hero-pill {
  display: inline-flex; align-items: center; gap: 0.45rem;
  background: rgba(255,255,255,0.06);
  border: 1px solid rgba(255,255,255,0.12);
  border-radius: 99px; padding: 0.4rem 1rem;
  font-size: 0.78rem; font-weight: 600;
  color: rgba(255,255,255,0.7); backdrop-filter: blur(6px);
}
.hero-pill svg { width: 13px; height: 13px; color: #4ade80; }

/* MAIN CONTENT */
.cs-main { padding: 5rem 0; background: var(--surface); }
.cs-grid {
  display: grid; grid-template-columns: 320px 1fr;
  gap: 2rem; align-items: start;
}

/* INFO CARD */
.cs-info-card {
  background: var(--white); border-radius: 22px;
  overflow: hidden; box-shadow: var(--shadow-card);
  border: 1px solid var(--border);
  position: sticky; top: 2rem;
}
.cs-info-header {
  background: linear-gradient(155deg, var(--navy-800) 0%, var(--navy-700) 100%);
  padding: 1.75rem 1.5rem; color: #fff;
  position: relative; overflow: hidden;
}
.cs-info-header::before {
  content: ''; position: absolute; top: -1px; left: 15%; right: 15%; height: 1px;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.25), transparent);
}
.cs-info-header h3 { font-size: 1.1rem; font-weight: 800; margin-bottom: 0.4rem; letter-spacing: -0.02em; }
.cs-info-header p { font-size: 0.8rem; color: rgba(255,255,255,0.55); line-height: 1.6; }
.cs-info-body { padding: 0.5rem 1.25rem; }
.cs-info-item {
  display: flex; align-items: flex-start; gap: 0.875rem;
  padding: 1rem 0; border-bottom: 1px solid var(--border);
}
.cs-info-item:last-child { border-bottom: none; }
.cs-info-icon {
  width: 38px; height: 38px; border-radius: 10px;
  display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.cs-info-icon svg { width: 17px; height: 17px; }
.cs-info-icon-navy  { background: rgba(9,24,60,0.07); color: var(--navy-600); }
.cs-info-icon-green { background: rgba(22,163,74,0.1); color: var(--green); }
.cs-info-icon-amber { background: rgba(245,158,11,0.1); color: #d97706; }
.cs-info-icon-red   { background: rgba(227,30,36,0.08); color: var(--red); }
.cs-info-label {
  font-size: 0.6rem; font-weight: 800; color: var(--text-muted);
  text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 3px;
}
.cs-info-value { font-size: 0.85rem; font-weight: 600; color: var(--text-primary); line-height: 1.4; }
.cs-quick {
  margin: 0 1.25rem 1.5rem;
  background: rgba(227,30,36,0.04);
  border: 1px solid rgba(227,30,36,0.12);
  border-radius: 14px; padding: 1rem;
}
.cs-quick-label {
  font-size: 0.6rem; font-weight: 800; color: var(--red);
  text-transform: uppercase; letter-spacing: 0.1em;
  margin-bottom: 0.8rem; display: flex; align-items: center; gap: 0.4rem;
}
.cs-quick-label svg { width: 11px; height: 11px; }
.cs-quick-btn {
  display: flex; align-items: center; gap: 0.6rem;
  background: var(--white); border: 1px solid var(--border);
  border-radius: 10px; padding: 0.7rem 0.9rem;
  font-size: 0.8rem; font-weight: 700; color: var(--text-primary);
  text-decoration: none; transition: all 0.2s var(--ease-out);
  margin-bottom: 0.5rem;
}
.cs-quick-btn:last-child { margin-bottom: 0; }
.cs-quick-btn:hover { border-color: var(--red); transform: translateX(3px); }
.cs-quick-btn svg { width: 16px; height: 16px; }
.ic-wa { color: #25d366; }
.ic-mail { color: var(--navy-500); }

/* FORM CARD */
.cs-form-card {
  background: var(--white); border-radius: 22px;
  overflow: hidden; box-shadow: var(--shadow-card); border: 1px solid var(--border);
}
.cs-form-header {
  background: linear-gradient(155deg, var(--navy-800) 0%, var(--navy-700) 100%);
  padding: 1.5rem 2rem; display: flex; align-items: center; gap: 1rem; color: #fff;
  position: relative; overflow: hidden;
}
.cs-form-header::before {
  content: ''; position: absolute; top: -1px; left: 15%; right: 15%; height: 1px;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.25), transparent);
}
.cs-form-header-icon {
  width: 48px; height: 48px; border-radius: 12px;
  background: rgba(227,30,36,0.15);
  border: 1px solid rgba(227,30,36,0.3);
  display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.cs-form-header-icon svg { width: 22px; height: 22px; color: rgba(255,120,120,0.95); }
.cs-form-header-text h3 { font-size: 1.2rem; font-weight: 800; margin-bottom: 0.2rem; letter-spacing: -0.02em; }
.cs-form-header-text p  { font-size: 0.8rem; color: rgba(255,255,255,0.55); }
.cs-form-body { padding: 2rem; }
.cs-form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem; }
.cs-field { display: flex; flex-direction: column; gap: 0.4rem; }
.cs-field.full { grid-column: 1 / -1; }
.cs-field label {
  font-size: 0.68rem; font-weight: 800; color: var(--text-muted);
  text-transform: uppercase; letter-spacing: 0.1em;
}
.cs-field input,
.cs-field textarea {
  width: 100%; padding: 0.8rem 1rem;
  border-radius: 10px; border: 1.5px solid var(--border);
  background: var(--surface-2); color: var(--text-primary);
  font-size: 0.9rem; font-family: inherit; outline: none; transition: all 0.2s;
}
.cs-field input:focus,
.cs-field textarea:focus {
  border-color: rgba(227,30,36,0.55);
  background: var(--white);
  box-shadow: 0 0 0 3px rgba(227,30,36,0.08);
}
.cs-field textarea { min-height: 130px; resize: vertical; }
.cs-submit {
  width: 100%; margin-top: 1.5rem; padding: 1rem 1.5rem;
  background: var(--red); color: #fff; border: none; border-radius: 10px;
  font-size: 0.93rem; font-weight: 700;
  display: flex; align-items: center; justify-content: center; gap: 0.6rem;
  cursor: pointer; transition: all 0.25s var(--ease-out);
  box-shadow: 0 8px 28px rgba(227,30,36,0.35), inset 0 1px 0 rgba(255,255,255,0.12);
  font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: 0.01em;
}
.cs-submit:hover { background: var(--red-hover); transform: translateY(-2px); box-shadow: 0 14px 36px rgba(227,30,36,0.5); }
.cs-submit svg { width: 18px; height: 18px; }
.cs-submit-note {
  text-align: center; font-size: 0.7rem; color: var(--text-faint);
  margin-top: 1rem; display: flex; align-items: center; justify-content: center; gap: 0.4rem;
}

/* REVEAL */
.rv { opacity: 0; transform: translateY(28px); transition: all 0.6s ease; }
.rv.in { opacity: 1; transform: translateY(0); }

/* RESPONSIVE */
@media (max-width: 900px) {
  .cs-grid { grid-template-columns: 1fr; }
  .cs-info-card { position: static; margin-bottom: 2rem; }
}
@media (max-width: 768px) {
  .hero-inner { padding: 4rem 0; }
  .cs-main { padding: 3rem 0; }
  .cs-form-body { padding: 1.5rem; }
  .cs-form-grid { grid-template-columns: 1fr; gap: 1rem; }
}
@media (max-width: 640px) {
  .container { padding: 0 1rem; }
  .hero-title { font-size: 2.2rem; }
}
</style>

@if(session('success'))
<div id="csToast" class="cs-toast">
  <div class="cs-toast-icon">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
      <polyline points="20 6 9 17 4 12"/>
    </svg>
  </div>
  <div>
    <div class="cs-toast-title">Pesan berhasil dikirim!</div>
    <div class="cs-toast-sub">Tim kami akan segera menghubungi Anda.</div>
  </div>
</div>
@endif

<div class="cs-page">
  <section class="hero">
    <div class="hero-bg"></div>
    <div class="hero-grid"></div>
    <div class="hero-lines"></div>
    <div class="container">
      <div class="hero-inner">
        <div class="hero-eyebrow">
          <div class="eyebrow-dot">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
            </svg>
          </div>
          <span>Customer Support</span>
        </div>
        <h1 class="hero-title">
          Ada yang Bisa
          <span class="line-accent">Kami Bantu?</span>
          <span class="line-light">Tim Siap Membantu Kapanpun Anda Butuhkan</span>
        </h1>
        <p class="hero-desc">
          Tim kami siap membantu pertanyaan, keluhan, maupun informasi terkait pengiriman Anda. Hubungi kami melalui form atau kontak yang tersedia.
        </p>
        <div class="hero-pills">
          <span class="hero-pill"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Respon Cepat</span>
          <span class="hero-pill"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> WhatsApp 7 Hari</span>
          <span class="hero-pill"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Tim Berpengalaman</span>
        </div>
      </div>
    </div>
  </section>

  <div class="cs-main">
    <div class="container">
      <div class="cs-grid rv">
        <div class="cs-info-card">
          <div class="cs-info-header">
            <h3 style="color: white;">Informasi Kontak</h3>
            <p>Hubungi kami untuk bantuan terkait pengiriman, tracking, atau informasi layanan lainnya.</p>
          </div>
          <div class="cs-info-body">
            <div class="cs-info-item">
              <div class="cs-info-icon cs-info-icon-navy"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></div>
              <div><div class="cs-info-label">Email</div><div class="cs-info-value">{{ $globalSettings['site_email'] }}</div></div>
            </div>
            <div class="cs-info-item">
              <div class="cs-info-icon cs-info-icon-green"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.4 2 2 0 0 1 3.6 1.22h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.89a16 16 0 0 0 6 6l.94-.94a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 21.73 16.92z"/></svg></div>
              <div><div class="cs-info-label">Phone / WhatsApp</div><div class="cs-info-value">+{{ $globalSettings['site_phone'] }}</div></div>
            </div>
            <div class="cs-info-item">
              <div class="cs-info-icon cs-info-icon-amber"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
              <div><div class="cs-info-label">Jam Operasional</div><div class="cs-info-value">Senin – Jumat, 08:00 – 16:00 WIB</div></div>
            </div>
            <div class="cs-info-item">
              <div class="cs-info-icon cs-info-icon-red"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></div>
              <div><div class="cs-info-label">WhatsApp</div><div class="cs-info-value">Tersedia 5 hari seminggu</div></div>
            </div>
          </div>
          <div class="cs-quick">
            <div class="cs-quick-label">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
              Hubungi Langsung
            </div>
            <a href="https://wa.me/+{{ preg_replace('/[^0-9]/', '', $globalSettings['site_phone']) }}" target="_blank" class="cs-quick-btn">
              <svg class="ic-wa" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
              Chat via WhatsApp
            </a>
            <a href="mailto:{{ $globalSettings['site_email'] }}" class="cs-quick-btn">
              <svg class="ic-mail" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
              Kirim Email
            </a>
          </div>
        </div>

        <div class="cs-form-card">
          <div class="cs-form-header">
            <div class="cs-form-header-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></div>
            <div class="cs-form-header-text"><h3 style="color: white !important;">Kirim Pesan</h3><p style="color: white !important;">Isi form di bawah, tim kami akan merespons dalam 1×24 jam</p></div>
          </div>
          <div class="cs-form-body">
            <form method="POST" action="{{ route('customer-service.send') }}">
              @csrf
              <div style="display:none">
                <input type="text" name="website_url" tabindex="-1" autocomplete="off">
                <input type="text" name="confirm_email" tabindex="-1" autocomplete="off">
                <input type="hidden" name="form_timestamp" value="{{ time() }}">
              </div>
              <div class="cs-form-grid">
                <div class="cs-field"><label>Nama Lengkap</label><input type="text" name="name" value="{{ old('name') }}" required></div>
                <div class="cs-field"><label>Alamat Email</label><input type="email" name="email" value="{{ old('email') }}" required></div>
                <div class="cs-field full"><label>Subjek</label><input type="text" name="subject" value="{{ old('subject') }}" required></div>
                <div class="cs-field full"><label>Pesan</label><textarea name="message" required>{{ old('message') }}</textarea></div>
              </div>
              <button type="submit" class="cs-submit">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                Kirim Pesan
              </button>
              <div class="cs-submit-note">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                Data Anda aman dan hanya digunakan untuk keperluan support
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  const toast = document.getElementById('csToast');
  if (toast) {
    setTimeout(() => toast.classList.add('show'), 100);
    setTimeout(() => {
      toast.classList.remove('show');
      toast.classList.add('hide');
      setTimeout(() => toast.remove(), 400);
    }, 3500);
  }
  const rvEls = document.querySelectorAll('.rv');
  const obs = new IntersectionObserver(entries => {
    entries.forEach((e, i) => {
      if (e.isIntersecting) {
        setTimeout(() => e.target.classList.add('in'), i * 100);
        obs.unobserve(e.target);
      }
    });
  }, { threshold: 0.1 });
  rvEls.forEach(el => obs.observe(el));
</script>
@endsection
