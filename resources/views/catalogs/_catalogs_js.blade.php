
@push('js')

<script>
$tableHeaderRow = $('#table-header-row');
$tableBody = $('#table-content');

// show delete sweetalert, trigger delete catalog action
function deleteAlert(button) {
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
}

// handle form errors from response
function handleFormErrors($formGroups, error) {
	console.log(error.responseText);
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
	});
}

// pluralize catalogs name
function mapCatalogName(name) {
	var plurals = {'group': 'groups', 'period': 'periods', 
	 'subject': 'subjects', 'privilege': 'privileges', 
	 'role': 'roles', 'federal-entity': 'federal-entities',
	 'disease': 'diseases', 'address': 'addresses', 
	 'clinic': 'clinics'};
	 return plurals[name];
}

// tanslate catalogs properties
function translateProperty(name) {
	var translations = {'group_id': 'grupo', 
		'period_id': 'periodo', 'period_start_date': 'fecha de inicio', 'period_end_date': 'fecha de fin',
		'subject_name': 'asignatura', 'semester': 'semestre',
		'privilege_name': 'privilegio',
		'role_name': 'rol', 'role_description': 'descripción',
		'federal_entity_name': 'entidad_federativa',
		'disease_id': 'código', 'disease_name': 'enfermedad', 'type_of_disease': 'tipo',
		'postal_code': 'código postal', 'settlement': 'colonia', 'municipality': 'municipio',
		'clinic_id': 'clínica', 'clinic_email': 'correo electrónico', 'clinic_phone': 'teléfono', 'address': 'dirección',
		'street': 'calle'
	};
	return translations[name];
}

// capitalize string
function capitalize(word) {
	return word.charAt(0).toUpperCase() + word.substring(1);
}

// exclude properties from object
function excludeProperties(excluded, object) {
	return Object.keys(object)
			.filter(function(element) { 
				return excluded.indexOf(element) == - 1
			});
}

// create jquery column
function createColumn(data, type) {
	return $('<' + type + '>' + data + '</' + type + '>');
}

// generate HTML string from jquery objects
function generateHTMLString(array) {
	return array.map(function(element) {
		return element.prop('outerHTML');
	}).join('');
}

// get columns from catalog's properties
function getColumns(catalog, entity) {
	var columns = null;
	switch(catalog) {
		case 'group':
			columns = [entity.group_id];
		break;
		case 'period':
			columns = [entity.period_id, entity.period_start_date, 
					entity.period_end_date];
		break;
		case 'subject':
			columns = [entity.subject_id, entity.subject_name, entity.semester + '°'];
		break;
		case 'privilege':
			columns = [entity.privilege_id, entity.privilege_name];
		break;
		case 'role':
			columns = [entity.role_id, entity.role_name, entity.role_description];
		break;
		case 'federal-entity':
			columns = [entity.federal_entity_id, entity.federal_entity_name];
		break;
		case 'disease':
			columns = [entity.disease_id, entity.disease_name, entity.type_of_disease];
		break;
		case 'address':
			columns = [entity.address_id, entity.postal_code, entity.settlement, entity.municipality, entity.federal_entity_id];
		break;
		case 'clinic':
			columns = [entity.clinic_id, entity.address_id, entity.clinic_email, entity.clinic_phone, entity.street];
			columns.push([entity.address.settlement, entity.address.municipality, entity.address.federal_entity_id, entity.address.postal_code].join(' '));
		break;
	}
	return columns;
}

// generate HTML string for bootstrap button
function htmlButton(entity, catalog, type, content) {
	var btnType = type == 'update' ? 'info' : 'danger';
	return '<button class="btn btn-' + btnType + ' ' + type + 
				 '" data-id="' +  entity[catalog.replace(/-/g, '_') + '_id'] + 
				 '" data-entity="' + catalog + '">' + content + '</button>';
}

