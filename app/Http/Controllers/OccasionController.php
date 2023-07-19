<?php

namespace App\Http\Controllers;

use App\Interfaces\OccasionInterface;
use App\Models\Auth\User\User;
use App\Models\Company;
use App\Models\InquiryReplyImage;
use App\Models\Occasion;
use App\Models\OccasionEvent;
use App\Models\OccasionServiceTypePivot;
use App\Models\ServiceType;
use Google\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OccasionController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->search) {
            $occasions = Occasion::where('name','like','%'.$request->search.'%')
                ->with('occasionEvents','occasionEventsReviews','transactions','transactions.user','transactions.status','transactions.plan')
                ->get()->toArray();
        } else {
            $occasions = Occasion::all()
                ->with('occasionEvents','occasionEventsReviews','transactions','transactions.user','transactions.status','transactions.plan')
                ->toArray();
        }
        if ($request->expectsJson()) {
            return response()->json([
                "status"    => "success" ,
                "response"  => [
                    "data"  => $occasions
                ]
            ]);
        }
    }

    public function occasionsServicesList(Request $request) {

        $occasions = Occasion::where('active',1)->with(  'serviceTypes')->get()->toArray();
        $occasionNames = [];
        foreach ($occasions as $occasion) {
            $occasionNames[] = $occasion['name'];
        }
        $occasionNames = json_encode($occasionNames);
        $serviceTypes = ServiceType::where('active',1)->get();
        return view('admin.occasion.index',compact('occasionNames','occasions','serviceTypes'));

    }
    public function occasionsServicesEdit(Request $request) {
        $id = $request->id;
        $typesAssigned =[];
        $serviceNames = [];
        $occasion = Occasion::where('id',$id)->with( 'serviceTypes','serviceTypes.serviceType','serviceTypes.vendors')->first()->toArray();
        foreach ($occasion['service_types'] as $k => $serviceType) {
            $companies = Company::where('service_type_id',$serviceType['service_type_id'])->get()->toArray();
            $companyNames = [];
            foreach ($companies as $company) {
                $companyNames[] = $company['name'].'+:+'.$company['user_id'];
            }
            $occasion['service_types'][$k]['vendors'] = OccasionEvent::where('service_type',$serviceType['service_type_id'])->get()->toArray();
            $occasion['service_types'][$k]['company_count'] = count($companies);
            $occasion['service_types'][$k]['providers'] = $companies;
            $occasion['service_types'][$k]['providers_name'] =  json_encode($companyNames);
            $typesAssigned[] = $serviceType['service_type_id'];
        }
        $serviceTypes = ServiceType::get();

        foreach ($serviceTypes as $serviceType) {
            $serviceNames[] = $serviceType->name;
        }
        $serviceNames = json_encode($serviceNames);

        return view('admin.occasion.edit',compact('serviceNames','typesAssigned','occasion','serviceTypes'));
    }

    public function occasionsServicesUnAssign(Request $request) {
        $data = $request->all();
        $user = User::where('id', $data['user_id'])->first();
        if($user && $user->company  ) {
            $company = $user->company;
            $company->service_type_id = 0;
            $company->save();
            OccasionServiceTypePivot::where('company_id',$user->company->id)->delete();
        }
        return redirect()->back()->with('success', 'Occassion Added Successful');
    }

    public function occasionsServicesTypeAssign(Request $request) {

        $data = $request->all();
        if($data['services']) {
            foreach ($data['services'] as $service) {
                $serviceTypePivot = new OccasionServiceTypePivot();
                $serviceTypePivot->occasion_id = $data['occasion_id'];
                $serviceTypePivot->service_type_id = $service;
                $serviceTypePivot->save();
            }
        }
        return redirect()->back()->with('success', 'Occassion Updated Successful');
    }
    public function occasionsServicesAssign(Request $request) {
        $data = $request->all();
        $user = User::where('id', $data['user_id'])->first();
        $serviceTypePivot = new OccasionServiceTypePivot();
        $serviceTypePivot->occasion_id = 0;
        $serviceTypePivot->service_type_id = $data['service_type'];
        $serviceTypePivot->company_id = $user->company ? $user->company->id : 0;
        $serviceTypePivot->save();
        $company = $user ? $user->company : null;
        if($company) {
            $company->service_type_id = $data['service_type'];
            $company->save();
        }
        if($user && $user->company && $user->company->services  ) {
            foreach ($user->company->services as $service) {
                $service->service_type = $data['service_type'];
                $service->save();
            }
        }
        return redirect()->back()->with('success', 'Occassion Added Successful');
    }
    public function occasionsServicesStore(Request $request) {
        $data = $request->all();
        $occasion = new Occasion();
        $occasion->name = $data['name'];
        $occasion->active = 1;
        $occasion->save();
        if($data['services']) {
            foreach ($data['services'] as $service) {
                $serviceTypePivot = new OccasionServiceTypePivot();
                $serviceTypePivot->occasion_id = $occasion->id;
                $serviceTypePivot->service_type_id = $service;
                $serviceTypePivot->save();
            }
        }
        return redirect()->back()->with('success', 'Occassion Added Successful');
    }
    public function occasionsServicesTypeStore(Request $request) {
        $data = $request->all();
        $serviceType = new ServiceType();
        $serviceType->name = $data['name'];
        $serviceType->active = 1;
        $serviceType->save();

        $serviceTypePivot = new OccasionServiceTypePivot();
        $serviceTypePivot->occasion_id = $data['occasion_id'];
        $serviceTypePivot->service_type_id = $serviceType->id;
        $serviceTypePivot->save();
        return redirect()->back()->with('success', 'Service Added Successful');
    }

    public function occasionsServicesRemove(Request $request) {
        $id = $request->id;
        Occasion::where('id',$id)->delete();
        OccasionServiceTypePivot::where('occasion_id',$id)->delete();
        return redirect()->back()->with('success', 'Occassion Deleted Successful');
    }
    public function occasionsServicesTypeRemove(Request $request) {
        $id = $request->id;
//        ServiceType::where('id',$id)->delete();
        OccasionServiceTypePivot::where('service_type_id',$id)->delete();
        return redirect()->back()->with('success', 'Service Deleted Successful');
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

    public function assignServices(Request $request) {
        $data = $request->all();
        if(isset($data['services'])) {
            $transaction = [];
            foreach ($data['services'] as $service) {
                $service =  OccasionEvent::where('id',$service)->first();
                if($service) {
                    $service->occasion_type = $data['id'];
                    $service->save();
                    $transaction[] = $service->toArray();
                }
            }
            Http::timeout(10)
                ->withOptions(['verify' => false])
                ->post('http://reservegcc.com:3000/alert', [
                    'transaction' => $transaction,
                    'status' => 'Assigned'
                ]);
        }
        return redirect()->back()->with('success', 'Occasion Assignment Successful');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $occasion = new Occasion();
        $occasion->name = $data['title'];
        $occasion->active = isset($data['active']) ? 1 : 0;
        if ($request->file('featured_image')) {
            $imageName = time() . '.' . $request->file('featured_image')->extension();
            $request->file('featured_image')->move(public_path("assets/images/occasions"), $imageName);
            $filename = "assets/images/occasions/{$imageName}";
            $occasion->logo = $filename;
        }
        $occasion->save();
        return redirect()->back()->with('success', 'Occasion Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Occasion  $occasion
     * @return \Illuminate\Http\Response
     */
    public function show(Occasion $occasion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Occasion  $occasion
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        try {
            $data = $request->all();
            $occasion = Occasion::where('id',$data['id'])->first();
            $occasion->name = $data['title'];
            $occasion->active = isset($data['active']) ? 1 : 0;
            if ($request->file('image')) {
                $imageName = time() . '.' . $request->file('image')->extension();
                $request->file('image')->move(public_path("assets/images/occasions"), $imageName);
                $filename = "assets/images/occasions/{$imageName}";
                $occasion->logo = $filename;
            }
            $occasion->save();
            return redirect()->back()->with('success', 'Occasion Updated Successfully');
        } catch (Exception $exception) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Occasion  $occasion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Occasion $occasion)
    {
        //
    }

    public function activateDeactivate(Request $request)
    {
        $data = $request->all();
        $occasion = Occasion::where('id',$data['id'])->first();
        $occasion->active = $data['active'] == 1 ? 0 : 1;
        $occasion->save();
        return redirect()->back()->with('success', 'Occasion Updated Successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Occasion  $occasion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Occasion $occasion)
    {
        //
    }
}
