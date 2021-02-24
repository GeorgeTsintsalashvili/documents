
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="font-mtavruli p-abs">HDD მეხსიერება</h4>
				<div class="options">
				 <ul class="nav nav-tabs">
					 <li class="active">
						 <a href="#products-list" data-toggle="tab" class="font-4">ჩამონათვალი</a>
					 </li>
					 <li>
						 <a href="#add-product" data-toggle="tab" class="font-4">დამატება</a>
					 </li>
				 </ul>
				</div>
			</div>
			<div class="panel-body">

				<div class="tab-content">

				 <div class="tab-pane active" id="products-list">

					 <table class="table table-hover mb1" data-update-route="{{ route('hddUpdateBase') }}">
	 					<thead>
	 						<tr class="font-mtavruli">
	 							<th>სურათი</th>
	 							<th>სათაური</th>
	 							<th>ფასი</th>
	 							<th>ფასდაკლება</th>
	 							<th>მდგომარეობა</th>
	 							<th>საწყობის ტიპი</th>
								<th class="text-center">საგარანტიო</th>
								<th class="text-center">ხილულობა</th>
								<th class="text-center">კონფ-რი</th>
								<th class="text-center">ნახვა</th>
								<th class="text-center">წაშლა</th>
	 						</tr>
	 					</thead>
	 					<tbody>

	           @foreach($items as $value)

	 						<tr data-record-id="{{ $value -> id }}">

	 							<td class="preview-image">
	 								<img src="/images/hardDiskDrives/main/preview/{{ $value -> mainImage }}" class="invoice-image" data-uuid="{{ $value -> uuid }}">
	 							</td>

	 							<td>
									 <input data-parameter-name="title" title="{{ $value -> title }}" type="text" value="{{ $value -> title }}" class="no-border transparent-bg-color field">
	 							</td>

	 							<!--- price and discount fields start --->
	 							<td>
	 								<b> ₾ </b>
	 								<input data-parameter-name="price" class="wpx-50 no-border transparent-bg-color field" value="{{ $value -> price }}">
	 							</td>

	 							<td>
	 								<b> ₾ </b>
	 								<input data-parameter-name="discount" class="wpx-50 no-border transparent-bg-color field" value="{{ $value -> discount }}">
	 							</td>

	 							<!--- price and discount fields end ---->
	 							<td>
	 								<select data-parameter-name="conditionId" class="wpr-100 record-update-data-list field">
	 									@foreach($conditions as $conditon)
	 										<option class="font-4" {{ $value -> conditionId == $conditon -> id ? "selected" : null }} value="{{ $conditon -> id }}">{{ $conditon -> conditionTitle }}</option>
	 									@endforeach
	 								</select>
	 							</td>

	 							<td>
	 								<select data-parameter-name="stockTypeId" class="wpr-100 record-update-data-list field">
	 									@foreach($stockTypes as $stock)
	 										<option class="font-4" {{ $value -> stockTypeId == $stock -> id ? "selected" : null }} value="{{ $stock -> id }}">{{ $stock -> stockTitle }}</option>
	 									@endforeach
	 								</select>
	 							</td>

								<td class="text-center">
									<a class="add-warranty mr20" href="{{ $value -> uuid }}" data-system-part="0" data-warranty-page="parts" data-warranty="{{ $value -> warranty }}" style="line-height: 1">
									 <i style="font-size: 22px" class="fa fa-wrench"></i>
									</a>

								 <a class="add-warranty" href="{{ $value -> uuid }}" data-system-part="1" data-warranty-page="computer" data-warranty="{{ $value -> warranty }}" style="line-height: 1">
									<i style="font-size: 24px" class="flaticon-016-tower"></i>
								 </a>
								</td>

	 							<td class="text-center">
	 								<input data-parameter-name="visibility" class="record-update-switch field" data-size="mini" type="checkbox" {{ $value -> visibility != 0 ? "checked" : null }} value="{{ $value -> visibility }}">
	 							</td>

								<td class="text-center">
									<input data-parameter-name="configuratorPart" class="record-update-switch field" data-size="mini" type="checkbox" {{ $value -> configuratorPart ? "checked" : null }} value="{{ $value -> configuratorPart }}">
								</td>

	 							<td class="text-center">
	 							 <a class="view-page" href="{{ route('hddEdit', ['id' => $value -> id]) }}">
	 								<i style="font-size: 18px" class="fas fa-edit" aria-hidden="true"></i>
	 							 </a>
	 							</td>

	 							<td class="text-center">
	 								<a class="delete-record" href="{{ route('hddDestroy', ['id' => $value -> id]) }}">
	 									<i style="font-size: 16px" class="fas fa-trash-alt" aria-hidden="true"></i>
	 								</a>
	 							</td>

	 						</tr>

	           @endforeach

	 				 </tbody>
	 				</table>

	         <div data-page-key="{{ $paginationKey }}" data-current-page="{{ $paginator -> currentPage }}" class="clearfix pagination-column col-sm-12">

	           <div class="col-sm-4">
	             <div class="input-group">
	               <span class="input-group-addon">
	                 <i class="fas fa-search"></i>
	               </span>
	               <input id="search-field" type="text" autocomplete="off" data-control-parameter-name="search-query" value="{{ $searchQuery }}" class="form-control font-4 control-field" placeholder="საძიებო სიტყვა">
	             </div>
	    			  </div>

	           <ul class="pagination mt0 mb20 col-sm-5">

	               @if($paginator -> currentPage > 1)

	                <li>
	                 <a href="{{ $paginator -> currentPage - 1 }}" class="page-switch">
	                   <i class="fa fa-angle-double-left" aria-hidden="true"></i>
	                 </a>
	                </li>

	               @endif

	               @foreach($paginator -> pages as $page)

	               @if($page['isPad'])

	               <li>
	                 <span>{{ $page['value'] }}</span>
	               </li>

	               @elseif($page['isActive'])

	               <li class="active">
	                 <span>{{ $page['value'] }}</span>
	               </li>

	               @else

	               <li>
	                <a href="{{ $page['value'] }}" class="page-switch">{{ $page['value'] }}</a>
	               </li>

	               @endif

	               @endforeach

	               @if($paginator -> currentPage < $paginator -> maxPage)

	               <li>
	                 <a href="{{ $paginator -> currentPage + 1 }}" class="page-switch">
	                   <i class="fa fa-angle-double-right" aria-hidden="true"></i>
	                 </a>
	               </li>

	               @endif

	            </ul>

	         </div>

	 				<div class="row p10">
	 					<div class="col-sm-6">
	 						<div class="alert alert-dismissable alert-warning">
	 								<p class="font-4">
	 									<i class="fa fa-exclamation-triangle"></i>
	 									<span style="font-size: 14px">საქონლის მინიმალური დაშვებული ფასი - </span>
	 									<b id="min-price" data-price="{{ $minPrice }}"> {{ $minPrice }} ლარი</b>
	 								</p>
	 								<p class="font-4">
	 								 <i class="fa fa-exclamation-triangle"></i>
	 								 <span style="font-size: 14px">საქონლის მაქსიმალური დაშვებული ფასი - </span>
	 								 <b id="max-price" data-price="{{ $maxPrice }}"> {{ $maxPrice }} ლარი</b>
	 								</p>
	 						</div>
	 				 </div>
	 				</div>

				 </div>

				 <div class="tab-pane" id="add-product">

					 <form action="{{ route('hddStore') }}" method="POST" class="form-horizontal row-border store-form" enctype="multipart/form-data">
 						<div class="form-group">

							<label class="col-sm-1 control-label font-4">სათაური</label>
							<div class="col-sm-3">
								<div class="input-group font-4">
									<span class="input-group-addon icheck">
										<input type="checkbox" name="configuratorPart">
									</span>
									<input type="text" name="title" class="form-control">
								</div>
							</div>

 							<label class="col-sm-1 control-label font-4">ფასი</label>
  						<div class="col-sm-3">
  			       <input type="text" id="touchspin1" name="price" class="form-control">
  			      </div>

 						  <label class="col-sm-1 control-label font-4">ფასდ-ბა</label>
 							<div class="col-sm-3">
 							 <input type="text" value="0" name="discount" class="form-control" id="touchspin2">
 							</div>

 						</div>

 						<div class="form-group">

 							<label class="col-sm-1 control-label font-4">ვადა</label>
 							<div class="col-sm-3">
 								 <select name="warrantyId" class="form-select wpr-100">
 									 @foreach($warranties as $value)
 										 <option class="font-4" value="{{ $value -> id }}">{{ $value -> durationUnit }}</option>
 									 @endforeach
 								 </select>
 							</div>

 							<label class="col-sm-1 control-label font-4">მდგო-ბა</label>
 							<div class="col-sm-3">
 								<select name="conditionId" class="form-select wpr-100">
 									@foreach($conditions as $value)
 		                <option class="font-4" value="{{ $value -> id }}">{{ $value -> conditionTitle }}</option>
 									@endforeach
 								</select>
 							</div>
 							<label class="col-sm-1 control-label font-4">საწყობი</label>
 							<div class="col-sm-3">
 								<select name="stockTypeId" class="form-select wpr-100">
 									@foreach($stockTypes as $value)
 		                <option class="font-4" value="{{ $value -> id }}">{{ $value -> stockTitle }}</option>
 									@endforeach
 								</select>
 							</div>
 						 </div>

 						 <div class="form-group">

 						 <label class="col-sm-1 control-label font-4">გარანტია</label>
 						 <div class="col-sm-3">
 								<input type="text" name="warrantyDuration" class="form-control" value="1" id="touchspin3">
 						 </div>

 						 <label class="col-sm-1 control-label font-4">სურათი</label>
 						 <div class="col-sm-3">
 							 <div class="fileinput fileinput-new wpr-100" data-provides="fileinput">
 	 							<div class="input-group">
 	 								<div class="form-control uneditable-input" data-trigger="fileinput">
 	 									<i class="fas fa-upload file-upload-icon"></i>
 										<span class="fileinput-filename">Max. 1 MB</span>
 	 								</div>
 	 								<span class="input-group-btn">
 	 									<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">
 											<i class="fas fa-times"></i>
 										</a>
 	 									<span class="btn btn-default btn-file">
 	 										<span class="fileinput-new upload-button font-4">არჩევა</span>
 	 										<span class="fileinput-exists file-change-button font-4">შეცვლა</span>
 	 										<input type="file" name="mainImage">
 	 									</span>
 	 								</span>
 	 							</div>
 	 						</div>
 						 </div>

 						 <label class="col-sm-1 control-label font-4">ხილულობა</label>
  						 <div class="col-sm-3">
  							<select name="visibility" class="form-select wpr-100">
  								<option class="font-4" value="1">გამოჩნდეს საიტზე</option>
  								<option class="font-4" value="0">არ გამოჩნდეს საიტზე</option>
  							</select>
 						 </div>

 						</div>

 						<div class="form-group">

 						 <label class="col-sm-1 control-label font-4">სურათები</label>
  						 <div class="col-sm-3">
  							 <div class="fileinput fileinput-new wpr-100" data-provides="fileinput">
  	 							<div class="input-group">
  	 								<div class="form-control uneditable-input" data-trigger="fileinput">
  	 									<i class="fas fa-upload file-upload-icon"></i>
  										<span class="fileinput-filename">Max. 1 MB</span>
  	 								</div>
  	 								<span class="input-group-btn">
  	 									<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">
  											<i class="fas fa-times"></i>
  										</a>
  	 									<span class="btn btn-default btn-file">
  	 										<span class="fileinput-new upload-button font-4">არჩევა</span>
  	 										<span class="fileinput-exists file-change-button font-4">შეცვლა</span>
  	 										<input type="file" name="images[]">
  	 									</span>
  	 								</span>
  	 							</div>
  	 						</div>
  						 </div>

 						 <label class="col-sm-1 control-label font-4"> </label>
  						 <div class="col-sm-3">
  							 <div class="fileinput fileinput-new wpr-100" data-provides="fileinput">
  	 							<div class="input-group">
  	 								<div class="form-control uneditable-input" data-trigger="fileinput">
  	 									<i class="fas fa-upload file-upload-icon"></i>
  										<span class="fileinput-filename">Max. 1 MB</span>
  	 								</div>
  	 								<span class="input-group-btn">
  	 									<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">
  											<i class="fas fa-times"></i>
  										</a>
  	 									<span class="btn btn-default btn-file">
  	 										<span class="fileinput-new upload-button font-4">არჩევა</span>
  	 										<span class="fileinput-exists file-change-button font-4">შეცვლა</span>
  	 										<input type="file" name="images[]">
  	 									</span>
  	 								</span>
  	 							</div>
  	 						</div>
  						 </div>

 						 <label class="col-sm-1 control-label font-4"></label>
  						 <div class="col-sm-3">
  							 <div class="fileinput fileinput-new wpr-100" data-provides="fileinput">
  	 							<div class="input-group">
  	 								<div class="form-control uneditable-input" data-trigger="fileinput">
  	 									<i class="fas fa-upload file-upload-icon"></i>
  										<span class="fileinput-filename">Max. 1 MB</span>
  	 								</div>
  	 								<span class="input-group-btn">
  	 									<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">
  											<i class="fas fa-times"></i>
  										</a>
  	 									<span class="btn btn-default btn-file">
  	 										<span class="fileinput-new upload-button font-4">არჩევა</span>
  	 										<span class="fileinput-exists file-change-button font-4">შეცვლა</span>
  	 										<input type="file" name="images[]">
  	 									</span>
  	 								</span>
  	 							</div>
  	 						</div>
  						 </div>

 						 <label class="col-sm-1 control-label font-4"></label>
 							 <div class="col-sm-3">
 								 <div class="fileinput fileinput-new wpr-100" data-provides="fileinput">
 									<div class="input-group">
 										<div class="form-control uneditable-input" data-trigger="fileinput">
 											<i class="fas fa-upload file-upload-icon"></i>
 											<span class="fileinput-filename">Max. 1 MB</span>
 										</div>
 										<span class="input-group-btn">
 											<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">
 												<i class="fas fa-times"></i>
 											</a>
 											<span class="btn btn-default btn-file">
 												<span class="fileinput-new upload-button font-4">არჩევა</span>
 												<span class="fileinput-exists file-change-button font-4">შეცვლა</span>
 												<input type="file" name="images[]">
 											</span>
 										</span>
 									</div>
 								</div>
 							 </div>

 							 <label class="col-sm-1 control-label font-4"></label>
 								 <div class="col-sm-3">
 									 <div class="fileinput fileinput-new wpr-100" data-provides="fileinput">
 										<div class="input-group">
 											<div class="form-control uneditable-input" data-trigger="fileinput">
 												<i class="fas fa-upload file-upload-icon"></i>
 												<span class="fileinput-filename">Max. 1 MB</span>
 											</div>
 											<span class="input-group-btn">
 												<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">
 													<i class="fas fa-times"></i>
 												</a>
 												<span class="btn btn-default btn-file">
 													<span class="fileinput-new upload-button font-4">არჩევა</span>
 													<span class="fileinput-exists file-change-button font-4">შეცვლა</span>
 													<input type="file" name="images[]">
 												</span>
 											</span>
 										</div>
 									</div>
 								 </div>

 								 <label class="col-sm-1 control-label font-4"></label>
 									 <div class="col-sm-3">
 										 <div class="fileinput fileinput-new wpr-100" data-provides="fileinput">
 											<div class="input-group">
 												<div class="form-control uneditable-input" data-trigger="fileinput">
 													<i class="fas fa-upload file-upload-icon"></i>
 													<span class="fileinput-filename">Max. 1 MB</span>
 												</div>
 												<span class="input-group-btn">
 												<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">
 													<i class="fas fa-times"></i>
 												</a>
 												<span class="btn btn-default btn-file">
 												<span class="fileinput-new upload-button font-4">არჩევა</span>
 												<span class="fileinput-exists file-change-button font-4">შეცვლა</span>
 												<input type="file" name="images[]">
 											</span>
 										</span>
 									</div>
 								</div>
 							</div>

 						</div>

 						<div class="form-group">
 							<label class="col-sm-1 control-label font-4">აღწერა</label>
 							<div class="col-sm-11">
 							 <div class="summernote">
 							 </div>
 							 <input type="hidden" name="description" id="description">
 							</div>
 						</div>

 						<div class="form-group">
 							<label class="col-sm-1 control-label font-4">SEO</label>
 							<div class="col-sm-5">
 								<textarea name="seoKeywords" rows="5" placeholder="საგასაღებო სიტყვები" class="form-control font-4"></textarea>
 							</div>
 							<label class="col-sm-1 control-label font-4"> </label>
 							<div class="col-sm-5">
 								<textarea name="seoDescription" rows="5" placeholder="მოკლე აღწერა" class="form-control font-4"></textarea>
 							</div>
 						</div>

 						<div class="form-group">

 							<label class="col-sm-1 control-label font-4">რაოდენობა</label>
 							<div class="col-sm-2">
 								<input type="text" class="form-control" data-reg-exp="^(0|[1-9]\d*)$" name="quantity">
 							</div>

							<label class="col-sm-1 control-label font-4">მოცულობა</label>
 							<div class="col-sm-2">
 								<input type="text" class="form-control" data-reg-exp="^([1-9]\d*)$" name="capacity">
 							</div>

							<label class="col-sm-1 control-label font-4">სიჩქარე</label>
 							<div class="col-sm-2">
 								<input type="text" class="form-control" data-reg-exp="^([1-9]\d*)$" name="rpm">
 							</div>

							<label class="col-sm-1 control-label font-4">ზომა</label>
							<div class="col-sm-2">
 								<select name="formFactorId" class="form-select wpr-100">
 									@foreach($formFactors as $value)
 		                <option class="font-4" value="{{ $value -> id }}">{{ $value -> formFactorTitle }}</option>
 									@endforeach
 								</select>
 							</div>

 						</div>

 						<div class="panel-footer">
 							<div class="row">
 								<div class="col-sm-3 col-sm-offset-1">
 									<input type="submit" class="btn-primary btn font-4" value="დამატება">
 								</div>
 								<div class="col-sm-3 col-sm-offset-0">
 									<img height="60px" src="/images/general/admin-loader.svg" class="loader invisible mt-md n">
 								</div>
 							</div>
 						</div>
 					</form>

         </div>

				</div>

			</div>
		</div>
  </div>
</div>

@include('parts.user.parameters')

@include('parts.user.switches')

@include('parts.user.lists')

@include('parts.user.plugins.summernote')

@include('parts.user.indexPage')

@include('parts.user.addPartWarranty')

@include('parts.user.addPartIntoInvoice')
