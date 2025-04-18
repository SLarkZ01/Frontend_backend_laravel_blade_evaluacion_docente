<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Select2 para mejorar los selectores -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Summernote para editor de texto enriquecido -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
    <!-- Chart.js para gráficos -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Dashboard de el sistema Evalacion Docente</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="{{ asset('images/LogoUniautonoma.png') }}" type="image/x-icon" />

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('css/sidebar/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar/atlantis.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

</head>

<body>
    <div class="wrapper">
        <div class="main-header">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="blue">

                <a href="" class="logo">
                    <img src="{{ asset('images/escudo.png') }}" alt="navbar brand" class="navbar-brand" height="42"
                        style="max-width: 100%; object-fit: contain;">
                </a>
                <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse"
                    data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <i class="icon-menu"></i>
                    </span>
                </button>
                <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
                <div class="nav-toggle">
                    <button class="btn btn-toggle toggle-sidebar">
                        <i class="icon-menu"></i>
                    </button>
                </div>
            </div>
            <!-- End Logo Header -->

            <!-- Navbar Header -->
            <nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">

                <div class="container-fluid">
                    <div class="collapse" id="search-nav">
                        <form class="navbar-left navbar-form nav-search mr-md-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="submit" class="btn btn-search pr-1">
                                        <i class="fa fa-search search-icon"></i>
                                    </button>
                                </div>
                                <input type="text" placeholder="Search ..." class="form-control">
                            </div>
                        </form>
                    </div>
                    <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                        <li class="nav-item toggle-nav-search hidden-caret">
                            <a class="nav-link" data-toggle="collapse" href="#search-nav" role="button"
                                aria-expanded="false" aria-controls="search-nav">
                                <i class="fa fa-search"></i>
                            </a>
                        </li>
                        <li class="nav-item dropdown hidden-caret">
                            <a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-envelope"></i>
                            </a>
                            <ul class="dropdown-menu messages-notif-box animated fadeIn"
                                aria-labelledby="messageDropdown">
                                <li>
                                    <div class="dropdown-title d-flex justify-content-between align-items-center">
                                        Messages
                                        <a href="#" class="small">Mark all as read</a>
                                    </div>
                                </li>
                                <li>
                                    <div class="message-notif-scroll scrollbar-outer">
                                        <div class="notif-center">
                                            <a href="#">
                                                <div class="notif-img">
                                                    <img src="../assets/img/jm_denis.jpg" alt="Img Profile">
                                                </div>
                                                <div class="notif-content">
                                                    <span class="subject">Jimmy Denis</span>
                                                    <span class="block">
                                                        How are you ?
                                                    </span>
                                                    <span class="time">5 minutes ago</span>
                                                </div>
                                            </a>
                                            <a href="#">
                                                <div class="notif-img">
                                                    <img src="../assets/img/chadengle.jpg" alt="Img Profile">
                                                </div>
                                                <div class="notif-content">
                                                    <span class="subject">Chad</span>
                                                    <span class="block">
                                                        Ok, Thanks !
                                                    </span>
                                                    <span class="time">12 minutes ago</span>
                                                </div>
                                            </a>
                                            <a href="#">
                                                <div class="notif-img">
                                                    <img src="../assets/img/mlane.jpg" alt="Img Profile">
                                                </div>
                                                <div class="notif-content">
                                                    <span class="subject">Jhon Doe</span>
                                                    <span class="block">
                                                        Ready for the meeting today...
                                                    </span>
                                                    <span class="time">12 minutes ago</span>
                                                </div>
                                            </a>
                                            <a href="#">
                                                <div class="notif-img">
                                                    <img src="../assets/img/talha.jpg" alt="Img Profile">
                                                </div>
                                                <div class="notif-content">
                                                    <span class="subject">Talha</span>
                                                    <span class="block">
                                                        Hi, Apa Kabar ?
                                                    </span>
                                                    <span class="time">17 minutes ago</span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <a class="see-all" href="javascript:void(0);">See all messages<i
                                            class="fa fa-angle-right"></i> </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown hidden-caret">
                            <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-bell"></i>
                                <span class="notification">4</span>
                            </a>
                            <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                                <li>
                                    <div class="dropdown-title">You have 4 new notification</div>
                                </li>
                                <li>
                                    <div class="notif-scroll scrollbar-outer">
                                        <div class="notif-center">
                                            <a href="#">
                                                <div class="notif-icon notif-primary"> <i class="fa fa-user-plus"></i>
                                                </div>
                                                <div class="notif-content">
                                                    <span class="block">
                                                        New user registered
                                                    </span>
                                                    <span class="time">5 minutes ago</span>
                                                </div>
                                            </a>
                                            <a href="#">
                                                <div class="notif-icon notif-success"> <i class="fa fa-comment"></i>
                                                </div>
                                                <div class="notif-content">
                                                    <span class="block">
                                                        Rahmad commented on Admin
                                                    </span>
                                                    <span class="time">12 minutes ago</span>
                                                </div>
                                            </a>
                                            <a href="#">
                                                <div class="notif-img">
                                                    <img src="../assets/img/profile2.jpg" alt="Img Profile">
                                                </div>
                                                <div class="notif-content">
                                                    <span class="block">
                                                        Reza send messages to you
                                                    </span>
                                                    <span class="time">12 minutes ago</span>
                                                </div>
                                            </a>
                                            <a href="#">
                                                <div class="notif-icon notif-danger"> <i class="fa fa-heart"></i>
                                                </div>
                                                <div class="notif-content">
                                                    <span class="block">
                                                        Farrah liked Admin
                                                    </span>
                                                    <span class="time">17 minutes ago</span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <a class="see-all" href="javascript:void(0);">See all notifications<i
                                            class="fa fa-angle-right"></i> </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown hidden-caret">
                            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                                <i class="fas fa-layer-group"></i>
                            </a>
                            <div class="dropdown-menu quick-actions quick-actions-info animated fadeIn">
                                <div class="quick-actions-header">
                                    <span class="title mb-1">Quick Actions</span>
                                    <span class="subtitle op-8">Shortcuts</span>
                                </div>
                                <div class="quick-actions-scroll scrollbar-outer">
                                    <div class="quick-actions-items">
                                        <div class="row m-0">
                                            <a class="col-6 col-md-4 p-0" href="#">
                                                <div class="quick-actions-item">
                                                    <i class="flaticon-file-1"></i>
                                                    <span class="text">Generated Report</span>
                                                </div>
                                            </a>
                                            <a class="col-6 col-md-4 p-0" href="#">
                                                <div class="quick-actions-item">
                                                    <i class="flaticon-database"></i>
                                                    <span class="text">Create New Database</span>
                                                </div>
                                            </a>
                                            <a class="col-6 col-md-4 p-0" href="#">
                                                <div class="quick-actions-item">
                                                    <i class="flaticon-pen"></i>
                                                    <span class="text">Create New Post</span>
                                                </div>
                                            </a>
                                            <a class="col-6 col-md-4 p-0" href="#">
                                                <div class="quick-actions-item">
                                                    <i class="flaticon-interface-1"></i>
                                                    <span class="text">Create New Task</span>
                                                </div>
                                            </a>
                                            <a class="col-6 col-md-4 p-0" href="#">
                                                <div class="quick-actions-item">
                                                    <i class="flaticon-list"></i>
                                                    <span class="text">Completed Tasks</span>
                                                </div>
                                            </a>
                                            <a class="col-6 col-md-4 p-0" href="#">
                                                <div class="quick-actions-item">
                                                    <i class="flaticon-file"></i>
                                                    <span class="text">Create New Invoice</span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown hidden-caret">
                            <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"
                                aria-expanded="false">
                                <div class="avatar-sm">
                                    <img src="{{ asset('images/gabito.jpg') }}" alt="..."
                                        class="avatar-img rounded-circle">
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-user animated fadeIn">
                                <div class="dropdown-user-scroll scrollbar-outer">
                                    <li>
                                        <div class="user-box">
                                            <div class="avatar-lg"><img src="{{ asset('images/gabito.jpg') }}"
                                                    alt="image profile" class="avatar-img rounded"></div>
                                            <div class="u-text">
                                                <h4>Angel David</h4>
                                                <p class="text-muted">GaboCraftYT@gmail.com</p><a href="profile.html"
                                                    class="btn btn-xs btn-secondary btn-sm">Ver perfil</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Mi perfil</a>
                                        <a class="dropdown-item" href="#">Mi saldo</a>
                                        <a class="dropdown-item" href="#">Bandeja de entrada</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Ajustes de la cuenta</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Cerrar Sesion</a>
                                    </li>
                                </div>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- End Navbar -->
        </div>

        <!-- Sidebar -->
        <div class="sidebar sidebar-style-2">
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <div class="user">
                        <div class="avatar-sm float-left mr-2">
                            <img src="{{ asset('images/gabito.jpg') }}" alt="..."
                                class="avatar-img rounded-circle">
                        </div>
                        <div class="info">
                            <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                                <span>
                                    Angel David
                                    <span class="user-level">Experto en rocket</span>
                                    <span class="caret"></span>
                                </span>
                            </a>
                            <div class="clearfix"></div>

                            <div class="collapse in" id="collapseExample">
                                <ul class="nav">
                                    <li>
                                        <a href="#profile">
                                            <span class="link-collapse">Mi perfil</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#edit">
                                            <span class="link-collapse">Editar perfil</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#settings">
                                            <span class="link-collapse">Configuracion</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <ul class="nav nav-primary">
                        {{$menu}}
                    </ul>
                </div>
            </div>
        </div>
        <!-- End Sidebar -->

        <!-- Main Panel -->
        <div class="main-panel">
            <div class="content">
                <div class="page-inner mt--10">
                    {{ $slot }}
                </div>
                <footer class="footer">
                    <div class="container-fluid">
                        <nav class="pull-left">
                            <ul class="nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="https://www.uniautonoma.edu.co">
                                        Pepemarco carreando
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="">
                                        Ayuda
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="https://github.com/SLarkZ01/Frontend_backend_laravel_blade_evaluacion_docente">
                                        Repositorio
                                    </a>
                                </li>
                            </ul>
                        </nav>
                        <div class="copyright ml-auto">
                            © Derchos reservados por los integrantes del proyecto 👨‍💻. la <a
                                href="https://www.uniautonoma.edu.co">Uniautonoma</a>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <!-- Fonts and icons -->
        <script src="{{ asset('js/sidebar/plugin/webfont/webfont.min.js') }}"></script>
        <!-- Core JS Files -->
        <script src="{{ asset('js/sidebar/core/jquery.3.2.1.min.js') }}"></script>
        <script src="{{ asset('js/sidebar/core/popper.min.js') }}"></script>
        <script src="{{ asset('js/sidebar/core/bootstrap.min.js') }}"></script>

        <!-- jQuery UI -->
        <script src="{{ asset('js/sidebar/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('js/sidebar/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>

        <!-- jQuery Scrollbar -->
        <script src="{{ asset('js/sidebar/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

        <!-- Chart JS -->
        <script src="{{ asset('js/sidebar/plugin/chart.js/chart.min.js') }}"></script>

        <!-- jQuery Sparkline -->
        <script src="{{ asset('js/sidebar/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

        <!-- Chart Circle -->
        <script src="{{ asset('js/sidebar/plugin/chart-circle/circles.min.js') }}"></script>

        <!-- Datatables -->
        <script src="{{ asset('js/sidebar/plugin/datatables/datatables.min.js') }}"></script>

        <!-- Bootstrap Notify -->
        <script src="{{ asset('js/sidebar/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

        <!-- jQuery Vector Maps -->
        <script src="{{ asset('js/sidebar/plugin/jqvmap/jquery.vmap.min.js') }}"></script>
        <script src="{{ asset('js/sidebar/plugin/jqvmap/maps/jquery.vmap.world.js') }}"></script>

        <!-- Sweet Alert -->
        <script src="{{ asset('js/sidebar/plugin/sweetalert/sweetalert.min.js') }}"></script>

        <!-- Atlantis Core JS -->
        <script src="{{ asset('js/sidebar/atlantis.min.js') }}"></script>
        <script src="{{ asset('js/sidebar/atlantis2.js') }}"></script>

        <script>
            WebFont.load({
                google: {
                    "families": ["Lato:300,400,700,900"]
                },
                custom: {
                    "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                        "simple-line-icons"
                    ],
                    urls: ["{{ asset('css/sidebar/fonts.css') }}"]
                },
                active: function() {
                    sessionStorage.fonts = true;
                }
            });
        </script>

</body>

</html>
