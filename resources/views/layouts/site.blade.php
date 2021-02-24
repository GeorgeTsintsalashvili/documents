<!DOCTYPE HTML>

<html lang="ka">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    @if($generalData['seoFieldsExist'])

    <title> {{ $generalData['seoFields'] -> title }} </title>

    <meta property="og:type" content="website"/>
    <meta property="og:url" content="{{ url() -> current() }}"/>
    <meta property="og:title" content="{{ $generalData['seoFields'] -> title }}" />
    <meta property="og:description" content="{{ $generalData['seoFields'] -> description }}" />
    <meta property="og:image" content="" />

    <meta name="description" content="{{ $generalData['seoFields'] -> description }}"/>
    <meta name="keywords" content="{{ $generalData['seoFields'] -> keywords }}"/>

    @endif

	  <meta name="viewport" content="width=device-width, minimum-scale=0.25, maximum-scale=1.6, initial-scale=1.0"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>

    <link rel="icon" href="/images/general/logo.ico">
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,200i,300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <link rel="stylesheet" href="/themes/css/product.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/themes/css/scenes.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/js/jquery/ui/themes/base/jquery.ui.core.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="/js/jquery/ui/themes/base/jquery.ui.slider.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="/js/jquery/ui/themes/base/jquery.ui.theme.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="/themes/css/modules/blocklayered/blocklayered.css" type="text/css" media="all"/>

    <link rel="stylesheet" href="/themes/css/autoload/highdpi.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/themes/css/autoload/responsive-tables.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/themes/css/autoload/uniform.default.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/js/jquery/plugins/fancybox/jquery.fancybox.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/themes/css/product_list.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/themes/css/modules/blockbestsellers/blockbestsellers.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/js/jquery/plugins/bxslider/jquery.bxslider.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/themes/css/modules/blockcategories/blockcategories.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/themes/css/modules/blockcurrencies/blockcurrencies.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/themes/css/modules/blocklanguages/blocklanguages.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/themes/css/modules/blockcontact/blockcontact.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/themes/css/modules/blockmyaccountfooter/blockmyaccount.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/themes/css/modules/blocknewproducts/blocknewproducts.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/themes/css/modules/blocknewsletter/blocknewsletter.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/themes/css/modules/blockspecials/blockspecials.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/themes/css/modules/blocktags/blocktags.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/themes/css/modules/blockuserinfo/blockuserinfo.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/themes/css/modules/blockviewed/blockviewed.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/themes/css/modules/homefeatured/homefeatured.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/modules/themeoptions/plugins/bootstrap-select-1.9.3/dist/css/bootstrap-select.min.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/modules/themeoptions/bootstrap/css/bootstrap.min.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/css/global.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/modules/themeoptions/plugins/scrollbar/jquery.mCustomScrollbar.min.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/fonts/font-awesome/css/all.min.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/fonts/flaticon/computer-parts/font/flaticon.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/modules/themeoptions/font/pe-icon-7-stroke/css/pe-icon-7-stroke.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/modules/themeoptions/font/pe-icon-7-stroke/css/helper.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/themes/css/modules/themeoptions/dorthemes.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/modules/themeoptions/css/owl.carousel.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/modules/themeoptions/plugins/slick/slick.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/modules/themeoptions/css/header/headerskin1.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/modules/themeoptions/css/footer/footerskin1.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/modules/themeoptions/css/topbar/topbarskin1.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/modules/ajaxtabproductcategory/assets/css/ajaxtabproductcategory.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/modules/ajaxtabsidebar_product/assets/css/ajaxtabsidebar_product.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/modules/dailydeals/views/css/dailydeals.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/modules/flipimage/css/flipimage.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/themes/css/modules/homeslider/homeslider.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/modules/categories/categories.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/modules/categories/animate.delay.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/modules/categories/animate.min.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/modules/dormegamenu/views/css/style.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/modules/searchcategories/dorsearch.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/modules/dorverticalmenu/views/css/dorverticalmenu.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/modules/tabproductcategory_pro/assets/css/tabproductcategory_pro.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/modules/tablistcategory/assets/css/tablistcategory.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/modules/tablistcategory2/assets/css/tablistcategory2.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/modules/viewedproducts/assets/css/dorblockviewed.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/themes/css/modules/blockwishlist/blockwishlist.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/themes/css/theme-default.css" type="text/css" />
    <link rel="stylesheet" href="/themes/css/dortopbar.css" type="text/css" />
    <link rel="stylesheet" href="/themes/css/dorheader.css" type="text/css" />
    <link rel="stylesheet" href="/themes/css/style.css" type="text/css" />
    <link rel="stylesheet" href="/themes/css/theme.css" type="text/css" />
    <link rel="stylesheet" href="/themes/css/responsive.css" type="text/css" />
    <link rel="stylesheet" href="/modules/range-picker/css/jquery.range.css" type="text/css" />
    <link rel="stylesheet" href="/themes/css/modules/themeoptions/color/color.css" type="text/css" data-style="color" />
    <link rel="stylesheet" href="/themes/css/modules/themeoptions/fonts/font.css" type="text/css" data-style="font" />
    <link rel="stylesheet" href="/css/live-search.css">

    <script type="text/javascript" src="/js/jquery/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="/js/jquery/plugins/jquery.idTabs.js"></script>
    <script type="text/javascript" src="/js/jquery/ui/jquery.ui.core.min.js"></script>
    <script type="text/javascript" src="/js/jquery/ui/jquery.ui.widget.min.js"></script>
    <script type="text/javascript" src="/js/jquery/ui/jquery.ui.mouse.min.js"></script>
    <script type="text/javascript" src="/js/jquery/ui/jquery.ui.slider.min.js"></script>

    <script type="text/javascript" src="/js/jquery/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="/js/jquery/plugins/jquery.easing.js"></script>
    <script type="text/javascript" src="/js/global.js"></script>
    <script type="text/javascript" src="/themes/js/autoload/10-bootstrap.min.js"></script>
    <script type="text/javascript" src="/themes/js/autoload/15-jquery.total-storage.min.js"></script>
    <script type="text/javascript" src="/themes/js/autoload/15-jquery.uniform-modified.js"></script>
    <script type="text/javascript" src="/js/jquery/plugins/fancybox/jquery.fancybox.js"></script>

    <script type="text/javascript" src="/js/jquery/plugins/jquery.scrollTo.js"></script>
    <script type="text/javascript" src="/js/jquery/plugins/jquery.serialScroll.js"></script>
    <script type="text/javascript" src="/js/jquery/plugins/bxslider/jquery.bxslider.js"></script>
    <script type="text/javascript" src="/themes/js/tools/treeManagement.js"></script>
    <script type="text/javascript" src="/modules/themeoptions/js/owl.carousel.min.js"></script>
    <script type="text/javascript" src="/modules/themeoptions/js/jquery.bpopup.min.js"></script>
    <script type="text/javascript" src="/modules/themeoptions/plugins/bootstrap-select-1.9.3/js/bootstrap-select.js"></script>
    <script type="text/javascript" src="/modules/themeoptions/plugins/scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
    <script type="text/javascript" src="/modules/themeoptions/plugins/slick/slick.min.js"></script>
    <script type="text/javascript" src="/modules/ajaxtabproductcategory/assets/js/ajaxtabproductcategory.js"></script>
    <script type="text/javascript" src="/modules/ajaxtabsidebar_product/assets/js/ajaxtabsidebar_product.js"></script>

    <script type="text/javascript" src="/modules/categories/categories.js"></script>
    <script type="text/javascript" src="/modules/dormegamenu/views/js/script.js"></script>
    <script type="text/javascript" src="/modules/dorverticalmenu/views/js/dorverticalmenu.js"></script>
    <script type="text/javascript" src="/modules/tabproductcategory_pro/assets/js/tabproductcategory_pro.js"></script>
    <script type="text/javascript" src="/modules/tablistcategory/assets/js/tablistcategory.js"></script>
    <script type="text/javascript" src="/modules/tablistcategory2/assets/js/tablistcategory2.js"></script>
    <script type="text/javascript" src="/modules/viewedproducts/assets/js/dorblockviewed.js"></script>

