<div class="flex relative flex-grow items-center px-4 w-full max-w-full text-left basis-0"
    title="Select time period"
    style="flex-flow: row wrap;"
  >
    <div class="flex -mr-px text-neutral-800">
      <span
        class="flex items-center py-1 px-3 mb-0 text-base font-normal leading-normal text-center whitespace-nowrap bg-gray-200 rounded border border-gray-300 border-solid text-zinc-600"
        >
        <i
          class="block not-italic leading-none far fa-calendar-alt"
          aria-hidden="true"
          
        ></i>
        </span>
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