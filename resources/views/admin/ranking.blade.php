@extends('layouts.app')
@section('title', 'Ranking Customer - Indo Cahaya Express')
@section('content')
@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300&display=swap');

/* ══ ICE Design System — Ranking ══ */
:root {
  --red:          #E31E24;
  --red-hover:    #C7181D;
  --red-deep:     #A0121A;
  --navy-900:     #060F2E;
  --navy-800:     #0A1A4A;
  --white:        #FFFFFF;
  --surface:      #FAFBFE;
  --surface-2:    #F1F5FC;
  --border:       #DDE6F5;
  --border-2:     #C8D6EE;
  --text-primary: #09183C;
  --text-2:       #3D5478;
  --text-muted:   #7A93B8;
  --green:        #16A34A;
  --shadow-xs:    0 1px 4px rgba(9,24,60,0.06);
  --shadow-lg:    0 16px 48px rgba(9,24,60,0.12);
  --ease-out:     cubic-bezier(0.22, 1, 0.36, 1);
  --ease-spring:  cubic-bezier(0.34, 1.56, 0.64, 1);
}

/* ── KEYFRAMES ── */
@keyframes slideInRight {
  from { opacity: 0; transform: translateX(80px); }
  to   { opacity: 1; transform: translateX(0); }
}
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(28px); }
  to   { opacity: 1; transform: translateY(0); }
}

/* ── PAGE SHELL ── */
.rk-shell {
  font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
  background: var(--surface);
  min-height: calc(100vh - 200px);
  padding: 3rem 0 5rem;
}
.rk-container {
  max-width: 1440px;
  margin: 0 auto;
  padding: 0 2rem;
}

