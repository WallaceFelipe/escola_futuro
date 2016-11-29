<?php


include('class/Conexao.class.php');
$conexao    = new Conexao();

$turma = intval($_GET['turma']);

$alunos = $conexao
			->select('*')
			->from('aluno')
			->where(" matricula in (select aluno_matricula from turma_aluno where turma_idturma = '$turma')")
			->executeNGet();

$provas = $conexao->select('*')->from('avaliacao')->where("turma_idturma = '$turma'")->executeNGet();


?>

<style>
.esconder{
	display:none;
}
</style>


<div class="row">
	<ol class="breadcrumb">
		<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
		<li><a href="index.php?p=notas_professor">Notas</a></li>
		<li class="active">Notas da Turma</li>
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

		
			<div class="panel-heading">

				

				<button type="button" onclick="location.href='index.php?p=notas_professor';" class="btn btn-danger">< Voltar</button>
				Notas da Turma
			</div>
			<div class="panel-body">
				
				<table class="table table-hover">
					<tr>
						<th>Matrícula</th>
						<th>Aluno</th>
						<?php 
						$array_provas = array();
						foreach($provas as $p){
							$array_provas[] = $p['idavaliacao'];
							?>
						<th>Prova #<?php echo $p['idavaliacao']; ?></th>
						<?php } ?>
						<th>Média</th>
						<th>Resultado</th>
					
					</tr>
					<?php foreach($alunos as $a){



						?>

					<tr>
						<td><?php echo $a['matricula']; ?></td>
						<td><?php echo $a['nome']; ?></td>
						<?php 
						$somatorio = 0;
						foreach($array_provas as $id_prova){ ?>
						<td><?php
						$nota = ($conexao->select('nota')->from('nota')->where("avaliacao_idavaliacao = '$id_prova' and aluno_matricula = '".$a['matricula']."'")->limit(1)->executeNGet('nota') * 100);
						$somatorio += $nota;
						echo $nota;
						?></td>
						<?php } ?>
						<td>
							<?php $media = ($somatorio/count($array_provas)); echo $media; ?>
						</td>
						<td>
							<?php if($media < 60){ ?>
							<span class="label label-danger">Reprovado</span>
							<?php }else{ ?>
							<span class="label label-success">Aprovado</span>
							<?php } ?>
						</td>
						
					
			
					</tr>
					<?php } ?>
				</table>

			</div>
		
		</div>
	</div>
</div><!--/.row-->
