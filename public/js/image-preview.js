document.addEventListener("DOMContentLoaded", function (){
    const input = document.getElementById("image");
    const wrapper = document.getElementById("preview-wrapper");
    const empty = document.getElementById("preview-empty");
    const filled = document.getElementById("preview-filled");
    const img = document.getElementById("preview-img");
    const nameEl = document.getElementById("preview-file-name");
    const removeBtn = document.getElementById("preview-remove");

    // Sembunyikan state pratinjau dan reset UI
    const showEmpty = () => {
        empty.classList.remove("hidden");
        filled.classList.add("hidden");
    };

    // Baca berkas media menggunakan FileReader API
    const showFile = (file) => {
        if (!file) return showEmpty();

        // Validasi tipe MIME di sisi klien (Client-Side Validation)
        if (!file.type.startsWith("image/")) {
            input.value = "";
            showEmpty();
            alert("Berkas yang dipilih harus berupa gambar!");
            return;
        }

        const reader = new FileReader();
        reader.onload = (e) => {
            img.src = e.target.result;
            nameEl.textContent = file.name;
            empty.classList.add("hidden");
            filled.classList.remove("hidden");
        };
        reader.readAsDataURL(file);
    };

    // Event Listener saat file dipilih secara manual
    input.addEventListener("change", () => showFile(input.files[0]));

    // Event Listener tombol hapus pratinjau
    removeBtn.addEventListener("click", (e) => {
        e.stopPropagation();
        input.value = "";
        img.removeAttribute("src");
        showEmpty();
    });

    // Buka dialog pemilih berkas saat area dropzone diklik
    empty.addEventListener("click", () => input.click());

    // --- Implementasi Drag and Drop ---
    wrapper.addEventListener("dragover", (e) => {
        e.preventDefault();
        wrapper.classList.add("bg-blue-50");
    });

    wrapper.addEventListener("dragleave", (e) => {
        e.preventDefault();
        wrapper.classList.remove("bg-blue-50");
    });

    wrapper.addEventListener("drop", (e) => {
        e.preventDefault();
        wrapper.classList.remove("bg-blue-50");

        const file = e.dataTransfer.files[0];
        if (file) {
            // Sinkronisasi file drop ke native HTML File Input via DataTransfer API
            const dt = new DataTransfer();
            dt.items.add(file);
            input.files = dt.files;

            showFile(file);
        }
    });
});