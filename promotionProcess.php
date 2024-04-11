<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

    session_start();
    //include_once 'includes/functions.inc.php';
    include_once 'includes/dbh.inc.php';
    include_once 'includes/emails.php';
    require_once "functions/checkIfAdminFunction.php"; 

    // Check if user is an admin
    checkIfAdmin();


    // Get PromoStatus
    $promoStatus = 'Active';
    $sqlPromoStatus = "SELECT promoStatus_id FROM PromoStatus WHERE promoStatus = ? ";
    $stmtPromoStatus = mysqli_prepare($conn, $sqlPromoStatus);
    mysqli_stmt_bind_param($stmtPromoStatus, "s", $promoStatus);
    mysqli_stmt_execute($stmtPromoStatus);
    $resultPromoStatus = mysqli_stmt_get_result($stmtPromoStatus);
    $promoStatusRow = mysqli_fetch_assoc($resultPromoStatus);
    if(!$promoStatusRow) {
        die("Promotion Status not found: $promoStatus");
    }

    // Set variable
    $promoStatusId = $promoStatusRow['promoStatus_id'];
    

    // Check if the add promotion button was clicked and if all fields are not empty
    if (isset($_POST["add-promotion-button"]) && !empty($_POST["promotion-name"]) && !empty($_POST["promotion-amount"]) && 
    !empty($_POST["promotion-code"]) && !empty($_POST["start-month"]) && !empty($_POST["start-day"]) && 
    !empty($_POST["end-month"]) && !empty($_POST["end-day"])){

        // Set variables
        $promoName = $_POST["promotion-name"];
        $promoAmount = $_POST["promotion-amount"];
        $promoCode = $_POST["promotion-code"];
        $promoStartMonth = $_POST["start-month"];
        $promoStartDay = $_POST["start-day"];
        $promoEndMonth = $_POST["end-month"];
        $promoEndDay = $_POST["end-day"];

            // SQL to insert info into DB
            $sqlInsertPromo = "INSERT INTO promotion (promoName, promoCode, startDay, startMonth, endDay, endMonth, promoStatus_id ,percentDiscount)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmtInsertPromo = mysqli_prepare($conn, $sqlInsertPromo);
            if (!$stmtInsertPromo) {
                die("Error: " . mysqli_error($conn));
            }
            // Handle errors
            try{
                // Execute
                mysqli_stmt_bind_param($stmtInsertPromo, "ssiiiiii", $promoName, $promoCode, $promoStartDay, $promoStartMonth,
                $promoEndDay, $promoEndMonth, $promoStatusId ,$promoAmount);
                mysqli_stmt_execute($stmtInsertPromo);

                // Check rows if added new info
                if(mysqli_stmt_affected_rows($stmtInsertPromo) > 0) {
                    sendEmailPromoToSubs($conn);
                    header("Location: currentPromotions.php?success=completed");
                    exit();
                }
                else{
                    header("Location: promotions.php?error=notAdded");
                    exit();
                }

            } catch(Exception $e) {
                die("Error: " . $e->getMessage());
            }    
    }
  

