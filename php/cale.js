const daysOfWeek = ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"];
const calendarElement = document.getElementById('calendar');
const monthTitle = document.getElementById('month-title');
const daysContainer = document.getElementById('days');
const prevMonthButton = document.getElementById('prev-month');
const nextMonthButton = document.getElementById('next-month');

const eventPopup = document.getElementById('event-popup');
const popupCloseButton = document.getElementById('popup-close');
const popupTitle = document.getElementById('popup-title');
const popupInfo = document.getElementById('popup-info');

let currentDate = new Date();
let events = [];

async function fetchEvents(month, year) {
  try {
    const response = await fetch(`getEvents.php?month=${month + 1}&year=${year}`);  // +1 para ajustar el mes (1-12)
    const data = await response.json();
    events = data;
    renderCalendar();
  } catch (error) {
    console.error('Error fetching events:', error);
  }
}

function renderCalendar() {
  const year = currentDate.getFullYear();
  const month = currentDate.getMonth();

  // Mostrar el mes y el año en el título
  monthTitle.textContent = `${getMonthName(month)} ${year}`;

  // Limpiar los días previos
  daysContainer.innerHTML = '';

  // Obtener el primer día del mes
  const firstDayOfMonth = new Date(year, month, 1);
  const lastDayOfMonth = new Date(year, month + 1, 0);
  const totalDaysInMonth = lastDayOfMonth.getDate();

  // Determinar el día de la semana en que empieza el mes
  const firstDayOfWeek = firstDayOfMonth.getDay();

  // Agregar días vacíos para el inicio del mes
  for (let i = 0; i < firstDayOfWeek; i++) {
    const emptyCell = document.createElement('div');
    emptyCell.classList.add('empty');
    daysContainer.appendChild(emptyCell);
  }

  // Agregar los días del mes
  for (let day = 1; day <= totalDaysInMonth; day++) {
    const dayCell = document.createElement('div');
    dayCell.textContent = day;

    // Verificar si hay un evento para ese día
    const event = events.find(e => new Date(e.date).getDate() === day && new Date(e.date).getMonth() === month);
    if (event) {
      dayCell.classList.add('event-day');
      dayCell.addEventListener('click', () => showEventPopup(event));
    }

    daysContainer.appendChild(dayCell);
  }
}

function getMonthName(monthIndex) {
  const months = [
    "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
    "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
  ];
  return months[monthIndex];
}

function showEventPopup(event) {
  popupTitle.textContent = event.title;
  popupInfo.textContent = event.info;
  eventPopup.style.display = 'flex';
}

popupCloseButton.addEventListener('click', () => {
  eventPopup.style.display = 'none';
});

// Manejar el cambio de mes
prevMonthButton.addEventListener('click', () => {
  currentDate.setMonth(currentDate.getMonth() - 1);
  fetchEvents(currentDate.getMonth(), currentDate.getFullYear());
});

nextMonthButton.addEventListener('click', () => {
  currentDate.setMonth(currentDate.getMonth() + 1);
  fetchEvents(currentDate.getMonth(), currentDate.getFullYear());
});

// Inicializar el calendario
fetchEvents(currentDate.getMonth(), currentDate.getFullYear());
