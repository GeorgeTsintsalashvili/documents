
<div class="row">
	<div class="col-xs-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="font-mtavruli">საწყობის ტიპი</h4>
			</div>
			<div class="panel-body">
				<table class="table table-hover mb1" data-update-route="{{ route('stockTypeUpdate') }}">
					<thead>
						<tr class="font-3">
							<th>დასახელება</th>
              <th>ფერი</th>
              <th>კონფიგ.</th>
              <th>კალათა</th>
							<th>წაშლა</th>
						</tr>
					</thead>
					<tbody>

          @foreach($stockTypes as $value)

						<tr data-record-id="{{ $value -> id }}">

              <!--- title field ---->
							<td>
								<input data-parameter-name="stockTitle" type="text" value="{{ $value -> stockTitle }}" class="no-border transparent-bg-color font-4 field">
							</td>

              <!--- color field ---->
							<td>
								<input data-parameter-name="statusColor" class="field" type="color" value="{{ $value -> statusColor }}">
							</td>

							<!--- switch button --->
							<td>
								<input data-parameter-name="configuratorPart" class="record-update-switch field" type="checkbox" data-size="mini" value="{{ $value -> configuratorPart }}" {{ $value -> configuratorPart ? "checked" : null }}>
							</td>

              <!--- cart field --->
							<td>
								<input data-parameter-name="enableAddToCartButton" class="record-update-switch field" type="checkbox" data-size="mini" {{ $value -> enableAddToCartButton ? "checked" : null }} value="{{ $value -> enableAddToCartButton }}">
							</td>

              <!--- delete button --->
							<td>
								<a class="delete-record" href="{{ route('stockTypeDestroy', ['id' => $value -> id]) }}">
									<i style="font-size: 16px" class="fa fa-trash" aria-hidden="true"></i>
								</a>
							</td>

						</tr>

          @endforeach

				 </tbody>
				</table>

       <form action="{{ route('stockTypeStore') }}" method="POST" class="form-horizontal row-border data-form" enctype="multipart/form-data">
 				<div class="form-group">
          <div class="col-sm-2">
            <input type="submit" class="btn-primary btn font-4" value="დამატება">
          </div>
 					<div class="col-sm-3">
 						<input name="stockTitle" type="text" class="form-control font-4" placeholder="დასახელება">
 					</div>
          <div class="col-sm-2">
            <input name="statusColor" type="color" style="height: 32px">
          </div>
          <div class="col-sm-2">
            <input class="form-switch" name="configuratorPart" type="checkbox" data-size="medium" data-off-color="default" data-on-text="I" data-off-text="O" checked value="1">
          </div>
          <div class="col-sm-2">
            <input class="form-switch" name="enableAddToCartButton" type="checkbox" data-size="medium" data-off-color="default" data-on-text="I" data-off-text="O" checked value="1">
          </div>
        </div>
       </form>

			</div>
		</div>
  </div>

<!--- product condition --->

<div class="col-xs-6">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="font-mtavruli">პროდუქტის მდგომარეობა</h4>
		</div>
		<div class="panel-body">

			<table class="table table-hover mb1" data-update-route="{{ route('condTypeUpdate') }}">
				<thead>
					<tr class="font-3">
						<th>დასახელება</th>
						<th>წაშლა</th>
					</tr>
				</thead>
				<tbody>

				@foreach($conditions as $value)

					<tr data-record-id="{{ $value -> id }}">

						<!--- title field --->
						<td>
							<input data-parameter-name="condition-title" type="text" value="{{ $value -> conditionTitle }}" class="no-border transparent-bg-color font-4 field">
						</td>

						<!--- delete button ---->
						<td>
							<a class="delete-record" href="{{ route('condTypeDestroy', ['id' => $value -> id]) }}">
								<i style="font-size: 16px" class="fa fa-trash" aria-hidden="true"></i>
							</a>
						</td>

					</tr>

				@endforeach

			 </tbody>
			</table>

		 <form action="{{ route('condTypeStore') }}" method="POST" class="form-horizontal row-border data-form" enctype="multipart/form-data">
			<div class="form-group">
				<div class="col-sm-3">
					<input type="submit" class="btn-primary btn font-4" value="დამატება" style="width: 100%">
				</div>
				<div class="col-sm-4">
					<input name="condition-title" type="text" class="form-control font-4" placeholder="დასახელება">
				</div>
			</div>
		</form>

		</div>
	</div>
</div>

</div>

