document.addEventListener('DOMContentLoaded', () => {
  // Elements
  const serviceSelect = document.getElementById('service');
  const date = document.getElementById('date');
  const startTime = document.getElementById('startTime');
  const endTime = document.getElementById('endTime');
  const totalHours = document.getElementById('totalHours');
  const totalCost = document.getElementById('totalCost');
  const downPayment = document.getElementById('downPayment');
  const additionalCheckboxes = document.querySelectorAll('.additional-checkbox');

  // --- Helpers ---
  function calculateHours() {
    if (!startTime.value || !endTime.value) {
      totalHours.value = "0.00";
      return 0;
    }

    const [sh, sm] = startTime.value.split(':').map(Number);
    const [eh, em] = endTime.value.split(':').map(Number);

    let diff = (eh * 60 + em) - (sh * 60 + sm);
    if (diff < 0) diff += 24 * 60; // next-day wrap

    const hours = diff / 60;
    totalHours.value = hours.toFixed(2);
    return hours;
  }

  function calculateAdditionals() {
    let total = 0;
    additionalCheckboxes.forEach(cb => {
      if (cb.checked) total += parseFloat(cb.dataset.price || 0);
    });
    return total;
  }

  function getStudioRate() {
    if (!window.studioPricings || !date.value) return 0;

    const day = new Date(date.value).getDay(); // 0=Sun ... 6=Sat
    const weekday = day === 0 ? 7 : day; // 1=Mon ... 7=Sun
    let rate = 0;

    window.studioPricings.forEach(sp => {
      if (weekday >= sp.weekdayFrom && weekday <= sp.weekdayTo) {
        rate = sp.hourlyRate;
      }
    });

    return rate;
  }

  // --- Main Calculation ---
  function calculateTotal() {
    if (serviceSelect.value !== '1') return; // Only for Studio Rental

    // Set default date/start/end if empty
    if (!date.value) date.value = new Date().toISOString().split('T')[0];
    if (!startTime.value) startTime.value = '09:00';
    if (!endTime.value) {
      const [sh, sm] = startTime.value.split(':').map(Number);
      const d = new Date();
      d.setHours(sh + 2, sm, 0, 0); // default 2 hours
      endTime.value = `${String(d.getHours()).padStart(2, '0')}:${String(d.getMinutes()).padStart(2, '0')}`;
    }

    const hours = calculateHours();
    const additionalsTotal = calculateAdditionals();
    const rate = getStudioRate();

    const total = hours * rate + additionalsTotal;
    totalCost.value = total.toFixed(2);
    downPayment.value = (total / 2).toFixed(2);
  }

  // --- Initialize ---
  function initStudioRental() {
    if (!window.studioPricings) {
      setTimeout(initStudioRental, 50); // wait until pricings are loaded
      return;
    }

    // Initial calculation
    calculateTotal();

    // Recalculate on input/change
    [startTime, endTime, date, ...additionalCheckboxes].forEach(el => {
      if (el) {
        el.addEventListener('input', calculateTotal);
        el.addEventListener('change', calculateTotal);
      }
    });
  }

  initStudioRental();

  // --- Recalculate when switching service ---
  serviceSelect.addEventListener('change', () => {
    if (serviceSelect.value === '1') calculateTotal();
  });
});
