import "./bootstrap";
import AOS from "aos";
import "aos/dist/aos.css";

AOS.init();

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

    let currentStep = 1;
    const totalSteps = 4;

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