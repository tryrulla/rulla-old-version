<?php

namespace App\Listeners;

use Aacotroneo\Saml2\Events\Saml2LoginEvent;
use App\Models\User;
use Auth;

class LoginListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param Saml2LoginEvent $event
     * @return void
     */
    public function handle(Saml2LoginEvent $event)
    {
        $user = User::firstOrCreate([
            'email' => $event->getSaml2User()->getAttribute(env('SAML2_EMAIL_ATTRIBUTE'))[0]
        ], [
            'username' => $event->getSaml2User()->getAttribute(env('SAML2_USERNAME_ATTRIBUTE'))[0],
            'name' => $event->getSaml2User()->getAttribute(env('SAML2_REALNAME_ATTRIBUTE'))[0],
            'password' => '', // no password
        ]);

        Auth::login($user);

        return redirect()->to('/');
    }
}
