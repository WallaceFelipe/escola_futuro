<?php

include('class/Conexao.class.php');
$conexao    = new Conexao();

if($_POST){


	$insert = $conexao->update('disciplina', $_POST, $_GET['codigo'], 'iddisciplina');

	if($insert)
		die("
		<script>
			alert('Disciplina editado com sucesso!'); 
			location.href='index.php?p=disciplina';
		</script>");


}
$cod = intval($_GET['codigo']);
$p = $conexao->select('*')->from('disciplina')->where("iddisciplina='$cod'")->limit(1)->executeNGet();

?>

<style>
.esconder{
	display:none;
}
</style>


<div class="row">
	<ol class="breadcrumb">
		<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
		<li class="active">Editar Disciplina</li>
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

				Editar Disciplina
				<button type="submit" class="btn btn-primary pull-right">Salvar</button>
				
			</div>
			<div class="panel-body">
				
				<div class="col-sm-4">

					<h4>Informações Básicas</h4>

					<div class="form-group">
						<label for="">Código do Aluno</label>
						<input type="text" value="<?php echo $p['codigo']; ?>" required  class="form-control" name="codigo">
					</div>

					<div class="form-group">
						<label for="">Nome do Aluno</label>
						<input type="text" value="<?php echo $p['nome']; ?>" required class="form-control" name="nome">
					</div>

					

			

				</div>

				

			</div>
			</form>
		</div>
	</div>
</div><!--/.row-->