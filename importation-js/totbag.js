document.addEventListener("DOMContentLoaded", () => {
  const refCode = document.getElementById("lfdj-totbag-ref-code");
  const copyBtn = document.getElementById("lfdj-totbag-ref-copy");
  const qtyInput = document.getElementById("lfdj-input-totbag-qty");

  if (!refCode) return;

  const updateReference = () => {
    refCode.textContent = "TOT-NAT-Q" + lfdjGetQty(qtyInput);
  };

  lfdjInitQtyStepper(qtyInput, updateReference);
  lfdjInitCopyButton(copyBtn, refCode);

  updateReference();
});
