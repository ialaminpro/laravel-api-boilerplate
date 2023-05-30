<?php

namespace App\Actions;

use App\Data\v1_0\RegisterData;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterNewUserAction
{
    public function __invoke(RegisterData $data, User $user = new User())
    {
        $registerData = $data->all();
        $registerData['password'] = Hash::make($data->password);
        unset($registerData['token_name']);
        unset($registerData['password_confirmation']);

        return $user->create($registerData);
    }
}
