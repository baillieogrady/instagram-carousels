@extends('layouts.app')

@section('content')
  <div class="container lg:max-w-6xl mx-auto px-2 font-black">
    <div class="bg-gray-200">
      <div class="relative mb-lux-2-sm md:mb-lux-2-md lg:mb-lux-2-lg xl:mb-lux-2-xl">
        <div class="container">
            <div class="home__border py-5 lg:py-6 flex w-full lg:w-1/2">
              <div class="flex items-center justify-between flex-grow">
                <input type="text" name="keyword" id="home__keyword" onkeyup="fetch()" class="blog__input bg-transparent outline-none hover:text-hos-black w-full cursor-pointer" placeholder="Search here..."></input>
              </div>
            </div>
          </div>
        <div class="home__data">
          <div class="container">
            <div id="home__dataFetch" class="flex flex-wrap -mx-6"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
