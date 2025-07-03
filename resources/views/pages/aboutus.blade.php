@extends('layouts.aboutus')

@section('title', 'About Us')

@section('content')
<main class="w-full px-4 md:px-16 lg:px-24 py-12 space-y-16">

    <!-- Parallax Banner -->
    <div class="relative rounded-xl overflow-hidden shadow-2xl">
      <div class="relative h-[28rem] parallax-banner" style="background-image: url('{{ asset('images/sayur1.jpg') }}');">
        <div class="absolute inset-0 bg-black/50 z-10"></div>
        <div class="absolute bottom-8 left-8 z-20 text-white text-4xl md:text-5xl font-bold drop-shadow-xl animate-glow">
          Sayur Kita — Grow Locally, Export Globally
        </div>
      </div>
    </div>

  <!-- Our Story -->
  <section class="text-center max-w-5xl mx-auto space-y-6" data-reveal>
    <h1 class="text-4xl font-bold">Our Story</h1>
    <p class="text-gray-600 text-base">
      Sayur Kita is a web-based CMS platform designed to support the export of Indonesia’s finest locally-grown vegetables...
    </p>
    <p class="text-gray-600 text-base">
      We are committed to improving transparency, efficiency, and accessibility...
    </p>
  </section>

  <!-- Vision & Mission -->
  {{-- <section class="grid md:grid-cols-2 gap-10" data-reveal>
    <div class="bg-white p-8 rounded-2xl shadow-lg text-center hover:shadow-green-200 transition duration-300 ease-in-out">
      <h3 class="text-2xl font-semibold mb-4 text-green-700">Our Mission</h3>
      <p class="text-gray-600">To empower Indonesia’s local vegetable industry...</p>
    </div>
    <div class="bg-white p-8 rounded-2xl shadow-lg text-center hover:shadow-green-200 transition duration-300 ease-in-out">
      <h3 class="text-2xl font-semibold mb-4 text-green-700">Our Vision</h3>
      <p class="text-gray-600">To become the leading digital gateway...</p>
    </div>
  </section> --}}

  <div id="Products" class="container max-w-[1130px] mx-auto flex flex-col gap-20 mt-20">
    @forelse($abouts as $about)
    <div class="product flex flex-wrap justify-center items-center gap-[60px] even:flex-row-reverse">
      <div class="w-[470px] h-[550px] flex shrink-0 overflow-hidden">
        <img src="{{Storage::url($about->thumbnail)}}" class="w-full h-full object-contain" alt="thumbnail">
      </div>
      <div class="flex flex-col gap-[30px] py-[50px] h-fit max-w-[500px]">
        <p class="badge w-fit bg-cp-pale-blue text-cp-light-blue p-[8px_16px] rounded-full uppercase font-bold text-sm">OUR {{$about->type}}</p>
        <div class="flex flex-col gap-[10px]">
          <h2 class="font-bold text-4xl leading-[45px]">{{$about->name}}</h2>
          <div class="flex flex-col gap-5">
            <div class="flex items-center gap-[10px]">
                @foreach($about->keypoints as $keypoint)
              <div class="w-6 h-6 flex shrink-0">
                <img src="assets/icons/tick-circle.svg" alt="icon">
              </div>
              <p class="leading-[26px] font-semibold">{{$keypoint}}</p>
            </div>
            @empty
            <p class="text-cp-light-grey">No key points available.</p>
            @endforelse
          </div>
        </div>
      </div>
    </div>
    @empty
    <p>No abouts found.</p>
    @endforelse


  <!-- Illustrations -->
  <section class="grid md:grid-cols-3 gap-10" data-reveal>
    @foreach ([['src' => 'petani lokal.jpg', 'label' => 'Local Farmer'], ['src' => 'distribusi cepat.png', 'label' => 'Fast Distribution'], ['src' => 'kualitas terbaik.png', 'label' => 'Best Quality']] as $item)
      <div class="bg-white rounded-xl shadow-md p-6 text-center transform hover:scale-105 transition duration-300 hover:shadow-xl">
        <img src="{{ asset('images/' . $item['src']) }}" alt="{{ $item['label'] }}" class="w-full h-52 object-cover rounded-lg mb-4">
        <p class="text-lg font-medium text-gray-700">{{ $item['label'] }}</p>
      </div>
    @endforeach
  </section>

  <!-- Leadership -->
  <section class="text-center space-y-8" data-reveal>
    <h2 class="text-3xl font-bold">Leadership</h2>
    <div class="flex flex-wrap justify-center gap-10 max-w-4xl mx-auto">
      @foreach ([['src' => 'yeni rokhayati.jpg', 'name' => 'Yeni Rokhayati, S.Si., M.Sc', 'title' => 'Head of Informatics Engineering Program'], ['src' => 'agung riyadi.jpg', 'name' => 'Agung Riyadi, S.Si., M.Kom', 'title' => 'Project Manager']] as $person)
        <div class="bg-white p-6 rounded-2xl shadow-lg max-w-xs transform hover:scale-105 transition duration-300">
          <img src="{{ asset('images/' . $person['src']) }}" class="w-32 h-32 object-cover rounded-full mx-auto mb-4 shadow">
          <h3 class="text-xl font-semibold text-gray-800">{{ $person['name'] }}</h3>
          <p class="text-gray-600 text-sm">{{ $person['title'] }}</p>
        </div>
      @endforeach
    </div>
  </section>

  <!-- Our Team -->
  <div id="Teams" class="w-full px-[10px] relative z-10">
    <div class="container max-w-[1130px] mx-auto flex flex-col gap-[50px] items-center">
      <div class="flex flex-col gap-[50px] items-center">
        <h2 class="font-bold text-4xl leading-[45px] text-center">We’re Here to Show <br> Awesome Teamwork</h2>
      </div>
      <div class="teams-card-container grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-[30px] justify-center">
        
        @forelse ($teams as $team)
        <div class="card bg-white flex flex-col h-full justify-center items-center p-[30px] px-[29px] gap-[30px] rounded-[20px] border border-[#E8EAF2] hover:shadow-[0_10px_30px_0_#D1D4DF80] hover:border-cp-dark-blue transition-all duration-300">
          <div class="w-[100px] h-[100px] flex shrink-0 items-center justify-center rounded-full bg-[linear-gradient(150.55deg,_#007AFF_8.72%,_#312ECB_87.11%)]">
            <div class="w-[90px] h-[90px] rounded-full overflow-hidden">
              <img src="{{Storage::url($team->avatar)}}" class="object-cover w-full h-full object-center" alt="photo">
            </div>
          </div>
          <div class="flex flex-col gap-1 text-center">
            <p class="font-bold text-xl leading-[30px]">{{ $team->name }}</p>
            <p class="text-cp-light-grey">{{ $team->occupation }}</p>
          </div>
          <div class="flex items-center justify-center gap-[10px]">
            <div class="w-6 h-6 flex shrink-0">
              <img src="assets/icons/global.svg" alt="icon">
            </div>
            <p class="text-cp-dark-blue font-semibold">{{ $team->location }}</p>
          </div>
        </div>
        @empty
        <p>No team members found.</p>
        @endforelse


      </div>
    </div>
  </div>

</main>
@endsection
