<?php
    include_once 'db_config.php';
    session_start();

    $role = $_SESSION["role"]; // get user role

    $date = $_POST["date"]; // get selected date

    // check what select query is going to use 
    $query = $role == 0 ? 
    // midwife side query
        // "SELECT appointments.patient_id, appointments.date, CONCAT(user_details.first_name, ' ', user_details.last_name)
        //     AS patient_name FROM appointments 
        //     INNER JOIN user_details ON appointments.patient_id = user_details.user_id
        //     WHERE date LIKE '$date%' AND status = 1
        //     ORDER BY appointments.date ASC" 
        "SELECT a.patient_id, a.date, p.patient_name
            FROM appointments a 
                RIGHT JOIN 
                    (SELECT ud.user_id, CONCAT(ud.first_name, ' ', ud.last_name) patient_name 
                    FROM user_details ud, patient_details pd, barangays b 
                    WHERE b.barangay_id = pd.barangay_id AND b.assigned_midwife = $_SESSION[id] AND pd.user_id = ud.user_id) 
                p ON a.patient_id = p.user_id
            WHERE a.date LIKE '$date%' AND a.status = 1 ORDER BY a.date ASC"
        :
    // patient side query
        "SELECT appointments.date, CONCAT(user_details.first_name, ' ', user_details.last_name) AS patient_name 
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