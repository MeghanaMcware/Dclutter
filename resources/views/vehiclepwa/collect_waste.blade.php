@extends('vehiclepwa.layout.app')

@section('title') Collect Waste @endsection
@section('heading') Collect Waste @endsection

@section('style')
    <style>
        :root { --primary-green: #0e7a43; --primary-dark: #095930; }

        .photo-card { background: #fff; border-radius: 16px; padding: 16px; border: 1px solid #f1f5f9; box-shadow: 0 4px 12px rgba(0,0,0,0.03); margin-bottom: 16px; }
        .photo-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
        .photo-header label { font-size: 14px; font-weight: 700; color: #0f172a; margin: 0; }
        .btn-cam { color: #64748b; font-size: 18px; background: none; border: none; cursor: pointer; }

        .img-preview-box { width: 100%; height: 160px; border-radius: 12px; overflow: hidden; background: #e2e8f0; position: relative; }
        .img-preview-box img { width: 100%; height: 100%; object-fit: cover; }

        .weight-card { background: #fff; border-radius: 16px; padding: 16px; border: 1px solid #f1f5f9; margin-bottom: 20px; }
        .weight-card label { font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 8px; display: block; }
        .weight-input-row { display: flex; border: 1.5px solid #cbd5e1; border-radius: 12px; overflow: hidden; background: #fff; }
        .weight-input-row input { border: none; outline: none; padding: 12px 14px; font-size: 16px; font-weight: 700; color: #0f172a; width: 100%; }
        .weight-unit-select { background: #f8fafc; border: none; border-left: 1px solid #cbd5e1; padding: 0 16px; font-weight: 700; color: #475569; font-size: 14px; }

        .btn-confirm { width: 100%; height: 50px; background: var(--primary-green); color: #fff; border: none; border-radius: 14px; font-size: 16px; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; box-shadow: 0 4px 14px rgba(14,122,67,0.3); }
        .btn-confirm:hover { background: var(--primary-dark); color: #fff; }
    </style>
@endsection

@section('content')
    <div class="container py-2" style="max-width: 440px; margin: 0 auto;">

        <!-- Before Collection Photo -->
        <div class="photo-card">
            <div class="photo-header">
                <label>Before Collection</label>
                <button class="btn-cam"><i class="fa-solid fa-camera"></i></button>
            </div>
            <div class="img-preview-box">
                <img src="{{ asset('frontend/pwa/images/pictures/1.jpg') }}" alt="Garbage Before Collection">
            </div>
        </div>

        <!-- After Collection Photo -->
        <div class="photo-card">
            <div class="photo-header">
                <label>After Collection</label>
                <button class="btn-cam"><i class="fa-solid fa-camera"></i></button>
            </div>
            <div class="img-preview-box">
                <img src="{{ asset('frontend/pwa/images/pictures/10.jpg') }}" alt="Cleaned After Collection">
            </div>
        </div>

        <!-- Waste Weight Input -->
        <div class="weight-card">
            <label>Waste Weight (Approx.)</label>
            <div class="weight-input-row">
                <input type="number" value="850" placeholder="Enter weight">
                <select class="weight-unit-select">
                    <option value="kg" selected>kg</option>
                    <option value="ton">ton</option>
                </select>
            </div>
        </div>

        <!-- Confirm Collection Button -->
        <a href="{{ route('driver.update_status') }}" class="btn-confirm">
            <span>Confirm Collection</span>
        </a>

    </div>
@endsection
