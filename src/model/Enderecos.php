<?php 
			
	/**
	 * Generated by Getz Framework
	 * 
	 * @author Mario Sakamoto <mskamot@gmail.com>
	 * @see https://wtag.com.br/getz
	 */
	 
	namespace src\model; 

	class Enderecos {
			
		private $id;
		private $logradouro;
		private $numero;
		private $bairro;
		private $cidade;
		private $complemento;
		private $cep;
		private $cadastrado;
		private $modificado;
			
		public function __construct() { }
			
		public function setId($id) {
			$this->id = $id;
		}
		
		public function getId() {
			return $this->id;
		}
					
		public function setLogradouro($logradouro) {
			$this->logradouro = $logradouro;
		}
		
		public function getLogradouro() {
			return $this->logradouro;
		}
					
		public function setNumero($numero) {
			$this->numero = $numero;
		}
		
		public function getNumero() {
			return $this->numero;
		}
					
		public function setBairro($bairro) {
			$this->bairro = $bairro;
		}
		
		public function getBairro() {
			return $this->bairro;
		}
					
		public function setCidade($cidade) {
			$this->cidade = $cidade;
		}
		
		public function getCidade() {
			return $this->cidade;
		}
					
		public function setComplemento($complemento) {
			$this->complemento = $complemento;
		}
		
		public function getComplemento() {
			return $this->complemento;
		}
					
		public function setCep($cep) {
			$this->cep = $cep;
		}
		
		public function getCep() {
			return $this->cep;
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