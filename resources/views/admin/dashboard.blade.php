@extends('adminlte::page')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center" style="height: 80vh; background: url('{{ asset('images/fondo6.jpg') }}') no-repeat center center fixed; background-size: cover;">
        
        <!-- Welcome Message -->
        <div class="content mt-5 text-light">
            <h2>Bienvenido a Body Iron Fitness</h2>
        </div>

        <!-- Display Date and Time -->
        <div id="datetime" class="text-light mb-4" style="font-size: 1.5em;">
            <!-- Date and Time will be shown here dynamically -->
        </div>
        <!-- Footer -->
        <footer class="text-center mt-5">
            <p>&copy; 2024 Body Iron Fitness - Todos los derechos reservados</p>
        </footer>

    <script>
        let currentYear = new Date().getFullYear();
        let currentMonth = new Date().getMonth();

        function updateDateTime() {
            const now = new Date();
            const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit' };
            document.getElementById('datetime').innerHTML = `${now.toLocaleDateString('es-ES', dateOptions)} - ${now.toLocaleTimeString('es-ES', timeOptions)}`;
        }

        function generateCalendar(year, month) {
            document.getElementById('monthSelect').value = month;
            document.getElementById('currentYear').innerText = year;

            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            let day = 1;
            let calendarBody = '';
            for (let i = 0; i < 6; i++) {
                let row = '<tr>';
                for (let j = 0; j < 7; j++) {
                    if (i === 0 && j < firstDay) {
                        row += '<td></td>';  // Empty cells before the 1st day
                    } else if (day <= daysInMonth) {
                        row += `<td ${day === new Date().getDate() && year === new Date().getFullYear() && month === new Date().getMonth() ? 'class="bg-primary"' : ''}>${day}</td>`;
                        day++;
                    } else {
                        row += '<td></td>';
                    }
                }
                row += '</tr>';
                calendarBody += row;
            }
            document.getElementById('calendarBody').innerHTML = calendarBody;
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateDateTime();
            generateCalendar(currentYear, currentMonth);
            setInterval(updateDateTime, 1000);

            document.getElementById('monthSelect').addEventListener('change', function() {
                currentMonth = parseInt(this.value);
                generateCalendar(currentYear, currentMonth);
            });

            document.getElementById('prevYear').addEventListener('click', function() {
                currentYear--;
                generateCalendar(currentYear, currentMonth);
            });

            document.getElementById('nextYear').addEventListener('click', function() {
                currentYear++;
                generateCalendar(currentYear, currentMonth);
            });
        });
    </script>

    
@stop
