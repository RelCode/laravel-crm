<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomersController extends Controller
{
    public function index(){
        $customers = Customers::latest()->paginate();
        return view('customers.list',['customers' => $customers]);
    }

    public function create(){
        return view('customers.create');
    }

    public function fetchProvinces(){
        $provinces = DB::table('provinces')->get();
        return response()->json(['provinces' => $provinces]);
    }

    public function fetchCities($id){
        $cities = DB::table('cities')->where('province',$id)->get();
        if($cities->count() == 0){
            $cities = '';
        }
        return response()->json(['cities' => $cities]);
    }

    public function edit($id){
        
    }
}
