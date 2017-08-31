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

                  $newRDV = json_decode(file_get_contents('php://input'));

                  try{
                     $request = $bdd->prepare('
                     INSERT INTO rendezvous
                     (Nom, Prenom, ContactId, HeurePrevu, HeurePriseEnCharge, TempsRetard, isValide, isRelance1, isRelanceBUD, isRelanceResp, isRelanceDA, DateCreation, DateModification) 
                     VALUES
                     (:Nom, :Prenom, :ContactId, :HeurePrevu, :HeurePriseEnCharge, :TempsRetard, :isValide, :isRelance1, :isRelanceBUD, :isRelanceResp, :isRelanceDA, :DateCreation, :DateModification)
                     ');

                     $request->execute(array(
                        'Nom' => $newRDV->nom_candidate,
                        'Prenom' => $newRDV->prenom_candidate,
                        'ContactId' => $newRDV->ContactId,
                        'HeurePrevu' => date("Y-m-d $newRDV->hour:$newRDV->minute:s"),
                        'HeurePriseEnCharge' => null,
                        'TempsRetard' => null,
                        'isValide' => 0,
                        'isRelance1' => 0,
                        'isRelanceBUD' => 0,
                        'isRelanceResp' => 0,
                        'isRelanceDA' => 0,
                        'DateCreation' => date("Y-m-d H:i:s"),
                        'DateModification' => date("Y-m-d H:i:s")
                     ));

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