<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 footer-copyright text-start">
                <p class="mb-0">
                    {{ __('footer.copyright', ['year' => now()->year]) }}
                </p>
            </div>
            <div class="col-md-6 text-end">
                <p class="mb-0">
                    {{ __('footer.handcrafted') }}
                    <i class="fa fa-heart text-danger"></i>
                </p>
            </div>
        </div>
    </div>
</footer>
