<?php

include('class/Conexao.class.php');
$conexao    = new Conexao();

if($_POST){

	$insert = $conexao->insert('professor', $_POST);

	if($insert)
		die("
		<script>
			alert('Professor cadastrado com sucesso!'); 
			location.href='index.php?p=professor';
		</script>");


}

?>

<style>
.esconder{
	display:none;
}
</style>


<div class="row">
	<ol class="breadcrumb">
		<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
		<li class="active">Cadastro de Projeto</li>
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

				Cadastrar Professor
				<button type="submit" class="btn btn-primary pull-right">Salvar</button>
				
			</div>
			<div class="panel-body">
				
				<div class="col-sm-4">

					<h4>Informações Básicas</h4>

					<div class="form-group">
						<label for="">Nome do Professor</label>
						<input type="text"  required class="form-control" name="nome">
					</div>

					<div class="form-group">
						<label for="">Login do Professor</label>
						<input type="text" value="" required  class="form-control" name="login">
					</div>

					<div class="form-group">
						<label for="">Senha</label>
						<input type="password" required  class="form-control" name="senha">
					</div>

				</div>

				

			</div>
			</form>
		</div>
	</div>
</div><!--/.row-->