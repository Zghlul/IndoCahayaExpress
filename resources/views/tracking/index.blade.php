@extends('layouts.app')
@section('title', 'Lacak Pengiriman - Indo Cahaya Express')
@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300&family=DM+Serif+Display:ital@0;1&display=swap');

/* ══════════════════════════════════════════
   DESIGN TOKENS — ICE Premium Palette
══════════════════════════════════════════ */
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
  --navy-400:     #2550C8;
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
  --sky:          #3BAEE0;
  --green:        #16A34A;
  --glow-navy:    rgba(20,56,160,0.18);
  --glow-red:     rgba(227,30,36,0.20);
  --shadow-xs:    0 1px 4px rgba(9,24,60,0.06);
  --shadow-sm:    0 2px 8px rgba(9,24,60,0.08);
  --shadow-md:    0 8px 24px rgba(9,24,60,0.10);
  --shadow-lg:    0 16px 48px rgba(9,24,60,0.12);
  --shadow-xl:    0 32px 80px rgba(9,24,60,0.14);
  --shadow-card:  0 4px 20px rgba(9,24,60,0.07), 0 1px 4px rgba(9,24,60,0.04);
  --ease-out:     cubic-bezier(0.22, 1, 0.36, 1);
  --ease-spring:  cubic-bezier(0.34, 1.56, 0.64, 1);
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

.trk-page {
  font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
  color: var(--text-primary);
  background: var(--white);
  line-height: 1.6;
  overflow-x: hidden;
}

.trk-page .container {
  max-width: 1440px;
  margin: 0 auto;
  padding: 0 3rem;
  width: 100%;
}
@media (max-width: 1280px) { .trk-page .container { padding: 0 2.5rem; } }
@media (max-width: 768px)  { .trk-page .container { padding: 0 1.5rem; } }

/* ══════════════════════════════════════════
   HERO
══════════════════════════════════════════ */
.hero {
  position: relative;
  min-height: 90vh;
  display: flex;
  align-items: center;
  overflow: hidden;
  background: var(--navy-900);
}

