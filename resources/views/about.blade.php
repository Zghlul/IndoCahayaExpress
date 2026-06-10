@extends('layouts.app')
@section('title', 'Tentang Kami - Indo Cahaya Express')
@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300&family=DM+Serif+Display:ital@0;1&display=swap');

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

/* ══ REVEAL ANIMATIONS (sama seperti home) ══ */
.reveal,
.reveal-left,
.reveal-right {
  opacity: 0;
  transition: opacity 0.7s var(--ease-out), transform 0.7s var(--ease-out);
}
.reveal       { transform: translateY(28px); }
.reveal-left  { transform: translateX(-32px); }
.reveal-right { transform: translateX(32px); }

.reveal.is-visible,
.reveal-left.is-visible,
.reveal-right.is-visible {
  opacity: 1;
  transform: translate(0);
}

.reveal-d1 { transition-delay: 0.08s; }
.reveal-d2 { transition-delay: 0.16s; }
.reveal-d3 { transition-delay: 0.24s; }
.reveal-d4 { transition-delay: 0.32s; }

/* ══ HERO ══ */
.hero {
  position: relative;
  min-height: 88vh;
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
    transparent 0%, rgba(227,30,36,0.35) 25%,
    rgba(227,30,36,0.15) 70%, transparent 100%);
}
.hero-lines::after {
  left: 52%;
  background: linear-gradient(to bottom,
    transparent 10%, rgba(59,174,224,0.12) 40%,
    rgba(59,174,224,0.06) 75%, transparent 100%);
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
.hero .container { position: relative; z-index: 2; }
.hero-inner {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  padding: 2rem 0 6rem;
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
  font-size: 0.58em;
  font-weight: 500;
  letter-spacing: -0.01em;
  font-family: 'Plus Jakarta Sans', sans-serif;
  margin-top: 0.2em;
  line-height: 1.3;
}

.hero-desc {
  font-size: 1.05rem;
  color: rgba(255,255,255,0.55);
  max-width: 600px;
  line-height: 1.8;
  margin-bottom: 3rem;
  font-weight: 400;
}

.hero-actions {
  display: flex;
  align-items: center;
  gap: 1rem;
  flex-wrap: wrap;
  justify-content: center;
}
.btn-hero-primary {
  display: inline-flex;
  align-items: center;
  gap: 0.55rem;
  padding: 0.9rem 2rem;
  background: var(--red);
  color: #fff;
  border-radius: 8px;
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-weight: 700;
  font-size: 0.9rem;
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

/* Stats Strip */
.hero-stats-strip {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  border-top: 1px solid rgba(255,255,255,0.06);
  margin-top: 4rem;
  padding: 2.5rem 0;
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
  font-size: 2.2rem; font-weight: 900;
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

/* ══ SECTION BASE ══ */
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
.section-center { text-align: center; margin-bottom: 4.5rem; }
.section-center .section-sub { margin: 0 auto; }

/* ══ STORY ══ */
.story-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 5rem;
  align-items: center;
}
.story-visual {
  position: relative;
  border-radius: 24px;
  overflow: hidden;
  background: linear-gradient(155deg, var(--navy-800) 0%, var(--navy-700) 100%);
  padding: 3.5rem 2.5rem;
  text-align: center;
  box-shadow: var(--shadow-xl);
}
.story-visual::before {
  content: '';
  position: absolute;
  top: -1px; left: 15%; right: 15%;
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.25), transparent);
}
.story-visual::after {
  content: '';
  position: absolute;
  bottom: -60px; right: -60px;
  width: 220px; height: 220px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(227,30,36,0.18) 0%, transparent 65%);
  pointer-events: none;
}
.story-visual-grid {
  position: absolute;
  inset: 0;
  background-image: radial-gradient(circle, rgba(255,255,255,0.04) 1px, transparent 1px);
  background-size: 30px 30px;
  pointer-events: none;
}
.story-visual-icon {
  position: relative; z-index: 1;
  width: 80px; height: 80px;
  background: rgba(255,255,255,0.08);
  border-radius: 22px;
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 1.5rem;
  border: 1px solid rgba(255,255,255,0.12);
}
.story-visual-icon svg { width: 38px; height: 38px; color: #fff; opacity: 0.9; }
.story-visual h3 {
  position: relative; z-index: 1;
  color: #fff;
  font-size: 1.55rem; font-weight: 900;
  margin-bottom: 0.5rem;
  letter-spacing: -0.03em;
}
.story-visual p {
  position: relative; z-index: 1;
  color: rgba(255,255,255,0.5);
  font-size: 0.9rem;
}
.story-year-badge {
  position: absolute;
  bottom: 1.8rem; right: 1.8rem;
  z-index: 2;
  background: rgba(255,255,255,0.1);
  backdrop-filter: blur(12px);
  border: 1px solid rgba(255,255,255,0.15);
  border-radius: 14px;
  padding: 0.9rem 1.3rem;
  text-align: center;
}
.story-year-badge strong {
  font-size: 1.9rem; font-weight: 900;
  display: block; line-height: 1;
  color: #fff; letter-spacing: -0.04em;
}
.story-year-badge span {
  font-size: 0.68rem;
  color: rgba(255,255,255,0.55);
  font-weight: 700; letter-spacing: 0.06em;
  text-transform: uppercase;
}
.story-text h2 {
  font-size: clamp(1.75rem, 3vw, 2.4rem);
  font-weight: 900;
  color: var(--text-primary);
  margin-bottom: 1.2rem;
  letter-spacing: -0.035em;
  line-height: 1.15;
}
.story-text p {
  color: var(--text-2);
  line-height: 1.85;
  margin-bottom: 1.1rem;
  font-size: 0.975rem;
}

/* ══ BENTO GRID — Values ══ */
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
.b-4 { grid-column: span 4; }
.b-6 { grid-column: span 6; }
.b-icon {
  width: 52px; height: 52px;
  border-radius: 14px;
  display: flex; align-items: center; justify-content: center;
  margin-bottom: 1.8rem;
}
.b-icon-red   { background: rgba(227,30,36,0.09); color: var(--red); }
.b-icon-navy  { background: rgba(14,34,96,0.08); color: var(--navy-600); }
.b-icon svg   { width: 24px; height: 24px; }
.b-card h3 {
  font-size: 1.12rem; font-weight: 800;
  color: var(--text-primary);
  letter-spacing: -0.02em;
  margin-bottom: 0.5rem;
  line-height: 1.25;
}
.b-card p { font-size: 0.875rem; color: var(--text-2); line-height: 1.7; }
.b-num {
  position: absolute;
  top: 2rem; right: 2rem;
  font-size: 4.5rem; font-weight: 900;
  color: rgba(9,24,60,0.04);
  letter-spacing: -0.06em; line-height: 1;
  pointer-events: none;
  font-variant-numeric: tabular-nums;
}

/* ══ MISSION & VISION ══ */
.mv-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1.75rem;
}
.mv-card {
  border-radius: 22px;
  padding: 2.8rem 2.4rem;
  background: var(--white);
  border: 1px solid var(--border);
  position: relative; overflow: hidden;
  transition: all 0.35s var(--ease-out);
}
.mv-card:hover {
  border-color: transparent;
  box-shadow: 0 24px 60px rgba(9,24,60,0.11);
  transform: translateY(-5px);
}
.mv-card::after {
  content: '';
  position: absolute;
  bottom: -40px; right: -40px;
  width: 160px; height: 160px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(227,30,36,0.06) 0%, transparent 65%);
  pointer-events: none;
}
.mv-icon {
  width: 58px; height: 58px;
  border-radius: 16px;
  background: var(--red);
  color: #fff;
  display: flex; align-items: center; justify-content: center;
  margin-bottom: 1.8rem;
  box-shadow: 0 8px 24px rgba(227,30,36,0.3);
}
.mv-icon svg { width: 26px; height: 26px; }
.mv-card h3 {
  font-size: 1.25rem; font-weight: 800;
  color: var(--text-primary);
  margin-bottom: 0.8rem;
  letter-spacing: -0.025em;
}
.mv-card p {
  color: var(--text-2);
  line-height: 1.75;
  margin-bottom: 1.5rem;
  font-size: 0.925rem;
}
.mv-list { list-style: none; padding: 0; border-top: 1px solid var(--border); padding-top: 1.3rem; }
.mv-list li {
  display: flex; gap: 0.7rem;
  margin-bottom: 0.6rem;
  font-size: 0.875rem;
  color: var(--text-primary);
  font-weight: 500;
  align-items: flex-start;
}
.mv-list li svg { width: 14px; height: 14px; color: var(--red); flex-shrink: 0; margin-top: 3px; }

