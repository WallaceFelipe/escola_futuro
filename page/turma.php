<?php



if($_POST['turma']){

	include('../class/Conexao.class.php');
	$conexao    = new Conexao();

	$tur = intval($_POST['turma']);

	$alunos = $conexao
	->select('a.matricula, a.nome')
	->from('turma_aluno ta, aluno a')
	->where("a.matricula = ta.aluno_matricula 
		and ta.turma_idturma = '$tur'")
	->executeNGet();

	$res = array();

	$res['aluno'] = $alunos;

	die(json_encode($res));

}

include('class/Conexao.class.php');
$conexao    = new Conexao();

if($_GET['deletar']){

	$turma = intval($_GET['deletar']);
	
	$conexao->execute("delete from turma_aluno where turma_idturma = '$turma'");
	$conexao->execute("delete from turma where idturma = '$turma'");
	

}

$alunos = $conexao->select('*')->from('turma t, professor p')->where("t.professor_idprofessor = p.idprofessor")->executeNGet();

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
						<th>Disciplina</th>
						<th>Professor</th>
						<th>Horário</th>
						<th>Alunos Matriculados</th>
						<th></th>
					</tr>
					<?php foreach($alunos as $a){

						$cont = $conexao->select('count(*) as n')->from("turma_aluno")->where("turma_idturma = '".$a['idturma']."'")->executeNGet('n');
						?>
					<tr>
						<td><?php echo $a['idturma']; ?></td>
						<td><?php echo $a['disciplina_codigo']; ?></td>
						<td><?php echo $a['nome']; ?></td>
						<td><?php echo $a['horario']; ?></td>
						<td><?php echo $cont; ?></td> 
						</td>
						<td class="text-right">
							<button type="button" 
							onclick="listar_alunos('<?php echo $a['idturma']; ?>');"
							class="btn btn-xs btn-info">
								ver alunos
							</button>

							<button type="button" 
							onclick="location.href='index.php?p=tur_editar&codigo=<?php echo $a['idturma']; ?>';" 
							class="btn btn-xs">
								editar
							</button>

							<button type="button" 
							onclick="location.href='index.php?p=turma&deletar=<?php echo $a['idturma']; ?>';" 
							class="btn btn-xs btn-danger">
								deletar
							</button>

						</td>
					</tr>
					<?php } ?>
				</table>

			</div>
		
		</div>
	</div>
</div><!--/.row-->

<script>
	function listar_alunos(t){

		console.log(t);
		$('#tabela').html('');

		$.post(
			'page/turma.php',
			{turma:t}
		).done(function(data){

			var tabela = '<tr><th>#</th><th>Aluno</th></tr>';

			console.log(data);
			var d = JSON.parse(data);
			console.log(d);

			for(var k =0; k < d.aluno.length; k++){
				tabela += "<tr><td>"+ d.aluno[k].matricula +"</td><td>"+ d.aluno[k].nome +"</td></tr>";
			}

			$('#tabela').html(tabela);

		});

		$('#myModal').modal('show');
	}
</script>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Alunos Matriculados</h4>
      </div>
      <div class="modal-body">
        <table id="tabela" class="table table-hover">
        	

        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
