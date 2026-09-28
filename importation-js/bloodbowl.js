document.addEventListener("DOMContentLoaded", () => {
  const tabButtons = document.querySelectorAll(".lfdj-bb-season-tab-btn");
  const panels = document.querySelectorAll(".lfdj-bb-season-panel");

  tabButtons.forEach((btn) => {
    btn.addEventListener("click", () => {
      const target = btn.dataset.tab;
      tabButtons.forEach((b) => b.classList.toggle("is-active", b === btn));
      panels.forEach((panel) => {
        panel.hidden = panel.dataset.panel !== target;
      });
    });
  });

  document.querySelectorAll(".lfdj-bb-results-toggle-btn").forEach((btn) => {
    btn.addEventListener("click", () => {
      const content = document.getElementById(btn.getAttribute("aria-controls"));
      const isOpen = btn.getAttribute("aria-expanded") === "true";
      btn.setAttribute("aria-expanded", String(!isOpen));
      content.hidden = isOpen;
    });
  });

  // ====== Galerie photo : lightbox avec navigation entre les 6 images ======
  const galleryLinks = [...document.querySelectorAll("#lfdj-bb-photo-grid a")];
  const lightbox = document.getElementById("lfdj-bb-lightbox");

  if (galleryLinks.length && lightbox) {
    const lightboxImg = lightbox.querySelector(".lfdj-bb-lightbox-img");
    const caption = lightbox.querySelector(".lfdj-bb-lightbox-caption");
    let currentIndex = 0;

    const show = (index) => {
      currentIndex = (index + galleryLinks.length) % galleryLinks.length;
      const link = galleryLinks[currentIndex];
      const img = link.querySelector("img");
      lightboxImg.src = link.getAttribute("href");
      lightboxImg.alt = img.alt;
      caption.textContent = img.alt;
    };

    const openLightbox = (index) => {
      show(index);
      lightbox.hidden = false;
      document.body.style.overflow = "hidden";
    };

    const closeLightbox = () => {
      lightbox.hidden = true;
      document.body.style.overflow = "";
    };

    galleryLinks.forEach((link, index) => {
      link.addEventListener("click", (e) => {
        e.preventDefault();
        openLightbox(index);
      });
    });

    lightbox.querySelector(".lfdj-bb-lightbox-close").addEventListener("click", closeLightbox);
    lightbox.querySelector(".lfdj-bb-lightbox-prev").addEventListener("click", () => show(currentIndex - 1));
    lightbox.querySelector(".lfdj-bb-lightbox-next").addEventListener("click", () => show(currentIndex + 1));

    lightbox.addEventListener("click", (e) => {
      if (e.target === lightbox) closeLightbox();
    });

    document.addEventListener("keydown", (e) => {
      if (lightbox.hidden) return;
      if (e.key === "Escape") closeLightbox();
      if (e.key === "ArrowLeft") show(currentIndex - 1);
      if (e.key === "ArrowRight") show(currentIndex + 1);
    });
  }
});
