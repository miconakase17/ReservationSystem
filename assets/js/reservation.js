// Show/hide studio fields based on service selection
  const serviceSelect = document.getElementById('service');
  const studioFields = document.getElementById('studio-fields');
  const inputs = studioFields.querySelectorAll('input');

  serviceSelect.addEventListener('change', function () {
    if (this.value === 'Studio Rental') {
      studioFields.style.display = 'flex';   // or 'block'
      inputs.forEach(input => input.required = true);
    } else {
      studioFields.style.display = 'none';
      inputs.forEach(input => input.required = false);
    }
  });

