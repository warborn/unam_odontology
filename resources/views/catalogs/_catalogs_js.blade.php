@push('js')

<script>
$tableHeaderRow = $('#table-header-row');
$tableBody = $('#table-content');

function mapCatalogName(name) {
	var plurals = {'group': 'groups', 'period': 'periods', 
	 'subject': 'subjects', 'privilege': 'privileges', 
	 'role': 'roles', 'federal-entity': 'federal-entities',
	 'disease': 'diseases', 'address': 'addresses', 
	 'clinic': 'clinics'};
	 return plurals[name];
}

function upperCaseWord(word) {
	return word.charAt(0).toUpperCase() + word.substring(1);
}

function excludeKeys(excluded, object) {
	return Object.keys(object)
			.filter(function(element) { 
				return excluded.indexOf(element) == - 1
			});
}

function createColumn(data, type) {
	return $('<' + type + '>' + data + '</' + type + '>');
}

function generateHTMLString() {
	var elements = Array.prototype.slice.call(arguments);
	return elements.map(function(element) {
		return element.prop('outerHTML');
	}).join('');
}

function createCatalogRow(catalog, entity) {
	var $tr = $('<tr>');
	var html = null;
	switch(catalog) {
		case 'group':
			$tds = [entity.group_id];
		break;
		case 'period':
			$tds = [entity.period_id, entity.period_start_date, 
					entity.period_end_date];
		break;
		case 'subject':
			$tds = [entity.subject_id, entity.subject_name, entity.semester];
		break;
		case 'privilege':
			$tds = [entity.privilege_id, entity.privilege_name];
		break;
		case 'role':
			$tds = [entity.role_id, entity.role_name, entity.role_description];
		break;
		case 'federal_entity':
			$tds = [entity.federal_entity_id];
		break;
		case 'disease':
			$tds = [entity.disease_id, entity.disease_name, entity.type_of_disease];
		break;
		case 'address':
			$tds = [entity.address_id, entity.postal_code, entity.settlement, entity.municipality, entity.federal_entity_id];
		break;
		case 'clinic':
			$tds = [entity.clinic_id, entity.address_id, entity.clinic_email, entity.clinic_phone, entity.street, entity.address.settlement, entity.address.municipality, entity.address.federal_entity_id, entity.address.postal_code];
		break;
	}
	$tds = $tds.map(function(element) {
		return createColumn(element, 'td');
	});
	$tds.push(createColumn('<button class="btn btn-info update" data-id="' + entity[catalog + '_id'] + '" data-entity="' + catalog + '">Modificar</button>', 'td'));
	$tds.push(createColumn('<button class="btn btn-danger delete" data-id="' + entity[catalog + '_id'] + '" data-entity="' + catalog + '">Eliminar</button>', 'td'));
	$tr.append(generateHTMLString.apply(null, $tds));
	return $tr;
}

function getInputs(form) {
	var selector = '#' + form.id + ' ';
	return $.merge($(selector + 'input'), $(selector + 'select'), $(selector + 'textarea'));
}

function getInputValues(form) {
	return getInputs(form).serialize();
}

function attachDeleteEvent(selector) {
	$(selector).click(function() {
		var button = this;
		swal({
		  title: "¿Estas seguro de que deseas eliminar el registro?",
		  text: "No podras deshacer esta accion",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonColor: "#DD6B55",
		  confirmButtonText: "Entendido",
		  closeOnConfirm: false
		},
		function(){
			deleteCatalog(button, function(response) {
				$('.delete[data-id=' +  button.dataset.id + ']').parent().parent().remove();
		  		swal("Eliminado!", "El registro se ha eliminado exitosamente.", "success");
			});
		});
	});
}

function attachUpdateEvent(selector, catalog) {
	$(selector).click(function() {
		var button = this;
		var id = button.dataset.id;
		$('#' + catalog + '-modal').modal('show');
		showCatalog(catalog, id, function(response) {
			var excluded = ['created_at', 'updated_at'];
			var entity = response;
			console.log(response)
			var keys = excludeKeys(excluded, entity);
			keys.forEach(function(key) {
				$('#' + catalog + '-form [name=' + key + ']').val(entity[key]);
			});
		});
	});
}

// send ajax request and insert results into the DOM
function getCatalog(catalog) {
	$.ajax({
	url: '/' + mapCatalogName(catalog),
	dataType: 'json',
	method: 'GET',
	success: function(response) {
		$tableHeaderRow.html('');
		$tableBody.html('');
		object = response[0];
		
		var excluded = ['created_at', 'updated_at'];
		var keys = excludeKeys(excluded, object).map(function(str) { 
				return str.split('_').map(upperCaseWord).join(' ')
		});

		keys.forEach(function(columnTitle) {
			$tableHeaderRow.append(createColumn(columnTitle, 'th'));
		});
		$tableHeaderRow.append(createColumn('&nbsp;', 'th'));
		$tableHeaderRow.append(createColumn('&nbsp;', 'th'));
		
		response.forEach(function(entity) {
			var $tr = createCatalogRow(catalog, entity);
			$tableBody.append($tr);
		});
		attachDeleteEvent('.btn.delete');
		attachUpdateEvent('.btn.update', catalog);
	},
	error: function(error) {
		console.log(error);
	}
	});
}

function createCatalog(form, catalog, success, error) {
	var data = getInputValues(form);
	var selector = '#' + catalog + '-form .form-group';
	var $formGroups = $(selector);
	$formGroups.removeClass('has-error');
	$(selector + ' span.help-block').remove();

	$.ajax({
		url: '/' + mapCatalogName(catalog),
		method: 'POST',
		data: data,
		success: function(response) {
			console.log('success');
			console.log(response);
			var $tr = createCatalogRow(catalog, response);
			$tableBody.append($tr);
			form.reset();
			$('#' + catalog + '-modal').modal('hide');
			swal("¡Se ha agregado un nuevo registro!", null, "success");
		},
		error: function(error) {
			console.log('error');
			var errors = error.responseJSON;
			$formGroups.each(function() { 
				var $group = $(this);
				var currentAttributeError = errors[this.id];
				if(currentAttributeError) {
					$group.addClass('has-error');
					errors[this.id].forEach(function(text) {
						$group.append('<span class="help-block">' + text + '</span>');
					});
				}
				
			})
		}
	});
	console.log('sended');
}

function showCatalog(catalog, id, success) {
	$.ajax({
		url: '/' + mapCatalogName(catalog) + '/' + id,
		method: 'GET',
		success: success,
		error: function(error) {
			console.log('error');
			console.log(error);
		}
	});
	console.log('sended');
}

function deleteCatalog(button, success) {
	console.log(button);
	var id = button.dataset.id;
	var catalog = button.dataset.entity;
	$.ajax({
		url: '/' + mapCatalogName(catalog) + '/' + id,
		method: 'DELETE',
		success: success,
		error: function(error) {
			console.log('error');
			console.log(error.responseText);
		}
	});
	console.log('sended');
}

// get catalogs
$("#catalogs-select").on('change', function() { 
	var selected = this.value;
	getCatalog(selected);
	$('.btn.catalog').hide();
	$('#' + selected + '-btn').show();
});

// add new catalog
$('#disease-form').submit(function(e) {
	e.preventDefault();
	createCatalog(this, this.id.replace(/-form/, ''));
});

</script>

@endpush