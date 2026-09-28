document.addEventListener("DOMContentLoaded", () => {
  const basePath = "./images/Textile/COLLECTION-GENERIQUE/";
  // Le t-shirt vierge (face/dos) est partagé avec les collections Pingu et
  // Pipito : un seul jeu de fichiers, pas de copie par collection.
  const shirtPath = "./images/Textile/DESCARTES/";

  const baseImg = document.getElementById("lfdj-generique-base");
  const logoImg = document.getElementById("lfdj-generique-logo");
  const refCode = document.getElementById("lfdj-generique-ref-code");
  const copyBtn = document.getElementById("lfdj-generique-ref-copy");
  const qtyInput = document.getElementById("lfdj-input-generique-qty");

  if (!baseImg) return;

  const wrap = baseImg.closest(".lfdj-boutique-wrap");
  const colorSwatches = wrap.querySelectorAll(".lfdj-color-swatch");
  const sizePills = wrap.querySelectorAll(".lfdj-size-row .lfdj-size-pill");
  const viewTabs = wrap.querySelectorAll(".lfdj-jersey-tabs .lfdj-size-pill");

  const render = () => {
    const view = lfdjGetActive(viewTabs)?.dataset.view || "FACE";
    const color = lfdjGetActive(colorSwatches);
    if (!color) return;

    baseImg.src = shirtPath + "TSHIRT-" + view + "-" + color.dataset.color + ".webp";
    baseImg.alt = "T-shirt générique, coloris " + (color.getAttribute("aria-label") || "").toLowerCase() + ", " + view.toLowerCase();

    // Le Noir a besoin d'une encre claire (contraste) pour rester lisible,
    // Blanc et Jaune partagent la même encre foncée.
    const isNoir = color.dataset.color === "NOIR";
    if (view === "DOS") {
      logoImg.src = basePath + (isNoir ? "LOGO-GENERIQUE-DOS-NOIR.webp" : "LOGO-GENERIQUE-DOS.webp");
      logoImg.alt = "Logo, dos";
    } else {
      logoImg.src = basePath + (isNoir ? "LOGO-GENERIQUE-FACE-NOIR.webp" : "LOGO-GENERIQUE-FACE-BLANC.webp");
      logoImg.alt = "Logo, face";
    }

    updateReference();
  };

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
