document.addEventListener('DOMContentLoaded', () => {
  // --- Elements ---
  const serviceSelect = document.getElementById('service');
  const studioFields = document.getElementById('studio-fields');
  const recordingFields = document.getElementById('recording-fields');
  const drumlessonFields = document.getElementById('drumlesson-fields');

  const startTime = document.getElementById('startTime');
  const endTime = document.getElementById('endTime');
  const dateInput = document.getElementById('date');
  const totalHours = document.getElementById('totalHours');
  const totalCost = document.getElementById('totalCost');
  const downPayment = document.getElementById('downPayment');

  const additionals = document.querySelectorAll('.additional-checkbox');

  // Recording inputs
  const multitrack = document.getElementById('multitrack');
  const livetrack = document.getElementById('livetrack');
  const mix = document.getElementById('mix');

  // --- Toggle service sections ---
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

  function handleServiceChange() {
    const value = serviceSelect.value;
    toggleSection(studioFields, value === '1');
    toggleSection(recordingFields, value === '2');
    toggleSection(drumlessonFields, value === '3');
    calculateTotal();
  }

  serviceSelect.addEventListener('change', handleServiceChange);
  handleServiceChange(); // initial call

  // --- Helper: Calculate hours for Studio Rental ---
  function calculateHours() {
    if (!startTime.value || !endTime.value) {
      totalHours.value = '';
      return 0;
    }
    const [sh, sm] = startTime.value.split(':').map(Number);
    const [eh, em] = endTime.value.split(':').map(Number);
    let diff = (eh * 60 + em) - (sh * 60 + sm);
    if (diff < 0) diff += 24 * 60; // next day
    const hours = diff / 60;
    totalHours.value = hours.toFixed(2);
    return hours;
  }

  // --- Helper: Calculate additionals ---
  function calculateAdditionals() {
    let total = 0;
    additionals.forEach(cb => {
      if (cb.checked) total += parseFloat(cb.dataset.price || 0);
    });
    return total;
  }

  // --- Helper: Get Studio Rental hourly rate from PHP data ---
  function getStudioRate(date) {
    if (!date || !window.studioPricings) return 0;
    const day = new Date(date).getDay(); // 0=Sun ... 6=Sat
    const weekday = day === 0 ? 7 : day; // convert to 1=Mon ... 7=Sun
    let rate = 0;
    window.studioPricings.forEach(sp => {
      if (weekday >= sp.weekdayFrom && weekday <= sp.weekdayTo) {
        rate = sp.hourlyRate;
      }
    });
    return rate;
  }

  // --- Helper: Get Recording price from PHP data ---
  function getRecordingPrice() {
    if (!window.recordingPricings) return 0;
    let total = 0;
    window.recordingPricings.forEach(opt => {
      if (multitrack.checked && opt.name === 'MultiTrack') total += parseFloat(opt.price);
      if (livetrack.checked && opt.name === 'LiveTrack') total += parseFloat(opt.price);
      if (mix.checked && opt.name === 'MixAndMaster') total += parseFloat(opt.price);
    });
    return total;
  }

  // --- Main calculation ---
  function calculateTotal() {
    const service = serviceSelect.value;
    let total = 0;

    if (service === '1') { // Studio Rental
      const hours = calculateHours();
      const additionalsTotal = calculateAdditionals();
      const rate = getStudioRate(dateInput.value);
      total = hours * rate + additionalsTotal;

    } else if (service === '2') { // Recording
      total = getRecordingPrice();

    }  if (service !== '3') {
    totalCost.value = total.toFixed(2);
    downPayment.value = (total / 2).toFixed(2);
  }
    totalCost.value = total.toFixed(2);
    downPayment.value = (total / 2).toFixed(2);
  }

  // --- Event listeners ---
  [startTime, endTime, dateInput, multitrack, livetrack, mix].forEach(el => {
    if (el) el.addEventListener('change', calculateTotal);
  });
  additionals.forEach(cb => cb.addEventListener('change', calculateTotal));

  calculateTotal(); // initial compute
});
