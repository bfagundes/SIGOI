<?php
include ("./functions/conexao.php");
include ("./functions/sessao.php");
require_once('./includes/header.php');
?>

<div id="prefetch">
	<input type="text" class="typeahead form-control" placeholder="Solicitante" id="inputSolicitante" name="inputSolicitante">
</div>

<script type="text/javascript">
var bestPictures = new Bloodhound({
	datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
	queryTokenizer: Bloodhound.tokenizers.whitespace,
	prefetch: '../data/films/post_1960.json',
	remote: {
		url: 'typeahead.php?query=%QUERY',
		wildcard: '%QUERY'
	}
});

$('#prefetch .typeahead').typeahead(null, {
	name: 'nome',
	display: 'nome',
	source: bestPictures
});
</script>

</body>
</html>