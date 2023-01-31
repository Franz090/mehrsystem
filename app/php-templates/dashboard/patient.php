<?php 
  if ($current_user_is_a_patient) { //closing bracket at the end of the file
    if ($status) {
  ?>
  <style>
    .text-main {
        color: var(--green);
        text-align: left !important;
    }
  </style>
  <div class="p-4">
    Patient <br/>
    BMI: <?php echo round($bmi,2). " ($bmi_desc)"?> 
  </div>

    
    
      <!-- <div class="row" style="width:100%;">
        <h2 class="">Appointment Schedule</h2>
        <div class="col-md-12 box background-head p-4">
            <div id="calendar"></div>
        </div>
        <div class="col-md-3">
          <div class="cardt rounded-0 shadow">
            <div class="card-header bg-gradient bg-primary text-light">
              <h5 class="card-title">Book an Appointment</h5>
            </div>
              <div class="card-body">
                <div class="container-fluid">
                  <form method="post" id="schedule-form">
                    <input type="hidden" name="id" value=""> 
                    <div class="form-group mb-2">
                        <label for="start_datetime" class="control-label">Appointment Date</label>
                        <input type="datetime-local" class="form-control form-control-sm rounded-0" 
                          name="date" id="start_datetime" required>
                    </div>   
                  </form>
                </div>
              </div>
              <div class="card-footer">
                <div class="text-center">
                    <button class="btn btn-primary btn-sm rounded-0" 
                      type="submit" name="submit_appointment" form="schedule-form"><i class="fa fa-save"></i> Save</button>
                    <button class="btn btn-default border btn-sm rounded-0" 
                      type="reset" form="schedule-form"><i class="fa fa-reset"></i> Cancel</button>
                </div>
              </div>
            </div>
          </div>
        </div> -->
         <div class="container-fluid" id="page-container">
            <div class="row" style="width:100%;">
                <div class="calendarBox"> 
                    <h2 class="text-main">Appointment Schedule</h2>
                    <div class="box">
                        <h6 class="text-center">Calendar</h6>
                        <div id="calendar"></div>
                    </div> 
                 
                </div>
            </div>
      <!-- Event Details Modal -->
      <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="event-details-modal">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content rounded-0">
            <div class="modal-header rounded-0">
                <h5 class="modal-title">Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body rounded-0">
                <div class="container-fluid">
                    <dl>
                        <!-- <dt class="text-muted">Name</dt>
                        <dd id="title" class="fw-bold fs-4"></dd> -->
                        <!-- <dt class="text-muted">Description</dt> -->
                        <!-- <dd id="description" class=""></dd> -->
                        <dt class="text-primary">Appointment Date and Time</dt>
                        <dd id="start" class=""></dd> 
                    </dl>
                </div>
            </div>
            <div class="modal-footer rounded-0">
                <div class="text-end">
                    <!-- <button type="button" class="btn btn-primary btn-sm rounded-0" id="edit" data-id="">Edit</button> -->
                    <!-- <button type="button" class="btn btn-danger btn-sm rounded-0" id="delete" data-id="">Cancel</button> -->
                    <button type="button" class="btn btn-primary btn-sm rounded-2" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
          </div>
        </div>
      </div>  
    </div> 

    <script>
      var scheds = $.parseJSON('<?= json_encode($sched_res) ?>')  
      console.log(scheds)
    </script>
  <?php
    } else {
?>  
    <!-- status inactive  -->
    <div class="container-fluid default" >
      <div class="background-head row m-2 my-4" >
        <h6 class="pb-3 m-3 fw-bolder ">
          Fill up all the required information (the one's with *) to let the assigned Midwife approve your account.
        </h6><hr>
  
        <div class="container default p-4 ">
          <div class="col-md-8 col-lg-5">         
            <form method="post" action="" class="form form-box px-3 py-5">
        
              <div class="mb-3">
                <label>Nickname*</label>
                <input type="text" value="<?php echo $c_nickname?>"
                    class="form-control mt-2 mb-2"  name="nickname"  placeholder="Nickname"/>
              </div> 
              <div class="form-input">
                <label for="contact">Mobile Number(s): *Separate each with a nextline and use this format: 09XX-XXX-XXXX*</label><br/>
                <textarea id="contact" name="contact" class="form-control form-control-md w-100"><?php echo $c_no?></textarea> 
              </div><br>
              <div class="mb-3"> 
                <label>Birth Date</label>
                <div class="input-group date" id="datepicker">
                  <input type="date" class="form-control option" name="b_date" value="<?php echo $c_b_date?>" required/>
                </div>
              </div>
              <div class="form-input">
                <label for="address">Address</label><br/>
                <textarea id="address" name="address" class="form-control form-control-md w-100"><?php echo $c_address?></textarea> 
              </div><br>
              <label>Civil Status*</label>
              <div class="mb-3">
                  <input type="text" value="<?php echo $c_civil_status?>" class="form-control mt-2 mb-2" name="civil_status" placeholder="Civil Status*" required/>
              </div>  

              <div class="form-input">
                <div class="form__text"><label>Medical History</label></div>
              </div>
              <div class="form_input-group" style="font-family:  'Open Sans', sans-serif;margin-bottom: 1rem;">
                Height* 
                <div class="d-flex input-group">
                  <input value="<?php echo $c_height_ft?>" min='0' type="number" 
                    class="form__input form-control" name="height_ft" placeholder="Feet*" required/> 
                  <div class="input-group-postpend">
                    <div id="weight-height" class="input-group-text form__input text-white">ft</div>
                  </div> 
                  <input value="<?php echo $c_height_in?>" min='0' max='11' type="number" 
                  class="form__input form-control" name="height_in" placeholder="Inches*" required/>
                  <div class="input-group-postpend">
                    <div id="weight-height" class=" input-group-text form__input text-white">inch(es)</div>
                  </div> 
                </div>
              </div>
              <div class="form__input-group" style="font-family:  'Open Sans', sans-serif;margin-bottom: 1rem;">   
                Weight*   
                <div class="d-flex input-group">
                  <input value="<?php echo $c_weight?>" type="number" class="form__input form-control" name="weight" placeholder="Weight*" 
                    required min="0"/>
                    <div class="input-group-postpend">
                      <div id="weight-height" class="w-100 input-group-text form__input text-white">kg</div>
                    </div> 
                </div>
              </div><br>
              <label>Blood Type*</label>
              <div class="mb-3"> 
                <input type="text" value="<?php echo $c_blood_type?>"
                  class="form-control mt-2 mb-2" name="blood_type" placeholder="Blood Type*" required/>  
              </div>
              <label>Diagnosed Condition</label> 
              <div class="mb-3">  
                <input type="text" value="<?php echo $c_diagnosed_condition?>"
                  class="form-control mt-2 mb-2" name="diagnosed_condition" placeholder="Diagnosed Condition"/> 
                <label>Family History</label> 
                <div class="mb-3"> 
                <input type="text" value="<?php echo $c_family_history?>"
                  class="form-control mt-2 mb-2" name="family_history" placeholder="Family History"/> 
                 </div>
                <label>Allergies</label> 
                <div class="mb-3"> 
                <input type="text" value="<?php echo $c_allergies?>"
                  class="form-control mt-2 mb-2" name="allergies" placeholder="Allergies"/>    
                </div>
              </div>
              <br>
              <button class="w-50 btn btn-primary  text-capitalize" type="submit" name="submit">Update Profile</button>
            </form> 
            
          </div> 
        </div> 
      </div> 

<?php 
    }
  }
?>