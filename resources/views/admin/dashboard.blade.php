@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page_title', 'Dashboard Overview')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <!-- Card 1: Total Routes -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-500 font-medium">Total Routes</p>
         <h3 class="text-2xl font-bold text-gray-800 mt-1">
    {{ $totalRoutes }}
</h3>      </div>
        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center font-bold">
            🗺️
        </div>
    </div>

    <!-- Card 2: Active Promotions -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-500 font-medium">Promotions</p>
         <h3 class="text-2xl font-bold text-gray-800 mt-1">
    {{ $totalPromotions }}
</h3>     </div>
        <div class="w-12 h-12 bg-green-50 text-green-600 rounded-lg flex items-center justify-center font-bold">
            🏷️
        </div>
    </div>

    <!-- Card 3: Quick Action -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-500 font-medium">System Status</p>
            <h3 class="text-2xl font-bold text-green-600 mt-1">Active</h3>
        </div>
        <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-lg flex items-center justify-center font-bold">
            ⚡
        </div>
    </div>
</div>

<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
    <h3 class="text-lg font-bold text-gray-800 mb-2">Welcome to Nova Admin Panel!</h3>
    <p class="text-gray-600 text-sm mb-4">
        
    </p>
    <a href="{{ route('admin.route-management.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition">
        Manage Routes →
    </a>
</div>
@endsection