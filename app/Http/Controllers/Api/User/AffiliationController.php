<?php

namespace App\Http\Controllers\Api\User;

use App\Support\Http\ApiResponse;
use App\Services\User\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserTransformer;
use App\Http\Resources\User\InvitedUsersTransformer;

final class AffiliationController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {}

    public function index(ApiResponse $response)
    {
        $user = Auth::user();

        $invitedUsers = $this->userService->getInvitedUsers($user);

        return $response->success(
            InvitedUsersTransformer::collection($invitedUsers),
            meta: ApiResponse::buildPaginationMeta($invitedUsers)
        );
    }
}
