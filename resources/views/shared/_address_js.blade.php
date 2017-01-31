@push('js')
<script>

jQuery(function ($) {        
  $('form').bind('submit', function () {
    $(this).find(':input').prop('disabled', false);
  });
});

var options = {
	postalCode: $('#postal-code'),
	state: $('#state'),
	municipality: $('#municipality'),
	settlement: $('#settlement')
}

if(options.postalCode.val().length == 5) {
	addressByPostalCode(options, options.postalCode.val());
}

bindAddressSearch(options);

function bindAddressSearch(options) {
	options.postalCode.on('change', function() {
		if(this.value.length == 5) {
			addressByPostalCode(options, this.value);
		}
	});
}

function fillSelect(input, options, selected) {
	var listItems = '';
	input.empty();
	$.each(options.list, function(key, obj) {
		listItems += '<option value="' + obj[options.value] + '" '+ (obj[options.value] == selected ? 'selected' : '') + '>' + obj[options.content] + '</option>';
	});
	input.append(listItems);
}


function addressByPostalCode(options, postalCode) {
	$.ajax({
		dataType: 'json',
		method: 'get',
		url: '/addresses/postal-code/' + postalCode,
		data: {code: postalCode},
		success: function(response) {
			console.log(response);
			fillSelect(options.state, {list: response.states, value: 'federal_entity_id', content: 'federal_entity_name'}, response.state);
			fillSelect(options.municipality, {list: response.municipalities, value: 'municipality', content: 'municipality'}, response.municipality);
			fillSelect(options.settlement, {list: response.settlements, value: 'settlement', content: 'settlement'});
		},
		error: function(response) {
			console.log(response.responseText);
		}
	});
}

</script>
@endpush