document.addEventListener('DOMContentLoaded', () => {
    const serviceSelect = document.getElementById('service');
    const dateInput = document.getElementById('date');
    const timeInput = document.getElementById('startTime');
    const sessionsList = document.getElementById('drumlesson-sessions-list');
    const sessionsInputs = document.getElementById('drumlesson-sessions-inputs');
    const totalCost = document.getElementById('totalCost');
    const downPayment = document.getElementById('downPayment');

    const drumFixedTotal = 7500; // total for 12 sessions
    const sessionDurationHours = 2; // 2 hours per session
    const totalSessions = 12;

    function generateDrumSessions() {
        if (serviceSelect.value != '3') {
            sessionsList.innerHTML = '';
            sessionsInputs.innerHTML = '';
            totalCost.value = '';
            downPayment.value = '';
            return;
        }

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

        for (let i = 0; i < totalSessions; i++) {
            const sessionStart = new Date(startDate);
            sessionStart.setDate(sessionStart.getDate() + i * 7);
            const sessionEnd = new Date(sessionStart);
            sessionEnd.setHours(sessionEnd.getHours() + sessionDurationHours);

            const li = document.createElement('li');
            li.innerHTML = `<strong>Session ${i + 1}: </strong><span>${sessionStart.toLocaleDateString('en-PH')} ` +
                `${sessionStart.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })} - ` +
                `${sessionEnd.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>`;
            sessionsList.appendChild(li);


            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'drumlessonSessions[]';
            input.value = `${sessionStart.toISOString()}|${sessionEnd.toISOString()}`;
            sessionsInputs.appendChild(input);
        }
    }

    [serviceSelect, dateInput, timeInput].forEach(el => {
        if (el) el.addEventListener('change', generateDrumSessions);
    });

    generateDrumSessions();
});
