<?php
    include_once 'db_config.php';
    session_start();

    $role = $_SESSION["role"]; // get user role

    $date = $_POST["date"]; // get selected date

    // check what select query is going to use
    if($role == 0)
        // midwife side query
        $query = "SELECT appointments.patient_id, appointments.date, CONCAT(user_details.first_name, ' ', user_details.last_name)
                AS patient_name FROM appointments 
                INNER JOIN user_details ON appointments.patient_id = user_details.user_id
                WHERE date LIKE '$date%' AND status = 1
                ORDER BY appointments.date ASC";
    else 
        // patient side query
        $query = "SELECT appointments.date, CONCAT(user_details.first_name, ' ', user_details.last_name) AS patient_name 
                FROM appointments 
                INNER JOIN user_details ON appointments.patient_id = user_details.user_id
                WHERE date LIKE '$date%' AND patient_id = $_SESSION[id] AND status = 1
                ORDER BY appointments.date ASC";

    // get result
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>" . $row["patient_name"] . "</td><td>" . date("h:i:s A", strtotime($row["date"])) . "</td></tr>"; 
        }
    }
    else {
        // display different response based on user role if no appointment was found.
        if($role == 0) 
            echo "<tr><td colspan='3'>No appointments found.</td></tr>";
        else {
            echo "<tr><td colspan='3'>You have no appointment schedule found for this date.</td></tr>";
        }
    }
    // get result

    mysqli_close($conn);
?>