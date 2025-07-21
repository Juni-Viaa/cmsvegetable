@props(['user'])

<div class="flex items-center space-x-4 mb-8">
    <div class="w-16 h-16 rounded-full bg-gray-800 overflow-hidden">
        <img src="https://via.placeholder.com/64x64/374151/ffffff?text={{ substr($user->first_name ?? 'U', 0, 1) }}"
            alt="Profile" class="w-full h-full object-cover">
    </div>
    <div>
        <h3 class="text-xl font-semibold text-gray-900">{{ $user->first_name ?? 'Muhammad' }},
            {{ $user->last_name ?? 'Faiz' }}</h3>
        <p class="text-gray-600">{{ $user->username ?? 'Faiz271204' }}</p>
        <p class="text-gray-600">{{ $user->phone ?? '082170640976' }}</p>
    </div>
</div>
