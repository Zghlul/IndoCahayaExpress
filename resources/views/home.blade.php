@extends('layouts.app')
@section('content')
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
  --glow-navy:     rgba(20,56,160,0.18);
  --glow-red:      rgba(227,30,36,0.20);
  --shadow-xs:     0 1px 4px rgba(9,24,60,0.06);
  --shadow-sm:     0 2px 8px rgba(9,24,60,0.08);
  --shadow-md:     0 8px 24px rgba(9,24,60,0.10);
  --shadow-lg:     0 16px 48px rgba(9,24,60,0.12);
  --shadow-xl:     0 32px 80px rgba(9,24,60,0.14);
  --shadow-card:   0 4px 20px rgba(9,24,60,0.07), 0 1px 4px rgba(9,24,60,0.04);
  --ease-out:      cubic-bezier(0.22, 1, 0.36, 1);
  --ease-spring:   cubic-bezier(0.34, 1.56, 0.64, 1);
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

.hp {
  font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
  color: var(--text-primary);
  background: var(--white);
  line-height: 1.6;
  overflow-x: hidden;
}

.hp .container {
  max-width: 1440px;
  margin: 0 auto;
  padding: 0 3rem;
  width: 100%;
}
@media (max-width: 1280px) { .hp .container { padding: 0 2.5rem; } }
@media (max-width: 768px)  { .hp .container { padding: 0 1.5rem; } }

/* ══════════════════════════════════════════
   HERO
══════════════════════════════════════════ */
.hero {
  position: relative;
  min-height: 100vh;
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
    transparent 100%
  );
}
.hero-lines::after {
  left: 52%;
  background: linear-gradient(to bottom,
    transparent 10%,
    rgba(59,174,224,0.12) 40%,
    rgba(59,174,224,0.06) 75%,
    transparent 100%
  );
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
  display: flex;
  flex-direction: column;
}

/* ── HERO INNER — KEY CHANGE: more padding, wider text col ── */
.hero-inner {
  display: grid;
  grid-template-columns: 1.15fr 460px;
  gap: 4rem;
  align-items: center;
  padding: 1rem 0 3rem;
}

.hero-text { max-width: 720px; }

