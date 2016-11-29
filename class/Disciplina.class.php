<?php

    require_once('Conexao.class.php');

    class Disciplina
    {
        public  $nome;
        public $codigo;
        public $iddisciplina;

        public function __construct() {
            unset($this->iddisciplina);
        }

        public function save () {
            $db = new Conexao();

            $array = array(
                    'nome' => $this->nome ,
                    'codigo' => $this->codigo ,
                    );

            if (!isset($this->iddisciplina)) {
                $db->insert('disciplina', $array);
                $this->iddisciplina = $db->getCodigo();
                return true;
            } else {
                return $db->update('disciplina', $array, $this->iddisciplina, 'iddisciplina');
            }

        }

        public function delete() {
            $db = new Conexao();

            return $db->execute("DELETE FROM disciplina WHERE iddisciplina = $this->iddisciplina");
        }

        

    }