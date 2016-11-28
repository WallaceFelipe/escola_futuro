<?php

class Turma extends CI_Model {
    public $idturma;
    public $disciplina_codigo;
    public $professor_idprofessor;
    public $horario;
    public $alunoList;
    public $avaliacaoList;

    public $disciplina_nome;
    public $professor_nome;

    /*
        Construtor
    */
    public function __construct ($idturma=0) {
        // Carregando biblioteca do banco de dados
        $this->load->database();

        /*
            Recupera uma turma já existente do banco de dados
                @ se $idturma for passado como parâmetro
        */
        if ($idturma) {
            // Obtém a turma com respectivo "$idturma"
            $this->db->join('disciplina', 'turma.disciplina_codigo = disciplina.codigo', 'inner');
            $this->db->join('professor', 'turma.professor_idprofessor = professor.idprofessor', 'inner');
            $this->db->select('turma.*, disciplina.nome, professor.nome as prof_nome');
            $this->db->where('idturma', $idturma);
            
            // Obtém o primeiro resultado (index 0) da busca
            $result = $this->db->get('turma')->result()[0];

            // Monta o objeto turma
            $this->idturma = $result->idturma;
            $this->disciplina_codigo = $result->disciplina_codigo;
            $this->disciplina_nome = $result->nome;
            $this->professor_idprofessor = $result->professor_idprofessor;
            $this->professor_nome = $result->prof_nome;
            $this->horario = $result->horario;

            // Captura as avaliações da turma;

            // Colocar a montagem da avaliacao aqui; 


            // Captura os alunos matriculados
            $this->db->join('aluno', 'turma_aluno.aluno_matricula = aluno.matricula', 'inner');
            $this->db->where('turma_idturma', $idturma);
            
            $this->db->select('turma_aluno.aluno_matricula, aluno.nome');
            $result = $this->db->get('turma_aluno');

            // Caso exita aluno matriculado, monta um array 
            // @ com a chave sendo o numero de matricula e o valor o nome do aluno
            if ($result->result()) {
                foreach ($result->result() as $r) {
                    $this->alunoList[$r->aluno_matricula] = $r->nome;
                }
            } else {
                $this->alunoList = null;
            }
            
            
            
            
            //$this->alunoList = $result->alunoList;
        }

        /*
            Adicionar nova turma
                @ se $idturma não for passado como parâmetro
        */
        else {
            // Remove o atributo idturma, já que ele será
            //  automaticamente gerado pelo banco de dados.
            unset( $this->idturma );
        }
    }

    /*
        Adiciona ou atualiza a turma no banco de dados
    */
    public function save () {
        // Atualiza
        //  @ verifico se o atributo "idturma" existe neste objeto.
        //    lembrando que este atributo é apagado se criamos uma nova turma.
        if ( isset($this->idturma) ) {
             $this->db->update('turmas', $this, array('idturma' => $this->idturma));
        }
        // Salva
        else {
            $this->db->insert('turmas', $this);
        }
    }

    /*
        Deleta a turma do banco de dados
    */
    public function delete () {
        $this->db->delete('turmas', array('idturma' => $this->idturma));
    }

    /*
        Obtém uma lista de todas as turmas
    */
    

}