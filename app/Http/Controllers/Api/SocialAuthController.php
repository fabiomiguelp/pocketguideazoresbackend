<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    protected array $providers = ['google', 'facebook', 'apple'];

    /**
     * Flutter flow: receive the access token from native SDK,
     * verify it with the provider, and return a Sanctum token.
     *
     * POST /api/auth/social
     * { "provider": "google", "token": "...", "name": "optional" }
     */
    public function handleToken(Request $request): JsonResponse
    {
        $request->validate([
            'provider' => ['required', 'string', 'in:' . implode(',', $this->providers)],
            'token'    => ['required', 'string'],
            'name'     => ['nullable', 'string', 'max:255'],
        ]);

        $provider = $request->provider;
        $accessToken = $request->token;

        try {
            $socialUser = Socialite::driver($provider)->stateless()->userFromToken($accessToken);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Invalid social token.',
            ], 401);
        }

        $user = DB::transaction(function () use ($socialUser, $provider, $request) {
            // Check if this social account already exists
            $socialAccount = SocialAccount::where('provider', $provider)
                ->where('provider_id', $socialUser->getId())
                ->first();

            if ($socialAccount) {
                $socialAccount->update([
                    'provider_token' => $socialUser->token,
                ]);

                // Update avatar if changed
                if ($socialUser->getAvatar()) {
                    $socialAccount->user->update(['avatar' => $socialUser->getAvatar()]);
                }

                return $socialAccount->user;
            }

            // Check if a user with the same email already exists
            $user = null;
            if ($socialUser->getEmail()) {
                $user = User::where('email', $socialUser->getEmail())->first();
            }

            if (!$user) {
                $user = User::create([
                    'name'              => $socialUser->getName() ?? $request->name ?? 'User',
                    'email'             => $socialUser->getEmail(),
                    'email_verified_at' => now(),
                    'avatar'            => $socialUser->getAvatar(),
                    'role'              => 'user',
                    'password'          => null,
                ]);
            }

            // Link the social account
            $user->socialAccounts()->create([
                'provider'       => $provider,
                'provider_id'    => $socialUser->getId(),
                'provider_token' => $socialUser->token,
            ]);

            return $user;
        });

        $token = $user->createToken('social-auth-token')->plainTextToken;

        return response()->json([
            'user'  => $user,
            'token' => $token,
        ]);
    }
}