<div data-widget-group="group1">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="font-3">ფასების დიაპაზონები</h4>
		</div>
		<div class="panel-editbox"></div>
		<div class="panel-body">
			<form action="{{ route('priceRangesUpdate') }}" method="POST" class="form-horizontal row-border data-form">
				<div class="form-group">
         <div class="col-sm-4">
					 <div class="row">
					  <label class="col-sm-6 control-label font-4">
							<span>პროცესორი</span>
							<i class="fas fa-long-arrow-alt-right" style="color: #fdbe19"></i>
							<b>Min</b>
						</label>
					  <div class="col-sm-3">
						 <input name="processorMinPrice" type="text" value="{{ $priceRanges -> processorMinPrice }}" class="form-control">
					  </div>
					 </div>
					 <br>
					 <div class="row">
						<label class="col-sm-6 control-label font-4">
							<span>პროცესორი</span>
							<i class="fas fa-long-arrow-alt-right" style="color: #fdbe19"></i>
							<b>Max</b>
						</label>
						<div class="col-sm-3">
						 <input name="processorMaxPrice" type="text" value="{{ $priceRanges -> processorMaxPrice }}" class="form-control">
						</div>
					 </div>
				 </div>
				 <div class="col-sm-4">
					 <div class="row">
					  <label class="col-sm-6 control-label font-4">
							<span>ოპერატიული</span>
							<i class="fas fa-long-arrow-alt-right" style="color: #fdbe19"></i>
							<b>Min</b>
						</label>
					  <div class="col-sm-3">
						 <input name="memoryModuleMinPrice" type="text" value="{{ $priceRanges -> memoryModuleMinPrice }}" class="form-control">
					  </div>
					 </div>
					 <br>
					 <div class="row">
						<label class="col-sm-6 control-label font-4">
							<span>ოპერატიული</span>
							<i class="fas fa-long-arrow-alt-right" style="color: #fdbe19"></i>
							<b>Max</b>
						</label>
						<div class="col-sm-3">
						 <input name="memoryModuleMaxPrice" type="text" value="{{ $priceRanges -> memoryModuleMaxPrice }}" class="form-control">
						</div>
					 </div>
				 </div>
				 <div class="col-sm-4">
					 <div class="row">
						<label class="col-sm-6 control-label font-4">
							<span>დედაპლატა</span>
							<i class="fas fa-long-arrow-alt-right" style="color: #fdbe19"></i>
							<b>Min</b>
						</label>
						<div class="col-sm-3">
						 <input name="motherboardMinPrice" type="text" value="{{ $priceRanges -> motherboardMinPrice }}" class="form-control">
						</div>
					 </div>
					 <br>
					 <div class="row">
						<label class="col-sm-6 control-label font-4">
							<span>დედაპლატა</span>
							<i class="fas fa-long-arrow-alt-right" style="color: #fdbe19"></i>
							<b>Max</b>
						</label>
						<div class="col-sm-3">
						 <input name="motherboardMaxPrice" type="text" value="{{ $priceRanges -> motherboardMaxPrice }}" class="form-control">
						</div>
					 </div>
				 </div>
				</div>

				<div class="form-group">
         <div class="col-sm-4">
					 <div class="row">
					  <label class="col-sm-6 control-label font-4">
							<span>ვიდეობარათი</span>
							<i class="fas fa-long-arrow-alt-right" style="color: #fdbe19"></i>
							<b>Min</b>
						</label>
					  <div class="col-sm-3">
						 <input name="videoCardMinPrice" type="text" value="{{ $priceRanges -> videoCardMinPrice }}" class="form-control">
					  </div>
					 </div>
					 <br>
					 <div class="row">
						<label class="col-sm-6 control-label font-4">
							<span>ვიდეობარათი</span>
							<i class="fas fa-long-arrow-alt-right" style="color: #fdbe19"></i>
							<b>Max</b>
						</label>
						<div class="col-sm-3">
						 <input name="videoCardMaxPrice" type="text" value="{{ $priceRanges -> videoCardMaxPrice }}" class="form-control">
						</div>
					 </div>
				 </div>
				 <div class="col-sm-4">
					 <div class="row">
					  <label class="col-sm-6 control-label font-4">
							<span>HDD</span>
							<i class="fas fa-long-arrow-alt-right" style="color: #fdbe19"></i>
							<b>Min</b>
						</label>
					  <div class="col-sm-3">
						 <input name="hardDiskDriveMinPrice" type="text" value="{{ $priceRanges -> hardDiskDriveMinPrice }}" class="form-control">
					  </div>
					 </div>
					 <br>
					 <div class="row">
						<label class="col-sm-6 control-label font-4">
							<span>HDD</span>
							<i class="fas fa-long-arrow-alt-right" style="color: #fdbe19"></i>
							<b>Max</b>
						</label>
						<div class="col-sm-3">
						 <input name="hardDiskDriveMaxPrice" type="text" value="{{ $priceRanges -> hardDiskDriveMaxPrice }}" class="form-control">
						</div>
					 </div>
				 </div>
				 <div class="col-sm-4">
					 <div class="row">
						<label class="col-sm-6 control-label font-4">
							<span>SSD</span>
							<i class="fas fa-long-arrow-alt-right" style="color: #fdbe19"></i>
							<b>Min</b>
						</label>
						<div class="col-sm-3">
						 <input name="solidStateDriveMinPrice" type="text" value="{{ $priceRanges -> solidStateDriveMinPrice }}" class="form-control">
						</div>
					 </div>
					 <br>
					 <div class="row">
						<label class="col-sm-6 control-label font-4">
							<span>SSD</span>
							<i class="fas fa-long-arrow-alt-right" style="color: #fdbe19"></i>
							<b>Max</b>
						</label>
						<div class="col-sm-3">
						 <input name="solidStateDriveMaxPrice" type="text" value="{{ $priceRanges -> solidStateDriveMaxPrice }}" class="form-control">
						</div>
					 </div>
				 </div>
				</div>

				<div class="form-group">
				 <div class="col-sm-4">
					 <div class="row">
						<label class="col-sm-6 control-label font-4">
							<span>კვების ბლოკი</span>
							<i class="fas fa-long-arrow-alt-right" style="color: #fdbe19"></i>
							<b>Min</b>
						</label>
						<div class="col-sm-3">
						 <input name="powerSupplyMinPrice" type="text" value="{{ $priceRanges -> powerSupplyMinPrice }}" class="form-control">
						</div>
					 </div>
					 <br>
					 <div class="row">
						<label class="col-sm-6 control-label font-4">
							<span>კვების ბლოკი</span>
							<i class="fas fa-long-arrow-alt-right" style="color: #fdbe19"></i>
							<b>Max</b>
						</label>
						<div class="col-sm-3">
						 <input name="powerSupplyMaxPrice" type="text" value="{{ $priceRanges -> powerSupplyMaxPrice }}" class="form-control">
						</div>
					 </div>
				 </div>
				 <div class="col-sm-4">
					 <div class="row">
						<label class="col-sm-6 control-label font-4">
							<span>CPU ქულერი</span>
							<i class="fas fa-long-arrow-alt-right" style="color: #fdbe19"></i>
							<b>Min</b>
						</label>
						<div class="col-sm-3">
						 <input name="processorCoolerMinPrice" type="text" value="{{ $priceRanges -> processorCoolerMinPrice }}" class="form-control">
						</div>
					 </div>
					 <br>
					 <div class="row">
						<label class="col-sm-6 control-label font-4">
							<span>CPU ქულერი</span>
							<i class="fas fa-long-arrow-alt-right" style="color: #fdbe19"></i>
							<b>Max</b>
						</label>
						<div class="col-sm-3">
						 <input name="processorCoolerMaxPrice" type="text" value="{{ $priceRanges -> processorCoolerMaxPrice }}" class="form-control">
						</div>
					 </div>
				 </div>
				 <div class="col-sm-4">
					 <div class="row">
						<label class="col-sm-6 control-label font-4">
							<span>კეისის ქულერი</span>
							<i class="fas fa-long-arrow-alt-right" style="color: #fdbe19"></i>
							<b>Min</b>
						</label>
						<div class="col-sm-3">
						 <input name="caseCoolerMinPrice" type="text" value="{{ $priceRanges -> caseCoolerMinPrice }}" class="form-control">
						</div>
					 </div>
					 <br>
					 <div class="row">
						<label class="col-sm-6 control-label font-4">
							<span>კეისის ქულერი</span>
							<i class="fas fa-long-arrow-alt-right" style="color: #fdbe19"></i>
							<b>Max</b>
						</label>
						<div class="col-sm-3">
						 <input name="caseCoolerMaxPrice" type="text" value="{{ $priceRanges -> caseCoolerMaxPrice }}" class="form-control">
						</div>
					 </div>
				 </div>
				</div>

				<div class="form-group">
				 <div class="col-sm-4">
					 <div class="row">
						<label class="col-sm-6 control-label font-4">
							<span>დისკმძრავი</span>
							<i class="fas fa-long-arrow-alt-right" style="color: #fdbe19"></i>
							<b>Min</b>
						</label>
						<div class="col-sm-3">
						 <input name="opticalDiscDriveMinPrice" type="text" value="{{ $priceRanges -> opticalDiscDriveMinPrice }}" class="form-control">
						</div>
					 </div>
					 <br>
					 <div class="row">
						<label class="col-sm-6 control-label font-4">
							<span>დისკმძრავი</span>
							<i class="fas fa-long-arrow-alt-right" style="color: #fdbe19"></i>
							<b>Max</b>
						</label>
						<div class="col-sm-3">
						 <input name="opticalDiscDriveMaxPrice" type="text" value="{{ $priceRanges -> opticalDiscDriveMaxPrice }}" class="form-control">
						</div>
					 </div>
				 </div>
				 <div class="col-sm-4">
					 <div class="row">
						<label class="col-sm-6 control-label font-4">
							<span>კეისი</span>
							<i class="fas fa-long-arrow-alt-right" style="color: #fdbe19"></i>
							<b>Min</b>
						</label>
						<div class="col-sm-3">
						 <input name="computerCaseMinPrice" type="text" value="{{ $priceRanges -> computerCaseMinPrice }}" class="form-control">
						</div>
					 </div>
					 <br>
					 <div class="row">
						<label class="col-sm-6 control-label font-4">
							<span>კეისი</span>
							<i class="fas fa-long-arrow-alt-right" style="color: #fdbe19"></i>
							<b>Max</b>
						</label>
						<div class="col-sm-3">
						 <input name="computerCaseMaxPrice" type="text" value="{{ $priceRanges -> computerCaseMaxPrice }}" class="form-control">
						</div>
					 </div>
				 </div>
				 <div class="col-sm-4">
					 <div class="row">
						<label class="col-sm-6 control-label font-4">
							<span>UPS</span>
							<i class="fas fa-long-arrow-alt-right" style="color: #fdbe19"></i>
							<b>Min</b>
						</label>
						<div class="col-sm-3">
						 <input name="uninterruptiblePowerSupplyMinPrice" type="text" value="{{ $priceRanges -> uninterruptiblePowerSupplyMinPrice }}" class="form-control">
						</div>
					 </div>
					 <br>
					 <div class="row">
						<label class="col-sm-6 control-label font-4">
							<span>UPS</span>
							<i class="fas fa-long-arrow-alt-right" style="color: #fdbe19"></i>
							<b>Max</b>
						</label>
						<div class="col-sm-3">
						 <input name="uninterruptiblePowerSupplyMaxPrice" type="text" value="{{ $priceRanges -> uninterruptiblePowerSupplyMaxPrice }}" class="form-control">
						</div>
					 </div>
				 </div>
				</div>

				<div class="form-group">
				 <div class="col-sm-4">
					 <div class="row">
						<label class="col-sm-6 control-label font-4">
							<span>მონიტორი</span>
							<i class="fas fa-long-arrow-alt-right" style="color: #fdbe19"></i>
							<b>Min</b>
						</label>
						<div class="col-sm-3">
						 <input name="monitorMinPrice" type="text" value="{{ $priceRanges -> monitorMinPrice }}" class="form-control">
						</div>
					 </div>
					 <br>
					 <div class="row">
						<label class="col-sm-6 control-label font-4">
							<span>მონიტორი</span>
							<i class="fas fa-long-arrow-alt-right" style="color: #fdbe19"></i>
							<b>Max</b>
						</label>
						<div class="col-sm-3">
						 <input name="monitorMaxPrice" type="text" value="{{ $priceRanges -> monitorMaxPrice }}" class="form-control">
						</div>
					 </div>
				 </div>
				 <div class="col-sm-4">
					 <div class="row">
						<label class="col-sm-6 control-label font-4">
							<span>პერიფერიალი</span>
							<i class="fas fa-long-arrow-alt-right" style="color: #fdbe19"></i>
							<b>Min</b>
						</label>
						<div class="col-sm-3">
						 <input name="peripheralMinPrice" type="text" value="{{ $priceRanges -> peripheralMinPrice }}" class="form-control">
						</div>
					 </div>
					 <br>
					 <div class="row">
						<label class="col-sm-6 control-label font-4">
							<span>პერიფერიალი</span>
							<i class="fas fa-long-arrow-alt-right" style="color: #fdbe19"></i>
							<b>Max</b>
						</label>
						<div class="col-sm-3">
						 <input name="peripheralMaxPrice" type="text" value="{{ $priceRanges -> peripheralMaxPrice }}" class="form-control">
						</div>
					 </div>
				 </div>
				 <div class="col-sm-4">
					 <div class="row">
						<label class="col-sm-6 control-label font-4">
							<span>დამტენი</span>
							<i class="fas fa-long-arrow-alt-right" style="color: #fdbe19"></i>
							<b>Min</b>
						</label>
						<div class="col-sm-3">
						 <input name="notebookChargerMinPrice" type="text" value="{{ $priceRanges -> notebookChargerMinPrice }}" class="form-control">
						</div>
					 </div>
					 <br>
					 <div class="row">
						<label class="col-sm-6 control-label font-4">
							<span>დამტენი</span>
							<i class="fas fa-long-arrow-alt-right" style="color: #fdbe19"></i>
							<b>Max</b>
						</label>
						<div class="col-sm-3">
						 <input name="notebookChargerMaxPrice" type="text" value="{{ $priceRanges -> notebookChargerMaxPrice }}" class="form-control">
						</div>
					 </div>
				 </div>
				</div>

				<div class="form-group">
				 <div class="col-sm-4">
					 <div class="row">
						<label class="col-sm-6 control-label font-4">
							<span>სისტემა</span>
							<i class="fas fa-long-arrow-alt-right" style="color: #fdbe19"></i>
							<b>Min</b>
						</label>
						<div class="col-sm-3">
						 <input name="computerMinPrice" type="text" value="{{ $priceRanges -> computerMinPrice }}" class="form-control">
						</div>
					 </div>
					 <br>
					 <div class="row">
						<label class="col-sm-6 control-label font-4">
							<span>სისტემა</span>
							<i class="fas fa-long-arrow-alt-right" style="color: #fdbe19"></i>
							<b>Max</b>
						</label>
						<div class="col-sm-3">
						 <input name="computerMaxPrice" type="text" value="{{ $priceRanges -> computerMaxPrice }}" class="form-control">
						</div>
					 </div>
				 </div>
				 <div class="col-sm-4">
					 <div class="row">
						<label class="col-sm-6 control-label font-4">
							<span>აქსესუარი</span>
							<i class="fas fa-long-arrow-alt-right" style="color: #fdbe19"></i>
							<b>Min</b>
						</label>
						<div class="col-sm-3">
						 <input name="accessoryMinPrice" type="text" value="{{ $priceRanges -> accessoryMinPrice }}" class="form-control">
						</div>
					 </div>
					 <br>
					 <div class="row">
						<label class="col-sm-6 control-label font-4">
							<span>აქსესუარი</span>
							<i class="fas fa-long-arrow-alt-right" style="color: #fdbe19"></i>
							<b>Max</b>
						</label>
						<div class="col-sm-3">
						 <input name="accessoryMaxPrice" type="text" value="{{ $priceRanges -> accessoryMaxPrice }}" class="form-control">
						</div>
					 </div>
				 </div>
				 <div class="col-sm-4">
					 <div class="row">
						<label class="col-sm-6 control-label font-4">
							<span>ქსელ. აპარატურა</span>
							<i class="fas fa-long-arrow-alt-right" style="color: #fdbe19"></i>
							<b>Min</b>
						</label>
						<div class="col-sm-3">
						 <input name="networkDeviceMinPrice" type="text" value="{{ $priceRanges -> networkDeviceMinPrice }}" class="form-control">
						</div>
					 </div>
					 <br>
					 <div class="row">
						<label class="col-sm-6 control-label font-4">
							<span>ქსელ. აპარატურა</span>
							<i class="fas fa-long-arrow-alt-right" style="color: #fdbe19"></i>
							<b>Max</b>
						</label>
						<div class="col-sm-3">
						 <input name="networkDeviceMaxPrice" type="text" value="{{ $priceRanges -> networkDeviceMaxPrice }}" class="form-control">
						</div>
					 </div>
				 </div>
				</div>

				<div class="panel-footer">
					<div class="row">
						<div class="col-sm-8 col-sm-offset-1">
							<input type="submit" class="btn-primary btn font-mtavruli" value="შენახვა">
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

@include('parts.user.parameters')

@include('parts.user.switches')
