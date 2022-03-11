<div>
    
<div class="flex flex-col mb-4">
  <x-form-select wire:model='branch_id'
    class="w-40 form-select px-4 py-3 rounded-full"
    name='branch_id'
    label='Select branch:'
    :options="$branches" />

    <livewire:map-view  :branch_id='$branch_id' />
</div>
