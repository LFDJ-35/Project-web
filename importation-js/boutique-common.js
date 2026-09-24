/**
 * Fonctions utilitaires partagées par les configurateurs de la boutique
 * (boutique.js, pipito.js, generique.js, maillots.js, sweats.js, totbag.js).
 * Ce fichier doit être chargé avant les scripts qui l'utilisent.
 */

function lfdjGetActive(list) {
  return Array.from(list).find((el) => el.classList.contains("active"));
}

function lfdjSelectOne(list, btn) {
  list.forEach((b) => b.classList.remove("active"));
  btn.classList.add("active");
}

function lfdjGetQty(qtyInput) {
  const n = qtyInput ? parseInt(qtyInput.value, 10) : 1;
  return n > 0 ? n : 1;
}

/**
 * Branche les boutons +/- d'un stepper de quantité sur son input.
 * @param {HTMLInputElement} qtyInput
 * @param {() => void} onChange Appelé après chaque changement de quantité
 */
function lfdjInitQtyStepper(qtyInput, onChange) {
  if (!qtyInput) return;

  qtyInput.addEventListener("input", onChange);

  const qtyStepper = qtyInput.closest(".lfdj-qty-stepper");
  if (!qtyStepper) return;

  qtyStepper.querySelectorAll(".lfdj-qty-btn").forEach((btn) => {
    btn.addEventListener("click", () => {
      const current = parseInt(qtyInput.value, 10) || 1;
      const next = btn.dataset.action === "increment" ? current + 1 : Math.max(1, current - 1);
      qtyInput.value = next;
      onChange();
    });
  });
}

/**
 * Branche un bouton "Copier" sur la référence générée, avec repli
 * (textarea + execCommand) si l'API clipboard n'est pas disponible.
 * @param {HTMLElement} copyBtn
 * @param {HTMLElement} refCode
 */
function lfdjInitCopyButton(copyBtn, refCode) {
  if (!copyBtn || !refCode) return;

  const icon = copyBtn.querySelector("i");
  const originalIconClass = icon ? icon.className : null;

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
    if (!icon) return;
    icon.className = "fa-solid fa-check";
    copyBtn.disabled = true;
    setTimeout(() => {
      icon.className = originalIconClass;
      copyBtn.disabled = false;
    }, 1500);
  });
}

/**
 * Bouton "+" en bas à droite de chaque aperçu produit (.lfdj-zoom-btn) :
 * ouvre une visionneuse plein écran avec le cadre d'aperçu agrandi.
 * Le cadre (et ses boutons de navigation associés : vue face/dos, choix du
 * design) est déplacé dans la visionneuse plutôt que cloné, pour que les
 * scripts de chaque collection (generique.js, pipito.js...) continuent de
 * le piloter normalement pendant qu'il est agrandi. Il est replacé à sa
 * position d'origine à la fermeture.
 */
document.addEventListener("DOMContentLoaded", () => {
  const zoomButtons = document.querySelectorAll(".lfdj-zoom-btn");
  if (!zoomButtons.length) return;

  const overlay = document.createElement("div");
  overlay.className = "lfdj-zoom-overlay";
  overlay.innerHTML = '<button type="button" class="lfdj-zoom-close" aria-label="Fermer l\'aperçu agrandi">&times;</button><div class="lfdj-zoom-stage"></div>';
  document.body.appendChild(overlay);

  const stage = overlay.querySelector(".lfdj-zoom-stage");
  const closeBtn = overlay.querySelector(".lfdj-zoom-close");
  let moved = [];

  const moveIn = (el) => {
    const marker = document.createComment("lfdj-zoom-placeholder");
    el.parentNode.insertBefore(marker, el);
    moved.push({ el, marker });
    stage.appendChild(el);
  };

  const closeZoom = () => {
    overlay.classList.remove("active");
    moved.forEach(({ el, marker }) => {
      marker.parentNode.insertBefore(el, marker);
      marker.remove();
    });
    moved = [];
  };

  const openZoom = (frame) => {
    if (moved.length) closeZoom();

    const wrap = frame.closest(".lfdj-boutique-wrap");
    const viewTabs = wrap.querySelector(".lfdj-jersey-tabs");
    const designGrid = wrap.querySelector(".lfdj-design-grid");

    if (viewTabs) moveIn(viewTabs);
    moveIn(frame);
    if (designGrid) moveIn(designGrid);

    overlay.classList.add("active");
  };

  zoomButtons.forEach((btn) => {
    btn.addEventListener("click", () => {
      openZoom(btn.parentElement);
    });
  });

  closeBtn.addEventListener("click", closeZoom);
  overlay.addEventListener("click", (e) => {
    if (e.target === overlay) closeZoom();
  });
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") closeZoom();
  });
});
