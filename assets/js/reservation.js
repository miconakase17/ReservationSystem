document.addEventListener('DOMContentLoaded', () => {
  // --- Elements ---
  const serviceSelect = document.getElementById('service');
  const studioFields = document.getElementById('studio-fields');
  const recordingFields = document.getElementById('recording-fields');
  const drumlessonFields = document.getElementById('drumlesson-fields');

  // --- Toggle section visibility ---
  function toggleSection(section, show) {
    if (!section) return;
    section.style.display = show ? 'block' : 'none';
    section.querySelectorAll('input, select, textarea').forEach(input => {
      if (show && input.hasAttribute('data-required-when-visible')) {
        input.setAttribute('required', 'required');
      } else {
        input.removeAttribute('required');
      }
    });
  }

  // --- Service Toggle ---
  const toggleServiceFields = () => {
    const value = serviceSelect.value;
    studioFields.style.display = value === '1' ? 'block' : 'none';
    recordingFields.style.display = value === '2' ? 'block' : 'none';
    if (drumlessonFields) drumlessonFields.style.display = value === '3' ? 'block' : 'none';
  };

  serviceSelect.addEventListener('change', function () {
    const value = this.value;
    toggleSection(studioFields, value === '1');     // Studio Rental
    toggleSection(recordingFields, value === '2');  // Recording
    toggleSection(drumlessonFields, value === '3'); // Drum Lesson
  });

  // Run once on page load
  toggleSection(studioFields, serviceSelect.value === '1');
  toggleSection(recordingFields, serviceSelect.value === '2');
  toggleSection(drumlessonFields, serviceSelect.value === '3');

  serviceSelect.addEventListener('change', toggleServiceFields);
  toggleServiceFields(); // Initial check

  // --- Recording Service Price Calculation ---
  const recordingTotal = document.getElementById('recording-total-price');
  const multitrackRadio = document.getElementById('multitrack');
  const livetrackRadio = document.getElementById('livetrack');
  const mixCheckbox = document.getElementById('mix');

  function calculateRecordingPrice() {
    let total = 0;

    if (multitrackRadio.checked) total += 500;
    if (livetrackRadio.checked) total += 800;
    if (mixCheckbox.checked) total += 1500;

    if (recordingTotal) recordingTotal.value = total;

    // Automatically set down payment to half
    const recordingDownPaymentInput = document.getElementById('recording-amountPaid');
    if (recordingDownPaymentInput) {
      const downPayment = Math.round(total / 2);
      recordingDownPaymentInput.value = downPayment; // no ₱ symbol
    }
  }

  // Attach event listeners
  [multitrackRadio, livetrackRadio, mixCheckbox].forEach(el => {
    if (el) el.addEventListener('change', calculateRecordingPrice);
  });

  // Initial calculation on page load
  calculateRecordingPrice();
});


// --- Drum Lesson Auto End Time ---
document.addEventListener('DOMContentLoaded', () => {
  const drumStart = document.getElementById('drumlesson-start-time');
  const drumEnd = document.getElementById('drumlesson-end-time');

  if (drumStart) {
    drumStart.addEventListener('input', () => {
      if (drumStart.value) {
        let [hours, minutes] = drumStart.value.split(':').map(Number);
        hours += 2; // Add 2 hours
        if (hours >= 24) hours -= 24; // Handle next day
        drumEnd.value = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`;
      } else {
        drumEnd.value = '';
      }
    });
  }
});
