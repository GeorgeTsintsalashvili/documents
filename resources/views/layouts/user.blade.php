
<!DOCTYPE html>

<html lang="en">

<head>

    <title>მართვის პანელი</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="description" content="">

    <link href="/assets/css/snackbar.css" rel="stylesheet">
    <link rel='icon' type='image/ico' href='/images/general/logo.ico'/>
    <link href='https://fonts.googleapis.com/css?family=RobotoDraft:300,400,400italic,500,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,400italic,600,700' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="/fonts/flaticon/computer-parts/font/flaticon.css" type="text/css" media="all" />
    <link type="text/css" href="/fonts/font-awesome/css/all.min.css" rel="stylesheet"> <!-- Font Awesome -->
    <link type="text/css" href="/assets/css/styles.css" rel="stylesheet"> <!-- Core CSS with all styles -->

    <link type="text/css" href="/assets/plugins/jstree/dist/themes/avenger/style.min.css" rel="stylesheet"> <!-- jsTree -->
    <link type="text/css" href="/assets/plugins/codeprettifier/prettify.css" rel="stylesheet"> <!-- Code Prettifier -->
    <link type="text/css" href="/assets/plugins/iCheck/skins/minimal/blue.css" rel="stylesheet"> <!-- iCheck -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries. Placeholdr.js enables the placeholder attribute -->

    <link type="text/css" href="/assets/plugins/form-select2/select2.css" rel="stylesheet"> <!-- Select2 -->
    <link type="text/css" href="/assets/plugins/form-multiselect/css/multi-select.css" rel="stylesheet"> <!-- Multiselect -->
    <link type="text/css" href="/assets/plugins/form-tokenfield/bootstrap-tokenfield.css" rel="stylesheet"> <!-- Tokenfield -->
    <link type="text/css" href="/assets/plugins/switchery/switchery.css" rel="stylesheet">  <!-- Switchery -->

    <link type="text/css" href="/assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" rel="stylesheet"> <!-- Touchspin -->
    <link type="text/css" href="/assets/js/jqueryui.css" rel="stylesheet"> <!-- jQuery UI CSS -->

    <link type="text/css" href="/assets/plugins/iCheck/skins/minimal/_all.css" rel="stylesheet"> <!-- Custom Checkboxes / iCheck -->
    <link type="text/css" href="/assets/plugins/iCheck/skins/flat/_all.css" rel="stylesheet">
    <link type="text/css" href="/assets/plugins/iCheck/skins/square/_all.css" rel="stylesheet">
    <link type="text/css" href="/assets/plugins/card/lib/css/card.css" rel="stylesheet"> <!-- Card -->

    <!-- Add Input style JS and CSS files -->
    <link rel="stylesheet" type="text/css" href="/assets/plugins/custom-file-input/css/component.css">
    <script type="text/javascript" src="/assets/js/jquery-1.10.2.min.js"></script>

    <!--- fancybox --->
    <script type="text/javascript" src="/plugins/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
    <script type="text/javascript" src="/plugins/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
    <script type="text/javascript" src="/plugins/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
    <script type="text/javascript" src="/plugins/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>

</head>

<body class="infobar-overlay sidebar-hideon-collpase sidebar-scroll">

<header id="topnav" class="navbar navbar-midnightblue navbar-fixed-top clearfix" role="banner">

<span id="trigger-sidebar" class="toolbar-trigger toolbar-icon-bg">
	<a data-toggle="tooltips" data-placement="right" title="Toggle Sidebar">
    <span class="icon-bg">
      <i class="fa fa-fw fa-bars"></i>
    </span>
  </a>
</span>

<span id="trigger-infobar" class="toolbar-trigger toolbar-icon-bg">
 <a href="{{ route('logout') }}">
 <span class="icon-bg">
  <i class="fas fa-sign-out-alt"></i>
 </span>
</a>
</span>

<ul class="nav navbar-nav toolbar pull-right">
<li class="toolbar-icon-bg hidden-xs" id="trigger-fullscreen">
  <a href="#" class="toggle-fullscreen">
   <span class="icon-bg">
    <i class="fa fa-fw fa-arrows-alt"></i>
   </span>
  </a>
</li>
</ul>

</header>

