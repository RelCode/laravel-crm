<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Leads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class LeadsController extends Controller
{
    public function index(User $user){
        //fetch all leads that are owned by this admin
        $leads = User::find(auth()->user()->id)->leads;
        // dd($leads);
        return view('leads.list',['leads' => $leads]);
    }
    
    public function create(){
        $stages = DB::table('stages')->get();
        // dd($stages);
        return view('leads.create',['stages' => $stages]);
    }

    public function store(Request $request){
        $this->validate($request,[
            'names' => 'required',
            'profession' => 'required',
            'email' => 'required|email',
            'stage' => 'required'
        ]);


        $lead = new Leads;
        $lead->id = date('ymd') . '_' . substr(uniqid(),6);
        $lead->names = $request->names;
        $lead->profession = $request->profession;
        $lead->email = $request->email;
        $lead->phone = $request->phone;
        $lead->owner = auth()->user()->id;
        $lead->stage = $request->stage;
        if($lead->save()){
            Alert::success('done','new lead created');
            return back();
        }
        Alert::error('failed','error occured. try again or contact admin');
        return back();
    }
}
