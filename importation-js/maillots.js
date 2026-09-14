document.addEventListener("DOMContentLoaded", () => {
  const basePath = "./images/Textile/MAILLOTS-LFDJ/";
  const NAME_MAX_WIDTH = 90;

  const baseImg = document.getElementById("lfdj-jersey-base");
  const designImg = document.getElementById("lfdj-jersey-design");
  const nameEl = document.getElementById("lfdj-jersey-name");
  const numberEl = document.getElementById("lfdj-jersey-number");
  const nameInput = document.getElementById("lfdj-input-name");
  const numberInput = document.getElementById("lfdj-input-number");
  const qtyInput = document.getElementById("lfdj-input-qty");
  const refCode = document.getElementById("lfdj-jersey-ref-code");
  const copyBtn = document.getElementById("lfdj-jersey-ref-copy");

  if (!baseImg) return;

  const jerseyWrap = baseImg.closest(".lfdj-boutique-wrap");
  const jerseyDesigns = jerseyWrap.querySelectorAll(".lfdj-design-thumb");
  const jerseyColors = jerseyWrap.querySelectorAll(".lfdj-color-swatch");
  const jerseySizes = jerseyWrap.querySelectorAll(".lfdj-size-row .lfdj-size-pill");
  const jerseyTabs = jerseyWrap.querySelectorAll(".lfdj-jersey-tabs .lfdj-size-pill");

  const numberColors = { B: "#c8a44d", Y: "#8e533a" };

  const sanitizeName = (value) => (value || "").trim().toUpperCase().replace(/[^A-Z0-9]/g, "") || "NOM";
  const sanitizeNumber = (value) => (value || "").trim().toUpperCase().slice(0, 4) || "00";

  const fitName = () => {
    if (!nameEl) return;
    nameEl.style.transform = "translate(-50%, -50%) scale(1)";
    const natural = nameEl.scrollWidth;
    const scale = natural > NAME_MAX_WIDTH ? NAME_MAX_WIDTH / natural : 1;
    nameEl.style.transform = "translate(-50%, -50%) scale(" + scale + ")";
  };

  const render = () => {
    const view = lfdjGetActive(jerseyTabs)?.dataset.view || "BACK";
    const color = lfdjGetActive(jerseyColors)?.dataset.color || "B";
    const design = lfdjGetActive(jerseyDesigns);
    const hasDesign = design && design.dataset.file;

    baseImg.src = basePath + "MAILLOT_" + view + "_" + color + ".webp";
    baseImg.alt = "Maillot " + (view === "BACK" ? "dos" : "face") + ", coloris " + (color === "B" ? "noir" : "jaune");

    const isBack = view === "BACK";
    designImg.classList.toggle("lfdj-hidden", !isBack || !hasDesign);
    nameEl.classList.toggle("lfdj-hidden", !isBack);
    numberEl.classList.toggle("lfdj-hidden", !isBack);

    if (isBack && hasDesign) {
      designImg.src = basePath + design.dataset.file;
      designImg.alt = "Design " + (design.getAttribute("aria-label") || "").replace("Design ", "");
    }

    numberEl.style.color = numberColors[color];

    fitName();
    updateReference();
  };

  const updateReference = () => {
    if (!refCode) return;
    const design = lfdjGetActive(jerseyDesigns);
    const color = lfdjGetActive(jerseyColors);
    const size = lfdjGetActive(jerseySizes);
    if (!design || !color || !size) return;
    const name = sanitizeName(nameInput ? nameInput.value : "");
    const number = sanitizeNumber(numberInput ? numberInput.value : "");
    refCode.textContent = [
      "MAI",
      design.dataset.code,
      color.dataset.code,
      size.dataset.code,
      name,
      number,
      "Q" + lfdjGetQty(qtyInput),
    ].join("-");
  };

  jerseyTabs.forEach((btn) => {
    btn.addEventListener("click", () => {
      lfdjSelectOne(jerseyTabs, btn);
      render();
    });
  });

  jerseyDesigns.forEach((btn) => {
    btn.addEventListener("click", () => {
      lfdjSelectOne(jerseyDesigns, btn);
      render();
    });
  });

  jerseyColors.forEach((btn) => {
    btn.addEventListener("click", () => {
      lfdjSelectOne(jerseyColors, btn);
      render();
    });
  });

  jerseySizes.forEach((btn) => {
    btn.addEventListener("click", () => {
      lfdjSelectOne(jerseySizes, btn);
      updateReference();
    });
  });

  if (nameInput && nameEl) {
    nameInput.addEventListener("input", () => {
      nameEl.textContent = nameInput.value.trim() || "VOTRE NOM";
      fitName();
      updateReference();
    });
  }

  if (numberInput && numberEl) {
    numberInput.addEventListener("input", () => {
      numberEl.textContent = numberInput.value.trim() || "00";
      updateReference();
    });
  }

  lfdjInitQtyStepper(qtyInput, updateReference);
  window.addEventListener("resize", fitName);
  lfdjInitCopyButton(copyBtn, refCode);

  render();
});
