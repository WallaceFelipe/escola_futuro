<?php


include('class/Conexao.class.php');
$conexao    = new Conexao();

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
		<li class="active">Turmas</li>
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

				Lista de Turmas
				
			</div>
			<div class="panel-body">
				
				<table class="table table-hover">
					<tr>
						<th>#</th>
						<th>Disciplina</th>
						<th>Professor</th>
					
						<th>Avaliações feitas</th>
						<th>Média</th>
						<th>Resultado</th>
					
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
						<td><?php $media = ($somatorio/$divisor); echo $media; ?></td>
						<td><?php if($media < 60){ ?>
							<span class="label label-danger">Reprovado</span>
							<?php }else{ ?>
							<span class="label label-success">Aprovado</span>
							<?php } ?></td>

					</tr>
					<?php } ?>
				</table>

			</div>
		
		</div>
	</div>
</div><!--/.row-->
