<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirect(string $provider)
    {
        $this->validateProvider($provider);
        Session::put('user_role', request()->input('role'));

        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider)
    {
        $userRole = Session::get('user_role');

        $redirectPage = '/';

        if ($userRole === 'marketer') {
            $redirectPage = 'filament.marketer.pages.dashboard';
        } elseif ($userRole === 'publisher') {
            $redirectPage = 'filament.publisher.pages.dashboard';
        }

        $this->validateProvider($provider);

        $response = Socialite::driver($provider)->user();

        $user = User::firstWhere(['email' => $response->getEmail()]);

        if ($user) {
            $user->update([$provider.'_id' => $response->getId()]);
            if ($user->role == 'marketer') {
                $redirectPage = 'filament.marketer.pages.dashboard';
            }
            if ($user->role == 'publisher') {
                $redirectPage = 'filament.publisher.pages.dashboard';
            }
        } else {
            $user = User::create([
                $provider.'_id' => $response->getId(),
                'name' => $response->getName(),
                'email' => $response->getEmail(),
                'password' => '',
                'role' => $userRole,
            ]);
        }

        auth()->login($user);

        return redirect()->intended(route($redirectPage));
    }

    protected function validateProvider(string $provider): array
    {
        return $this->getValidationFactory()->make(
            ['provider' => $provider],
            ['provider' => 'in:google']
        )->validate();
    }
}
