@extends('layouts.app')

@section('title', 'FAQ - Indo Cahaya Express')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300&family=DM+Serif+Display:ital@0;1&display=swap');

:root {
  --red: #E31E24; --red-hover: #C7181D; --red-deep: #A0121A;
  --navy-900: #060F2E; --navy-800: #0A1A4A; --navy-700: #0D2260; --navy-600: #102B78; --navy-500: #1438A0;
  --white: #FFFFFF; --surface: #FAFBFE; --surface-2: #F1F5FC; --surface-3: #E8EFF9;
  --border: #DDE6F5; --border-2: #C8D6EE;
  --text-primary: #09183C; --text-2: #3D5478; --text-muted: #7A93B8; --text-faint: #AAB9D0;
  --shadow-sm: 0 2px 8px rgba(9,24,60,0.08);
  --shadow-md: 0 8px 24px rgba(9,24,60,0.10);
  --shadow-lg: 0 16px 48px rgba(9,24,60,0.12);
  --shadow-card: 0 4px 20px rgba(9,24,60,0.07), 0 1px 4px rgba(9,24,60,0.04);
  --ease-out: cubic-bezier(0.22, 1, 0.36, 1);
}

.faq-page { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; color: var(--text-primary); background: var(--white); }

/* ── Hero ── */
.faq-hero {
  position: relative; min-height: 45vh;
  display: flex; align-items: center; overflow: hidden;
  background: var(--navy-900);
}
.faq-hero-bg {
  position: absolute; inset: 0;
  background:
    radial-gradient(ellipse 100% 80% at 100% 0%, rgba(20,56,160,0.55) 0%, transparent 55%),
    radial-gradient(ellipse 70% 60% at 0% 100%, rgba(227,30,36,0.10) 0%, transparent 50%),
    linear-gradient(168deg, #060F2E 0%, #0B1C55 45%, #091640 100%);
  z-index: 0;
}
.faq-hero-grid {
  position: absolute; inset: 0;
  background-image: radial-gradient(circle, rgba(255,255,255,0.055) 1px, transparent 1px);
  background-size: 44px 44px;
  mask-image: radial-gradient(ellipse 90% 80% at 50% 50%, black 40%, transparent 80%);
  z-index: 0;
}
.faq-hero .container { position: relative; z-index: 2; text-align: center; padding: 4rem 2rem; max-width: 900px; margin: 0 auto; }
.faq-eyebrow {
  display: inline-flex; align-items: center; gap: 0.5rem;
  background: rgba(227,30,36,0.1); border: 1px solid rgba(227,30,36,0.28);
  color: rgba(255,120,120,0.95); border-radius: 99px;
  padding: 0.35rem 1rem; font-size: 0.68rem; font-weight: 800;
  letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 1.5rem;
}
.faq-eyebrow svg { width: 10px; height: 10px; }
.faq-hero h1 {
  font-size: clamp(2rem, 4vw, 3.6rem); font-weight: 900;
  color: #fff; letter-spacing: -0.04em; line-height: 1.05; margin-bottom: 1rem;
}
.faq-hero h1 span {
  display: block; font-family: 'DM Serif Display', serif;
  font-style: italic; font-weight: 400; color: var(--red);
  font-size: 1.08em;
}
.faq-hero p { font-size: 0.95rem; color: rgba(255,255,255,0.5); line-height: 1.8; max-width: 560px; margin: 0 auto 2rem; }
.faq-search-wrap {
  max-width: 480px; margin: 0 auto;
  position: relative;
}
.faq-search-wrap input {
  width: 100%; padding: 0.85rem 1.25rem 0.85rem 3rem;
  background: rgba(255,255,255,0.08); border: 1.5px solid rgba(255,255,255,0.15);
  border-radius: 12px; color: #fff; font-size: 0.9rem; font-family: inherit;
  transition: all 0.25s var(--ease-out); outline: none;
}
.faq-search-wrap input::placeholder { color: rgba(255,255,255,0.35); }
.faq-search-wrap input:focus { background: rgba(255,255,255,0.12); border-color: rgba(255,255,255,0.35); }
.faq-search-icon {
  position: absolute; left: 1rem; top: 50%; transform: translateY(-50%);
  color: rgba(255,255,255,0.4); pointer-events: none;
}

/* ── Layout ── */
.faq-body { padding: 5rem 0; background: var(--surface); }
.faq-container { 
  max-width: 1440px; 
  margin: 0 auto; 
  padding: 0 2rem; 
  display: grid; 
  grid-template-columns: 260px 1fr; 
  gap: 3rem; 
  align-items: start; /* WAJIB agar sticky bekerja */
}

/* ── TOC Sidebar ── */
.faq-toc {
  position: sticky;
  top: 2rem;
  align-self: start; /* pastikan alignment start */
  background: var(--white);
  border: 1px solid var(--border);
  border-radius: 20px;
  overflow: hidden;
  box-shadow: var(--shadow-card);
  /* tambahan untuk kompatibilitas */
  position: -webkit-sticky;
}
.faq-toc-header {
  background: linear-gradient(155deg, var(--navy-800) 0%, var(--navy-700) 100%);
  padding: 1.25rem 1.5rem;
  position: relative; overflow: hidden;
}
.faq-toc-header::before {
  content: ''; position: absolute; top: -1px; left: 15%; right: 15%; height: 1px;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.25), transparent);
}
.faq-toc-header h3 { font-size: 0.875rem; font-weight: 800; color: #fff; margin: 0; }
.faq-toc-body { padding: 0.75rem; }
.faq-toc-link {
  display: flex; align-items: center; gap: 0.5rem;
  padding: 0.55rem 0.75rem; border-radius: 8px;
  font-size: 0.8rem; font-weight: 600; color: var(--text-2);
  text-decoration: none; transition: all 0.2s; line-height: 1.4; cursor: pointer;
}
.faq-toc-link:hover { background: var(--surface-2); color: var(--navy-600); }
.faq-toc-link.active { background: rgba(227,30,36,0.08); color: var(--red); }
.faq-toc-dot {
  width: 22px; height: 22px; border-radius: 6px;
  background: var(--surface-3); color: var(--text-muted);
  display: flex; align-items: center; justify-content: center;
  font-size: 0.65rem; font-weight: 800; flex-shrink: 0;
}
.faq-toc-link.active .faq-toc-dot { background: var(--red); color: #fff; }
.faq-toc-updated {
  margin: 0.5rem 0.75rem 0.75rem;
  padding: 0.6rem 0.75rem;
  background: rgba(22,163,74,0.06); border: 1px solid rgba(22,163,74,0.18);
  border-radius: 10px; font-size: 0.7rem; color: var(--text-muted);
  display: flex; align-items: center; gap: 0.4rem;
}
.faq-toc-updated strong { color: #16a34a; }
.faq-stat-block {
  margin: 0 0.75rem 0.75rem;
  padding: 0.85rem 1rem;
  background: var(--surface-2); border: 1px solid var(--border);
  border-radius: 12px;
}
.faq-stat-block p { font-size: 0.72rem; color: var(--text-muted); margin: 0 0 0.25rem; }
.faq-stat-row { display: flex; justify-content: space-between; align-items: center; }
.faq-stat-row span { font-size: 0.75rem; color: var(--text-2); font-weight: 600; }
.faq-stat-row strong { font-size: 0.85rem; color: var(--navy-600); font-weight: 800; }

/* ── Category Section ── */
.faq-category {
  background: var(--white); border: 1px solid var(--border);
  border-radius: 20px; padding: 2.5rem; margin-bottom: 1.5rem;
  box-shadow: var(--shadow-card); transition: all 0.3s var(--ease-out);
}
.faq-category:hover { border-color: var(--border-2); box-shadow: var(--shadow-md); }
.faq-cat-header { display: flex; align-items: flex-start; gap: 1rem; margin-bottom: 1.5rem; }
.faq-cat-icon {
  width: 44px; height: 44px; border-radius: 12px; flex-shrink: 0;
  display: flex; align-items: center; justify-content: center;
  background: rgba(227,30,36,0.08); border: 1px solid rgba(227,30,36,0.15);
  color: var(--red);
}
.faq-cat-icon svg { width: 20px; height: 20px; }
.faq-cat-meta {}
.faq-cat-badge {
  display: inline-flex; align-items: center; gap: 0.45rem;
  background: rgba(227,30,36,0.07); border: 1px solid rgba(227,30,36,0.14);
  color: var(--red); border-radius: 99px;
  padding: 0.28rem 0.75rem; font-size: 0.65rem; font-weight: 800;
  letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 0.5rem;
}
.faq-cat-meta h2 {
  font-size: 1.2rem; font-weight: 800; color: var(--text-primary);
  letter-spacing: -0.025em; margin: 0; line-height: 1.3;
}
.faq-cat-meta p { font-size: 0.85rem; color: var(--text-muted); margin: 0.25rem 0 0; }

/* ── Accordion ── */
.faq-list { display: flex; flex-direction: column; gap: 0.75rem; }
.faq-item {
  border: 1px solid var(--border); border-radius: 12px; overflow: hidden;
  transition: all 0.25s var(--ease-out);
}
.faq-item.open { border-color: rgba(227,30,36,0.22); box-shadow: 0 4px 16px rgba(227,30,36,0.06); }
.faq-q {
  width: 100%; display: flex; align-items: center; justify-content: space-between; gap: 1rem;
  padding: 1.1rem 1.25rem; cursor: pointer; background: none; border: none;
  text-align: left; font-family: inherit; transition: background 0.2s;
}
.faq-q:hover { background: var(--surface-2); }
.faq-item.open .faq-q { background: rgba(227,30,36,0.04); }
.faq-q-text { font-size: 0.9rem; font-weight: 700; color: var(--text-primary); line-height: 1.45; }
.faq-item.open .faq-q-text { color: var(--navy-600); }
.faq-q-icon {
  width: 28px; height: 28px; border-radius: 8px; flex-shrink: 0;
  display: flex; align-items: center; justify-content: center;
  background: var(--surface-3); color: var(--text-muted);
  transition: all 0.25s var(--ease-out);
}
.faq-item.open .faq-q-icon { background: var(--red); color: #fff; transform: rotate(45deg); }
.faq-q-icon svg { width: 14px; height: 14px; }
.faq-a {
  display: none; padding: 0 1.25rem 1.25rem; 
  border-top: 1px solid var(--border);
}
.faq-item.open .faq-a { display: block; }
.faq-a p {
  font-size: 0.875rem; color: var(--text-2);
  line-height: 1.8; margin: 1rem 0 0.75rem;
}
.faq-a p:last-child { margin-bottom: 0; }
.faq-a ul {
  list-style: none; padding: 0; margin: 0.5rem 0 0.75rem;
  display: flex; flex-direction: column; gap: 0.45rem;
}
.faq-a ul li {
  display: flex; align-items: flex-start; gap: 0.6rem;
  font-size: 0.875rem; color: var(--text-2); line-height: 1.65;
}
.faq-a ul li::before {
  content: ''; width: 6px; height: 6px;
  background: var(--red); border-radius: 50%;
  margin-top: 0.55rem; flex-shrink: 0;
}
.faq-highlight {
  background: rgba(227,30,36,0.04); border: 1px solid rgba(227,30,36,0.12);
  border-left: 3px solid var(--red); border-radius: 8px;
  padding: 1rem 1.25rem; margin: 0.75rem 0;
  font-size: 0.875rem; color: var(--text-2); line-height: 1.7;
}
.faq-highlight strong { color: var(--text-primary); }
.faq-info {
  background: rgba(20,56,160,0.04); border: 1px solid rgba(20,56,160,0.12);
  border-left: 3px solid var(--navy-500); border-radius: 8px;
  padding: 1rem 1.25rem; margin: 0.75rem 0;
  font-size: 0.875rem; color: var(--text-2); line-height: 1.7;
}
.faq-info strong { color: var(--navy-600); }
.faq-formula {
  background: var(--navy-900); border-radius: 10px;
  padding: 1rem 1.25rem; margin: 0.75rem 0;
  font-family: 'Courier New', monospace; font-size: 0.85rem;
  color: #7dd3fc; line-height: 1.9;
}
.faq-formula span { color: rgba(255,255,255,0.5); font-size: 0.78rem; }
.faq-table { width: 100%; border-collapse: collapse; margin: 0.75rem 0; font-size: 0.82rem; }
.faq-table th {
  background: var(--navy-800); color: #fff;
  padding: 0.65rem 0.9rem; text-align: left; font-weight: 700;
  font-size: 0.75rem; letter-spacing: 0.03em;
}
.faq-table th:first-child { border-radius: 8px 0 0 0; }
.faq-table th:last-child { border-radius: 0 8px 0 0; }
.faq-table td { padding: 0.65rem 0.9rem; border-bottom: 1px solid var(--border); color: var(--text-2); }
.faq-table tr:last-child td { border-bottom: none; }
.faq-table tr:hover td { background: var(--surface-2); }
.badge-service {
  display: inline-block; padding: 0.2rem 0.6rem; border-radius: 99px;
  font-size: 0.7rem; font-weight: 700; letter-spacing: 0.04em;
}
.badge-red { background: rgba(227,30,36,0.1); color: var(--red); }
.badge-navy { background: rgba(20,56,160,0.1); color: var(--navy-600); }
.badge-green { background: rgba(22,163,74,0.1); color: #16a34a; }
.badge-yellow { background: rgba(234,179,8,0.1); color: #a16207; }
.badge-purple { background: rgba(124,58,237,0.1); color: #7c3aed; }

/* ── Contact CTA ── */
.faq-contact-card {
  background: linear-gradient(155deg, var(--navy-800) 0%, var(--navy-700) 100%);
  border-radius: 20px; padding: 2.5rem; text-align: center;
  position: relative; overflow: hidden; margin-top: 1.5rem;
}
.faq-contact-card::before {
  content: ''; position: absolute; top: -1px; left: 15%; right: 15%; height: 1px;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.25), transparent);
}
.faq-contact-card h3 { font-size: 1.2rem; font-weight: 800; color: #fff; margin: 0 0 0.5rem; }
.faq-contact-card p { font-size: 0.875rem; color: rgba(255,255,255,0.55); margin: 0 0 1.5rem; }
.faq-contact-btns { display: flex; gap: 0.75rem; justify-content: center; flex-wrap: wrap; }
.faq-btn-primary {
  display: inline-flex; align-items: center; gap: 0.5rem;
  background: var(--red); color: #fff; padding: 0.75rem 1.5rem;
  border-radius: 8px; font-weight: 700; font-size: 0.875rem;
  text-decoration: none; transition: all 0.25s var(--ease-out);
  box-shadow: 0 8px 24px rgba(227,30,36,0.4);
}
.faq-btn-primary:hover { background: var(--red-hover); transform: translateY(-2px); color: #fff; }
.faq-btn-outline {
  display: inline-flex; align-items: center; gap: 0.5rem;
  background: transparent; color: rgba(255,255,255,0.7);
  border: 1.5px solid rgba(255,255,255,0.2); padding: 0.75rem 1.5rem;
  border-radius: 8px; font-weight: 700; font-size: 0.875rem;
  text-decoration: none; transition: all 0.25s var(--ease-out);
}
.faq-btn-outline:hover { background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.38); color: #fff; }

/* ── No-result ── */
.faq-noresult { text-align: center; padding: 3rem 1rem; display: none; }
.faq-noresult svg { width: 48px; height: 48px; color: var(--text-faint); margin-bottom: 1rem; }
.faq-noresult h4 { font-size: 1rem; font-weight: 700; color: var(--text-2); margin: 0 0 0.5rem; }
.faq-noresult p { font-size: 0.875rem; color: var(--text-muted); margin: 0; }

/* ── Responsive ── */
@media (max-width: 900px) {
  .faq-container { grid-template-columns: 1fr; }
  .faq-toc { position: static; }
  .faq-toc-body { display: flex; flex-wrap: wrap; gap: 0.3rem; padding: 0.75rem; }
  .faq-toc-link { padding: 0.4rem 0.7rem; }
}
@media (max-width: 600px) {
  .faq-hero .container { padding: 3rem 1.25rem; }
  .faq-body { padding: 3rem 0; }
  .faq-container { padding: 0 1rem; gap: 1.5rem; }
  .faq-category { padding: 1.5rem; }
  .faq-table { font-size: 0.78rem; }
  .faq-table th, .faq-table td { padding: 0.5rem 0.65rem; }
}
</style>

<div class="faq-page">

  {{-- ════════════════════════════════════════
       HERO
  ════════════════════════════════════════ --}}
  <section class="faq-hero">
    <div class="faq-hero-bg"></div>
    <div class="faq-hero-grid"></div>
    <div class="container">
      <div class="faq-eyebrow">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        Pusat Informasi
      </div>
      <h1>Pertanyaan yang<span>Sering Ditanyakan</span></h1>
      <p>Temukan jawaban seputar DDP, War Risk Charge, layanan pengiriman, dan cara kerja sistem kami.</p>
      <div class="faq-search-wrap">
        <svg class="faq-search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" id="faqSearch" placeholder="Cari pertanyaan... (contoh: DDP, War Risk)" autocomplete="off">
      </div>
    </div>
  </section>

  {{-- ════════════════════════════════════════
       BODY
  ════════════════════════════════════════ --}}
  <div class="faq-body">
    <div class="faq-container">

      {{-- ── Sidebar TOC ── --}}
      <aside>
        <div class="faq-toc">
          <div class="faq-toc-header"><h3>Kategori FAQ</h3></div>
          <div class="faq-toc-body">
            <a href="#cat1" class="faq-toc-link"><span class="faq-toc-dot">01</span>Surcharge &amp; Biaya Tambahan</a>
            <a href="#cat2" class="faq-toc-link"><span class="faq-toc-dot">02</span>DDP – Delivered Duty Paid</a>
            <a href="#cat3" class="faq-toc-link"><span class="faq-toc-dot">03</span>War Risk Charge</a>
            <a href="#cat4" class="faq-toc-link"><span class="faq-toc-dot">04</span>Layanan Pengiriman</a>
            <a href="#cat5" class="faq-toc-link"><span class="faq-toc-dot">05</span>Berat &amp; Dimensi</a>
            <a href="#cat6" class="faq-toc-link"><span class="faq-toc-dot">06</span>Invoice &amp; Pembayaran</a>
            <a href="#cat7" class="faq-toc-link"><span class="faq-toc-dot">07</span>Tracking &amp; Status</a>
            <a href="#cat8" class="faq-toc-link"><span class="faq-toc-dot">08</span>Barang Terlarang</a>
          </div>
          <div class="faq-toc-updated">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            Diperbarui: <strong>Januari 2025</strong>
          </div>
          <div class="faq-stat-block">
            <p>Pengaturan Default Sistem</p>
            <div class="faq-stat-row"><span>DDP Percent</span><strong>19%</strong></div>
            <div class="faq-stat-row" style="margin-top:0.3rem"><span>War Risk Percent</span><strong>32%</strong></div>
          </div>
        </div>
      </aside>

      {{-- ── Main Content ── --}}
      <div class="faq-content" id="faqContent">

        {{-- ─────────────────────────────
             KATEGORI 1: Surcharge & Biaya
        ───────────────────────────── --}}
        <div id="cat1" class="faq-category">
          <div class="faq-cat-header">
            <div class="faq-cat-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </div>
            <div class="faq-cat-meta">
              <div class="faq-cat-badge">
                <svg width="8" height="8" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
                Kategori 01
              </div>
              <h2>Surcharge &amp; Biaya Tambahan</h2>
              <p>Penjelasan umum tentang biaya-biaya di luar ongkos kirim dasar</p>
            </div>
          </div>
          <div class="faq-list">

            <div class="faq-item">
              <button class="faq-q" type="button">
                <span class="faq-q-text">Apa saja biaya tambahan (surcharge) yang mungkin muncul di invoice saya?</span>
                <span class="faq-q-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
              </button>
              <div class="faq-a">
                <p>Selain ongkos kirim dasar, terdapat beberapa jenis biaya tambahan tergantung layanan dan negara tujuan:</p>
                <table class="faq-table">
                  <thead><tr><th>Jenis Surcharge</th><th>Berlaku untuk</th><th>Keterangan</th></tr></thead>
                  <tbody>
                    <tr><td><strong>War Risk Charge</strong></td><td><span class="badge-service badge-green">REGULER</span></td><td>Biaya asuransi risiko perang, dihitung dari nilai deklarasi</td></tr>
                    <tr><td><strong>DDP (Duty &amp; Tax)</strong></td><td><span class="badge-service badge-green">REGULER</span> ke USA</td><td>Bea masuk &amp; pajak impor prabayar untuk tujuan Amerika Serikat</td></tr>
                    <tr><td><strong>Biaya TESS</strong></td><td><span class="badge-service badge-red">FLASH</span></td><td>Surcharge khusus layanan Aramex</td></tr>
                  </tbody>
                </table>
                <div class="faq-info">
                  <strong>Catatan:</strong> Layanan PRIORITY, FedEx, FAST ASIA, US REGULER, dan FLASH AUSSY tidak memiliki surcharge DDP atau War Risk secara default.
                </div>
              </div>
            </div>

            <div class="faq-item">
              <button class="faq-q" type="button">
                <span class="faq-q-text">Apakah biaya surcharge bisa berubah sewaktu-waktu?</span>
                <span class="faq-q-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
              </button>
              <div class="faq-a">
                <p>Ya. Persentase War Risk dan DDP ditetapkan oleh admin sistem dan dapat berubah mengikuti kebijakan maskapai/mitra logistik, fluktuasi nilai tukar, atau regulasi bea cukai negara tujuan.</p>
                <div class="faq-highlight">
                  <strong>Penting:</strong> Setiap perubahan persentase DDP akan otomatis menghitung ulang (recalculate) semua invoice berstatus <em>Unpaid</em>. Invoice yang sudah <em>Paid</em> tidak akan berubah.
                </div>
              </div>
            </div>

          </div>
        </div>

        {{-- ─────────────────────────────
             KATEGORI 2: DDP
        ───────────────────────────── --}}
        <div id="cat2" class="faq-category">
          <div class="faq-cat-header">
            <div class="faq-cat-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
            </div>
            <div class="faq-cat-meta">
              <div class="faq-cat-badge">
                <svg width="8" height="8" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
                Kategori 02
              </div>
              <h2>DDP – Delivered Duty Paid</h2>
              <p>Bea masuk &amp; pajak impor yang dibayarkan di muka oleh pengirim</p>
            </div>
          </div>
          <div class="faq-list">

            <div class="faq-item">
              <button class="faq-q" type="button">
                <span class="faq-q-text">Apa itu DDP (Delivered Duty Paid)?</span>
                <span class="faq-q-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
              </button>
              <div class="faq-a">
                <p>DDP (Delivered Duty Paid) adalah sistem pengiriman di mana <strong>pengirim membayar semua biaya bea masuk dan pajak impor di muka</strong>, sehingga penerima tidak perlu membayar apapun saat paket tiba.</p>
                <p>Tanpa DDP, penerima di negara tujuan akan ditagih oleh pihak bea cukai setempat sebelum paket dapat diambil. Dengan DDP, proses ini sudah diselesaikan oleh Indo Cahaya Express atas nama pengirim.</p>
                <div class="faq-info">
                  <strong>Berlaku untuk:</strong> Layanan <strong>REGULER (SingPost)</strong> ke tujuan <strong>Amerika Serikat (USA)</strong>.
                </div>
              </div>
            </div>

            <div class="faq-item">
              <button class="faq-q" type="button">
                <span class="faq-q-text">Bagaimana cara menghitung biaya DDP?</span>
                <span class="faq-q-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
              </button>
              <div class="faq-a">
                <p>Biaya DDP dihitung dari <strong>total nilai deklarasi barang (declare value)</strong> dalam USD, dikalikan kurs USD ke IDR saat itu, kemudian dikalikan persentase DDP yang berlaku:</p>
                <div class="faq-formula">
                  DDP = Total Declare Value (USD) × Kurs USD/IDR × DDP%<br>
                  <span>──────────────────────────────────────────────</span><br>
                  Contoh:<br>
                  Declare Value = $50<br>
                  Kurs USD/IDR  = Rp 16.000<br>
                  DDP%          = 19%<br>
                  <span>──────────────────────</span><br>
                  DDP = 50 × 16.000 × 0,19 = <strong>Rp 152.000</strong>
                </div>
                <div class="faq-highlight">
                  <strong>Catatan:</strong> Kurs USD/IDR diambil secara real-time dari API nilai tukar. DDP hanya dihitung jika total declare value &gt; 0.
                </div>
              </div>
            </div>

            <div class="faq-item">
              <button class="faq-q" type="button">
                <span class="faq-q-text">Pengiriman ke negara mana saja yang dikenakan DDP?</span>
                <span class="faq-q-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
              </button>
              <div class="faq-a">
                <p>Saat ini DDP hanya berlaku untuk layanan <span class="badge-service badge-green">REGULER</span> ke <strong>Amerika Serikat</strong> (termasuk US Territories). Negara lain tidak dikenakan DDP secara otomatis.</p>
                <table class="faq-table">
                  <thead><tr><th>Negara Tujuan</th><th>Layanan</th><th>DDP</th></tr></thead>
                  <tbody>
                    <tr><td>Amerika Serikat (USA)</td><td><span class="badge-service badge-green">REGULER</span></td><td><strong style="color:var(--red)">Ya – wajib</strong></td></tr>
                    <tr><td>Negara lainnya</td><td><span class="badge-service badge-green">REGULER</span></td><td>Tidak</td></tr>
                    <tr><td>Semua negara</td><td><span class="badge-service badge-navy">PRIORITY / FedEx / FLASH dll</span></td><td>Tidak</td></tr>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="faq-item">
              <button class="faq-q" type="button">
                <span class="faq-q-text">Apakah DDP bisa dihindari atau dioptimalkan?</span>
                <span class="faq-q-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
              </button>
              <div class="faq-a">
                <p>DDP adalah kewajiban bea cukai yang tidak dapat dihindari untuk tujuan USA. Namun ada beberapa hal yang dapat Anda perhatikan:</p>
                <ul>
                  <li>Pastikan nilai deklarasi (declare value) akurat dan tidak melebihi nilai nyata barang.</li>
                  <li>Pertimbangkan layanan non-REGULER (PRIORITY/FedEx) jika barang bernilai tinggi, karena DDP tidak berlaku.</li>
                  <li>Untuk pengiriman volume besar ke USA, diskusikan dengan tim kami tentang opsi terbaik.</li>
                </ul>
                <div class="faq-highlight">
                  <strong>Perhatian:</strong> Mendeklarasikan nilai barang lebih rendah dari nilai sebenarnya adalah pelanggaran hukum bea cukai dan dapat menyebabkan paket ditahan atau dikembalikan.
                </div>
              </div>
            </div>

          </div>
        </div>

        {{-- ─────────────────────────────
             KATEGORI 3: War Risk Charge
        ───────────────────────────── --}}
        <div id="cat3" class="faq-category">
          <div class="faq-cat-header">
            <div class="faq-cat-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            </div>
            <div class="faq-cat-meta">
              <div class="faq-cat-badge">
                <svg width="8" height="8" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
                Kategori 03
              </div>
              <h2>War Risk Charge</h2>
              <p>Biaya surcharge asuransi risiko konflik bersenjata dalam jalur pengiriman</p>
            </div>
          </div>
          <div class="faq-list">

            <div class="faq-item">
              <button class="faq-q" type="button">
                <span class="faq-q-text">Apa itu War Risk Charge?</span>
                <span class="faq-q-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
              </button>
              <div class="faq-a">
                <p><strong>War Risk Charge</strong> adalah biaya tambahan yang dikenakan oleh maskapai/agen logistik sebagai kompensasi atas risiko melewati kawasan udara atau laut yang dianggap berbahaya akibat konflik bersenjata, ketidakstabilan politik, atau situasi geopolitik tertentu.</p>
                <p>Biaya ini bukan asuransi barang Anda, melainkan surcharge operasional yang dibebankan oleh mitra pengiriman (SingPost untuk layanan REGULER) kepada Indo Cahaya Express, dan diteruskan kepada pengirim.</p>
              </div>
            </div>

            <div class="faq-item">
              <button class="faq-q" type="button">
                <span class="faq-q-text">Layanan apa yang dikenakan War Risk Charge?</span>
                <span class="faq-q-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
              </button>
              <div class="faq-a">
                <p>War Risk Charge hanya berlaku untuk layanan <span class="badge-service badge-green">REGULER</span> (berbasis SingPost). Layanan lain seperti PRIORITY, FedEx, FLASH, FAST ASIA tidak dikenakan War Risk Charge.</p>
                <div class="faq-info">
                  <strong>Default persentase:</strong> War Risk Charge dihitung sebesar <strong>32%</strong> dari ongkos kirim dasar (dapat berubah sesuai pengaturan admin).
                </div>
              </div>
            </div>

            <div class="faq-item">
              <button class="faq-q" type="button">
                <span class="faq-q-text">Bagaimana cara menghitung War Risk Charge?</span>
                <span class="faq-q-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
              </button>
              <div class="faq-a">
                <div class="faq-formula">
                  War Risk = Ongkos Kirim Dasar × War Risk%<br>
                  <span>──────────────────────────────────────────────</span><br>
                  Contoh:<br>
                  Ongkos Kirim Dasar = Rp 200.000<br>
                  War Risk%          = 32%<br>
                  <span>──────────────────────</span><br>
                  War Risk = 200.000 × 0,32 = <strong>Rp 64.000</strong>
                </div>
                <p>Nilai ini akan muncul sebagai baris terpisah di invoice Anda dengan label <em>War Risk Charge</em>.</p>
              </div>
            </div>

            <div class="faq-item">
              <button class="faq-q" type="button">
                <span class="faq-q-text">Apakah War Risk Charge berlaku untuk semua negara tujuan?</span>
                <span class="faq-q-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
              </button>
              <div class="faq-a">
                <p>War Risk Charge berlaku untuk semua tujuan yang menggunakan layanan REGULER (SingPost), tidak terbatas pada negara tertentu. Besarnya sama untuk semua tujuan (mengacu pada persentase yang diatur sistem).</p>
              </div>
            </div>

          </div>
        </div>

        {{-- ─────────────────────────────
             KATEGORI 4: Layanan Pengiriman
        ───────────────────────────── --}}
        <div id="cat4" class="faq-category">
          <div class="faq-cat-header">
            <div class="faq-cat-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
            </div>
            <div class="faq-cat-meta">
              <div class="faq-cat-badge">
                <svg width="8" height="8" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
                Kategori 04
              </div>
              <h2>Layanan Pengiriman</h2>
              <p>Perbandingan semua pilihan layanan yang tersedia di Indo Cahaya Express</p>
            </div>
          </div>
          <div class="faq-list">

            <div class="faq-item">
              <button class="faq-q" type="button">
                <span class="faq-q-text">Apa saja layanan pengiriman yang tersedia?</span>
                <span class="faq-q-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
              </button>
              <div class="faq-a">
                <table class="faq-table">
                  <thead><tr><th>Layanan</th><th>Mitra</th><th>Maks. Berat</th><th>Estimasi</th><th>Surcharge</th></tr></thead>
                  <tbody>
                    <tr><td><span class="badge-service badge-yellow">PRIORITY</span></td><td>DHL</td><td>30 kg</td><td>3–5 hari kerja</td><td>Tidak ada</td></tr>
                    <tr><td><span class="badge-service badge-purple">FedEx</span></td><td>FedEx</td><td>30 kg</td><td>12–15 hari kerja</td><td>Tidak ada</td></tr>
                    <tr><td><span class="badge-service badge-navy">US REGULER</span></td><td>USPS</td><td>2 kg</td><td>7–14 hari kerja</td><td>Tidak ada</td></tr>
                    <tr><td><span class="badge-service badge-green">REGULER</span></td><td>SingPost</td><td>2 kg</td><td>Sesuai tabel rate</td><td>War Risk + DDP (USA)</td></tr>
                    <tr><td><span class="badge-service badge-navy">FAST ASIA</span></td><td>TLX</td><td>30 kg</td><td>5–7 hari kerja</td><td>Tidak ada</td></tr>
                    <tr><td><span class="badge-service badge-red">FLASH</span></td><td>Aramex</td><td>20 kg</td><td>3–5 hari kerja</td><td>Biaya TESS</td></tr>
                    <tr><td><span class="badge-service badge-green">FLASH AUSSY</span></td><td>TGE</td><td>30 kg</td><td>5–7 hari kerja</td><td>Tidak ada</td></tr>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="faq-item">
              <button class="faq-q" type="button">
                <span class="faq-q-text">Apa perbedaan layanan REGULER dan US REGULER?</span>
                <span class="faq-q-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
              </button>
              <div class="faq-a">
                <p><strong>REGULER</strong> menggunakan mitra SingPost dan berlaku untuk banyak negara tujuan, termasuk USA. Layanan ini memiliki War Risk Charge dan DDP (khusus USA).</p>
                <p><strong>US REGULER</strong> menggunakan mitra USPS dan ditujukan khusus ke Amerika Serikat. Layanan ini <em>tidak</em> memiliki War Risk Charge maupun DDP secara otomatis.</p>
                <div class="faq-highlight">
                  <strong>Perbedaan penting dalam perhitungan berat:</strong> Layanan <strong>REGULER</strong> hanya menggunakan <em>berat fisik</em> (tidak diperhitungkan volumetrik), sedangkan layanan lain menggunakan <em>max(berat fisik, berat volumetrik)</em>.
                </div>
              </div>
            </div>

            <div class="faq-item">
              <button class="faq-q" type="button">
                <span class="faq-q-text">Layanan mana yang terbaik untuk pengiriman ke Amerika Serikat?</span>
                <span class="faq-q-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
              </button>
              <div class="faq-a">
                <p>Tergantung kebutuhan Anda:</p>
                <ul>
                  <li><strong>Paket ringan (&lt;2 kg), harga ekonomis:</strong> REGULER atau US REGULER. Perhatikan bahwa REGULER ada War Risk + DDP untuk USA.</li>
                  <li><strong>Paket berat (&gt;2 kg), kecepatan penting:</strong> PRIORITY (DHL) – tanpa surcharge, estimasi 3–5 hari kerja.</li>
                  <li><strong>Paket sedang, nilai barang rendah:</strong> US REGULER (USPS) – estimasi 7–14 hari, tanpa DDP/War Risk.</li>
                </ul>
                <div class="faq-info">
                  <strong>Saran:</strong> Gunakan kalkulator ongkir kami untuk membandingkan total biaya semua layanan sebelum memesan.
                </div>
              </div>
            </div>

          </div>
        </div>

        {{-- ─────────────────────────────
             KATEGORI 5: Berat & Dimensi
        ───────────────────────────── --}}
        <div id="cat5" class="faq-category">
          <div class="faq-cat-header">
            <div class="faq-cat-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
            </div>
            <div class="faq-cat-meta">
              <div class="faq-cat-badge">
                <svg width="8" height="8" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
                Kategori 05
              </div>
              <h2>Berat &amp; Dimensi Paket</h2>
              <p>Cara menghitung berat dibebankan dan batas berat maksimal</p>
            </div>
          </div>
          <div class="faq-list">

            <div class="faq-item">
              <button class="faq-q" type="button">
                <span class="faq-q-text">Apa itu berat volumetrik dan bagaimana cara menghitungnya?</span>
                <span class="faq-q-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
              </button>
              <div class="faq-a">
                <p>Berat volumetrik adalah konversi dimensi fisik paket (panjang × lebar × tinggi) menjadi satuan berat, sebagai ukuran ruang yang digunakan di pesawat/kendaraan.</p>
                <div class="faq-formula">
                  Berat Volumetrik (kg) = (Panjang × Lebar × Tinggi) ÷ 5000<br>
                  <span>──────────────────────────────────────────────</span><br>
                  Contoh:<br>
                  Dimensi = 30 cm × 20 cm × 25 cm<br>
                  Volumetrik = (30 × 20 × 25) ÷ 5000 = 15.000 ÷ 5000 = <strong>3 kg</strong>
                </div>
              </div>
            </div>

            <div class="faq-item">
              <button class="faq-q" type="button">
                <span class="faq-q-text">Apa itu berat dibebankan (chargeable weight)?</span>
                <span class="faq-q-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
              </button>
              <div class="faq-a">
                <p>Berat dibebankan adalah berat yang dijadikan dasar perhitungan ongkos kirim. Aturannya berbeda tergantung layanan:</p>
                <table class="faq-table">
                  <thead><tr><th>Layanan</th><th>Berat Dibebankan</th></tr></thead>
                  <tbody>
                    <tr><td><span class="badge-service badge-green">REGULER</span></td><td>= Berat Fisik saja (volumetrik diabaikan)</td></tr>
                    <tr><td>Semua layanan lainnya</td><td>= Max (Berat Fisik, Berat Volumetrik)</td></tr>
                  </tbody>
                </table>
                <div class="faq-highlight">
                  <strong>Contoh:</strong> Paket berat fisik 1 kg, volumetrik 3 kg.<br>
                  Layanan REGULER → dibebankan 1 kg.<br>
                  Layanan PRIORITY → dibebankan 3 kg.
                </div>
              </div>
            </div>

            <div class="faq-item">
              <button class="faq-q" type="button">
                <span class="faq-q-text">Berapa batas berat maksimal per layanan?</span>
                <span class="faq-q-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
              </button>
              <div class="faq-a">
                <ul>
                  <li><strong>REGULER &amp; US REGULER</strong> — Maksimal 2 kg</li>
                  <li><strong>FLASH (Aramex)</strong> — Maksimal 20 kg</li>
                  <li><strong>PRIORITY, FedEx, FAST ASIA, FLASH AUSSY</strong> — Maksimal 30 kg</li>
                  <li><strong>Batas sistem global</strong> — Default 70 kg (dapat diubah admin)</li>
                </ul>
                <div class="faq-info">
                  Paket yang melebihi batas berat maksimal layanan tidak akan tersedia untuk dipilih pada kalkulator ongkir.
                </div>
              </div>
            </div>

          </div>
        </div>

        {{-- ─────────────────────────────
             KATEGORI 6: Invoice & Pembayaran
        ───────────────────────────── --}}
        <div id="cat6" class="faq-category">
          <div class="faq-cat-header">
            <div class="faq-cat-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            </div>
            <div class="faq-cat-meta">
              <div class="faq-cat-badge">
                <svg width="8" height="8" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
                Kategori 06
              </div>
              <h2>Invoice &amp; Pembayaran</h2>
              <p>Struktur invoice, komponen biaya, dan proses pembayaran</p>
            </div>
          </div>
          <div class="faq-list">

            <div class="faq-item">
              <button class="faq-q" type="button">
                <span class="faq-q-text">Apa saja komponen biaya dalam invoice ICE?</span>
                <span class="faq-q-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
              </button>
              <div class="faq-a">
                <table class="faq-table">
                  <thead><tr><th>Komponen</th><th>Keterangan</th></tr></thead>
                  <tbody>
                    <tr><td><strong>Subtotal</strong></td><td>Total ongkos kirim dasar dari semua shipment dalam invoice</td></tr>
                    <tr><td><strong>War Risk Charge</strong></td><td>Biaya risiko perang (khusus REGULER)</td></tr>
                    <tr><td><strong>DDP</strong></td><td>Bea masuk &amp; pajak impor prabayar (khusus REGULER ke USA)</td></tr>
                    <tr><td><strong>Aramex Surcharge</strong></td><td>Biaya TESS (khusus layanan FLASH)</td></tr>
                    <tr><td><strong>Grand Total</strong></td><td>Subtotal + War Risk + DDP + Surcharge lainnya</td></tr>
                  </tbody>
                </table>
                <div class="faq-formula">
                  Grand Total = Subtotal + War Risk Charge + DDP + Aramex Surcharge
                </div>
              </div>
            </div>

            <div class="faq-item">
              <button class="faq-q" type="button">
                <span class="faq-q-text">Apa yang terjadi setelah invoice saya dibayar (Paid)?</span>
                <span class="faq-q-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
              </button>
              <div class="faq-a">
                <p>Setelah invoice ditandai <strong>Paid</strong> oleh admin, semua shipment yang terkait dengan invoice tersebut akan secara otomatis diperbarui statusnya dari <em>Pending</em> menjadi <em>Processing</em>.</p>
                <div class="faq-info">
                  Setelah status <strong>Processing</strong>, tim kami akan segera memproses pengiriman barang Anda dan memperbarui nomor tracking.
                </div>
              </div>
            </div>

            <div class="faq-item">
              <button class="faq-q" type="button">
                <span class="faq-q-text">Bisakah invoice yang sudah dibayar diubah atau dihapus?</span>
                <span class="faq-q-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
              </button>
              <div class="faq-a">
                <p>Invoice yang sudah berstatus <strong>Paid</strong> tidak dapat diubah nilai DDP-nya secara otomatis (recalculate hanya berlaku untuk invoice Unpaid). Untuk perubahan pada invoice yang sudah Paid, silakan hubungi tim admin secara langsung.</p>
              </div>
            </div>

          </div>
        </div>

        {{-- ─────────────────────────────
             KATEGORI 7: Tracking & Status
        ───────────────────────────── --}}
        <div id="cat7" class="faq-category">
          <div class="faq-cat-header">
            <div class="faq-cat-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            </div>
            <div class="faq-cat-meta">
              <div class="faq-cat-badge">
                <svg width="8" height="8" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
                Kategori 07
              </div>
              <h2>Tracking &amp; Status Pengiriman</h2>
              <p>Alur status paket dari Pending hingga Delivered</p>
            </div>
          </div>
          <div class="faq-list">

            <div class="faq-item">
              <button class="faq-q" type="button">
                <span class="faq-q-text">Apa saja status pengiriman dan artinya?</span>
                <span class="faq-q-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
              </button>
              <div class="faq-a">
                <table class="faq-table">
                  <thead><tr><th>Status</th><th>Arti</th></tr></thead>
                  <tbody>
                    <tr><td><span class="badge-service badge-yellow">Pending</span></td><td>Shipment dibuat, menunggu pembayaran invoice</td></tr>
                    <tr><td><span class="badge-service badge-navy">Processing</span></td><td>Invoice Paid, paket sedang diproses &amp; disiapkan</td></tr>
                    <tr><td><span class="badge-service badge-purple">In Transit</span></td><td>Paket sedang dalam perjalanan menuju tujuan</td></tr>
                    <tr><td><span class="badge-service badge-green">Delivered</span></td><td>Paket telah diterima oleh penerima</td></tr>
                    <tr><td><span class="badge-service badge-red">Cancelled</span></td><td>Pengiriman dibatalkan (tidak termasuk dalam laporan pendapatan)</td></tr>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="faq-item">
              <button class="faq-q" type="button">
                <span class="faq-q-text">Bagaimana cara melacak paket saya?</span>
                <span class="faq-q-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
              </button>
              <div class="faq-a">
                <p>Setelah shipment dibuat, Anda akan mendapatkan <strong>nomor tracking</strong> dengan format <code>ICE[YYYYMMDD][8 karakter unik]</code>. Gunakan nomor ini di halaman Tracking kami.</p>
                <p>Riwayat tracking dimulai otomatis dari status <em>"Shipment created, waiting for pickup"</em> di lokasi Jakarta, Indonesia saat paket pertama kali dibuat.</p>
              </div>
            </div>

          </div>
        </div>

        {{-- ─────────────────────────────
             KATEGORI 8: Barang Terlarang
        ───────────────────────────── --}}
        <div id="cat8" class="faq-category">
          <div class="faq-cat-header">
            <div class="faq-cat-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
            </div>
            <div class="faq-cat-meta">
              <div class="faq-cat-badge">
                <svg width="8" height="8" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
                Kategori 08
              </div>
              <h2>Barang Terlarang &amp; Pembatasan</h2>
              <p>Daftar barang yang tidak dapat dikirimkan melalui ICE</p>
            </div>
          </div>
          <div class="faq-list">

            <div class="faq-item">
              <button class="faq-q" type="button">
                <span class="faq-q-text">Barang apa saja yang tidak boleh dikirim?</span>
                <span class="faq-q-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
              </button>
              <div class="faq-a">
                <ul>
                  <li>Narkotika, psikotropika, dan zat adiktif terlarang dalam bentuk apapun.</li>
                  <li>Senjata api, amunisi, bahan peledak, atau peralatan militer.</li>
                  <li>Uang tunai, cek, surat berharga, atau instrumen keuangan lainnya.</li>
                  <li>Hewan hidup atau produk hewan yang dilindungi hukum internasional (CITES).</li>
                  <li>Bahan berbahaya, radioaktif, mudah terbakar, atau beracun.</li>
                  <li>Barang-barang yang melanggar hak kekayaan intelektual (barang palsu/tiruan).</li>
                </ul>
                <div class="faq-highlight">
                  <strong>Sanksi:</strong> Pengirim yang terbukti mengirimkan barang terlarang akan dikenakan pembatalan layanan tanpa pengembalian biaya dan dilaporkan kepada pihak berwenang.
                </div>
              </div>
            </div>

            <div class="faq-item">
              <button class="faq-q" type="button">
                <span class="faq-q-text">Apa yang terjadi jika paket tertahan di bea cukai?</span>
                <span class="faq-q-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
              </button>
              <div class="faq-a">
                <p>Jika paket tertahan di bea cukai negara tujuan, ICE akan menginformasikan kepada pengirim. Penyebab umum penahanan:</p>
                <ul>
                  <li>Nilai deklarasi tidak sesuai atau dokumen pendukung tidak lengkap.</li>
                  <li>Barang memerlukan izin khusus di negara tujuan.</li>
                  <li>Identitas penerima tidak jelas atau tidak dapat dihubungi.</li>
                </ul>
                <div class="faq-info">
                  Untuk layanan REGULER ke USA yang menggunakan DDP, risiko penahanan akibat masalah bea cukai jauh lebih kecil karena biaya sudah dibayar di muka.
                </div>
              </div>
            </div>

          </div>
        </div>

        {{-- ── No Result State ── --}}
        <div class="faq-noresult" id="faqNoResult">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <h4>Pertanyaan tidak ditemukan</h4>
          <p>Coba kata kunci lain atau hubungi tim kami secara langsung.</p>
        </div>

        {{-- ── Contact CTA ── --}}
        <div class="faq-contact-card">
          <h3>Masih Ada Pertanyaan?</h3>
          <p>Tim Customer Service kami siap membantu Anda 24/7.</p>
          <div class="faq-contact-btns">
            <a href="{{ route('customer-service') }}" class="faq-btn-primary">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
              Hubungi CS
            </a>
            <a href="https://wa.me/+{{ preg_replace('/[^0-9]/', '', $globalSettings['site_phone']) }}" target="_blank" class="faq-btn-outline">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2.18h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.89a16 16 0 0 0 6 6l.94-.94a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
              WhatsApp
            </a>
            <a href="{{ route('terms') }}" class="faq-btn-outline">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
              Syarat &amp; Ketentuan
            </a>
          </div>
        </div>

      </div>{{-- /.faq-content --}}
    </div>{{-- /.faq-container --}}
  </div>{{-- /.faq-body --}}
</div>{{-- /.faq-page --}}

<script>
// ── Accordion ──────────────────────────────────────
document.querySelectorAll('.faq-q').forEach(btn => {
  btn.addEventListener('click', () => {
    const item = btn.closest('.faq-item');
    const isOpen = item.classList.contains('open');
    // close all
    document.querySelectorAll('.faq-item.open').forEach(el => el.classList.remove('open'));
    // toggle current
    if (!isOpen) item.classList.add('open');
  });
});

// ── Scroll Spy yang lebih akurat ────────────────────
const categories = document.querySelectorAll('.faq-category');
const tocLinks   = document.querySelectorAll('.faq-toc-link');

function updateActiveToc() {
  let current = '';
  // Cari kategori yang paling atas terlihat di viewport
  for (let i = 0; i < categories.length; i++) {
    const cat = categories[i];
    const rect = cat.getBoundingClientRect();
    // Jika bagian atas kategori sudah melewati batas atas viewport (dengan offset)
    if (rect.top <= 150) {
      current = '#' + cat.id;
    } else {
      break;
    }
  }
  // Jika belum ada yang terdeteksi, gunakan kategori pertama
  if (!current && categories.length) current = '#' + categories[0].id;

  tocLinks.forEach(link => {
    const href = link.getAttribute('href');
    link.classList.toggle('active', href === current);
  });
}

// Event listener scroll
window.addEventListener('scroll', updateActiveToc);
window.addEventListener('load', updateActiveToc);
window.addEventListener('resize', updateActiveToc);

// ── Smooth scroll saat klik TOC ────────────────────
tocLinks.forEach(link => {
  link.addEventListener('click', function(e) {
    e.preventDefault();
    const targetId = this.getAttribute('href');
    const targetElement = document.querySelector(targetId);
    if (targetElement) {
      const offsetTop = targetElement.getBoundingClientRect().top + window.scrollY - 80;
      window.scrollTo({ top: offsetTop, behavior: 'smooth' });
      // Update active state setelah scroll
      setTimeout(updateActiveToc, 100);
    }
  });
});

// ── Search / Filter ──────────────────────────────────
const searchInput = document.getElementById('faqSearch');
const noResult    = document.getElementById('faqNoResult');

searchInput.addEventListener('input', () => {
  const q = searchInput.value.toLowerCase().trim();
  let hasVisible = false;

  document.querySelectorAll('.faq-item').forEach(item => {
    const text = item.innerText.toLowerCase();
    const match = !q || text.includes(q);
    item.style.display = match ? '' : 'none';
    if (match) hasVisible = true;
  });

  document.querySelectorAll('.faq-category').forEach(cat => {
    const visibleItems = [...cat.querySelectorAll('.faq-item')].filter(i => i.style.display !== 'none');
    cat.style.display = visibleItems.length ? '' : 'none';
  });

  // Auto-open single result
  if (q) {
    const visible = document.querySelectorAll('.faq-item:not([style*="display: none"])');
    if (visible.length === 1) visible[0].classList.add('open');
  }

  noResult.style.display = hasVisible ? 'none' : 'block';
});
</script>
@endsection