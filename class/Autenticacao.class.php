<?php 
    require_once('Conexao.class.php');
    require_once('Professor.class.php');
    require_once('Aluno.class.php');
    require_once('Funcionario.class.php');

    class Autenticacao
    {
        public function autenticar($ator, $login, $senha) {
            $db = new Conexao();
            $login = $db->escape($login);
            $senha = $db->escape($senha);
            
            
            switch ($ator) {
                case 'professor':
                    $resultado = $this->prof_auth($db, $login, $senha);
                    break;
                case 'aluno':
                    $resultado = $this->aluno_auth($db, $login, $senha);
                    break;
                case 'funcionario':
                    $resultado = $this->func_auth($db, $login, $senha);
                    break;
                default:
                    $resultado = null;
                    break;
            }
            var_dump($resultado);
            return $resultado;
        }


        private function prof_auth($db, $login, $senha) {
            $result = $db->select("*")->from("professor")->where('login = "'.$login.'" and senha = "'.$senha.'"')->limit(1)->executeNGet();

            if ($result) {
                $objeto = new Professor();
                $objeto->nome = $result['nome'];
                $objeto->codigo = $result['codigo'];
                $objeto->senha = $result['senha'];
                $objeto->login = $result['login'];

                // Query que lista as informações das turmas que o professor leciona
                $turmas = $db->execute("SELECT turma.*, disciplina.nome FROM turma JOIN disciplina ON turma.disciplina_codigo = disciplina.codigo WHERE turma.professor_idprofessor = ".$result['idprofessor']);
                foreach ($turmas as $turma) {
                    # criar turma
                }
            } else {
                $objeto = null;
            }

            return $objeto;
        }
        
        private function aluno_auth($db, $login, $senha) {
            $result = $db->select("*")->from("aluno")->where('login = "'.$login.'" and senha = "'.$senha.'"')->limit(1)->executeNGet();
            
            if ($result) {
                $objeto = new Aluno();
                $objeto->nome = $result['nome'];
                $objeto->matricula = $result['matricula'];
                $objeto->senha = $result['senha'];
                $objeto->login = $result['login'];

                // Query que lista as informações das turmas que o aluno está matriculado
                $turmas = $db->execute("SELECT turma.*, disciplina.nome FROM turma_aluno JOIN turma ON turma_aluno.turma_idturma = turma.idturma JOIN disciplina ON turma.disciplina_codigo = disciplina.codigo WHERE turma_aluno.aluno_matricula = ".$result['matricula']);
                foreach ($turmas as $turma) {
                    # criar turma
                }
            } else {
                $objeto = null;
            }

            return $objeto;
        }

        private function func_auth($db, $login, $senha) {
            
            $result = $db->select("*")->from("funcionario")->where('login = "'.$login.'" and senha = "'.$senha.'"')->limit(1)->executeNGet();
            
            if ($result) {
                $objeto = new Funcionario();
                $objeto->nome = $result['nome'];
                $objeto->idfuncionario = $result['idfuncionario'];
                $objeto->senha = $result['senha'];
                $objeto->login = $result['login'];
            } else {
                $objeto = null;
            }
            return $objeto;
        }

    }