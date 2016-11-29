<?php

    require_once('Turma.class.php');
    require_once('Conexao.class.php');

    class Aluno
    {
        public $matricula;
        public $nome;
        public $login;
        public $senha;
        public $turmas;


        public function __construct () {
            unset($this->matricula);
        }

        public function save () {
            $db = new Conexao();

            $array = array(
                    'nome' => $this->nome ,
                    'login' => $this->login ,
                    'senha' => $this->senha );

            if (!isset($this->matricula)) {
                $db->insert('aluno', $array);
                $this->matricula = $db->getCodigo();
                return true;
            } else {
                return $db->update('aluno', $array, $this->matricula, 'matricula');
            }

        }

        public function delete() {
            $db = new Conexao();

            return $db->execute("DELETE FROM aluno WHERE matricula = $this->matricula");
        }

        public function matricula_turma($cod_turma, $nome_disc) {
            $db = new Conexao();

            $array = array(
                'turma_idturma' => $cod_turma,
                'aluno_matricula' => $this->matricula,
                'disciplina' => $nome_disc
            );

            if ($db->insert('turma_aluno', $array)) {
                return true;
            } else {
                return false;
            }
        }

    }