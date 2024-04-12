<?php
//include_once 'includes/dbh.inc.php';


// Sending email to the users when they update their account
function sendEmailEditProfileSuccess($email) {
    $mail = require "mailer.php";
    $mail->setFrom("noreply@example.com");
    $mail->addAddress($_POST["email-address"]);
    $mail->Subject = "Information Changed";
    $mail->Body = <<<END
        Your personal information was changed successfully!
    END;
    try {
        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
        exit();
    }
}


// Sending email to the subscribed users
function sendEmailPromoToSubs($conn) {
    // Select the users that are subscribed to promos
    $sqlSubUsers = "SELECT email FROM Users WHERE promoSub_id = 1";
    $resultSubUsers = mysqli_query($conn, $sqlSubUsers);

    // Look for subscribed users
    if(mysqli_num_rows($resultSubUsers) > 0) {
        // Loop over the rows
        while($rows = mysqli_fetch_assoc($resultSubUsers)) {
            $email = $rows['email'];
            $mail = require "mailer.php";
            $mail->setFrom("noreply@example.com");
            $mail->addAddress($email);
            $mail->Subject = "New Promotion Available!";
            $mail->Body = <<<END
                We want to kindly inform you that we have a new promotion available for you to use.<br><br>
                Enjoy your time at A2 Movies!<br><br>
                Sincerely A2 Movies Team.
            END;
            try {
                $mail->send();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
                exit();
            }
        }
    }
        
}
