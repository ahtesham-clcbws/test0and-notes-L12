<div>
    {{-- HEADER --}}
    <x-header :title="$type == 1 ? 'Practice Tests' : 'Gyanology Tests'" separator progress-indicator>
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
    <x-card separator shadow>
        <x-table :headers="$headers" :rows="$tests" with-pagination>
            {{-- Custom Title Slot --}}
            @scope('cell_title', $test)
                <div class="flex items-center gap-3">
                    @if($test->is_attempted)
                        <x-icon name="o-check-circle" class="text-success h-5 w-5" tooltip="Already attempted" />
                    @else
                        <x-icon name="o-clock" class="text-info h-5 w-5" tooltip="Not started" />
                    @endif
                    <div>
                        <div class="font-bold">{{ $test->title }}</div>
                        <div class="text-xs text-base-content/60">{{ $test->total_questions }} Questions | {{ $test->time_to_complete }} Minutes</div>
                    </div>
                </div>
            @endscope

            {{-- Custom Category Slot --}}
            @scope('cell_category_name', $test)
                <x-badge :value="$test->category_name" class="badge-primary badge-outline" />
            @endscope

            {{-- Custom Date Slot --}}
            @scope('cell_test_date', $test)
                <span class="text-xs">{{ \Carbon\Carbon::parse($test->created_at)->format('d M, Y') }}</span>
            @endscope

            {{-- Custom Status Slot --}}
            @scope('cell_status', $test)
                @if($test->is_attempted)
                    <x-badge value="ATTEMPTED" class="badge-success" />
                @else
                    <x-badge value="AVAILABLE" class="badge-info" />
                @endif
            @endscope

            {{-- Custom Actions Slot --}}
            @scope('actions', $test)
                <div class="flex gap-2">
                    @if($test->is_attempted)
                        <x-button
                            label="View Results"
                            icon="o-chart-bar"
                            link="/student/test/show-result/{{ Auth::id() }}/{{ $test->id }}"
                            class="btn-sm btn-outline btn-success" />
                    @else
                        <x-button
                            label="Start Test"
                            icon="o-play"
                            link="/student/test/start-test/{{ $test->id }}"
                            class="btn-sm btn-primary" />
                    @endif
                    <x-button
                        icon="o-document-magnifying-glass"
                        link="/student/test/question-paper/{{ $test->id }}"
                        class="btn-sm btn-ghost"
                        tooltip="Question Paper" />
                </div>
            @endscope
        </x-table>
    </x-card>
</div>
