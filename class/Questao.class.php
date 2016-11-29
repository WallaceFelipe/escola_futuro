<?php

    require_once('Conexao.class.php');

    class Questao
    {
        public $idquestao;
        public $enunciado;
        public $opcao1;
        public $opcao2;
        public $opcao3;
        public $opcao4;
        public $resposta;
        public $disciplina_codigo;

        public function __construct() {
            unset($idquestao);
        }

        public function save() {         
            $db = new Conexao();

            $array = array(
                    'enunciado' => $this->enunciado ,
                    'opcao1' => $this->opcao1 ,
                    'opcao2' => $this->opcao2 ,
                    'opcao3' => $this->opcao3 ,
                    'opcao4' => $this->opcao4 ,
                    'resposta' => $this->resposta ,
                    'disciplina_codigo' => $this->disciplina_codigo );

            if (!isset($this->idquestao)) {
                $db->insert('questao', $array);
                $this->idquestao = $db->getCodigo();
                return true;
            } else {
                return $db->update('questao', $array, $this->idquestao, 'idquestao');
            }

        }

        public function delete() {
            $db = new Conexao();

            return $db->execute("DELETE FROM questao WHERE idquestao = $this->idquestao");
        }
        
    }