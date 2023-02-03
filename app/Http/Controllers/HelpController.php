<?php

namespace App\Http\Controllers;

use App\Interfaces\HelpInterface;
use App\Models\Inquiries;
use App\Models\InquiryAttachments;
use App\Models\InquiryReply;
use App\Models\InquiryReplyImage;
use App\Models\Occasion;
use App\Models\OccasionType;
use App\Models\PlanType;
use App\Models\ServiceType;
use Google\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HelpController extends Controller
{

    /**
 * Create a new controller instance.
 *
 * @return void
 */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activeInquiries = Inquiries::where('is_active',1)->with('user')->get();
        $inActiveInquiries = Inquiries::where('is_active',0)->with('user')->get();
        $serviceTypes = ServiceType::all()->toArray();
        $occasionTypes =  Occasion::all()->toArray();
        $plan = PlanType::all()->toArray();
        return view('admin.helps.index',compact('activeInquiries','inActiveInquiries','occasionTypes','serviceTypes','plan'));
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

    public function replies(Request $request) {
        try {
            $data = $request->all();
            $inquiryReplies = InquiryReply::where('inquiries_id', $data['inquiries_id'])->get();
            $data = '';
            foreach ($inquiryReplies as $inquiryReply) {
                $name = $inquiryReply->user->first_name . ' ' . $inquiryReply->user->last_name;
                $date = $inquiryReply->created_at->format('d/m/Y h:i A');
                $imageProfile = $inquiryReply->user->profile_picture ?? asset('images/blank-profile-picture.png');
                $description = $inquiryReply->description;
                $data .= '<div class="card mt-7 mb-2" ><div class="card-body">';
                $data .= '<div class="d-flex bd-highlight mb-3">
                        <div class="p-2 bd-highlight"><img width="50" class="img-circle " src="' . $imageProfile . '" alt="..."></div>
                        <div class="p-2 bd-highlight"><span class="">' . $name . '</span></div>
                        <div class="ms-auto p-2 bd-highlight"><span class="">' . $date . '</span></div>
                    </div>
                    <div class="d-flex flex-column bd-highlight mb-3">
                        <div class="p-2 bd-highlight ">' . $description . '</div>
                    </div>';
                $data .= '</div></div>';
            }
            echo $data;
            die;
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function reply(Request $request)
    {

        $data = $request->all();
        $company = $request->user()->company;
        $inquiryReply = new InquiryReply();

        $inquiryReply->inquiries_id = $data['issue_id'];
        $inquiryReply->user_id = $request->user()->id;
        $inquiryReply->description = $data['reply'];
        $inquiryReply->is_owner = $request->user()->id != $data['owner_id'] ? 0 : 1;
        $inquiryReply->save();
        if ($request->file('images')) {
            foreach ($request->file('images') as $imagefile) {
                $image = new InquiryReplyImage();
                $imageName = time() . '.' . $imagefile->extension();
                $imagefile->move(public_path("images/company/{$company->id}/reply"), $imageName);
                $filename = "images/company/{$company->id}/reply/{$imageName}";
                $image->image = $filename;
                $image->inquiry_replies_id = $inquiryReply->id;
                $image->save();
            }
        }
        $response = [
            'success' => true,
            'data' => $inquiryReply,
            'message' => 'Successfully saved'
        ];

        return response()->json($response, 200);
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
