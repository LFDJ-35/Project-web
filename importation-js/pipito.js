document.addEventListener("DOMContentLoaded", () => {
  const basePath = "./images/Textile/COLLECTION-PIPITO/";

  const baseImg = document.getElementById("lfdj-pipito-base");
  const refCode = document.getElementById("lfdj-pipito-ref-code");
  const copyBtn = document.getElementById("lfdj-pipito-ref-copy");
  const qtyInput = document.getElementById("lfdj-input-pipito-qty");

  if (!baseImg) return;

  const wrap = baseImg.closest(".lfdj-boutique-wrap");
  const designThumbs = wrap.querySelectorAll(".lfdj-design-thumb");
  const sizePills = wrap.querySelectorAll(".lfdj-size-row .lfdj-size-pill");

  const updateReference = () => {
    if (!refCode) return;
    const design = lfdjGetActive(designThumbs);
    const size = lfdjGetActive(sizePills);
    if (!design || !size) return;
    refCode.textContent = ["PIP", design.dataset.code, "NOI", size.dataset.code, "Q" + lfdjGetQty(qtyInput)].join("-");
  };

  designThumbs.forEach((btn) => {
    btn.addEventListener("click", () => {
      lfdjSelectOne(designThumbs, btn);
      baseImg.src = basePath + btn.dataset.file;
      baseImg.alt = "T-shirt La Forge des Joueurs, design " + (btn.getAttribute("aria-label") || "");
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

  const initialDesign = lfdjGetActive(designThumbs);
  if (initialDesign) {
    baseImg.src = basePath + initialDesign.dataset.file;
  }

  updateReference();
});
