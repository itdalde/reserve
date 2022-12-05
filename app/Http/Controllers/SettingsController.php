<?php

namespace App\Http\Controllers;

use App\Models\Auth\Role\Role;
use App\Models\EventImages;
use App\Models\Occasion;
use App\Models\OccasionEvent;
use App\Models\ServiceType;
use App\Models\Status;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.settings.index');
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

    public function manageOrders(Request $request)
    {
        return view('admin.orders.manage');
    }

    public function services(Request $request)
    {
        $services = ServiceType::all();
        return view('admin.settings.services', compact('services'));
    }

    public function occasions(Request $request)
    {
        $occasions = Occasion::all();
        $services = OccasionEvent::with('company')->get()->toArray();
        return view('admin.settings.occasions', compact('occasions','services'));
    }

    public function statuses(Request $request)
    {
        $statuses = Status::all();
        return view('admin.settings.statuses', compact('statuses'));
    }

    public function roles(Request $request)
    {
        $roles = Role::all();
        return view('admin.settings.roles', compact('roles'));
    }

    public function companyUpdate(Request $request)
    {
        try {
            $data = $request->all();
            $user = auth()->user();
            $company = $user->company;
            if ($request->file('company_image')) {
                $file = $request->file('company_image');
                $imageName = time() . '.' . $file->extension();
                $file->move(public_path("assets/images/company"), $imageName);
                $filename = "assets/images/company/{$imageName}";
                $company->logo = $filename;
            }
            $company->description = $data['description'];
            $company->location = $data['location'];
            $company->phone_number = $data['phone_number'];
            $company->name = $data['name'];
            $company->save();
            return redirect()->back()->with('success', 'Company Updated Successfully');
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    public function statusDelete(Request $request)
    {
        try {
            $data = $request->all();
            Status::where('id',$data['id'])->delete();
            return redirect()->back()->with('success', 'Company Updated Successfully');
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }
    public function statusUpdate(Request $request)
    {
        try {
            $data = $request->all();
            $status = Status::where('id',$data['id'])->first();
            $status->name = $data['name'];
            $status->active = isset($data['active']) ? 1 : 0;
            $status->save();
            return redirect()->back()->with('success', 'Status Updated Successfully');
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }
    public function statusStore(Request $request)
    {
        try {
            $data = $request->all();
            $status = new Status();
            $status->name = $data['name'];
            $status->active = isset($data['active']) ? 1 : 0;
            $status->save();
            return redirect()->back()->with('success', 'Company Updated Successfully');
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }
    public function serviceDelete(Request $request)
    {
        try {
            $data = $request->all();
            ServiceType::where('id',$data['id'])->delete();
            return redirect()->back()->with('success', 'Service Type Deleted Successfully');
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }
    public function serviceUpdate(Request $request)
    {
        try {
            $data = $request->all();
            $status = ServiceType::where('id',$data['id'])->first();
            $status->name = $data['name'];
            $status->active = isset($data['active']) ? 1 : 0;
            $status->save();
            return redirect()->back()->with('success', 'Service Type Updated Successfully');
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }
    public function serviceStore(Request $request)
    {
        try {
            $data = $request->all();
            $status = new ServiceType();
            $status->name = $data['name'];
            $status->active = isset($data['active']) ? 1 : 0;
            $status->save();
            return redirect()->back()->with('success', 'Service Type Created Successfully');
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
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
            $user = auth()->user();
            $user->first_name = $data['first_name'];
            if ($request->file('profile_image')) {
                $file = $request->file('profile_image');
                $imageName = time() . '.' . $file->extension();
                $file->move(public_path("assets/images/avatar"), $imageName);
                $filename = "assets/images/avatar/{$imageName}";
                $user->profile_picture = $filename;
            }
            $user->last_name = $data['last_name'];
            $user->location = $data['location'];
            $user->phone_number = $data['phone_number'];
            if ($data['password'] != '') {
                $user->password = bcrypt($data['password']);
            }
            $user->save();
            return redirect()->back()->with('success', 'User Updated Successfully');
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
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
