<div class="col form-inline" 
    title="Select time period"> 
        @if(isset($title))
            {{$title}}
        @endif
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
        </div>
        <select wire:model="setPeriod" class="form-control">
            @if (isset($all)) <option
                value="allDates">All</option>
            @endif
            @foreach (config('app.timeframes') as $key=>$per)
                <option
                value="{{$key}}">{{$per}}</option>
            @endforeach
        </select>   
</div>