document.addEventListener('DOMContentLoaded', () => {
  const serviceSelect = document.getElementById('service');
  const date = document.getElementById('date');
  const startTime = document.getElementById('startTime');
  const endTime = document.getElementById('endTime');
  const totalHours = document.getElementById('totalHours');
  const totalCost = document.getElementById('totalCost');
  const downPayment = document.getElementById('downPayment');
  const additionalCheckboxes = document.querySelectorAll('.additional-checkbox');

  function calculateHours() {
    if (!startTime.value || !endTime.value) {
      totalHours.value = '';
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

  function calculateTotal() {
    if (serviceSelect.value !== '1') return; // only for Studio Rental
    const hours = calculateHours();
    const additionalsTotal = calculateAdditionals();
    const rate = getStudioRate();
    const total = hours * rate + additionalsTotal;
    totalCost.value = total.toFixed(2);
    downPayment.value = (total / 2).toFixed(2);
  }

  // Auto-fill end time with default 2 hours (optional)
  startTime.addEventListener('change', () => {
    if (serviceSelect.value !== '1') return;
    if (!startTime.value) return;

    const [sh, sm] = startTime.value.split(':').map(Number);
    const startDate = new Date();
    startDate.setHours(sh, sm, 0, 0);

    const endDate = new Date(startDate);
    endDate.setHours(endDate.getHours() + 2); // default 2 hours

    endTime.value = `${String(endDate.getHours()).padStart(2, '0')}:${String(endDate.getMinutes()).padStart(2, '0')}`;
    calculateTotal();
  });

  // Recalculate total when inputs change
  [startTime, endTime, date, ...additionalCheckboxes].forEach(el => {
    if (el) el.addEventListener('change', calculateTotal);
  });

});
