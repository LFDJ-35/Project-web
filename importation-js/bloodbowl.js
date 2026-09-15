document.addEventListener("DOMContentLoaded", () => {
  const tabButtons = document.querySelectorAll(".lfdj-bb-season-tab-btn");
  const panels = document.querySelectorAll(".lfdj-bb-season-panel");

  tabButtons.forEach((btn) => {
    btn.addEventListener("click", () => {
      const target = btn.dataset.tab;
      tabButtons.forEach((b) => b.classList.toggle("is-active", b === btn));
      panels.forEach((panel) => {
        panel.hidden = panel.dataset.panel !== target;
      });
    });
  });

  document.querySelectorAll(".lfdj-bb-results-toggle-btn").forEach((btn) => {
    btn.addEventListener("click", () => {
      const content = document.getElementById(btn.getAttribute("aria-controls"));
      const isOpen = btn.getAttribute("aria-expanded") === "true";
      btn.setAttribute("aria-expanded", String(!isOpen));
      content.hidden = isOpen;
    });
  });
});
