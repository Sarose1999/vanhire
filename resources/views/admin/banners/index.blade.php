<x-admin-layout>
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Manage Banners</h1>

    <!-- Add Banner Button -->
    <div class="mb-6">
        <a href="{{ route('admin.banners.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition-all duration-300 transform hover:scale-105">
            + Add New Banner
        </a>
    </div>

    @if(session('success'))
        <div id="success-msg" class="mb-4 p-3 bg-green-100 text-green-800 rounded shadow transition-opacity duration-500">
            {{ session('success') }}
        </div>
    @endif

    @if($banners->count() > 0)
    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold">#</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Title</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Subtitle</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Preview</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($banners as $banner)
                <tr class="hover:bg-gray-50 transition duration-300 ease-in-out transform hover:scale-[1.01] cursor-pointer">
                    <td class="px-6 py-4">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 font-medium">{{ $banner->title }}</td>
                    <td class="px-6 py-4">{{ $banner->subtitle ?? '-' }}</td>
                    <td class="px-6 py-4">
                        @if($banner->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($banner->image))
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($banner->image) }}" alt="Banner Image" class="w-32 h-16 object-cover rounded shadow-sm transition-transform duration-300 hover:scale-110">
                        @else
                            <span class="text-gray-400">No Image</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <label class="flex items-center cursor-pointer">
                            <div class="relative">
                                <input type="checkbox" class="toggle-active sr-only" data-id="{{ $banner->id }}" {{ $banner->is_active ? 'checked' : '' }}>
                                <div class="w-10 h-4 bg-gray-400 rounded-full shadow-inner transition-colors"></div>
                                <div class="dot absolute w-6 h-6 bg-white rounded-full shadow -left-1 -top-1 transition-transform"></div>
                            </div>
                        </label>
                    </td>
                    <td class="px-6 py-4 flex gap-2">
                        <a href="{{ route('admin.banners.edit', $banner->id) }}" class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition-all duration-300 relative group">
                            Edit
                            <span class="absolute -top-6 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">Edit Banner</span>
                        </a>

                        <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this banner?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition-all duration-300 relative group">
                                Delete
                                <span class="absolute -top-6 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">Delete Banner</span>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
        <p class="text-center text-gray-500 mt-10">No banners found. Add a new banner to get started.</p>
    @endif

    <!-- AJAX Script for toggle -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        const toggles = document.querySelectorAll('.toggle-active');

        toggles.forEach(toggle => {
            toggle.addEventListener('change', function() {
                const bannerId = this.dataset.id;
                const isActive = this.checked ? 1 : 0;

                axios.post('/admin/banners/' + bannerId + '/toggle', {
                    is_active: isActive
                }, {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => {
                    const msg = document.getElementById('success-msg');
                    if(msg){
                        msg.textContent = response.data.message;
                        msg.classList.remove('hidden');
                        setTimeout(() => msg.classList.add('hidden'), 2500);
                    }
                })
                .catch(error => {
                    alert('Error updating status!');
                    this.checked = !this.checked;
                });
            });
        });
    </script>

    <style>
        /* Toggle Switch */
        .toggle-active + div {
            width: 2.5rem;
            height: 1rem;
            border-radius: 9999px;
            background-color: #d1d5db;
            position: relative;
            transition: background-color 0.3s;
        }
        .toggle-active + div .dot {
            width: 1.5rem;
            height: 1.5rem;
            border-radius: 50%;
            background-color: white;
            position: absolute;
            top: -0.25rem;
            left: -0.25rem;
            transition: transform 0.3s;
        }
        .toggle-active:checked + div {
            background-color: #34d399;
        }
        .toggle-active:checked + div .dot {
            transform: translateX(100%);
        }
    </style>
</x-admin-layout>
