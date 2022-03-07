<div>
  <div>
  <h2>
    @if ($branch_id)
      {{$branches[$branch_id]}}
    @endif
    {{$status !=0 ? $statuses[$status] : ''}} {{$type != '0' ? $types[$type] : ''}}
</h2>
<div class="flex flex-col mb-4">
  <x-form-select wire:model='branch_id'
    class="border py-2 px-3 text-grey-darkest"
    name='branch_id'
    label='Select branch:'
    :options="$branches" />

  <x-form-select wire:model='type'
    class="border py-2 px-3 text-grey-darkest"
    name='type'
    label='Select type:'
    :options="$types" />

  <x-form-select wire:model='status'
    class="border py-2 px-3 text-grey-darkest"
    name='status'
    label='Status:'
    :options="$statuses" />

 <x-periodselector />
  <div id='calendar-container' wire:ignore>
    <div id='calendar'></div>
  </div>
  @push('scripts')

    <x-calendar-script />
  @endpush
</div>
</div>
