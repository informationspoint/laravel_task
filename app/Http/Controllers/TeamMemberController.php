<?php

namespace App\Http\Controllers;

use App\Models\MortageVolumn;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeamMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($month = null)
    {   
        $teamMembers = TeamMember::with('mortageVolumns')->paginate(2);
        $mortageVolumnTop = DB::select('select team_member_id, full_name, month(month) as month, sum(amount) as total_amount from mortage_volumns INNER JOIN team_members as team ON mortage_volumns.team_member_id=team.id group by team_member_id,month(month),team.full_name order by total_amount desc limit 5');
        $mortageVolumnDates = DB::select("select month from mortage_volumns GROUP BY month");
         return view('welcome',['teamMembers' => $teamMembers, 'mortageVolumnTop' => $mortageVolumnTop,'mortageVolumnDates' => $mortageVolumnDates,'monthwise' => '']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request,[
         'email'=>'unique:team_members',
       ]);

        $teamMember = TeamMember::create([
            'full_name' => $request['full_name'],
            'email' => $request['email']
        ]);
        
        if($request['mortageDate'] && $request['mortageVolumn']){
            $mortageData = [];
            foreach($request['mortageDate'] as $index => $date){
                $requestData = [
                    'month' => $date,
                    'amount' => $request['mortageVolumn'][$index],
                    'team_member_id' => $teamMember['id']
                ];
                array_push($mortageData, $requestData);
            }
            MortageVolumn::insert($mortageData);
        }
        return redirect()->back()->with('success', 'Team Member Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $teamMember = TeamMember::with('mortageVolumns')->where('id',$id)->first();
        return response()->json($teamMember);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function updateTeamMember(Request $request)
    {
        $teamMember = TeamMember::where('id', $request['team_member_id'])->update([
            'full_name' => $request['full_name'],
            'email' => $request['email']
        ]);
        MortageVolumn::where('team_member_id',$request['team_member_id'])->delete();
        if($request['mortageDate'] && $request['mortageVolumn']){
            $mortageData = [];
            foreach($request['mortageDate'] as $index => $date){
                $requestData = [
                    'month' => $date,
                    'amount' => $request['mortageVolumn'][$index],
                    'team_member_id' => $request['team_member_id']
                ];
                array_push($mortageData, $requestData);
            }
            MortageVolumn::insert($mortageData);
        }
        return redirect()->back()->with('success', 'Team Member Update Successfully');
    }

      public function getMonthlyStats(Request $request)
    {
        $teamMembers = TeamMember::with('mortageVolumns')->paginate(10);
        $mortageVolumnTop = DB::select("select mortage_volumns.month,sum(mortage_volumns.amount) as total_amount,team_members.full_name from team_members,mortage_volumns  WHERE mortage_volumns.team_member_id = team_members.id 
     AND mortage_volumns.month='".$request->month."' GROUP BY mortage_volumns.team_member_id order by total_amount desc limit 5
        ");
        $mortageVolumnDates = DB::select("select month from mortage_volumns GROUP BY month");
         return view('welcome',['teamMembers' => $teamMembers, 'mortageVolumnTop' => $mortageVolumnTop,'mortageVolumnDates' => $mortageVolumnDates,'monthwise' => $request->month]);
    }
}