// create a new catalog row for a table
function createCatalogRow(catalog, entity) {
	var $row = $('<tr>');
	var html = null;
	var buttons = [htmlButton(entity, catalog, 'update', 'Modificar'), htmlButton(entity, catalog, 'delete', 'Eliminar')];
	if(catalog == 'role') {
		var rolePrivilegesUrl = '/roles/' + entity.role_id + '/privileges';
		buttons.splice(1, 0, '<a class="btn btn-primary" href="' + rolePrivilegesUrl + '">Privilegios</a>');
	}
	var $columns = getColumns(catalog, entity).concat(buttons)
		.map(function(element) {
			return createColumn(element, 'td');
	});
	$row.append(generateHTMLString($columns));
	return $row;
}

// add table headers from array of string
function addTableHeaders($tableHeaderRow, columns) {
	columns.forEach(function(columnTitle) {
		$tableHeaderRow.append((createColumn(columnTitle, 'th')));
	});
	return $tableHeaderRow;
}

// add table columns from array of objects
function addTableColumns($tableBody, catalog, resources) {
	resources.forEach(function(resource) {
		var $tr = createCatalogRow(catalog, resource);
		$tableBody.append($tr);
	});
	return $tableBody;
}

// get all inputs (select, textarea) from a form 
function getInputs(form) {
	var selector = '#' + form.id + ' ';
	return $.merge($(selector + 'input'), $(selector + 'select'), $(selector + 'textarea'));
}

// get serialized input values from a form
function getInputValues(form) {
	return getInputs(form).serialize();
}

// remove bootstrap error messages
function removeErrors(form) {
	var selector = '#' + form.id + ' .form-group';
	var $formGroups = $(selector);
	$formGroups.removeClass('has-error');
	$(selector + ' span.help-block').remove();
	return $formGroups;
}

// attach update event to buttons
function attachUpdateEvent(elements, callback) {
	elements.click(function() {
		var button = this;
		var id = button.dataset.id;
		var catalog = button.dataset.entity;
		var $modal = $('#' + catalog + '-modal')
		$modal.modal('show');
		// setupFormAction(button, 'update');
		var $form = $modal.find('.modal-form');
		$form.attr('data-action', 'update');
		$form.attr('data-id', id);
		showCatalog(catalog, id, function(response) {
			var excluded = ['created_at', 'updated_at'];
			var entity = response;
			var keys = excludeProperties(excluded, entity);;
			keys.forEach(function(key) {
				$('#' + catalog + '-form [name=' + key + ']').val(entity[key]);
			});
		});
	});
}

// attach delete event to buttons
function attachDeleteEvent(elements, callback) {
	elements.click(function() {
		var button = this;
		callback(button);
	});
}

// send AJAX request
function sendAJAX(options, catalog, id) {
	options['url'] = '/' + mapCatalogName(catalog) + (id ? '/' + id : '');
	$.ajax(options);
}


// set form data-action attribute dinamically to specify REST action
function setupFormAction(button, action) {
	var $modal = $('#' + button.id.replace(/-btn/, '') + '-modal');
	$modal.modal('show');
	$modal.find('.modal-form').attr('data-action', action);
}

// send ajax request for index actionand insert results into the DOM
function getCatalogs(catalog) {
	var success = function(response) {
		// clear table header and body
		$tableHeaderRow.html('');
		$tableBody.html('');
		object = response[0];
		if(object) {
			var excluded = ['created_at', 'updated_at'];
			var keys = excludeProperties(excluded, object).map(function(str) { 
					translated = translateProperty(str) || str;
					return translated.split('_').map(capitalize).join(' ');
			});

			addTableHeaders($tableHeaderRow, keys.concat(['&nbsp;', '&nbsp;']));
			addTableColumns($tableBody, catalog, response);

			attachUpdateEvent($('.btn.update'));
			attachDeleteEvent($('.btn.delete'), deleteAlert);
		}
	}

	var error = function(error) {
		console.log(error.responseText);
	}

	var options = { method: 'GET', dataType: 'JSON', success: success, error: error };
	sendAJAX(options, catalog);
}

