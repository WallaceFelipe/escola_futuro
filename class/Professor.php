<?php

class Professor extends CI_Model {
    public $idprofessor;
    public $nome;
    public $login;
    public $senha;

    /*
        Construtor
    */
    public function __construct ($idprofessor=0) {
        // Carregando biblioteca do banco de dados
        $this->load->database();

        /*
            Recupera um professor já existente do banco de dados
                @ se $idprofessor for passado como parâmetro
        */
        if ($idprofessor) {
            // Obtém  professor com respectivo "$idprofessor"
            $this->db->where('idprofessor', $idprofessor);
            
            // Obtém o primeiro resultado (index 0) da busca
            $result = $this->db->get('professores')->result()[0];

            // Monta o objeto professor
            $this->idprofessor = $result->idprofessor;
            $this->nome = $result->nome;
            $this->login = $result->login;
            $this->senha = $result->senha;
        }

        /*
            Adicionar novo professor
                @ se $idprofessor não for passado como parâmetro
        */
        else {
            // Remove o atributo idprofessor, já que ele será
            //  automaticamente gerado pelo banco de dados.
            unset( $this->idprofessor );
        }
    }

    /*
        Adiciona ou atualiza o professor no banco de dados
    */
    public function save () {
        // Atualiza
        //  @ verifico se o atributo "idprofessor" existe neste objeto.
        //    lembrando que este atributo é apagado se criamos um novo professor.
        if ( isset($this->idprofessor) ) {
             $this->db->update('professores', $this, array('idprofessor' => $this->idprofessor));
        }
        // Salva
        else {
            $this->db->insert('professores', $this);
        }
    }

    /*
        Deleta o professor do banco de dados
    */
    public function delete () {
        $this->db->delete('professores', array('idprofessor' => $this->idprofessor));
    }

    /*
        Obtém uma lista de todos os professores
    */
    public static function getProfessores () {
        // Obtém instância do CodeIgniter
        $CI =& get_instance();

        // Carregando biblioteca do banco de dados
        $CI->load->database();

        // Obtém todos os posts
        $CI->db->order_by("idprofessor", "cresc");
        $result = $CI->db->get('professores')->result();

        // Monta vetor de objetos "Professor"
        $professores  = [];

        foreach ($result as $professor) {
            $tmp    = new Professor();
            $tmp->idprofessor = $professor->idprofessor;
            $tmp->nome = $professor->nome;
            $tmp->login = $professor->login;
            $tmp->senha = $professor->senha;

            $professores[] = $tmp;
        }

        return $professores;
    }

}