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
        border-radius: 20px;
        box-shadow: 0 2px 14px rgba(0,0,0,0.03);
        border: 1px solid #eef2f6;
        overflow: hidden;
        width: 100%;
    }

    .hero-section {
        padding: 24px 24px 16px;
        position: relative;
        overflow: hidden;
        background: linear-gradient(180deg, rgba(230,244,255,0.45) 0%, rgba(255,255,255,0) 100%);
    }

    .hero-title {
        font-size: 32px;
        font-weight: 800;
        line-height: 1.15;
        color: #1e293b;
        margin-bottom: 12px;
        letter-spacing: -0.5px;
    }

    .text-green {
        color: #0e7a43;
    }

    .hero-subtitle {
        font-size: 14px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .hero-desc {
        font-size: 13px;
        color: #64748b;
        line-height: 1.55;
        margin-bottom: 20px;
        max-width: 900px;
    }

    .hero-illustration {
        width: 100%;
        border-radius: 16px;
        margin-bottom: 24px;
        overflow: hidden;
    }
    
    .hero-illustration img {
        width: 100%;
        height: auto;
        max-height: 480px;
        display: block;
        border-radius: 16px;
        object-fit: cover;
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    }
    
    .action-buttons {
        padding: 0 24px;
        display: grid;
        grid-template-columns: 1fr;
        gap: 14px;
        margin-bottom: 30px;
    }

    @media (min-width: 768px) {
        .action-buttons {
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
    }

    .btn-action-primary {
        background: #0e7a43;
        color: #ffffff;
        border-radius: 14px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(14, 122, 67, 0.2);
        transition: transform 0.2s, background 0.2s;
    }

    .btn-action-primary:hover {
        background: #095930;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .btn-action-secondary {
        background: #ffffff;
        color: #0e7a43;
        border: 1.5px solid #cbd5e1;
        border-radius: 14px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        text-decoration: none;
        box-shadow: 0 2px 6px rgba(0,0,0,0.03);
        transition: transform 0.2s, border-color 0.2s;
    }

    .btn-action-secondary:hover {
        border-color: #0e7a43;
        color: #0e7a43;
        transform: translateY(-1px);
    }

    .btn-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
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
        font-size: 12.5px;
    }
    
    .btn-action-primary .btn-subtitle { color: rgba(255,255,255,0.85); }
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
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
    }

    .stat-card {
        background: #f8fafc;
        border-radius: 14px;
        padding: 16px 10px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border: 1px solid #f1f5f9;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        border-color: #cbd5e1;
    }

    .stat-val {
        font-size: 20px;
        font-weight: 800;
        margin-bottom: 4px;
        line-height: 1.2;
    }

    .stat-lbl {
        font-size: 11.5px;
        color: #475569;
        font-weight: 600;
        line-height: 1.2;
    }

    .text-blue { color: #2563eb; }
    .text-orange { color: #f59e0b; }
    .text-red { color: #ef4444; }
    .font-13 { font-size: 13px; }
    .font-11 { font-size: 12px; }

    .recent-section {
        padding: 0 24px;
    }

    @media (min-width: 768px) {
        .hero-title {
            font-size: 38px;
        }

        .hero-subtitle {
            font-size: 15px;
        }

        .hero-desc {
            font-size: 14px;
        }

        .stat-card {
            padding: 20px 14px;
        }

        .stat-val {
            font-size: 24px;
        }

        .stat-lbl {
            font-size: 12.5px;
        }
    }
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
        <div class="recent-section mt-4">
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
                <a href="{{ route('user.details', ['id' => $req->id]) }}" class="d-flex align-items-center justify-content-between p-3 mb-2 rounded-3 border text-decoration-none bg-white shadow-sm" style="border-color: #e2e8f0 !important;">
                    <div>
                        <div class="fw-bold text-dark font-13">{{ $req->request_number }}</div>
                        <div class="text-muted font-11 mt-1">
                            <i class="fa fa-calendar-alt me-1"></i><b>{{ $req->created_at->format('d M Y') }}</b> &bull; {{ is_array($req->category_ids) ? implode(', ', $req->category_ids) : $req->category_ids }}
                        </div>
                    </div>
                    <div class="d-flex flex-column align-items-end gap-2">
                        <span class="badge {{ $badgeClass }}" style="font-size: 11px; text-transform: capitalize; padding: 6px 10px;">
                            {{ $req->status_label }}
                        </span>
                        <span class="btn btn-sm btn-outline-primary"
                              style="font-size: 12px; padding: 2px 21px; font-weight: 600; cursor: pointer;" onclick="window.location.href='{{ route('user.details', ['id' => $req->id]) }}'">
                            View
                        </span>
                    </div>
                </a>
            @endforeach
            
            <div class="mt-3 d-flex justify-content-center">
                {{ $recentRequests->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @endif
</div>
@endsection
