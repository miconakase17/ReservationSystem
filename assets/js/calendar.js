document.addEventListener("DOMContentLoaded", function () {
  const monthSelect = document.getElementById("monthSelect");
  const yearLabel = document.getElementById("yearLabel");
  const prevYear = document.getElementById("prevYear");
  const nextYear = document.getElementById("nextYear");
  const prevWeek = document.getElementById("prev");
  const nextWeek = document.getElementById("next");
  const calendarBody = document.getElementById("calendar-body");
  const weekDatesRow = document.getElementById("weekDatesRow").children;

  let currentDate = new Date();

  async function renderWeek() {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    yearLabel.textContent = year;
    monthSelect.value = month.toString();

    // Find Sunday of current week
    const startOfWeek = new Date(currentDate);
    startOfWeek.setDate(currentDate.getDate() - currentDate.getDay());

    const weekDates = [];
    for (let i = 1; i < 8; i++) {
      const cell = weekDatesRow[i];
      const dayDate = new Date(startOfWeek);
      dayDate.setDate(startOfWeek.getDate() + (i - 1));
      cell.textContent = dayDate.getDate();
      weekDates.push(dayDate);

      const today = new Date();
      cell.classList.toggle(
        "active-date",
        dayDate.toDateString() === today.toDateString()
      );
      cell.classList.toggle(
        "text-muted",
        dayDate.getMonth() !== month
      );
    }

    // Define exact hourly slots
    const times = [];
    for (let hour = 9; hour <= 23; hour++) {
      const h = hour.toString().padStart(2, "0");
      times.push(`${h}:00:00`);
    }

    calendarBody.innerHTML = "";

    times.forEach(time => {
      const row = document.createElement("tr");

      const timeCell = document.createElement("th");
      timeCell.textContent = new Date(`1970-01-01T${time}`)
        .toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' });
      row.appendChild(timeCell);

      for (let i = 0; i < 7; i++) {
        const cell = document.createElement("td");
        cell.classList.add("time-slot");
        cell.dataset.date = weekDates[i].toISOString().split("T")[0];
        cell.dataset.time = time;
        row.appendChild(cell);
      }

      calendarBody.appendChild(row);
    });

    // Fetch reservations
    const startDate = weekDates[0].toISOString().split("T")[0];
    const endDate = weekDates[6].toISOString().split("T")[0];

    try {
      const response = await fetch(`process/FetchReservationProcess.php?start=${startDate}&end=${endDate}`);
      const result = await response.json();
      const reservations = result.data || result;

      console.log("Fetched reservations:", reservations); // ✅ Add this line

      reservations.forEach(res => {
        const { date, startTime, endTime, serviceName, statusName} = res;

        const start = new Date(`1970-01-01T${startTime}`);
        const end = new Date(`1970-01-01T${endTime}`);
        const duration = Math.ceil((end - start) / (1000 * 60 * 60)); // in hours

        // Find start cell
        const startCell = calendarBody.querySelector(
          `td[data-date='${date}'][data-time='${startTime}']`
        );
        if (!startCell) return;

        // Create reservation block
        const block = document.createElement("div");
        block.classList.add("reservation", "bg-primary", "text-white", "rounded", "p-1", "small");
        block.textContent = `${serviceName}  (${statusName})`;

        // Merge vertically by spanning multiple hours
        startCell.appendChild(block);
        startCell.style.position = "relative";
        block.style.position = "absolute";
        block.style.top = "0";
        block.style.left = "0";
        block.style.right = "0";
        block.style.height = `${duration * 100}%`; // each slot = 1 unit height
        block.style.zIndex = "5";

        // Hide subsequent time cells in same column (merge effect)
        for (let h = 1; h < duration; h++) {
          const nextHour = (startHour + h).toString().padStart(2, "0") + ":00:00";
          const nextCell = calendarBody.querySelector(
            `td[data-date='${date}'][data-time='${nextHour}']`
          );
          if (nextCell) nextCell.style.visibility = "hidden";
        }
      });

    } catch (error) {
      console.error("Error fetching reservations:", error);
    }
  }

  // Navigation
  prevYear.addEventListener("click", () => {
    currentDate.setFullYear(currentDate.getFullYear() - 1);
    renderWeek();
  });
  nextYear.addEventListener("click", () => {
    currentDate.setFullYear(currentDate.getFullYear() + 1);
    renderWeek();
  });
  prevWeek.addEventListener("click", () => {
    currentDate.setDate(currentDate.getDate() - 7);
    renderWeek();
  });
  nextWeek.addEventListener("click", () => {
    currentDate.setDate(currentDate.getDate() + 7);
    renderWeek();
  });
  monthSelect.addEventListener("change", () => {
    currentDate.setMonth(parseInt(monthSelect.value, 10));
    renderWeek();
  });

  renderWeek();
});
