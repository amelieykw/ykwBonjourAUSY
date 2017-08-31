<?php

	include("connect.php");

	if( $_POST["selected_table_create_file"] ) {

   		$selected_table_create_file = $_POST["selected_table_create_file"];

   		try {
   			$filename = $selected_table_create_file;
			$file = fopen($filename, "r");

			if($file == false){
				echo "Erreur pour ouvrir ce ficher";
				exit();
			}

			$filesize = filesize($filename);
			$filetext = fread($file, $filesize);
			fclose($file);

			// Table structure for table `site`
			$sql_create_table = $filetext;

			$bdd->exec($sql_create_table);

			echo 'Bien créer la table '.$selected_table_create_file;


		} catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}

		$bdd = null;

        exit();
   	}
?>