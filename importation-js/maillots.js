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

  const getActive = (list) => Array.from(list).find((el) => el.classList.contains("active"));
  const selectOne = (list, btn) => {
    list.forEach((b) => b.classList.remove("active"));
    btn.classList.add("active");
  };

  const numberColors = { B: "#c8a44d", Y: "#8e533a" };

  const sanitizeName = (value) => (value || "").trim().toUpperCase().replace(/[^A-Z0-9]/g, "") || "NOM";
  const sanitizeNumber = (value) => (value || "").trim().toUpperCase().slice(0, 4) || "00";
  const getQty = () => {
    const n = qtyInput ? parseInt(qtyInput.value, 10) : 1;
    return n > 0 ? n : 1;
  };

  const fitName = () => {
    if (!nameEl) return;
    nameEl.style.transform = "translate(-50%, -50%) scale(1)";
    const natural = nameEl.scrollWidth;
    const scale = natural > NAME_MAX_WIDTH ? NAME_MAX_WIDTH / natural : 1;
    nameEl.style.transform = "translate(-50%, -50%) scale(" + scale + ")";
  };

  const render = () => {
    const view = getActive(jerseyTabs)?.dataset.view || "BACK";
    const color = getActive(jerseyColors)?.dataset.color || "B";
    const design = getActive(jerseyDesigns);
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
    const design = getActive(jerseyDesigns);
    const color = getActive(jerseyColors);
    const size = getActive(jerseySizes);
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
      "Q" + getQty(),
    ].join("-");
  };

  jerseyTabs.forEach((btn) => {
    btn.addEventListener("click", () => {
      selectOne(jerseyTabs, btn);
      render();
    });
  });

  jerseyDesigns.forEach((btn) => {
    btn.addEventListener("click", () => {
      selectOne(jerseyDesigns, btn);
      render();
    });
  });

  jerseyColors.forEach((btn) => {
    btn.addEventListener("click", () => {
      selectOne(jerseyColors, btn);
      render();
    });
  });

  jerseySizes.forEach((btn) => {
    btn.addEventListener("click", () => {
      selectOne(jerseySizes, btn);
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

  window.addEventListener("resize", fitName);

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
