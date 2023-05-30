<?php

namespace App\Actions;

use App\Data\v1_0\CreateTokenData;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CreateTokenAction
{
    public function __invoke(CreateTokenData $data): string
    {
        if (!Hash::check($data->password, $data->user->password)) {
            throw ValidationException::withMessages([
                'email' => [(string)trans('validation.credentials')],
            ]);
        }

        return $data->user->createToken($data->token_name)->plainTextToken;
    }
}
