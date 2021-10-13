<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
// use Config;
use App\Http\Controllers\Controller;

class DBController extends Controller
{
    public function GetAllData(){
        // dd(Config::get('database.default'));
        // $data = DB::raw('SELECT * FROM names');
        $data = DB::table('names')
#            ->select('name')
            ->get();
        return $data;
    }
}
