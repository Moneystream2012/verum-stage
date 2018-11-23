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

    'accepted'   => ':attribute должен быть принят.',
    'active_url' => ':attribute недействительный URL.',
    'after'      => ':attribute должна быть датой после :date.',
    'alpha'      => ':attribute может содержать только буквы.',
    'alpha_dash' => ':attribute может содержать только буквы, цифры, и дефисы.',
    'alpha_num'  => ':attribute может содержать только буквы и цифры.',
    'array'      => ':attribute должна быть массивом.',
    'before'     => ':attribute долежн быть датой до :date.',
    'between'    => [
        'numeric' => ':attribute должен быть от :min до :max.',
        'file'    => ':attribute должен быть размером от :min до :max килобайтов.',
        'string'  => ':attribute должен быть длиной от :min до :max символов.',
        'array'   => ':attribute должен состоять от :min до :max элементов.',
    ],
    'boolean'        => ':attribute поле должно быть `истиной` или `ложью`.',
    'confirmed'      => ':attribute подтверждение не соответствует.',
    'date'           => ':attribute не является действительной датой.',
    'date_format'    => ':attribute не соответствует формату :format.',
    'different'      => ':attribute и :other должны различаться.',
    'digits'         => ':attribute должен состоять из :digits цифр.',
    'digits_between' => ':attribute должен состоять от :min до :max цифр.',
    'dimensions'     => ':attribute имеет недопустимые размеры изображения.',
    'distinct'       => ':attribute - поле имеет повторяющееся значение.',
    'email'          => ':attribute - адрес эл. почты должен быть действительным.',
    'exists'         => 'Выбранный :attribute является недействительным.',
    'file'           => ':attribute должен быть файлом.',
    'filled'         => ':attribute - поле, обязательное для заполнения.',
    'image'          => ':attribute должно быть изображением.',
    'in'             => 'Выбранное :attribute является недействительным.',
    'in_array'       => ':attribute поле не существует в :other.',
    'integer'        => ':attribute должен быть целым числом.',
    'ip'             => ':attribute должен быть действительным IP-адресом.',
    'json'           => ':attribute должна быть действительной строкой JSON.',
    'max'            => [
        'numeric' => ':attribute может быть не более :max.',
        'file'    => ':attribute может быть не более :max килобайтов.',
        'string'  => ':attribute может быть не более :max символов.',
        'array'   => ':attribute должен состоять из не более чем :max элементов.',
    ],
    'mimes' => ':attribute должен быть файлом типа: :values.',
    'min'   => [
        'numeric' => ':attribute должен быть не менее :min.',
        'file'    => ':attribute должен быть не менее :min килобайтов.',
        'string'  => ':attribute должен быть не менее :min символов.',
        'array'   => ':attribute должен состоять из не менее чем :min элементов.',
    ],
    'not_in'               => 'Выбранный :attribute является недействительным.',
    'numeric'              => ':attribute должен быть числом.',
    'present'              => ':attribute поле должно присутствовать.',
    'regex'                => ':attribute формат недействителен.',
    'required'             => ':attribute - поле, обязательное для заполнения.',
    'required_if'          => ':attribute поле требуется, если :other равно :value.',
    'required_unless'      => ':attribute поле требуется, если :other в диапазоне :values.',
    'required_with'        => ':attribute поле требуется, если не присутствует :values.',
    'required_with_all'    => ':attribute поле требуется, если не присутствует одна из :values.',
    'required_without'     => ':attribute поле требуется, если не присутствует :values.',
    'required_without_all' => ':attribute поле требуется, если не присутствует ни одна из :values.',
    'same'                 => ':attribute и :other должен соответствовать.',
    'size'                 => [
        'numeric' => ':attribute должен быть  :size.',
        'file'    => ':attribute должен быть :size килобайтов.',
        'string'  => ':attribute должен содержать :size символов.',
        'array'   => ':attribute должен содержать :size элементов.',
    ],
    'string'   => ':attribute должен быть строкой.',
    'timezone' => ':attribute должна быть действительной зоной.',
    'unique'   => ':attribute уже занят.',
    'url'      => ':attribute формат URL недействителен.',

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
        'transaction_password' => 'Пароль транзакции',
    ],

    'phone'     => ':attribute поле содержит недопустимое число.',
    'recaptcha' => ':attribute поле неверно.',

    // user
    'is_user'        => 'Этот пользователь не существует.',
    'not_user'       => 'Пользователь не найден.',
    'deficiency'     => 'Недостаточно средств на балансе.',
    'check_password' => ':attribute неверный пароль.',
];
