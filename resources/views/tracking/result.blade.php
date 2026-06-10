@extends('layouts.app')

@section('title', 'Tracking Result - Indo Cahaya Express')

@section('content')
<style>
.tracking-result-page {
    padding: 4rem 1rem;
    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
    min-height: calc(100vh - 200px);
}
.tracking-result-card {
    background: var(--bg-secondary);
    border-radius: var(--radius-2xl);
    padding: 3rem 2.5rem;
    max-width: 800px;
    width: 100%;
    margin: 0 auto;
    border: 1px solid var(--border);
    box-shadow: var(--shadow-xl);
}
.tracking-header {
    text-align: center;
    margin-bottom: 2.5rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid var(--border-light);
}
.tracking-header h1 {
    font-size: 1.75rem;
    font-weight: 900;
    color: var(--text);
    margin: 0 0 0.5rem;
}
.tracking-number {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--primary-600);
    background: var(--primary-50);
    padding: 0.75rem 1.5rem;
    border-radius: var(--radius-lg);
    display: inline-block;
    margin-top: 1rem;
}
.tracking-timeline {
    position: relative;
    padding-left: 2rem;
}
.tracking-timeline::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 2px;
    background: var(--border-light);
}
.timeline-item {
    position: relative;
    padding-bottom: 2rem;
}
.timeline-item:last-child {
    padding-bottom: 0;
}
.timeline-item::before {
    content: '';
    position: absolute;
    left: -2rem;
    top: 0;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background: var(--primary-500);
    border: 3px solid var(--bg-secondary);
    box-shadow: 0 0 0 3px var(--primary-100);
}
.timeline-date {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-muted);
    margin-bottom: 0.25rem;
}
.timeline-status {
    font-size: 1rem;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 0.25rem;
}
.timeline-location {
    font-size: 0.9375rem;
    color: var(--text-secondary);
    margin-bottom: 0.5rem;
}
.timeline-description {
    font-size: 0.9375rem;
    color: var(--text-secondary);
    line-height: 1.6;
}
.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: white;
    color: var(--text);
    border: 1.5px solid var(--border);
    border-radius: var(--radius-lg);
    font-size: 0.9375rem;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.2s ease;
    margin-top: 2rem;
}
.btn-back:hover {
    background: var(--primary-50);
    border-color: var(--primary-300);
    color: var(--primary-700);
}
.btn-back svg {
    width: 16px;
    height: 16px;
}
</style>

<div class="tracking-result-page">
    <div class="tracking-result-card">
        <div class="tracking-header">
            <h1>Tracking Result</h1>
            <div class="tracking-number">{{ $tracking->tracking_number }}</div>
        </div>

        <div class="tracking-timeline">
            @php
                $trackingHistory = \DB::table('tracking')
                    ->where('tracking_number', $tracking->tracking_number)
                    ->orderBy('created_at', 'desc')
                    ->get();
            @endphp

            @foreach($trackingHistory as $history)
                <div class="timeline-item">
                    <div class="timeline-date">{{ $history->created_at->format('d M Y, H:i') }}</div>
                    <div class="timeline-status">{{ ucfirst($history->status) }}</div>
                    <div class="timeline-location">{{ $history->location }}</div>
                    <div class="timeline-description">{{ $history->description }}</div>
                </div>
            @endforeach
        </div>

        <div style="text-align: center;">
            <a href="{{ route('tracking') }}" class="btn-back">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
                Track Another Shipment
            </a>
        </div>
    </div>
</div>
@endsection
