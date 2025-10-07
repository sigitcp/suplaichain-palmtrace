

<!-- Library Bundle Script -->
<script src="{{ asset('assets/js/core/libs.min.js') }}"></script>

<!-- External Library Bundle Script -->
<script src="{{ asset('assets/js/core/external.min.js') }}"></script>

<!-- Widgetchart Script -->
<script src="{{ asset('assets/js/charts/widgetcharts.js') }}"></script>

<!-- mapchart Script -->
<script src="{{ asset('assets/js/charts/vectore-chart.js') }}"></script>
<script src="{{ asset('assets/js/charts/dashboard.js') }}"></script>

<!-- fslightbox Script -->
<script src="{{ asset('assets/js/plugins/fslightbox.js') }}"></script>

<!-- Settings Script -->
<script src="{{ asset('assets/js/plugins/setting.js') }}"></script>

<!-- Slider-tab Script -->
<script src="{{ asset('assets/js/plugins/slider-tabs.js') }}"></script>

<!-- Form Wizard Script -->
<script src="{{ asset('assets/js/plugins/form-wizard.js') }}"></script>

<!-- AOS Animation Plugin -->
<script src="{{ asset('assets/vendor/aos/dist/aos.js') }}"></script>

<!-- App Script -->
<script src="{{ asset('assets/js/hope-ui.js') }}" defer></script>



<script>
    const colorPicker = document.getElementById("colorPicker");
    const colorCode = document.getElementById("colorCode");

    // Fungsi untuk konversi #rgb -> #rrggbb
    function expandHex(shortHex) {
        if (/^#([0-9A-F]{3})$/i.test(shortHex)) {
            return "#" + shortHex[1] + shortHex[1] + shortHex[2] + shortHex[2] + shortHex[3] + shortHex[3];
        }
        return shortHex;
    }

    // Kalau pilih warna dari color picker → update input text
    colorPicker.addEventListener("input", function() {
        colorCode.value = this.value;
    });

    // Kalau edit kode warna di text → update color picker
    colorCode.addEventListener("input", function() {
        let val = this.value.trim();

        // Otomatis tambahkan '#' kalau tidak ada
        if (!val.startsWith("#")) {
            val = "#" + val;
        }

        // Expand kalau #rgb
        val = expandHex(val);

        // Cek valid #rrggbb
        if (/^#([0-9A-F]{6})$/i.test(val)) {
            colorPicker.value = val; // update color picker
            this.classList.remove("is-invalid");
        } else {
            this.classList.add("is-invalid");
        }
    });
</script>

<script>
    const colorEditPicker = document.getElementById("colorEditPicker");
    const colorEditCode = document.getElementById("colorEditCode");

    // Fungsi untuk konversi #rgb -> #rrggbb
    function expandHex(shortHex) {
        if (/^#([0-9A-F]{3})$/i.test(shortHex)) {
            return "#" + shortHex[1] + shortHex[1] + shortHex[2] + shortHex[2] + shortHex[3] + shortHex[3];
        }
        return shortHex;
    }

    // Kalau pilih warna dari color picker → update input text
    colorEditPicker.addEventListener("input", function() {
        colorEditCode.value = this.value;
    });

    // Kalau edit kode warna di text → update color picker
    colorEditCode.addEventListener("input", function() {
        let val = this.value.trim();

        // Otomatis tambahkan '#' kalau tidak ada
        if (!val.startsWith("#")) {
            val = "#" + val;
        }

        // Expand kalau #rgb
        val = expandHex(val);

        // Cek valid #rrggbb
        if (/^#([0-9A-F]{6})$/i.test(val)) {
            colorEditPicker.value = val; // update color picker
            this.classList.remove("is-invalid");
        } else {
            this.classList.add("is-invalid");
        }
    });
</script>