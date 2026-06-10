<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Maintenance - Indo Cahaya Express</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <style>
        *,*::before,*::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --red: #E31E24; --red-hover: #C7181D;
            --navy-900: #060F2E; --navy-800: #0A1A4A; --navy-700: #0D2260; --navy-600: #102B78;
            --white: #FFFFFF; --border: #DDE6F5;
            --text-primary: #09183C; --text-2: #3D5478; --text-muted: #7A93B8;
            --shadow-md: 0 8px 24px rgba(9,24,60,0.10);
            --shadow-lg: 0 16px 48px rgba(9,24,60,0.12);
            --ease-out: cubic-bezier(0.22, 1, 0.36, 1);
        }
        body {
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            background: var(--navy-900);
            color: #fff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
            position: relative;
        }
        .maintenance-bg {
            position: fixed; inset: 0;
            background:
                radial-gradient(ellipse 100% 80% at 100% 0%, rgba(20,56,160,0.55) 0%, transparent 55%),
                radial-gradient(ellipse 70% 60% at 0% 100%, rgba(227,30,36,0.10) 0%, transparent 50%),
                radial-gradient(ellipse 60% 70% at 55% 50%, rgba(11,26,74,0.9) 0%, transparent 70%),
                linear-gradient(168deg, #060F2E 0%, #0B1C55 45%, #091640 100%);
            z-index: 0;
        }
        .maintenance-grid {
            position: fixed; inset: 0;
            background-image:
                radial-gradient(circle, rgba(255,255,255,0.055) 1px, transparent 1px);
            background-size: 44px 44px;
            mask-image: radial-gradient(ellipse 90% 80% at 50% 50%, black 40%, transparent 80%);
            z-index: 0;
        }
        .maintenance-lines {
            position: fixed; inset: 0; z-index: 0; overflow: hidden;
        }
        .maintenance-lines::before {
            content: ''; position: absolute; top: 0; bottom: 0; right: 34%; width: 1px;
            background: linear-gradient(to bottom, transparent 0%, rgba(227,30,36,0.35) 25%, rgba(227,30,36,0.15) 70%, transparent 100%);
        }
        .container {
            position: relative; z-index: 2;
            max-width: 680px; margin: 0 auto;
            padding: 2rem; text-align: center;
        }
        .maintenance-icon {
            width: 100px; height: 100px;
            margin: 0 auto 2rem;
            background: rgba(227,30,36,0.12);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            border: 1px solid rgba(227,30,36,0.28);
            backdrop-filter: blur(10px);
            box-shadow: 0 0 40px rgba(227,30,36,0.2);
        }
        .maintenance-icon svg { width: 48px; height: 48px; color: var(--red); }
        .info-pill {
            display: inline-flex; align-items: center; gap: 0.5rem;
            background: rgba(34,197,94,0.10); border: 1px solid rgba(34,197,94,0.25);
            border-radius: 99px; padding: 0.45rem 1.1rem;
            font-size: 0.72rem; font-weight: 800; color: #4ade80;
            letter-spacing: 0.1em; text-transform: uppercase;
            margin-bottom: 2rem;
        }
        .info-pill svg { width: 14px; height: 14px; }
        h1 {
            font-size: clamp(2.5rem, 6vw, 4rem);
            font-weight: 900;
            letter-spacing: -0.04em;
            margin-bottom: 1.5rem;
            line-height: 1;
            color: #fff;
        }
        h1 .accent {
            display: block;
            font-family: 'DM Serif Display', serif;
            font-style: italic;
            font-weight: 400;
            color: var(--red);
            font-size: 1.08em;
            letter-spacing: -0.025em;
            line-height: 1.05;
        }
        .maintenance-desc {
            font-size: 1rem; line-height: 1.8;
            color: rgba(255,255,255,0.55);
            margin-bottom: 2.5rem; max-width: 520px; margin-left: auto; margin-right: auto;
        }
        .contact-buttons {
            display: flex; gap: 1rem;
            justify-content: center; flex-wrap: wrap;
        }
        .btn {
            display: inline-flex; align-items: center; gap: 0.6rem;
            padding: 0.9rem 1.8rem; border-radius: 8px;
            font-weight: 700; text-decoration: none;
            transition: all 0.25s var(--ease-out);
            font-size: 0.9rem; cursor: pointer; border: none;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .btn svg { width: 18px; height: 18px; }
        .btn-primary {
            background: var(--red); color: #fff;
            box-shadow: 0 8px 28px rgba(227,30,36,0.4), inset 0 1px 0 rgba(255,255,255,0.12);
        }
        .btn-primary:hover {
            background: var(--red-hover);
            transform: translateY(-2px);
            box-shadow: 0 14px 36px rgba(227,30,36,0.5);
        }
        .btn-outline {
            background: transparent;
            border: 1.5px solid rgba(255,255,255,0.18) !important;
            color: rgba(255,255,255,0.65);
        }
        .btn-outline:hover {
            background: rgba(255,255,255,0.07);
            border-color: rgba(255,255,255,0.38) !important;
            color: #fff; transform: translateY(-2px);
        }
        .eta {
            margin-top: 3rem; font-size: 0.78rem;
            color: rgba(255,255,255,0.3);
            display: flex; align-items: center; justify-content: center;
            gap: 0.5rem;
        }
        .eta::before { content: '—'; opacity: 0.4; }
        .eta::after  { content: '—'; opacity: 0.4; }
        @media (max-width: 640px) {
            .container { padding: 1.5rem; }
            .btn { padding: 0.7rem 1.4rem; }
        }
    </style>
</head>
<body>
    <div class="maintenance-bg"></div>
    <div class="maintenance-grid"></div>
    <div class="maintenance-lines"></div>

    <div class="container">
        <div class="maintenance-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
                <circle cx="12" cy="12" r="3"/>
            </svg>
        </div>

        <div class="info-pill">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Sedang dalam pemeliharaan
        </div>

        <h1>
            Kami Akan
            <span class="accent">Segera Kembali</span>
        </h1>

        <p class="maintenance-desc">
            Indo Cahaya Express sedang melakukan peningkatan sistem untuk memberikan layanan terbaik bagi Anda.
            Mohon maaf atas ketidaknyamanannya. Tim kami bekerja keras agar website dapat diakses kembali dalam waktu singkat.
        </p>

        <div class="contact-buttons">
            <a href="https://wa.me/+{{ preg_replace('/[^0-9]/', '', $globalSettings['site_phone']) }}" target="_blank" class="btn btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
                Hubungi WhatsApp
            </a>
            <a href="mailto:{{ $globalSettings['site_email'] }}" class="btn btn-outline">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                    <polyline points="22,6 12,13 2,6"/>
                </svg>
                Email Support
            </a>
        </div>

        <div class="eta">
            Estimasi selesai: dalam beberapa jam. Terima kasih atas kesabaran Anda.
        </div>
    </div>
</body>
</html>
