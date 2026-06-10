@extends('layouts.app')
@section('title', 'Kalkulator Ongkir - Indo Cahaya Express')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300&family=DM+Serif+Display:ital@0;1&display=swap');

:root {
  --red:           #E31E24;
  --red-hover:     #C7181D;
  --red-deep:      #A0121A;
  --navy-900:      #060F2E;
  --navy-800:      #0A1A4A;
  --navy-700:      #0D2260;
  --navy-600:      #102B78;
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
  --green:         #16A34A;
  --shadow-sm:     0 2px 8px rgba(9,24,60,0.08);
  --shadow-md:     0 8px 24px rgba(9,24,60,0.10);
  --shadow-lg:     0 16px 48px rgba(9,24,60,0.12);
  --shadow-xl:     0 32px 80px rgba(9,24,60,0.14);
  --ease-out:      cubic-bezier(0.22, 1, 0.36, 1);
  --ease-spring:   cubic-bezier(0.34, 1.56, 0.64, 1);
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

.cp {
  font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
  color: var(--text-primary);
  background: var(--white);
  line-height: 1.6;
  overflow-x: hidden;
}
.cp .container {
  max-width: 1440px;
  margin: 0 auto;
  padding: 0 3rem;
  width: 100%;
}
@media (max-width: 1280px) { .cp .container { padding: 0 2.5rem; } }
@media (max-width: 768px)  { .cp .container { padding: 0 1.5rem; } }

/* ══ SCROLL REVEAL (seperti di home) ══ */
.reveal {
  opacity: 0;
  transform: translateY(28px);
  transition: opacity 0.7s var(--ease-out), transform 0.7s var(--ease-out);
}
.reveal.is-visible {
  opacity: 1;
  transform: translateY(0);
}
.reveal-d1 { transition-delay: 0.05s; }
.reveal-d2 { transition-delay: 0.1s; }
.reveal-d3 { transition-delay: 0.15s; }
.reveal-d4 { transition-delay: 0.2s; }
.reveal-d5 { transition-delay: 0.25s; }

/* ══ HERO ══ */
.hero {
  position: relative;
  min-height: 100vh;
  display: flex;
  align-items: center;
  overflow: hidden;
  background: var(--navy-900);
}
.hero-canvas {
  position: absolute; inset: 0; z-index: 0;
  background:
    radial-gradient(ellipse 100% 80% at 100% 0%,   rgba(20,56,160,0.55) 0%, transparent 55%),
    radial-gradient(ellipse 70%  60% at 0%   100%, rgba(227,30,36,0.10) 0%, transparent 50%),
    radial-gradient(ellipse 60%  70% at 55%  50%,  rgba(11,26,74,0.9)   0%, transparent 70%),
    linear-gradient(168deg, #060F2E 0%, #0B1C55 45%, #091640 100%);
}
.hero-canvas::after {
  content: '';
  position: absolute; inset: 0;
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.035'/%3E%3C/svg%3E");
  pointer-events: none; mix-blend-mode: overlay; opacity: 0.5;
}
.hero-grid {
  position: absolute; inset: 0; z-index: 0;
  background-image: radial-gradient(circle, rgba(255,255,255,0.055) 1px, transparent 1px);
  background-size: 44px 44px;
  mask-image: radial-gradient(ellipse 90% 80% at 50% 50%, black 40%, transparent 80%);
}
.hero-lines { position: absolute; inset: 0; z-index: 0; overflow: hidden; }
.hero-lines::before, .hero-lines::after {
  content: ''; position: absolute; top: 0; bottom: 0; width: 1px;
}
.hero-lines::before {
  right: 34%;
  background: linear-gradient(to bottom, transparent 0%, rgba(227,30,36,0.35) 25%, rgba(227,30,36,0.15) 70%, transparent 100%);
}
.hero-lines::after {
  left: 52%;
  background: linear-gradient(to bottom, transparent 10%, rgba(59,174,224,0.12) 40%, rgba(59,174,224,0.06) 75%, transparent 100%);
}
.hero-glow { position: absolute; z-index: 0; border-radius: 50%; filter: blur(80px); pointer-events: none; }
.hero-glow-1 { width: 700px; height: 700px; top: -200px; right: -100px; background: radial-gradient(circle, rgba(20,56,160,0.4) 0%, transparent 65%); }
.hero-glow-2 { width: 500px; height: 500px; bottom: -100px; left: 0; background: radial-gradient(circle, rgba(227,30,36,0.1) 0%, transparent 65%); }
.hero .container { position: relative; z-index: 2; display: flex; flex-direction: column; }

.hero-inner {
  display: grid;
  grid-template-columns: 1.15fr 480px;
  gap: 4rem;
  align-items: start;
  padding: 1rem 0 3rem;
}
.hero-text { max-width: 720px; }

.hero-badge {
  display: inline-flex; align-items: center; gap: 0.6rem;
  margin-bottom: 2.4rem;
  padding: 0.5rem 1rem 0.5rem 0.55rem;
  border-radius: 99px;
  border: 1px solid rgba(227,30,36,0.3);
  background: rgba(227,30,36,0.07);
  backdrop-filter: blur(10px);
}
.hero-badge-dot {
  width: 26px; height: 26px; border-radius: 50%;
  background: linear-gradient(135deg, var(--red), var(--red-deep));
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0; box-shadow: 0 4px 12px rgba(227,30,36,0.4);
}
.hero-badge-dot svg { width: 13px; height: 13px; color: #fff; }
.hero-badge span {
  font-size: 0.7rem; font-weight: 800;
  letter-spacing: 0.12em; text-transform: uppercase;
  color: rgba(255,255,255,0.75); padding-right: 0.3rem;
}

.hero-heading {
  font-size: clamp(3.8rem, 6vw, 7.5rem);
  font-weight: 900; line-height: 0.93;
  letter-spacing: -0.045em; color: #fff;
  margin-bottom: 2.2rem;
}
.hero-heading .word-plain { display: block; }
.hero-heading .word-serif {
  display: block;
  font-family: 'DM Serif Display', serif; font-style: italic;
  font-weight: 400; color: var(--red); font-size: 1.1em;
  letter-spacing: -0.025em; line-height: 1.0; margin: 0.03em 0;
  text-shadow: 0 0 40px rgba(227,30,36,0.85), 0 0 80px rgba(227,30,36,0.55), 0 0 130px rgba(227,30,36,0.28);
}
.hero-heading .word-dim {
  display: block; color: rgba(255,255,255,0.40);
  font-size: 0.52em; font-weight: 500; letter-spacing: -0.01em;
  font-family: 'Plus Jakarta Sans', sans-serif;
  margin-top: 0.22em; line-height: 1.25;
}

.hero-desc {
  font-size: 1.05rem; color: rgba(255,255,255,0.55);
  max-width: 500px; line-height: 1.8; margin-bottom: 3rem; font-weight: 400;
}

.hero-actions { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; }
.btn-hero-primary {
  display: inline-flex; align-items: center; gap: 0.55rem;
  padding: 1rem 2.2rem; background: var(--red); color: #fff;
  border-radius: 8px; font-family: 'Plus Jakarta Sans', sans-serif;
  font-weight: 700; font-size: 0.92rem; letter-spacing: 0.01em;
  text-decoration: none; border: none; cursor: pointer;
  transition: all 0.25s var(--ease-out);
  box-shadow: 0 8px 28px rgba(227,30,36,0.4), inset 0 1px 0 rgba(255,255,255,0.12);
  white-space: nowrap;
}
.btn-hero-primary svg { width: 17px; height: 17px; flex-shrink: 0; }
.btn-hero-primary:hover { background: var(--red-hover); transform: translateY(-2px); box-shadow: 0 14px 36px rgba(227,30,36,0.5); }

.btn-hero-ghost {
  display: inline-flex; align-items: center; gap: 0.65rem;
  padding: 0.9rem 0.4rem; color: rgba(255,255,255,0.6);
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-weight: 600; font-size: 0.9rem;
  text-decoration: none; border: none; background: transparent;
  cursor: pointer; transition: all 0.22s var(--ease-out); white-space: nowrap;
}
.btn-hero-ghost .icon-ring {
  width: 40px; height: 40px; border-radius: 50%;
  border: 1.5px solid rgba(255,255,255,0.2);
  display: flex; align-items: center; justify-content: center;
  transition: all 0.22s var(--ease-out);
}
.btn-hero-ghost .icon-ring svg { width: 16px; height: 16px; }
.btn-hero-ghost:hover { color: rgba(255,255,255,0.9); }
.btn-hero-ghost:hover .icon-ring { background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.45); transform: translateX(3px); }
.hero-divider { width: 1px; height: 28px; background: rgba(255,255,255,0.12); margin: 0 0.3rem; }

.hero-trust {
  display: flex; align-items: center; gap: 0.75rem;
  margin-top: 3rem; padding-top: 2.4rem;
  border-top: 1px solid rgba(255,255,255,0.07);
}
.trust-avatars { display: flex; align-items: center; }
.trust-avatar {
  width: 32px; height: 32px; border-radius: 50%;
  border: 2px solid rgba(255,255,255,0.15); background: var(--navy-600);
  color: rgba(255,255,255,0.8);
  display: flex; align-items: center; justify-content: center;
  font-size: 0.72rem; font-weight: 800; margin-left: -8px;
}
.trust-avatars .trust-avatar:first-child { margin-left: 0; }
.trust-text { font-size: 0.8rem; color: rgba(255,255,255,0.45); line-height: 1.4; }
.trust-text strong { display: block; color: rgba(255,255,255,0.75); font-weight: 700; font-size: 0.82rem; }

/* ── Calculator Card (glassmorphism, right column) ── */
.calc-card {
  position: relative;
  background: rgba(255,255,255,0.05);
  backdrop-filter: blur(40px);
  -webkit-backdrop-filter: blur(40px);
  border: 1px solid rgba(255,255,255,0.1);
  border-radius: 24px;
  padding: 2.8rem;
  overflow: hidden;
  box-shadow:
    0 40px 100px rgba(0,0,0,0.35),
    0 8px 24px rgba(0,0,0,0.2),
    inset 0 1px 0 rgba(255,255,255,0.12);
}
.calc-card::before {
  content: '';
  position: absolute; top: -1px; left: 15%; right: 15%;
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.35), transparent);
}
.calc-card::after {
  content: '';
  position: absolute; bottom: -60px; right: -60px;
  width: 220px; height: 220px; border-radius: 50%;
  background: radial-gradient(circle, rgba(227,30,36,0.18) 0%, transparent 65%);
  pointer-events: none;
}
.calc-card-head {
  display: flex; align-items: flex-start; justify-content: space-between;
  margin-bottom: 2rem;
}
.calc-card-title {
  font-size: 1.35rem; font-weight: 800;
  color: #fff; line-height: 1.2; letter-spacing: -0.02em;
}
.calc-card-sub { font-size: 0.82rem; color: rgba(255,255,255,0.42); margin-top: 0.3rem; }

