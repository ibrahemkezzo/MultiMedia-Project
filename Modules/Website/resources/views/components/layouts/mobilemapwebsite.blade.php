{{-- Modules/Website/resources/views/components/mobile-map.blade.php --}}

<div class="mobile-map">
    <div id="mobileMapModal" class="d-none modal" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5); z-index: 1055;">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">store Locations</h5>
                    <button type="button" class="btn-close" id="closeMobileMap"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light">
                        <div class="text-center p-4">
                            <div class="bg-secondary bg-opacity-10 rounded p-5 mb-3">
                                <svg width="64" height="64" fill="currentColor" class="text-muted" viewBox="0 0 16 16">
                                    <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"></path>
                                </svg>
                            </div>
                            <h6 class="text-muted mb-2">interactiveMap</h6>
                            <p class="text-muted small mb-0">mapComingSoon</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
