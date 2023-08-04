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
use DateTime;
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
        return view('admin.schedules.index', compact('services', 'schedules'));
    }
    public function list(Request $request)
    {
         $service_id = $request->service_id;
         if (!$request->service_id) {
           $service = OccasionEvent::where('company_id', auth()->user()->company->id)->first();
           $service_id = $service ? $service->id : null;
         }

        if ($request->ajax()) {
            $response = $this->fetchData($service_id,$request->start,$request->end);
            return response()->json($response);
        }
        $servicesObj = OccasionEvent::where('company_id', auth()->user()->company->id);
        if($service_id) {
            $servicesObj->where('id', $service_id);
        }
       $services = $servicesObj->orderBy('id', 'DESC')->get();

        return view('admin.schedules.manage', compact('services'));
    }
    public function updateSchedule(Request $request)
    {
        $data = $request->all();
        $start = Carbon::today()->startOfMonth();
        $end = Carbon::today()->endOfMonth();
        if(isset($data['month'])) {
            $inputMonth = $data['month'][0];
            $inputYear = $data['month'][1];
            $start = Carbon::parse("1 $inputMonth $inputYear")->startOfMonth();
            $end = Carbon::parse("1 $inputMonth $inputYear")->endOfMonth();
        }
        $startFormatted = $start->format('Y-m-d');
        $endFormatted = $end->format('Y-m-d');
        $date = $start;
        $dates = [];
        /**
         * Request Type:
         * 1 - Block all weekends (sat-sun only) (update to fri-sat)
         * 2 - Block all days
         * 3 - Unblock all days
         * 4 - Clear blocked
         */
        $response = [];
        if ($request->type == 1) {
            while ($date <= $end) {
                if ($date->isFriday() || $date->isSaturday()) {
                    $dates[] = [
                        'old_format' => $date->format('d/m/Y'),
                        'new_format' => $date->format('Y-m-d')
                    ];
                }
                $date->addDays(1);
            }
        } else if ($request->type == 2 || $request->type == 3) {
            while ($date <= $end) {
                $dates[] = [
                    'old_format' => $date->format('d/m/Y'),
                    'new_format' => $date->format('Y-m-d')
                ];
                $date->addDays(1);
            }
        } else if ($request->type == 4) {
            AvailableDates::where('company_id', auth()->user()->company->id)
            ->where('service_id', $request->service_id)
            ->whereBetween('date', [$start->format('d/m/Y'), $end->format('d/m/Y')])
            ->delete();
        } else if ($request->date) {
            $existingDate = AvailableDates::where('company_id', auth()->user()->company->id)->where('date', $request->date)->where('service_id', $request->service_id)->first();
            if ($existingDate) {
                $existingDate->status = $existingDate->status == 1 ? 2 : ($existingDate->status == 2 ? 0 : 1);
                $existingDate->save();
            } else {
                // $service = OccasionEvent::where('company_id', auth()->user()->company->id)->orderBy('id', 'DESC')->first();
                $avail = new AvailableDates();
                $selectedDate = Carbon::createFromFormat('d/m/Y',  $request->date);
                $avail->date = $request->date;
                $avail->date_obj =  $selectedDate->format('Y-m-d');
                $avail->service_id = $request->service_id;
                $avail->company_id = auth()->user()->company->id;
                $avail->status = 1;
                $avail->save();
            }
            $response = $this->fetchData($request->service_id,$startFormatted,$endFormatted);
            return response()->json($response);
        }

        // AvailableDates::whereBetween('date', [$start->format('d/m/Y'), $end->format('d/m/Y')])->where('company_id', auth()->user()->company->id)->where('service_id', $request->service_id)->get();
        $services = OccasionEvent::where('company_id', auth()->user()->company->id)->where('id', $request->service_id)->orderBy('id', 'DESC')->get();
        foreach ($services as $service) {
            foreach ($dates as $date) {
                $avail = new AvailableDates();
                $avail->date = $date['old_format'];
                $avail->date_obj =  $date['new_format'];
                $avail->service_id = $request->service_id;
                $avail->company_id = auth()->user()->company->id;
                $avail->status = $request->type == 2 ? 1 : 2;
                $avail->save();
            }
        }
        $response = $this->fetchData($request->service_id,$startFormatted,$endFormatted);
        return response()->json($response);
    }

    public function fetchData($service_id,$start,$end) {
        $response = [];
        $data = AvailableDates::whereDate('date_obj', '>=', $start)
            ->whereDate('date_obj',   '<=', $end)
            ->where('company_id', auth()->user()->company->id)
            ->where('service_id', $service_id)
            ->get();

        foreach ($data as $event) {
            if ($event->status != 0) {
                $response[] = [
                    'id' => $event->id,
                    'title' => $event->service->name,
                    'start' => date('Y-m-d', strtotime($event->date_obj)),
                    'end' => date('Y-m-d', strtotime($event->date_obj)),
                    'overlap' => false,
                    'rendering' => 'background',
                    'color' => $event->status == 1 ? '#198754 !important' : ($event->status == 2 ? '#dc3545 !important' : ''), #FF0000' // #25b900 // green,
                ];
            }
        }
        return $response;
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

    public function deleteSchedule(Request $request)
    {
        $data = $request->all();
        Schedule::where('id', $data['id'])->delete();
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