.hero-canvas {
  position: absolute;
  inset: 0;
  z-index: 0;
  background:
    radial-gradient(ellipse 100% 80% at 100% 0%,   rgba(20,56,160,0.55) 0%, transparent 55%),
    radial-gradient(ellipse 70%  60% at 0%   100%, rgba(227,30,36,0.10) 0%, transparent 50%),
    radial-gradient(ellipse 60%  70% at 55%  50%,  rgba(11,26,74,0.9)   0%, transparent 70%),
    linear-gradient(168deg, #060F2E 0%, #0B1C55 45%, #091640 100%);
}

.hero-canvas::after {
  content: '';
  position: absolute;
  inset: 0;
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.035'/%3E%3C/svg%3E");
  pointer-events: none;
  mix-blend-mode: overlay;
  opacity: 0.5;
}

.hero-grid {
  position: absolute;
  inset: 0;
  z-index: 0;
  background-image: radial-gradient(circle, rgba(255,255,255,0.055) 1px, transparent 1px);
  background-size: 44px 44px;
  mask-image: radial-gradient(ellipse 90% 80% at 50% 50%, black 40%, transparent 80%);
}

.hero-lines {
  position: absolute;
  inset: 0;
  z-index: 0;
  overflow: hidden;
}
.hero-lines::before,
.hero-lines::after {
  content: '';
  position: absolute;
  top: 0; bottom: 0;
  width: 1px;
}
.hero-lines::before {
  right: 34%;
  background: linear-gradient(to bottom,
    transparent 0%,
    rgba(227,30,36,0.35) 25%,
    rgba(227,30,36,0.15) 70%,
    transparent 100%);
}
.hero-lines::after {
  left: 52%;
  background: linear-gradient(to bottom,
    transparent 10%,
    rgba(59,174,224,0.12) 40%,
    rgba(59,174,224,0.06) 75%,
    transparent 100%);
}

.hero-glow {
  position: absolute;
  z-index: 0;
  border-radius: 50%;
  filter: blur(80px);
  pointer-events: none;
}
.hero-glow-1 {
  width: 700px; height: 700px;
  top: -200px; right: -100px;
  background: radial-gradient(circle, rgba(20,56,160,0.4) 0%, transparent 65%);
}
.hero-glow-2 {
  width: 500px; height: 500px;
  bottom: -100px; left: 0;
  background: radial-gradient(circle, rgba(227,30,36,0.1) 0%, transparent 65%);
}

.hero .container {
  position: relative;
  z-index: 2;
}

.hero-inner {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  padding: 1rem 0 6rem;
}

.hero-badge {
  display: inline-flex;
  align-items: center;
  gap: 0.6rem;
  margin-bottom: 2.2rem;
  padding: 0.5rem 1rem 0.5rem 0.55rem;
  border-radius: 99px;
  border: 1px solid rgba(227,30,36,0.3);
  background: rgba(227,30,36,0.07);
  backdrop-filter: blur(10px);
}
.hero-badge-dot {
  width: 26px; height: 26px;
  border-radius: 50%;
  background: linear-gradient(135deg, var(--red), var(--red-deep));
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
  box-shadow: 0 4px 12px rgba(227,30,36,0.4);
}
.hero-badge-dot svg { width: 13px; height: 13px; color: #fff; }
.hero-badge span {
  font-size: 0.7rem; font-weight: 800;
  letter-spacing: 0.12em; text-transform: uppercase;
  color: rgba(255,255,255,0.75);
  padding-right: 0.3rem;
}

.hero-heading {
  font-size: clamp(3rem, 5vw, 5rem);
  font-weight: 900;
  line-height: 1.0;
  letter-spacing: -0.04em;
  color: #fff;
  margin-bottom: 1.8rem;
}
.hero-heading .word-plain { display: block; }
.hero-heading .word-serif {
  display: block;
  font-family: 'DM Serif Display', serif;
  font-style: italic;
  font-weight: 400;
  color: var(--red);
  font-size: 1.06em;
  letter-spacing: -0.025em;
  line-height: 1.08;
  margin: 0.06em 0;
  text-shadow:
    0 0 40px rgba(227,30,36,0.85),
    0 0 80px rgba(227,30,36,0.55),
    0 0 130px rgba(227,30,36,0.28),
    0 0 220px rgba(227,30,36,0.12);
}
.hero-heading .word-dim {
  display: block;
  color: rgba(255,255,255,0.38);
  font-size: 0.56em;
  font-weight: 500;
  letter-spacing: -0.01em;
  font-family: 'Plus Jakarta Sans', sans-serif;
  margin-top: 0.2em;
  line-height: 1.3;
}

.hero-desc {
  font-size: 1.05rem;
  color: rgba(255,255,255,0.55);
  max-width: 560px;
  line-height: 1.8;
  margin-bottom: 2.2rem;
  font-weight: 400;
}

.hero-pills {
  display: flex;
  gap: 0.75rem;
  flex-wrap: wrap;
  justify-content: center;
  margin-bottom: 3rem;
}
.hero-pill {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  background: rgba(255,255,255,0.06);
  border: 1px solid rgba(255,255,255,0.12);
  border-radius: 99px;
  padding: 0.45rem 1rem;
  font-size: 0.8rem;
  font-weight: 600;
  color: rgba(255,255,255,0.75);
  backdrop-filter: blur(8px);
}
.hero-pill svg { width: 13px; height: 13px; color: #4ade80; flex-shrink: 0; }

/* ── Search card (floating inside hero) ── */
.search-card {
  background: rgba(255,255,255,0.06);
  border: 1px solid rgba(255,255,255,0.13);
  border-radius: 24px;
  padding: 2.2rem 2.8rem;
  max-width: 720px;
  width: 100%;
  backdrop-filter: blur(20px);
  box-shadow: 0 24px 64px rgba(0,0,0,0.28), inset 0 1px 0 rgba(255,255,255,0.08);
  position: relative;
}
.search-card::before {
  content: '';
  position: absolute;
  top: -1px; left: 15%; right: 15%;
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
}

.search-label {
  font-size: 0.67rem;
  font-weight: 800;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  color: rgba(255,255,255,0.45);
  margin-bottom: 1rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}
.search-label svg { width: 12px; height: 12px; }

.search-form { display: flex; gap: 0.875rem; }

.search-input-wrap {
  position: relative;
  flex: 1;
}
.search-input-wrap svg {
  position: absolute;
  left: 1.1rem;
  top: 50%;
  transform: translateY(-50%);
  color: var(--text-muted);
  pointer-events: none;
  width: 17px; height: 17px;
}
.search-input-wrap input {
  width: 100%;
  padding: 1rem 1.25rem 1rem 3rem;
  border-radius: 12px;
  border: 1.5px solid var(--border);
  background: var(--white);
  font-size: 0.9375rem;
  font-weight: 500;
  color: var(--text-primary);
  font-family: 'Plus Jakarta Sans', sans-serif;
  outline: none;
  box-shadow: 0 4px 16px rgba(0,0,0,0.14);
  transition: all 0.2s var(--ease-out);
}
.search-input-wrap input:focus {
  border-color: var(--red);
  box-shadow: 0 0 0 3px rgba(227,30,36,0.1), 0 4px 16px rgba(0,0,0,0.14);
}
.search-input-wrap input::placeholder { color: var(--text-muted); }

.search-btn {
  padding: 1rem 2rem;
  border-radius: 12px;
  border: none;
  background: var(--red);
  color: #fff;
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 0.9375rem;
  font-weight: 800;
  cursor: pointer;
  white-space: nowrap;
  box-shadow: 0 8px 28px rgba(227,30,36,0.45);
  transition: all 0.22s var(--ease-out);
  display: flex; align-items: center; gap: 0.6rem;
  flex-shrink: 0;
  letter-spacing: 0.01em;
}
.search-btn svg { width: 16px; height: 16px; }
.search-btn:hover {
  background: var(--red-hover);
  transform: translateY(-2px);
  box-shadow: 0 14px 36px rgba(227,30,36,0.55);
}
.search-btn:active { transform: translateY(0); }

/* Hero stats strip */
.hero-stats-strip {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  border-top: 1px solid rgba(255,255,255,0.06);
  margin-top: 4rem;
  padding: 2.5rem 0;
  max-width: 720px;
  width: 100%;
}
.hero-stat { padding: 0 2rem; position: relative; text-align: center; }
.hero-stat + .hero-stat::before {
  content: '';
  position: absolute;
  left: 0; top: 15%; height: 70%;
  width: 1px;
  background: rgba(255,255,255,0.07);
}
.hero-stat-num {
  font-size: 2rem; font-weight: 900;
  color: #fff; line-height: 1;
  letter-spacing: -0.04em;
  font-variant-numeric: tabular-nums;
  margin-bottom: 0.3rem;
}
.hero-stat-num em { font-style: normal; color: var(--red); }
.hero-stat-label {
  font-size: 0.7rem; font-weight: 700;
  text-transform: uppercase; letter-spacing: 0.09em;
  color: rgba(255,255,255,0.32);
}

/* ══════════════════════════════════════════
   SECTION BASE
══════════════════════════════════════════ */
.section      { padding: 7rem 0; }
.section-soft { background: var(--surface); }
.section-alt  { background: var(--surface-2); }

.section-label {
  display: inline-flex; align-items: center; gap: 0.45rem;
  background: rgba(227,30,36,0.07);
  border: 1px solid rgba(227,30,36,0.14);
  color: var(--red);
  border-radius: 99px;
  padding: 0.35rem 0.9rem;
  font-size: 0.67rem; font-weight: 800;
  letter-spacing: 0.1em; text-transform: uppercase;
  margin-bottom: 1.1rem;
}
.section-label svg { width: 10px; height: 10px; }
.section-heading {
  font-size: clamp(2rem, 3vw, 2.9rem);
  font-weight: 900;
  color: var(--text-primary);
  letter-spacing: -0.035em;
  line-height: 1.1;
  margin-bottom: 0.8rem;
}
.section-sub {
  font-size: 1rem;
  color: var(--text-2);
  max-width: 540px;
  line-height: 1.75;
  font-weight: 400;
}
.section-center {
  text-align: center;
  margin-bottom: 4rem;
}
.section-center .section-sub { margin: 0 auto; }

/* ══════════════════════════════════════════
   RESULT CARD
══════════════════════════════════════════ */
.result-wrap { max-width: 960px; margin: 0 auto 3rem; }
.result-card {
  background: var(--white);
  border-radius: 24px;
  box-shadow: var(--shadow-xl);
  border: 1px solid var(--border);
  overflow: hidden;
  transition: transform 0.35s var(--ease-out), box-shadow 0.35s var(--ease-out);
}
.result-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 40px 100px rgba(9,24,60,0.16);
}

.result-card-header {
  background: linear-gradient(155deg, var(--navy-800) 0%, var(--navy-700) 100%);
  padding: 2rem 2.8rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 1rem;
  position: relative;
  overflow: hidden;
}
.result-card-header::before {
  content: '';
  position: absolute;
  top: -1px; left: 10%; right: 10%;
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.22), transparent);
}
.result-card-header::after {
  content: '';
  position: absolute;
  inset: 0;
  background-image: radial-gradient(circle, rgba(255,255,255,0.04) 1px, transparent 1px);
  background-size: 28px 28px;
  pointer-events: none;
}

