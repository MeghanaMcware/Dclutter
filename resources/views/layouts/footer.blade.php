<footer id="footer" class="footer-custom">
    <!-- Top accent bar -->
    <div class="footer-top-bar"></div>

    <div class="container footer-content py-5">
        <div class="row gy-4">
            
            <!-- Column 1: Brand & About -->
            <div class="col-lg-4 col-md-6 footer-brand-col">
                <a href="{{ url('/') }}" class="footer-logo d-flex align-items-center mb-3 text-decoration-none">
                    <img src="{{ asset('frontendwebsite/img/GBA-removebg-preview.png') }}" alt="GBA D-Clutter Logo" class="footer-logo-img me-2">
                    <div class="d-flex flex-column">
                        <span class="footer-brand-title">D-CLUTTER</span>
                        <!-- <span class="footer-brand-subtitle">D-CLUTTER PORTAL</span> -->
                    </div>
                </a>
                <p class="footer-description">
                    Empowering Bengaluru with rapid clutter clearance and efficient waste management for a cleaner, greener city environment.
                </p>
                <div class="footer-social-links d-flex gap-2 mt-4">
                    <a href="https://www.facebook.com/GBAoffice" target="_blank" aria-label="Facebook" class="social-btn"><i class="bi bi-facebook"></i></a>
                    <a href="https://x.com/BSWML_GBA/" target="_blank" aria-label="Twitter X" class="social-btn"><i class="bi bi-twitter-x"></i></a>
                    <a href="https://www.instagram.com/gba_office/?igsh=MW80dDF6cTE4dDNzOQ%3D%3D" target="_blank" aria-label="Instagram" class="social-btn"><i class="bi bi-instagram"></i></a>
                    <a href="https://www.youtube.com/@gba_office" target="_blank" aria-label="YouTube" class="social-btn"><i class="bi bi-youtube"></i></a>
                </div>
            </div>

            <!-- Column 2: Quick Links -->
            <div class="col-lg-2 col-md-6 footer-links-col">
                <h5 class="footer-heading">Quick Links</h5>
                <ul class="footer-links-list list-unstyled ps-0">
                    <li><a href="{{ url('/') }}"><i class="bi bi-chevron-right me-1"></i> Home</a></li>
                    <li><a href="{{ route('citizen.report') }}"><i class="bi bi-chevron-right me-1"></i> Report Request</a></li>
                    <li><a href="{{ route('citizen.track') }}"><i class="bi bi-chevron-right me-1"></i> Track Request</a></li>
                    <li><a href="{{ url('/#processflow') }}"><i class="bi bi-chevron-right me-1"></i> Process Flow</a></li>
                </ul>
            </div>

            <!-- Column 3: Contact Details -->
            <div class="col-lg-3 col-md-6 footer-contact-col">
                <h5 class="footer-heading">Contact Details</h5>
                <ul class="footer-contact-list list-unstyled ps-0">
                    <li class="d-flex align-items-start mb-3">
                        <i class="bi bi-geo-alt-fill contact-icon me-2 mt-1"></i>
                        <span>Greater Bengaluru Authority (GBA) & BSWML Office, Bengaluru, Karnataka</span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="bi bi-telephone-fill contact-icon me-2"></i>
                        <a href="tel:+91-11-2436-0721" class="contact-link">+91-11-2436-0721</a>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="bi bi-envelope-fill contact-icon me-2"></i>
                        <a href="mailto:info@bswml.net" class="contact-link">info@bswml.net</a>
                    </li>
                </ul>
            </div>

            <!-- Column 4: Visitor Count & CTA -->
            <div class="col-lg-3 col-md-6 footer-action-col">
                <h5 class="footer-heading">Portal Statistics</h5>
                <div class="visitor-card p-3 rounded-3 mb-3">
                    <div class="d-flex align-items-center">
                        <div class="visitor-icon-box me-3">
                            <i class="bi bi-people-fill fs-4"></i>
                        </div>
                        <div>
                            <span class="visitor-label d-block">Total Visitor Count</span>
                            <span class="visitor-count-number fw-bold fs-4">{{ number_format((int) ($visitorCount ?? 0)) }}</span>
                        </div>
                    </div>
                </div>
                
               
            </div>

        </div>
    </div>

    <!-- Bottom Copyright Section -->
    <div class="footer-bottom py-3">
        <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between text-center text-md-start gap-2">
            <p class="mb-0 copyright-text">
                © {{ date('Y') }} <strong class="text-white">Greater Bengaluru Authority (GBA)</strong>. All Rights Reserved.
            </p>
            <div class="credits-text">
                Designed & Developed by <a href="https://mcwaretechnologies.com/" target="_blank" class="developer-link">McWare Technologies</a>
            </div>
        </div>
    </div>
