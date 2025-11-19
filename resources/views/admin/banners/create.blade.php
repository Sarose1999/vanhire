<x-admin-layout>
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Add New Banner</h1>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded shadow">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li class="mb-1">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow rounded-lg p-6 space-y-6">
        @csrf

        <div>
            <label class="block font-semibold mb-2">Title <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <div>
            <label class="block font-semibold mb-2">Subtitle</label>
            <input type="text" name="subtitle" value="{{ old('subtitle') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block font-semibold mb-2">Image</label>
            <input type="file" name="image" accept="image/*" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <p class="text-gray-500 text-sm mt-1">Recommended size: 1200x400px</p>
        </div>

        <div class="flex items-center gap-4">
            <label class="flex items-center cursor-pointer">
                <input type="checkbox" name="is_active" class="toggle-active sr-only" checked>
                <div class="toggle-track relative w-10 h-5 rounded-full bg-gray-300 transition-colors">
                    <div class="dot absolute w-5 h-5 bg-white rounded-full shadow -left-0.5 -top-0.5 transition-transform"></div>
                </div>
                <span class="ml-2 text-gray-900 font-medium">Active</span>
            </label>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded shadow hover:bg-blue-700 transition">Save Banner</button>
            <a href="{{ route('admin.banners.index') }}" class="bg-gray-200 px-5 py-2 rounded shadow hover:bg-gray-300 transition">Cancel</a>
        </div>
    </form>

    <style>
        /* Toggle Switch */
        .toggle-active + .toggle-track {
            background-color: #d1d5db;
        }
        .toggle-active:checked + .toggle-track {
            background-color: #34d399;
        }
        .toggle-active + .toggle-track .dot {
            transform: translateX(0);
        }
        .toggle-active:checked + .toggle-track .dot {
            transform: translateX(100%);
        }
    </style>
</x-admin-layout>
