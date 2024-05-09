<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    // 6 - kayıt sayfasını görüntüleyecek fonksiyon GET
    public function register()
    {
        return view("account.register");
    }
    // 8 - bu fonksiyon kullanıcıyı kayıt edecektir. POST
    public function processRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            // mail adresleri benzersiz olsun
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:5',
            'password_confirmation' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('account.register')->withInput()->withErrors($validator);
        }

        // Kullanıcı kayıt
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('account.login')->with('success', 'Kayıt başarılı.');
    }

    public function login()
    {
        return view("account.login");
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|email",
            "password" => "required",
        ]);

        if ($validator->fails()) {
            return redirect()->route("account.login")->withInput()->withErrors($validator);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // VT ile eşleşiyo mu
            return redirect()->route('account.profile');
        } else {
            return redirect()->route("account.login")->with("error", "Kullanıcı veya parola hatalı.");
        }
    }

    public function profile()
    {

        $user = User::find(Auth::user()->id);
        //dd($user);

        // 17   -   giriş yapılan kullanıcının bilgilerini profil sayfasına iletelim.
        // user değişkeni kullanarak.
        return view(
            "account.profile",
            [
                "user" => $user
            ]
        );
    }

    //  18  -   profil güncelleme
    public function updateProfile(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,'.Auth::user()->id.',id',
        ]);
        if ($validator->fails()) {
            return redirect()->route('account.profile')->withInput()->withErrors($validator);
        }

        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        return redirect()->route('account.profile')->with('success','Profil güncellendi');
    }

    //  14  -   logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route("account.login");
    }

}

