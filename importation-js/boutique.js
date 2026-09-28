document.addEventListener("DOMContentLoaded", () => {
  const basePath = "./images/Textile/COLLECTION-PINGU/TSHIRT/";
  // Les t-shirts vierges (face/dos) sont partagés entre les collections
  // Pingu, Pipito et Générique : un seul jeu de fichiers, pas de copie
  // par collection.
  const shirtPath = "./images/Textile/DESCARTES/";

  const designImg = document.getElementById("lfdj-tshirt-design");
  const baseImg = document.getElementById("lfdj-tshirt-base");
  const logoImg = document.getElementById("lfdj-tshirt-logo");
  const refCode = document.getElementById("lfdj-ref-code");
  const copyBtn = document.getElementById("lfdj-ref-copy");

  if (!baseImg) return;

  const wrap = baseImg.closest(".lfdj-boutique-wrap");
  const designThumbs = wrap.querySelectorAll(".lfdj-design-thumb");
  const colorSwatches = wrap.querySelectorAll(".lfdj-color-swatch");
  const sizePills = wrap.querySelectorAll(".lfdj-size-row .lfdj-size-pill");
  const viewTabs = wrap.querySelectorAll(".lfdj-jersey-tabs .lfdj-size-pill");
  const qtyInput = document.getElementById("lfdj-input-tshirt-qty");

  // Le design (dos) et le logo cœur (face) sont mutuellement exclusifs
  // selon la vue active ; seul le logo dépend aussi du coloris (encre
  // claire nécessaire sur le Noir pour rester lisible).
  const render = () => {
    const view = lfdjGetActive(viewTabs)?.dataset.view || "DOS";
    const color = lfdjGetActive(colorSwatches);
    if (!color) return;

    baseImg.src = shirtPath + "TSHIRT-" + view + "-" + color.dataset.color + ".webp";
    baseImg.alt = "T-shirt " + view.toLowerCase() + ", coloris " + (color.getAttribute("aria-label") || "").toLowerCase();

    const isDos = view === "DOS";
    designImg.classList.toggle("lfdj-hidden", !isDos);
    logoImg.classList.toggle("lfdj-hidden", isDos);

    if (!isDos) {
      const isLightColor = ["BLANC", "CIEL", "ROSEPALE"].includes(color.dataset.color);
      logoImg.src = basePath + (isLightColor ? "LOGO-PINGU-FACE-BLANC.webp" : "LOGO-PINGU-FACE-NOIR.webp");
    }

    updateReference();
  };

  const updateReference = () => {
    const design = lfdjGetActive(designThumbs);
    const color = lfdjGetActive(colorSwatches);
    const size = lfdjGetActive(sizePills);
    if (!design || !color || !size || !refCode) return;
    refCode.textContent = ["EST", design.dataset.code, color.dataset.code, size.dataset.code, "Q" + lfdjGetQty(qtyInput)].join("-");
  };

  designThumbs.forEach((btn) => {
    btn.addEventListener("click", () => {
      lfdjSelectOne(designThumbs, btn);
      designImg.src = basePath + btn.dataset.file;
      designImg.alt = "Design " + (btn.getAttribute("aria-label") || "").replace("Design ", "");
      updateReference();
    });
  });

  colorSwatches.forEach((btn) => {
    btn.addEventListener("click", () => {
      lfdjSelectOne(colorSwatches, btn);
      render();
    });
  });

  viewTabs.forEach((btn) => {
    btn.addEventListener("click", () => {
      lfdjSelectOne(viewTabs, btn);
      render();
    });
  });

  sizePills.forEach((btn) => {
    btn.addEventListener("click", () => {
      lfdjSelectOne(sizePills, btn);
      updateReference();
    });
  });

  lfdjInitQtyStepper(qtyInput, updateReference);
  lfdjInitCopyButton(copyBtn, refCode);

  render();
});
