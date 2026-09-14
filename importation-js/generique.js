document.addEventListener("DOMContentLoaded", () => {
  const basePath = "./images/Textile/COLLECTION-GENERIQUE/";

  const baseImg = document.getElementById("lfdj-generique-base");
  const refCode = document.getElementById("lfdj-generique-ref-code");
  const copyBtn = document.getElementById("lfdj-generique-ref-copy");
  const qtyInput = document.getElementById("lfdj-input-generique-qty");

  if (!baseImg) return;

  const wrap = baseImg.closest(".lfdj-boutique-wrap");
  const colorSwatches = wrap.querySelectorAll(".lfdj-color-swatch");
  const sizePills = wrap.querySelectorAll(".lfdj-size-row .lfdj-size-pill");

  const updateReference = () => {
    if (!refCode) return;
    const color = lfdjGetActive(colorSwatches);
    const size = lfdjGetActive(sizePills);
    if (!color || !size) return;
    refCode.textContent = ["GEN", "XX", color.dataset.code, size.dataset.code, "Q" + lfdjGetQty(qtyInput)].join("-");
  };

  colorSwatches.forEach((btn) => {
    btn.addEventListener("click", () => {
      lfdjSelectOne(colorSwatches, btn);
      baseImg.src = basePath + btn.dataset.file;
      baseImg.alt = "T-shirt générique, coloris " + (btn.getAttribute("aria-label") || "").toLowerCase() + ", face et dos";
      updateReference();
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

  const initialColor = lfdjGetActive(colorSwatches);
  if (initialColor) {
    baseImg.src = basePath + initialColor.dataset.file;
  }

  updateReference();
});
