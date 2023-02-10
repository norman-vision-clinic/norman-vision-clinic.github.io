<?php
$date = $_POST['Date'];
//$time = $_POST['Time'];
$time = 12345;
$firstname = $_POST['Firstname'];
$lastname = $_POST['Lastname'];
$phonenumber = $_POST['Phonenumber'];
$emailaddress = $_POST['Emailaddress'];

function countDigits($str)
{
    return preg_match_all( "/[0-9]/", $str);
}
function cleanTime($string){
    return preg_replace('/[^0-9\:,]*/' , '', $string);
}
function removeSpecialChars($st){
    return str_replace(array('?', '\"', '+', '!', '$', '#', '%', '^', ':', '|', '}', '{', ']', '[', '&', '_', '/', '<', '>', '.', ',', '/', '\\', '\'', '`', '~', '*', '(', ')', ';'), '', $st);
}
function removeSpecialCharsAndNumbers($s){
    return str_replace(array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '?', '\"', '+', '!', '$', '#', '%', '^', ':', '|', '}', '{', ']', '[', '&', '_', '/', '<', '>', '.', ',', '/', '\\', '\'', '`', '~', '*', '(', ')', ';'), '', $s);
}

if(is_null($date) || $date == "" ||
   is_null($time) || $time == "" ||
   is_null($firstname) || $firstname == "" ||
   is_null($lastname) || $lastname == "" ||
   is_null($phonenumber) || $phonenumber == ""){//making sure all requried fields are populated

    echo"<h3>Please fill out all fields</h3>";
}
else{
    $amountOfNumericsInPhoneNumber = countDigits($phonenumber);
    if($amountOfNumericsInPhoneNumber != 10){
        echo "<h3>Please enter a valid phone number</h3>";
    }
    else{
        $phonenumberCleaned = preg_replace('/\D/', '', $phonenumber);
        if(strlen($date) != 10){
            echo "<h3>An Error has occured</h3>";
            exit;
        }
        else{
            $dateCleaned = explode("-", $date);
            $year=$dateCleaned[0];
            $month=$dateCleaned[1];
            $day=$dateCleaned[2];
            $dateFormatted = $month."/".$day."/".$year;

            if(strlen($time) != 5){
                echo "<h3>An error has occured</h3>";
                exit;
            }
            else{
                $timeCleaned = cleanTime($time);
                $firstnameCleaned = removeSpecialCharsAndNumbers($firstname);

                if(strlen($firstnameCleaned)==1){
                    echo "<h3>Please fill out the first name field</h3>";
                }
                else{
                    $lastnameCleaned = removeSpecialCharsAndNumbers($lastname);

                    if(strlen($lastnameCleaned)==1){
                        echo "<h3>Please fill out the last name field</h3>";
                    }
                    else{
                        $name = $firstnameCleaned . " " . $lastnameCleaned;
                        $msg = "Client's Name: ".$name."\n Date Requested: ".$dateFormatted."\n Client's Phone: ".$phonenumberCleaned."\n Client's Email: ".$emailaddress;

                        echo "<h3>Your appointment request has been sent in,<br>Thank you!</h3>";
?>
<script>
    $(document).ready(function(){
        $('#formWrapper').hide();
    });
</script>
<?php
                        mail("june.normanvision@gmail.com","Online Appointment Schedule Notification ",$msg);
//                        mail("jeremy@tetonsolutionsgroup.com","Online Appointment Schedule Notification ",$msg);


                    }
                }
            }
        }
    }
}
?>