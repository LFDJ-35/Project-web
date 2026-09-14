document.addEventListener("DOMContentLoaded", () => {
  const basePath = "./images/Textile/COLLECTION-PINGU/SWEAT/";

  const baseImg = document.getElementById("lfdj-sweat-base");
  const designImg = document.getElementById("lfdj-sweat-design");
  const refCode = document.getElementById("lfdj-sweat-ref-code");
  const copyBtn = document.getElementById("lfdj-sweat-ref-copy");
  const qtyInput = document.getElementById("lfdj-input-sweat-qty");
  const priceTag = document.getElementById("lfdj-sweat-price");

  if (!baseImg) return;

  const wrap = baseImg.closest(".lfdj-boutique-wrap");
  const productTabs = wrap.querySelectorAll(".lfdj-jersey-tabs .lfdj-size-pill");
  const designThumbs = wrap.querySelectorAll(".lfdj-design-thumb");
  const colorRows = wrap.querySelectorAll(".lfdj-color-row");
  const sizePills = wrap.querySelectorAll(".lfdj-size-row .lfdj-size-pill");

  const productCodes = { ROUSSEAU: "ROUS", MONTAIGNE: "MONT" };
  const productPrices = { ROUSSEAU: "60", MONTAIGNE: "74" };

  const getActiveColorRow = () => {
    const product = lfdjGetActive(productTabs)?.dataset.product || "ROUSSEAU";
    return wrap.querySelector('.lfdj-color-row[data-product-colors="' + product + '"]');
  };

  const render = () => {
    const product = lfdjGetActive(productTabs)?.dataset.product || "ROUSSEAU";

    colorRows.forEach((row) => {
      row.classList.toggle("lfdj-hidden", row.dataset.productColors !== product);
    });

    const colorRow = getActiveColorRow();
    const color = colorRow ? lfdjGetActive(colorRow.querySelectorAll(".lfdj-color-swatch")) : null;
    const design = lfdjGetActive(designThumbs);

    if (color) {
      baseImg.src = basePath + "SWEAT-" + product + "-" + color.dataset.file + ".webp";
      baseImg.alt = "Sweat " + (product === "ROUSSEAU" ? "Rousseau" : "Montaigne") + ", coloris " + (color.getAttribute("aria-label") || "").toLowerCase();
    }

    if (design) {
      designImg.src = basePath + design.dataset.file;
      designImg.alt = "Design " + (design.getAttribute("aria-label") || "").replace("Design ", "");
    }

    if (priceTag) {
      priceTag.textContent = productPrices[product] + " € la pièce";
    }

    updateReference();
  };

  const updateReference = () => {
    if (!refCode) return;
    const product = lfdjGetActive(productTabs)?.dataset.product || "ROUSSEAU";
    const colorRow = getActiveColorRow();
    const color = colorRow ? lfdjGetActive(colorRow.querySelectorAll(".lfdj-color-swatch")) : null;
    const design = lfdjGetActive(designThumbs);
    const size = lfdjGetActive(sizePills);
    if (!color || !design || !size) return;
    refCode.textContent = [
      "SWE",
      productCodes[product],
      design.dataset.code,
      color.dataset.code,
      size.dataset.code,
      "Q" + lfdjGetQty(qtyInput),
    ].join("-");
  };

  productTabs.forEach((btn) => {
    btn.addEventListener("click", () => {
      lfdjSelectOne(productTabs, btn);
      const colorRow = getActiveColorRow();
      if (colorRow) {
        const swatches = colorRow.querySelectorAll(".lfdj-color-swatch");
        if (swatches.length && !lfdjGetActive(swatches)) {
          lfdjSelectOne(swatches, swatches[0]);
        }
      }
      render();
    });
  });

  designThumbs.forEach((btn) => {
    btn.addEventListener("click", () => {
      lfdjSelectOne(designThumbs, btn);
      render();
    });
  });

  colorRows.forEach((row) => {
    row.querySelectorAll(".lfdj-color-swatch").forEach((btn) => {
      btn.addEventListener("click", () => {
        lfdjSelectOne(row.querySelectorAll(".lfdj-color-swatch"), btn);
        render();
      });
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
