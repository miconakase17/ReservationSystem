document.addEventListener('DOMContentLoaded', () => {
    const serviceSelect = document.getElementById('service');
    const dateInput = document.getElementById('drumlesson-start-date');
    const timeInput = document.getElementById('drumlesson-start-time');
    const sessionsList = document.getElementById('drumlesson-sessions-list');
    const sessionsInputs = document.getElementById('drumlesson-sessions-inputs');
    const totalCost = document.getElementById('totalCost');
    const downPayment = document.getElementById('downPayment');

    const drumFixedTotal = 7500; // total for 12 sessions
    const sessionDurationHours = 2; // each session is 2 hours
    const totalSessions = 12;

    function generateDrumSessions() {
        if (serviceSelect.value !== '3') {
            // clear sessions and totals if not drum lesson
            sessionsList.innerHTML = '';
            sessionsInputs.innerHTML = '';
            totalCost.value = '';
            downPayment.value = '';
            return;
        }

        // Set the totals immediately (even if date/time not selected yet)
        totalCost.value = drumFixedTotal.toFixed(2);
        downPayment.value = (drumFixedTotal / 2).toFixed(2);

        const startDateStr = dateInput.value;
        const startTimeStr = timeInput.value;

        if (!startDateStr || !startTimeStr) return;

        sessionsList.innerHTML = '';
        sessionsInputs.innerHTML = '';

        const [hour, minute] = startTimeStr.split(':').map(Number);
        const startDate = new Date(startDateStr);
        startDate.setHours(hour, minute, 0, 0);

        const endTimeInput = document.getElementById('endTime');
        if (endTimeInput) {
            const endDate = new Date(startDate);
            endDate.setHours(endDate.getHours() + sessionDurationHours);
            endTimeInput.value = `${String(endDate.getHours()).padStart(2, '0')}:${String(endDate.getMinutes()).padStart(2, '0')}`;
        }

        for (let i = 0; i < totalSessions; i++) {
            const sessionStart = new Date(startDate);
            sessionStart.setDate(sessionStart.getDate() + i * 7);
            const sessionEnd = new Date(sessionStart);
            sessionEnd.setHours(sessionEnd.getHours() + sessionDurationHours);

            // Display session
            const li = document.createElement('li');
            li.textContent = sessionStart.toLocaleDateString('en-PH', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) +
                ` ${sessionStart.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })} - ` +
                `${sessionEnd.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}`;
            sessionsList.appendChild(li);

            // Hidden input for form submission
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'drumlessonSessions[]';
            input.value = `${sessionStart.toISOString()}|${sessionEnd.toISOString()}`;
            sessionsInputs.appendChild(input);
        }
    }

    

    // Event listeners
    [serviceSelect, dateInput, timeInput].forEach(el => {
        if (el) el.addEventListener('change', generateDrumSessions);
    });

    // Initialize on page load
    generateDrumSessions();
});
