<div class="modal fade" <?php echo(" id=\"".$modalInsert."\""); ?> tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><?php echo $pageTitle; ?></h4>
			</div>
			<div class="modal-body">
				<form role="form" method="post" <?php echo(" action=\"".$pageUrl."\""); ?>>
					<div class="form-group">
						<label for="setor-heading"><?php echo $inputTitle1; ?></label>
						<input type="text" <?php echo(" name=\"".$inputName1."\" id=\"".$inputName1."\""); ?> class="form-control" value="" required>
					</div>
					<div class="btn-group" role="group">
						<div class="form-group">
							<select <?php echo(" id=\"".$inputName2."\" name=\"".$inputName2."\""); ?> class="selectpicker" data-width="100%">
								<?php
								echo "<option>".$inputTitle2."</option>";
								for($i=0; $i < count($array); $i++){
									echo "<option>".$array[$i]['nome']."</option>";
								} ?>
							</select> 
						</div>
					</div>
					<div class="form-group">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
						<input <?php echo(" name=\"".$btnInsert."\""); ?> type="submit" class="btn btn-primary" value="Salvar"/>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>