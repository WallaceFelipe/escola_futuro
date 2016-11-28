<?php

include('class/Conexao.class.php');
$conexao    = new Conexao();

if($_POST){

	$var =  array();
	$var['disciplina_codigo'] = $_POST['disciplina_codigo'];
	$var['professor_idprofessor'] = $_POST['professor_idprofessor'];
	$var['horario'] = $_POST['horario'];

	$turma = $conexao->insert('turma',$var);
	$cod = $conexao->insert_id;

	foreach($_POST['alunos'] as $alu){

		$tmp = array();
		$tmp['turma_idturma'] = $cod;
		$tmp['aluno_matricula'] = $alu;
		$tmp['disciplina'] = $var['disciplina_codigo'];
		$conexao->insert('turma_aluno', $tmp);

	}

	echo "<script>alert('Turma criada com sucesso!'); location.href='index.php?p=turma';</script>";

}

$disc = $conexao->select('*')->from('disciplina')->executeNGet();
$prof = $conexao->select('*')->from('professor')->executeNGet();
$alun = $conexao->select('*')->from('aluno')->executeNGet();
?>

<style>
.esconder{
	display:none;
}
</style>


<div class="row">
	<ol class="breadcrumb">
		<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
		<li class="active">Cadastro de Disciplina</li>
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

				Cadastrar Turma
				<button type="submit" class="btn btn-primary pull-right">Salvar</button>
				
			</div>
			<div class="panel-body">
				
				<div class="col-sm-4">

					<h4>Informações Básicas</h4>

					<div class="form-group">
						<label for="">Código</label>
						<select name="disciplina_codigo" class="form-control" required>
							<option value="">Selecione</option>
							<?php foreach($disc as $d){ ?>
							<option value="<?php echo $d['codigo']; ?>"><?php echo $d['codigo']; ?></option>
							<?php } ?>
						</select>
					</div>

					<div class="form-group">
						<label for="">Professor</label>
						<select name="professor_idprofessor" class="form-control" required>
							<option value="">Selecione</option>
							<?php foreach($prof as $d){ ?>
							<option value="<?php echo $d['idprofessor']; ?>"><?php echo $d['nome']; ?></option>
							<?php } ?>
						</select>
					</div>

					<div class="form-group">
						<label for="">Horário</label>
						<input type="text" name="horario" class="form-control">
					</div>

				</div>

				<div class="col-sm-4">
					<select name="alunos[]" class="form-control" required multiple>
					  	<?php foreach($alun as $d){ ?>
							<option value="<?php echo $d['matricula']; ?>"><?php echo $d['nome']; ?></option>
						<?php } ?>

					</select>
				</div>

				

			</div>
			</form>
		</div>
	</div>
</div><!--/.row-->