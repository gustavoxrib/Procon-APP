<?php 
			
	/**
	 * Generated by Getz Framework
	 * 
	 * @author Mario Sakamoto <mskamot@gmail.com>
	 * @see https://wtag.com.br/getz
	 */
	 
	namespace src\model; 

	class Cards {
			
		private $id;
		private $nome_categoria;
		private $foto;
		private $link;
		private $cadastrado;
		private $modificado;
			
		public function __construct() { }
			
		public function setId($id) {
			$this->id = $id;
		}
		
		public function getId() {
			return $this->id;
		}
					
		public function setNome_categoria($nome_categoria) {
			$this->nome_categoria = $nome_categoria;
		}
		
		public function getNome_categoria() {
			return $this->nome_categoria;
		}
					
		public function setFoto($foto) {
			$this->foto = $foto;
		}
		
		public function getFoto() {
			return $this->foto;
		}
					
		public function setLink($link) {
			$this->link = $link;
		}
		
		public function getLink() {
			return $this->link;
		}
					
		public function setCadastrado($cadastrado) {
			$this->cadastrado = $cadastrado;
		}
		
		public function getCadastrado() {
			return $this->cadastrado;
		}
					
		public function setModificado($modificado) {
			$this->modificado = $modificado;
		}
		
		public function getModificado() {
			return $this->modificado;
		}
					
	}
	
?>