<div>
     <script src="//maps.googleapis.com/maps/api/js?key={{config('app.google_api')}}"></script>
    <h2>Maps {{$limit}}</h2>
    <x-form-input type="text" wire:model="findaddress" name="findaddress" placeholder="Add an address" />
    <x-form-select wire:model='limit' name="limit" :options="$limits" />
    @push('scripts')
         <x-map-script :markers="$markers" />
    @endpush
    <div class="columns-3 flex ml-5 font-sans text-xs leading-3 text-left box-border text-zinc-800">

        <div
          id="loc-list"
          class="float-left overflow-auto w-1 font-sans text-xs text-left box-border text-zinc-800"
          style="height: 530px;"
        >
            <ul
            id="list"
            class="block float-left clear-left p-0 m-0 text-xs box-border"
            style="list-style: none;"
            >
                @foreach($addresses as $mark)
                    <li
                      data-markerid="{{$loop->index}}"
                      style="background: rgb(255, 255, 255); list-style: outside none none;"
                      class="block float-left clear-left my-1 mx-2 w-48 leading-4 bg-white border border-white border-solid cursor-pointer box-border"
                      >
                      <div
                        class="float-left py-px px-1 mt-2 mr-0 mb-0 ml-1 w-4 text-center text-white box-border bg-stone-900"
                        style="font-weight: bold; list-style: outside none none;"
                        >
                        {{$loop->index}}
                      </div>
                      <div
                        class="float-left ml-1 w-40 text-left box-border"
                        style="list-style: outside none none;"
                        >
                        <div
                          class="p-2 cursor-pointer box-border"
                          style="list-style: outside none none;"
                          >
                          <div
                            class="text-red-700 box-border"
                            style="font-weight: bold; list-style: outside none none;"
                          >
                            {{$mark->businessname}}
                          </div>
                          <div class="box-border" style="list-style: outside none none;"></div>

                          <div class="box-border" style="list-style: outside none none;">
                           {{$mark->fullAddress}}
                          </div>
                          <div class="box-border" style="list-style: outside none none;">
                            lead
                          </div>
                          <div class="box-border" style="list-style: outside none none;">
                            <a
                            href="{{route('address.show', $mark->id)}}"
                            class="text-red-500 bg-transparent box-border hover:text-sky-700"
                            style="text-decoration: none; list-style: outside none none;"
                            >Location Details</a
                            >
                          </div>
                          <div
                            class="italic box-border text-neutral-400"
                            style="font-weight: bold; list-style: outside none none;"
                            >
                            {{number_format($mark->distance,1)}} miles
                          </div>
                          <div class="box-border" style="list-style: outside none none;">
                            <a
                            href="https://maps.google.com/maps?saddr=804 F St, Petaluma, CA 94952, USA&amp;daddr=  ,  "
                            target="_blank"
                            class="text-red-500 bg-transparent box-border hover:text-sky-700"
                            style="text-decoration: none; list-style: outside none none;"
                            >Directions</a
                            >
                          </div>
                        </div>
                      </div>
                    </li>
                @endforeach   
            </ul>
        </div>
       
                <div wire:ignore x-ref='map' id='map' style='width: 60%; height: 600px;border:red solid 1px'></div>
            
       
    </div>    
</div>