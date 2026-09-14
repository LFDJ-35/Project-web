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

  const getActive = (list) => Array.from(list).find((el) => el.classList.contains("active"));
  const selectOne = (list, btn) => {
    list.forEach((b) => b.classList.remove("active"));
    btn.classList.add("active");
  };
  const getQty = () => {
    const n = qtyInput ? parseInt(qtyInput.value, 10) : 1;
    return n > 0 ? n : 1;
  };

  const getActiveColorRow = () => {
    const product = getActive(productTabs)?.dataset.product || "ROUSSEAU";
    return wrap.querySelector('.lfdj-color-row[data-product-colors="' + product + '"]');
  };

  const render = () => {
    const product = getActive(productTabs)?.dataset.product || "ROUSSEAU";

    colorRows.forEach((row) => {
      row.classList.toggle("lfdj-hidden", row.dataset.productColors !== product);
    });

    const colorRow = getActiveColorRow();
    const color = colorRow ? getActive(colorRow.querySelectorAll(".lfdj-color-swatch")) : null;
    const design = getActive(designThumbs);

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
    const product = getActive(productTabs)?.dataset.product || "ROUSSEAU";
    const colorRow = getActiveColorRow();
    const color = colorRow ? getActive(colorRow.querySelectorAll(".lfdj-color-swatch")) : null;
    const design = getActive(designThumbs);
    const size = getActive(sizePills);
    if (!color || !design || !size) return;
    refCode.textContent = [
      "SWE",
      productCodes[product],
      design.dataset.code,
      color.dataset.code,
      size.dataset.code,
      "Q" + getQty(),
    ].join("-");
  };

  productTabs.forEach((btn) => {
    btn.addEventListener("click", () => {
      selectOne(productTabs, btn);
      const colorRow = getActiveColorRow();
      if (colorRow) {
        const swatches = colorRow.querySelectorAll(".lfdj-color-swatch");
        if (swatches.length && !getActive(swatches)) {
          selectOne(swatches, swatches[0]);
        }
      }
      render();
    });
  });

  designThumbs.forEach((btn) => {
    btn.addEventListener("click", () => {
      selectOne(designThumbs, btn);
      render();
    });
  });

  colorRows.forEach((row) => {
    row.querySelectorAll(".lfdj-color-swatch").forEach((btn) => {
      btn.addEventListener("click", () => {
        selectOne(row.querySelectorAll(".lfdj-color-swatch"), btn);
        render();
      });
    });
  });

  sizePills.forEach((btn) => {
    btn.addEventListener("click", () => {
      selectOne(sizePills, btn);
      updateReference();
    });
  });

  if (qtyInput) {
    qtyInput.addEventListener("input", updateReference);

    const qtyStepper = qtyInput.closest(".lfdj-qty-stepper");
    if (qtyStepper) {
      qtyStepper.querySelectorAll(".lfdj-qty-btn").forEach((btn) => {
        btn.addEventListener("click", () => {
          const current = parseInt(qtyInput.value, 10) || 1;
          const next = btn.dataset.action === "increment" ? current + 1 : Math.max(1, current - 1);
          qtyInput.value = next;
          updateReference();
        });
      });
    }
  }

  if (copyBtn && refCode) {
    copyBtn.addEventListener("click", async () => {
      const text = refCode.textContent;
      try {
        await navigator.clipboard.writeText(text);
      } catch (e) {
        const helper = document.createElement("textarea");
        helper.value = text;
        document.body.appendChild(helper);
        helper.select();
        document.execCommand("copy");
        document.body.removeChild(helper);
      }
      const original = copyBtn.textContent;
      copyBtn.textContent = "Copié !";
      copyBtn.disabled = true;
      setTimeout(() => {
        copyBtn.textContent = original;
        copyBtn.disabled = false;
      }, 1500);
    });
  }

  render();
});
