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

	if ($method == "page") {
		$view->setTitle(ucfirst($screen));
		$view->setDescription("");
		$view->setKeywords("");
		echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/head.html");
		echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/criar_uma_conta.html");
		echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/foot.html");
	}

?>