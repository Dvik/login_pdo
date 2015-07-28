<?php

//login.php

/**
 * Start the session.
 */
session_start();
$response = array();


require 'connect.php';


//If the POST var "login" exists (our submit button), then we can
//assume that the user has submitted the login form.
if(isset($_POST['getById'])){
    
    //Retrieve the field values from our login form.
    $id = !empty($_POST['id']) ? trim($_POST['id']) : null;
	
    //Retrieve the user account information for the given email.
    $sql = "SELECT * FROM userinfo WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    
    //Bind value.
    $stmt->bindValue(':id', $id);
    
    //Execute.
    $stmt->execute();
    
    //Fetch row.
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //If $row is FALSE.
    if($user === false){
        //Could not find a user with that email!
        //PS: You might want to handle this error in a more user-friendly manner!
		 $response["success"] = 0;
        $response["message"] = "Oops! An error occurred.";
		echo json_encode($response);
        //die('Incorrect email / password combination!');
    } else{
            $response["success"] = 1;
			$response["message"] = "User found";
			$response["id"] = $user["id"];
			$response["name"] = $user["name"];
			$response["email"] = $user["email"];
			$response["gender"] = $user["gender"];
			$response["bgroup"] = $user["bgroup"];
			$response["phone"] = $user["phone"];
			$response["country"] = $user["country"];
			$response["state"] = $user["state"];
			$response["city"] = $user["city"];
			$response["address"] = $user["address"];
			$response["candonate"] = $user["candonate"];
			$response["description"] = $user["description"];
			$response["weight"] = $user["weight"];
			$response["age"] = $user["age"];
			$response["latitude"] = $user["latitude"];
			$response["longitude"] = $user["longitude"];
			$response["deviceid"] = $user["deviceid"];
			$response["createdDate"] = $user["createdDate"];
			$response["modifiedDate"] = $user["modifiedDate"];

			// echoing JSON response
			echo json_encode($response);
            //Redirect to our protected page, which we called home.php
            //header('Location: home.php');
            //exit;
            
        } 
    }
    

 