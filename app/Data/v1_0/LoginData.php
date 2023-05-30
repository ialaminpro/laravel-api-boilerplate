<?php

namespace App\Data\v1_0;

use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Password;
use Spatie\LaravelData\Data;

/** @typescript */
class LoginData extends Data
{
    public function __construct(

        #[Max(80), Min(6), Exists('users', 'email'), Email([Email::RfcValidation, Email::NoRfcWarningsValidation, Email::DnsCheckValidation, Email::SpoofCheckValidation, Email::FilterEmailValidation])]
        public string $email,

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
