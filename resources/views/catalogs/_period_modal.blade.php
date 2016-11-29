<button type="button" class="btn btn-primary catalog" id="period-btn">Agregar Periodo</button>

<div class="modal fade" id="period-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title text-center" id="myModalLabel" >Periodo</h4>
			</div>
			<div class="modal-body">
				<div class="well">
					<form id="period-form" class="modal-form">
						<div class="form-group" id="period_id">
							<input type="text" name="period_id" placeholder="Periodo" class="form-control">
						</div>

						<div class="form-group" id="period_start_date">
                <div class='input-group date' id="datetimepicker1">
                    <input type='text' class="form-control" name="period_start_date" placeholder="Fecha de inicio" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>

            <div class="form-group" id="period_end_date">
                <div class='input-group date' id="datetimepicker2">
                    <input type='text' class="form-control" name="period_end_date" placeholder="Fecha de fín" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
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

@push('js')
<script type="text/javascript">
  $(function () {
      $('#datetimepicker1').datetimepicker({
      	locale: 'es',
      	format: 'YYYY-MM-DD'
      });
      $('#datetimepicker2').datetimepicker({
      	locale: 'es',
      	format: 'YYYY-MM-DD'
      });
  });
</script>
@endpush