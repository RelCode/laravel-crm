<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

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

    public function store(Request $request){
        $this->validate($request,[
            'name' => 'required',
            'profession' => 'required',
            'email' => 'required|email|unique:customers,email',
            'address' => 'required',
            'city' => 'required',
            'province' => 'required'
        ]);
        //check if the user selected province exists
        $province = DB::table('provinces')->where('id',$request->province)->get();
        if($province->count() == 0){
            Alert::warning('error','invalid province selected');
            return back();
        }
        //we check if the selected city exists in the selected province exists
        $city = DB::table('cities')->where('id',$request->city)->where('province',$request->province)->get();
        if ($city->count() == 0) {
            Alert::warning('error', 'invalid city selected');
            return back();
        }
        $customer = new Customers();
        $customer->name = $request->name;
        $customer->profession = $request->profession;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->city = $request->city;
        $customer->province = $request->province;
        if($customer->save()){
            Alert::success('done','new customer has been added');
            return back();
        }
        Alert::error('error','action failed. try again');
        return back();
    }

    public function edit($id){
        $customer = Customers::find($id);
        if(is_null($customer)){
            Alert::warning('error','invalid customer ID provided');
            return back();
        }
        if(!is_null($customer->city)){
            $city = DB::table('cities')
            ->where('id', $customer->city)
            ->where('province', $customer->province)
            ->get();
            if ($city->count() == 0) {
                Alert::error('error', 'invalid city information. contact admin');
                return back();
            }
            $city = $city[0];
        }else{
            $city = '';
        }
        return view('customers.edit',['customer' => $customer,'city' => $city]);
    }

    public function update(Request $request, $id){
        //check if the customer exists
        $customer = Customers::find($id);
        if (is_null($customer)) {
            Alert::warning('error', 'invalid customer ID provided');
            return back();
        }
        $this->validate($request, [
            'name' => 'required',
            'profession' => 'required',
            'email' => ['required','email',Rule::unique('customers')->ignore($id)],
            'address' => 'required',
            'city' => 'required',
            'province' => 'required'
        ]);
        //check if the user selected province exists
        $province = DB::table('provinces')->where('id', $request->province)->get();
        if ($province->count() == 0) {
            Alert::warning('error', 'invalid province selected');
            return back();
        }
        //we check if the selected city exists in the selected province exists
        $city = DB::table('cities')->where('id', $request->city)->where('province', $request->province)->get();
        if ($city->count() == 0) {
            Alert::warning('error', 'invalid city selected');
            return back();
        }
        // $customer = new Customers();
        $customer->name = $request->name;
        $customer->profession = $request->profession;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->city = $request->city;
        $customer->province = $request->province;
        if ($customer->save()) {
            Alert::success('done', 'customer info has been updated');
            return back();
        }
        Alert::error('error', 'action failed. try again');
        return back();
    }
}
