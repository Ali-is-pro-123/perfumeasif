const bagCount = document.querySelector(".bag-count");
const addButtons = document.querySelectorAll(".add-button");
const detailAddButton = document.querySelector(".add-button-detail");
const siteHeader = document.querySelector(".site-header");
const contactForm = document.querySelector(".contact-form");
const signupForms = document.querySelectorAll(".footer-form");
const scentSlider = document.querySelector("[data-scent-slider]");
const sliderPrev = document.querySelector("[data-slider-prev]");
const sliderNext = document.querySelector("[data-slider-next]");

let bagItems = 0;

const updateHeader = () => {
  if (document.body.classList.contains("inner-page")) return;
  siteHeader?.classList.toggle("is-scrolled", window.scrollY > 24);
};

const addToBag = (label, button) => {
  bagItems += 1;
  if (bagCount) bagCount.textContent = bagItems;
  if (button) {
    button.title = "Added";
    button.animate(
      [
        { transform: "scale(1)" },
        { transform: "scale(0.92)" },
        { transform: "scale(1)" },
      ],
      { duration: 220, easing: "ease-out" }
    );
  }
  if (label && button) button.setAttribute("aria-label", `${label} added to bag`);
};

updateHeader();
window.addEventListener("scroll", updateHeader, { passive: true });

addButtons.forEach((button) => {
  button.addEventListener("click", () => {
    const card = button.closest(".product-card");
    addToBag(card?.dataset.product || "Product", button);
  });
});

detailAddButton?.addEventListener("click", () => {
  const detail = detailAddButton.closest(".product-detail");
  addToBag(detail?.dataset.product || "Product", detailAddButton);
  const label = detailAddButton.querySelector("span");
  if (label) label.textContent = "Added to bag";
});

contactForm?.addEventListener("submit", (event) => {
  event.preventDefault();
  const status = contactForm.querySelector(".form-status");
  if (status) status.textContent = "Message received. We will reply within one business day.";
  contactForm.reset();
});

signupForms.forEach((form) => {
  form.addEventListener("submit", (event) => {
    event.preventDefault();
    const status = form.querySelector(".form-status");
    if (status) status.textContent = "You're on the private list.";
    form.reset();
  });
});

const scrollScentSlider = (direction) => {
  if (!scentSlider) return;
  const firstCard = scentSlider.querySelector(".slider-card");
  const gap = 18;
  const distance = firstCard ? firstCard.getBoundingClientRect().width + gap : scentSlider.clientWidth;
  scentSlider.scrollBy({ left: distance * direction, behavior: "smooth" });
};

sliderPrev?.addEventListener("click", () => scrollScentSlider(-1));
sliderNext?.addEventListener("click", () => scrollScentSlider(1));
