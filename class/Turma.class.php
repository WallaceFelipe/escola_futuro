<?php

    require_once('Avaliacao.class.php');

    class Turma 
    {
        // propriedades referentes a tabela no banco
        public $idturma;
        public $disciplina_codigo;
        public $professor_idprofessor;
        public $horario;

        // propriedades referentes às entidades vinculadas
        public $alunoList;
        public $avaliacaoList;

        // propriedades complementares
        public $disciplina_nome;
        public $professor_nome;

        public function __construct() {
            unset($this->idturma);
            unset($this->alunoList);
            unset($this->avaliacaoList);
        }

        public function save() {         
            $db = new Conexao();

            $array = array(
                    'disciplina_codigo' => $this->disciplina_codigo ,
                    'professor_idprofessor' => $this->professor_idprofessor ,
                    'horario' => $this->horario );

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

        public function carregaAlunos() {

        }

        public function carregaAvaliacao() {

            $db = new Conexao();

            $result = $db->select('*')->from('avaliacao')->where('turma_idturma = '.$this->idturma.'')->orderby('idavaliacao')->executeNGet();
            
            $avaliacoes = [];

            foreach ($result as $avaliacao) {
                $tmp = new Avaliacao();

                $tmp->idavaliacao = $avaliacao['idavaliacao'];
                $tmp->status = $avaliacao['status'];
                $tmp->turma_idturma = $avaliacao['turma_idturma'];

                $tmp->carregaQuestoes();

                $avaliacoes[] = $tmp;
            }

            $this->avaliacaoList = $avaliacoes;
            return $avaliacoes;
        }

        
    }
    