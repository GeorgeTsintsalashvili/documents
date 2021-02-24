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
								<span class="last-breadcrumb-part font-3">კალათა</span>
							</div>
						</div>
					</div>
			</div>
	 <!-- /Breadcrumb -->

     <div class="columns-container">
         <div id="columns" class="container ">
             <div class="row">

                 <div id="center_column" class="center_column dor-two-cols col-xs-12 col-sm-12">

                     @if($contentData['shoppingCartIsNotEmpty'])

										 <div class="header-my-cart">
												 <span class="heading-counter font-4">თქვენს კალათაში არის
												 <span id="summary_products_quantity">{{ $contentData['numberOfProducts'] }} პროდუქტი</span>
												 </span>
										 </div>

                     <div id="order-detail-content" class="table_block table-responsive">
                         <table id="cart_summary" class="table table-bordered stock-management-on">
                             <thead class="font-4">
                                 <tr>
                                  <th class="cart_product first_item" colspan="2">პროდუქცია</th>
                                  <th class="cart_unit item text-center">კოდი</th>
                                  <th class="cart_quantity item text-center">რაოდნეობა</th>
                                  <th class="cart_total item text-center">ღირებულება</th>
                                  <th class="cart_del item text-center"></th>
                                 </tr>
                             </thead>
                             <tfoot>

                                 <tr class="cart_total_voucher">
                                     <td colspan="2">
                                       <span class="font-4">
                                         საერთო ფასდაკლება
                                       </span>
                                     </td>
                                     <td class="price-discount price" id="total_discount_container">
                                        <b>₾ </b>
																				<span id="total_discount">{{ $contentData['totalDiscount'] }}</span>
                                     </td>
                                 </tr>
                                 <tr class="cart_total_price">
                                     <td colspan="2" class="total_price_container">
                                         <span class="font-4">საერთო ღირებულება</span>
                                         <div class="hookDisplayProductPriceBlock-price">
                                         </div>
                                     </td>
                                     <td class="price" id="total_price_container">
																			 <b>₾ </b>
                                       <span id="total_price">{{ $contentData['totalPrice'] }}</span>
                                     </td>
                                 </tr>
                             </tfoot>
                             <tbody>

                                @foreach($contentData['products'] as $value)

                                 <tr class="cart_item first_item address_0 odd" data-category-id="{{ $value -> categoryId }}" data-product-id="{{ $value -> id }}" data-max-quantity="{{ $value -> quantity }}">
                                     <td class="cart_product">
                                      <a target="_blank" href="/{{ $value -> pathPart }}/{{ $value -> id }}">
                                        <img src="/images/{{ $value -> pathPart }}/main/preview/{{ $value -> mainImage }}" width="100" height="100"/>
                                      </a>
                                     </td>
                                     <td class="cart_description">
                                      <p class="product-name">
                                        <a target="_blank" class="font-4" href="/{{ $value -> pathPart }}/{{ $value -> id }}">{{ $value -> title }}</a>
                                      </p>
                                     </td>
                                     <td>
                                        <ul class="price text-right" id="product_price_18_144_0">
                                          <li class="code">{{ $value -> code }}</li>
                                        </ul>
                                     </td>

                                     <td class="cart_quantity text-center">

                                         <div class="cart_quantity_button clearfix">
                                             <a rel="nofollow" class="cart_quantity_down btn btn-default button-minus" href="#" title="გამოკლება">
                                                 <span>
                                                   <i class="icon-minus"></i>
                                                 </span>
                                             </a>

                                             <input type="text" autocomplete="off" class="cart_quantity_input form-control grey" value="{{ $value -> numOfUnits }}" name="quantity_18_144_0_0" />

                                             <a rel="nofollow" class="cart_quantity_up btn btn-default button-plus" href="#" title="დამატება">
                                               <span>
                                                 <i class="icon-plus"></i>
                                               </span>
                                             </a>
                                         </div>
                                     </td>
                                     <td class="cart_total text-center">
                                      <span class="price" id="total_product_price_18_144_0">
                                        ₾ {{ $value -> totalPrice }}
                                      </span>
																			@if($value -> totalPrice < $value -> originalPrice)
																			 <b class="original-price">
																				₾{{ $value -> originalPrice }}
																			 </b>
																			@endif
                                     </td>
                                     <td class="cart_delete text-center" data-title="წაშლა">
                                      <div>
                                        <a rel="nofollow" title="წაშლა" class="cart_quantity_delete" id="18_144_0_0" href="#">
                                          <i class="fa fa-times"></i>
                                        </a>
                                      </div>
                                     </td>
                                 </tr>
																@endforeach
                             </tbody>
                         </table>
                     </div>
                     <!-- end order-detail-content -->

										 <!--- Make this button visible --->
                     <div id="HOOK_SHOPPING_CART"></div>
                     <p class="cart_navigation clearfix" style="display: none">
                      <a href="#" id="purchase-button" class="button btn btn-default standard-checkout button-medium">
                        <span class="font-3">პროდუქციის შეძენა</span>
                      </a>
                     </p>
                     <div class="clear"></div>
                     <div class="cart_navigation_extra">
                      <div id="HOOK_SHOPPING_CART_EXTRA"></div>
                     </div>

									@else
										<div class="header-my-cart" id="cart-is-empty">
											<span class="heading-counter font-4">ამჟამად თქვენი კალათა ცარიელია</span>
										</div>
                  @endif

                 </div>
                 <!-- #center_column -->
             </div>
             <!-- .row -->
         </div>
         <!-- #columns -->
     </div>
  <!-- .columns-container -->

<link rel="stylesheet" href="/css/shopping-cart.css" type="text/css" />

<script type="text/javascript" src="/js/shopping-cart.js"></script>

@endsection
