<?php
			
	/**
	 * Generated by Getz Framework
	 * 
	 * @author Mario Sakamoto <mskamot@gmail.com>
	 * @see https://wtag.com.br/getz 
	 */
	 
	namespace src\model; 
	
	class MarcasDao {
	
		private $connection;
		
		/*
		 * Constant variables
		 */
		private $create = "INSERT INTO marcas (
				marca
				, cadastrado
				, modificado
				) VALUES";
				
		public $read = 
				"marcas.id AS \"marcas.id\"
				, marcas.marca AS \"marcas.marca\"
				, marcas.cadastrado AS \"marcas.cadastrado\"
				, marcas.modificado AS \"marcas.modificado\"
				";
				
		private $update = "UPDATE marcas SET";
		private $delete = "DELETE FROM marcas";
		
		public $from = "marcas marcas";
		
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
		 * @param {Marcas}marcas
		 */
		public function setCreate($marcas) {		
			$this->sql = $this->create . " (\"" . 
					$marcas->getMarca() .
					"\", \"" . $marcas->getCadastrado() .
					"\", \"" . $marcas->getModificado() .
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
			
			$this->setWhere($where);
			$this->setOrder($order);
			
			$this->sql = "SELECT " . $this->read . " FROM " . $this->getFrom() . 
					$this->getWhere() . "
				" . $this->getOrder();
		}
		
		/**
		 * @return {String}
		 */
		public function getRead() {
			return $this->sql;
		}
		
		/**
		 * @param {Marcas}marcas  
		 * @param {String} where
		 */
		public function setUpdate($marcas, $where) {
			$this->setWhere($where);
			
			$this->sql = $this->update . 
					" id = \"" . $marcas->getId() . 
					"\", marca = \"" . $marcas->getMarca() . 
					"\", modificado = \"" . $marcas->getModificado() . 
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
					"SELECT count(1) AS \"marcas.size\" from marcas" . $this->getWhere());

			while ($row = $result->fetch_assoc()) {		
				$this->setResponse(0, "marcas.size", $row["marcas.size"]);
				
				$pages = ceil($row["marcas.size"] / $this->connection->getItensPerPage());
				
				$this->setResponse(0, "marcas.page", $this->connection->getPosition());
				$this->setResponse(0, "marcas.pages", $pages);
				
				$pagination = "<select id='gz-select-pagination' onchange='goPage();'>";
				
				for ($i = 1; $i <= $pages; $i++) {
					if ($i == $this->connection->getPosition())
						$pagination .= "<option value='" . $i . "' selected>" . $i . "</option>";
					else
						$pagination .= "<option value='" . $i . "'>" . $i . "</option>";
				}	

				$pagination .= "</select>";
						
				$this->setResponse(0, "marcas.pagination", $pagination);
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
		 * @param {Marcas} marcas 
		 * @return {Boolean}
		 */
		public function create($marcas) {
			$result = "";

			$this->setCreate($marcas);
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
				$this->setResponse($line, "marcas.id", $row["marcas.id"]);
				$this->setResponse($line, "marcas.marca", $row["marcas.marca"]);
				$this->setResponse($line, "marcas.marca.format.json", modelDoubleQuotesJson($row["marcas.marca"]));
				$this->setResponse($line, "marcas.marca.format", modelDoubleQuotes($row["marcas.marca"]));
				$this->setResponse($line, "marcas.marca.view", addLine($row["marcas.marca"]));
				$this->setResponse($line, "marcas.cadastrado", modelDateTime($row["marcas.cadastrado"]));
				$this->setResponse($line, "marcas.modificado", modelDateTime($row["marcas.modificado"]));
			
				$this->setResponse($line, "marcas.line", $line);
			
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
		 * @param {Marcas} marcas 
		 * @return {Boolean}
		 */
		public function update($marcas) {
			$result = "";
			
			$this->setUpdate($marcas, "marcas.id = " . $marcas->getId());
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
				$this->setResponse($size, "marcas.id", $row["marcas.id"]);
				$this->setResponse($size, "marcas.marca", $row["marcas.marca"]);
			
				if ($row["marcas.id"] == $selected)
					$this->setResponse($size, "marcas.selected", "selected");
				else
					$this->setResponse($size, "marcas.selected", "");
					
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
				$this->setResponse($size, "marcas.id", $row["marcas.id"]);
				$this->setResponse($size, "marcas.marca", $row["marcas.marca"]);
				$this->setResponse($size, "marcas.selected", "selected");
					
				$size++;
			}
			
			$this->connection->free($result);
			
			$this->setResponse(0, "size", $size);

			return $this->getResponse();
		}

	}

?>