/* ══ TIMELINE ══ */
.timeline-wrap {
  background: var(--surface-3);
  border: 1px solid var(--border-2);
  border-radius: 22px;
  padding: 2.4rem 2.2rem;
}
.timeline-item { display: flex; gap: 1.5rem; margin-bottom: 2rem; }
.timeline-item:last-child { margin-bottom: 0; }
.timeline-left { display: flex; flex-direction: column; align-items: center; }
.timeline-dot {
  width: 12px; height: 12px;
  background: var(--red);
  border-radius: 50%;
  flex-shrink: 0; margin-top: 0.3rem;
  box-shadow: 0 0 0 3px rgba(227,30,36,0.15);
}
.timeline-line {
  width: 1px; flex: 1;
  background: var(--border-2);
  margin-top: 0.5rem; margin-bottom: -1.5rem;
}
.timeline-item:last-child .timeline-line { display: none; }
.timeline-year {
  font-size: 0.67rem; font-weight: 800;
  color: var(--red);
  text-transform: uppercase; letter-spacing: 0.08em;
  margin-bottom: 0.2rem;
}
.timeline-content h4 {
  font-weight: 800; color: var(--text-primary);
  margin-bottom: 0.3rem;
  font-size: 0.975rem; letter-spacing: -0.015em;
}
.timeline-content p { font-size: 0.845rem; color: var(--text-2); line-height: 1.65; }

