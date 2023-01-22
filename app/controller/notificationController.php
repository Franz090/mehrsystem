<?php 
 require_once('../includes/connection.php');

 if(isset($_REQUEST['command'])) {
    $controller = new notificationController();
    if($_REQUEST['command'] == 'markAllNotifRead') {
        $controller->markAllNotifRead();
    }
    else if($_REQUEST['command'] == 'changeNotifStatus') {
        if(isset($_GET['notif_id']) && isset($_GET['status'])) {
            $controller->changeNotifStatus($_GET['notif_id'], $_GET['status']);
        }
        
    }
}

 class notificationController {
    public function __construct()
    {
        $db = new Connection;
        $this->conn = $db->open();
    }

    public function addNotif($user_id, $message) {
        $query = "INSERT INTO notifications(user_id, message)
                    VALUES($user_id, '$message');";
        return $this->conn->query($query);
    }

    public function markAllNotifRead() {
        $query = "UPDATE notifications SET status=:status WHERE user_id = :user_id";
        $res = $this->conn->prepare($query);
        $res->execute(array(
            ':user_id' => $_SESSION['id'],
            ':status' => 1,
        ));
        if($res) {
            echo json_encode(array(
                'status' => 'success',
                'message' => "You've marked all notifications as read."
            ));
        } else {
            echo json_encode(array(
                'status' => 'error',
                'message' => "Something went wrong!"
            ));
        }
    }

    public function changeNotifStatus($id, $status) {
        $query = "UPDATE notifications SET status=:status WHERE id = :id";
        $res = $this->conn->prepare($query);
        $res->execute(array(
            ':id' => $id,
            ':status' => $status == 1 ? 0 : 1,
        ));

        if($res) {
            echo json_encode(array(
                'status' => 'success',
                'message' => "Updated Status!"
            ));
        } else {
            echo json_encode(array(
                'status' => 'error',
                'message' => "Something went wrong!"
            ));
        }
    }

 }


?>
