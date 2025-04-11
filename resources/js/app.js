import "./bootstrap";
import AOS from "aos";
import "aos/dist/aos.css";

document.addEventListener("DOMContentLoaded", function () {
    // semua kode JS kamu taruh di sini
    AOS.init();

    // Fungsi auto scroll one page
    document.querySelectorAll("#faq-accordion details").forEach((detail) => {
        detail.addEventListener("click", function () {
            document
                .querySelectorAll("#faq-accordion details")
                .forEach((item) => {
                    if (item !== detail) item.removeAttribute("open");
                });
        });
    });

    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", function (e) {
            e.preventDefault();

            document.querySelector(this.getAttribute("href")).scrollIntoView({
                behavior: "smooth",
            });
        });
    });

    // reset form
    document.getElementById("form-laporan").reset();

    // Fungsi opsi penggunaan email dan nomor telepon
    const toggle = document.getElementById("toggleContact");
    const contactFields = document.getElementById("contactFields");
    const infoFields = document.getElementById("infoFields");
    const emailInput = document.getElementById("email");
    const phoneInput = document.getElementById("phone");

    toggle.checked = true;

    toggle.addEventListener("change", () => {
        if (toggle.checked) {
            // Tampilkan form email & telepon
            contactFields.classList.remove("hidden", "opacity-0", "scale-95");
            contactFields.classList.add("opacity-100", "scale-100");

            // Fungsi aktivasi input
            if (emailInput) emailInput.disabled = false;
            if (phoneInput) phoneInput.disabled = false;

            // Sembunyikan info pengganti
            infoFields.classList.replace("opacity-100", "opacity-0");
            infoFields.classList.replace("scale-100", "scale-95");
            setTimeout(() => infoFields.classList.add("hidden"), 500);
        } else {
            // Tampilkan info pengganti
            infoFields.classList.remove("hidden", "opacity-0", "scale-95");
            infoFields.classList.add("opacity-100", "scale-100");

            // Fungsi non-aktivasi input
            if (emailInput) emailInput.disabled = true;
            if (phoneInput) phoneInput.disabled = true;

            // Sembunyikan form email & telepon
            contactFields.classList.replace("opacity-100", "opacity-0");
            contactFields.classList.replace("scale-100", "scale-95");
            setTimeout(() => contactFields.classList.add("hidden"), 500);
        }
    });

    // Fungsi UI - Perpindahan Langkah
    let currentStep = 1;
    const totalSteps = 4;

    const form = document.querySelector("form");

    form.addEventListener("keydown", function (e) {
        console.log("Keydown detected:", e.key, "Current Step:", currentStep);
        if (e.key === "Enter" && currentStep !== totalSteps) {
            e.preventDefault();
            console.log("Enter prevented");
        }
    });

    document.getElementById("nextButton").addEventListener("click", () => {
        if (currentStep < totalSteps) {
            document
                .getElementById(`step${currentStep}`)
                .classList.add("hidden");
            currentStep++;
            document
                .getElementById(`step${currentStep}`)
                .classList.remove("hidden");
        }
        updateSteps();
        updateButtons();

        if (currentStep === totalSteps) {
            updateSummary();
        }
    });

    document.getElementById("prevButton").addEventListener("click", () => {
        if (currentStep > 1) {
            document
                .getElementById(`step${currentStep}`)
                .classList.add("hidden");
            currentStep--;
            document
                .getElementById(`step${currentStep}`)
                .classList.remove("hidden");
        }
        updateSteps();
        updateButtons();
    });

    function updateSteps() {
        for (let i = 1; i <= totalSteps; i++) {
            const stepIndicator = document.getElementById(`step${i}Indicator`);
            if (i < currentStep) stepIndicator.classList.add("step-error");
            else if (i === currentStep)
                stepIndicator.classList.add("step-error");
            else stepIndicator.classList.remove("step-error");
        }
    }

    function updateButtons() {
        document
            .getElementById("prevButton")
            .classList.toggle("hidden", currentStep === 1);
        document
            .getElementById("nextButton")
            .classList.toggle("hidden", currentStep === totalSteps);
        document
            .getElementById("submitButton")
            .classList.toggle("hidden", currentStep !== totalSteps);
    }

    function updateSummary() {
        const get = (id) => document.getElementById(id);

        const summaryNama = get("summaryNama");
        if (summaryNama)
            summaryNama.textContent = get("informant_name")?.value || "-";

        const summaryEmail = get("summaryEmail");
        if (summaryEmail) summaryEmail.textContent = get("email")?.value || "-";

        const summaryTelepon = get("summaryTelepon");
        if (summaryTelepon)
            summaryTelepon.textContent = get("phone")?.value || "-";

        const categorySelect = document.querySelector(
            'select[name="category_id"]'
        );
        const summaryJenis = get("summaryJenis");
        if (summaryJenis)
            summaryJenis.textContent =
                categorySelect?.options[categorySelect.selectedIndex]?.text ||
                "-";

        const reportedNames = Array.from(
            document.querySelectorAll('input[name="reported_name[]"]')
        )
            .map((input) => input.value || "-")
            .join(", ");
        const reportedUnits = Array.from(
            document.querySelectorAll('input[name="reported_unit[]"]')
        )
            .map((input) => input.value || "-")
            .join(", ");

        const summaryTerlapor = get("summaryTerlapor");
        if (summaryTerlapor) summaryTerlapor.textContent = reportedNames || "-";

        const summaryJabatan = get("summaryJabatan");
        if (summaryJabatan) summaryJabatan.textContent = reportedUnits || "-";

        const summaryDeskripsi = get("summaryDeskripsi");
        if (summaryDeskripsi)
            summaryDeskripsi.textContent =
                document.querySelector('textarea[name="violation_desc"]')
                    ?.value || "-";

        const summaryLokasi = get("summaryLokasi");
        if (summaryLokasi)
            summaryLokasi.textContent = get("location")?.value || "-";

        const summaryWaktu = get("summaryWaktu");
        if (summaryWaktu)
            summaryWaktu.textContent = get("datetime")?.value || "-";
    }

    // Prevent Submit Kosong
    document
        .getElementById("submitButton")
        .addEventListener("click", function (e) {
            const namaPelapor = document
                .getElementById("namaPelapor")
                .value.trim();

            if (!namaPelapor) {
                alert("Harap lengkapi semua data yang wajib diisi!");
                e.preventDefault();
            }
        });
});

