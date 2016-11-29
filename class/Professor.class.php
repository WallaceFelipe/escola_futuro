<?php

    require_once('Conexao.class.php');

    class Professor
    {
        public $idprofessor;
        public $nome;
        public $login;
        public $senha;
        public $turmas;

        public function __construct () {
            unset($this->idprofessor);
        }

         public function save () {
            $db = new Conexao();

            $array = array(
                    'nome' => $this->nome ,
                    'login' => $this->login ,
                    'senha' => $this->senha );

            if (!isset($this->idprofessor)) {
                $db->insert('aluno', $array);
                $db->getCodigo();
                return true;
            } else {
                return $db->update('aluno', $array, $this->idprofessor, 'idprofessor');
            }

        }

        public function delete() {
            $db = new Conexao();

            return $db->execute("DELETE FROM professor WHERE idprofessor = $this->idprofessor");
        }

        
    }