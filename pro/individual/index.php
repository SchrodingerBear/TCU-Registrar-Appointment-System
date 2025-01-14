<?php
if (!isset($file_access)) die("Direct File Access Denied");
?>

<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<div class="content">
    <div class="container-fluid">
        <?php
        if (!isset($_POST['submit'])) {
        ?>
                <div class="row">

<?php 
require_once('../admin/config.php');

?>
    <div class="col-lg-12">
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <?php
$qry = $conn->query("SELECT * FROM `schedule_settings`");
$meta = array_column($qry->fetch_all(MYSQLI_ASSOC),'meta_value','meta_field');
?>

<?php
$sched_arr = [];
?>
<div class="card">
<div class="card-body">
    <div id="calendar"></div>
</div>
</div>
<style>
.fc-event-title {
color: black !important;
}
.fc-event:hover, .fc-event-selected {
    color: black !important;
}
a.fc-list-day-text {
    color: black !important;
}
.fc-event:hover, .fc-event-selected {
    color: black !important;
    cursor: pointer;
}
</style>
<?php
$sched_query = $conn->query("SELECT a.*,p.name FROM `appointments` a inner join `patient_list` p on a.patient_id = p.id");
$sched_arr = json_encode($sched_query->fetch_all(MYSQLI_ASSOC));
$schedule_settings = json_encode($meta);
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var Calendar = FullCalendar.Calendar;
    var date = new Date();
    var d = date.getDate(),
        m = date.getMonth(),
        y = date.getFullYear();
    var scheds = JSON.parse('<?php echo $sched_arr ?>');
    var scheduleSettings = JSON.parse('<?php echo $schedule_settings ?>');

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
        events: function(fetchInfo, successCallback) {
            var events = [];
            Object.keys(scheds).forEach(k => {
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

            // Add "Appointment Available" for all allowed days without appointments in all months except the current month
            var allowedDays = scheduleSettings.day_schedule.split(',');
            for (var month = 0; month < 12; month++) {
                if (month === currentMonth) continue; // Skip the current month
                var daysInMonth = moment([currentYear, month]).daysInMonth();

                for (var day = 1; day <= daysInMonth; day++) {
                    var date = moment([currentYear, month, day]);
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
            }

            successCallback(events);
        },
        eventClick: function(info) {
            if (info.event.extendedProps.rendering !== 'background') {
                uni_modal("Appointment Details", "appointments/view_details.php?id=" + info.event.id);
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
    document.getElementById('location').addEventListener('change', function() {
        location.href = "./?lid=" + this.value;
    });
});
</script>

</div>
</div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header alert-success">
                        <h5 class="m-0">Step-by-Step Instructions for Scheduling an Appointment</h5>
                    </div>
                    <div class="card-body">
                        
                        
                        <b>Step 1 Initiate Appointment Creation.</b> <br>
                        Begin by creating a new appointment in this application by selecting “New Appointment.” This will open the appointment scheduling form, where you can begin your Appointment process.
                       <br><br>
                        <b>Step 2: Select Required Documents and Schedule.</b><br>
                        Choose the specific documents you need from the available options, and set your preferred appointment date and time. Select an available schedule that best suits your needs, ensuring it allows adequate time for document processing and preparation.
                        <br><br>
                        <b>Step 3: Download the PDF form below and Complete the Form.</b><br>
                        Download the official request form, which must be filled out accurately and completely. This form is required for submission at the registrar's office, where it will be reviewed and validated by staff to confirm the completeness and accuracy of your records.
                        <br><br>
                        <b>Step 4: Confirm Appointment and Document Pickup.</b><br>
                        After setting up your appointment, the system will confirm an available date and time for you to collect your requested documents.
                        <br><br>
                        <b>Step 5: Collect Documents at Registrar’s Office.</b><br>
                        Once the appointment is finalized and confirmed, proceed to the registrar’s office on the scheduled date and time to collect your documents. Be prepared to present any necessary identification as instructed.
                        <br><br> 
                        To view and schedule appointments, select “New Appointment.” This will display a list of available schedules that you can browse and select for your Appointment. Once an appointment is successfully booked, you can review your complete Appointment history at any time by clicking on “View Appoitnment.” <br><br>
                <a href="./Registrar_Form.pdf" download="Form" class="download-btn">Download Form <i class="fa fa-download"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <?php
        } else {
            $class = $_POST['class'];
            $number = $_POST['number'];
            $schedule_id = $_POST['id'];
            if ($number < 1) die("Invalid Number");
        ?>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header alert-success">
                        <h5 class="m-0">Appointment Preview</h5>
                    </div>
                    <div class="card-body">
                        <div class="callout callout-info">
                            <h5><i class="fas fa-info"></i> <?php echo ucwords($class), " Class"; ?>:</h5>
                            You are about to book <?php echo $number, " Ticket", $number > 1 ? 's' : '', ' for ', getRouteFromSchedule($schedule_id); ?>
                            <br><br>

                            <?php
                                $fee = ($_SESSION['amount'] = getFee($schedule_id, $class));
                                echo $number, " x $", $fee, " = $", ($fee * $number), "<hr/>";
                                $fee = $fee * $number;
                                $amount = intval($fee);
                                $vat = ceil($fee * 0.01);
                                echo "V.A.T Charges = $$vat<br/><br/><hr/>";
                                echo "Total = $", $total = $amount + $vat;
                                $fee = intval($total) . "00";
                                $_SESSION['amount'] = $total;
                                $_SESSION['original'] = $fee;
                                $_SESSION['schedule'] = $schedule_id;
                                $_SESSION['no'] = $number;
                                $_SESSION['class'] = $class;
                            ?>
                        </div>
                        <a href="pay.php">
                            <button onclick="return confirm('You will be directed to make your payment.\nPayment finalizes your booking!')" class="btn btn-primary">Pay Now</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
</div>

<!-- Conditions and Reminders Section -->
<div class="container-fluid mt-4">
    <div class="card">
        <div class="card-header alert-warning">
            <h5 class="m-0">CONDITIONS AND REMINDERS</h5>
        </div>
        <div class="card-body">
            <p>1. Only the owner of the records is allowed to request and claim documents relative to his/her school records. However, request and/or claim of documents by a representative is allowed only upon presentation of the following:</p>
            <ul>
                <li>If representative is an immediate family member: A formal authorization letter duly signed by the owner of the credential(s) and 2 valid IDs of both the owner and the representative.</li>
                <li>If representative is not an immediate family member: A notarized special power of attorney from the owner of the credential(s) and 1 valid ID each for the owner and the representative.</li>
            </ul>
            <p>2. Fill out the request form legibly and completely. Only forms with complete data will be processed.</p>
            <p>3. The university reserves the right to withhold, deny, or cancel any request for document issuance pending submission of all required credentials and academic requirements.</p>
            <p>4. The registrar’s staff will inform you through call or text of any deficiency in requirements/credentials. You may also contact our office at 0961 887 2644.</p>
            <p>5. Documents not claimed after sixty (60) days will be destroyed.</p>
        </div>
    </div>
</div>

</body>
</html>