// Fungsi untuk menambah input terlapor
document.addEventListener("DOMContentLoaded", function () {
    const maxTerlapor = 5; // Batas maksimal terlapor
    const addTerlaporBtn = document.getElementById("addTerlapor");
    const terlaporContainer = document.getElementById("terlaporContainer");

    // Event ketika tombol "+" ditekan
    addTerlaporBtn.addEventListener("click", function () {
        const terlaporItems =
            document.querySelectorAll(".terlapor-item").length;

        // Batas maksimal input terlapor = 5 orang
        if (terlaporItems < maxTerlapor) {
            const newTerlapor = document.createElement("div");
            newTerlapor.classList.add(
                "terlapor-item",
                "flex",
                "space-x-4",
                "mt-4"
            );
            newTerlapor.innerHTML = `
                <!-- Nama Terlapor -->
                <fieldset class="fieldset w-1/2">
                    <input type="text" class="input w-full" name="reported_name[]" placeholder="Nama Terlapor" />
                </fieldset>

                <!-- Unit Jabatan -->
                <fieldset class="fieldset w-1/2">
                    <input type="text" class="input w-full" name="reported_unit[]" placeholder="Jabatan" />
                </fieldset>

                <!-- Tombol "-" untuk hapus -->
                <button type="button" class="btn btn-outline btn-error px-3 py-2 self-center removeTerlapor">
                    -
                </button>
            `;

            // Tambah elemen baru ke dalam container
            terlaporContainer.appendChild(newTerlapor);

            // Aktifkan fungsi hapus pada tombol "-"
            activateRemoveButtons();
        }
    });

    // Fungsi hapus input terlapor
    function activateRemoveButtons() {
        document.querySelectorAll(".removeTerlapor").forEach((button) => {
            button.addEventListener("click", function () {
                this.parentElement.remove();
            });
        });
    }
});
