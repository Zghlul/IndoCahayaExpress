@extends('layouts.app')
@section('title', 'Login - Indo Cahaya Express')
@section('content')

<style>
  /* ══ LOGIN PAGE ══ */
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

  /* Subtle background decoration */
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
    grid-template-columns: 420px 1fr;
    max-width: 900px;
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
    padding: 3.5rem 3rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    position: relative;
    overflow: hidden;
  }

  /* Grid pattern overlay */
  .auth-left::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image:
      linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
      linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
    background-size: 32px 32px;
    pointer-events: none;
  }

  /* Red accent glow */
  .auth-left::after {
    content: '';
    position: absolute;
    bottom: -80px; right: -80px;
    width: 280px; height: 280px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(227,30,36,0.2) 0%, transparent 65%);
    pointer-events: none;
  }

  .auth-brand {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    margin-bottom: 2.5rem;
    position: relative;
    z-index: 1;
  }
  .auth-brand-logo {
    width: 40px; height: 40px;
    border-radius: 10px;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.15);
    display: flex; align-items: center; justify-content: center;
    overflow: hidden;
  }
  .auth-brand-logo img { height: 28px; width: auto;}
  .auth-brand-text { display: flex; flex-direction: column; }
  .auth-brand-name {
    font-size: 0.82rem; font-weight: 900;
    color: #fff; letter-spacing: 0.04em;
    line-height: 1.15;
  }
  .auth-brand-sub {
    font-size: 0.58rem; font-weight: 600;
    color: rgba(255,255,255,0.45);
    text-transform: uppercase; letter-spacing: 0.1em;
  }

  .auth-left-heading {
    font-size: 1.75rem;
    font-weight: 900;
    color: #fff;
    line-height: 1.25;
    letter-spacing: -0.03em;
    margin-bottom: 0.875rem;
    position: relative; z-index: 1;
  }
  .auth-left-heading em {
    font-style: italic;
    font-family: 'DM Serif Display', Georgia, serif;
    color: rgba(255,255,255,0.75);
    font-weight: 400;
  }

  .auth-left-desc {
    font-size: 0.875rem;
    color: rgba(255,255,255,0.55);
    line-height: 1.7;
    margin-bottom: 2.5rem;
    position: relative; z-index: 1;
  }

  .auth-features {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    position: relative; z-index: 1;
  }
  .auth-feature {
    display: flex;
    align-items: center;
    gap: 0.875rem;
  }
  .auth-feature-icon {
    width: 38px; height: 38px;
    border-radius: 10px;
    background: rgba(255,255,255,0.07);
    border: 1px solid rgba(255,255,255,0.12);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    transition: all 0.2s;
  }
  .auth-feature:hover .auth-feature-icon {
    background: rgba(227,30,36,0.2);
    border-color: rgba(227,30,36,0.3);
  }
  .auth-feature-icon svg { width: 17px; height: 17px; color: rgba(255,255,255,0.8); }
  .auth-feature span {
    font-size: 0.85rem;
    font-weight: 600;
    color: rgba(255,255,255,0.7);
    line-height: 1.4;
  }

  /* ── Right Panel ── */
  .auth-right {
    padding: 3.5rem 3rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    background: var(--ice-surface);
  }

  .auth-title {
    font-size: 1.6rem;
    font-weight: 900;
    color: var(--ice-navy);
    margin-bottom: 0.35rem;
    letter-spacing: -0.02em;
    line-height: 1.2;
  }
  .auth-subtitle {
    font-size: 0.875rem;
    color: var(--ice-text-2);
    margin-bottom: 2rem;
    line-height: 1.6;
  }

  /* Alert */
  .auth-alert {
    display: flex;
    align-items: flex-start;
    gap: 0.65rem;
    padding: 0.875rem 1.1rem;
    border-radius: 10px;
    margin-bottom: 1.5rem;
    font-size: 0.85rem;
    font-weight: 600;
    animation: authAlertIn 0.3s ease;
  }
  .auth-alert.error {
    background: rgba(227,30,36,0.06);
    border: 1.5px solid rgba(227,30,36,0.2);
    color: var(--ice-red-dark);
  }
  .auth-alert.success {
    background: rgba(16,185,129,0.06);
    border: 1.5px solid rgba(16,185,129,0.2);
    color: #065f46;
  }
  .auth-alert svg { width: 17px; height: 17px; flex-shrink: 0; margin-top: 1px; }
  @keyframes authAlertIn {
    from { opacity: 0; transform: translateY(-6px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  /* Form groups */
  .af-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    margin-bottom: 1.25rem;
  }
  .af-label {
    font-size: 0.75rem;
    font-weight: 800;
    color: var(--ice-navy);
    text-transform: uppercase;
    letter-spacing: 0.07em;
  }
  .af-input-wrap { position: relative; }
  .af-input-wrap svg {
    position: absolute;
    left: 1rem; top: 50%;
    transform: translateY(-50%);
    width: 17px; height: 17px;
    color: var(--ice-text-muted);
    pointer-events: none;
    transition: color 0.2s;
  }
  .af-input-wrap input {
    width: 100%;
    padding: 0.875rem 1rem 0.875rem 2.9rem;
    border-radius: 10px;
    border: 1.5px solid var(--ice-border);
    background: var(--ice-surface-alt);
    font-size: 0.9rem;
    color: var(--ice-text);
    font-weight: 500;
    outline: none;
    transition: all 0.2s;
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

  /* Submit button */
  .af-submit {
    width: 100%;
    padding: 0.9rem 1.5rem;
    border-radius: 10px;
    border: none;
    background: var(--ice-red);
    color: #fff;
    font-size: 0.95rem;
    font-weight: 800;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.6rem;
    margin-top: 0.5rem;
    transition: all 0.2s;
    font-family: 'Plus Jakarta Sans', sans-serif;
    letter-spacing: 0.01em;
    box-shadow: 0 6px 20px rgba(227,30,36,0.3), inset 0 1px 0 rgba(255,255,255,0.15);
  }
  .af-submit svg { width: 17px; height: 17px; }
  .af-submit:hover {
    background: var(--ice-red-dark);
    transform: translateY(-1px);
    box-shadow: 0 10px 28px rgba(227,30,36,0.4);
  }
  .af-submit:active { transform: translateY(0); }

  /* Divider */
  .af-divider {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin: 1.75rem 0 1.25rem;
  }
  .af-divider::before, .af-divider::after {
    content: ''; flex: 1; height: 1px;
    background: var(--ice-border);
  }
  .af-divider span {
    font-size: 0.72rem;
    font-weight: 700;
    color: var(--ice-text-muted);
    text-transform: uppercase;
    letter-spacing: 0.08em;
  }

  /* Register link box */
  .af-link-box {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.875rem;
    border-radius: 10px;
    background: var(--ice-surface-alt);
    border: 1.5px solid var(--ice-border);
    font-size: 0.875rem;
    color: var(--ice-text-2);
    transition: all 0.2s;
  }
  .af-link-box:hover {
    border-color: var(--ice-border-2);
    background: #EEF2F7;
  }
  .af-link-box a {
    color: var(--ice-red);
    font-weight: 800;
    text-decoration: none;
    transition: color 0.2s;
  }
  .af-link-box a:hover { color: var(--ice-red-dark); }

  /* Responsive */
  @media (max-width: 820px) {
    .auth-card { grid-template-columns: 1fr; max-width: 480px; }
    .auth-left  { padding: 2.5rem 2rem; }
    .auth-right { padding: 2.5rem 2rem; }
    .auth-features { display: none; }
    .auth-left-heading { font-size: 1.5rem; }
    .auth-brand { margin-bottom: 1.5rem; }
    .auth-left-desc { margin-bottom: 0; }
  }
  @media (max-width: 480px) {
    .auth-page { padding: 1.5rem 1rem; }
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
          <img src="{{ asset('img/logo_white.png') }}" alt="ICE">
        </div>
        <div class="auth-brand-text">
          <span class="auth-brand-name">INDO CAHAYA EXPRESS</span>
          <span class="auth-brand-sub">Pengiriman Internasional</span>
        </div>
      </div>

      <h2 class="auth-left-heading">
        Solusi Pengiriman<br><em>Internasional</em>
      </h2>
      <p class="auth-left-desc">Platform pengiriman terpercaya dari Indonesia ke seluruh dunia. Cepat, aman, dan terjangkau.</p>

      <div class="auth-features">
        <div class="auth-feature">
          <div class="auth-feature-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
          </div>
          <span>Lacak pengiriman secara real-time</span>
        </div>
        <div class="auth-feature">
          <div class="auth-feature-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
          </div>
          <span>Pengiriman aman & terjamin</span>
        </div>
        <div class="auth-feature">
          <div class="auth-feature-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
            </svg>
          </div>
          <span>Express & economy tersedia</span>
        </div>
        <div class="auth-feature">
          <div class="auth-feature-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10"/>
              <line x1="2" y1="12" x2="22" y2="12"/>
              <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
            </svg>
          </div>
          <span>50+ negara tujuan pengiriman</span>
        </div>
      </div>
    </div>

    <!-- Right Panel -->
    <div class="auth-right">
      <div class="auth-title">Selamat Datang</div>
      <div class="auth-subtitle">Masuk ke akun Anda untuk melanjutkan</div>

      @if ($errors->any() || session('error'))
      <div class="auth-alert error">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="10"/>
          <line x1="12" y1="8" x2="12" y2="12"/>
          <line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        <span>{{ $errors->first() ?? session('error') }}</span>
      </div>
      @endif

      <form method="POST" action="{{ route('login.authenticate') }}">
        @csrf

        <div class="af-group">
          <label class="af-label">Email</label>
          <div class="af-input-wrap">
            <input type="email" name="email" placeholder="nama@email.com"
                   value="{{ old('email') }}" required autofocus>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
            </svg>
          </div>
        </div>

        <div class="af-group">
          <label class="af-label">Password</label>
          <div class="af-input-wrap">
            <input type="password" name="password" placeholder="Masukkan password" required>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
          </div>
        </div>

        <button type="submit" name="login" class="af-submit">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
            <polyline points="10 17 15 12 10 7"/>
            <line x1="15" y1="12" x2="3" y2="12"/>
          </svg>
          Masuk ke Akun
        </button>
      </form>

      <div class="af-divider"><span>atau</span></div>

      <div class="af-link-box">
        Belum punya akun?&nbsp;<a href="{{ route('register') }}">Daftar sekarang</a>
      </div>
    </div>

  </div>
</div>

@endsection
