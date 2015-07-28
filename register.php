<?php

//register.php

/**
 * Start the session.
 */
session_start();

$response = array();
/**
 * Include ircmaxell's password_compat library.
 */
require 'password.php';

/**
 * Include our MySQL connection.
 */
require 'connect.php';


//If the POST var "register" exists (our submit button), then we can
//assume that the user has submitted the registration form.
if(isset($_POST['register'])){
    
    //Retrieve the field values from our registration form.
	$name = !empty($_POST['name']) ? trim($_POST['name']) : null;
    $email = !empty($_POST['email']) ? trim($_POST['email']) : null;
    $password = !empty($_POST['password']) ? trim($_POST['password']) : null;
	$gender = !empty($_POST['gender']) ? trim($_POST['gender']) : null;
	$bgroup = !empty($_POST['bgroup']) ? trim($_POST['bgroup']) : null;
	$phone = !empty($_POST['phone']) ? trim($_POST['phone']) : null;
	$country = !empty($_POST['country']) ? trim($_POST['country']) : null;
	$state = !empty($_POST['state']) ? trim($_POST['state']) : null;
	$city = !empty($_POST['city']) ? trim($_POST['city']) : null;
	$address = !empty($_POST['address']) ? trim($_POST['address']) : null;
	$candonate = !empty($_POST['candonate']) ? trim($_POST['candonate']) : null;
	$description = !empty($_POST['description']) ? trim($_POST['description']) : null;
	$weight = !empty($_POST['weight']) ? trim($_POST['weight']) : null;
	$age = !empty($_POST['age']) ? trim($_POST['age']) : null;
	$deviceid = !empty($_POST['deviceid']) ? trim($_POST['deviceid']) : null;
	
    
    //TO ADD: Error checking (email characters, password length, etc).
    //Basically, you will need to add your own error checking BEFORE
    //the prepared statement is built and executed.
    
    //Now, we need to check if the supplied email already exists.
    
    //Construct the SQL statement and prepare it.
    $sql = "SELECT COUNT(email) AS num FROM userinfo WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    
    //Bind the provided email to our prepared statement.
    $stmt->bindValue(':email', $email);
    
    //Execute.
    $stmt->execute();
    
    //Fetch the row.
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //If the provided email already exists - display error.
    //TO ADD - Your own method of handling this error. For example purposes,
    //I'm just going to kill the script completely, as error handling is outside
    //the scope of this tutorial.
    if($row['num'] > 0){
		$response["success"] = 0;
        $response["message"] = "Oops! An error occurred.";
		
        
        // echoing JSON response
        echo json_encode($response);
        //die('That email already exists!');
    }
    else
	{
    //Hash the password as we do NOT want to store our passwords in plain text.
    $passwordHash = password_hash($password, PASSWORD_BCRYPT, array("cost" => 12));
    
    //Prepare our INSERT statement.
    //Remember: We are inserting a new row into our users table.
    $sql = "INSERT INTO userinfo (name, email, password, gender, bgroup, phone, country, state, city, address, candonate, description, weight, age, deviceid) VALUES (:name, :email, :password, :gender, :bgroup, :phone, :country, :state, :city, :address, :candonate, :description, :weight, :age, :deviceid)";
    $stmt = $pdo->prepare($sql);
    
    //Bind our variables.
	$stmt->bindValue(':name', $name);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', $passwordHash);
	$stmt->bindValue(':gender', $gender);
	$stmt->bindValue(':bgroup', $bgroup);
	$stmt->bindValue(':phone', $phone);
	$stmt->bindValue(':country', $country);
	$stmt->bindValue(':state', $state);
	$stmt->bindValue(':city', $city);
	$stmt->bindValue(':address', $address);
	$stmt->bindValue(':candonate', $candonate);
	$stmt->bindValue(':description', $description);
	$stmt->bindValue(':weight', $weight);
	$stmt->bindValue(':age', $age);
	$stmt->bindValue(':deviceid', $deviceid);
	

    //Execute the statement and insert the new account.
    $result = $stmt->execute();
    
    //If the signup process is successful.
    if($result){
        //What you do here is up to you!
		$response["success"] = 1;
        $response["message"] = "User successfully Registered.";

		$response["email"] = $email;
		
        // echoing JSON response
        echo json_encode($response);
        //echo 'Thank you for registering with our website.';
    }
	else
	{
		$response["success"] = 0;
    $response["message"] = "Unknown Error";

    // echoing JSON response
    echo json_encode($response);
	}
    
}
}

?>
