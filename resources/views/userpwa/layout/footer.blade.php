<footer class="user-footer">
    <div class="user-footer__skyline" aria-hidden="true"></div>
    <div class="user-footer__content">
        <div class="user-footer__brand">
            <span class="user-footer__logo"><i class="fa-solid fa-leaf" aria-hidden="true"></i></span>
            <strong>DCLUTTER</strong>
        </div>
        <div class="user-footer__tagline">BENGALURU'S CLEAN STREETS</div>
        <div class="user-footer__heart" aria-hidden="true"><i class="fa-solid fa-heart"></i></div>
        <div class="user-footer__copyright">&copy; 2026 DCLUTTER. All rights reserved.</div>
         <p class="mb-0 footernewp">
                      <span class="text-primary"  style="cursor: pointer;">
                        Version 1.0
                      </span> | Designed and Developed by
                      <a href="https://mcwaretechnologies.com/" target="_blank"
                          style="text-decoration: none; color: #007bff;">
                          McWare Technologies
                      </a>
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
        border-radius: 18px 18px 18px 18px;
        color: #64748b;
            border: 1px solid #00000036;
                margin: 30px 10px 15px;
    }
    .footernewp{
        font-size:11px;
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
        border: 2px solid #18b86c;
        border-radius: 50%;
        color: #0aaf5c;
        background: #fff;
        font-size: 18px;
        transform: rotate(-12deg);
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

    .user-footer__heart {
        margin: 7px auto 6px;
        color: #078b4c;
        font-size: 11px;
    }

    .user-footer__copyright,
    .user-footer__made {
        font-size: 11px;
        line-height: 1.5;
    }

    .user-footer__made i {
        color: #ef476f;
        margin: 0 2px;
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
    }
</style>