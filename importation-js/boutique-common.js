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
