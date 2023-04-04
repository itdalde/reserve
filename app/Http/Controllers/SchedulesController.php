<?php

namespace App\Http\Controllers;

use App\Models\Auth\Role\Role;
use App\Models\Auth\User\User;
use App\Models\AvailableDates;
use App\Models\EventImages;
use App\Models\Occasion;
use App\Models\OccasionEvent;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Schedule;
use App\Models\ServiceType;
use App\Models\Status;
use App\Utility\NotificationUtility;
use Carbon\Carbon;
use Google\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class SchedulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $services = OccasionEvent::where('company_id', auth()->user()->company->id)->orderBy('id', 'DESC')->get();
        $schedules = Schedule::where('company_id', auth()->user()->company->id)->orderBy('id', 'DESC')->get();
        return view('admin.schedules.index',compact('services','schedules'));
    }
    public function list(Request $request)
    {
        if($request->ajax()) {
            $response = [];
            $data = AvailableDates::whereDate('date_obj', '>=', $request->start)
                ->whereDate('date_obj',   '<=', $request->end)->where('company_id', auth()->user()->company->id)
                ->get();
            foreach ($data as $datum) {
                $response[] = [
                    'id' => $datum->id,
                    'title' => $datum->service->name,
                    'start' => $datum->date_obj,
                    'end' => $datum->date_obj,
                ];
            }
            return response()->json($response);
        }
        return view('admin.schedules.manage');
    }
    public function updateSchedule(Request $request){
        $start = Carbon::today()->startOfMonth();
        $end = Carbon::today()->endOfMonth();
        $date = $start;
        $dates = [];
        if($request->type == 2) {
            while ($date <= $end) {
                if (! $date->isWeekend() ) {
                    $dates[] = [
                        'old_format' => $date->format('d/m/Y'),
                        'new_format' => $date->format('Y-m-d')
                    ];
                }
                $date->addDays(1);
            }
        } else {
            while ($date <= $end) {
                $dates[] = [
                    'old_format' => $date->format('d/m/Y'),
                    'new_format' => $date->format('Y-m-d')
                ];
                $date->addDays(1);
            }
        }
        $response = [];
        AvailableDates::where('company_id', auth()->user()->company->id)->delete();
        $services = OccasionEvent::where('company_id', auth()->user()->company->id)->orderBy('id', 'DESC')->get();
        foreach ($services as $service) {
            foreach ($dates as $date) {
                $avail = new AvailableDates();
                $avail->date = $date['old_format'];
                $avail->date_obj =  $date['new_format'];
                $avail->service_id = $service->id;
                $avail->company_id = auth()->user()->company->id;
                $avail->status = 1;
                $avail->save();
            }
        }
        return response()->json($response);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $company_id = auth()->user()->company->id;
            $schedule = new Schedule();
            $schedule->name = $data['name'];
            $schedule->description = $data['description'];
            $schedule->company_id = $company_id;
            $schedule->date = $data['date'];
            $schedule->save();
            return redirect()->back()->with('success', 'Schedule Added Successfully');
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    public function deleteSchedule(Request $request) {
        $data = $request->all();
        Schedule::where('id',$data['id'])->delete();
        return redirect()->route('schedules.index')->with('success', 'Schedule Removed Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
