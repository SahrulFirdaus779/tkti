<?php

// Pesan validasi Bahasa Indonesia (hanya aturan yang dipakai di aplikasi ini)
return [
    'required' => ':Attribute wajib diisi.',
    'email' => ':Attribute harus berupa alamat email yang valid.',
    'unique' => ':Attribute sudah terdaftar.',
    'confirmed' => 'Konfirmasi :attribute tidak cocok.',
    'numeric' => ':Attribute harus berupa angka.',
    'date' => ':Attribute bukan tanggal yang valid.',
    'in' => ':Attribute yang dipilih tidak valid.',
    'string' => ':Attribute harus berupa teks.',
    'min' => [
        'numeric' => ':Attribute minimal :min.',
        'string' => ':Attribute minimal :min karakter.',
    ],
    'max' => [
        'numeric' => ':Attribute maksimal :max.',
        'string' => ':Attribute maksimal :max karakter.',
    ],

    'attributes' => [
        'name' => 'nama',
        'email' => 'email',
        'password' => 'password',
    ],
];
