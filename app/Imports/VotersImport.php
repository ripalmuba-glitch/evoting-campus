<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class VotersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Pastikan tidak menduplikasi email yang sama
        if (User::where('email', $row['email'])->exists()) {
            return null;
        }

        return new User([
            'name'     => $row['name'],     // Sesuai header di Excel
            'email'    => $row['email'],    // Sesuai header di Excel
            'password' => Hash::make('12345678'), // Password Default
            'role'     => 'voter',
            'is_voted' => false,
        ]);
    }
}
