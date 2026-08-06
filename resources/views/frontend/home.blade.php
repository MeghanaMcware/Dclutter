@extends('layouts.app')

<style>
:root {
    --brand-green: #087d45;
    --brand-green-dark: #055a31;
    --brand-green-light: #e8f5ed;
    --ink-dark: #17251d;
    --ink-muted: #56645b;
    --border-color: #e4e9e6;
}

/* ---------------- Hero Section ---------------- */
.heronew {
    position: relative;
    min-height: 340px;
    background: linear-gradient(90deg, 
        rgba(255, 255, 255, 0.96) 0%, 
        rgba(255, 255, 255, 0.88) 40%, 
        rgba(255, 255, 255, 0.4) 70%, 
        rgba(255, 255, 255, 0.1) 100%),
        url('{{ asset("frontendwebsite/img/candd_new_image.png") }}') center right / cover no-repeat;
    overflow: hidden;
    padding: 45px 32px;
    border-radius: 12px;
    margin-bottom: 28px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    border: 1px solid var(--border-color);
}

.heronew-title {
    font-weight: 800;
    font-size: 2.2rem;
    line-height: 1.18;
    color: var(--ink-dark);
}

.heronew-title .accent {
    color: var(--brand-green);
}

.heronew-desc {
    color: var(--ink-muted);
    max-width: 520px;
    font-size: 0.95rem;
    margin-top: 0.8rem;
    line-height: 1.5;
}

.btn-brand-primary {
    background-color: var(--brand-green) !important;
    border-color: var(--brand-green) !important;
    color: #fff !important;
    border-radius: 6px !important;
    font-weight: 700 !important;
    padding: 10px 22px !important;
    font-size: 0.9rem !important;
    box-shadow: 0 3px 10px rgba(8, 125, 69, 0.25);
    transition: all 0.2s ease-in-out;
}

.btn-brand-primary:hover {
    background-color: var(--brand-green-dark) !important;
    border-color: var(--brand-green-dark) !important;
    transform: translateY(-1px);
}

.btn-brand-outline {
    background-color: #ffffff !important;
    border: 1.5px solid #aebbb4 !important;
    color: var(--ink-dark) !important;
    border-radius: 6px !important;
    font-weight: 700 !important;
    padding: 10px 22px !important;
    font-size: 0.9rem !important;
    transition: all 0.2s ease-in-out;
}

.btn-brand-outline:hover {
    background-color: #f7faf8 !important;
    border-color: var(--brand-green) !important;
    color: var(--brand-green) !important;
}

/* ---------------- How It Works ---------------- */
.how-it-works-card {
    border: 1px solid var(--border-color);
    border-radius: 10px;
    background: #ffffff;
    padding: 24px;
    margin-bottom: 28px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
}

.how-it-works-title {
    font-size: 1.25rem;
    font-weight: 800;
    color: var(--ink-dark);
    margin-bottom: 20px;
}

.steps-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    position: relative;
    padding: 10px 0;
}

.steps-wrapper::before {
    content: '';
    position: absolute;
    top: 32px;
    left: 8%;
    right: 8%;
    height: 2px;
    background: #d8e3dc;
    z-index: 1;
}

.step-item {
    position: relative;
    z-index: 2;
    text-align: center;
    flex: 1;
    padding: 0 10px;
}

.step-num {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: var(--brand-green);
    color: #ffffff;
    font-weight: 800;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 12px;
    box-shadow: 0 3px 8px rgba(8, 125, 69, 0.2);
}

.step-item h6 {
    font-weight: 700;
    font-size: 0.95rem;
    color: var(--ink-dark);
    margin-bottom: 4px;
}

.step-item p {
    font-size: 0.78rem;
    color: var(--ink-muted);
    margin: 0;
    line-height: 1.35;
}

/* ---------------- D-Clutter Categories ---------------- */
.waste-categories {
    border: 1px solid var(--border-color);
    border-radius: 10px;
    background: #ffffff;
    padding: 22px;
    margin-bottom: 28px;
}

.waste-categories-title {
    font-size: 1.1rem;
    font-weight: 800;
    color: var(--ink-dark);
    margin-bottom: 16px;
}

.waste-category-list {
    display: flex;
    gap: 12px;
}

.waste-category-pill {
    flex: 1;
    background: #f2f5f3;
    border: 1px solid #e1e7e3;
    border-radius: 6px;
    color: #2b3930;
    font-size: 0.85rem;
    font-weight: 700;
    padding: 12px 10px;
    text-align: center;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s ease;
}

.waste-category-pill:hover {
    background: var(--brand-green);
    color: #ffffff;
    border-color: var(--brand-green);
    transform: translateY(-2px);
}

/* ---------------- Key Benefits ---------------- */
.benefits-section {
    border: 1px solid var(--border-color);
    border-radius: 10px;
    background: #ffffff;
    padding: 24px;
    margin-bottom: 32px;
}

.benefits-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 16px;
    margin-top: 16px;
}

.benefit-card {
    background: #f8faf9;
    border: 1px solid #e7ede9;
    border-radius: 8px;
    padding: 16px;
    text-align: center;
}

.benefit-icon {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: var(--brand-green-light);
    color: var(--brand-green);
    font-size: 1.2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 10px;
}

.benefit-card h6 {
    font-size: 0.85rem;
    font-weight: 700;
    color: var(--ink-dark);
    margin-bottom: 4px;
}

.benefit-card p {
    font-size: 0.75rem;
    color: var(--ink-muted);
    margin: 0;
    line-height: 1.3;
}

