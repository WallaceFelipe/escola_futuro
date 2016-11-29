<?php
    require_once('Conexao.class.php');

    class Funcionario {
        public $nome;
        public $codgio;
        public $login;
        private $senha;
 
        public function __construct() {
            unset($this->codigo);
        }

        public function save() {         
            $db = new Conexao();

            $array = array(
                    'nome' => $this->nome ,
                    'login' => $this->login ,
                    'senha' => $this->senha );

            if (!isset($this->idturma)) {
                $db->insert('turma', $array);
                $this->idturma = $db->getCodigo();
                return true;
            } else {
                return $db->update('turma', $array, $this->idturma, 'idturma');
            }

        }

        public function delete() {
            $db = new Conexao();

            return $db->execute("DELETE FROM turma WHERE idturma = $this->idturma");
        }
        
    }