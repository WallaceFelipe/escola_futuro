<?php



if($_POST['turma']){

	include('../class/Conexao.class.php');
	$conexao    = new Conexao();

	$tur = intval($_POST['turma']);

	$alunos = $conexao
	->select('a.matricula, a.nome')
	->from('turma_aluno ta, aluno a')
	->where("a.matricula = ta.aluno_matricula 
		and ta.turma_idturma = '$tur'
		and a.matricula = '".$user->matricula."'")
	->executeNGet();

	$res = array();

	$res['aluno'] = $alunos;

	die(json_encode($res));

}

include('class/Conexao.class.php');
$conexao    = new Conexao();

if($_GET['deletar']){

	$turma = intval($_GET['deletar']);
	
	$conexao->execute("delete from turma_aluno where turma_idturma = '$turma'");
	$conexao->execute("delete from turma where idturma = '$turma'");
	

}

$alunos = $conexao
			->select('*')
			->from('turma t, professor p')
			->where("t.professor_idprofessor = p.idprofessor and t.idturma IN(select turma_idturma from turma_aluno where aluno_matricula = '".$user->matricula."')")
			->executeNGet();
?>

<style>
.esconder{
	display:none;
}
</style>


<div class="row">
	<ol class="breadcrumb">
		<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
		<li class="active">Turmas e Avaliações</li>
	</ol>
</div><!--/.row-->

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"></h1>
	</div>
</div><!--/.row-->


<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">

			<form action="" method="POST"  enctype="multipart/form-data">
			<div class="panel-heading">

				Minas Turmas e Avaliações
				
			</div>
			<div class="panel-body">
				
				<table class="table table-hover">
					<tr>
						<th>#</th>
						<th>Disciplina</th>
						<th>Professor</th>
						<th>Horário</th>
						<th>Avaliações feitas</th>
						<th>Média</th>
						<th>Avaliações Pendentes</th>
					</tr>
					<?php foreach($alunos as $a){

						$tmp = new Turma();
						$tmp->idturma = $a['idturma'];
						$avaliacoes = $tmp->carregaAvaliacao();

						?>
					<tr>
						<td><?php echo $a['idturma']; ?></td>
						<td><?php echo $a['disciplina_codigo']; ?></td>
						<td><?php echo $a['nome']; ?></td>
						<td><?php echo $a['horario']; ?></td>
						<td><?php
							$divisor = 0;
							$somatorio = 0;

							$avals = $conexao
													->select('*')
													->from("nota")
													->where("avaliacao_idavaliacao in(select idavaliacao from avaliacao where turma_idturma = '".$a['idturma']."') and aluno_matricula = '".$user->matricula."'")
													->executeNGet();

							foreach($avals as $av){
								echo "Avaliação ".$av['avaliacao_idavaliacao'].": Nota ".($av['nota']*100)."<br>";
								$divisor++;
								$somatorio += ($av['nota']*100); 
							}

						?>
						</td>
						<td><?php echo ($somatorio/$divisor); ?></td>
						<td class="text-left">
								
							<?php 
							if(is_array($avaliacoes))
							foreach($avaliacoes as $k=>$av) {


								

								if(!$av->AlunoJaFezAvaliacao($user->matricula)) { 

								?>	
							<button type="button" 
							onclick="location.href='index.php?p=prov_cadastrar&codigo=<?php echo $av->idavaliacao; ?>';" 
							class="btn btn-xs btn-default">
								iniciar avaliação <?php echo $k; ?>
							</button>
							<?php } } ?>

						</td>
					</tr>
					<?php } ?>
				</table>

			</div>
		
		</div>
	</div>
</div><!--/.row-->
