<?php
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
  header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
   
  include("../connect.php");
  include("../authentication/verify_jwt_token.php");

  // Authorization
  if($_SERVER['HTTP_AUTHORIZATION']) {
    $currentUserToken = $_SERVER['HTTP_AUTHORIZATION'];
    $currentUser = explode('.', $currentUserToken);
    preg_match('{"username":"(.*?)"}', base64_decode($currentUser[1]), $match);
    $currentUsername = $match[1];

    try {
      $response = $bdd->query("SELECT * from administrateur WHERE login='$currentUsername'");

      if($response->rowCount() == 1) {
        $donnees = $response->fetch();
        // verify token
        $authorization_result = verify_jwt_token($donnees['AdminId'], $donnees['login'], $donnees['password'], $currentUserToken);

        if($authorization_result == true) {
        	// the true DB operation method
    			$reponse = $bdd->query("SELECT ContactId, Nom, Prenom FROM contact");
    			$donnees = $reponse->fetchall();
    			echo(json_encode($donnees));
    			$reponse->closeCursor(); 
        }       
      }
    }catch(PDOException $e){
      echo $sql . "<br>" . $e->getMessage();
    } 
  }else{
    echo $_SERVER['HTTP_AUTHORIZATION'];
  }

  $bdd = null;
  exit();
?>

