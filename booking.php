<html>
    <head>
        <title>Passenger Detail</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="simple.css">

        <style>
            body {
                background-color: #E8F5E9;
                font-family: "Poppins","Roboto", sans-serif;
                margin:0;
                background-image: url(metro15.jpg);
            }
            .ticket-box{
                width: 50%;
                margin: 50px auto;
                padding: 20px;
                background-color: #ffffff;
                border: 2px solid #1B5E20;
                border radius: 10px;
                box-shadow: 0px 4px 12px rgba(0,0,0,0.5);
                text-align: left;
            }
            .ticket-box h1{
                text-align:center;
                color: #333333;
                margin-top:1px;
                font-size:25px;
            }
            .ticket-box p{
                font-size: 18px;
                color: #5A6A8D;
                margin:7px 0;
            }
            .ticket-box p span{
                font-weight: bold;
                color: #1A237E;
            }
            .ticket-box .travel-id{
                font-size:20px;
                font-weight:bold;
                color: #1B5E20;
                text-align:center;
                margin-top:10px;
            }

        </style>
    </head>
    <body>  

<?php

$host="localhost";
$username="root";
$password="";
$dbname="metroconnect";

$conn= mysqli_connect($host,$username,$password,$dbname);

if($conn->connect_error){
    die("connection failed");
}
else{
    echo"Data Collected Succesfully...";
}

$from=$_POST['from'];
$to=$_POST['to'];
$pname=$_POST['pname'];
$jdate=$_POST['jdate'];
$time=$_POST['time'];
$gender=$_POST['gender'];

$data= "INSERT INTO booking_DB VALUES('$from','$to','$pname','$jdate','$time','$gender')";
$check=mysqli_query($conn,$data);
if($check){

    echo '<div class="ticket-box">';
    echo "<br><h1>Passenger Details - </h1><br>";
    echo "<br><p>Journey Start : <span>".$from."</span></p><br>";
    echo " <p>Journey End : <span>".$to."</p> </span>";
    // echo " <p>Fare Price : <span>".$fare."</p> </span>";
    echo "<br> <p> Passenger Name : <span>".$pname."</p> </span>";
    echo "<br> <p> Date of Journey : <span>".$jdate."</p> </span>";
    echo "<br> <p> Departure Time : <span>".$time."</p> </span><br> Your ticket will be expire after 24 hrs.";
    echo "<br> <p> Gender : <span>".$gender."</p> </span>";
    $random = uniqid();
    echo '<br> <div class="travel-id">Your Traveling ID : <span>'.$random.'</span></div>';

    // it is an liberary for creating QR codes. Without this lib we cannot use QRcode::png().
    require('phpqrcode/qrlib.php');
    
                // Check if qr_codes directory exists, if not create it. it is the place where all QR code ae stored
    $qr_dir = 'qr_codes/';
    if (!file_exists($qr_dir)) {
        mkdir($qr_dir, 0777); // Create directory with full permissions. mkdir stands for make directory. 
                                    // 0777 is used for giving full read, write permissions for owner, group,etc.
    }
    $filename = $qr_dir . $random . '.png';
    QRcode::png('Passenger: ' . $pname . ', From: ' . $from . ', To: ' . $to . ', Date: ' . $jdate, $filename, QR_ECLEVEL_L, 5);

    // Display the QR code image
    echo "<br><img src='" . $filename . "' alt='QR Code'><br>";
    echo "</div>";
}
else{
    echo "<br>Error. Please Try Again.";
}
$conn->close();

?>


</body>
</html>
