<?php

namespace Http\Controllers\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreWithMissingData() {

        $payload = [
            'first_name' => 'Al',
            'last_name'  => 'Amin'
            //email address is missing
        ];
        $this->json('post', 'api/v1.0/auth/register', $payload)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure(['errors']);
    }

    public function testUserIsCreatedSuccessfully()
    {
        $userData = User::factory()->raw();
        $payload = $userData;
        $payload['password'] = 'fAzEZ869QWt';
        $payload['password_confirmation'] = 'fAzEZ869QWt';
        $payload['token_name'] = 'Roomeo App';
        unset($userData['uuid']);
        unset($userData['password']);
        unset($userData['email_verified_at']);
        unset($userData['remember_token']);


        $this->json('post', 'api/v1.0/auth/register', $payload)
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure(
                [
                    'data' => [
                        'token',
                        'user' => [
                            'uuid',
                            'first_name',
                            'last_name',
                            'photo',
                            'phone_number',
                            'email',
                            'role_id',
                            'status',
                        ]
                    ],
                ]
            );

        $this->assertDatabaseHas('users', $userData);
    }
}
