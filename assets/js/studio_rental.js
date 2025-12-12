document.addEventListener('DOMContentLoaded', () => {
  const serviceSelect = document.getElementById('service');
  const date = document.getElementById('date');
  const startTime = document.getElementById('startTime');
  const endTime = document.getElementById('endTime');
  const totalHours = document.getElementById('totalHours');
  const totalCost = document.getElementById('totalCost');
  const downPayment = document.getElementById('downPayment');

  // Calculate hours between start and end time
  function calculateHours() {
    if (!startTime.value || !endTime.value) return 0;
    const [sh, sm] = startTime.value.split(':').map(Number);
    const [eh, em] = endTime.value.split(':').map(Number);
    let diff = (eh * 60 + em) - (sh * 60 + sm);
    if (diff < 0) diff += 24 * 60; // next-day wrap
    const hours = diff / 60;
    totalHours.value = hours.toFixed(2);
    return hours;
  }

  // Get studio hourly rate based on date
  function getStudioRate() {
    if (!window.studioPricings || window.studioPricings.length === 0 || !date.value) return 0;
    const day = new Date(date.value).getDay();
    const weekday = day === 0 ? 7 : day; // Sunday = 7
    let rate = 0;
    window.studioPricings.forEach(sp => {
      if (weekday >= sp.weekdayFrom && weekday <= sp.weekdayTo) rate = sp.hourlyRate;
    });
    return rate;
  }

  // Calculate total including additionals
  function calculateTotal() {
    if (serviceSelect.value !== '1') {
      totalCost.value = '';
      downPayment.value = '';
      totalHours.value = '';
      return;
    }

    if (!date.value || !startTime.value) return;

    // Auto-fill end time 2 hours after start if empty
    if (!endTime.value) {
      const [sh, sm] = startTime.value.split(':').map(Number);
      const d = new Date();
      d.setHours(sh + 2, sm, 0, 0);
      endTime.value = `${String(d.getHours()).padStart(2,'0')}:${String(d.getMinutes()).padStart(2,'0')}`;
    }

    const hours = calculateHours();
    const rate = getStudioRate();

    // Re-query additionals every calculation
    const additionalCheckboxes = document.querySelectorAll('.additional-checkbox');
    let additionalsTotal = 0;
    additionalCheckboxes.forEach(cb => {
      if (cb.checked) additionalsTotal += parseFloat(cb.dataset.price || 0);
    });

    const total = hours * rate + additionalsTotal;
    totalCost.value = total.toFixed(2);
    downPayment.value = (total / 2).toFixed(2);
  }

  // Add event listeners
  function addListeners() {
    [date, startTime, endTime, serviceSelect].forEach(el => {
      el.addEventListener('input', calculateTotal);
      el.addEventListener('change', calculateTotal);
    });
    // Add listener for dynamic checkboxes
    document.addEventListener('change', (e) => {
      if (e.target && e.target.classList.contains('additional-checkbox')) {
        calculateTotal();
      }
    });
  }

  // Recalculate when modal opens
  const reservationModal = document.getElementById('reservationForm');
  reservationModal.addEventListener('shown.bs.modal', () => {
    calculateTotal();
    addListeners();
  });
});
