<!-- PWA Manifest & Meta Tags -->
<link rel="manifest" href="{{ asset('manifest.json') }}">
<meta name="theme-color" content="#0e7a43">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<meta name="apple-mobile-web-app-title" content="D-Clutter">
<link rel="apple-touch-icon" href="{{ asset('icons/icon-192x192.png') }}">
<link rel="apple-touch-icon" sizes="152x152" href="{{ asset('icons/icon-152x152.png') }}">
<link rel="apple-touch-icon" sizes="192x192" href="{{ asset('icons/icon-192x192.png') }}">
<link rel="apple-touch-icon" sizes="512x512" href="{{ asset('icons/icon-512x512.png') }}">
<link rel="icon" type="image/png" sizes="192x192" href="{{ asset('icons/icon-192x192.png') }}">

<!-- PWA Service Worker Registration -->
<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('{{ asset("sw.js") }}', { scope: '/' })
                .then(function(reg) {
                    console.log('PWA ServiceWorker registered with scope: ', reg.scope);
                })
                .catch(function(err) {
                    console.warn('PWA ServiceWorker registration failed: ', err);
                });
        });
    }
</script>
