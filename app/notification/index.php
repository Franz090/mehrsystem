<?php
@include '../includes/config.php';
session_start();

@include '../php-templates/redirect/admin-page-setter.php';
$page = 'notification';
include_once('../php-templates/admin-navigation-head.php');


?>

 
<div class="container_nu">

  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php');  ?>
  

  <!-- Page Content -->
  <div class="main_nu" >
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid default">
      <div class="background-head row m-2 my-4">
        <div style="display:flex; justify-content: space-between; margin-bottom: 10px;">
            <h4 class="fw-bolder">Notifications</h4>
            <?php if($notifCount) {?>
                <button class="btn btn-primary pull-right" id="mark-all">Mark all as read</button>
            <?php } ?>
        </div>
        
        <div class="table-padding table-responsive">
          <div class="pagination-sm col-md-8 col-lg-12 " id="table-position">
           <table class="table mt-5 table-lg display" id="datatables">
            <thead class="table-light text-left" colspan="3">
              <tr>
                <th></th>
                <th style="text-align: left !important;" scope="col">Message</th> 
                <th style="text-align: left !important;" scope="col">Created Date</th>  
              </tr>
            </thead>
            <tbody>
            <?php
                $getNotification = $onloadData->getNotification();
                while ($data = $getNotification->fetch()) {
             ?>
                <tr  class="<?php echo $data['status'] ? '':'bg-light text-dark'?> style='max-width: 28rem;border-radius: 200px;'">
                    <td>
                        <h4 class="change-status" style="cursor: pointer;" data-id="<?php echo $data['id'] ?>" data-status="<?php echo $data['status'] ?>">
                            <?php 
                                if($data['status']) {
                                    echo '<ion-icon name="eye-outline" style="padding-bottom: 5px;padding-top: 5px;"></ion-icon>';
                                } else {
                                    echo '<ion-icon name="eye-off-outline" style="padding-bottom: 5px;padding-top:5px;"></ion-icon>';
                                }
                            ?>
                        </h4>
                    </td>
                    <td ><?php echo $data['message']?></td>
                    <td><?php echo date('m-d-Y h:i a', strtotime($data['created_date']))?></td>
                </tr>
            <?php  
                }
            ?>
            </tbody>
          </table>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>

<script>
    $(document).ready( function () {
        $('#datatables').DataTable({
          "order": [],
          destroy: true,
          fixedColumns: true,
          responsive: true,
          language:{
            search: "_INPUT_",
            searchPlaceholder: "Search Notification",
          }
        });

        var url = '../controller/notificationController.php';
        $('#mark-all').on('click', function() {
            $.SystemScript.swalConfirmMessage('Are you sure', 
            'Do you want to mark all notification as read?', 'question').done(function(response) {
                if(response) {
                    let path = url + `?command=markAllNotifRead`;
                    $.SystemScript.executeGet(path).done((res) => {
                        console.log(res);
                        if(res.data.status == 'success') {
                            $.SystemScript.swalAlertMessage('Successfully',`${res.data.message}`, 'success');
                            $('.swal2-confirm').click(function(){
                                location.reload();
                            });
                        } else {
                            $.SystemScript.swalAlertMessage('Error',`${res.data.message}`, 'error');
                        }
                    });
                }
            });
        })


        $(".change-status").on('click', function(){
            const notif_id = $( this ).data( "id" );
            const notif_status = $( this ).data( "status" );
            let path = url + `?command=changeNotifStatus&notif_id=${notif_id}&status=${notif_status}`;
            $.SystemScript.executeGet(path).done((res) => {
                console.log(res);
                if(res.data.status == 'success') {
                    location.reload();
                } else {
                    $.SystemScript.swalAlertMessage('Error',`${res.data.message}`, 'error');
                }
            });
        })
    });
  </script>