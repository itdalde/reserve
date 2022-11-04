
<nav class="navbar-vertical navbar mt-10">
    <div class="nav-scroller">
        <!-- Brand logo -->
        <div class="d-flex flex-column bd-highlight mb-3">
            <div class="  bd-highlight">
                <a class="navbar-brand" href="{{ url('/admin') }}">
                    <img class="company-logo" src="/assets/images/company/{{ Auth::user()->company->logo }}" alt="...."/>
                </a>
            </div>
            <div class=" bd-highlight text-center">
                <span>{{Auth::user()->company->name}}</span>
            </div>
        </div>
        <ul class="navbar-nav flex-column" id="sideNavbar">

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


        </ul>

    </div>
</nav>
