<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">

            <div class="info">
                <img alt="" class="img-fluid mb-2" src="{{ asset('images/FOP5-logo-main.png') }}"
                    style="width: 100px;">
                <h5 class="text-white">NDUB Alumni Portal</h5>
                <a class="" href="#"><b>{{ Auth::user()->name }} <br>
                        @php
                            use App\Models\User;
                            $user = User::where('id', Auth::user()->id)->first();
                            echo '<small></small>';
                        @endphp</b></a><br>
            </div>

        </div>

        <!-- Sidebar Menu -->

        <nav class="mt-2">


            <ul class="nav nav-pills nav-sidebar flex-column" data-accordion="false" data-widget="treeview"
                role="menu">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            @php
                $loggedUser = Auth::user();
            @endphp
            @if($loggedUser->user_slug!='Account-1')
                @if(Auth::user()->role_id == '1' || Auth::user()->role_id == '2' || Auth::user()->role_id == '3')
                <li class="nav-item">

                <a class="nav-link" href="{{ url('dashboard') }}">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                        Dashboard
                    </p>
                </a>
                </li>
                
                @endif
                
                @if(Auth::user()->role_id == '3')

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('add_peo_po') }}">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            PEO + PO Form
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                        <a class="nav-link" href="{{ route('add_peo') }}">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                             PEO Form
                            </p>
                        </a>
                    </li>

                @endif
            @endif
                @if (Auth::user()->role_id == '1' || Auth::user()->role_id == '2')
                
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('peo_feedback') }}">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                             PEO Feedback
                            </p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('peo_po_feedback') }}">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                             PEO + PO Feedback
                            </p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('all_student') }}">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                All Students
                            </p>
                        </a>
                    </li>
            @if($loggedUser->user_slug!='Account-1')       
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('add_student') }}">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                Add Student
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('all_support_ticket') }}">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                All Support Tickets
                            </p>
                        </a>
                    </li>
                @endif

                @if (Auth::user()->role_id == '3')
                
                    <li class="nav-item">
                        <a class="nav-link" href="https://ndub.edu.bd/wp-content/uploads/2024/01/Please-bring-the-following-required-documents-with-the-Online-Registration-Form.pdf">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                Required Documents
                            </p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('add_support_ticket') }}">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                Support
                            </p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="https://ndub.edu.bd/wp-content/uploads/2024/01/Convocation-tutorial-1.pdf">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                Tutorial
                            </p>
                        </a>
                    </li>
                    
                @endif
            @endif
                
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <!-- Authentication -->
                        <form action="{{ route('logout') }}" id="logout-form" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Sign Out
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
