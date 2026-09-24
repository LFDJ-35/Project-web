document.addEventListener("DOMContentLoaded", () => {
  const designPath = "./images/Textile/COLLECTION-PIPITO/";
  const shirtPath = "./images/Textile/DESCARTES/";

  const baseImg = document.getElementById("lfdj-pipito-base");
  const designImg = document.getElementById("lfdj-pipito-design");
  const refCode = document.getElementById("lfdj-pipito-ref-code");
  const copyBtn = document.getElementById("lfdj-pipito-ref-copy");
  const qtyInput = document.getElementById("lfdj-input-pipito-qty");

  if (!baseImg) return;

  const wrap = baseImg.closest(".lfdj-boutique-wrap");
  const designThumbs = wrap.querySelectorAll(".lfdj-design-thumb");
  const colorSwatches = wrap.querySelectorAll(".lfdj-color-swatch");
  const sizePills = wrap.querySelectorAll(".lfdj-size-row .lfdj-size-pill");
  const viewTabs = wrap.querySelectorAll(".lfdj-jersey-tabs .lfdj-size-pill");

  // Le design est imprimé devant : visible en vue Face, masqué en vue Dos
  // (pas de logo au dos pour cette collection, juste le t-shirt uni).
  const render = () => {
    const view = lfdjGetActive(viewTabs)?.dataset.view || "FACE";
    const color = lfdjGetActive(colorSwatches);
    if (!color) return;

    baseImg.src = shirtPath + "TSHIRT-" + view + "-" + color.dataset.color + ".webp";
    baseImg.alt = "T-shirt " + view.toLowerCase() + ", coloris " + (color.getAttribute("aria-label") || "").toLowerCase();

    const isFace = view === "FACE";
    designImg.classList.toggle("lfdj-hidden", !isFace);

    const design = lfdjGetActive(designThumbs);
    if (design && isFace) {
      designImg.src = designPath + design.dataset.file;
      designImg.alt = "Design " + (design.getAttribute("aria-label") || "").replace("Design ", "");
    }

    updateReference();
  };

  const updateReference = () => {
    if (!refCode) return;
    const design = lfdjGetActive(designThumbs);
    const color = lfdjGetActive(colorSwatches);
    const size = lfdjGetActive(sizePills);
    if (!design || !color || !size) return;
    refCode.textContent = ["PIP", design.dataset.code, color.dataset.code, size.dataset.code, "Q" + lfdjGetQty(qtyInput)].join("-");
  };

  designThumbs.forEach((btn) => {
    btn.addEventListener("click", () => {
      lfdjSelectOne(designThumbs, btn);
      render();
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
