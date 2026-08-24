@extends('userpwa.layout.app')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@section('style')
<style>
    .dashboard-container {
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    
    .action-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        padding: 40px 20px;
        text-align: center;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 16px;
        border: 2px solid transparent;
        transition: all 0.2s ease;
    }
    
    .action-card:hover, .action-card:active {
        border-color: #0e7a43;
        background: #f0fdf4;
    }
    
    .action-card i {
        font-size: 48px;
        color: #0e7a43;
    }
    
    .action-card h3 {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        text-transform: uppercase;
       
    }
    
    .welcome-text {
        font-size: 22px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 8px;
    }
    
    .subtitle-text {
        color: #64748b;
        font-size: 14px;
        margin-bottom: 24px;
    }
</style>
@endsection

@section('content')
<div class="dashboard-container">
    <div>
        <h2 class="welcome-text">Hello, Citizen!</h2>
       
    </div>

    <a href="{{ route('user.report') }}" class="action-card">
        <i class="fa-solid fa-camera-rotate"></i>
        <h3>REPORT REQUEST</h3>
    </a>

    <a href="{{ route('user.track') }}" class="action-card">
        <i class="fa-solid fa-map-location-dot"></i>
        <h3>TRACK REQUEST</h3>
    </a>
</div>
@endsection