@media (max-width: 991px) {
    .steps-wrapper { flex-wrap: wrap; gap: 20px; }
    .steps-wrapper::before { display: none; }
    .step-item { flex: 1 1 45%; }
    .benefits-grid { grid-template-columns: repeat(2, 1fr); }
    .waste-category-list { flex-wrap: wrap; }
    .waste-category-pill { flex: 1 1 45%; }
}

@media (max-width: 576px) {
    .heronew { padding: 24px 18px; }
    .heronew-title { font-size: 1.6rem; }
    .step-item { flex: 1 1 100%; }
    .benefits-grid { grid-template-columns: 1fr; }
    .waste-category-pill { flex: 1 1 100%; }
}
</style>

@section('content')
<div class="container my-4">
    <!-- HERO BANNER -->
    <section class="heronew d-flex align-items-center">
        <div class="row w-100">
            <div class="col-12 col-lg-8">
                <h1 class="heronew-title mb-2">
                    Together, Let's<br>
                    Build a <span class="accent">Cleaner Bengaluru</span>
                </h1>
                <p class="heronew-desc">
                    A single window platform for all your D-Clutter (Construction &amp; Demolition) Waste management needs. Report waste, track collection, and ensure eco-friendly disposal.
                </p>
                <div class="d-flex flex-wrap gap-3 mt-4">
                    <a href="{{ route('citizen.report') }}" class="btn btn-brand-primary d-inline-flex align-items-center gap-2">
                        <i class="bi bi-plus-circle-fill"></i> Report D-Clutter Waste
                    </a>
                    <a href="{{ route('citizen.track') }}" class="btn btn-brand-outline d-inline-flex align-items-center gap-2">
                        <i class="bi bi-search"></i> Track Your Request
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- HOW IT WORKS -->
    <section class="how-it-works-card" id="processflow">
        <h3 class="how-it-works-title">How It Works</h3>
        <div class="steps-wrapper">
            <div class="step-item">
                <div class="step-num">1</div>
                <h6>Raise Request</h6>
                <p>Submit D-Clutter waste pickup request with site details.</p>
            </div>
            <div class="step-item">
                <div class="step-num">2</div>
                <h6>Verification</h6>
                <p>We confirm waste specs and schedule pickup.</p>
            </div>
            <div class="step-item">
                <div class="step-num">3</div>
                <h6>Assigned</h6>
                <p>Vehicle &amp; authorized contractor assigned.</p>
            </div>
            <div class="step-item">
                <div class="step-num">4</div>
                <h6>Pickup</h6>
                <p>Waste is collected directly from your site.</p>
            </div>
            <div class="step-item">
                <div class="step-num">5</div>
                <h6>Disposed</h6>
                <p>Waste is safely disposed &amp; recycled responsibly.</p>
            </div>
        </div>
    </section>

    <!-- D-CLUTTER CATEGORIES -->
    <section class="waste-categories">
        <h3 class="waste-categories-title">D-Clutter Categories</h3>
        <div class="waste-category-list">
            <a href="{{ route('citizen.report') }}?type=Bricks%20%2F%20Concrete" class="waste-category-pill">Furniture</a>
            <a href="{{ route('citizen.report') }}?type=Tiles%20%2F%20Ceramics" class="waste-category-pill">Mattresses & Cushions</a>
            <a href="{{ route('citizen.report') }}?type=Metal%20%2F%20Steel" class="waste-category-pill">Electronics</a>
            <a href="{{ route('citizen.report') }}?type=Wood%20%2F%20C%26D%20Parts" class="waste-category-pill">Clothes & Footwear</a>
            <a href="{{ route('citizen.report') }}?type=Wood%20%2F%20C%26D%20Parts" class="waste-category-pill">Books & Magazines</a>
            <a href="{{ route('citizen.report') }}?type=Others" class="waste-category-pill">Others</a>
        </div>
    </section>

    <!-- KEY BENEFITS OF THE SYSTEM -->
    <section class="benefits-section">
        <h3 class="waste-categories-title mb-1">Key System Benefits</h3>
        <p class="text-muted small mb-0">Empowering citizens and municipal authorities for sustainable urban D-Clutter waste handling.</p>

        <div class="benefits-grid">
            <div class="benefit-card">
                <div class="benefit-icon"><i class="bi bi-window"></i></div>
                <h6>Single-Window Service</h6>
                <p>All-in-one portal for reporting, scheduling, and payment handling.</p>
            </div>

            <div class="benefit-card">
                <div class="benefit-icon"><i class="bi bi-geo-alt"></i></div>
                <h6>Real-Time Tracking</h6>
                <p>Track contractor assignment &amp; vehicle location step-by-step.</p>
            </div>

            <div class="benefit-card">
                <div class="benefit-icon"><i class="bi bi-shield-check"></i></div>
                <h6>Transparent Updates</h6>
                <p>Automated SMS and online status logs at every stage.</p>
            </div>

            <div class="benefit-card">
                <div class="benefit-icon"><i class="bi bi-recycle"></i></div>
                <h6>Authorized Recycling</h6>
                <p>Guaranteed transportation to certified processing plants.</p>
            </div>

            <div class="benefit-card">
                <div class="benefit-icon"><i class="bi bi-camera-fill"></i></div>
                <h6>Photo Evidence</h6>
                <p>Digital records and photo proof before &amp; after disposal.</p>
            </div>
        </div>
    </section>
</div>
@endsection
