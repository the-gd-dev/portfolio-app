<?php

namespace App\Http\Traits;

use App\Models\User;
use Socialite;
use Auth;
use Illuminate\Support\Str;
trait  SocialLoginTrait
{
    protected $providers = [
        'facebook', 'google', 'twitter', 'linkedin'
    ];

    public function redirectToProvider($driver)
    {
        if (!$this->isProviderAllowed($driver)) {
            return $this->sendFailedResponse("{$driver} is not currently supported", $driver);
        }

        try {
            return Socialite::driver($driver)->redirect();
        } catch (\Exception $e) {
            // You should show something simple fail message
            return $this->sendFailedResponse($e->getMessage(), $driver);
        }
    }


    public function handleProviderCallback($driver)
    {
        try {
            $user = Socialite::driver($driver)->user();
        } catch (\Exception $e) {
            return $this->sendFailedResponse($e->getMessage());
        }

        // check for email in returned user
        return empty($user->email)
            ? $this->sendFailedResponse("No email id returned from {$driver} provider.", $driver)
            : $this->loginOrCreateAccount($user, $driver);
    }

    protected function sendSuccessResponse($driver)
    {
        $this->createActivity(auth()->user(), $driver.'_login', 'login');
        return "<script type='text/javascript' charset='utf-8'>window.self.close();</script>";
    }

    protected function sendFailedResponse($msg = null, $driver)
    {
        $this->createActivity(auth()->user(), $driver.'_login', 'failed');
        return $msg;
    }

    protected function loginOrCreateAccount($providerUser, $driver)
    {
        // check for already has account
        $user = User::where('email', $providerUser->getEmail())->first();

        // if user already found
        if ($user) {
            // update the avatar and provider that might have changed
            $user->update([
                'display_picture' => $providerUser->avatar,
                $driver.'_id' => $providerUser->id
            ]);
        } else {
            if ($providerUser->getEmail()) { //Check email exists or not. If exists create a new user
                $user = User::create([
                    'secret_id' => Str::random(16),
                    'role_id' => 3,
                    'username' => $providerUser->getEmail(),
                    'name' => $providerUser->getName(),
                    'email' => $providerUser->getEmail(),
                    'display_picture' => $providerUser->getAvatar(),
                    $driver.'_id' => $providerUser->getId(),
                    'password' => '' // user can use reset password to create a password
                ]);
                $this->createDefaultData($user);
            } else {

                //Show message here what you want to show

            }
        }

        // login the user
        Auth::login($user, true);

        return $this->sendSuccessResponse($driver);
    }

    private function isProviderAllowed($driver)
    {
        return in_array($driver, $this->providers) && config()->has("services.{$driver}");
    }
}
