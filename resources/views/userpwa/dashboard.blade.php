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
        <div class="stats-header">Quick Stats</div>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-val text-blue">12,568</div>
                <div class="stat-lbl">Total Requests</div>
            </div>
            <div class="stat-card">
                <div class="stat-val text-green">9,245</div>
                <div class="stat-lbl">Completed</div>
            </div>
            <div class="stat-card">
                <div class="stat-val text-orange">1,256</div>
                <div class="stat-lbl">In Progress</div>
            </div>
            <div class="stat-card">
                <div class="stat-val text-red">256</div>
                <div class="stat-lbl">Pending</div>
            </div>
        </div>
    </div>
</div>
@endsection
