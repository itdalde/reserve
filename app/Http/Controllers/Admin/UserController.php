<?php

namespace App\Http\Controllers\Admin;

use App\Models\Auth\Role\Role;
use App\Models\Auth\User\User;
use App\Models\Occasion;
use App\Models\OrderSplit;
use App\Utility\NotificationUtility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Notes;
use App\Repositories\Access\User\EloquentUserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Validator;

class UserController extends Controller
{
    /**
     * Repository
     *
     * @var object
     */
    protected $repository;

    /**
     * Construct
     *
     */
    public function __construct()
    {
        $this->repository = new EloquentUserRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('admin.users.index', ['users' => User::with('roles')->sortable(['email' => 'asc'])->paginate()]);
    }

    /**
     * Restore Users
     *
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request)
    {
        return view('admin.users.restore', ['users' => User::onlyTrashed()->with('roles')->sortable(['email' => 'asc'])->paginate()]);
    }

    /**
     * Restore Users
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function restoreUser($id)
    {
        $status = $this->repository->restore($id);

        if ($status) {
            return redirect()->route('admin.users')->withFlashSuccess('User Restored Successfully!');
        }

        return redirect()->route('admin.users')->withFlashDanger('Unable to Restore User!');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('admin.users.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', ['user' => $user, 'roles' => Role::get()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param User $user
     * @return mixed
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'active' => 'sometimes|boolean',
            'confirmed' => 'sometimes|boolean',
        ]);

        $validator->sometimes('email', 'unique:users', function ($input) use ($user) {
            return strtolower($input->email) != strtolower($user->email);
        });

        $validator->sometimes('password', 'min:6|confirmed', function ($input) {
            return $input->password;
        });

        if ($validator->fails()) return redirect()->back()->withErrors($validator->errors());

        $user->name = $request->get('name');
        $user->email = $request->get('email');

        if ($request->has('password')) {
            $user->password = bcrypt($request->get('password'));
        }

        $user->active = $request->get('active', 0);
        $user->confirmed = $request->get('confirmed', 0);

        $user->save();

        //roles
        if ($request->has('roles')) {
            $user->roles()->detach();

            if ($request->get('roles')) {
                $user->roles()->attach($request->get('roles'));
            }
        }

        return redirect()->intended(route('admin.users'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = $this->repository->destroy($id);

        if ($status) {
            return redirect()->route('admin.users')->withFlashSuccess('User Deleted Successfully!');
        }

        return redirect()->route('admin.users')->withFlashDanger('Unable to Delete User!');
    }

    public function view(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        $total = 0;
        $totalOrders = 0;
       if($user->company  ) {
           if( $user->company->services) {
               $total = 0;
               foreach ($user->company->services as $service) {
                   $totalOrders += count($user->customer_orders);
                   foreach ($service->orders as  $order) {
                       $total += OrderSplit::where('order_id', $order['order']['id'])->where('status', 'paid')->sum('amount');
                   }
               }
           }
       } else {
           $totalOrders = count($user->customer_orders);
           foreach ($user->customer_orders as $order) {
               $total += $order->total_amount;
           }
       }
        return view('superadmin.user-view', compact('user', 'total','totalOrders'));
    }

    public function approve(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        $user->confirmed = 1;
        $user->save();
        return redirect()->back()->with('success', 'Approved Successfully');
    }

    public function removeUser(Request $request)
    {
        User::where('id', $request->id)->delete();
        return redirect()->back()->with('success', 'Removed Successfully');
    }

    public function serviceProviders(Request $request)
    {
        $total = 0;
        $users = User::whereHas('company')->with('roles')->sortable(['email' => 'asc'])->get();
        foreach ($users  as $i => $user) {
            if ($user->company && $user->company->services) {
                $total = 0;
                foreach ($user->company->services as $service) {
                    foreach ($service->orders as $k => $order) {
                        $total += OrderSplit::where('order_id', $order['order']['id'])->where('status', 'paid')->sum('amount');
                    }
                }
            }
            $users[$i]->total = $total;
        }
        return view('superadmin.service-provider', compact('users'));
    }

    public function testFcm()
    {

        $response = [
            "status" => "success",
            "message" => "Transactions Successfully Released!",
            "data" => ['test' => 'ni']
        ];

        $fcmTokens = User::whereNotNull('fcm_token')->pluck('fcm_token')->toArray();
        NotificationUtility::sendNotification('Test', 'Approved by ', $fcmTokens, $response);

        return response()->json([
            'success' => true,
            'message' => 'Successfully sent'
        ]);
    }

    public function testSocket()
    {
        Http::timeout(10)
            ->withOptions(['verify' => false])
            ->post('http://reservegcc.com:3000/reservation', [
                'transaction' => [
                    'test' => 'only'
                ],
                'status' => 'approved'
            ]);
        return response()->json([
            'success' => true,
            'message' => 'Successfully sent'
        ]);
    }

    public function updateToken(Request $request)
    {
        try {

            $user = auth()->user();
            $user->fcm_token = $request->fcm_token;
            $user->save();
            return response()->json([
                'success' => true,
                'message' => 'Successfully added'
            ]);
        } catch (\Exception $e) {
            report($e);
            return response()->json([   
                'success' => false
            ], 500);
        }
    }

    public function userList(Request $request)
    {
        if ($request->search) {
            $users = User::where('full_name', 'like', '%' . $request->search . '%')
                ->orWhere('first_name', 'like', '%' . $request->search . '%')
                ->orWhere('last_name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%')
                ->orWhere('phone_number', 'like', '%' . $request->search . '%')
                ->get()->toArray();
        } else {
            $users = User::all()->toArray();
        }
        return response()->json([
            "status" => "success",
            "response" => [
                "data" => $users
            ]
        ]);
    }
}
