<?php
	include("connect.php");

   	if( $_POST["selected_insert_original_data_file"] ) {

   		$selected_insert_original_data_file = $_POST["selected_insert_original_data_file"];

   		try {
			$filename = $selected_insert_original_data_file;
			$file = fopen($filename, "r");

			if($file == false){
				echo "Erreur pour ouvrir ce ficher";
				exit();
			}

			$filesize = filesize($filename);
			$filetext = fread($file, $filesize);
			fclose($file);

			// Table structure for table `site`
			$sql_insert_table_site = $filetext;

			$bdd->exec($sql_insert_table_site);


			echo 'Bien insérer les données dans la table avec le ficher '.$selected_insert_original_data_file;


		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}


		$bdd = null;

        exit();
   	}
?>
