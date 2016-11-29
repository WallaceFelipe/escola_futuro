<?php


$pagina = 'inicial.php';
if(isset($_GET['p']))
	$pagina = $_GET['p'].".php";


?>

<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">

		<ul class="nav menu">
			<!-- Menu que chama as pages -->
			<li <?php if ($_GET['p'] == 'inicio' || empty($_GET['p'])) echo "class='active'"; ?> ><a href="index.php"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Dashboard</a></li>
			
			<!-- modulo 3 -->
			<li <?php if ($_GET['p'] == 'alu_turma') echo "class='active'"; ?> >
				<a href="index.php?p=alu_turma">
					<svg class="glyph stroked male user"><use xlink:href="#stroked-male-user"></use></svg> Minhas Turmas/Avaliações
				</a>
			</li>
			<li <?php if ($_GET['p'] == 'notas_aluno') echo "class='active'"; ?> >
				<a href="index.php?p=notas_aluno">
					<svg class="glyph stroked male user"><use xlink:href="#stroked-male-user"></use></svg> Minhas Notas
				</a>
			</li>
		</ul>

	</div><!--/.sidebar-->

	
	<!--Inclui as paginas -->
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<?php include('page/'.$pagina); ?>
	</div><!--/.main-->