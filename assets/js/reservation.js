document.addEventListener('DOMContentLoaded', () => {
  // --- Elements ---
  const serviceSelect = document.getElementById('service');
  const studioFields = document.getElementById('studio-fields');
  const recordingFields = document.getElementById('recording-fields');
  const drumlessonFields = document.getElementById('drumlesson-fields');

  const startTime = document.getElementById('studio-start-time');
  const endTime = document.getElementById('studio-end-time');
  const dateInput = document.getElementById('studio-date');
  const totalHours = document.getElementById('total-hours');
  const totalAmount = document.getElementById('total-amount');

  const rentalImageInput = document.getElementById('rental-image');
  const rentalImagePreview = document.getElementById('rental-image-preview');
  const recordingImageInput = document.getElementById('recording-image');
  const recordingImagePreview = document.getElementById('recording-image-preview');

  // --- Service Toggle ---
  const toggleServiceFields = () => {
    const value = serviceSelect.value;
    studioFields.style.display = value === '1' ? 'block' : 'none';
    recordingFields.style.display = value === '2' ? 'block' : 'none';
    if (drumlessonFields) drumlessonFields.style.display = value === '3' ? 'block' : 'none';
  };
  
  function toggleRequired(container, isRequired) {
  container.querySelectorAll('input, select, textarea').forEach(input => {
    if (isRequired) {
      input.setAttribute('required', 'required');
    } else {
      input.removeAttribute('required');
    }
  });
}

serviceSelect.addEventListener('change', function() {
  const value = this.value;
  const showStudio = value === '1';
  const showRecording = value === '2';
  const showDrum = value === '3';

  studioFields.style.display = showStudio ? 'block' : 'none';
  recordingFields.style.display = showRecording ? 'block' : 'none';
  if (drumlessonFields) drumlessonFields.style.display = showDrum ? 'block' : 'none';

  toggleRequired(studioFields, showStudio);
  toggleRequired(recordingFields, showRecording);
  if (drumlessonFields) toggleRequired(drumlessonFields, showDrum);
});

  serviceSelect.addEventListener('change', toggleServiceFields);
  toggleServiceFields(); // Initial check

  // --- Set allowed hours ---
  if (startTime) startTime.setAttribute('min', '09:00'); startTime.setAttribute('max', '23:00');
  if (endTime) endTime.setAttribute('min', '10:00'); endTime.setAttribute('max', '24:00');

  // --- Hourly Rate ---
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
      return;
    }

    if (startTime.value < '09:00' || startTime.value > '23:00' || endTime.value < '10:00' || endTime.value > '24:00') {
      alert('Operating hours are 9:00 AM to 12:00 midnight.');
      totalHours.value = '';
      totalAmount.value = '';
      return;
    }

    const start = new Date(`1970-01-01T${startTime.value}:00`);
    const end = new Date(`1970-01-01T${endTime.value}:00`);
    let diff = (end - start) / (1000 * 60 * 60);

    if (diff <= 0) {
      totalHours.value = '';
      totalAmount.value = '';
      return;
    }

    const hours = Math.ceil(diff);
    totalHours.value = `${hours} hour${hours > 1 ? 's' : ''}`;

    const rate = getHourlyRateForDate(new Date(dateInput.value));
    let baseAmount = hours * rate;

    let additionalsTotal = 0;
    document.querySelectorAll('.additional-checkbox:checked').forEach(cb => {
      additionalsTotal += parseInt(cb.dataset.price) || 0;
    });

    totalAmount.value = `₱${(baseAmount + additionalsTotal).toLocaleString()}`;
  };

  [startTime, endTime, dateInput].forEach(el => el?.addEventListener('change', calculateTotal));
  document.querySelectorAll('.additional-checkbox').forEach(cb => cb.addEventListener('change', calculateTotal));

  // --- Image Preview ---
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
  setupImagePreview(recordingImageInput, recordingImagePreview);
});
