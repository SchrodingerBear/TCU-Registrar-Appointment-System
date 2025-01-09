<?php 
require_once('../config.php');
$qry3 = $conn->query("SELECT * FROM `passenger` WHERE id = '{$_SESSION['user_id']}' ");
if($qry3->num_rows > 0){
    $patient = $qry3->fetch_assoc();
}
?>

<div class="container-fluid">
    <form id="appointment_form" class="py-2">
    <div class="row" id="appointment">
        <div class="col-6" id="frm-field">
            <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
            <input type="hidden" name="patient_id" value="<?php echo isset($patient_id) ? $patient_id : '' ?>">
                <div class="form-group">
                    <label for="name" class="control-label">Fullname</label>
                    <input type="text" class="form-control" name="name" value="<?php echo isset($patient['name']) ? $patient['name'] : '' ?>" required>
                </div>
                <div class="form-group">
                    <label for="email" class="control-label">Email</label>
                    <input type="email" class="form-control" name="email" value="<?php echo isset($patient['email']) ? $patient['email'] : '' ?>"  required>
                </div>
                <div class="form-group">
                    <label for="contact" class="control-label">Section</label>
                    <input type="text" class="form-control" name="contact" value="<?php echo isset($patient['contact']) ? $patient['contact'] : '' ?>"  required>
                </div>
                
                <div hidden class="form-group">
                    <label for="contact" class="control-label">Student Id</label>
                    <input  type="text" class="form-control" name="contact" value="<?php echo isset($patient['id']) ? $patient['id'] : '' ?>"  required>
                </div>
                
                <div class="form-group">
                    <label for="department" class="control-label">Department</label>
                    <select type="text" class="custom-select" name="department" required>
                    <option <?php echo isset($patient['department']) && $patient['department'] == "College of Arts and Sciences (CAS)" ? "selected": "" ?>>College of Arts and Sciences (CAS)</option>
                    <option <?php echo isset($patient['department']) && $patient['department'] == "College of Business Management (CBM)" ? "selected": "" ?>>College of Business Management (CBM)</option>
                    <option <?php echo isset($patient['department']) && $patient['department'] == "College of Criminal Justice (CCJ)" ? "selected": "" ?>>College of Criminal Justice (CCJ)</option>
                    <option <?php echo isset($patient['department']) && $patient['department'] == "College of Education (COE)" ? "selected": "" ?>>College of Education (COE)</option>
                    <option <?php echo isset($patient['department']) && $patient['department'] == "College of Engineering and Technology (CET)" ? "selected": "" ?>>College of Engineering and Technology (CET)</option>
                    <option <?php echo isset($patient['department']) && $patient['department'] == "College of Hospitality and Tourism Management (CHTM)" ? "selected": "" ?>>College of Hospitality and Tourism Management (CHTM)</option>    
                    <option <?php echo isset($patient['department']) && $patient['department'] == "College of Information and Communication Technology (CICT)" ? "selected": "" ?>>College of Information and Communication Technology (CICT)</option>                                    
                </select>
                </div>
                <div class="form-group">
                    <label for="dob" class="control-label">Date of Birth</label>
                    <input type="date" class="form-control" name="dob" value="<?php echo isset($patient['dob']) ? $patient['dob'] : '' ?>"  required>
                </div>
        </div>
        <div class="col-6">
                
                <div class="form-group">
                     <label for="documents">Select Documents</label>
                        <select name="documents[]" multiple required class="select form-control">
                         <option>Transcript of Record</option>
                        <option>Diplomas and Certificate</option>
                        <option>Course Schedule</option>
                        <option>Good Moral</option>
                        <option>Attendance Records</option>
                        <option>Transfer Records</option>
                        <option>Student ID Cards</option>
                        <option>Grades Reports</option>
                        <option>Fee Payment Records</option>
             </select>
      </div>

            <div class="form-group">
                <label for="ailment" class="control-label">Notes</label>
                <textarea class="form-control" name="ailment" rows="3" required><?php echo isset($ailment)? $ailment : "" ?></textarea>
            </div>
            
    
            <div class="form-group">
                <label for="date_sched" class="control-label">Appointment</label>
                <input type="datetime-local" class="form-control" name="date_sched" value="<?php echo isset($date_sched)? date("Y-m-d\TH:i",strtotime($date_sched)) : "" ?>" required>
            </div>
            <div class="form-group">
                <label for="status" class="control-label">Status</label>
                <select name="status" id="status" class="custom custom-select">
                    <option value="0"<?php echo isset($status) && $status == "0" ? "selected": "" ?>>Pending</option>
                    <option value="1"<?php echo isset($status) && $status == "1" ? "selected": "" ?>>Confirmed</option>
                    <option value="2"<?php echo isset($status) && $status == "2" ? "selected": "" ?>>Cancelled</option>
                </select>
            </div>
           
        </div>
        <div class="form-group d-flex justify-content-end w-100 form-group">
            <button type="submit" class="btn-primary btn">Submit Appointment</button>
        </div>
        </form>
    </div>
</div>

<!-- Include SweetAlert library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById('appointment_form').addEventListener('submit', function(e) {
    e.preventDefault();
    var form = e.target;
    var formData = new FormData(form);

    fetch('../admin/classes/Master.php?f=save_appointment', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'failed') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.msg
            }).then(() => {
                location.reload();
            });
        } else {
            // Generate a random unique ID in hex format
            const uniqueId = Math.random().toString(16).substr(2, 8).toUpperCase();
            const qrCodeUrl = `https://api.qrserver.com/v1/create-qr-code/?data=${uniqueId}&size=150x150`;

            Swal.fire({
                icon: 'success',
                title: 'Appointment saved successfully.',
                html:
                      'Download the official request form, which must be filled out accurately and completely. This form is required for submission at the registrar\'s office, where it will be reviewed and validated by staff to confirm the completeness and accuracy of your records.<br><br>' +
                      '<a href="Registrar_Form.pdf" class="btn btn-primary" download>Download Registrar Form</a><br><br>' +
                      'Here is your unique QR code for verification:<br>' +
                      'CODE: ' + uniqueId + '<br>' +
                      `<img src="${qrCodeUrl}" alt="QR Code">`
            }).then(() => {
                location.reload();
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'An error occurred',
            text: 'An error occurred while saving the appointment.'
        });
    });
});
</script>
