<button type="button" class="btn btn-primary catalog" id="diseases-btn">Agregar Enfermedad</button>

<div class="modal fade" id="diseases-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title text-center" id="myModalLabel">Enfermedad</h4>
			</div>
			<div class="modal-body">
				<div class="well">
					<form id="diseases-form" class="modal-form">
						<div class="form-group" id="disease_id">
							<input type="text" name="disease_id" placeholder="Clave" class="form-control">
						</div>

						<div class="form-group" id="disease_name">
							<input type="text" name="disease_name" placeholder="Nombre" class="form-control">
						</div>

						<div class="form-group" id="type_of_disease">
							<select name="type_of_disease" class="form-control">
								<option selected disabled>Categoria</option>
								<option value="general" selected>General</option>
								<option value="odontológica">Odontológica</option>
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