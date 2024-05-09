<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    // 6 - kayıt sayfasını görüntüleyecek fonksiyon GET
    public function register(){
        return view("account.register");
    }
    // 8 - bu fonksiyon kullanıcıyı kayıt edecektir. POST
    public function processRegister(Request $request){
        $validator = Validator::make($request->all(), [
            'name'=>'required|min:3',
            'email'=>'required|email',
            'password'=>'required|confirmed|min:5',
            'password_confirmation'=>'required',
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

        return redirect()->route('account.login')->with('success','Kayıt başarılı.');
    }

    public function login(){
        return view("account.login");
    }
}

