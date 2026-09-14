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

  const getActive = (list) => Array.from(list).find((el) => el.classList.contains("active"));

  const updateReference = () => {
    const design = getActive(designThumbs);
    const color = getActive(colorSwatches);
    const size = getActive(sizePills);
    if (!design || !color || !size || !refCode) return;
    const qty = qtyInput && parseInt(qtyInput.value, 10) > 0 ? parseInt(qtyInput.value, 10) : 1;
    refCode.textContent = ["EST", design.dataset.code, color.dataset.code, size.dataset.code, "Q" + qty].join("-");
  };

  const selectOne = (list, btn) => {
    list.forEach((b) => b.classList.remove("active"));
    btn.classList.add("active");
  };

  designThumbs.forEach((btn) => {
    btn.addEventListener("click", () => {
      selectOne(designThumbs, btn);
      designImg.src = designPath + btn.dataset.file;
      designImg.alt = "Design " + (btn.getAttribute("aria-label") || "").replace("Design ", "");
      updateReference();
    });
  });

  colorSwatches.forEach((btn) => {
    btn.addEventListener("click", () => {
      selectOne(colorSwatches, btn);
      baseImg.src = colorPath + btn.dataset.file;
      baseImg.alt = "T-shirt dos, coloris " + (btn.getAttribute("aria-label") || "").toLowerCase();
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

  updateReference();
});
