<?php


$pagina = 'inicial.php';
if(isset($_GET['p']))
	$pagina = $_GET['p'].".php";


?>

<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">

		<ul class="nav menu">
			<!-- Menu que chama as pages -->
			<li <?php if ($_GET['p'] == 'inicio' || empty($_GET['p'])) echo "class='active'"; ?> ><a href="index.php"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Dashboard</a></li>
			<li <?php if ($_GET['p'] == 'Turma') echo "class='active'"; ?> ><a href="index.php?p=professor_turmas"><svg class="glyph stroked male user"><use xlink:href="#stroked-male-user"></use></svg> Minhas Turmas</a></li>
			<!--<li <?php if ($_GET['p'] == 'aluno') echo "class='active'"; ?> ><a href="index.php?p=aluno"><svg class="glyph stroked male user"><use xlink:href="#stroked-male-user"></use></svg> Alunos</a></li>
			<li <?php if ($_GET['p'] == 'disciplina') echo "class='active'"; ?> ><a href="index.php?p=disciplina"><svg class="glyph stroked male user"><use xlink:href="#stroked-male-user"></use></svg> Disciplinas</a></li>
			<li <?php if ($_GET['p'] == 'turma') echo "class='active'"; ?> ><a href="index.php?p=turma"><svg class="glyph stroked male user"><use xlink:href="#stroked-male-user"></use></svg> Turmas</a></li>-->
			<li <?php if ($_GET['p'] == 'notas_professor') echo "class='active'"; ?> >
				<a href="index.php?p=notas_professor">
					<svg class="glyph stroked male user"><use xlink:href="#stroked-male-user"></use></svg> Notas
				</a>
			</li>
		</ul>

	</div><!--/.sidebar-->

	
	<!--Inclui as paginas -->
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<?php include('page/'.$pagina); ?>
	</div><!--/.main-->