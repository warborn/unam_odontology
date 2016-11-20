<button type="button" class="btn btn-primary catalog" id="federal-entity-btn">
	Agregar Entidad Federativa
</button>

<div class="modal fade" id="federal-entity-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title text-center" id="myModalLabel" >Agregar Entidad Federativa</h4>
			</div>
			<div class="modal-body">
				<div class="well">
					<form id="federal-entity-form" class="modal-form">
						<div class="form-group">
							<input type="text" name="federal_entity_name" placeholder="Nombre" class="form-control">
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