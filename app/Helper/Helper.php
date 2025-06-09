<?php

namespace App\Helper;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Activity;
use App\Models\Gallery;
use App\Models\beneficiarie;
use App\Models\Member;
use App\Models\academic_session;
use App\Models\Notice;
use App\Models\Working_Area;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Session;
use Auth;


    // public static function getUSer()
    // {
    //     $user = Auth::User();
    //     return $user;
    // }

    
    // function say_hello($name = 'Guest') {
    //     return "Hello, $name!";
    // }

    if (!function_exists('say_hello')) {
    function say_hello($name = 'Guest') {
        return "Hello, $name!";
    }
}
   
?>


