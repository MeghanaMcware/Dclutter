<script src="https://cdn.jsdelivr.net/npm/browser-image-compression@2.0.2/dist/browser-image-compression.js"></script>
<script>
    (function () {
        async function compressImage(file) {
            const options = {
                maxSizeMB: 0.15, // Targets around 150KB
                maxWidthOrHeight: 1024,
                useWebWorker: true,
                initialQuality: 0.6
            };
            try {
                return await imageCompression(file, options);
            } catch (error) {
                console.error("Image compression failed, using original file", error);
                return file;
            }
        }

        async function handleImageUpload(input) {
            if (!input.files || input.files.length === 0) return;

            const files = Array.from(input.files);
            const isAnyImage = files.some(f => f.type.startsWith('image/'));
            if (!isAnyImage || input.getAttribute('data-no-compress')) return;

            try {
                const compressedFiles = await Promise.all(files.map(async (file) => {
                    if (file.type.startsWith('image/') && file.size > 200 * 1024) { // Only if > 200KB
                        return await compressImage(file);
                    }
                    return file;
                }));

                const dataTransfer = new DataTransfer();
                compressedFiles.forEach(f => dataTransfer.items.add(f));
                input.files = dataTransfer.files;

                // Trigger change event manually so other listeners know it's updated
                // We skip bubbling to avoid infinite loop since we use capturing phase listener
            } catch (err) {
                console.error('Compression Error:', err);
            }
        }

        document.addEventListener('change', function(e) {
            if (e.target.tagName === 'INPUT' && e.target.type === 'file' && !e.target.hasAttribute('data-compressing')) {
                e.target.setAttribute('data-compressing', 'true');
                handleImageUpload(e.target).finally(() => {
                    e.target.removeAttribute('data-compressing');
                });
            }
        }, true);
    })();
</script>
