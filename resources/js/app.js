import "./bootstrap";
import AOS from "aos";
import "aos/dist/aos.css";

AOS.init();

// Fungsi auto scroll one page
document.querySelectorAll("#faq-accordion details").forEach((detail) => {
    detail.addEventListener("click", function () {
        document.querySelectorAll("#faq-accordion details").forEach((item) => {
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

// Fungsi opsi penggunaan email dan nomor telepon
const toggle = document.getElementById("toggleContact");
const contactFields = document.getElementById("contactFields");
const infoFields = document.getElementById("infoFields");

toggle.addEventListener("change", () => {
    if (toggle.checked) {
        // Tampilkan form email & telepon
        contactFields.classList.remove("hidden", "opacity-0", "scale-95");
        contactFields.classList.add("opacity-100", "scale-100");

        // Sembunyikan info pengganti
        infoFields.classList.replace("opacity-100", "opacity-0");
        infoFields.classList.replace("scale-100", "scale-95");
        setTimeout(() => infoFields.classList.add("hidden"), 500);
    } else {
        // Tampilkan info pengganti
        infoFields.classList.remove("hidden", "opacity-0", "scale-95");
        infoFields.classList.add("opacity-100", "scale-100");

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
    if (e.key === "Enter" && currentStep !== totalSteps) {
        e.preventDefault();
    }
});

document.getElementById("nextButton").addEventListener("click", () => {
    if (currentStep < totalSteps) {
        document.getElementById(`step${currentStep}`).classList.add("hidden");
        currentStep++;
        document
            .getElementById(`step${currentStep}`)
            .classList.remove("hidden");
    }
    updateSteps();
    updateButtons();
});

document.getElementById("prevButton").addEventListener("click", () => {
    if (currentStep > 1) {
        document.getElementById(`step${currentStep}`).classList.add("hidden");
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
        else if (i === currentStep) stepIndicator.classList.add("step-error");
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


// Fungsi Validasi Form
document.getElementById("emailPelapor").addEventListener("input", function () {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const emailError = document.getElementById("emailError");
    emailError.textContent = emailPattern.test(this.value)
        ? ""
        : "Format email tidak valid";
});

document
    .getElementById("teleponPelapor")
    .addEventListener("input", function () {
        const phonePattern = /^\d{10,13}$/;
        const teleponError = document.getElementById("teleponError");
        teleponError.textContent = phonePattern.test(this.value)
            ? ""
            : "Nomor telepon harus berisi 10-13 digit angka";
    });

// Validasi Nama Pelapor
document.getElementById("namaPelapor").addEventListener("input", function () {
    const namaError = document.getElementById("namaError");
    const namaValue = this.value.trim();
    namaError.textContent =
        namaValue && /^[a-zA-Z\s]+$/.test(namaValue)
            ? ""
            : "Nama hanya boleh berisi huruf dan spasi";
});

// Prevent Submit Kosong
document.getElementById("submitButton").addEventListener("click", function (e) {
    const namaPelapor = document.getElementById("namaPelapor").value.trim();
    const emailPelapor = document.getElementById("emailPelapor").value.trim();
    const teleponPelapor = document
        .getElementById("teleponPelapor")
        .value.trim();

    if (!namaPelapor || !emailPelapor || !teleponPelapor) {
        alert("Harap lengkapi semua data yang wajib diisi!");
        e.preventDefault();
    }
});
