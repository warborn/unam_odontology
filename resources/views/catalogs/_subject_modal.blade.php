<button type="button" class="btn btn-primary catalog" id="subjects-btn">Agregar Asignatura</button>

<div class="modal fade" id="subjects-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title text-center" id="myModalLabel" >Asignatura</h4>
			</div>
			<div class="modal-body">
				<div class="well">
					<form id="subjects-form" class="modal-form">
						<div class="form-group" id="subject_id">
							<input type="text" name="subject_id" placeholder="Clave de asignatura" class="form-control">
						</div>
						<div class="form-group" id="subject_name">
							<input type="text" name="subject_name" placeholder="Nombre de asignatura" class="form-control">
						</div>

						<div class="form-group" id="semester">
							<select name="semester" class="form-control">
								<option selected disabled>Semestre</option>
								<option value="1">1°</option>
								<option value="2">2°</option>
								<option value="3">3°</option>
								<option value="4">4°</option>
								<option value="5">5°</option>
								<option value="6">6°</option>
								<option value="7">7°</option>
								<option value="8">8°</option>
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