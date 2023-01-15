<?php 

@include 'app/includes/config.php';

$select_footer_data = "SELECT * FROM footer WHERE footer_id=1";
if ($result = mysqli_query($conn, $select_footer_data)) {
    foreach ($result as $row) {
        $email = $row['email'];
        $address = $row['address'];
        $fb_link = $row['fb_link'];
        $schedule = $row['schedule'];
        $contact_num_select = "SELECT mobile_number FROM contacts WHERE type=0";
        if ($result_c_no = mysqli_query($conn, $contact_num_select)) {
            $contact_num = [];
            foreach ($result_c_no as $row2)  
                array_push($contact_num,$row2['mobile_number']);  
        } 
    }

    mysqli_free_result($result);
}
else {
    $error = "Something went wrong fetching data from the database.";
}

?>

<section class="footer"> 
    <?php if (isset($error)) {?>
        <span> <?php echo $error?> </span>
    <?php } else {?>
        
        <div class="box-container"> 
            <div class="box">
                <h3>Contact Us</h3>
                <a style="text-transform:none;"> <i class="fas fa-solid fa-envelope"></i> <?php echo $email?> </a>
                <?php foreach ($contact_num as $key => $value) { ?>
                    <a> <i class="fas fa-solid fa-phone"></i> <?php echo $value;?> </a>
                <?php }?> 
            </div>

            <div class="box">
                <h3>Address</h3>
                <a> <i class="fas fa-solid fa-location-arrow"></i> 
                    <?php echo $address; ?>
                </a>
            </div>

            <div class="box">
                <h3>Opening Hours</h3>
                <a> <i class="fas fa-phone"></i> <?php echo $schedule; ?></a>
            </div> 

            <div class="box">
                <h3>Follow us</h3>
                <a href="<?php echo $fb_link?>" target="_blank"> <i class="fab fa-facebook-f"></i> facebook </a>
                <!-- <a href="#"> <i class="fab fa-twitter"></i> twitter </a>
                <a href="#"> <i class="fab fa-instagram"></i> instagram </a> -->
            </div> 
        </div> 
    <?php }?>
    <div class="credit"> All rights reserved|<span>2022</span></div>
</section>