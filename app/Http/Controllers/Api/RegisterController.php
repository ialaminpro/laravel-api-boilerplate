<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\CreateTokenAction;
use App\Actions\RegisterNewUserAction;
use App\Data\v1_0\CreateTokenData;
use App\Data\v1_0\RegisterData;
use App\Enums\VersionEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

final class RegisterController extends BaseController
{
    public function __invoke(RegisterData $data, VersionEnum $version): JsonResponse
    {
        abort_unless(
            $version->greaterThanOrEqualsTo(VersionEnum::v1_0),
            Response::HTTP_NOT_FOUND
        );

        DB::beginTransaction();
        try {

            $user = app(RegisterNewUserAction::class)($data);

            $token = app(CreateTokenAction::class)(new CreateTokenData(user: $user, password: $data->password, token_name: $data->token_name));

            DB::commit();

            return $this->sendResponse(['token' => $token, 'user' => collect($user)->only(['uuid', 'first_name', 'last_name', 'email', 'photo', 'status', 'role_id', 'phone_number'])], __('messages.success.register'), Response::HTTP_CREATED);
        } catch (\Illuminate\Database\QueryException $e) {

            return $this->sendError(config('app.debug') ? $e->getMessage() : Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->sendError(Response::$statusTexts[$e->getCode()], $e->getCode());
        }
    }
}
