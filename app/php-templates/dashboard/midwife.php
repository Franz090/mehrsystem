<!-- Add style in calendar -->
<style>
    <?php include '../custom-calendar/calendar.css'; ?>
</style>

<!-- Add style in calendar -->
<?php
if ($current_user_is_a_midwife) {

    $midwife_condition_string = "role=-1 AND u.user_id=pd.user_id
    AND b.barangay_id=pd.barangay_id AND b.assigned_midwife=$session_id AND pd.status=1
    AND b.archived=0";

    // patients 
    $select_patients = "SELECT CONCAT(first_name, IF(middle_name IS NULL OR middle_name='', '', CONCAT(' ', SUBSTRING(middle_name, 1, 1), '.')), 
    ' ', last_name) name, u.user_id patient_id 
      FROM users u, patient_details pd, barangays b, user_details ud 
        WHERE ud.user_id=u.user_id AND $midwife_condition_string";

    $select_appointments = "SELECT * 
        FROM appointments a, ($select_patients) p 
            WHERE a.status=1 AND p.patient_id=a.patient_id";
    // echo $select_appointments;
    $sched_res = [];
    if ($result_appointments = mysqli_query($conn, $select_appointments)) {
        foreach ($result_appointments as $row) {
            $row['appointment_date'] = date("F d, Y h:i A", strtotime($row['date']));
            $sched_res[$row['appointment_id']] = $row;
        }
        mysqli_free_result($result_appointments);
    } else {
        $error = 'Something went wrong fetching data from the database.';
    }

    // total patients 
    $select_total_patients = "SELECT COUNT(u.user_id) c 
        FROM users u, patient_details pd, barangays b 
        WHERE $midwife_condition_string";
    $total_patients = 0;
    if ($result_total_patients = mysqli_query($conn, $select_total_patients)) {
        foreach ($result_total_patients as $row) {
            $total_patients = $row['c'];
        }
        mysqli_free_result($result_total_patients);
    } else {
        $error = 'Something went wrong fetching data from the database.';
    }
    // appointments today 
    $select_appointments_today = "SELECT COUNT(a.appointment_id) c 
    FROM users u, patient_details pd, barangays b, appointments a 
    WHERE (a.date BETWEEN '$curr_date 00:00:00' AND '$curr_date 23:59:59') AND a.patient_id=u.user_id AND a.status=1 
        AND $midwife_condition_string";
    // echo $select_appointments_today;
    if ($result_appointments_today = mysqli_query($conn, $select_appointments_today)) {
        foreach ($result_appointments_today as $row) {
            $appointments_today = $row['c'];
        }
        mysqli_free_result($result_appointments_today);
    } else {
        $error = 'Something went wrong fetching data from the database.';
    }

    // get patients 
    $patient_list = [];
    @include '../php-templates/midwife/get-assigned-barangays.php';
    if (count($_barangay_list) > 0) {
        $barangay_select = '';
        $barangay_list_length_minus_1 = count($_barangay_list) - 1;
        foreach ($_barangay_list as $key => $value) {
            $barangay_select .= "p.barangay_id=$value ";
            if ($key < $barangay_list_length_minus_1) {
                $barangay_select .= "OR ";
            }
        }
        $select1 = "SELECT u.user_id, trimester,
            CONCAT(ud.first_name, 
        IF(ud.middle_name IS NULL OR ud.middle_name='', '', 
            CONCAT(' ', SUBSTRING(ud.middle_name, 1, 1), '.')), 
        ' ', ud.last_name) name
            FROM users u, patient_details p, user_details ud
            WHERE role=-1 AND ($barangay_select) AND p.user_id=u.user_id AND ud.user_id=u.user_id";
        // fetch patients  

        $result_patient = mysqli_query($conn, $select1);

        if (mysqli_num_rows($result_patient)) {
            foreach ($result_patient as $row) {
                $id = $row['user_id'];
                $name = $row['name'];
                $trimester = $row['trimester'];
                array_push($patient_list, array('id' => $id, 'name' => $name, 'trimester' => $trimester));
            }
            mysqli_free_result($result_patient);
            // print_r($result_barangay); 
        } else {
            mysqli_free_result($result_patient);
            $error = 'Something went wrong fetching data from the database.';
        }
    }
    // submit add appointment
    @include '../php-templates/appointments/submit-add-appointment.php';

    $conn->close();
