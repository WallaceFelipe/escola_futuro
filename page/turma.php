<?php

include('class/Conexao.class.php');
$conexao    = new Conexao();

if($_GET['deletar']){

	$prof = intval($_GET['deletar']);
	

	

}

$alunos = $conexao->select('*')->from('turma')->executeNGet();

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

				<button type="button" onclick="location.href='index.php?p=tur_cadastrar';" class="btn btn-primary pull-right">Cadastrar</button>
			
				
			</div>
			<div class="panel-body">
				
				<table class="table table-hover">
					<tr>
						<th>#</th>
						<th>Nome</th>

						<th></th>
					</tr>
					<?php foreach($alunos as $p){ ?>
					<tr>
						<td><?php echo $p['codigo']; ?></td>
						<td><?php echo $p['nome']; ?></td>

						<td class="text-right">
							<button type="button" onclick="location.href='index.php?p=tur_veralunos&codigo=<?php echo $p['iddisciplina']; ?>';" class="btn btn-xs">ver alunos</button>
							<button type="button" onclick="location.href='index.php?p=dis_editar&codigo=<?php echo $p['iddisciplina']; ?>';" class="btn btn-xs">editar</button>
							<button type="button" onclick="location.href='index.php?p=disciplina&deletar=<?php echo $p['iddisciplina']; ?>';" class="btn btn-xs btn-danger">deletar</button>
						</td>
					</tr>
					<?php } ?>
				</table>

			</div>
		
		</div>
	</div>
</div><!--/.row-->
