<?php
 
require_once('../includes/connection.php');
require 'mailerController.php';
require 'notificationController.php';
require 'onLoadController.php';

if(isset($_REQUEST['command'])) {
    $controller = new appointmentController();
    if($_REQUEST['command'] == 'addAppointment') {
        $controller->addAppointment();
    }
    else if($_REQUEST['command'] == 'addAppointmentFromPatient') {
        $controller->addAppointmentFromPatient();
    }
    else if($_REQUEST['command'] == 'deleteAppointment') {
        if(isset($_GET['appointment_id'])) {
            $controller->deleteAppointment($_GET['appointment_id'], $_GET['appointment_date'], $_GET['patient']);
        }
    }
    else if($_REQUEST['command'] == 'approveAppointment') {
        if(isset($_GET['appointment_id'])) {
            $controller->approveAppointment($_GET['appointment_id'], $_GET['appointment_date'], $_GET['patient']);
        }
    }
    else if($_REQUEST['command'] == 'searchAvailableAppointment') {
        $controller->searchAvailableAppointment();
    }    
}


 class appointmentController {

    public function __construct()
    {
        $db = new Connection;
        $this->conn = $db->open();

        //mailer
        $this->mailer = new mailerController;
        //notification
        $this->notif = new notificationController;
        //onLoadController
        $this->onLoad = new onLoadController;
    }

    public function addAppointment() {
        $id_trimester_split = explode('AND',$_POST['patient_id_trimester']);
        $patient_id = $id_trimester_split[0];
        $midwife = $_SESSION['id'];
        $date = $_POST['date'];
        $status = 1;
        $trimester_post = $id_trimester_split[1];

        if (empty($date) || empty($patient_id)) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'All field are required.'
            ));
        } else {

            $created_date = date_create($_POST['date']);
            $date_formatted = date_format($created_date,"F d, Y g:i A");
            // $patient_id = substr($patient_id, 0, 1);
            // $trimester_post = substr($trimester_post, 4, 1);
            $inserted = $this->insertAppoint($patient_id, $midwife, $date, $status, $trimester_post);

            if($inserted) {
                
                $p_d = $this->getUserDetails($patient_id);
                $m_d = $this->getUserDetails($midwife);

                $message_for_patient = 'You have appointed to '.$m_d['first_name'].' '.$m_d['last_name']. '(Midwife) on '.$date_formatted.'.';
                $mail = $this->mailer->sendMail($p_d['email'], 'New Appointment', $message_for_patient, $p_d['first_name'].' '.$p_d['last_name']);

                $message_for_midwife = 'You have appointed '.$p_d['first_name'].' '.$p_d['last_name']. '(Patient) on '.$date_formatted.'.';
                $mail = $this->mailer->sendMail($m_d['email'], 'New Appointment', $message_for_midwife, $m_d['first_name'].' '.$m_d['last_name']);
                
                //add notification in database
                $this->notif->addNotif($patient_id, $message_for_patient);
                $this->notif->addNotif($midwife, $message_for_midwife);
                
                if($mail) {
                    echo json_encode(array(
                        'status' => 'success',
                        'message' => 'Added New Appointment',
                    ));
                } else {
                    echo json_encode(array(
                        'status' => 'error',
                        'message' => 'Something Went Wrong!'
                    ));
                }
                
            } else {
                echo json_encode(array(
                    'status' => 'error',
                    'message' => 'Something Went Wrong!'
                ));
            }
            
        }
    }

    public function addAppointmentFromPatient() {
        $date = $_POST['date'];
        $patient_id = $_SESSION['id'];
        $midwife = $this->onLoad->getMidwifeIdByUser($patient_id);
        $status = 0;
        $trimester_post = 0;
        

        if (empty($date)) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Date field is required.'
            ));
        } else {
            $inserted = $this->insertAppoint($patient_id, $midwife, $date, $status, $trimester_post);
            if($inserted) {
                $created_date = date_create($_POST['date']);
                $date_formatted = date_format($created_date,"F d, Y g:i A");
                $p_d = $this->getUserDetails($patient_id);
                $m_d = $this->getUserDetails($midwife);

                $message_for_midwife = $p_d['first_name'].' '.$p_d['last_name']. '(Patient) requested an Appointment on '.$date_formatted.'.';
                $mail = $this->mailer->sendMail($m_d['email'], 'New Pending Appointment Request', $message_for_midwife, $m_d['first_name'].' '.$m_d['last_name']);
                $this->notif->addNotif($midwife, $message_for_midwife);
                if($mail) {
                    echo json_encode(array(
                        'status' => 'success',
                        'message' => 'Added New Appointment',
                    ));
                } else {
                    echo json_encode(array(
                        'status' => 'error',
                        'message' => 'Something Went Wrong!'
                    ));
                }
            } else {
                echo json_encode(array(
                    'status' => 'error',
                    'message' => 'Something Went Wrong!'
                ));
            }
        }
        
    }

    public function insertAppoint($patient_id, $midwife, $date, $status, $trimester_post) {
        $query = "INSERT INTO appointments(patient_id, midwife_id,date, status, trimester)
                    VALUES($patient_id, $midwife, '$date', $status, $trimester_post);";
        return $this->conn->query($query);
    }

    public function getUserDetails($id) {
        $query = 'SELECT u.user_id, email, first_name, middle_name, last_name FROM users u, user_details ud 
        WHERE u.user_id = ud.user_id AND u.user_id ='. $id;
        $res = $this->conn->query($query);
        $data = [];
        if($res->rowCount()) {
            foreach($res as $row) {
                array_push($data, $row);
            }
        }
        return $data[0];
    }


    public function deleteAppointment($id, $date,$patientid) {

        if($patientid) {
            $query = "UPDATE appointments SET status=:status WHERE appointment_id = :appointment_id;";
            $res = $this->conn->prepare($query);
            $res->execute(array(
                ':appointment_id' => $id,
                ':status' => -1,
            ));

            if($res) {
                $p_d = $this->getUserDetails($patientid);
                $m_d = $this->getUserDetails($_SESSION['id']);

                $message_for_patient = $m_d['first_name'].' '.$m_d['last_name']. '(Midwife) cancelled your appointment that set on '.$date.'.';
                $mail = $this->mailer->sendMail($p_d['email'], 'Cancelled an Appointment', $message_for_patient, $p_d['first_name'].' '.$p_d['last_name']);
                $this->notif->addNotif($patientid, $message_for_patient);

                if($mail) {
                    echo json_encode(array(
                        'status' => 'success',
                        'message' => 'Cancelled Patient Appointment!',
                    ));
                } else {
                    echo json_encode(array(
                        'status' => 'error',
                        'message' => 'Something Went Wrong!'
                    )); 
                }

            } else {
                echo json_encode(array(
                    'status' => 'error',
                    'message' => 'Something Went Wrong!'
                )); 
            }
            

        } else {

            $query = "DELETE FROM appointments WHERE appointment_id = $id;"; 
            $res = $this->conn->query($query);

            if($res) {
                $midwife = $this->onLoad->getMidwifeIdByUser($_SESSION['id']);
                $p_d = $this->getUserDetails($_SESSION['id']);
                $m_d = $this->getUserDetails($midwife);
                $message_for_midwife = $p_d['first_name'].' '.$p_d['last_name']. '(Patient) cancelled Appointment set on '.$date.'.';
                $mail = $this->mailer->sendMail($m_d['email'], 'Cancelled an Appointment', $message_for_midwife, $m_d['first_name'].' '.$m_d['last_name']);
                $this->notif->addNotif($midwife, $message_for_midwife);
    
                if($mail) {
                    echo json_encode(array(
                        'status' => 'success',
                        'message' => 'Cancelled your Appointment!',
                    ));
                } else {
                    echo json_encode(array(
                        'status' => 'error',
                        'message' => 'Something Went Wrong!'
                    )); 
                }
                
            } else {
                echo json_encode(array(
                    'status' => 'error',
                    'message' => 'Something Went Wrong!'
                ));
            }
        }
          
    }

    public function approveAppointment($id, $date, $patientid) {
        
        $date_substr = substr($date, 0, 10);
        $midwife_id = $_SESSION['id'];
        $query = "SELECT date FROM appointments WHERE date LIKE '$date_substr%' AND STATUS = 1 AND midwife_id = $midwife_id;";
        $res = $this->conn->query($query);
        if($res->rowCount()) {
            foreach($res as $row) {
                $diff = abs(strtotime($date) - strtotime($row['date']));
                $minutes = ($diff / 60);
                if($minutes < 30) {
                    echo json_encode(array(
                        'status' => 'error',
                        'message' => 'Appointment Date and time is not available, please check the available time for this date.'
                    ));
                    die();
                }
            }
            
        }

        $query2 = "UPDATE appointments SET status=:status WHERE appointment_id = :appointment_id;";
        $res2 = $this->conn->prepare($query2);
        $res2->execute(array(
            ':appointment_id' => $id,
            ':status' => 1,
        ));
        if($res2) {
            $created_date = date_create($date);
            $date_formatted = date_format($created_date,"F d, Y g:i A");
            $p_d = $this->getUserDetails($patientid);
            $m_d = $this->getUserDetails($_SESSION['id']);

            $message_for_patient = $m_d['first_name'].' '.$m_d['last_name']. '(Midwife) Approved your appointment that set on '.$date_formatted.'.';
            $mail = $this->mailer->sendMail($p_d['email'], 'Approved an Appointment', $message_for_patient, $p_d['first_name'].' '.$p_d['last_name']);
            $this->notif->addNotif($patientid, $message_for_patient);

            if($mail) {
                echo json_encode(array(
                    'status' => 'success',
                    'message' => 'Approved Patient Appointment!',
                ));
            } else {
                echo json_encode(array(
                    'status' => 'error',
                    'message' => 'Something Went Wrong!'
                )); 
            }

        } else {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Something Went Wrong!'
            )); 
        }
    }
    

    public function searchAvailableAppointment(){
        $role = isset($_POST['role']) ? $_POST['role'] : '';
        $date = isset($_POST['s_date']) ? $_POST['s_date'] : '';

        if($role == 'midwife') {
            $midwife_id = $_SESSION['id'];
            
        }else if($role == 'patient') {
            $midwife_id = $this->onLoad->getMidwifeIdByUser($_SESSION['id']);
        } else {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Something Went Wrong!'
            )); 
        }

        $query = "SELECT date FROM appointments WHERE date LIKE '$date%' AND STATUS = 1 AND midwife_id = $midwife_id;";
        $res = $this->conn->query($query);
        $data = [];
        if($res->rowCount()) {
            foreach($res as $row) {
                $created_date = date_create($row['date']);
                array_push($data, date_format($created_date,"g:i A - F d, Y"));
            }
        }
        echo json_encode(array(
            'status' => 'success',
            'count' => $res->rowCount(),
            'data' => $data, 
        ));
       
    }

        

 }


?>
