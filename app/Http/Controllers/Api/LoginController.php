<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\CreateTokenAction;
use App\Data\v1_0\CreateTokenData;
use App\Data\v1_0\LoginData;
use App\Enums\StatusEnum;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class LoginController extends BaseController
{
    public function __invoke(LoginData $data): JsonResponse
    {
        /** @var User $user */
        $user = User::whereEmail($data->email)->first();
        if ($user->status == StatusEnum::INACTIVE) {
            return $this->sendResponse([], __('messages.error.inactive'), Response::HTTP_LOCKED);
        }
        if ($user) {

            $token = app(CreateTokenAction::class)(new CreateTokenData(user: $user, password: $data->password, token_name: $data->token_name));

            return $this->sendResponse(['token' => $token, 'user' => collect($user)->only(['uuid', 'first_name', 'last_name', 'email', 'photo', 'status', 'role_id', 'phone_number']),], __('messages.success.login'), Response::HTTP_OK);
        } else {
            return $this->sendError(__('messages.error.unauthorised'), Response::HTTP_UNAUTHORIZED);
        }

    }
}
