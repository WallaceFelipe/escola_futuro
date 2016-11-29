<?php

    require_once('Questao.class.php');

    class Avaliacao
    {
        public $idavaliacao;
        public $status;
        public $turma_idturma;

        public $questoes;

        public function __construct() {
            unset($idavaliacao);
        }

        public function save() {         
            $db = new Conexao();

            $array = array(
                    'status' => $this->status ,
                    'turma_idturma' => $this->turma_idturma );

            if (!isset($this->idavaliacao)) {
                $db->insert('avaliacao', $array);
                $this->idavaliacao = $db->getCodigo();
                return true;
            } else {
                return $db->update('avaliacao', $array, $this->idavaliacao, 'idavaliacao');
            }

        }

        // Deleta a avalaição, porem verifica se ela não foi respondida.
        public function delete() {
            $db = new Conexao();
            if ($this->status == 1) {
                return false;
            }
            
            if($db->execute("DELETE FROM questao_avaliacao WHERE avaliacao_idavaliacao = $this->idavaliacao")) {
                $db->execute("DELETE FROM avaliacao WHERE idturma = $this->idavaliacao");
                return true;
            }

            return false;
        }

        public function carregaQuestoes() {
            $db = new Conexao();

            $result = $db->execute("SELECT * FROM questao_avaliacao qa JOIN questao q ON qa.questao_idquestao = q.idquestao WHERE qa.avaliacao_idavaliacao = ".$this->idavaliacao);

            $questoes = [];

            foreach ($result as $r) {
                $tmp = new Questao();

                $tmp->idquestao = $r['idquestao'];
                $tmp->enunciado = $r['enunciado'];
                $tmp->opcao1 = $r['opcao1'];
                $tmp->opcao2 = $r['opcao2'];
                $tmp->opcao3 = $r['opcao3'];
                $tmp->opcao4 = $r['opcao4'];
                $tmp->resposta = $r['resposta'];
                $tmp->disciplina_codigo = $r['disciplina_codigo'];
                
                $questoes[] = $tmp;
            } 

            $this->questoes = $questoes;
            return $questoes;
        }

        public function AlunoJaFezAvaliacao($aluno){

            $db = new Conexao();

            $aluno     = $db->escape($aluno);
            $avaliacao = $this->idavaliacao;

            $rs = $db
                    ->select('count(*) as n')
                    ->from('nota')
                    ->where("avaliacao_idavaliacao = '$avaliacao' and aluno_matricula = '$aluno'")
                    ->limit(1)
                    ->executeNGet('n');

            if($rs == '1')
                return true;
            else
                return false;

        }

    }