</footer>

<style>
/* Custom Footer Styling */
.footer-custom {
    background: linear-gradient(135deg, #071e16 0%, #0a2e21 50%, #05140e 100%);
    color: #e0e7e4;
    font-family: 'Inter', sans-serif !important;
    position: relative;
    overflow: hidden;
}

.footer-custom::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at 80% 20%, rgba(16, 185, 129, 0.08) 0%, transparent 60%);
    pointer-events: none;
}

.footer-top-bar {
    height: 4px;
    background: linear-gradient(90deg, #10b981 0%, #059669 40%, #34d399 70%, #10b981 100%);
    box-shadow: 0 0 12px rgba(16, 185, 129, 0.6);
}

.footer-logo-img {
    height: 48px;
    width: auto;
    object-fit: contain;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
}

.footer-brand-title {
    color: #ffffff;
    font-size: 1.25rem;
    font-weight: 800;
    letter-spacing: 1px;
    line-height: 1.1;
}

.footer-brand-subtitle {
    color: #34d399;
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 1.5px;
}

.footer-description {
    color: #a3b8b0;
    font-size: 0.9rem;
    line-height: 1.6;
    margin-top: 10px;
}

.footer-heading {
    color: #ffffff;
    font-size: 1.05rem;
    font-weight: 700;
    position: relative;
    padding-bottom: 10px;
    margin-bottom: 18px;
    letter-spacing: 0.5px;
}

.footer-heading::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    width: 32px;
    height: 3px;
    background: #10b981;
    border-radius: 2px;
}

.footer-links-list li {
    margin-bottom: 10px;
}

.footer-links-list a {
    color: #a3b8b0;
    text-decoration: none;
    font-size: 0.9rem;
    transition: all 0.25s ease;
    display: inline-flex;
    align-items: center;
}

.footer-links-list a i {
    font-size: 0.75rem;
    transition: transform 0.25s ease;
    color: #10b981;
}

.footer-links-list a:hover {
    color: #ffffff;
    transform: translateX(4px);
}

.footer-links-list a:hover i {
    transform: translateX(3px);
}

.footer-contact-list {
    color: #a3b8b0;
    font-size: 0.9rem;
}

.contact-icon {
    color: #10b981;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.contact-link {
    color: #a3b8b0;
    text-decoration: none;
    transition: color 0.25s ease;
}

.contact-link:hover {
    color: #ffffff;
    text-decoration: underline;
}

/* Social buttons */
.social-btn {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.07);
    border: 1px solid rgba(255, 255, 255, 0.12);
    color: #ffffff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.05rem;
    text-decoration: none;
    transition: all 0.3s ease;
}

.social-btn:hover {
    background: #10b981;
    color: #ffffff;
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
    border-color: #10b981;
}

/* Visitor counter card */
.visitor-card {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(8px);
    transition: border-color 0.3s ease;
}

.visitor-card:hover {
    border-color: rgba(16, 185, 129, 0.4);
}

.visitor-icon-box {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    background: rgba(16, 185, 129, 0.15);
    color: #34d399;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid rgba(16, 185, 129, 0.25);
}

.visitor-label {
    color: #94a3b8;
    font-size: 0.78rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.visitor-count-number {
    color: #ffffff;
    letter-spacing: 1px;
}

/* CTA Button */
.btn-footer-cta {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: #ffffff !important;
    font-weight: 600;
    font-size: 0.92rem;
    border-radius: 8px;
    border: none;
    box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3);
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-footer-cta:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(16, 185, 129, 0.45);
    color: #ffffff !important;
}

/* Footer Bottom */
.footer-bottom {
    background: rgba(0, 0, 0, 0.25);
    border-top: 1px solid rgba(255, 255, 255, 0.08);
}

.copyright-text {
    color: #94a3b8;
    font-size: 0.85rem;
}

.credits-text {
    color: #94a3b8;
    font-size: 0.85rem;
}

.developer-link {
    color: #34d399;
    font-weight: 600;
    text-decoration: none;
    transition: color 0.25s ease;
}

.developer-link:hover {
    color: #6ee7b7;
    text-decoration: underline;
}
</style>
