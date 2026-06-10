@extends('layouts.app')

@section('title', 'Syarat & Ketentuan - Indo Cahaya Express')

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

.tc-page { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; color: var(--text-primary); background: var(--white); }

/* Hero */
.tc-hero {
  position: relative; min-height: 45vh;
  display: flex; align-items: center; overflow: hidden;
  background: var(--navy-900);
}
.tc-hero-bg {
  position: absolute; inset: 0;
  background:
    radial-gradient(ellipse 100% 80% at 100% 0%, rgba(20,56,160,0.55) 0%, transparent 55%),
    radial-gradient(ellipse 70% 60% at 0% 100%, rgba(227,30,36,0.10) 0%, transparent 50%),
    linear-gradient(168deg, #060F2E 0%, #0B1C55 45%, #091640 100%);
  z-index: 0;
}
.tc-hero-grid {
  position: absolute; inset: 0;
  background-image: radial-gradient(circle, rgba(255,255,255,0.055) 1px, transparent 1px);
  background-size: 44px 44px;
  mask-image: radial-gradient(ellipse 90% 80% at 50% 50%, black 40%, transparent 80%);
  z-index: 0;
}
.tc-hero .container { position: relative; z-index: 2; text-align: center; padding: 4rem 2rem; max-width: 900px; margin: 0 auto; }
.tc-eyebrow {
  display: inline-flex; align-items: center; gap: 0.5rem;
  background: rgba(227,30,36,0.1); border: 1px solid rgba(227,30,36,0.28);
  color: rgba(255,120,120,0.95); border-radius: 99px;
  padding: 0.35rem 1rem; font-size: 0.68rem; font-weight: 800;
  letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 1.5rem;
}
.tc-eyebrow svg { width: 10px; height: 10px; }
.tc-hero h1 {
  font-size: clamp(2rem, 4vw, 3.6rem); font-weight: 900;
  color: #fff; letter-spacing: -0.04em; line-height: 1.05; margin-bottom: 1rem;
}
.tc-hero h1 span {
  display: block; font-family: 'DM Serif Display', serif;
  font-style: italic; font-weight: 400; color: var(--red);
  font-size: 1.08em;
}
.tc-hero p { font-size: 0.95rem; color: rgba(255,255,255,0.5); line-height: 1.8; max-width: 560px; margin: 0 auto; }

/* Layout utama (flex dengan sidebar) */
.tc-body { padding: 5rem 0; background: var(--surface); }
.tc-container { 
  max-width: 1440px; 
  margin: 0 auto; 
  padding: 0 2rem; 
  display: flex; 
  gap: 2rem; 
  align-items: flex-start;
}

/* Sidebar (gaya Settings) */
.tc-sidebar {
  width: 260px;
  flex-shrink: 0;
  background: var(--white);
  border: 1px solid var(--border);
  border-radius: 18px;
  overflow: hidden;
  position: sticky;
  top: 1.5rem;
  box-shadow: var(--shadow-sm);
}
.tc-sidebar-hdr {
  padding: 1rem 1.25rem;
  background: var(--navy-900);
}
.tc-sidebar-hdr h3 {
  font-size: 0.7rem; font-weight: 800; text-transform: uppercase;
  letter-spacing: 0.12em; color: rgba(255,255,255,0.75); margin: 0;
  display: flex; align-items: center; gap: 0.5rem;
}
.tc-sidebar-hdr h3 svg { width: 14px; height: 14px; opacity: 0.7; }
.tc-nav {
  display: flex;
  flex-direction: column;
  padding: 0.4rem 0;
}
.tc-nav a {
  display: flex; align-items: center; gap: 0.65rem;
  padding: 0.75rem 1.25rem;
  font-size: 0.82rem; font-weight: 600;
  color: var(--text-2); text-decoration: none;
  border-left: 3px solid transparent;
  transition: all 0.15s;
}
.tc-nav a svg { width: 16px; height: 16px; color: var(--text-muted); flex-shrink: 0; transition: color 0.15s; }
.tc-nav a.active {
  background: rgba(227,30,36,0.05);
  border-left-color: var(--red);
  color: var(--red); font-weight: 700;
}
.tc-nav a.active svg { color: var(--red); }
.tc-nav a:hover:not(.active) {
  background: var(--surface-2); border-left-color: var(--border-2); color: var(--navy-900);
}
.tc-nav a:hover:not(.active) svg { color: var(--navy-900); }

/* Main konten */
.tc-content {
  flex: 1;
  min-width: 0;
}

/* Section blocks */
.tc-section {
  background: var(--white); border: 1px solid var(--border);
  border-radius: 20px; padding: 2rem; margin-bottom: 1.5rem;
  box-shadow: var(--shadow-card); transition: all 0.3s var(--ease-out);
}
.tc-section:hover { border-color: var(--border-2); box-shadow: var(--shadow-md); }
.tc-section-num {
  display: inline-flex; align-items: center; gap: 0.45rem;
  background: rgba(227,30,36,0.07); border: 1px solid rgba(227,30,36,0.14);
  color: var(--red); border-radius: 99px;
  padding: 0.3rem 0.75rem; font-size: 0.65rem; font-weight: 800;
  letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 1rem;
}
.tc-section h2 {
  font-size: 1.25rem; font-weight: 800; color: var(--text-primary);
  letter-spacing: -0.025em; margin: 0 0 1rem; line-height: 1.3;
}
.tc-section p {
  font-size: 0.9rem; color: var(--text-2);
  line-height: 1.8; margin-bottom: 1rem;
}
.tc-section p:last-child { margin-bottom: 0; }
.tc-list {
  list-style: none; padding: 0; margin: 0.5rem 0 1rem;
  display: flex; flex-direction: column; gap: 0.5rem;
}
.tc-list li {
  display: flex; align-items: flex-start; gap: 0.6rem;
  font-size: 0.875rem; color: var(--text-2); line-height: 1.65;
}
.tc-list li::before {
  content: ''; width: 6px; height: 6px;
  background: var(--red); border-radius: 50%;
  margin-top: 0.5rem; flex-shrink: 0;
}
.tc-highlight {
  background: rgba(227,30,36,0.04); border: 1px solid rgba(227,30,36,0.12);
  border-left: 3px solid var(--red); border-radius: 8px;
  padding: 1rem 1.25rem; margin: 1rem 0;
  font-size: 0.875rem; color: var(--text-2); line-height: 1.7;
}
.tc-highlight strong { color: var(--text-primary); }
.tc-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.75rem; margin: 1rem 0; }
.tc-grid-item {
  background: var(--surface-2); border: 1px solid var(--border);
  border-radius: 12px; padding: 1rem 1.25rem;
}
.tc-grid-item h4 { font-size: 0.8rem; font-weight: 800; color: var(--text-primary); margin: 0 0 0.35rem; }
.tc-grid-item p { font-size: 0.8rem; color: var(--text-muted); margin: 0; line-height: 1.6; }

