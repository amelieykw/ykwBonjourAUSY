<?php
   header('Access-Control-Allow-Origin: *');
   header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
   header('Access-Control-Allow-Methods: POST, GET, OPTIONS');

   include("../connect.php");
   include("./create_jwt_token.php");

	if( file_get_contents('php://input')) {

    	// $raw_data = file_get_contents('php://input');

   	$currentUser = json_decode(file_get_contents('php://input'));

      if(isset($currentUser->username) AND isset($currentUser->password)) {
         try{
            $response = $bdd->query("SELECT * from administrateur WHERE login='$currentUser->username'");

            if($response->rowCount() == 1) {
               $donnees = $response->fetch();

               if($currentUser->password == $donnees['password']){
                  $token = create_jwt_token($donnees['AdminId'], $donnees['login'], $donnees['password']);

                  $body = array('token' => $token);
                  $response = array('status' => 200, 'body' => $body);
                  $response = json_encode($response);
                  echo $response;
               }else{
                  $response = array('status' => 200);
                  $response = json_encode($response);
                  echo $response;
               }            
            }else{
               $response = array('status' => 200);
               $response = json_encode($response);
               echo $response;
            }
         }catch(PDOException $e){
            echo $sql . "<br>" . $e->getMessage();
         } 
      }    
	}

	$bdd = null;

    exit();
?>