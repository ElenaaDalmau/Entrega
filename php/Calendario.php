<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario de Citas</title>
    <style>
        /* Estilos para el calendario */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        #calendar {
            width: 300px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background-color: white;
            padding: 20px;
            text-align: center;
        }

        #month-title {
            font-size: 20px;
            margin-bottom: 20px;
        }

        .days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
            text-align: center;
        }

        .days div {
            padding: 10px;
            cursor: pointer;
        }

        .days .empty {
            visibility: hidden;
        }

        .days .event-day {
            background-color: #f39c12;
            color: white;
            border-radius: 50%;
            cursor: pointer;
        }

        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 100;
            width: 300px;
            text-align: center;
        }

        .popup button {
            margin-top: 10px;
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 8px;
            border-radius: 5px;
            cursor: pointer;
        }

        .popup button:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>

    <!-- Calendario -->
    <div id="calendar">
        <div id="month-title"></div>
        <div class="days" id="days"></div>
        <button id="prev-month">Anterior</button>
        <button id="next-month">Siguiente</button>
    </div>

    <!-- Pop-up -->
    <div class="popup" id="event-popup">
        <h3 id="popup-title"></h3>
        <p id="popup-info"></p>
        <button id="popup-close">Cerrar</button>
    </div>

    <!-- JavaScript -->
    <script>
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
        const dniCliente = '12345678A'; 
        async function fetchEvents(month, year, dni) {
          try {
            const response = await fetch(`getEvents.php?month=${month + 1}&year=${year}`); // +1 para ajustar el mes (1-12)
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
          fetchEvents(currentDate.getMonth(), currentDate.getFullYear(), dniCliente);
        });

        nextMonthButton.addEventListener('click', () => {
          currentDate.setMonth(currentDate.getMonth() + 1);
          fetchEvents(currentDate.getMonth(), currentDate.getFullYear(), dniCliente);
        });

        // Inicializar el calendario
        fetchEvents(currentDate.getMonth(), currentDate.getFullYear(), dniCliente);
    </script>
</body>
</html>
