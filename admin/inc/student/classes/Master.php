<?php
require_once('../config.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; 

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
			return json_encode($resp);
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
		if(!in_array(strtolower(date("l",strtotime($date_sched))),explode(',',strtolower($sched_set['day_schedule'])))){
			$resp['status'] = 'failed';
			$resp['msg'] = "Selected Schedule Day of Week is invalid.";
			return json_encode(value: $resp);
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
			$resp['msg'] = "Selected Schedule DateTime conflicts to other appointment.";
			return json_encode($resp);
			exit;
		}
		if(empty($patient_id))
		$sql = "INSERT INTO `patient_list` set name = '{$name}'  ";
		else
		$sql = "UPDATE `patient_list` set name = '{$name}' where id = '{$id}'  ";
		$save_inv = $this->conn->query($sql);
		$this->capture_err();
		if($save_inv){
			$patient_id = (empty($patient_id))? $this->conn->insert_id : $patient_id;
			if(empty($id))
			$sql = "INSERT INTO `appointments` set date_sched = '{$date_sched}',patient_id = '{$patient_id}',`status` = '{$status}',`ailment` = '{$ailment}' ";
			else
			$sql = "UPDATE `appointments` set date_sched = '{$date_sched}',patient_id = '{$patient_id}',`status` = '{$status}',`ailment` = '{$ailment}' where id = '{$id}' ";

			$save_sched = $this->conn->query($sql);
			$this->capture_err();
			$data = "";
			foreach($_POST as $k=> $v){
				if(!in_array($k,array('lid','date_sched','status','ailment'))){
					if(!empty($data)) $data .=", ";
					$data .= " ({$patient_id},'{$k}','{$v}')";
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
				
				// Send email notification
				require 'vendor/autoload.php'; // Include PHPMailer autoload

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
					$mail->SMTPDebug = 2;
					// Email Settings
					$mail->setFrom('support@tcuregistrarrequest.site', 'TCU Registrar');
					$mail->addAddress($email, $name); // Recipient's email and name

					$mail->isHTML(true);
					$mail->Subject = 'Appointment Confirmation';
					$mail->Body    = '<p>Hello '.$name.',</p><p>Your appointment has been successfully scheduled.</p>';
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
				}		try {
					// SMTP Server Settings
					$mail->isSMTP();
					$mail->Host       = 'smtp.hostinger.com'; // Hostinger SMTP server
					$mail->SMTPAuth   = true;
					$mail->Username   = 'support@tcuregistrarrequest.site'; // Your email
					$mail->Password   = '#228JyiuS'; // Your email password
					$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
					$mail->Port = 587;  // Use TLS port
					$mail->SMTPDebug = 2;
					// Email Settings
					$mail->setFrom('support@tcuregistrarrequest.site', 'TCU Registrar');
					$mail->addAddress($email, $name); // Recipient's email and name

					$mail->isHTML(true);
					$mail->Subject = 'Appointment Confirmation';
					$mail->Body    = '<p>Hello '.$name.',</p><p>Your appointment has been successfully scheduled.</p>';
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