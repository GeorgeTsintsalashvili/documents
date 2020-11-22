@if($computersExist)

<!-- Products list -->
 <ul id="dor-product-tab-categories-data" class="product_list grid row dor-product-tab-categories showcolumn">

  @foreach($computers as $value)
   <li class="ajax_block_product col-xs-12 col-sm-4 col-md-3 first-in-line first-item-of-tablet-line first-item-of-mobile-line">
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

                     <span class="price product-price"><b class="currency-gel">₾</b> {{ $value -> price - $value -> discount }} </span>
                     <span class="old-price product-price">₾ {{ $value -> price }} </span>

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
@endif
