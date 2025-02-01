document.addEventListener("DOMContentLoaded", function () {
    const monthYearElement = document.getElementById('month-year');
    const calendarTable = document.getElementById('calendar-table');

    const months = [
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];

    const events = {
        '2024-06': [
            { date: '2024-06-28', event: '8:00 AM - 5:00 PM<br>Social Pension Program for Indigent Senior Citizens' },
            { date: '2024-06-29', event: '8:00 AM - 5:00 PM<br>Social Pension Program for Indigent Senior Citizens' },
            { date: '2024-06-07', event: '8:00 AM - 5:00 PM<br>Satellite registration of Voters: Rosario' },
            { date: '2024-06-08', event: '8:00 AM - 5:00 PM<br>Satellite Registration of Voters: Sampaguita' },
            { date: '2024-06-15', event: '8:00 AM - 5:00 PM<br>Satellite registration for Voters: Brgy. Landayan' },
            { date: '2024-06-19', event: 'Satellite registration for Voters: SM San pedro' },
            { date: '2024-06-22', event: '8:00 AM - 5:00 PM<br>Satellite registration for Voters: Brgy pacita 2' },
            { date: '2024-06-28', event: '8:00 AM - 5:00 PM<br>Satellite Registration for Voters: Sto. Nino<br>San Vicente/Sito bayan bayanan' }
        ]
    };

    let currentYear = 2024;
    let currentMonth = 5; // June is the 5th index (0-based index)

    function loadCalendar(year, month) {
        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        monthYearElement.textContent = `${months[month]} ${year}`;

        let tableHTML = '<thead><tr>';
        tableHTML += '<th>MON</th><th>TUE</th><th>WED</th><th>THU</th><th>FRI</th><th>SAT</th><th>SUN</th>';
        tableHTML += '</tr></thead><tbody>';

        let day = 1;
        for (let i = 0; i < 6; i++) {
            tableHTML += '<tr>';
            for (let j = 0; j < 7; j++) {
                if (i === 0 && j < firstDay) {
                    tableHTML += '<td class="inactive"></td>';
                } else if (day > daysInMonth) {
                    tableHTML += '<td class="inactive"></td>';
                } else {
                    const fullDate = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                    const eventHTML = events[`${year}-${String(month + 1).padStart(2, '0')}`]?.find(e => e.date === fullDate)?.event || '';
                    tableHTML += `<td>${day}<br><span>${eventHTML}</span></td>`;
                    day++;
                }
            }
            tableHTML += '</tr>';
        }
        tableHTML += '</tbody>';

        calendarTable.innerHTML = tableHTML;
    }

    document.getElementById('next').addEventListener('click', () => {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        loadCalendar(currentYear, currentMonth);
    });

    document.getElementById('prev').addEventListener('click', () => {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        loadCalendar(currentYear, currentMonth);
    });

    loadCalendar(currentYear, currentMonth);
});