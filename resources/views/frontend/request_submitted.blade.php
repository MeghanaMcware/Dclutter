@extends('layouts.app')

<style>
:root {
    --green: #087d45;
    --green-dark: #055a31;
    --green-light: #e8f5ed;
    --ink: #17251d;
    --muted: #64716a;
    --line: #e4e9e6;
}

.request-ui {
    max-width: 1080px;
    margin: 0 auto;
    padding: 30px 20px 50px;
    color: var(--ink);
    font-family: 'Inter', sans-serif;
}

.btn-ui {
    border: 0;
    border-radius: 6px;
    background: var(--green);
    color: #ffffff !important;
    font-size: 14px;
    font-weight: 700;
    padding: 12px 28px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    transition: background 0.2s ease, transform 0.1s ease;
    box-shadow: 0 3px 10px rgba(8, 125, 69, 0.2);
}

.btn-ui:hover {
    background: var(--green-dark);
    transform: translateY(-1px);
}

/* Success UI */
.success-ui {
    text-align: center;
    padding: 40px 20px;
    max-width: 500px;
    margin: 0 auto;
}

.success-check-wrapper {
    position: relative;
    width: 90px;
    height: 90px;
    margin: 0 auto 24px;
}

.success-check {
    width: 90px;
    height: 90px;
    background: var(--green);
    box-shadow: 0 0 0 14px #eff8f1;
    border-radius: 50%;
    color: #ffffff;
    font-size: 48px;
    line-height: 90px;
    margin: 0 auto;
    animation: popIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

@keyframes popIn {
    0% { transform: scale(0); }
    100% { transform: scale(1); }
}

.confetti-dot {
    position: absolute;
    width: 8px;
    height: 8px;
    border-radius: 50%;
}
.c1 { background: #ffb703; top: -10px; left: 10px; }
.c2 { background: #087d45; top: 10px; right: -12px; }
.c3 { background: #2196f3; bottom: -5px; left: -8px; }
.c4 { background: #e91e63; bottom: 10px; right: -10px; }

.id-box {
    border: 1px solid var(--line);
    border-radius: 8px;
    padding: 22px;
    width: 100%;
    margin: 24px auto;
    font-size: 13px;
    background: #f8faf9;
    color: var(--muted);
}

.id-box b {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-size: 20px;
    color: var(--ink);
    margin: 10px 0;
    font-weight: 800;
}

.copy-btn {
    background: none;
    border: none;
    color: var(--green);
    cursor: pointer;
    font-size: 18px;
    padding: 4px;
    transition: transform 0.1s ease;
}

.copy-btn:hover {
    transform: scale(1.15);
}
</style>

@section('content')
<main class="request-ui">
    <div class="success-ui">
        <div class="success-check-wrapper">
            <div class="success-check">✓</div>
            <div class="confetti-dot c1"></div>
            <div class="confetti-dot c2"></div>
            <div class="confetti-dot c3"></div>
            <div class="confetti-dot c4"></div>
        </div>

        <h1 style="font-size: 26px; font-weight: 800; margin-bottom: 8px;">Request Submitted<br>Successfully!</h1>
        <p style="font-size: 13px; color: var(--muted);">Thank you for contributing towards a cleaner, sustainable Bengaluru.</p>

        <div class="id-box">
            <span>Your Request ID</span>
            <b id="successReqId">
                <span id="reqIdText">{{ request('id', 'DCL-2025-000123') }}</span>
                <button class="copy-btn" onclick="copyReqId()" title="Copy Request ID"><i class="bi bi-copy"></i></button>
            </b>
            <span style="font-size: 11px;">You will receive real-time SMS updates<br>on your registered mobile number.</span>
        </div>

        <div style="display: flex; flex-direction: column; gap: 12px; align-items: center;">
            <a class="btn-ui" href="{{ url('/') }}" style="width: 100%; text-align: center;">Go to Dashboard</a>
            <a href="{{ route('citizen.report') }}" style="color: var(--green); text-decoration: none; font-weight: 700; font-size: 13px;">Create Another Request</a>
        </div>
    </div>
</main>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof hideLoader === 'function') hideLoader();

    const searchId = new URLSearchParams(window.location.search).get('id');
    if (searchId) {
        document.getElementById('reqIdText').innerText = searchId;
    }
});

function copyReqId() {
    const reqId = document.getElementById('reqIdText').innerText;
    navigator.clipboard.writeText(reqId).then(() => {
        alert(`Request ID ${reqId} copied to clipboard!`);
    });
}
</script>
@endsection
