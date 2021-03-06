
@push('js')

<script>
var $tableHeaderRow = $('#table-header-row');
var $tableBody = $('#table-content');
var account = {};
var siteRoot = "{{env('SITE_ROOT')}}";

function flatInnerObject(object, innerObject) {
	for(var property in object[innerObject]) {
		if(object[innerObject].hasOwnProperty(property)) {
			object[property] = object[innerObject][property];
		}
	}
	return object;;
}

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
				$('.delete[data-id="' +  button.dataset.id + '"]').parent().parent().remove();
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
	var plurals = {'groups': 'group', 'periods': 'period', 
                        'subjects': 'subject', 'privileges': 'privilege', 
                        'roles': 'role', 'federal-entities': 'federal-entity',
                        'diseases': 'disease', 'addresses': 'address', 
                        'clinics': 'clinic'};
	return plurals[name];
}

// tanslate catalogs properties
function translateProperty(name) {
	console.log(name);
	var translations = {'group_id': 'grupo', 
		'period_id': 'periodo', 'period_start_date': 'fecha de inicio', 'period_end_date': 'fecha de fin',
		'subject_id': 'clave', 'subject_name': 'asignatura', 'semester': 'semestre',
		'privilege_name': 'privilegio',
		'role_name': 'rol', 'role_description': 'descripción',
		'federal_entity_name': 'entidad federativa',
		'federal_entity_id': 'entidad federativa',
		'federal_entity': 'entidad federativa',
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
		case 'groups':
			columns = [entity.group_id];
		break;
		case 'periods':
			columns = [entity.period_id, entity.period_start_date, 
					entity.period_end_date];
		break;
		case 'subjects':
			columns = [entity.subject_id, entity.subject_name, entity.semester + '°'];
		break;
		case 'privileges':
			columns = [entity.privilege_name];
		break;
		case 'roles':
			columns = [entity.role_name, entity.role_description];
		break;
		case 'federal-entities':
			columns = [entity.federal_entity_name];
		break;
		case 'diseases':
			columns = [entity.disease_id, entity.disease_name, entity.type_of_disease];
		break;
		case 'addresses':
			columns = [entity.postal_code, entity.settlement, entity.municipality, entity.federal_entity.federal_entity_name];
		break;
		case 'clinics':
			columns = [entity.clinic_id, entity.clinic_email, entity.clinic_phone, entity.street];
			columns.push([entity.address.settlement, entity.address.municipality, entity.address.postal_code + ' ' + entity.address.federal_entity.federal_entity_name].join(', '));
		break;
	}
	return columns;
}

// generate HTML string for bootstrap button
function htmlButton(entity, catalog, type, content) {
	var btnType = type == 'update' ? 'info' : 'danger';
	return '<button class="btn btn-' + btnType + ' ' + type + 
				 '" data-id="' +  entity[mapCatalogName(catalog).replace(/-/g, '_') + '_id'] + 
				 '" data-entity="' + catalog + '">' + content + '</button>';
}

// create a new catalog row for a table
function createCatalogRow(catalog, entity, privileges) {
	var $row = $('<tr>');
	var html = null;
	var buttons = [];

	// Add update and delete buttons based on the enabled privileges for each catalog
	if(!privileges || privileges.update) buttons.push(htmlButton(entity, catalog, 'update', 'Modificar'));
	if(!privileges || privileges.destroy) buttons.push(htmlButton(entity, catalog, 'delete', 'Eliminar'));

	// If current catalog is role, add a button to manage the privilege for each role
	if(catalog == 'roles') {
		var rolePrivilegesUrl = siteRoot +  '/roles/' + entity.role_id + '/privileges';
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
function addTableColumns($tableBody, catalog, response) {
	response.data.forEach(function(resource) {
		var $tr = createCatalogRow(catalog, resource, response.privileges);
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
			if(catalog == 'clinics') {
				response = flatInnerObject(response, 'address');
			}
			var excluded = ['created_at', 'updated_at'];
			var entity = response;
			var keys = excludeProperties(excluded, entity);;
			keys.forEach(function(key) {
				$('#' + catalog + '-form [name=' + key + ']').val(entity[key]);
			});
			if(catalog == 'clinics' || catalog == 'addresses') {
				addressByPostalCode(options, options.postalCode.val(), response.settlement);
			}
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
	options['url'] = siteRoot + '/' + catalog + (id ? '/' + id : '');
	$.ajax(options);
}


// set form data-action attribute dinamically to specify REST action
function setupFormAction(button, action) {
	var $modal = $('#' + button.id.replace(/-btn/, '') + '-modal');
	$modal.modal('show');
	$modal.find('.modal-form').attr('data-action', action);
}

// send ajax request for index action and insert results into the DOM
function getCatalogs(catalog) {
	// Response have data property corresponding to an array of catalogs
	// and a privileges property corresponding to an array of enabled privileges for
	// the current catalog
	var success = function(response) {
		// clear table header and body
		$tableHeaderRow.html('');
		$tableBody.html('');
		object = response.data[0];
		if(object) {
			var excluded = ['created_at', 'updated_at', 'privilege_id', 'role_id', 'federal_entity_id', 'address_id'];
			var keys = excludeProperties(excluded, object).map(function(str) { 
					translated = translateProperty(str) || str;
					return translated.split('_').map(capitalize).join(' ');
			});

			account.privileges = response.privileges;
			
			$actionColumns = [response.privileges.update, response.privileges.destroy]
				.filter(function(value) { return value; })
				.map(function(value) { return '&nbsp'; });
			addTableHeaders($tableHeaderRow, keys.concat($actionColumns));
			addTableColumns($tableBody, catalog, response);

			if(response.privileges.update) {
				attachUpdateEvent($('.btn.update'));
			}
			if(response.privileges.destroy) {
				attachDeleteEvent($('.btn.delete'), deleteAlert);
			}
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
		var $tr = createCatalogRow(catalog, response, account.privileges);
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
		var $newtr = createCatalogRow(catalog, response);
		var $oldtr = $($('[data-id="' + id + '"]')[0]).parent().parent();
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


var accounts = {!! json_encode(account()->all_privileges()) !!}

// events
// window.location.hash = window.location.hash || '#groups';

if(window.location.hash) {
	var catalog = window.location.hash.substr(1);
	$('#catalogs-select option[value="' + catalog + '"]').attr("selected", "selected");
	setupCatalogsListBinding(catalog);
}

function setupCatalogsListBinding(catalog) {
	getCatalogs(catalog);
	$.ajax({
		url: siteRoot + '/catalogs/' + catalog,
		type: 'GET',
		success: function(response) {
			$('#catalog-container').html(response).fadeIn();
			setupModals();
			if(catalog == 'addresses' || catalog == 'clinics') {	
				$.getScript(siteRoot + '/catalogs/address-js', function() {
				});
			} else if(catalog == 'periods') {
				$.getScript(siteRoot + '/catalogs/datetimepicker-js', function() {
				});
			}
		},
		error: function(response) {
			console.log(response.responseText);
			$('#catalog-container').html('');
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
	 	if($form[0].id == 'clinics-form' || $form[0].id == 'addresses-form') {
	 		$form.find('select').empty();
	 	}
	});
}

</script>

@endpush