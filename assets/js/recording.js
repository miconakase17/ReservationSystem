document.addEventListener('DOMContentLoaded', () => {
  const serviceSelect = document.getElementById('service');
  const totalCost = document.getElementById('totalCost');
  const downPayment = document.getElementById('downPayment');
  const multitrack = document.getElementById('multitrack');
  const livetrack = document.getElementById('livetrack');
  const mix = document.getElementById('mix');
  const startTime = document.getElementById('startTime');
  const endTime = document.getElementById('endTime');

  // 🧾 Prices from PHP
  const priceMap = {};
  if (window.recordingPricings && Array.isArray(window.recordingPricings)) {
    window.recordingPricings.forEach(p => {
      priceMap[p.name] = parseFloat(p.price);
    });
  }

  function getHours() {
    if (!startTime.value || !endTime.value) return 1; // default 1 hour
    const [sh, sm] = startTime.value.split(':').map(Number);
    const [eh, em] = endTime.value.split(':').map(Number);
    let diff = (eh * 60 + em) - (sh * 60 + sm);
    if (diff < 0) diff += 24 * 60;
    return diff / 60;
  }

  function calculateTotal() {
    let total = 0;
    const service = serviceSelect.value;
    const hours = getHours();

    if (service === '2') { // Recording
      if (multitrack.checked) total += (priceMap['MultiTrack'] || 0) * hours;
      if (livetrack.checked) total += (priceMap['LiveTrack'] || 0) * hours;
      if (mix.checked) total += priceMap['MixAndMaster'] || 0; // fixed
    }

    totalCost.value = total.toFixed(2);
    downPayment.value = (total / 2).toFixed(2);
  }


  // 🧠 Watch for changes
  [multitrack, livetrack, mix, serviceSelect, startTime, endTime].forEach(el => {
    if (el) {
      el.addEventListener('change', calculateTotal);
      el.addEventListener('input', calculateTotal); // recalc as user types
    }
  });

  calculateTotal(); // initial compute
});
