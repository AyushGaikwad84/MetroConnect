<?php

$host="localhost";
$username="root";
$password="";
$dbname="metroconnect";

$conn=mysqli_connect($host,$username,$password,$dbname);

if($conn->connect_error){
    die("connection failed");
}
else{
    echo "<b>Database Connected</b><br>";
}

//  here this $_server is used to check whether the data is sent using POST method or not
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $name= $_POST['name'];    
    $email= $_POST['email'];  
    $username= $_POST['username']; 
    $userpass= $_POST['userpass']; 
    $confirmpass = $_POST['confirmpass'];

        if($userpass == $confirmpass)
        {

            $data = "INSERT INTO registeration_table VALUES ('$name','$email','$username','$userpass')";
            $check=mysqli_query($conn,$data);

                if($check){
                    echo "Registered Successfully <br> Welcome <b>".$username."</b>";
                    header("refresh:3; url=log.html");
                    echo "<br><br>You will be Redirect to login Page in 5 seconds.<br> Login Yourself Before Booking Online Ticket.";
                    exit;
                }
                else{
                    echo "error... There is an error While Inserting Data into Database.";
                }

        }  //this is close of password match 'if' statement.
        else{
            echo "<br> Password Doesn't Match to Your Confirm Password <br> Please Try Again...";
        }

}  // this is close of $server 'if' statement.
else{
    echo "Form not Submitted...";
}


$conn->close();

?>