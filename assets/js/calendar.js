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

  function formatLocalDate(d) {
    return `${d.getFullYear()}-${String(d.getMonth()+1).padStart(2,'0')}-${String(d.getDate()).padStart(2,'0')}`;
  }

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

      cell.textContent = dayDate.getDate();

      const today = new Date();
      cell.classList.toggle("active-date", dayDate.toDateString() === today.toDateString());
      cell.classList.toggle("text-muted", dayDate.getMonth() !== month);
    }

    // Time slots (00:00–23:00)
    const times = [];
    for (let hour = 9; hour <= 23; hour++) {
      times.push(`${String(hour).padStart(2,'0')}:00:00`);
    }

    calendarBody.innerHTML = "";

    times.forEach(time => {
      const row = document.createElement("tr");

      const timeCell = document.createElement("th");
      timeCell.textContent = time.slice(0,5); // display HH:MM
      row.appendChild(timeCell);

      for (let i = 0; i < 7; i++) {
        const cell = document.createElement("td");
        cell.classList.add("time-slot");
        cell.dataset.date = formatLocalDate(weekDates[i]);
        cell.dataset.time = time;
        row.appendChild(cell);
      }

      calendarBody.appendChild(row);
    });

    // Fetch reservations
    const startDate = formatLocalDate(weekDates[0]);
    const endDate = formatLocalDate(weekDates[6]);

    try {
      const response = await fetch(`process/FetchReservationProcess.php?start=${startDate}&end=${endDate}`);
      const result = await response.json();
      const reservations = result.data || result;

      reservations.forEach(res => {
        const { date, startTime, endTime, serviceName, statusName } = res;

        const start = new Date(`${date}T${startTime}`);
        const end = new Date(`${date}T${endTime}`);
        const duration = Math.ceil((end - start) / (1000 * 60 * 60));

        const startCell = calendarBody.querySelector(
          `td[data-date='${date}'][data-time='${startTime}']`
        );
        if (!startCell) return;

        const block = document.createElement("div");
        block.classList.add("reservation", "bg-primary", "text-white", "rounded", "p-1", "small");
        const textDiv = document.createElement("div");
        textDiv.classList.add("text-container");
        textDiv.textContent = `${serviceName} (${statusName})`;

        block.appendChild(textDiv);



                // Assign color based on status
        switch(statusName.toLowerCase()) {
            case "confirmed":
                block.classList.add("bg-success", "text-white"); // green
                break;
            case "pending":
                block.classList.add("bg-warning", "text-dark"); // yellow
                break;
            case "cancelled":
                block.classList.add("bg-danger", "text-white"); // red
                break;
            default:
                block.classList.add("bg-primary", "text-white"); // blue as default
                break;
        }


        startCell.appendChild(block);
        startCell.style.position = "relative";
        block.style.position = "absolute";
        block.style.top = "2px";
        block.style.left = "2px";
        block.style.right = "2px";
        block.style.bottom = "2px";
        block.style.height = `${duration * 100}%`;
        block.style.zIndex = "5";

        const startHour = parseInt(startTime.split(":")[0], 10);
        for (let h = 1; h < duration; h++) {
          const nextHour = `${String(startHour + h).padStart(2,'0')}:00:00`;
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
  prevYear.addEventListener("click", () => { currentDate.setFullYear(currentDate.getFullYear() - 1); renderWeek(); });
  nextYear.addEventListener("click", () => { currentDate.setFullYear(currentDate.getFullYear() + 1); renderWeek(); });
  prevWeek.addEventListener("click", () => { currentDate.setDate(currentDate.getDate() - 7); renderWeek(); });
  nextWeek.addEventListener("click", () => { currentDate.setDate(currentDate.getDate() + 7); renderWeek(); });
  monthSelect.addEventListener("change", () => { currentDate.setMonth(parseInt(monthSelect.value, 10)); renderWeek(); });

  renderWeek();
});
