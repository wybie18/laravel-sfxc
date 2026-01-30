<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\V1\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\LoginHistory;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

final class AuthController extends ApiController
{
    /**
     * Authenticate a user and return a token.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::query()
            ->where('email', $request->email)
            ->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            $this->recordLoginAttempt($request, $user, false, 'Invalid credentials');

            return $this->unauthorized('Invalid credentials');
        }

        if (! $user->is_active) {
            $this->recordLoginAttempt($request, $user, false, 'Account is inactive');

            return $this->forbidden('Your account has been deactivated. Please contact the administrator.');
        }

        $user->update(['last_login_at' => now()]);

        $this->recordLoginAttempt($request, $user, true);

        $token = $user->createToken('auth-token')->plainTextToken;

        $user->load($this->getUserRelations());

        return $this->success([
            'user' => new UserResource($user),
            'token' => $token,
        ], 'Login successful');
    }

    /**
     * Logout the authenticated user.
     */
    public function logout(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        LoginHistory::query()
            ->where('user_id', $user->id)
            ->whereNull('logout_at')
            ->latest('login_at')
            ->first()
            ?->update(['logout_at' => now()]);

        $user->currentAccessToken()->delete();

        return $this->success(message: 'Logged out successfully');
    }

    /**
     * Get the authenticated user's information.
     */
    public function me(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();
        $user->load($this->getUserRelations());

        return $this->success(new UserResource($user));
    }

    /**
     * Refresh the authenticated user's token.
     */
    public function refresh(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $user->currentAccessToken()->delete();

        $token = $user->createToken('auth-token')->plainTextToken;

        return $this->success([
            'token' => $token,
        ], 'Token refreshed successfully');
    }

    /**
     * Get the relations to load for the user.
     *
     * @return array<string>
     */
    private function getUserRelations(): array
    {
        return [
            'person.contactInformation',
            'person.addresses',
            'roles.permissions',
            'student.currentProgram.program.department.college',
            'student.currentProgram.curriculum',
            'student.guardians',
            'faculty.department.college',
            'faculty.specializations',
            'staff.office',
            'staff.department.college',
            'staff.position',
        ];
    }

    /**
     * Record a login attempt in the login history.
     */
    private function recordLoginAttempt(
        LoginRequest $request,
        ?User $user,
        bool $success,
        ?string $failureReason = null
    ): void {
        if ($user === null) {
            return;
        }

        LoginHistory::query()->create([
            'user_id' => $user->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'login_status' => $success ? 'success' : 'failed',
            'failure_reason' => $failureReason,
            'login_at' => now(),
        ]);
    }
}
