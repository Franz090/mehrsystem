<?php
 require_once('../includes/connection.php');

 class onLoadController {

    public function __construct()
    {
        $db = new Connection;
        $this->conn = $db->open();
        
    }

    public function getUser() {
        $query = 'SELECT * FROM users';
        $res = $this->conn->prepare($query);
        $res->execute();
        return $res;
    }

    public function getMidwifeAppointment() {
        return $this->getAppointmentByMidwife($_SESSION['id']);
    }

    public function getAppointmentByMidwife($m_id) {
        $query = 'SELECT date FROM appointments WHERE status = 1 AND date > CURRENT_DATE() AND midwife_id='.$m_id;
        $res = $this->conn->query($query);
        $date = [];
        if($res->rowCount()) {
            foreach($res as $data) {
                array_push($date, $data['date']);
            }
        }
        return $date;
    }
    
    public function getMidwifeIdByUser($id) {
        $query = 'SELECT b.assigned_midwife AS midwife_id FROM patient_details pd, barangays b 
                    WHERE pd.barangay_id = b.barangay_id AND pd.user_id ='.$id;
        $res = $this->conn->query($query);
        $m_id = '';
        if($res->rowCount()) {
            foreach($res as $data) {
                $m_id = $data['midwife_id'];
            }
        }
        return $m_id;
    }

    public function getAppointmentByAssignedMidwife(){
        $m_id = $this->getMidwifeIdByUser($_SESSION['id']);
        $date = $this->getAppointmentByMidwife($m_id);
        return $date;
    }

    public function getNotifCount() {
        $id = $_SESSION['id'];
        $query = "SELECT * FROM notifications WHERE user_id= $id AND status = 0;";
        $res = $this->conn->query($query);
        return $res->rowCount();
    }

    public function getNotification() {
        $id = $_SESSION['id'];
        $query = "SELECT * FROM notifications WHERE user_id = $id ORDER BY id DESC; ";
        $res = $this->conn->prepare($query);
        $res->execute();
        return $res;
    }
 }


?>