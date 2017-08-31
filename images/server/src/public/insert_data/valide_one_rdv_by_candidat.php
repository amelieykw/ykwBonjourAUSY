<?php
	include("../connect.php");

	$selected_rdv_id = $_GET['RDVId'];

	$update_rdv_validation_by_candidat_query = 'UPDATE rendezvous SET isRelance1=1, HeurePrevu=NOW() WHERE RDVID='.$selected_rdv_id;

	$select_rdv_isRelance1 = 'SELECT isRelance1 FROM rendezvous WHERE RDVId ='.$selected_rdv_id;

	try {

		$bdd->query($update_rdv_validation_by_candidat_query);

		$reponse = $bdd->query($select_rdv_isRelance1);
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