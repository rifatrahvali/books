<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    // 6 - kayıt sayfasını görüntüleyecek fonksiyon
    public function register(){
        return view("account.register");
    }
    // 8 - bu fonksiyon kullanıcıyı kayıt edecektir.
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
    }
}

