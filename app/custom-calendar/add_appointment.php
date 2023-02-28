<?php 
    include "db_config.php";
    session_start();

    // check user roles
    if(isset($_SESSION['role'])) {
        $admin = $_SESSION['role'];  
        $current_user_is_an_admin = $admin==1; 
        $current_user_is_a_midwife = $admin==0; 
        $current_user_is_a_patient = $admin==-1;  
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check which submit button name is used to add
        if (isset($_POST["submit_button"]) == "patient_add_appointment" && !isset($_POST['patient_id_trimester'])) {
            $time = $_POST['selected_time'];
            $status = "";
            $response_txt = "";

            if(empty($time))
            {
                $status = "error";
                $response_txt = "Please select your appointment time.";
            }
            else if(strtotime($time) < strtotime('8:00am') || strtotime($time) > strtotime('5:00pm'))
            {
                $status = "error";
                $response_txt = "Appointment time is only available at 8:00 am and 5:00 pm.";
            }
            else {
                // get trimester of current patient user  
                $select_trimester = "SELECT trimester FROM users u, patient_details p, user_details ud
                WHERE u.user_id=$_SESSION[id] AND p.user_id=u.user_id AND ud.user_id=u.user_id";
                $result_trimester = mysqli_query($conn, $select_trimester);

                if (mysqli_num_rows($result_trimester)) {
                foreach($result_trimester as $row)  
                    $trimester_from_db = $row['trimester'];   
                    mysqli_free_result($result_trimester);
                } 
                else  { 
                    mysqli_free_result($result_trimester);
                    $status = "error";
                    $response_txt = "Something went wrong from the database.";
                }  

                $date = mysqli_real_escape_string($conn, $_POST['selected_date'] . " " . $time); // get date

                // select brgy id of patient
                $select_brgy = "SELECT barangay_id FROM patient_details WHERE user_id = $_SESSION[id]";
                $brgy_result = $conn->query($select_brgy);

                $brgy_id = $brgy_result->fetch_row()[0] ?? false;

                // select brgy midwife of patient
                $select_mw = "SELECT assigned_midwife FROM barangays WHERE barangay_id = $brgy_id";
                $midwife_result = $conn->query($select_mw);

                $midwife_id = $midwife_result->fetch_row()[0] ?? false;

                // insert appointment
                $insert1 = "INSERT INTO appointments(patient_id, midwife_id, date, status, trimester)
                    VALUES($_SESSION[id], $midwife_id, '$date', 0, $trimester_from_db);";

                if (mysqli_query($conn,$insert1))  {
                    $status = "success";
                    $response_txt = "Added Succesfully!";
                }
                else {
                    $status = "error";
                    $response_txt = "Something went wrong from the database.";
                }  
            }
            
            // Send a response back to the client
            header('Content-Type: application/json');
            echo json_encode([
                'status' => $status,
                'message' => $response_txt
            ]);
        } 
        else if (isset($_POST['submit_button']) == "mw_add_appointment") {
            $time = $_POST['selected_time'];
            $status = "";
            $response_txt = "";

            if (empty($_POST['selected_date']) || (empty($_POST['patient_id_trimester'] && $current_user_is_a_midwife || $current_user_is_a_patient)) || empty($time))
            {
                $status = "error";
                $response_txt = "Please fill up required fields.";
            }
            else if(strtotime($time) < strtotime('8:00am') || strtotime($time) > strtotime('5:00pm'))
            {
                $status = "error";
                $response_txt = "Appointment time is only available at 8:00 am and 5:00 pm.";
            }
            else {   
                if ($current_user_is_a_midwife)
                {
                    $id_trimester_split = explode('AND',$_POST['patient_id_trimester']);                
                }   

                $a_date = mysqli_real_escape_string($conn, $_POST['selected_date'] . " " . $time);
                $patient_id = mysqli_real_escape_string($conn, ($current_user_is_a_midwife?$id_trimester_split[0]:$_SESSION['id']));
                $trimester_post = mysqli_real_escape_string($conn, ($current_user_is_a_midwife?$id_trimester_split[1]:$trimester_from_db));

                // select brgy id of patient
                $select_brgy = "SELECT barangay_id FROM patient_details WHERE user_id = $patient_id";
                $brgy_result = $conn->query($select_brgy);

                $brgy_id = $brgy_result->fetch_row()[0] ?? false;

                // select brgy midwife of patient
                $select_mw = "SELECT assigned_midwife FROM barangays WHERE barangay_id = $brgy_id";
                $midwife_result = $conn->query($select_mw);

                $midwife_id = $midwife_result->fetch_row()[0] ?? false;

                // insert appointment
                $insert1 = "INSERT INTO appointments(patient_id, midwife_id, date, status, trimester)
                    VALUES($patient_id, $midwife_id, '$a_date', 1, $trimester_post);";

                if (mysqli_query($conn,$insert1))  {    
                    $status = "success";
                    $response_txt = "Added Succesfully!";
                }
                else {
                    $status = "error";
                    $response_txt = "Something went wrong from the database.";
                }   
            }

            // Send a response back to the client
            header('Content-Type: application/json');
            echo json_encode([
                'status' => $status,
                'message' => $response_txt
            ]);
        } 
        else {
            $status = "error";
            $response_txt = "User is not identified.";

            // Send a response back to the client
            header('Content-Type: application/json');
            echo json_encode([
                'status' => $status,
                'message' => $response_txt
            ]);
        }
    }
?>