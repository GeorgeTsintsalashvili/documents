@extends('layouts.site')

@section('content')

<!--- main content start ------->

<!-- Breadcrumb -->
			<div class="breadcrumb">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<a class="breadcrumb-part breadcrumb-link-1" href="/">
									<i class="fa fa-home"></i>
								</a>
								<span class="last-breadcrumb-part font-3">ოპერატიულები</span>
							</div>
						</div>
					</div>
			</div>
	 <!-- /Breadcrumb -->

 @if($contentData['memoryModulesExist'])

			<div class="columns-container">
					<div id="columns" class="container ">
							<div class="row">
									<div id="left_column" class="column col-xs-12 col-sm-3 filter">

												 <div id="layered_block_left" class="block">
														 <div class="block_content filter-item-1">
																 <form action="{{ route('mmLoad') }}" class="filter-form" method="post" id="layered_form">
																		<div class="filter-form-container">

																			<!--- Order and visibility params ----->

																			<input name="order" type="hidden" class="order" value="0">
																			<input name="numOfProductsToShow" type="hidden" class="numOfProductsToShow" value="9">
																			<input name="active-page" type="hidden" class="active-page" value="1">

																			<!--- Price filter start --->

																			<div class="layered_price">
																					<div class="layered_subtitle_heading">
																						<h2 class="title_block">
																						 <span></span>
																						 <span class="font-3">ღირებულება</span>
																					 </h2>
																					</div>
																					<ul id="ul_layered_price_0" class="col-lg-12 layered_filter_ul">
																							<div id="price-range" data-min-price="{{ $contentData['configuration']['productPriceRange'] -> memoryModuleMinPrice }}" data-max-price="{{ $contentData['configuration']['productPriceRange'] -> memoryModuleMaxPrice }}">
																							 <span class="from-sign">₾</span>
																							 <input name="price-from" type="text" class="price-from" oninput="this.value = this.value.replace(/[^0-9.]/g, '')" value="{{ $contentData['configuration']['productPriceRange'] -> memoryModuleMinPrice }}">
																							 <span class="to-sign">₾</span>
																							 <input name="price-to" type="text" class="price-to" oninput="this.value = this.value.replace(/[^0-9.]/g, '')" value="{{ $contentData['configuration']['productPriceRange'] -> memoryModuleMaxPrice }}">
																							</div>
																							<input type="hidden" class="slider-input" value="{{ $contentData['configuration']['productPriceRange'] -> memoryModuleMinPrice }}, {{ $contentData['configuration']['productPriceRange'] -> memoryModuleMaxPrice }}"/>
																					</ul>
																			</div>

																		  <!--- Price filter end --->

																			<!--- Memory module type filter start --->

																			<div class="layered_filter">
																					<h2 class="title_block">
																						<span class="font-3">მეხსიერების ტიპი</span>
																					</h2>
																					<ul class="col-lg-12 layered_filter_ul">

																						@foreach($contentData['configuration']['memoryModuleTypes'] as $key => $value)
																							<li class="nomargin hiddable col-lg-12">
																									<input type="checkbox" class="checkbox" value="{{ $value -> id }}" data-active="0" data-hidden-input="type-id"/>
																									<label for="">
																											<a href="#" data-rel="nofollow">
																												<b>{{ $value -> typeTitle }}</b>
																												<span> ({{ $value -> numOfProducts }})</span>
																											</a>
																									</label>
																							 </li>
																						 @endforeach
																					 </ul>
																				 <input name="type-id" type="hidden" class="type-id" value="0">
																				</div>

																			 <!--- Memory module type filter end --->

																			 <!--- Destination filter start --->

 																			<div class="layered_filter">
 																					<h2 class="title_block">
 																						<span class="font-3">დანიშნულება</span>
 																					</h2>
 																					<ul class="col-lg-12 layered_filter_ul">


																						<li class="nomargin hiddable col-lg-12">
																								 <input type="checkbox" class="checkbox" value="1" data-active="0" data-hidden-input="destination"/>
																								 <label>
																										 <a href="#" data-rel="nofollow">
																											 <b class="font-4">სტაციონალურის</b>
																											 <span> {{ $contentData['configuration']['numberOfDesktopMemoryModules'] }} </span>
																										 </a>
																								 </label>
																							</li>

 																							<li class="nomargin hiddable col-lg-12">
 																									<input type="checkbox" class="checkbox" value="2" data-active="0" data-hidden-input="destination"/>
 																									<label>
 																											<a href="#" data-rel="nofollow">
 																												<b class="font-4">ლეპტოპის</b>
 																												<span> {{ $contentData['configuration']['numberOfLaptopMemoryModules'] }} </span>
 																											</a>
 																									</label>
 																							 </li>

 																					 </ul>
 																				 <input name="destination" type="hidden" class="destination" value="0">
 																				</div>

 																			 <!--- Destination filter end ---->

																			 <!--- Capacity filter start --->

 																				<div class="layered_filter">
 																						<h2 class="title_block">
 																						 <span class="font-3">მოცულობა</span>
 																					 </h2>

 																					<ul class="col-lg-12 layered_filter_ul">
 																					 @foreach($contentData['configuration']['capacities'] as $key => $value)
 																							<li class="nomargin hiddable col-lg-12">
 																									<input type="checkbox" class="checkbox" value="{{ $value -> isCouple }}-{{ $value -> capacity }}" data-active="0" data-hidden-input="capacity"/>
 																									<label for="">
 																											<a href="#" data-rel="nofollow">
																												@if($value -> isCouple)
																												<b>{{ $value -> capacity }} GB  (2x {{ $value -> capacity / 2 }} GB)</b>
																												@else
																												<b>{{ $value -> capacity }} GB</b>
																												@endif
 																												<span> ({{ $value -> numOfProducts }})</span>
 																											</a>
 																									</label>
 																							</li>
 																					 @endforeach
 																					</ul>
 																			 <input name="capacity" type="hidden" class="capacity" value="0">
 																			</div>

 																			<!--- Capacity filter end --->

																			<!--- Frequency filter start --->

																				<div class="layered_filter">
																						<h2 class="title_block">
																						 <span class="font-3">სიხშირე</span>
																					 </h2>

																					<ul class="col-lg-12 layered_filter_ul">
																					 @foreach($contentData['configuration']['frequencies'] as $key => $value)
																							<li class="nomargin hiddable col-lg-12">
																									<input type="checkbox" class="checkbox" value="{{ $value -> frequency }}" data-active="0" data-hidden-input="frequency"/>
																									<label for="">
																											<a href="#" data-rel="nofollow">
																												<b>{{ $value -> frequency }} MHZ</b>
																												<span> ({{ $value -> numOfProducts }})</span>
																											</a>
																									</label>
																							</li>
																					 @endforeach
																					</ul>
																			 <input name="frequency" type="hidden" class="frequency" value="0">
																			</div>

																			<!--- Frequency filter end --->

																			<!--- Stock type filter start --->

																			<div class="layered_filter">
																				<h2 class="title_block">
																				 <span class="font-3">საწყობის ტიპი</span>
																			 </h2>
																			<ul class="col-lg-12 layered_filter_ul">
																			 @foreach($contentData['configuration']['stockTypes'] as $key => $value)
																					<li class="nomargin hiddable col-lg-12">
																							<input type="checkbox" class="checkbox" value="{{ $value -> id }}" data-active="0" data-hidden-input="stock-type"/>
																							<label for="">
																									<a href="#" data-rel="nofollow">
																										<b class="font-4">{{ $value -> stockTitle }}</b>
																										<span> ({{ $value -> numOfProducts }})</span>
																									</a>
																							</label>
																					</li>
																			 @endforeach
																			</ul>
																	 <input name="stock-type" type="hidden" class="stock-type" value="0">
																	</div>

                                  <!--- Stock type filter end --->


																	<!--- Condition filter start --->

																		 <div class="layered_filter">
																				<h2 class="title_block">
																				 <span class="font-3">მდგომარეობა</span>
																			 </h2>
																			<ul class="col-lg-12 layered_filter_ul">
																			 @foreach($contentData['configuration']['conditions'] as $key => $value)
																					<li class="nomargin hiddable col-lg-12">
																							<input type="checkbox" class="checkbox" value="{{ $value -> id }}" data-active="0" data-hidden-input="condition"/>
																							<label for="">
																									<a href="#" data-rel="nofollow">
																										<b class="font-4">{{ $value -> conditionTitle }}</b>
																										<span> ({{ $value -> numOfProducts }})</span>
																									</a>
																							</label>
																					</li>
																			 @endforeach
																			</ul>
																	 <input name="condition" type="hidden" class="condition" value="0">
																	</div>

																	<!--- Condition filter end --->

																	</div>
															</form>
													</div>

										</div>
									</div>

									<!--- MainMemories list start ----->

									<div id="center_column" class="center_column dor-two-cols col-xs-12 col-sm-9">
											<div class="content_sortPagiBar clearfix">
											 <!-- Sort bar start -->
													<div class="sortPagiBar clearfix">
															<form action="" method="get" class="nbrItemPage">
																	<div class="clearfix selector1">
																			<label for="nb_item" class="hidden">
																					ჩვენება
																			</label>
																			<input type="hidden" name="cate_type" value="2" />
																			<input type="hidden" name="id_category" value="3" />
																			<select name="n" id="nb_item" class="selectpicker">
																					<option value="9" selected>9</option>
																					<option value="12">12</option>
																					<option value="15">15</option>
																					<option value="18">18</option>
																					<option value="21">21</option>
																					<option value="24">24</option>
																					<option value="27">27</option>
																					<option value="30">30</option>
																			</select>
																			<span>per page</span>
																	</div>
															</form>

															<ul class="display hidden-xs">
																	<li class="display-title font-3">ჩვენება:</li>
																	<li id="grid"><a rel="nofollow" href="#" data-toggle="tooltip" data-placement="top"><i class="fa fa-th"></i></a></li>
																	<li id="list"><a rel="nofollow" href="#" data-toggle="tooltip" data-placement="top"><i class="fa fa-list"></i></a></li>
																	<input type="hidden" class="products-view-type" value="grid">
															</ul>

															<form id="productsSortForm" action="#" class="productsSortForm">
																	<div class="select selector1">
																			<label for="selectProductSort" class="hidden">დახარისხება</label>
																			<select id="selectProductSort" class="selectProductSort selectpicker">
																					<option value="0" selected="selected">დახარისხება ჩუმათობით</option>
																					<option value="1">ფასის კლებადობით</option>
																					<option value="2">ფასის ზრდადობით</option>
																					<option value="3">მეხსიერების კლებადობით</option>
																					<option value="4">მეხსიერების ზრდადობით</option>
																					<option value="5">სიხშირის კლებადობით</option>
																					<option value="6">სიხშირის ზრდადობით</option>
																					<option value="7">დამატების დროის კლებადობით</option>
																					<option value="8">დამატების დროის ზრდადობით</option>
																			</select>
																	</div>
															</form>
													</div>
											 <!-- Sort bar end -->
										 </div>

											<!-- Products list -->

										 <div id="result-content">

											@foreach($contentData['memoryModules'] as $index => $row)

											 <ul class="product_list grid row showcolumn3" >
												 @foreach($row as $key => $value)
													 <li class="ajax_block_product col-xs-12 col-sm-6 col-md-4 last-in-line first-item-of-tablet-line last-item-of-mobile-line">
															 <div class="product-container">
																	 <div class="dor-display-product-info">
																			 <div class="left-block">
																					 <div class="product-image-container">
																							 <a class="product_img_link" target="_blank" href="/memoryModules/{{ $value -> id }}" title="{{ $value -> title }}">
																								<img class="replace-2x img-responsive" src="/images/memoryModules/main/original/{{ $value -> mainImage }}" width="450" height="478"/>
																							 </a>
																							 <div class="content_price">

																							 <span itemprop="price" class="price product-price">
																									 <b class="currency-gel">₾</b> {{ $value -> newPrice }}
																								</span>

																								<meta itemprop="priceCurrency" content="GEL" />

																								@if($value -> newPrice != $value -> price)

																								<span class="old-price product-price">
																									<b>₾</b> {{ $value -> price }}
																								</span>

																							  @endif

																							 </div>
																					 </div>
                                         </div>

																					<div class="right-block">
																							<h5>
																							 <a class="product-name font-4" href="/memoryModules/{{ $value -> id }}" title="{{ $value -> title }}">
																								 <span class="font-4">{{ $value -> title }} </span>
																							 </a>
																							</h5>

																							<div class="product-desc" itemprop="description">
																								 <div>
																									 <b class="font-4">მოცულობა: </b>
																									 <span>{{ $value -> capacity }} GB</span>
																								 </div>
																								 <div>
																									 <b class="font-4">სიხშირე: </b>
																									 <span>{{ $value -> frequency }} MHZ</span>
																								 </div>
																								 <div>
																									 <b class="font-4">ტიპი: </b>
																									 <span>{{ $value -> typeTitle }}</span>
																								 </div>
																								 <div>
																									 <b class="font-4">იყიდება: </b>
																									 <span class="font-4">{{ $value -> label }}</span>
																								 </div>
																							 </div>

																							 <div class="content_price">
																									<span class="price product-price">
																									 <b class="currency-gel">₾</b> {{ $value -> newPrice }}
																									</span>

																									@if($value -> newPrice != $value -> price)

																									<span class="old-price product-price">
																										<b>₾</b> {{ $value -> price }}
																									</span>
																								 @endif
																								 </div>

																									<div class="product-flags">
																										<span class="discount"></span>
																									</div>

																								 </div>
																								</div>
																										<div class="product-more-options">
																												<div class="read-more-container">
																														<a class="button read-more-button btn btn-default" target="_blank" href="/memoryModules/{{ $value -> id }}">
																															<i class="fa fa-plus"></i>
																															<span class="font-3">დაწვრილებით</span>
																														</a>
																												</div>
																												<div class="short-description">
																													<div>
				 																									 <b class="font-4">მოცულობა: </b>
				 																									 <span>{{ $value -> capacity }} GB</span>
				 																								 </div>
				 																								 <div>
				 																									 <b class="font-4">სიხშირე: </b>
				 																									 <span>{{ $value -> frequency }} MHZ</span>
				 																								 </div>
				 																								 <div>
				 																									 <b class="font-4">ტიპი: </b>
				 																									 <span>{{ $value -> typeTitle }}</span>
				 																								 </div>
																												 <div>
																													 <b class="font-4">იყიდება: </b>
																													 <span class="font-4">{{ $value -> label }}</span>
																												 </div>
																												</div>
																										</div>

															                 </div>
															 <!-- .product-container> -->
													 </li>
													@endforeach
												</ul>
											@endforeach

											<div class="content_sortPagiBar">
													<div class="bottom-pagination-content clearfix">

															<!-- Pagination -->
															<div id="pagination_bottom" class="pagination clearfix" style="width: 80%">
                                <ul class="pagination">

                                     @foreach($contentData['pages'] as $page)

                                     @if($page['isPad'])

                                      <li class="dots">
                                        <span>
                                          <span>{{ $page['value'] }}</span>
                                        </span>
                                      </li>

                                     @elseif($page['isActive'])

                                      <li class="active current">
                                        <span>
                                          <span>{{ $page['value'] }}</span>
                                        </span>
                                      </li>

                                     @else

                                     <li>
                                       <a href="{{ $page['value'] }}">
                                         <span>{{ $page['value'] }}</span>
                                       </a>
                                     </li>

                                    @endif

                                    @endforeach

                                    @if($contentData['maxPage'] > 1)

                                    <li id="pagination_next_bottom" class="pagination_next">
                                        <a href="2" rel="next">
                                         <i class="icon-chevron-right"></i>
                                        </a>
                                    </li>

                                    @endif

                                </ul>

															</div>
															<!-- /Pagination -->

													</div>
											</div>

										 </div>

									</div>
								 <!--- Main memories list end ----->
							</div>
							<!-- .row -->
					</div>
					<!-- #columns -->
			</div>

			<div class="blockDorado10 clearfix">
					<div class="container">
						<div class="row"></div>
					</div>
			</div>

@include('parts.site.list')

@else

<div class="container" id="no-products-container">
	<div class="columns-container">
		<div class="row">
			 <div class="column col-xs-12 col-sm-12">
				<div class="warning-container">
					<h1 class="font-4">პროდუქცია ჯერ არ არის დამატებული!</h1>
				</div>
			</div>
		</div>
	</div>
</div>

@endif

@endsection
