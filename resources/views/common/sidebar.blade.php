<?php
$roles=Session::get('ROLES');
$role=explode(',',$roles);
$count=count($role);

?>
    <div class="topnav">
        <div class="container-fluid">
            <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
                <div class="collapse navbar-collapse" id="topnav-menu-content">
                    <ul class="navbar-nav">

                        
                        <!-- Only dashboard -->
                        @if($roles==0)
                            <li class="nav-item">
                                <a href="{{route('dashboard')}}" class="waves-effect nav-link">
                                    <i class="bx bx-home-circle"></i>
                                    <span key="t-dashboards">Dashboard</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{route('user.page')}}" class="waves-effect nav-link">
                                    <i class="bx bx-user"></i>
                                    <span key="t-dashboards">Manage Users</span>
                                </a>
                            </li>
                        @endif
                        @if($roles==0 || $roles==1)
                            <li class="nav-item">
                                <a href="{{route('project_enquiry.page')}}" class="waves-effect nav-link">
                                    <i class="bx bx-task"></i>
                                    <span key="t-dashboards">Project Enquiry</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{route('coverted_projects.page')}}" class="waves-effect nav-link">
                                    <i class="bx bx-task"></i>
                                    <span key="t-dashboards">Converted Projects</span>
                                </a>
                            </li>
                        @endif    
                            <li class="nav-item">
                                <a href="{{route('enq_tasks.page')}}" class="waves-effect nav-link">
                                    <i class="bx bx-task"></i>
                                    <span key="t-dashboards">Enquiry Tasks</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{route('conv_tasks.page')}}" class="waves-effect nav-link">
                                    <i class="bx bx-task"></i>
                                    <span key="t-dashboards">Converted Tasks</span>
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a href="{{route('visit_manage.page')}}" class="waves-effect nav-link">
                                    <i class="bx bx-task"></i>
                                    <span key="t-dashboards">Visit Management</span>
                                </a>
                            </li>

                            <!-- <li class="nav-item">
                                <a href="{{route('project_type.page')}}" class="waves-effect nav-link">
                                    <i class="bx bx-task"></i>
                                    <span key="t-dashboards">Project Type</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{route('consultant.page')}}" class="waves-effect nav-link">
                                    <i class="bx bx-task"></i>
                                    <span key="t-dashboards">Manage Consultant</span>
                                </a>
                            </li> -->
                        
                    </ul>
                </div>
            </nav>
        </div>
    </div>