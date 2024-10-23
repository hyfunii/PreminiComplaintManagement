@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Complaint Files</h1>

        @if($files->isEmpty())
            <p class="text-gray-600">No files uploaded for complaints yet.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($files as $file)
                    <div class="bg-white shadow-md rounded-lg p-4">
                        <h2 class="text-lg font-semibold mb-2">{{ $file->complaint->title }}</h2>
                        
                        @if ($file->file_path && file_exists(public_path('storage/' . $file->file_path)))
                            <img src="{{ asset('storage/' . $file->file_path) }}" alt="Complaint File" class="w-full h-48 object-cover rounded-md">
                        @else
                            <div class="text-center text-gray-600">No document</div>
                        @endif

                        <div class="mt-4">
                            <p class="text-sm text-gray-600">Type: {{ $file->file_type }}</p>
                            <p class="text-sm text-gray-600">Uploaded at: {{ $file->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
