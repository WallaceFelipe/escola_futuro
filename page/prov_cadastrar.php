<?php

include('class/Conexao.class.php');
$conexao    = new Conexao();


$prova = new Avaliacao();
$prova->idavaliacao = intval($_GET['codigo']);

$questoes = $prova->carregaQuestoes();

if($_POST['concluir']){
	
	$total_perguntas = count($questoes);
	$acertos         = 0;
	
	// ve resposta das questoes
	foreach($_POST['questao'] as $idquestao=>$resposta){

		$tmp = new Questao();
		$tmp->idquestao = $idquestao;
		if($resposta == $tmp->get_resposta_correta())
			$acertos++;

	}

	$final = array();
	$final['avaliacao_idavaliacao'] = $prova->idavaliacao;
	$final['aluno_matricula'] = $user->matricula;
	$nota = $acertos/$total_perguntas;
	$final['nota'] = $nota;
	$res = $conexao->insert('nota', $final);

	// quantidade de pessoas que deveria ter feito a prova
	$cont = $conexao->select('count(*) as n')->from("turma_aluno")->where("turma_idturma = in (select turma_idturma from avaliacao where idavaliacao = '".$prova->idavaliacao."')")->executeNGet('n');
	// verifica se todos alunos ja fizeram a prova
	$cont2 = $conexao->select('count(*) as n')->from("nota")->where("avaliacao_idavaliacao = '$prova->idavaliacao'")->executeNGet('n');
	// fim
	if(intval($cont) == intval($cont2)){ // se todos os alunos ja fizeram a prova, marca ela como feita
		$temp = array();
		$temp['status'] = 1;
		$conexao->update('avaliacao', $temp, $prova->idavaliacao, 'idavaliacao');
	}

	$nota = $nota*100;
	$nota = $nota."/100";

	if($res)
		die("<script>alert('avaliação finalizada! Você tirou $nota'); location.href='index.php?p=alu_turma';</script>");


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
		<li class="active">Avaliação <?php echo $prova->idavaliacao; ?></li>
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

					Realizar Avaliação
					<button type="submit" name="concluir" value="true" class="btn btn-primary pull-right">Concluir</button>
				
					
				</div>
				<div class="panel-body">
					<?php 
					$k = 0;
					foreach($questoes as $q){ ?>
					<h2><?php echo $q->enunciado; ?></h2>
					<div class="form-group">
						<label for="in<?php echo $k; ?>"><input required id="in<?php echo $k++; ?>" value="1" name="questao[<?php echo $q->idquestao; ?>]" type="radio"> <?php echo $q->opcao1; ?></label><br>
						<label for="in<?php echo $k; ?>"><input required id="in<?php echo $k++; ?>" value="2" name="questao[<?php echo $q->idquestao; ?>]" type="radio"> <?php echo $q->opcao2; ?></label><br>
						<label for="in<?php echo $k; ?>"><input required id="in<?php echo $k++; ?>" value="3" name="questao[<?php echo $q->idquestao; ?>]" type="radio"> <?php echo $q->opcao3; ?></label><br>
						<label for="in<?php echo $k; ?>"><input required id="in<?php echo $k++; ?>" value="4" name="questao[<?php echo $q->idquestao; ?>]" type="radio"> <?php echo $q->opcao4; ?></label><br>
					</div>
					<hr>
					<?php } ?>


				</div>
			</form>
		
		</div>
	</div>
</div><!--/.row-->