.hero-badge {
  display: inline-flex;
  align-items: center;
  gap: 0.6rem;
  margin-bottom: 2.4rem;
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

/* ── HERO HEADING — KEY CHANGE: much larger ── */
.hero-heading {
  font-size: clamp(4.8rem, 7.5vw, 9rem);
  font-weight: 900;
  line-height: 0.93;
  letter-spacing: -0.045em;
  color: #fff;
  margin-bottom: 2.2rem;
}
.hero-heading .word-plain { display: block; }

.hero-heading .word-serif {
  display: block;
  font-family: 'DM Serif Display', serif;
  font-style: italic;
  font-weight: 400;
  color: var(--red);
  font-size: 1.1em;
  letter-spacing: -0.025em;
  line-height: 1.0;
  margin: 0.03em 0;
  text-shadow:
    0 0 40px rgba(227,30,36,0.85),
    0 0 80px rgba(227,30,36,0.55),
    0 0 130px rgba(227,30,36,0.28),
    0 0 220px rgba(227,30,36,0.12);
}

.hero-heading .word-dim {
  display: block;
  color: rgba(255,255,255,0.40);
  font-size: 0.52em;
  font-weight: 500;
  letter-spacing: -0.01em;
  font-family: 'Plus Jakarta Sans', sans-serif;
  margin-top: 0.22em;
  line-height: 1.25;
}

.hero-desc {
  font-size: 1.05rem;
  color: rgba(255,255,255,0.55);
  max-width: 500px;
  line-height: 1.8;
  margin-bottom: 3rem;
  font-weight: 400;
}

.hero-actions {
  display: flex;
  align-items: center;
  gap: 1rem;
  flex-wrap: wrap;
}

.btn-hero-primary {
  display: inline-flex;
  align-items: center;
  gap: 0.55rem;
  padding: 1rem 2.2rem;
  background: var(--red);
  color: #fff;
  border-radius: 8px;
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-weight: 700;
  font-size: 0.92rem;
  letter-spacing: 0.01em;
  text-decoration: none;
  border: none;
  cursor: pointer;
  transition: all 0.25s var(--ease-out);
  box-shadow: 0 8px 28px rgba(227,30,36,0.4), inset 0 1px 0 rgba(255,255,255,0.12);
  white-space: nowrap;
}
.btn-hero-primary svg { width: 17px; height: 17px; flex-shrink: 0; }
.btn-hero-primary:hover {
  background: var(--red-hover);
  transform: translateY(-2px);
  box-shadow: 0 14px 36px rgba(227,30,36,0.5);
}
.btn-hero-primary:active { transform: translateY(0); }

.btn-hero-ghost {
  display: inline-flex;
  align-items: center;
  gap: 0.65rem;
  padding: 0.9rem 0.4rem;
  color: rgba(255,255,255,0.6);
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-weight: 600;
  font-size: 0.9rem;
  text-decoration: none;
  border: none;
  background: transparent;
  cursor: pointer;
  transition: all 0.22s var(--ease-out);
  white-space: nowrap;
}
.btn-hero-ghost .icon-ring {
  width: 40px; height: 40px;
  border-radius: 50%;
  border: 1.5px solid rgba(255,255,255,0.2);
  display: flex; align-items: center; justify-content: center;
  transition: all 0.22s var(--ease-out);
}
.btn-hero-ghost .icon-ring svg { width: 16px; height: 16px; }
.btn-hero-ghost:hover { color: rgba(255,255,255,0.9); }
.btn-hero-ghost:hover .icon-ring {
  background: rgba(255,255,255,0.08);
  border-color: rgba(255,255,255,0.45);
  transform: translateX(3px);
}

.hero-divider {
  width: 1px; height: 28px;
  background: rgba(255,255,255,0.12);
  margin: 0 0.3rem;
}

.hero-trust {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  margin-top: 3rem;
  padding-top: 2.4rem;
  border-top: 1px solid rgba(255,255,255,0.07);
}
.trust-avatars { display: flex; align-items: center; }
.trust-avatar {
  width: 32px; height: 32px;
  border-radius: 50%;
  border: 2px solid rgba(255,255,255,0.15);
  background: var(--navy-600);
  color: rgba(255,255,255,0.8);
  display: flex; align-items: center; justify-content: center;
  font-size: 0.72rem; font-weight: 800;
  margin-left: -8px;
}
.trust-avatars .trust-avatar:first-child { margin-left: 0; }
.trust-text {
  font-size: 0.8rem;
  color: rgba(255,255,255,0.45);
  line-height: 1.4;
}
.trust-text strong {
  display: block;
  color: rgba(255,255,255,0.75);
  font-weight: 700;
  font-size: 0.82rem;
}

/* ── Tracking card ── */
.track-card {
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
.track-card::before {
  content: '';
  position: absolute;
  top: -1px; left: 15%; right: 15%;
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.35), transparent);
}
.track-card::after {
  content: '';
  position: absolute;
  bottom: -60px; right: -60px;
  width: 220px; height: 220px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(227,30,36,0.18) 0%, transparent 65%);
  pointer-events: none;
}
.track-card-head {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  margin-bottom: 2.2rem;
}
.track-card-title {
  font-size: 1.35rem; font-weight: 800;
  color: #fff; line-height: 1.2;
  letter-spacing: -0.02em;
}
.track-card-sub {
  font-size: 0.82rem;
  color: rgba(255,255,255,0.42);
  margin-top: 0.3rem;
}
.live-badge {
  display: flex; align-items: center; gap: 0.4rem;
  background: rgba(34,197,94,0.12);
  border: 1px solid rgba(34,197,94,0.28);
  border-radius: 99px;
  padding: 0.32rem 0.75rem;
  font-size: 0.68rem; font-weight: 800;
  color: #4ade80;
  letter-spacing: 0.06em;
  text-transform: uppercase;
  flex-shrink: 0;
}
.live-dot {
  width: 6px; height: 6px;
  border-radius: 50%;
  background: #4ade80;
  animation: live-pulse 2s ease-in-out infinite;
}
@keyframes live-pulse {
  0%, 100% { opacity: 1; transform: scale(1); }
  50%       { opacity: 0.45; transform: scale(0.75); }
}
.track-label {
  display: block;
  font-size: 0.68rem; font-weight: 800;
  letter-spacing: 0.1em; text-transform: uppercase;
  color: rgba(255,255,255,0.38);
  margin-bottom: 0.55rem;
}
.track-input {
  width: 100%;
  background: rgba(255,255,255,0.06);
  border: 1px solid rgba(255,255,255,0.12);
  border-radius: 12px;
  padding: 0.95rem 1.2rem;
  color: #fff;
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 0.95rem; font-weight: 500;
  outline: none;
  transition: all 0.2s;
  margin-bottom: 1.2rem;
}
.track-input::placeholder { color: rgba(255,255,255,0.25); }
.track-input:focus {
  border-color: rgba(227,30,36,0.55);
  background: rgba(255,255,255,0.09);
  box-shadow: 0 0 0 3px rgba(227,30,36,0.1);
}
.track-btn {
  width: 100%;
  background: linear-gradient(135deg, var(--red), var(--red-hover));
  border: none; color: #fff;
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 0.93rem; font-weight: 700;
  padding: 1.05rem;
  border-radius: 12px;
  cursor: pointer;
  transition: all 0.25s var(--ease-out);
  display: flex; align-items: center; justify-content: center; gap: 0.5rem;
  box-shadow: 0 8px 28px rgba(227,30,36,0.4), inset 0 1px 0 rgba(255,255,255,0.12);
  letter-spacing: 0.01em;
}
.track-btn svg { width: 17px; height: 17px; }
.track-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 14px 36px rgba(227,30,36,0.5);
}
.track-btn:active { transform: translateY(0); }
.track-features {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 0.6rem;
  margin-top: 1.6rem;
  padding-top: 1.6rem;
  border-top: 1px solid rgba(255,255,255,0.07);
}
.track-feat {
  display: flex; align-items: center; gap: 0.5rem;
  font-size: 0.78rem; color: rgba(255,255,255,0.42);
  font-weight: 500;
}
.track-feat svg { width: 13px; height: 13px; color: var(--red); flex-shrink: 0; }

