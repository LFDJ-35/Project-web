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

  const getActive = (list) => Array.from(list).find((el) => el.classList.contains("active"));
  const selectOne = (list, btn) => {
    list.forEach((b) => b.classList.remove("active"));
    btn.classList.add("active");
  };
  const getQty = () => {
    const n = qtyInput ? parseInt(qtyInput.value, 10) : 1;
    return n > 0 ? n : 1;
  };

  const updateReference = () => {
    if (!refCode) return;
    const color = getActive(colorSwatches);
    const size = getActive(sizePills);
    if (!color || !size) return;
    refCode.textContent = ["GEN", "XX", color.dataset.code, size.dataset.code, "Q" + getQty()].join("-");
  };

  colorSwatches.forEach((btn) => {
    btn.addEventListener("click", () => {
      selectOne(colorSwatches, btn);
      baseImg.src = basePath + btn.dataset.file;
      baseImg.alt = "T-shirt générique, coloris " + (btn.getAttribute("aria-label") || "").toLowerCase() + ", face et dos";
      updateReference();
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

  const initialColor = getActive(colorSwatches);
  if (initialColor) {
    baseImg.src = basePath + initialColor.dataset.file;
  }

  updateReference();
});
