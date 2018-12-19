<?php
	function getPosts()
	{
		$db = dbConnect();
		$req = $db->query('SELECT id, titre, contenu, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM billets ORDER BY date_creation DESC LIMIT 0, 5');

		return $req;
	}

	function getPost($postId)
	{
		$db = dbConnect();
		$req = $db->prepare('SELECT id, titre, contenu, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM billets WHERE id = ?');
		$req->execute(array($postId));
		$post = $req->fetch();

		return $post;
	}

	function getComments($postId)
	{
		$db = dbConnect();
		$comments = $db->prepare('SELECT id, auteur, commentaire, DATE_FORMAT(date_commentaire, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr FROM commentaires WHERE id_billet = ? ORDER BY date_commentaire DESC');
		$comments->execute(array($postId));

		return $comments;
	}

	function dbConnect()
	{
		try
		{
			$db = new PDO('mysql:host=localhost;dbname=miniblog;charset=utf8', 'root', '');
			return $db;
		}
		catch(Exception $e)
		{
			die('Erreur : '.$e->getMessage());
		}
	}