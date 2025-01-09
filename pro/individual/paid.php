<?php
if (!isset($file_access)) die("Direct File Access Denied");
?>
<?php

if (isset($_GET['now'])) {
    echo "<script>alert('Your payment was successful');window.location='individual.php?page=paid';</script>";
    exit;
}

?>
<!-- Content Header (Page header) -->


<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="callout callout-info">
                    <h5><i class="fas fa-info"></i> Info:</h5>
                   Appointment History
                </div>



                <div class="card">
                    <div class="card-header alert-success">
                        <h5 class="m-0">View Appointment List </h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id='example1'>
                            <thead>
                                <tr>
                                    <th>Student Number</th>
                                    <th>Name</th>
                                    <th>Schedule Date</th>
                                    <th>Status</th>
                                    <!-- <th>Action</th> -->
                                </tr>
                            </thead>
                     
                            <tbody>
                    <?php 
                    $i = 1;
                    $user_id = $_SESSION['user_id'];
                    $qry = $conn->query("SELECT p.*,a.date_sched,a.status,a.id as aid from `passenger` p inner join `appointments` a on p.id = a.patient_id WHERE a.patient_id = '$user_id' order by unix_timestamp(a.date_sched) desc ");
                    while($row = $qry->fetch_assoc()):
                    ?>
					
						<tr>
						
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo $row['name'] ?></td>
							<td><?php echo date("M d,Y h:i A",strtotime($row['date_sched'])) ?></td>
							<td class="text-center">
								<?php 
								switch($row['status']){ 
									case(0): 
										echo '<span class="badge badge-primary">Pending</span>';
									break; 
									case(1): 
									echo '<span class="badge badge-success">Confirmed</span>';
									break; 
									case(2): 
										echo '<span class="badge badge-danger">Cancelled</span>';
									break; 
									default: 
										echo '<span class="badge badge-secondary">NA</span>';
                                } 
								?>
							</td>
							<!-- <td align="center">
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item view_data" href="javascript:void(0)" data-id="<?php echo $row['aid'] ?>"> View</a>
									<div class="divider"></div>
									<a class="dropdown-item edit_data" href="javascript:void(0)" data-id="<?php echo $row['aid'] ?>"> Edit</a>
				                  </div>
							</td> -->
						</tr>
					<?php endwhile; ?>
				</tbody>
                        </table>


                    </div>

                    <br />
                </div>
                <!-- /.invoice -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>

<?php 
if (isset($_POST['modify'])){

    $pk = $_POST['pk'];
    $s = $_POST['s'];
    $db = connect();
    $sql = "UPDATE booked SET schedule_id = '$s' WHERE id = '$pk';";
    // die($sql);
    $query = $db->query($sql);
    if ($query){
        alert("Modification Saved");
        load($_SERVER['PHP_SELF']."?page=paid");
        
    }else{
        alert("Error Occurred While Trying To Save.");
    }
}

?>