<div id="wrapper">
 <div id="layout-static">
  <div class="static-sidebar-wrapper sidebar-inverse">
   <div class="static-sidebar">
    <div class="sidebar">
	  <div class="widget stay-on-collapse" id="widget-sidebar">
    <nav role="navigation" class="widget-body">
	   <ul class="acc-menu">
	    <li>
        <a class="home-link" href="{{ route('userhome') }}">
        <i class="fa fa-wrench" aria-hidden="true"></i>
        <span class="font-4">მომხმარებელი</span>
       </a>
      </li>

      <li>
        <a href="{{ route('useranalytics') }}">
        <i class="fas fa-chart-pie"></i>
        <span class="font-4">ანალიტიკა</span>
       </a>
      </li>

      <li>
        <a href="{{ route('userstatements') }}">
        <i class="fas fa-bullhorn"></i>
        <span class="font-4">განცხადებები</span>
       </a>
      </li>

    <li>
      <a href="{{ route('usercontact') }}">
        <i class="fa fa-info-circle"></i>
        <span class="font-4">კონტაქტი</span>
      </a>
    </li>

    <li class="hasChild">
      <a href="#">
        <i class="fas fa-cog"></i>
        <span class="font-4">პარამეტრები</span>
      </a>
      <ul class="acc-menu sidebar-sub-menu">
        <li>
          <a href="{{ route('paramsgeneral') }}">
           <i class="fas fa-sliders-h"></i>
           <span class="font-mtavruli">საერთო</span>
          </a>
        </li>
        <li>
          <a href="{{ route('paramscpu') }}">
           <i class="fas fa-microchip"></i>
           <span class="font-mtavruli">პროცესორის</span>
          </a>
        </li>
        <li>
          <a href="{{ route('paramsram') }}">
           <i class="fas fa-memory"></i>
           <span class="font-mtavruli">ოპერატიულის</span>
          </a>
        </li>
        <li>
          <a href="{{ route('paramsmtb') }}">
           <i class="flaticon-033-motherboard"></i>
           <span class="font-mtavruli">დედაპლატის</span>
          </a>
        </li>
        <li>
          <a href="{{ route('paramsvc') }}">
           <i class="flaticon-026-sound-card"></i>
           <span class="font-mtavruli">გრაფიკის</span>
          </a>
        </li>
        <li>
          <a href="{{ route('paramshdd') }}">
           <i class="flaticon-005-hdd"></i>
           <span class="font-mtavruli">HDD მეხსიერების</span>
          </a>
        </li>
        <li>
          <a href="{{ route('paramsssd') }}">
           <i class="flaticon-004-ssd"></i>
           <span class="font-mtavruli">SSD მეხსიერების</span>
          </a>
        </li>
        <li>
          <a href="{{ route('paramsodd') }}">
           <i class="flaticon-001-cd-drive"></i>
           <span class="font-mtavruli">დისკმძრავების</span>
          </a>
        </li>
        <li>
          <a href="{{ route('paramsmonitor') }}">
           <i class="fas fa-desktop"></i>
           <span class="font-mtavruli">მონიტორის</span>
          </a>
        </li>
        <li>
          <a href="{{ route('paramsncm') }}">
           <i class="fas fa-charging-station"></i>
           <span class="font-mtavruli">ნოუთბუქის დამტენის</span>
          </a>
        </li>
        <li>
          <a href="{{ route('paramsnd') }}">
           <i class="fas fa-project-diagram"></i>
           <span class="font-mtavruli">ქსელური აპარატურის</span>
          </a>
        </li>
        <li>
          <a href="{{ route('paramsperipherals') }}">
           <i class="flaticon-012-printer-1"></i>
           <span class="font-mtavruli">პერიფერიალების</span>
          </a>
        </li>
        <li>
          <a href="{{ route('paramsacc') }}">
           <i class="flaticon-018-mouse"></i>
           <span class="font-mtavruli">აქსესუარების</span>
          </a>
        </li>
      </ul>
    </li>

    <li>
      <a href="{{ route('userslides') }}">
        <i class="far fa-images"></i>
        <span class="font-4">სლაიდები</span>
      </a>
    </li>
    <li>
      <a href="{{ route('warranty') }}">
        <i class="fas fa-award" style="font-size: 20px"></i>
        <span class="font-4">საგარანტიო</span>
      </a>
    </li>
    <li>
      <a href="{{ route('invoice') }}">
        <i class="fas fa-file-invoice"></i>
        <span class="font-4">ინვოისი</span>
      </a>
    </li>
    <li>
      <a href="{{ route('usersb') }}">
        <i class="flaticon-016-tower"></i>
        <span class="font-4">სისტემური ბლოკები</span>
      </a>
    </li>
    <li class="hasChild">
      <a href="#">
        <i class="fas fa-tools"></i>
        <span class="font-4">ნაწილები</span>
      </a>
      <ul class="acc-menu sidebar-sub-menu">
        <li>
          <a href="{{ route('usercpu') }}">
           <i class="fas fa-microchip"></i>
           <span class="font-mtavruli">პროცესორები</span>
          </a>
        </li>
        <li>
          <a href="{{ route('usermm') }}">
           <i class="fas fa-memory"></i>
           <span class="font-mtavruli">ოპერატიულები</span>
          </a>
        </li>
        <li>
          <a href="{{ route('usermb') }}">
           <i class="flaticon-033-motherboard"></i>
           <span class="font-mtavruli">დედაპლატები</span>
          </a>
        </li>
        <li>
          <a href="{{ route('uservc') }}">
           <i class="flaticon-026-sound-card"></i>
           <span class="font-mtavruli">ვიდეო ბარათები</span>
          </a>
        </li>
        <li>
          <a href="{{ route('userhdd') }}">
           <i class="flaticon-005-hdd"></i>
           <span class="font-mtavruli">HDD მეხსიერება</span>
          </a>
        </li>
        <li>
          <a href="{{ route('userssd') }}">
           <i class="flaticon-004-ssd"></i>
           <span class="font-mtavruli">SSD მეხსიერება</span>
          </a>
        </li>
        <li>
          <a href="{{ route('userps') }}">
           <i class="flaticon-002-supply"></i>
           <span class="font-mtavruli">კვების ბლოკები</span>
          </a>
        </li>
        <li>
          <a href="{{ route('userpc') }}">
           <i class="flaticon-019-cooler"></i>
           <span class="font-mtavruli">CPU ქულერები</span>
          </a>
        </li>
        <li>
          <a href="{{ route('usercc') }}">
           <i class="flaticon-015-cooler-1"></i>
           <span class="font-mtavruli">კეისის ქულერები</span>
          </a>
        </li>
        <li>
          <a href="{{ route('usercases') }}">
           <i class="flaticon-003-tower-1"></i>
           <span class="font-mtavruli">კეისები</span>
          </a>
        </li>
        <li>
          <a href="{{ route('userodd') }}">
           <i class="flaticon-001-cd-drive"></i>
           <span class="font-mtavruli">დისკმძრავები</span>
          </a>
        </li>
       </ul>
    </li>

    <li>
      <a href="{{ route('usermonitors') }}">
        <i class="fas fa-desktop"></i>
        <span class="font-4">მონიტორები</span>
      </a>
    </li>

    <li>
      <a href="{{ route('useracc') }}">
        <i class="flaticon-018-mouse"></i>
        <span class="font-4">აქსესუარები</span>
      </a>
    </li>

    <li>
     <a href="{{ route('userups') }}">
       <i class="fa fa-plug"></i>
       <span class="font-4">უწყვეტი კვების წყარო</span>
      </a>
     </li>
     <li>
      <a href="{{ route('usernc') }}">
        <i class="fas fa-charging-station"></i>
        <span class="font-4">ნოუთბუქის დამტენები</span>
       </a>
      </li>
    <li>
      <a href="{{ route('usernd') }}">
        <i class="fas fa-project-diagram"></i>
        <span class="font-4">ქსელური აპარატურა</span>
      </a>
    </li>
    <li>
      <a href="{{ route('userperipherals') }}">
        <i class="flaticon-012-printer-1"></i>
        <span class="font-4">პერიფერიალები</span>
      </a>
    </li>
	   </ul>
    </nav>
   </div>
  </div>
 </div>
