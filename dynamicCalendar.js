const monthYear = document.getElementById("monthYear");
const calendarDays = document.getElementById("calendarDays");
const prevMonthBtn = document.getElementById("prevMonthBtn");
const nextMonthBtn = document.getElementById("nextMonthBtn");

let currentDate = new Date();
const currentYear = new Date().getFullYear();

const holidays = {
  [`${currentYear}-01-01`]: "New Year's Day",
  [`${currentYear}-02-25`]: "EDSA People Power Revolution",
  [`${currentYear}-04-09`]: "Araw ng Kagitingan",
  [`${currentYear}-05-01`]: "Labor Day",
  [`${currentYear}-06-12`]: "Independence Day",
  [`${currentYear}-08-21`]: "Ninoy Aquino Day",
  [`${currentYear}-11-01`]: "All Saints' Day",
  [`${currentYear}-11-30`]: "Bonifacio Day",
  [`${currentYear}-12-25`]: "Christmas Day",
  [`${currentYear}-12-30`]: "Rizal Day",
};

// ✅ Calculate Holy Week Dates (Fixed)
function calculateHolyWeek(year) {
  const a = year % 19;
  const b = Math.floor(year / 100);
  const c = year % 100;
  const d = Math.floor(b / 4);
  const e = b % 4;
  const f = Math.floor((b + 8) / 25);
  const g = Math.floor((b - f + 1) / 3);
  const h = (19 * a + b - d - g + 15) % 30;
  const i = Math.floor(c / 4);
  const k = c % 4;
  const l = (32 + 2 * e + 2 * i - h - k) % 7;
  const m = Math.floor((a + 11 * h + 22 * l) / 451);
  const month = Math.floor((h + l - 7 * m + 114) / 31); // March or April
  const day = ((h + l - 7 * m + 114) % 31) + 1; // Easter Sunday

  // ✅ Get Easter Sunday Date (Corrected)
  const easterSunday = new Date(year, month - 1, day);

  // ✅ Correct subtraction for Maundy Thursday (-3 days)
  const maundyThursday = new Date(easterSunday);
  maundyThursday.setDate(easterSunday.getDate() - 2);

  // ✅ Correct subtraction for Good Friday (-2 days)
  const goodFriday = new Date(easterSunday);
  goodFriday.setDate(easterSunday.getDate() - 1);

  // ✅ Store Correct Dates
  holidays[maundyThursday.toISOString().split("T")[0]] = "Maundy Thursday";
  holidays[goodFriday.toISOString().split("T")[0]] = "Good Friday";
}

// ✅ Calculate Holy Week for the Current Year
calculateHolyWeek(currentYear);

function renderCalendar() {
  const month = currentDate.getMonth();
  const year = currentDate.getFullYear();

  // Set the month-year title
  monthYear.textContent = `${currentDate.toLocaleString("default", {
    month: "long",
  })} ${year}`;

  // Get the first and last day of the month
  const firstDayOfMonth = new Date(year, month, 1).getDay();
  const lastDateOfMonth = new Date(year, month + 1, 0).getDate();

  // Get the last date of the previous month
  const lastDateOfPrevMonth = new Date(year, month, 0).getDate();

  // Clear previous dates
  calendarDays.innerHTML = "";

  // Days from previous month
  for (let i = firstDayOfMonth; i > 0; i--) {
    const day = document.createElement("div");
    day.classList.add("day", "prev-month");
    day.textContent = lastDateOfPrevMonth - i + 1;
    calendarDays.appendChild(day);
  }

  // Current month days
  for (let i = 1; i <= lastDateOfMonth; i++) {
    const day = document.createElement("div");
    day.classList.add("day");

    const dateStr = `${year}-${(month + 1).toString().padStart(2, "0")}-${i
      .toString()
      .padStart(2, "0")}`;

    // ✅ Add day number
    const dateSpan = document.createElement("span");
    dateSpan.textContent = i;
    day.appendChild(dateSpan);

    // ✅ Highlight today's date
    if (
      i === new Date().getDate() &&
      month === new Date().getMonth() &&
      year === new Date().getFullYear()
    ) {
      day.classList.add("today");
    }

    // ✅ Highlight paydays (8th & 20th)
    if (i === 5 || i === 20) {
      day.classList.add("payday");
      const paydayText = document.createElement("div");
      paydayText.textContent = "💰 Payday!";
      paydayText.classList.add("event-text");
      day.appendChild(paydayText);
    }

    // ✅ Highlight holidays with names
    if (holidays[dateStr]) {
      day.classList.add("holiday");
      const holidayText = document.createElement("div");
      holidayText.textContent = `🎉 ${holidays[dateStr]}`;
      holidayText.classList.add("event-text");
      day.appendChild(holidayText);
    }

    calendarDays.appendChild(day);
  }

  // Next month days to fill calendar (if needed)
  const totalDays = firstDayOfMonth + lastDateOfMonth;
  const nextDays = 7 - (totalDays % 7);

  for (let i = 1; i < nextDays; i++) {
    const day = document.createElement("div");
    day.classList.add("day", "next-month");
    day.textContent = i;
    calendarDays.appendChild(day);
  }
}

// Event listeners for month navigation
prevMonthBtn.addEventListener("click", () => {
  currentDate.setMonth(currentDate.getMonth() - 1);
  renderCalendar();
});

nextMonthBtn.addEventListener("click", () => {
  currentDate.setMonth(currentDate.getMonth() + 1);
  renderCalendar();
});

// Initialize calendar
renderCalendar();
