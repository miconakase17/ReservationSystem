// assets/js/studioRental.js
document.addEventListener('DOMContentLoaded', () => {
  // --- Studio Rental Elements ---
  const startTime = document.getElementById('studioStartTime');
  const endTime = document.getElementById('studioEndTime');
  const dateInput = document.getElementById('studioDate');
  const totalHours = document.getElementById('totalHours');
  const totalAmount = document.getElementById('studioTotalCost');
  const downPaymentInput = document.getElementById('studioDownPayment');
  const rentalImageInput = document.getElementById('studioReceipt');
  const rentalImagePreview = document.getElementById('rental-image-preview');

  // --- Enforce allowed hours ---
  if (startTime) {
    startTime.setAttribute('min', '09:00');
    startTime.setAttribute('max', '23:00');
  }
  if (endTime) {
    endTime.setAttribute('min', '10:00');
    endTime.setAttribute('max', '24:00');
  }

  // --- Hourly Rate Lookup ---
  const getHourlyRateForDate = (date) => {
    const rules = window.studioPricings || [];
    if (!date) return 0;
    const weekday = ((date.getDay() + 6) % 7) + 1;

    for (const r of rules) {
      const from = parseInt(r.weekdayFrom, 10);
      const to = parseInt(r.weekdayTo, 10);
      const rate = parseInt(r.hourlyRate, 10);

      if (!isNaN(from) && !isNaN(to) && !isNaN(rate)) {
        if ((from <= to && weekday >= from && weekday <= to) ||
            (from > to && (weekday >= from || weekday <= to))) {
          return rate;
        }
      }
    }
    return 0;
  };

  // --- Calculate Total ---
  const calculateTotal = () => {
    if (!startTime.value || !endTime.value || !dateInput.value) {
      totalHours.value = '';
      totalAmount.value = '';
      downPaymentInput.value = '';
      return;
    }

    if (startTime.value < '09:00' || startTime.value > '23:00' ||
        endTime.value < '10:00' || endTime.value > '24:00') {
      alert('Operating hours are 9:00 AM to 12:00 midnight.');
      totalHours.value = '';
      totalAmount.value = '';
      downPaymentInput.value = '';
      return;
    }

    const start = new Date(`1970-01-01T${startTime.value}:00`);
    const end = new Date(`1970-01-01T${endTime.value}:00`);
    let diff = (end - start) / (1000 * 60 * 60);
    if (diff <= 0) {
      totalHours.value = '';
      totalAmount.value = '';
      downPaymentInput.value = '';
      return;
    }

    const hours = Math.ceil(diff);
    totalHours.value = `${hours} hour${hours > 1 ? 's' : ''}`;

    const rate = getHourlyRateForDate(new Date(dateInput.value));
    let baseAmount = hours * rate;

    // Additionals
    let additionalsTotal = 0;
    document.querySelectorAll('.additional-checkbox:checked').forEach(cb => {
      additionalsTotal += parseInt(cb.dataset.price) || 0;
    });

    const total = baseAmount + additionalsTotal;
    totalAmount.value = `₱${total.toLocaleString()}`;
    downPaymentInput.value = Math.round(total / 2);
  };

  // --- Attach event listeners ---
  [startTime, endTime, dateInput].forEach(el => el?.addEventListener('change', calculateTotal));
  document.querySelectorAll('.additional-checkbox').forEach(cb => cb.addEventListener('change', calculateTotal));

  // --- Receipt Image Preview ---
  const setupImagePreview = (input, preview) => {
    if (!input || !preview) return;
    input.addEventListener('change', e => {
      const file = e.target.files[0];
      if (!file) return;
      if (!file.type.startsWith('image/')) {
        alert('Please select a valid image file.');
        input.value = '';
        preview.style.display = 'none';
        return;
      }
      const reader = new FileReader();
      reader.onload = ev => {
        preview.src = ev.target.result;
        preview.style.display = 'block';
      };
      reader.readAsDataURL(file);
    });
  };
  setupImagePreview(rentalImageInput, rentalImagePreview);
});
