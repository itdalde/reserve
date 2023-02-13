
<nav class="navbar-vertical navbar mt-10">
    <div class="nav-scroller">
        <!-- Brand logo -->
        @if(!Auth::user()->hasRole('superadmin'))
        <div class="d-flex flex-column bd-highlight mb-3">
            <div class="  bd-highlight">
                <a class="navbar-brand" href="{{ url('/admin') }}">
                    @if(Auth::user() && Auth::user()->company && Auth::user()->company->logo)
                        <img class="company-logo" src="{{  asset(Auth::user()->company->logo) }}" alt="...."   />
                    @else
                        <img class="company-logo" src="https://ui-avatars.com/api/?name={{Auth::user() && Auth::user()->company ? Auth::user()->company->name : Auth::user()->email}}" alt="...">
                    @endif
                </a>
            </div>
            <div class=" bd-highlight text-center">
                <span>{{Auth::user() && Auth::user()->company ? Auth::user()->company->name : ''}}</span>
            </div>
        </div>
        @endif
        <ul class="navbar-nav flex-column" id="sideNavbar">

            @if(!Auth::user()->hasRole('superadmin'))
            <li class="nav-item py-2">
                <a class="nav-link has-arrow  {{ Request::is('admin*') ? ' active' : '' }} " href="{{ url('/admin') }}">
                    <img class="ml-15px " style="{{ Request::is('admin*') ? ' ' : 'width: 30px;' }} " href="{{ url('/admin') }}" src="{{Request::is('admin*') ? asset('assets/images/icons/Dashboard filled active.svg') : asset('assets/images/icons/Dashboard filled.png')}}" alt="....">  Dashboard
                </a>

            </li>
                <li class="nav-item py-2">
                    <a class="nav-link {{ Request::is('service*') ? ' active' : '' }}" href="{{ route('services.index') }}">
                        <img class="ml-15px " src="{{Request::is('service*') ? asset('assets/images/icons/Services Outline active.svg') : asset('assets/images/icons/Services Outline.svg')}}" alt="....">
                        Service
                    </a>
                </li>
            <li class="nav-item py-2">
                <a class="nav-link {{ Request::is('orders*') ? ' active' : '' }}" href="{{ route('orders.index') }}">
                    <img class="ml-15px " src="{{Request::is('orders*') ? asset('assets/images/icons/Orders Outline active.svg') : asset('assets/images/icons/Orders Outline.svg')}}" alt="....">
                    Orders
                </a>
            </li>
            <li class="nav-item py-2">
                <a class="nav-link {{ Request::is('helps*') ? ' active' : '' }}" href="{{ route('helps.index') }}">
                    <img class="ml-15px " src="{{Request::is('helps*') ? asset('assets/images/icons/Group active.svg') : asset('assets/images/icons/Group.svg')}}" alt="....">
                    Help
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link px-4 d-flex align-items-center custom-tooltip customers-side-tab"  data-bs-toggle="collapse" href="#settings" role="button" aria-expanded="false" aria-controls="settings">
                    <span class="ml-15px "><i style="font-size: 25px; {{Request::is('settings*') ? 'color:orange' : ''}}" class="bi bi-gear"></i> </span>
                    <span>Settings</span>
                </a>
                <ul class="collapse pl-0 mx-0 {{ Request::is('schedules*') || Request::is('settings*') ? ' show' : '' }}" id="settings" style="list-style-type: none;">
                    <li class="nav-item {{ Request::is('schedules*') || Request::is('settings*') ? ' show' : '' }}">
                        <a class="nav-link pl-5 d-flex align-items-center custom-tooltip" href="{{route('settings.index')}}">
                            <span class="pl-1 ml-2"> Profile </span>
                        </a>
                    </li>
                    <li class="nav-item {{ Request::is('schedules*') || Request::is('settings*')? 'show' : '' }}">
                        <a class="nav-link pl-5 d-flex align-items-center custom-tooltip" href="{{route('settings.manage_orders')}}">
                            <span class="pl-1 ml-2">Manage orders</span>
                        </a>
                    </li>
                    <li class="nav-item {{ Request::is('schedules*') || Request::is('settings*') ? 'show' : '' }}">
                        <a class="nav-link pl-5 d-flex align-items-center custom-tooltip" href="{{ route('schedules.index') }}">
                              <span class="pl-1 ml-2">My Schedule</span>
                        </a>
                    </li>
                </ul>
            </li>
            @else
                <li class="nav-item py-2">
                    <a class="nav-link {{ Request::is('admin') ? ' active' : '' }}" href="{{ url('/admin') }}">
                        <img class="ml-15px " src="{{Request::is('admin') ? asset('assets/images/icons/customers-side.png') : asset('assets/images/icons/customers-side-inactive.png')}}" alt="....">
                        Customers
                    </a>
                </li>
                <li class="nav-item py-2">
                    <a class="nav-link {{ Request::is('service-providers*') ? ' active' : '' }}" href="{{ route('service-providers.list') }}">
                        <img class="ml-15px " src="{{Request::is('service-providers*') ? asset('assets/images/icons/service-providers-active.png') : asset('assets/images/icons/service-providers.png')}}" alt="....">
                        Service Providers
                    </a>
                </li>
                <li class="nav-item py-2">
                    <a class="nav-link {{ Request::is('admin/orders*') ? ' active' : '' }}" href="{{ route('orders.admin') }}">
                        <span class="ml-15px "><i style="font-size: 25px; {{Request::is('admin/orders*') ? 'color:orange' : ''}}" class="bi bi-menu-app-fill"></i>  </span>
                        Orders
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link px-4 d-flex align-items-center custom-tooltip customers-side-tab {{ Request::is('settings*') ? ' show active' : '' }}"  data-bs-toggle="collapse" href="#settings" role="button" aria-expanded="{{ Request::is('settings*') ? 'true' : 'false' }}" aria-controls="settings">
                        <span class="ml-15px "><i style="font-size: 25px; {{Request::is('settings*') ? 'color:orange' : ''}}" class="bi bi-gear"></i> </span>
                        <span>Settings</span>
                    </a>
                    <ul class="collapse pl-0 mx-0 {{ Request::is('settings*') ? ' show' : '' }}" id="settings" style="list-style-type: none;">
                        <li class="nav-item {{ Request::is('settings*') ? ' show' : '' }}">
                            <a class="nav-link pl-5 d-flex align-items-center custom-tooltip" href="{{route('settings.services')}}">
                                <span class="pl-1 ml-2"> Services </span>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('settings*') ? 'show' : '' }}">
                            <a class="nav-link pl-5 d-flex align-items-center custom-tooltip" href="{{route('settings.occasions')}}">
                                <span class="pl-1 ml-2">Occasions</span>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('settings*') ? 'show' : '' }}">
                            <a class="nav-link pl-5 d-flex align-items-center custom-tooltip" href="{{route('settings.statuses')}}">
                                <span class="pl-1 ml-2">Statuses</span>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('settings*') ? 'show' : '' }}">
                            <a class="nav-link pl-5 d-flex align-items-center custom-tooltip" href="{{route('settings.roles')}}">
                                <span class="pl-1 ml-2">Roles</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

        </ul>

    </div>
</nav>
