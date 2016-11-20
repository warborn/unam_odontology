<button type="button" class="btn btn-primary catalog" id="role-btn">Agregar Rol</button>

<div class="modal fade" id="role-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title text-center" id="myModalLabel" >Rol</h4>
			</div>
			<div class="modal-body">
				<div class="well">
					<form id="role-form" class="modal-form">
						<div class="form-group" id="role_name">
							<input type="text" name="role_name" placeholder="Nombre del rol" class="form-control">
						</div>

						<div class="form-group" id="role_description">
							<input type="text" name="role_description" placeholder="Descripción del rol" class="form-control">
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