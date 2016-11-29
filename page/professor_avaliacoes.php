<?php
	$turma = $user->turmas[$_GET['id']];
	$turma->carregaAvaliacao();
	
	
?>
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

				Lista de Avaliações

				<button type="button" onclick="location.href='index.php?p=avaliacao_cadastrar';" class="btn btn-primary pull-right">Cadastrar Avaliação</button>
			
				
			</div>
			<div class="panel-body">
				
				<table class="table table-hover">
					<tr>
						<th>#</th>
						<th>Avaliação</th>
						<th>Status</th>
						<th></th>
					</tr>
					<?php foreach($turma->avaliacaoList as $k => $avaliacao){ ?>
					<tr>
						<td><?php echo $avaliacao->idavaliacao; ?></td>
						<td><?php echo $k+1; ?></td>
						<?php if($avaliacao->status == 0) { ?>
							<td><?php echo 'Não respondido';?></td>

							<td class="text-right">
								<button type="button" onclick="location.href='index.php?p=professor_avaliacoes&id=<?php echo $turma->idturma; ?>';" class="btn btn-sm btn-default">editar</button>
								<button type="button" onclick="location.href='index.php?p=professor_alunos&id=<?php echo $turma->idturma; ?>';" class="btn btn-sm btn-danger">deletar</button>
							</td>
						<?php }else { ?>
							<td><?php echo 'Respondido';?></td>
						<?php } ?>  
					</tr>
					<?php } ?>
				</table>

			</div>
		
		</div>
	</div>
</div><!--/.row-->
