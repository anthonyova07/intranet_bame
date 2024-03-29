' =<?php

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
    'accepted' => 'El campo :attribute debe ser aceptado.',
    'active_url' => 'El campo :attribute no es una URL válida.',
    'after' => 'El campo :attribute debe ser una fecha posterior a :date.',
    'alpha' => 'El campo :attribute sólo puede contener letras.',
    'alpha_dash' => 'El campo :attribute sólo puede contener letras, números y guiones (a-z, 0-9, -_).',
    'alpha_num' => 'El campo :attribute sólo puede contener letras y números.',
    'array' => 'El campo :attribute debe ser un array.',
    'before' => 'El campo :attribute debe ser una fecha anterior a :date.',
    'between' => [
        'numeric' => 'El campo :attribute debe ser un valor entre :min y :max.',
        'file' => 'El archivo :attribute debe pesar entre :min y :max kilobytes.',
        'string' => 'El campo :attribute debe contener entre :min y :max caracteres.',
        'array' => 'El campo :attribute debe contener entre :min y :max elementos.',
    ],
    'boolean' => 'El campo :attribute debe ser verdadero o falso.',
    'confirmed' => 'El campo confirmación de :attribute no coincide.',
    'date' => 'El campo :attribute no corresponde con una fecha válida.',
    'date_format' => 'El campo :attribute no corresponde con el formato de fecha :format.',
    'different' => 'Los campos :attribute y :other han de ser diferentes.',
    'digits' => 'El campo :attribute debe ser un número de :digits dígitos.',
    'digits_between' => 'El campo :attribute debe contener entre :min y :max dígitos.',
    'email' => 'El campo :attribute no corresponde con una dirección de e-mail válida.',
    'filled' => 'El campo :attribute es obligatorio.',
    'exists' => 'El campo :attribute no existe.',
    'image' => 'El campo :attribute debe ser una imagen.',
    'in' => 'El campo :attribute debe ser igual a alguno de estos valores :values',
    'integer' => 'El campo :attribute debe ser un número entero.',
    'ip' => 'El campo :attribute debe ser una dirección IP válida.',
    'json' => 'El campo :attribute debe ser una cadena de texto JSON válida.',
    'max' => [
        'numeric' => 'El campo :attribute debe ser :max como máximo.',
        'file' => 'El archivo :attribute debe pesar :max kilobytes como máximo.',
        'string' => 'El campo :attribute debe contener :max caracteres como máximo.',
        'array' => 'El campo :attribute debe contener :max elementos como máximo.',
    ],
    'mimes' => 'El campo :attribute debe ser un archivo de tipo :values.',
    'min' => [
        'numeric' => 'El campo :attribute debe tener al menos :min.',
        'file' => 'El archivo :attribute debe pesar al menos :min kilobytes.',
        'string' => 'El campo :attribute debe contener al menos :min caracteres.',
        'array' => 'El campo :attribute no debe contener más de :min elementos.',
    ],
    'not_in' => 'El campo :attribute seleccionado es invalido.',
    'numeric' => 'El campo :attribute debe ser un numero.',
    'regex' => 'El formato del campo :attribute es inválido.',
    'required' => 'El campo :attribute es obligatorio',
    'required_if' => 'El campo :attribute es obligatorio cuando el campo :other es :value.',
    'required_with' => 'El campo :attribute es obligatorio cuando :values está presente.',
    'required_with_all' => 'El campo :attribute es obligatorio cuando :values está presente.',
    'required_without' => 'El campo :attribute es obligatorio cuando :values no está presente.',
    'required_without_all' => 'El campo :attribute es obligatorio cuando ningún campo :values están presentes.',
    'same' => 'Los campos :attribute y :other deben coincidir.',
    'size' => [
        'numeric' => 'El campo :attribute debe ser :size.',
        'file' => 'El archivo :attribute debe pesar :size kilobytes.',
        'string' => 'El campo :attribute debe contener :size caracteres.',
        'array' => 'El campo :attribute debe contener :size elementos.',
    ],
    'string' => 'El campo :attribute debe contener solo caracteres.',
    'timezone' => 'El campo :attribute debe contener una zona válida.',
    'unique' => 'El elemento :attribute ya está en uso.',
    'url' => 'El formato de :attribute no corresponde con el de una URL válida.',
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
    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],
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
      'user' => 'Usuario',
      'password' => 'Contraseña',
      'menu' => 'Menú',
      'submenu' => 'SubMenú',
      'description' => 'Descripción',
      'caption' => 'Título',
      'link' => 'Link',
      'coduni' => 'Código Único',
      'identification' => 'Identificación',
      'credit_card' => 'TDC',
      'customer_number' => '# Cliente',
      'product' => '# Producto',
      'month_process' => 'Mes del Proceso',
      'year_process' => 'Año del Proceso',
      'ncf' => '# NCF',
      'day_from' => 'Día (Desde)',
      'day_to' => 'Día (Hasta)',
      'year' => 'Año',
      'amount' => 'Monto',
      'month' => 'Mes',
      'day' => 'Día',
      'to_name' => 'A nombre de',
      'title' => 'Título',
      'detail' => 'Detalle',
      'image' => 'Imagen',
      'type' => 'Tipo',
      'descriptions' => 'Descripciones',
      'awards' => 'Premios',
      'start_event' => 'Fecha Inicio(Evento)',
      'end_event' => 'Fecha Final(Evento)',
      'end_subscriptions' => 'Fin de Suscripciones',
      'number_persons' => 'Numero de Personas',
      'number_companions' => 'Total de Acompañantes P/P',
      'limit_persons' => 'Limita Personas',
      'limit_companions' => 'Limita Acompañantes',
      'last_names' => 'Apellidos',
      'names' => 'Nombres',
      'name' => 'Nombre',
      'identification_type' => 'Tipo de Identificación',
      'unsubscription_reason' => 'Motivo',
      'curriculum' => 'Curriculum Vitae',
      'name_last_name' => 'Nombre y Apellido',
      'mail' => 'Correo',
      'idea' => 'Idea',
      'images' => 'Imágenes',
      'channel' => 'Canal de Distribución',
      'product_type' => 'Tipo de Producto',
      'product' => 'Producto',
      'amount' => 'Monto',
      'claim_type' => 'Tipo de Reclamación',
      'response_term' => 'Plazo de Respuesta',
      'response_date' => 'Fecha de Respuesta',
      'es_name' => 'Nombre ES',
      'es_detail' => 'Detalle ES',
      'es_detail_2' => 'Detalle 2 ES',
      'en_name' => 'Nombre EN',
      'en_detail' => 'Detalle EN',
      'en_detail_2' => 'Detalle 2 EN',
      'capital' => 'Capital',
      'capital_discount_percent' => '% Descuento',
      'interest' => 'Interés',
      'interest_discount_percent' => '% Descuento',
      'arrears' => 'Mora',
      'arrears_discount_percent' => '% Descuento',
      'charges' => 'Cargos',
      'charges_discount_percent' => '% Descuento',
      'others_charges' => 'Otros Cargos',
      'others_charges_discount_percent' => '% Descuento',
      'comment' => 'Comentario',
      'code' => 'Código',
      'kind_person' => 'Tipo de Persona',
      'rate_day' => 'Tasa del Día',
      'claim_status' => 'Estatus de Reclamación',
      'product_service' => 'Producto y Servicio',
      'link' => 'Hipervínculo',
      'link_video' => 'Hipervínculo del Video',
      'color' => 'Color',
      'backcolor' => 'Fondo',
      'bordcolor' => 'Borde',
      'textcolor' => 'Texto',
      'startdate' => 'Fecha de Inicio',
      'enddate' => 'Fecha Final',
      'folder_name' => 'Nombre de Carpeta',
      'request_type' => 'Tipo de Solicitud',
      'process' => 'Proceso',
      'subprocess' => 'Subproceso',
      'cause_analysis' => 'Análisis de Causa',
      'people_involved' => 'Personas Involucradas',
      'deliverable' => 'Entregables',
      'users' => 'Usuarios',
      'status' => 'Estatus',
      'full_name' => 'Nombre Completo',
      'birthdate' => 'Cumpleaño',
      'initial_date' => 'Ingreso',
      'image_banner' => 'Imagen Banner',
      'rate_type' => 'Tipo de Tasa',
      'content' => 'Tipo de Contenido',
      'sequence' => 'Secuencia',
      'ranges' => 'Rangos',
      'recordcard' => 'Código',
      'servicedat' => 'Fecha de Ingreso',
      'position' => 'Posición',
      'plastic_name' => 'Nombre Plástico',
      'marital_status' => 'Estado Civil',
      'pstreet' => 'Calle',
      'pnum' => 'Número',
      'pbuilding' => 'Edificio',
      'papartment' => 'Apartamento',
      'psector' => 'Sector',
      'pmail' => 'Correo',
      'pnear' => 'Cerca de',
      'pschedule' => 'Horario de Entrega',
      'pphone_res' => 'Teléfono Residencial',
      'pphone_cel' => 'Teléfono Celular',
      'business_name' => 'Nombre Empresa',
      'position' => 'Cargo que Ocupa',
      'working_time' => 'Tiempo Laboral',
      'monthly_income' => 'Ingresos Mensuales',
      'others_income' => 'Otros Ingresos',
      'lstreet' => 'Calle',
      'lnum' => 'Número',
      'lbuilding' => 'Edificio',
      'lapartment' => 'Apartamento',
      'lsector' => 'Sector',
      'lmail' => 'Correo',
      'lnear' => 'Cerca de',
      'lschedule' => 'Horario de Entrega',
      'lphone_off' => 'Teléfono Oficina',
      'lphone_ext' => 'Extensión',
      'lphone_fax' => 'Fax',
      'send_dir_plastic' => 'Dirección de Entrega',
      'ref_1_name' => 'Nombre y Apellido',
      'ref_1_phone_res' => 'Teléfono Residencial',
      'ref_1_phone_cel' => 'Teléfono Celular',
      'ref_2_name' => 'Nombre y Apellido',
      'ref_2_phone_res' => 'Teléfono Residencial',
      'ref_2_phone_cel' => 'Teléfono Celular',
      'username' => 'Usuario',
      'business' => 'Empresa',
      'closing_cost' => 'Gasto de Cierre',
      'age' => 'Edad',
      'name_2' => 'Segundo Nombre',
      'lastname' => 'Apellido',
      'lastname_2' => 'Segundo Apellido',
    ],
];
