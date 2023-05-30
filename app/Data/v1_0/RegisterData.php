<?php

namespace App\Data\v1_0;

use App\Enums\RoleEnum;
use App\Enums\StatusEnum;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Uuid;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Confirmed;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Password;
use Spatie\LaravelData\Attributes\Validation\Unique;


/** @typescript */
class RegisterData extends Data
{
    public function __construct(

        #[Uuid(), Nullable, Unique('users')]
        public ?string         $uuid,

        #[Max(30)]
        public string          $first_name,

        #[Max(30), Nullable]
        public ?string         $last_name,

        #[Nullable]
        public ?string         $photo,

        #[Min(8), Max(16), Unique('users'),]
        public ?string         $phone_number,

        #[Min(2), Max(3)]
        public ?string         $phone_country,

        #[Min(6), Max(80), Unique('users'), Email([Email::RfcValidation, Email::NoRfcWarningsValidation, Email::DnsCheckValidation, Email::SpoofCheckValidation, Email::FilterEmailValidation])]
        public string          $email,

        #[Nullable]
        public RoleEnum|null   $role_id,

        #[Confirmed, Password(8, true, true, true), Max(30)]
        public string          $password,

        #[Nullable]
        public StatusEnum|null $status,

        #[Nullable, Exists('users', 'id')]
        public ?int            $created_by,

        #[Max(50)]
        public string $token_name

//        #[Nullable, Exists('users', 'id')]
//        public ?int            $updated_by,

//        #[Nullable, Exists('users', 'id')]
//        public ?int            $deleted_by,

//        #[DateFormat('Y-m-d H:i:s'), Nullable]
//        public ?string     $created_at,

//        #[DateFormat('Y-m-d H:i:s'), Nullable]
//        public ?string     $updated_at,

//        #[DateFormat('Y-m-d H:i:s'), Nullable]
//        public ?string     $deleted_at,
    )
    {
        $this->role_id ??= RoleEnum::USER;
        $this->status ??= StatusEnum::ACTIVE;
    }

    public static function authorize(): bool
    {
        return true;
    }

    public static function rules(): array
    {
        return [
            'phone_number' => 'phone|unique:users,phone_number',
            'phone_country' => 'required_with:phone_number',
        ];
    }


    public static function messages(): array
    {
        return [
            'phone_country.required_with' => __('validation.phone_country'),
        ];
    }


}
