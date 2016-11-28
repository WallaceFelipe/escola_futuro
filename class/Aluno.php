<?php

class Aluno extends CI_Model {
    public $matricula;
    public $nome;
    public $login;
    public $senha;

    /*
        Construtor
    */
    public function __construct ($matricula=0) {
        // Carregando biblioteca do banco de dados
        $this->load->database();

        /*
            Recupera um aluno já existente do banco de dados
                @ se $matricula for passado como parâmetro
        */
        if ($matricula) {
            // Obtém  aluno com respectivo "$matricula"
            $this->db->where('matricula', $matricula);
            
            // Obtém o primeiro resultado (index 0) da busca
            $result = $this->db->get('alunos')->result()[0];

            // Monta o objeto aluno
            $this->matricula = $result->matricula;
            $this->nome = $result->nome;
            $this->login = $result->login;
            $this->senha = $result->senha;
        }

        /*
            Adicionar novo aluno
                @ se $matricula não for passado como parâmetro
        */
        else {
            // Remove o atributo matricula, já que ele será
            //  automaticamente gerado pelo banco de dados.
            unset( $this->matricula );
        }
    }

    /*
        Adiciona ou atualiza o aluno no banco de dados
    */
    public function save () {
        // Atualiza
        //  @ verifico se o atributo "matricula" existe neste objeto.
        //    lembrando que este atributo é apagado se criamos um novo aluno.
        if ( isset($this->matricula) ) {
             $this->db->update('alunos', $this, array('matricula' => $this->matricula));
        }
        // Salva
        else {
            $this->db->insert('alunos', $this);
        }
    }

    /*
        Deleta o aluno do banco de dados
    */
    public function delete () {
        $this->db->delete('alunos', array('matricula' => $this->matricula));
    }

    /*
        Obtém uma lista de todos os alunos
    */
    public static function getAlunos () {
        // Obtém instância do CodeIgniter
        $CI =& get_instance();

        // Carregando biblioteca do banco de dados
        $CI->load->database();

        // Obtém todos os posts
        $CI->db->order_by("matricula", "cresc");
        $result = $CI->db->get('alunos')->result();

        // Monta vetor de objetos "Aluno"
        $alunos  = [];

        foreach ($result as $aluno) {
            $tmp    = new Aluno();
            $tmp->matricula = $aluno->matricula;
            $tmp->nome = $aluno->nome;
            $tmp->login = $aluno->login;
            $tmp->senha = $aluno->senha;

            $alunos[] = $tmp;
        }

        return $alunos;
    }

}