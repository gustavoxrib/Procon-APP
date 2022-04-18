<?php
			
	/**
	 * Generated by Getz Framework
	 * 
	 * @author Mario Sakamoto <mskamot@gmail.com>
	 * @see https://wtag.com.br/getz 
	 */
	 
	namespace src\model; 
	
	use src\model;
	
	class Situacoes_registrosDao {
	
		private $connection;
		
		/*
		 * Constant variables
		 */
		private $create = "INSERT INTO situacoes_registros (
				situacao_registro
				, cadastrado
				, modificado
				, cor
				) VALUES";
				
		public $read = 
				"situacoes_registros.id AS \"situacoes_registros.id\"
				, situacoes_registros.situacao_registro AS \"situacoes_registros.situacao_registro\"
				, situacoes_registros.cadastrado AS \"situacoes_registros.cadastrado\"
				, situacoes_registros.modificado AS \"situacoes_registros.modificado\"
				, situacoes_registros.cor AS \"situacoes_registros.cor\"
				";
				
		private $update = "UPDATE situacoes_registros SET";
		private $delete = "DELETE FROM situacoes_registros";
		
		public $from = "situacoes_registros situacoes_registros";
		
		/*
		 * Parameters
		 */
		private $where;
		private $order;
		
		// Dynamic query
		private $sql;
		
		// Controller response
		private $response;	
		
		/**
		 * @param {Object} connection
		 */
		public function __construct($connection) {
			$this->connection = $connection;
		}

		/**
		 * @param {Situacoes_registros}situacoes_registros
		 */
		public function setCreate($situacoes_registros) {		
			$this->sql = $this->create . " (\"" . 
					$situacoes_registros->getSituacao_registro() .
					"\", \"" . $situacoes_registros->getCadastrado() .
					"\", \"" . $situacoes_registros->getModificado() .
					"\", \"" . $situacoes_registros->getCor() .
					"\")";
		}
		
		/**
		 * @return {String}
		 */
		public function getCreate() {
			return $this->sql;
		}	
		
		/**
		 * @param {String} where
		 * @param {String} order
		 */
		public function setRead($where, $order) {
			$coresDao = new model\CoresDao($this->connection);
			
			$this->setWhere($where);
			$this->setOrder($order);
			
			$this->sql = "SELECT " . $this->read . ", " . $coresDao->read . 
					" FROM " . $this->getFrom() .", " . $coresDao->from . 
					($this->getWhere() == "" ? " WHERE situacoes_registros.cor = cores.id" : $this->getWhere()) . 
					" AND situacoes_registros.cor = cores.id" . $this->getOrder();
		}
		
		/**
		 * @return {String}
		 */
		public function getRead() {
			return $this->sql;
		}
		
		/**
		 * @param {Situacoes_registros}situacoes_registros  
		 * @param {String} where
		 */
		public function setUpdate($situacoes_registros, $where) {
			$this->setWhere($where);
			
			$this->sql = $this->update . 
					" id = \"" . $situacoes_registros->getId() . 
					"\", situacao_registro = \"" . $situacoes_registros->getSituacao_registro() . 
					"\", modificado = \"" . $situacoes_registros->getModificado() . 
					"\", cor = \"" . $situacoes_registros->getCor() . 
					"\"" . $this->getWhere();
		}
		
		/**
		 * @return {String}
		 */
		public function getUpdate() {
			return $this->sql;
		}
		
		/**
		 * @param {String} where
		 */
		public function setDelete($where) {	
			$this->setWhere($where);
			
			$this->sql = $this->delete . $this->getWhere();
		}
		
		/**
		 * @return {String}
		 */
		public function getDelete() {
			return $this->sql;
		}
		
		/**
		 * @return {String}
		 */
		public function getFrom() {
			return $this->from;
		}
		
		/**
		 * @param {String} where
		 */
		public function setWhere($where) {
			if ($where != "")
				$this->where = " WHERE " . $where;
			else
				$this->where = "";
		}
		
		/**
		 * @return {String}
		 */
		public function getWhere() {
			return $this->where;
		}
		
		/**
		 * @param {String} order
		 */
		public function setOrder($order) {
			if ($order != "")
				$this->order = " ORDER BY " . $order;
			else
				$this->order = "";
		}
		
		/**
		 * @return {String}
		 */
		public function getOrder() {
			return $this->order;
		}
		
		/**
		 * @param {Integer} line
		 * @param column String
		 * @param value String
		 */
		private function setResponse($line, $column, $value) {
			$this->response[$line][$column] = $value;
		}

		/**
		 * @return {Array}
		 */
		private function getResponse() {
			return $this->response;
		}

		/**
		 * @param {String} where
		 */
		private function setSize($where) {
			$this->setWhere($where);
			
			$result = $this->connection->execute(
					"SELECT count(1) AS \"situacoes_registros.size\" from situacoes_registros" . $this->getWhere());

			while ($row = $result->fetch_assoc()) {		
				$this->setResponse(0, "situacoes_registros.size", $row["situacoes_registros.size"]);
				
				$pages = ceil($row["situacoes_registros.size"] / $this->connection->getItensPerPage());
				
				$this->setResponse(0, "situacoes_registros.page", $this->connection->getPosition());
				$this->setResponse(0, "situacoes_registros.pages", $pages);
				
				$pagination = "<select id='gz-select-pagination' onchange='goPage();'>";
				
				for ($i = 1; $i <= $pages; $i++) {
					if ($i == $this->connection->getPosition())
						$pagination .= "<option value='" . $i . "' selected>" . $i . "</option>";
					else
						$pagination .= "<option value='" . $i . "'>" . $i . "</option>";
				}	

				$pagination .= "</select>";
						
				$this->setResponse(0, "situacoes_registros.pagination", $pagination);
			}

			$this->connection->free($result);
		}
		
		/**
		 * @param {Integer} line
		 */
		public function setDivLine($line) {
			$this->setResponse($line - 1, "@_START_LINE_TWO", modelStartLine($line, 2));
			$this->setResponse($line - 1, "@_END_LINE_TWO", modelEndLine($line, 2));

			$this->setResponse($line - 1, "@_START_LINE_THREE", modelStartLine($line, 3));
			$this->setResponse($line - 1, "@_END_LINE_THREE", modelEndLine($line, 3));
			
			$this->setResponse($line - 1, "@_START_LINE_FOUR", modelStartLine($line, 4));
			$this->setResponse($line - 1, "@_END_LINE_FOUR", modelEndLine($line, 4));
		}
		
		/**
		 * @param {Integer} line
		 */
		public function checkDivLine($line) {
			if (modelCheckEndLine($line, 2) != "")
				$this->setResponse($line - 1, "@_END_LINE_TWO", modelCheckEndLine($line, 2));
			
			if (modelCheckEndLine($line, 3) != "")
				$this->setResponse($line - 1, "@_END_LINE_THREE", modelCheckEndLine($line, 3));		

			if (modelCheckEndLine($line, 4) != "")
				$this->setResponse($line - 1, "@_END_LINE_FOUR", modelCheckEndLine($line, 4));			
		}	

		/**
		 * @param {String} log
		 */
		private function setLog($log) {
			$this->setResponse(0, "log", $log);
		}
		
		/**
		 * @param {Situacoes_registros} situacoes_registros 
		 * @return {Boolean}
		 */
		public function create($situacoes_registros) {
			$result = "";

			$this->setCreate($situacoes_registros);
			$result = $this->connection->execute($this->getCreate());
			
			return $result;
		}

		/**
		 * @param {String} where
		 * @param {String} order
		 * @param {Boolean} wp
		 * @param {Array}
		 */
		public function read($where, $order, $wp) {
			$line = 0;

			$this->setRead($where, $order);
			$result = $this->connection->execute($this->getRead());

			while ($row = $result->fetch_assoc()) {
				$this->setResponse($line, "situacoes_registros.id", $row["situacoes_registros.id"]);
				$this->setResponse($line, "situacoes_registros.situacao_registro", $row["situacoes_registros.situacao_registro"]);
				$this->setResponse($line, "situacoes_registros.situacao_registro.format.json", modelDoubleQuotesJson($row["situacoes_registros.situacao_registro"]));
				$this->setResponse($line, "situacoes_registros.situacao_registro.format", modelDoubleQuotes($row["situacoes_registros.situacao_registro"]));
				$this->setResponse($line, "situacoes_registros.situacao_registro.view", addLine($row["situacoes_registros.situacao_registro"]));
				$this->setResponse($line, "situacoes_registros.cadastrado", modelDateTime($row["situacoes_registros.cadastrado"]));
				$this->setResponse($line, "situacoes_registros.modificado", modelDateTime($row["situacoes_registros.modificado"]));
				$this->setResponse($line, "situacoes_registros.cor", $row["situacoes_registros.cor"]);
				$this->setResponse($line, "cores.cor", $row["cores.cor"]);
			
				$this->setResponse($line, "situacoes_registros.line", $line);
			
				$line++;
				
				if ($wp)
					$this->setDivLine($line);
			}

			$this->connection->free($result);
			
			if ($wp && $line > 0) {
				$this->checkDivLine($line);
				
				$this->setSize($where);
			}

			return $this->getResponse();
		}

		/**
		 * @param {Situacoes_registros} situacoes_registros 
		 * @return {Boolean}
		 */
		public function update($situacoes_registros) {
			$result = "";
			
			$this->setUpdate($situacoes_registros, "situacoes_registros.id = " . $situacoes_registros->getId());
			$result = $this->connection->execute($this->getUpdate());

			return $result;
		}

		/**
		 * @param {String} where
		 * @return {Boolean}
		 */
		public function delete($where) {
			$result = "";
			
			$this->setDelete($where);
			$result = $this->connection->execute($this->getDelete());

			return $result;
		}
		
		/**
		 * @param {Integer} selected
		 * @param {String} order
		 * @return {Array}
		 */
		public function combo($selected, $order) {
			$size = 0;

			$this->setRead("", $order);
			$result = $this->connection->execute($this->getRead());

			while ($row = $result->fetch_assoc()) {
				$this->setResponse($size, "situacoes_registros.id", $row["situacoes_registros.id"]);
				$this->setResponse($size, "situacoes_registros.situacao_registro", $row["situacoes_registros.situacao_registro"]);
			
				if ($row["situacoes_registros.id"] == $selected)
					$this->setResponse($size, "situacoes_registros.selected", "selected");
				else
					$this->setResponse($size, "situacoes_registros.selected", "");
					
				$size++;
			}
			
			$this->connection->free($result);
			
			$this->setResponse(0, "size", $size);

			return $this->getResponse();
		}
		
		/**
		 * @param {String} where
		 * @return {Array}
		 */
		public function comboScr($where) {
			$size = 0;

			$this->setRead($where, "");
			$result = $this->connection->execute($this->getRead());

			while ($row = $result->fetch_assoc()) {
				$this->setResponse($size, "situacoes_registros.id", $row["situacoes_registros.id"]);
				$this->setResponse($size, "situacoes_registros.situacao_registro", $row["situacoes_registros.situacao_registro"]);
				$this->setResponse($size, "situacoes_registros.selected", "selected");
					
				$size++;
			}
			
			$this->connection->free($result);
			
			$this->setResponse(0, "size", $size);

			return $this->getResponse();
		}

	}

?>