document.addEventListener('DOMContentLoaded', () => {
  const serviceSelect = document.getElementById('service');
  const totalCost = document.getElementById('totalCost');
  const downPayment = document.getElementById('downPayment');
  const multitrack = document.getElementById('multitrack');
  const livetrack = document.getElementById('livetrack');
  const mix = document.getElementById('mix');

  // 🧾 Prices from PHP
  const priceMap = {};
  if (window.recordingPricings && Array.isArray(window.recordingPricings)) {
    window.recordingPricings.forEach(p => {
      priceMap[p.name] = parseFloat(p.price);
    });
  }

  function calculateTotal() {
    let total = 0;
    const service = serviceSelect.value;

    if (service === '2') { // Recording
      if (multitrack.checked) total += priceMap['MultiTrack'] || 0;
      if (livetrack.checked) total += priceMap['LiveTrack'] || 0;
      if (mix.checked) total += priceMap['MixAndMaster'] || 0;
    }

    totalCost.value = total.toFixed(2);
    downPayment.value = (total / 2).toFixed(2);
  }

  // 🧠 Watch for changes
  [multitrack, livetrack, mix, serviceSelect].forEach(el => {
    if (el) el.addEventListener('change', calculateTotal);
  });

  // Initialize
  calculateTotal();

  // Optional: recalc if service changes to/from Recording
  serviceSelect.addEventListener('change', calculateTotal);
});
