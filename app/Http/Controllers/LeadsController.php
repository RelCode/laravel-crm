<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Leads;
use App\Models\Notes;
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
            ->where('deleted_at',null)
            ->join('stages','leads.stage','stages.id')
            ->join('users','leads.owner','users.id')
            ->select('leads.*','stages.stage as current_stage','users.name as creator')
            ->orderBy('leads.created_at','desc')
            ->paginate(5);
        return view('leads.list',['leads' => $leads]);
    }
    
    public function create(){
        return view('leads.create');
    }

    public function store(Request $request){
        $this->validate($request,[
            'names' => 'required',
            'profession' => 'required',
            'email' => 'required|email|unique:leads,email'
        ]);

        //

        $lead = new Leads;
        $lead->id = date('ymd') . '_' . substr(uniqid(),6);
        $lead->names = $request->names;
        $lead->profession = $request->profession;
        $lead->email = $request->email;
        $lead->phone = $request->phone;
        $lead->owner = auth()->user()->id;
        if($lead->save()){
            Alert::success('done','new lead created');
            return back();
        }
        Alert::error('failed','error occured. try again or contact admin');
        return back();
    }

    public function edit($id){
        $lead = DB::table('leads')
            ->where('leads.owner', auth()->user()->id)
            ->where('leads.id', $id)
            ->join('stages', 'leads.stage', 'stages.id')
            ->join('users', 'leads.owner', 'users.id')
            ->select('leads.*', 'stages.stage as current_stage', 'users.name as creator')
            ->get();
        return view('leads.edit',['lead' => $lead]);
    }

    public function update(Request $request, $id){
        //validate user input
        $this->validate($request, [
            'names' => 'required',
            'profession' => 'required',
            'email' => ['required','email',Rule::unique('leads')->ignore($id)],//the rule ensure the email does not belong to anyone if a different email has been inserted
        ]);
        $lead = Leads::find($id);
        //check if user with the ID submitted exists
        if($lead == null){
            Alert::warning('warning','action failed');
            return back();
        }
        //check if admin is updating a lead he/she owns
        if($lead->owner != auth()->user()->id){
            Alert::warning('error','you don\'t have privileges to perform this action');
            return back();
        }
        //update the 
        $lead->names = $request->names;
        $lead->profession = $request->profession;
        $lead->email = $request->email;
        $lead->phone = $request->phone;
        $lead->owner = auth()->user()->id;
        if ($lead->save()) {
            Alert::success('done', $lead->names . ' info was updated');
            return back();
        }
        Alert::error('failed', 'error occured. try again or contact admin');
        return back();
    }

    public function destroy(Request $request){
        $user = isset($_GET['userId']) ? htmlentities($_GET['userId'],ENT_QUOTES) : '';//get parameterized user id
        $token = isset($_GET['_token']) ? htmlentities($_GET['_token'],ENT_QUOTES) : '';//get parameterized session token
        if($user == '' || $token == ''){//check if the id & token are provided
            Alert::error('error','action failed');
            return back();
        }
        //check if the token matches the session
        if($token != session('_token')){
            Alert::error('error','invalid action');
            return back();
        }
        //check if the current user should be having this lead's ID
        $lead = DB::table('leads')
            ->where('id',$user)
            ->where('owner',auth()->user()->id)
            ->get();
        if($lead->count() == 0){
            Alert::warning('error','you don\'t have privileges to perform this action');
            return back();
        }
        //update soft delete
        $affected = DB::table('leads')
            ->where('id',$user)
            ->where('owner',auth()->user()->id)
            ->update(['deleted_at' => date('Y-m-d H:i:s')]);
        if($affected == 1){
            Alert::success('done',$lead[0]->names . ' is deleted from the system');
            return back();
        }
        Alert::error('error','action failed. try again');
        return back();
    }

    public function action($id){
        $lead = DB::table('leads')
            ->join('stages','leads.stage','stages.id')
            ->where('leads.id', $id)
            ->where('leads.owner', auth()->user()->id)
            ->where('leads.deleted_at',null)
            ->select('leads.*','stages.stage as current_stage')
            ->get();
        if($lead->count() == 0){
            Alert::info('error','selected user does not exist');
            return back();
        }
        $notes = DB::table('notes')
            ->where('creator', auth()->user()->id)
            ->where('lead', $id)
            ->orderBy('created_at', 'desc')
            ->get();
        $stages = $this->getStages();
        return view('leads.action',['lead' => $lead[0],'notes' => $notes,'stages' => $stages]);
    }

    public function handle(Request $request, $id){
        if(isset($request->stage)){
            //handling stage update function
            $this->handleStageUpdate($request,$id);
            return back();
        }elseif(isset($request->notes)){
            //handling the note taking function
            $this->handleNotes($request,$id);
            return back();
        }elseif(isset($request->activity)){
            //handling scheduling an activity
            $this->handleActivity($request,$id);
            return back();
        }else{
            Alert::error('error','invalid action');
            return back();
        }
    }

    public function handleStageUpdate($request,$id){
        $stage = DB::table('stages')
            ->where('id',$request->stage)
            ->get();
        //check if the provided stage value exists
        if($stage->count() == 0){
            Alert::info('error','invalid stage selected');
            return false;
        }
        //check if the current user should be having this lead's ID
        $lead = DB::table('leads')
            ->where('id', $id)
            ->where('owner', auth()->user()->id)
            ->get();
        if ($lead->count() == 0) {
            Alert::warning('error', 'you don\'t have privileges to perform this action');
            return false;
        }
        //else update the lead
        $affected = DB::table('leads')
            ->where('id', $id)
            ->where('owner', auth()->user()->id)
            ->update(['stage' => $request->stage]);
        if ($affected == 1) {
            $this->saveNotes($id,'Lead Stage Changed','from <strong>' . $request->current . '</strong> to <strong>' . $request[(int)$request->stage] . '</strong>');
            Alert::success('done', $lead[0]->names . ' process stage has changed');
            return true;
        }
        Alert::error('error', 'action failed. try again');
        return false;
    }

    public function handleNotes($request,$id){
        //validate user input
        $this->validate($request,[
            'title' => 'required|max:128',
            'body' => 'required|max:512'
        ]);
        //check if the current user should be having this lead's ID
        $lead = DB::table('leads')
            ->where('id', $id)
            ->where('owner', auth()->user()->id)
            ->get();
        if ($lead->count() == 0) {
            Alert::warning('error', 'you don\'t have privileges to perform this action');
            return back();
        }
        $this->saveNotes($id,$request->title,$request->body);
    }

    public function handleActivity($request,$id){
        $this->validate($request,[
            'datetime' => 'required|date',
            'activity' => 'required'
        ]);
        if(date('Y-m-d H:i:s', strtotime($request->datetime)) < date('Y-m-d H:i:s')){
            Alert::warning('error','invalid time slot selected');
            return back();
        }
        //check if the current user should be having this lead's ID
        $lead = DB::table('leads')
            ->where('id', $id)
            ->where('owner', auth()->user()->id)
            ->get();
        if ($lead->count() == 0) {
            Alert::warning('error', 'you don\'t have privileges to perform this action');
            return back();
        }
        $schedule = DB::table('schedule')
            ->insert(['creator' => auth()->user()->id,'lead' => $id, 'activity' => $request->activity . ' at ' . $request->datetime]);
        if($schedule){
            $this->saveNotes($id,'Activity Scheduled','You have set: <strong>'.$request->activity.'</strong> for <strong>'.$request->datetime.'</strong>');
            Alert::success('done','you have created an activity to do with the lead');
        }else{
            Alert::error('error','action failed. try again');
        }
    }

    public function saveNotes($id,$title,$body){
        $note = new Notes();
        $note->creator = auth()->user()->id;
        $note->lead = htmlentities($id, ENT_QUOTES);
        $note->title = $title;
        $note->body = $body;
        if ($note->save()) {
            Alert::success('done', 'notes successfully added');
            return true;
        }
        Alert::error('error', 'action failed. try again');
        return false;
    }

    private function getStages(){
        return DB::table('stages')->get();
    }
}
