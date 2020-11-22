@extends('layouts.site')

@section('content')

@if($contentData['computerExists'])

<!--- main content start ------->

<div id="fb-root"></div>

<!-- Breadcrumb -->
      <div class="breadcrumb">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <a class="breadcrumb-part breadcrumb-link-1" href="/">
                  <i class="fa fa-home"></i>
                </a>
                <a class="breadcrumb-part breadcrumb-link-1" href="/computers">
                  <span class="font-3">სისტემური ბლოკები</span>
                </a>
                <span class="last-breadcrumb-part font-4">{{ $contentData['computer'] -> title }}</span>
              </div>
            </div>
          </div>
      </div>
     <!-- /Breadcrumb -->

        <div class="columns-container">
            <div id="columns" class="container ">

                <div class="row">
                    <div id="center_column" class="center_column  dor-normal-cols col-xs-12 col-sm-12">
                        <div class=" dor-normal-cols">
                            <div class="primary_block row dor-media-bottom  dor-primary-image-left">
                                <div class="container">
                                    <div class="top-hr"></div>
                                </div>
                                <!-- left infos-->
                                <div class="pb-left-column col-md-6 col-sm-12 col-xs-12 media">
                                   <div class="image-block-wrapper">
                                    <!-- product img-->
                                    <div id="image-block" class="clearfix">
                                       @if($contentData['computer'] -> isOffer)
                                        <span class="product-flag new">
							                            <span class="font-2"> შემოთავაზება</span>
                                        </span>
                                        @endif
                                        <span id="view_full_size">
						                            <span class="border-product"></span>
                                        <img id="bigpic" data-itemprop="image" src="/images/computers/main/original/{{ $contentData['computer'] -> mainImage }}" width="800" height="850" />
                                        <span class="span_link no-print">
                                          <span class="hidden"></span>
                                        </span>
                                        </span>
                                    </div>
                                    </div>

                                    <!-- end image-block -->
                                    <!-- thumbnails -->

                                     <div class="views-block-wrapper">
                                       <div id="views_block" class="clearfix ">
                                          <a id="view_scroll_left" href="javascript:{}" style="display: none">
                                           <span class="hidden"></span>
                                           <i aria-hidden="true" class="fa fa-angle-up"></i>
                                          </a>
                                          <div id="thumbs_list">
                                              <ul id="thumbs_list_frame">
                                                <li>
                                                  <a href="/images/computers/main/original/{{ $contentData['computer'] -> mainImage }}" data-fancybox-group="other-views" class="fancybox shown">
                                                    <img class="img-responsive" src="/images/computers/main/preview/{{ $contentData['computer'] -> mainImage }}" height="266" width="250" data-itemprop="image" />
                                                  </a>
                                                </li>

                                                @if($contentData['imagesExist'])

                                                @foreach($contentData['images'] as $value)
                                                  <li>
                                                    <a href="/images/computers/slides/original/{{ $value -> image }}" data-fancybox-group="other-views" class="fancybox shown">
                                                      <img class="img-responsive" src="/images/computers/slides/preview/{{ $value -> image }}" height="266" width="250" data-itemprop="image" />
                                                    </a>
                                                  </li>
                                                @endforeach

                                               @endif

                                              </ul>
                                          </div>
                                          <!-- end thumbs_list -->
                                          <a id="view_scroll_right" href="javascript:{}">
                                            <i aria-hidden="true" class="fa fa-angle-down"></i>
                                          </a>
                                      </div>
                                      <!-- end views-block -->
                                     </div>
                                </div>
                                <!-- end pb-left-column -->
                                <!-- end left infos-->
                                <!-- center infos -->

                                <div class="pb-center-column col-md-6 col-sm-12 col-xs-12 info">

                                    <div class="product_title_wrapper">

                                        <div class="product_title entry-title" data-itemprop="name">
                                            <h1 class="font-4" data-itemprop="name"> {{ $contentData['computer'] -> title }} </h1>
                                        </div>
                                    </div>

                                    <!--Price Detail-->
                                    <div class="content_prices clearfix">
                                        <!-- prices -->
                                        <div>
                                          <p class="our_price_display font-4 fsz-18 no-mrgn price">
                                            <span id="our_price_display" class="price" data-itemprop="price" content="1000"><b>₾</b> {{ $contentData['computer'] -> newPrice }}</span>
                                          </p>
                                          @if($contentData['computer'] -> discount != 0)
                                            <p id="old_price" class="font-3 fsz-18 no-mrgn">
                                              <span id="old_price_display">
                                                <span class="price font-4 fsz-18 no-mrgn"><b>₾</b> {{ $contentData['computer'] -> price }}</span>
                                              </span>
                                            </p>
                                          @endif
                                        </div>
                                        <!-- end prices -->

                                    </div>
                                    <!-- end content_prices -->
                                    <!--End Price Detail-->

                                    <p id="product-warranty">
                                       <i class="fas fa-award"></i>
                                       <span class="font-4">მოქმედებს {{ $contentData['computer'] -> warrantyDuration }} {{ $contentData['warrantyTitle'] }} გარანტია საუკეთესო პირობებით</span>
                                    </p>

                                    <p id="installment-allowed">
                                      <i class="fas fa-calendar-alt"></i>
                                      <span class="font-4">შეგიძლიათ ისარგებლოთ განვადებით</span>
                                    </p>

                                    <p class="warning_inline font-3" id="stock-status" style="background-color: {{ $contentData['computer'] -> statusColor }}">
                                      <i class="fas fa-boxes"></i>
                                      <span>{{ $contentData['computer'] -> stockTitle }}</span>
                                    </p>

                                    <p id="product-condition">
                                       <b class="font-3">მდგომარეობა </b>
                                       <span class="font-2">{{ $contentData['conditionTitle'] }}</span> <br>
                                    </p>

                                    <p id="product-code">
                                       <b class="font-3">პროდუქტის კოდი </b>
                                       <span>{{ $contentData['computer'] -> code }} </span> <br>
                                    </p>

                                    <!--- Share buttons --->

                                    <div class="social-networks-wrapper">
                                     <div class="fb-share-button" data-href="/computers/{{ $contentData['computer'] -> id }}" data-size="small" data-layout="button_count" style="position: absolute"></div>
                                     <a class="twitter-share-button" href="https://dev.twitter.com/web/tweet-button">Tweet</a>
                                    </div>
                                </div>
                                <!-- end center infos-->
                            </div>
                            <!-- end primary_block -->

                            <div class="dorTabProductDetail ProductDetailTabsStyleRow">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">

                                  <li data-role="presentation" class="active">
                                      <a href="#productDesc" data-aria-controls="data info" data-role="tab" data-toggle="tab">
                                       <span class="font-2">მახასიათებლები</span>
                                      </a>
                                  </li>
                                    <li data-role="presentation">
                                        <a href="#productReview" data-aria-controls="Reviews" data-role="tab" data-toggle="tab">
                                          <span class="font-2">კომენტარები</span>
                                        </a>
                                    </li>

                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content">

                                    <div class="entry-content wc-tab tab-pane col-lg-6 col-sm-8 col-xs-12 active" data-role="tabpanel" id="productDesc">
                                        <!-- More info -->
                                        <hr class="heading-seperator">
                                        <div class="scroll-div-none">
                                            <div class="rte">
                                                <div class="techspecs-section">
                                                    <div class="techspecs-row">
                                                        <div class="techspecs-column">
                                                            <div class="column large-12 small-12 small-push-0">
                                                                <div class="product-description">
                                                                  {!! $contentData['computer'] -> description !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end  More info -->
                                    </div>

                                    <div class="entry-content wc-tab tab-pane col-lg-4 col-sm-6 col-xs-12" data-role="tabpanel" id="productReview">
                                        <!--HOOK_PRODUCT_TAB -->
                                        <hr class="heading-seperator">
                                        <div class="scroll-div-none">
                                            <div id="new_comment_form" class="reviewFormCustom">
                                                <div data-width="500" class="fb-comments" data-href="{{ url() -> current() }}" data-numposts="5"></div>
                                            </div>
                                        </div>
                                        <!--end HOOK_PRODUCT_TAB-->
                                    </div>

                                </div>
                            </div>
                            <!-- End Dor Tab Product Detail -->

                          <!-- description & features -->

                        </div>
                        <!-- itemscope product wrapper -->

                    </div>
                    <!-- #center_column -->

                   <!---Section for same products carousel --->

                   @if($contentData['recommendedComputersExist'])

                   <div class="DorTopProductCategory1 blockPosition dor-bg-gray">
                       <div class="container">
                           <div class="row">
                               <div id="dorTopProductCategory" class="dorTopProductCategory clearfix show-hover2" data-cateId="6">
                                   <div class="container">
                                       <div class="row">
                                           <div class="dorTopProductCategoryData">
                                               <div class="fancy-heading text-left top-list-title">
                                                   <h3>
                                                    <span class="font-3"> მსგავსი პროდუქცია</span>
                                                  </h3>
                                               </div>
                                               <div class="dor-topproduct-category-inner">
                                                   <div class="dor-topproduct-category-wrapper">
                                                       <div class="protab-contents">
                                                           <div class="dor-topproduct-category-data col-lg-12 col-sm-12 col-xs-12">
                                                               <div class="dor-topproduct-cate-inner" style="padding-bottom: 100px">
                                                                   <div class="dor-topproduct-cate-wrapper">

                                                                      <!-- Products list -->
                                                                      <ul id="dor-product-top1-data" class="product_list grid row dor-product-top showcolumn3">

                                                                        @foreach($contentData['recommendedComputers'] as $value)

                                                                          <li class="ajax_block_product col-xs-12 col-sm-4 col-md-3 last-item-of-mobile-line">
                                                                               <div class="product-container">
                                                                                   <div class="dor-display-product-info">

                                                                                       <div class="left-block">
                                                                                           <div class="product-image-container">
                                                                                               <a class="product_img_link" href="/computers/{{ $value -> id }}">
                                                                                                 <img class="replace-2x img-responsive" src="/images/computers/main/original/{{ $value -> mainImage }}"/>
                                                                                               </a>
                                                                                           </div>
                                                                                       </div>

                                                                                       <div class="right-block">
                                                                                           <h5>
                                                                                           <a class="product-name font-4" href="/computers/{{ $value -> id }}">
                                                                                            {{ $value -> title }}
                                                                                           </a>
                                                                                          </h5>

                                                                                           <div class="content_price">

                                                                                             @if($value -> discount != 0)

                                                                                             <span class="price product-price"><b class="currency-gel">₾</b> {{ $value -> newPrice }} </span>
                                                                                             <span class="old-price product-price">₾ {{ $value -> price }} </span>

                                                                                            @else
                                                                                             <span class="price product-price"><b class="currency-gel">₾</b> {{ $value -> price }} </span>
                                                                                            @endif
                                                                                           </div>
                                                                                       </div>
                                                                                   </div>

                                                                                 <div class="product-more-options">
                                                                                  <div class="read-more-container">
                                                                                     <a class="button read-more-button btn btn-default" href="/computers/{{ $value -> id }}">
                                                                                      <i class="fa fa-plus"></i>
                                                                                      <span class="font-3">დაწვრილებით</span>
                                                                                     </a>
                                                                                 </div>
                                                                                 <div class="short-description">
                                                                                   <div title="პროცესორი"><i class="fas fa-microchip"> </i> <span>{{ $value -> cpu }}</span></div>
                                                                                   <div title="ოპერატიული"><i class="fas fa-memory"> </i> <span>{{ $value -> memory }} GB </span></div>
                                                                                   <div title="გრაფიკა"><i class="flaticon-026-sound-card"> </i> <span>{{ $value -> gpuTitle }}</span></div>
                                                                                   <div title="მეხსიერება"><i class="flaticon-005-hdd"> </i> <span>{{ $value -> storage }}</span></div>
                                                                                 </div>
                                                                               </div>
                                                                               </div>
                                                                               <!-- .product-container> -->
                                                                           </li>
                                                                        @endforeach
                                                                       </ul>
                                                                   </div>
                                                               </div>
                                                           </div>
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>

                           </div>
                       </div>
                   </div>
                  @endif
                </div>
                <!-- .row -->
            </div>
            <!-- #columns -->
        </div>
      <!-- .columns-container -->

@include('parts.site.view')

@endif

@endsection
