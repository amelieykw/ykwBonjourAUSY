<?php
	try
	{
	    $bdd = new PDO('mysql:host=mysql;dbname=bonjourausy;charset=latin1', 'root', 'admin', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	catch (Exception $e)
	{
	    die('Erreur : ' . $e->getMessage());
	}

?>