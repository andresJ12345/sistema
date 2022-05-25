    <div class="overlay"></div>
    <div class="search-overlay"></div>

    <!--  BEGIN SIDEBAR  -->
    <div class="sidebar-wrapper sidebar-theme">

        <nav id="compactSidebar">

            <div class="theme-logo">
                <a href="index.html">
                    <img src="../../dist/assets/img/favicon.png" class="navbar-logo" alt="logo">
                </a>
            </div>

            <ul class="menu-categories">

                <?php $MenuList =  $DataUserMenu->DrawMenu();
                foreach ($MenuList as $RowMenu) {
                    if ($RowMenu['pathPage'] !== 'buscador') {
                        $isActive = $DataUserMenu->IsActive($RowMenu['pathPage']);


                ?>

                        <li class="menu menu-single <?php echo $isActive['class']; ?>">
                            <a href="../<?php echo $RowMenu['pathPage'] ?>" data-active="<?php echo $isActive['bool']; ?>" class="menu-toggle">
                                <div class="base-menu">
                                    <div class="base-icons">
                                        <?php echo $RowMenu['icono'] ?>
                                    </div>
                                </div>
                            </a>
                            <div class="tooltip"><span> <?php echo $RowMenu['nombre'] ?></span></div>
                        </li>
                <?php
                    }
                }
                ?>


                <!-- <li class="menu">
                    <a href="#app" data-active="false" class="menu-toggle">
                        <div class="base-menu">
                            <div class="base-icons">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-cpu">
                                    <rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect>
                                    <rect x="9" y="9" width="6" height="6"></rect>
                                    <line x1="9" y1="1" x2="9" y2="4"></line>
                                    <line x1="15" y1="1" x2="15" y2="4"></line>
                                    <line x1="9" y1="20" x2="9" y2="23"></line>
                                    <line x1="15" y1="20" x2="15" y2="23"></line>
                                    <line x1="20" y1="9" x2="23" y2="9"></line>
                                    <line x1="20" y1="14" x2="23" y2="14"></line>
                                    <line x1="1" y1="9" x2="4" y2="9"></line>
                                    <line x1="1" y1="14" x2="4" y2="14"></line>
                                </svg>
                            </div>
                        </div>
                    </a>
                    <div class="tooltip"><span>Apps</span></div>
                </li> -->

            </ul>

            <div class="sidebar-bottom-actions">

                <!-- <div class="external-links">
                    <a target="_blank" href="../../documentation/index.html" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-help-circle">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                            <line x1="12" y1="17" x2="12.01" y2="17"></line>
                        </svg>
                        <div class="tooltip"><span>Ayuda</span></div>
                    </a>
                </div> -->

                <div class="dropdown user-profile-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="../../dist/assets/img/user.png" class="img-fluid" alt="avatar">
                    </a>
                    <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                        <div class="dropdown-inner">
                            <div class="user-profile-section">
                                <div class="media mx-auto">
                                    <img src="../../dist/assets/img/user.png" class="img-fluid mr-2" alt="avatar">
                                    <div class="media-body">
                                        <h5><?php echo $DataUserMenu->DataUser('nombre') ?></h5>
                                        <p><?php echo $DataUserMenu->NameRol() ?></p>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="dropdown-item">
                                <a href="auth_lockscreen.html">
                                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                                        <line x1="12" y1="9" x2="12" y2="13"></line>
                                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                                    </svg>
                                    <span>Mis novedades</span>
                                </a>
                            </div>

                            <div class="dropdown-item">
                                <a href="auth_lockscreen.html">
                                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                        <polyline points="23 4 23 10 17 10"></polyline>
                                        <polyline points="1 20 1 14 7 14"></polyline>
                                        <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                                    </svg><span>Cambiar contraseña</span>
                                </a>
                            </div> -->
                            <div class="dropdown-item">
                                <a href="../ayuda/index.php">
                                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                                    </svg> <span>Ayuda</span>
                                </a>
                            </div>
                            <div class="dropdown-item">
                                <a href="../login/salir.php">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                        <polyline points="16 17 21 12 16 7"></polyline>
                                        <line x1="21" y1="12" x2="9" y2="12"></line>
                                    </svg> <span>Salir</span>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </nav>

        
    </div>
    <!--  END SIDEBAR  -->