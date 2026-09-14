document.addEventListener("DOMContentLoaded", () => {
  const designPath = "./images/Textile/COLLECTION-PINGU/TSHIRT/";
  const colorPath = "./images/Textile/COLLECTION-PINGU/TSHIRT/";

  const designImg = document.getElementById("lfdj-tshirt-design");
  const baseImg = document.getElementById("lfdj-tshirt-base");
  const refCode = document.getElementById("lfdj-ref-code");
  const copyBtn = document.getElementById("lfdj-ref-copy");

  if (!baseImg) return;

  const wrap = baseImg.closest(".lfdj-boutique-wrap");
  const designThumbs = wrap.querySelectorAll(".lfdj-design-thumb");
  const colorSwatches = wrap.querySelectorAll(".lfdj-color-swatch");
  const sizePills = wrap.querySelectorAll(".lfdj-size-pill");
  const qtyInput = document.getElementById("lfdj-input-tshirt-qty");

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
      designImg.src = designPath + btn.dataset.file;
      designImg.alt = "Design " + (btn.getAttribute("aria-label") || "").replace("Design ", "");
      updateReference();
    });
  });

  colorSwatches.forEach((btn) => {
    btn.addEventListener("click", () => {
      lfdjSelectOne(colorSwatches, btn);
      baseImg.src = colorPath + btn.dataset.file;
      baseImg.alt = "T-shirt dos, coloris " + (btn.getAttribute("aria-label") || "").toLowerCase();
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

  updateReference();
});
