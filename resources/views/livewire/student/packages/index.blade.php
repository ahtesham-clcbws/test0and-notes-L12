<div>
    <x-header :title="ucfirst($type) . ' Packages'" subtitle="Explore available educational plans" separator progress-indicator>
        <x-slot:actions>
            <x-input placeholder="Search package..." wire:model.live.debounce="search" icon="o-magnifying-glass" clearable />
        </x-slot:actions>
    </x-header>

    <x-card shadow separator>
        <x-table :headers="$headers" :rows="$rows" :sort-by="$sortBy" with-pagination>
            @scope('cell_package_type', $row)
                <div class="flex flex-col">
                    <x-badge :value="$row->package_type == 1 ? 'Institute' : 'Global'" :class="$row->package_type == 1 ? 'badge-primary' : 'badge-neutral'" />
                    @if($row->package_type == 1)
                        <span class="text-[10px] opacity-50 mt-1 truncate max-w-32">{{ $row->my_institute_name }}</span>
                    @endif
                </div>
            @endscope

            @scope('cell_final_fees', $row)
                @if($row->final_fees == 0)
                    <x-badge value="FREE" class="badge-success badge-outline" />
                @else
                    <span class="font-bold text-primary">₹ {{ number_format($row->final_fees, 2) }}</span>
                @endif
            @endscope

            @scope('cell_duration', $row)
                <div class="flex items-center gap-1">
                    <x-icon name="o-calendar" class="w-4 h-4 opacity-50" />
                    <span>{{ $row->duration }} Days</span>
                </div>
            @endscope

            @scope('cell_actions', $row)
                <div class="flex justify-end gap-2">
                    <x-button 
                        label="{{ $row->final_fees == 0 ? 'Enroll Free' : 'Buy Now' }}" 
                        icon="{{ $row->final_fees == 0 ? 'o-check-badge' : 'o-shopping-cart' }}" 
                        link="{{ route('student.plan-checkout', [$row->id]) }}" 
                        class="btn-sm {{ $row->final_fees == 0 ? 'btn-info' : 'btn-success' }}" 
                        no-wire-navigate />
                </div>
            @endscope
        </x-table>

        @if($rows->isEmpty())
             <div class="py-20 text-center">
                <x-icon name="o-magnifying-glass-circle" class="w-16 h-16 mx-auto mb-4 opacity-20" />
                <h3 class="text-xl font-bold opacity-50">No packages found</h3>
                <p class="mt-2 opacity-50">Try refining your search or check back soon for new offers.</p>
            </div>
        @endif
    </x-card>
</div>
