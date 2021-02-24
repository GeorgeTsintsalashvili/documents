
<div class="panel panel-default" id="product-data-container" data-record-id="{{ $product -> id }}">

 <div class="panel-heading">
   <h2 id="back-button">
     <i class="fas fa-long-arrow-alt-left"></i>
     <span class="font-3"> უკან დაბრუნება </span>
   </h2>
   <div class="options">
    <ul class="nav nav-tabs">
      <li class="active">
        <a href="#editor" data-toggle="tab" class="font-4">რედაქტორი</a>
      </li>
      <li>
        <a href="#images" data-toggle="tab" class="font-4">სურათები</a>
      </li>
    </ul>
   </div>
 </div>

 <div class="panel-body">

  <div class="tab-content">

    <div class="tab-pane active" id="editor">

      <form class="form-horizontal record-update-form" method="POST" action="{{ route('sbUpdate') }}">

          <div class="form-group">

             <input type="hidden" name="record-id" value="{{ $product -> id}}">

             <div class="col-sm-12">
              <div class="summernote">
               {!! $product -> description !!}
              </div>
              <input type="hidden" name="description" id="description">
             </div>

          </div>

          <div class="form-group">

            <label class="col-sm-1 control-label font-4">SEO</label>

            <div class="col-sm-5">
              <textarea class="form-control font-1" name="seoKeywords" rows="6" placeholder="საგასაღებო სიტყვები">{{ $product -> seoKeywords }}</textarea>
            </div>

            <label class="col-sm-1 control-label font-4"> </label>

            <div class="col-sm-5">
              <textarea class="form-control font-1" name="seoDescription" rows="6" placeholder="მოკლე აღწერა">{{ $product -> seoDescription }}</textarea>
            </div>

          </div>

          <div class="form-group">

              <label class="col-sm-1 control-label font-4">სისტემა</label>
              <div class="col-sm-2">
               <select name="seriesId" class="edit-page-list wpr-100">
                 @foreach($series as $value)
                   @if($value -> id == $product -> seriesId)
                    <option selected class="font-4" value="{{ $value -> id }}">{{ $value -> seriesTitle }}</option>
                   @else
                    <option class="font-4" value="{{ $value -> id }}">{{ $value -> seriesTitle }}</option>
                   @endif
                 @endforeach
               </select>
              </div>

              <label class="col-sm-1 control-label font-4">გრაფიკა</label>
               <div class="col-sm-2">
                  <select name="computerGraphicsId" class="edit-page-list wpr-100">
                    @foreach($graphics as $value)
                      @if($value -> id == $product -> computerGraphicsId)
                       <option selected class="font-4" value="{{ $value -> id }}">{{ $value -> graphicsTitle }}</option>
                      @else
                        <option class="font-4" value="{{ $value -> id }}">{{ $value -> graphicsTitle }}</option>
                      @endif
                     @endforeach
                  </select>
              </div>

                <label class="col-sm-1 control-label font-4">გარანტია</label>
                <div class="col-sm-2">
                 <input type="text" name="warrantyDuration" class="form-control" value="{{ $product -> warrantyDuration }}">
                </div>

                <label class="col-sm-1 control-label font-4">ვადა</label>
                <div class="col-sm-2">

                 <select name="warrantyId" class="edit-page-list wpr-100">
                  @foreach($warranties as $value)
                   @if($value -> id == $product -> warrantyId)
                     <option selected class="font-4" value="{{ $value -> id }}">{{ $value -> durationUnit }}</option>
                   @else
                     <option class="font-4" value="{{ $value -> id }}">{{ $value -> durationUnit }}</option>
                   @endif
                 @endforeach
                </select>
               </div>

           </div>

           <div class="form-group">

              <label class="col-sm-1 control-label font-4">CPU</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" name="cpu" value="{{ $product -> cpu }}">
              </div>

              <label class="col-sm-1 control-label font-4">RAM</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" name="memory" value="{{ $product -> memory }}">
              </div>

              <label class="col-sm-1 control-label font-4">HDD</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" name="hardDiscDriveCapacity" value="{{ $product -> hardDiscDriveCapacity }}">
              </div>

              <label class="col-sm-1 control-label font-4">SSD</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" name="solidStateDriveCapacity" value="{{ $product -> solidStateDriveCapacity }}">
              </div>

           </div>

          <div class="form-group">

              <label class="col-sm-1 control-label font-4">GPU</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" name="gpuTitle" value="{{ $product -> gpuTitle }}">
              </div>

              <label class="col-sm-1 control-label font-4">VRAM</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" name="videoMemory" value="{{ $product -> videoMemory }}">
              </div>

          </div>

           <div class="panel-footer">
            <div class="row">
              <div class="col-sm-3 col-sm-offset-1">
                <input type="submit" class="btn-primary btn font-4" value="განახლება">
              </div>
            </div>
          </div>

       </form>
    </div>

  <div class="tab-pane" id="images">

    <div class="panel panel-default">
      <div class="panel-heading">
        <h2 class="font-4"> მთავარი სურათი </h2>
      </div>
      <div class="panel-body">
        <div class="tab-content">
          <div class="row mb50">
            <div class="col-sm-4">
              <a href="/computers/{{ $product -> id }}" target="_blank">
               <img id="main-image" src="/images/computers/main/original/{{ $product -> mainImage }}" class="img-responsive img-thumbnail wpr-100">
               <span id="main-image-link-icon">
                 <i class="fas fa-link"></i>
               </span>
              </a>
            </div>

            <div class="col-sm-8">
              <form method="POST" action="{{ route('sbImageUpdate') }}" class="dropzone" id="main-image-dropzone" enctype="multipart/form-data">
                <div class="fallback">
                 <input type="file" name="mainImage">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">
        <h2 class="font-4"> სურათები </h2>
      </div>
      <div class="panel-body">

      <div class="tab-content">

        <div class="row">
         <div class="col-md-12">
             <div class="owl-carousel owl-theme">
               @foreach($images as $image)
                <div class="item">
                  <a href="/images/computers/slides/original/{{ $image -> image }}" data-fancybox-group="button" class="fancy fancybox-buttons zoom-button">
                    <i class="fas fa-expand"></i>
                  </a>
                  <a href="{{ route('sbImgDestroy', ['id' => $image -> id]) }}" class="image-delete-button">
                    <i class="fas fa-trash-alt"></i>
                  </a>
                  <img src="/images/computers/slides/preview/{{ $image -> image }}">
                </div>
               @endforeach
             </div>
         </div>
       </div>

        <div class="row mt40">
          <div class="col-md-12">
            <form method="POST" action="{{ route('sbImageUpload') }}" class="dropzone" enctype="multipart/form-data" id="images-dropzone">
            </form>
          </div>
        </div>

      </div> <!--- inline tab content end--->

    </div> <!--- inline panel body end --->

   </div> <!--- inline panel end --->

  </div>

 </div>

 </div>

</div>

@include('parts.user.general')

@include('parts.user.plugins.summernote')

@include('parts.user.plugins.carousel')

@include('parts.user.plugins.fancybox')

@include('parts.user.plugins.dropzone')

@include('parts.user.editPage')
