@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold mb-6">Dashboard Admin</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-gray-500 text-sm">Total Siswa</h3>
                <p class="text-3xl font-bold text-blue-600">{{ $totalSiswa }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-gray-500 text-sm">Total Petugas</h3>
                <p class="text-3xl font-bold text-green-600">{{ $totalPetugas }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-gray-500 text-sm">Toggle Aktif</h3>
                <p class="text-3xl font-bold text-orange-600">{{ $activeToggles }}</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold mb-4">Menu</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('admin.siswa.index') }}"
                    class="bg-blue-600 text-white text-center py-4 rounded-lg hover:bg-blue-700">
                    Data Siswa
                </a>
                <a href="{{ route('admin.petugas.index') }}"
                    class="bg-green-600 text-white text-center py-4 rounded-lg hover:bg-green-700">
                    Data Petugas
                </a>
                <a href="{{ route('admin.settings.index') }}"
                    class="bg-purple-600 text-white text-center py-4 rounded-lg hover:bg-purple-700">
                    Settings
                </a>
                <a href="{{ route('admin.history') }}"
                    class="bg-gray-600 text-white text-center py-4 rounded-lg hover:bg-gray-700">
                    History Toggle
                </a>
            </div>
        </div>
    </div>
@endsection
