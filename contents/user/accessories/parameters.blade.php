
<div class="row">
	<div class="col-xs-9">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="font-mtavruli">აქსესუარების ტიპები</h4>
			</div>
			<div class="panel-body">
				<table class="table table-hover mb1" data-update-route="{{ route('accTypeUpdate') }}">
					<thead>
						<tr class="font-3">
							<th>დასახელება</th>
							<th>გასაღები</th>
							<th>სიმბოლოს კოდი</th>
							<th>წაშლა</th>
						</tr>
					</thead>
					<tbody>

          @foreach($accessoriesTypes as $value)

						<tr data-record-id="{{ $value -> id }}">

              <!--- Title field --->
							<td>
								<input data-parameter-name="accessory-type-title" type="text" value="{{ $value -> typeTitle }}" class="no-border transparent-bg-color font-4 field">
							</td>

							<!--- Type key field --->
							<td>
								<input data-parameter-name="type-key" type="text" value="{{ $value -> typeKey }}" class="no-border transparent-bg-color font-4 field">
							</td>

							<!--- Icon field ---->
							<td>
								<input data-parameter-name="accessory-type-icon" type="text" value="{{ $value -> icon }}" class="no-border transparent-bg-color font-4 field">
							</td>

              <!--- Delete button --->
							<td>
								<a class="delete-record" href="{{ route('accTypeDestroy', ['id' => $value -> id]) }}">
									<i style="font-size: 16px" class="fa fa-trash" aria-hidden="true"></i>
								</a>
							</td>
						</tr>

          @endforeach

				 </tbody>
				</table>

        <div data-page-key="{{ $accTypesPageKey }}" data-current-page="{{ $accTypesPaginator -> currentPage }}" class="clearfix pagination-column col-sm-12">

          <ul class="pagination mt0 mb20 col-sm-8">

              @if($accTypesPaginator -> currentPage > 1)

               <li>
                <a href="{{ $accTypesPaginator -> currentPage - 1 }}" class="page-switch">
                  <i class="fa fa-angle-double-left" aria-hidden="true"></i>
                </a>
               </li>

              @endif

              @foreach($accTypesPaginator -> pages as $page)

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

              @if($accTypesPaginator -> currentPage < $accTypesPaginator -> maxPage)

              <li>
                <a href="{{ $accTypesPaginator -> currentPage + 1 }}" class="page-switch">
                  <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                </a>
              </li>

              @endif

           </ul>

         </div>

       <form action="{{ route('accTypeStore') }}" method="post" class="form-horizontal row-border data-form" enctype="multipart/form-data">
 				<div class="form-group">
          <div class="col-sm-2">
            <input type="submit" class="btn-primary btn font-4" value="დამატება">
          </div>
 					<div class="col-sm-3">
 						<input name="accessory-type-title" type="text" class="form-control font-4" placeholder="დასახელება">
 					</div>
					<div class="col-sm-3">
						<input name="type-key" type="text" class="form-control font-4" placeholder="გასაღები">
					</div>
					<div class="col-sm-4">
						<input name="accessory-type-icon" type="text" class="form-control font-4" placeholder="კოდი (არასავალდებულო)">
					</div>
        </div>
      </form>

			</div>
		</div>
  </div>

</div>

@include('parts.user.parameters')
