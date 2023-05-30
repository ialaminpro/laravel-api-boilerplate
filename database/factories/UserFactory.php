<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\RoleEnum;
use App\Enums\StatusEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Propaganistas\LaravelPhone\PhoneNumber;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $phone = $this->faker->e164PhoneNumber();;

        return [
            'uuid' => $this->faker->uuid(),
            'first_name' => $this->faker->name(),
            'last_name' => $this->faker->name(),
            'photo' => $this->faker->imageUrl(),
            'phone_number' => $phone,
            'phone_country' => (new PhoneNumber($phone))->getCountry(),
            'email' => $this->faker->unique()->userName . '@obcc.de',
            'role_id' => RoleEnum::USER,
            'status' => StatusEnum::ACTIVE,
            'email_verified_at' => now(),
            'password' => Hash::make('fAzEZ869QWt'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
