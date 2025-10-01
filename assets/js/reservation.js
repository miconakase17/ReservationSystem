// Show/hide studio fields based on service selection
  const serviceSelect = document.getElementById('service');
  const studioFields = document.getElementById('studio-fields');
  const recordingFields = document.getElementById('recording-fields');
  const drumlessonFields = document.getElementById('drumlesson-fields');
  const inputs = studioFields.querySelectorAll('input');

  serviceSelect.addEventListener('change', function () {
    if (this.value === 'Studio Rental') {
      studioFields.style.display = 'flex';
      recordingFields.style.display = 'none';
      if (drumlessonFields) drumlessonFields.style.display = 'none';
    } else if (this.value === 'Recording') {
      studioFields.style.display = 'none';
      recordingFields.style.display = 'flex';
      if (drumlessonFields) drumlessonFields.style.display = 'none';
    } else if (this.value === 'Drum Lesson') {
      studioFields.style.display = 'none';
      recordingFields.style.display = 'none';
      if (drumlessonFields) drumlessonFields.style.display = 'flex';
    } else {
      studioFields.style.display = 'none';
      recordingFields.style.display = 'none';
      if (drumlessonFields) drumlessonFields.style.display = 'none';
    }
  });

// Calculate total hours and amount
  const startTime = document.getElementById('start-time');
  const endTime = document.getElementById('end-time');

  // Set allowed operating hours
  if (startTime) {
    startTime.setAttribute('min', '09:00');
    startTime.setAttribute('max', '23:00');
    //startTime.setAttribute('step', '3600'); // Only whole hours
  }
  if (endTime) {
    endTime.setAttribute('min', '10:00');
    endTime.setAttribute('max', '24:00');
    //endTime.setAttribute('step', '3600'); // Only whole hours
  }
  const totalHours = document.getElementById('total-hours');
  const totalAmount = document.getElementById('total-amount');

  const ratePerHour = 250;
  function calculateTotal() {
    const dateInput = document.getElementById('date');
    if (startTime.value && endTime.value && dateInput && dateInput.value) {
      // Validate operating hours
      if (startTime.value < '09:00' || startTime.value > '23:00' || endTime.value < '10:00' || endTime.value > '24:00') {
        totalHours.value = '';
        totalAmount.value = '';
        alert('Operating hours are 9:00 AM to 12:00 midnight.');
        return;
      }

      let start = new Date("1970-01-01T" + startTime.value + ":00");
      let end = new Date("1970-01-01T" + endTime.value + ":00");

      let diff = (end - start) / (1000 * 60 * 60); // hours

      if (diff > 0) {
        let hours = Math.ceil(diff); // round up to nearest full hour
        totalHours.value = hours + " hour" + (hours > 1 ? "s" : "");

        // Get day of week from selected date
        let selectedDate = new Date(dateInput.value);
        let day = selectedDate.getDay(); // 0=Sunday, 1=Monday, ..., 6=Saturday
        let rate = (day >= 1 && day <= 4) ? 250 : 300; // Mon-Thu: 250, Fri-Sun: 300

        let baseAmount = hours * rate;

        // Additionals
        var additionalsTotal = 0;
        document.querySelectorAll('.additional-checkbox:checked').forEach(function(cb) {
          additionalsTotal += parseInt(cb.getAttribute('data-price'));
        });

        totalAmount.value = "₱" + (baseAmount + additionalsTotal).toLocaleString();
      } else {
        totalHours.value = "";
        totalAmount.value = "";
      }
    } else {
      totalHours.value = "";
      totalAmount.value = "";
    }
  }

  startTime.addEventListener("change", calculateTotal);
  endTime.addEventListener("change", calculateTotal);
  const dateInput = document.getElementById('date');
  if (dateInput) {
    dateInput.addEventListener("change", calculateTotal);
  }

  // Additionals checkbox listeners
  document.querySelectorAll('.additional-checkbox').forEach(function(checkbox) {
    checkbox.addEventListener('change', calculateTotal);
  });

