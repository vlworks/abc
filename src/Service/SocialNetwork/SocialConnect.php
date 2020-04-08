<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    /**
     * Ранее мы писали на Laravel авторизацию через социальные сети.
     * Использовался Socialite.
     * Авторизация по кнопкам с ссылками типа /auth/redirect/{social}, где social = социальная сеть vkontakte,facebook.
     * Ниже описаны методы универсальные для авторизации (сдеано только facebook).
     * Метод подходит и для vkontakte, за исключением того что вконтакте не имеет в api метод getEmail
     * Чтобы не городить развилки на проверку соц сети,
     * можно добавить адаптер который будет своими способами получать email от api vkontakte и возвращать результат в имеющуюся логику.
     */



    public function auth($social){
        if (Auth::id()) {
            return redirect()->route('home');
        }
        return Socialite::driver($social)->redirect();
    }

    public function callback($social){
        if (Auth::id()) {
            return redirect()->route('home');
        }
        $getInfo = Socialite::driver($social)->user();
        $user = $this->createUser($getInfo, $social);
        Auth::login($user);
        return redirect()->route('home');
    }

    public function createUser($getInfo, $social){
        $user = User::query()
            ->where('social_id', $getInfo->getId())
            ->where('social', $social)
            ->first();
        if(empty($user)){
            $user = new User();
            $user->fill([
                'name' => $getInfo->getName(),
                'email' => $getInfo->getEmail(),
                'social' => $social,
                'social_id' => $getInfo->getId(),
                'avatar' => $getInfo->getAvatar()
            ]);
            $user->save();
        }
        return $user;
    }
}
