
<div class="row">

	<div class="col-xs-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="font-mtavruli">მეხსიერების ტიპები</h4>
			</div>
			<div class="panel-body">
				<table class="table table-hover mb1" data-update-route="{{ route('mmtypeUpdate') }}">
					<thead>
						<tr class="font-3">
							<th>დასახელება</th>
							<th>წაშლა</th>
						</tr>
					</thead>
					<tbody>

					@foreach($ramTypes as $value)

						<tr data-record-id="{{ $value -> id }}">

							<!--- Title field --->
							<td>
								<input data-parameter-name="ram-type-title" type="text" value="{{ $value -> typeTitle }}" class="no-border transparent-bg-color font-4 field">
							</td>

							<!--- Delete button --->
							<td>
								<a class="delete-record" href="{{ route('mmtypeDestroy', ['id' => $value -> id]) }}">
									<i style="font-size: 16px" class="fa fa-trash" aria-hidden="true"></i>
								</a>
							</td>

						</tr>

					@endforeach

				 </tbody>
				</table>

      <div data-page-key="{{ $ramTypesPageKey }}" data-current-page="{{ $ramTypesPaginator -> currentPage }}" class="clearfix pagination-column col-sm-12">

        <ul class="pagination mt0 mb20 col-sm-8">

            @if($ramTypesPaginator -> currentPage > 1)

             <li>
              <a href="{{ $ramTypesPaginator -> currentPage - 1 }}" class="page-switch">
                <i class="fa fa-angle-double-left" aria-hidden="true"></i>
              </a>
             </li>

            @endif

            @foreach($ramTypesPaginator -> pages as $page)

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

            @if($ramTypesPaginator -> currentPage < $ramTypesPaginator -> maxPage)

            <li>
              <a href="{{ $ramTypesPaginator -> currentPage + 1 }}" class="page-switch">
                <i class="fa fa-angle-double-right" aria-hidden="true"></i>
              </a>
            </li>

            @endif

         </ul>

       </div>

			 <form action="{{ route('mmtypeStore') }}" method="post" class="form-horizontal row-border data-form" enctype="multipart/form-data">
				<div class="form-group">
					<div class="col-sm-3">
						<input type="submit" class="btn-primary btn font-4" value="დამატება">
					</div>
					<div class="col-sm-6">
						<input name="ram-type-title" type="text" class="form-control font-4" placeholder="დასახელება">
					</div>
				</div>
			</form>

			</div>
		</div>
	</div>

</div>

@include('parts.user.parameters')

@include('parts.user.switches')
