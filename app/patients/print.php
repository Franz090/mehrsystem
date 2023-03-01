<?php 
  require ("invoice/fpdf/fpdf.php");

  @include '../includes/config.php';

  $user_id = $_GET['user_details_id'];
  $c_id_str = "";
  if (isset($_GET['c_id'])) { 
    $c_id_str = "AND consultations.consultation_id=".$_GET['c_id']; 
  }

  $sql_select = "SELECT *, user_details.first_name, user_details.last_name FROM consultations 
  INNER JOIN user_details ON consultations.patient_id = user_details.user_id WHERE user_details.user_id = $user_id $c_id_str";
  // echo $sql_select;
  // query for selecting consultation and user details
  $query = mysqli_query($conn, $sql_select);

  $cons_list = []; // array container for consultatio details

  // Get consultation details
  foreach($query as $rows) {
    $first_name = $rows["first_name"];
    $last_name = $rows["last_name"];
    $midwife_id = $rows["midwife_appointed"];
    $cons_date = $rows["date"];
    $trimester = $rows["trimester"];
    $gestation = $rows["gestation"];
    $weight = $rows["weight"];
    $height = $rows["height_ft"] . "'" . $rows["height_in"] . '"';
    $presc = $rows["prescription"];
    $advice = $rows["advice"];

    // push other consultation details to array 
    array_push($cons_list, array(
      'cons_date' => $cons_date,
      'trimester' => $trimester,
      'gestation' => $gestation,
      'weight' => $weight,
      'height' => $height,
      'presc' => $presc,
      'advice' => $advice
    ));
    // push other consultation details to array 
  }

  // query for selecting brgy of user
  $select_brgy = mysqli_query($conn, "SELECT barangays.health_center FROM patient_details
  INNER JOIN barangays ON patient_details.barangay_id = barangays.barangay_id 
  WHERE patient_details.user_id = $user_id");

  // Get brgy details
  foreach($select_brgy as $row) {
    $brgy = $row["health_center"];
  }

  // query for selecting midwife
  $select_midwife = mysqli_query($conn,"SELECT first_name, last_name FROM user_details WHERE user_id = $midwife_id");

  // Get midwife
  foreach($select_midwife as $row) {
    $midwife = $row["first_name"] . " " . $row["last_name"];
  }

  //customer and invoice details
  $info=[
    "customer"=> $first_name . " " . $last_name ,
    "address"=> "Barangay" . " " . $brgy,
    "midwife"=> $midwife,
    "invoice_date"=> date('d-m-y'),
    "total_amt"=>"5200.00",
    "words"=>"Rupees Five Thousand Two Hundred Only",
  ];
  
  class PDF extends FPDF
  {
    function Header(){
      
      //Display Company Info
      $this->SetFont('Arial','B',14);
      $this->Cell(50,10,"MEHR",0,1);
      $this->SetFont('Arial','',14);
      $this->Cell(50,7,"Sta. Cruz, Laguna",0,1);
      
      //Display INVOICE text
      $this->SetY(15);
      $this->SetX(-70);
      $this->SetFont('Arial','B',18);
      $this->Cell(50,10,"MEDICAL RECEIPT",0,1);
      
      //Display Horizontal line
      $this->Line(0,48,210,48);
    }
    
    function body($info,$cons_list){
      
      //Billing Details
      $this->SetY(55);
      $this->SetX(10);
      $this->SetFont('Arial','B',12);
      $this->Cell(50,10,"Patient Details: ",0,1);
      $this->SetFont('Arial','',12);
      $this->Cell(50,7,$info["customer"],0,1);
      $this->Cell(50,7,$info["address"],0,1);
      
      //Display Invoice no
      
      $this->SetY(55);
      $this->SetX(-70);
      $this->SetFont('Arial','B',12);
      $this->Cell(50,7,"Midwife: ".$info["midwife"]);
      
      //Display Invoice date
      $this->SetFont('Arial','',12);
      $this->SetY(63);
      $this->SetX(-70);
      $this->Cell(50,7,"Date : ".$info["invoice_date"]);
      
      //Display Table headings
      $this->SetY(85);
      $this->SetX(10);
      $this->SetFont('Arial','B',12);
      $this->MultiCell(0, 10, "CONSULTATION(S)", 'LRTB');
      $this->SetFont('Arial','',12);
      
      //Display table product rows
      foreach($cons_list as $row){
        $this->SetFont('Arial','B',12);
        $this->MultiCell(0, 10, "Date: " . substr($row["cons_date"], 0, 11), 'LR', false);
        $this->SetFont('Arial','',12);
        $this->MultiCell(0, 10, "Trimester: " . $row["trimester"], 'LR', false);
        $this->MultiCell(0, 10, "Gestation: " . $row["gestation"], 'LR', false);
        $this->MultiCell(0, 10, "Weight: " . $row["weight"], 'LR', false);
        $this->MultiCell(0, 10, "Height: " . $row["height"], 'LR', false);
        $this->MultiCell(0, 10, "Prescription: " . $row["presc"], 'LR', false);
        $this->MultiCell(0, 10, "Advice: " . $row["advice"], 'LRB', false);
      }
    }
    
  }
  //Create A4 Page with Portrait 
  $pdf=new PDF("P","mm","A4");
  $pdf->AddPage();
  $pdf->body($info,$cons_list);
  $pdf->Output();
?>