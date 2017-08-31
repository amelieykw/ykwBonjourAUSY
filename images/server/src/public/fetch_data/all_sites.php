<?php
	
	include("../connect.php");

	$fetch_all_sites_query = "SELECT SiteId, Libelle FROM site";

	try {
			// On récupère tout le contenu de la table site
			$reponse = $bdd->query($fetch_all_sites_query);
			// On affiche chaque entrée une à une
			$donnees = $reponse->fetchall();

			// Print JSON encode of the array.
			echo(json_encode($donnees));

			$reponse->closeCursor(); // Termine le traitement de la requête

		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}

		$bdd = null;

        exit();
?>