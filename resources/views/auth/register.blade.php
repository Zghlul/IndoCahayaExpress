@extends('layouts.app')
@section('title', 'Daftar - Indo Cahaya Express')
@section('content')

<style>
  /* ══ AUTH PAGE ══ */
  .auth-page {
    min-height: calc(100vh - 68px);
    background: var(--ice-surface-alt);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 3rem 1.5rem;
    position: relative;
    overflow: hidden;
  }
  .auth-page::before {
    content: '';
    position: absolute;
    top: -200px; right: -200px;
    width: 600px; height: 600px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(227,30,36,0.06) 0%, transparent 70%);
    pointer-events: none;
  }
  .auth-page::after {
    content: '';
    position: absolute;
    bottom: -200px; left: -200px;
    width: 500px; height: 500px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(7,23,43,0.06) 0%, transparent 70%);
    pointer-events: none;
  }

  .auth-card {
    display: grid;
    grid-template-columns: 360px 1fr;
    max-width: 1040px;
    width: 100%;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 24px 64px rgba(7,23,43,0.14), 0 4px 16px rgba(7,23,43,0.06);
    background: var(--ice-surface);
    border: 1px solid var(--ice-border);
    position: relative;
    z-index: 1;
  }

  /* ── Left Panel ── */
  .auth-left {
    background: linear-gradient(145deg, var(--ice-navy) 0%, var(--ice-navy-mid) 50%, #0A1C38 100%);
    padding: 3.5rem 2.75rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    position: relative;
    overflow: hidden;
  }
  .auth-left::before {
    content: '';
    position: absolute; inset: 0;
    background-image:
      linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
      linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
    background-size: 32px 32px;
    pointer-events: none;
  }
  .auth-left::after {
    content: '';
    position: absolute;
    bottom: -80px; right: -80px;
    width: 280px; height: 280px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(227,30,36,0.18) 0%, transparent 65%);
    pointer-events: none;
  }

  .auth-brand {
    display: flex; align-items: center; gap: 0.65rem;
    margin-bottom: 2.5rem;
    position: relative; z-index: 1;
  }
  .auth-brand-logo {
    width: 40px; height: 40px;
    border-radius: 10px;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.15);
    display: flex; align-items: center; justify-content: center;
    overflow: hidden;
  }
  .auth-brand-logo img { height: 28px; width: auto; filter: brightness(10); }
  .auth-brand-text { display: flex; flex-direction: column; }
  .auth-brand-name  { font-size: 0.78rem; font-weight: 900; color: #fff; letter-spacing: 0.04em; line-height: 1.15; }
  .auth-brand-sub   { font-size: 0.56rem; font-weight: 600; color: rgba(255,255,255,0.45); text-transform: uppercase; letter-spacing: 0.1em; }

  .auth-left-heading {
    font-size: 1.65rem; font-weight: 900; color: #fff;
    line-height: 1.25; letter-spacing: -0.03em;
    margin-bottom: 0.875rem;
    position: relative; z-index: 1;
  }
  .auth-left-heading em {
    font-style: italic;
    font-family: 'DM Serif Display', Georgia, serif;
    color: rgba(255,255,255,0.7); font-weight: 400;
  }
  .auth-left-desc {
    font-size: 0.85rem; color: rgba(255,255,255,0.5);
    line-height: 1.7; margin-bottom: 2.5rem;
    position: relative; z-index: 1;
  }

  .auth-features { display: flex; flex-direction: column; gap: 0.875rem; position: relative; z-index: 1; }
  .auth-feature  { display: flex; align-items: center; gap: 0.875rem; }
  .auth-feature-icon {
    width: 36px; height: 36px;
    border-radius: 9px;
    background: rgba(255,255,255,0.07);
    border: 1px solid rgba(255,255,255,0.12);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; transition: all 0.2s;
  }
  .auth-feature:hover .auth-feature-icon { background: rgba(227,30,36,0.2); border-color: rgba(227,30,36,0.3); }
  .auth-feature-icon svg { width: 16px; height: 16px; color: rgba(255,255,255,0.8); }
  .auth-feature span { font-size: 0.82rem; font-weight: 600; color: rgba(255,255,255,0.65); line-height: 1.4; }

  /* ── Right Panel ── */
  .auth-right {
    padding: 2.75rem 3rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    background: var(--ice-surface);
  }

  .auth-title    { font-size: 1.5rem; font-weight: 900; color: var(--ice-navy); margin-bottom: 0.3rem; letter-spacing: -0.02em; line-height: 1.2; }
  .auth-subtitle { font-size: 0.85rem; color: var(--ice-text-2); margin-bottom: 1.5rem; line-height: 1.6; }

  /* Alerts */
  .auth-alert {
    display: flex; align-items: flex-start; gap: 0.65rem;
    padding: 0.875rem 1.1rem; border-radius: 10px;
    margin-bottom: 1.25rem; font-size: 0.84rem; font-weight: 600;
    animation: authAlertIn 0.3s ease;
  }
  .auth-alert.error   { background: rgba(227,30,36,0.06); border: 1.5px solid rgba(227,30,36,0.2); color: var(--ice-red-dark); }
  .auth-alert.success { background: rgba(16,185,129,0.07); border: 1.5px solid rgba(16,185,129,0.25); color: #065f46; }
  .auth-alert svg { width: 16px; height: 16px; flex-shrink: 0; margin-top: 1px; }
  .auth-alert ul  { padding-left: 1rem; margin-top: 0.25rem; font-weight: 500; }
  .auth-alert li  { margin: 0.15rem 0; }
  @keyframes authAlertIn {
    from { opacity: 0; transform: translateY(-6px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  /* Section label */
  .af-section {
    font-size: 0.65rem; font-weight: 800;
    color: var(--ice-red);
    text-transform: uppercase; letter-spacing: 0.1em;
    margin: 1.25rem 0 0.875rem;
    display: flex; align-items: center; gap: 0.6rem;
  }
  .af-section::after { content: ''; flex: 1; height: 1px; background: var(--ice-border); }

  /* Form grid */
  .af-row      { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
  .af-row.full { grid-template-columns: 1fr; }

  .af-group {
    display: flex; flex-direction: column; gap: 0.4rem;
    margin-bottom: 0.875rem;
  }
  .af-label {
    font-size: 0.72rem; font-weight: 800; color: #fff;
    text-transform: uppercase; letter-spacing: 0.07em;
    display: flex; align-items: center; gap: 4px;
  }
  .af-label .req { color: var(--ice-red); font-size: 0.8rem; }

  .af-input-wrap { position: relative; }
  .af-input-wrap svg {
    position: absolute; left: 0.9rem; top: 50%;
    transform: translateY(-50%);
    width: 16px; height: 16px;
    color: var(--ice-text-muted);
    pointer-events: none; transition: color 0.2s;
  }
  .af-input-wrap input {
    width: 100%;
    padding: 0.78rem 0.9rem 0.78rem 2.65rem;
    border-radius: 9px;
    border: 1.5px solid var(--ice-border);
    background: var(--ice-surface-alt);
    font-size: 0.86rem; color: var(--ice-text); font-weight: 500;
    outline: none; transition: all 0.2s;
    box-sizing: border-box;
    font-family: 'Plus Jakarta Sans', sans-serif;
  }
  .af-input-wrap input:focus {
    border-color: var(--ice-red);
    background: var(--ice-surface);
    box-shadow: 0 0 0 3px rgba(227,30,36,0.08);
  }
  .af-input-wrap input:focus ~ svg { color: var(--ice-red); }
  .af-input-wrap input::placeholder { color: var(--ice-text-muted); }
  .af-hint { font-size: 0.68rem; color: var(--ice-text-muted); line-height: 1.4; }

  /* Submit */
  .af-submit {
    width: 100%;
    padding: 0.875rem 1.5rem;
    border-radius: 10px; border: none;
    background: var(--ice-red); color: #fff;
    font-size: 0.9rem; font-weight: 800; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 0.6rem;
    margin-top: 0.5rem; transition: all 0.2s;
    font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: 0.01em;
    box-shadow: 0 6px 20px rgba(227,30,36,0.3), inset 0 1px 0 rgba(255,255,255,0.15);
  }
  .af-submit svg { width: 17px; height: 17px; }
  .af-submit:hover { background: var(--ice-red-dark); transform: translateY(-1px); box-shadow: 0 10px 28px rgba(227,30,36,0.4); }
  .af-submit:active { transform: translateY(0); }

  /* Divider & link */
  .af-divider {
    display: flex; align-items: center; gap: 1rem;
    margin: 1.5rem 0 1rem;
  }
  .af-divider::before, .af-divider::after { content: ''; flex: 1; height: 1px; background: var(--ice-border); }
  .af-divider span { font-size: 0.7rem; font-weight: 700; color: var(--ice-text-muted); text-transform: uppercase; letter-spacing: 0.08em; }

  .af-link-box {
    display: flex; align-items: center; justify-content: center; gap: 0.5rem;
    padding: 0.875rem; border-radius: 10px;
    background: var(--ice-surface-alt); border: 1.5px solid var(--ice-border);
    font-size: 0.875rem; color: var(--ice-text-2); transition: all 0.2s;
  }
  .af-link-box:hover { border-color: var(--ice-border-2); background: #EEF2F7; }
  .af-link-box a { color: var(--ice-red); font-weight: 800; text-decoration: none; }
  .af-link-box a:hover { color: var(--ice-red-dark); }

  /* Custom Checkbox (fixed) */
  .terms-check-wrap {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 1.4rem;
    border-radius: 14px;
    border: 1.5px solid var(--ice-border);
    background: var(--ice-surface-alt);
    cursor: pointer;
    transition: all 0.25s ease;
    user-select: none;
  }
  .terms-check-wrap .custom-check-box {
    width: 22px;
    height: 22px;
    min-width: 22px;
    border-radius: 7px;
    border: 1.5px solid var(--ice-border-2);
    background: var(--ice-surface);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
  }
  .terms-check-wrap .custom-check-box svg {
    width: 13px;
    height: 13px;
    stroke: white;
    opacity: 0;
    transform: scale(0.4);
    transition: all 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
  }
  .terms-check-wrap.is-checked {
    border-color: var(--ice-red);
    background: rgba(227,30,36,0.04);
  }
  .terms-check-wrap.is-checked .custom-check-box {
    background: var(--ice-red);
    border-color: var(--ice-red);
  }
  .terms-check-wrap.is-checked .custom-check-box svg {
    opacity: 1;
    transform: scale(1);
  }
  .terms-check-text {
    font-size: 0.85rem;
    color: var(--ice-text-2);
    line-height: 1.5;
    font-weight: 500;
    flex: 1;
  }
  .terms-check-text a {
    color: var(--ice-red);
    font-weight: 700;
    text-decoration: none;
  }
  .terms-check-text a:hover {
    text-decoration: underline;
  }
  .has-error .terms-check-wrap {
    border-color: var(--ice-red);
    background: rgba(227,30,36,0.06);
  }
  .error-msg {
    display: none;
    font-size: 0.7rem;
    font-weight: 600;
    color: var(--ice-red);
    margin-top: 0.3rem;
  }

  /* Responsive */
  @media (max-width: 860px) {
    .auth-card { grid-template-columns: 1fr; max-width: 520px; }
    .auth-left  { padding: 2.5rem 2rem; }
    .auth-right { padding: 2.5rem 2rem; }
    .auth-features { display: none; }
    .auth-left-heading { font-size: 1.4rem; }
    .auth-left-desc { margin-bottom: 0; }
    .af-row { grid-template-columns: 1fr; }
  }
  @media (max-width: 480px) {
    .auth-page  { padding: 1.5rem 1rem; }
    .auth-left  { padding: 2rem 1.5rem; }
    .auth-right { padding: 2rem 1.5rem; }
  }
</style>

<div class="auth-page">
  <div class="auth-card">

    <!-- Left Panel -->
    <div class="auth-left">
      <div class="auth-brand">
        <div class="auth-brand-logo">
          <img src="{{ asset('img/logo.png') }}" alt="ICE">
        </div>
        <div class="auth-brand-text">
          <span class="auth-brand-name">INDO CAHAYA EXPRESS</span>
          <span class="auth-brand-sub">Pengiriman Internasional</span>
        </div>
      </div>

      <h2 class="auth-left-heading">
        Bergabung<br><em>Bersama Kami</em>
      </h2>
      <p class="auth-left-desc">Daftarkan akun Anda dan mulai nikmati layanan pengiriman internasional yang cepat, aman, dan terpercaya.</p>

      <div class="auth-features">
        <div class="auth-feature">
          <div class="auth-feature-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
              <circle cx="9" cy="7" r="4"/>
              <line x1="19" y1="8" x2="19" y2="14"/>
              <line x1="22" y1="11" x2="16" y2="11"/>
            </svg>
          </div>
          <span>Daftar gratis dalam hitungan menit</span>
        </div>
        <div class="auth-feature">
          <div class="auth-feature-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
          </div>
          <span>Data Anda aman & terenkripsi</span>
        </div>
        <div class="auth-feature">
          <div class="auth-feature-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <circle cx="11" cy="11" r="8"/>
              <path d="m21 21-4.35-4.35"/>
            </svg>
          </div>
          <span>Lacak semua pengiriman Anda</span>
        </div>
        <div class="auth-feature">
          <div class="auth-feature-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
            </svg>
          </div>
          <span>Express & economy tersedia</span>
        </div>
      </div>
    </div>

    <!-- Right Panel -->
    <div class="auth-right">
      <div class="auth-title">Buat Akun Baru</div>
      <div class="auth-subtitle">Isi data di bawah untuk mendaftar</div>

      @if (session('success'))
        <div class="auth-alert success">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
            <polyline points="22 4 12 14.01 9 11.01"/>
          </svg>
          <div>
            <strong>Pendaftaran berhasil!</strong><br>
            Akun Anda telah dibuat. Silakan <a href="{{ route('login') }}" style="color:#065f46; font-weight:800;">login di sini</a>.
          </div>
        </div>
      @else

        @if ($errors->any())
          <div class="auth-alert error">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10"/>
              <line x1="12" y1="8" x2="12" y2="12"/>
              <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <div>
              <strong>Pendaftaran gagal:</strong>
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          </div>
        @endif

        <form method="POST" action="{{ route('register.store') }}">
          @csrf

          <div class="af-section">Informasi Pribadi</div>
          <div class="af-row">
            <div class="af-group">
              <label class="af-label">Nama Lengkap <span class="req">*</span></label>
              <div class="af-input-wrap">
                <input type="text" name="name" required autofocus
                       value="{{ old('name') }}" placeholder="Contoh: Budi Santoso">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                </svg>
              </div>
            </div>
            <div class="af-group">
              <label class="af-label">Nama Perusahaan <span class="req">*</span></label>
              <div class="af-input-wrap">
                <input type="text" name="company_name" required
                       value="{{ old('company_name') }}" placeholder="PT Maju Jaya / -">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
              </div>
              <span class="af-hint">Isi "-" jika perorangan</span>
            </div>
          </div>

          <div class="af-section">Kontak</div>
          <div class="af-row full">
            <div class="af-group">
              <label class="af-label">Email <span class="req">*</span></label>
              <div class="af-input-wrap">
                <input type="email" name="email" required
                       value="{{ old('email') }}" placeholder="email@contoh.com">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                  <polyline points="22,6 12,13 2,6"/>
                </svg>
              </div>
              <span class="af-hint">Email digunakan sebagai identitas pengirim di invoice</span>
            </div>
          </div>

          <div class="af-row">
            <div class="af-group">
              <label class="af-label">Nomor Telepon <span class="req">*</span></label>
              <div class="af-input-wrap">
                <input type="text" name="no_telp" required
                       value="{{ old('no_telp') }}" placeholder="08123456789">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.18 2 2 0 0 1 3.6 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.6a16 16 0 0 0 5.49 5.49l.96-.96a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21 16v.92z"/>
                </svg>
              </div>
            </div>
            <div class="af-group">
              <label class="af-label">Kota <span class="req">*</span></label>
              <div class="af-input-wrap">
                <input type="text" name="kota" required
                       value="{{ old('kota') }}" placeholder="Contoh: Jakarta">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                </svg>
              </div>
            </div>
          </div>

          <div class="af-section">Keamanan Akun</div>
          <div class="af-row">
            <div class="af-group">
              <label class="af-label">Password <span class="req">*</span></label>
              <div class="af-input-wrap">
                <input type="password" name="password" required placeholder="Min. 6 karakter">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
              </div>
            </div>
            <div class="af-group">
              <label class="af-label">Konfirmasi Password <span class="req">*</span></label>
              <div class="af-input-wrap">
                <input type="password" name="password_confirmation" required placeholder="Ulangi password">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
              </div>
            </div>
          </div>

          {{-- Terms & Conditions Checkbox (FIXED) --}}
          <div class="af-group" id="grp-terms">
            <input type="checkbox" name="terms_accepted" id="termsCheckbox" value="1" style="display: none;">
            <label class="terms-check-wrap" id="termsWrap" for="termsCheckbox">
              <div class="custom-check-box">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                  <polyline points="20 6 9 17 4 12"/>
                </svg>
              </div>
              <span class="terms-check-text">
                Saya telah membaca dan menyetujui <a href="{{ route('terms') }}" target="_blank">Syarat &amp; Ketentuan</a> Indo Cahaya Express
              </span>
            </label>
            <span class="error-msg">Anda harus menyetujui syarat dan ketentuan untuk mendaftar.</span>
          </div>

          <button type="submit" class="af-submit">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
              <circle cx="9" cy="7" r="4"/>
              <line x1="19" y1="8" x2="19" y2="14"/>
              <line x1="22" y1="11" x2="16" y2="11"/>
            </svg>
            Buat Akun Sekarang
          </button>
        </form>

      @endif

      <div class="af-divider"><span>atau</span></div>
      <div class="af-link-box">
        Sudah punya akun?&nbsp;<a href="{{ route('login') }}">Login di sini</a>
      </div>
    </div>

  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const cb = document.getElementById('termsCheckbox');
    const wrap = document.getElementById('termsWrap');
    const grp = document.getElementById('grp-terms');
    const errorMsg = grp.querySelector('.error-msg');

    function updateCheckboxUI() {
      if (cb.checked) {
        wrap.classList.add('is-checked');
        grp.classList.remove('has-error');
        if (errorMsg) errorMsg.style.display = 'none';
      } else {
        wrap.classList.remove('is-checked');
      }
    }

    // Toggle checkbox when clicking on the label (including the link? But link click will bubble)
    // However, clicking on the <a> will navigate, we don't want to toggle.
    // So we intercept click on the label and only toggle if target is not the link.
    wrap.addEventListener('click', function(e) {
      // If the click is on the link or any of its children, do not toggle.
      if (e.target.closest('a')) {
        return;
      }
      e.preventDefault();
      cb.checked = !cb.checked;
      cb.dispatchEvent(new Event('change'));
    });

    cb.addEventListener('change', updateCheckboxUI);
    updateCheckboxUI();

    // Form validation
    const form = document.querySelector('form[action="{{ route('register.store') }}"]');
    if (form) {
      form.addEventListener('submit', function(e) {
        if (!cb.checked) {
          e.preventDefault();
          grp.classList.add('has-error');
          if (errorMsg) errorMsg.style.display = 'block';
          grp.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else {
          grp.classList.remove('has-error');
          if (errorMsg) errorMsg.style.display = 'none';
        }
      });
    }
  });
</script>
@endsection