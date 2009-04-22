<?php
	if(isset($_GET['page'])){
		$page = $_GET['page'];
	}else{
		$page = "videoEthno";
	}

   // Connexion à la base de données
   $link = mysql_connect("mysql", "user02150", "mundigo")
       or die("Impossible de se connecter : " . mysql_error());
     
    // Sélection de la base de données
    mysql_select_db("db0215001", $link);
	
	$repSpip = "spip/";
   
	switch ($page) {
		case 'videoEthno':
			$sql = "SELECT d.fichier, a.titre, a.texte, a.descriptif
			FROM spip_documents d
				INNER JOIN spip_documents_articles da ON d.id_document = da.id_document
				INNER JOIN spip_articles a ON a.id_article = da.id_article AND a.id_rubrique = 3
			WHERE id_type =53";
			$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
			echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
				<player showDisplay=\"yes\" showPlayer=\"yes\" showPlaylist=\"no\" autoStart=\"no\">		
					";
			while($r = mysql_fetch_assoc($req)) 
			{
				echo "		<song path=\"".$repSpip.$r['fichier']."\" title=\"".utf8_encode($r['titre'])."\" comments=\"".utf8_encode($r['texte'])."\"/>
				";
			}         
			echo "</player>";
			break;
		case 'mundigo':
			//la charte
			$sql = "SELECT texte, titre
				FROM spip_rubriques 
				WHERE id_rubrique = 20";
			$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
			echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
				<pages >		
					";
			while($r = mysql_fetch_assoc($req)) 
			{
				echo "		<page titre=\"".utf8_encode($r['titre'])."\" comments=\"".utf8_encode($r['texte'])."\"/>
				";
			}         
			echo "</pages>";
			break;
		case 'annonce':
			echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
				<pages >		
					";
			//a l'affciche
			$sql = "SELECT a.texte, a.titre
			FROM spip_articles a
			WHERE a.id_rubrique = 33
			ORDER BY a.maj DESC
			LIMIT 0 , 1";
			$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
			$r = mysql_fetch_assoc($req); 
			echo "		<page titre=\"".utf8_encode($r['titre'])."\" comments=\"".utf8_encode($r['texte'])."\"/>
				";
			//a venir
			$sql = "SELECT a.texte, a.titre
			FROM spip_articles a
			WHERE a.id_rubrique = 7
			ORDER BY a.maj DESC
			LIMIT 0 , 1";
			$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
			$r = mysql_fetch_assoc($req); 
			echo "		<page titre=\"".utf8_encode($r['titre'])."\" comments=\"".utf8_encode($r['texte'])."\"/>
				";
			//Ethno clip
			$sql = "SELECT texte, titre
			FROM spip_rubriques 
			WHERE id_rubrique = 3";
			$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
			$r = mysql_fetch_assoc($req); 
			echo "		<page titre=\"".utf8_encode($r['titre'])."\" comments=\"".utf8_encode($r['texte'])."\"/>
				";
			//Actu 0 et 1
			$sql = "SELECT a.texte, a.titre, d.fichier
			FROM spip_articles a
				LEFT JOIN spip_documents_articles da ON da.id_article = a.id_article
				LEFT JOIN spip_documents d ON d.id_document = da.id_document 
			WHERE a.id_rubrique = 6
			ORDER BY a.date DESC
			LIMIT 0 , 2";
			$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
			while($r = mysql_fetch_assoc($req)){ 
				echo "		<page titre=\"".utf8_encode($r['titre'])."\" comments=\"".utf8_encode($r['texte'])."\" path=\"".$repSpip.$r['fichier']."\"/>
					";
			}
			echo "</pages>";
			break;
	}	
	
    // Fermeture de la connexion MySQL   
   mysql_close($link);

?>