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
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<div class="content">
    <div class="container-fluid">
        <?php
        if (!isset($_POST['submit'])) {
        ?>
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
