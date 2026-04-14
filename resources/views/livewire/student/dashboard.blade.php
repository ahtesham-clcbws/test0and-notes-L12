<div>
    {{-- HEADER --}}
    <x-header title="Welcome back, {{ Auth::user()->name }}!" progress-indicator />

    {{-- PRIMARY STATS GRID (Legacy Row 1) --}}
    <div class="grid gap-4 mb-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6">
        @php
            $grid1 = [
                ['title' => 'Test Attempt', 'value' => $testAttemptCount, 'image' => 'student1/images/test_attempt.png', 'color' => '#fece5e', 'link' => route('student.test-attempt')],
                ['title' => 'Institute Test', 'value' => $testInstitute, 'image' => 'student1/images/institute_test.png', 'color' => '#ace1f9', 'link' => route('student.institute_tests')],
            ];
            
            foreach($this->test_cat as $item) {
                $staticIcon = match($item->cat_name) {
                    'New Test' => 'student1/images/1.png',
                    'Original Test' => 'student1/images/2.png',
                    'Previous Test' => 'student1/images/3.png',
                    'Premium Test' => 'student1/images/4.png',
                    default => 'student1/images/1.png'
                };
                $grid1[] = ['title' => $item->cat_name, 'value' => $this->testCount[$item->id] ?? 0, 'image' => $staticIcon, 'color' => '#dee9a2', 'link' => route('student.dashboard_gyanology_list', ['cat' => $item->id])];
            }
        @endphp

        @foreach($grid1 as $card)
            <a href="{{ $card['link'] }}" class="group flex flex-col h-full transition-all bg-white border border-base-200 rounded-2xl shadow-sm hover:shadow-md hover:border-primary-300">
                <div class="flex items-center p-4 gap-4 flex-1">
                    <div class="p-2 rounded-xl" style="background-color: {{ $card['color'] }}">
                        <img src="{{ asset($card['image']) }}" class="w-12 h-10 object-contain" alt="{{ $card['title'] }}" />
                    </div>
                    <div class="flex-1">
                        <div class="text-xs font-semibold tracking-wider text-base-content/50">{{ $card['title'] }}</div>
                        <div class="text-2xl font-black text-base-content">{{ $card['value'] }}</div>
                    </div>
                </div>
                <div class="px-4 py-2 text-xs text-primary/80 bg-base-100 flex items-center justify-between border-t border-base-100 rounded-b-2xl group-hover:bg-primary-50 transition-colors">
                    <span>View Details</span>
                    <x-icon name="o-arrow-right" class="w-3 h-3 group-hover:translate-x-1 transition-transform" />
                </div>
            </a>
        @endforeach
    </div>

    {{-- SECONDARY STATS GRID (Legacy Row 2) --}}
    <div class="grid gap-4 mb-10 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6">
        @php
            $grid2 = [
                ['title' => 'Study Notes', 'value' => $notes_count, 'image' => 'student1/images/student_note.png', 'color' => '#facacb', 'link' => route('student.show')],
                ['title' => 'Comprehensive', 'value' => $comprehensive_count, 'image' => 'student1/images/5.png', 'color' => '#ace1f9', 'link' => route('student.showComprehensive')],
                ['title' => 'Short Notes', 'value' => $short_notes_count, 'image' => 'student1/images/6.png', 'color' => '#dee9a2', 'link' => route('student.showShortNotes')],
                ['title' => 'Premium Notes', 'value' => $premium_count, 'image' => 'student1/images/7.png', 'color' => '#facacb', 'link' => route('student.showPremium')],
                ['title' => 'Live Classes', 'value' => $video_count, 'image' => 'student1/images/video_note.png', 'color' => '#fff466', 'link' => route('student.showvideo')],
                ['title' => 'Current Affairs', 'value' => $gk_count, 'image' => 'student1/images/gk.png', 'color' => '#c6c4e1', 'link' => route('student.showgk')],
            ];
        @endphp

        @foreach($grid2 as $card)
            <a href="{{ $card['link'] }}" class="group flex flex-col h-full transition-all bg-white border border-base-200 rounded-2xl shadow-sm hover:shadow-md hover:border-primary-300">
                <div class="flex items-center p-4 gap-4 flex-1">
                    <div class="p-2 rounded-xl" style="background-color: {{ $card['color'] }}">
                        <img src="{{ asset($card['image']) }}" class="w-12 h-10 object-contain" alt="{{ $card['title'] }}" />
                    </div>
                    <div class="flex-1">
                        <div class="text-xs font-semibold tracking-wider text-base-content/50">{{ $card['title'] }}</div>
                        <div class="text-2xl font-black text-base-content">{{ $card['value'] }}</div>
                    </div>
                </div>
                <div class="px-4 py-2 text-xs text-primary/80 bg-base-100 flex items-center justify-between border-t border-base-100 rounded-b-2xl group-hover:bg-primary-50 transition-colors">
                    <span>View Details</span>
                    <x-icon name="o-arrow-right" class="w-3 h-3 group-hover:translate-x-1 transition-transform" />
                </div>
            </a>
        @endforeach
    </div>

    {{-- MOTIVATION FOOTER --}}
    <div class="flex items-center justify-center p-8 rounded-3xl bg-linear-to-br from-indigo-50 to-blue-50 border border-indigo-100">
        <div class="text-center">
            <p class="text-lg italic font-medium text-base-content/80">"{{ $quote }}"</p>
        </div>
    </div>
</div>
