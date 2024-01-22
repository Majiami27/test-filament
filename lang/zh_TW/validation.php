<?php

return [

    /*
    |--------------------------------------------------------------------------
    | 驗證語言行
    |--------------------------------------------------------------------------
    |
    | 以下語言行包含了驗證器類別使用的預設錯誤訊息。某些規則具有多個版本，
    | 如大小規則。您可以隨意調整這些訊息以更好地符合您應用程式的需求。
    |
    */

    'accepted' => ':attribute 必須被接受。',
    'accepted_if' => '當 :other 是 :value 時，:attribute 必須被接受。',
    'active_url' => ':attribute 必須是有效的 URL。',
    'after' => ':attribute 必須是 :date 之後的日期。',
    'after_or_equal' => ':attribute 必須是 :date 之後或等於該日期。',
    'alpha' => ':attribute 必須只包含字母。',
    'alpha_dash' => ':attribute 只能包含字母、數字、破折號和底線。',
    'alpha_num' => ':attribute 只能包含字母和數字。',
    'array' => ':attribute 必須是一個陣列。',
    'ascii' => ':attribute 只能包含單字範圍的字母、數字和符號。',
    'before' => ':attribute 必須是 :date 之前的日期。',
    'before_or_equal' => ':attribute 必須是 :date 之前或等於該日期。',
    'between' => [
        'array' => ':attribute 必須包含 :min 到 :max 個項目。',
        'file' => ':attribute 必須介於 :min 到 :max 公斤之間。',
        'numeric' => ':attribute 必須介於 :min 到 :max 之間。',
        'string' => ':attribute 必須介於 :min 到 :max 個字元之間。',
    ],
    'boolean' => ':attribute 必須是 true 或 false。',
    'can' => ':attribute 包含未經授權的值。',
    'confirmed' => ':attribute 確認不符。',
    'current_password' => '密碼不正確。',
    'date' => ':attribute 必須是有效的日期。',
    'date_equals' => ':attribute 必須是等於 :date 的日期。',
    'date_format' => ':attribute 必須符合格式 :format。',
    'decimal' => ':attribute 必須有 :decimal 位小數。',
    'declined' => ':attribute 必須被拒絕。',
    'declined_if' => '當 :other 是 :value 時，:attribute 必須被拒絕。',
    'different' => ':attribute 和 :other 必須不同。',
    'digits' => ':attribute 必須是 :digits 位數字。',
    'digits_between' => ':attribute 必須介於 :min 到 :max 位數字之間。',
    'dimensions' => ':attribute 的圖片尺寸無效。',
    'distinct' => ':attribute 具有重複的值。',
    'doesnt_end_with' => ':attribute 不能以以下之一結尾：:values。',
    'doesnt_start_with' => ':attribute 不能以以下之一開頭：:values。',
    'email' => ':attribute 必須是有效的電子郵件地址。',
    'ends_with' => ':attribute 必須以以下之一結尾：:values。',
    'enum' => '所選 :attribute 無效。',
    'exists' => '所選 :attribute 無效。',
    'extensions' => ':attribute 必須具有以下擴展名之一：:values。',
    'file' => ':attribute 必須是檔案。',
    'filled' => ':attribute 必須有值。',
    'gt' => [
        'array' => ':attribute 必須有超過 :value 項目。',
        'file' => ':attribute 必須大於 :value 公斤。',
        'numeric' => ':attribute 必須大於 :value。',
        'string' => ':attribute 必須超過 :value 個字元。',
    ],
    'gte' => [
        'array' => ':attribute 必須有 :value 項目或更多。',
        'file' => ':attribute 必須大於或等於 :value 公斤。',
        'numeric' => ':attribute 必須大於或等於 :value。',
        'string' => ':attribute 必須大於或等於 :value 個字元。',
    ],
    'hex_color' => ':attribute 必須是有效的十六進制顏色。',
    'image' => ':attribute 必須是圖片。',
    'in' => '所選 :attribute 無效。',
    'in_array' => ':attribute 必須存在於 :other 中。',
    'integer' => ':attribute 必須是整數。',
    'ip' => ':attribute 必須是有效的 IP 位址。',
    'ipv4' => ':attribute 必須是有效的 IPv4 位址。',
    'ipv6' => ':attribute 必須是有效的 IPv6 位址。',
    'json' => ':attribute 必須是有效的 JSON 字串。',
    'lowercase' => ':attribute 必須是小寫。',
    'lt' => [
        'array' => ':attribute 必須有少於 :value 項目。',
        'file' => ':attribute 必須小於 :value 公斤。',
        'numeric' => ':attribute 必須小於 :value。',
        'string' => ':attribute 必須少於 :value 個字元。',
    ],
    'lte' => [
        'array' => ':attribute 不得有超過 :value 項目。',
        'file' => ':attribute 必須小於或等於 :value 公斤。',
        'numeric' => ':attribute 必須小於或等於 :value。',
        'string' => ':attribute 必須小於或等於 :value 個字元。',
    ],
    'mac_address' => ':attribute 必須是有效的 MAC 位址。',
    'max' => [
        'array' => ':attribute 不得有超過 :max 項目。',
        'file' => ':attribute 不得大於 :max 公斤。',
        'numeric' => ':attribute 不得大於 :max。',
        'string' => ':attribute 不得大於 :max 個字元。',
    ],
    'max_digits' => ':attribute 不得超過 :max 位數字。',
    'mimes' => ':attribute 必須是類型為 :values 的檔案。',
    'mimetypes' => ':attribute 必須是類型為 :values 的檔案。',
    'min' => [
        'array' => ':attribute 必須至少有 :min 項目。',
        'file' => ':attribute 必須至少為 :min 公斤。',
        'numeric' => ':attribute 必須至少為 :min。',
        'string' => ':attribute 必須至少有 :min 個字元。',
    ],
    'min_digits' => ':attribute 必須至少有 :min 位數字。',
    'missing' => ':attribute 必須不存在。',
    'missing_if' => '當 :other 是 :value 時，:attribute 必須不存在。',
    'missing_unless' => '當 :other 不是 :value 時，:attribute 必須不存在。',
    'missing_with' => '當 :values 存在時，:attribute 必須不存在。',
    'missing_with_all' => '當 :values 存在時，:attribute 必須不存在。',
    'multiple_of' => ':attribute 必須是 :value 的倍數。',
    'not_in' => '所選 :attribute 無效。',
    'not_regex' => ':attribute 格式無效。',
    'numeric' => ':attribute 必須是數字。',
    'password' => [
        'letters' => ':attribute 必須包含至少一個字母。',
        'mixed' => ':attribute 必須包含至少一個大寫字母和一個小寫字母。',
        'numbers' => ':attribute 必須包含至少一個數字。',
        'symbols' => ':attribute 必須包含至少一個符號。',
        'uncompromised' => '提供的 :attribute 已出現在數據泄露中。請選擇其他 :attribute。',
    ],
    'present' => ':attribute 必須存在。',
    'present_if' => '當 :other 是 :value 時，:attribute 必須存在。',
    'present_unless' => '除非 :other 是 :value，否則 :attribute 必須存在。',
    'present_with' => '當 :values 存在時，:attribute 必須存在。',
    'present_with_all' => '當 :values 存在時，:attribute 必須存在。',
    'prohibited' => ':attribute 被禁止。',
    'prohibited_if' => '當 :other 是 :value 時，:attribute 被禁止。',
    'prohibited_unless' => '除非 :other 是 :value，否則 :attribute 被禁止。',
    'prohibits' => ':attribute 禁止 :other 存在。',
    'regex' => ':attribute 格式無效。',
    'required' => ':attribute 是必填的。',
    'required_array_keys' => ':attribute 必須包含以下鍵的項目：:values。',
    'required_if' => '當 :other 是 :value 時，:attribute 是必填的。',
    'required_if_accepted' => '當 :other 被接受時，:attribute 是必填的。',
    'required_unless' => '除非 :other 在 :values 中，否則 :attribute 是必填的。',
    'required_with' => '當 :values 存在時，:attribute 是必填的。',
    'required_with_all' => '當 :values 都存在時，:attribute 是必填的。',
    'required_without' => '當 :values 不存在時，:attribute 是必填的。',
    'required_without_all' => '當 :values 都不存在時，:attribute 是必填的。',
    'same' => ':attribute 必須與 :other 相符。',
    'size' => [
        'array' => ':attribute 必須包含 :size 項目。',
        'file' => ':attribute 必須是 :size 公斤。',
        'numeric' => ':attribute 必須是 :size。',
        'string' => ':attribute 必須是 :size 個字元。',
    ],
    'starts_with' => ':attribute 必須以以下之一開頭：:values。',
    'string' => ':attribute 必須是字串。',
    'timezone' => ':attribute 必須是有效的時區。',
    'unique' => ':attribute 已經存在。',
    'uploaded' => ':attribute 上傳失敗。',
    'uppercase' => ':attribute 必須是大寫。',
    'url' => ':attribute 格式無效。',
    'ulid' => ':attribute 必須是有效的 ULID。',
    'uuid' => ':attribute 必須是有效的 UUID。',

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
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
