@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <div class="w-full max-w-lg mx-auto bg-white p-8 shadow-md rounded-lg">
            <h1 class="text-2xl font-bold mb-6">Form Pengaduan</h1>

            @if (session('success'))
                <div class="bg-green-500 text-white p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-bold mb-2">Nama:</label>
                    <input type="text" name="name" id="name" value="{{ Auth::user()->name }}" readonly
                        class="w-full p-2 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed">
                </div>

                <div class="mb-4">
                    <label for="category_id" class="block text-gray-700 font-bold mb-2">Kategori:</label>
                    <select name="category_id" id="category_id"
                        class="w-full p-2 border border-gray-300 rounded-lg @error('category_id') border-red-500 @enderror">
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="title" class="block text-gray-700 font-bold mb-2">Judul Pengaduan:</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                        class="w-full p-2 border border-gray-300 rounded-lg @error('title') border-red-500 @enderror"
                        placeholder="Masukkan judul pengaduan">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-gray-700 font-bold mb-2">Deskripsi Pengaduan:</label>
                    <textarea name="description" id="description" rows="4"
                        class="w-full p-2 border border-gray-300 rounded-lg @error('description') border-red-500 @enderror"
                        placeholder="Deskripsikan pengaduan">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="file_path" class="block text-gray-700 font-bold mb-2">Dokumentasi (Gambar):</label>
                    <input type="file" name="file_path" id="file_path" accept=".png, .jpg, .jpeg"
                        class="w-full p-2 border border-gray-300 rounded-lg @error('file_path') border-red-500 @enderror">
                    <p class="text-gray-600 text-sm mt-1">Format yang diizinkan: PNG, JPG, JPEG</p>
                    @error('file_path')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <button type="submit" class="w-full bg-blue-500 text-white p-3 rounded-lg font-bold hover:bg-blue-700">
                        Kirim Pengaduan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
