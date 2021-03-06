<?php

	/**
	 * Generated by Getz Framework
	 *
	 * @author Mario Sakamoto <mskamot@gmail.com>
	 * @see https://wtag.com.br/getz
	 */
	 
	use lib\getz;
	use src\logic;	 
	use src\model;	 
	
	require_once($_DOCUMENT_ROOT . "/lib/getz/Activator.php");
	
	/*
	 * Filters
	 */
	$where = "";
	
	if ($search != "")
		$where = "produto_precos.produto_preco LIKE \"%" . $search . "%\"";	
		
	if ($code != "")
		$where = "produto_precos.id = " . $code;
	
	if (isset($_GET["friendly"]))
		$where = "produto_precos.produto_preco = \"" . removeLine($_GET["friendly"]) . "\"";	
		
	$limit = "";	
		
	if ($order != "") {
		$o = explode("<gz>", $order);

		$limit = $o[0] . " " . $o[1] . " LIMIT " . 
				(($position * $itensPerPage) - $itensPerPage) . ", " . $itensPerPage;
				
	} else {
		if ($position > 0 && $itensPerPage > 0) {
			$limit = "produto_precos.id DESC LIMIT " . 
					(($position * $itensPerPage) - $itensPerPage) . ", " . $itensPerPage;	
		}
	}
	
	/**************************************************
	 * Webpage
	 **************************************************/		
	
	/*
	 * Page
	 */
	if ($method == "page") {
		/*
		 * SEO
		 */
		$view->setTitle(ucfirst($screen));
		$view->setDescription("");
		$view->setKeywords("");
		
		$daoFactory->beginTransaction();
		$response["produto_precos"] = $daoFactory->getProduto_precosDao()->read($where, $limit, true);
		$daoFactory->close();
		
		if (isset($_GET["friendly"]))
			$view->setTitle($response["produto_precos"][0]["produto_precos.produto_preco"]);

		echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/header.html");
		
		echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . 
				(isset($_GET["friendly"]) ? "/html/@_PAGE.html" : "/html/produto_precos.html"), $response);
		
		echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/footer.html");
	}
	
	/**************************************************
	 * Webservice
	 **************************************************/	

	/*
	 * Create
	 */
	else if ($method == "api-create") {
		enableCORS();
		if (isset($_POST["request"])) {
			$request = json_decode($_POST["request"], true);
			// $request[0]["@_PARAM"] = $daoFactory->prepare($request[0]["@_PARAM"]); // Prepare with sql injection.

			$daoFactory->beginTransaction();
			$produto_precos = new model\Produto_precos();
			$produto_precos->setProduto_preco(logicZero(controllerDouble($request["produto_precos.produto_preco"])));
			$produto_precos->setCadastrado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
			$produto_precos->setModificado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
			$produto_precos->setProduto($request["produto_precos.produto"]);
			$produto_precos->setEstabelecimento($request["produto_precos.estabelecimento"]);
			
			$resultDao = $daoFactory->getProduto_precosDao()->create($produto_precos);

			if ($resultDao) {
				$daoFactory->commit();
				$response["message"] = "success";
			} else {							
				$daoFactory->rollback();
				$response["message"] = "error";
			}

			$daoFactory->close();
		} else {
			$response["message"] = "error";
		}
		
		echo $view->json($response);
	}
	
	/*
	 * Read
	 */
	else if ($method == "api-read") {
		enableCORS();
		
		if (isset($_POST["request"])) {
			$request = json_decode($_POST["request"], true);
			
			$limit = "produto_precos.id DESC LIMIT " . 
					(($request[0]["page"] * $request[0]["pageSize"]) - 
					$request[0]["pageSize"]) . ", " . $request[0]["pageSize"];	
		}
		
		$daoFactory->beginTransaction();
		$produto_precos = $daoFactory->getProduto_precosDao()->read("", $limit, false);
		$daoFactory->close();
		
		echo $view->json($produto_precos);
	}
	
	/*
	 * Update
	 */
	else if ($method == "api-update") {	
		enableCORS();
		if (isset($_POST["request"])) {
			$request = json_decode($_POST["request"], true);
			// $request[0]["@_PARAM"] = $daoFactory->prepare($request[0]["@_PARAM"]); // Prepare with sql injection.
			
			$produto_precos = new model\Produto_precos();
			$produto_precos->setId($request["produto_precos.id"]);
			$produto_precos->setProduto_preco(logicZero(controllerDouble($request["produto_precos.produto_preco"])));
			$produto_precos->setCadastrado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
			$produto_precos->setModificado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
			$produto_precos->setProduto($request["produto_precos.produto"]);
			$produto_precos->setEstabelecimento($request["produto_precos.estabelecimento"]);
			
			$daoFactory->beginTransaction();
			$resultDao = $daoFactory->getProduto_precosDao()->update($produto_precos);

			if ($resultDao) {
				$daoFactory->commit();
				$response["message"] = "success";
			} else {							
				$daoFactory->rollback();
				$response["message"] = "error";
			}

			$daoFactory->close();
		} else {
			$response["message"] = "error";
		}
		
		echo $view->json($response);
	}
	
	/* 
	 * Delete
	 */
	else if ($method == "api-delete") {
		enableCORS();
		if (isset($_POST["request"])) {
			$request = json_decode($_POST["request"], true);
			$request["produto_precos.id"] = $daoFactory->prepare($request["produto_precos.id"]); // Prepare with sql injection.
				
			$result = true;
			$lines = explode("<gz>", $request["produto_precos.id"]);

			$daoFactory->beginTransaction();

			for ($i = 0; $i < sizeof($lines); $i++) {
				$where = "produto_precos.id = " . $lines[$i];
				
				$resultDao = $daoFactory->getProduto_precosDao()->delete($where);
				$result = !$result ? false : (!$resultDao ? false : true);
			}

			if ($result) {
				$daoFactory->commit();
				$response["message"] = "success";
			} else {							
				$daoFactory->rollback();
				$response["message"] = "error";
			}

			$daoFactory->close();
		} else {
			$response["message"] = "error";
		} 

		echo $view->json($response);
	}
	
	/**************************************************
	 * System
	 **************************************************/	
	
	else {
		if (!getActiveSession($_ROOT . $_MODULE)) 
			echo "<script>goTo(\"/login/1\");</script>";
		else {
			/*
			 * Create
			 */
			if ($method == "stateCreate") {
				if (!getPermission($_ROOT . $_MODULE, $daoFactory, $screen, $method))
					echo "<script>goTo(\"/login/1\");</script>";	
				else {
					$daoFactory->beginTransaction();
					$response["titles"] = $daoFactory->getTelasDao()->read("telas.identificador = \"" . $screen . "\"", "", true);
					$response["produtos"] = $daoFactory->getProdutosDao()->read("", "produtos.id ASC", false);
					$response["estabelecimentos"] = $daoFactory->getEstabelecimentosDao()->read("", "estabelecimentos.id ASC", false);
					$daoFactory->close();

					echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/menus/menusCST.html", getMenu($daoFactory, $_USER, $screen));
					echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/produto_precos/produto_precosCRT.html", $response);
				}
			}

			/*
			 * Read
			 */
			else if ($method == "stateRead") {
				if (!getPermission($_ROOT . $_MODULE, $daoFactory, $screen, $method))
					echo "<script>goTo(\"/login/1\");</script>";	
				else {
					$daoFactory->beginTransaction();
					$response["titles"] = $daoFactory->getTelasDao()->read("telas.identificador = \"" . $screen . "\"", "", true);
					$response["produto_precos"] = $daoFactory->getProduto_precosDao()->read($where, $limit, true);
					if (!is_array($response["produto_precos"])) {
						$response["data_not_found"][0]["value"] = "<p>N??o possui registro.</p>";
					}
					$daoFactory->close();

					echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/menus/menusCST.html", getMenu($daoFactory, $_USER, $screen));
					echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/produto_precos/produto_precosRD.html", $response);
				}
			}

			/*
			 * Update
			 */
			else if ($method == "stateUpdate") {
				if (!getPermission($_ROOT . $_MODULE, $daoFactory, $screen, $method))
					echo "<script>goTo(\"/login/1\");</script>";	
				else {
					$daoFactory->beginTransaction();
					$response["titles"] = $daoFactory->getTelasDao()->read("telas.identificador = \"" . $screen . "\"", "", true);
					$response["produto_precos"] = $daoFactory->getProduto_precosDao()->read($where, "", true);
					$response["produto_precos"][0]["produto_precos.produtos"] = $daoFactory->getProdutosDao()->read("", "produtos.id ASC", false);
					for ($x = 0; $x < sizeof($response["produto_precos"][0]["produto_precos.produtos"]); $x++) {
						if ($response["produto_precos"][0]["produto_precos.produtos"][$x]["produtos.id"] == 
								$response["produto_precos"][0]["produto_precos.produto"]) {
							$response["produto_precos"][0]["produto_precos.produtos"][$x]["produtos.selected"] = "selected";
						}
					}
					$response["produto_precos"][0]["produto_precos.estabelecimentos"] = $daoFactory->getEstabelecimentosDao()->read("", "estabelecimentos.id ASC", false);
					for ($x = 0; $x < sizeof($response["produto_precos"][0]["produto_precos.estabelecimentos"]); $x++) {
						if ($response["produto_precos"][0]["produto_precos.estabelecimentos"][$x]["estabelecimentos.id"] == 
								$response["produto_precos"][0]["produto_precos.estabelecimento"]) {
							$response["produto_precos"][0]["produto_precos.estabelecimentos"][$x]["estabelecimentos.selected"] = "selected";
						}
					}
					$daoFactory->close();

					echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/menus/menusCST.html", getMenu($daoFactory, $_USER, $screen));
					echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/produto_precos/produto_precosUPD.html", $response);
				}
			}

			/*
			 * Called
			 */
			else if ($method == "stateCalled") {
				if (!getPermission($_ROOT . $_MODULE, $daoFactory, $screen, $method))
					echo "<script>goTo(\"/login/1\");</script>";	
				else {
					/*
					 * Insert your foreign key here
					 */
					if ($where != "")
						$where .= " AND produto_precos.@_FOREIGN_KEY = " . $base;
					else 
						$where = "produto_precos.@_FOREIGN_KEY = " . $base;
						
					$daoFactory->beginTransaction();
					$response["titles"] = $daoFactory->getTelasDao()->read("telas.identificador = \"" . $screen . "\"", "", true);
					$response["produto_precos"] = $daoFactory->getProduto_precosDao()->read($where, $limit, true);
					if (!is_array($response["produto_precos"])) {
						$response["data_not_found"][0]["value"] = "<p>N??o possui registro.</p>";
					}
					$daoFactory->close();

					echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/menus/menusCST.html", getMenu($daoFactory, $_USER, $screen));
					echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/produto_precos/produto_precosCLL.html", $response);
				}
			}

			/*
			 * Screen
			 */
			else if ($method == "screen") {
				if ($base != "") {
					$arrBase = explode("<gz>", $base);
					
					if (sizeof($arrBase) > 1) {
						if ($where != "")
							$where .= " AND produto_precos.@_FOREIGN_KEY = " . $arrBase[1];
						else
							$where = "produto_precos.@_FOREIGN_KEY = " . $arrBase[1];
					}
				}
				
				$limit = "produto_precos.id DESC LIMIT " . (($position * 5) - 5) . ", 5";

				$daoFactory->beginTransaction();
				$response["titles"] = $daoFactory->getTelasDao()->read("telas.identificador = \"" . $screen . "\"", "", true);
				$response["produto_precos"] = $daoFactory->getProduto_precosDao()->read($where, $limit, true);
				$daoFactory->close();

				echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/produto_precos/produto_precosSCR.html", $response) . 
						"<size>" . (is_array($response["produto_precos"]) ? $response["produto_precos"][0]["produto_precos.size"] : 0) . "<theme>455a64";
			}

			/*
			 * Screen handler
			 */
			else if ($method == "screenHandler") {	
				$where = "";

				// Get value from combo
				$cmb = explode("<gz>", $search);

				if ($cmb[1] != "")
					$where = "produto_precos.id = " . $cmb[1];

				$daoFactory->beginTransaction();
				$response["produto_precos"] = $daoFactory->getProduto_precosDao()->comboScr($where);
				$daoFactory->close();

				echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/produto_precos/produto_precosCMB.html", $response);
			}

			/*
			 * Create
			 */
			else if ($method == "create") {
				if (!getPermission($_ROOT . $_MODULE, $daoFactory, $screen, $method)) {
					$response["message"] = "permission";
					
					echo $view->json($response);
				} else {
					$produto_precos = new model\Produto_precos();
					$produto_precos->setProduto_preco(logicZero(controllerDouble($form[0])));
					$produto_precos->setCadastrado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
					$produto_precos->setModificado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
					$produto_precos->setProduto($form[1]);
					$produto_precos->setEstabelecimento($form[2]);
					
					$daoFactory->beginTransaction();
					$resultDao = $daoFactory->getProduto_precosDao()->create($produto_precos);

					if ($resultDao) {
						$daoFactory->commit();
						$response["message"] = "success";				
					} else {							
						$daoFactory->rollback();
						$response["message"] = "error";
					}

					$daoFactory->close();

					echo $view->json($response);
				}
			}

			/*
			 * Action update
			 */
			else if ($method == "update") {	
				if (!getPermission($_ROOT . $_MODULE, $daoFactory, $screen, $method)) {
					$response["message"] = "permission";
					
					echo $view->json($response);
				} else {
					$produto_precos = new model\Produto_precos();
					$produto_precos->setId($code);
					$produto_precos->setProduto_preco(logicZero(controllerDouble($form[0])));
					$produto_precos->setCadastrado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
					$produto_precos->setModificado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
					$produto_precos->setProduto($form[1]);
					$produto_precos->setEstabelecimento($form[2]);
					
					$daoFactory->beginTransaction();
					$resultDao = $daoFactory->getProduto_precosDao()->update($produto_precos);

					if ($resultDao) {
						$daoFactory->commit();
						$response["message"] = "success";
					} else {							
						$daoFactory->rollback();
						$response["message"] = "error";
					}

					$daoFactory->close();

					echo $view->json($response);
				}
			}
			
			/* 
			 * Action delete
			 */
			else if ($method == "delete") {
				if (!getPermission($_ROOT . $_MODULE, $daoFactory, $screen, $method)) {
					$response["message"] = "permission";
					
					echo $view->json($response);
				} else {
					$result = true;
					$lines = explode("<gz>", $code);

					$daoFactory->beginTransaction();

					for ($i = 1; $i < sizeof($lines); $i++) {
						$where = "produto_precos.id = " . $lines[$i];
						
						$resultDao = $daoFactory->getProduto_precosDao()->delete($where);
						$result = !$result ? false : (!$resultDao ? false : true);
					}

					if ($result) {
						$daoFactory->commit();
						$response["message"] = "success";
					} else {							
						$daoFactory->rollback();
						$response["message"] = "error";
					}

					$daoFactory->close();

					echo $view->json($response);	
				}
			}
		}
	}

?>