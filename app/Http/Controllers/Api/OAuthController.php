<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use function config;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends ApiController
{
    public function vippsLogin()
    {
        $response = Socialite::driver('vipps')->stateless()
            ->with(['state' => $this->shop->getId()])
            ->redirectUrl($this->getRedirectUrl('vipps'))
            ->setScopes(config('vipps.login.scopes'))
            ->redirect();

        return $response->getTargetUrl();
    }

    public function vippsRedirect(): Application | RedirectResponse | Redirector
    {
//        $user      = Socialite::driver('vipps')->stateless()->user();
//        $vippsUser = VippsUser::callbackHandler($user);
////        $state      = request()->get('state') === self::NULLLLLL ? null : request()->get('state');
//        $shop = Shop::getItem($state);
//        $url  = $shop ? $shop->url() : env('CLIENT_URL');
//
//        return Profile::createOrGetFromVippsUser($vippsUser)->redirectWithSessionKey($url);
    }

    protected function getRedirectUrl(string $provider): string
    {
        return "/api/{$this->shop->getNamespace()}/oauth/${provider}/callback";
    }
}
