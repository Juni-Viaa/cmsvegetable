<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('styles/output.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <!-- CSS for carousel/flickity-->
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
    <link rel="stylesheet" href="https://unpkg.com/flickity-fade@2/flickity-fade.css">

    <!-- CSS for modal/flowbite -->
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css"  rel="stylesheet" /> -->
</head>

<body class="font-poppins text-cp-black">
    <div id="header" class="bg-[#F6F7FA] relative overflow-hidden">
        <div class="container max-w-[1130px] mx-auto relative pt-10 z-10">
            <nav class="flex flex-wrap items-center justify-between bg-white p-[20px_30px] rounded-[20px] gap-y-3">
                <div class="flex items-center gap-3">
                    <div class="flex shrink-0 h-[43px] overflow-hidden">
                        <img src="images\logo\logo.png" class="object-contain w-full h-full" alt="logo">
                    </div>
                    <div class="flex flex-col">
                        <p id="CompanyName" class="font-extrabold text-xl leading-[30px]">SayurKita</p>
                        <p id="CompanyTagline" class="text-sm text-cp-light-grey">Vegetable Revolution</p>
                    </div>
                </div>
                <ul class="flex flex-wrap items-center gap-[30px]">
                    <li class="font-semibold hover:text-cp-dark-blue transition-all duration-300 text-cp-dark-blue">
                        <a href="{{ route('landingpage') }}">Home</a>
                    </li>
                    <li class="font-semibold hover:text-cp-dark-blue transition-all duration-300">
                        <a href="/list_product">Products</a>
                    </li>
                    <li class="font-semibold hover:text-cp-dark-blue transition-all duration-300">
                        <a href="{{ route('gallery') }}">Gallery</a>
                    </li>
                    <li class="font-semibold hover:text-cp-dark-blue transition-all duration-300">
                        <a href="{{ route('blog') }}">Blog</a>
                    </li>
                    <li class="font-semibold hover:text-cp-dark-blue transition-all duration-300">
                        <a href="{{ route('aboutus') }}">About</a>
                    </li>
                </ul>
                <a href="{{ route('login') }}"
                    class="bg-cp-dark-blue p-[14px_20px] w-fit rounded-xl hover:shadow-[0_12px_30px_0_#312ECB66] transition-all duration-300 font-bold text-white">Login</a>
            </nav>
            <div id="Hero" class="flex flex-col gap-[30px] mt-20 pb-20">
                <div class="flex items-center bg-white p-[8px_16px] gap-[10px] rounded-full w-fit">
                    <div class="w-5 h-5 flex shrink-0 overflow-hidden">
                        <img src="images/icons/crown.svg" class="object-contain" alt="icon">
                    </div>
                    <p class="font-semibold text-sm">Top Quality Vegetables</p>
                </div>
                <div class="flex flex-col gap-[10px]">
                    <h1 class="font-extrabold text-[50px] leading-[65px] max-w-[536px]">Bringing the Best Vegetables<br>
                        From the Land to Your Table</h1>
                    <p class="text-cp-light-grey leading-[30px] max-w-[437px]">SayurKita delivers high quality local
                        vegetables harvested with care and dedication. By prioritizing sustainability and innovation, we
                        are committed to delivering fresh and nutritious products</p>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('list_product') }}"
                        class="bg-cp-dark-blue p-5 w-fit rounded-xl hover:shadow-[0_12px_30px_0_#312ECB66] transition-all duration-300 font-bold text-white">Explore
                        Now</a>
                    {{-- <button class="bg-cp-black p-5 w-fit rounded-xl font-bold text-white flex items-center gap-[10px]" onclick="{modal.show()}">
              <div class="w-6 h-6 flex shrink-0 overflow-hidden">
                <img src="images/icons/play-circle.svg" class="w-full h-full object-contain" alt="icon">
              </div>
              <span>Watch Video</span>
            </button> --}}
                </div>
            </div>
        </div>
        <div class="absolute w-[43%] h-full top-0 right-0 overflow-hidden z-0">
            <img src="" class="object-cover w-full h-full" alt="banner">
        </div>
    </div>
    {{-- <div id="Clients" class="container max-w-[1130px] mx-auto flex flex-col justify-center text-center gap-5 mt-20">
    {{-- <h2 class="font-bold text-lg">Trusted by Thousand People</h2>
    <div class="logo-container flex flex-wrap gap-5 justify-center">
      <div class="logo-card h-[68px] w-fit flex items-center shrink-0 border border-[#E8EAF2] rounded-[18px] p-4 gap-[10px] bg-white hover:border-cp-dark-blue transition-all duration-300">
        <div class="overflow-hidden h-9">
          <img src="images/logo/logo-54.svg" class="object-contain w-full h-full" alt="logo">
        </div>
      </div>
      <div class="logo-card h-[68px] w-fit flex items-center shrink-0 border border-[#E8EAF2] rounded-[18px] p-4 gap-[10px] bg-white hover:border-cp-dark-blue transition-all duration-300">
        <div class="overflow-hidden h-9">
          <img src="images/logo/logo-52.svg" class="object-contain w-full h-full" alt="logo">
        </div>
      </div>
      <div class="logo-card h-[68px] w-fit flex items-center shrink-0 border border-[#E8EAF2] rounded-[18px] p-4 gap-[10px] bg-white hover:border-cp-dark-blue transition-all duration-300">
        <div class="overflow-hidden h-9">
          <img src="images/logo/logo-55.svg" class="object-contain w-full h-full" alt="logo">
        </div>
      </div>
      <div class="logo-card h-[68px] w-fit flex items-center shrink-0 border border-[#E8EAF2] rounded-[18px] p-4 gap-[10px] bg-white hover:border-cp-dark-blue transition-all duration-300">
        <div class="overflow-hidden h-9">
          <img src="images/logo/logo-44.svg" class="object-contain w-full h-full" alt="logo">
        </div>
      </div>
      <div class="logo-card h-[68px] w-fit flex items-center shrink-0 border border-[#E8EAF2] rounded-[18px] p-4 gap-[10px] bg-white hover:border-cp-dark-blue transition-all duration-300">
        <div class="overflow-hidden h-9">
          <img src="images/logo/logo-51.svg" class="object-contain w-full h-full" alt="logo">
        </div>
      </div>
      <div class="logo-card h-[68px] w-fit flex items-center shrink-0 border border-[#E8EAF2] rounded-[18px] p-4 gap-[10px] bg-white hover:border-cp-dark-blue transition-all duration-300">
        <div class="overflow-hidden h-9">
          <img src="images/logo/logo-55.svg" class="object-contain w-full h-full" alt="logo">
        </div>
      </div>
      <div class="logo-card h-[68px] w-fit flex items-center shrink-0 border border-[#E8EAF2] rounded-[18px] p-4 gap-[10px] bg-white hover:border-cp-dark-blue transition-all duration-300">
        <div class="overflow-hidden h-9">
          <img src="images/logo/logo-52.svg" class="object-contain w-full h-full" alt="logo">
        </div>
      </div>
      <div class="logo-card h-[68px] w-fit flex items-center shrink-0 border border-[#E8EAF2] rounded-[18px] p-4 gap-[10px] bg-white hover:border-cp-dark-blue transition-all duration-300">
        <div class="overflow-hidden h-9">
          <img src="images/logo/logo-54.svg" class="object-contain w-full h-full" alt="logo">
        </div>
      </div>
      <div class="logo-card h-[68px] w-fit flex items-center shrink-0 border border-[#E8EAF2] rounded-[18px] p-4 gap-[10px] bg-white hover:border-cp-dark-blue transition-all duration-300">
        <div class="overflow-hidden h-9">
          <img src="images/logo/logo-51.svg" class="object-contain w-full h-full" alt="logo">
        </div>
      </div>
    </div>
  </div> --}}
    <div id="OurPrinciples" class="container max-w-[1130px] mx-auto flex flex-col gap-[30px] mt-20">
        <div class="flex items-center justify-between">
            <div class="flex flex-col gap-[14px]">
                <p
                    class="badge w-fit bg-cp-pale-blue text-cp-light-blue p-[8px_16px] rounded-full uppercase font-bold text-sm">
                    OUR PRODUCT</p>
                <h2 class="font-bold text-4xl leading-[45px]">Fresh Vegetables<br> the Best Choice for Your Health</h2>
            </div>
            <a href="{{ route('list_product') }}"
                class="bg-cp-black p-[14px_20px] w-fit rounded-xl font-bold text-white">Explore More</a>
        </div>
        <div class="flex flex-wrap items-center gap-[30px] justify-center">
            <div
                class="card w-[356.67px] flex flex-col bg-white border border-[#E8EAF2] rounded-[20px] gap-[30px] overflow-hidden hover:border-cp-dark-blue transition-all duration-300">
                <div class="thumbnail h-[200px] flex shrink-0 overflow-hidden">
                    <img src="" class="object-cover object-center w-full h-full" alt="thumbnails">
                </div>
                <div class="flex flex-col p-[0_30px_30px_30px] gap-5">
                    <div class="w-[55px] h-[55px] flex shrink-0 overflow-hidden">
                        <img src="" class="w-full h-full object-contain" alt="icon">
                    </div>
                    <div class="flex flex-col gap-1">
                        <p class="title font-bold text-xl leading-[30px]">Tomato</p>
                        <p class="leading-[30px] text-cp-light-grey">Fresh Tomatoes, a Natural Source of Vitamin C for
                            Every Day! Enjoy the Natural Delights of Nutritious Local Vegetables</p>
                    </div>
                    <a href="{{ route('list_product') }}" class="font-semibold text-cp-dark-blue">Learn More</a>
                </div>
            </div>
            <div
                class="card w-[356.67px] flex flex-col bg-white border border-[#E8EAF2] rounded-[20px] gap-[30px] overflow-hidden hover:border-cp-dark-blue transition-all duration-300">
                <div class="thumbnail h-[200px] flex shrink-0 overflow-hidden">
                    <img src="" class="object-cover object-center w-full h-full" alt="thumbnails">
                </div>
                <div class="flex flex-col p-[0_30px_30px_30px] gap-5">
                    <div class="w-[55px] h-[55px] flex shrink-0 overflow-hidden">
                        <img src="" class="w-full h-full object-contain" alt="icon">
                    </div>
                    <div class="flex flex-col gap-1">
                        <p class="title font-bold text-xl leading-[30px]">Spinach</p>
                        <p class="leading-[30px] text-cp-light-grey">Quality Spinach, the Right Choice to Keep Your
                            Energy and Health. Fresh, Nutritious, and Ready to Invigorate Your Life</p>
                    </div>
                    <a href="{{ route('list_product') }}" class="font-semibold text-cp-dark-blue">Learn More</a>
                </div>
            </div>
            <div
                class="card w-[356.67px] flex flex-col bg-white border border-[#E8EAF2] rounded-[20px] gap-[30px] overflow-hidden hover:border-cp-dark-blue transition-all duration-300">
                <div class="thumbnail h-[200px] flex shrink-0 overflow-hidden">
                    <img src="" class="object-cover object-center w-full h-full" alt="thumbnails">
                </div>
                <div class="flex flex-col p-[0_30px_30px_30px] gap-5">
                    <div class="w-[55px] h-[55px] flex shrink-0 overflow-hidden">
                        <img src="" class="w-full h-full object-contain" alt="icon">
                    </div>
                    <div class="flex flex-col gap-1">
                        <p class="title font-bold text-xl leading-[30px]">Kale</p>
                        <p class="leading-[30px] text-cp-light-grey">Nutrient-rich Local Kale for a Healthy Lifestyle.
                            Ready to be the perfect addition to your every dish!</p>
                    </div>
                    <a href="" class="font-semibold text-cp-dark-blue">Learn More</a>
                </div>
            </div>
        </div>
    </div>
    <div id="Stats" class="bg-cp-black w-full mt-20">
        <div class="container max-w-[1000px] mx-auto py-10">
            <div class="flex flex-wrap items-center justify-between p-[10px]">
                <div class="card w-[200px] flex flex-col items-center gap-[10px] text-center">
                    <div class="w-[55px] h-[55px] flex shrink-0 overflow-hidden">
                        <img src="" class="object-contain w-full h-full" alt="icon">
                    </div>
                    <p class="text-cp-pale-orange font-bold text-4xl leading-[54px]">189.409</p>
                    <p class="text-cp-light-grey">Vegetables</p>
                </div>
                <div class="card w-[200px] flex flex-col items-center gap-[10px] text-center">
                    <div class="w-[55px] h-[55px] flex shrink-0 overflow-hidden">
                        <img src="" class="object-contain w-full h-full" alt="icon">
                    </div>
                    <p class="text-cp-pale-orange font-bold text-4xl leading-[54px]">198</p>
                    <p class="text-cp-light-grey">Blogs</p>
                </div>
                <div class="card w-[200px] flex flex-col items-center gap-[10px] text-center">
                    <div class="w-[55px] h-[55px] flex shrink-0 overflow-hidden">
                        <img src="" class="object-contain w-full h-full" alt="icon">
                    </div>
                    <p class="text-cp-pale-orange font-bold text-4xl leading-[54px]">512</p>
                    <p class="text-cp-light-grey">Comments</p>
                </div>
                <div class="card w-[200px] flex flex-col items-center gap-[10px] text-center">
                    <div class="w-[55px] h-[55px] flex shrink-0 overflow-hidden">
                        <img src="" class="object-contain w-full h-full" alt="icon">
                    </div>
                    <p class="text-cp-pale-orange font-bold text-4xl leading-[54px]">4.9/5</p>
                    <p class="text-cp-light-grey">Honest Reviews</p>
                </div>
            </div>
        </div>
    </div>
    <div id="Products" class="container max-w-[1130px] mx-auto flex flex-col gap-20 mt-20">
        <div class="product flex flex-wrap justify-center items-center gap-[60px] even:flex-row-reverse">
            <div class="w-[470px] h-[550px] flex shrink-0 overflow-hidden">
                <img src="" class="w-full h-full object-contain" alt="thumbnail">
            </div>
            <div class="flex flex-col gap-[30px] py-[50px] h-fit max-w-[500px]">
                <p
                    class="badge w-fit bg-cp-pale-blue text-cp-light-blue p-[8px_16px] rounded-full uppercase font-bold text-sm">
                    BEST PRODUCT</p>
                <div class="flex flex-col gap-[10px]">
                    <h2 class="font-bold text-4xl leading-[45px]">Spinach</h2>
                    <p class="leading-[30px] text-cp-light-grey">Lorem ipsum amet dolor metrics and perfomance burning
                        rate random says.</p>
                </div>
                <a href=""
                    class="bg-cp-dark-blue p-[14px_20px] w-fit rounded-xl hover:shadow-[0_12px_30px_0_#312ECB66] transition-all duration-300 font-bold text-white">Explore
                    Now</a>
            </div>
        </div>
        <div class="product flex flex-wrap justify-center items-center gap-[60px] even:flex-row-reverse">
            <div class="w-[470px] h-[550px] flex shrink-0 overflow-hidden">
                <img src="" class="w-full h-full object-contain" alt="thumbnail">
            </div>
            <div class="flex flex-col gap-[30px] py-[50px] h-fit max-w-[500px]">
                <p
                    class="badge w-fit bg-cp-pale-blue text-cp-light-blue p-[8px_16px] rounded-full uppercase font-bold text-sm">
                    BEST COMMUNITY</p>
                <div class="flex flex-col gap-[10px]">
                    <h2 class="font-bold text-4xl leading-[45px]">Tomatoes as Natural Source of Vitamin C</h2>
                    <p class="leading-[30px] text-cp-light-grey">Lorem ipsum amet dolor metrics and perfomance burning
                        rate random says.</p>
                </div>
                <a href=""
                    class="bg-cp-dark-blue p-[14px_20px] w-fit rounded-xl hover:shadow-[0_12px_30px_0_#312ECB66] transition-all duration-300 font-bold text-white">Explore
                    Now</a>
            </div>
        </div>
        <div class="product flex flex-wrap justify-center items-center gap-[60px] even:flex-row-reverse">
            <div class="w-[470px] h-[550px] flex shrink-0 overflow-hidden">
                <img src="" class="w-full h-full object-contain" alt="thumbnail">
            </div>
            <div class="flex flex-col gap-[30px] py-[50px] h-fit max-w-[500px]">
                <p
                    class="badge w-fit bg-cp-pale-blue text-cp-light-blue p-[8px_16px] rounded-full uppercase font-bold text-sm">
                    OUR GALLERY</p>
                <div class="flex flex-col gap-[10px]">
                    <h2 class="font-bold text-4xl leading-[45px]">Vegetable Field</h2>
                    <p class="leading-[30px] text-cp-light-grey">Lorem ipsum amet dolor metrics and perfomance burning
                        rate random says.</p>
                </div>
                <a href=""
                    class="bg-cp-dark-blue p-[14px_20px] w-fit rounded-xl hover:shadow-[0_12px_30px_0_#312ECB66] transition-all duration-300 font-bold text-white">Explore
                    Now</a>
            </div>
        </div>
    </div>
    {{-- <div id="Teams" class="bg-[#F6F7FA] w-full py-20 px-[10px] mt-20">
    <div class="container max-w-[1130px] mx-auto flex flex-col gap-[30px] items-center">
      <div class="flex flex-col gap-[14px] items-center">
        <p class="badge w-fit bg-cp-light-blue text-white p-[8px_16px] rounded-full uppercase font-bold text-sm">OUR POWERFUL TEAM</p>
        <h2 class="font-bold text-4xl leading-[45px] text-center">We Share Same Dreams <br> Change The World</h2>
      </div>
      <div class="teams-card-container grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-[30px] justify-center">
        <div class="card bg-white flex flex-col h-full justify-center items-center p-[30px] px-[29px] gap-[30px] rounded-[20px] border border-white hover:shadow-[0_10px_30px_0_#D1D4DF80] hover:border-cp-dark-blue transition-all duration-300">
          <div class="w-[100px] h-[100px] flex shrink-0 items-center justify-center rounded-full bg-[linear-gradient(150.55deg,_#007AFF_8.72%,_#312ECB_87.11%)]">
            <div class="w-[90px] h-[90px] rounded-full overflow-hidden">
              <img src="images/photos/photo1.png" class="object-cover w-full h-full object-center" alt="photo">
            </div>
          </div>
          <div class="flex flex-col gap-1 text-center">
            <p class="font-bold text-xl leading-[30px]">Angga Setiawan</p>
            <p class="text-cp-light-grey">Chief Executive Officer</p>
          </div>
          <div class="flex items-center justify-center gap-[10px]">
            <div class="w-6 h-6 flex shrink-0">
              <img src="images/icons/global.svg" alt="icon">
            </div>
            <p class="text-cp-dark-blue font-semibold">Shanghai, China</p>
          </div>
        </div>
        <div class="card bg-white flex flex-col h-full justify-center items-center p-[30px] px-[29px] gap-[30px] rounded-[20px] border border-white hover:shadow-[0_10px_30px_0_#D1D4DF80] hover:border-cp-dark-blue transition-all duration-300">
          <div class="w-[100px] h-[100px] flex shrink-0 items-center justify-center rounded-full bg-[linear-gradient(150.55deg,_#007AFF_8.72%,_#312ECB_87.11%)]">
            <div class="w-[90px] h-[90px] rounded-full overflow-hidden">
              <img src="images/photos/photo2.png" class="object-cover w-full h-full object-center" alt="photo">
            </div>
          </div>
          <div class="flex flex-col gap-1 text-center">
            <p class="font-bold text-xl leading-[30px]">SayurKita Liza</p>
            <p class="text-cp-light-grey">Product Manager</p>
          </div>
          <div class="flex items-center justify-center gap-[10px]">
            <div class="w-6 h-6 flex shrink-0">
              <img src="images/icons/global.svg" alt="icon">
            </div>
            <p class="text-cp-dark-blue font-semibold">Bali, Indonesia</p>
          </div>
        </div>
        <div class="card bg-white flex flex-col h-full justify-center items-center p-[30px] px-[29px] gap-[30px] rounded-[20px] border border-white hover:shadow-[0_10px_30px_0_#D1D4DF80] hover:border-cp-dark-blue transition-all duration-300">
          <div class="w-[100px] h-[100px] flex shrink-0 items-center justify-center rounded-full bg-[linear-gradient(150.55deg,_#007AFF_8.72%,_#312ECB_87.11%)]">
            <div class="w-[90px] h-[90px] rounded-full overflow-hidden">
              <img src="images/photos/photo3.png" class="object-cover w-full h-full object-center" alt="photo">
            </div>
          </div>
          <div class="flex flex-col gap-1 text-center">
            <p class="font-bold text-xl leading-[30px]">Bruno Oleo</p>
            <p class="text-cp-light-grey">Customer Relations</p>
          </div>
          <div class="flex items-center justify-center gap-[10px]">
            <div class="w-6 h-6 flex shrink-0">
              <img src="images/icons/global.svg" alt="icon">
            </div>
            <p class="text-cp-dark-blue font-semibold">Orchard, Singapore</p>
          </div>
        </div>
        <div class="card bg-white flex flex-col h-full justify-center items-center p-[30px] px-[29px] gap-[30px] rounded-[20px] border border-white hover:shadow-[0_10px_30px_0_#D1D4DF80] hover:border-cp-dark-blue transition-all duration-300">
          <div class="w-[100px] h-[100px] flex shrink-0 items-center justify-center rounded-full bg-[linear-gradient(150.55deg,_#007AFF_8.72%,_#312ECB_87.11%)]">
            <div class="w-[90px] h-[90px] rounded-full overflow-hidden">
              <img src="images/photos/photo4.png" class="object-cover w-full h-full object-center" alt="photo">
            </div>
          </div>
          <div class="flex flex-col gap-1 text-center">
            <p class="font-bold text-xl leading-[30px]">Sami Kimi</p>
            <p class="text-cp-light-grey">Senior 3D Designer</p>
          </div>
          <div class="flex items-center justify-center gap-[10px]">
            <div class="w-6 h-6 flex shrink-0">
              <img src="images/icons/global.svg" alt="icon">
            </div>
            <p class="text-cp-dark-blue font-semibold">Ho Chi Min, Vietnam</p>
          </div>
        </div>
        <div class="card bg-white flex flex-col h-full justify-center items-center p-[30px] px-[29px] gap-[30px] rounded-[20px] border border-white hover:shadow-[0_10px_30px_0_#D1D4DF80] hover:border-cp-dark-blue transition-all duration-300">
          <div class="w-[100px] h-[100px] flex shrink-0 items-center justify-center rounded-full bg-[linear-gradient(150.55deg,_#007AFF_8.72%,_#312ECB_87.11%)]">
            <div class="w-[90px] h-[90px] rounded-full overflow-hidden">
              <img src="images/photos/photo5.png" class="object-cover w-full h-full object-center" alt="photo">
            </div>
          </div>
          <div class="flex flex-col gap-1 text-center">
            <p class="font-bold text-xl leading-[30px]">Wibowo Putra</p>
            <p class="text-cp-light-grey">Senior 3D Designer</p>
          </div>
          <div class="flex items-center justify-center gap-[10px]">
            <div class="w-6 h-6 flex shrink-0">
              <img src="images/icons/global.svg" alt="icon">
            </div>
            <p class="text-cp-dark-blue font-semibold">Ho Chi Min, Vietnam</p>
          </div>
        </div>
        <div class="card bg-white flex flex-col h-full justify-center items-center p-[30px] px-[29px] gap-[30px] rounded-[20px] border border-white hover:shadow-[0_10px_30px_0_#D1D4DF80] hover:border-cp-dark-blue transition-all duration-300">
          <div class="w-[100px] h-[100px] flex shrink-0 items-center justify-center rounded-full bg-[linear-gradient(150.55deg,_#007AFF_8.72%,_#312ECB_87.11%)]">
            <div class="w-[90px] h-[90px] rounded-full overflow-hidden">
              <img src="images/photos/photo6.png" class="object-cover w-full h-full object-center" alt="photo">
            </div>
          </div>
          <div class="flex flex-col gap-1 text-center">
            <p class="font-bold text-xl leading-[30px]">Putri Emily</p>
            <p class="text-cp-light-grey">Chief Executive Officer</p>
          </div>
          <div class="flex items-center justify-center gap-[10px]">
            <div class="w-6 h-6 flex shrink-0">
              <img src="images/icons/global.svg" alt="icon">
            </div>
            <p class="text-cp-dark-blue font-semibold">Shanghai, China</p>
          </div>
        </div>
        <div class="card bg-white flex flex-col h-full justify-center items-center p-[30px] px-[29px] gap-[30px] rounded-[20px] border border-white hover:shadow-[0_10px_30px_0_#D1D4DF80] hover:border-cp-dark-blue transition-all duration-300">
          <div class="w-[100px] h-[100px] flex shrink-0 items-center justify-center rounded-full bg-[linear-gradient(150.55deg,_#007AFF_8.72%,_#312ECB_87.11%)]">
            <div class="w-[90px] h-[90px] rounded-full overflow-hidden">
              <img src="images/photos/photo7.png" class="object-cover w-full h-full object-center" alt="photo">
            </div>
          </div>
          <div class="flex flex-col gap-1 text-center">
            <p class="font-bold text-xl leading-[30px]">Yuyan Chin</p>
            <p class="text-cp-light-grey">Product Manager</p>
          </div>
          <div class="flex items-center justify-center gap-[10px]">
            <div class="w-6 h-6 flex shrink-0">
              <img src="images/icons/global.svg" alt="icon">
            </div>
            <p class="text-cp-dark-blue font-semibold">Bali, Indonesia</p>
          </div>
        </div>
        <a href="team.html" class="view-all-card">
          <div class="card bg-white flex flex-col h-full justify-center items-center p-[30px] gap-[30px] rounded-[20px] border border-white hover:shadow-[0_10px_30px_0_#D1D4DF80] hover:border-cp-dark-blue transition-all duration-300">
            <div class="w-[60px] h-[60px] flex shrink-0">
              <img src="images/icons/profile-2user.svg" alt="icon">
            </div>
            <div class="flex flex-col gap-1 text-center">
              <p class="font-bold text-xl leading-[30px]">View All</p>
              <p class="text-cp-light-grey">Our Great People</p>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div> --}}
    <div id="Testimonials" class="w-full flex flex-col gap-[50px] items-center mt-20">
        <div class="flex flex-col gap-[14px] items-center">
            <p
                class="badge w-fit bg-cp-pale-blue text-cp-light-blue p-[8px_16px] rounded-full uppercase font-bold text-sm">
                Blogs</p>
            <h2 class="font-bold text-4xl leading-[45px] text-center">Discover Inspiring Tales of Freshness<br>Dive
                into Our Blog</h2>
        </div>
        <div class="main-carousel w-full">
            <div
                class="carousel-card container max-w-[1130px] w-full flex flex-wrap justify-between items-center lg:mx-[calc((100vw-1130px)/2)]">
                <div class="testimonial-container flex flex-col gap-[112px] w-[565px]">
                    <div class="flex flex-col gap-[30px]">
                        <div class="h-9 overflow-hidden">
                            <img src="images/logo/logo-51.svg" class="object-contain" alt="icon">
                        </div>
                        <div class="relative pt-[27px] pl-[30px]">
                            <div class="absolute top-0 left-0">
                                <img src="images/icons/quote.svg" alt="icon">
                            </div>
                            <p class="font-semibold text-2xl leading-[46px] relative z-10">SayurKita delivers fresh,
                                high-quality vegetables directly to your table, ensuring health and sustainability.</p>
                        </div>
                        <div class="flex items-center justify-between pl-[30px]">
                            <div class="flex items-center gap-6">
                                <div class="w-[60px] h-[60px] flex shrink-0 rounded-full overflow-hidden">
                                    <img src="images/logo/logo.png" class="w-full h-full object-cover"
                                        alt="photo">
                                </div>
                                <div class="flex flex-col justify-center gap-1">
                                    <p class="font-bold">SayurKita</p>
                                    <p class="text-sm text-cp-light-grey">Vegetable Revolution</p>
                                </div>
                            </div>
                            <div class="flex flex-nowrap">
                                <div class="w-6 h-6 flex shrink-0">
                                    <img src="images/icons/Star-rating.svg" alt="star">
                                </div>
                                <div class="w-6 h-6 flex shrink-0">
                                    <img src="images/icons/Star-rating.svg" alt="star">
                                </div>
                                <div class="w-6 h-6 flex shrink-0">
                                    <img src="images/icons/Star-rating.svg" alt="star">
                                </div>
                                <div class="w-6 h-6 flex shrink-0">
                                    <img src="images/icons/Star-rating.svg" alt="star">
                                </div>
                                <div class="w-6 h-6 flex shrink-0">
                                    <img src="images/icons/Star-rating.svg" alt="star">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-indicator flex items-center justify-center gap-2 h-4 shrink-0">
                    </div>
                </div>
                <div class="testimonial-thumbnail w-[470px] h-[550px] rounded-[20px] overflow-hidden bg-[#D9D9D9]">
                    <img src="" class="w-full h-full object-cover object-center" alt="thumbnail">
                </div>
            </div>
            <div
                class="carousel-card container max-w-[1130px] w-full flex flex-wrap justify-between items-center lg:mx-[calc((100vw-1130px)/2)]">
                <div class="testimonial-container flex flex-col gap-[112px] w-[565px]">
                    <div class="flex flex-col gap-[30px]">
                        <div class="h-9 overflow-hidden">
                            <img src="images/logo/logo-51.svg" class="object-contain" alt="icon">
                        </div>
                        <div class="relative pt-[27px] pl-[30px]">
                            <div class="absolute top-0 left-0">
                                <img src="images/icons/quote.svg" alt="icon">
                            </div>
                            <p class="font-semibold text-2xl leading-[46px] relative z-10">Lorem ipsum dolor sit amet
                                consectetur adipisicing elit. Nihil distinctio quasi blanditiis dolorum iste velit. Quo
                                alias non ab debitis!</p>
                        </div>
                        <div class="flex items-center justify-between pl-[30px]">
                            <div class="flex items-center gap-6">
                                <div class="w-[60px] h-[60px] flex shrink-0 rounded-full overflow-hidden">
                                    <img src="images/logo/logo.png" class="w-full h-full object-cover"
                                        alt="photo">
                                </div>
                                <div class="flex flex-col justify-center gap-1">
                                    <p class="font-bold">SayurKita</p>
                                    <p class="text-sm text-cp-light-grey">Vegetable Revolution</p>
                                </div>
                            </div>
                            <div class="flex flex-nowrap">
                                <div class="w-6 h-6 flex shrink-0">
                                    <img src="images/icons/Star-rating.svg" alt="star">
                                </div>
                                <div class="w-6 h-6 flex shrink-0">
                                    <img src="images/icons/Star-rating.svg" alt="star">
                                </div>
                                <div class="w-6 h-6 flex shrink-0">
                                    <img src="images/icons/Star-rating.svg" alt="star">
                                </div>
                                <div class="w-6 h-6 flex shrink-0">
                                    <img src="images/icons/Star-rating.svg" alt="star">
                                </div>
                                <div class="w-6 h-6 flex shrink-0">
                                    <img src="images/icons/Star-rating.svg" alt="star">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-indicator flex items-center justify-center gap-2 h-4 shrink-0">
                    </div>
                </div>
                <div class="testimonial-thumbnail w-[470px] h-[550px] rounded-[20px] overflow-hidden bg-[#D9D9D9]">
                    <img src="" class="w-full h-full object-cover object-center" alt="thumbnail">
                </div>
            </div>
            <div
                class="carousel-card container max-w-[1130px] w-full flex flex-wrap justify-between items-center lg:mx-[calc((100vw-1130px)/2)]">
                <div class="testimonial-container flex flex-col gap-[112px] w-[565px]">
                    <div class="flex flex-col gap-[30px]">
                        <div class="h-9 overflow-hidden">
                            <img src="images/logo/logo-54.svg" class="object-contain" alt="icon">
                        </div>
                        <div class="relative pt-[27px] pl-[30px]">
                            <div class="absolute top-0 left-0">
                                <img src="images/icons/quote.svg" alt="icon">
                            </div>
                            <p class="font-semibold text-2xl leading-[46px] relative z-10">Lorem ipsum dolor sit, amet
                                consectetur adipisicing elit. Distinctio officia, reprehenderit magni obcaecati
                                praesentium quasi iusto rerum.</p>
                        </div>
                        <div class="flex items-center justify-between pl-[30px]">
                            <div class="flex items-center gap-6">
                                <div class="w-[60px] h-[60px] flex shrink-0 rounded-full overflow-hidden">
                                    <img src="images/logo/logo.png" class="w-full h-full object-cover"
                                        alt="photo">
                                </div>
                                <div class="flex flex-col justify-center gap-1">
                                    <p class="font-bold">SayurKita</p>
                                    <p class="text-sm text-cp-light-grey">Vegetable Revolution</p>
                                </div>
                            </div>
                            <div class="flex flex-nowrap">
                                <div class="w-6 h-6 flex shrink-0">
                                    <img src="images/icons/Star-rating.svg" alt="star">
                                </div>
                                <div class="w-6 h-6 flex shrink-0">
                                    <img src="images/icons/Star-rating.svg" alt="star">
                                </div>
                                <div class="w-6 h-6 flex shrink-0">
                                    <img src="images/icons/Star-rating.svg" alt="star">
                                </div>
                                <div class="w-6 h-6 flex shrink-0">
                                    <img src="images/icons/Star-rating.svg" alt="star">
                                </div>
                                <div class="w-6 h-6 flex shrink-0">
                                    <img src="images/icons/Star-rating.svg" alt="star">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-indicator flex items-center justify-center gap-2 h-4 shrink-0">
                    </div>
                </div>
                <div class="testimonial-thumbnail w-[470px] h-[550px] rounded-[20px] overflow-hidden bg-[#D9D9D9]">
                    <img src="" class="w-full h-full object-cover object-center" alt="thumbnail">
                </div>
            </div>
            <div
                class="carousel-card container max-w-[1130px] w-full flex flex-wrap justify-between items-center lg:mx-[calc((100vw-1130px)/2)]">
                <div class="testimonial-container flex flex-col gap-[112px] w-[565px]">
                    <div class="flex flex-col gap-[30px]">
                        <div class="h-9 overflow-hidden">
                            <img src="images/logo/logo-44.svg" class="object-contain" alt="icon">
                        </div>
                        <div class="relative pt-[27px] pl-[30px]">
                            <div class="absolute top-0 left-0">
                                <img src="images/icons/quote.svg" alt="icon">
                            </div>
                            <p class="font-semibold text-2xl leading-[46px] relative z-10">Lorem ipsum dolor sit amet,
                                consectetur adipisicing elit. Recusandae, rem!</p>
                        </div>
                        <div class="flex items-center justify-between pl-[30px]">
                            <div class="flex items-center gap-6">
                                <div class="w-[60px] h-[60px] flex shrink-0 rounded-full overflow-hidden">
                                    <img src="images/logo/logo.png" class="w-full h-full object-cover"
                                        alt="photo">
                                </div>
                                <div class="flex flex-col justify-center gap-1">
                                    <p class="font-bold">SayurKita</p>
                                    <p class="text-sm text-cp-light-grey">Vegetable Revolution</p>
                                </div>
                            </div>
                            <div class="flex flex-nowrap">
                                <div class="w-6 h-6 flex shrink-0">
                                    <img src="images/icons/Star-rating.svg" alt="star">
                                </div>
                                <div class="w-6 h-6 flex shrink-0">
                                    <img src="images/icons/Star-rating.svg" alt="star">
                                </div>
                                <div class="w-6 h-6 flex shrink-0">
                                    <img src="images/icons/Star-rating.svg" alt="star">
                                </div>
                                <div class="w-6 h-6 flex shrink-0">
                                    <img src="images/icons/Star-rating.svg" alt="star">
                                </div>
                                <div class="w-6 h-6 flex shrink-0">
                                    <img src="images/icons/Star-rating.svg" alt="star">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-indicator flex items-center justify-center gap-2 h-4 shrink-0">
                    </div>
                </div>
                <div class="testimonial-thumbnail w-[470px] h-[550px] rounded-[20px] overflow-hidden bg-[#D9D9D9]">
                    <img src="" class="w-full h-full object-cover object-center" alt="thumbnail">
                </div>
            </div>
            <div
                class="carousel-card container max-w-[1130px] w-full flex flex-wrap justify-between items-center lg:mx-[calc((100vw-1130px)/2)]">
                <div class="testimonial-container flex flex-col gap-[112px] w-[565px]">
                    <div class="flex flex-col gap-[30px]">
                        <div class="h-9 overflow-hidden">
                            <img src="images/logo/logo-54.svg" class="object-contain" alt="icon">
                        </div>
                        <div class="relative pt-[27px] pl-[30px]">
                            <div class="absolute top-0 left-0">
                                <img src="images/icons/quote.svg" alt="icon">
                            </div>
                            <p class="font-semibold text-2xl leading-[46px] relative z-10">Lorem, ipsum dolor sit amet
                                consectetur adipisicing elit. Officiis quia adipisci voluptatum deleniti rerum,
                                explicabo aperiam illum porro voluptatibus qui expedita sapiente sed sequi animi!</p>
                        </div>
                        <div class="flex items-center justify-between pl-[30px]">
                            <div class="flex items-center gap-6">
                                <div class="w-[60px] h-[60px] flex shrink-0 rounded-full overflow-hidden">
                                    <img src="images/logo/logo.png" class="w-full h-full object-cover"
                                        alt="photo">
                                </div>
                                <div class="flex flex-col justify-center gap-1">
                                    <p class="font-bold">SayurKita</p>
                                    <p class="text-sm text-cp-light-grey">Vegetable Revolution</p>
                                </div>
                            </div>
                            <div class="flex flex-nowrap">
                                <div class="w-6 h-6 flex shrink-0">
                                    <img src="images/icons/Star-rating.svg" alt="star">
                                </div>
                                <div class="w-6 h-6 flex shrink-0">
                                    <img src="images/icons/Star-rating.svg" alt="star">
                                </div>
                                <div class="w-6 h-6 flex shrink-0">
                                    <img src="images/icons/Star-rating.svg" alt="star">
                                </div>
                                <div class="w-6 h-6 flex shrink-0">
                                    <img src="images/icons/Star-rating.svg" alt="star">
                                </div>
                                <div class="w-6 h-6 flex shrink-0">
                                    <img src="images/icons/Star-rating.svg" alt="star">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-indicator flex items-center justify-center gap-2 h-4 shrink-0">
                    </div>
                </div>
                <div class="testimonial-thumbnail w-[470px] h-[550px] rounded-[20px] overflow-hidden bg-[#D9D9D9]">
                    <img src="" class="w-full h-full object-cover object-center" alt="thumbnail">
                </div>
            </div>
        </div>
    </div>
    <div id="Awards" class="container max-w-[1130px] mx-auto flex flex-col gap-[30px] mt-20">
        <div class="flex items-center justify-between">
            <div class="flex flex-col gap-[14px]">
                <p
                    class="badge w-fit bg-cp-pale-blue text-cp-light-blue p-[8px_16px] rounded-full uppercase font-bold text-sm">
                    OUR GALLERY</p>
                <h2 class="font-bold text-4xl leading-[45px]">We’ve Dedicated <br>Our Best Efforts</h2>
            </div>
            <a href="{{ route('gallery') }}"
                class="bg-cp-black p-[14px_20px] w-fit rounded-xl font-bold text-white">Explore More</a>
        </div>
        <div
            class="awards-card-container grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-[30px] justify-center">
            <div
                class="card bg-white flex flex-col h-full p-[30px] gap-[30px] rounded-[20px] border border-[#E8EAF2] hover:border-cp-dark-blue transition-all duration-300">
                <div class="w-[55px] h-[55px] flex shrink-0">
                    <img src="images/icons/cup-blue.svg" alt="icon">
                </div>
                <hr class="border-[#E8EAF2]">
                <p class="font-bold text-xl leading-[30px]">Tomatoes<br> Farm</p>
                <hr class="border-[#E8EAF2]">
                <p class="text-cp-light-grey">Bali, 2020</p>
            </div>
            <div
                class="card bg-white flex flex-col h-full p-[30px] gap-[30px] rounded-[20px] border border-[#E8EAF2] hover:border-cp-dark-blue transition-all duration-300">
                <div class="w-[55px] h-[55px] flex shrink-0">
                    <img src="images/icons/cup-blue.svg" alt="icon">
                </div>
                <hr class="border-[#E8EAF2]">
                <p class="font-bold text-xl leading-[30px]">Small Things Made Much Big Impacts</p>
                <hr class="border-[#E8EAF2]">
                <p class="text-cp-light-grey">Zurich, 2022</p>
            </div>
            <div
                class="card bg-white flex flex-col h-full p-[30px] gap-[30px] rounded-[20px] border border-[#E8EAF2] hover:border-cp-dark-blue transition-all duration-300">
                <div class="w-[55px] h-[55px] flex shrink-0">
                    <img src="images/icons/cup-blue.svg" alt="icon">
                </div>
                <hr class="border-[#E8EAF2]">
                <p class="font-bold text-xl leading-[30px]">Vegetable<br> Fields</p>
                <hr class="border-[#E8EAF2]">
                <p class="text-cp-light-grey">Shanghai, 2021</p>
            </div>
            <div
                class="card bg-white flex flex-col h-full p-[30px] gap-[30px] rounded-[20px] border border-[#E8EAF2] hover:border-cp-dark-blue transition-all duration-300">
                <div class="w-[55px] h-[55px] flex shrink-0">
                    <img src="images/icons/cup-blue.svg" alt="icon">
                </div>
                <hr class="border-[#E8EAF2]">
                <p class="font-bold text-xl leading-[30px]">Teamwork and Solidarity</p>
                <hr class="border-[#E8EAF2]">
                <p class="text-cp-light-grey">Bandung, 2023</p>
            </div>
        </div>
    </div>
    <div id="FAQ" class="bg-[#F6F7FA] w-full py-20 px-[10px] mt-20 -mb-20">
        <div class="container max-w-[1000px] mx-auto">
            <div class="flex flex-col lg:flex-row gap-[50px] sm:gap-[70px] items-center">
                <div class="flex flex-col gap-[30px]">
                    <div class="flex flex-col gap-[10px]">
                        <h2 class="font-bold text-4xl leading-[45px]">Frequently Asked Questions</h2>
                    </div>
                    <a href="contact.html" class="p-5 bg-cp-black rounded-xl text-white w-fit font-bold">Contact
                        Us</a>
                </div>
                <div class="flex flex-col gap-[30px] sm:w-[603px] shrink-0">
                    <div class="flex flex-col p-5 rounded-2xl bg-white w-full">
                        <button class="accordion-button flex justify-between gap-1 items-center"
                            data-accordion="accordion-faq-1">
                            <span class="font-bold text-lg leading-[27px] text-left">What is SayurKita?</span>
                            <div class="arrow w-9 h-9 flex shrink-0">
                                <img src="images/icons/arrow-circle-down.svg" class="transition-all duration-300"
                                    alt="icon">
                            </div>
                        </button>
                        <div id="accordion-faq-1" class="accordion-content hide">
                            <p class="leading-[30px] text-cp-light-grey pt-[14px]">SayurKita is dedicated to promoting
                                the freshest and healthiest vegetables, ensuring every meal is packed with nutrition and
                                flavor. Join us in embracing a sustainable and wholesome lifestyle with our top-quality
                                produce.</p>
                        </div>
                    </div>
                    <div class="flex flex-col p-5 rounded-2xl bg-white w-full">
                        <button class="accordion-button flex justify-between gap-1 items-center"
                            data-accordion="accordion-faq-2">
                            <span class="font-bold text-lg leading-[27px] text-left">What kind of type Vegetables are
                                popular?</span>
                            <div class="arrow w-9 h-9 flex shrink-0">
                                <img src="images/icons/arrow-circle-down.svg" class="transition-all duration-300"
                                    alt="icon">
                            </div>
                        </button>
                        <div id="accordion-faq-2" class="accordion-content hide">
                            <p class="leading-[30px] text-cp-light-grey pt-[14px]">Some of the most popular types of
                                vegetables include leafy greens like spinach and kale, root vegetables such as carrots
                                and potatoes, and fruit vegetables like tomatoes and bell peppers. These vegetables are
                                loved for their versatility, nutrition, and flavor.</p>
                        </div>
                    </div>
                    <div class="flex flex-col p-5 rounded-2xl bg-white w-full">
                        <button class="accordion-button flex justify-between gap-1 items-center"
                            data-accordion="accordion-faq-3">
                            <span class="font-bold text-lg leading-[27px] text-left">When is the best time to plant
                                vegetables?</span>
                            <div class="arrow w-9 h-9 flex shrink-0">
                                <img src="images/icons/arrow-circle-down.svg" class="transition-all duration-300"
                                    alt="icon">
                            </div>
                        </button>
                        <div id="accordion-faq-3" class="accordion-content hide">
                            <p class="leading-[30px] text-cp-light-grey pt-[14px]">The best time to plant vegetables
                                depends on the type of vegetable and the climate. In general, spring is a great time to
                                plant most vegetables, while fall is ideal for certain crops like garlic and onions.
                                It's important to consider the specific needs of each vegetable and the local climate
                                when planning your garden.</p>
                        </div>
                    </div>
                    <div class="flex flex-col p-5 rounded-2xl bg-white w-full">
                        <button class="accordion-button flex justify-between gap-1 items-center"
                            data-accordion="accordion-faq-4">
                            <span class="font-bold text-lg leading-[27px] text-left">Who is the target audience for
                                SayurKita?</span>
                            <div class="arrow w-9 h-9 flex shrink-0">
                                <img src="images/icons/arrow-circle-down.svg" class="transition-all duration-300"
                                    alt="icon">
                            </div>
                        </button>
                        <div id="accordion-faq-4" class="accordion-content hide">
                            <p class="leading-[30px] text-cp-light-grey pt-[14px]">SayurKita is dedicated to promoting
                                the freshest and healthiest vegetables, ensuring every meal is packed with nutrition and
                                flavor. Join us in embracing a sustainable and wholesome lifestyle with our top-quality
                                produce.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="bg-cp-black w-full relative overflow-hidden mt-20">
        <div
            class="container max-w-[1130px] mx-auto flex flex-wrap gap-y-4 items-center justify-between pt-[100px] pb-[220px] relative z-10">
            <div class="flex flex-col gap-10">
                <div class="flex items-center gap-3">
                    <div class="flex shrink-0 h-[43px] overflow-hidden">
                        <img src="images\logo\logo.png" class="object-contain w-full h-full" alt="logo">
                    </div>
                    <div class="flex flex-col">
                        <p id="CompanyName" class="font-extrabold text-xl leading-[30px] text-white">SayurKita</p>
                        <p id="CompanyTagline" class="text-sm text-cp-light-grey">Vegetable Revolution</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <a href="">
                        <div class="w-6 h-6 flex shrink-0 overflow-hidden">
                            <img src="images/icons/youtube.svg" class="w-full h-full object-contain" alt="youtube">
                        </div>
                    </a>
                    <a href="">
                        <div class="w-6 h-6 flex shrink-0 overflow-hidden">
                            <img src="images/icons/whatsapp.svg" class="w-full h-full object-contain" alt="whatsapp">
                        </div>
                    </a>
                    <a href="">
                        <div class="w-6 h-6 flex shrink-0 overflow-hidden">
                            <img src="images/icons/facebook.svg" class="w-full h-full object-contain" alt="facebook">
                        </div>
                    </a>
                    <a href="">
                        <div class="w-6 h-6 flex shrink-0 overflow-hidden">
                            <img src="images/icons/instagram.svg" class="w-full h-full object-contain"
                                alt="instagram">
                        </div>
                    </a>
                </div>
            </div>
            <div class="flex flex-wrap gap-[50px]">
                <div class="flex flex-col w-[200px] gap-3">
                    <p class="font-bold text-lg text-white">Products</p>
                    <a href="" class="text-cp-light-grey hover:text-white transition-all duration-300">Product
                        List</a>
                    <a href="" class="text-cp-light-grey hover:text-white transition-all duration-300">Blog
                        List</a>
                    <a href=""
                        class="text-cp-light-grey hover:text-white transition-all duration-300">Gallery</a>
                </div>
                <div class="flex flex-col w-[200px] gap-3">
                    <p class="font-bold text-lg text-white">About</p>
                    <a href="" class="text-cp-light-grey hover:text-white transition-all duration-300">General
                        Contact</a>
                    <a href="" class="text-cp-light-grey hover:text-white transition-all duration-300">Our Big
                        Purposes</a>
                    <a href="" class="text-cp-light-grey hover:text-white transition-all duration-300">About
                        Us</a>
                </div>
                <div class="flex flex-col w-[200px] gap-3">
                    <p class="font-bold text-lg text-white">Useful Links</p>
                    <a href="" class="text-cp-light-grey hover:text-white transition-all duration-300">Privacy
                        & Policy</a>
                    <a href="" class="text-cp-light-grey hover:text-white transition-all duration-300">Terms &
                        Conditions</a>
                    <a href="contact.html"
                        class="text-cp-light-grey hover:text-white transition-all duration-300">Contact Us</a>
                </div>
            </div>
        </div>
        <div class="absolute -bottom-[135px] w-full">
            <p class="font-extrabold text-[250px] leading-[375px] text-center text-white opacity-5">SayurKita</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- JavaScript -->
    <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
    <script src="https://unpkg.com/flickity-fade@1/flickity-fade.js"></script>
    <script src="{{ asset('styles/carousel.js') }} "></script>
    <script src="{{ asset('styles/accordion.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="{{ asset('styles/modal-video.js') }}"></script>
</body>

</html>
