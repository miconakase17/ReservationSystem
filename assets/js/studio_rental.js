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
    totalHours.value = hours;
    return hours;
  }

  function calculateAdditionals() {
    let total = 0;
    additionalCheckboxes.forEach(cb => {
      if (cb.checked) total += parseFloat(cb.dataset.price || 0);
    });
    return total;
  }
});
