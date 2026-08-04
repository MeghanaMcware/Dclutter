@extends('vehiclepwa.layout.app')

@section('title') Trip Summary @endsection
@section('heading') Trip Summary @endsection

@section('style')
    <style>
        :root { --primary-green: #0e7a43; --primary-dark: #095930; }

        .check-circle { width: 80px; height: 80px; background: var(--primary-green); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 10px auto 16px; font-size: 38px; box-shadow: 0 10px 25px rgba(14,122,67,0.3); }

        .summary-title { font-size: 22px; font-weight: 800; color: var(--primary-green); margin-bottom: 6px; }
        .summary-sub { font-size: 13px; color: #64748b; margin-bottom: 24px; line-height: 1.5; }

        .summary-card { background: #fff; border-radius: 16px; padding: 18px; border: 1px solid #f1f5f9; box-shadow: 0 4px 12px rgba(0,0,0,0.03); text-align: left; margin-bottom: 24px; }
        .summary-row { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid #f1f5f9; font-size: 14px; }
        .summary-row:last-child { border-bottom: none; }
        .summary-row .label { color: #64748b; font-weight: 500; }
        .summary-row .val { color: #0f172a; font-weight: 700; }

        .btn-submit-summary { width: 100%; height: 50px; background: var(--primary-green); color: #fff; border: none; border-radius: 14px; font-size: 16px; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; box-shadow: 0 4px 14px rgba(14,122,67,0.3); }
        .btn-submit-summary:hover { background: var(--primary-dark); color: #fff; }
    </style>
@endsection

@section('content')
    <div class="container py-2 text-center" style="max-width: 440px; margin: 0 auto;">

        <!-- Checkmark Badge -->
        <div class="check-circle">
            <i class="fa-solid fa-check"></i>
        </div>

        <h2 class="summary-title">Trip Completed!</h2>
        <p class="summary-sub">Great job! You have completed all<br>stops for this trip.</p>

        <!-- Summary Data Breakdown -->
        <div class="summary-card">
            <div class="summary-row">
                <span class="label">Trip ID</span>
                <span class="val">TRP-2025-05-24-01</span>
            </div>
            <div class="summary-row">
                <span class="label">Total Stops</span>
                <span class="val">35</span>
            </div>
            <div class="summary-row">
                <span class="label">Completed</span>
                <span class="val">35</span>
            </div>
            <div class="summary-row">
                <span class="label">Waste Collected</span>
                <span class="val">2.4 Ton</span>
            </div>
            <div class="summary-row">
                <span class="label">Distance Covered</span>
                <span class="val">11.8 km</span>
            </div>
            <div class="summary-row">
                <span class="label">Time Taken</span>
                <span class="val">4h 15m</span>
            </div>
        </div>

        <!-- Recent Uploads (Mockup Display) -->
        <div class="summary-card" id="recentUploadsCard" style="display: none;">
            <h5 style="font-size: 15px; font-weight: 700; margin-bottom: 12px; color: #1f2937;">Recent Photos</h5>
            <div style="display: flex; gap: 10px;">
                <div style="flex: 1; text-align: center;">
                    <img id="summaryBeforeImg" src="" style="width: 100%; height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid #e2e8f0; display: none;">
                    <span style="font-size: 11px; color: #64748b; font-weight: 600; margin-top: 4px; display: block;">BEFORE</span>
                </div>
                <div style="flex: 1; text-align: center;">
                    <img id="summaryAfterImg" src="" style="width: 100%; height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid #e2e8f0; display: none;">
                    <span style="font-size: 11px; color: #64748b; font-weight: 600; margin-top: 4px; display: block;">AFTER</span>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <a href="{{ route('driver.notifications') }}" class="btn-submit-summary">
            <span>Submit Summary</span>
        </a>

    </div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const beforeData = localStorage.getItem('recentBeforeImg');
        const afterData = localStorage.getItem('recentAfterImg');
        
        if (beforeData || afterData) {
            document.getElementById('recentUploadsCard').style.display = 'block';
            
            if (beforeData) {
                const bImg = document.getElementById('summaryBeforeImg');
                bImg.src = beforeData;
                bImg.style.display = 'block';
            }
            if (afterData) {
                const aImg = document.getElementById('summaryAfterImg');
                aImg.src = afterData;
                aImg.style.display = 'block';
            }
        }
    });
</script>
@endsection
