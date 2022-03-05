<div>
  <h2>
    @if ($branch_id)
      {{$branches[$branch_id]}}
    @endif
</h2>
  <x-form-select wire:model='branch_id'
    name='branch_id'
    label='Select branch:'
    :options="$branches" />

    <x-form-select wire:model='type'
    name='type'
    label='Select type:'
    :options="$types" />
  <div id='calendar-container' wire:ignore>
    <div id='calendar'></div>
  </div>
</div>
@push('scripts')

   <x-calendar-script />
@endpush