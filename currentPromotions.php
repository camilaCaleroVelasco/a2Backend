<?php
session_start();
if ((!isset($_SESSION["email"])) || (isset($_SESSION["email"]) && $_SESSION["userType_id"] !== 2)) {

    header("Location: restrictedAccess.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA Compatible" content="IE=edge">
    <title>A2 MOVIES</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Enable back on to put style -->
    <link rel="stylesheet" href="css/register.css">


</head>

<body>
    <header>
        <a href="index.php">
            <img class="logo" src="images/A2 Movies Icon.jpeg" alt="logo">
            <!--clicking a2 movies icon will link back to homepage-->
        </a>
    </header>

    <!-- Beginning Field for Register Info -->
    <div class="wrapper"> <!-- div class wrapper starts here -->
        <h1> Current Promotions </h1>        

        <form action="#" method="post"> <!--push info to the DB -->
            <h2> Promotion 1</h2>
             <!-- added promotions info will appear here --> 

        </form>



    </div> <!-- div class wrapper ends here -->


</body>

</html>