</head>

<body id="index" class="proDetailCol1 proCateCol2 dorHoverProduct2 index hide-left-column hide-right-column lang_en  dor-list-effect-pizza2">

<!-- Load Facebook SDK for JavaScript -->

<div id="fb-root"></div>

<script>

    window.fbAsyncInit = function() {
          FB.init({
            xfbml            : true,
            version          : 'v5.0'
          });
        };

        (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = '/js/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));

</script>

<!-- Facebook customer chat code -->

<div class="fb-customerchat" attribution=setup_tool page_id="425829564213269" logged_in_greeting="გამარჯობა, რით შემიძლია დაგეხმაროთ?" logged_out_greeting="გამარჯობა, რით შემიძლია დაგეხმაროთ?" minimized="true"></div>

<!-- Header section -->

    <div id="page" class="headerskin1 full">
        <div id="dor-topbar01" class="dor-topbar-wrapper">
            <div class="dor-topbar-inner">
                <div class="container">
                    <div class="row">
                        <div class="dor-topbar-line">
                            <div class="dor-topbar-line-inner">
                                <div class="dor-topbar-line-wrapper row">
                                    <div class="topbar-infomation col-lg-8 col-sm-8 pull-left">
                                        <ul>
                                            <li class="time-work font-4">
                                              <span>
                                                <i class="far fa-calendar-alt"></i>
                                                {{ $generalData['contact'] -> schedule }}
                                              </span>
                                            </li>
                                            <li class="phone-shop font-4">
											                       <span>
                                               <i class="fa fa-phone"></i>
                                               {{ $generalData['contact'] -> phone }}
                                             </span>
                                            </li>
                                            <li class="mail-shop font-4">
                                              <span><i class="fa fa-envelope"></i>
                                                {{ $generalData['contact'] -> email }}
                                              </span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="topbar-infomation-right col-lg-4 col-sm-4 pull-right">
                                        <ul>
                                          <li class="store-location">
                                            <a href="{{ $generalData['contact'] -> googleMapLink }}" target="_blank">
                                            <span class="font-4">
                                              <i class="fas fa-map-marker" aria-hidden="true"></i>
                                               {{ $generalData['contact'] -> address }}
                                            </span>
                                           </a>
                                          </li>
                                          <li class="free-ship">
                                            <span class="font-4">
                                              <i class="fas fa-truck"></i>
                                              {{ $generalData['contact'] -> delivery }}
                                            </span>
                                          </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="#" rel="nofollow" class="select-setting hidden pull-right">
                          <i class="material-icons">&#xE8B8;</i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <header id="header" class="header-absolute">
            <div id="dor-header01" class="header-content-wrapper dor-header">
                <div class="header-top">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-2 dor-main-logo">
                                <div class="main-logo-inner">
                                    <div class="main-logo-wrapper">
                                        <div class="item-logo" id="_desktop_logo">
                                           <div class="h1-logo no-margin">
			                                      <a href="/">
							                               <img class="logo img-responsive" src="/images/general/logo.png"/>
						                                </a>
			                                     </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="dor-mainmenu-inner col-md-10">
                                <div class="head-dormenu">
                                    <nav class="dor-megamenu col-lg-12 clearfix">
                                        <div class="navbar navbar-default " role="navigation">
                                            <!-- Brand and toggle get grouped for better mobile display -->
                                            <div class="navbar-header">
                                                <button type="button" class="navbar-toggle open-menu" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                                                    <span class="sr-only"></span>
                                                    <span class="icon-bar"></span>
                                                    <span class="icon-bar"></span>
                                                    <span class="icon-bar"></span>
                                                </button>
                                            </div>
                                            <!-- Collect the nav links, forms, and other content for toggling -->
                                            <div id="dor-top-menu" class="collapse navbar-collapse navbar-ex1-collapse">
                                                <div class="close_menu" style="display:none">
                                                    <span class="btn-close"><i class="material-icons">&#xE14C;</i></span>
                                                </div>
                                                <ul class="nav navbar-nav megamenu">
                                                  <li>
                                                      <a target="_self" data-rel="5" href="/">
                                                      <i class="fa fa-home menu-icon" aria-hidden="true"></i>
                                                      <span class="menu-title font-3">მთავარი</span>
                                                     </a>
                                                  </li>
                                                  <li class=" parent dropdown aligned-fullwidth">
                                                   <a class="dropdown-toggle" data-toggle="dropdown" data-rel="4" href="javascript:void(0)">
                                                    <i class="fas fa-store menu-icon" aria-hidden="true"></i>
                                                    <span class="menu-title font-3">მაღაზია</span>
                                                    <b class="caret"></b>
                                                   </a>
                                                   <span class="caretmobile hidden"></span>
                                                      <ul class="dropdown-menu level1 megamenu-content" role="menu" style="width:300px">
                                                          <li>
                                                              <div class="row">
                                                                  <div class="col-sm-4">
                                                                      <div class="widget-content">
                                                                          <div class="widget-subcategories block">
                                                                              <div class="widget-heading title_block">
                                                                                  <a href="#" class="img">
                                                                                    <span class="font-3">კომპიუტერის ნაწილები</span>
                                                                                  </a>
                                                                                  <span class="caretmobile hidden"></span>
                                                                              </div>
                                                                              <div class="widget-inner block_content">
                                                                                  <div class="widget-heading hidden">
                                                                                      <a href="#" class="img"></a>
                                                                                      <span class="caretmobile hidden"></span>
                                                                                  </div>
                                                                                  <ul>
                                                                                      <li class="clearfix">
                                                                                          <a href="{{ route('cpu') }}" class="img">
                                                                                           <i class="fa fa-angle-double-right"></i>
                                                                                           <span class="font-4">პროცესორები</span>
                                                                                          </a>
                                                                                      </li>
                                                                                      <li class="clearfix">
                                                                                          <a href="{{ route('mb') }}" class="img">
                                                                                           <i class="fa fa-angle-double-right"></i>
                                                                                           <span class="font-4">დედაპლატები</span>
                                                                                          </a>
                                                                                      </li>
                                                                                      <li class="clearfix">
                                                                                          <a href="{{ route('mm') }}" class="img">
                                                                                           <i class="fa fa-angle-double-right"></i>
                                                                                           <span class="font-4">ოპერატიულები</span>
                                                                                          </a>
                                                                                      </li>
                                                                                      <li class="clearfix">
                                                                                          <a href="{{ route('vc') }}" class="img">
                                                                                           <i class="fa fa-angle-double-right"></i>
                                                                                           <span class="font-4">ვიდეო ბარათები</span>
                                                                                          </a>
                                                                                      </li>
                                                                                      <li class="clearfix">
                                                                                          <a href="{{ route('hdd') }}" class="img">
                                                                                           <i class="fa fa-angle-double-right"></i>
                                                                                           <span class="font-4">HDD მეხსიერება</span>
                                                                                          </a>
                                                                                      </li>
                                                                                      <li class="clearfix">
                                                                                          <a href="{{ route('ssd') }}" class="img">
                                                                                           <i class="fa fa-angle-double-right"></i>
                                                                                           <span class="font-4">SSD მეხსიერება</span>
                                                                                          </a>
                                                                                      </li>
                                                                                      <li class="clearfix">
                                                                                          <a href="{{ route('cases') }}" class="img">
                                                                                           <i class="fa fa-angle-double-right"></i>
                                                                                           <span class="font-4">კეისები</span>
                                                                                         </a>
                                                                                      </li>
                                                                                      <li class="clearfix">
                                                                                          <a href="{{ route('ps') }}" class="img">
                                                                                           <i class="fa fa-angle-double-right"></i>
                                                                                           <span class="font-4">კვების ბლოკები</span>
                                                                                         </a>
                                                                                      </li>
                                                                                      <li class="clearfix">
                                                                                          <a href="{{ route('pc') }}" class="img">
                                                                                           <i class="fa fa-angle-double-right"></i>
                                                                                           <span class="font-4">პროცესორის ქულერები</span>
                                                                                         </a>
                                                                                      </li>
                                                                                      <li class="clearfix">
                                                                                          <a href="{{ route('cc') }}" class="img">
                                                                                           <i class="fa fa-angle-double-right"></i>
                                                                                           <span class="font-4">კეისის ქულერები</span>
                                                                                         </a>
                                                                                      </li>
                                                                                      <li class="clearfix">
                                                                                          <a href="{{ route('odd') }}" class="img">
                                                                                           <i class="fa fa-angle-double-right"></i>
                                                                                           <span class="font-4">დისკმძრავები</span>
                                                                                         </a>
                                                                                      </li>
                                                                                  </ul>
                                                                              </div>
                                                                          </div>
                                                                      </div>
                                                                  </div>
                                                                  <div class="col-sm-4">
                                                                      <div class="widget-content">
                                                                          <div class="widget-subcategories block">
                                                                              <div class="widget-heading title_block">
                                                                                  <a href="#" class="img">
                                                                                    <span class="font-3">აქსესუარები</span>
                                                                                  </a>
                                                                                  <span class="caretmobile hidden"></span>
                                                                              </div>
                                                                              <div class="widget-inner block_content">
                                                                                  <div class="widget-heading hidden">
                                                                                      <a href="#" class="img"></a>
                                                                                      <span class="caretmobile hidden"></span>
                                                                                  </div>
                                                                                  <ul>

                                                                                    @foreach($generalData['accessoriesTypes'] as $value)
                                                                                      <li class="clearfix">
                                                                                          <a href="{{ route('accByType', ['id' => $value -> id]) }}" class="img">
                                                                                            <i class="fa fa-angle-double-right"></i>
                                                                                            <span class="font-4">{{ $value -> typeTitle }}</span>
                                                                                          </a>
                                                                                      </li>
                                                                                     @endforeach
                                                                                  </ul>
                                                                              </div>
                                                                          </div>
                                                                      </div>
                                                                  </div>
                                                                  <div class="col-sm-4">
                                                                      <div class="widget-content">
                                                                          <div class="widget-subcategories block">
                                                                              <div class="widget-heading title_block">
                                                                                  <a href="#" title="" class="img">
                                                                                    <span class="font-3">ქსელური მოწყობილობები</span>
                                                                                  </a>
                                                                                  <span class="caretmobile hidden"></span>
                                                                               </div>
                                                                               <div class="widget-inner block_content">
                                                                                  <div class="widget-heading hidden">
                                                                                      <a href="#" class="img"></a>
                                                                                      <span class="caretmobile hidden"></span>
                                                                                  </div>
                                                                                  <ul>

                                                                                      @foreach($generalData['networkDevicesTypes'] as $key => $value)
                                                                                        <li class="clearfix">
                                                                                            <a href="{{ route('ndByType', ['id' => $value -> id]) }}" class="img">
                                                                                              <i class="fa fa-angle-double-right"></i>
                                                                                              <span class="font-4"> {{ $value -> typeTitle }} </span>
                                                                                            </a>
                                                                                        </li>
                                                                                     @endforeach
                                                                                  </ul>
                                                                              </div>
                                                                          </div>
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                              <div class="row">
                                                               <div class="col-sm-4">
                                                                  <div class="widget-content">
                                                                      <div class="widget-subcategories block">
                                                                          <div class="widget-heading title_block">
                                                                              <a href="#" class="img">
                                                                                <span class="font-3">პერიფერიალები</span>
                                                                              </a>
                                                                              <span class="caretmobile hidden"></span>
                                                                          </div>
                                                                          <div class="widget-inner block_content">
                                                                              <div class="widget-heading hidden">
                                                                                  <a href="#" class="img"></a>
                                                                                  <span class="caretmobile hidden"></span>
                                                                              </div>
                                                                              <ul>

                                                                                @foreach($generalData['peripheralsTypes'] as $value)
                                                                                  <li class="clearfix">
                                                                                      <a href="{{ route('perByType', ['id' => $value -> id]) }}" data-rel="sub-32" class="img">
                                                                                         <i class="fa fa-angle-double-right"></i>
                                                                                         <span class="font-4"> {{ $value -> typeTitle }} </span>
                                                                                      </a>
                                                                                  </li>
                                                                                @endforeach
                                                                              </ul>
                                                                          </div>
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                              <div class="col-sm-4">
                                                                  <div class="widget-content">
                                                                      <div class="widget-subcategories block">
                                                                          <div class="widget-heading title_block">
                                                                              <a href="#" title="" class="img">
                                                                                 <span class="font-3">კომპიუტერის კომპონენტები</span>
                                                                              </a>
                                                                              <span class="caretmobile hidden"></span>
                                                                          </div>
                                                                          <div class="widget-inner block_content">
                                                                              <div class="widget-heading hidden">
                                                                                  <a href="#" class="img"></a>
                                                                                  <span class="caretmobile hidden"></span>
                                                                              </div>
                                                                              <ul>
                                                                                  <li class="clearfix">
                                                                                      <a href="{{ route('sb') }}" data-rel="sub-46" class="img">
                                                                                         <i class="fa fa-angle-double-right"></i>
                                                                                         <span class="font-4">სისტემური ბლოკები</span>
                                                                                      </a>
                                                                                  </li>
                                                                                  <li class="clearfix">
                                                                                      <a href="{{ route('monitors') }}" data-rel="sub-47" class="img">
                                                                                        <i class="fa fa-angle-double-right"></i>
                                                                                        <span class="font-4">მონიტორები</span>
                                                                                      </a>
                                                                                  </li>
                                                                                  <li class="clearfix">
                                                                                      <a href="{{ route('ups') }}" data-rel="sub-48" class="img">
                                                                                          <i class="fa fa-angle-double-right"></i>
                                                                                          <span class="font-4">უწყვეტი კვების წყარო</span>
                                                                                       </a>
                                                                                  </li>
                                                                                  <li class="clearfix">
                                                                                      <a href="{{ route('nc') }}" data-rel="sub-48" class="img">
                                                                                          <i class="fa fa-angle-double-right"></i>
                                                                                          <span class="font-4">ნოუთბუქის დამტენები</span>
                                                                                       </a>
                                                                                  </li>
                                                                              </ul>
                                                                          </div>
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                            </div>
                                                          </li>
                                                      </ul>
                                                  </li>

                                                    <li class=" parent dropdown aligned-fullwidth">
                                                     <a class="dropdown-toggle" data-toggle="dropdown" data-rel="4" href="javascript:void(0)">
													                            <i class="fa fa-wrench menu-icon" aria-hidden="true"></i>
													                            <span class="menu-title font-3">სერვისები</span>
                                                      <b class="caret"></b>
                                                     </a>

                                                    </li>
                                                    <li>
		                                                  <a data-rel="5" href="/configurator">
                                                       <i class="fas fa-cog menu-icon"></i>
													                             <span class="menu-title font-3">კონფიგურატორი</span>
													                            </a>
                                                    </li>
                                                    <li>
													                             <a data-rel="6" href="/contact">
													                              <i class="fa fa-address-book menu-icon"></i>
													                              <span class="menu-title font-3">კონტაქტი</span>
													                             </a>
													                          </li>
													                            <li>
													                             <a data-rel="6" href="/shoppingCart">
													                              <i class="fas fa-shopping-basket menu-icon"></i>
													                              <span class="menu-title font-3">კალათა</span>
													                             </a>
													                          </li>
                                                 </ul>
                                            </div>
                                        </div>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="header-piz-line no-padding">
                    <div class="container">
                        <div class="row">
                            <div id="dor-verticalmenu" class="block block-info nopadding closes">

                                <div class="dor-vertical-title">
                                    <div class="vertical-menu-head">
                                        <div class="vertical-menu-head-inner">
                                            <div class="vertical-menu-head-wrapper">
                                              <div class="fa-icon-menu">
                                                <i class="fa fa-list"></i>
                                              </div>
                                              <h3 class="dor_title_block">
                                               <span class="font-3 product-categories">პროდუქციის კატალოგი</span>
                                              </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="dor-verticalmenu block_content">
                                    <div class="navbar navbar-default">
                                        <div class="controll-vertical-mobile clearfix hidden">
                                            <div class="navbar-header vertical-menu-header hidden">
                                                <button type="button" class="navbar-toggle open_menu">
                                                    <i class="material-icons">&#xE8FE;</i>
                                                </button>
                                            </div>
                                            <div class="close_menu_vertical" style="display:none">
                                                <span class="btn-close" style="padding: 5px"><i class="material-icons">&#xE14C;</i></span>
                                            </div>
                                        </div>
                                        <div class="verticalmenu" role="navigation">
                                            <div class="navbar-header">
                                                <div class="navbar-collapse navbar-ex1-collapse">
                                                    <ul class="nav navbar-nav verticalmenu">
                                                       <li>
														                            <a target="_self" href="{{ route('sb') }}">
														                             <i class="flaticon-016-tower"></i>
														                             <span class="menu-title font-4"> სისტემური ბლოკები</span>
														                            </a>
													                             </li>

                                                       <li>
                                                       <a target="_self" href="{{ route('monitors') }}">
                                                         <i class="fas fa-desktop"></i>
                                                        <span class="menu-title font-4"> მონიტორები</span>
                                                       </a>
                                                      </li>

                                                      <li class=" parent dropdown aligned-left">
                                                       <a class="has-sub-menu dropdown-toggle-" data-toggle="dropdown-" target="self" href="#">
                                                        <i class="fas fa-tools"></i>
                                                        <span class="menu-title font-4"> კომპიუტერის ნაწილები </span>
                                                        <i class="menu-sign fa fa-plus" data-minus="0" aria-hidden="true"> </i>
                                                       </a>
                                                       <ul role="menu" class="sub-menu">
                                                           <li>
                                                               <div class="row">
                                                                   <div class="col-sm-12">
                                                                       <div class="widget-content">
                                                                           <div class="widget-links">
                                                                               <div class="widget-inner block_content">
                                                                                   <div id="tabs1234000592" class="panel-group">
                                                                                       <ul class="nav-links" data-id="myTab">
                                                                                         <li>
                                                                                           <a href="{{ route('cpu') }}">
                                                                                             <i class="fas fa-microchip"></i>
                                                                                            <span class="font-4"> პროცესორები</span>
                                                                                           </a>
                                                                                         </li>
                                                                                          <li>
                                                                                            <a href="{{ route('mb') }}">
                                                                                              <i class="flaticon-033-motherboard"></i>
                                                                                             <span class="font-4"> დედაპლატები</span>
                                                                                            </a>
                                                                                          </li>
                                                                                          <li>
                                                                                            <a href="{{ route('mm') }}">
                                                                                             <i class="fas fa-memory"></i>
                                                                                             <span class="font-4"> ოპერატიულები</span>
                                                                                            </a>
                                                                                          </li>
                                                                                          <li>
                                                                                            <a href="{{ route('vc') }}">
                                                                                             <i class="flaticon-026-sound-card"></i>
                                                                                             <span class="font-4"> ვიდეო ბარათები</span>
                                                                                            </a>
                                                                                          </li>
                                                                                          <li>
                                                                                            <a href="{{ route('hdd') }}">
                                                                                             <i class="flaticon-005-hdd"></i>
                                                                                             <span class="font-4"> HDD მეხსიერება</span>
                                                                                            </a>
                                                                                          </li>

                                                                                          <li>
                                                                                            <a href="{{ route('ssd') }}">
                                                                                             <i class="flaticon-004-ssd"></i>
                                                                                             <span class="font-4"> SSD მეხსიერება</span>
                                                                                            </a>
                                                                                          </li>

                                                                                          <li>
                                                                                            <a href="{{ route('cases') }}">
                                                                                             <i class="flaticon-003-tower-1"></i>
                                                                                             <span class="font-4"> კეისები</span>
                                                                                            </a>
                                                                                          </li>
                                                                                          <li>
                                                                                            <a href="{{ route('ps') }}">
                                                                                             <i class="flaticon-002-supply"></i>
                                                                                             <span class="font-4"> კვების ბლოკები</span>
                                                                                            </a>
                                                                                          </li>
                                                                                          <li>
                                                                                            <a href="{{ route('pc') }}">
                                                                                             <i class="flaticon-019-cooler"></i>
                                                                                             <span class="font-4"> პროცესორის ქულერები</span>
                                                                                            </a>
                                                                                          </li>
                                                                                          <li>
                                                                                            <a href="{{ route('cc') }}">
                                                                                             <i class="flaticon-015-cooler-1"></i>
                                                                                             <span class="font-4"> კეისის ქულერები</span>
                                                                                            </a>
                                                                                          </li>
                                                                                          <li>
                                                                                            <a href="{{ route('odd') }}">
                                                                                             <i class="flaticon-001-cd-drive"></i>
                                                                                             <span class="font-4"> დისკმძრავები</span>
                                                                                            </a>
                                                                                          </li>
                                                                                       </ul>
                                                                                   </div>
                                                                               </div>
                                                                           </div>

                                                                       </div>
                                                                   </div>
                                                               </div>
                                                           </li>
                                                        </ul>
                                                       </li>


                                                        <li class=" parent dropdown aligned-left">
                                                         <a class="has-sub-menu dropdown-toggle-" data-toggle="dropdown-" target="self" href="#">
                                                          <i class="flaticon-018-mouse"></i>
                                                          <span class="menu-title font-4"> აქსესუარები </span>
                                                          <i class="menu-sign fa fa-plus" data-minus="0" aria-hidden="true"> </i>
                                                         </a>
                                                         <ul role="menu" class="sub-menu">
                                                             <li>
                                                                 <div class="row">
                                                                     <div class="col-sm-12">
                                                                         <div class="widget-content">
                                                                             <div class="widget-links">
                                                                                 <div class="widget-inner block_content">
                                                                                     <div id="tabs1234000592" class="panel-group">
                                                                                         <ul class="nav-links" data-id="myTab">
                                                                                           @foreach($generalData['accessoriesTypes'] as $value)
                                                                                           <li>
                                                                                             <a href="{{ route('accByType', ['id' => $value -> id]) }}">
                                                                                               <i class="{{ $value -> icon }}"></i>
                                                                                              <span class="font-4"> {{ $value -> typeTitle }} </span>
                                                                                             </a>
                                                                                           </li>
                                                                                          @endforeach
                                                                                         </ul>
                                                                                     </div>
                                                                                 </div>
                                                                             </div>
                                                                         </div>
                                                                     </div>
                                                                 </div>
                                                             </li>
                                                          </ul>
                                                         </li>

                                                         <li class="parent dropdown aligned-left">
                                                          <a class="has-sub-menu dropdown-toggle-" data-toggle="dropdown-" target="self" href="#">
                                                           <i class="fas fa-network-wired"></i>
                                                           <span class="menu-title font-4"> ქსელური მოწყობილობები </span>
                                                           <i class="menu-sign fa fa-plus" data-minus="0" aria-hidden="true"> </i>
                                                          </a>
                                                          <ul role="menu" class="sub-menu">
                                                              <li>
                                                                  <div class="row">
                                                                      <div class="col-sm-12">
                                                                          <div class="widget-content">
                                                                              <div class="widget-links">
                                                                                  <div class="widget-inner block_content">
                                                                                      <div id="tabs1234000592" class="panel-group">
                                                                                          <ul class="nav-links" data-id="myTab">
                                                                                            @foreach($generalData['networkDevicesTypes'] as $value)
                                                                                            <li>
                                                                                              <a href="{{ route('ndByType', ['id' => $value -> id]) }}">
                                                                                                <i class="{{ $value -> icon }}"></i>
                                                                                               <span class="font-4"> {{ $value -> typeTitle }} </span>
                                                                                              </a>
                                                                                            </li>
                                                                                           @endforeach
                                                                                          </ul>
                                                                                      </div>
                                                                                  </div>
                                                                              </div>

                                                                          </div>
                                                                      </div>
                                                                  </div>
                                                              </li>
                                                           </ul>
                                                          </li>

                                                          <li class=" parent dropdown aligned-left">
                                                           <a class="has-sub-menu dropdown-toggle-" data-toggle="dropdown-" target="self" href="#">
                                                            <i class="flaticon-012-printer-1"></i>
                                                            <span class="menu-title font-4"> პერიფერიალები</span>
                                                            <i class="menu-sign fa fa-plus" data-minus="0" aria-hidden="true"> </i>
                                                           </a>
                                                           <ul role="menu" class="sub-menu">
                                                               <li>
                                                                   <div class="row">
                                                                       <div class="col-sm-12">
                                                                           <div class="widget-content">
                                                                               <div class="widget-links">
                                                                                   <div class="widget-inner block_content">
                                                                                       <div id="tabs1234000592" class="panel-group">
                                                                                           <ul class="nav-links" data-id="myTab">
                                                                                             @foreach($generalData['peripheralsTypes'] as $key => $value)
                                                                                             <li>
                                                                                               <a href="{{ route('perByType', ['id' => $value -> id]) }}">
                                                                                                <i class="{{ $value -> icon }}"></i>
                                                                                                <span class="font-4"> {{ $value -> typeTitle }} </span>
                                                                                               </a>
                                                                                             </li>
                                                                                            @endforeach
                                                                                           </ul>
                                                                                       </div>
                                                                                   </div>
                                                                               </div>
                                                                           </div>
                                                                       </div>
                                                                   </div>
                                                                </li>
                                                             </ul>
                                                           </li>

                                                      <li>
                                                        <a target="_self" href="{{ route('ups') }}">
                                                         <i class="fa fa-plug"></i>
                                                         <span class="menu-title font-4"> უწყვეტის კვების წყარო (UPS)</span>
                                                        </a>
                                                      </li>
                                                      <li>
                                                        <a target="_self" href="{{ route('nc') }}">
                                                         <i class="fas fa-charging-station"></i>
                                                         <span class="menu-title font-4"> ნოუთბუქის დამტენები</span>
                                                        </a>
                                                      </li>

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- pos search module TOP -->
                            <div id="dor_search_top" class="center_column col-lg-4 col-md-4 col-xs-12 col-sm-12 clearfix">
                                <form method="get" action="/search" id="searchbox" class="form-inline">
                                    <div class="dor_search form-group">

                                        <div id="live-search-container" style="display: none">
                                         <ul class="search-result-list"></ul>
                                        </div>

                                        <input type="text" name="query" id="dor_query_top" value="" placeholder="ჩაწერეთ ტექსტი..." class="search_query form-control font-4" autocomplete="off" />
                                        <input type="hidden" name="categoryId" id="category" value="f1u3ja5i7">
                                        <div class="pos_search form-group no-uniform ">
                                            <div class="choose-category-lists">
                                                <div class="choose-category-lists-inner">
                                                    <div class="choose-category-lists-wrapper">
                                                        <div class="choose-category-lists-content">
                                                            <span class="font-3" data-bind="label">ყველა კატეგორია</span>&nbsp; <span class="fa fa-angle-down"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <ul class="dropdown-menu search-category-lists scroll-div" role="menu">
                                                <li>
                                                  <a href="#" data-category-id="f1u3ja5i7">
                                                    <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                                                    <span class="font-3"> ყველა კატეგორია</span>
                                                  </a>
                                                </li>

                                                @foreach($generalData['tables'] as $table)

                                                 <li>
                                                  <a href="#" data-category-id="{{ $table -> alias }}">
                                                   <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                                                   <span class="font-3"> {{ $table -> title }} </span>
                                                  </a>
                                                 </li>

                                               @endforeach

                                            </ul>
                                        </div>
                                        <button type="submit" class="btn btn-default submit-search">
                                          <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </header>

      <!-- Page content start-->

      @yield('content')

      <!-- Page content end-->

<!-- Footer -->
  <footer id="footer" class="clearfix">
    <div id="scroll-top-wrapper">
      <div id="scroll-top">
        <a href="#">
			   <span>
			    <i class="fa fa-angle-up"></i>
			   </span>
			  </a>
      </div>
     </div>

      <div class="footer-container-main footerSkin1">
          <div class="doradoFooterTop clearfix"></div>
              <div class="footer-adv-bottom clearfix">
                    <div class="container">
                        <div class="row">
                            <!-- <div class="footer-static row-fluid"> -->
                            <div class="footer-copyright-payment clearfix">
                                <div class="footer-bottom-info-wapper clearfix">
                                    <div class="col-lg-6 col-sm-6 col-sx-12">
                                      <b>{{ $generalData['contact'] -> companyName }}</b> © {{ date('Y') }}
                                      <span class="font-4"> &nbsp; ყველა უფლება დაცულია</span>
                                    </div>

                                    <!---Make visible--->
                                    <div class="col-lg-6 col-sm-6 col-sx-12 pull-right">
                                     <div class="site-rating">
                                       <!-- TOP.GE ASYNC COUNTER CODE -->
                                        <div id="top-ge-counter-container" data-site-id="113303"></div>
                                      <script async src="https://counter.top.ge/counter.js"></script>
                                       <!-- / END OF TOP.GE COUNTER CODE -->
                                     </div>
                                    </div>
                                </div>
                             </div>
                          <!-- </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- #footer -->
    </div>
  <!-- #page -->

<script src="/js/general.js" type="text/javascript"></script>
<script src="/js/live-search.js" type="text/javascript"></script>
<script src="/js/script.js" type="text/javascript"></script>

@if($generalData['informationToUsers'] -> visibility && !$generalData['displayMessageCookieIsDefined'])

<!--Notification start-->
<section id="message-to-users">
 <div class="message-container">
  <div class="wrapper">
    <div class="message-area">
      <h1 class="text-to-output font-4"> {{ $generalData['informationToUsers'] -> text }}</h1>
      <span class="close-block">
        <i class="fa fa-times"></i>
      </span>
      <script type="text/javascript">
        $("#message-to-users").click(function(){$(this).css("display", "none");});
      </script>
    </div>
  </div>
 </div>
</section>
<!--Notification end-->

@endif

</body>

</html>
