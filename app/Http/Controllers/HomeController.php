<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Auth;
use Illuminate\Support\Facades\Session;
use JWTAuth;
use Illuminate\Support\Facades\DB;
use URL;
use App\Models\Common;
use App\Models\Faq;
use App\Models\Cms;
use App\Models\Settings;

class HomeController extends Controller
{
    public $data = [];
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
        
    public function termsofuseMobile(){
        $this->data['termscondition'] = Cms::where('slug_url', 'terms_and_condition')->first();
        return view('web.termsofuse.termsofusemobile',$this->data);
    }
    
    public function privacyPolicyMobile(){
        $this->data['privacypolicy'] = Cms::where('slug_url', 'privacy_policy')->first();
        return view('web.privacypolicy.privacypolicymobile',$this->data);
    }
    
    
    
    
}
