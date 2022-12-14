<div class="header @@classList fixed-top">
    <!-- navbar -->
    <nav class="navbar-classic navbar navbar-expand-lg">
        <a href="/admin"><img src="{{ asset('assets/landing/img/logo-black.png') }}" alt=".."
                              style="    margin-right: 6px; width: 60%;" class="img-fluid"></a>
        <a id="nav-toggle" href="#"><i
                data-feather="menu"

                class="nav-icon me-2 icon-xs"></i></a>
        <div class="ms-lg-3 d-none d-md-none d-lg-block w-25">
            <!-- Form -->
            @if(!Auth::user()->hasRole('superadmin'))
            <form class="d-flex align-items-center">
                <input id="head-general-search" type="search" class="form-control" placeholder="Search"/>
            </form>
            @else
                <span><h3>Admin account</h3></span>
            @endif
        </div>
        @if(!Auth::user()->hasRole('superadmin') && isset($services) && count($services) < 1)
        <div class="mx-2 d-flex justify-content-center">
            <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#new-service-modal">
                <img src="{{asset('assets/images/icons/add.png')}}" alt="...">  &nbsp; &nbsp; &nbsp; &nbsp;Add new service
            </button>
        </div>
    @endif
        <!--Navbar nav -->
        <ul class="navbar-nav navbar-right-wrap ms-auto d-flex nav-top-wrap">
            <li class="dropdown stopevent">
                <a class="btn btn-light btn-icon rounded-circle indicator indicator-primary text-muted" href="#" role="button"
                   id="dropdownNotification" data-bs-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    <i class="icon-xs" data-feather="bell"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end"
                     aria-labelledby="dropdownNotification">
                    <div>
                        <div class="border-bottom px-3 pt-2 pb-3 d-flex justify-content-between align-items-center">
                            <p class="mb-0 text-dark fw-medium fs-4">Notifications</p>
                            <a href="#" class="text-muted">
                                <span>
                                  <i class="me-1 icon-xxs" data-feather="settings"></i>
                                </span>
                            </a>
                        </div>
                        <!-- List group -->
                        <ul class="list-group list-group-flush notification-list-scroll">
                            <!-- List group item
                            <li class="list-group-item bg-light">
                                <a href="#" class="text-muted">
                                    <h5 class=" mb-1">Rishi Chopra</h5>
                                    <p class="mb-0">
                                        Mauris blandit erat id nunc blandit, ac eleifend dolor pretium.
                                    </p>
                                </a>
                            </li> -->
                            <!-- List group item
                            <li class="list-group-item">


                                <a href="#" class="text-muted">
                                    <h5 class=" mb-1">Neha Kannned</h5>
                                    <p class="mb-0">
                                        Proin at elit vel est condimentum elementum id in ante. Maecenas et
                                        sapien metus.
                                    </p>
                                </a>


                            </li> -->
                            <!-- List group item
                            <li class="list-group-item">


                                <a href="#" class="text-muted">
                                    <h5 class=" mb-1">Nirmala Chauhan</h5>
                                    <p class="mb-0">
                                        Morbi maximus urna lobortis elit sollicitudin sollicitudieget elit vel
                                        pretium.
                                    </p>
                                </a>


                            </li>-->
                            <!-- List group item
                            <li class="list-group-item">


                                <a href="#" class="text-muted">
                                    <h5 class=" mb-1">Sina Ray</h5>
                                    <p class="mb-0">
                                        Sed aliquam augue sit amet mauris volutpat hendrerit sed nunc eu diam.
                                    </p>
                                </a>


                            </li>-->
                        </ul>
                        <div class="border-top px-3 py-2 text-center">
                            <a href="{{route('notifications.index')}}" class="text-inherit fw-semi-bold">
                                View all Notifications
                            </a>
                        </div>
                    </div>
                </div>
            </li>
            <!-- List -->
            <li class="dropdown ms-2">
                <a class="rounded-circle" href="#" role="button" id="dropdownUser"
                   data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="avatar avatar-md avatar-indicators avatar-online">

                        @if(Auth::user() && Auth::user()->profile_picture )
                            <img class="rounded-circle" src="{{ asset( Auth::user()->profile_picture) }}" alt="...."   />
                        @else
                            <img class="rounded-circle" src="https://ui-avatars.com/api/?name={{Auth::user() && Auth::user()->first_name ? Auth::user()->first_name: Auth::user()->email}}" alt="...">
                        @endif
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end text-center" style="    width: 200px;"
                     aria-labelledby="dropdownUser">
                    <div class="px-4 pb-0 pt-2">
                        <div class="lh-1 ">
                            <h5 class="mb-1"> {{Auth::check() ? Auth::user()->full_name : ''}}</h5>
                            <a href="#" class="text-inherit fs-6 d-none" >View my profile</a>
                        </div>
                        <div class=" dropdown-divider mt-3 mb-2"></div>
                    </div>

                    <ul class="list-unstyled">

                        <li class="d-none">
                            <a class="dropdown-item" href="#">
                                <i class="me-2 icon-xxs dropdown-item-icon" data-feather="user"></i>Edit
                                Profile
                            </a>
                        </li>
                        <li class="d-none">
                            <a class="dropdown-item"
                               href="#">
                                <i class="me-2 icon-xxs dropdown-item-icon"
                                   data-feather="activity"></i>Activity Log
                            </a>


                        </li>

                        <li class="d-none">
                            <a class="dropdown-item text-primary" href="#">
                                <i class="me-2 icon-xxs text-primary dropdown-item-icon"
                                   data-feather="star"></i>Go Pro
                            </a>
                        </li>
                        <li class="d-none">
                            <a class="dropdown-item" href="#">
                                <i class="me-2 icon-xxs dropdown-item-icon"
                                   data-feather="settings"></i>Account Settings
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{route('logout')}}">
                                <i class="me-2 icon-xxs dropdown-item-icon"
                                   data-feather="power"></i>Sign Out
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </nav>
</div>
