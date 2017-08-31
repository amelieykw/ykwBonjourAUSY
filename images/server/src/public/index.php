<?php
	include("./create_table/create_table_query.php");
	include("./insert_data/insert_query_file.php");

	if( $_POST["selected_select_data_query"] ) {
      $selected_select_data_query = $_POST["selected_select_data_query"];
      header( "Location:$selected_select_data_query" );
      
      exit();
   }
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Bonjour AUSY index page</title>
	</head>
	<body>
		<a href="/helloworld.php">redirect to Hello World Page</a><br/>
		<br/>
		<div>
			<p>Choose a file to create a table :</p>
	        <form action = "<?php $_SERVER['PHP_SELF'] ?>" method ="POST">
	         	<select name = "selected_table_create_file">      
		            <option value = "./create_table/create_table_admin.txt">
		            	administrator
		            </option>
		            <option value="./create_table/create_table_sites.txt">
		            	site
		            </option>
		            <option value="./create_table/create_table_contact.txt">
		            	contact
		            </option>
		            <option value="./create_table/create_table_rdv.txt">
		            	rendez-vous
		            </option>
	         	</select>
	            <input type = "Submit" value="Create table"/>
	        </form>
		</div>
		<div>
			<p>Choose a file of original data to insert :</p>
	        <form action = "<?php $_SERVER['PHP_SELF'] ?>" method ="POST">
	         	<select name = "selected_insert_original_data_file">
	         		<option value="./insert_data/administrateur_original.txt">
		            	administrateur
		            </option>      
		            <option value = "./insert_data/sites_original.txt">
		            	sites
		            </option>
		            <option value="./insert_data/contacts_original.txt">
		            	contacts
		            </option>
		            <option value="./insert_data/rendezvous_original.txt">
		            	rendez-vous
		            </option>
	         	</select>
	            <input type = "Submit" value="Insert data"/>
	        </form>
		</div>
		<div>
			<div>
				<p>1. Android MainActivity Button Sites : </p>
				<p>SELECT SiteId, Libelle FROM site 
				<a href="./fetch_data/all_sites.php">./fetch_data/all_sites.php</a></p>
			</div>
			<div>
				<p>2. According to SiteId, Contact JION Rendezvous : </p>
				<p>./fetch_data/rdv_info_of_one_site.php?sitelibelle=Nantes</p>
				<p>./insert_data/valide_one_rdv_by_manager.php</p>
				<!-- <p>
				<a href="./fetch_data/rdv_info_of_one_site.php?sitelibelle=Bordeaux">rdv_info_of_one_site.php</a></p> -->
			</div>
		</div>			
	</body>
</html>