  <header id="lfdj-sticky-header" class="lfdj-bg">
    <nav class="lfdj-navbar">
      <a href="/laforgedesjoueurs.php" aria-label="Association"><i class="fa-solid fa-house"></i></a>
      <a href="/figurines.php">Figurines</a>
      <a href="/bloodbowl.php">Blood Bowl</a>
      <a href="/roleplay.php">Jeux de rôle</a>
      <a href="/roots.php">Roots</a>
      <a href="/autres.php">Autres</a>
      <a href="/discord.php">Discord</a>
<input type="checkbox" id="dark-mode-toggle" />
<label for="dark-mode-toggle" class="toggle"></label>
    </nav>
  </header>

  <script>
  const key = "lfdj_darkmode";
  const toggle = document.getElementById("dark-mode-toggle");

  try {
    toggle.checked = localStorage.getItem(key) === "1";
  } catch (e) {}

  toggle.addEventListener("change", () => {
    try {
      localStorage.setItem(key, toggle.checked ? "1" : "0");
    } catch (e) {}
  });
</script>