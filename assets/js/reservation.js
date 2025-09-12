// Show/hide studio fields based on service selection
  const serviceSelect = document.getElementById('service');
  const studioFields = document.getElementById('studio-fields');
  const inputs = studioFields.querySelectorAll('input');

  serviceSelect.addEventListener('change', function () {
    if (this.value === 'Studio Rental') {
      studioFields.style.display = 'flex';   // or 'block'
      inputs.forEach(input => input.required = true);
    } else {
      studioFields.style.display = 'none';
      inputs.forEach(input => input.required = false);
    }
  });

// Calculate total hours and amount
  const startTime = document.getElementById('start-time');
  const endTime = document.getElementById('end-time');
  const totalHours = document.getElementById('total-hours');
  const totalAmount = document.getElementById('total-amount');

  const ratePerHour = 250; // ✅ set your hourly rate here

  function calculateTotal() {
    if (startTime.value && endTime.value) {
      let start = new Date("1970-01-01T" + startTime.value + ":00");
      let end = new Date("1970-01-01T" + endTime.value + ":00");

      let diff = (end - start) / (1000 * 60 * 60); // hours

      if (diff > 0) {
        let hours = Math.ceil(diff); // ✅ round up to nearest full hour
        totalHours.value = hours + " hour" + (hours > 1 ? "s" : "");
        totalAmount.value = "₱" + (hours * ratePerHour).toLocaleString();
      } else {
        totalHours.value = "";
        totalAmount.value = "";
      }
    }
  }

  startTime.addEventListener("change", calculateTotal);
  endTime.addEventListener("change", calculateTotal);

