<?php

if($_POST){
	include('../class/Conexao.class.php');
	include('../class/Questao.class.php');
	include('../class/Avaliacao.class.php');
	

	//Trecho para o cadastro da questão via post ajax
	if($_POST['action'] == 'questao') {
		$var = new Questao();
		$var->enunciado = $_POST['enunciado'];
		$var->opcao1 = $_POST['opcao1'];
		$var->opcao2 = $_POST['opcao2'];
		$var->opcao3 = $_POST['opcao3'];
		$var->opcao4 = $_POST['opcao4'];
		$var->resposta = $_POST['resposta'];
		$var->disciplina_codigo = $_POST['disciplina_codigo'];

		$var->save();

		die(json_encode($var->idquestao));
	}

	
	//atualização das informações da avaliação
	$var =  new Avaliacao();
	$var->idavaliacao = $_POST['avaliacao'];
	$var->turma_idturma = $_POST['turma'];
	$var->status = 0;
	var_dump($var);
	$var->save($_POST['questoes']);
	
	

	echo "<script>alert('Avaliação cadastrada com sucesso.'); location.href='index.php?p=professor_turmas';</script>";

}
include('class/Conexao.class.php');

$conexao    = new Conexao();

$turma = $user->turmas[$_GET['t']];
$questoes = $conexao->select('*')->from('questao')->where('disciplina_codigo = "'.$turma->disciplina_codigo.'"')->orderby('idquestao desc')->executeNGet();
$questoes_cad = $conexao->select('*')->from('questao_avaliacao')->where('avaliacao_idavaliacao ='.$_GET['id'])->orderby('questao_idquestao desc')->executeNGet();
$cadastradas = [];
foreach ($questoes_cad as $questao) {
	$cadastradas[] = $questao['questao_idquestao'];
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
		<li class="active">Cadastro de Avaliação</li>
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

				Cadastrar Avaliação
				<button type="submit" class="btn btn-primary pull-right">Salvar</button>
				
			</div>
			<div class="panel-body">
				
				<div class="col-sm-4">

					<h4>Informações Básicas</h4>

					<div class="form-group">
						<label for="">Turma</label>
						<input class="form-control hidden" name="turma" value="<?php echo $turma->idturma;?>">
						<input class="form-control hidden" name="avaliacao" value="<?php echo $_GET['id'];?>">
						<input class="form-control" value="<?php echo $turma->disciplina_codigo.' - '.$turma->disciplina_nome.' - '.$turma->horario;?>" readonly>
					</div>

				</div>

				<div class="col-sm-8">
					<div class="panel panel-defult">
						<div class="panel-heading">
							Escolha as questões
							<button type="button" class="btn btn-primary pull-right" onclick="$('#myModal').modal('show');">Nova Questão</button>
						</div>
						<div class="panel-body">
							<table class="table table-hover">
								<thead>
									<th>#</th>
									<th>Enunciado</th>
								</thead>
								<tbody id='listaQuestao'>
									<?php foreach ($questoes as $questao) { ?>
										<tr>
											<td><?php if(in_array($questao['idquestao'], $cadastradas)) {?>
													<input type="checkbox" name="questoes[]" value="<?php echo $questao['idquestao']; ?>" checked>
												<?php }else{ ?>
													<input type="checkbox" name="questoes[]" value="<?php echo $questao['idquestao']; ?>"> <?php } ?></td>
											<td><?php echo $questao['enunciado']; ?></td>
										</tr>
									<?php }?>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				

			</div>
			</form>
		</div>
	</div>
</div><!--/.row-->


<script>

	function cadastrar_questao() {

		$.post(
			'page/avaliacao_cadastrar.php',
			{
				action: 'questao',
				enunciado: $('#enunciado').val(),
				opcao1: $('#opcao1').val(),
				opcao2: $('#opcao2').val(),
				opcao3: $('#opcao3').val(),
				opcao4: $('#opcao4').val(),
				resposta: $('#resposta').val(),
				disciplina_codigo: '<?php echo $turma->disciplina_codigo;?>'
			}).done(function(data){
			
				console.log(data);
				var d = JSON.parse(data);

				var tupla = '<tr>' +
								'<td><input type="checkbox" name="questoes[]" value="'+data[0]+'" checked></td>' +
								'<td>'+$('#enunciado').val()+'</td>' +
							'</tr>';

				$('#listaQuestao').prepend(tupla);

			});
	}
</script>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Nova Questão</h4>
      </div>
	  
      <div class="modal-body">
        <div class="form-group">
			<label for="">Enunciado</label>
			<input type="text" id="enunciado" class="form-control" name="enunciado" placeholder="Digite o enunciado da questão..." required>
		</div>
		<div class="form-group">
			<label for="">Opção 1</label>
			<input type="text" id="opcao1" class="form-control" name="opcao1"  required>
		</div>
		<div class="form-group">
			<label for="">Opção 2</label>
			<input type="text" id="opcao2" class="form-control" name="opcao2"  required>
		</div>
		<div class="form-group">
			<label for="">Opção 3</label>
			<input type="text" id="opcao3" class="form-control" name="opcao3"  required>
		</div>
		<div class="form-group">
			<label for="">Opção 4</label>
			<input type="text" id="opcao4" class="form-control" name="opcao4"  required>
		</div>
		<div class="form-group">
			<label for="">Resposta Correta</label>
			<select class="form-control" id="resposta" required>
				<option value="1">Opção 1</option>
				<option value="2">Opção 2</option>
				<option value="3">Opção 3</option>
				<option value="4">Opção 4</option>
			</select>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal" onclick='cadastrar_questao();'>Cadastrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->