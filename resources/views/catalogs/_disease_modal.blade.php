<button type="button" class="btn btn-primary catalog" data-toggle="modal" data-target="#disease-modal" id="disease-btn">Agregar Enfermedad</button>

<div class="modal fade" id="disease-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Modal title</h4>
			</div>
			<div class="modal-body">
				<div class="well">
					<form id="disease-form">
						<div class="form-group" id="disease_id">
							<input type="text" name="disease_id" placeholder="Clave" class="form-control">
						</div>

						<div class="form-group" id="disease_name">
							<input type="text" name="disease_name" placeholder="Nombre" class="form-control">
						</div>

						<div class="form-group" id="type_of_disease">
							<select name="type_of_disease" class="form-control">
								<option selected disabled>Categoria</option>
								<option value="general">General</option>
								<option value="odontological">Odontológica</option>
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