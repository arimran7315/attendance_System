<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function reportAll( Request $request){
        
$user = User::select('name','email', 'id')->whereRole('student')->get();
       $attendance = Attendance::select('user_id','status','created_at')->whereBetween('created_at',[$request->Datefrom,$request->Dateto])->get();
       $from = $request->Datefrom;
       $to = $request->Dateto;
        return view('reportAll',compact(['user','attendance','from','to']));
        // return $attendance;
    }
    public function report(Request $request){
        $id = $request->id;
        $user = User::with(['attendances' => function ($query) use ($request) {
    $query->whereBetween('created_at', [$request->Datefrom, $request->Dateto]);
}])->find($id);

        return view('report', compact('user'));
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $date = date('Y-m-d'); // Using only date for the query
        $userId = Auth::user()->id;
        // Check if the attendance record exists for the specific user and date

        $status = Attendance::select('id', 'status')->where('user_id', $userId)
            ->whereDate('created_at', $date)->first();
        if ($status) {
            return view('index', compact('status'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $date = date('Y-m-d'); // Using only date for the query
        $userId = Auth::user()->id;
        // Check if the attendance record exists for the specific user and date
        $status = Attendance::where('user_id', $userId)
            ->whereDate('created_at', $date)
            ->exists();
        if ($status == 0) {
            if ($request->attendance == 'p') {
                $attendance = Attendance::create([
                    'user_id' => $userId,
                    'status' => 1
                ]);
            }
            if ($request->attendance == 'l') {
                $attendance = Attendance::create([
                    'user_id' => $userId,
                    'status' => 2
                ]);
            }
            return redirect()->route('attendance.index');
        } else {

            return redirect()->route('attendance.index');
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Fetch the user with their attendances
        $user = User::with('attendances')->find($id);

        // Check if the user exists
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        // Return the user and their attendances
        return view('viewAttendance', compact('user'));
    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::with('attendances')->find($id);
        return view('editAttendance',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       // Validate the request data
    $request->validate([
        'status' => 'required|integer',
    ]);

    // Find the attendance record by ID
    $attendance = Attendance::findOrFail($id);

    // Update the status field
    $attendance->status = $request->status;
    $attendance->save();

    // Redirect back with a success message
    return redirect()->back()->with('success', 'Attendance status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $attendance = Attendance::find($id)->delete();
        return redirect()->back()->with('success', 'Attendance status updated successfully.');
    }
}
