<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    // 'accepted'             => 'The :attribute must be accepted.',
    // 'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => ':attribute debe ser una fecha posterior a :date.',
    'alpha'                => ':attribute puede contener solo letras.',
    // 'alpha_dash'           => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num'            => ':attribute puede contener solo números y letras.',
    // 'array'                => 'The :attribute must be an array.',
    'before'               => ':attribute debe ser una fecha anterior a :date.',
    // 'between'              => [
    //     'numeric' => 'The :attribute must be between :min and :max.',
    //     'file'    => 'The :attribute must be between :min and :max kilobytes.',
    //     'string'  => 'The :attribute must be between :min and :max characters.',
    //     'array'   => 'The :attribute must have between :min and :max items.',
    // ],
    // 'boolean'              => 'The :attribute field must be true or false.',
    // 'confirmed'            => ':attribute confirmation does not match.',
    'date'                 => ':attribute no es una fecha valida.',
    // 'date_format'          => 'The :attribute does not match the format :format.',
    // 'different'            => 'The :attribute and :other must be different.',
    'digits'               => ':attribute debe contener :digits digitos.',
    // 'digits_between'       => 'The :attribute must be between :min and :max digits.',
    // 'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => ':attribute debe ser un correo electronico valido.',
    // 'exists'               => 'The selected :attribute is invalid.',
    // 'filled'               => 'The :attribute field is required.',
    // 'image'                => 'The :attribute must be an image.',
    // 'in'                   => 'The selected :attribute is invalid.',
    // 'in_array'             => 'The :attribute field does not exist in :other.',
    // 'integer'              => 'The :attribute must be an integer.',
    // 'ip'                   => 'The :attribute must be a valid IP address.',
    // 'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => ':attribute no debe ser mayor a :max.',
        // 'file'    => 'The :attribute may not be greater than :max kilobytes.',
        'string'  => ':attribute no debe tener más de :max caracteres.',
        // 'array'   => ':attribute may not have more than :max items.',
    ],
    // 'mimes'                => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => ':attribute debe ser al menos :min.',
        // 'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => ':attribute debe tener al menos :min caracteres.',
        // 'array'   => ':attribute must have at least :min items.',
    ],
    // 'not_in'               => 'The selected :attribute is invalid.',
    // 'numeric'              => 'The :attribute must be a number.',
    'present'              => ':attribute debe estar presente.',
    // 'regex'                => ':attribute format is invalid.',
    'required'             => ':attribute es obligatorio/a.',
    // 'required_if'          => 'The :attribute field is required when :other is :value.',
    // 'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    // 'required_with'        => 'The :attribute field is required when :values is present.',
    // 'required_with_all'    => 'The :attribute field is required when :values is present.',
    // 'required_without'     => 'The :attribute field is required when :values is not present.',
    // 'required_without_all' => 'The :attribute field is required when none of :values are present.',
    // 'same'                 => 'The :attribute and :other must match.',
    // 'size'                 => [
    //     'numeric' => 'The :attribute must be :size.',
    //     'file'    => 'The :attribute must be :size kilobytes.',
    //     'string'  => 'The :attribute must be :size characters.',
    //     'array'   => 'The :attribute must contain :size items.',
    // ],
    // 'string'               => 'The :attribute must be a string.',
    // 'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => ':attribute ya existe.',
    // 'url'                  => 'The :attribute format is invalid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    // 'custom' => [
    //     'attribute-name' => [
    //         'rule-name' => 'custom-message',
    //     ],
    // ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
    	// Groups
    	'group_id' => 'El nombre del grupo',
    	// Periods
    	'period_id' => 'El periodo',
    	'period_start_date' => 'La fecha de inicio del periodo',
    	'period_end_date' => 'La fecha de termino del periodo',
    	// Subjects
    	'subject_name' => 'El nombre de la asignatura',
    	'semester' => 'El semestre',
    	// Users
    	'user_id' => 'El nombre de usuario',
    	'password' => 'La contraseña',
    	// Teachers
    	'rfc' => 'El RFC',
    	// Students
    	'account_number' => 'El número de cuenta',
    	// Patients
    	'age' => 'La edad',
    	'federal_entity_id' => 'La entidad federativa',
    	'ocupation' => 'La ocupación',
    	'school_grade' => 'El grado escolar',
    	'civil_status' => 'El estado civil',
    	'phone' => 'El teléfono',
    	'medical_service' => 'El servicio médico',
    	'service_name' => 'El nombre nombre del servicio',
    	// Interns
    	'service_start_date' => 'La fecha de inicio del servicio',
    	'service_end_date' => 'La fecha de termino del servicio',
    	// 'account_number' => 'El número de cuenta',
    	// Privileges
    	'privilege_name' =>  'El nombre del privilegio',
    	// Roles
    	'role_name' => 'El nombre del rol',
    	'role_description' => 'La descripción del rol',
    	// Clinics
    	'clinic_id' => 'La clínica',
    	'clinic_email' => 'El correo electronico',
    	'clinic_phone' => 'El teléfono',
    	'street' => 'La calle',
    	// Federal Entities
    	'federal_entity_id' => 'La entidad federativa',
    	// Addresses
    	'postal_code' => 'El codigo postal',
    	'settlement' => 'La colonia',
    	'minicipality' => 'El municipio',
    	'federal_entity_id' => 'La entidad federativa',
    	// Formats
    	'user_intern_id' => 'El pasante',
    	// 'clinic_id' => 'La clínica',
    	'user_patient_id' => 'El paciente',
    	'medical_history_number' => 'El número de historia clínica',
    	'consultation_reason' => 'La rázon de consulta',
    	'medical_treatment' => 'El tratamiento médico',
    	'therapeutic_used' => 'La terapeutica usada',
    	'observations' => 'Las observaciones',
    	'referrenced_by' => 'Referido por',
    	'dental_disease' => 'Enfermedad odontológica',
    	'format_status' => 'El estado del formato',
    	// Personal Informations
    	'user_name' => 'El nombre',
    	'last_name' => 'El apellido paterno',
    	'mother_last_name' => 'El apellido materno',
    	'email' => 'El correo electronico',
    	'phone' => 'El teléfono',
    	'gender' => 'El sexo',
    	// 'street' => 'La calle',
    	// Diseases
    	'disease_name' => 'El nombre de la enfermedad',
    	'type_of_disease' => 'El tipo de la enfermedad',
    ],

];
