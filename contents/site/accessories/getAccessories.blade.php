
@if($data['productsExist'])

  @foreach($data['products'] as $index => $row)

   <ul class="product_list grid row showcolumn3" >
     @foreach($row as $key => $value)
       <li class="ajax_block_product col-xs-12 col-sm-6 col-md-4 last-in-line first-item-of-tablet-line last-item-of-mobile-line">
           <div class="product-container">
               <div class="dor-display-product-info">
                   <div class="left-block">
                       <div class="product-image-container">
                           <a class="product_img_link" target="_blank" href="/accessories/{{ $value -> id }}" title="{{ $value -> title }}">
                            <img class="replace-2x img-responsive" src="/images/accessories/main/original/{{ $value -> mainImage }}" width="450" height="478"/>
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
                           <a class="product-name font-4" target="_blank" href="/accessories/{{ $value -> id }}" title="{{ $value -> title }}">
                             <span class="font-4">{{ $value -> title }} </span>
                           </a>
                          </h5>

                          <div class="product-desc" itemprop="description">
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
                                        <a class="button read-more-button btn btn-default" target="_blank" href="/accessories/{{ $value -> id }}">
                                          <i class="fa fa-plus"></i>
                                          <span class="font-3">დაწვრილებით</span>
                                        </a>
                                    </div>
                                    <div class="short-description">
                                    </div>
                                </div>
                             </div>
                         <!-- .product-container> -->
                       </li>
                   @endforeach
                 </ul>
              @endforeach

  <!-- Pagination start-->

    <div class="content_sortPagiBar">
      <div class="bottom-pagination-content clearfix">

        <div id="pagination_bottom" class="pagination clearfix" style="width: 80%">
          <ul class="pagination">

            @if($data['currentPage'] > 1)

              <li id="pagination_previous_bottom" class="pagination_previous">
                <a href="{{ $data['currentPage'] - 1 }}" rel="prev">
                  <i class="icon-chevron-left"></i>
                </a>
              </li>

              @endif

              @foreach($data['pages'] as $page)

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

              @if($data['currentPage'] < $data['maxPage'])

                <li id="pagination_next_bottom" class="pagination_next">
                 <a href="{{ $data['currentPage'] + 1 }}" rel="next">
                  <i class="icon-chevron-right"></i>
                 </a>
                </li>

              @endif

            </ul>
          </div>
        </div>
     </div>

  <!-- Pagination end -->

@endif
