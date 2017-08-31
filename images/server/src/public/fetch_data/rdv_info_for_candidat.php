 <?php
	include("../connect.php");

	$selected_site_libelle = $_GET['sitelibelle'];
	$maximun_number_of_data = $_GET['maxNbOfData'];
	$offset = $_GET['offset'];

	$fetch_all_sites_query = 'SELECT r.RDVId, r.Nom AS rdvNom, r.Prenom AS rdvPrenom, r.ContactId, r.HeurePrevu, r.HeurePriseEnCharge, r.isValide, r.isRelance1, tmp.Nom AS contactNom, tmp.Prenom AS contactPrenom, tmp.TelMobile FROM (SELECT s.SiteId, c.ContactId, c.Nom, c.Prenom, c.TelMobile FROM site s, contact c WHERE s.SiteId = c.SiteId) AS tmp, rendezvous r WHERE tmp.ContactId = r.ContactId order by RDVId limit '.$maximun_number_of_data.' offset '.$offset.';';

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