{{--
    Perbaikan upload file (materi diklat, template sertifikat, dll) saat
    diakses lewat tunnel ngrok gratis.

    ngrok versi gratis kadang menampilkan halaman peringatan/interstitial
    sebelum meneruskan request ke server. Untuk navigasi halaman biasa itu
    tidak masalah, tapi untuk request AJAX/XHR (termasuk upload file
    Livewire) itu bikin request-nya gagal dengan status 401 karena tidak
    ada cara bagi JavaScript untuk "klik lewati" halaman peringatan itu.

    Header `ngrok-skip-browser-warning` memberi tahu ngrok untuk
    melewati peringatan tersebut untuk request ini. Script ini otomatis
    menambahkan header itu ke semua request fetch/XHR, tapi HANYA kalau
    halaman sedang diakses lewat domain ngrok — supaya tidak mengubah apa
    pun saat aplikasi diakses lewat domain normal/production.
--}}
<script>
    (function () {
        if (!/ngrok/i.test(window.location.hostname)) {
            return;
        }

        var HEADER_NAME = 'ngrok-skip-browser-warning';

        var originalFetch = window.fetch;
        if (typeof originalFetch === 'function') {
            window.fetch = function (input, init) {
                init = init || {};
                var headers = new Headers(init.headers || {});
                headers.set(HEADER_NAME, 'true');
                init.headers = headers;
                return originalFetch(input, init);
            };
        }

        var originalOpen = XMLHttpRequest.prototype.open;
        XMLHttpRequest.prototype.open = function () {
            var result = originalOpen.apply(this, arguments);
            try {
                this.setRequestHeader(HEADER_NAME, 'true');
            } catch (e) {
                // Diamkan kalau browser menolak set header sebelum open() selesai.
            }
            return result;
        };
    })();
</script>
