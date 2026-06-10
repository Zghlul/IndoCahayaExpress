{{-- resources/views/invoice/detail.blade.php --}}
@extends('layouts.app')

@section('title', "{{ $invoice->nomor_inv }}")

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
    /* ─────────────────────────────────────────
       RESET & BASE  (sama untuk user & admin)
    ───────────────────────────────────────── */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --red:          #E31E24;
      --red-hover:    #C7181D;
      --navy-900:     #060F2E;
      --navy-800:     #0A1A4A;
      --navy-700:     #0D2260;
      --navy-600:     #102B78;
      --navy-500:     #1438A0;
      --navy-400:     #2550C8;
      --surface:      #F4F7FD;
      --surface-2:    #EBF1FA;
      --border:       #DDE6F5;
      --border-2:     #C8D6EE;
      --text-primary: #09183C;
      --text-2:       #3D5478;
      --text-muted:   #7A93B8;
      --text-faint:   #AAB9D0;
      --shadow-xs:    0 1px 4px rgba(9,24,60,.06);
      --shadow-sm:    0 2px 8px rgba(9,24,60,.08);
      --shadow-md:    0 8px 24px rgba(9,24,60,.10);
      --shadow-card:  0 4px 28px rgba(9,24,60,.09), 0 1px 4px rgba(9,24,60,.04);
      --ease-out:     cubic-bezier(0.22, 1, 0.36, 1);
    }

    body {
      font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
      background: var(--surface);
      color: var(--text-primary);
      font-size: 13px;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    /* ─────────────────────────────────────────
       TOOLBAR (admin & customer versi berbeda)
    ───────────────────────────────────────── */
    .toolbar {
      background: #fff;
      border-bottom: 1px solid var(--border);
      height: 56px;
      padding: 0 28px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: sticky;
      top: 0;
      z-index: 100;
      box-shadow: var(--shadow-xs);
    }

    .tb-left { display: flex; align-items: center; gap: 10px; }

    .tb-brand {
      font-size: 14px;
      font-weight: 900;
      color: var(--navy-700);
      letter-spacing: -0.02em;
    }

    .tb-sep {
      color: var(--red);
      font-weight: 800;
      font-size: 13px;
    }

    .tb-inv {
      font-size: 11.5px;
      font-weight: 700;
      color: var(--navy-600);
      background: var(--surface-2);
      padding: 3px 10px;
      border-radius: 6px;
      border: 1px solid var(--border-2);
    }

    .badge-paid {
      padding: 3px 10px;
      border-radius: 99px;
      font-size: 10px;
      font-weight: 800;
      background: #f0fdf4;
      color: #166534;
      border: 1px solid #bbf7d0;
      letter-spacing: 0.02em;
    }

    .badge-unpaid {
      padding: 3px 10px;
      border-radius: 99px;
      font-size: 10px;
      font-weight: 800;
      background: #fefce8;
      color: #854d0e;
      border: 1px solid #fde68a;
      letter-spacing: 0.02em;
    }

    .tb-btns { display: flex; gap: 7px; }

    .btn {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 7px 15px;
      border-radius: 8px;
      font-size: 12px;
      font-weight: 700;
      font-family: inherit;
      cursor: pointer;
      border: none;
      text-decoration: none;
      white-space: nowrap;
      transition: all 0.2s var(--ease-out);
      letter-spacing: 0.01em;
    }

    .btn svg { width: 13px; height: 13px; flex-shrink: 0; }

    .btn-ghost {
      background: #fff;
      color: var(--text-2);
      border: 1.5px solid var(--border) !important;
    }
    .btn-ghost:hover {
      background: var(--surface-2);
      border-color: var(--border-2) !important;
      color: var(--text-primary);
    }

    .btn-dark {
      background: #1e293b;
      color: #fff;
      box-shadow: 0 2px 8px rgba(0,0,0,.1);
    }
    .btn-dark:hover {
      background: #0f172a;
      transform: translateY(-1px);
    }

    .btn-green {
      background: #15803d;
      color: #fff;
      box-shadow: 0 2px 8px rgba(21,128,61,.3);
    }
    .btn-green:hover {
      background: #166534;
      transform: translateY(-1px);
    }

    .btn-red {
      background: var(--red);
      color: #fff;
      box-shadow: 0 4px 16px rgba(227,30,36,.3);
    }
    .btn-red:hover {
      background: var(--red-hover);
      box-shadow: 0 8px 24px rgba(227,30,36,.4);
      transform: translateY(-1px);
    }

    /* ─────────────────────────────────────────
       PAGE WRAP
    ───────────────────────────────────────── */
    .page-wrap {
      padding: 28px 20px 56px;
      display: flex;
      justify-content: center;
    }

    /* ─────────────────────────────────────────
       INVOICE CARD (sama untuk semua)
    ───────────────────────────────────────── */
    .invoice {
      width: 300mm;
      background: #fff;
      border-radius: 16px;
      border: 1px solid var(--border);
      box-shadow: var(--shadow-card);
      overflow: hidden;
    }

    /* ─── HEADER ─── */
    .inv-header {
      background: linear-gradient(145deg, var(--navy-900) 0%, var(--navy-700) 60%, var(--navy-800) 100%);
      padding: 26px 32px 22px;
      display: grid;
      grid-template-columns: 1fr 1fr;
      align-items: start;
      gap: 16px;
      position: relative;
      overflow: hidden;
    }

    .inv-header::before {
      content: '';
      position: absolute;
      top: -60px; right: -60px;
      width: 260px; height: 260px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(20,56,160,.35) 0%, transparent 65%);
      pointer-events: none;
    }

    .inv-header::after {
      content: '';
      position: absolute;
      bottom: -40px; left: 30%;
      width: 180px; height: 180px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(227,30,36,.12) 0%, transparent 65%);
      pointer-events: none;
    }

    .company-logo-wrap {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 10px;
    }

    .company-logo-icon {
      width: 42px; height: 42px;
      border-radius: 11px;
      display: flex; margin-top: 5px; justify-content: center;
      flex-shrink: 0;
    }

    .company-logo-icon svg { width: 22px; height: 22px; color: #fff; }

    .company-name {
      font-size: 18px;
      font-weight: 900;
      color: #fff;
      letter-spacing: -0.02em;
      line-height: 1.1;
    }

    .company-tagline {
      font-size: 9px;
      color: rgba(255,255,255,.45);
      letter-spacing: 1.8px;
      text-transform: uppercase;
      margin-top: 2px;
      font-weight: 600;
    }

    .company-addr {
      font-size: 10.5px;
      color: rgba(255,255,255,.45);
      line-height: 1.9;
      position: relative; z-index: 1;
      margin-top:35px;
    }

    .inv-meta { text-align: right; position: relative; z-index: 1; }

    .doc-label {
      font-size: 9px;
      font-weight: 800;
      color: rgba(255,255,255,.4);
      text-transform: uppercase;
      letter-spacing: 2px;
    }

    .inv-number {
      font-size: 20px;
      font-weight: 900;
      color: #fff;
      margin-top: 3px;
      letter-spacing: -0.02em;
    }

    .meta-list { margin-top: 12px; display: flex; flex-direction: column; gap: 3px; }

    .meta-item {
      display: flex;
      justify-content: flex-end;
      gap: 10px;
      font-size: 10.5px;
    }

    .meta-item .ml { color: rgba(255,255,255,.42); font-weight: 500; }
    .meta-item .mv { color: rgba(255,255,255,.9); font-weight: 700; min-width: 110px; text-align: right; }
    .meta-item .mv-paid   { color: #86efac !important; }
    .meta-item .mv-unpaid { color: #fde68a !important; }

    /* ─── ACCENT STRIPE ─── */
    .accent-stripe {
      height: 3px;
      background: linear-gradient(90deg, var(--red) 0%, #ff6b6b 50%, var(--red) 100%);
    }

    /* ─── BODY ─── */
    .inv-body { padding: 18px 32px 16px; }

    /* ─── DDP ALERT ─── */
    .ddp-bar {
      background: #fff7ed;
      border: 1px solid #fed7aa;
      border-left: 3px solid #f97316;
      border-radius: 8px;
      padding: 8px 14px;
      margin-bottom: 16px;
      display: flex;
      align-items: center;
      gap: 9px;
      font-size: 11px;
      color: #7c2d12;
      font-weight: 500;
    }

    .ddp-bar strong { font-weight: 800; }

    /* ─── INFO ROW ─── */
    .info-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
      margin-bottom: 16px;
    }

.info-box,
.bank-box {
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid var(--border);
    background: #fff;
    padding: 0;
}

    .info-box-head {
      background: linear-gradient(135deg, var(--navy-800) 0%, var(--navy-600) 100%);
      padding: 8px 16px;
      font-size: 8.5px;
      font-weight: 800;
      color: rgba(255,255,255,.65);
      text-transform: uppercase;
      letter-spacing: 1.5px;
      display: flex;
      align-items: center;
      gap: 7px;
    }

    .info-box-head svg { opacity: .75; }
    .info-box-body { padding: 14px 16px; }

    /* Shipper */
    .shipper-row { display: flex; align-items: flex-start; gap: 12px; }

    .shipper-avatar {
      width: 40px; height: 40px;
      border-radius: 11px;
      background: linear-gradient(135deg, var(--navy-700), var(--navy-400));
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
      font-size: 14px; font-weight: 900; color: #fff;
      letter-spacing: -0.5px;
      box-shadow: 0 4px 12px rgba(14,34,96,.2);
    }

    .shipper-info { flex: 1; }

    .shipper-name-val {
      font-size: 13.5px;
      font-weight: 800;
      color: var(--text-primary);
      line-height: 1.25;
      letter-spacing: -0.01em;
    }

    .shipper-company-val {
      font-size: 10.5px;
      font-weight: 700;
      color: var(--navy-400);
      margin-top: 1px;
    }

    .shipper-contacts {
      display: flex;
      gap: 8px;
      margin-top: 10px;
      flex-wrap: wrap;
    }

    .shipper-contact-chip {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 99px;
      padding: 3px 10px;
      font-size: 10.5px;
      color: var(--text-2);
      font-weight: 500;
      transition: all 0.18s;
    }

    .shipper-contact-chip svg { width: 9px; height: 9px; color: var(--text-muted); flex-shrink: 0; }
    .shipper-contact-chip:hover { border-color: var(--border-2); background: var(--surface-2); }

    /* Summary grid */
    .summary-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 10px;
      padding: 14px 16px;
    }

    .sum-cell {
      background: linear-gradient(135deg, var(--surface) 0%, #EEF3FC 100%);
      border: 1px solid var(--border);
      border-radius: 10px;
      padding: 12px 10px;
      text-align: center;
      transition: all 0.2s var(--ease-out);
    }

    .sum-cell:hover {
      border-color: var(--border-2);
      box-shadow: var(--shadow-sm);
      transform: translateY(-1px);
    }

    .sum-val {
      font-size: 20px;
      font-weight: 900;
      color: var(--navy-700);
      line-height: 1;
      letter-spacing: -0.03em;
    }

    .sum-unit { font-size: 10px; font-weight: 700; color: #93c5fd; }

    .sum-lbl {
      font-size: 8px;
      color: var(--text-muted);
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-top: 4px;
      font-weight: 700;
    }

    /* ─── TABLE ─── */
    .inv-table {
      width: 100%;
      border-collapse: collapse;
      border: 1px solid var(--border);
      border-radius: 12px;
      overflow: hidden;
      margin-bottom: 14px;
      box-shadow: var(--shadow-xs);
    }

    .inv-table thead tr {
      background: linear-gradient(90deg, var(--navy-800) 0%, var(--navy-600) 100%);
    }

    .inv-table th {
      padding: 9px 11px;
      font-size: 8.5px;
      font-weight: 800;
      color: rgba(255,255,255,.65);
      text-align: left;
      letter-spacing: 0.9px;
      text-transform: uppercase;
      white-space: nowrap;
    }

    .inv-table th.r { text-align: right; }

    .inv-table td {
      padding: 8px 11px;
      font-size: 11.5px;
      color: var(--text-2);
      border-bottom: 1px solid var(--surface-2);
      vertical-align: middle;
      transition: background 0.15s;
    }

    .inv-table td.r { text-align: right; font-weight: 700; color: var(--text-primary); }
    .inv-table tbody tr:nth-child(even) td { background: #FAFBFE; }
    .inv-table tbody tr:last-child td { border-bottom: none; }
    .inv-table tbody tr:hover td { background: #EEF3FC !important; }

    .track-tag {
      font-size: 10px;
      font-weight: 700;
      color: var(--navy-600);
      background: var(--surface-2);
      padding: 2px 8px;
      border-radius: 5px;
      border: 1px solid var(--border-2);
      display: inline-block;
      letter-spacing: 0.02em;
    }
    
    .svc-tag {
      font-size: 9.5px;
      font-weight: 800;
      padding: 2px 9px;
      border-radius: 99px;
      display: inline-block;
      letter-spacing: 0.01em;
    }
    .svc-priority  { background: rgba(245,158,11,0.2); color: #92400e; border:1px solid rgba(245,158,11,0.4); }
    .svc-fedex     { background: rgba(168,85,247,0.15); color: #6b21a5; border:1px solid rgba(168,85,247,0.35); }
    .svc-us-reguler{ background: rgba(59,130,246,0.15); color: #1e3a8a; border:1px solid rgba(59,130,246,0.35); }
    .svc-reguler   { background: rgba(20,184,166,0.15); color: #115e59; border:1px solid rgba(20,184,166,0.35); }
    .svc-fast-asian{ background: rgba(6,182,212,0.15); color: #155e75; border:1px solid rgba(6,182,212,0.35); }
    .svc-flash     { background: rgba(239,68,68,0.15); color: #991b1b; border:1px solid rgba(239,68,68,0.35); }
    .svc-flash-aussy{ background: rgba(34,197,94,0.15); color: #166534; border:1px solid rgba(34,197,94,0.35); }

    /* ─── BOTTOM ROW ─── */
    .bottom-row {
      display: grid;
      grid-template-columns: 1fr auto;
      gap: 16px;
      align-items: start;
    }

    .notes-bank-row {
      display: grid;
      grid-template-columns: 1fr auto;
      gap: 12px;
      align-items: stretch;
    }

    .inv-notes {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 10px;
      padding: 13px 16px;
      font-size: 10.5px;
      color: var(--text-muted);
      line-height: 1.9;
    }

    .notes-hd {
      font-size: 8.5px;
      font-weight: 800;
      color: var(--text-faint);
      text-transform: uppercase;
      letter-spacing: 1.2px;
      margin-bottom: 6px;
    }

    .info-box-head,
    .bank-box-head {
    margin: 0;
    border-radius: 0;
}

    .bank-box-head {
      background: linear-gradient(90deg, var(--navy-800) 0%, var(--navy-600) 100%);
      padding: 8px 14px;
      font-size: 8.5px;
      font-weight: 800;
      color: rgba(255,255,255,.6);
      text-transform: uppercase;
      letter-spacing: 1.2px;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .bank-box-body {
      padding: 12px 14px;
      display: grid;
      grid-template-columns: auto 1fr;
      gap: 3px 10px;
      align-items: center;
    }

    .bank-lbl {
      font-size: 9.5px;
      color: var(--text-muted);
      white-space: nowrap;
      font-weight: 500;
    }

    .bank-val {
      font-size: 11.5px;
      font-weight: 800;
      color: var(--navy-700);
    }

    .bank-val.rekening {
      font-size: 13px;
      letter-spacing: 0.5px;
      color: var(--text-primary);
    }

    /* ─── TOTALS ─── */
    .totals-wrap { min-width: 252px; }

    .totals-inner {
      border: 1px solid var(--border);
      border-radius: 10px;
      overflow: hidden;
      box-shadow: var(--shadow-xs);
    }

    .t-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 9px 14px;
      border-bottom: 1px solid var(--surface-2);
      font-size: 11.5px;
    }

    .t-row .tl { color: var(--text-muted); font-weight: 500; }
    .t-row .tv { font-weight: 800; color: var(--text-primary); }
    .t-row:first-child { background: var(--surface); }

    .t-row.ddp { background: #fff7ed; }
    .t-row.ddp .tl { color: #c2410c; font-weight: 600; }
    .t-row.ddp .tv { color: #9a3412; }

    .t-row.faded { background: var(--surface); }
    .t-row.faded .tl,
    .t-row.faded .tv { color: var(--text-faint); font-size: 10.5px; font-weight: 500; }

    .t-row.grand {
      background: linear-gradient(135deg, var(--navy-800) 0%, var(--navy-600) 100%);
      border-bottom: none;
      padding: 14px;
    }

    .t-row.grand .tl {
      color: rgba(255,255,255,.5);
      font-size: 9.5px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.6px;
    }

    .t-row.grand .tv {
      color: #fff;
      font-size: 18px;
      font-weight: 900;
      letter-spacing: -0.02em;
    }

    /* ─── FOOTER ─── */
    .inv-footer {
      background: linear-gradient(90deg, var(--navy-900) 0%, var(--navy-800) 100%);
      border-top: 3px solid var(--red);
      padding: 10px 32px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .inv-footer .fl { font-size: 10px; color: rgba(255,255,255,.38); }
    .inv-footer .fl strong { color: rgba(255,255,255,.65); font-weight: 700; }
    .inv-footer .fr { font-size: 9.5px; color: rgba(255,255,255,.25); }

    /* ─────────────────────────────────────────
       MODAL EDIT INVOICE (hanya untuk admin)
    ───────────────────────────────────────── */
    .modal-overlay {
      display: none;
      position: fixed;
      inset: 0;
      z-index: 9999;
      background: rgba(6,15,46,.65);
      backdrop-filter: blur(6px);
      justify-content: center;
      align-items: center;
      padding: 1rem;
    }

    .modal-overlay.open { display: flex; }

    .modal-box {
      background: #fff;
      border-radius: 18px;
      width: 100%;
      max-width: 520px;
      max-height: 90vh;
      display: flex;
      flex-direction: column;
      box-shadow: 0 32px 80px rgba(6,15,46,.35);
      border: 1px solid var(--border);
      overflow: hidden;
    }

    .modal-hdr {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1.25rem 1.5rem;
      background: linear-gradient(135deg, var(--navy-900), var(--navy-700));
      border-bottom: 1px solid rgba(255,255,255,.07);
    }

    .modal-hdr h3 {
      font-size: 1rem;
      font-weight: 800;
      color: #fff;
      display: flex;
      align-items: center;
      gap: 0.6rem;
      letter-spacing: -0.01em;
    }

    .modal-close {
      width: 30px; height: 30px;
      background: rgba(255,255,255,.1);
      border: 1px solid rgba(255,255,255,.15);
      border-radius: 7px;
      color: rgba(255,255,255,.75);
      cursor: pointer;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.1rem;
      transition: all 0.18s;
    }

    .modal-close:hover {
      background: rgba(227,30,36,.65);
      border-color: rgba(227,30,36,.5);
      color: #fff;
    }

    .modal-body {
      padding: 1.5rem;
      overflow-y: auto;
      flex: 1;
      scrollbar-width: none;
    }

    .modal-body::-webkit-scrollbar { display: none; }

    .modal-field { margin-bottom: 1rem; }

    .modal-label {
      display: block;
      font-size: 0.68rem;
      font-weight: 800;
      color: var(--text-muted);
      text-transform: uppercase;
      letter-spacing: 0.08em;
      margin-bottom: 0.45rem;
    }

    .modal-input,
    .modal-select {
      width: 100%;
      padding: 10px 14px;
      border-radius: 9px;
      border: 1.5px solid var(--border);
      font-size: 0.875rem;
      font-weight: 500;
      background: #fff;
      color: var(--text-primary);
      font-family: inherit;
      box-sizing: border-box;
      transition: border-color 0.18s, box-shadow 0.18s;
      outline: none;
    }

    .modal-input:focus,
    .modal-select:focus {
      border-color: var(--navy-400);
      box-shadow: 0 0 0 3px rgba(37,80,200,.12);
    }

    .modal-footer {
      padding: 1rem 1.5rem 1.5rem;
      display: flex;
      gap: 0.75rem;
      border-top: 1px solid var(--border);
      background: var(--surface);
    }

    .btn-modal-cancel {
      flex: 1;
      padding: 11px;
      background: #fff;
      color: var(--text-2);
      border: 1.5px solid var(--border);
      border-radius: 9px;
      font-weight: 700;
      font-size: 0.875rem;
      font-family: inherit;
      cursor: pointer;
      transition: all 0.18s;
    }

    .t-row.war-risk { background: #fef2f2; }
    .t-row.war-risk .tl { color: #b91c1c; font-weight: 600; }
    .t-row.war-risk .tv { color: #991b1b; }

    .btn-modal-cancel:hover {
      border-color: var(--border-2);
      color: var(--text-primary);
      background: var(--surface-2);
    }

    .btn-modal-save {
      flex: 2;
      padding: 11px;
      background: linear-gradient(135deg, var(--navy-800), var(--navy-400));
      color: #fff;
      border: none;
      border-radius: 9px;
      font-weight: 800;
      font-size: 0.875rem;
      font-family: inherit;
      cursor: pointer;
      display: flex; align-items: center; justify-content: center; gap: 6px;
      box-shadow: 0 4px 16px rgba(14,34,96,.25);
      transition: all 0.2s var(--ease-out);
    }

    .btn-modal-save:hover {
      box-shadow: 0 8px 24px rgba(14,34,96,.35);
      transform: translateY(-1px);
    }

    /* ─────────────────────────────────────────
       PRINT
    ───────────────────────────────────────── */
    @media print {
  *, *::before, *::after {
    -webkit-print-color-adjust: exact !important;
    print-color-adjust: exact !important;
  }

  html, body {
    margin: 0 !important;
    padding: 0 !important;
    background: white !important;
  }

  /* Sembunyikan elemen navigasi & toolbar */
  nav, header, .navbar, .sidebar, .main-sidebar,
  footer, .footer, .breadcrumb, .app-header,
  .main-header, .app-sidebar, .app-footer,
  .top-nav, .side-nav, .menu, .user-menu,
  [class*="navbar"], [class*="sidebar"], [class*="footer"],
  .toolbar {
    display: none !important;
  }

  body > div:not(.page-wrap),
  #app > div:not(.page-wrap),
  .app-content, .main-content {
    display: none !important;
  }

  .page-wrap {
    display: block !important;
    padding: 0 !important;
    margin: 0 !important;
    position: static !important;
  }

  .rec-address {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: 1.3em;
    max-height: 2.6em;
    white-space: normal;
}

  .invoice {
    width: 100% !important;
    max-width: 100% !important;
    border-radius: 0 !important;
    box-shadow: none !important;
    border: none !important;
    page-break-inside: avoid;
    margin: 0 auto;
  }

  /* Perbaikan header & body */
  .inv-header {
    padding: 12px 16px 10px !important;
  }
  .inv-body {
    padding: 8px 16px 10px !important;
  }
  .info-row {
    margin-bottom: 8px !important;
  }

  /* Tabel agar tidak overflow */
  .inv-table {
    width: 100% !important;
    table-layout: fixed !important;
    font-size: 9px !important;
  }

  /* Atur lebar kolom agar proporsional dan tracking number tidak 2 baris */
.inv-table th:nth-child(1) { width: 4%; }  /* # */
.inv-table th:nth-child(2) { width: 20%; } /* Nama Penerima */
.inv-table th:nth-child(3) { width: 18%; } /* Tracking No. */
.inv-table th:nth-child(4) { width: 10%; }  /* Negara */
.inv-table th:nth-child(5) { width: 10%; } /* Layanan (diperkecil) */
.inv-table th:nth-child(6) { width: 12%; } /* Dimensi */
.inv-table th:nth-child(7) { width: 8%; }  /* Volumetrik */
.inv-table th:nth-child(8) { width: 8%; }  /* Berat Fisik */
.inv-table th:nth-child(9) { width: 8%; }  /* Ongkir (bisa lebih kecil) */

  .inv-table th,
  .inv-table td {
    padding: 4px 6px !important;
    font-size: 8.5px !important;
    word-break: break-word;
    white-space: normal !important;
  }
  .inv-table th.r,
  .inv-table td.r {
    text-align: right;
  }
  /* Kolom nomor, tracking, layanan, dll diperkecil */
  .inv-table th:first-child,
  .inv-table td:first-child {
    width: 28px !important;
  }
  .track-tag {
    font-size: 7.5px !important;
    padding: 1px 4px !important;
  }
  .svc-tag {
    font-size: 7.5px !important;
    padding: 1px 5px !important;
  }

  /* Ringkasan (summary grid) */
  .summary-grid {
    gap: 6px;
    padding: 8px 10px;
  }
  .sum-cell {
    padding: 6px 4px;
  }
  .sum-val {
    font-size: 14px;
  }
  .sum-lbl {
    font-size: 6px;
  }

  /* Bottom row */
  .bottom-row {
    gap: 8px;
  }
  .inv-notes, .bank-box {
    font-size: 8px;
    padding: 8px;
  }
  .totals-wrap {
    min-width: 180px;
  }
  .t-row {
    padding: 4px 8px;
    font-size: 9px;
  }
  .t-row.grand .tv {
    font-size: 12px;
  }

  /* Footer */
  .inv-footer {
    padding: 6px 16px;
    font-size: 7px;
  }

  @page {
    size: A4 portrait;
    margin: 0.001cm;
  }
}
</style>
@endpush

@section('content')
@php
    function rp($n) { return 'Rp ' . number_format((float)$n, 0, ',', '.'); }

    $bulan = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    $tgl_raw     = $invoice->created_at ?? now();
    $tgl_display = date('d', strtotime($tgl_raw)) . ' ' . $bulan[(int)date('m', strtotime($tgl_raw))] . ' ' . date('Y', strtotime($tgl_raw));
    $is_paid     = ($invoice->status ?? '') === 'Paid';

    // Hitung total berat yang dibebankan (chargeable weight) untuk ringkasan
    $total_chargeable_weight = $shipments->sum('berat_dibebankan');
@endphp

{{-- ════════ TOOLBAR ════════ --}}
<div class="toolbar">
    <div class="tb-left">
        <span class="tb-brand">Indo Cahaya Express</span>
        <span class="tb-sep">—</span>
        <span class="tb-inv">{{ $invoice->nomor_inv }}</span>
        @if($is_paid)
            <span class="badge-paid">Lunas</span>
        @else
            <span class="badge-unpaid">Belum Lunas</span>
        @endif
    </div>
    <div class="tb-btns">
        @if($isAdmin)
            {{-- Tombol untuk admin --}}
            <button type="button" class="btn btn-dark" onclick="openEditModal()">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Edit
            </button>
            @if(!$is_paid)
                <form method="POST" action="{{ route('invoices.mark-paid', hashid_encode($invoice->id)) }}" style="display:inline-flex;margin:0;">
                    @csrf
                    <button type="submit" class="btn btn-green" onclick="return confirm('Tandai invoice ini sebagai Lunas?')">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Tandai Lunas
                    </button>
                </form>
            @endif
            <a href="{{ route('invoices.delete', hashid_encode($invoice->id)) }}" class="btn btn-red" onclick="return confirm('Hapus invoice {{ $invoice->nomor_inv }}? Semua item terkait akan ikut terhapus.')">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                    <path d="M10 11v6M14 11v6"/>
                </svg>
                Hapus
            </a>
            <a href="{{ route('orders') }}" class="btn btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" style="width: 20px; height: 20px;" fill="black" viewBox="0 0 24 24" stroke-width="2" filter="brightness(0) saturate(100%) invert(100%)">
                </svg>
                Orders
            </a>
            <a href="{{ route('admin.invoices.index') }}" class="btn btn-ghost">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <line x1="8" y1="6" x2="21" y2="6"/>
                    <line x1="8" y1="12" x2="21" y2="12"/>
                    <line x1="8" y1="18" x2="21" y2="18"/>
                    <line x1="3" y1="6" x2="3.01" y2="6"/>
                    <line x1="3" y1="12" x2="3.01" y2="12"/>
                    <line x1="3" y1="18" x2="3.01" y2="18"/>
                </svg>
                Invoices
            </a>
        @else
            {{-- Tombol untuk customer --}}
            <a href="{{ route('invoices') }}" class="btn btn-ghost">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
                Kembali ke Invoices Saya
            </a>
        @endif
        <button class="btn btn-red" onclick="preparePrintAndPrint()">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <polyline points="6 9 6 2 18 2 18 9"/>
                <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                <rect x="6" y="14" width="12" height="8"/>
            </svg>
            Cetak / PDF
        </button>
    </div>
</div>

{{-- ════════ INVOICE CARD ════════ --}}
<div class="page-wrap">
<div class="invoice">

    {{-- HEADER --}}
    <div class="inv-header">
        <div>
            <div class="company-logo-wrap">
                <div class="company-logo-icon">
                  <img src="/img/logo_outline.png" alt="Indo Cahaya Express Logo" style="height: 25px;">
                </div>
                <div>
                    <div class="company-name">Indo Cahaya Express</div>
                    <div class="company-tagline">International Courier &amp; Express</div>
                </div>
            </div>
            <div class="company-addr">
                {{ $globalSettings['site_address'] ?? 'Citra Indah' }}<br>
                +{{ $globalSettings['site_phone'] ?? '+62 8518366 0490' }} &nbsp;&middot;&nbsp;
                {{ $globalSettings['site_email'] ?? 'indocahayaexpress@gmail.com' }}
            </div>
        </div>

        <div class="inv-meta">
            <div class="doc-label">Commercial Invoice</div>
            <div class="inv-number">{{ $invoice->nomor_inv }}</div>
            <div class="meta-list">
                <div class="meta-item">
                    <span class="ml">Tanggal</span>
                    <span class="mv">{{ $tgl_display }}</span>
                </div>
                <div class="meta-item">
                    <span class="ml">Jumlah Paket</span>
                    <span class="mv">{{ count($shipments) }} Paket</span>
                </div>
                <div class="meta-item">
                    <span class="ml">Status</span>
                    <span class="mv {{ $is_paid ? 'mv-paid' : 'mv-unpaid' }}">
                        {{ $is_paid ? '✓ Lunas' : '⏳ Belum Lunas' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- RED STRIPE --}}
    <div class="accent-stripe"></div>

    {{-- BODY --}}
    <div class="inv-body">

        @if($invoice->ddp > 0)
        <div class="ddp-bar">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#f97316" stroke-width="2" style="flex-shrink:0">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                <line x1="12" y1="9" x2="12" y2="13"/>
                <line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
            <span><strong>DDP {{ $ddpPercent ?? 19 }}% berlaku</strong> — Biaya dihitung dari total nilai barang sesuai regulasi bea cukai.</span>
        </div>
        @endif

        {{-- INFO ROW --}}
        <div class="info-row">
            {{-- Shipper --}}
            <div class="info-box">
                <div class="info-box-head">
                    <svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    Pengirim / Shipper
                </div>
                <div class="info-box-body">
                    <div class="shipper-row">
                        <div class="shipper-avatar">{{ strtoupper(substr($shipper_name, 0, 2)) }}</div>
                        <div class="shipper-info">
                            <div class="shipper-name-val">{{ htmlspecialchars($shipper_name) }}</div>
                            @if(!empty($shipper_company))
                                <div class="shipper-company-val">{{ htmlspecialchars($shipper_company) }}</div>
                            @endif
                            <div class="shipper-contacts">
                                <span class="shipper-contact-chip">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                        <polyline points="22,6 12,13 2,6"/>
                                    </svg>
                                    {{ htmlspecialchars($shipper_email) }}
                                </span>
                                <span class="shipper-contact-chip">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2.18h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                    </svg>
                                    {{ htmlspecialchars($shipper_phone) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Summary --}}
            <div class="info-box">
                <div class="info-box-head">
                    <svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7"/>
                        <rect x="14" y="3" width="7" height="7"/>
                        <rect x="3" y="14" width="7" height="7"/>
                        <path d="M14 14h3v3m0 4v-4m4 0h-4"/>
                    </svg>
                    Ringkasan Pengiriman
                </div>
                <div class="summary-grid">
                    <div class="sum-cell">
                        <div class="sum-val">{{ count($shipments) }}</div>
                        <div class="sum-lbl">Paket</div>
                    </div>
                    <div class="sum-cell">
                        <div class="sum-val">{{ number_format($total_chargeable_weight, 1) }}<span class="sum-unit"> kg</span></div>
                        <div class="sum-lbl">Total Berat (Dibebankan)</div>
                    </div>
                    <div class="sum-cell">
                        <div class="sum-val" style="font-size:14px;">${{ number_format($total_usd, 2) }}</div>
                        <div class="sum-lbl">Nilai Barang</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABLE --}}
        <table class="inv-table">
            <thead>
                <tr>
                    <th style="width:24px">#</th>
                    <th>Nama Penerima</th>
                    <th>Tracking No.</th>
                    <th>Negara</th>
                    <th>Layanan</th>
                    <th class="r">Dimensi (P×L×T)</th>
                    <th class="r">Volume</th>
                    <th class="r">Berat Fisik</th>
                    <th class="r">Ongkir (IDR)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($shipments as $idx => $ship)
                <tr>
                    <td style="color:var(--text-faint); font-weight:700; font-size:11px;">{{ $idx + 1 }}</td>
                    <td>
                        <div class="rec-name" style="font-weight:800; ...">
                            {{ htmlspecialchars(firstTwoSentences($ship->nama_penerima ?? '—')) }}
                        </div>
                        <div class="rec-address" style="color:var(--text-faint); margin-top:2px; line-height:1.4;">
                            {{ $ship->alamat_penerima ?? '—' }}
                        </div>
                    </td>
                    <td><span class="track-tag">{{ htmlspecialchars($ship->tracking_number ?? '—') }}</span></td>
                    <td style="font-weight:600; color:var(--text-2);">{{ htmlspecialchars($ship->negara ?? '—') }}</td>
                    <td>
                        @php
                            $service = strtolower(str_replace(' ', '-', $ship->service ?? ''));
                        @endphp
                        <span class="svc-tag svc-{{ $service }}">{{ htmlspecialchars($ship->service ?? '—') }}</span>
                    </td>
                    <td class="r" style="font-size:11px; color:var(--text-2);">
                        {{ number_format($ship->panjang ?? 0,0) }}×{{ number_format($ship->lebar ?? 0,0) }}×{{ number_format($ship->tinggi ?? 0,0) }} cm
                    </td>
                    <td class="r">{{ number_format($ship->volumetrik ?? 0, 2) }} kg</td>
                    <td class="r">{{ number_format($ship->berat_fisik ?? 0, 2) }} kg</td>
                    <td class="r">{{ rp($ship->charge_idr ?? 0) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- BOTTOM --}}
        <div class="bottom-row">
            <div class="notes-bank-row">
                <div class="inv-notes">
                    <div class="notes-hd">Catatan</div>
                    @if(!empty($invoice->catatan))
                        {!! nl2br(e($invoice->catatan)) !!}
                        @if($invoice->aramex_surcharge > 0)
                            <br><br>• TESS = Temporary Emergency Situational Surcharge
                        @endif
                    @else
                        1. Invoice ini sah sebagai bukti pengiriman resmi ICE Logistics.<br>
                        2. Hubungi kami jika ada pertanyaan mengenai invoice ini.<br>
                        @if($invoice->ddp > 0)
                        3. DDP {{ $ddpPercent ?? 19 }}% dikenakan dari total nilai barang sesuai regulasi bea cukai.<br>
                        @endif
                        4. Sertakan nomor invoice <strong style="color:var(--text-2);">{{ $invoice->nomor_inv }}</strong> pada keterangan transfer.
                        @if($invoice->aramex_surcharge > 0)
                            <br><br>• TESS = Temporary Emergency Situational Surcharge
                        @endif
                    @endif
                </div>

                <div class="bank-box">
                    <div class="bank-box-head">
                        <svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="rgba(255,255,255,.7)" stroke-width="2">
                            <rect x="2" y="5" width="20" height="14" rx="2"/>
                            <line x1="2" y1="10" x2="22" y2="10"/>
                        </svg>
                        Informasi Pembayaran
                    </div>
                    <div class="bank-box-body">
                        <span class="bank-lbl">Bank</span>
                        <span class="bank-val">Bank Mandiri</span>
                        <span class="bank-lbl">Kode</span>
                        <span class="bank-val">008</span>
                        <span class="bank-lbl">Rekening</span>
                        <span class="bank-val rekening">1330032434334</span>
                        <span class="bank-lbl">Atas Nama</span>
                        <span class="bank-val">CV. Indo Cahaya Mandiri</span>
                    </div>
                </div>
            </div>

            {{-- Totals --}}
            <div class="totals-wrap">
                <div class="totals-inner">
                    <div class="t-row">
                        <span class="tl">Subtotal ({{ count($shipments) }} paket)</span>
                        <span class="tv">{{ rp($calc_subtotal) }}</span>
                    </div>
                    @if($calc_ddp > 0)
                    <div class="t-row ddp">
                        <span class="tl">DDP {{ $ddpPercent ?? 19 }}%</span>
                        <span class="tv">{{ rp($calc_ddp) }}</span>
                    </div>
                    @else
                    <div class="t-row faded">
                        <span class="tl">DDP</span>
                        <span class="tv">Tidak berlaku</span>
                    </div>
                    @endif
                    @if($calc_war_risk > 0)
                    <div class="t-row war-risk">
                        <span class="tl">War Risk Charge (32%)</span>
                        <span class="tv">{{ rp($calc_war_risk) }}</span>
                    </div>
                    @endif
                    @if($invoice->aramex_surcharge > 0)
                    <div class="t-row war-risk" style="background:#fef9c3;">
                        <span class="tl">TESS</span>
                        <span class="tv">{{ rp($invoice->aramex_surcharge) }}</span>
                    </div>
                    @endif
                    <div class="t-row grand">
                        <span class="tl">Grand Total</span>
                        <span class="tv">{{ rp($calc_grand) }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>{{-- /inv-body --}}

    {{-- FOOTER --}}
    <div class="inv-footer">
        <div class="fl">
            <strong>ICE Logistics</strong> &mdash; {{ $globalSettings['site_address'] }} &nbsp;&middot;&nbsp; +{{ $globalSettings['site_phone'] }} &nbsp;&middot;&nbsp; {{ $globalSettings['site_email'] }}
        </div>
        <div class="fr">{{ $tgl_display }}</div>
    </div>

</div>{{-- /invoice --}}
</div>{{-- /page-wrap --}}

{{-- ════════ FUNGSI PRINT UNTUK SEMUA USER ════════ --}}
<script>
    function preparePrintAndPrint() {
        var originalTitle = document.title;
        document.title = "{{ $invoice->nomor_inv }}";
        window.print();
        setTimeout(function() {
            document.title = originalTitle;
        }, 500);
    }
</script>

@if($isAdmin)
{{-- ════════ MODAL EDIT INVOICE (hanya untuk admin) ════════ --}}
<div id="editInvoiceModal" class="modal-overlay" style="display: none;">
    <div class="modal-box">
        <div class="modal-hdr">
            <h3>
                <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Edit Invoice
            </h3>
            <button class="modal-close" onclick="closeEditModal()">&times;</button>
        </div>
        <form id="editInvoiceForm" method="POST" action="{{ route('invoice.update', hashid_encode($invoice->id)) }}">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="modal-field">
                    <label class="modal-label">Nama Customer</label>
                    <input type="text" name="nama_customer" id="edit_nama_customer" class="modal-input" required>
                </div>
                <div class="modal-field">
                    <label class="modal-label">Email Customer</label>
                    <input type="email" name="email_customer" id="edit_email_customer" class="modal-input" required>
                </div>
                <div class="modal-field">
                    <label class="modal-label">Subtotal (IDR)</label>
                    <input type="number" name="subtotal" id="edit_subtotal" class="modal-input" required>
                </div>
                <div class="modal-field">
                    <label class="modal-label">DDP (IDR)</label>
                    <input type="number" name="ddp" id="edit_ddp" class="modal-input" step="any" readonly style="background:#f1f5f9; cursor:not-allowed;">
                </div>
                <div class="modal-field">
                    <label class="modal-label">Grand Total (IDR)</label>
                    <input type="number" name="grand_total" id="edit_grand_total" class="modal-input" step="any" readonly style="background:#f1f5f9; cursor:not-allowed;">
                </div>
                <div class="modal-field">
                    <label class="modal-label">Status</label>
                    <select name="status" id="edit_status" class="modal-select">
                        <option value="Unpaid">Unpaid</option>
                        <option value="Paid">Paid</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn-modal-save">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal() {
        document.getElementById('edit_nama_customer').value = '{{ addslashes($invoice->nama_customer) }}';
        document.getElementById('edit_email_customer').value = '{{ addslashes($invoice->email_customer) }}';
        document.getElementById('edit_subtotal').value = '{{ $invoice->subtotal }}';
        document.getElementById('edit_ddp').value = '{{ $invoice->ddp ?? 0 }}';
        document.getElementById('edit_grand_total').value = '{{ $invoice->grand_total }}';
        document.getElementById('edit_status').value = '{{ $invoice->status }}';
        document.getElementById('editInvoiceModal').style.display = 'flex';
    }

    function closeEditModal() {
        document.getElementById('editInvoiceModal').style.display = 'none';
    }

    document.getElementById('edit_subtotal').addEventListener('input', function() {
        let subtotal = parseFloat(this.value) || 0;
        let ddp = parseFloat(document.getElementById('edit_ddp').value) || 0;
        document.getElementById('edit_grand_total').value = subtotal + ddp;
    });

    document.getElementById('editInvoiceForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Gagal update: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(err => alert('Terjadi kesalahan: ' + err));
    });
</script>
@endif

@endsection