.calc-live-badge {
  display: flex; align-items: center; gap: 0.4rem;
  background: rgba(34,197,94,0.12);
  border: 1px solid rgba(34,197,94,0.28);
  border-radius: 99px;
  padding: 0.32rem 0.75rem;
  font-size: 0.68rem; font-weight: 800;
  color: #4ade80; letter-spacing: 0.06em; text-transform: uppercase; flex-shrink: 0;
}
.calc-live-dot { width: 6px; height: 6px; border-radius: 50%; background: #4ade80; animation: live-pulse 2s ease-in-out infinite; }
@keyframes live-pulse { 0%,100% { opacity:1; transform:scale(1); } 50% { opacity:0.45; transform:scale(0.75); } }

/* Form elements — dark glass style */
.f-label-dark {
  display: block; font-size: 0.68rem; font-weight: 800;
  letter-spacing: 0.1em; text-transform: uppercase;
  color: rgba(255,255,255,0.38); margin-bottom: 0.55rem;
}
.f-group-dark { margin-bottom: 1.2rem; }
.f-row-2-dark { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
.f-row-4-dark { display: grid; grid-template-columns: repeat(4, 1fr); gap: 0.75rem; }

.f-input-dark {
  width: 100%;
  background: rgba(255,255,255,0.06);
  border: 1px solid rgba(255,255,255,0.12);
  border-radius: 12px;
  padding: 0.95rem 1.2rem;
  color: #fff;
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 0.9rem; font-weight: 500;
  outline: none; transition: all 0.2s;
}
.f-input-dark::placeholder { color: rgba(255,255,255,0.25); }
.f-input-dark:focus { border-color: rgba(227,30,36,0.55); background: rgba(255,255,255,0.09); box-shadow: 0 0 0 3px rgba(227,30,36,0.1); }
.f-input-dark:hover { border-color: rgba(255,255,255,0.2); }
.f-origin-dark {
  width: 100%;
  background: rgba(255,255,255,0.04);
  border: 1px solid rgba(255,255,255,0.08);
  border-radius: 12px; padding: 0.95rem 1.2rem;
  color: rgba(255,255,255,0.45);
  font-size: 0.9rem; font-weight: 600;
  display: flex; align-items: center; gap: 0.6rem;
}
.f-origin-dark svg { width: 14px; height: 14px; flex-shrink: 0; }

.f-section-divider {
  display: flex; align-items: center; gap: 0.5rem;
  font-size: 0.62rem; font-weight: 800;
  color: rgba(255,255,255,0.28);
  text-transform: uppercase; letter-spacing: 0.1em;
  margin: 1.4rem 0 1.2rem;
  padding-bottom: 0.8rem;
  border-bottom: 1px solid rgba(255,255,255,0.07);
}
.f-section-divider svg { width: 11px; height: 11px; color: var(--red); }

.calc-btn {
  width: 100%; margin-top: 0.5rem;
  padding: 1.05rem 1.5rem;
  border-radius: 12px; border: none;
  background: linear-gradient(135deg, var(--red), var(--red-hover));
  color: #fff; font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 1rem; font-weight: 800; letter-spacing: 0.01em;
  cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.75rem;
  transition: all 0.25s var(--ease-out);
  box-shadow: 0 8px 28px rgba(227,30,36,0.4), inset 0 1px 0 rgba(255,255,255,0.12);
}
.calc-btn:hover { transform: translateY(-2px); box-shadow: 0 14px 36px rgba(227,30,36,0.5); }
.calc-btn:active { transform: translateY(0); }
.calc-btn:disabled { opacity: 0.7; cursor: not-allowed; transform: none; box-shadow: none; }
.calc-btn svg { width: 18px; height: 18px; }
@keyframes spin { to { transform: rotate(360deg); } }
.spin { animation: spin 0.8s linear infinite; }

.calc-feats {
  display: grid; grid-template-columns: 1fr 1fr; gap: 0.6rem;
  margin-top: 1.6rem; padding-top: 1.6rem;
  border-top: 1px solid rgba(255,255,255,0.07);
}
.calc-feat { display: flex; align-items: center; gap: 0.5rem; font-size: 0.78rem; color: rgba(255,255,255,0.42); font-weight: 500; }
.calc-feat svg { width: 13px; height: 13px; color: var(--red); flex-shrink: 0; }

/* ── Hero stats strip ── */
.hero-stats-strip {
  display: grid; grid-template-columns: repeat(4, 1fr);
  border-top: 1px solid rgba(255,255,255,0.06);
  padding: 2.8rem 0;
}
.hero-stat { padding: 0 2rem; position: relative; text-align: center; }
.hero-stat + .hero-stat::before {
  content: ''; position: absolute; left: 0; top: 15%; height: 70%;
  width: 1px; background: rgba(255,255,255,0.07);
}
.hero-stat-num {
  font-size: 2.4rem; font-weight: 900; color: #fff; line-height: 1;
  letter-spacing: -0.04em; margin-bottom: 0.35rem;
}
.hero-stat-num em { font-style: normal; color: var(--red); }
.hero-stat-label {
  font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
  letter-spacing: 0.09em; color: rgba(255,255,255,0.32);
}

/* ══ RESULT ══ */
.result-section {
  background: var(--surface);
  padding: 4rem 0;
}
.res-wrap { max-width: 1000px; margin: 0 auto; }
.res-header {
  background: linear-gradient(155deg, var(--navy-800) 0%, var(--navy-700) 100%);
  border-radius: 20px 20px 0 0; padding: 1.3rem 1.9rem;
  display: flex; align-items: center; gap: 0.75rem; color: #fff;
  position: relative; overflow: hidden;
}
.res-header::after {
  content: ''; position: absolute; inset: 0;
  background-image: radial-gradient(circle, rgba(255,255,255,0.04) 1px, transparent 1px);
  background-size: 24px 24px; pointer-events: none;
}
.res-header svg { width: 18px; height: 18px; flex-shrink: 0; position: relative; z-index: 1; }
.res-header span { font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; opacity: 0.85; position: relative; z-index: 1; }
.res-summary {
  display: grid; grid-template-columns: repeat(4, 1fr);
  gap: 1px; background-color: var(--border);
  border: 1px solid var(--border); border-top: none;
}
.res-summary-cell { background: var(--white); padding: 1.3rem 1.6rem; }
.res-cell-lbl { font-size: 0.6rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.35rem; }
.res-cell-val { font-size: 0.95rem; font-weight: 700; color: var(--text-primary); }
.res-summary-cell.highlight { background: #fff5f5; }
.res-summary-cell.highlight .res-cell-val { color: var(--red); font-size: 1rem; }
.res-vendors-wrap {
  background: var(--white); border: 1px solid var(--border);
  border-top: none; border-radius: 0 0 20px 20px; padding: 2rem;
}
.res-vendors-title { font-size: 0.7rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 1.4rem; }
.res-vendors-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.25rem; }

/* Vendor cards */
.vendor-card {
  border-radius: 18px; padding: 1.6rem; border: 1.5px solid var(--border);
  background: var(--surface); display: flex; flex-direction: column; gap: 1rem;
  transition: all 0.3s var(--ease-out);
}
.vendor-card.available:hover { transform: translateY(-4px); box-shadow: var(--shadow-lg); }
.vendor-card.unavailable { opacity: 0.55; background: var(--surface-2); }
.vendor-card-top { display: flex; justify-content: space-between; align-items: center; gap: 0.75rem; }
.vendor-name { font-size: 1.25rem; font-weight: 900; letter-spacing: -0.025em; }
.vendor-badge { font-size: 0.6rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; padding: 0.3rem 0.85rem; border-radius: 99px; white-space: nowrap; flex-shrink: 0; }
.vendor-badge.ok { background: rgba(22,163,74,0.1); color: #16A34A; border: 1px solid rgba(22,163,74,0.22); }
.vendor-badge.na { background: var(--surface-2); color: var(--text-muted); border: 1px solid var(--border); }
.vendor-meta { display: flex; flex-direction: column; gap: 0.5rem; }
.vendor-meta-row { display: flex; justify-content: space-between; align-items: center; font-size: 0.8rem; }
.vendor-meta-row span:first-child { color: var(--text-muted); }
.vendor-meta-row span:last-child { font-weight: 700; color: var(--text-primary); }
.vendor-price { font-size: 1.85rem; font-weight: 900; letter-spacing: -0.04em; line-height: 1; }
.vendor-price-na { font-size: 0.9rem; font-weight: 700; color: var(--text-muted); padding: 0.5rem 0; }
.vendor-btn {
  display: block; text-align: center; padding: 0.9rem 1rem;
  border-radius: 12px; font-size: 0.875rem; font-weight: 800;
  text-decoration: none; transition: all 0.22s var(--ease-out);
  margin-top: auto; letter-spacing: 0.01em;
}
.vendor-btn.active { color: #fff; box-shadow: 0 6px 20px rgba(0,0,0,0.18); }
.vendor-btn.active:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(0,0,0,0.25); }
.vendor-btn.inactive { background: var(--surface-2); color: var(--text-muted); cursor: not-allowed; }

/* ══ SECTION BASE ══ */
.section { padding: 7rem 0; }
.section-soft { background: var(--surface); }
.section-alt  { background: var(--surface-2); }
.section-label {
  display: inline-flex; align-items: center; gap: 0.45rem;
  background: rgba(227,30,36,0.07); border: 1px solid rgba(227,30,36,0.14);
  color: var(--red); border-radius: 99px; padding: 0.35rem 0.9rem;
  font-size: 0.67rem; font-weight: 800; letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 1.1rem;
}
.section-label svg { width: 10px; height: 10px; }
.section-heading { font-size: clamp(2rem, 3vw, 2.9rem); font-weight: 900; color: var(--text-primary); letter-spacing: -0.035em; line-height: 1.1; margin-bottom: 0.8rem; }
.section-sub { font-size: 1rem; color: var(--text-2); max-width: 540px; line-height: 1.75; font-weight: 400; }
.section-center { text-align: center; margin-bottom: 4.5rem; }
.section-center .section-sub { margin: 0 auto; }

/* ══ HOW IT WORKS ══ */
.steps-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem; }
.step-item { text-align: center; }
.step-num {
  width: 56px; height: 56px; border-radius: 50%;
  background: linear-gradient(135deg, var(--navy-800), var(--navy-700));
  color: #fff; font-size: 1.1rem; font-weight: 800;
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 1.2rem;
  box-shadow: 0 8px 24px rgba(9,24,60,0.22);
  border: 2px solid rgba(255,255,255,0.1);
}
.step-item h4 { font-size: 0.9rem; font-weight: 800; color: var(--text-primary); margin-bottom: 0.4rem; letter-spacing: -0.015em; }
.step-item p  { font-size: 0.8rem; color: var(--text-2); line-height: 1.6; }

/* ══ PILLARS ══ */
.pillars { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.75rem; }
.pillar {
  padding: 2.8rem 2.4rem; border-radius: 22px;
  background: var(--white); border: 1px solid var(--border);
  position: relative; overflow: hidden;
  transition: all 0.35s var(--ease-out);
}
.pillar:hover { border-color: transparent; box-shadow: 0 24px 60px rgba(9,24,60,0.11); transform: translateY(-5px); }
.pillar-count {
  position: absolute; top: 2rem; right: 2.2rem;
  font-size: 5rem; font-weight: 900; color: rgba(9,24,60,0.04);
  letter-spacing: -0.05em; line-height: 1; pointer-events: none; transition: color 0.35s;
}
.pillar:hover .pillar-count { color: rgba(227,30,36,0.06); }
.pillar-icon {
  width: 58px; height: 58px; border-radius: 16px;
  background: rgba(227,30,36,0.08); color: var(--red);
  display: flex; align-items: center; justify-content: center;
  margin-bottom: 1.8rem; transition: all 0.3s var(--ease-out);
}
.pillar:hover .pillar-icon { background: var(--red); color: #fff; transform: scale(1.06); box-shadow: 0 8px 24px rgba(227,30,36,0.3); }
.pillar-icon svg { width: 26px; height: 26px; }
.pillar h3 { font-size: 1.1rem; font-weight: 800; color: var(--text-primary); letter-spacing: -0.02em; margin-bottom: 0.7rem; line-height: 1.25; }
.pillar p  { font-size: 0.875rem; color: var(--text-2); line-height: 1.75; }

/* ══ CTA ══ */
.cta-wrap { padding: 6rem 0; }
.cta-inner {
  position: relative; background: var(--navy-900); border-radius: 28px; overflow: hidden;
  display: grid; grid-template-columns: 1fr 280px; align-items: center; gap: 4rem; padding: 5.5rem 5rem;
}
.cta-inner::before {
  content: ''; position: absolute; inset: 0;
  background-image: linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
  background-size: 48px 48px; pointer-events: none;
}
.cta-inner::after {
  content: ''; position: absolute; top: -100px; left: 40%;
  width: 500px; height: 500px; border-radius: 50%;
  background: radial-gradient(circle, rgba(20,56,160,0.35) 0%, transparent 60%); pointer-events: none;
}
.cta-content { position: relative; z-index: 1; }
.cta-chip {
  display: inline-flex; align-items: center; gap: 0.45rem;
  background: rgba(227,30,36,0.18); border: 1px solid rgba(227,30,36,0.3);
  color: #ff7a7a; border-radius: 99px; padding: 0.32rem 0.85rem;
  font-size: 0.67rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 1.4rem;
}
.cta-chip svg { width: 9px; height: 9px; }
.cta-title { font-size: clamp(1.9rem, 3vw, 2.8rem); font-weight: 900; color: #fff; letter-spacing: -0.035em; line-height: 1.12; margin-bottom: 1rem; }
.cta-title span { color: var(--red); }
.cta-desc { color: rgba(255,255,255,0.5); font-size: 0.975rem; line-height: 1.75; max-width: 520px; margin-bottom: 2.4rem; }
.cta-btns { display: flex; gap: 1rem; flex-wrap: wrap; position: relative; z-index: 1; }
.cta-btn-primary {
  display: inline-flex; align-items: center; gap: 0.55rem;
  background: var(--red); color: #fff; padding: 1rem 2.2rem; border-radius: 10px;
  font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.93rem; font-weight: 700;
  text-decoration: none; border: none; cursor: pointer;
  transition: all 0.25s var(--ease-out); box-shadow: 0 8px 28px rgba(227,30,36,0.4); letter-spacing: 0.01em;
}
.cta-btn-primary svg { width: 18px; height: 18px; }
.cta-btn-primary:hover { background: var(--red-hover); transform: translateY(-2px); box-shadow: 0 14px 40px rgba(227,30,36,0.5); }
.cta-btn-outline {
  display: inline-flex; align-items: center; gap: 0.55rem;
  background: transparent; color: rgba(255,255,255,0.65); padding: 1rem 2.2rem; border-radius: 10px;
  font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.93rem; font-weight: 700;
  text-decoration: none; border: 1.5px solid rgba(255,255,255,0.18); cursor: pointer;
  transition: all 0.25s var(--ease-out); letter-spacing: 0.01em;
}
.cta-btn-outline svg { width: 18px; height: 18px; }
.cta-btn-outline:hover { background: rgba(255,255,255,0.07); border-color: rgba(255,255,255,0.38); color: #fff; }
.cta-pills { position: relative; z-index: 1; display: flex; flex-direction: column; gap: 1rem; }
.cta-pill {
  background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
  border-radius: 16px; padding: 1.4rem 1.8rem; text-align: center;
  backdrop-filter: blur(12px); transition: all 0.25s;
}
.cta-pill:hover { background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.18); }
.cta-pill-num { font-size: 2.1rem; font-weight: 900; color: #fff; line-height: 1; letter-spacing: -0.04em; }
.cta-pill-num em { font-style: normal; color: var(--red); }
.cta-pill-label { font-size: 0.68rem; font-weight: 700; color: rgba(255,255,255,0.38); text-transform: uppercase; letter-spacing: 0.09em; margin-top: 0.3rem; }

/* ══ RESPONSIVE ══ */
@media (max-width: 1200px) {
  .hero-inner { grid-template-columns: 1fr 420px; gap: 3rem; }
  .hero-heading { font-size: clamp(3rem, 6vw, 6rem); }
}
@media (max-width: 1024px) {
  .pillars { grid-template-columns: repeat(2, 1fr); }
  .cta-inner { grid-template-columns: 1fr; padding: 4rem 3.5rem; }
  .cta-pills { flex-direction: row; justify-content: flex-start; }
}
@media (max-width: 860px) {
  .hero-inner { grid-template-columns: 1fr; gap: 3rem; padding: 3rem 0 2.5rem; }
  .hero-heading { font-size: clamp(3rem, 10vw, 5rem); }
  .hero-stats-strip { grid-template-columns: repeat(2, 1fr); }
  .hero-stat:nth-child(3)::before, .hero-stat:nth-child(4)::before { display: none; }
  .f-row-4-dark { grid-template-columns: repeat(2, 1fr); }
  .steps-grid { grid-template-columns: repeat(2, 1fr); }
  .pillars { grid-template-columns: 1fr; }
  .res-summary { grid-template-columns: repeat(2, 1fr); }
  .res-vendors-grid { grid-template-columns: 1fr; }
  .cta-inner { padding: 3.5rem 2.5rem; }
  .cta-pills { display: none; }
  .hero-divider { display: none; }
}
@media (max-width: 600px) {
  .cp .container { padding: 0 1.25rem; }
  .hero-heading { font-size: clamp(2.8rem, 12vw, 4.5rem); }
  .hero-stats-strip { grid-template-columns: 1fr 1fr; }
  .f-row-2-dark, .f-row-4-dark { grid-template-columns: 1fr; }
  .steps-grid { grid-template-columns: 1fr; }
  .section { padding: 5rem 0; }
  .cta-inner { padding: 3rem 1.75rem; }
  .cta-btns { flex-direction: column; }
  .cta-btn-primary, .cta-btn-outline { justify-content: center; }
}
</style>

<div class="cp">

  {{-- ══ HERO ══ --}}
  <section class="hero">
    <div class="hero-canvas"></div>
    <div class="hero-grid"></div>
    <div class="hero-lines"></div>
    <div class="hero-glow hero-glow-1"></div>
    <div class="hero-glow hero-glow-2"></div>
    <div class="container">
      <div class="hero-inner">

        {{-- LEFT: Text dengan animasi reveal --}}
        <div class="hero-text reveal reveal-d1">
          <div class="hero-badge">
            <div class="hero-badge-dot">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <rect x="4" y="2" width="16" height="20" rx="2"/>
                <line x1="8" y1="6" x2="16" y2="6"/>
                <line x1="8" y1="10" x2="16" y2="10"/>
                <line x1="8" y1="14" x2="12" y2="14"/>
              </svg>
            </div>
            <span>Kalkulator Ongkir</span>
          </div>
          <h1 class="hero-heading">
            <span class="word-plain">Hitung Biaya</span>
            <span class="word-serif">Pengiriman</span>
            <span class="word-dim">Instan, Transparan, Tanpa Biaya Tersembunyi</span>
          </h1>
          <p class="hero-desc">
            Masukkan detail paket dan dapatkan estimasi biaya pengiriman ke 200+ negara secara instan — bandingkan vendor dan pilih yang terbaik.
          </p>
          <div class="hero-actions">
            <a href="{{ route('book') }}" class="btn-hero-primary">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 7h13M10 21a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm7 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
              </svg>
              Booking Sekarang
            </a>
            <div class="hero-divider"></div>
            <a href="{{ route('tracking.index') }}" class="btn-hero-ghost">
              <div class="icon-ring">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                  <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
              </div>
              Lacak Paket
            </a>
          </div>
          <div class="hero-trust">
            <div class="trust-avatars">
              <div class="trust-avatar">A</div>
              <div class="trust-avatar">S</div>
              <div class="trust-avatar">B</div>
              <div class="trust-avatar">+</div>
            </div>
            <div class="trust-text">
              <strong>10.000+ pengiriman sukses</strong>
              dipercaya ribuan pelanggan di seluruh Indonesia
            </div>
          </div>
        </div>

        {{-- RIGHT: Calculator Card dengan animasi reveal --}}
        <div class="calc-card reveal reveal-d2">
          <div class="calc-card-head">
            <div>
              <div class="calc-card-title">Shipping Calculator</div>
              <div class="calc-card-sub">Estimasi biaya pengiriman internasional</div>
            </div>
            <div class="calc-live-badge">
              <div class="calc-live-dot"></div>
              Live
            </div>
          </div>

          <form id="calcForm">
            {{-- Rute --}}
            <div class="f-section-divider">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
              </svg>
              Rute Pengiriman
            </div>
            <div class="f-row-2-dark" style="margin-bottom:1.2rem;">
              <div>
                <label class="f-label-dark">Asal Pengiriman</label>
                <div class="f-origin-dark">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                    <circle cx="12" cy="9" r="2.5"/>
                  </svg>
                  Indonesia
                </div>
                <input type="hidden" name="origin" value="Indonesia">
              </div>
              <div>
                <label class="f-label-dark">Negara Tujuan</label>
                <select name="country" id="country" required class="f-input-dark" style="appearance:auto;">
                  <option value="" style="background:#0A1A4A;">-- Pilih Negara --</option>
                  @foreach($countries as $country)
                    <option value="{{ $country->id }}" style="background:#0A1A4A;">{{ $country->country_name }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            {{-- Dimensi & Berat --}}
            <div class="f-section-divider">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
              </svg>
              Dimensi &amp; Berat
            </div>
            <div class="f-row-2-dark" style="margin-bottom:0.75rem;">
            <div>
              <label for="weight" class="f-label-dark">Berat Paket (gram)</label>
              <input type="number" step="1" min="1" name="weight" id="weight" placeholder="cth: 2500" required class="f-input-dark">
              <small style="color: rgba(255,255,255,0.35); font-size: 0.65rem; display: block; margin-top: 4px;">* 1 kg = 1000 gram</small>
            </div>
            <div>
              <label class="f-label-dark">Panjang (cm)</label>
              <input type="number" name="length" placeholder="cth: 30" required class="f-input-dark">
            </div>
            </div>
            <div class="f-row-2-dark">
              <div>
                <label class="f-label-dark">Lebar (cm)</label>
                <input type="number" name="width" placeholder="cth: 20" required class="f-input-dark">
              </div>
              <div>
                <label class="f-label-dark">Tinggi (cm)</label>
                <input type="number" name="height" placeholder="cth: 15" required class="f-input-dark">
              </div>
            </div>

            <button type="submit" class="calc-btn" id="calcBtn" style="margin-top:1.6rem;">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="4" y="2" width="16" height="20" rx="2"/>
                <line x1="8" y1="10" x2="16" y2="10"/>
                <line x1="8" y1="14" x2="12" y2="14"/>
              </svg>
              Hitung Ongkos Kirim
            </button>
          </form>

          <div class="calc-feats">
            <div class="calc-feat">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
              Harga Transparan
            </div>
            <div class="calc-feat">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
              50+ Negara
            </div>
            <div class="calc-feat">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
              Tanpa Registrasi
            </div>
            <div class="calc-feat">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
              Express &amp; Economy
            </div>
          </div>
        </div>
      </div>

      {{-- Stats Strip dengan Counter Animation --}}
      <div class="hero-stats-strip reveal reveal-d3">
        <div class="hero-stat">
          <div class="hero-stat-num">
            <span class="counter" data-target="200">0</span><em>+</em>
          </div>
          <div class="hero-stat-label">Negara Tujuan</div>
        </div>
        <div class="hero-stat">
          <div class="hero-stat-num">
            <span class="counter" data-target="10000">0</span><em>+</em>
          </div>
          <div class="hero-stat-label">Pengiriman Sukses</div>
        </div>
        <div class="hero-stat">
          <div class="hero-stat-num">
            <span class="counter" data-target="2">0</span><em>+</em>
          </div>
          <div class="hero-stat-label">Vendor Partner</div>
        </div>
        <div class="hero-stat">
          <div class="hero-stat-num">
            <span class="counter" data-target="99">0</span><em>%</em>
          </div>
          <div class="hero-stat-label">Kepuasan</div>
        </div>
      </div>
    </div>
  </section>

  {{-- ══ RESULT ══ --}}
  <div id="resultSection" style="display:none;" class="result-section">
    <div class="container">
      <div class="res-wrap" id="result"></div>
    </div>
  </div>

  {{-- ══ HOW IT WORKS ══ --}}
  <section class="section section-soft">
    <div class="container">
      <div class="section-center reveal">
        <span class="section-label">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/>
          </svg>
          Panduan
        </span>
        <h2 class="section-heading">Cara Menggunakan Kalkulator</h2>
        <p class="section-sub">Hanya 4 langkah mudah untuk mendapatkan estimasi biaya pengiriman</p>
      </div>
      <div class="steps-grid">
        <div class="step-item reveal reveal-d1">
          <div class="step-num">1</div>
          <h4>Pilih Negara Tujuan</h4>
          <p>Pilih negara destinasi pengiriman dari 200+ pilihan yang tersedia.</p>
        </div>
        <div class="step-item reveal reveal-d2">
          <div class="step-num">2</div>
          <h4>Isi Berat &amp; Dimensi</h4>
          <p>Masukkan berat aktual dan ukuran panjang, lebar, serta tinggi paket.</p>
        </div>
        <div class="step-item reveal reveal-d3">
          <div class="step-num">3</div>
          <h4>Klik Hitung</h4>
          <p>Sistem otomatis menghitung biaya dari semua vendor yang tersedia.</p>
        </div>
        <div class="step-item reveal reveal-d4">
          <div class="step-num">4</div>
          <h4>Pilih &amp; Booking</h4>
          <p>Bandingkan harga antar vendor dan pilih yang paling sesuai kebutuhan.</p>
        </div>
      </div>
    </div>
  </section>

  {{-- ══ WHY US ══ --}}
  <section class="section section-alt">
    <div class="container">
      <div class="section-center reveal">
        <span class="section-label">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
          </svg>
          Keunggulan
        </span>
        <h2 class="section-heading">Mengapa Memilih Kami</h2>
        <p class="section-sub">Komitmen kami terhadap kualitas, keamanan, dan kepuasan pelanggan tidak pernah goyah</p>
      </div>
      <div class="pillars">
        <div class="pillar reveal reveal-d1">
          <div class="pillar-count">01</div>
          <div class="pillar-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <line x1="12" y1="1" x2="12" y2="23"/>
              <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
            </svg>
          </div>
          <h3>Harga Transparan</h3>
          <p>Tidak ada biaya tersembunyi. Harga yang Anda lihat di kalkulator adalah harga yang Anda bayar.</p>
        </div>
        <div class="pillar reveal reveal-d2">
          <div class="pillar-count">02</div>
          <div class="pillar-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <circle cx="12" cy="12" r="10"/>
              <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
            </svg>
          </div>
          <h3>Jangkauan Global</h3>
          <p>Jaringan pengiriman ke 200+ negara dengan mitra logistik terpercaya di setiap wilayah.</p>
        </div>
        <div class="pillar reveal reveal-d3">
          <div class="pillar-count">03</div>
          <div class="pillar-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
            </svg>
          </div>
          <h3>Pengiriman Cepat</h3>
          <p>Layanan express 3–6 hari kerja atau economy 7–20 hari, sesuai kebutuhan dan anggaran Anda.</p>
        </div>
      </div>
    </div>
  </section>

  {{-- ══ CTA ══ --}}
  <div class="cta-wrap">
    <div class="container">
      <div class="cta-inner reveal">
        <div class="cta-content">
          <div class="cta-chip">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            Mulai Sekarang
          </div>
          <h2 class="cta-title">Siap Kirim ke <span>Seluruh Dunia?</span></h2>
          <p class="cta-desc">Gunakan kalkulator di atas dan booking pengiriman internasional Anda dalam hitungan menit.</p>
          <div class="cta-btns">
            <button onclick="document.getElementById('country').focus(); window.scrollTo({top:0,behavior:'smooth'});" class="cta-btn-primary">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="4" y="2" width="16" height="20" rx="2"/>
                <line x1="8" y1="10" x2="16" y2="10"/>
                <line x1="8" y1="14" x2="12" y2="14"/>
              </svg>
              Hitung Sekarang
            </button>
            <a href="{{ route('customer-service') }}" class="cta-btn-outline">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
              </svg>
              Konsultasi Gratis
            </a>
          </div>
        </div>
        <div class="cta-pills">
          <div class="cta-pill">
            <div class="cta-pill-num">50<em>+</em></div>
            <div class="cta-pill-label">Negara</div>
          </div>
          <div class="cta-pill">
            <div class="cta-pill-num">10K<em>+</em></div>
            <div class="cta-pill-label">Pengiriman</div>
          </div>
          <div class="cta-pill">
            <div class="cta-pill-num">99<em>%</em></div>
            <div class="cta-pill-label">Kepuasan</div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>{{-- /cp --}}

<script>
/* ── Scroll Reveal (sama) ── */
const revealElements = document.querySelectorAll('.reveal');
const revealObserver = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('is-visible');
      revealObserver.unobserve(entry.target);
    }
  });
}, { threshold: 0.12 });
revealElements.forEach(el => revealObserver.observe(el));

/* ── Counter Animation (sama) ── */
const counters = document.querySelectorAll('.counter');
const counterObserver = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (!entry.isIntersecting) return;
    const el = entry.target;
    const target = parseInt(el.dataset.target);
    const duration = 1800;
    const step = target / (duration / 16);
    let current = 0;
    const update = () => {
      current = Math.min(current + step, target);
      el.textContent = Math.floor(current).toLocaleString('id-ID');
      if (current < target) requestAnimationFrame(update);
    };
    requestAnimationFrame(update);
    counterObserver.unobserve(el);
  });
}, { threshold: 0.4 });
counters.forEach(c => counterObserver.observe(c));

