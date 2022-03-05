<?php
//main variables
$username = filter_input( INPUT_POST, 'username' );
$password = filter_input( INPUT_POST, 'password' );

$studentid = filter_input( INPUT_POST, 'studentid' );
$email = filter_input( INPUT_POST, 'email' );
$dateofbirth = filter_input( INPUT_POST, 'dateofbirth' );
$phonenumber = filter_input( INPUT_POST, 'phonenumber' );

//pasword being hased and salted
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

//medical information
$medicalconditions = filter_input( INPUT_POST, 'medicalconditions' );
$doctorinformation = filter_input( INPUT_POST, 'doctorinformation' );
$kininfo = filter_input( INPUT_POST, 'kininfo' );

// encryption of personal data 
$cipherring = "AES-128-CTR";            // Storing the cipher method (ctr = safest choice)
$option = 0;                            // Storing the bitwise disjunction of the flags
$encryption_iv = "1234567891234567";    // Storing the initialization vector which is not null
$encryption_key = "1234567891234567";   // Storing the encryption key (must be 16 bits of length)

$encryptedemail = openssl_encrypt($email,$cipherring,$encryption_iv,$option,$encryption_key);
$encryptedkininfo = openssl_encrypt($kininfo,$cipherring,$encryption_iv,$option,$encryption_key);

// If passed username isn't empty, continue to check for next item and so on.
if ( !empty( $username ) ) {  
    if ( !empty( $hashed_password ) ) {
        if ( !empty( $studentid ) ) {
            if ( !empty( $encryptedemail ) ) {
                if ( !empty ( $dateofbirth ) ) {
                    if ( !empty ( $phonenumber ) ) {
                        if ( !empty ( $medicalconditions ) ) {
                            if ( !empty ( $doctorinformation ) ) {           
                                if ( !empty ( $encryptedkininfo ) ) {   

                                    $host = "localhost";
                                    $dbusername = "root";
                                    $dbpassword = "";
                                    $dbname = "studentinfo";

                                    // Create connection

                                    $conn = new mysqli ( $host, $dbusername, $dbpassword, $dbname);

                                    if ( mysqli_connect_error() ) {
                                        die( 'Connect Error ('. mysqli_connect_errno() .') '. mysqli_connect_error() );
                                    } 
                                    
                                    // If connection wasn't closed, Insert the items into table "account"
                                    
                                    else {
                                        $sql = "INSERT INTO account 
                                        (username,
                                        password,
                                        studentid, 
                                        email,
                                        dateofbirth,
                                        phonenumber,
                                        medicalconditions,
                                        doctorinformation,
                                        kininfo
                                        )
                                        
                                    values 
                                    ('$username',
                                    '$hashed_password',
                                    '$studentid',
                                    '$encryptedemail',
                                    '$dateofbirth',
                                    '$phonenumber',
                                    '$medicalconditions',
                                    '$doctorinformation',
                                    '$encryptedkininfo'
                                    )";
                                    
                                    // If query has been made, print out a message else, throw connection error.
                                        
                                        if ( $conn->query( $sql ) ) {
                                            echo "Successfully Registered";
                                        } 

                                        else {
                                            echo "Error: ". $sql ."
                                        ". $conn->error;
                                        }

                                        $conn->close();
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}

?>