/* ── Hero stats strip ── */
.hero-stats-strip {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  border-top: 1px solid rgba(255,255,255,0.06);
  padding: 2.8rem 0;
}
.hero-stat {
  padding: 0 2rem;
  position: relative;
  text-align: center;
}
.hero-stat + .hero-stat::before {
  content: '';
  position: absolute;
  left: 0; top: 15%; height: 70%;
  width: 1px;
  background: rgba(255,255,255,0.07);
}
.hero-stat-num {
  font-size: 2.4rem; font-weight: 900;
  color: #fff; line-height: 1;
  letter-spacing: -0.04em;
  font-variant-numeric: tabular-nums;
  margin-bottom: 0.35rem;
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
.section-heading-light { color: #fff; }
.section-sub {
  font-size: 1rem;
  color: var(--text-2);
  max-width: 540px;
  line-height: 1.75;
  font-weight: 400;
}
.section-sub-light { color: rgba(255,255,255,0.5); }
.section-center {
  text-align: center;
  margin-bottom: 4.5rem;
}
.section-center .section-sub { margin: 0 auto; }

/* ══════════════════════════════════════════
   SERVICES — Bento
══════════════════════════════════════════ */
.bento {
  display: grid;
  grid-template-columns: repeat(12, 1fr);
  grid-auto-rows: auto;
  gap: 1.25rem;
}
.b-card {
  border-radius: 20px;
  padding: 2.4rem 2.2rem;
  position: relative; overflow: hidden;
  border: 1px solid var(--border);
  background: var(--white);
  transition: transform 0.35s var(--ease-out), box-shadow 0.35s var(--ease-out), border-color 0.35s;
}
.b-card:hover {
  transform: translateY(-5px);
  box-shadow: var(--shadow-lg);
  border-color: transparent;
}
.b-5  { grid-column: span 5; }
.b-4  { grid-column: span 4; }
.b-3  { grid-column: span 3; }
.b-7  { grid-column: span 7; }
.b-6  { grid-column: span 6; }

.b-card.b-dark {
  background: linear-gradient(155deg, var(--navy-800) 0%, var(--navy-700) 100%);
  border: none;
  box-shadow: var(--shadow-lg);
}
.b-card.b-dark:hover { box-shadow: 0 28px 64px rgba(9,24,60,0.28); }
.b-card.b-dark::after {
  content: '';
  position: absolute;
  bottom: -50px; right: -50px;
  width: 200px; height: 200px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(227,30,36,0.22) 0%, transparent 65%);
  pointer-events: none;
}
.b-icon {
  width: 52px; height: 52px;
  border-radius: 14px;
  display: flex; align-items: center; justify-content: center;
  margin-bottom: 1.8rem;
}
.b-icon-navy  { background: rgba(14,34,96,0.08); color: var(--navy-600); }
.b-icon-red   { background: rgba(227,30,36,0.09); color: var(--red); }
.b-icon-ghost { background: rgba(255,255,255,0.1); color: rgba(255,255,255,0.9); }
.b-icon svg   { width: 24px; height: 24px; }
.b-card h3 {
  font-size: 1.12rem; font-weight: 800;
  color: var(--text-primary);
  letter-spacing: -0.02em;
  margin-bottom: 0.5rem;
  line-height: 1.25;
}
.b-card.b-dark h3 { color: #fff; }
.b-card p { font-size: 0.875rem; color: var(--text-2); line-height: 1.7; }
.b-card.b-dark p { color: rgba(255,255,255,0.5); }
.b-link {
  display: inline-flex; align-items: center; gap: 0.4rem;
  font-size: 0.8rem; font-weight: 700;
  color: var(--red); text-decoration: none;
  margin-top: 1.4rem;
  transition: gap 0.2s var(--ease-out);
}
.b-link svg { width: 13px; height: 13px; }
.b-link:hover { gap: 0.7rem; }
.b-card.b-dark .b-link { color: rgba(255,255,255,0.55); }
.b-card.b-dark .b-link:hover { color: #fff; }
.b-num {
  position: absolute;
  top: 2rem; right: 2rem;
  font-size: 4.5rem; font-weight: 900;
  color: rgba(9,24,60,0.04);
  letter-spacing: -0.06em;
  line-height: 1;
  pointer-events: none;
  font-variant-numeric: tabular-nums;
}
.b-card.b-dark .b-num { color: rgba(255,255,255,0.04); }

/* ══════════════════════════════════════════
   DELIVERY TIME — Tabs
══════════════════════════════════════════ */
.tab-switcher {
  display: flex;
  gap: 0.4rem;
  background: var(--surface-3);
  border: 1px solid var(--border);
  border-radius: 12px;
  padding: 5px;
  width: fit-content;
  margin: 0 auto 3.5rem;
  flex-wrap: wrap;
}
.tab-btn {
  padding: 0.6rem 1.6rem;
  border-radius: 8px;
  border: none;
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 0.8rem; font-weight: 700;
  cursor: pointer;
  background: transparent;
  color: var(--text-muted);
  transition: all 0.22s;
  letter-spacing: 0.02em;
  white-space: nowrap;
}
.tab-btn.active {
  background: var(--navy-800);
  color: #fff;
  box-shadow: var(--shadow-sm);
}
.tab-btn:not(.active):hover {
  background: var(--border);
  color: var(--text-primary);
}
.tab-panel { display: none; }
.tab-panel.active { display: block; }

.route-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 1.25rem;
}
.route-card {
  background: var(--white);
  border: 1px solid var(--border);
  border-radius: 18px;
  padding: 2rem 1.8rem;
  position: relative; overflow: hidden;
  transition: all 0.3s var(--ease-out);
  cursor: default;
}
.route-card::before {
  content: '';
  position: absolute;
  left: 0; top: 0; bottom: 0;
  width: 3px;
  background: var(--red);
  border-radius: 0 3px 3px 0;
  transform: scaleY(0);
  transform-origin: bottom;
  transition: transform 0.3s var(--ease-out);
}
.route-card:hover {
  border-color: rgba(227,30,36,0.15);
  box-shadow: var(--shadow-md);
  transform: translateY(-3px);
}
.route-card:hover::before { transform: scaleY(1); }
.route-icon {
  width: 36px; height: 36px;
  border-radius: 10px;
  background: rgba(227,30,36,0.08);
  display: flex; align-items: center; justify-content: center;
  color: var(--red);
  margin-bottom: 1.2rem;
}
.route-icon svg { width: 16px; height: 16px; }
.route-region {
  font-size: 0.8rem; font-weight: 700;
  color: var(--text-muted);
  text-transform: uppercase; letter-spacing: 0.06em;
  margin-bottom: 0.4rem;
}
.route-time {
  font-size: 2.2rem; font-weight: 900;
  color: var(--text-primary);
  line-height: 1; letter-spacing: -0.04em;
  margin-bottom: 0.2rem;
}
.route-time em { font-style: normal; color: var(--red); }
.route-unit {
  font-size: 0.72rem; font-weight: 700;
  color: var(--text-faint);
  text-transform: uppercase; letter-spacing: 0.07em;
}
.route-countries {
  margin-top: 1rem;
  padding-top: 0.85rem;
  border-top: 1px solid var(--border);
  display: flex;
  flex-wrap: wrap;
  gap: 0.35rem;
}
.country-tag {
  font-size: 0.68rem;
  font-weight: 600;
  background: var(--surface-2);
  color: var(--text-2);
  border-radius: 6px;
  padding: 0.18rem 0.5rem;
  border: 1px solid var(--border);
}
.timeline-disclaimer {
  margin-top: 2rem;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  font-size: 0.78rem;
  color: var(--text-muted);
  padding: 0.75rem 1.5rem;
  background: var(--surface-2);
  border-radius: 99px;
  width: fit-content;
  margin-left: auto; margin-right: auto;
}
.timeline-disclaimer svg { width: 13px; height: 13px; flex-shrink: 0; }

/* ══════════════════════════════════════════
   WHY US — Pillars
══════════════════════════════════════════ */
.pillars {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1.75rem;
}
.pillar {
  padding: 2.8rem 2.4rem;
  border-radius: 22px;
  background: var(--white);
  border: 1px solid var(--border);
  position: relative; overflow: hidden;
  transition: all 0.35s var(--ease-out);
}
.pillar:hover {
  border-color: transparent;
  box-shadow: 0 24px 60px rgba(9,24,60,0.11);
  transform: translateY(-5px);
}
.pillar-count {
  position: absolute;
  top: 2rem; right: 2.2rem;
  font-size: 5rem; font-weight: 900;
  color: rgba(9,24,60,0.04);
  letter-spacing: -0.05em;
  line-height: 1;
  pointer-events: none;
  transition: color 0.35s;
  font-variant-numeric: tabular-nums;
}
.pillar:hover .pillar-count { color: rgba(227,30,36,0.06); }
.pillar-icon {
  width: 58px; height: 58px;
  border-radius: 16px;
  background: rgba(227,30,36,0.08);
  color: var(--red);
  display: flex; align-items: center; justify-content: center;
  margin-bottom: 1.8rem;
  transition: all 0.3s var(--ease-out);
}
.pillar:hover .pillar-icon {
  background: var(--red);
  color: #fff;
  transform: scale(1.06);
  box-shadow: 0 8px 24px rgba(227,30,36,0.3);
}
.pillar-icon svg { width: 26px; height: 26px; }
.pillar h3 {
  font-size: 1.1rem; font-weight: 800;
  color: var(--text-primary);
  letter-spacing: -0.02em;
  margin-bottom: 0.7rem;
  line-height: 1.25;
}
.pillar p { font-size: 0.875rem; color: var(--text-2); line-height: 1.75; }

/* ══════════════════════════════════════════
   TESTIMONIALS
══════════════════════════════════════════ */
.testi-section { overflow: hidden; }
.testi-slider-wrap {
  position: relative;
  overflow: hidden;
  padding: 1rem 0 1.5rem;
}
.testi-slider-wrap::before,
.testi-slider-wrap::after {
  content: '';
  position: absolute;
  top: 0; bottom: 0;
  width: 160px;
  z-index: 2;
  pointer-events: none;
}
.testi-slider-wrap::before { left: 0;  background: linear-gradient(to right, var(--surface-2), transparent); }
.testi-slider-wrap::after  { right: 0; background: linear-gradient(to left,  var(--surface-2), transparent); }
.testi-track {
  display: flex;
  gap: 1.5rem;
  width: max-content;
  animation: ticker 38s linear infinite;
}
.testi-track:hover { animation-play-state: paused; }
@keyframes ticker {
  0%   { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}
.testi-card {
  flex: 0 0 360px;
  background: var(--white);
  border: 1px solid var(--border);
  border-radius: 20px;
  padding: 2.2rem 2rem;
  transition: all 0.3s var(--ease-out);
}
.testi-card:hover {
  box-shadow: var(--shadow-lg);
  transform: translateY(-5px);
  border-color: transparent;
}
.testi-stars { display: flex; gap: 3px; margin-bottom: 1.1rem; }
.testi-stars svg { width: 14px; height: 14px; fill: #F59E0B; stroke: none; }
.testi-quote-mark {
  font-family: 'DM Serif Display', serif;
  font-size: 2.8rem;
  line-height: 0.8;
  color: var(--red);
  opacity: 0.4;
  margin-bottom: 0.4rem;
}
.testi-text { font-size: 0.875rem; color: var(--text-2); line-height: 1.75; margin-bottom: 1.6rem; }
.testi-divider { height: 1px; background: var(--border); margin-bottom: 1.3rem; }
.testi-author  { display: flex; align-items: center; gap: 0.85rem; }
.testi-avatar  {
  width: 40px; height: 40px;
  border-radius: 50%;
  background: var(--navy-800);
  color: #fff;
  display: flex; align-items: center; justify-content: center;
  font-weight: 800; font-size: 0.82rem;
  flex-shrink: 0;
}
.testi-name  { font-size: 0.875rem; font-weight: 700; color: var(--text-primary); line-height: 1.2; }
.testi-route {
  font-size: 0.75rem; color: var(--text-muted);
  display: flex; align-items: center; gap: 0.3rem;
  margin-top: 0.2rem;
}
.testi-route svg { width: 11px; height: 11px; }

/* ══════════════════════════════════════════
   CTA
══════════════════════════════════════════ */
.cta-wrap { padding: 6rem 0; }
.cta-inner {
  position: relative;
  background: var(--navy-900);
  border-radius: 28px;
  overflow: hidden;
  display: grid;
  grid-template-columns: 1fr 280px;
  align-items: center;
  gap: 4rem;
  padding: 5.5rem 5rem;
}
.cta-inner::before {
  content: '';
  position: absolute; inset: 0;
  background-image:
    linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
  background-size: 48px 48px;
  pointer-events: none;
}
.cta-inner::after {
  content: '';
  position: absolute;
  top: -100px; left: 40%;
  width: 500px; height: 500px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(20,56,160,0.35) 0%, transparent 60%);
  pointer-events: none;
}
.cta-content { position: relative; z-index: 1; }
.cta-chip {
  display: inline-flex; align-items: center; gap: 0.45rem;
  background: rgba(227,30,36,0.18);
  border: 1px solid rgba(227,30,36,0.3);
  color: #ff7a7a;
  border-radius: 99px;
  padding: 0.32rem 0.85rem;
  font-size: 0.67rem; font-weight: 800;
  text-transform: uppercase; letter-spacing: 0.1em;
  margin-bottom: 1.4rem;
}
.cta-chip svg { width: 9px; height: 9px; }
.cta-title {
  font-size: clamp(1.9rem, 3vw, 2.8rem);
  font-weight: 900;
  color: #fff;
  letter-spacing: -0.035em;
  line-height: 1.12;
  margin-bottom: 1rem;
}
.cta-title span { color: var(--red); }
.cta-desc {
  color: rgba(255,255,255,0.5);
  font-size: 0.975rem;
  line-height: 1.75;
  max-width: 520px;
  margin-bottom: 2.4rem;
}
.cta-btns { display: flex; gap: 1rem; flex-wrap: wrap; position: relative; z-index: 1; }
.cta-btn-primary {
  display: inline-flex; align-items: center; gap: 0.55rem;
  background: var(--red); color: #fff;
  padding: 1rem 2.2rem; border-radius: 10px;
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 0.93rem; font-weight: 700;
  text-decoration: none; border: none; cursor: pointer;
  transition: all 0.25s var(--ease-out);
  box-shadow: 0 8px 28px rgba(227,30,36,0.4);
  letter-spacing: 0.01em;
}
.cta-btn-primary svg { width: 18px; height: 18px; }
.cta-btn-primary:hover {
  background: var(--red-hover);
  transform: translateY(-2px);
  box-shadow: 0 14px 40px rgba(227,30,36,0.5);
}
.cta-btn-outline {
  display: inline-flex; align-items: center; gap: 0.55rem;
  background: transparent; color: rgba(255,255,255,0.65);
  padding: 1rem 2.2rem; border-radius: 10px;
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 0.93rem; font-weight: 700;
  text-decoration: none;
  border: 1.5px solid rgba(255,255,255,0.18);
  cursor: pointer;
  transition: all 0.25s var(--ease-out);
  letter-spacing: 0.01em;
}
.cta-btn-outline svg { width: 18px; height: 18px; }
.cta-btn-outline:hover {
  background: rgba(255,255,255,0.07);
  border-color: rgba(255,255,255,0.38);
  color: #fff;
}
.cta-pills { position: relative; z-index: 1; display: flex; flex-direction: column; gap: 1rem; }
.cta-pill {
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,255,255,0.1);
  border-radius: 16px;
  padding: 1.4rem 1.8rem;
  text-align: center;
  backdrop-filter: blur(12px);
  transition: all 0.25s;
}
.cta-pill:hover { background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.18); }
.cta-pill-num {
  font-size: 2.1rem; font-weight: 900;
  color: #fff; line-height: 1;
  letter-spacing: -0.04em;
}
.cta-pill-num em { font-style: normal; color: var(--red); }
.cta-pill-label {
  font-size: 0.68rem; font-weight: 700;
  color: rgba(255,255,255,0.38);
  text-transform: uppercase; letter-spacing: 0.09em;
  margin-top: 0.3rem;
}

/* ══════════════════════════════════════════
   RESPONSIVE
══════════════════════════════════════════ */
@media (max-width: 1200px) {
  .hero-inner { grid-template-columns: 1fr 420px; gap: 3rem; }
  .hero-heading { font-size: clamp(4rem, 6.5vw, 7rem); }
  .b-5 { grid-column: span 6; }
  .b-4 { grid-column: span 6; }
  .b-3 { grid-column: span 6; }
  .b-7 { grid-column: span 6; }
  .b-6 { grid-column: span 6; }
}
@media (max-width: 1024px) {
  .pillars { grid-template-columns: repeat(2, 1fr); }
  .route-grid { grid-template-columns: repeat(2, 1fr); }
  .cta-inner { grid-template-columns: 1fr; padding: 4rem 3.5rem; }
  .cta-pills { flex-direction: row; justify-content: flex-start; }
}
@media (max-width: 860px) {
  .hero-inner { grid-template-columns: 1fr; gap: 3rem; padding: 3rem 0 2.5rem; }
  .hero-heading { font-size: clamp(3.5rem, 10vw, 6rem); }
  .hero-stats-strip { grid-template-columns: repeat(2, 1fr); }
  .hero-stat:nth-child(3)::before,
  .hero-stat:nth-child(4)::before { display: none; }
  .bento { grid-template-columns: 1fr; }
  .b-5,.b-4,.b-3,.b-7,.b-6 { grid-column: span 1; }
  .pillars { grid-template-columns: 1fr; }
  .cta-inner { padding: 3.5rem 2.5rem; }
  .cta-pills { display: none; }
  .hero-divider { display: none; }
}
@media (max-width: 600px) {
  .hp .container { padding: 0 1.25rem; }
  .hero-heading { font-size: clamp(3rem, 12vw, 5rem); }
  .hero-stats-strip { grid-template-columns: 1fr 1fr; }
  .route-grid { grid-template-columns: 1fr; }
  .section { padding: 5rem 0; }
  .cta-inner { padding: 3rem 1.75rem; }
  .cta-btns { flex-direction: column; }
  .cta-btn-primary, .cta-btn-outline { justify-content: center; }
}
</style>

<div class="hp">

  {{-- ══ HERO ══ --}}
  <section class="hero">
    <div class="hero-canvas"></div>
    <div class="hero-grid"></div>
    <div class="hero-lines"></div>
    <div class="hero-glow hero-glow-1"></div>
    <div class="hero-glow hero-glow-2"></div>
    <div class="container">
      <div class="hero-inner">

        {{-- LEFT: Text --}}
        <div class="hero-text">
          <div class="hero-badge hero-eyebrow">
            <div class="hero-badge-dot">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <circle cx="12" cy="12" r="10"/>
                <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
              </svg>
            </div>
            <span>Global Logistics Leader</span>
          </div>
          <h1 class="hero-heading hero-title">
            <span class="word-plain">Pengiriman</span>
            <span class="word-serif">Internasional</span>
            <span class="word-dim">Terpercaya &amp; Cepat ke 200+ Negara</span>
          </h1>
          <p class="hero-desc">
            Indo Cahaya Express menghubungkan bisnis Anda ke 200+ negara dengan </br>layanan door-to-door, tracking real-time, dan jaminan keamanan penuh.
          </p>
          <div class="hero-actions hero-cta-row">
            <a href="{{ route('calculator') }}" class="btn-hero-primary">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 7h13M10 21a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm7 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
              </svg>
              Hitung Ongkir
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
          <div class="hero-trust hero-cta-row reveal-d1">
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

        {{-- RIGHT: Tracking Card --}}
        <div class="track-card track-panel">
          <div class="track-card-head">
            <div>
              <div class="track-card-title">Lacak Paket</div>
              <div class="track-card-sub">Pantau kiriman Anda real-time</div>
            </div>
            <div class="live-badge">
              <div class="live-dot"></div>
              Live
            </div>
          </div>
          <form action="{{ route('tracking.track') }}" method="POST">
            @csrf
            <label class="track-label">Nomor Resi / Tracking</label>
            <input type="text" name="tracking_number" class="track-input"
                   placeholder="Contoh: ICE2024001234" required autocomplete="off">
            <button type="submit" class="track-btn">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
              </svg>
              Lacak Sekarang
            </button>
          </form>
          <div class="track-features">
            <div class="track-feat">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
              Update real-time
            </div>
            <div class="track-feat">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
              Notifikasi status
            </div>
            <div class="track-feat">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
              Riwayat lengkap
            </div>
            <div class="track-feat">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
              50+ negara
            </div>
          </div>
        </div>
      </div>

      {{-- Stats Strip --}}
      <div class="hero-stats-strip">
        <div class="hero-stat">
          <div class="hero-stat-num">
            <span class="counter" data-target="10000">0</span><em>+</em>
          </div>
          <div class="hero-stat-label">Pengiriman Sukses</div>
        </div>
        <div class="hero-stat">
          <div class="hero-stat-num">
            <span class="counter" data-target="200">0</span><em>+</em>
          </div>
          <div class="hero-stat-label">Negara Tujuan</div>
        </div>
        <div class="hero-stat">
          <div class="hero-stat-num">
            <span class="counter" data-target="99">0</span><em>%</em>
          </div>
          <div class="hero-stat-label">Tepat Waktu</div>
        </div>
        <div class="hero-stat">
          <div class="hero-stat-num">
            5<em>★</em>
          </div>
          <div class="hero-stat-label">Rating Pelanggan</div>
        </div>
      </div>
    </div>
  </section>

  {{-- ══ SERVICES ══ --}}
  <section class="section section-soft">
    <div class="container">
      <div class="section-center">
        <span class="section-label reveal">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 5v3h-7V8z"/>
          </svg>
          Layanan Kami
        </span>
        <h2 class="section-heading reveal reveal-d1">Solusi Pengiriman Modern</h2>
        <p class="section-sub reveal reveal-d2">Dirancang untuk bisnis dari skala kecil hingga enterprise dengan standar internasional</p>
      </div>
      <div class="bento">
        <div class="b-card b-dark b-5 reveal reveal-d1">
          <div class="b-num">01</div>
          <div class="b-icon b-icon-ghost">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <circle cx="12" cy="12" r="10"/>
              <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
            </svg>
          </div>
          <h3>International Shipping</h3>
          <p>Pengiriman global door-to-door dengan asuransi penuh, bea cukai terintegrasi, dan tracking real-time ke 200+ negara di seluruh penjuru dunia.</p>
          <a href="{{ route('book') }}" class="b-link">
            Mulai Pengiriman
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </a>
        </div>
        <div class="b-card b-4 reveal-d2">
          <div class="b-num">02</div>
          <div class="b-icon b-icon-red">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
            </svg>
          </div>
          <h3>Express Delivery</h3>
          <p>Prioritas pengiriman 3–6 hari kerja untuk paket mendesak dengan konfirmasi penerimaan langsung.</p>
          <a href="{{ route('book') }}" class="b-link">
            Pilih Express
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </a>
        </div>
        <div class="b-card b-3 reveal-d3">
          <div class="b-num">03</div>
          <div class="b-icon b-icon-navy">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 5v3h-7V8z"/>
            </svg>
          </div>
          <h3>Economy</h3>
          <p>Hemat biaya dengan estimasi 7–20 hari, ideal untuk pengiriman non-urgent dan volume besar.</p>
          <a href="{{ route('book') }}" class="b-link">
            Lihat Tarif
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </a>
        </div>
        <div class="b-card b-6 reveal-d4">
          <div class="b-num">04</div>
          <div class="b-icon b-icon-navy">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
            </svg>
          </div>
          <h3>Real-Time Tracking</h3>
          <p>Pantau posisi paket Anda setiap saat dengan sistem tracking canggih yang menampilkan riwayat perjalanan lengkap dari gudang ke tangan penerima.</p>
          <a href="{{ route('tracking.index') }}" class="b-link">
            Cek Tracking
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </a>
        </div>
        <div class="b-card b-6 reveal-d5">
          <div class="b-num">05</div>
          <div class="b-icon b-icon-red">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
          </div>
          <h3>Shipping Insurance</h3>
          <p>Setiap pengiriman dilindungi asuransi komprehensif.</p>
          <a href="{{ route('terms') }}" class="b-link">
            Pelajari Lebih
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </a>
        </div>
      </div>
    </div>
  </section>

  {{-- ══ WHY US ══ --}}
  <section class="section section-soft">
    <div class="container">
      <div class="section-center">
        <span class="section-label reveal">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
          </svg>
          Keunggulan
        </span>
        <h2 class="section-heading reveal reveal-d1">Mengapa Memilih Kami</h2>
        <p class="section-sub reveal reveal-d2">Komitmen kami terhadap kualitas, keamanan, dan kepuasan pelanggan tidak pernah goyah</p>
      </div>
      <div class="pillars">
        <div class="pillar">
          <div class="pillar-count">01</div>
          <div class="pillar-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
          </div>
          <h3>Jaminan Keamanan</h3>
          <p>Setiap paket dilindungi asuransi penuh dengan standar penanganan internasional.</p>
        </div>
        <div class="pillar">
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
        <div class="pillar">
          <div class="pillar-count">03</div>
          <div class="pillar-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
            </svg>
          </div>
          <h3>CS Responsif Di Jam Kerja</h3>
          <p>Tim customer service kami siap membantu kapan saja — mulai dari konsultasi tarif hingga penanganan klaim dan proses bea cukai.</p>
        </div>
      </div>
    </div>
  </section>

  {{-- ══ TESTIMONIALS ══ --}}
  <section class="section section-alt testi-section">
    <div class="container">
      <div class="section-center">
        <span class="section-label reveal">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
          </svg>
          Testimoni
        </span>
        <h2 class="section-heading reveal reveal-d1">Dipercaya Pelanggan</h2>
        <p class="section-sub reveal reveal-d2">Cerita nyata dari mereka yang telah mempercayakan pengiriman kepada kami</p>
      </div>
    </div>
    <div class="testi-slider-wrap">
      <div class="testi-track">
        @php
          $testis = [
            ['A','Ahmad R.','Jakarta → Malaysia','Pengiriman super cepat! Hanya 4 hari paket sudah tiba dengan kondisi sempurna. Tracking-nya juga sangat akurat dan mudah dipahami.'],
            ['S','Siti R.','Surabaya → Jepang','Tracking real-time sangat membantu. Customer service sangat responsif saat saya ada pertanyaan soal bea cukai. Puas sekali!'],
            ['B','Budi S.','Bandung → Australia','Harga sangat kompetitif dibanding jasa lain. Paket sampai tepat sesuai estimasi. Akan terus pakai Indo Cahaya Express.'],
            ['D','Dewi K.','Medan → USA','CS sangat membantu mengurus dokumen bea cukai. Paket tiba dalam 8 hari tanpa hambatan apapun. Luar biasa!'],
            ['R','Rendi P.','Yogyakarta → Singapura','Dokumen penting tiba tepat waktu untuk meeting saya. Proses booking juga sangat mudah dan cepat. Sangat direkomendasikan!'],
            ['F','Fitri H.','Semarang → Korea','Booking online mudah, tidak ada biaya tersembunyi. Transparansi harga yang sangat saya apresiasi. Layanan premium!'],
          ];
        @endphp
        @foreach($testis as $t)
        <div class="testi-card">
          <div class="testi-stars">
            @for($i=0;$i<5;$i++)
              <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            @endfor
          </div>
          <div class="testi-quote-mark">"</div>
          <p class="testi-text">{{ $t[3] }}</p>
          <div class="testi-divider"></div>
          <div class="testi-author">
            <div class="testi-avatar">{{ $t[0] }}</div>
            <div>
              <div class="testi-name">{{ $t[1] }}</div>
              <div class="testi-route">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                {{ $t[2] }}
              </div>
            </div>
          </div>
        </div>
        @endforeach
        @foreach($testis as $t)
        <div class="testi-card">
          <div class="testi-stars">
            @for($i=0;$i<5;$i++)
              <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            @endfor
          </div>
          <div class="testi-quote-mark">"</div>
          <p class="testi-text">{{ $t[3] }}</p>
          <div class="testi-divider"></div>
          <div class="testi-author">
            <div class="testi-avatar">{{ $t[0] }}</div>
            <div>
              <div class="testi-name">{{ $t[1] }}</div>
              <div class="testi-route">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                {{ $t[2] }}
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ══ CTA ══ --}}
  <section class="cta-wrap">
    <div class="container">
      <div class="cta-inner">
        <div class="cta-content">
          <div class="cta-chip">
            <svg viewBox="0 0 24 24" fill="currentColor" width="9" height="9">
              <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
            </svg>
            Mulai Sekarang
          </div>
          <h2 class="cta-title">Siap Kirim ke <span>Seluruh Dunia?</span></h2>
          <p class="cta-desc">Bergabung dengan ribuan pelanggan yang sudah mempercayakan pengiriman internasional kepada Indo Cahaya Express. Dapatkan penawaran terbaik hari ini.</p>
          <div class="cta-btns">
            <a href="{{ route('calculator') }}" class="cta-btn-primary">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 7h13M10 21a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm7 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
              </svg>
              Hitung Ongkir Gratis
            </a>
            <a href="{{ route('customer-service') }}" class="cta-btn-outline">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
              </svg>
              Hubungi Kami
            </a>
          </div>
        </div>
        <div class="cta-pills">
          <div class="cta-pill">
            <div class="cta-pill-num">200<em>+</em></div>
            <div class="cta-pill-label">Negara Tujuan</div>
          </div>
          <div class="cta-pill">
            <div class="cta-pill-num">99<em>%</em></div>
            <div class="cta-pill-label">On-Time Rate</div>
          </div>
          <div class="cta-pill">
            <div class="cta-pill-num">24<em>/7</em></div>
            <div class="cta-pill-label">Customer Support</div>
          </div>
        </div>
      </div>
    </div>
  </section>

</div>{{-- /hp --}}

<script>
const counters = document.querySelectorAll('.counter');
const counterObs = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    if (!entry.isIntersecting) return;
    const el     = entry.target;
    const target = +el.dataset.target;
    const dur    = 1800;
    const step   = target / (dur / 16);
    let cur = 0;
    const run = () => {
      cur = Math.min(cur + step, target);
      el.textContent = Math.floor(cur).toLocaleString('id-ID');
      if (cur < target) requestAnimationFrame(run);
    };
    requestAnimationFrame(run);
    counterObs.unobserve(el);
  });
}, { threshold: 0.4 });
counters.forEach(c => counterObs.observe(c));

function switchTab(e, id) {
  document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
  document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
  document.getElementById(id).classList.add('active');
  e.currentTarget.classList.add('active');
}

// Scroll Reveal
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

</script>
@endsection