/* ── Format harga (titik sebagai pemisah ribuan) ── */
function formatPrice(value) {
  if (!value && value !== 0) return '0';
  let num = value.toString().replace(/[^0-9]/g, '');
  if (num === '') return '0';
  return parseInt(num, 10).toLocaleString('id-ID');
}

/* ── Calculator (dengan konversi gram → kg) ── */
document.addEventListener('DOMContentLoaded', function () {
  const form        = document.getElementById('calcForm');
  const resultDiv   = document.getElementById('result');
  const section     = document.getElementById('resultSection');
  const btn         = document.getElementById('calcBtn');
  if (!form) return;

  const btnDefault = `
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
      <rect x="4" y="2" width="16" height="20" rx="2"/>
      <line x1="8" y1="10" x2="16" y2="10"/>
      <line x1="8" y1="14" x2="12" y2="14"/>
    </svg>
    Hitung Ongkos Kirim
  `;
  const btnLoading = `
    <svg class="spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
      <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
    </svg>
    Menghitung...
  `;

  form.addEventListener('submit', async function (e) {
    e.preventDefault();
    resultDiv.innerHTML = '';
    section.style.display = 'none';

    const country = document.getElementById('country').value;
    const weightGram = parseFloat(document.querySelector('[name="weight"]').value);
    const length = parseFloat(document.querySelector('[name="length"]').value);
    const width  = parseFloat(document.querySelector('[name="width"]').value);
    const height = parseFloat(document.querySelector('[name="height"]').value);

    if (!country) { showError('Silakan pilih negara tujuan terlebih dahulu.'); return; }
    if (isNaN(weightGram) || weightGram <= 0) {
      showError('Harap isi berat paket dengan benar (minimal 1 gram).');
      return;
    }
    if (isNaN(length) || length <= 0 || isNaN(width) || width <= 0 || isNaN(height) || height <= 0) {
      showError('Harap isi dimensi paket dengan benar (cm).');
      return;
    }

    const weightKg = weightGram / 1000;

    btn.innerHTML = btnLoading;
    btn.disabled = true;

    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (!token) {
      showError('CSRF token tidak ditemukan. Silakan refresh halaman.');
      resetBtn();
      return;
    }

    try {
      const response = await fetch('{{ route("calculator.calculate") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
        body: JSON.stringify({ 
          country, 
          weight: weightKg, 
          length, 
          width, 
          height 
        })
      });

      if (!response.ok) {
        let msg = 'HTTP ' + response.status;
        try { const err = await response.json(); msg = err.message || err.error || msg; } catch {}
        throw new Error(msg);
      }

      const data = await response.json();

const vendorCards = data.vendors.map(v => {
    const ok = v.available;
    const weightUsed = (v.weight_used !== undefined) ? v.weight_used : data.final_weight;
    const priceFormatted = ok ? 'Rp ' + formatPrice(v.price) : 'Tidak Tersedia';
    const hasSurcharge = (v.surcharge_info && v.surcharge_info !== 'Tidak ada');
    
    return `
      <div class="vendor-card ${ok ? 'available' : 'unavailable'}" style="border-color: ${ok ? v.color + '33' : 'var(--border)'}">
        <div class="vendor-card-top">
          <div class="vendor-name" style="color: ${ok ? v.color : 'var(--text-muted)'}">${v.name}</div>
          <span class="vendor-badge ${ok ? 'ok' : 'na'}">${ok ? 'Tersedia' : 'Tidak Tersedia'}</span>
        </div>
        <div class="vendor-meta">
          <div class="vendor-meta-row">
            <span>Estimasi Pengiriman</span>
            <span>${v.estimated_delivery || 'Tidak tersedia'}</span>
          </div>
          <div class="vendor-meta-row" style="flex-direction: column; align-items: flex-start; gap: 0.2rem;">
            <div style="display: flex; justify-content: space-between; width: 100%;">
              <span>Biaya Tambahan</span>
              <span ${hasSurcharge ? 'style="color: #e31e24; font-weight:600;"' : ''}>${v.surcharge_info || 'Tidak ada'}</span>
            </div>
            ${hasSurcharge ? '<div style="font-size:0.65rem; color:#e31e24; margin-top:2px;">* Harga belum termasuk biaya tambahan ini</div>' : ''}
          </div>
        </div>
        ${ok
          ? `<div class="vendor-price" style="color: ${v.color}">${priceFormatted}</div>`
          : `<div class="vendor-price-na">Tidak Tersedia</div>`
        }
        ${ok
          ? `<a href="{{ route('book') }}?vendor=${encodeURIComponent(v.name)}&country=${encodeURIComponent(data.country_name)}&weight=${data.actual_weight}&price=${v.price}&length=${data.length}&width=${data.width}&height=${data.height}"
              class="vendor-btn active" style="background: ${v.color}">
              Pilih ${v.name}
            </a>`
          : `<div class="vendor-btn inactive">Tidak Tersedia</div>`
        }
      </div>
    `;
}).join('');


      resultDiv.innerHTML = `
        <div>
          <div class="res-header">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>Hasil Kalkulasi — ${data.vendors.length} Vendor</span>
          </div>
          <div class="res-summary">
            <div class="res-summary-cell">
              <div class="res-cell-lbl">Berat Aktual (kg)</div>
              <div class="res-cell-val">${data.actual_weight.toFixed(2)} kg</div>
            </div>
            <div class="res-summary-cell">
              <div class="res-cell-lbl">Berat Volumetrik (kg)</div>
              <div class="res-cell-val">${data.volumetric_weight.toFixed(2)} kg</div>
            </div>
            <div class="res-summary-cell highlight">
              <div class="res-cell-lbl">Berat Dikenakan</div>
              <div class="res-cell-val">${data.final_weight.toFixed(2)} kg</div>
            </div>
            <div class="res-summary-cell">
              <div class="res-cell-lbl">Negara Tujuan</div>
              <div class="res-cell-val">${data.country_name}</div>
            </div>
          </div>
          <div class="res-vendors-wrap">
            <div class="res-vendors-title">Perbandingan Harga Vendor</div>
            <div class="res-vendors-grid">
              ${vendorCards}
            </div>
          </div>
        </div>
      `;
      section.style.display = 'block';
      section.scrollIntoView({ behavior: 'smooth', block: 'start' });

    } catch (err) {
      console.error('Error:', err);
      showError('Terjadi kesalahan: ' + err.message);
    } finally {
      resetBtn();
    }
  });

  function showError(msg) {
    resultDiv.innerHTML = `
      <div style="background:#fff5f5; border:1.5px solid rgba(227,30,36,0.2); border-radius:14px; padding:1.4rem 1.6rem; color:#dc2626; font-weight:600; font-size:0.9rem; display:flex; align-items:center; gap:0.75rem;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="10"/>
          <line x1="12" y1="8" x2="12" y2="12"/>
          <line x1="12" y1="16" x2="12.01" y2="16" stroke-width="3" stroke-linecap="round"/>
        </svg>
        ${msg}
      </div>
    `;
    section.style.display = 'block';
  }

  function resetBtn() {
    btn.innerHTML = btnDefault;
    btn.disabled = false;
  }
});
</script>
@endsection