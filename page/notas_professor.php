<?php


include('class/Conexao.class.php');
$conexao    = new Conexao();


$alunos = $conexao
			->select('*')
			->from('turma t, professor p')
			->where("t.professor_idprofessor = p.idprofessor and t.professor_idprofessor = '".$user->idprofessor."'")
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
		<li class="active">Notas dos Alunos</li>
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

				Notas dos Alunos
				
			</div>
			<div class="panel-body">
				
				<table class="table table-hover">
					<tr>
						<th>#</th>
						<th>Disciplina</th>
						<th>Professor</th>
						<th>Alunos Matriculados</th>
						<th>Ação</th>
					
					</tr>
					<?php foreach($alunos as $a){

						?>

					<tr>
						<td><?php echo $a['idturma']; ?></td>
						<td><?php echo $a['disciplina_codigo']; ?></td>
						<td><?php echo $a['nome']; ?></td>
						<td>
							<?php
							$cont = $conexao->select('count(*) as n')->from("turma_aluno")->where("turma_idturma = '".$a['idturma']."'")->executeNGet('n');
							echo $cont; ?>
						</td>
						<td><button type="button" onclick="location.href='index.php?p=ver_notas_turma&turma=<?php echo $a['idturma']; ?>'"; class="btn btn-xs btn-success">ver alunos e notas</button></td>
						
					
			
					</tr>
					<?php } ?>
				</table>

			</div>
		
		</div>
	</div>
</div><!--/.row-->
