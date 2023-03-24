<!-- Import the Sweet Alert library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Import calendar js file for custom calendar -->
<script src="../custom-calendar/calendar.js"></script>

<!-- Show appointment modal -->
<div class="modal fade" id="show_apt_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Appointment(s)</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mx-2">
                <table id="appointment_table" class="table">
                    <thead>
                        <tr>
                            <th>Patient Name</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Show add appointment modal -->
<div class="modal fade" id="add_apt_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">New Appointment</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form class="m-5">
                <?php
                if (isset($error))
                    echo '<span class="form__input-error-message">' . $error . '</span>';
                ?>
                <div class="mb-4">
                    <label>Date:</label>
                    <input type="date" name="selected_date" id="selected_date" readonly>
                    <br>
                    <label>Time: &nbsp; &nbsp;</label>
                    <input type="time" name="selected_time" id="selected_time">
                </div>
                <!-- searchable select  -->
                <?php if($_SESSION['role'] == 0) : ?>
                <div class="wrapper_ss">
                    
                    <div class="select-btn_ss">
                        <span>Select A Patient</span>
                        <i class="uil uil-angle-down"></i>
                    </div>
                    <input type="text" style="display:none;" name="patient_id_trimester" id="patient_id_trimester" class="patient_id_trimester" />
                    <div class="content_ss">
                        <div class="search_ss">
                            <ion-icon class="search-logo" name="search-outline"></ion-icon>
                            <input spellcheck="false" type="text" placeholder="Search" class="ss">
                        </div>
                        <ul class="options_ss"></ul>
                    </div>
                </div>
                <?php endif; ?>
                </div>
                <div class="modal-footer">
                <?php if($_SESSION['role'] == 0) : ?>
                    <button type="submit" name="mw_add_appointment" class="btn btn-primary btn-submit">Add Appointment</button>
                <?php else : ?>
                    <button type="submit" name="patient_add_appointment" class="btn btn-primary btn-submit">Add Appointment</button>
                <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Internal script for submitting form -->
<script>
    const form = document.querySelector('form'); // get the form element

    // Add an event listener to the form's submit event
    form.addEventListener('submit', function(event) {
        event.preventDefault(); // prevent the form from submitting

        document.querySelector(".btn-submit").disabled = true;
        document.querySelector(".btn-submit").innerHTML = "Please wait...";

        const formData = new FormData(form);
        
        let submitButtonName = event.submitter.name; // determine which submit button was used

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../custom-calendar/add_appointment.php');
        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText); // get response json
                const status = response.status; // get status from response json
                const message = response.message; // get status from message
                
                if(status == "success") {
                    // show a success SweetAlert alert box
                    Swal.fire({
                        icon: 'success',
                        title: message,
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        location.reload();
                    });
                }
                else {
                    // show a error SweetAlert alert box
                    Swal.fire({
                        icon: 'error',
                        text: message,
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        document.querySelector(".btn-submit").disabled = false;
                        document.querySelector(".btn-submit").innerHTML = "Add Appointment";
                    });
                }
            }
            else {
                // show a error SweetAlert alert box
                Swal.fire({
                    icon: 'error',
                    text: xhr.status,
                    confirmButtonText: 'OK'
                }).then((result) => {
                    location.reload();
                });
            }
        };
        xhr.onerror = function() {
            // show a error SweetAlert alert box
            Swal.fire({
                icon: 'error',
                text: xhr.status,
                confirmButtonText: 'OK'
            }).then((result) => {
                location.reload();
            });
        };

        formData.append('submit_button', submitButtonName); // add the submit button name to the form data

        xhr.send(formData);
    });

    
</script>

<!-- Calendar -->
<?php
class Calendar
{

    private $active_year, $active_month, $active_day, $_midwife_id;
    private $events = [];
    public function __construct($date = null, $midwife_id)
    {
        $this->_midwife_id=$midwife_id;
        // check if it was a custom date in a calendar
        if(isset($_GET["date"])) {
            $date= $_GET["date"];
            $month = date('m', strtotime($date));
            $year = date('Y', strtotime($date));

            $this->active_month = $month;
            $this->active_year = $year;
        }
        else {
            $this->active_month = $date != null ? date('m', strtotime($date)) : date('m');
            $this->active_year = $date != null ? date('Y', strtotime($date)) : date('Y');
        }
        // check if it was a custom date in a calendar

        $this->active_day = $date != null ? date('d', strtotime($date)) : date('d');
    }