.result-title {
  display: flex;
  align-items: center;
  gap: 0.875rem;
  font-size: 1.15rem;
  font-weight: 800;
  color: #fff;
  position: relative; z-index: 1;
  letter-spacing: -0.02em;
}
.result-title svg { width: 22px; height: 22px; flex-shrink: 0; }

/* Status badges */
.status-badge {
  padding: 0.45rem 1.1rem;
  border-radius: 99px;
  font-size: 0.72rem; font-weight: 800;
  display: inline-flex; align-items: center; gap: 0.45rem;
  letter-spacing: 0.06em; text-transform: uppercase;
  position: relative; z-index: 1;
}
.status-badge::before {
  content: '';
  width: 6px; height: 6px;
  border-radius: 50%;
  background: currentColor;
  flex-shrink: 0;
  animation: pulse-dot 2s ease-in-out infinite;
}
@keyframes pulse-dot {
  0%, 100% { opacity: 1; transform: scale(1); }
  50% { opacity: 0.5; transform: scale(0.7); }
}
.status-shipped    { background: rgba(255,255,255,0.12); color: #fff; border: 1px solid rgba(255,255,255,0.22); }
.status-processing { background: rgba(251,191,36,0.18); color: #fde68a; border: 1px solid rgba(251,191,36,0.3); }
.status-pending    { background: rgba(255,255,255,0.08); color: rgba(255,255,255,0.85); border: 1px solid rgba(255,255,255,0.18); }
.status-done       { background: rgba(22,163,74,0.18); color: #6ee7b7; border: 1px solid rgba(22,163,74,0.3); }
.status-cancelled  { background: rgba(220,38,38,0.18); color: #fca5a5; border: 1px solid rgba(220,38,38,0.3); }
.status-default    { background: rgba(255,255,255,0.08); color: rgba(255,255,255,0.85); border: 1px solid rgba(255,255,255,0.18); }

.result-body { padding: 2.8rem; }
.result-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 2rem;
}
.result-item { display: flex; flex-direction: column; gap: 0.5rem; }
.result-item-label {
  font-size: 0.63rem; font-weight: 800;
  color: var(--text-muted);
  text-transform: uppercase; letter-spacing: 0.1em;
}
.result-item-value {
  font-size: 0.975rem; font-weight: 700;
  color: var(--text-primary); line-height: 1.4;
}
.tracking-chip {
  display: inline-block;
  font-family: 'SF Mono', 'Monaco', 'Inconsolata', 'Roboto Mono', monospace;
  background: var(--surface-3);
  color: var(--navy-700);
  padding: 0.4rem 0.95rem;
  border-radius: 10px;
  font-size: 0.875rem;
  font-weight: 700;
  border: 1px solid var(--border-2);
  letter-spacing: 0.03em;
}

/* ══ Status Progress Bar ══ */
.status-progress {
  margin-top: 2.4rem;
  padding-top: 2.4rem;
  border-top: 1px solid var(--border);
}
.status-progress-label {
  font-size: 0.67rem; font-weight: 800;
  color: var(--text-muted);
  text-transform: uppercase; letter-spacing: 0.1em;
  margin-bottom: 1.5rem;
}
.progress-steps {
  display: flex;
  align-items: center;
  gap: 0;
}
.progress-step {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.6rem;
  flex: 1;
  position: relative;
}
.progress-step:not(:last-child)::after {
  content: '';
  position: absolute;
  top: 18px;
  left: 50%;
  width: 100%;
  height: 2px;
  background: var(--border);
  z-index: 0;
}
.progress-step.done:not(:last-child)::after { background: var(--green); }
.progress-step.active:not(:last-child)::after { background: var(--border); }

.step-dot {
  width: 36px; height: 36px;
  border-radius: 50%;
  border: 2px solid var(--border);
  background: var(--white);
  display: flex; align-items: center; justify-content: center;
  position: relative; z-index: 1;
  transition: all 0.3s var(--ease-out);
}
.step-dot svg { width: 15px; height: 15px; color: var(--text-muted); }
.progress-step.done .step-dot {
  border-color: var(--green);
  background: var(--green);
}
.progress-step.done .step-dot svg { color: #fff; }
.progress-step.active .step-dot {
  border-color: var(--red);
  background: var(--red);
  box-shadow: 0 0 0 4px rgba(227,30,36,0.15);
}
.progress-step.active .step-dot svg { color: #fff; }
.step-label {
  font-size: 0.68rem; font-weight: 700;
  color: var(--text-muted);
  text-align: center;
  letter-spacing: 0.01em;
  line-height: 1.3;
}
.progress-step.done  .step-label  { color: var(--green); }
.progress-step.active .step-label { color: var(--red); font-weight: 800; }

/* Not Found */
.not-found {
  text-align: center;
  padding: 4.5rem 2rem;
}
.not-found-icon {
  width: 88px; height: 88px;
  border-radius: 50%;
  background: #fff5f5;
  border: 2px solid rgba(227,30,36,0.18);
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 1.7rem;
}
.not-found-icon svg { width: 38px; height: 38px; color: var(--red); }
.not-found h3 {
  font-size: 1.3rem; font-weight: 800;
  color: var(--text-primary);
  margin-bottom: 0.7rem;
  letter-spacing: -0.025em;
}
.not-found p {
  font-size: 0.95rem;
  color: var(--text-2);
  line-height: 1.75;
}

/* ══════════════════════════════════════════
   FAQ ACCORDION
══════════════════════════════════════════ */
.faq-wrap {
  max-width: 960px;
  margin: 0 auto;
  background: var(--white);
  border-radius: 24px;
  border: 1px solid var(--border);
  overflow: hidden;
  box-shadow: var(--shadow-md);
}
.faq-card-title {
  display: flex; align-items: center; gap: 0.8rem;
  padding: 2rem 2.4rem 1.8rem;
  font-size: 1.05rem; font-weight: 800;
  color: var(--text-primary);
  border-bottom: 1px solid var(--border);
  letter-spacing: -0.02em;
}
.faq-card-title svg { width: 18px; height: 18px; color: var(--red); flex-shrink: 0; }
.accordion-item { border-bottom: 1px solid var(--border); }
.accordion-item:last-child { border-bottom: none; }
.accordion-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1.4rem 2.4rem;
  cursor: pointer;
  font-size: 0.9375rem; font-weight: 600;
  color: var(--text-primary);
  transition: background 0.15s;
  user-select: none;
  gap: 1rem;
}
.accordion-header:hover { background: rgba(227,30,36,0.025); }
.accordion-header .acc-icon {
  width: 18px; height: 18px;
  flex-shrink: 0;
  color: var(--text-muted);
  transition: transform 0.25s var(--ease-out);
}
.accordion-item.active .accordion-header {
  color: var(--text-primary);
  background: rgba(227,30,36,0.03);
  font-weight: 700;
}
.accordion-item.active .accordion-header .acc-icon {
  transform: rotate(180deg);
  color: var(--red);
}
.accordion-body {
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.35s var(--ease-out), padding 0.3s ease;
  font-size: 0.9375rem;
  color: var(--text-2);
  line-height: 1.8;
  padding: 0 2.4rem;
}
.accordion-item.active .accordion-body {
  max-height: 250px;
  padding: 0 2.4rem 1.6rem;
}

/* ══════════════════════════════════════════
   TIPS SECTION
══════════════════════════════════════════ */
.tips-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1.75rem;
  max-width: 960px;
  margin: 0 auto;
}
.tip-card {
  background: var(--white);
  border-radius: 22px;
  padding: 2.4rem 2.2rem;
  border: 1px solid var(--border);
  transition: all 0.35s var(--ease-out);
  position: relative; overflow: hidden;
}
.tip-card:hover {
  border-color: transparent;
  box-shadow: var(--shadow-lg);
  transform: translateY(-5px);
}
.tip-card::after {
  content: '';
  position: absolute;
  bottom: -30px; right: -30px;
  width: 120px; height: 120px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(227,30,36,0.05) 0%, transparent 65%);
  pointer-events: none;
}
.tip-icon {
  width: 52px; height: 52px;
  border-radius: 14px;
  background: rgba(227,30,36,0.08);
  color: var(--red);
  display: flex; align-items: center; justify-content: center;
  margin-bottom: 1.6rem;
  transition: all 0.3s var(--ease-out);
}
.tip-card:hover .tip-icon {
  background: var(--red);
  color: #fff;
  transform: scale(1.06);
  box-shadow: 0 8px 24px rgba(227,30,36,0.3);
}
.tip-icon svg { width: 22px; height: 22px; }
.tip-card h4 {
  font-size: 1rem; font-weight: 800;
  color: var(--text-primary);
  letter-spacing: -0.02em;
  margin-bottom: 0.5rem;
}
.tip-card p { font-size: 0.875rem; color: var(--text-2); line-height: 1.7; }

/* ══════════════════════════════════════════
   RESPONSIVE
══════════════════════════════════════════ */
@media (max-width: 860px) {
  .hero-inner { padding: 5rem 0 4rem; }
  .hero-stats-strip { grid-template-columns: repeat(3, 1fr); }
  .search-form { flex-direction: column; }
  .search-card { padding: 1.75rem 1.5rem; }
  .result-grid { grid-template-columns: repeat(2, 1fr); }
  .result-body { padding: 2rem 1.5rem; }
  .result-card-header { padding: 1.5rem 1.75rem; }
  .faq-card-title, .accordion-header { padding-left: 1.5rem; padding-right: 1.5rem; }
  .accordion-body { padding: 0 1.5rem; }
  .accordion-item.active .accordion-body { padding: 0 1.5rem 1.4rem; }
  .tips-grid { grid-template-columns: 1fr; }
  .progress-steps { flex-direction: column; align-items: flex-start; gap: 1rem; }
  .progress-step { flex-direction: row; gap: 1rem; flex: none; width: 100%; }
  .progress-step:not(:last-child)::after { display: none; }
  .step-label { text-align: left; }
}
@media (max-width: 600px) {
  .trk-page .container { padding: 0 1.25rem; }
  .result-grid { grid-template-columns: 1fr; }
  .section { padding: 5rem 0; }
  .hero-stats-strip { grid-template-columns: 1fr 1fr 1fr; }
}
@media (max-width: 480px) {
  .hero-stats-strip { grid-template-columns: 1fr; }
  .hero-stat + .hero-stat::before { display: none; }
}
</style>

<div class="trk-page">

  {{-- ══ HERO ══ --}}
  <section class="hero">
    <div class="hero-canvas"></div>
    <div class="hero-grid"></div>
    <div class="hero-lines"></div>
    <div class="hero-glow hero-glow-1"></div>
    <div class="hero-glow hero-glow-2"></div>
    <div class="container">
      <div class="hero-inner">

        <div class="hero-badge reveal">
          <div class="hero-badge-dot">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <circle cx="11" cy="11" r="8"/>
              <path d="m21 21-4.35-4.35"/>
            </svg>
          </div>
          <span>Lacak Pengiriman</span>
        </div>

        <h1 class="hero-heading reveal reveal-d1">
          <span class="word-plain">Pantau Status</span>
          <span class="word-serif">Paket Anda</span>
          <span class="word-dim">Real-time, Akurat &amp; Terpercaya</span>
        </h1>

        <p class="hero-desc reveal reveal-d2">
          Masukkan nomor resi Anda untuk melihat status pengiriman secara real-time, kapan saja dan di mana saja.
        </p>

        <div class="hero-pills reveal reveal-d3">
          <span class="hero-pill">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Update Real-time
          </span>
          <span class="hero-pill">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Akurat &amp; Terpercaya
          </span>
          <span class="hero-pill">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Semua Layanan ICE
          </span>
        </div>

        {{-- Search Card --}}
        <div class="search-card reveal reveal-d4">
          <div class="search-label">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="11" cy="11" r="8"/>
              <path d="m21 21-4.35-4.35"/>
            </svg>
            Nomor Resi / Tracking Number
          </div>
          <form method="POST" action="{{ route('tracking.track') }}" class="search-form">
            @csrf
            <div class="search-input-wrap">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/>
                <path d="m21 21-4.35-4.35"/>
              </svg>
              <input
                type="text"
                name="tracking_number"
                value="{{ old('tracking_number', $trackingNumber ?? '') }}"
                placeholder="Masukkan nomor resi Anda..."
                autocomplete="off"
              >
            </div>
            <button type="submit" class="search-btn">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/>
                <path d="m21 21-4.35-4.35"/>
              </svg>
              Lacak
            </button>
          </form>
        </div>

      </div>
    </div>
  </section>

  {{-- ══ RESULT & FAQ ══ --}}
  <section class="section section-soft" style="padding-top: 5rem;">
    <div class="container">

      {{-- Hasil Tracking --}}
      @if(isset($trackingNumber) && !empty($trackingNumber))
      <div class="result-wrap reveal">
        <div class="result-card">
          @php
            if (isset($shipment) && $shipment && !isset($shipment->status_pengerjaan)) {
              $shipment->status_pengerjaan = 'pending';
            }
          @endphp

          @if(isset($shipment) && $shipment)
            @php
              $st = strtolower($shipment->status_pengerjaan ?? 'pending');
              $badgeCls = match(true) {
                $st === 'shipped'                     => 'status-shipped',
                $st === 'done'                        => 'status-done',
                $st === 'pending'                     => 'status-pending',
                in_array($st, ['cancel','cancelled']) => 'status-cancelled',
                $st === 'processing'                  => 'status-processing',
                default                               => 'status-default',
              };
              $statusLabel = ucfirst($shipment->status_pengerjaan ?? 'Pending');
              $steps = [
                ['key' => 'pending',    'label' => 'Menunggu',   'icon' => '<path d="M12 8v4l3 3"/><circle cx="12" cy="12" r="10"/>'],
                ['key' => 'processing', 'label' => 'Diproses',   'icon' => '<path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>'],
                ['key' => 'shipped',    'label' => 'Dikirim',    'icon' => '<rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 5v3h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/>'],
                ['key' => 'done',       'label' => 'Terkirim',   'icon' => '<polyline points="20 6 9 17 4 12"/>'],
              ];
              $stepOrder  = ['pending' => 0, 'processing' => 1, 'shipped' => 2, 'done' => 3];
              $currentIdx = $stepOrder[$st] ?? 0;
            @endphp

            <div class="result-card-header">
              <div class="result-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <rect x="1" y="3" width="15" height="13" rx="1"/>
                  <path d="M16 8h4l3 5v3h-7V8z"/>
                  <circle cx="5.5" cy="18.5" r="2.5"/>
                  <circle cx="18.5" cy="18.5" r="2.5"/>
                </svg>
                Paket Ditemukan
              </div>
              <span class="status-badge {{ $badgeCls }}">{{ $statusLabel }}</span>
            </div>

            <div class="result-body">
              <div class="result-grid">
                <div class="result-item">
                  <span class="result-item-label">Nomor Resi</span>
                  <span class="tracking-chip">{{ $shipment->tracking_number }}</span>
                </div>
                <div class="result-item">
                  <span class="result-item-label">Negara Tujuan</span>
                  <span class="result-item-value">{{ $shipment->country_name ?? $shipment->negara }}</span>
                </div>
                <div class="result-item">
                  <span class="result-item-label">Layanan</span>
                  <span class="result-item-value">{{ strtoupper($shipment->service ?? '-') }}</span>
                </div>
                <div class="result-item">
                  <span class="result-item-label">Berat Dikenakan</span>
                  <span class="result-item-value">{{ number_format($shipment->berat_dibebankan ?? 0, 2) }} kg</span>
                </div>
                <div class="result-item">
                  <span class="result-item-label">Biaya (IDR)</span>
                  <span class="result-item-value">Rp {{ number_format($shipment->charge_idr ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="result-item">
                  <span class="result-item-label">Status</span>
                  <span class="result-item-value">{{ $statusLabel }}</span>
                </div>
              </div>

              {{-- Progress steps (hidden for cancelled) --}}
              @if($st !== 'cancel' && $st !== 'cancelled')
              <div class="status-progress">
                <div class="status-progress-label">Progres Pengiriman</div>
                <div class="progress-steps">
                  @foreach($steps as $i => $step)
                    @php
                      $isDone   = $i < $currentIdx;
                      $isActive = $i === $currentIdx;
                      $stepCls  = $isDone ? 'done' : ($isActive ? 'active' : '');
                    @endphp
                    <div class="progress-step {{ $stepCls }}">
                      <div class="step-dot">
                        @if($isDone)
                          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polyline points="20 6 9 17 4 12"/>
                          </svg>
                        @else
                          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">{!! $step['icon'] !!}</svg>
                        @endif
                      </div>
                      <span class="step-label">{{ $step['label'] }}</span>
                    </div>
                  @endforeach
                </div>
              </div>
              @endif
            </div>

          @else

            <div class="result-card-header">
              <div class="result-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <circle cx="11" cy="11" r="8"/>
                  <path d="m21 21-4.35-4.35"/>
                </svg>
                Hasil Pencarian
              </div>
            </div>
            <div class="not-found">
              <div class="not-found-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                  <circle cx="11" cy="11" r="8"/>
                  <path d="m21 21-4.35-4.35"/>
                  <path d="M8 11h6M11 8v6" stroke-width="2"/>
                </svg>
              </div>
              <h3>Nomor Resi Tidak Ditemukan</h3>
              <p>
                Tidak ada pengiriman yang cocok dengan <strong>{{ $trackingNumber }}</strong>.<br>
                Periksa kembali nomor resi Anda dan coba lagi.
              </p>
            </div>

          @endif
        </div>
      </div>
      @endif

      {{-- Tips Cards --}}
      <div class="section-center reveal" @if(isset($trackingNumber) && !empty($trackingNumber)) style="margin-top: 1rem;" @endif>
        <span class="section-label">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
          </svg>
          Tips Tracking
        </span>
        <h2 class="section-heading">Cara Melacak Paket Anda</h2>
        <p class="section-sub">Ikuti langkah mudah ini untuk mendapatkan informasi pengiriman yang akurat</p>
      </div>

      <div class="tips-grid reveal reveal-d1">
        <div class="tip-card">
          <div class="tip-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <rect x="4" y="2" width="16" height="20" rx="2"/>
              <line x1="8" y1="6" x2="16" y2="6"/>
              <line x1="8" y1="10" x2="16" y2="10"/>
              <line x1="8" y1="14" x2="12" y2="14"/>
            </svg>
          </div>
          <h4>Temukan Nomor Resi</h4>
          <p>Cek email konfirmasi atau hubungi pengirim untuk mendapatkan nomor resi pengiriman Anda.</p>
        </div>
        <div class="tip-card">
          <div class="tip-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <circle cx="11" cy="11" r="8"/>
              <path d="m21 21-4.35-4.35"/>
            </svg>
          </div>
          <h4>Masukkan Nomor Resi</h4>
          <p>Ketik nomor resi di kotak pencarian di atas dengan tepat tanpa spasi atau simbol tambahan.</p>
        </div>
        <div class="tip-card">
          <div class="tip-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
            </svg>
          </div>
          <h4>Pantau Status Real-time</h4>
          <p>Status paket Anda diperbarui secara otomatis. Refresh halaman untuk mendapatkan update terbaru.</p>
        </div>
      </div>

    </div>
  </section>

  {{-- ══ FAQ ══ --}}
  <section class="section section-alt">
    <div class="container">

      <div class="section-center reveal">
        <span class="section-label">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <circle cx="12" cy="12" r="10"/>
            <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
            <line x1="12" y1="17" x2="12.01" y2="17" stroke-width="3" stroke-linecap="round"/>
          </svg>
          FAQ
        </span>
        <h2 class="section-heading">Pertanyaan yang Sering Ditanyakan</h2>
        <p class="section-sub">Temukan jawaban atas pertanyaan umum seputar pelacakan pengiriman</p>
      </div>

      <div class="faq-wrap reveal reveal-d1">
        <div class="faq-card-title">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
            <line x1="12" y1="17" x2="12.01" y2="17" stroke-width="3" stroke-linecap="round"/>
          </svg>
          Frequently Asked Questions
        </div>

        @php
          $faqs = [
            [
              'q' => 'Apa itu Nomor Resi dan Di Mana Saya Bisa Menemukannya?',
              'a' => 'Nomor resi adalah kombinasi unik huruf dan angka yang digunakan untuk mengidentifikasi paket Anda. Biasanya pengirim, toko online, atau email konfirmasi akan memberikan nomor resi tersebut.',
            ],
            [
              'q' => 'Kapan Informasi Tracking Akan Muncul?',
              'a' => 'Update tracking biasanya muncul dalam 24 hingga 48 jam setelah paket Anda diproses dan dimasukkan ke dalam sistem kami.',
            ],
            [
              'q' => 'Mengapa Nomor Resi Saya Tidak Berfungsi?',
              'a' => 'Pastikan Anda memasukkan nomor resi dengan benar tanpa spasi atau simbol tambahan. Jika masih tidak berfungsi, hubungi pengirim atau toko tempat Anda memesan.',
            ],
            [
              'q' => 'Apakah Saya Bisa Melacak Tanpa Nomor Resi?',
              'a' => 'Jika Anda tidak memiliki nomor resi, silakan hubungi pengirim. Dalam beberapa kasus, referensi pengiriman alternatif dapat digunakan untuk menemukan paket Anda.',
            ],
          ];
        @endphp

        @foreach($faqs as $i => $faq)
        <div class="accordion-item {{ $i === 0 ? 'active' : '' }}">
          <div class="accordion-header">
            {{ $faq['q'] }}
            <svg class="acc-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <path d="m6 9 6 6 6-6"/>
            </svg>
          </div>
          <div class="accordion-body">{{ $faq['a'] }}</div>
        </div>
        @endforeach
      </div>

    </div>
  </section>

</div>{{-- /trk-page --}}

<script>
if ('scrollRestoration' in history) {
  history.scrollRestoration = 'manual';
}

/* ── Scroll Reveal (sama seperti home) ── */
document.addEventListener('DOMContentLoaded', () => {
  const els = document.querySelectorAll('.reveal, .reveal-left, .reveal-right');
  if (!els.length) return;
  const io = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        e.target.classList.add('is-visible');
        io.unobserve(e.target);
      }
    });
  }, { threshold: 0.12 });
  els.forEach(el => io.observe(el));
});

/* ── Accordion ── */
document.querySelectorAll('.accordion-header').forEach(header => {
  header.addEventListener('click', () => {
    const item     = header.closest('.accordion-item');
    const isActive = item.classList.contains('active');
    document.querySelectorAll('.accordion-item').forEach(i => i.classList.remove('active'));
    if (!isActive) item.classList.add('active');
  });
});

/* ── Auto scroll ke hasil jika ada ── */
document.addEventListener('DOMContentLoaded', () => {
  const resultEl = document.querySelector('.result-wrap');
  if (resultEl) {
    setTimeout(() => resultEl.scrollIntoView({ behavior: 'smooth', block: 'start' }), 300);
  }
});
</script>
@endsection
