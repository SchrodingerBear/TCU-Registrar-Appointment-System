<?php
require_once('../config.php');
require '../../vendor/autoload.php'; 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	function capture_err(){
		if(!$this->conn->error)
			return false;
		else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			if(isset($sql))
			$resp['sql'] = $sql;
			exit;
		}
	}
	function save_appointment(){
		extract($_POST);
		$sched_set_qry = $this->conn->query("SELECT * FROM `schedule_settings`");
		$sched_set = array_column($sched_set_qry->fetch_all(MYSQLI_ASSOC),'meta_value','meta_field');
		$morning_start = date("Y-m-d ") . explode(',',$sched_set['morning_schedule'])[0];
		$morning_end = date("Y-m-d ") . explode(',',$sched_set['morning_schedule'])[1];
		$afternoon_start = date("Y-m-d ") . explode(',',$sched_set['afternoon_schedule'])[0];
		$afternoon_end = date("Y-m-d ") . explode(',',$sched_set['afternoon_schedule'])[1];
		$sched_time = date("Y-m-d ") . date("H:i",strtotime($date_sched));
		$day_of_week = date("l", strtotime($date_sched));
		$holidays = isset($sched_set['holiday_schedule']) ? explode(',', $sched_set['holiday_schedule']) : [];
		$valid_holidays = array_filter($holidays, function($holiday) {
			// Ensure the date is in Y-m-d format
			return strtotime($holiday) !== false;
		});
		
		$formatted_date_sched = date("Y-m-d", strtotime($date_sched));
		
		// Check if the selected date is in the valid holidays array
		if (in_array($formatted_date_sched, $valid_holidays)) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Selected day is a holiday. No appointments available.";
			return json_encode($resp);
			exit;
		}
		

		$day_schedule = explode(',', $sched_set['day_schedule']);
		if (!in_array($day_of_week, $day_schedule)) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Selected day is not available for appointments.";
			return json_encode($resp);
			exit;
		}

		if(!( (strtotime($sched_time) >= strtotime($morning_start) && strtotime($sched_time) <= strtotime($morning_end)) || (strtotime($sched_time) >= strtotime($afternoon_start) && strtotime($sched_time) <= strtotime($afternoon_end)) )){
			$resp['status'] = 'failed';
			$resp['msg'] = "Selected Schedule Time is invalid.";
			return json_encode($resp);
			exit;
		}

		$check = $this->conn->query("SELECT * FROM `appointments` where ('".strtotime($date_sched)."' Between unix_timestamp(date_sched) and unix_timestamp(DATE_ADD(date_sched, interval 30 MINUTE)) OR '".strtotime($date_sched.' +30 mins')."' Between unix_timestamp(date_sched) and unix_timestamp(DATE_ADD(date_sched, interval 30 MINUTE))) ".($id >0 ? " and id != '{$id}' " : ""))->num_rows;
		$this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Selected Schedule DateTime conflicts with another appointment.";
			return json_encode($resp);
			exit;
		}
		if(empty($patient_id)) {
			$patient_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
			if(empty($patient_id)) {
				$sql = "INSERT INTO `patient_list` set name = '{$name}'";
				$save_inv = $this->conn->query($sql);
				$this->capture_err();
				if($save_inv) {
					$patient_id = $this->conn->insert_id;
				}
			}
		} else {
			$sql = "UPDATE `patient_list` set name = '{$name}' where id = '{$patient_id}'";
			$save_inv = $this->conn->query($sql);
			$this->capture_err();
		}

		if(!empty($patient_id)) {
			if(empty($id)) {
				$sql = "INSERT INTO `appointments` set date_sched = '{$date_sched}', patient_id = '{$patient_id}', `status` = '{$status}', `ailment` = '{$ailment}'";
			} else {
				$sql = "UPDATE `appointments` set date_sched = '{$date_sched}', patient_id = '{$patient_id}', `status` = '{$status}', `ailment` = '{$ailment}' where id = '{$id}'";
			}

			$save_sched = $this->conn->query($sql);
			$this->capture_err();
			$data = "";
			foreach($_POST as $k => $v) {
				if (!in_array($k, ['lid', 'date_sched', 'status', 'ailment'])) {
					if (!empty($data)) $data .= ", ";
					$v = is_array($v) ? json_encode($v) : $v; // Convert arrays to JSON strings
					$data .= " ({$patient_id}, '{$k}', '{$v}')";
				}
			}
			
			$sql = "INSERT INTO `patient_meta` (patient_id,meta_field,meta_value) VALUES $data ";
			$this->conn->query("DELETE FROM `patient_meta` where patient_id = '{$patient_id}'");
			$save_meta = $this->conn->query($sql);
			$this->capture_err();
		
			if($save_sched && $save_meta){
				$resp['status'] = 'success';
				$resp['name'] = $name;
				$this->settings->set_flashdata('success',' Appointment successfully saved');
				

				$mail = new PHPMailer(true);

				try {
					// SMTP Server Settings
					$mail->isSMTP();
					$mail->Host       = 'smtp.hostinger.com'; // Hostinger SMTP server
					$mail->SMTPAuth   = true;
					$mail->Username   = 'support@tcuregistrarrequest.site'; // Your email
					$mail->Password   = '#228JyiuS'; // Your email password
					$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
					$mail->Port = 587;  // Use TLS port
					// Email Settings
					$mail->setFrom('support@tcuregistrarrequest.site', 'TCU Registrar');
					$mail->addAddress($email, $name); // Recipient's email and name

					$mail->isHTML(true);
					$mail->Subject = 'Appointment Confirmation';
					$documents = isset($_POST['documents']) ? implode(', ', $_POST['documents']) : 'None';
					$mail->Body    = '<p>Appointment Details</p>
														  <p>Appointment Schedule: '.date("F j, Y", strtotime($date_sched)).'</p>
														  <p>Student Name: '.$name.'</p>
														  <p>Date of Birth: '.date("F j, Y", strtotime($dob)).'</p>
														  <p>Email: '.$email.'</p>
														  <p>Documents: '.$documents.'</p>
														  <p>Notes: '.$ailment.'</p>
														  <p>Status: '.$status.'</p>';
					$mail->SMTPOptions = array(
						'ssl' => array(
							'verify_peer' => false,
							'verify_peer_name' => false,
							'allow_self_signed' => true
						)
					);
					
					$mail->send();
					$resp['email_status'] = 'Email has been sent successfully.';
				} catch (Exception $e) {
					$resp['email_status'] = "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
				}
			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = "There's an error while submitting the data.";
			}

		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = "There's an error while submitting the data.";
		}
		return json_encode($resp);
	}
	function multiple_action(){
		extract($_POST);
		if($_action != 'delete'){
			$stat_arr = array("pending"=>0,"confirmed"=>1,"cancelled"=>2);
			$status = $stat_arr[$_action];
			$sql = "UPDATE `appointments` set status = '{$status}' where patient_id in (".(implode(",",$ids)).") ";
			$process = $this->conn->query($sql);
			$this->capture_err();
		}else{
			$sql = "DELETE s.*,i.*,im.* from  `appointments` s inner join `patient_list` i on s.patient_id = i.id  inner join `patient_meta` im on im.patient_id = i.id where s.patient_id in (".(implode(",",$ids)).") ";
			$process = $this->conn->query($sql);
			$this->capture_err();
		}
		if($process){
			$resp['status'] = 'success';
			$act = $_action == 'delete' ? "Deleted" : "Updated";
			$this->settings->set_flashdata("success","Appointment/s successfully ".$act);
		}else{
			$resp['status'] = 'failed';
			$resp['error_sql'] = $sql;
		}
		return json_encode($resp);
	}
	function save_sched_settings(){
		$data = "";
		foreach($_POST as $k => $v){
			if(is_array($_POST[$k]))
			$v = implode(',',$_POST[$k]);
			if(!empty($data)) $data .= ",";
			$data .= " ('{$k}','{$v}') ";
		}
		$sql = "INSERT INTO `schedule_settings` (`meta_field`,`meta_value`) VALUES {$data}";
		if(!empty($data)){
			$this->conn->query("DELETE FROM `schedule_settings`");
			$this->capture_err();
		}
		$save = $this->conn->query($sql);
		if($save){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',' Schedule settings successfully updated');
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error;
			$resp['msg'] = "An Error occure while excuting the query.";

		}
		return json_encode($resp);
	}
	
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'save_appointment':
		echo $Master->save_appointment();
	break;
	case 'multiple_action':
		echo $Master->multiple_action();
	break;
	case 'save_sched_settings':
		echo $Master->save_sched_settings();
		break;
	default:
		// echo $sysset->index();
		break;
}