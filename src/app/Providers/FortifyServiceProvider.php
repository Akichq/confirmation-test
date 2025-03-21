<?php

namespace App\Providers;

use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use App\Actions\Fortify\CreateNewUser;
use App\Http\Requests\LoginUserRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
{
    $this->app->bind(
        \Laravel\Fortify\Contracts\CreatesNewUsers::class,
        \App\Actions\Fortify\CreateNewUser::class
    );
}

    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);

        Fortify::registerView(function () {
            return view('auth.register');
        });

        Fortify::authenticateUsing(function (Request $request) {
        $validated = $request->validateWithBag('login', (new LoginUserRequest())->rules());
            $user = User::where('email', $validated['email'])->first();

            if ($user &&
                Hash::check($validated['password'], $user->password)) {
                return $user;
            }
        });

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(10)->by($email.$request->ip());
        });
    }
}

