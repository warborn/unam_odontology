<button type="button" class="btn btn-primary catalog" data-toggle="modal" data-target="#address-modal" id="address-btn">Agregar Dirección</button>

<div class="modal fade" id="address-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Modal title</h4>
			</div>
			<div class="modal-body">
				<div class="well">
					<form>
						<div class="form-group">
							<input type="text" placeholder="Nombre" class="form-control">
						</div>

						<div class="form-group">
							<input type="text" placeholder="Código postal" class="form-control">
						</div>

						<div class="form-group">
							<select class="form-control">
								<option value="">Estado de México</option>
								<option value="">Cuidad de México</option>
							</select>
						</div>

						<div class="form-group">
							<select class="form-control">
								<option value="">Naucalpan de Juarez</option>
								<option value="">Cuautitlán Izcalli</option>
							</select>
						</div>

						<div class="form-group">
							<select class="form-control">
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