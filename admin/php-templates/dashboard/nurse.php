<?php 
if ($admin==1) {
    include_once('script.php');
?>

<div class="container default">
    Nurse 
    <div class="row mt-5">
        <div class="col-md-6 col-sm-12 d-flex justify-content-center">
            <div id="piechart" class="chart"
                style="bottom:200px;width: 400px;height 200px;">
            </div>
        </div>
        <div class="col-md-6 col-sm-12 d-flex justify-content-center">
            <div id="columnchart_material" class="columnchart">
            </div>
        </div>
    </div>  
</div>

<div class="container default">
    <table class="table mt-5 table-striped table-sm ">
    <thead class="table-dark">
        <tr>
        <th scope="col">#</th>
        <th scope="col">First</th>
        <th scope="col">Last</th>
        <th scope="col">Handle</th>
        </tr>
    </thead>
    <tbody>
        <tr>
        <th scope="row">1</th>
        <td>Mark</td>
        <td>Otto</td>
        <td>@mdo</td>
        </tr>
        <tr>
        <th scope="row">2</th>
        <td>Jacob</td>
        <td>Thornton</td>
        <td>@fat</td>
        </tr>
        <tr>
        <th scope="row">3</th>
        <td>Larry</td>
        <td>the Bird</td>
        <td>@twitter</td>
        </tr>
    </tbody>
    </table>
</div>
<div class="container">
    <div class="row bg-light m-3 con1"></div>
</div>

<?php 
}
?>