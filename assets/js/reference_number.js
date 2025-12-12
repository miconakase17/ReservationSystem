document.addEventListener('DOMContentLoaded', () => {
  const reservationForm = document.querySelector('.reservation-form');
  const paymentMethod = document.getElementById('paymentMethod');
  const referenceNumber = document.getElementById('referenceNumber');

  if (reservationForm && paymentMethod && referenceNumber) {

    // Set placeholder on page load & change
    function updatePlaceholder() {
      if (paymentMethod.value === 'Gcash') {
        referenceNumber.placeholder = 'xxxx-xxx-xxxxx';
        referenceNumber.maxLength = 13; // 4+1+3+1+5 = 13 chars
      } else {
        referenceNumber.placeholder = 'xxxxxx';
        referenceNumber.maxLength = 6;
      }
      referenceNumber.value = ''; // optional: clear input when changing method
    }

    paymentMethod.addEventListener('change', updatePlaceholder);
    updatePlaceholder();

    // Auto-format & restrict input
    referenceNumber.addEventListener('input', () => {
      if (paymentMethod.value === 'Gcash') {
        let val = referenceNumber.value.replace(/\D/g, ''); // digits only
        if (val.length > 4) val = val.slice(0, 4) + '-' + val.slice(4);
        if (val.length > 8) val = val.slice(0, 8) + '-' + val.slice(8, 13);
        referenceNumber.value = val;
      } else {
        // Other payment methods: digits only, max 6
        referenceNumber.value = referenceNumber.value.replace(/\D/g, '');
        if (referenceNumber.value.length > 6) {
          referenceNumber.value = referenceNumber.value.slice(0, 6);
        }
      }
    });

    // Validation on submit
    reservationForm.addEventListener('submit', (e) => {
      const method = paymentMethod.value;
      const ref = referenceNumber.value.trim();

      const gcashPattern = /^\d{4}-\d{3}-\d{5}$/;
      const otherPattern = /^\d{6}$/;

      if (method === 'Gcash') {
        if (!gcashPattern.test(ref)) {
          e.preventDefault();
          Swal.fire({
            icon: 'error',
            title: 'Invalid Reference Number',
            text: 'For GCash, the reference number must be in the format xxxx-xxx-xxxxx',
          });
          referenceNumber.focus();
        }
      } else {
        if (!otherPattern.test(ref)) {
          e.preventDefault();
          Swal.fire({
            icon: 'error',
            title: 'Invalid Reference Number',
            text: 'For selected payment method, the reference number must be 6 digits',
          });
          referenceNumber.focus();
        }
      }
    });
  }
});
