<!--begin::Sidebar-->
<aside class = "app-sidebar bg-body-secondary shadow elevation-4 d-flex flex-column" style = "height: 100vh;"
       data-bs-theme = "dark">
    <!--begin::Sidebar Brand-->
    <div class = "sidebar-brand">
        <!--begin::Brand Link-->
        <a href = "{{ route('order.create') }}" class = "brand-link">

            <!--begin::Brand Text-->
            <span class = "brand-text fw-light">Dental Connect</span>
            <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class = "sidebar-wrapper flex-grow-1">
        <nav class = "mt-2">
            <!--begin::Sidebar Menu-->
            <ul
                class = "nav sidebar-menu flex-column"
                data-lte-toggle = "treeview"
                role = "menu"
                data-accordion = "false"
            >

                @can('isDentist')
                    <li class = "nav-item">
                        <a href = "{{ route('dentist.index') }}" class = "nav-link d-flex align-items-center gap-2">
                            <i class = "fas fa-align-justify"></i>
                            <p>Orders</p>
                        </a>
                    </li>
                    <li class = "nav-item">
                        <a href = "{{ route('appointment.show') }}" class = "nav-link d-flex align-items-center gap-2">
                            <i class="fa-solid fa-list-check"></i>
                            <p>Appointments</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dentist.edit') }}" class="nav-link d-flex align-items-center gap-2">
                            <i class="fa-solid fa-pen"></i>
                            <p>Edit profile</p>
                        </a>
                    </li>
                @endcan


                @if(!Auth::check())
                    <li class = "nav-item">
                        <a href = "{{ route('order.create') }}" class = "nav-link d-flex align-items-center gap-2">
                            <i class = "fas fa-align-justify"></i>
                            <p>New Appointment</p>
                        </a>
                    </li>
                @endif
                <li class = "nav-item">
                    <a href = "{{ route('dentist.dentists') }}" class = "nav-link d-flex align-items-center gap-2">
                        <i class="fa-solid fa-user-doctor"></i>
                        <p>Dentists</p>
                    </a>
                </li>
            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->

    @if(Auth::check())
        <ul
            class = "nav sidebar-menu flex-column"
            data-lte-toggle = "treeview"
            role = "menu"
            data-accordion = "false"
        >
            <li>
                <div class = "nav-item">
                    <form action = "{{ route('logout') }}" method = "POST">
                        @csrf
                        <button type = "submit" class = "nav-link">
                            <i class = "nav-icon fas fa-sign-out-alt"></i>
                            Log out
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    @endif
    @if(!Auth::check())
        <ul
            class = "nav sidebar-menu flex-column"
            data-lte-toggle = "treeview"
            role = "menu"
            data-accordion = "false"
        >
            @if(!Auth::check())
                <li class = "nav-item">
                    <a href = "{{ route('login') }}" class = "nav-link">
                        <p class="fs-8 text-secondary">Log in as dentist</p>
                    </a>
                </li>
            @endif
        </ul>
    @endif


</aside>
<!--end::Sidebar-->
