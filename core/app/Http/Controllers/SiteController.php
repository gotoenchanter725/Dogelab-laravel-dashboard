<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Page;
use Illuminate\Http\Request;


class SiteController extends Controller
{
    public function __construct(){
        $this->activeTemplate = activeTemplate();

    }

    public function index(){

        if(request()->has('ref')){
            session()->put('reference', request()->ref);
        }


        $account = session('ACCOUNT');
        $account = Account::where('wallet', $account)->first();
        if($account){
            return redirect()->route('account.home');
        }

        $count = Page::where('tempname',$this->activeTemplate)->where('slug','home')->count();

        if($count == 0){
            $page = new Page();
            $page->tempname = $this->activeTemplate;
            $page->name = 'HOME';
            $page->slug = 'home';
            $page->save();
        }

        $data['page_title'] = 'Home';
        $data['sections'] = Page::where('tempname',$this->activeTemplate)->where('slug','home')->firstOrFail();
        return view($this->activeTemplate . 'home', $data);
    }

    public function pages($slug)
    {
        $page = Page::where('tempname',$this->activeTemplate)->where('slug',$slug)->firstOrFail();
        $data['page_title'] = $page->name;
        $data['sections']   = $page;
        return view($this->activeTemplate . 'pages', $data);
    }

    public function page($id)
    {

        $data           = Frontend::findOrFail($id);
        $page_title     = $data->data_values->page_title??'';

        return view($this->activeTemplate.'page', compact('page_title', 'data'));
    }


    public function contact()
    {
        $data['page_title'] = "Contact Us";
        $data['sections'] = Page::where('tempname',$this->activeTemplate)->where('slug','contact')->firstOrFail();
        return view($this->activeTemplate . 'contact', $data);
    }


    public function contactSubmit(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|max:191',
            'email' => 'required|max:191',
            'subject' => 'required|max:100',
            'message' => 'required',
        ]);

        sendContactEmail($request->email, $request->name, $request->subject, $request->message);


        $notify[] = ['success', 'Mail Sent Successfully!'];

        return redirect()->back()->withNotify($notify);
    }
    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return redirect()->back();
    }


    public function cookieAccept(){
        session()->put('cookie_accepted',true);
        return response()->json(['success'=>'Cookie accepted successfully']);
    }

    public function blogs()
    {
        $data['page_title'] = "Blogs";
        $data['blogs']      = Frontend::where('data_keys','blog.element')->latest()->paginate(9);
        $data['sections']   = Page::where('tempname',$this->activeTemplate)->where('slug', 'blogs')->firstOrFail();

        return view($this->activeTemplate . 'blogs', $data);
    }

    public function blogDetails($id,$slug){
        $blog = Frontend::where('id',$id)->where('data_keys','blog.element')->firstOrFail();
        $page_title     = 'Read Blog';
        $latestBlogs    = Frontend::where('id', '!=', $id)->where('data_keys', 'blog.element')->take(5)->get();
        return view($this->activeTemplate.'blogDetails',compact('blog','page_title', 'latestBlogs'));
    }

    public function placeholderImage($size = null){

        if ($size != 'undefined') {
            $size = $size;
            $imgWidth = explode('x',$size)[0];
            $imgHeight = explode('x',$size)[1];
            $text = $imgWidth . '×' . $imgHeight;
        }else{
            $imgWidth = 150;
            $imgHeight = 150;
            $text = 'Undefined Size';
        }
        $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if($imgHeight < 100 && $fontSize > 30){
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');


        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

}
