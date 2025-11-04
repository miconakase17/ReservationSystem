document.addEventListener('DOMContentLoaded', () => {
  const serviceSelect = document.getElementById('service');
  const studioFields = document.getElementById('studio-fields');
  const recordingFields = document.getElementById('recording-fields');
  const drumlessonFields = document.getElementById('drumlesson-fields');

  const startTime = document.getElementById('startTime'); // Studio Rental / Recording
  const endTime = document.getElementById('endTime');
  const dateInput = document.getElementById('date');
  const totalHours = document.getElementById('totalHours');
  const totalCost = document.getElementById('totalCost');
  const downPayment = document.getElementById('downPayment');

  const additionals = document.querySelectorAll('.additional-checkbox');
  const multitrack = document.getElementById('multitrack');
  const livetrack = document.getElementById('livetrack');
  const mix = document.getElementById('mix');

  const drumStartTime = document.getElementById('drumlesson-start-time');
  const drumDate = document.getElementById('drumlesson-start-date');

  // --- Toggle service sections ---
  function toggleSection(section, show) {
    if (!section) return;
    section.style.display = show ? 'block' : 'none';
    section.querySelectorAll('input, select, textarea').forEach(input => {
      if (show && input.hasAttribute('data-required-when-visible')) input.setAttribute('required', 'required');
      else input.removeAttribute('required');
    });
  }


  const endTimeNote = document.getElementById('endTimeNote');

  function handleServiceChange() {
    const value = serviceSelect.value;
    toggleSection(studioFields, value === '1');
    toggleSection(recordingFields, value === '2');
    toggleSection(drumlessonFields, value === '3');

    // Show note only for Drum Lesson
    if (endTimeNote) endTimeNote.style.display = (value === '3') ? 'block' : 'none';

    calculateTotal();
  }

  serviceSelect.addEventListener('change', handleServiceChange);
  handleServiceChange();

  // --- Studio Rental / Recording helpers ---
  function calculateHours() {
    if (!startTime.value || !endTime.value) return 0;
    const [sh, sm] = startTime.value.split(':').map(Number);
    const [eh, em] = endTime.value.split(':').map(Number);
    let diff = (eh * 60 + em) - (sh * 60 + sm);
    if (diff < 0) diff += 24 * 60;
    totalHours.value = (diff / 60).toFixed(2);
    return diff / 60;
  }

  function calculateAdditionals() {
    let total = 0;
    additionals.forEach(cb => {
      if (cb.checked) total += parseFloat(cb.dataset.price || 0);
    });
    return total;
  }

  function getStudioRate(date) {
    if (!date || !window.studioPricings) return 0;
    const day = new Date(date).getDay();
    const weekday = day === 0 ? 7 : day;
    let rate = 0;
    window.studioPricings.forEach(sp => {
      if (weekday >= sp.weekdayFrom && weekday <= sp.weekdayTo) rate = sp.hourlyRate;
    });
    return rate;
  }

  function getRecordingPrice() {
    if (!window.recordingPricings) return 0;
    let total = 0;
    const hours = calculateHours() || 1;
    window.recordingPricings.forEach(opt => {
      if (multitrack.checked && opt.name === 'MultiTrack') total += parseFloat(opt.price) * hours;
      if (livetrack.checked && opt.name === 'LiveTrack') total += parseFloat(opt.price) * hours;
      if (mix.checked && opt.name === 'MixAndMaster') total += parseFloat(opt.price);
    });
    return total;
  }

  // --- Main total calculation ---
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

    } else if (service === '3') { // Drum Lesson
      total = 7500; // fixed total
    }

    totalCost.value = total.toFixed(2);
    downPayment.value = (total / 2).toFixed(2);
  }

  // --- Event listeners for Studio Rental / Recording ---
  [startTime, endTime, dateInput, multitrack, livetrack, mix].forEach(el => {
    if (!el) return;
    el.addEventListener('change', () => {
      if (serviceSelect.value === '1' || serviceSelect.value === '2') calculateTotal();
    });
  });

  // --- Drum Lesson total remains fixed ---
  [drumStartTime, drumDate].forEach(el => {
    if (!el) return;
    el.addEventListener('change', () => {
      if (serviceSelect.value === '3') {
        totalCost.value = '7500';
        downPayment.value = '3750';
      }
    });
  });

  // Initial calculation
  calculateTotal();
});

document.addEventListener('DOMContentLoaded', () => {
  const reservationForm = document.querySelector('.reservation-form');

  reservationForm.addEventListener('submit', (e) => {
    e.preventDefault(); // Stop normal form submission

    const formData = new FormData(reservationForm);

    fetch(reservationForm.action, {
      method: 'POST',
      body: formData
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          Swal.fire({
            icon: 'success',
            title: 'Reservation Confirmed!',
            text: data.message || 'Your reservation has been submitted successfully!',
            confirmButtonText: 'OK'
          }).then(() => {
            // Redirect after user clicks OK
            window.location.href = 'customer-dashboard.php';
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Reservation Failed',
            text: data.message || 'Something went wrong. Please try again.',
            confirmButtonText: 'OK'
          });
        }
      })
      .catch(err => {
        console.error(err);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Could not process reservation. Please try again.',
          confirmButtonText: 'OK'
        });
      });
  });
});