    public function add_event($txt, $date, $days = 1, $color = '')
    {
        $color = $color ? ' ' . $color : $color;
        $this->events[] = [$txt, $date, $days, $color];
    }

    public function __toString()
    {
        $midwife_id = $this->_midwife_id;
        $num_days = date('t', strtotime($this->active_day . '-' . $this->active_month . '-' . $this->active_year));
        $num_days_last_month = date('j', strtotime('last day of previous month', strtotime($this->active_day . '-' . $this->active_month . '-' . $this->active_year)));
        $days = [0 => 'Sun', 1 => 'Mon', 2 => 'Tue', 3 => 'Wed', 4 => 'Thu', 5 => 'Fri', 6 => 'Sat'];
        $first_day_of_week = array_search(date('D', strtotime($this->active_year . '-' . $this->active_month . '-1')), $days);
        $html = '<div class="calendar">';
        $html .= '<div class="header">';
        $html .= '<div class="month-year d-flex justify-content-between">';
        $html .= date('F Y', strtotime($this->active_year . '-' . $this->active_month . '-' . $this->active_day));
        $html .= '<span class="months-locator">
                    <button id="prev_month" onclick="prevMonth(\'' . $this->active_year . '\', \'' . $this->active_month . '\' )">&#60</button>
                    <button id="next_month" onclick="nextMonth(\'' . $this->active_year . '\', \'' . $this->active_month . '\' )">&#62</button>
                </span>
                ';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="days">';
        foreach ($days as $day) {
            $html .= '
                <div class="day_name">
                    ' . $day . '
                </div>
            ';
        }
        for ($i = $first_day_of_week; $i > 0; $i--) {
            $html .= '
                <div class="day_num ignore">
                    ' . ($num_days_last_month - $i + 1) . '
                </div>
            ';
        }
        for ($i = 1; $i <= $num_days; $i++) {
            $selected = '';
            $is_weekend = (date('N', strtotime($this->active_year . '-' . $this->active_month . '-' . $i)) >= 6); // check if it's a weekend day
            if ($i == $this->active_day) {
                $selected = ' selected';
            }
            $html .= '<div class="day_num' . $selected . '">';
            $html .= '<span>' . $i . '</span>';
            
            // If weekend, don't display buttons
            if(!$is_weekend) {
                include 'db_config.php'; // including database

                // query for counting appointment for the day
                $date_str = $this->active_year . '-' . $this->active_month . '-' . $i;
                $num_appts_query = "SELECT COUNT(*) AS num_appts 
                    FROM appointments a, barangays b, patient_details p
                    WHERE DATE(date) = '$date_str' AND a.status = 1 AND a.patient_id = p.user_id
                        AND p.barangay_id = b.barangay_id AND b.assigned_midwife = $midwife_id";
                $num_appts_result = mysqli_query($conn, $num_appts_query);
                $num_appts = mysqli_fetch_assoc($num_appts_result)['num_appts'];

                // Check if the date is greater than or equal to today's date
                if (strtotime($this->active_year . '-' . $this->active_month . '-' . $i) >= strtotime(date('Y-m-d'))) {
                    // display add button
                    $html .= '<button class="event blue" onclick="showApt(\'' . date('Y-m-d', strtotime($this->active_year . '-' . $this->active_month . '-' . $i)) . '\')">';
                    $html .= "$num_appts / 18 Appointments";
                    $html .= '</button>';

                    // //  display add appointment button appointment count is not greater than 18
                    if($num_appts < 18)
                    {
                        $html .= '<button class="event green" onclick="addApt(\'' . date('Y-m-d', strtotime($this->active_year . '-' . $this->active_month . '-' . $i)) . '\');">';
                        $html .= "Add Appointment";
                        $html .= '</button>';
                    }
                }   
                else {
                    // display appointment button only
                    $html .= '<button class="event blue" onclick="showApt(\'' . date('Y-m-d', strtotime($this->active_year . '-' . $this->active_month . '-' . $i)) . '\')">';
                    $html .= "$num_appts / 18 Appointments";
                    $html .= '</button>';
                }
            }
            // if weekend, don't display buttons
            $html .= '</div>';
            
        }
        for ($i = 1; $i <= (42 - $num_days - max($first_day_of_week, 0)); $i++) {
            $html .= '
                <div class="day_num ignore">
                    ' . $i . '
                </div>
            ';
        }
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }
}
