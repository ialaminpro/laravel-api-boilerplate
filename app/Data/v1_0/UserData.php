<?php

namespace App\Data\v1_0;

use App\Enums\RoleEnum;
use Spatie\LaravelData\Attributes\Validation\Enum;
use Spatie\LaravelData\Attributes\Validation\Max;

use Spatie\LaravelData\Data;

class UserData extends Data
{
    public function __construct(

        public ?string       $uuid,
        #[Max(25)]
        public string        $first_name,
        #[Max(25)]
        public ?string       $last_name,
        #[Max(16)]
        public ?string       $phone_number,
        #[Max(80)]
        public string        $email,

        public RoleEnum|null $role,

        public string        $password
    ) {}

    public static function authorize(): bool
    {
        return true;
    }
}
