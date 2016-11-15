<button type="button" class="btn btn-primary catalog" id="address-btn">Agregar Dirección</button>

<div class="modal fade" id="address-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title text-center" id="myModalLabel">Dirección</h4>
			</div>
			<div class="modal-body">
				<div class="well">
					<form id="address-form" class="modal-form">
						<div class="form-group">
							<input type="text" name="postal_code"" placeholder="Código postal" class="form-control">
						</div>

						<div class="form-group">
							<select name="federal_entity_id" class="form-control">
								<option value="">Estado de México</option>
								<option value="">Cuidad de México</option>
							</select>
						</div>

						<div class="form-group">
							<select name="municipality" class="form-control">
								<option value="">Naucalpan de Juarez</option>
								<option value="">Cuautitlán Izcalli</option>
							</select>
						</div>

						<div class="form-group">
							<select name="settlement" class="form-control">
								<option value="">Jardines del Molinito</option>
								<option value="">Xhala</option>
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