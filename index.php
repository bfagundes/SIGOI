<?php
session_start();

// variaveis
$pageTitle = "SIGOI";
$pageUrl = "index.php";

// Includes
include ("./functions/conexao.php");
include ("./functions/sessao.php");
require_once('./includes/header.php');
require_once('./includes/navbar_index.php');
?>

	<div class="container-fluid">

		<!-- ----- Tabela de Chamados Abertos ------ -->
		<table class="table table-condensed table-hover">
			<thead>
				<tr>
					<th width="2%"></th>
					<th width="2%"></th>
					<th class="col-sm-3">Chamados Abertos</th>
					<th class="col-sm-2">Solicitante</th>
					<th class="col-sm-2">Local</th>
					<th class="col-sm-1">Data</th>
					<th class="col-sm-2">Técnico</th>
				</tr>
			</thead>
			<tbody>
				<tr>
			  		<td><input type="checkbox" class="Ch-Abertos"></td>
			  		<td><span class="label label-danger">Urgente</span></td> 
			  		<td>Mudar as mesas de lugar</td>
			  		<td>Anne</td>
			  		<td>Assessoria Técnica</td>
			  		<td>10/Ago/15</td>
			  		<td>Matteus Barragan</td>
		  		</tr>
		  		<tr>
			  		<td><input type="checkbox" class="Ch-Abertos"></td>
			  		<td><span class="label label-warning">Alta</span></td> 
			  		<td>A pasta da farmácia sumui do desktop</td>
			  		<td>Karina da Farmácia</td>
			  		<td>Farmácia</td>
			  		<td>10/Ago/15</td>
			  		<td>Elisa Penteado</td>
		  		</tr>
		  		<tr>
			  		<td><input type="checkbox" class="Ch-Abertos"></td>
			  		<td><span class="label label-info">Média</span></td> 
			  		<td>Problemas com terroristas sírios</td>
			  		<td>Tera Giga</td>
			  		<td>Egenharia</td>
			  		<td>10/Ago/15</td>
			  		<td>Bruno Fagundes</td>
		  		</tr>
		  		<tr>
			  		<td><input type="checkbox" class="Ch-Abertos"></td>
			  		<td><span class="label label-success">Baixa</span></td> 
			  		<td>Quebrar 38 contas</td>
			  		<td>Adriana</td>
			  		<td>Faturamento</td>
			  		<td>10/Ago/15</td>
			  		<td>Igor Nunes</td>
		  		</tr>
			</tbody>
		</table>

		<!-- ----- Tabela de Chamados Pendentes ------ -->
		<table class="table table-condensed table-hover">
			<thead>
				<tr>
					<th width="2%"></th>
					<th width="2%"></th>
					<th class="col-sm-3">Chamados Pendentes</th>
					<th class="col-sm-2">Solicitante</th>
					<th class="col-sm-2">Local</th>
					<th class="col-sm-1">Data</th>
					<th class="col-sm-2">Técnico</th>
				</tr>
			</thead>
			<tbody>
				<tr>
			  		<td><input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."></td>
			  		<td><span class="label label-danger">Urgente</span></td> 
			  		<td>Mudar as mesas de lugar</td>
			  		<td>Anne</td>
			  		<td>Assessoria Técnica</td>
			  		<td>10/Ago/15</td>
			  		<td>Matteus Barragan</td>
		  		</tr>
		  		<tr>
			  		<td><input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."></td>
			  		<td><span class="label label-warning">Alta</span></td> 
			  		<td>A pasta da farmácia sumui do desktop</td>
			  		<td>Karina da Farmácia</td>
			  		<td>Farmácia</td>
			  		<td>10/Ago/15</td>
			  		<td>Elisa Penteado</td>
		  		</tr>
		  		<tr>
			  		<td><input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."></td>
			  		<td><span class="label label-info">Média</span></td> 
			  		<td>Problemas com terroristas sírios</td>
			  		<td>Tera Giga</td>
			  		<td>Egenharia</td>
			  		<td>10/Ago/15</td>
			  		<td>Bruno Fagundes</td>
		  		</tr>
		  		<tr>
			  		<td><input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."></td>
			  		<td><span class="label label-success">Baixa</span></td> 
			  		<td>Quebrar 38 contas</td>
			  		<td>Adriana</td>
			  		<td>Faturamento</td>
			  		<td>10/Ago/15</td>
			  		<td>Igor Nunes</td>
		  		</tr>
			</tbody>
		</table>
	</div>

	<!-- Footer -->
	<?php require_once('./includes/footer.php'); ?>

</body>
</html>