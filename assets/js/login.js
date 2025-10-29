document.addEventListener("DOMContentLoaded", () => {
  const popup = document.getElementById("error-popup");
  if (!popup) return;

  const closeBtn = popup.querySelector(".close-popup");

  // Start from hidden state
  popup.classList.remove("show", "hide");

  // Force browser to compute the current style (reflow)
  void popup.offsetHeight;

  // Now safely trigger the transition
  popup.classList.add("show");

  // --- Close animation ---
  function closePopup() {
    popup.classList.remove("show");
    popup.classList.add("hide");

    popup.addEventListener(
      "transitionend",
      () => {
        popup.style.display = "none";
      },
      { once: true }
    );
  }

  if (closeBtn) closeBtn.addEventListener("click", closePopup);

  // Auto-close after 4 seconds
  setTimeout(closePopup, 4000);
});