/* ══ ACHIEVEMENT STATS ══ */
.achieve-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1.75rem;
}
.stat-dark {
  background: linear-gradient(155deg, var(--navy-800) 0%, var(--navy-700) 100%);
  border-radius: 20px; padding: 2rem;
  position: relative; overflow: hidden;
  box-shadow: var(--shadow-lg);
}
.stat-dark::after {
  content: '';
  position: absolute;
  bottom: -40px; right: -40px;
  width: 160px; height: 160px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(227,30,36,0.2) 0%, transparent 65%);
  pointer-events: none;
}
.stat-dark-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1.2rem;
  text-align: center;
  position: relative; z-index: 1;
}
.stat-dark-val {
  font-size: 2.1rem; font-weight: 900;
  color: #fff; line-height: 1;
  letter-spacing: -0.04em; margin-bottom: 0.3rem;
  font-variant-numeric: tabular-nums;
}
.stat-dark-val em { font-style: normal; color: var(--red); }
.stat-dark-lbl {
  font-size: 0.72rem; font-weight: 700;
  color: rgba(255,255,255,0.45);
  text-transform: uppercase; letter-spacing: 0.08em;
}

.hours-card {
  background: var(--white);
  border: 1px solid var(--border);
  border-radius: 20px;
  padding: 2rem 2.2rem;
}
.hours-title {
  display: flex; align-items: center; gap: 0.6rem;
  font-size: 1rem; font-weight: 800;
  color: var(--text-primary);
  margin-bottom: 1.5rem;
  letter-spacing: -0.015em;
}
.hours-title svg { width: 18px; height: 18px; color: var(--red); flex-shrink: 0; }
.hours-row {
  display: flex; justify-content: space-between; align-items: center;
  padding: 0.7rem 0;
  border-bottom: 1px solid var(--border);
  font-size: 0.875rem;
  color: var(--text-primary);
}
.hours-row:last-of-type { border-bottom: none; }
.hours-open   { color: #16A34A; font-weight: 700; }
.hours-closed { color: var(--red); font-weight: 700; }
.hours-note {
  display: flex; align-items: center; gap: 0.6rem;
  background: #EFF6FF;
  padding: 0.8rem 1.1rem;
  border-radius: 10px;
  margin-top: 1.2rem;
  font-size: 0.82rem;
  color: #2563EB;
  font-weight: 600;
  border: 1px solid #DBEAFE;
}
.hours-note svg { width: 14px; height: 14px; flex-shrink: 0; }

/* ══ TEAM ══ */
.team-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1.75rem;
}
.team-card {
  background: var(--white);
  border: 1px solid var(--border);
  border-radius: 20px;
  overflow: hidden;
  transition: all 0.35s var(--ease-out);
}
.team-card:hover {
  transform: translateY(-5px);
  box-shadow: var(--shadow-lg);
  border-color: transparent;
}
.team-avatar-wrap {
  background: linear-gradient(155deg, var(--navy-800) 0%, var(--navy-700) 100%);
  padding: 2.5rem;
  text-align: center;
  position: relative; overflow: hidden;
}
.team-avatar-wrap::before {
  content: '';
  position: absolute; inset: 0;
  background-image: radial-gradient(circle, rgba(255,255,255,0.04) 1px, transparent 1px);
  background-size: 24px 24px;
}
.team-avatar {
  position: relative; z-index: 1;
  display: inline-flex;
  width: 96px; height: 96px;
  background: rgba(255,255,255,0.1);
  border-radius: 50%;
  font-size: 2.2rem; font-weight: 900;
  color: #fff;
  align-items: center; justify-content: center;
  border: 2px solid rgba(255,255,255,0.18);
  box-shadow: 0 8px 24px rgba(0,0,0,0.2);
  letter-spacing: -0.02em;
}
.team-info { padding: 1.7rem 1.8rem; text-align: center; }
.team-info h4 {
  font-size: 1.1rem; font-weight: 800;
  margin-bottom: 0.4rem;
  color: var(--text-primary); letter-spacing: -0.02em;
}
.team-role {
  display: inline-block;
  background: rgba(227,30,36,0.08);
  color: var(--red);
  font-size: 0.68rem; font-weight: 800;
  padding: 0.25rem 0.85rem;
  border-radius: 99px;
  margin-bottom: 0.9rem;
  border: 1px solid rgba(227,30,36,0.14);
  letter-spacing: 0.04em;
  text-transform: uppercase;
}
.team-info p { font-size: 0.855rem; color: var(--text-2); line-height: 1.7; }