// send ajax request for create action and insert resource into the DOM
function createCatalog(form, catalog) {
	var data = getInputValues(form);
	var $formGroups = removeErrors(form);

	var success = function(response) {
		var $tr = createCatalogRow(catalog, response);
		$tableBody.append($tr);
		$('#' + catalog + '-modal').modal('hide');
		swal("¡Se ha agregado un nuevo registro!", null, "success");
		attachUpdateEvent($tr.find('.btn.update'));
		attachDeleteEvent($tr.find('.btn.delete'), deleteAlert);
	}

	var error = function(error) {
		handleFormErrors($formGroups, error);
	}

	var options = { method: 'POST', data: data, success: success, error: error };
	sendAJAX(options, catalog);
}

// send ajax request for show action
function showCatalog(catalog, id, success) {
	var options = { method: 'GET', success: success, 
		error: function(error) {
			console.log(error.responseText);
		}
	};
	sendAJAX(options, catalog, id);
}

// send ajax request for update action and update resource on the DOM
function updateCatalog(form, catalog, id) {
	var data = getInputValues(form);
	var $formGroups = removeErrors(form);

	var success = function(response) {
		console.log(response);
		var $newtr = createCatalogRow(catalog, response);
		var $oldtr = $($('[data-id=' + id + ']')[0]).parent().parent();
		$oldtr.replaceWith('<tr data-state="new">' + generateHTMLString([$newtr]) + '</tr>');
		$('#' + catalog + '-modal').modal('hide');
		swal("¡Se ha modificado el registro!", null, "success");
		$oldtr = $($('[data-state=new]')[0]).parent().parent();
		attachUpdateEvent($oldtr.find('.btn.update'));
		attachDeleteEvent($oldtr.find('.btn.delete'), deleteAlert);
		$oldtr.removeAttr('data-state');
	}

	var options = {method: 'PATCH', data: data, success: success, 
		error: function(error) {
			if(error.status === 500) {
				swal("Error!", "No se pudo modificar el registro.", "error")
			} else if(error.status === 422) {
				handleFormErrors($formGroups, error);
			}
		}
	};
	sendAJAX(options, catalog, id);
}

// send ajax request for delete action and delete resource from the DOM
function deleteCatalog(button, success) {
	var id = button.dataset.id;
	var catalog = button.dataset.entity;

	var options = { method: 'DELETE', success, success, 
		error: function(error) {
			console.log(error.responseText);
			swal("Error!", "No se pudo eliminar el registro.", "error")
		}
	}
	sendAJAX(options, catalog, id);
}

// events

if(window.location.hash) {
	var catalog = window.location.hash.substr(1);
	$('#catalogs-select option[value="' + catalog + '"]').attr("selected", "selected");
	setupCatalogsListBinding(catalog);
}

function setupCatalogsListBinding(catalog) {
	getCatalogs(catalog);
	$.ajax({
		url: '/catalogs/' +  catalog,
		type: 'GET',
		success: function(response) {
			$('#catalog-container').html(response).fadeIn();
			setupModals();
			$.getScript('/catalogs/address-js', function() {
				console.log('address_js loaded');
			});
		},
		error: function(response) {
			console.log(response);
		}
	});
} 
// get catalogs
$("#catalogs-select").on('change', function() { 
	var selected = this.value;
	window.location.hash = selected;
	setupCatalogsListBinding(selected);
});

function setupModals() {
	// add new catalog
	$('.modal-form').submit(function(e) {
		e.preventDefault();
		var data = [this, this.id.replace(/-form/, '')];
		if(this.dataset.action == 'update') { 
			data.push(this.dataset.id);
			updateCatalog.apply(null, data);
		} else {
			createCatalog.apply(null, data);
		}
	});

	$('.btn.catalog').click(function() {
			setupFormAction(this, 'create');
	});

	// reset modal form on close
	$('.modal').on('hidden.bs.modal', function (e) {
	  var $form = $(this).find('.modal-form');
	  $form.removeAttr('data-action');
	  $form[0].reset();
	  removeErrors($form[0]);
	 	if($form[0].id == 'clinic-form') {
	 		$form.find('select').empty();
	 	}
	});
}



</script>

@endpush