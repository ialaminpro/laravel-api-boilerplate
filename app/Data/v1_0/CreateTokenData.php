<?php

namespace App\Data\v1_0;

use App\Models\User;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Password;
use Spatie\LaravelData\Data;

/** @typescript */
class CreateTokenData extends Data
{
    public function __construct(

        public User $user,

        #[Password(8, true, true, true), Max(30)]
        public string $password,

        #[Max(50)]
        public string $token_name
    ) {}

    public static function authorize(): bool
    {
        return true;
    }
}
