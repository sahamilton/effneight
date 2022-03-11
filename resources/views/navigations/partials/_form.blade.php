<div class="mb-4{{ $errors->has('parent_id)') ? ' has-error' : '' }}">
<label class="md:w-1/3 pr-4 pl-4 control-label">Parent</label>
<div class="md:w-1/2 pr-4 pl-4">

    <select required class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded" name='parent_id'>

    @foreach ($navigations as $nav)
    	
        @if(isset($navitem) && $navitem->id == $nav->id)
        <option selected value="{{$nav->id}}">{{$nav->name}}</option>
        @else
        <option selected value="{{$nav->id}}">{{$nav->name}}</option>
        @endif
    @endforeach


    </select>
    <span class="help-block">
        <strong>{{ $errors->has('parent_id') ? $errors->first('parent_id') : ''}}</strong>
        </span>
</div>
</div>

<!-- group -->
<div class="mb-4{{ $errors->has('group') ? ' has-error' : '' }}">
    <label class="md:w-1/3 pr-4 pl-4 control-label">Nav Group</label>
        <div class="md:w-1/2 pr-4 pl-4">
            <input type="text" 
            required 
            
            class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded" 
            name='group' 
            description="group" 
            value="{{ old('group', isset($navigation) ? $navigation->group : '')}}" 
            placeholder="group">
            <span class="help-block">
                <strong>{{ $errors->has('group') ? $errors->first('group') : ''}}</strong>
                </span>
        </div>
</div>

<!-- display_name -->
<div class="mb-4{{ $errors->has('display_name') ? ' has-error' : '' }}">
    <label class="md:w-1/3 pr-4 pl-4 control-label">Display Name</label>
        <div class="md:w-1/2 pr-4 pl-4">
            <input type="text"
            required
            class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded" 
            name='display_name' 
            description="display_name" 
            value="{{ old('display_name', isset($navigation) ?$navigation->display_name : '')}}" .
            placeholder="display name">
            <span class="help-block">
                <strong>{{ $errors->has('display_name') ? $errors->first('display_name') : ''}}</strong>
                </span>
        </div>
</div>

<!-- route -->
<div class="mb-4{{ $errors->has('route') ? ' has-error' : '' }}">
    <label class="md:w-1/3 pr-4 pl-4 control-label">Route</label>
        <div class="md:w-1/2 pr-4 pl-4">
            <input 
            type="text" 
            required 
            class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded" 
            name='route' 
            description="route" 
            value="{{ old('route', isset($navigation) ? $navigation->route : '') }}" 
            placeholder="route">
            <span class="help-block">
                <strong>{{ $errors->has('route') ? $errors->first('route') : ''}}</strong>
                </span>
        </div>
</div>
   <!-- icon -->
<div class="mb-4{{ $errors->has('icon') ? ' has-error' : '' }}">
    <label class="md:w-1/3 pr-4 pl-4 control-label">Icon</label>
        <div class="md:w-1/2 pr-4 pl-4">
            <input 
            type="text" 
            required 
            class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded" 
            name='icon' 
            description="icon" 
            value="{{ old('icon', isset($navigation) ? $navigation->icon : '') }}" 
            placeholder="icon">
            <span class="help-block">
                <strong>{{ $errors->has('icon') ? $errors->first('icon') : ''}}</strong>
                </span>
        </div>
</div>
<div class="mb-4{{ $errors->has('sequence') ? ' has-error' : '' }}">
    <label class="md:w-1/3 pr-4 pl-4 control-label">Sequence</label>
        <div class="md:w-1/2 pr-4 pl-4">
            <input 
            type="text" 
            required 
            class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded" 
            name='sequence' 
            description="sequence" 
            value="{{ old('sequence',  isset($navigation) ? $navigation->sequence : '') }}" 
            placeholder="sequence">
            <span class="help-block">
                <strong>{{ $errors->has('sequence') ? $errors->first('sequence') : ''}}</strong>
                </span>
        </div>
</div>                  
    

