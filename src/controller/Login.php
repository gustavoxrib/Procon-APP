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

	if ($method == "login") {
		$where = "usuarios.email = \"" . $form[0] . "\" AND " . "usuarios.senha = \"" . md5($form[1]) . "\" AND " .
				"usuarios.situacao_registro = 1";
		$daoFactory->beginTransaction();
		$usuarios = $daoFactory->getUsuariosDao()->read($where, "", true);
		$daoFactory->close();
		if (is_array($usuarios) && $usuarios[0]["usuarios.size"] != 0) {
			$response["message"] = "success";
			setActiveSession($_ROOT . $_MODULE);
			setUserSession($_ROOT . $_MODULE, $usuarios);
		} else {
			$response["message"] = "error";
		}
		echo $view->json($response);
	} else {
		if (isset($session)) {
			echo "<script>goTo(\"/" . $_HOME . "/1\");</script>";
		} else {
			echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/login/loginCST.html");
		}
	}

?>