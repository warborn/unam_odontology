@extends('layouts.app')

@section('content')
<h1>This is the catalogs view</h1>

<select id="catalogs-select">
	<option disabled selected></option>
	<option value="group">Grupos</option>
	<option value="period">Periodos</option>
	<option value="subject">Asignaturas</option>
	<option value="privilege">Privilegios</option>
	<option value="role">Roles</option>
	<option value="federal-entitie">Entidades federativas</option>
	<option value="disease">Enfermedades</option>
	<option value="addresse">Direcciones</option>
	<option value="clinic">Clinicas</option>
</select>

<table border="1">
	<thead>
		<tr id="table-header-row">
		</tr>
	</thead>
	<tbody id="table-content">
	</tbody>
</table>


<script>
$(document).ready(function() {
	function upperCaseWord(word) {
		return word.charAt(0).toUpperCase() + word.substring(1);
	}

	function excludeKeys(excluded, object) {
		return Object.keys(object)
				.filter(function(element) { 
					return excluded.indexOf(element) == - 1
				});
	}

	function createTD(data, type) {
		type = type == undefined ? 'td' : 'td';
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
				$tds = [createTD(entity.group_id)];
			break;
			case 'period':
				$tds = [entity.period_id, entity.period_start_date, 
						entity.period_end_date].map(createTD);
			break;
			case 'subject':
				$tds = [entity.subject_id, entity.subject_name, entity.semester].map(createTD);
			break;
			case 'privilege':
				$tds = [entity.privilege_id, entity.privilege_name].map(createTD);
			break;
			case 'role':
				$tds = [entity.role_id, entity.role_name, entity.role_description].map(createTD);
			break;
			case 'federal-entitie':
				$tds = [entity.federal_entity_id].map(createTD);
			break;
			case 'disease':
				$tds = [entity.disease_id, entity.disease_name, entity.type_of_disease].map(createTD);
			break;
			case 'addresse':
				$tds = [entity.address_id, entity.postal_code, entity.settlement, entity.municipality, entity.federal_entity_id	].map(createTD);
			break;
			case 'clinic':
				$tds = [entity.clinic_id, entity.address_id, entity.clinic_email, entity.clinic_phone, entity.street, entity.address.settlement, entity.address.municipality, entity.address.federal_entity_id, entity.address.postal_code, ].map(createTD);
			break;
		}
		$tr.append(generateHTMLString.apply(null, $tds));
		return $tr;
	}

	function getCatalog(catalog) {
		$.ajax({
		url: '/' + catalog + 's',
		dataType: 'json',
		method: 'GET',
		success: function(response) {
			$tableHeaderRow = $('#table-header-row');
			$tableHeaderRow.html('');
			$tableBody = $('#table-content');
			$tableBody.html('');
			object = response[0];
			
			var excluded = ['created_at', 'updated_at'];
			var keys = excludeKeys(excluded, object).map(function(str) { 
					return str.split('_').map(upperCaseWord).join(' ')
			});

			keys.forEach(function(columnTitle) {
				$tableHeaderRow.append(createTD(columnTitle, 'th'));
			});
			
			response.forEach(function(entity) {
				var $tr = createCatalogRow(catalog, entity);
				$tableBody.append($tr);
			});
		},
		error: function(error) {
			console.log(error);
		}
		});
	}

	$("#catalogs-select").on('change', function() { 
		getCatalog(this.value);
	});
});
</script>

@endsection