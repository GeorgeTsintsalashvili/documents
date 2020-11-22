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
								<span class="last-breadcrumb-part font-3">ვიდეო ბარათები</span>
							</div>
						</div>
					</div>
			</div>
	 <!-- /Breadcrumb -->

 @if($contentData['videoCardsExist'])

			<div class="columns-container">
					<div id="columns" class="container">
							<div class="row">
									<div id="left_column" class="column col-xs-12 col-sm-3 filter">

												 <div id="layered_block_left" class="block">
														 <div class="block_content filter-item-1">
																 <form action="{{ route('vcLoad') }}" class="filter-form" method="post" id="layered_form">
																		<div class="filter-form-container">

																			<!--- Order and visibility params ----->

																			<input name="order" type="hidden" class="order" value="0">
																			<input name="numOfProductsToShow" type="hidden" class="numOfProductsToShow" value="12">
																			<input name="active-page" type="hidden" class="active-page" value="1">

																			<!--- Price filter start -------->

																			<div class="layered_price">
																					<div class="layered_subtitle_heading">
																						<h2 class="title_block">
																						 <span></span>
																						 <span class="font-3">ღირებულება</span>
																					 </h2>
																					</div>
																					<ul id="ul_layered_price_0" class="col-lg-12 layered_filter_ul">
																							<div id="price-range" data-min-price="{{ $contentData['configuration']['productPriceRange'] -> videoCardMinPrice }}" data-max-price="{{ $contentData['configuration']['productPriceRange'] -> videoCardMaxPrice }}">
																							 <span class="from-sign">₾</span>
																							 <input name="price-from" type="text" class="price-from" oninput="this.value = this.value.replace(/[^0-9.]/g, '')" value="{{ $contentData['configuration']['productPriceRange'] -> videoCardMinPrice }}">
																							 <span class="to-sign">₾</span>
																							 <input name="price-to" type="text" class="price-to" oninput="this.value = this.value.replace(/[^0-9.]/g, '')" value="{{ $contentData['configuration']['productPriceRange'] -> videoCardMaxPrice }}">
																							</div>
																							<input type="hidden" class="slider-input" value="{{ $contentData['configuration']['productPriceRange'] -> videoCardMinPrice }}, {{ $contentData['configuration']['productPriceRange'] -> videoCardMaxPrice }}"/>
																					</ul>
																			</div>
																		  <!--- Price filter end ----->


																			<!--- Video card manufacturer filter start ------>

																			<div class="layered_filter">
																					<h2 class="title_block">
																						<span class="font-3">მწარმოებლები</span>
																					</h2>
																					<ul class="col-lg-12 layered_filter_ul">

																						@foreach($contentData['configuration']['videoCardsManufacturers'] as $key => $value)
																							<li class="nomargin hiddable col-lg-12">
																									<input type="checkbox" class="checkbox" value="{{ $value -> id }}" data-active="0" data-hidden-input="video-card-manufacturer"/>
																									<label for="">
																											<a href="#" data-rel="nofollow">
																												<b>{{ $value -> videoCardManufacturerTitle }}</b>
																												<span> ({{ $value -> numOfProducts }})</span>
																											</a>
																									</label>
																							 </li>
																						 @endforeach
																					 </ul>
																				 <input name="video-card-manufacturer" type="hidden" class="video-card-manufacturer" value="0">
																				</div>

																			 <!--- Video card manufacturer filter filter end ------>

																			<!--- GPU manufacturer filter start ----->

																			<div class="layered_filter">
																					<h2 class="title_block">
																						<span class="font-3">გრაფიკული პროცესორი</span>
																					</h2>
																					<ul class="col-lg-12 layered_filter_ul">

																						@foreach($contentData['configuration']['gpuManufacturers'] as $key => $value)
																							<li class="nomargin hiddable col-lg-12">
																									<input type="checkbox" class="checkbox" value="{{ $value -> id }}" data-active="0" data-hidden-input="gpu-manufacturer"/>
																									<label for="">
																											<a href="#" data-rel="nofollow">
																												<b>{{ $value -> gpuTitle }}</b>
																												<span> ({{ $value -> numOfProducts }})</span>
																											</a>
																									</label>
																							 </li>
																						 @endforeach
																					 </ul>
																				 <input name="gpu-manufacturer" type="hidden" class="gpu-manufacturer" value="0">
																				</div>

																			 <!--- GPU manufacturer filter filter end ------->

																			 <!--- Memory capacity filter start ------->

 																				<div class="layered_filter">
 																						<h2 class="title_block">
 																						 <span class="font-3">მეხსიერების მოცულობა</span>
 																					 </h2>
 																					<ul class="col-lg-12 layered_filter_ul">
 																					 @foreach($contentData['configuration']['memoryCapacities'] as $key => $value)
 																							<li class="nomargin hiddable col-lg-12">
 																									<input type="checkbox" class="checkbox" value="{{ $value -> memory }}" data-active="0" data-hidden-input="memory-capacity"/>
 																									<label for="">
 																											<a href="#" data-rel="nofollow">
 																												<b>{{ $value -> memory }} GB</b>
 																												<span> ({{ $value -> numOfProducts }})</span>
 																											</a>
 																									</label>
 																							</li>
 																						@endforeach
 																					</ul>
 																			 <input name="memory-capacity" type="hidden" class="memory-capacity" value="0">
 																			</div>

 																			<!--- Memory capacity filter filter end ----->

																			<!--- Memory type filter start ------->

																				<div class="layered_filter">
																						<h2 class="title_block">
																						 <span class="font-3">მეხსიერების ტიპი</span>
																					 </h2>
																					<ul class="col-lg-12 layered_filter_ul">
																					 @foreach($contentData['configuration']['memoryTypes'] as $key => $value)
																							<li class="nomargin hiddable col-lg-12">
																									<input type="checkbox" class="checkbox" value="{{ $value -> id }}" data-active="0" data-hidden-input="memory-type"/>
																									<label for="">
																											<a href="#" data-rel="nofollow">
																												<b>{{ $value -> typeTitle }}</b>
																												<span> ({{ $value -> numOfProducts }})</span>
																											</a>
																									</label>
																							</li>
																						@endforeach
																					</ul>
																			 <input name="memory-type" type="hidden" class="memory-type" value="0">
																			</div>

																			<!--- Memory type filter filter end -------->


																			<!--- Memory bandwidth filter start ----->

																				<div class="layered_filter">
																						<h2 class="title_block">
																						 <span class="font-3">მეხსიერების ინტერფეისი</span>
																					 </h2>
																					<ul class="col-lg-12 layered_filter_ul">
																					 @foreach($contentData['configuration']['memoryInterfaces'] as $key => $value)
																							<li class="nomargin hiddable col-lg-12">
																									<input type="checkbox" class="checkbox" value="{{ $value -> memoryBandwidth }}" data-active="0" data-hidden-input="memory-bandwidth"/>
																									<label for="">
																											<a href="#" data-rel="nofollow">
																												<b>{{ $value -> memoryBandwidth }} Bit</b>
																												<span> ({{ $value -> numOfProducts }})</span>
																											</a>
																									</label>
																							</li>
																						@endforeach
																					</ul>
																			 <input name="memory-bandwidth" type="hidden" class="memory-bandwidth" value="0">
																			</div>

																			<!--- Memory bandwidth  filter filter end ------>


																			<!--- Stock type filter start ------->

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

                                  <!--- Stock type filter end ------>


																	<!--- Condition filter start ----->

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
																	<!--- Condition filter end ---->

																	</div>
															</form>
													</div>

										</div>
									</div>

									<!--- VideoCards list start ------->

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
																					<option value="9">9</option>
																					<option value="12" selected>12</option>
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
																	<li id="grid">
																		<a rel="nofollow" href="#" data-toggle="tooltip" data-placement="top">
																			<i class="fa fa-th"></i>
																		</a>
																	</li>
																	<li id="list">
																		<a rel="nofollow" href="#" data-toggle="tooltip" data-placement="top">
																			<i class="fa fa-list"></i>
																		</a>
																	</li>
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
																					<option value="5">დამატების დროის კლებადობით</option>
																					<option value="6">დამატების დროის ზრდადობით</option>
																			</select>
																	</div>
															</form>
													</div>
											 <!-- Sort bar end -->
										 </div>

										<!-- Products list -->
										 <div id="result-content">
											@foreach($contentData['videoCards'] as $index => $row)
											 <ul class="product_list grid row showcolumn3" >
												 @foreach($row as $key => $value)
													 <li class="ajax_block_product col-xs-12 col-sm-6 col-md-4 last-in-line first-item-of-tablet-line last-item-of-mobile-line">
															 <div class="product-container">
																	 <div class="dor-display-product-info">
																			 <div class="left-block">
																					 <div class="product-image-container">
																							 <a class="product_img_link" target="_blank" href="/videoCards/{{ $value -> id }}" title="{{ $value -> title }}">
																								<img class="replace-2x img-responsive" src="/images/videoCards/main/original/{{ $value -> mainImage }}" width="450" height="478"/>
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
																							 <a class="product-name font-4" target="_blank" target="_blank" href="/videoCards/{{ $value -> id }}" title="{{ $value -> title }}">
																								 <span class="font-4">{{ $value -> title }} </span>
																							 </a>
																							</h5>

																							<div class="product-desc" itemprop="description">
																								 <div>
																									 <b class="font-4">გრაფიკული პროცესორი: </b>
																									 <span>{{ $value -> gpuTitle }}</span>
																								 </div>
																								 <div>
																									 <b class="font-4">მეხსიერების მოცულობა: </b>
																									 <span>{{ $value -> memory }} GB</span>
																								 </div>
																								 <div>
																									 <b class="font-4">მეხსიერების ტიპი: </b>
																									 <span>{{ $value -> typeTitle }}</span>
																								 </div>
																								 <div>
																									 <b class="font-4">მეხსიერების ინტერფეისი: </b>
																									 <span>{{ $value -> memoryBandwidth }} Bit</span>
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
																														<a class="button read-more-button btn btn-default" target="_blank" target="_blank" href="/videoCards/{{ $value -> id }}">
																															<i class="fa fa-plus"></i>
																															<span class="font-3">დაწვრილებით</span>
																														</a>
																												</div>
																												<div class="short-description">
																													<div>
				 																									 <b class="font-4">პროცესორი: </b>
				 																									 <span>{{ $value -> gpuTitle }}</span>
				 																								 </div>
				 																								 <div>
				 																									 <b class="font-4">მოცულობა: </b>
				 																									 <span>{{ $value -> memory }} GB</span>
				 																								 </div>
				 																								 <div>
				 																									 <b class="font-4">ტიპი: </b>
				 																									 <span>{{ $value -> typeTitle }}</span>
				 																								 </div>
				 																								 <div>
				 																									 <b class="font-4">ინტერფეისი: </b>
				 																									 <span>{{ $value -> memoryBandwidth }} Bit</span>
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
								 <!--- Video Cards list end ----->
							</div>
						<!-- .row -->
					 </div>
					<!-- #columns -->
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
