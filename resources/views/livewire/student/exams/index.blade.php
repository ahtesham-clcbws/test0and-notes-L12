<div>
    {{-- HEADER --}}
    <x-header :title="$this->source == 'institute' ? 'Institute Tests' : ($type == 1 ? 'Practice Tests' : 'Gyanology Tests')" separator progress-indicator>
        <x-slot:middle class="justify-start!">
            <x-input placeholder="Search tests..." wire:model.live.debounce.300ms="search" clearable icon="o-magnifying-glass" />
        </x-slot:middle>
        <x-slot:actions>
            <x-select
                label="Category"
                :options="$this->categories"
                wire:model.live="category"
                icon="o-tag"
                placeholder="All Categories"
                inline
                class="min-w-48" />
        </x-slot:actions>
    </x-header>

    {{-- TABLE --}}
    <x-card separator shadow class="mt-4">
        <x-table :headers="$headers" :rows="$tests" :sort-by="$sortBy" with-pagination hover>
            {{-- Custom ID Slot --}}
            @scope('cell_id', $test)
                 <span class="font-mono text-[10px] opacity-40">#{{ $test->id }}</span>
            @endscope

            {{-- Custom Title Slot --}}
            @scope('cell_title', $test)
                <div class="flex items-center gap-3">
                    @if($test->attempt_status === 'completed')
                        <x-icon name="o-check-circle" class="text-success h-5 w-5" tooltip="Completed" />
                    @elseif($test->attempt_status === 'running')
                        <x-icon name="o-play-circle" class="text-warning h-5 w-5" tooltip="In Progress" />
                    @else
                        <x-icon name="o-clock" class="text-info h-5 w-5" tooltip="Not started" />
                    @endif
                    <div>
                        <div class="font-bold text-base-content">{{ $test->title }}</div>
                        <div class="flex items-center gap-2 mt-0.5">
                            <span class="text-[10px] uppercase font-bold tracking-wider text-base-content/40">{{ $test->total_questions }} Questions</span>
                            <span class="text-base-content/20">•</span>
                            <span class="text-[10px] uppercase font-bold tracking-wider text-base-content/40">{{ $test->time_to_complete }} Minutes</span>
                        </div>
                    </div>
                </div>
            @endscope

            {{-- Custom Category Slot --}}
            @scope('cell_category_name', $test)
                <x-badge :value="$test->category_name ?? 'Uncategorized'" class="badge-ghost text-[9px] uppercase font-bold tracking-tight py-0 px-2" />
            @endscope

            {{-- Custom Date Slot --}}
            @scope('cell_created_at', $test)
                <span class="text-xs opacity-70">{{ \Carbon\Carbon::parse($test->created_at)->format('d M, Y') }}</span>
            @endscope

            {{-- Custom Status Slot --}}
            @scope('cell_status', $test)
                @if($test->attempt_status === 'completed')
                    <x-badge value="COMPLETED" class="badge-success" />
                @elseif($test->attempt_status === 'running')
                    <x-badge value="RUNNING" class="badge-warning" />
                @else
                    <x-badge value="AVAILABLE" class="badge-info" />
                @endif
            @endscope

            {{-- Custom Actions Slot --}}
            @scope('actions', $test)
                <div class="flex gap-2">
                    @if($test->attempt_status === 'completed')
                        <x-button
                            label="View Results"
                            icon="o-chart-bar"
                            link="{{ route('student.show-result', [Auth::id(), $test->id]) }}"
                            class="btn-sm btn-outline btn-success" />
                    @elseif($test->attempt_status === 'running')
                        <x-button
                            label="Resume"
                            icon="o-forward"
                            link="{{ route('student.start-test', [$test->id]) }}"
                            class="btn-sm btn-warning" />
                    @else
                        <x-button
                            label="Start Test"
                            icon="o-play"
                            link="{{ route('student.test-name', [$test->id]) }}"
                            class="btn-sm btn-primary" />
                    @endif
                    <x-button
                        icon="o-document-magnifying-glass"
                        link="{{ route('student.question-paper', [$test->id]) }}"
                        class="btn-sm btn-ghost"
                        tooltip="Question Paper" />
                </div>
            @endscope
        </x-table>
    </x-card>
</div>
