
 <div class="part-select-head">
    <h1 class="font-4"> ოპერატიულები </h1>
     <a href="#" class="select-part-window-close-button">
      <i class="fa fa-times"></i>
     </a>
    </div>
    <div class="part-select-filter">
      <a href="0" class="{{ $data['filter-parameter'] == 0 ? 'active-filter-link' : 'inactive-filter-link' }}"> All </a>
     @foreach($data['capacities'] as $value)
      <a href="{{ $value -> capacity }}" class="{{ $data['filter-parameter'] == $value -> capacity ? 'active-filter-link' : 'inactive-filter-link' }}"> {{ $value -> capacity }}GB </a>
     @endforeach
    </div>
    <div class="part-select-body">
     <div class="part-select-list container">

       @if($data['partsExist'])

       @foreach($data['products'] as $part)

       <div class="row parts-item">
        <div class="col-sm-2">
          <img src="/images/memoryModules/main/original/{{ $part -> mainImage }}" class="part-image">
        </div>
        <div class="col-sm-7">
         <div class="part-to-select-container">
           <h1 class="part-to-select-title font-4">{{ $part -> title }}</h1>
           <div class="part-to-select-description">

             <div class="part-specification">
               <b class="font-4">მოცულობა </b>
               <span> {{ $part -> capacity }} GB</span>
             </div>

              <div class="part-specification">
                <b class="font-4">სიხშირე </b>
                <span> {{ $part -> frequency }} Mhz</span>
              </div>

              <div class="part-specification">
               <b class="font-4">მეხსიერების ტიპი </b>
               <span> {{ $part -> typeTitle }}</span>
             </div>

             <div class="part-specification">
               <b class="font-4">იყიდება </b>
               <span class="font-4"> {{ $part -> isCouple ? 'წყვილ-წყვილად' : 'ცალ-ცალად' }} </span>
             </div>

             <div class="part-specification">
               <b class="font-4">მდგომარეობა </b>
               <span class="font-4"> {{ $part -> conditionTitle }}</span>
             </div>

          </div>
         </div>
        </div>

        <div class="col-sm-3">

          <div class="part-current-price-container">
           <span class="part-current-price">₾ {{ $part -> price - $part -> discount }} </span>
          </div>

          @if($part -> discount != 0)
           <div class="part-old-price-container">
            <span class="part-old-price">₾ {{ $part -> price }}</span>
           </div>
          @endif

          <div class="quantity-product-option">
            <div id="quantity_wanted_p" class="dor-atr-mes">
              <div class="quantity_value_opt">
                <div class="qty-button-control dor-quantity-p dor-quantity-minus">
                  <a href="#" data-field-quantity="quantity" class="btn btn-default button-minus product_quantity_down">
                    <span>
                      <i class="icon-minus"></i>
                    </span>
                  </a>
                </div>
                <input type="text" name="quantity" value="1" data-allowed-quantity="{{ $part -> units }}" min="1" class="text dor-quantity-p quantity_wanted">
                <div class="qty-button-control dor-quantity-p dor-quantity-plus">
                  <a href="#" data-field-quantity="quantity" class="btn btn-default button-plus product_quantity_up">
                    <span>
                      <i class="icon-plus"></i>
                    </span>
                  </a>
                </div>
              </div>
            </div>
          </div>

          <div class="part-choose-button-container" data-part-id="{{ $part -> id }}" data-part-select-uri="/configurator/selectMemory">
            <button class="part-choose-button font-3"> დამატება </button>
          </div>

        </div>
       </div>
      @endforeach

    @else
     <h1 class="font-4 component-not-found-heading"> <i class="fa fa-exclamation-triangle"></i> კომპონენტი ვერ მოიძებნა</h1>
    @endif

     </div>
    </div>
