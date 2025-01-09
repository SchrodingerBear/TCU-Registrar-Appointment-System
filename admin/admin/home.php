<?php
$qry = $conn->query("SELECT * FROM `schedule_settings`");
$meta = array_column($qry->fetch_all(MYSQLI_ASSOC),'meta_value','meta_field');
?>

<h1 class="text-light">Welcome to <?php echo $_settings->info('name') ?></h1>
<?php
$sched_arr = array();
?>
<hr>
<div class="container">
    <div class="card">
        <div class="card-body">
                <div id="calendar"></div>
        </div>
    </div>
</div>
<style>
        .fc-event:hover, .fc-event-selected {
                color: black !important;
        }
        a.fc-list-day-text {
                color: black !important;
        }
        .fc-event:hover, .fc-event-selected {
                color: black !important;
                background: var(--light);
                cursor: pointer;
        }
</style>
<?php
$sched_query = $conn->query("SELECT a.*,p.name FROM `appointments` a inner join `patient_list` p on a.patient_id = p.id");
$sched_arr = json_encode($sched_query->fetch_all(MYSQLI_ASSOC));
$schedule_settings = json_encode($meta);
?>
<script>
    $(function(){
        $('.select2').select2()
        var Calendar = FullCalendar.Calendar;
        var date = new Date()
        var d    = date.getDate(),
            m    = date.getMonth(),
            y    = date.getFullYear()
        var scheds = $.parseJSON('<?php echo ($sched_arr) ?>');
        var scheduleSettings = $.parseJSON('<?php echo ($schedule_settings) ?>');

        var calendarEl = document.getElementById('calendar');

        var calendar = new Calendar(calendarEl, {
            initialView: "dayGridMonth",
            headerToolbar: {
                right: "dayGridWeek,dayGridMonth,listDay prev,next"
            },
            buttonText: {
                dayGridWeek: "Week",
                dayGridMonth: "Month",
                listDay: "Day",
                listWeek: "Week",
            },
            themeSystem: 'bootstrap',
            events: function(event, successCallback) {
                var events = [];
                Object.keys(scheds).map(k => {
                    var bg = 'var(--primary)';
                    if (scheds[k].status == 0)
                        bg = 'var(--primary)';
                    if (scheds[k].status == 1)
                        bg = 'var(--success)';
                    events.push({
                        id: scheds[k].id,
                        title: scheds[k].name,
                        start: moment(scheds[k].date_sched).format('YYYY-MM-DD[T]HH:mm'),
                        backgroundColor: bg,
                        borderColor: bg,
                    });
                });

                // Add unavailable dates and holidays
                var unavailableDates = scheduleSettings.holiday_schedule.split(',');
                unavailableDates.forEach(date => {
                    events.push({
                        title: 'Holiday',
                        start: date,
                        backgroundColor: 'var(--danger)',
                        borderColor: 'var(--danger)',
                        rendering: 'background'
                    });
                });

                // Add "Appointment Available" for all allowed days without appointments
                var allowedDays = scheduleSettings.day_schedule.split(',');
                var currentMonth = moment().month();
                var currentYear = moment().year();
                var daysInMonth = moment().daysInMonth();

                for (var day = 1; day <= daysInMonth; day++) {
                    var date = moment([currentYear, currentMonth, day]);
                    var dayName = date.format('dddd');
                    if (allowedDays.includes(dayName)) {
                        var isHoliday = unavailableDates.includes(date.format('YYYY-MM-DD'));
                        if (!isHoliday) {
                            var hasAppointment = scheds.some(sched => moment(sched.date_sched).isSame(date, 'day'));
                            if (!hasAppointment) {
                                events.push({
                                    title: 'Appointment Available',
                                    start: date.format('YYYY-MM-DD'),
                                    backgroundColor: 'var(--success)',
                                    borderColor: 'var(--success)',
                                    rendering: 'background'
                                });
                            }
                        }
                    } else {
                        events.push({
                            title: dayName + ' is not Available',
                            start: date.format('YYYY-MM-DD'),
                            backgroundColor: 'var(--warning)',
                            borderColor: 'var(--warning)',
                            rendering: 'background'
                        });
                    }
                }

                successCallback(events);
            },
            eventClick: (info) => {
                if (info.event.extendedProps.rendering !== 'background') {
                    uni_modal("Appointment Details", "appointments/view_details.php?id=" + info.event.id)
                }
            },
            editable: false,
            selectable: true,
            selectAllow: function(select) {
                var dayName = moment(select.start).format('dddd');
                var allowedDays = scheduleSettings.day_schedule.split(',');
                if (moment().subtract(1, 'day').diff(select.start) < 0 && allowedDays.includes(dayName)) {
                    return true;
                } else {
                    return false;
                }
            }
        });

        calendar.render();
        $('#location').change(function() {
            location.href = "./?lid=" + $(this).val();
        })
    })
</script>
