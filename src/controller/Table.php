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
		$daoFactory->beginTransaction();
		$response["usuarios"] = $daoFactory->getUsuariosDao()->read("", "usuarios.id ASC", true);

		// $response["cards"] = $daoFactory->getCardsDao()->read("", "cards.id ASC", true);


		$daoFactory->close();

		// $response["users"] = [
		// 	["user" => 'ash', 'jobs' => [["job" => "job 1"], ["job" => "job 2"]]],
		// 	["user" => 'brock', 'jobs' => [["job" => "job 3"], ["job" => "job 4"]]],
		// 	["user" => 'misty', 'jobs' => [["job" => "job 5"], ["job" => "job 6"]]]
		// ];
		// $response["values"] = [
		// 	"a" => 1,
		// 	"b" => 2,
		// 	"c" => 3
		// ];
		// $response["values2"] = [
		// 	10,
		// 	20,
		// 	30
		// ];
		
		$response["print"] = "true";
		echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/header.html");
		echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/table.html", $response);
		echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/footer.html");
	}

?>