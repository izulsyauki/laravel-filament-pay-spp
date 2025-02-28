<x-filament-panels::page>
    <x-filament::section>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <label class="block text-gray-400 font-medium mb-1">Nama:</label>
                    <p class="text-gray-900 font-semibold">{{ $user->name }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <label class="block text-gray-400 font-medium mb-1">Nomor Telepon:</label>
                    <p class="text-gray-900 font-semibold">{{ $user->phone ?? 'Belum diisi' }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <label class="block text-gray-400 font-medium mb-1">Email</label>
                    <p class="text-gray-900 font-semibold">{{ $user->email }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-400 font-medium mb-1">Foto:</label>
                    <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('images/default-user.png') }}"
                        alt="Gambar" class="w-32 h-auto object-cover rounded-md border cursor-pointer"
                        x-on:click="dispatch('open-modal', { id: 'image-modal', image: '{{ $user->image ? asset('storage/' . $super->image) : asset('images/default-user.png') }}'})">
                </div>

                <div>
                    <label class="block text-gray-400 font-medium mb-1">Ijazah:</label>
                    <img src="{{ $user->scanijazah ? asset('storage/' . $user->scanijazah) : asset('images/default-ijazah.png') }}"
                        alt="Gambar" class="w-32 h-auto object-cover rounded-md border cursor-pointer"
                        x-on:click="dispatch('open-modal', { id: 'image-modal', image: '{{ $user->scanijazah ? asset('storage/' . $super->scanijazah) : asset('images/default-ijazah.png') }}'})">
                </div>
            </div>
        </div>
    </x-filament::section>

    <x-filament::section class="mt-3">
        <form>
            {{ $this->form }}

            <x-filament::button type="submit" color="primary">Edit</x-filament::button>
        </form>
    </x-filament::section>

    <x-filament::modal id='image-modal'>
        <div class="p-4 flex items-center justify-center overflow-hidden max-h-screen" x-data="{ image: '', scale: 1, offsetX: 0, offsetY: 0, isDragging: false, startX: 0, startY: 0 }"
            x-on:open-modal.window="if ($event.detail.image == 'image-modal'){image = $event.detail.image}"
            x-on:close-modal.window="scale = 1; offsetX = 0; offsetY = 0">
            <div class="relative max-w-full max-h-screen overflow-auto" style="touch-action: none">
                <img x-bind:src="image" alt="Preview"
                    class="rounded-md object-contain cursor-grab":style="'transform: scale(' + scale + ') translate(' + offsetX + 'px);'"
                    x-on:mousedown="isDragging = true; startX = $event.clientX; startY = $event.clientY; $event.preventDefault(); $event.stopPropagation(); offsetX = 0; offsetY = 0; scale = 1;"
                    x-on:mousemove="if (isDragging) {offsetX = offsetX + $event.clientX - startX; offsetY = offsetY + $event.clientY - startY; startX = $event.clientX; startY = $event.clientY;}"
                    x-on:mouseup="isDragging = false;"
                    x-on:wheel="scale = Math.min(2, Math.max(0.5, scale - $event.deltaY * 0.002, 3));"></img>
            </div>
        </div>
    </x-filament::modal>
</x-filament-panels::page>
