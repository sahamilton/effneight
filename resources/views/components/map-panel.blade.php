<li
  data-markerid="{{$loop->index}}"
  style="background: rgb(255, 255, 255); list-style: outside none none;"
  class="block float-left clear-left my-1 mx-2 w-48 leading-4 bg-white border border-white border-solid cursor-pointer box-border"
  >
  <div
    class="float-left py-px px-1 mt-2 mr-0 mb-0 ml-1 w-4 text-center text-white box-border bg-stone-900"
    style="font-weight: bold; list-style: outside none none;"
    >
    
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
        Businessname
      </div>
      <div class="box-border" style="list-style: outside none none;"></div>

      <div class="box-border" style="list-style: outside none none;">
       Address
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
        Distance miles
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