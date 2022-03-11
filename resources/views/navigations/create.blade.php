@extends('layouts.app')
@section('content')
<div class="container mx-auto sm:px-4">
	<h4> Add Navigation Item</h4>
<form name="createNav" method="post" action="{{route('navigation.store')}}">
@csrf
@include('navigations.partials._form')
<input type="submit" name="submit" class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline bg-teal-500 text-white hover:bg-teal-600" value="Create Nav Item" >

</form>


</div>

@endsection