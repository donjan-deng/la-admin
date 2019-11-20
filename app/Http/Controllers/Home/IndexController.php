<?php

namespace App\Http\Controllers\Home;

use Session;
use Illuminate\Http\Request;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Endroid\QrCode\QrCode;

class IndexController extends BaseController
{
    public function index(Request $request)
    {
        return view('home.index');
    }
    //验证码
    public function captcha(Request $request)
    {
        $length = $request->input('length', 4);
        $width = $request->input('width', 80);
        $height = $request->input('height', 35);
        header('Content-type: image/jpeg');
        $phraseBuilder = new PhraseBuilder($length);
        $builder = new CaptchaBuilder(null, $phraseBuilder);
        $builder->build($width, $height);
        $phrase = $builder->getPhrase();
        Session::flash('captcha', $phrase); //存储验证码
        return response($builder->output())->header('Content-type', 'image/jpeg'); //把验证码数据以jpeg图片的格式输出
    }

    //二维码生成
    public function qrcode(Request $request)
    {
        $qrCode = new QrCode($request->input('q'));
        header('Content-Type: ' . $qrCode->getContentType());
        echo $qrCode->writeString();
    }
}
