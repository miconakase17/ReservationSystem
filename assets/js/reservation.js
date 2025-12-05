document.addEventListener('DOMContentLoaded', () => {
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
  const multitrack = document.getElementById('multitrack');
  const livetrack = document.getElementById('livetrack');
  const mix = document.getElementById('mix');

  const drumStartTime = document.getElementById('drumlesson-start-time');
  const drumDate = document.getElementById('drumlesson-start-date');

  const endTimeNote = document.getElementById('endTimeNote');

  // Toggle Fields
  function toggleSection(section, show) {
    if (!section) return;
    section.style.display = show ? 'block' : 'none';
    section.querySelectorAll('input, select, textarea').forEach(input => {
      if (show && input.hasAttribute('data-required-when-visible'))
        input.setAttribute('required', 'required');
      else input.removeAttribute('required');
    });
  }

  function handleServiceChange() {
    const value = serviceSelect.value;

    toggleSection(studioFields, value === '1');
    toggleSection(recordingFields, value === '2');
    toggleSection(drumlessonFields, value === '3');

    if (endTimeNote)
      endTimeNote.style.display = value === '3' ? 'block' : 'none';

    // ALWAYS recalc when switching service
    calculateTotal();
  }

  serviceSelect.addEventListener('change', handleServiceChange);
  handleServiceChange();

  // Helpers
  function calculateHours() {
    const sh = startTime.value ? parseInt(startTime.value.split(':')[0], 10) : 0;
    const sm = startTime.value ? parseInt(startTime.value.split(':')[1], 10) : 0;
    const eh = endTime.value ? parseInt(endTime.value.split(':')[0], 10) : 0;
    const em = endTime.value ? parseInt(endTime.value.split(':')[1], 10) : 0;

    let diff = (eh * 60 + em) - (sh * 60 + sm);
    if (diff < 0) diff += 24 * 60;

    totalHours.value = diff > 0 ? (diff / 60).toFixed(2) : "0.00";
    return diff / 60;
  }

  // Attach listeners for both input and change
  [startTime, endTime].forEach(el => {
    if (el) {
      el.addEventListener('input', calculateTotal);
      el.addEventListener('change', calculateTotal);
    }
  });

  // Trigger total on load in case inputs are pre-filled (e.g., browser autofill)
  calculateTotal();



  function calculateAdditionals() {
    let total = 0;
    additionals.forEach(cb => {
      if (cb.checked) total += parseFloat(cb.dataset.price || 0);
    });
    return total;
  }

  function getStudioRate(date) {
    if (!date || !window.studioPricings) return 0;

    const weekday = new Date(date).getDay() || 7;
    let rate = 0;

    window.studioPricings.forEach(sp => {
      if (weekday >= sp.weekdayFrom && weekday <= sp.weekdayTo)
        rate = sp.hourlyRate;
    });

    return rate;
  }

  function getRecordingPrice() {
    if (!window.recordingPricings) return 0;

    let total = 0;
    const hours = calculateHours() || 1;

    window.recordingPricings.forEach(opt => {
      if (multitrack.checked && opt.name === 'MultiTrack') total += opt.price * hours;
      if (livetrack.checked && opt.name === 'LiveTrack') total += opt.price * hours;
      if (mix.checked && opt.name === 'MixAndMaster') total += opt.price;
    });

    return total;
  }

  function calculateTotal() {
    const service = serviceSelect.value;
    let total = 0;

    if (service === '1') {
      // Only calculate if start, end, and date are filled
      if (!startTime.value || !endTime.value || !dateInput.value) {
        totalHours.value = "0.00";
        totalCost.value = "0.00";
        downPayment.value = "0.00";
        return;
      }

      const hours = calculateHours();
      const rate = getStudioRate(dateInput.value) || 0; // ensure numeric
      const additionalsTotal = calculateAdditionals();

      total = hours * rate + additionalsTotal;
    } else if (service === '2') {
      total = getRecordingPrice();
    } else if (service === '3') {
      total = 7500;
    }

    totalCost.value = total.toFixed(2);
    downPayment.value = (total / 2).toFixed(2);
  }


  // Attach listeners
  [startTime, endTime, dateInput].forEach(el => {
    if (el) {
      el.addEventListener('input', calculateTotal);
      el.addEventListener('change', calculateTotal);
    }
  });

  // Trigger calculation on page load in case inputs are pre-filled
  calculateTotal();
});

// ===============================
// FORM VALIDATION (SweetAlert)
// ===============================
document.addEventListener('DOMContentLoaded', () => {
  const reservationForm = document.querySelector('.reservation-form');
  const serviceSelect = document.getElementById('service');

  reservationForm.addEventListener('submit', (e) => {
    const selectedDate = document.getElementById("date").value;
    const start = document.getElementById("startTime").value;
    const end = document.getElementById("endTime").value;
    const service = serviceSelect.value;

    const today = new Date().toISOString().split("T")[0];
    const OPEN = "09:00";
    const CLOSE = "24:00"; // EXACT 12 MN

    // RECORDING MODE VALIDATION
    if (service === '2') { // Recording selected
      const selectedMode = document.querySelector('input[name="recordingMode"]:checked');
      if (!selectedMode) {
        e.preventDefault();
        Swal.fire({
          icon: 'warning',
          title: 'Recording Mode Required',
          text: 'Please select a recording mode before submitting.',
          confirmButtonText: 'OK'
        });
        return;
      }
    }

    // DATE CHECK
    if (selectedDate < today) {
      e.preventDefault();
      Swal.fire({
        icon: 'error',
        title: 'Invalid Date',
        html: `You cannot select a past date.`,
        confirmButtonText: 'OK'
      });
      return;
    }

    // TIME CHECK (Studio & Recording)
    if (["1", "2"].includes(serviceSelect.value)) {
      if (start < OPEN || end > CLOSE) {
        e.preventDefault();
        Swal.fire({
          icon: 'error',
          title: 'Invalid Time Selection',
          html: `Operating Hours:<br> <b>9:00 AM – 12:00 MN</b>`,
          confirmButtonText: 'OK'
        });
        return;
      }
    }

    // Submit via AJAX
    e.preventDefault();

    const formData = new FormData(reservationForm);

    formData.set('startTime', document.getElementById('startTime').value + ":00");
    formData.set('endTime', document.getElementById('endTime').value + ":00");
    
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
          }).then(() => window.location.href = 'customer-dashboard.php');

        } else {
          Swal.fire({
            icon: 'error',
            title: 'Reservation Failed',
            text: data.message || 'Something went wrong.',
            confirmButtonText: 'OK'
          });
        }
      })
      .catch(err => {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Could not process reservation.',
          confirmButtonText: 'OK'
        });
      });
  });
});
