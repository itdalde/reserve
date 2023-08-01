<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AuditTrail;

class AuditTrailMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $action)
    {
        $user = Auth::user();
        $data = $request->all();
        $loggedUser = $user->first_name . ' ' . $user->last_name;
        $userAction = $action == 'resource' ? ucfirst($request->method()) : $this->action($action);

        $routeName = $request->route()->getName();
        $module = ucfirst(str_singular($routeName)); 
        $model  = ucfirst(explode('.', $module)[0]);

        if ($userAction == 'GET' || $userAction == 'Get') {
            return $next($request);
        }
        
        AuditTrail::create([
            'user_id' => $user->id,
            'user' => $loggedUser,
            'model' => $model,
            'action' => $userAction,
            'notes' => 'User ' . $loggedUser . ' performs ' . $userAction . ' request with the following endpoint ' . $request->getRequestUri(),
            'data' => "-",
            'company_id' => Auth::user()->company->id,
        ]);
        return $next($request);
    }

    public function action($action) {
        $actionPerformed;
        switch ($action){
            case 'get': 
                $actionPerformed = 'Get';
                break;
            case 'post':
                $actionPerformed = 'Create';
                break;
            case 'put':
                $actionPerformed = 'Update';
                break;
            case 'delete':
                $actionPerformed = 'Delete';
                break;
            default;
                return;
        }
        return $actionPerformed;
    }
}
