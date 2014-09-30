<?php
	$root_dir = $_SERVER['DOCUMENT_ROOT'] ;
	$uploaddir = "$root_dir/model/" ;
	$file_name = basename($_FILES['file']['name']) ;
	$uploadfile = $uploaddir . $file_name;
	if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
	    // on redirige vers la page en renvoyant le chemin du fichier téléversé
	    
	    
	} else {
	    echo "Attaque potentielle par téléchargement de fichiers.
	          Voici plus d'informations :\n";
	}

	$_SESSION['file_name'] = $file_name ;
	var_dump($_SESSION);exit;
	//header('Location: http://localhost/teapot/');
?>