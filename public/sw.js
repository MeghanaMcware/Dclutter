const CACHE_NAME = 'dclutter-cache-v3';

self.addEventListener('install', (event) => {
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((keys) => {
            return Promise.all(
                keys.map((key) => {
                    if (key !== CACHE_NAME) {
                        return caches.delete(key);
                    }
                })
            );
        }).then(() => self.clients.claim())
    );
});

self.addEventListener('fetch', (event) => {
    // Only intercept HTTP/HTTPS GET requests
    if (event.request.method !== 'GET' || !event.request.url.startsWith('http')) {
        return;
    }

    // Network first, fallback to cache if offline
    event.respondWith(
        fetch(event.request).catch(() => caches.match(event.request))
    );
});
