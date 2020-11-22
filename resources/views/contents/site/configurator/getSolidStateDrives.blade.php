
<div class="part-select-head">
  <h1 class="font-4"> SSD მეხსიერება </h1>
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
        <img src="/images/solidStateDrives/main/original/{{ $part -> mainImage }}" class="part-image">
      </div>
      <div class="col-sm-7">
       <div class="part-to-select-container">
         <h1 class="part-to-select-title font-4">{{ $part -> title }}</h1>
         <div class="part-to-select-description">

           <div class="part-specification">
             <b class="font-4">მეხსიერება </b>
             <span> {{ $part -> capacity }} GB</span>
           </div>

           <div class="part-specification">
             <b class="font-4">ფორმფაქტორი </b>
             <span> {{ $part -> formFactorTitle }}</span>
           </div>

           <div class="part-specification">
             <b class="font-4">მდგომარეობა </b>
             <span class="font-4"> {{ $part -> conditionTitle }}</span>
           </div>

           <div class="part-specification">
             <b class="font-4">საწყობის ტიპი </b>
             <span class="font-4"> {{ $part -> stockTitle }}</span>
           </div>

           @if($part -> quantity != 0)
           <div class="part-specification">
             <b class="font-4">დარჩენილი ერთეულები </b>
             <span> {{ $part -> quantity }}</span>
           </div>
           @endif
        </div>
       </div>
      </div>

      <div class="col-sm-3">

        <div class="part-current-price-container">
         <span class="part-current-price">₾ {{ $part -> price - $part -> discount }}</span>
        </div>

        @if($part -> discount != 0)
        <div class="part-old-price-container">
          <span class="part-old-price">₾ {{ $part -> price }}</span>
        </div>
        @endif

        <div class="part-choose-button-container" data-part-id="{{ $part -> id }}" data-part-select-uri="/configurator/selectSolidStateDrive">
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
