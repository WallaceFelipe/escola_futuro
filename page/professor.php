<?php

include('class/Conexao.class.php');
$conexao    = new Conexao();

if($_GET['deletar']){

	$prof = intval($_GET['deletar']);
	$res = $conexao->execute("delete from professor where idprofessor = '$prof'");

	//if($res)
	//	echo "<script>alert('Professor deletado!');</script>";

}

$professores = $conexao->select('*')->from('professor')->executeNGet();

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

				Lista de Professores

				<button type="button" onclick="location.href='index.php?p=pro_cadastrar';" class="btn btn-primary pull-right">Cadastrar</button>
			
				
			</div>
			<div class="panel-body">
				
				<table class="table table-hover">
					<tr>
						<th>#</th>
						<th>Nome</th>
						<th>Login</th>
						<th></th>
					</tr>
					<?php foreach($professores as $p){ ?>
					<tr>
						<td><?php echo $p['idprofessor']; ?></td>
						<td><?php echo $p['nome']; ?></td>
						<td><?php echo $p['login']; ?></td>
						<td class="text-right">
							<button type="button" onclick="location.href='index.php?p=pro_editar&codigo=<?php echo $p['idprofessor']; ?>';" class="btn btn-xs">editar</button>
							<button type="button" onclick="location.href='index.php?p=professor&deletar=<?php echo $p['idprofessor']; ?>';" class="btn btn-xs btn-danger">deletar</button>
						</td>
					</tr>
					<?php } ?>
				</table>

			</div>
		
		</div>
	</div>
</div><!--/.row-->
