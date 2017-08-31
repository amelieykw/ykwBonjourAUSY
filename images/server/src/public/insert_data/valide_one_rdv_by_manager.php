<?php
	include("../connect.php");

	$selected_rdv_id = $_GET['RDVId'];

	$update_rdv_validation_by_manager_query = 'UPDATE rendezvous SET isValide=1, HeurePriseEnCharge=NOW() WHERE RDVID='.$selected_rdv_id;

	$update_tempsRetard_query = 'UPDATE rendezvous SET TempsRetard=TIMEDIFF(HeurePriseEnCharge, HeurePrevu) WHERE RDVID='.$selected_rdv_id;

	$select_rdv_isValide = 'SELECT isValide FROM rendezvous WHERE RDVId ='.$selected_rdv_id;

	try {

		$bdd->query($update_rdv_validation_by_manager_query);

		$reponse = $bdd->query($select_rdv_isValide);
		// On affiche chaque entrée une à une
		$donnees = $reponse->fetchall();;

		// Print JSON encode of the array.
		echo(json_encode($donnees));

		$reponse->closeCursor(); // Termine le traitement de la requête

	} catch (PDOException $e) {
		echo $sql . "<br>" . $e->getMessage();
	}

	$bdd = null;
	

    exit();
?>