/* ══ PILLARS ══ */
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
  letter-spacing: -0.05em; line-height: 1;
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
  background: var(--red); color: #fff;
  transform: scale(1.06);
  box-shadow: 0 8px 24px rgba(227,30,36,0.3);
}
.pillar-icon svg { width: 26px; height: 26px; }
.pillar h3 {
  font-size: 1.1rem; font-weight: 800;
  color: var(--text-primary);
  letter-spacing: -0.02em;
  margin-bottom: 0.7rem; line-height: 1.25;
}
.pillar p { font-size: 0.875rem; color: var(--text-2); line-height: 1.75; }

/* ══ CTA ══ */
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
  font-weight: 900; color: #fff;
  letter-spacing: -0.035em; line-height: 1.12;
  margin-bottom: 1rem;
}
.cta-title span { color: var(--red); }
.cta-desc {
  color: rgba(255,255,255,0.5);
  font-size: 0.975rem; line-height: 1.75;
  max-width: 520px; margin-bottom: 2.4rem;
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
.cta-pills {
  position: relative; z-index: 1;
  display: flex; flex-direction: column; gap: 1rem;
}
.cta-pill {
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,255,255,0.1);
  border-radius: 16px;
  padding: 1.4rem 1.8rem;
  text-align: center;
  backdrop-filter: blur(12px);
  transition: all 0.25s;
}
.cta-pill:hover {
  background: rgba(255,255,255,0.08);
  border-color: rgba(255,255,255,0.18);
}
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

/* ══ RESPONSIVE ══ */
@media (max-width: 1200px) { .story-grid { gap: 3rem; } }
@media (max-width: 1024px) {
  .mv-grid { grid-template-columns: 1fr; }
  .pillars { grid-template-columns: repeat(2, 1fr); }
  .team-grid { grid-template-columns: repeat(2, 1fr); }
  .cta-inner { grid-template-columns: 1fr; padding: 4rem 3.5rem; }
  .cta-pills { flex-direction: row; justify-content: flex-start; }
  .achieve-grid { grid-template-columns: 1fr; }
}
@media (max-width: 860px) {
  .hero-inner { padding: 5rem 0 4rem; }
  .hero-stats-strip { grid-template-columns: repeat(2, 1fr); }
  .hero-stat:nth-child(3)::before,
  .hero-stat:nth-child(4)::before { display: none; }
  .story-grid { grid-template-columns: 1fr; gap: 2.5rem; }
  .bento { grid-template-columns: 1fr; }
  .b-4, .b-6 { grid-column: span 1; }
  .pillars { grid-template-columns: 1fr; }
  .team-grid { grid-template-columns: 1fr; }
  .cta-inner { padding: 3.5rem 2.5rem; }
  .cta-pills { display: none; }
}
@media (max-width: 600px) {
  .hp .container { padding: 0 1.25rem; }
  .hero-stats-strip { grid-template-columns: 1fr 1fr; }
  .section { padding: 5rem 0; }
  .cta-inner { padding: 3rem 1.75rem; }
  .cta-btns { flex-direction: column; }
  .cta-btn-primary, .cta-btn-outline { justify-content: center; }
  .mv-grid { grid-template-columns: 1fr; }
}

