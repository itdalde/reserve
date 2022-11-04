<?php

namespace App\Http\Controllers;

use App\Models\Inquiries;
use App\Models\InquiryAttachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HelpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inquiries = Inquiries::all();
        return view('admin.helps.index',compact('inquiries'));
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
        $inquiry = new Inquiries();
        $inquiry->title = $request->title;
        $inquiry->description = $request->description;
        $inquiry->reference = time().rand(1,100);
        $inquiry->save();
        if($request->hasfile('attachments'))   {
            foreach($request->file('attachments') as $file) {
                $name = time().rand(1,100).'.'.$file->extension();
                $file->move(public_path('assets/images/attachments'), $name);
                $inquiryAttachments = new InquiryAttachments();
                $inquiryAttachments->inquiries_id = $inquiry->id;
                $inquiryAttachments->attachment = $name;
                $inquiryAttachments->save();
            }
        }

        return back()->with('success', 'Data Your files has been successfully added');
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
        //
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
}
