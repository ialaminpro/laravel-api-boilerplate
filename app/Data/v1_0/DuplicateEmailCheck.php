<?php

namespace App\Data\v1_0;

use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\WithCastable;
use Spatie\LaravelData\Data;

class DuplicateEmailCheck extends Data
{
    public function __construct(
        #[WithCastable(Email::class, normalize: true)]
        public Email $email,
    )
    {
    }
}
