<div class="modal fade" <?php echo(" id=\"".$modalUpdate."\""); ?> tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Editar Função</h4>
			</div>
			<div class="modal-body">
				<form role="form" method="post" <?php echo(" action=\"".$pageUrl."\""); ?>>
					<div class="form-group">
						<label for="funcao-heading">Função</label>
						<input type="hidden" <?php echo(" name=\"".$dataId."\" id=\"".$dataId."\""); ?> value=""/>
						<input type="text" name=<?php echo("\"".$inputName1."\" id=\"".$inputName1."\""); ?> class="form-control" value="" required>
					</div>
					<div class="form-group">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
						<input <?php echo(" name=\"".$btnUpdate."\""); ?> type="submit" class="btn btn-primary" value="Salvar"/>
						<input <?php echo(" name=\"".$btnDelete."\""); ?> type="submit" class="btn btn-danger" value="Delete" onclick="return confirm('Você tem certeza?');"/>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>