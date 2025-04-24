<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <p class="mb-0">&copy; <script>document.write(new Date().getFullYear())</script> {{ config('app.name') }}. Crafted with <i class="mdi mdi-heart text-danger"></i> by Pixtive</p>
            </div>
            @if (config('app.debug'))
            <div class="col-sm-6">
                <div class="text-sm-end d-none d-sm-block">
                    Page rendered in <strong>{{ round(microtime(true) - LARAVEL_START, 2) }}</strong> seconds
                </div>
            </div>
            @endif
        </div>
    </div>
</footer>
