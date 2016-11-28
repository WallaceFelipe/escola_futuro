<?php

    /*
        Classe helper para listagem de objetos da aplicação
    */
    class Listagem extends CI_MODEL {
        
        public function __construct()
        {
            parent::__construct();
            $this->load->database();
        }

        public function getProfessor() {
            
            $this->db->get('professor')->result;
            
        
        }

        /*
            Função getTurmas lista todas as turmas, os atores podem ser
            @ funcionario, aluno ou professor
            @ no caso de aluno e professor, passar o id deles
        */

        public static function getTurmas ($ator, $id = 0) {
            // Obtém instância do CodeIgniter
            $CI =& get_instance();

            // Carregando biblioteca do banco de dados e a classe Turma
            $CI->load->database();
            $CI->load->model('Turma');

            // Obtém todos os posts
            if ($ator == 'aluno') {

                $CI->db->where('turma_aluno.aluno_matricula', $id);
                $resultado = $CI->db->get('turma_aluno')->result();

                foreach ($resultado as $r) {
                    
                    $CI->db->where('idturma', $r->turma_idturma);

                    $CI->db->join('disciplina', 'turma.disciplina_codigo = disciplina.codigo', 'inner');
                    $CI->db->join('professor', 'turma.professor_idprofessor = professor.idprofessor', 'inner');
                    $CI->db->select('turma.*, disciplina.nome, professor.nome as prof_nome');

                    $CI->db->order_by("idturma", "cresc");
                    $result = $CI->db->get('turma')->result();
                    
                    // Monta vetor de objetos "Turma"
                    $turmas  = [];

                    foreach ($result as $turma) {
                        $tmp    = new Turma();
                        $tmp->idturma = $turma->idturma;
                        $tmp->disciplina_codigo = $turma->disciplina_codigo;
                        $tmp->disciplina_nome = $turma->nome;
                        $tmp->professor_idprofessor = $turma->professor_idprofessor;
                        $tmp->professor_nome = $turma->prof_nome;
                        $tmp->horario = $turma->horario;
                        //$tmp->alunoList = $turma->alunoList;

                        $CI->db->join('aluno', 'turma_aluno.aluno_matricula = aluno.matricula', 'inner');
                        $CI->db->where('turma_idturma', $turma->idturma);
                        
                        $CI->db->select('turma_aluno.aluno_matricula, aluno.nome');
                        $result = $CI->db->get('turma_aluno');

                        // Caso exita aluno matriculado, monta um array 
                        // @ com a chave sendo o numero de matricula e o valor o nome do aluno
                        if ($result->result()) {
                            foreach ($result->result() as $r) {
                                $tmp->alunoList[$r->aluno_matricula] = $r->nome;
                            }
                        } else {
                            $tmp->alunoList = null;
                        }

                        $turmas[] = $tmp;
                    }
                }



            } else {


                if ($ator == 'professor') {
                    $CI->db->where('turma.professor_idprofessor', $id);
                } 


                $CI->db->join('disciplina', 'turma.disciplina_codigo = disciplina.codigo', 'inner');
                $CI->db->join('professor', 'turma.professor_idprofessor = professor.idprofessor', 'inner');
                $CI->db->select('turma.*, disciplina.nome, professor.nome as prof_nome');

                $CI->db->order_by("idturma", "cresc");
                $result = $CI->db->get('turma')->result();
                
                // Monta vetor de objetos "Turma"
                $turmas  = [];

                foreach ($result as $turma) {
                    $tmp    = new Turma();
                    $tmp->idturma = $turma->idturma;
                    $tmp->disciplina_codigo = $turma->disciplina_codigo;
                    $tmp->disciplina_nome = $turma->nome;
                    $tmp->professor_idprofessor = $turma->professor_idprofessor;
                    $tmp->professor_nome = $turma->prof_nome;
                    $tmp->horario = $turma->horario;
                    //$tmp->alunoList = $turma->alunoList;

                    $CI->db->join('aluno', 'turma_aluno.aluno_matricula = aluno.matricula', 'inner');
                    $CI->db->where('turma_idturma', $turma->idturma);
                    
                    $CI->db->select('turma_aluno.aluno_matricula, aluno.nome');
                    $result = $CI->db->get('turma_aluno');

                    // Caso exita aluno matriculado, monta um array 
                    // @ com a chave sendo o numero de matricula e o valor o nome do aluno
                    if ($result->result()) {
                        foreach ($result->result() as $r) {
                            $tmp->alunoList[$r->aluno_matricula] = $r->nome;
                        }
                    } else {
                        $tmp->alunoList = null;
                    }

                    $turmas[] = $tmp;
                }
            }

            return $turmas;
        }
        

        /*
            Recupera todas as disciplinas
        */
        public function getDisciplinas () {
            
            $this->load->model('Disciplina');
            
            $resultado = $this->db->get('disciplina')->result();

            $disciplina = [];

            foreach ($resultado as $r) {
                $tmp = new Disciplina();
                $tmp->iddisciplina = $r->iddisciplina;
                $tmp->codigo = $r->codigo;
                $tmp->nome =  $r->nome;

                $disciplina[] = $tmp;
            }

            return $disciplina;
        }

        public function getAlunos($turma = 0) {
            
        }

    }