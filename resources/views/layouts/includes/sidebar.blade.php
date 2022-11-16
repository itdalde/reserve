
<nav class="navbar-vertical navbar mt-10">
    <div class="nav-scroller">
        <!-- Brand logo -->
        @if(!Auth::user()->hasRole('superadmin'))
        <div class="d-flex flex-column bd-highlight mb-3">
            <div class="  bd-highlight">
                <a class="navbar-brand" href="{{ url('/admin') }}">
                    <img class="company-logo" src="/assets/images/company/{{ Auth::user() && Auth::user()->company ? Auth::user()->company->logo: '' }}" alt="...."/>
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
            @else
                <li class="nav-item py-2">
                    <a class="nav-link {{ Request::is('admin*') ? ' active' : '' }}" href="{{ url('/admin') }}">
                        <img class="ml-15px " src="{{Request::is('admin*') ? asset('assets/images/icons/customers-side.png') : asset('assets/images/icons/customers-side-inactive.png')}}" alt="....">
                        Customers
                    </a>
                </li>
                <li class="nav-item py-2">
                    <a class="nav-link {{ Request::is('service-providers*') ? ' active' : '' }}" href="{{ route('service-providers.list') }}">
                        <img class="ml-15px " src="{{Request::is('service-providers*') ? asset('assets/images/icons/service-providers-active.png') : asset('assets/images/icons/service-providers.png')}}" alt="....">
                        Service Providers
                    </a>
                </li>

            @endif

        </ul>

    </div>
</nav>
