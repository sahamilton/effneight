<x-layout>
<div class="container mx-auto sm:px-4">
    <div class="md:w-4/5 pr-4 pl-4 col-md-offset-1">
    	<h2>All Navigation</h2>
    	<div class="pull-right"><a href="{{route('navigation.create')}}" class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline btn-small bg-teal-500 text-white hover:bg-teal-600">Add Navigation</a></div>

        <table class="w-full max-w-full mb-4 bg-transparent">
            <thead>
               
                <th>Group</th>
                <th>Navigation</th>
                <th>Icon</th>
                <th>Actions</th>
     
            </thead>
			<tbody>
				@foreach ($navigations as $navigation)
				
				<tr>
					<td>
						 {!!str_repeat ( '&nbsp;' , $navigation->depth * 3 )!!} 
						 {{$navigation->group}}</td>
					<td>{!!str_repeat ( '&nbsp;' , $navigation->depth * 3 )!!} 
						{{$navigation->display_name}}</td>
					
					<td><i class="{{$navigation->icon}}"></i></td>
					<td>
						<div class="relative inline-flex align-middle">
						  <button type="button" class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline bg-green-500 text-white hover:bg-green-600  inline-block w-0 h-0 ml-1 align border-b-0 border-t-1 border-r-1 border-l-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						    Action
						  </button>
						  <div class=" absolute left-0 z-50 float-left hidden list-reset	 py-2 mt-1 text-base bg-white border border-gray-300 rounded">
							    <a class="block w-full py-1 px-6 font-normal text-gray-900 whitespace-no-wrap border-0"  href="{{route('navigation.edit',$navigation->id)}}">
							    	<i class="far fa-edit icon-info"></i> Edit this navigation item
							    </a>
								<a class="block w-full py-1 px-6 font-normal text-gray-900 whitespace-no-wrap border-0" data-action="{{route('navigation.destroy',$navigation->id)}}" 
							            data-toggle="modal" 
							            data-target="#confirm-delete" 
							            data-title = "this navigation item" 
							            data-_method="delete"
							            href="#"
							            title="Delete Navigation Item">
							        <i class="fa fa-trash icon-danger" ></i>
							        Delete this navigation item
							    </a>

							</div>
						</div>
				    </td>
					
				</tr>
				@endforeach
			</tbody>
			
		</table>
	</div>
</div>
</x-layout>
