 <div class="footer-card card shape-rounded bg-20" style="height:230px;z-index:-1;">
    <div class="card-overlay bg-highlight opacity-90"></div>
</div> 


<div class="footer card card-style mx-0 mb-0">
    <a href="#" class="footer-title pt-4 new-family d-flex flex-column align-items-center justify-content-center">
        <h2>CLEARIT</h2>
    </a>
    <p class="text-center font-12 mt-n1 mb-3 opacity-70">
        <span class="color-highlight"></span>
    </p>
    <p class="boxed-text-l new-family">
        {{ __('messages.footermsg') }}
        <a href="#" onclick="window.location.href='tel:+911124360721'">
            +91-11-2436-0721
        </a>
    </p>
    <div class="text-center mb-3">
        <a href="https://www.facebook.com/people/Bswml-Bengaluru/pfbid0fEPiBEJprCesDJYvkC5N967cGPRrGLy3CzQfRohipjHwjjrhBYWX6hpf1KrpQXBal/"
            class="icon icon-xs rounded-sm shadow-l me-1 bg-facebook"><i class="fab fa-facebook-f"></i></a>
        <a href="https://x.com/BSWML_GBA/" class="icon icon-xs rounded-sm shadow-l me-1"
            style="background-color: #000000; color: white;"><i class="fab fa-x-twitter"></i></a>
        <a href="https://www.instagram.com/BSWML_GBA/" class="icon icon-xs rounded-sm shadow-l me-1"
            style="background-color: #e4405f; color: white;"><i class="fab fa-instagram"></i></a>
        <a href="https://www.youtube.com/@BSWML_GBA" class="icon icon-xs rounded-sm me-1 shadow-l"
            style="background-color: #ff0000; color: white;"><i class="fab fa-youtube"></i></a>
        <a href="#" class="back-to-top icon icon-xs rounded-sm shadow-l bg-highlight color-white"><i
                class="fa fa-arrow-up"></i></a>
    </div>
    <span class="d-flex flex-column gap-1 footer-copyright">
        <!-- <p class=" mb-1 new-family d-flex flex-row gap-2 justify-content-center">
            <a class="" href="">{{ __('messages.about') }}</a>
            <a class="" href="">{{ __('messages.termsPrivacyPlocy') }}</a>
        </p> -->
        <p class=" mb-0 new-family">{{ __('messages.footercopyright') }} &copy; <a href="">{{ __('messages.udmc') }}</a>
            <span id="copyright-year">2026</span>{{ __('messages.footerallright') }}
        </p>
        <p class="mb-1 new-family text-center opacity-70 text-dark">
            <span class="text-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" style="cursor:pointer">
                Version 1.0.0
            </span> | Designed and Developed by <a href="https://mcwaretechnologies.com/" target="_blank"
                          style="text-decoration: none; color: #007bff;">
                          McWare Technologies
                      </a>
        </p>
    </span>

</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title new-family" id="exampleModalLabel">Version Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body changelog-container">
                <div class="">
                    
                        <div class="changelog-item">
                            <div class="version-header">
                                <div>
                                    <span class="version-number new-family">v1.0.0</span>
                                  
                                        <span class="latest-badge new-family">LATEST</span>
                                  
                                </div>
                                <span class="release-date new-family">01 Jan 2023</span>
                            </div>
                            <ul class="update-list">
                                <li class="update-item new-family">
                                    <span
                                        class="update-label label-new new-family">
                                       new
                                    </span>
                                        
                                </li>
                               
                                    <li class="update-item mt-1">
                                        <a href="" target="_blank"
                                            class="text-primary new-family">
                                            <i class="bi bi-file-pdf"></i> View Release Notes
                                        </a>
                                    </li>
                             
                            </ul>
                        </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>
<div class="footer-card card shape-rounded bg-20" style="height:230px">
    <div class="card-overlay bg-highlight opacity-90"></div>
</div>

<style>
    .changelog-container {
        height: 50vh;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #ccc #f1f1f1;
    }

    .changelog-container::-webkit-scrollbar {
        width: 6px;
    }

    .changelog-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }

    .changelog-container::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 3px;
    }

    .changelog-container::-webkit-scrollbar-thumb:hover {
        background: #999;
    }

    .changelog-item {
        border-bottom: 1px solid #e9ecef;
        padding: 15px 0;
        margin-bottom: 10px;
    }

    .changelog-item:last-child {
        border-bottom: none;
    }

    .version-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .version-number {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
    }

    .release-date {
        color: #6c757d7a;
        font-size: 0.9rem;
    }

    .latest-badge {
        background-color: #28a745;
        color: white;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 500;
        margin-left: 10px;
    }

    .update-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .update-item {
        padding: 5px 0;
        padding-left: 20px;
        position: relative;
        font-size: 0.9rem;
        color: #555;
    }

    .update-item:before {
        content: "·";
        position: absolute;
        left: 5px;
        color: #007bff;
        font-weight: bold;
    }

    .update-label {
        display: inline-block;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 0.7rem;
        font-weight: 600;
        margin-right: 8px;
        text-transform: uppercase;
    }

    .label-new {
        background-color: #d4edda;
        color: #155724;
    }

    .label-fix {
        background-color: #f8d7da;
        color: #721c24;
    }

    .modal-content {
        border-radius: 15px;
    }
</style>