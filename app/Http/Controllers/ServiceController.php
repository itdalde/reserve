<?php

namespace App\Http\Controllers;

use App\Interfaces\ServiceInterface;
use App\Models\AvailableDates;
use App\Models\EventImages;
use App\Models\Occasion;
use App\Models\OccasionEvent;
use App\Models\OccasionEventAddon;
use App\Models\OccasionEventPrice;
use App\Models\OccasionEventReviews;
use App\Models\OccasionEventsPivot;
use App\Models\OccasionType;
use App\Models\PlanType;
use App\Models\ServiceType;
use App\Models\Feature;
use App\Models\Condition;
use Carbon\Carbon;
use Google\Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;    

class ServiceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = OccasionEvent::where('company_id', auth()->user()->company->id)->orderBy('id', 'DESC')->get();
        $occasionTypes = Occasion::all()->toArray();
        $plan = PlanType::all()->toArray();
        return view('admin.services.index', compact('occasionTypes', 'plan', 'services'));
    }

    public function servicesRemoveImage(Request $request) {
        $data = $request->all();
        $image = str_replace( asset(''),'',$data['image_url']);
        EventImages::where('image', $image)->delete();
        echo json_encode(['message' => 'success']);
    }

    public function updateService(Request $request)
    {
        try {
            $data = $request->all();
            $service = OccasionEvent::where('id',$data['id'])->first();
            if ($request->file('service_gallery')) {
                $file = $request->file('service_gallery');
                $filename = $this->uploadImage($file, $service);
                $service->image = $filename;
            }

            $service->name = $data['service_name'];
            $service->description = $data['service_description'];
            $service->address_1 = $data['service_location'];
            $service->max_capacity = $data['max_capacity'];
            $service->min_capacity = $data['min_capacity'];
            $service->availability_slot = $data['available_slot'];
            $data['start_available_time'] ? $service->availability_time_in = $data['start_available_time'] : '';
            $data['end_available_time'] ? $service->availability_time_out = $data['end_available_time'] : '';
            AvailableDates::where('service_id',$data['id'])->delete();
            $availableDates = explode(',',$data['available_date']);
            $unavailableDates = explode(',',$data['un_available_date']);
            foreach ($availableDates as $availableDate) {
                $avail = new AvailableDates();
                $avail->date = $availableDate;
                $avail->service_id = $data['id'];
                $avail->company_id = auth()->user()->company->id;
                $avail->status = 1;
                $avail->save();
            }
            foreach ($unavailableDates as $availableDate) {
                $avail = new AvailableDates();
                $avail->date = $availableDate;
                $avail->service_id = $data['id'];
                $avail->company_id = auth()->user()->company->id;
                $avail->status = 0;
                $avail->save();
            }
            if ($request->file('images')) {
                foreach ($request->file('images') as $file) {
                    $this->uploadImage($file, $service);
                }
            }
            $service->save();
            if(isset($data['price']) && $data['price']) {
                foreach ($data['price'] as  $price) {

                    foreach ($price as $k => $p) {
                        $pri = OccasionEventPrice::where('id',$k)->first();
                        $pri->service_price = $p;
                        $pri->package_price = $p;
                        $pri->save();
                        continue;
                    }
                }
            }
//
//            foreach ($data['add_on_name'] as $k => $name) {
//                if ($name) {
//                    $occasionEventAddon = OccasionEventAddon::where('id',$data['add_on_id'])->first();
//                    $occasionEventAddon->name = $name;
//                    $occasionEventAddon->price = $data['add_on_price'][$k] ?? 0;
//                    $occasionEventAddon->description = $data['add_on_description'][$k] ?? '';
//                    $occasionEventAddon->save();
//                }
//            }

            return redirect()->back()->with(['message' => 'Service Updated Successfully']);
        }catch (Exception $exception) {

        }
    }

    public function reviews(Request $request)
    {

        try {
            $id = $request->all()['occasion_event_id'];
            $sort = $request->all()['sort'] ?? 'DESC';
            $services = OccasionEventReviews::where('occasion_event_id', $id)->with('user', 'occasionEvent')
                ->orderBy('rate', $sort)->get()->toArray();
            usort($services, function ($a, $b) {
                return $a['rate'] <=> $b['rate'];
            });
            if ($sort != 'DESC') {
                $services = array_reverse($services);
            }
            $response = [];
            foreach ($services as $service) {
                $html = '';
                $companyId = $service["occasion_event"]["company_id"];
                $rate1 = $service['rate'] >= 1 ? 'checked' : "";
                $rate2 = $service['rate'] >= 2 ? 'checked' : "";
                $rate3 = $service['rate'] >= 3 ? 'checked' : "";
                $rate4 = $service['rate'] >= 4 ? 'checked' : "";
                $rate5 = $service['rate'] >= 5 ? 'checked' : "";
                $noImage = asset('images/no-image.jpg');
                $html .= '<div class="d-flex flex-column bd-highlight mb-3">';
                $html .= '<div class="p-2 bd-highlight  d-inline-flex"><img src="' . asset("images/company/$companyId/profile/") . $service['user']['profile_picture'] . '" alt="..." onerror="this.onerror=null; this.src=' . $noImage . '"> <p class="px-2">' . $service['user']['first_name'] . " " . $service['user']['last_name'] . '</p></div>';
                $html .= '<div class="p-2 bd-highlight d-inline-flex">';
                $html .= '<span class="bi bi-star ' . $rate1 . '"></span> ';
                $html .= '<span class="bi bi-star ' . $rate2 . '"></span>';
                $html .= '<span class="bi bi-star ' . $rate3 . '"></span>';
                $html .= '<span class="bi bi-star ' . $rate4 . '"></span>';
                $html .= '<span class="bi bi-star ' . $rate5 . '"></span>';
                $html .= '<span class="px-2"><h4>' . $service['title'] . '</h4></span>';
                $html .= '</div>';
                $html .= '<div class="p-2 bd-highlight"  dir="auto">' . $service['description'] . '</div></div>';
                $response[] = [
                    'rate' => $html,
                ];
            }
            echo json_encode($response);
            die;
        } catch (\Exception $exception) {
            $response = array(
                "draw" => 1,
                "iTotalRecords" => 0,
                "iTotalDisplayRecords" => 0,
                "aaData" => [],
                "error" => $exception->getMessage(),
            );
            return new JsonResponse($response);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if (
            Auth::user()->company->logo == null || 
            Auth::user()->company->phone_number == null ||
            Auth::user()->company->open_at == null || 
            Auth::user()->company->close_at == null
        ) {
            return view('admin.settings.index');
        }
        $hasServiceType  = auth()->user()->company && auth()->user()->company->service_type_id ? true : false;
        return view('admin.services.create',compact('hasServiceType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $company = $request->user()->company;
        $service = new OccasionEvent();
        $service->company_id = $company->id;
        $service->name = $data['service_name'];
        $service->name_arabic = $data['locale'] == 'ar' ? $data['service_name_arabic'] : '-';
        $service->occasion_type = 0;
        $service->price = $data['service_price'];
        $service->description = $data['service_description'];
        $service->description_arabic = $data['locale'] == 'ar
        ' ? $data['service_description_arabic'] : '-';
        $service->address_1 = $data['location'] ?? '';
        $service->max_capacity = $data['max_capacity'] ?? 0;
        $service->min_capacity = $data['min_capacity'] ?? 0;
        $service->availability_slot = $data['available_slot'] ?? 0;
        /**
         * Commented for now;
         */
        // $availabilityTimeIn = date('H:i',strtotime($data['start_available_time']));
        // $availabilityTimeOut = date('H:i',strtotime($data['end_available_time']));
        $service->availability_time_in = $availabilityTimeIn ?? date('H:i');
        $service->availability_time_out = $availabilityTimeOut ?? date('H:i');

        $service->duration = $data['not_applicable'] != 'not-applicable' ? $data['not_applicable'] : 0;

        $availableDates = date('Y-m-d H:i:s');// explode(',',$data['start_available_date']);
        $unavailableDates = date('Y-m-d H:i:s');// explode(',',$data['end_available_time']);
        $service->availability_start_date =  date('Y-m-d H:i:s');
        $service->availability_end_date = date('Y-m-d H:i:s');;
        $service->active = 3;
        $service->service_type = $company->service_type_id;
        $service->locale = $data['locale'] ?? 'en';
        $service->save();
        foreach ([$availableDates] as $availableDate) {
            $avail = new AvailableDates();
            $avail->date = $availableDate;
            $avail->service_id = $service->id;
            $avail->company_id = auth()->user()->company->id;
            $avail->status = 1;
            $avail->save();
        }
        foreach ([$unavailableDates] as $availableDate) {
            $avail = new AvailableDates();
            $avail->date = $availableDate;
            $avail->service_id = $service->id;
            $avail->company_id = auth()->user()->company->id;
            $avail->status = 0;
            $avail->save();
        }
        if ($request->file('images')) {
            foreach ($request->file('images') as $file) {
                $this->uploadImage($file, $service);
            }
        }
        if ($request->file('service_gallery')) {
            $file = $request->file('service_gallery');
            $filename = $this->uploadImage($file, $service);
            $service = OccasionEvent::where('id',$service->id)->first();
            $service->image = $filename;
            $service->save();
        }
        $price = new OccasionEventPrice();
        $price->occasion_event_id = $service->id;
        $price->plan_id = $data['plan_id'] ?? 1;
        $price->service_price = $data['service_price'];
        $price->package = $data['plan_id'] == 1 ? 'Per Guest' : 'Per Package'; // $data['package_name'] ?? 'Per person';
        $price->min_capacity = $data['package_min_capacity'] ?? 0;
        $price->max_capacity = $data['package_max_capacity'] ?? 0;
        $price->package_details = $data['package_details'] ?? '-';
        $price->package_price = $data['service_price'];
        $price->active = 1;
        $price->save();

        foreach ($data['feature'] as $k => $name) {
            if ($name) {
                $feat = new Feature();
                $feat->name = $name;
                $feat->service_id = $service->id;
                $feat->save();
            }
        }

        foreach ($data['condition'] as $k => $name) {
            if ($name) {
                $condt = new Condition();
                $condt->name = $name;
                $condt->service_id = $service->id;
                $condt->save();
            }
        }

        foreach ($data['add_on_name'] as $k => $name) {
            if ($name) {
                $occasionEventAddon = new OccasionEventAddon();
                $occasionEventAddon->occasion_event_id = $service->id;
                $occasionEventAddon->name = $name;
                $occasionEventAddon->price = $data['add_on_price'][$k] ?? 0;
                $occasionEventAddon->description = $data['add_on_description'][$k] ?? '';
                $occasionEventAddon->save();
            }
        }

        return redirect()->route('services.index')->with(['message' => 'Service Saved Successfully']);
    }

    public function uploadImage($file, $service, $isFeatured = 0)
    {
        $company = auth()->user()->company;
        $image = new EventImages();
        $imageName = time() . '.' . $file->extension();
        $file->move(public_path("images/company/{$company->id}/services"), $imageName);
        $filename = "images/company/{$company->id}/services/{$imageName}";
        $image->image = $filename;
        $image->is_featured = $isFeatured;
        $image->occasion_event_id = $service->id;
        $image->save();
        return $filename;
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
        $service = OccasionEvent::where('id', $id)->first();
        $locale = $service->locale;
        return view('admin.services.edit', compact('service', 'locale'));
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
        $service = OccasionEvent::where('id',$id)->first();
        $data = $request->all();
        $service->name = $data['service_name'];
        $service->name_arabic = $data['locale'] == 'ar' ? $data['service_name_arabic'] : '-';
        $service->occasion_type = 0;
        $service->price = $data['service_price'];
        $service->description = $data['service_description'];
        $service->description_arabic = $data['locale'] == 'ar
        ' ? $data['service_description_arabic'] : '-';
        $service->address_1 = $data['location'] ?? '';
        $service->max_capacity = $data['max_capacity'] ?? 0;
        $service->min_capacity = $data['min_capacity'] ?? 0;
        $service->availability_slot = $data['available_slot'] ?? 0;
      
        $service->availability_time_in = $availabilityTimeIn ?? date('H:i');
        $service->availability_time_out = $availabilityTimeOut ?? date('H:i');

        $service->duration = $data['not_applicable'] != 'not-applicable' ? $data['not_applicable'] : 0;

        $availableDates = date('Y-m-d H:i:s');// explode(',',$data['start_available_date']);
        $unavailableDates = date('Y-m-d H:i:s');// explode(',',$data['end_available_time']);
        $service->availability_start_date =  date('Y-m-d H:i:s');
        $service->availability_end_date = date('Y-m-d H:i:s');;
        $service->locale = $data['locale'] ?? 'en';
        $service->save();

        if ($request->file('images')) {
            foreach ($request->file('images') as $file) {
                $this->uploadImage($file, $service);
            }
        }
        if ($request->file('service_gallery')) {
            $file = $request->file('service_gallery');
            $filename = $this->uploadImage($file, $service);
            $service = OccasionEvent::where('id',$service->id)->first();
            $service->image = $filename;
            $service->save();
        }

        $price = OccasionEventPrice::where('plan_id', $service->paymentPlan->plan_id)->first();
        $price->occasion_event_id = $service->id;
        $price->plan_id = $data['plan_id'] ?? 1;
        $price->service_price = $data['service_price'];
        $price->package = $data['package_name'] ?? 'Per person';
        $price->min_capacity = $data['package_min_capacity'] ?? 0;
        $price->max_capacity = $data['package_max_capacity'] ?? 0;
        $price->package_details = $data['package_details'] ?? '-';
        $price->package_price = $data['service_price'];
        $price->active = 1;
        $price->save();

        Feature::where('service_id', $service->id)->delete();
        foreach($data['feature'] as $key => $name) {
            if ($name) {
                $feat = new Feature();
                $feat->name = $name;
                $feat->service_id = $service->id;
                $feat->save();
            }
        }
        Condition::where('service_id', $service->id)->delete();
        foreach ($data['condition'] as $k => $name) {
            if ($name) {
                $condt = new Condition();
                $condt->name = $name;
                $condt->service_id = $service->id;
                $condt->save();
            }
        }
        OccasionEventAddon::where('occasion_event_id', $service->id)->delete();
        foreach ($data['add_on_name'] as $k => $name) {
            if ($name) {
                $occasionEventAddon = new OccasionEventAddon();
                $occasionEventAddon->occasion_event_id = $service->id;
                $occasionEventAddon->name = $name;
                $occasionEventAddon->price = $data['add_on_price'][$k] ?? 0;
                $occasionEventAddon->description = $data['add_on_description'][$k] ?? '';
                $occasionEventAddon->save();
            }
        }
        
        return redirect()->route('services.index')->with(['message' => 'Service Updated Successfully']);
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

    public function deleteService(Request $request) {
        $event = OccasionEvent::where('id', $request->service_id)->first();
        $event->active = 0; // inactive
        $event->deleted_at = Carbon::now();
        $event->save();

        Http::timeout(10)
            ->withOptions(['verify' => false])
            ->post('http://reservegcc.com:3000/alert', [
                'transaction' => $event,
                'status' => 'Deactivated'
            ]);
        return redirect()->back()->with('success', 'Service is deleted');
    }

    public function publishService(Request $request) {
        $exist = AvailableDates::where('company_id', auth()->user()->company->id)->where('service_id', $request->service_id)->first();
        if (!$exist) {
            return redirect()->back()->with('success', 'Please set your availability dates first.');
        }
        $event = OccasionEvent::where('id', $request->service_id)->first();
        $event->active = 1; // publish
        $event->save();
        Http::timeout(10)
            ->withOptions(['verify' => false])
            ->post('http://reservegcc.com:3000/alert', [
                'transaction' => $event,
                'status' => 'Published'
            ]);
        return redirect()->back()->with('success', 'Service is published');
    }

    public function pausedService(Request $request) {
        $event = OccasionEvent::where('id', $request->service_id)->first();
        $event->active = 2; // paused
        $event->save();
        Http::timeout(10)
            ->withOptions(['verify' => false])
            ->post('http://reservegcc.com:3000/alert', [
                'transaction' => $event,
                'status' => 'Paused'
            ]);
        return redirect()->back()->with('success', 'Service is paused');
    }

    public function resumeService(Request $request) {
        $event = OccasionEvent::where('id', $request->service_id)->first();
        $event->active = 1; // resume
        $event->save();
        Http::timeout(10)
            ->withOptions(['verify' => false])
            ->post('http://reservegcc.com:3000/alert', [
                'transaction' => $event,
                'status' => 'Resumed'
            ]);
        return redirect()->back()->with('success', 'Service is resumed');
    }

    public function deleteEventImage(Request $request) {

        EventImages::where('id', $request->id)->delete();
        return json_encode('Service Image Deleted');
    }
}
