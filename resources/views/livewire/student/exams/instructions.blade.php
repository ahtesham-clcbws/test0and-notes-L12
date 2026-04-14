<div class="py-6 px-4 md:px-8 max-w-7xl mx-auto">
    {{-- Main Content and Sidebar --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- Instructions Section --}}
        <div class="lg:col-span-2 space-y-8">
            <x-card class="shadow-sm border-gray-100" title="{{ $test->title }}">
                <div class="text-sm font-bold text-primary-600 bg-primary-50 px-4 py-3 rounded-xl inline-flex items-center gap-4 mb-6">
                    <span class="flex items-center gap-1.5"><x-icon name="o-clock" class="w-4 h-4" /> {{ $test_duration }} Minutes</span>
                    <span class="w-1 h-1 bg-primary-300 rounded-full"></span>
                    <span class="flex items-center gap-1.5"><x-icon name="o-queue-list" class="w-4 h-4" /> {{ $test->sections }} Sections</span>
                    <span class="w-1 h-1 bg-primary-300 rounded-full"></span>
                    <span class="flex items-center gap-1.5"><x-icon name="o-question-mark-circle" class="w-4 h-4" /> {{ $test->total_questions }} Questions</span>
                </div>

                <div class="prose prose-slate max-w-none">
                    <h3 class="text-xl font-black text-gray-900 mb-4">Exam Instructions</h3>
                    <div class="space-y-4 text-gray-600 leading-relaxed font-medium">
                        <p>1. Please read the questions carefully before answering. Each question has a specific time limit and marking scheme.</p>
                        <p>2. Ensure you have a stable internet connection. If the test is interrupted, your progress up to the last saved answer will be preserved.</p>
                        <p>3. Do not refresh or close the browser window during the test. Use the "Save & Next" button to proceed through questions.</p>
                        <p>4. You can use the "Mark for Review" feature to flag questions you want to return to later before final submission.</p>
                    </div>

                    <div class="mt-8 space-y-3 pt-6 border-t border-gray-50">
                        <x-checkbox 
                            label="I agree to all terms & conditions" 
                            wire:model.live="termsAccepted" 
                            class="checkbox-primary font-bold"
                        />
                        @error('termsAccepted') <span class="text-error text-xs font-bold block ml-8">{{ $message }}</span> @enderror

                        <x-checkbox 
                            label="I accept the privacy policy and data usage terms" 
                            wire:model.live="privacyAccepted" 
                            class="checkbox-primary font-bold"
                        />
                        @error('privacyAccepted') <span class="text-error text-xs font-bold block ml-8">{{ $message }}</span> @enderror
                    </div>
                </div>
            </x-card>

            {{-- Section Breakdown (Optional but useful for parity if they want detailed info) --}}
            <x-card class="shadow-sm border-gray-100" title="Section Distribution">
                <div class="space-y-6">
                    @foreach($test->getSection as $section)
                        <div class="p-4 rounded-2xl bg-gray-50/50 border border-gray-100">
                            <h5 class="font-black text-gray-800 mb-3 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-primary-500"></span>
                                {{ $section->sectionSubject->name }}
                            </h5>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-xs font-bold uppercase tracking-widest text-gray-400">
                                <div class="space-y-1">
                                    <p class="text-[10px] opacity-70">Questions</p>
                                    <p class="text-gray-700">{{ $section->number_of_questions }}</p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-[10px] opacity-70">Type</p>
                                    <p class="text-gray-700">{{ $section->question_type == '1' ? 'MCQ' : 'Text' }}</p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-[10px] opacity-70">Part</p>
                                    <p class="text-gray-700 truncate">{{ $section->sectionSubjectPart->name ?? 'N/A' }}</p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-[10px] opacity-70">Lesson</p>
                                    <p class="text-gray-700 truncate">{{ $section->sectionSubjectLesson->name ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-card>
        </div>

        {{-- Sidebar Section --}}
        <div class="space-y-6">
            <x-card class="shadow-sm border-gray-100 text-center">
                <div class="flex flex-col items-center gap-4 py-4">
                    <div class="relative">
                        <x-avatar image="{{ '/storage/'.$user_data->photo_url }}" class="w-32! h-32! border-4 border-white shadow-xl" />
                        <div class="absolute bottom-1 right-1 w-6 h-6 bg-green-500 border-4 border-white rounded-full"></div>
                    </div>
                    <div class="space-y-1">
                        <h2 class="text-2xl font-black text-gray-900">{{ auth()->user()->name }}</h2>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-[0.2em]">{{ $user_data->educationType?->name }} • {{ $user_data->classType?->name }}</p>
                    </div>
                    
                    <div class="w-full pt-6">
                        <x-button 
                            label="Start Test Now" 
                            icon="o-bolt" 
                            wire:click="startTest" 
                            class="btn-primary btn-lg btn-block rounded-2xl font-black text-lg shadow-lg shadow-primary-200"
                            :disabled="!$termsAccepted || !$privacyAccepted"
                        />
                    </div>
                </div>
            </x-card>

            <x-alert icon="o-exclamation-triangle" class="bg-amber-50 border-amber-200 text-amber-700 text-xs font-bold leading-relaxed">
                Ensure you have finished all your preparations before starting. The timer will start immediately.
            </x-alert>
        </div>

    </div>
</div>
