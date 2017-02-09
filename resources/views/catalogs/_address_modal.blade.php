<button type="button" class="btn btn-primary catalog" id="addresses-btn">Agregar Dirección</button>

<div class="modal fade" id="addresses-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title text-center" id="myModalLabel">Dirección</h4>
			</div>
			<div class="modal-body">
				<div class="well">
					<form id="addresses-form" class="modal-form">
						<div class="form-group" id="postal_code">
							<input type="text" name="postal_code" placeholder="Código postal" class="form-control" id="postal-code-input">
						</div>

						<div class="form-group" id="settlement">
							<input type="text" placeholder="Colonia" name="settlement" class="form-control">
						</div>

						<div class="form-group" id="state">
							<select name="state" class="form-control" id="state-input" readonly>
							</select>
						</div>

						<div class="form-group" id="municipality">
							<select name="municipality" class="form-control" id="municipality-input" readonly>
							</select>
						</div>

						<div class="form-group custom-btn">
							<input type="submit" value="Guardar" class="form-control btn btn-success">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>