@extends('userpwa.layout.app')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@section('style')
<style>
    .dashboard-container {
        display: flex;
        flex-direction: column;
        background: #ffffff;
        min-height: 100%;
        padding-bottom: 24px;
    }

    .hero-section {
           padding: 10px 20px 16px;
        position: relative;
        overflow: hidden;
        background: linear-gradient(180deg, rgba(230,244,255,0.4) 0%, rgba(255,255,255,0) 100%);
    }

    .hero-title {
        font-size: 28px;
        font-weight: 800;
        line-height: 1.15;
        color: #1e293b;
        margin-bottom: 12px;
    }

    .text-green {
        color: #0e7a43;
    }

    .hero-subtitle {
        font-size: 13px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .hero-desc {
        font-size: 12px;
        color: #64748b;
        line-height: 1.5;
        margin-bottom: 20px;
        max-width: 90%;
    }

    .hero-illustration {
        width: 100%;
        border-radius: 12px;
        margin-bottom: 24px;
        overflow: hidden;
    }
    
    .hero-illustration img {
        width: 100%;
        height: auto;
        display: block;
    }
    
    .action-buttons {
        padding: 0 24px;
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin-bottom: 32px;
    }

    .btn-action-primary {
        background: #0e7a43;
        color: #ffffff;
        border-radius: 12px;
        padding: 16px;
        display: flex;
        align-items: center;
        gap: 16px;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(14, 122, 67, 0.2);
    }

    .btn-action-secondary {
        background: #ffffff;
        color: #0e7a43;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        padding: 16px;
        display: flex;
        align-items: center;
        gap: 16px;
        text-decoration: none;
        box-shadow: 0 2px 6px rgba(0,0,0,0.03);
    }

    .btn-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .btn-action-primary .btn-icon {
        background: rgba(255,255,255,0.2);
        color: #ffffff;
    }

    .btn-action-secondary .btn-icon {
        background: rgba(14, 122, 67, 0.1);
        color: #0e7a43;
    }

    .btn-content {
        display: flex;
        flex-direction: column;
    }

    .btn-title {
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 2px;
    }

    .btn-action-primary .btn-title { color: #ffffff; }
    .btn-action-secondary .btn-title { color: #1e293b; }

    .btn-subtitle {
        font-size: 12px;
    }
    
    .btn-action-primary .btn-subtitle { color: rgba(255,255,255,0.8); }
    .btn-action-secondary .btn-subtitle { color: #64748b; }

    .stats-section {
        padding: 0 24px;
    }

    .stats-header {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 16px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr;
        gap: 8px;
    }

    .stat-card {
        background: #f8fafc;
        border-radius: 12px;
        padding: 12px 8px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border: 1px solid #f1f5f9;
    }

    .stat-val {
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .stat-lbl {
        font-size: 10px;
        color: #475569;
        font-weight: 600;
        line-height: 1.2;
    }

    .text-blue { color: #3b82f6; }
    .text-orange { color: #f59e0b; }
    .text-red { color: #ef4444; }
</style>
@endsection

@section('content')
<div class="dashboard-container">
    <div class="hero-section">
        <div class="hero-title">
            Together for a<br>
            <span class="text-green">Cleaner</span><br>
            Bengaluru
        </div>
        <div class="hero-subtitle">
            Report &bull; Assign &bull; Collect &bull; Dispose
        </div>
        <div class="hero-desc">
            A single window platform for all your Debris & Bulk Waste Management needs.
        </div>
        
        <div class="hero-illustration">
            <img src="{{ asset('frontendwebsite/img/hero-truck-new.png') }}" alt="Bengaluru Clean Streets Illustration">
        </div>
    </div>

    <div class="action-buttons">
        <a href="{{ route('user.report') }}" class="btn-action-primary">
            <div class="btn-icon">
                <i class="fa-solid fa-file-circle-exclamation"></i>
            </div>
            <div class="btn-content">
                <span class="btn-title">Raise an Issue</span>
                <span class="btn-subtitle">Raise debris or waste issues</span>
            </div>
        </a>

        <a href="{{ route('user.track') }}" class="btn-action-secondary">
            <div class="btn-icon">
                <i class="fa-solid fa-file-signature"></i>
            </div>
            <div class="btn-content">
                <span class="btn-title">Track Your Request</span>
                <span class="btn-subtitle">Track and check status</span>
            </div>
        </a>
    </div>

    <div class="stats-section">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="stats-header mb-0">Quick Stats</div>
            @if(Auth::check())
                <span class="badge bg-light text-muted border" style="font-size: 11px; font-weight: 600;">My Activity</span>
            @else
                <span class="badge bg-light text-muted border" style="font-size: 11px; font-weight: 600;">Platform Stats</span>
            @endif
        </div>
        <div class="stats-grid">
            <a href="{{ route('user.track') }}" class="stat-card text-decoration-none">
                <div class="stat-val text-blue">{{ number_format($totalRequests) }}</div>
                <div class="stat-lbl">Total Requests</div>
            </a>
            <a href="{{ route('user.track') }}" class="stat-card text-decoration-none">
                <div class="stat-val text-green">{{ number_format($completedRequests) }}</div>
                <div class="stat-lbl">Completed</div>
            </a>
            <a href="{{ route('user.track') }}" class="stat-card text-decoration-none">
                <div class="stat-val text-orange">{{ number_format($inProgressRequests) }}</div>
                <div class="stat-lbl">In Progress</div>
            </a>
            <a href="{{ route('user.track') }}" class="stat-card text-decoration-none">
                <div class="stat-val text-red">{{ number_format($pendingRequests) }}</div>
                <div class="stat-lbl">Pending</div>
            </a>
        </div>
    </div>

    @if(isset($recentRequests) && $recentRequests->count() > 0)
        <div class="recent-section mt-4" style="padding: 0 24px;">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span style="font-size: 14px; font-weight: 700; color: #1e293b;">Recent Requests</span>
                <a href="{{ route('user.track') }}" style="font-size: 12px; font-weight: 600; color: #0e7a43; text-decoration: none;">View All <i class="fa fa-arrow-right ms-1"></i></a>
            </div>
            @foreach($recentRequests as $req)
                @php
                    $badgeClass = 'bg-secondary';
                    if (in_array($req->status, ['completed', 'dumped', 'picked_up'])) {
                        $badgeClass = 'bg-success';
                    } elseif ($req->status === 'assigned') {
                        $badgeClass = 'bg-warning text-dark';
                    } elseif ($req->status === 'pending') {
                        $badgeClass = 'bg-danger';
                    }
                @endphp
                <a href="{{ route('user.details', ['id' => $req->request_number]) }}" class="d-flex align-items-center justify-content-between p-3 mb-2 rounded-3 border text-decoration-none bg-white shadow-sm" style="border-color: #e2e8f0 !important;">
                    <div>
                        <div class="fw-bold text-dark font-13">{{ $req->request_number }}</div>
                        <div class="text-muted font-11 mt-1">
                            <i class="fa fa-calendar-alt me-1"></i>{{ $req->created_at->format('d M Y') }} &bull; {{ is_array($req->category_ids) ? implode(', ', $req->category_ids) : $req->category_ids }}
                        </div>
                    </div>
                    <span class="badge {{ $badgeClass }}" style="font-size: 11px; text-transform: capitalize; padding: 6px 10px;">
                        {{ str_replace('_', ' ', $req->status) }}
                    </span>
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection
