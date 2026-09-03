@extends('userpwa.layout.app')

@section('title', 'Profile')
@section('heading', 'Profile')

@section('style')
<style>
    .profile-container {
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    
    .profile-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        padding: 30px 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 16px;
        border: 1px solid #e4e9e6;
    }
    
    .profile-avatar {
        width: 100px;
        height: 100px;
        background: #e8f5ed;
        color: #0e7a43;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        margin-bottom: 10px;
    }
    
    .profile-info {
        width: 100%;
        text-align: left;
        margin-top: 20px;
    }

    .info-group {
        margin-bottom: 20px;
        border-bottom: 1px solid #e4e9e6;
        padding-bottom: 15px;
    }

    .info-group:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .info-label {
        font-size: 13px;
        font-weight: 700;
        color: #64716a;
        margin-bottom: 6px;
        display: block;
    }
    
    .info-value {
        font-size: 16px;
        font-weight: 600;
        color: #1e293b;
    }

    .logout-btn {
        background: #fdf2f2;
        color: #dc3545;
        border: 1px solid #f8d7da;
        border-radius: 12px;
        padding: 14px;
        width: 100%;
        font-weight: 700;
        font-size: 16px;
        text-align: center;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s;
        margin-top: 10px;
    }

    .logout-btn:hover {
        background: #dc3545;
        color: #ffffff;
    }

</style>
@endsection

@section('content')
<div class="profile-container">
    <div class="profile-card">
        <div class="profile-avatar-wrapper" style="position: relative; display: inline-block; margin-bottom: 10px;">
            <div class="profile-avatar" style="padding: 0; overflow: hidden; border: 3px solid #e8f5ed; margin-bottom: 0;">
                <img src="https://ui-avatars.com/api/?name=Demo+User&background=e8f5ed&color=0e7a43&size=100&bold=true" alt="Profile Photo" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
            </div>
            <label for="profileImageUpload" class="edit-avatar-btn" style="position: absolute; bottom: 0; right: 0; background: #0e7a43; color: white; border: 2px solid #ffffff; border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 6px rgba(0,0,0,0.15); margin: 0;">
                <i class="fa-solid fa-camera" style="font-size: 14px;"></i>
            </label>
            <input type="file" id="profileImageUpload" style="display: none;" accept="image/*">
        </div>
        <h2 style="font-size: 24px; font-weight: 800; color: #0f172a; margin: 0;">Citizen Profile</h2>
        
        <div class="profile-info">
            <div class="info-group">
                <span class="info-label">Name</span>
                <div class="info-value">Demo User</div>
            </div>
            
            <div class="info-group">
                <span class="info-label">Mobile Number</span>
                <div class="info-value">+91 9876543210</div>
            </div>
            
            <div class="info-group">
                <span class="info-label">Member Since</span>
                <div class="info-value">Aug 2026</div>
            </div>
        </div>
    </div>

    <a href="/user/login" class="logout-btn">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
    </a>
</div>
@endsection
