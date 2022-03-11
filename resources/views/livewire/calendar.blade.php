<div>
  <div>
    <h2>
      @if ($branch_id)
        {{$branches[$branch_id]}}
      @endif
      {{$status !=0 ? $statuses[$status] : ''}} {{$type != '0' ? $types[$type] : ''}}
    </h2>
    <div
      class="flex relative flex-grow items-center px-4 w-full max-w-full leading-6 text-left basis-0 text-neutral-800"
      style="flex-flow: row wrap;"
    >
      <x-form-select wire:model='branch_id'
        class="flex relative flex-grow items-center px-4 w-full max-w-full"
        name='branch_id'
        label='Select branch:'
        :options="$branches" />

      <x-form-select wire:model='type'
        class="flex relative flex-grow items-center px-4 w-full max-w-full"
        name='type'
        label='Select type:'
        :options="$types" />

      <x-form-select wire:model='status'
        class="flex relative flex-grow items-center px-4 w-full max-w-full"
        name='status'
        label='Status:'
        :options="$statuses" />

      <x-periodselector />
  
      <div
        id="calendar"
        wire:ignore
        class="flex-auto p-5 text-base leading-6 text-left text-neutral-800"
        style="direction: ltr;"
      ></div>
    </div>
  </div>
  @push('scripts')

    <x-calendar-script />
  @endpush
</div>