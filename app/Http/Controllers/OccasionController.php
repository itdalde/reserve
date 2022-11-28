<?php

namespace App\Http\Controllers;

use App\Interfaces\OccasionInterface;
use App\Models\InquiryReplyImage;
use App\Models\Occasion;
use Google\Exception;
use Illuminate\Http\Request;

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
        $data = $request->all();
        $occasion = new Occasion();
        $occasion->name = $data['name'];
        $occasion->active = isset($data['active']) ? 1 : 0;
        if ($request->file('image')) {
            $imageName = time() . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path("assets/images/occasions"), $imageName);
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
