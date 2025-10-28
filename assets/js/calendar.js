
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

  function renderWeek() {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    yearLabel.textContent = year;
    monthSelect.value = month.toString();

    // Find Sunday of the current week
    const startOfWeek = new Date(currentDate);
    startOfWeek.setDate(currentDate.getDate() - currentDate.getDay());

    // Fill the week date headers (Sun–Sat)
    for (let i = 1; i < 8; i++) {
      const cell = weekDatesRow[i];
      const dayDate = new Date(startOfWeek);
      dayDate.setDate(startOfWeek.getDate() + (i - 1));

      cell.textContent = dayDate.getDate();

      // Highlight today
      const today = new Date();
      if (
        dayDate.getDate() === today.getDate() &&
        dayDate.getMonth() === today.getMonth() &&
        dayDate.getFullYear() === today.getFullYear()
      ) {
        cell.classList.add("active-date");
      } else {
        cell.classList.remove("active-date");
      }

      // Dim other months
      if (dayDate.getMonth() !== month) {
        cell.classList.add("text-muted");
      } else {
        cell.classList.remove("text-muted");
      }
    }

    // Time slots for the week
    const times = [
      "9:00 AM","10:00 AM","11:00 AM","12:00 NN",
      "1:00 PM","2:00 PM","3:00 PM","4:00 PM",
      "5:00 PM","6:00 PM","7:00 PM","8:00 PM",
      "9:00 PM","10:00 PM","11:00 PM","12:00 MN"
    ];

    calendarBody.innerHTML = "";

    times.forEach(time => {
      const row = document.createElement("tr");

      // First cell = time
      const timeCell = document.createElement("th");
      timeCell.textContent = time;
      row.appendChild(timeCell);

      // 7 days = Sun–Sat
      for (let i = 0; i < 7; i++) {
        const cell = document.createElement("td");
        cell.classList.add("time-slot");
        row.appendChild(cell);
      }

      calendarBody.appendChild(row);
    });
  }

  // Year navigation
  prevYear.addEventListener("click", () => {
    currentDate.setFullYear(currentDate.getFullYear() - 1);
    renderWeek();
  });
  nextYear.addEventListener("click", () => {
    currentDate.setFullYear(currentDate.getFullYear() + 1);
    renderWeek();
  });

  // Week navigation
  prevWeek.addEventListener("click", () => {
    currentDate.setDate(currentDate.getDate() - 7);
    renderWeek();
  });
  nextWeek.addEventListener("click", () => {
    currentDate.setDate(currentDate.getDate() + 7);
    renderWeek();
  });

  // Month selection
  monthSelect.addEventListener("change", () => {
    currentDate.setMonth(parseInt(monthSelect.value, 10));
    renderWeek();
  });

  renderWeek();
});
