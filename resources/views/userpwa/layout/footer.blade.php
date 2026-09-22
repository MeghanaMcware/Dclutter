<footer class="user-footer">
    <div class="user-footer__skyline" aria-hidden="true"></div>
    <div class="user-footer__content">
        <div class="user-footer__brand">
            <span class="user-footer__logo">
                <img src="{{ asset('frontendwebsite/img/GBA-removebg-preview.png') }}" alt="DCLUTTER logo">
            </span>
            <strong>DCLUTTER</strong>
        </div>

        <div class="user-footer__tagline">BENGALURU'S CLEAN STREETS</div>

        <ul class="user-footer__social">
            <li>
                <a href="https://www.facebook.com/people/Bswml-Bengaluru/pfbid0fEPiBEJprCesDJYvkC5N967cGPRrGLy3CzQfRohipjHwjjrhBYWX6hpf1KrpQXBal/" target="_blank" rel="noopener noreferrer"
                   class="user-footer__social-link is-facebook" aria-label="Facebook">
                    <i class="fa-brands fa-facebook-f" aria-hidden="true"></i>
                </a>
            </li>
            <li>
                <a href="https://x.com/BSWML_GBA/" target="_blank" rel="noopener noreferrer"
                   class="user-footer__social-link is-twitter" aria-label="Twitter">
                    <i class="fab fa-x-twitter"></i>
                </a>
            </li>
            <li>
                <a href="https://www.instagram.com/BSWML_GBA/" target="_blank" rel="noopener noreferrer"
                   class="user-footer__social-link is-whatsapp" aria-label="instgram">
                    <i class="fab fa-instagram"></i>
                </a>
            </li>
            <li>
                <a href="https://www.youtube.com/@BSWML_GBA" target="_blank" rel="noopener noreferrer"
                   class="user-footer__social-link is-youtube" aria-label="instgram">
                   <i class="fab fa-youtube"></i>
                </a>
            </li>
        </ul>

        <div class="user-footer__copyright">&copy; {{ date('Y') }} DCLUTTER. All rights reserved.</div>

        <p class="mb-0 footernewp">
            <span class="text-primary" style="cursor: pointer;">Version 1.0</span> | Designed and Developed by
            <a href="https://mcwaretechnologies.com/" target="_blank" rel="noopener noreferrer"
               style="text-decoration: none; color: #007bff;">McWare Technologies</a>
        </p>
    </div>
</footer>

<style>
.user-footer {
    position: relative;
    isolation: isolate;
    min-height: 154px;
    max-width: 420px;
    overflow: hidden;
    background: linear-gradient(180deg, #f2f8ff 0%, #eef8ff 72%, #dff4ec 100%);
    border-radius: 18px;
    color: #64748b;
    border: 1px solid #00000036;
    margin: 30px auto 15px;
}

.footernewp {
    font-size: 10px;
}

.user-footer__content {
    position: relative;
    z-index: 2;
    padding: 19px 12px 22px;
    text-align: center;
}

.user-footer__brand {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    color: #087d45;
}

.user-footer__logo {
    display: grid;
    width: 32px;
    height: 32px;
    place-items: center;
    padding: 3px;
    overflow: hidden;
    border: 2px solid #18b86c;
    border-radius: 50%;
    background: #fff;
    transform: rotate(-12deg);
}

.user-footer__logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.user-footer__brand strong {
    font-size: 24px;
    font-weight: 800;
    letter-spacing: 0.5px;
}

.user-footer__tagline {
    margin-top: 2px;
    color: #71839a;
    font-size: 9px;
    font-weight: 700;
    letter-spacing: 2px;
}

/* --- social buttons --- */
.user-footer__social {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin: 12px 0 10px;
    padding: 0;
    list-style: none;
}

.user-footer__social-link {
    display: grid;
    place-items: center;
    width: 34px;
    height: 34px;
    border-radius: 10px;
    color: #fff;
    font-size: 15px;
    text-decoration: none;
    transition: transform .18s ease, box-shadow .18s ease, filter .18s ease;
}

.user-footer__social-link:hover,
.user-footer__social-link:focus-visible {
    color: #fff;
    transform: translateY(-2px);
    filter: brightness(1.06);
    box-shadow: 0 6px 14px rgba(15, 23, 42, .18);
}

.user-footer__social-link:focus-visible {
    outline: 2px solid #0f172a;
    outline-offset: 2px;
}

.is-facebook  { background: #3b5998; }
.is-twitter   { background: #000; }
.is-whatsapp  { background: #e4405f; }
.is-youtube  { background: #ff0000; }

.user-footer__copyright {
    font-size: 11px;
    line-height: 1.5;
}

.user-footer__skyline {
    position: absolute;
    inset: auto 0 0;
    height: 58px;
    opacity: 0.42;
    background: linear-gradient(135deg, transparent 10%, #cfe6f3 10% 15%, transparent 15% 22%, #cfe6f3 22% 28%, transparent 28% 35%, #cfe6f3 35% 40%, transparent 40% 49%, #cfe6f3 49% 54%, transparent 54% 64%, #cfe6f3 64% 70%, transparent 70% 78%, #cfe6f3 78% 84%, transparent 84%);
    clip-path: polygon(0 45%, 4% 45%, 4% 28%, 8% 28%, 8% 55%, 13% 55%, 13% 18%, 18% 18%, 18% 48%, 23% 48%, 23% 32%, 28% 32%, 28% 52%, 34% 52%, 34% 12%, 39% 12%, 39% 43%, 46% 43%, 46% 24%, 52% 24%, 52% 48%, 58% 48%, 58% 16%, 64% 16%, 64% 48%, 72% 48%, 72% 25%, 78% 25%, 78% 50%, 85% 50%, 85% 10%, 91% 10%, 91% 48%, 100% 48%, 100% 100%, 0 100%);
}

@media (max-width: 360px) {
    .user-footer__brand strong { font-size: 21px; }
    .user-footer__tagline { letter-spacing: 1.4px; }
    .user-footer__social-link { width: 31px; height: 31px; font-size: 14px; }
}
</style>