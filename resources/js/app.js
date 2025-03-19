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
