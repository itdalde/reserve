<?php

namespace App\Http\Controllers;

use App\Interfaces\ServiceInterface;
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
use Google\Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            if ($request->file('featured_image')) {
                $file = $request->file('featured_image');
                $filename = $this->uploadImage($file, $service);
                $service->image = $filename;
            }

            $service->name = $data['service_name'];
            $service->description = $data['service_description'];
            $service->address_1 = $data['service_location'];
            $service->max_capacity = $data['min_capacity'];
            $service->min_capacity = $data['max_capacity'];
            $service->availability_slot = $data['available_slot'];
            $service->availability_start_date = $data['start_available_date'];
            $service->availability_end_date = $data['end_available_date'];
            if ($request->file('images')) {
                foreach ($request->file('images') as $file) {
                    $this->uploadImage($file, $service);
                }
            }
            $service->save();

//            $price = $service->price;
//            $price->plan_id = $data['plan_id'];
//            $price->service_price = $data['service_price'];
//            $price->package = $data['package_name'];
//            $price->min_capacity = $data['package_min_capacity'];
//            $price->max_capacity = $data['package_max_capacity'];
//            $price->package_details = $data['package_details'];
//            $price->package_price = $data['service_price'];
//            $price->save();
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

            return redirect()->back()->with('success', 'Service Saved Successfully');
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
        $service->occasion_type = 0;
        $service->price = $data['service_price'];
        $service->description = $data['service_description'];
        $service->address_1 = $data['location'];
        $service->max_capacity = $data['min_capacity'];
        $service->min_capacity = $data['max_capacity'];
        $service->availability_slot = $data['available_slot'];
        $service->availability_start_date = $data['start_available_date'];
        $service->availability_end_date = $data['end_available_date'];
        $service->availability_time_in = $data['start_available_time'];
        $service->availability_time_out = $data['end_available_time'];
        $service->active = 1;
        $service->service_type = $data['service_type'];

        if ($request->file('featured_image')) {
            $file = $request->file('featured_image');
            $filename = $this->uploadImage($file, $service);
            $service->image = $filename;
        }

        if ($request->file('images')) {
            foreach ($request->file('images') as $file) {
                $this->uploadImage($file, $service);
            }
        }
        $service->save();

        $price = new OccasionEventPrice();
        $price->occasion_event_id = $service->id;
        $price->plan_id = $data['plan_id'];
        $price->service_price = $data['service_price'];
        $price->package = $data['package_name'];
        $price->min_capacity = $data['package_min_capacity'];
        $price->max_capacity = $data['package_max_capacity'];
        $price->package_details = $data['package_details'];
        $price->package_price = $data['service_price'];
        $price->active = 1;
        $price->save();

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

        return redirect()->back()->with('success', 'Service Saved Successfully');
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
