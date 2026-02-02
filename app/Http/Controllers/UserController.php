<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeMail; // 作成したMailableクラスをインポート
use Illuminate\Support\Facades\Mail; // Mailファサードをインポート

class UserController extends Controller
{
    public function sendWelcomeEmail($userEmail, $userName)
    {
        // to()メソッドで宛先を指定し、send()メソッドでMailableインスタンスを渡します。
        Mail::to($userEmail)->send(new WelcomeMail($userName));

        return 'ウェルカムメールを ' . $userEmail . ' に送信しました。';
    }
}