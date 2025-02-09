<?php

namespace App\Http\Controllers\Company;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TeamMember;
use App\Http\Requests\Company\StoreTeamMemberRequest;
use App\Http\Requests\Company\UpdateTeamMemberRequest;
use Illuminate\Support\Facades\DB;
use App\Helpers\UploadFile;
class TeamMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members   = TeamMember::pluck('id');
        $MainTitle = 'Team Members';
        $SubTitle  = 'View';
        return view('Company._team_members.index',compact('MainTitle','SubTitle','members'));
    }
    /**
     * Display a listing of the resource in DT.
     */
    public function members()
    {
        $records = TeamMember::where('company_id',CompanyID())->get();
        return Datatables::of($records)->make(true);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $MainTitle = 'Team Members';
        $SubTitle = 'Add';
        return view('Company._team_members.create',compact('MainTitle','SubTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeamMemberRequest $request)
    {
        $input = $request->all();
        //upload new file
        if ($request->file('image'))
            $image =  UploadFile::UploadSinglelFile($request->file('image'),'CompanyTeamMembers');
        else
            $image = null;
        DB::beginTransaction();
        try {
        TeamMember::create([
            'image'         => $image,
            'company_id'    => $input['company_id'],
            'en'    => [
                      'name'    => $input['name_en'],
                      'title'   => $input['title_en'],
                      'alt'     => $input['alt_en']
                  ],
           'ar'     => [
                       'name'  =>  $input['name_ar'],
                       'title' => $input['title_ar'],
                       'alt'   => $input['alt_ar']
                  ],
        ]);
        DB::commit();
        session()->flash('_added','Member has been createed succssfuly');
        return redirect()->route('company.members.index');
        }catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
       
        $MainTitle  = 'Team Members';
        $SubTitle   = 'Edit';
        $member     = TeamMember::findOrFail($id); 
        if(CompanyID()==$member->company_id)
            return view('Company._team_members.edit',compact('MainTitle','SubTitle','member'));
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(UpdateTeamMemberRequest $request, $id)
    {
        $member = TeamMember::findOrFail($id);
        $input = $request->all();

        //upload new file
        if ($request->file('image'))
        {
            //Remove old file
            UploadFile::RemoveFile($member->image);
            $image =  UploadFile::UploadSinglelFile($request->file('image'),'CompanyTeamMembers');
        }
        else
            $image = $member->image;
        DB::beginTransaction();
        try {
            $member->image                  =  $image;
            $member->translate('en')->name  = $input['name_en'];
            $member->translate('ar')->name  = $input['name_ar'];  
            $member->translate('en')->title = $input['title_en'];
            $member->translate('ar')->title = $input['title_ar'];            
            $member->translate('en')->alt   = $input['alt_en'];            
            $member->translate('ar')->alt   = $input['alt_ar'];            
            $member->save();
        DB::commit();
        session()->flash('_updated','Member data has been updated succssfuly');
        return back();
        }catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
      
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $member  = TeamMember::findOrFail($id);
            //Remove old file
        if($member->image)
            UploadFile::RemoveFile($member->image);
        $member->delete();
        return response()->json(['success' => 'Data is successfully deleted']);
    }
}
