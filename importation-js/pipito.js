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
    const design = getActive(designThumbs);
    const size = getActive(sizePills);
    if (!design || !size) return;
    refCode.textContent = ["PIP", design.dataset.code, "NOI", size.dataset.code, "Q" + getQty()].join("-");
  };

  designThumbs.forEach((btn) => {
    btn.addEventListener("click", () => {
      selectOne(designThumbs, btn);
      baseImg.src = basePath + btn.dataset.file;
      baseImg.alt = "T-shirt La Forge des Joueurs, design " + (btn.getAttribute("aria-label") || "");
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

  const initialDesign = getActive(designThumbs);
  if (initialDesign) {
    baseImg.src = basePath + initialDesign.dataset.file;
  }

  updateReference();
});
