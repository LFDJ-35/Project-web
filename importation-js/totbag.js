document.addEventListener("DOMContentLoaded", () => {
  const refCode = document.getElementById("lfdj-totbag-ref-code");
  const copyBtn = document.getElementById("lfdj-totbag-ref-copy");
  const qtyInput = document.getElementById("lfdj-input-totbag-qty");

  if (!refCode) return;

  const getQty = () => {
    const n = qtyInput ? parseInt(qtyInput.value, 10) : 1;
    return n > 0 ? n : 1;
  };

  const updateReference = () => {
    refCode.textContent = "TOT-NAT-Q" + getQty();
  };

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

  if (copyBtn) {
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
