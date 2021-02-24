@extends('layouts.site')

@section('content')

<script type="text/javascript" src="/modules/homeslider/js/homeslider.js"></script>
<script type="text/javascript" src="/modules/homeslider/js/jssor.slider.min.js"></script>
<script type="text/javascript" src="/js/slider-options.js"></script>

    <!--- Slider section start --->

    @if($contentData['slidesExist'])
    <div class="container dor-bg-white" id="home-slider">
		 <div class="row">
            <div id="Dor_Full_Slider" class="col-md-12" style="height: 480px">
                <!-- Loading Screen -->
                <div class="slider-loading" data-u="loading">
                    <div class="slider-loading-img"></div>
                </div>
                <div class="slider-content-wrapper" data-u="slides">

                  @foreach($contentData['slides'] as $slide)
                    <div class="slider-content" data-p="225.00">
                        <img data-u="image" src="/images/slides/original/{{ $slide -> image }}"/>
                        <div class="dor-info-perslider">
                            <div class="dor-slider-title" data-u="caption" data-t="12"> </div>
                            <div class="dor-slider-caption" data-u="caption" data-t="9"> </div>
                        </div>
                    </div>
                  @endforeach
                </div>
                <!-- Bullet Navigator -->
                <div data-u="navigator" class="dorNavSlider" data-autocenter="1">
                    <!-- bullet navigator item prototype -->
                    <div data-u="prototype"></div>
                </div>
                <!-- Arrow Navigator -->
                <span data-u="arrowleft" class="dorArrowLeft" data-autocenter="2">
                 <i class="fa fa-angle-left"></i>
                </span>
                <span data-u="arrowright" class="dorArrowRight" data-autocenter="2">
                  <i class="fa fa-angle-right"></i>
                </span>
            </div>
           </div>
        </div>
        @endif

      <!--- Slider section end --->


      <!--- Series section start --->

        @if($contentData['cpuSeriesExist'] && $contentData['activeCpuSeriesId'])
        <div class="blockDorado3 blockPosition dor-bg-gray">
            <div class="container">
                <div class="row">
                    <div id="dor-tab-product-category" class="show-hover2">
                        <div class="title-header-tab hidden">
                            <h3></h3>
                            <p></p>
                        </div>
                        <div class="dor-tab-product-category-wrapper">
                            <ul role="tablist" class="nav nav-tabs" id="dorTabAjax">
																	@foreach($contentData['cpuSeries'] as $value)
																	<li class="{{ $contentData['activeCpuSeriesId'] == $value -> id ? 'active' : null }}">
																		<a aria-expanded="false" data-toggle="tab" data-ajaxurl="{{ route('homePageComputers', ['id' => $value -> id]) }}" href="#computer-systems">
                                      <b class="font-4">{{ $value -> homePageTitle }}</b>
                                    </a>
																	</li>
																 @endforeach
                            </ul>

							             <!--- Active systems --->

                            <div class="tab-content" id="dorTabProductCategoryContent">
                                <div id="initial-computer-systems-tab" class="tab-pane fade  active  in">
                                    <div class="productTabContent_new_product dor-content-items" style="padding-bottom: 90px">
                                        <div class="row-item">
                                            <!-- Products list -->
                                            <ul id="dor-product-tab-categories-data" class="product_list grid row dor-product-tab-categories showcolumn3">

                                            @foreach($contentData['activeSystems'] as $value)

																							<li class="ajax_block_product col-xs-12 col-sm-4 col-md-3 first-in-line first-item-of-tablet-line first-item-of-mobile-line">
																									<div class="product-container">
																											<div class="dor-display-product-info">
																													<div class="left-block">
																															<div class="product-image-container">
																																	<a class="product_img_link" href="/computers/{{ $value -> id }}">
																																	 <img class="replace-2x img-responsive" src="/images/computers/main/original/{{ $value -> mainImage }}">
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

																					                      <span class="price product-price"><b class="currency-gel">₾</b> {{ $value -> newPrice }}</span>
																					                      <span class="old-price product-price">₾ {{ $value -> price }}</span>

																					                     @else
																					                      <span class="price product-price"><b class="currency-gel">₾</b> {{ $value -> price }}</span>
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

								              <!--- block where requested html fragment is placed --->

                                <div id="computer-systems" class="tab-pane fade  in">
                                    <div class="productTabContent_feature_product dor-content-items">
                                        <div class="row-item">
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

        <!--- Seris section end --->


        <!--- Offer section start --->

        @if($contentData['specialOffersExist'])
        <div class="DorTopProductCategory1 blockPosition dor-bg-gray">
            <div class="container">
                <div class="row">
                    <div id="dorTopProductCategory" class="dorTopProductCategory clearfix show-hover2" data-cateId="6">
                        <div class="container">
                            <div class="row">
                                <div class="dorTopProductCategoryData">
                                    <div class="fancy-heading text-left top-list-title">
                                        <h3>
																					<span class="font-4"> ჩვენ გთავაზობთ</span>
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

                                                                @foreach($contentData['specialOffers'] as $value)

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

                                                                                  <span class="price product-price"><b class="currency-gel">₾</b> {{ $value -> newPrice }}</span>
                                                                                  <span class="old-price product-price">₾ {{ $value -> price }}</span>

                                                                                 @else
                                                                                  <span class="price product-price"><b class="currency-gel">₾</b> {{ $value -> price }}</span>
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

      <!--- Offer section end --->

      <!--- Latest products section start ------------->

      @if($contentData['latestProductsExist'])
      <div class="DorTopProductCategory1 blockPosition dor-bg-gray" style="margin-top: 0">
          <div class="container">
              <div class="row">
                  <div id="dorTopProductCategory" class="dorTopProductCategory clearfix show-hover2" data-cateId="6">
                      <div class="container">
                          <div class="row">
                              <div class="dorTopProductCategoryData">
                                  <div class="fancy-heading text-left top-list-title">
                                      <h3>
                                        <span class="font-4"> ბოლოს დამატებული პროდუქცია</span>
                                      </h3>
                                  </div>
                                  <div class="dor-topproduct-category-inner">
                                      <div class="dor-topproduct-category-wrapper">
                                          <div class="protab-contents">
                                              <div class="dor-topproduct-category-data col-lg-12 col-sm-12 col-xs-12">
                                                  <div class="dor-topproduct-cate-inner" style="padding-bottom: 50px">
                                                      <div class="dor-topproduct-cate-wrapper">
                                                         <!-- Products list -->
                                                         <ul id="dor-product-top1-data" class="product_list grid row dor-product-top showcolumn3">

                                                              @foreach($contentData['latestProducts'] as $value)

                                                              <li class="ajax_block_product col-xs-12 col-sm-4 col-md-3 last-item-of-mobile-line">
                                                                  <div class="product-container">
                                                                      <div class="dor-display-product-info">

                                                                          <div class="left-block">
                                                                              <div class="product-image-container">
                                                                                  <a class="product_img_link" href="/{{ $value -> pathPart }}/{{ $value -> id }}">
                                                                                    <img class="replace-2x img-responsive" src="/images/{{ $value -> pathPart }}/main/original/{{ $value -> mainImage }}"/>
                                                                                  </a>
                                                                              </div>
                                                                          </div>

                                                                          <div class="right-block">
                                                                              <h5>
                                                                               <a class="product-name font-4" href="/{{ $value -> pathPart }}/{{ $value -> id }}">
                                                                                {{ $value -> title }}
                                                                               </a>
                                                                              </h5>

                                                                              <div class="content_price">

                                                                                @if($value -> discount != 0)

                                                                                <span class="price product-price"><b class="currency-gel">₾</b> {{ $value -> newPrice }}</span>
                                                                                <span class="old-price product-price">₾ {{ $value -> price }}</span>

                                                                               @else
                                                                                <span class="price product-price"><b class="currency-gel">₾</b> {{ $value -> price }}</span>
                                                                               @endif

                                                                              </div>
                                                                          </div>
                                                                      </div>

                                                                     <div class="product-more-options">
                                                                      <div class="read-more-container">
                                                                         <a class="button read-more-button btn btn-default" href="/{{ $value -> pathPart }}/{{ $value -> id }}">
                                                                          <i class="fa fa-plus"></i>
                                                                          <span class="font-3">დაწვრილებით</span>
                                                                         </a>
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

    <!--- Latest products section end --->


    <!--- Discounted products section start ------------->

    @if($contentData['discountedProductsExist'])
    <div class="DorTopProductCategory1 blockPosition dor-bg-gray" style="margin-top: 0">
        <div class="container">
            <div class="row">
                <div id="dorTopProductCategory" class="dorTopProductCategory clearfix show-hover2" data-cateId="6">
                    <div class="container">
                        <div class="row">
                            <div class="dorTopProductCategoryData">
                                <div class="fancy-heading text-left top-list-title">
                                    <h3>
                                      <span class="font-4"> ფასდაკლებული პროდუქცია</span>
                                    </h3>
                                </div>
                                <div class="dor-topproduct-category-inner">
                                    <div class="dor-topproduct-category-wrapper">
                                        <div class="protab-contents">
                                            <div class="dor-topproduct-category-data col-lg-12 col-sm-12 col-xs-12">
                                                <div class="dor-topproduct-cate-inner" style="padding-bottom: 50px">
                                                    <div class="dor-topproduct-cate-wrapper">
                                                       <!-- Products list -->
                                                       <ul id="dor-product-top1-data" class="product_list grid row dor-product-top showcolumn3">

                                                            @foreach($contentData['discountedProducts'] as $value)

                                                            <li class="ajax_block_product col-xs-12 col-sm-4 col-md-3 last-item-of-mobile-line">
                                                                <div class="product-container">
                                                                    <div class="dor-display-product-info">

                                                                        <div class="left-block">
                                                                            <div class="product-image-container">
                                                                                <a class="product_img_link" href="/{{ $value -> pathPart }}/{{ $value -> id }}">
                                                                                  <img class="replace-2x img-responsive" src="/images/{{ $value -> pathPart }}/main/original/{{ $value -> mainImage }}"/>
                                                                                </a>
                                                                            </div>
                                                                        </div>

                                                                        <div class="right-block">
                                                                            <h5>
                                                                             <a class="product-name font-4" href="/{{ $value -> pathPart }}/{{ $value -> id }}">
                                                                              {{ $value -> title }}
                                                                             </a>
                                                                            </h5>

                                                                            <div class="content_price">
                                                                              @if($value -> discount != 0)

                                                                              <span class="price product-price"><b class="currency-gel">₾</b> {{ $value -> newPrice }}</span>
                                                                              <span class="old-price product-price">₾ {{ $value -> price }}</span>

                                                                             @else
                                                                              <span class="price product-price"><b class="currency-gel">₾</b> {{ $value -> price }}</span>
                                                                             @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                   <div class="product-more-options">
                                                                    <div class="read-more-container">
                                                                       <a class="button read-more-button btn btn-default" href="/{{ $value -> pathPart }}/{{ $value -> id }}">
                                                                        <i class="fa fa-plus"></i>
                                                                        <span class="font-3">დაწვრილებით</span>
                                                                       </a>
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

    <!--- Discounted products section end ----->


    <!--- Accessories section start ------------->

      @if($contentData['activeAccessoryCategoryId'] != 0)
        <div class="DorTabPro blockPosition">
            <div class="container">
                <div class="row">
                    <div id="dor-tab-product-category-pro" class="clearfix show-hover2">
                        <div class="container">
                            <div class="row">
                                <div class="dor-pro-tabcontent clearfix">
                                    <div class="dor-tabpro-product-category-wrapper" data-tab-id="besseller_product">
                                        <div class="row-item-protab">
                                            <div class="protab-lists">
                                                <div class="pro-tab-head">
												                          <!--- tabproductcategory --->
                                                    <ul role="tablist" class="nav nav-tabs" id="dorTabAjaxPro">
                                                      @foreach($contentData['accessoriesTypes'] as $accessory)
                                                        <li>
                                                          <a class="{{ $accessory -> id == $contentData['activeAccessoryCategoryId'] ? 'active' : null }} " aria-expanded="false" href="#computer-accessories" data-ajaxurl="{{ route('homePageAccessories', ['id' => $accessory -> id]) }}" data-toggle="tab" style="padding-right: 8px">
                                                           <span class="font-4">{{ $accessory -> typeTitle }}</span>
                                                          </a>
                                                        </li>
                                                     @endforeach
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="protab-contents">
                                                <div class="tab-content dorTabProductCategoryContentPro" id="dorTabProductCategoryContentPro">

                                                    <div id="computer-accessories" class="tab-pane fade active in">
                                                        <div class="productTabContentPro_4 dor-content-items">
                                                            <div class="row-items">

                                                                <!-- Products list -->
                                                                <ul id="dor-product-tabpro-data" class="product_list grid row dor-product-tabpro showcolumn3">

                                                                    @foreach($contentData['activeAccessories'] as $value)

                                                                    <li class="ajax_block_product col-xs-12 col-sm-4 col-md-3 last-item-of-mobile-line">
                                                                        <div class="product-container" itemscope itemtype="#">
                                                                            <div class="dor-display-product-info">
                                                                                <div class="left-block">
                                                                                    <div class="product-image-container">
                                                                                        <a class="product_img_link" href="/accessories/{{ $value -> id }}" title="{{ $value -> title }}" itemprop="url">
                                                                                          <img class="replace-2x img-responsive" src="/images/accessories/main/original/{{ $value -> mainImage }}" itemprop="image"/>
                                                                                        </a>
                                                                                    </div>
                                                                                 </div>

                                                                                <div class="right-block">

                                                                                    <h5 itemprop="name">
														                                                         <a class="product-name font-4" href="/accessories/{{ $value -> id }}" title="{{ $value -> title }}" itemprop="url" >
								                                                                      <span class="font-4">{{ $value -> title }}</span>
							                                                                       </a>
						                                                                        </h5>

                                                                                    <div class="content_price">

                                                                                      @if($value -> discount != 0)

                                                                                      <span class="price product-price"><b class="currency-gel">₾</b> {{ $value -> newPrice }} </span>
                                                                                      <span class="old-price product-price">₾ {{ $value -> price }}</span>

                                                                                     @else
                                                                                      <span class="price product-price"><b class="currency-gel">₾</b> {{ $value -> price }}</span>
                                                                                     @endif
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                            <div class="product-more-options">
                                                                              <div class="read-more-container">
                                                                                  <a class="button read-more-button btn btn-default" href="/accessories/{{ $value -> id }}">
                                                                                    <i class="fa fa-plus"></i>
                                                                                    <span class="font-3">დაწვრილებით</span>
                                                                                  </a>
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
        </div>
      @endif

    <!--- Accessories section end --->

@endsection