?>

    <div class="container-fluid default">
        Midwife <!-- cards -->
        <div class="cardBoxs">

            <div class="cards">
                <div>
                    <div class="number"><?php echo $total_patients ?> </div>
                    <div class="cardsNames">Total Number of Patients</div>
                </div>

                <div class="iconBx">
                    <ion-icon name="people-outline"></ion-icon>
                </div>

            </div>
            <div class="cards">
                <div>
                    <div class="number"><?php echo $appointments_today ?></div>
                    <div class="cardsNames"> Appointments Today</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="today-outline"></ion-icon>
                </div>
            </div>

        </div>

        <div class="container-fluid" id="page-container">
            <div class="row" style="width:100%;">
                <div class="calendarBox">
                    <div class="box">
                        <!-- <h6 class="text-center">Calendar Appointment Schedule</h6> -->
                        <!-- <div id="calendar"></div> -->
                        <?php
                        include '../custom-calendar/calendar.php';
                        $calendar = new Calendar(null, $session_id); // instance of calendar

                        $yester_date = date('Y-m-d', strtotime('-1 days')); // get yesterday date
                        $cur_date = date('Y-m-d'); // get current date

                        // adding events
                        // $calendar->add_event('Add Appointment', $cur_date, 1, 'green');
                        // $calendar->add_event('Add Appointment', $cur_date, 1, 'green');
                        // adding events

                        echo $calendar; // displaying calendar
                        ?>
                    </div>
                    <div class="col-md-3">
                        <div class="cardt rounded-0 shadow">
                            <div class="card-header bg-gradient bg-primary text-light">
                                <h5 class="card-title">Add an Appointment</h5>
                            </div>
                            <div class="card-body">
                                <div class="container-fluid">
                                    <!-- <form method="post" id="schedule-form">
                                        <div class="form-group mb-2">
                                            <label for="patient" class="control-label">Patient</label>
                                            <select  class="form-select"  name="patient_id_trimester" id="patient">
                                                <?php
                                                // if (count($patient_list)>0) {
                                                // foreach ($patient_list as $key => $value) { 
                                                ?> 
                                                    <option class="option" value="<?php // echo $value['id']."AND".$value['trimester'];
                                                                                    ?>" <?php //echo $key===0?'selected':'';
                                                                                        ?>>
                                                        <?php // echo $value['name'];
                                                        ?></option>
                                                <?php
                                                // }    
                                                // }
                                                ?>  
                                            </select>
                                            
                                            searchable select 
                                            <div class="wrapper_ss">
                                                <div class="select-btn_ss">
                                                    <span>Select A Patient</span>
                                                    <i class="uil uil-angle-down"></i>
                                                </div>
                                                <input type="text" style="display:none;" name="patient_id_trimester" class="patient_id_trimester"/>
                                                <div class="content_ss">
                                                    <div class="search_ss">
                                                        <i class="uil uil-search"></i>
                                                        <input spellcheck="false" type="text" placeholder="Search" class="ss">
                                                    </div>
                                                    <ul class="options_ss"></ul>
                                                </div>
                                            </div> 
                                            <label for="start_datetime" class="control-label">Appointment Date</label> 
                                            <input type="datetime-local" class="form-control form-control-sm rounded-0" 
                                                name="date" id="start_datetime" required>
                                        </div>   
                                    </form> -->
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-center">
                                    <button class="btn btn-primary btn-sm rounded-0" type="submit" name="submit_appointment" form="schedule-form"><i class="fa fa-save"></i> Save</button>
                                    <button class="btn btn-default border btn-sm rounded-0" type="reset" form="schedule-form"><i class="fa fa-reset"></i> Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Event Details Modal -->
            <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="event-details-modal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-0">
                        <div class="modal-header rounded-0">
                            <h5 class="modal-title">Appointment</h5>
                        </div>
                        <div class="modal-body rounded-0">
                            <div class="container-fluid">
                                <dl>
                                    <dt class="text-muted">Name</dt>
                                    <dd id="title" class="fw-bold text-md-start fs-6"></dd>
                                    <!-- <dt class="text-muted">Description</dt> -->
                                    <!-- <dd id="description" class=""></dd> -->
                                    <dt class="text-muted">Appointment Date and Time</dt>
                                    <dd id="start" class=""></dd>
                                </dl>
                            </div>
                        </div>
                        <div class="modal-footer rounded-0">
                            <div class="text-end">
                                <button type="button" class="btn btn-primary btn-sm rounded-0" data-bs-dismiss="modal">Close</button>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>


        <script>
            var scheds = $.parseJSON('<?= json_encode($sched_res) ?>')
            //   console.log(scheds)
        </script>




    <?php
}
    ?>