</div>

<div class="static-content-wrapper">
  <div class="static-content">
    <div class="page-content">
       <div class="container-fluid mt40" id="main-content">
         <!-- Page content start-->

          @yield('content')

         <!-- Page content end-->
        </div>
      </div>
    </div>

  <footer role="contentinfo">
    <div class="clearfix">
        <ul class="list-unstyled list-inline pull-left">
            <li>
              <h6 style="margin: 0"></h6>
            </li>
        </ul>
        <button class="pull-right btn btn-link btn-xs hidden-print" id="back-to-top">
          <i class="fa fa-arrow-up"></i>
        </button>
    </div>
   </footer>
  </div>
 </div>
</div>

<!--- snackbar element to display request response --->

<div id="snackbar">
 <i class="fa fa-info-circle"></i>
 <span class="message font-4"></span>
</div>

<!-- page load script -->

<script type="text/javascript" src="/assets/js/page-loader.js"></script>

<!-- Load jQuery -->

<script type="text/javascript" src="/assets/js/jqueryui-1.9.2.min.js"></script> <!-- Load jQueryUI -->
<script type="text/javascript" src="/assets/js/bootstrap.min.js"></script> 	<!-- Load Bootstrap -->

<script type="text/javascript" src="/assets/plugins/easypiechart/jquery.easypiechart.js"></script> <!-- EasyPieChart-->
<script type="text/javascript" src="/assets/plugins/sparklines/jquery.sparklines.min.js"></script> <!-- Sparkline -->
<script type="text/javascript" src="/assets/plugins/jstree/dist/jstree.min.js"></script> <!-- jsTree -->

