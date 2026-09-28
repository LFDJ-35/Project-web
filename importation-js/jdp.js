document.addEventListener("DOMContentLoaded", () => {
  // ====== Galerie photo : lightbox avec navigation entre les images ======
  const galleryLinks = [...document.querySelectorAll("#lfdj-jdp-photo-grid a")];
  const lightbox = document.getElementById("lfdj-jdp-lightbox");

  if (galleryLinks.length && lightbox) {
    const lightboxImg = lightbox.querySelector(".lfdj-jdp-lightbox-img");
    const caption = lightbox.querySelector(".lfdj-jdp-lightbox-caption");
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

    lightbox.querySelector(".lfdj-jdp-lightbox-close").addEventListener("click", closeLightbox);
    lightbox.querySelector(".lfdj-jdp-lightbox-prev").addEventListener("click", () => show(currentIndex - 1));
    lightbox.querySelector(".lfdj-jdp-lightbox-next").addEventListener("click", () => show(currentIndex + 1));

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
