/**
 * Initialise un configurateur de sweat autonome (Rousseau ou Montaigne).
 * Les deux modèles sont maintenant deux sections indépendantes plutôt que
 * partagées dans un seul bloc avec bascule produit.
 * @param {object} opts
 * @param {string} opts.idPrefix Préfixe des ids (ex. "lfdj-sweat-rousseau")
 * @param {string} opts.garmentPath Dossier des photos du sweat vierge
 * @param {string} opts.refModel Code modèle pour la référence (ex. "ROUS")
 * @param {string} opts.qtyId Id de l'input quantité
 * @param {object} opts.lightColors Coloris jugés assez clairs pour le logo à encre noire
 */
function lfdjInitSweat(opts) {
  const designPath = "./images/Textile/COLLECTION-PINGU/SWEAT/";

  const baseImg = document.getElementById(opts.idPrefix + "-base");
  if (!baseImg) return;

  const designImg = document.getElementById(opts.idPrefix + "-design");
  const logoImg = document.getElementById(opts.idPrefix + "-logo");
  const refCode = document.getElementById(opts.idPrefix + "-ref-code");
  const copyBtn = document.getElementById(opts.idPrefix + "-ref-copy");
  const qtyInput = document.getElementById(opts.qtyId);

  const wrap = baseImg.closest(".lfdj-boutique-wrap");
  const viewTabs = wrap.querySelectorAll(".lfdj-sweat-view-tabs .lfdj-size-pill");
  const designThumbs = wrap.querySelectorAll(".lfdj-design-thumb");
  const colorSwatches = wrap.querySelectorAll(".lfdj-color-swatch");
  const sizePills = wrap.querySelectorAll(".lfdj-size-row .lfdj-size-pill");

  const render = () => {
    const color = lfdjGetActive(colorSwatches);
    const design = lfdjGetActive(designThumbs);
    const view = lfdjGetActive(viewTabs)?.dataset.view || "DOS";
    const isDos = view === "DOS";

    if (color) {
      baseImg.src = opts.garmentPath + "SWEAT-" + view + "-" + color.dataset.color + ".webp";
      baseImg.alt = "Sweat, coloris " + (color.getAttribute("aria-label") || "").toLowerCase() + ", " + view.toLowerCase();
    }

    designImg.classList.toggle("lfdj-hidden", !isDos);
    logoImg.classList.toggle("lfdj-hidden", isDos);

    if (design && isDos) {
      designImg.src = designPath + design.dataset.file;
      designImg.alt = "Design " + (design.getAttribute("aria-label") || "").replace("Design ", "");
    }

    if (!isDos && color) {
      const isLight = opts.lightColors[color.dataset.color] === true;
      logoImg.src = designPath + (isLight ? "LOGO-PINGU-FACE-BLANC.webp" : "LOGO-PINGU-FACE-NOIR.webp");
    }

    updateReference();
  };

  const updateReference = () => {
    if (!refCode) return;
    const color = lfdjGetActive(colorSwatches);
    const design = lfdjGetActive(designThumbs);
    const size = lfdjGetActive(sizePills);
    if (!color || !design || !size) return;
    refCode.textContent = [
      "SWE",
      opts.refModel,
      design.dataset.code,
      color.dataset.code,
      size.dataset.code,
      "Q" + lfdjGetQty(qtyInput),
    ].join("-");
  };

  viewTabs.forEach((btn) => {
    btn.addEventListener("click", () => {
      lfdjSelectOne(viewTabs, btn);
      render();
    });
  });

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

  sizePills.forEach((btn) => {
    btn.addEventListener("click", () => {
      lfdjSelectOne(sizePills, btn);
      updateReference();
    });
  });

  lfdjInitQtyStepper(qtyInput, updateReference);
  lfdjInitCopyButton(copyBtn, refCode);

  render();
}

document.addEventListener("DOMContentLoaded", () => {
  lfdjInitSweat({
    idPrefix: "lfdj-sweat-rousseau",
    garmentPath: "./images/Textile/ROUSSEAU/",
    refModel: "ROUS",
    qtyId: "lfdj-input-sweat-rousseau-qty",
    lightColors: { CIEL: true },
  });

  lfdjInitSweat({
    idPrefix: "lfdj-sweat-montaigne",
    garmentPath: "./images/Textile/MONTAIGNE/",
    refModel: "MONT",
    qtyId: "lfdj-input-sweat-montaigne-qty",
    lightColors: { BLANC: true, GRISCLAIR: true },
  });
});
