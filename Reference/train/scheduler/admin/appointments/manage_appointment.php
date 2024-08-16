<?php 
require_once('../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `appointments` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
    $qry2 = $conn->query("SELECT * FROM `patient_meta` where patient_id = '{$patient_id}' ");
    foreach($qry2->fetch_all(MYSQLI_ASSOC) as $row){
        $patient[$row['meta_field']] = $row['meta_value'];
    }
}
?>
<style>
#uni_modal .modal-content>.modal-footer{
    display:none;
}
#uni_modal .modal-body{
    padding-top:0 !important;
}
</style>
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
                
                <div class="form-group">
                    <label for="contact" class="control-label">Student Id</label>
                    <input type="text" class="form-control" name="contact" value="<?php echo isset($patient['contact']) ? $patient['contact'] : '' ?>"  required>
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
        <div class="col-6">s
                
                <div class="form-group">
                     <label for="documents">Select Documents</label>
                        <select name="subject[]" multiple required class="select form-control">
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
            <?php if($_settings->userdata('id') > 0): ?>

            <div class="form-group">
                <label for="ailment" class="control-label">Notes</label>
                <textarea class="form-control" name="ailment" rows="3" required><?php echo isset($ailment)? $ailment : "" ?></textarea>
            </div>
            
            <?php else: ?>
                <input type="hidden" name="ailment" value="">
            <?php endif; ?>
            <div class="form-group">
                <label for="date_sched" class="control-label">Appointment</label>
                <input type="datetime-local" class="form-control" name="date_sched" value="<?php echo isset($date_sched)? date("Y-m-d\TH:i",strtotime($date_sched)) : "" ?>" required>
            </div>
            <?php if($_settings->userdata('id') > 0): ?>
            <div class="form-group">
                <label for="status" class="control-label">Status</label>
                <select name="status" id="status" class="custom custom-select">
                    <option value="0"<?php echo isset($status) && $status == "0" ? "selected": "" ?>>Pending</option>
                    <option value="1"<?php echo isset($status) && $status == "1" ? "selected": "" ?>>Confirmed</option>
                    <option value="2"<?php echo isset($status) && $status == "2" ? "selected": "" ?>>Cancelled</option>
                </select>
            </div>
            <?php else: ?>
                <input type="hidden" name="status" value="0">
            <?php endif; ?>
        </div>
        <div class="form-group d-flex justify-content-end w-100 form-group">
            <button class="btn-primary btn">Submit Appointment</button>
            <button class="btn-light btn ml-2" type="button" data-dismiss="modal">Cancel</button>
        </div>
        </form>
    </div>
</div>
<script>
$(function(){
    $('#appointment_form').submit(function(e){
        e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_appointment",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
				success:function(resp){
					if(typeof resp =='object' && resp.status == 'success'){
                       location.reload()
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").animate({ scrollTop: $('#uni_modal').offset().top }, "fast");
                    }else{
						alert_toast("An error occured",'error');
                        console.log(resp)
					}
						end_loader();
				}
			})
    })
    $('#uni_modal').on('hidden.bs.modal', function (e) {
        if($('#appointment_form').length <= 0)
            location.reload()
    })
})
</script>


