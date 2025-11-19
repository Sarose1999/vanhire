<x-admin-layout>
    <div class="container mx-auto mt-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Manage Vans</h2>
            <a href="{{ route('admin.vans.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">+ Add New Van</a>
        </div>

        @if(session('success'))
            <div class="mb-4 bg-green-100 text-green-800 px-4 py-2 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Image</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Name</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Model</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Seats</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Price/Day ($)</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($vans as $van)
                    <tr class="hover:bg-gray-100 transition">
                        <td class="px-6 py-4">{{ $van->id }}</td>
                        <td class="px-6 py-4 flex items-center">
                            @if($van->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($van->image))
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($van->image) }}"
                                     alt="{{ $van->name }}" class="h-16 w-24 object-cover rounded">
                            @else
                                <span class="text-red-600 font-bold mr-2">⚠</span>
                                <span class="text-gray-500 text-sm">No Image</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $van->name }}</td>
                        <td class="px-6 py-4">{{ $van->model }}</td>
                        <td class="px-6 py-4">{{ $van->seats }}</td>
                        <td class="px-6 py-4">{{ $van->price_per_day }}</td>
                        <td class="px-6 py-4 space-x-2">
                            <a href="{{ route('admin.vans.edit', $van->id) }}"
                               class="text-yellow-600 hover:text-yellow-800">Edit</a>
                            <form action="{{ route('admin.vans.destroy', $van->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800"
                                        onclick="return confirm('Are you sure you want to delete this van?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <a href="{{ route('admin.dashboard') }}"
           class="inline-block mt-4 bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition">
           Back
        </a>
    </div>
</x-admin-layout>
