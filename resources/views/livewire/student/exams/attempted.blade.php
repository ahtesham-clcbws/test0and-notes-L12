<div>
    <x-header title="Attempted Tests" subtitle="Your historical test performance" separator progress-indicator>
        <x-slot:actions>
            <x-input placeholder="Search tests..." wire:model.live.debounce="search" icon="o-magnifying-glass" clearable />
        </x-slot:actions>
    </x-header>

    <x-card shadow separator class="mt-4">
        <x-table :headers="$headers" :rows="$attempts" :sort-by="$sortBy" with-pagination hover>
            @scope('cell_created_at', $attempt)
                {{ $attempt->created_at->format('M d, Y') }}
            @endscope

            @scope('cell_test_type', $attempt)
                @if($attempt->test->user_id)
                    <x-badge value="Institute" class="badge-neutral" />
                @else
                    <x-badge value="Global" class="badge-primary" />
                @endif
            @endscope

            @scope('cell_actions', $attempt)
                <div class="flex justify-end gap-2">
                    @if($attempt->status === 'running')
                        <x-button 
                            label="Resume" 
                            icon="o-play" 
                            link="{{ route('student.start-test', [$attempt->test->id]) }}" 
                            class="btn-sm btn-warning" />
                    @elseif($attempt->test->show_result)
                        <x-button 
                            label="View Result" 
                            icon="o-chart-bar" 
                            link="{{ route('student.show-result', ['payload' => \Illuminate\Support\Facades\Crypt::encrypt(['student_id' => auth()->id(), 'test_id' => $attempt->test->id, 'mode' => 'result'])]) }}" 
                            class="btn-sm btn-outline btn-success" 
                            no-wire-navigate />
                    @else
                        <x-badge value="RESULT PENDING" class="badge-ghost text-[10px]" />
                    @endif
                </div>
            @endscope
        </x-table>
        
        @if($attempts->isEmpty())
            <div class="py-20 text-center">
                <x-icon name="o-no-symbol" class="w-16 h-16 mx-auto mb-4 opacity-20" />
                <h3 class="text-xl font-bold opacity-50">No attempted tests found</h3>
                <p class="mt-2 opacity-50">Browse the test list to start your first attempt!</p>
                <x-button label="Browse Tests" link="/student/test" icon="o-magnifying-glass" class="mt-6 btn-primary" />
            </div>
        @endif
    </x-card>
</div>
