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
          if( file_get_contents('php://input')) {
            $selectedRdvId = json_decode(file_get_contents('php://input'));

            try{
              $request = $bdd->prepare('UPDATE rendezvous SET isValide=0 WHERE RDVId=:selectedRdvId;');
              $request->execute(array('selectedRdvId' => $selectedRdvId));
            }catch(PDOException $e){
              echo $sql . "<br>" . $e->getMessage();
            } 
          }
        }else {
          echo "token's not right";
        }        
      }else{
        echo "wrong currentUsername";
      }
    }catch(PDOException $e){
      echo $sql . "<br>" . $e->getMessage();
    } 
  }else{
    echo "Authorization not found";
  }

  $bdd = null;
  exit();
?>