@keyframes live-pulse {
  0%, 100% { opacity: 1; transform: scale(1); }
  50%       { opacity: 0.45; transform: scale(0.75); }
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

        <div class="hero-badge reveal">
          <div class="hero-badge-dot">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <circle cx="12" cy="12" r="10"/>
              <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
            </svg>
          </div>
          <span>Tentang Kami</span>
        </div>

        <h1 class="hero-heading reveal reveal-d1">
          <span class="word-plain">Perjalanan</span>
          <span class="word-serif">Indo Cahaya Express</span>
          <span class="word-dim">Menghubungkan Indonesia ke Dunia</span>
        </h1>

        <p class="hero-desc reveal reveal-d2">
          Berdiri sejak 2020, ICE telah berkembang menjadi mitra logistik terpercaya untuk ribuan bisnis di Indonesia, mengirimkan paket ke lebih dari 200 negara dengan layanan door-to-door yang andal.
        </p>

        <div class="hero-actions reveal reveal-d3">
          <a href="{{ route('book') }}" class="btn-hero-primary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 7h13M10 21a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm7 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
            </svg>
            Mulai Kirim
          </a>
          <a href="{{ route('customer-service') }}" class="btn-hero-ghost">
            <div class="icon-ring">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M5 12h14M12 5l7 7-7 7"/>
              </svg>
            </div>
            Hubungi Kami
          </a>
        </div>

        <div class="hero-stats-strip reveal reveal-d4">
          <div class="hero-stat">
            <div class="hero-stat-num">2020</div>
            <div class="hero-stat-label">Berdiri Sejak</div>
          </div>
          <div class="hero-stat">
            <div class="hero-stat-num"><span class="counter" data-target="200">0</span><em>+</em></div>
            <div class="hero-stat-label">Negara Tujuan</div>
          </div>
          <div class="hero-stat">
            <div class="hero-stat-num"><span class="counter" data-target="10000">0</span><em>+</em></div>
            <div class="hero-stat-label">Pengiriman Sukses</div>
          </div>
          <div class="hero-stat">
            <div class="hero-stat-num"><span class="counter" data-target="99">0</span><em>%</em></div>
            <div class="hero-stat-label">Kepuasan Pelanggan</div>
          </div>
        </div>

      </div>
    </div>
  </section>

  {{-- ══ CERITA KAMI ══ --}}
  <section class="section section-soft">
    <div class="container">
      <div class="story-grid">
        <div class="story-visual reveal-left">
          <div class="story-visual-grid"></div>
          <div class="story-visual-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
              <rect x="1" y="3" width="15" height="13" rx="1"/>
              <path d="M16 8h4l3 5v3h-7V8z"/>
              <circle cx="5.5" cy="18.5" r="2.5"/>
              <circle cx="18.5" cy="18.5" r="2.5"/>
            </svg>
          </div>
          <h3>Indo Cahaya Express</h3>
          <p>Jasa Pengiriman Internasional Terpercaya</p>
          <div class="story-year-badge">
            <strong>2020</strong>
            <span>Berdiri Sejak</span>
          </div>
        </div>
        <div class="story-text reveal-right">
          <span class="section-label">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
            Cerita Kami
          </span>
          <h2>Cerita di Balik<br>Indo Cahaya Express</h2>
          <p>Indo Cahaya Express (ICE) berdiri pada tahun 2020, berawal dari kebutuhan para pelaku bisnis online di Indonesia yang kesulitan menemukan jasa pengiriman internasional yang terpercaya, transparan, dan terjangkau.</p>
          <p>Kami memulai dengan melayani rute Indonesia–Malaysia dan terus berkembang hingga kini melayani lebih dari 200 negara di seluruh dunia. Dengan tim yang berpengalaman di bidang logistik internasional, kami berkomitmen untuk memberikan layanan terbaik kepada setiap pelanggan.</p>
          <p>Kepercayaan Anda adalah fondasi utama kami. Setiap paket yang dipercayakan kepada ICE ditangani dengan standar keamanan tertinggi dan dipantau secara real-time dari pintu ke pintu.</p>
        </div>
      </div>
    </div>
  </section>

  {{-- ══ MISI & VISI ══ --}}
  <section class="section section-alt">
    <div class="container">
      <div class="section-center reveal">
        <span class="section-label">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <circle cx="12" cy="12" r="10"/>
            <path d="M12 8v4l3 3"/>
          </svg>
          Arah & Tujuan
        </span>
        <h2 class="section-heading">Misi & Visi</h2>
        <p class="section-sub">Arah dan tujuan yang mendasari setiap langkah kami menuju layanan global</p>
      </div>
      <div class="mv-grid">
        <div class="mv-card reveal reveal-d1">
          <div class="mv-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10"/>
              <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
            </svg>
          </div>
          <h3>Visi Kami</h3>
          <p>Menjadi jasa pengiriman internasional nomor satu dari Indonesia yang diakui secara global karena keandalan, kecepatan, dan kepercayaan.</p>
          <ul class="mv-list">
            <li>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
              Jangkauan 200+ negara di 2030
            </li>
            <li>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
              Pemimpin pasar dari Indonesia
            </li>
            <li>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
              Teknologi tracking terdepan
            </li>
          </ul>
        </div>
        <div class="mv-card reveal reveal-d2">
          <div class="mv-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
          </div>
          <h3>Misi Kami</h3>
          <p>Memberikan layanan pengiriman internasional yang cepat, aman, dan transparan dengan harga terjangkau untuk semua kalangan.</p>
          <ul class="mv-list">
            <li>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
              Layanan pelanggan 7 hari seminggu
            </li>
            <li>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
              Tarif transparan tanpa biaya tersembunyi
            </li>
            <li>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
              Inovasi teknologi berkelanjutan
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  {{-- ══ NILAI-NILAI KAMI ══ --}}
  <section class="section section-soft">
    <div class="container">
      <div class="section-center reveal">
        <span class="section-label">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
          </svg>
          Prinsip Kami
        </span>
        <h2 class="section-heading">Nilai-Nilai Kami</h2>
        <p class="section-sub">Prinsip yang kami pegang teguh dalam setiap pelayanan kepada pelanggan</p>
      </div>
      <div class="bento reveal reveal-d1">
        <div class="b-card b-4">
          <div class="b-num">01</div>
          <div class="b-icon b-icon-red">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
          </div>
          <h3>Kepercayaan</h3>
          <p>Setiap paket adalah tanggung jawab kami. Kami tidak kompromi soal keamanan dan kejujuran dalam setiap layanan.</p>
        </div>
        <div class="b-card b-4">
          <div class="b-num">02</div>
          <div class="b-icon b-icon-red">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
            </svg>
          </div>
          <h3>Kecepatan</h3>
          <p>Inovasi terus-menerus memastikan paket tiba secepat mungkin ke tujuan dengan estimasi yang akurat.</p>
        </div>
        <div class="b-card b-4">
          <div class="b-num">03</div>
          <div class="b-icon b-icon-red">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10"/>
              <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
            </svg>
          </div>
          <h3>Jangkauan Global</h3>
          <p>Jaringan mitra tersebar di seluruh dunia untuk pengiriman ke manapun tanpa batasan wilayah.</p>
        </div>
        <div class="b-card b-4">
          <div class="b-num">04</div>
          <div class="b-icon b-icon-navy">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
              <circle cx="9" cy="7" r="4"/>
              <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
          </div>
          <h3>Fokus Pelanggan</h3>
          <p>Kepuasan Anda prioritas utama. Tim CS kami siap membantu kapanpun Anda membutuhkan bantuan.</p>
        </div>
        <div class="b-card b-4">
          <div class="b-num">05</div>
          <div class="b-icon b-icon-navy">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
            </svg>
          </div>
          <h3>Transparansi</h3>
          <p>Harga jelas, tracking transparan — tidak ada biaya tersembunyi di setiap proses pengiriman.</p>
        </div>
        <div class="b-card b-4">
          <div class="b-num">06</div>
          <div class="b-icon b-icon-navy">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
            </svg>
          </div>
          <h3>Kualitas Tinggi</h3>
          <p>Standar internasional dari packaging hingga pengiriman akhir ke tangan penerima.</p>
        </div>
      </div>
    </div>
  </section>

  {{-- ══ TIMELINE & PENCAPAIAN ══ --}}
  <section class="section section-alt">
    <div class="container">
      <div class="section-center reveal">
        <span class="section-label">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
            <line x1="16" y1="2" x2="16" y2="6"/>
            <line x1="8" y1="2" x2="8" y2="6"/>
            <line x1="3" y1="10" x2="21" y2="10"/>
          </svg>
          Milestone
        </span>
        <h2 class="section-heading">Perjalanan Kami</h2>
        <p class="section-sub">Langkah demi langkah menuju layanan global yang lebih baik</p>
      </div>
      <div class="story-grid">
        <div class="timeline-wrap reveal-left">
          <div class="timeline-item">
            <div class="timeline-left">
              <div class="timeline-dot"></div>
              <div class="timeline-line"></div>
            </div>
            <div class="timeline-content">
              <div class="timeline-year">2020</div>
              <h4>Pendirian Perusahaan</h4>
              <p>Melayani rute Indonesia–Malaysia dengan 2 tim yang berdedikasi penuh.</p>
            </div>
          </div>
          <div class="timeline-item">
            <div class="timeline-left">
              <div class="timeline-dot"></div>
              <div class="timeline-line"></div>
            </div>
            <div class="timeline-content">
              <div class="timeline-year">2021</div>
              <h4>Ekspansi ke 15 Negara</h4>
              <p>Asia Tenggara & Asia Timur, tim berkembang menjadi 8 orang.</p>
            </div>
          </div>
          <div class="timeline-item">
            <div class="timeline-left">
              <div class="timeline-dot"></div>
              <div class="timeline-line"></div>
            </div>
            <div class="timeline-content">
              <div class="timeline-year">2022</div>
              <h4>Sistem Tracking Real-Time</h4>
              <p>Peluncuran platform tracking online yang tersedia 24/7 untuk semua pelanggan.</p>
            </div>
          </div>
          <div class="timeline-item">
            <div class="timeline-left">
              <div class="timeline-dot"></div>
              <div class="timeline-line"></div>
            </div>
            <div class="timeline-content">
              <div class="timeline-year">2023</div>
              <h4>Layanan Express Premium</h4>
              <p>Peluncuran priority shipping dengan jaringan Eropa & Amerika Serikat.</p>
            </div>
          </div>
          <div class="timeline-item">
            <div class="timeline-left">
              <div class="timeline-dot"></div>
              <div class="timeline-line"></div>
            </div>
            <div class="timeline-content">
              <div class="timeline-year">2024–Kini</div>
              <h4>50+ Negara, 10.000+ Pengiriman</h4>
              <p>Melayani lebih dari 200 negara di seluruh dunia dengan kepuasan 99%.</p>
            </div>
          </div>
        </div>
        <div class="reveal-right">
          <span class="section-label">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <line x1="18" y1="20" x2="18" y2="10"/>
              <line x1="12" y1="20" x2="12" y2="4"/>
              <line x1="6" y1="20" x2="6" y2="14"/>
            </svg>
            Statistik
          </span>
          <h2 class="section-heading" style="margin-bottom:0.6rem;">Pencapaian Kami</h2>
          <p class="section-sub" style="margin-bottom:2rem;">Angka yang membuktikan komitmen kami kepada pelanggan</p>
          <div class="achieve-grid">
            <div class="stat-dark">
              <div class="stat-dark-grid">
                <div>
                  <div class="stat-dark-val">10K<em>+</em></div>
                  <div class="stat-dark-lbl">Pengiriman</div>
                </div>
                <div>
                  <div class="stat-dark-val">50<em>+</em></div>
                  <div class="stat-dark-lbl">Negara</div>
                </div>
                <div>
                  <div class="stat-dark-val">5<em>+</em></div>
                  <div class="stat-dark-lbl">Tahun</div>
                </div>
                <div>
                  <div class="stat-dark-val">99<em>%</em></div>
                  <div class="stat-dark-lbl">Kepuasan</div>
                </div>
              </div>
            </div>
            <div class="hours-card">
              <div class="hours-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <circle cx="12" cy="12" r="10"/>
                  <polyline points="12 6 12 12 16 14"/>
                </svg>
                Jam Operasional
              </div>
              <div class="hours-row">
                <span>Senin – Jumat</span>
                <span class="hours-open">08.00 – 17.00 WIB</span>
              </div>
              <div class="hours-row">
                <span>Sabtu</span>
                <span class="hours-open">08.00 – 14.00 WIB</span>
              </div>
              <div class="hours-row">
                <span>Minggu & Libur</span>
                <span class="hours-closed">Tutup</span>
              </div>
              <div class="hours-note">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
                WhatsApp tersedia 7 hari seminggu
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- ══ KEUNGGULAN KAMI ══ --}}
  <section class="section section-soft">
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
              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
          </div>
          <h3>Jaminan Keamanan</h3>
          <p>Setiap paket dilindungi asuransi penuh dengan standar penanganan internasional. Kompensasi penuh jika terjadi kerusakan atau kehilangan.</p>
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
          <p>Jaringan pengiriman ke 200+ negara dengan mitra logistik terpercaya di setiap wilayah. Tidak ada destinasi yang terlalu jauh untuk kami.</p>
        </div>
        <div class="pillar reveal reveal-d3">
          <div class="pillar-count">03</div>
          <div class="pillar-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
            </svg>
          </div>
          <h3>CS Responsif 7 Hari</h3>
          <p>Tim customer service kami siap membantu kapan saja — mulai dari konsultasi tarif hingga penanganan klaim dan proses bea cukai.</p>
        </div>
      </div>
    </div>
  </section>

  {{-- ══ TIM KAMI ══ --}}
  <section class="section section-alt">
    <div class="container">
      <div class="section-center reveal">
        <span class="section-label">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
          </svg>
          Tim Kami
        </span>
        <h2 class="section-heading">Orang-Orang di Balik ICE</h2>
        <p class="section-sub">Tim berdedikasi yang memastikan setiap pengiriman berjalan sempurna dari awal hingga akhir</p>
      </div>
      <div class="team-grid">
        <div class="team-card reveal reveal-d1">
          <div class="team-avatar-wrap">
            <div class="team-avatar">M</div>
          </div>
          <div class="team-info">
            <h4>Mauladani</h4>
            <div class="team-role">Founder & CEO</div>
            <p>Memimpin ICE sejak 2020 dengan visi membawa logistik Indonesia ke kancah global yang lebih kompetitif.</p>
          </div>
        </div>
        <div class="team-card reveal reveal-d2">
          <div class="team-avatar-wrap">
            <div class="team-avatar">A</div>
          </div>
          <div class="team-info">
            <h4>Andril</h4>
            <div class="team-role">Operations Manager</div>
            <p>Memastikan setiap pengiriman berjalan lancar dari proses pickup hingga delivery ke tangan penerima.</p>
          </div>
        </div>
        <div class="team-card reveal reveal-d3">
          <div class="team-avatar-wrap">
            <div class="team-avatar">R</div>
          </div>
          <div class="team-info">
            <h4>Rania</h4>
            <div class="team-role">Customer Service Lead</div>
            <p>Memimpin tim CS yang siap membantu pelanggan dengan cepat, ramah, dan profesional setiap saat.</p>
          </div>
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
            <svg viewBox="0 0 24 24" fill="currentColor">
              <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
            </svg>
            Mulai Sekarang
          </div>
          <h2 class="cta-title">Siap Kirim ke <span>Seluruh Dunia?</span></h2>
          <p class="cta-desc">Bergabung dengan ribuan pelanggan yang sudah mempercayakan pengiriman internasional mereka kepada Indo Cahaya Express.</p>
          <div class="cta-btns">
            <a href="{{ route('book') }}" class="cta-btn-primary">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 7h13M10 21a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm7 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
              </svg>
              Booking Sekarang
            </a>
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
            <div class="cta-pill-num">10K<em>+</em></div>
            <div class="cta-pill-label">Pengiriman</div>
          </div>
          <div class="cta-pill">
            <div class="cta-pill-num">50<em>+</em></div>
            <div class="cta-pill-label">Negara</div>
          </div>
          <div class="cta-pill">
            <div class="cta-pill-num">99<em>%</em></div>
            <div class="cta-pill-label">Kepuasan</div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>{{-- /hp --}}

<script>
/* ── Scroll Reveal ── */
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

/* ── Counter Animation ── */
document.addEventListener('DOMContentLoaded', () => {
  const counters = document.querySelectorAll('.counter');
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      const el     = entry.target;
      const target = +el.getAttribute('data-target');
      const step   = target / (1800 / 16);
      let current  = 0;
      const timer  = setInterval(() => {
        current = Math.min(current + step, target);
        el.textContent = Math.floor(current).toLocaleString('id-ID');
        if (current >= target) clearInterval(timer);
      }, 16);
      observer.unobserve(el);
    });
  }, { threshold: 0.5 });
  counters.forEach(c => observer.observe(c));
});
</script>

@endsection
