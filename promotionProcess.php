<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

    session_start();
    include_once 'includes/functions.inc.php';
    include_once 'includes/dbh.inc.php';

    // If not an admin then they cannot access promotion page
    function promotionAccess() {

        if ((!isset($_SESSION["email"])) || (isset($_SESSION["email"]) && $_SESSION["userType_id"] !== 2)) {

            header("Location: restrictedAccess.php");
            exit();
        }
    }

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
    
    // Set variables 
    $promoStatusId = $promoStatusRow['promoStatus_id'];
    $promoName = $_POST["promotion-name"];
    $promoAmount = $_POST["promotion-amount"];
    $promoCode = $_POST["promotion-code"];
    $promoStartMonth = $_POST["start-month"];
    $promoStartDay = $_POST["start-day"];
    $promoEndMonth = $_POST["end-month"];
    $promoEndDay = $_POST["end-day"];

    // Check if the add promotion button was clicked and if all fields are not empty
    if (isset($_POST["add-promotion-button"]) && !empty($promoName) && !empty($promoAmount) && 
    !empty($promoCode) && !empty($promoStartMonth) && !empty($promoStartDay) && 
    !empty($promoEndMonth) && !empty($promoEndDay)){

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
  
