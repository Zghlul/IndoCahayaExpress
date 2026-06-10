<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $globalSettings['site_name'] ?? 'Indo Cahaya Express' }}</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
  <script src="{{ asset('js/app.js') }}?v={{ time() }}"></script>
  <style>
    /* ══ RESET & TOKENS ══ */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    /* ══ GLOBAL OVERFLOW & SCROLLBAR FIX ══ */
    html, body {
      scrollbar-width: none;
      -ms-overflow-style: none;
    }
    html::-webkit-scrollbar,
    body::-webkit-scrollbar { width: 0; height: 0; display: none; }

    .site-header,
    .site-header *:not(.dd-panel) {
      transform: none !important;
    }
    .site-header { overflow: visible !important; }

    :root {
      /* Brand */
      --ice-red:         #E31E24;
      --ice-red-dark:    #C7181D;
      --ice-red-deep:    #A0121A;
      --ice-red-glow:    rgba(227,30,36,0.22);

      /* Navy spectrum */
      --ice-navy:        #060F2E;
      --ice-navy-mid:    #0A1A4A;
      --ice-navy-600:    #102B78;
      --ice-navy-500:    #1438A0;

      /* Surfaces – semi-transparent dark */
      --ice-surface:     rgba(6,15,46,0.92);
      --ice-surface-alt: rgba(10,26,74,0.80);
      --ice-surface-2:   rgba(16,43,120,0.25);
      --ice-surface-3:   rgba(255,255,255,0.06);

      /* Glass */
      --ice-glass:       rgba(255,255,255,0.05);
      --ice-glass-2:     rgba(255,255,255,0.08);
      --ice-glass-border: rgba(255,255,255,0.10);
      --ice-glass-border-2: rgba(255,255,255,0.15);

      /* Text */
      --ice-text:        #FFFFFF;
      --ice-text-2:      rgba(255,255,255,0.75);
      --ice-text-muted:  rgba(255,255,255,0.45);
      --ice-text-faint:  rgba(255,255,255,0.25);

      /* Borders */
      --ice-border:      rgba(255,255,255,0.08);
      --ice-border-2:    rgba(255,255,255,0.14);

      /* Radius */
      --ice-radius-sm:   6px;
      --ice-radius:      10px;
      --ice-radius-lg:   14px;
      --ice-radius-xl:   20px;

      /* Shadows */
      --ice-shadow-xs:   0 1px 4px rgba(0,0,0,0.3);
      --ice-shadow-sm:   0 2px 8px rgba(0,0,0,0.35);
      --ice-shadow:      0 8px 24px rgba(0,0,0,0.40);
      --ice-shadow-lg:   0 16px 48px rgba(0,0,0,0.45);
      --ice-shadow-xl:   0 32px 80px rgba(0,0,0,0.50);

      /* Easing */
      --ease-out:        cubic-bezier(0.22, 1, 0.36, 1);
      --ease-spring:     cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    html { scroll-behavior: smooth; }
    body {
      font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
      color: var(--ice-text);
      background: var(--ice-navy);
      background-image:
        radial-gradient(ellipse 80% 60% at 20% 0%, rgba(20,56,160,0.55) 0%, transparent 60%),
        radial-gradient(ellipse 60% 40% at 80% 10%, rgba(227,30,36,0.18) 0%, transparent 50%),
        radial-gradient(ellipse 100% 80% at 50% 100%, rgba(10,26,74,0.7) 0%, transparent 70%);
      min-height: 100vh;
      line-height: 1.6;
      width: 100%;
    }

    /* ══ HEADER ══ */
    .site-header {
      position: sticky;
      top: 0;
      z-index: 500;
      width: 100%;
      background: rgba(6,15,46,0.75);
      backdrop-filter: blur(24px) saturate(160%);
      -webkit-backdrop-filter: blur(24px) saturate(160%);
      border-bottom: 1px solid var(--ice-glass-border);
      box-shadow: 0 1px 0 rgba(255,255,255,0.05), 0 4px 32px rgba(0,0,0,0.3);
    }

    /* Top accent line */
    .site-header::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 2px;
      background: linear-gradient(90deg, var(--ice-navy-mid) 0%, var(--ice-red) 50%, var(--ice-navy-mid) 100%);
    }

    .header-inner {
      max-width: 1440px;
      width: 100%;
      margin: 0 auto;
      padding: 0 2rem;
      display: flex;
      align-items: center;
      height: 68px;
      gap: 1rem;
    }

    /* Brand */
    .header-brand {
      display: flex;
      align-items: center;
      gap: 0.7rem;
      text-decoration: none;
      flex-shrink: 0;
      min-width: 0;
    }
    .header-brand img {
      height: 38px;
      width: auto;
      transition: filter 0.3s ease;
    }
    .header-brand:hover img {
      filter: drop-shadow(0 0 12px rgba(227, 30, 36, 0.8))
              drop-shadow(0 0 30px rgba(227, 30, 36, 0.5))
              drop-shadow(0 2px 4px rgba(0,0,0,0.15));
    }
    .brand-text-wrap { display: flex; flex-direction: column; min-width: 0; }
    .brand-name {
      font-size: 0.92rem;
      font-weight: 900;
      color: #fff;
      letter-spacing: 0.02em;
      line-height: 1.15;
      white-space: nowrap;
    }
    .brand-tagline {
      font-size: 0.57rem;
      font-weight: 700;
      color: var(--ice-text-muted);
      text-transform: uppercase;
      letter-spacing: 0.1em;
      white-space: nowrap;
    }

    /* Main Nav */
    .header-nav {
      display: flex;
      align-items: center;
      gap: 0.1rem;
      margin-left: auto;
      flex-shrink: 1;
      min-width: 0;
    }
    .nav-link {
      display: inline-flex;
      align-items: center;
      gap: 0.35rem;
      font-size: 0.84rem;
      font-weight: 600;
      color: var(--ice-text-2);
      text-decoration: none;
      padding: 0.45rem 0.75rem;
      border-radius: var(--ice-radius-sm);
      transition: all 0.2s var(--ease-out);
      position: relative;
      white-space: nowrap;
    }
    .nav-link:hover {
      color: #fff;
      background: var(--ice-glass-2);
    }
    .nav-link.active {
      color: #fff;
      background: rgba(227,30,36,0.15);
      font-weight: 700;
    }
    .nav-link.active::after {
      content: '';
      position: absolute;
      bottom: -1px;
      left: 50%;
      transform: translateX(-50%);
      width: 18px;
      height: 2px;
      background: var(--ice-red);
      border-radius: 2px;
    }

    /* Actions area */
    .header-actions {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      flex-shrink: 0;
      margin-left: 0.5rem;
    }

    /* Book / Ship Now CTA */
    .btn-book {
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      background: var(--ice-red);
      color: #fff !important;
      font-size: 0.8rem;
      font-weight: 700;
      padding: 0.52rem 1rem;
      border-radius: var(--ice-radius-sm);
      text-decoration: none;
      transition: all 0.25s var(--ease-out);
      border: none;
      cursor: pointer;
      box-shadow: 0 4px 16px rgba(227,30,36,0.4), inset 0 1px 0 rgba(255,255,255,0.15);
      font-family: 'Plus Jakarta Sans', sans-serif;
      letter-spacing: 0.01em;
      white-space: nowrap;
      flex-shrink: 0;
    }
    .btn-book svg { width: 14px; height: 14px; flex-shrink: 0; }
    .btn-book:hover {
      background: var(--ice-red-dark);
      transform: translateY(-1px);
      box-shadow: 0 8px 24px rgba(227,30,36,0.5);
    }
    .btn-book:active { transform: translateY(0); }

    /* Login Button */
    .btn-login {
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      font-size: 0.8rem;
      font-weight: 700;
      color: rgba(255,255,255,0.9);
      background: var(--ice-glass);
      border: 1.5px solid var(--ice-glass-border-2);
      border-radius: var(--ice-radius-sm);
      padding: 0.5rem 0.9rem;
      text-decoration: none;
      transition: all 0.2s var(--ease-out);
      white-space: nowrap;
      flex-shrink: 0;
      backdrop-filter: blur(8px);
    }
    .btn-login svg { width: 14px; height: 14px; flex-shrink: 0; }
    .btn-login:hover {
      background: rgba(255,255,255,0.12);
      color: #fff;
      border-color: rgba(255,255,255,0.25);
    }

    /* ── Dropdown base ── */
    .dd-wrap {
      position: relative;
      display: inline-flex;
      align-items: center;
    }
    .dd-trigger {
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      font-size: 0.8rem;
      font-weight: 700;
      padding: 0.48rem 0.85rem;
      border-radius: var(--ice-radius-sm);
      cursor: pointer;
      border: 1.5px solid;
      transition: all 0.2s var(--ease-out);
      font-family: 'Plus Jakarta Sans', sans-serif;
      white-space: nowrap;
      user-select: none;
      flex-shrink: 0;
    }
    .dd-trigger svg { width: 13px; height: 13px; transition: transform 0.2s; }
    .dd-trigger.admin-style {
      background: rgba(255,255,255,0.07);
      border-color: rgba(255,255,255,0.12);
      color: rgba(255,255,255,0.85);
    }
    .dd-trigger.admin-style:hover {
      background: rgba(255,255,255,0.12);
      border-color: rgba(255,255,255,0.2);
      color: #fff;
    }
    .dd-trigger.dev-style {
      background: rgba(20,56,160,0.5);
      border-color: rgba(255,255,255,0.15);
      color: #fff;
      box-shadow: 0 4px 12px rgba(0,0,0,0.3);
      backdrop-filter: blur(8px);
    }
    .dd-trigger.dev-style:hover {
      background: rgba(20,56,160,0.7);
      transform: translateY(-1px);
    }

    /* Dropdown panel */
    .dd-panel {
      display: none;
      position: absolute;
      top: calc(100% + 10px);
      right: 0;
      background: rgba(6,15,46,0.92);
      backdrop-filter: blur(24px) saturate(160%);
      -webkit-backdrop-filter: blur(24px) saturate(160%);
      border: 1px solid var(--ice-glass-border-2);
      border-radius: var(--ice-radius-lg);
      box-shadow: 0 24px 60px rgba(0,0,0,0.5), inset 0 1px 0 rgba(255,255,255,0.08);
      z-index: 999;
      overflow: hidden;
    }
    .dd-panel.is-open {
      display: block;
      animation: ddIn 0.22s cubic-bezier(0.34,1.56,0.64,1) forwards;
      transform-origin: top right;
    }
    @keyframes ddIn {
      from { opacity: 0; transform: translateY(-8px) scale(0.95); }
      to   { opacity: 1; transform: translateY(0)   scale(1); }
    }

    /* Dropdown internals */
    .dd-admin   { min-width: 220px; padding: 6px 0; }
    .dd-dev     { min-width: 260px; padding: 0; }
    .dd-profile { min-width: 240px; padding: 0; }

    .dd-section-head {
      display: flex;
      align-items: center;
      gap: 0.6rem;
      padding: 12px 16px;
      background: rgba(255,255,255,0.05);
      border-bottom: 1px solid rgba(255,255,255,0.08);
    }
    .dd-section-head span {
      font-size: 0.68rem;
      font-weight: 800;
      color: rgba(255,255,255,0.9);
      text-transform: uppercase;
      letter-spacing: 0.1em;
    }
    .dd-section-head svg { width: 14px; height: 14px; color: rgba(255,255,255,0.65); }

    .dd-label {
      font-size: 0.6rem;
      font-weight: 800;
      color: var(--ice-text-muted);
      text-transform: uppercase;
      letter-spacing: 0.1em;
      padding: 10px 16px 4px;
    }
    .dd-item {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      padding: 9px 16px;
      font-size: 0.85rem;
      font-weight: 600;
      color: var(--ice-text-2);
      text-decoration: none;
      transition: all 0.15s;
      white-space: nowrap;
    }
    .dd-item:hover { background: rgba(227,30,36,0.12); color: #fff; }
    .dd-item:hover svg { color: var(--ice-red); }
    .dd-item svg { width: 15px; height: 15px; color: var(--ice-text-muted); flex-shrink: 0; transition: color 0.15s; }
    .dd-item.active { background: rgba(227,30,36,0.12); color: #fff; font-weight: 700; }
    .dd-sep { height: 1px; background: rgba(255,255,255,0.07); margin: 4px 0; }

    /* Profile header */
    .profile-header {
      padding: 14px 16px 12px;
      background: rgba(255,255,255,0.05);
      border-bottom: 1px solid rgba(255,255,255,0.07);
      display: flex;
      align-items: flex-start;
      gap: 0.85rem;
    }
    .profile-header-avatar {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: rgba(227,30,36,0.2);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.875rem;
      font-weight: 800;
      color: #fff;
      flex-shrink: 0;
      border: 1.5px solid rgba(227,30,36,0.4);
    }
    .profile-header-info { flex: 1; min-width: 0; }
    .profile-header-label {
      font-size: 0.6rem;
      font-weight: 700;
      color: var(--ice-text-muted);
      text-transform: uppercase;
      letter-spacing: 0.08em;
    }
    .profile-header-name {
      font-size: 0.9rem;
      font-weight: 800;
      color: #fff;
      margin-top: 2px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    .role-badge {
      display: inline-block;
      margin-top: 6px;
      font-size: 0.62rem;
      font-weight: 700;
      padding: 2px 8px;
      border-radius: 99px;
    }
    .role-dev    { background: rgba(139,92,246,0.2); color: #c4b5fd; border: 1px solid rgba(139,92,246,0.3); }
    .role-admin  { background: rgba(59,130,246,0.2); color: #93c5fd; border: 1px solid rgba(59,130,246,0.3); }
    .role-owner  { background: rgba(245,158,11,0.2); color: #fcd34d; border: 1px solid rgba(245,158,11,0.3); }
    .role-member { background: rgba(255,255,255,0.1); color: rgba(255,255,255,0.8); border: 1px solid rgba(255,255,255,0.15); }

    .dd-item-danger { color: #f87171 !important; }
    .dd-item-danger svg { color: #f87171 !important; }
    .dd-item-danger:hover { background: rgba(239,68,68,0.12) !important; color: #fca5a5 !important; }

    .dd-item-ship {
      background: var(--ice-red) !important;
      color: #fff !important;
      margin: 8px;
      border-radius: var(--ice-radius-sm);
      justify-content: center;
      font-size: 0.82rem;
      box-shadow: 0 4px 16px rgba(227,30,36,0.4);
    }
    .dd-item-ship svg { color: #fff !important; }
    .dd-item-ship:hover {
      background: var(--ice-red-dark) !important;
      transform: translateY(-1px);
    }
    .dd-profile-body { padding: 6px 0; }
    .dd-panel.dd-profile { padding-bottom: 6px; }

    /* User avatar button */
    .user-avatar-btn {
      width: 34px;
      height: 34px;
      border-radius: 50%;
      background: rgba(227,30,36,0.2);
      color: #fff;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 0.82rem;
      font-weight: 800;
      cursor: pointer;
      text-transform: uppercase;
      border: 2px solid rgba(227,30,36,0.4);
      box-shadow: var(--ice-shadow-sm);
      transition: all 0.2s var(--ease-out);
      flex-shrink: 0;
    }
    .user-avatar-btn:hover {
      transform: scale(1.05);
      box-shadow: 0 0 0 3px rgba(227,30,36,0.3);
      border-color: var(--ice-red);
    }

    /* Flash */
    #flash-notif {
      position: fixed;
      top: 88px;
      right: 1.5rem;
      z-index: 9999;
      display: flex;
      align-items: flex-start;
      gap: 0.75rem;
      background: rgba(6,15,46,0.88);
      backdrop-filter: blur(20px);
      border: 1px solid var(--ice-glass-border-2);
      border-radius: var(--ice-radius-lg);
      padding: 1rem 1.25rem;
      box-shadow: var(--ice-shadow-lg);
      min-width: 280px;
      max-width: 380px;
    }

    /* Mobile toggle */
    .nav-toggle {
      display: none;
      width: 34px;
      height: 34px;
      border: 1.5px solid var(--ice-glass-border-2);
      border-radius: var(--ice-radius-sm);
      background: var(--ice-glass);
      cursor: pointer;
      align-items: center;
      justify-content: center;
      color: rgba(255,255,255,0.8);
      transition: all 0.2s;
      flex-shrink: 0;
    }
    .nav-toggle:hover { background: var(--ice-glass-2); color: #fff; }
    .nav-toggle svg { width: 18px; height: 18px; }

    /* Animations */
    @keyframes flashIn  { from { opacity:0; transform:translateX(60px); }  to { opacity:1; transform:translateX(0); } }
    @keyframes flashOut { from { opacity:1; transform:translateX(0); }     to { opacity:0; transform:translateX(60px); } }

    /* ══ FOOTER ══ */
    .site-footer {
      background: rgba(4,10,30,0.85);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      color: rgba(255,255,255,0.55);
      padding: 5rem 0 0;
      margin-top: 6rem;
      position: relative;
      overflow: hidden;
      width: 100%;
      border-top: 1px solid rgba(255,255,255,0.07);
    }
    .site-footer::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 3px;
      background: linear-gradient(90deg, transparent 0%, var(--ice-red) 40%, transparent 100%);
    }
    .site-footer::after {
      content: '';
      position: absolute;
      inset: 0;
      background-image:
        linear-gradient(rgba(255,255,255,0.012) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.012) 1px, transparent 1px);
      background-size: 60px 60px;
      pointer-events: none;
    }
    .footer-inner {
      max-width: 1440px;
      width: 100%;
      margin: 0 auto;
      padding: 0 2rem;
      position: relative;
      z-index: 1;
    }
    .footer-grid {
      display: grid;
      grid-template-columns: 2fr 1fr 1fr 1.5fr;
      gap: 3.5rem;
      padding-bottom: 3.5rem;
    }
    .footer-brand-logo {
      display: flex;
      align-items: center;
      gap: 0.65rem;
      margin-bottom: 1.2rem;
      text-decoration: none;
    }
    .footer-brand-logo img { height: 34px; filter: brightness(1.2); }
    .footer-brand-name {
      font-size: 0.92rem;
      font-weight: 900;
      color: #fff;
      letter-spacing: 0.02em;
      white-space: nowrap;
    }
    .footer-tagline {
      font-size: 0.875rem;
      line-height: 1.7;
      color: rgba(255,255,255,0.38);
      margin-bottom: 1.8rem;
    }
    .footer-social { display: flex; gap: 0.75rem; }
    .social-btn {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: var(--ice-glass);
      border: 1px solid var(--ice-glass-border);
      display: flex;
      align-items: center;
      justify-content: center;
      color: rgba(255,255,255,0.45);
      text-decoration: none;
      transition: all 0.2s var(--ease-out);
    }
    .social-btn:hover {
      background: var(--ice-red);
      border-color: var(--ice-red);
      color: #fff;
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(227,30,36,0.4);
    }
    .social-btn svg { width: 17px; height: 17px; }
    .footer-col-title {
      font-size: 0.72rem;
      font-weight: 800;
      color: rgba(255,255,255,0.7);
      text-transform: uppercase;
      letter-spacing: 0.1em;
      margin-bottom: 1.2rem;
    }
    .footer-links { list-style: none; padding: 0; display: flex; flex-direction: column; gap: 0.55rem; }
    .footer-links a {
      font-size: 0.85rem;
      font-weight: 500;
      color: rgba(255,255,255,0.38);
      text-decoration: none;
      transition: all 0.2s var(--ease-out);
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
    }
    .footer-links a:hover { color: rgba(255,255,255,0.85); transform: translateX(4px); }
    .footer-links a::before {
      content: '';
      width: 4px;
      height: 4px;
      border-radius: 50%;
      background: var(--ice-red);
      flex-shrink: 0;
      opacity: 0;
      transition: opacity 0.2s;
    }
    .footer-links a:hover::before { opacity: 1; }
    .footer-contact { display: flex; flex-direction: column; gap: 0.9rem; }
    .contact-row {
      display: flex;
      align-items: flex-start;
      gap: 0.65rem;
      font-size: 0.84rem;
      color: rgba(255,255,255,0.38);
      line-height: 1.5;
    }
    .contact-row-icon {
      width: 30px;
      height: 30px;
      border-radius: 8px;
      background: var(--ice-glass);
      border: 1px solid var(--ice-glass-border);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      margin-top: 1px;
    }
    .contact-row-icon svg { width: 13px; height: 13px; color: var(--ice-red); }
    .footer-bottom {
      border-top: 1px solid rgba(255,255,255,0.06);
      padding: 1.5rem 0;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 1rem;
    }
    .footer-copyright { font-size: 0.8rem; color: rgba(255,255,255,0.22); }
    .footer-copyright strong { color: rgba(255,255,255,0.4); font-weight: 700; }
    .footer-legal { display: flex; gap: 1.5rem; }
    .footer-legal a {
      font-size: 0.8rem;
      color: rgba(255,255,255,0.22);
      text-decoration: none;
      transition: color 0.2s;
    }
    .footer-legal a:hover { color: rgba(255,255,255,0.6); }

    /* ══ WHATSAPP FLOAT ══ */
    .wa-float {
      position: fixed;
      bottom: 2rem;
      right: 2rem;
      z-index: 9999;
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      gap: 0.6rem;
    }
    .wa-tooltip {
      background: rgba(6,15,46,0.92);
      backdrop-filter: blur(12px);
      color: #fff;
      font-size: 0.78rem;
      font-weight: 600;
      padding: 0.55rem 0.9rem;
      border-radius: var(--ice-radius);
      white-space: nowrap;
      display: none;
      box-shadow: var(--ice-shadow-lg);
      border: 1px solid rgba(255,255,255,0.1);
      position: relative;
    }
    .wa-tooltip::after {
      content: '';
      position: absolute;
      right: -5px;
      top: 50%;
      transform: translateY(-50%);
      border: 5px solid transparent;
      border-right: none;
      border-left-color: rgba(6,15,46,0.92);
    }
    .wa-float:hover .wa-tooltip { display: block; animation: fadeIn 0.2s ease; }
    .wa-btn {
      width: 56px;
      height: 56px;
      border-radius: 50%;
      background: #25D366;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 8px 28px rgba(37,211,102,0.45);
      text-decoration: none;
      transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
      border: 3px solid rgba(255,255,255,0.2);
    }
    .wa-btn:hover {
      transform: scale(1.1) translateY(-4px);
      box-shadow: 0 16px 36px rgba(37,211,102,0.55);
    }
    .wa-btn svg { width: 28px; height: 28px; fill: #fff; }

    /* ══ RESPONSIVE ══ */
    @media (max-width: 1280px) {
      .header-inner { padding: 0 1.75rem; }
      .footer-inner { padding: 0 1.75rem; }
      .nav-link { padding: 0.45rem 0.6rem; font-size: 0.82rem; }
    }
    @media (max-width: 1100px) {
      .nav-link { padding: 0.45rem 0.5rem; font-size: 0.78rem; }
      .header-inner { gap: 0.75rem; }
    }
    @media (max-width: 900px) {
      .header-nav { display: none; }
      .nav-toggle { display: inline-flex; }
    }
    @media (max-width: 768px) {
      .footer-grid { grid-template-columns: 1fr 1fr; gap: 2.5rem; }
      .brand-tagline { display: none; }
      .header-inner { padding: 0 1.25rem; }
      .footer-inner { padding: 0 1.25rem; }
    }
    @media (max-width: 480px) {
      .footer-grid { grid-template-columns: 1fr; }
      .wa-float { bottom: 1.2rem; right: 1.2rem; }
      .wa-btn { width: 50px; height: 50px; }
      .header-inner { padding: 0 1rem; gap: 0.5rem; }
      .footer-inner { padding: 0 1rem; }
      .btn-login span, .btn-book span { display: none; }
    }

    /* Global Loading Overlay */
    #global-loading {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(6,15,46,0.85);
        backdrop-filter: blur(4px);
        z-index: 99999;
        display: none;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        gap: 1rem;
        font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
    }
    #global-loading .spinner {
        width: 56px;
        height: 56px;
        border: 4px solid rgba(255,255,255,0.2);
        border-top-color: var(--red, #E31E24);
        border-radius: 50%;
        animation: global-spin 0.8s linear infinite;
    }
    #global-loading .loading-text {
        color: white;
        font-weight: 600;
        font-size: 1rem;
        letter-spacing: 0.02em;
    }
    @keyframes global-spin {
        to { transform: rotate(360deg); }
    }
  </style>
  @stack('styles')
</head>
<body>
  <div id="global-loading">
    <div class="spinner"></div>
    <div class="loading-text">Loading, please wait...</div>
  </div>

  <!-- ══ HEADER ══ -->
  <header class="site-header">
    <div class="header-inner">
      <!-- Brand -->
      <a href="{{ route('home') }}" class="header-brand">
        <img src="{{ asset('img/logo_outline.png') }}" alt="Indo Cahaya Express">
        <div class="brand-text-wrap">
          <span class="brand-name">INDO CAHAYA EXPRESS</span>
          <span class="brand-tagline">Pengiriman Internasional</span>
        </div>
      </a>

      <!-- Main Nav -->
      <nav class="header-nav">
        <a href="{{ route('home') }}"             class="nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a>
        <a href="{{ route('calculator') }}"       class="nav-link {{ request()->is('calculator') ? 'active' : '' }}">Calculator</a>
        <a href="{{ route('tracking.index') }}"   class="nav-link {{ request()->is('tracking') ? 'active' : '' }}">Tracking</a>
        <a href="{{ route('customer-service') }}" class="nav-link {{ request()->is('customer-service') ? 'active' : '' }}">Customer Service</a>
        <a href="{{ route('about') }}"            class="nav-link {{ request()->is('about') ? 'active' : '' }}">About Us</a>
      </nav>

      <!-- Actions -->
      <div class="header-actions">
        @auth
          @php
            $role     = auth()->user()->role ?? '';
            $is_admin = ($role === 'admin');
            $is_dev   = ($role === 'dev');
            $is_owner = ($role === 'owner');
            $initial  = strtoupper(mb_substr(auth()->user()->name, 0, 1));
          @endphp

          {{-- Admin / Owner Dropdown --}}
          @if($is_admin || $is_owner)
          <div class="dd-wrap" id="dd-admin-wrap">
            <span class="dd-trigger admin-style" id="dd-admin-trigger">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18m0 0h10a2 2 0 0 0 2-2V9M9 21H5a2 2 0 0 1-2-2V9m0 0h18"/>
              </svg>
              {{ $is_owner ? 'Owner' : 'Admin' }}
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" class="dd-chevron"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>
            </span>
            <div class="dd-panel dd-admin" id="dd-admin-panel">
              <div class="dd-section-head">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="14" height="14"><path d="M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18m0 0h10a2 2 0 0 0 2-2V9M9 21H5a2 2 0 0 1-2-2V9m0 0h18"/></svg>
                <span>{{ $is_owner ? 'Owner Panel' : 'Admin Panel' }}</span>
              </div>
              <div style="padding: 6px 0;">
                <a href="{{ route('orders') }}" class="dd-item {{ request()->is('admin/orders') ? 'active' : '' }}">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 7h13M10 21a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm7 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/></svg>
                  Orders
                </a>
                <a href="{{ route('admin.invoices.index') }}" class="dd-item {{ request()->is('admin/invoices') ? 'active' : '' }}">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="9" y1="13" x2="15" y2="13"/><line x1="9" y1="17" x2="13" y2="17"/></svg>
                  Invoices
                </a>
                <a href="{{ route('admin.reports') }}" class="dd-item {{ request()->is('admin/reports') ? 'active' : '' }}">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
                  Reports
                </a>
                <a href="{{ route('admin.ranking') }}" class="dd-item {{ request()->is('admin/ranking') ? 'active' : '' }}">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                  Ranking Customer
                </a>
                <div class="dd-sep"></div>
                <a href="{{ route('admin.rates') }}" class="dd-item {{ request()->is('admin/rates') ? 'active' : '' }}">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                  View Rates
                </a>
              </div>
            </div>
          </div>
          @endif

          {{-- Developer Dropdown --}}
          @if($is_dev)
          <div class="dd-wrap" id="dd-dev-wrap">
            <span class="dd-trigger dev-style" id="dd-dev-trigger">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" width="13" height="13"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
              Developer
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" class="dd-chevron"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>
            </span>
            <div class="dd-panel dd-dev" id="dd-dev-panel">
              <div class="dd-section-head">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="14" height="14"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                <span>Developer Panel</span>
              </div>
              <div style="padding: 6px 0;">
                <div class="dd-label">Operasional</div>
                <a href="{{ route('orders') }}" class="dd-item {{ request()->is('admin/orders') ? 'active' : '' }}">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 7h13M10 21a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm7 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/></svg>
                  Orders
                </a>
                <a href="{{ route('admin.invoices.index') }}" class="dd-item {{ request()->is('admin/invoices') ? 'active' : '' }}">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="9" y1="13" x2="15" y2="13"/><line x1="9" y1="17" x2="13" y2="17"/></svg>
                  Invoices
                </a>
                <a href="{{ route('admin.reports') }}" class="dd-item">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
                  Reports
                </a>
                <a href="{{ route('admin.ranking') }}" class="dd-item">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                  Ranking Customer
                </a>
                <div class="dd-sep"></div>
                <div class="dd-label">Member & Pricing</div>
                <a href="{{ route('d-e-v.members') }}" class="dd-item">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                  Kelola Member
                </a>
                <a href="{{ route('admin.rates') }}" class="dd-item">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                  Edit Rates
                </a>
                <div class="dd-sep"></div>
                <div class="dd-label">System</div>
                <a href="{{ route('admin.settings') }}" class="dd-item">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                  System Settings
                </a>
              </div>
            </div>
          </div>
          @endif

          {{-- Ship Now CTA --}}
          <a href="{{ route('calculator') }}" class="btn-book">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path d="M5 17H3a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v3"/>
              <rect x="9" y="11" width="14" height="10" rx="2"/>
            </svg>
            Ship Now
          </a>

          {{-- Profile Dropdown --}}
          <div class="dd-wrap" id="dd-profile-wrap">
            <div class="user-avatar-btn" id="dd-profile-trigger">{{ $initial }}</div>
            <div class="dd-panel dd-profile" id="dd-profile-panel">
              <div class="profile-header">
                <div class="profile-header-avatar">{{ $initial }}</div>
                <div class="profile-header-info">
                  <div class="profile-header-label">Logged in as</div>
                  <div class="profile-header-name">{{ auth()->user()->name }}</div>
                  @if($is_dev)
                    <span class="role-badge role-dev">Developer</span>
                  @elseif($is_admin)
                    <span class="role-badge role-admin">Admin</span>
                  @elseif($is_owner)
                    <span class="role-badge role-owner">Owner</span>
                  @else
                    <span class="role-badge role-member">Member</span>
                  @endif
                </div>
              </div>
              <div class="dd-profile-body">
                <a href="{{ route('my.dashboard') }}" class="dd-item {{ request()->is('dashboard') ? 'active' : '' }}">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                  Dashboard Saya
                </a>
                <a href="{{ route('invoices') }}" class="dd-item {{ request()->is('invoices') ? 'active' : '' }}">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="9" y1="13" x2="15" y2="13"/><line x1="9" y1="17" x2="13" y2="17"/></svg>
                  Invoice Saya
                </a>
                <div class="dd-sep"></div>
                <a href="{{ route('book') }}" class="dd-item dd-item-ship">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M5 17H3a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v3"/><rect x="9" y="11" width="14" height="10" rx="2"/></svg>
                  Ship Now
                </a>
                <div class="dd-sep"></div>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dd-item dd-item-danger">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                  Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
              </div>
            </div>
          </div>

        @else
          <a href="{{ route('login') }}" class="btn-login">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="14" height="14">
              <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
              <polyline points="10 17 15 12 10 7"/>
              <line x1="15" y1="12" x2="3" y2="12"/>
            </svg>
            <span>Login</span>
          </a>
        @endauth

        <!-- Mobile toggle -->
        <button class="nav-toggle" id="nav-toggle" aria-label="Toggle Menu">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <line x1="3" y1="6" x2="21" y2="6"/>
            <line x1="3" y1="12" x2="21" y2="12"/>
            <line x1="3" y1="18" x2="21" y2="18"/>
          </svg>
        </button>
      </div>{{-- /header-actions --}}
    </div>{{-- /header-inner --}}

    <!-- Mobile Nav Drawer -->
    <nav id="mobile-nav" style="display:none; border-top: 1px solid rgba(255,255,255,0.07); background: rgba(6,15,46,0.95); backdrop-filter: blur(20px); padding: 0.75rem 1.5rem 1rem;">
      <a href="{{ route('home') }}"             class="nav-link {{ request()->is('/') ? 'active' : '' }}"              style="display:block; margin-bottom:0.2rem;">Home</a>
      <a href="{{ route('about') }}"            class="nav-link {{ request()->is('about') ? 'active' : '' }}"          style="display:block; margin-bottom:0.2rem;">About Us</a>
      <a href="{{ route('calculator') }}"       class="nav-link {{ request()->is('calculator') ? 'active' : '' }}"     style="display:block; margin-bottom:0.2rem;">Calculator</a>
      <a href="{{ route('tracking.index') }}"   class="nav-link {{ request()->is('tracking') ? 'active' : '' }}"       style="display:block; margin-bottom:0.2rem;">Tracking</a>
      <a href="{{ route('customer-service') }}" class="nav-link {{ request()->is('customer-service') ? 'active' : '' }}" style="display:block;">Customer Service</a>
    </nav>
  </header>

  {{-- Flash Messages --}}
  @if(session('success') || session('error') || session('info'))
  <div id="flash-notif" style="animation: flashIn 0.4s cubic-bezier(0.34,1.56,0.64,1) forwards;">
    @if(session('success'))
      <div style="width:8px;height:8px;border-radius:50%;background:#22c55e;flex-shrink:0;margin-top:4px;"></div>
      <div>
        <div style="font-size:0.82rem;font-weight:800;color:#4ade80;margin-bottom:2px;">Berhasil</div>
        <div style="font-size:0.82rem;color:rgba(255,255,255,0.65);">{{ session('success') }}</div>
      </div>
    @elseif(session('error'))
      <div style="width:8px;height:8px;border-radius:50%;background:#ef4444;flex-shrink:0;margin-top:4px;"></div>
      <div>
        <div style="font-size:0.82rem;font-weight:800;color:#f87171;margin-bottom:2px;">Error</div>
        <div style="font-size:0.82rem;color:rgba(255,255,255,0.65);">{{ session('error') }}</div>
      </div>
    @else
      <div style="width:8px;height:8px;border-radius:50%;background:#3b82f6;flex-shrink:0;margin-top:4px;"></div>
      <div>
        <div style="font-size:0.82rem;font-weight:800;color:#60a5fa;margin-bottom:2px;">Info</div>
        <div style="font-size:0.82rem;color:rgba(255,255,255,0.65);">{{ session('info') }}</div>
      </div>
    @endif
  </div>
  <script>
    setTimeout(() => {
      const f = document.getElementById('flash-notif');
      if (f) {
        f.style.animation = 'flashOut 0.35s ease forwards';
        setTimeout(() => f.remove(), 400);
      }
    }, 4500);
  </script>
  @endif

  {{-- Page Content --}}
  @yield('content')

  <!-- ══ FOOTER ══ -->
  <footer class="site-footer">
    <div class="footer-inner">
      <div class="footer-grid">
        <!-- Col 1: Brand -->
        <div>
          <a href="{{ route('home') }}" class="footer-brand-logo">
            <img src="{{ asset('img/logo_white.png') }}" alt="Indo Cahaya Express">
            <span class="footer-brand-name">{{ $globalSettings['site_name'] ?? 'Indo Cahaya Express' }}</span>
          </a>
          <p class="footer-tagline">Solusi pengiriman internasional terpercaya dari Indonesia ke seluruh dunia. Cepat, aman, dan terjangkau.</p>
          <div class="footer-social">
            <a href="#" class="social-btn" aria-label="Facebook">
              <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            </a>
            <a href="#" class="social-btn" aria-label="Instagram">
              <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1 1 12.324 0 6.162 6.162 0 0 1-12.324 0zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm4.965-10.405a1.44 1.44 0 1 1 2.881.001 1.44 1.44 0 0 1-2.881-.001z"/></svg>
            </a>
            <a href="https://wa.me/6281316048642" class="social-btn" aria-label="WhatsApp">
              <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
            </a>
          </div>
        </div>

        <!-- Col 2: Layanan -->
        <div>
          <div class="footer-col-title">Layanan</div>
          <ul class="footer-links">
            <li><a href="{{ route('tracking.index') }}">Tracking Paket</a></li>
            <li><a href="{{ route('calculator') }}">Cek Tarif</a></li>
            <li><a href="{{ route('calculator') }}">Booking Online</a></li>
          </ul>
        </div>

        <!-- Col 3: Dukungan -->
        <div>
          <div class="footer-col-title">Dukungan</div>
          <ul class="footer-links">
            <li><a href="{{ route('customer-service') }}">Customer Service</a></li>
            <li><a href="{{ route('about') }}">Tentang Kami</a></li>
            <li><a href="{{ route('terms') }}">Syarat & Ketentuan</a></li>
            <li><a href="{{ route('faq') }}">FAQ</a></li>
          </ul>
        </div>

        <!-- Col 4: Kontak -->
        <div>
          <div class="footer-col-title">Kontak</div>
          <div class="footer-contact">
            <div class="contact-row">
              <div class="contact-row-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
              </div>
              <span>{{ $globalSettings['site_email'] ?? '' }}</span>
            </div>
            <div class="contact-row">
              <div class="contact-row-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 014.22 11.9a19.79 19.79 0 01-3.07-8.67A2 2 0 012.94 1.5h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L7.09 9.41a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
              </div>
              <span>+{{ $globalSettings['site_phone'] ?? '' }}</span>
            </div>
            <div class="contact-row">
              <div class="contact-row-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
              </div>
              <span>{{ $globalSettings['site_address'] ?? '' }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Footer Bottom -->
      <div class="footer-bottom">
        <p class="footer-copyright">
          &copy; {{ date('Y') }} <strong>{{ $globalSettings['site_name'] }}</strong>. All rights reserved.
        </p>
        <div class="footer-legal">
          <a href="{{ route('terms') }}">Privacy Policy</a>
          <a href="{{ route('terms') }}">Terms of Service</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- WhatsApp Float -->
  <div class="wa-float">
    <div class="wa-tooltip">Hubungi via WhatsApp</div>
    <a class="wa-btn"
       href="https://wa.me/6281316048642?text=Halo%20Indo%20Cahaya%20Express%2C%20saya%20ingin%20bertanya%20tentang%20pengiriman."
       target="_blank" rel="noopener noreferrer" aria-label="Chat WhatsApp">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/>
      </svg>
    </a>
  </div>

  <script>
    // ========== GLOBAL LOADING OVERLAY DENGAN VALIDASI FORM ==========
    let loadingTimeout = null;

    function showGlobalLoading() {
      if (loadingTimeout) clearTimeout(loadingTimeout);
      const el = document.getElementById('global-loading');
      if (el) el.style.display = 'flex';
      loadingTimeout = setTimeout(() => {
        hideGlobalLoading();
      }, 2000);
    }

    function hideGlobalLoading() {
      if (loadingTimeout) {
        clearTimeout(loadingTimeout);
        loadingTimeout = null;
      }
      const el = document.getElementById('global-loading');
      if (el) el.style.display = 'none';
    }

    document.addEventListener('submit', function(e) {
      const form = e.target;
      if (!form.checkValidity()) return;
      if (form.classList && form.classList.contains('needs-validation')) return;
      showGlobalLoading();
    });

    document.addEventListener('click', function(e) {
      let link = e.target.closest('a');
      if (!link) return;
      const href = link.getAttribute('href');
      if (link.target === '_blank') return;
      if (!href || href === '#' || href.startsWith('javascript:')) return;
      if (link.hasAttribute('data-no-loading')) return;
      showGlobalLoading();
    });

    window.addEventListener('pageshow', hideGlobalLoading);
    document.addEventListener('DOMContentLoaded', hideGlobalLoading);
    window.addEventListener('load', hideGlobalLoading);

    // ========== INTERCEPT AJAX (FETCH & XHR) - loading tidak muncul untuk polling ==========
    const originalFetch = window.fetch;
    window.fetch = function(...args) {
      const url = args[0];
      if (typeof url === 'string' && url.includes('/check-new-shipments')) {
        return originalFetch.apply(this, args);
      }
      showGlobalLoading();
      return originalFetch.apply(this, args).finally(() => {
        hideGlobalLoading();
      });
    };

    (function() {
      let xhrOpen = XMLHttpRequest.prototype.open;
      XMLHttpRequest.prototype.open = function(method, url, async, user, password) {
        const isPolling = url && url.includes('/check-new-shipments');
        if (!isPolling) {
          this.addEventListener('loadend', function() {
            hideGlobalLoading();
          });
          showGlobalLoading();
        }
        return xhrOpen.apply(this, arguments);
      };
    })();

    // Dropdown & mobile nav (tidak diubah)
    document.addEventListener('DOMContentLoaded', function () {
      const dropdowns = [
        { trigger: 'dd-admin-trigger',   panel: 'dd-admin-panel' },
        { trigger: 'dd-dev-trigger',     panel: 'dd-dev-panel' },
        { trigger: 'dd-profile-trigger', panel: 'dd-profile-panel' },
      ];

      function closeAll() {
        dropdowns.forEach(({ panel }) => {
          const el = document.getElementById(panel);
          if (el) el.classList.remove('is-open');
        });
      }

      dropdowns.forEach(({ trigger, panel }) => {
        const triggerEl = document.getElementById(trigger);
        const panelEl   = document.getElementById(panel);
        if (!triggerEl || !panelEl) return;
        triggerEl.addEventListener('click', function (e) {
          e.stopPropagation();
          const isOpen = panelEl.classList.contains('is-open');
          closeAll();
          if (!isOpen) panelEl.classList.add('is-open');
        });
        panelEl.addEventListener('click', e => e.stopPropagation());
      });

      document.addEventListener('click', closeAll);

      const toggle    = document.getElementById('nav-toggle');
      const mobileNav = document.getElementById('mobile-nav');
      if (toggle && mobileNav) {
        toggle.addEventListener('click', () => {
          mobileNav.style.display = mobileNav.style.display === 'none' ? 'block' : 'none';
        });
      }
    });

    // ==================== NOTIFIKASI SUARA SHIPMENT BARU (POLLING) ====================
    @auth
    @php
        $userRole = auth()->user()->role ?? '';
        $canListen = in_array($userRole, ['admin', 'dev', 'owner']);
    @endphp
    @if($canListen)
    (function() {
        const POLL_INTERVAL = 10000; // 10 detik
        const SOUND_URL = '{{ asset("sounds/notification.mp3") }}';
        const API_URL = '/check-new-shipments';

        let lastCheckTime = localStorage.getItem('lastShipmentCheck');
        if (!lastCheckTime) {
            lastCheckTime = new Date().toISOString();
            localStorage.setItem('lastShipmentCheck', lastCheckTime);
        }

        function playSound() {
            try {
                const audio = new Audio(SOUND_URL);
                audio.play().catch(e => console.warn('Audio play gagal:', e));
            } catch(e) {
                console.error(e);
            }
        }

        function showToast(message) {
            let toastContainer = document.getElementById('shipment-notify-toast');
            if (!toastContainer) {
                toastContainer = document.createElement('div');
                toastContainer.id = 'shipment-notify-toast';
                toastContainer.style.cssText = `
                    position: fixed;
                    bottom: 90px;
                    right: 20px;
                    z-index: 10000;
                    background: rgba(6,15,46,0.95);
                    backdrop-filter: blur(12px);
                    border-left: 4px solid #E31E24;
                    border-radius: 12px;
                    padding: 12px 20px;
                    color: white;
                    font-weight: 600;
                    font-size: 0.85rem;
                    box-shadow: 0 8px 20px rgba(0,0,0,0.3);
                    display: flex;
                    align-items: center;
                    gap: 12px;
                    transition: opacity 0.3s;
                `;
                document.body.appendChild(toastContainer);
            }
            toastContainer.innerHTML = `<span>🔔</span><span>${message}</span>`;
            toastContainer.style.opacity = '1';
            setTimeout(() => {
                toastContainer.style.opacity = '0';
                setTimeout(() => {
                    if (toastContainer.parentNode) toastContainer.remove();
                }, 300);
            }, 4000);
        }

        async function checkNewShipments() {
            try {
                const response = await fetch(`${API_URL}?since=${encodeURIComponent(lastCheckTime)}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                if (!response.ok) return;
                const data = await response.json();
                if (data.new_shipments && data.new_shipments.length > 0) {
                    playSound();
                    const count = data.new_shipments.length;
                    showToast(`${count} shipment baru telah dibuat!`);
                    const latestTime = data.new_shipments[0].created_at;
                    if (latestTime) {
                        localStorage.setItem('lastShipmentCheck', latestTime);
                        lastCheckTime = latestTime;
                    }
                }
                localStorage.setItem('lastShipmentCheck', new Date().toISOString());
                lastCheckTime = localStorage.getItem('lastShipmentCheck');
            } catch (err) {
                console.warn('Gagal mengecek shipment baru', err);
            }
        }

        setInterval(checkNewShipments, POLL_INTERVAL);
        setTimeout(checkNewShipments, 2000);
    })();
    @endif
    @endauth
  </script>

  @stack('scripts')
</body>
</html>