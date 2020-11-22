
  @if($accessoriesExist)

  <!-- Products list -->
  <ul id="dor-product-tabpro-data" class="product_list grid row dor-product-tabpro showcolumn3">

      @foreach($accessories as $value)

      <li class="ajax_block_product col-xs-12 col-sm-4 col-md-3 last-item-of-mobile-line">
          <div class="product-container" itemscope itemtype="#">
              <div class="dor-display-product-info">
                  <div class="left-block">
                      <div class="product-image-container">
                          <a class="product_img_link" href="/accessories/{{ $value -> id }}" title="{{ $value -> mainImage }}" itemprop="url">
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

                        <span class="price product-price"><b class="currency-gel">₾</b> {{ $value -> price - $value -> discount }}</span>
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

@endif