<script type="text/javascript" src="/assets/plugins/codeprettifier/prettify.js"></script> <!-- Code Prettifier  -->
<script type="text/javascript" src="/assets/plugins/bootstrap-switch/bootstrap-switch.js"></script> <!-- Swith/Toggle Button -->

<script type="text/javascript" src="/assets/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js"></script>  <!-- Bootstrap Tabdrop -->
<script type="text/javascript" src="/assets/plugins/iCheck/icheck.min.js"></script>  <!-- iCheck -->

<script type="text/javascript" src="/assets/js/enquire.min.js"></script> <!-- Enquire for Responsiveness -->
<script type="text/javascript" src="/assets/plugins/bootbox/bootbox.js"></script>	<!-- Bootbox -->

<script type="text/javascript" src="/assets/plugins/nanoScroller/js/jquery.nanoscroller.min.js"></script> <!-- nano scroller -->
<script type="text/javascript" src="/assets/plugins/jquery-mousewheel/jquery.mousewheel.min.js"></script> 	<!-- Mousewheel support needed for jScrollPane -->

<script type="text/javascript" src="/assets/js/application.js"></script>
<script type="text/javascript" src="/assets/demo/demo.js"></script>
<script type="text/javascript" src="/assets/demo/demo-switcher.js"></script>

<!-- End loading site level scripts -->

<!-- Load page level scripts-->

<script type="text/javascript" src="/assets/plugins/form-multiselect/js/jquery.multi-select.min.js"></script> <!-- Multiselect Plugin -->
<script type="text/javascript" src="/assets/plugins/quicksearch/jquery.quicksearch.min.js"></script> <!-- Quicksearch to go with Multisearch Plugin -->
<script type="text/javascript" src="/assets/plugins/form-typeahead/typeahead.bundle.min.js"></script> <!-- Typeahead for Autocomplete -->
<script type="text/javascript" src="/assets/plugins/form-select2/select2.min.js"></script> <!-- Advanced Select Boxes -->
<script type="text/javascript" src="/assets/plugins/form-autosize/jquery.autosize-min.js"></script> <!-- Autogrow Text Area -->
<script type="text/javascript" src="/assets/plugins/form-colorpicker/js/bootstrap-colorpicker.min.js"></script> <!-- Color Picker -->
<script type="text/javascript" src="/assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js"></script> <!-- Touchspin -->

<!-- Fullscreen Editor -->

<script type="text/javascript" src="/assets/plugins/form-jasnyupload/fileinput.min.js"></script> <!-- File Input -->
<script type="text/javascript" src="/assets/plugins/form-tokenfield/bootstrap-tokenfield.min.js"></script>  <!-- Tokenfield -->
<script type="text/javascript" src="/assets/plugins/switchery/switchery.js"></script>  <!-- Switchery -->

<script type="text/javascript" src="/assets/plugins/card/lib/js/card.js"></script> <!-- Card -->
<script type="text/javascript" src="/assets/plugins/bootstrap-switch/bootstrap-switch.js"></script> <!-- BS Switch -->
<script type="text/javascript" src="/assets/plugins/jquery-chained/jquery.chained.min.js"></script> <!-- Chained Select Boxes -->

<script type="text/javascript" src="/assets/plugins/jquery-mousewheel/jquery.mousewheel.min.js"></script> <!-- MouseWheel Support -->
<script type="text/javascript" src="/assets/demo/demo-formcomponents.js"></script>
<script type="text/javascript" src="/assets/plugins/wijets/wijets.js"></script> <!-- Wijet -->

 <!-- End loading page level scripts-->

 </body>
</html>
