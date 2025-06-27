    <div class="container max-w-[1130px] mx-auto relative pt-10 z-10">
      <nav class="flex flex-wrap items-center justify-between bg-white p-[20px_30px] rounded-[20px] gap-y-3">
          <div class="flex items-center gap-3">
              <div class="flex shrink-0 h-[43px] overflow-hidden">
                  <img src="{{ asset('assets/logo/logo.png') }}" class="object-contain w-full h-full" alt="logo">
              </div>
              <div class="flex flex-col">
                <p id="CompanyName" class="font-extrabold text-xl leading-[30px]">SayurKita</p>
                <p id="CompanyTagline" class="text-sm text-cp-light-grey">Vegetable Revolution</p>
              </div>
          </div>
          <ul class="flex flex-wrap items-center gap-[30px]">
            <li class="{{request()->routeIs('front.index') ? 'text-cp-dark-blue' : ''}} font-semibold hover:text-cp-dark-blue transition-all duration-300">
              <a href="{{route('front.index')}}">Home</a>
            </li>
            <li class="{{request()->routeIs('products') ? 'text-cp-dark-blue' : ''}}font-semibold hover:text-cp-dark-blue transition-all duration-300">
              <a href="{{route('list_product')}}">Products</a>
            </li>
            <li class="{{request()->routeIs('gallery') ? 'text-cp-dark-blue' : ''}}font-semibold hover:text-cp-dark-blue transition-all duration-300">
              <a href="{{route('gallery')}}">Gallery</a>
            </li>
            <li class="{{request()->routeIs('blog') ? 'text-cp-dark-blue' : ''}} font-semibold hover:text-cp-dark-blue transition-all duration-300">
              <a href="{{route('list_blog')}}">Blog</a>
            </li>
            <li class="{{request()->routeIs('aboutus') ? 'text-cp-dark-blue' : ''}} font-semibold hover:text-cp-dark-blue transition-all duration-300">
              <a href="{{route('aboutus')}}">About</a>
            </li>
          </ul>
          <a href="{{route('login')}}" class="bg-cp-dark-blue p-[14px_20px] w-fit rounded-xl hover:shadow-[0_12px_30px_0_#312ECB66] transition-all duration-300 font-bold text-white">Login</a>
      </nav>
    </div>