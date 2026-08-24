@extends('userpwa.layout.app')

@section('title', 'Edit Request')
@section('heading', 'Edit Request')

@section('style')
<style>
    .edit-container { padding: 20px; }
    
    .card-ui {
        background: #fff; border-radius: 16px; padding: 24px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.03); margin-bottom: 24px;
    }
    
    .form-label { font-weight: 600; font-size: 13px; color: #334155; margin-bottom: 8px; }
    .form-control { border-radius: 12px; padding: 12px 16px; border: 1px solid #cbd5e1; font-size: 14px; }
    .form-control:focus { border-color: #0e7a43; box-shadow: 0 0 0 3px rgba(14, 122, 67, 0.1); }
    
    .btn-save {
        background: #0e7a43; color: #fff; border-radius: 12px; padding: 14px;
        font-weight: 600; width: 100%; border: none; margin-top: 8px;
    }
    
    .btn-cancel {
        background: #f1f5f9; color: #475569; border-radius: 12px; padding: 14px;
        font-weight: 600; width: 100%; border: none; margin-top: 12px; text-decoration: none;
        display: block; text-align: center;
    }
</style>
@endsection

@section('content')
<div class="edit-container">
    <div class="card-ui">
        <h4 style="font-size: 18px; font-weight: 800; color: #1e293b; margin-bottom: 20px;">Edit Request Details</h4>
        
        <form action="#" method="GET">
            <div class="mb-3">
                <label class="form-label">Pickup Address</label>
                <textarea class="form-control" rows="3">8888, Kaverappa Layout, Vasanth Nagar, Bengaluru, Karnataka 560052</textarea>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Scheduled Pickup Date</label>
                <input type="date" class="form-control" value="2026-08-23">
            </div>
            
            <div class="mb-4">
                <label class="form-label">Mobile Number</label>
                <input type="tel" class="form-control" value="9876543210">
            </div>
            
            <button type="submit" class="btn-save">Save Changes</button>
            <a href="{{ route('user.track') }}" class="btn-cancel">Cancel</a>
        </form>
    </div>
</div>
@endsection
