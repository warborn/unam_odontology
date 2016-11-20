<button type="button" class="btn btn-primary catalog" id="privilege-btn">Agregar Privilegio</button>

<div class="modal fade" id="privilege-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title text-center" id="myModalLabel" >Privilegio</h4>
			</div>
			<div class="modal-body">
				<div class="well">
					<form id="privilege-form" class="modal-form">
						<div class="form-group" id="privilege_name">
							<input type="text" name="privilege_name" placeholder="Nombre del privilegio" class="form-control">
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