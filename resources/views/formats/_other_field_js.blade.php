@push('js')
<script type="text/javascript">
	 // change disease inputs
  var $generalDisease = $('#general_disease');
  var $otherDisease = $('#other_disease');
	$('#has_disease').on('change', function() { 
		if(this.value == 0) {
			$generalDisease.attr('disabled', true)[0].selectedIndex = 0;
			$otherDisease.attr('disabled', true).val('');
		} else {
			$generalDisease.removeAttr('disabled');
			$otherDisease.removeAttr('disabled');
		}
	});

	$generalDisease.on('change', function() {
		if(this.value) {
			$otherDisease.attr('disabled', true);
		} else {
			$otherDisease.removeAttr('disabled');
		}
	});

	// change medical service inputs 

	var $medicalService = $('#medical_service');
  var $otherMedicalService = $('#other_medical_service');
	$('#has_medical_service').on('change', function() { 
		console.log('changed');
		if(this.value == 0) {
			$medicalService.attr('disabled', true)[0].selectedIndex = 0;
			$otherMedicalService.attr('disabled', true).val('');
		} else {
			$medicalService.removeAttr('disabled');
			$otherMedicalService.removeAttr('disabled');
		}
	});

	$medicalService.on('change', function() {
		if(this.value) {
			$otherMedicalService.attr('disabled', true);
		} else {
			$otherMedicalService.removeAttr('disabled');
		}
	});

	$('#medical_treatment').on('change', function(){
		if(this.value == 0) {
			$('#therapeutic_used').attr('disabled', true).val('');
		} else {
			$('#therapeutic_used').removeAttr('disabled');
		}
	});
</script>
@endpush