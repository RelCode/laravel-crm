<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Leads;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class LeadsController extends Controller
{
    public function index(User $user){
        //fetch all leads that are owned by this admin
        $leads = DB::table('leads')
            ->where('owner',auth()->user()->id)
            ->join('stages','leads.stage','stages.id')
            ->join('users','leads.owner','users.id')
            ->select('leads.*','stages.stage as current_stage','users.name as creator')
            ->paginate(5);
        return view('leads.list',['leads' => $leads]);
    }
    
    public function create(){
        $stages = $this->getStages();
        return view('leads.create',['stages' => $stages]);
    }

    public function store(Request $request){
        $this->validate($request,[
            'names' => 'required',
            'profession' => 'required',
            'email' => 'required|email|unique:leads,email',
            'stage' => 'required'
        ]);

        //

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

    public function edit($id){
        $stages = $this->getStages();
        $lead = DB::table('leads')
            ->where('leads.owner', auth()->user()->id)
            ->where('leads.id', $id)
            ->join('stages', 'leads.stage', 'stages.id')
            ->join('users', 'leads.owner', 'users.id')
            ->select('leads.*', 'stages.stage as current_stage', 'users.name as creator')
            ->get();
        return view('leads.edit',['lead' => $lead,'stages' => $stages]);
    }

    public function update(Request $request, $id){
        //validate user input
        $this->validate($request, [
            'names' => 'required',
            'profession' => 'required',
            'email' => ['required','email',Rule::unique('leads')->ignore($id)],//the rule ensure the email does not belong to anyone if a different email has been inserted
            'stage' => 'required'
        ]);
        $lead = Leads::find($id);
        //check if user with the ID submitted exists
        if($lead == null){
            Alert::warning('warning','action failed');
            return back();
        }
        //update the 
        $lead->names = $request->names;
        $lead->profession = $request->profession;
        $lead->email = $request->email;
        $lead->phone = $request->phone;
        $lead->owner = auth()->user()->id;
        $lead->stage = $request->stage;
        if ($lead->save()) {
            Alert::success('done', 'lead info updated');
            return back();
        }
        Alert::error('failed', 'error occured. try again or contact admin');
        return back();
    }

    private function getStages(){
        return DB::table('stages')->get();
    }
}
