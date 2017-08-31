<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
   
	include("../connect.php");
  	include("../authentication/verify_jwt_token.php");
  	include("../email_alert/create_email.php");

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

                  	$raw_datas = json_decode(file_get_contents('php://input'));
                  	$emailUsage = $raw_datas->emailUsage;
					
					$request = $bdd->prepare('
		                select r.RDVId, r.HeurePrevu, r.Nom, r.Prenom, c.ContactId, c.email from rendezvous r, contact c where r.RDVId = :selectedRdvId AND r.contactId = c.contactId
		            ');
		            $request->execute(array(
		                'selectedRdvId' => $raw_datas->selectedRdvId
		            ));
		            $donnees = $request->fetch();
		                     
		            $heurePrevu = $donnees['HeurePrevu'];
		            $prenomCandidat = $donnees['Prenom'];
		            $nomCandidat = $donnees['Nom'];

                  	switch ($emailUsage) {
                  		case 'ValidationRdv':
	                  		$titre = "Votre rendez-vous est arrivé!";

			                $message = "<html><body>";
							$message .= "<div>Bonjour,</div>";
							$message .= "<div>Votre rdv de <strong>$heurePrevu</strong>, (Mr ou Mme) <strong>$prenomCandidat $nomCandidat</strong> vous attend à l'accueil. Veuillez à valider sa prise en charge sur la borne dédiée.</div>";
							$message .= "<div>Merci et bon entretien!</div>";
							$message .= "<div>Votre application《 Bonjour AUSY 》</div>";
							$message .= "</body></html>";

			                create_email($donnees['email'], $titre, $message);
	                  		break;
	                  	case 'AnnulationRdv':
	                  		$titre = "Votre rendez-vous est annulé!";

			                $message = "<html><body>";
							$message .= "<div>Bonjour,</div>";
							$message .= "<div>Votre rdv de <strong>$heurePrevu</strong> avec (Mr ou Mme) <strong>$prenomCandidat $nomCandidat</strong> est annulé.</div>";
							$message .= "<div>Votre application《 Bonjour AUSY 》</div>";
							$message .= "</body></html>";

			                create_email($donnees['email'], $titre, $message);
	                  		break;
	                  	default:
	                  		break;
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