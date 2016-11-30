
<style>
.esconder{
	display:none;
}
</style>


<div class="row">
	<ol class="breadcrumb">
		<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
		<li class="active">Professores</li>
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

				Lista de Professores

				<!--<button type="button" onclick="location.href='index.php?p=pro_cadastrar';" class="btn btn-primary pull-right">Cadastrar</button>-->
			
				
			</div>
			<div class="panel-body">
				
				<table class="table table-hover">
					<tr>
						<th>#</th>
						<th>Codigo</th>
						<th>Disciplina</th>
						<th>Horario</th>
						<th></th>
					</tr>
					<?php foreach($user->turmas as $k => $turma){ ?>
					<tr>
						<td><?php echo $turma->idturma; ?></td>
						<td><?php echo $turma->disciplina_codigo; ?></td>
						<td><?php echo $turma->disciplina_nome; ?></td>
						<td><?php echo $turma->horario; ?></td>
						<td class="text-right">
							<button type="button" onclick="location.href='index.php?p=professor_avaliacoes&id=<?php echo $k; ?>';" class="btn btn-sm btn-success">avaliações</button>
						</td>
					</tr>
					<?php } ?>
				</table>

			</div>
		
		</div>
	</div>
</div><!--/.row-->
