<?php

	/**
	 * Generated by Getz Framework
	 * 
	 * @author Mario Sakamoto <mskamot@gmail.com>
	 * @see https://wtag.com.br/getz
	 */
	 
	use lib\getz;
	use src\model;
	 
	require_once($_DOCUMENT_ROOT . "/lib/getz/Activator.php");

	/*
	 * Login
	 */
	if ($method == "page") {
		$view->setTitle(ucfirst($screen));
		$view->setDescription("");
		$view->setKeywords("");
		if (isset($_GET["friendly"])) {
			$token = base64_decode($_GET["friendly"]);
			$tokenMath = explode("g3tz", $token);
			$userId = ($tokenMath[1] / 128) - 32;
			$daoFactory->beginTransaction();
			$usuariosDao = $daoFactory->getUsuariosDao()->read("usuarios.id = " . $userId . 
					" AND usuarios.situacao_registro = 1", "usuarios.id ASC", true);
			if (is_array($usuariosDao) && sizeof($usuariosDao) > 0) {
				$today = date("Y-m-d H:i:s", (time() - 3600 * 3));
				$password_token_expiration = controllerDateTime($usuariosDao[0]["usuarios.password_token_expiration"]);
				if (strtotime($password_token_expiration) >= strtotime($today)) {
					$response["usuarios"][0]["usuarios.password_token"] = $_GET["friendly"];
				} else {
					echo "<script>alert(\"Token inválido ou expirado. Solicite nova alteração de senha!\")</script>";
					echo "<script>goTo(\"/esqueci_a_minha_senha\")</script>";
				}
			} else {
				echo "<script>alert(\"A sua conta não foi ativada por e-mail e/ ou foi desativada!\")</script>";
				echo "<script>goTo(\"/home\")</script>";
			}
		}
		echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/head.html", $response);
		echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/alterar_a_minha_senha.html", $response);
		echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/foot.html", $response);
	}

?>