/* Contact CTA */
.tc-contact-card {
  background: linear-gradient(155deg, var(--navy-800) 0%, var(--navy-700) 100%);
  border-radius: 20px; padding: 2rem; text-align: center;
  position: relative; overflow: hidden; margin-top: 1.5rem;
}
.tc-contact-card::before {
  content: ''; position: absolute; top: -1px; left: 15%; right: 15%; height: 1px;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.25), transparent);
}
.tc-contact-card h3 { font-size: 1.2rem; font-weight: 800; color: #fff; margin: 0 0 0.5rem; }
.tc-contact-card p { font-size: 0.875rem; color: rgba(255,255,255,0.55); margin: 0 0 1.5rem; }
.tc-contact-btns { display: flex; gap: 0.75rem; justify-content: center; flex-wrap: wrap; }
.tc-btn-primary {
  display: inline-flex; align-items: center; gap: 0.5rem;
  background: var(--red); color: #fff; padding: 0.75rem 1.5rem;
  border-radius: 8px; font-weight: 700; font-size: 0.875rem;
  text-decoration: none; transition: all 0.25s var(--ease-out);
  box-shadow: 0 8px 24px rgba(227,30,36,0.4);
}
.tc-btn-primary:hover { background: var(--red-hover); transform: translateY(-2px); }
.tc-btn-outline {
  display: inline-flex; align-items: center; gap: 0.5rem;
  background: transparent; color: rgba(255,255,255,0.7);
  border: 1.5px solid rgba(255,255,255,0.2); padding: 0.75rem 1.5rem;
  border-radius: 8px; font-weight: 700; font-size: 0.875rem;
  text-decoration: none; transition: all 0.25s var(--ease-out);
}
.tc-btn-outline:hover { background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.38); color: #fff; }

/* Responsive */
@media (max-width: 900px) {
  .tc-container { flex-direction: column; }
  .tc-sidebar { width: 100%; position: static; }
  .tc-nav { flex-direction: row; flex-wrap: wrap; padding: 0.5rem; gap: 0.25rem; }
  .tc-nav a { border-left: none; border-bottom: 2px solid transparent; border-radius: 8px; padding: 0.5rem 0.85rem; }
  .tc-nav a.active { border-left-color: transparent; border-bottom-color: var(--red); background: rgba(227,30,36,0.05); }
}
@media (max-width: 600px) {
  .tc-hero .container { padding: 3rem 1.25rem; }
  .tc-body { padding: 3rem 0; }
  .tc-container { padding: 0 1rem; gap: 1.5rem; }
  .tc-section { padding: 1.5rem; }
  .tc-grid { grid-template-columns: 1fr; }
}
</style>

<div class="tc-page">
  <section class="tc-hero">
    <div class="tc-hero-bg"></div>
    <div class="tc-hero-grid"></div>
    <div class="container">
      <div class="tc-eyebrow">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
        Dokumen Resmi
      </div>
      <h1>Syarat &amp; Ketentuan<span>Layanan Pengiriman</span></h1>
      <p>Harap baca dengan seksama sebelum menggunakan layanan Indo Cahaya Express.</p>
    </div>
  </section>

  <div class="tc-body">
    <div class="tc-container">

      {{-- Sidebar (gaya Settings) --}}
      <aside class="tc-sidebar">
        <div class="tc-sidebar-hdr">
          <h3>
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="3"/>
              <path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/>
            </svg>
            Daftar Isi
          </h3>
        </div>
        <nav class="tc-nav">
          <a href="#s1"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg> Definisi & Cakupan</a>
          <a href="#s2"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg> Hak & Kewajiban</a>
          <a href="#s3"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg> Larangan Pengiriman</a>
          <a href="#s4"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg> Tarif & Pembayaran</a>
          <a href="#s5"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> Waktu Pengiriman</a>
          <a href="#s6"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M20 12H4M12 4v16"/></svg> Asuransi & Klaim</a>
          <a href="#s7"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 6h18M3 12h18M3 18h18"/></svg> Bea Cukai</a>
          <a href="#s8"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg> Tanggung Jawab</a>
          <a href="#s9"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 9h6M9 15h6"/></svg> Privasi & Data</a>
          <a href="#s10"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg> Sengketa</a>
        </nav>
      </aside>

      {{-- Main Content --}}
      <div class="tc-content">

        <div id="s1" class="tc-section">
          <div class="tc-section-num"><svg width="8" height="8" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg> Pasal 1</div>
          <h2>Definisi &amp; Cakupan Layanan</h2>
          <p>Syarat dan ketentuan ini mengatur hubungan hukum antara Indo Cahaya Express (selanjutnya "ICE" atau "Perusahaan") dengan setiap pengguna layanan pengiriman internasional yang disediakan.</p>
          <p>Dengan menggunakan layanan ICE, Anda dianggap telah membaca, memahami, dan menyetujui seluruh syarat dan ketentuan yang berlaku.</p>
          <div class="tc-grid">
            <div class="tc-grid-item"><h4>Pengirim</h4><p>Pihak yang menyerahkan paket untuk dikirimkan melalui layanan ICE.</p></div>
            <div class="tc-grid-item"><h4>Penerima</h4><p>Pihak yang berhak menerima paket di alamat tujuan pengiriman.</p></div>
            <div class="tc-grid-item"><h4>Layanan</h4><p>Jasa pengiriman internasional door-to-door yang disediakan ICE.</p></div>
            <div class="tc-grid-item"><h4>Tarif</h4><p>Biaya pengiriman berdasarkan berat, dimensi, dan negara tujuan.</p></div>
          </div>
        </div>

        <div id="s2" class="tc-section">
          <div class="tc-section-num"><svg width="8" height="8" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg> Pasal 2</div>
          <h2>Hak &amp; Kewajiban Pengirim</h2>
          <p>Pengirim memiliki hak untuk mendapatkan layanan pengiriman sesuai dengan standar yang dijanjikan. Namun pengirim juga memiliki kewajiban sebagai berikut:</p>
          <ul class="tc-list">
            <li>Memberikan informasi pengiriman yang akurat dan lengkap termasuk nama, alamat, dan nomor kontak penerima.</li>
            <li>Mengemas paket dengan layak sehingga tidak rusak selama proses pengiriman.</li>
            <li>Memastikan isi paket tidak termasuk dalam daftar barang terlarang untuk dikirim.</li>
            <li>Melunasi biaya pengiriman sesuai dengan tarif yang berlaku sebelum pengiriman diproses.</li>
            <li>Menyediakan dokumen pendukung (invoice, packing list) untuk keperluan bea cukai bila diperlukan.</li>
          </ul>
        </div>

        <div id="s3" class="tc-section">
          <div class="tc-section-num"><svg width="8" height="8" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg> Pasal 3</div>
          <h2>Barang Terlarang &amp; Pembatasan</h2>
          <p>ICE tidak bertanggung jawab atas konsekuensi hukum maupun kerugian yang timbul akibat pengiriman barang-barang berikut:</p>
          <ul class="tc-list">
            <li>Narkotika, psikotropika, dan zat adiktif terlarang dalam bentuk apapun.</li>
            <li>Senjata api, amunisi, bahan peledak, atau peralatan militer.</li>
            <li>Uang tunai, cek, surat berharga, atau instrumen keuangan lainnya.</li>
            <li>Hewan hidup atau produk hewan yang dilindungi hukum internasional (CITES).</li>
            <li>Bahan berbahaya, radioaktif, mudah terbakar, atau beracun.</li>
            <li>Barang-barang yang melanggar hak kekayaan intelektual (barang palsu/tiruan).</li>
          </ul>
          <div class="tc-highlight"><strong>Penting:</strong> Pengirim yang terbukti mengirimkan barang terlarang akan dikenakan sanksi berupa pembatalan layanan tanpa pengembalian biaya dan dilaporkan kepada pihak berwenang.</div>
        </div>

        <div id="s4" class="tc-section">
          <div class="tc-section-num"><svg width="8" height="8" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg> Pasal 4</div>
          <h2>Tarif &amp; Ketentuan Pembayaran</h2>
          <p>Tarif pengiriman dihitung berdasarkan berat aktual atau berat volumetrik (mana yang lebih besar), negara tujuan, dan jenis layanan yang dipilih.</p>
          <ul class="tc-list">
            <li>Berat volumetrik = (Panjang × Lebar × Tinggi) / 5000 dalam satuan kilogram.</li>
            <li>Pembayaran harus dilakukan penuh sebelum barang diproses untuk pengiriman.</li>
            <li>Tarif dapat berubah sewaktu-waktu mengikuti perubahan kurs dan kebijakan mitra logistik.</li>
            <li>Biaya tambahan dapat dikenakan untuk daerah terpencil, layanan khusus, atau kondisi tertentu.</li>
          </ul>
        </div>

        <div id="s5" class="tc-section">
          <div class="tc-section-num"><svg width="8" height="8" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg> Pasal 5</div>
          <h2>Estimasi &amp; Keterlambatan Pengiriman</h2>
          <p>Waktu pengiriman yang tertera merupakan estimasi dan bukan jaminan. ICE tidak bertanggung jawab atas keterlambatan yang disebabkan oleh:</p>
          <ul class="tc-list">
            <li>Pemrosesan bea cukai di negara tujuan yang membutuhkan waktu lebih lama dari biasanya.</li>
            <li>Kondisi cuaca ekstrem, bencana alam, atau force majeure lainnya.</li>
            <li>Ketidaklengkapan dokumen yang disebabkan oleh pengirim atau penerima.</li>
            <li>Penundaan dari pihak maskapai atau agen pengiriman internasional.</li>
            <li>Situasi pandemi, embargo, atau pembatasan wilayah tertentu.</li>
          </ul>
        </div>

        <div id="s6" class="tc-section">
          <div class="tc-section-num"><svg width="8" height="8" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg> Pasal 6</div>
          <h2>Asuransi &amp; Prosedur Klaim</h2>
          <p>Setiap pengiriman melalui ICE dilindungi oleh asuransi pengiriman. Nilai pertanggungan maksimal disesuaikan dengan nilai barang yang dideklarasikan.</p>
          <ul class="tc-list">
            <li>Klaim kerusakan harus diajukan dalam 3 (tiga) hari kerja setelah paket diterima.</li>
            <li>Klaim kehilangan dapat diajukan setelah 30 (tiga puluh) hari dari tanggal pengiriman.</li>
            <li>Klaim wajib disertai foto kerusakan, bukti nilai barang, dan nomor resi pengiriman.</li>
            <li>Nilai klaim tidak dapat melebihi nilai yang dideklarasikan pada saat pengiriman.</li>
          </ul>
        </div>

        <div id="s7" class="tc-section">
          <div class="tc-section-num"><svg width="8" height="8" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg> Pasal 7</div>
          <h2>Bea Cukai &amp; Pajak Impor</h2>
          <p>Bea cukai dan pajak impor adalah tanggung jawab penerima barang sesuai dengan regulasi negara tujuan. ICE bertindak sebagai fasilitator, bukan penanggung pajak.</p>
          <div class="tc-highlight">Beberapa negara menerapkan kebijakan <strong>DDP (Delivered Duty Paid)</strong> yang mengharuskan pengirim membayar bea cukai di muka. Biaya DDP akan diinformasikan sebelum pengiriman diproses.</div>
        </div>

        <div id="s8" class="tc-section">
          <div class="tc-section-num"><svg width="8" height="8" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg> Pasal 8</div>
          <h2>Batasan Tanggung Jawab</h2>
          <p>Tanggung jawab ICE terbatas pada nilai barang yang dideklarasikan dan tidak mencakup kerugian tidak langsung, kehilangan keuntungan, atau kerugian konsekuensial lainnya.</p>
        </div>

        <div id="s9" class="tc-section">
          <div class="tc-section-num"><svg width="8" height="8" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg> Pasal 9</div>
          <h2>Privasi &amp; Perlindungan Data</h2>
          <p>ICE berkomitmen menjaga kerahasiaan data pribadi pengguna. Data yang dikumpulkan hanya digunakan untuk keperluan operasional pengiriman dan tidak akan dijual atau dibagikan kepada pihak ketiga tanpa persetujuan pengguna, kecuali diwajibkan oleh hukum.</p>
        </div>

        <div id="s10" class="tc-section">
          <div class="tc-section-num"><svg width="8" height="8" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg> Pasal 10</div>
          <h2>Penyelesaian Sengketa &amp; Hukum yang Berlaku</h2>
          <p>Segala sengketa yang timbul dari penggunaan layanan ICE diselesaikan secara musyawarah mufakat. Apabila tidak tercapai kesepakatan, penyelesaian dilakukan melalui Pengadilan Negeri Jakarta Pusat sesuai hukum Republik Indonesia.</p>
        </div>

        <div class="tc-contact-card">
          <h3>Ada Pertanyaan tentang Syarat &amp; Ketentuan?</h3>
          <p>Tim kami siap membantu menjelaskan ketentuan layanan secara lebih detail.</p>
          <div class="tc-contact-btns">
            <a href="{{ route('customer-service') }}" class="tc-btn-primary">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
              Hubungi CS
            </a>
            <a href="https://wa.me/+{{ preg_replace('/[^0-9]/', '', $globalSettings['site_phone']) }}" target="_blank" class="tc-btn-outline">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2.18h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.89a16 16 0 0 0 6 6l.94-.94a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
              WhatsApp
            </a>
          </div>
        </div>

      </div>{{-- /.tc-content --}}
    </div>{{-- /.tc-container --}}
  </div>{{-- /.tc-body --}}
</div>{{-- /.tc-page --}}

<script>
// Scroll spy untuk Terms
const sectionsTerms = document.querySelectorAll('.tc-section');
const navTerms = document.querySelectorAll('.tc-nav a');

function updateActiveTerms() {
  let current = '';
  for (let i = 0; i < sectionsTerms.length; i++) {
    const rect = sectionsTerms[i].getBoundingClientRect();
    if (rect.top <= 150) {
      current = '#' + sectionsTerms[i].id;
    } else {
      break;
    }
  }
  if (!current && sectionsTerms.length) current = '#' + sectionsTerms[0].id;

  navTerms.forEach(link => {
    const href = link.getAttribute('href');
    link.classList.toggle('active', href === current);
  });
}

window.addEventListener('scroll', updateActiveTerms);
window.addEventListener('load', updateActiveTerms);
window.addEventListener('resize', updateActiveTerms);

// Smooth scroll
navTerms.forEach(link => {
  link.addEventListener('click', function(e) {
    e.preventDefault();
    const targetId = this.getAttribute('href');
    const targetEl = document.querySelector(targetId);
    if (targetEl) {
      const offsetTop = targetEl.getBoundingClientRect().top + window.scrollY - 80;
      window.scrollTo({ top: offsetTop, behavior: 'smooth' });
      setTimeout(updateActiveTerms, 100);
    }
  });
});
</script>
@endsection