/* ── HERO ── */
.rk-hero {
  position: relative;
  overflow: hidden;
  border-radius: 24px;
  margin-bottom: 2rem;
  box-shadow: 0 20px 60px rgba(6,15,46,0.30);
  min-height: 170px;
  display: flex;
  align-items: center;
}
.rk-hero-canvas {
  position: absolute; inset: 0; z-index: 0;
  background:
    radial-gradient(ellipse 100% 80% at 100% 0%,  rgba(20,56,160,0.55) 0%, transparent 55%),
    radial-gradient(ellipse 70%  60% at 0%  100%, rgba(227,30,36,0.10) 0%, transparent 50%),
    radial-gradient(ellipse 60%  70% at 55% 50%,  rgba(11,26,74,0.9)   0%, transparent 70%),
    linear-gradient(168deg, var(--navy-900) 0%, #0B1C55 45%, #091640 100%);
}
.rk-hero-canvas::after {
  content: '';
  position: absolute; inset: 0;
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.035'/%3E%3C/svg%3E");
  pointer-events: none; mix-blend-mode: overlay; opacity: 0.5;
}
.rk-hero-grid {
  position: absolute; inset: 0; z-index: 0;
  background-image: radial-gradient(circle, rgba(255,255,255,0.055) 1px, transparent 1px);
  background-size: 44px 44px;
  mask-image: radial-gradient(ellipse 90% 80% at 50% 50%, black 40%, transparent 80%);
}
.rk-hero-lines {
  position: absolute; inset: 0; z-index: 0; overflow: hidden;
}
.rk-hero-lines::before,
.rk-hero-lines::after {
  content: ''; position: absolute; top: 0; bottom: 0; width: 1px;
}
.rk-hero-lines::before {
  right: 34%;
  background: linear-gradient(to bottom, transparent 0%, rgba(227,30,36,0.35) 25%, rgba(227,30,36,0.15) 70%, transparent 100%);
}
.rk-hero-lines::after {
  left: 52%;
  background: linear-gradient(to bottom, transparent 10%, rgba(59,174,224,0.12) 40%, rgba(59,174,224,0.06) 75%, transparent 100%);
}
.rk-hero-glow {
  position: absolute; z-index: 0; border-radius: 50%; filter: blur(80px); pointer-events: none;
}
.rk-hero-glow-1 {
  width: 600px; height: 600px; top: -200px; right: -80px;
  background: radial-gradient(circle, rgba(20,56,160,0.4) 0%, transparent 65%);
}
.rk-hero-glow-2 {
  width: 350px; height: 350px; bottom: -100px; left: 0;
  background: radial-gradient(circle, rgba(227,30,36,0.12) 0%, transparent 65%);
}
.rk-hero-inner {
  position: relative; z-index: 2;
  width: 100%;
  padding: 2.5rem;
  display: flex; align-items: center; justify-content: space-between;
  gap: 2rem; flex-wrap: wrap;
}
.rk-hero-text { flex: 1; min-width: 260px; }
.rk-hero-eyebrow {
  display: inline-flex; align-items: center; gap: 0.6rem;
  margin-bottom: 1.1rem;
  padding: 0.4rem 1rem 0.4rem 0.55rem;
  border-radius: 99px;
  border: 1px solid rgba(227,30,36,0.3);
  background: rgba(227,30,36,0.07);
  backdrop-filter: blur(10px);
}
.rk-hero-eyebrow-dot {
  width: 22px; height: 22px; border-radius: 50%;
  background: linear-gradient(135deg, var(--red), var(--red-deep));
  display: flex; align-items: center; justify-content: center; flex-shrink: 0;
  box-shadow: 0 4px 12px rgba(227,30,36,0.4);
}
.rk-hero-eyebrow-dot svg { width: 11px; height: 11px; color: #fff; }
.rk-hero-eyebrow span {
  font-size: 0.68rem; font-weight: 800; letter-spacing: 0.12em;
  text-transform: uppercase; color: rgba(255,255,255,0.75);
  padding-right: 0.3rem;
}
.rk-hero h1 {
  font-size: clamp(1.75rem, 3.5vw, 2.4rem);
  font-weight: 900; line-height: 1.05;
  margin: 0 0 0.5rem; color: #fff;
  letter-spacing: -0.03em;
}
.rk-hero p {
  font-size: 0.95rem; color: rgba(255,255,255,0.55); margin: 0;
  font-weight: 400; line-height: 1.6;
}
/* Back button */
.rk-btn-back {
  display: inline-flex; align-items: center; gap: 6px;
  padding: 1rem 1.75rem;
  background: rgba(255,255,255,0.08); color: rgba(255,255,255,0.9);
  border-radius: 10px;
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-weight: 700; font-size: 0.92rem; letter-spacing: 0.01em;
  text-decoration: none; border: 1px solid rgba(255,255,255,0.15);
  backdrop-filter: blur(10px); flex-shrink: 0;
  transition: all 0.25s var(--ease-out);
  white-space: nowrap;
}
.rk-btn-back svg { width: 16px; height: 16px; flex-shrink: 0; }
.rk-btn-back:hover {
  background: rgba(255,255,255,0.16);
  border-color: rgba(255,255,255,0.3);
  color: #fff; transform: translateX(-2px);
}

/* ── STATS ── */
.rk-stats {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 1.25rem; margin-bottom: 2rem;
}
.o-stat {
  background: var(--white); border: 1px solid var(--border); border-radius: 18px;
  padding: 1.4rem; transition: all 0.3s var(--ease-out);
  position: relative; overflow: hidden;
}
.o-stat:hover { transform: translateY(-4px); box-shadow: var(--shadow-lg); border-color: var(--border-2); }
.o-stat::before {
  content: ''; position: absolute; top: 0; left: 0;
  width: 100%; height: 3px;
  background: var(--os-accent, var(--navy-900));
}
.o-stat[data-accent="navy"]  { --os-accent: var(--navy-900); }
.o-stat[data-accent="green"] { --os-accent: var(--green); }
.o-stat[data-accent="red"]   { --os-accent: var(--red); }
.o-stat-head {
  display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;
}
.o-stat-icon {
  width: 44px; height: 44px; border-radius: 12px;
  background: color-mix(in srgb, var(--os-accent) 10%, transparent);
  color: var(--os-accent);
  display: inline-flex; align-items: center; justify-content: center;
}
.o-stat-icon svg { width: 22px; height: 22px; }
.o-stat-tag {
  font-size: 0.68rem; font-weight: 800; padding: 0.25rem 0.55rem;
  border-radius: 99px;
  background: color-mix(in srgb, var(--os-accent) 10%, transparent);
  color: var(--os-accent); text-transform: uppercase; letter-spacing: 0.05em;
}
.o-stat-label { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-muted); margin: 0 0 0.4rem; }
.o-stat-val    { font-size: 1.85rem; font-weight: 900; color: var(--text-primary); line-height: 1; letter-spacing: -0.02em; }
.o-stat-val-sm { font-size: 1.2rem;  font-weight: 900; line-height: 1.2; letter-spacing: -0.01em; }
.o-stat-val-sm.red   { color: var(--red); }
.o-stat-val-sm.green { color: var(--green); }
.o-stat-sub    { font-size: 0.78rem; color: var(--text-2); margin-top: 0.35rem; }

/* ── TABLE CARD ── */
.rk-card {
  background: var(--white); border: 1px solid var(--border);
  border-radius: 18px; overflow: hidden; margin-bottom: 2rem;
}
.rk-card-header {
  padding: 1.1rem 1.4rem; display: flex; justify-content: space-between; align-items: center;
  border-bottom: 1px solid var(--border); background: var(--surface); flex-wrap: wrap; gap: 0.5rem;
}
.rk-card-header-left { display: flex; align-items: center; gap: 0.6rem; }
.rk-card-header-icon {
  width: 32px; height: 32px; border-radius: 9px;
  background: rgba(6,15,46,0.06); color: var(--navy-900);
  display: inline-flex; align-items: center; justify-content: center;
}
.rk-card-header-icon svg { width: 16px; height: 16px; }
.rk-card-header h3 { margin: 0; font-size: 1rem; font-weight: 800; color: var(--text-primary); letter-spacing: -0.01em; }
.rk-card-meta { font-size: 0.78rem; color: var(--text-muted); font-weight: 600; }
.rk-table-wrap { overflow-x: auto; }
.rk-tbl { width: 100%; border-collapse: collapse; }
.rk-tbl thead tr { background: var(--navy-900); }
.rk-tbl th {
  padding: 0.85rem 1rem; font-size: 0.68rem; font-weight: 800;
  color: rgba(255,255,255,0.85); text-align: left;
  letter-spacing: 0.1em; white-space: nowrap;
  border-bottom: 1px solid var(--border);
}
.rk-tbl td {
  padding: 0.95rem 1rem; font-size: 0.85rem; color: var(--text-2);
  border-bottom: 1px solid var(--border); vertical-align: middle; font-weight: 500;
}
.rk-tbl tr:last-child td { border-bottom: none; }
.rk-tbl tbody tr { transition: background 0.15s; }
.rk-tbl tbody tr:hover td { background: var(--surface-2); }

/* Top-3 row highlights */
.rk-tbl tbody tr.row-top1 td { background: rgba(255,215,0,0.04); }
.rk-tbl tbody tr.row-top2 td { background: rgba(192,192,192,0.04); }
.rk-tbl tbody tr.row-top3 td { background: rgba(205,127,50,0.04); }
.rk-tbl tbody tr.row-top1:hover td { background: rgba(255,215,0,0.08); }
.rk-tbl tbody tr.row-top2:hover td { background: rgba(192,192,192,0.08); }
.rk-tbl tbody tr.row-top3:hover td { background: rgba(205,127,50,0.08); }

/* ── RANK BADGE ── */
.rk-rank-badge {
  width: 36px; height: 36px; border-radius: 50%;
  display: inline-flex; align-items: center; justify-content: center;
  font-size: 0.875rem; font-weight: 900; flex-shrink: 0;
}
.rk-rank-1     { background: linear-gradient(135deg, #ffd700, #ffb800); color: #7a5200; box-shadow: 0 4px 14px rgba(255,215,0,0.45); }
.rk-rank-2     { background: linear-gradient(135deg, #c0c0c0, #a8a8a8); color: #fff; box-shadow: 0 4px 12px rgba(192,192,192,0.4); }
.rk-rank-3     { background: linear-gradient(135deg, #cd7f32, #b87333); color: #fff; box-shadow: 0 4px 12px rgba(205,127,50,0.4); }
.rk-rank-other { background: var(--surface-2); color: var(--text-muted); border: 1.5px solid var(--border); }

/* ── CUSTOMER INFO ── */
.rk-customer-name { font-weight: 700; color: var(--text-primary); font-size: 0.9rem; }
.rk-customer-sub  { font-size: 0.78rem; color: var(--text-muted); margin-top: 2px; }
.rk-val-highlight { font-weight: 800; color: var(--text-primary); }
.rk-val-green     { font-weight: 800; color: var(--green); }

/* ── PROGRESS BAR (shipment count visualizer) ── */
.rk-progress-wrap { display: flex; align-items: center; gap: 0.6rem; }
.rk-progress {
  flex: 1; height: 6px; background: var(--border);
  border-radius: 99px; overflow: hidden; min-width: 60px; max-width: 120px;
}
.rk-progress-fill {
  height: 100%; border-radius: 99px;
  background: linear-gradient(90deg, var(--navy-900), #1438A0);
  transition: width 0.6s var(--ease-out);
}

/* ── EMPTY ── */
.rk-empty { padding: 3.5rem 1.5rem; text-align: center; color: var(--text-muted); }
.rk-empty-icon {
  width: 64px; height: 64px; margin: 0 auto 1rem;
  border-radius: 16px; background: var(--surface-2);
  display: inline-flex; align-items: center; justify-content: center; color: var(--navy-900);
}
.rk-empty-icon svg { width: 28px; height: 28px; }
.rk-empty h4 { font-size: 1rem; font-weight: 800; color: var(--text-primary); margin: 0 0 0.4rem; }
.rk-empty p  { margin: 0; font-size: 0.85rem; }

/* ── RESPONSIVE ── */
@media (max-width: 1100px) { .rk-stats { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 768px) {
  .rk-container { padding: 0 1.25rem; }
  .rk-shell { padding: 1.5rem 0 3rem; }
  .rk-hero-inner { padding: 1.75rem 1.5rem; }
  .rk-stats { grid-template-columns: 1fr 1fr; gap: 1rem; }
  .rk-tbl th, .rk-tbl td { padding: 8px 10px; font-size: 0.78rem; }
  .rk-progress { display: none; }
}
@media (max-width: 480px) { .rk-stats { grid-template-columns: 1fr; } }
</style>
@endpush

<div class="rk-shell">
  <div class="rk-container">

    {{-- ═══ HERO ═══ --}}
    <section class="rk-hero">
      <div class="rk-hero-canvas"></div>
      <div class="rk-hero-grid"></div>
      <div class="rk-hero-lines"></div>
      <div class="rk-hero-glow rk-hero-glow-1"></div>
      <div class="rk-hero-glow rk-hero-glow-2"></div>
      <div class="rk-hero-inner">
        <div class="rk-hero-text">
          <div class="rk-hero-eyebrow">
            <div class="rk-hero-eyebrow-dot">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
              </svg>
            </div>
            <span>Customer Rank</span>
          </div>
          <h1>Ranking Customer</h1>
          <p>Daftar pemesan terbanyak berdasarkan pengiriman yang sudah delivered.</p>
        </div>
        <a href="{{ route('orders') }}" class="rk-btn-back">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <polyline points="15 18 9 12 15 6"/>
          </svg>
          Kembali ke Orders
        </a>
      </div>
    </section>

    {{-- ═══ STATS ═══ --}}
    <section class="rk-stats">
      <div class="o-stat reveal" data-accent="navy">
        <div class="o-stat-head">
          <div class="o-stat-icon">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
          </div>
          <span class="o-stat-tag">Aktif</span>
        </div>
        <p class="o-stat-label">Total Customer Aktif</p>
        <div class="o-stat-val">{{ number_format($totalCustomers) }}</div>
        <div class="o-stat-sub">Customer dengan pengiriman</div>
      </div>

      <div class="o-stat reveal reveal-d1" data-accent="green">
        <div class="o-stat-head">
          <div class="o-stat-icon">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
          <span class="o-stat-tag">Delivered</span>
        </div>
        <p class="o-stat-label">Total Pengiriman Delivered</p>
        <div class="o-stat-val">{{ number_format($totalShipmentsDelivered) }}</div>
        <div class="o-stat-sub">Seluruh pengiriman selesai</div>
      </div>

      <div class="o-stat reveal reveal-d2" data-accent="red">
        <div class="o-stat-head">
          <div class="o-stat-icon">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <line x1="12" y1="1" x2="12" y2="23"/>
              <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
            </svg>
          </div>
          <span class="o-stat-tag">IDR</span>
        </div>
        <p class="o-stat-label">Total Revenue Delivered</p>
        <div class="o-stat-val-sm red">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</div>
        <div class="o-stat-sub">Dari pengiriman selesai</div>
      </div>
    </section>

    {{-- ═══ TABLE CARD ═══ --}}
    <div class="rk-card reveal">
      <div class="rk-card-header">
        <div class="rk-card-header-left">
          <div class="rk-card-header-icon">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
            </svg>
          </div>
          <h3>Top 20 Customer Pemesan Terbanyak</h3>
        </div>
        <span class="rk-card-meta">{{ count($rankingData) }} customer</span>
      </div>

      <div class="rk-table-wrap">
        <table class="rk-tbl">
          <thead>
            <tr>
              <th>Rank</th>
              <th>Nama Customer</th>
              <th>Email</th>
              <th>Perusahaan</th>
              <th>Total Delivered</th>
              <th>Total Pengeluaran</th>
            </tr>
          </thead>
          <tbody>
            @php $maxDelivered = $rankingData->max('total_delivered') ?: 1; @endphp
            @forelse($rankingData as $index => $customer)
              @php $rank = $index + 1; @endphp
              <tr class="{{ $rank === 1 ? 'row-top1' : ($rank === 2 ? 'row-top2' : ($rank === 3 ? 'row-top3' : '')) }}">
                <td>
                  <div class="rk-rank-badge
                    @if($rank == 1) rk-rank-1
                    @elseif($rank == 2) rk-rank-2
                    @elseif($rank == 3) rk-rank-3
                    @else rk-rank-other
                    @endif">
                    {{ $rank }}
                  </div>
                </td>
                <td>
                  <div class="rk-customer-name">{{ htmlspecialchars($customer->name) }}</div>
                </td>
                <td>
                  <div class="rk-customer-sub">{{ htmlspecialchars($customer->email) }}</div>
                </td>
                <td>
                  <div class="rk-customer-sub">{{ htmlspecialchars($customer->company_name ?? '—') }}</div>
                </td>
                <td>
                  <div class="rk-progress-wrap">
                    <span class="rk-val-highlight">{{ number_format($customer->total_delivered) }}</span>
                    <span style="color:var(--text-muted);font-size:0.78rem;"> pengiriman</span>
                    <div class="rk-progress">
                      <div class="rk-progress-fill" style="width:{{ round(($customer->total_delivered / $maxDelivered) * 100) }}%"></div>
                    </div>
                  </div>
                </td>
                <td>
                  <span class="rk-val-green">Rp {{ number_format($customer->total_spent ?? 0, 0, ',', '.') }}</span>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6">
                  <div class="rk-empty">
                    <div class="rk-empty-icon">
                      <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                      </svg>
                    </div>
                    <h4>Belum ada data ranking</h4>
                    <p>Belum ada customer dengan pengiriman delivered.</p>
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div>{{-- /container --}}
</div>{{-- /shell --}}

<script>
// ── SCROLL REVEAL ──
document.addEventListener('DOMContentLoaded', () => {
  const els = document.querySelectorAll('.reveal, .reveal-left, .reveal-right');
  if (!els.length) return;
  const io = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) { e.target.classList.add('is-visible'); io.unobserve(e.target); }
    });
  }, { threshold: 0.1 });
  els.forEach(el => io.observe(el));
});
</script>
@endsection
