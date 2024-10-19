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

                // Generate the QR code file.  dot(.) is a string concatenation operator. It is used to join multiple strings together into one.
                // we used $random for creating unique file name, & .png is an extension. the syntax looks like 'qr_codes/123abc.png'
                // In QRcode::png() 'Passenger' to 'jdate' is the information which is stored in the QR code. 
                // $filename is for path to save it.
                // Error correction level for the QR code, which determines how much data can be restored if the QR code is damaged. QR_ECLEVEL_L (low) allows for 7% error correction.
                // This is the size of QR code 5 means medium.
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

<!-- 
    so now here is explaination of how we create qr code automatically. here is a step by step points - 

        1:  go to browser and search- sourceforge.net/projects/phpqrcode/ . this is an php liberary for creating 2D QR codes. 
            download it and extract file in your project folder 'project sem 5'. and create another folder in your project folder name 
            'qr_codes'.

        2:  add 'require 'phpqrcode/qrlib.php';' in your php code  here is a directory 
                C:\xampp\htdocs\project sem 5\
                ├── booking.php
                └── phpqrcode\
                    ├── qrlib.php
                    └── (other QR code related files)

        3:  if it shows error like this 'Fatal error: Uncaught Error: Call to undefined function ImageCreate()' bez GD liberary is disabled. 
            ImageCreate() fun is not available. to solve this seacrh ' php.ini' and search ';extension=gd' when you find it just remove 
            semicolon(;) save the file and restart apache and MySql server.

        4:  after that if it shows error like this 'Warning: imagepng(qr_codes/66f1982b2791f.png): Failed to open stream: 
            No such file or directory in C:\xampp\htdocs\project sem 5\phpqrcode\qrimage.php on line 43' this tells you that your qr_codes 
            folder is not exist. so create it in your project folder and go to properties and *uncheck* the readonly option and apply. 
            and write code which is on now between 93-103 lines.

        5:  now again run if it shows error of undefined variable $random so write $random= uniqid(); / $random=rand(9999,99999);min,max.

        ---so below add-on notes is given by chatgpt -
        
        1:  Directory Permissions: Ensure that the qr_codes folder has the correct read/write permissions (777) if the system still fails 
            to generate QR codes. You can adjust permissions in the file manager or via a terminal.

        2:  QR Code Size and Error Correction: You can control the size and error correction level of the QR code using the parameters 
            in QRcode::png(). For example, you can set a higher error correction level if needed.

        3:  File Path Validation: Always ensure the file path provided for saving the QR code is valid. If the qr_codes/ folder path is incorrect, 
            it may not save the image.

        4:  Dynamic QR Code Data: The data encoded in the QR code can be dynamically modified by passing additional parameters 
            (e.g., journey details, user info) into the QRcode::png() method.

-->