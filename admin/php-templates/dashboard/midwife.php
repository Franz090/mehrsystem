<?php 
if ($admin==0) {
    include_once('script.php');
?> 

<div class="container-fluid default"> 
Midwife <br/>
    <div class="row mt-5 col-sm-12">
        
        <div class="col-md-6 col-sm-12 d-flex justify-content-center">
            <div id="piechart" class="chart"
                style="bottom:200px; width: 400px;height 200px;"> </div>
        </div>
        <div class="col-md-6 col-sm-12 d-flex justify-content-center">
            <div id="columnchart_material" class="columnchart"> </div>
        </div>
    </div>  
    <table class="table mt-5 table-striped table-sm col-sm-12">
        <thead class="table-dark">
            <tr>
            <th scope="col">#</th>
            <th scope="col">Infant Birth Names</th>
            <th scope="col">Vaccination Status</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>

        <?php if (count($infant_list)==0) { ?> 
            <tr> 
                <td colspan='4' style="text-align:center">No Infant Records</td> 
            </tr> 
        <?php } else 
            foreach ($infant_list as $key => $value) { ?> 
            <tr>
                <th scope="row"><?php echo ($key+1);?></th>
                <td><?php echo $value['name'];?></td>
                <td><?php echo $value['status'];?></td>
                <td>
                    <a href="edit-infant.php?id=<?php echo $value['id'] ?>">
                        <button class="edit btn btn-success btn-sm btn-inverse">Edit</button></a>
                    <!-- <a href="delete-infant.php?id=<?php //echo $value['id'] ?>">  -->
                        <button class="del btn btn-danger btn-sm btn-inverse" onclick="temp_func()">
                        Delete</button> 
                    <!-- </a>     -->
                </td>
            </tr> 
        <?php } ?>
            
        </tbody>
    </table>
    <div> 
        <div>  
            Total Number of Patients: <?php echo $total_patients ?>  
        </div>
        <div>  
            Appointments Today: <?php echo $appointments_today ?>  
        </div>
        <div>  
            Tetanus Toxoid Vaccinated Patients: <?php echo isset($total_vacc)?$total_vacc:0 ?>  
        </div> 
    </div>
</div>
 
<!-- <div class="container">
    <div class="row bg-light m-3 con1"></div>
</div> -->

<?php 
}
?>