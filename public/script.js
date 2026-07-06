const detailAddButton = document.querySelector(".add-button-detail");
const siteHeader = document.querySelector(".site-header");
const scentSlider = document.querySelector("[data-scent-slider]");
const sliderPrev = document.querySelector("[data-slider-prev]");
const sliderNext = document.querySelector("[data-slider-next]");

const updateHeader = () => {
  if (document.body.classList.contains("inner-page")) return;
  siteHeader?.classList.toggle("is-scrolled", window.scrollY > 24);
};

updateHeader();
window.addEventListener("scroll", updateHeader, { passive: true });

detailAddButton?.addEventListener("click", () => {
  const label = detailAddButton.querySelector("span");
  if (label) label.textContent = "Request information";
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
