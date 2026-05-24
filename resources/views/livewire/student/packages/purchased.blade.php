<div>
    <x-header title="My Packages" subtitle="Your enrolled premium and free packages" separator progress-indicator>
        <x-slot:actions>
            <x-input placeholder="Search package..." wire:model.live.debounce="search" icon="o-magnifying-glass" clearable />
        </x-slot:actions>
    </x-header>

    <x-card shadow separator>
        <x-table :headers="$headers" :rows="$rows" :sort-by="$sortBy" with-pagination>
            @scope('cell_plan.package_type', $row)
                <div class="flex flex-col gap-1">
                    <x-badge :value="$row->plan->package_type == 1 ? 'Institute' : 'Test and Notes'" class="badge-outline badge-primary" />
                    @if($row->plan->final_fees == 0)
                        <x-badge value="FREE" class="badge-success badge-outline" />
                    @endif
                </div>
            @endscope

            @scope('cell_plan_start_date', $row)
                {{ date('d M, Y', $row->plan_start_date) }}
            @endscope

            @scope('cell_plan_end_date', $row)
                {{ date('d M, Y', $row->plan_end_date) }}
            @endscope

            @scope('cell_plan.duration', $row)
                {{ $row->plan->duration }} Days
            @endscope

            @scope('cell_plan_status', $row)
                @php
                    $status = match($row->plan_status) {
                        0 => ['label' => 'In Queue', 'class' => 'badge-info'],
                        1, 2 => ['label' => 'Active', 'class' => 'badge-success'],
                        3 => ['label' => 'Inactive', 'class' => 'badge-neutral'],
                        default => ['label' => 'Expired', 'class' => 'badge-error']
                    };
                @endphp
                <x-badge :value="$status['label']" :class="$status['class']" />
            @endscope

            @scope('cell_actions', $row)
                <div class="flex justify-end gap-2">
                    @if(in_array($row->plan_status, [1, 2]))
                         <x-button 
                            label="Manage" 
                            icon="o-cog-6-tooth" 
                            link="{{ route('student.package_manage', [$row->plan_id]) }}" 
                            class="btn-sm btn-warning" />
                    @else
                        <x-button icon="o-lock-closed" class="btn-sm" disabled />
                    @endif
                </div>
            @endscope
        </x-table>

        @if($rows->isEmpty())
             <div class="py-20 text-center">
                <x-icon name="o-shopping-bag" class="w-16 h-16 mx-auto mb-4 opacity-20" />
                <h3 class="text-xl font-bold opacity-50">No enrolled packages</h3>
                <p class="mt-2 opacity-50">Enroll in a free package or explore premium plans to get started.</p>
                <div class="flex justify-center gap-3 mt-6">
                    <x-button label="Free Packages" link="{{ route('student.plan', ['type' => 'free']) }}" class="btn-info" />
                    <x-button label="Premium Packages" link="{{ route('student.plan', ['type' => 'premium']) }}" class="btn-primary" />
                </div>
            </div>
        @endif
    </x-card>
</div>
