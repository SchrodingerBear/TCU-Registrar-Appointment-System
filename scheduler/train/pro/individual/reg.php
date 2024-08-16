<?php  
require_once('../../config.php');

if (isset($_GET['id']) && $_GET['id'] > 0) {
    $stmt = $conn->prepare("SELECT * FROM `appointments` WHERE id = ?");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $appointment = $result->fetch_assoc();
        extracappointmentt($appointment); // Extract variables from the result array
    }

    $stmt = $conn->prepare("SELECT * FROM `patient_meta` WHERE patient_id = ?");
    $stmt->bind_param("i", $patient_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $patient = [];
    while ($row = $result->fetch_assoc()) {
        $patient[$row['meta_field']] = $row['meta_value'];
    }
}

?>
<style>
#uni_modal .modal-content > .modal-footer {
    display: none;
}
#uni_modal .modal-body {
    padding-top: 0 !important;
}
</style>
<div class="container-fluid">
    <form id="appointment_form" class="py-2">
        <div class="row" id="appointment">
            <div class="col-6" id="frm-field">
                <input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>">
                <input type="hidden" name="patient_id" value="<?php echo isset($patient_id) ? $patient_id : ''; ?>">

                <div class="form-group">
                    <label for="name" class="control-label">(Last Name, First Name, Middle Name.)</label>
                    <input type="text" class="form-control" name="name" value="<?php echo isset($patient['name']) ? $patient['name'] : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="student_id" class="control-label">Student ID</label>
                    <input type="text" class="form-control" name="student_id" value="<?php echo isset($patient['student_id']) ? $patient['student_id'] : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="section" class="control-label">Section</label>
                    <input type="text" class="form-control" name="section" value="<?php echo isset($patient['section']) ? $patient['section'] : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email" class="control-label">Email</label>
                    <input type="email" class="form-control" name="email" value="<?php echo isset($patient['email']) ? $patient['email'] : ''; ?>" required>
                </div>
                
               
                <div class="form-group">
                    <label for="department" class="control-label">Department</label>
                    <select class="custom-select" name="department" required>
                        <?php 
                        $departments = [
                            "College of Arts and Sciences (CAS)",
                            "College of Business Management (CBM)",
                            "College of Criminal Justice (CCJ)",
                            "College of Education (COE)",
                            "College of Engineering and Technology (CET)",
                            "College of Hospitality and Tourism Management (CHTM)",
                            "College of Information and Communication Technology (CICT)"
                        ];
                        foreach ($departments as $dept) {
                            $selected = (isset($patient['department']) && $patient['department'] == $dept) ? "selected" : "";
                            echo "<option $selected>$dept</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="dob" class="control-label">Date of Birth</label>
                    <input type="date" class="form-control" name="dob" value="<?php echo isset($patient['dob']) ? $patient['dob'] : ''; ?>" required>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="documents" class="control-label">Select Documents</label>
                    <select name="documents[]" multiple required class="select form-control">
                        <?php
                        $documents = [
                            "Transcript of Record",
                            "Diplomas and Certificate",
                            "GWA",
                            "COR",
                            "Unit Earned",

                            "Transfer Records",
                            "Student ID Cards",
                            "Grades Reports",
                            
                          
                        ];
                        foreach ($documents as $doc) {
                            echo "<option>$doc</option>";
                        }
                        ?>
                    </select>
                </div>
                <?php if ($_settings->userdata('id') > 0): ?>
                    <div class="form-group">
                        <label for="notes" class="control-label">Notes</label>
                        <textarea class="form-control" name="notes" rows="3"><?php echo isset($ailment) ? $ailment : ''; ?></textarea>
                    </div>
                <?php else: ?>
                    <input type="hidden" name="notes" value="">
                <?php endif; ?>
                <div class="form-group">
                    <label for="date_sched" class="control-label">Appointment Date</label>
                    <input type="datetime-local" class="form-control" name="date_sched" value="<?php echo isset($date_sched) ? date("Y-m-d\TH:i", strtotime($date_sched)) : ''; ?>" required>
                </div>
                <?php if ($_settings->userdata('id') > 0): ?>
                    <div class="form-group">
                        <label for="status" class="control-label">Status</label>
                        <select name="status" id="status" class="custom-select">
                            <option value="0" <?php echo isset($status) && $status == "0" ? "selected" : ""; ?>>Pending</option>
                            <option value="1" <?php echo isset($status) && $status == "1" ? "selected" : ""; ?>>Confirmed</option>
                            <option value="2" <?php echo isset($status) && $status == "2" ? "selected" : ""; ?>>Cancelled</option>
                        </select>
                    </div>
                <?php else: ?>
                    <input type="hidden" name="status" value="0">
                <?php endif; ?>
            </div>
        </div>
        <div class="form-group d-flex justify-content-end w-100">
            <button class="btn btn-primary">Submit Appointment</button>
            <button class="btn btn-light ml-2" type="button" data-dismiss="modal">Cancel</button>
        </div>
    </form>
</div>
<script>
$(document).ready(function() {
    $('#appointment_form').on('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        start_loader();

        $.ajax({
            url: _base_url_ + "classes/Master.php?f=save_appointment",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            dataType: 'json',
            success: function(resp) {
                end_loader();
                if (resp.status === 'success') {
                    Swal.fire({
                        title: "Appointment Saved!",
                        text: "Would you like to download your PDF?",
                        icon: "success",
                        showCancelButton: true,
                        confirmButtonText: "Download",
                        cancelButtonText: "Close"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = './Registrar_Form.pdf';
                        } else {
                            location.reload();
                        }
                    });
                } else if (resp.status === 'failed') {
                    alert_toast(resp.msg || "An error occurred.", 'error');
                } else {
                    alert_toast("An unknown error occurred.", 'error');
                }
            },
            error: function(err) {
                end_loader();
                console.error(err);
                alert_toast("An error occurred while saving the appointment.", 'error');
            }
        });
    });
});
</script>




