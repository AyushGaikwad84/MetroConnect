<html>
    <head>
    <title>Login Page</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="simple.css">

        <style>
            body{
                background-color: #E8F5E9;
                font-family: "Poppins","Roboto", sans-serif;
                margin:0;
            }
            .msg{
                border: 2px solid #5A6A8D;
                background-color: #04AA6D;
                text-align: center;
            }
            p{
                font-size: 30px;
                margin-top: 50px;
                margin-left: 40%;
                margin-right: 40%;
                text-align: center;
                border: 2px solid #5A6A8D;
                border-radius: 10px;
            }
            h2{
                font-size: 20px;
                color: #1A237E;
               margin-left:40%;
               margin-right:40%;
            }
            h3{
                font-size: 17px;
                border: 2px solid #d32a1e;
                text-align: center;
                border-width:20px;
                line-height: 1.5;
                margin-left: 40%;
                margin-right: 40%;
                color: #5A6A8D;
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
    echo " <p>DataBase Connected </p><br>";
}

$username=$_POST['username'];
$password=$_POST['pass'];

$password_check = "SELECT password FROM registeration_table WHERE username = '$username'";
$result = mysqli_query($conn,$password_check);

// this mysqli_num_rows() function is used for check if query returned any rows from database and returns the no. of results(means how many rows found)
if(mysqli_num_rows($result)> 0)
{

    // it fetches the row from result set as an associative array
    $row= mysqli_fetch_assoc($result);
    $storedpass = $row['password'];

     if ($password === $storedpass)
    {
     $data = "INSERT INTO login VALUES ('','$username','$password')";
     $check=mysqli_query($conn,$data);
    
        if($check)
        {
            echo '<div class="msg">';
        echo "<h2>Successfully Login <br> Welcome ".$username."</h2>";
        header("refresh:10; url=MetroConnect.html");
        exit;
        echo '</div>';
        echo "You Will redirect automatically to main Page After 10 seconds";
        }
        else{
        echo "<br>Error While Inserting Data";
        }
    }
    else{
    echo "<h3>Incorrect Password</h3>";
    }
}
else{
 echo "<h3>User <b>".$username."</b> not found<br>Please Register Yourself before Log-in</h3>";
//  echo "<h3>Please Register Yourself before Log-in</h3>";
 
}
$conn->close();

?>
</body>
</html>