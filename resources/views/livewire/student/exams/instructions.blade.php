<div class="max-w-325 mx-auto py-2 px-2 min-h-screen">
    <div class="flex flex-col lg:flex-row bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden min-h-[50vh]">
        
        {{-- LEFT PANEL: INSTRUCTIONS --}}
        <div class="flex-1 p-3 md:p-5 bg-white">
            <div class="mb-4">
                <h1 class="text-xl font-bold text-gray-900 uppercase tracking-tight mb-1">{{ $test->title }}</h1>
                <div class="text-[10px] font-normal text-gray-600">
                    ({{ $test->sections }} Sections) • Duration: {{ $test_duration }} Minutes • Questions: {{ $test->total_questions }}
                </div>
                <div class="text-[9px] font-bold text-gray-400 mt-1">
                    {{ date('d M Y', strtotime($test->created_at)) }} <br>
                    <span class="text-error uppercase tracking-widest font-bold">Live Test</span>
                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-xs font-bold text-gray-900 border-b border-gray-900 w-16 pb-0.5 mb-4">Instruction</h3>
                
                {{-- LEGEND BOX (Ultra-Compact) --}}
                <div class="bg-gray-50/50 rounded-lg border border-gray-100 p-2 flex flex-row items-center justify-between mb-6 max-w-xl">
                    <div class="flex items-center gap-2 flex-1 justify-center">
                        <span class="w-6 h-6 rounded-full bg-success"></span>
                        <span class="font-bold text-gray-700 text-[10px]">Attempted</span>
                    </div>
                    
                    <div class="w-px h-6 bg-gray-200"></div>
                    
                    <div class="flex items-center gap-2 flex-1 justify-center">
                        <span class="w-6 h-6 rounded-full bg-gray-300"></span>
                        <span class="font-bold text-gray-700 text-[10px]">Not Attempted</span>
                    </div>
                    
                    <div class="w-px h-6 bg-gray-200"></div>
                    
                    <div class="flex items-center gap-3 flex-[1.5] justify-center">
                        <div class="flex items-center gap-1">
                            <span class="w-6 h-6">
                                <x-icon name="s-star" class="w-6 h-6 text-warning" />
                            </span>
                            <div class="relative w-6 h-6">
                                <span class="w-6 h-6 rounded-full bg-success block"></span>
                                <x-icon name="s-star" class="w-4 h-4 text-warning absolute -top-1 -right-1" />
                            </div>
                            <div class="relative w-6 h-6">
                                <span class="w-6 h-6 rounded-full bg-gray-300 block"></span>
                                <x-icon name="s-star" class="w-4 h-4 text-warning absolute -top-1 -right-1" />
                            </div>
                        </div>
                        <span class="font-bold text-gray-700 text-[10px]">Mark for Review</span>
                    </div>
                </div>

                <div class="space-y-2 text-gray-700 font-normal text-[10px] leading-tight max-w-2xl">
                    <p>0.25% marks will be deducted for each wrong answer</p>
                    <p>2 marks will be provided for each correct answer.</p>
                    <p>Total time will be allotted / count for whole test, time will not be calculated for each question</p>
                    <p>Time for test is set to according to the server.</p>
                </div>
            </div>

            {{-- ACCEPTANCE --}}
            <div class="space-y-1 pt-4">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" wire:model.live="termsAccepted" class="w-3.5 h-3.5 border-gray-300 rounded" />
                    <span class="font-normal text-gray-700 text-[10px]">I have read and understood all instructions provided above.</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" wire:model.live="privacyAccepted" class="w-3.5 h-3.5 border-gray-300 rounded" />
                    <span class="font-normal text-gray-700 text-[10px]">I understand that any attempt to use unfair means will lead to disqualification.</span>
                </label>
            </div>
        </div>

        {{-- RIGHT PANEL Overlay Sidebar --}}
        <div class="w-full lg:w-80 bg-[#edf5e1] flex flex-col p-3 items-center border-l border-gray-100">
            <div class="w-full flex-1 flex flex-col items-center">
                <div class="bg-white rounded-xl p-3 w-full flex flex-col items-center text-center shadow-sm">
                    <x-avatar image="{{ '/storage/'.$user_data->photo_url }}" class="w-14! h-14! rounded-full border-2 border-gray-50 mb-2" />
                    
                    <h2 class="text-xs font-bold text-gray-900 mb-0.5">{{ auth()->user()->name }}</h2>
                    <div class="font-normal truncate text-gray-500" style="font-size: 0.75rem;">
                         {{ $user_data->education_type_data?->name ?? '' }} / {{ $user_data->class_data?->name ?? '' }}
                    </div>
                    
                    @if(auth()->user()->myInstitute)
                        <div class="font-normal truncate text-gray-500 mt-0.5" style="font-size: 0.7rem;">
                            {{ auth()->user()->myInstitute->institute_name }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="w-full mt-auto flex justify-center pb-2">
                <x-button 
                    label="Start Test" 
                    wire:click="startTest" 
                    class="btn-success btn-sm px-6 text-white font-bold text-xs rounded transition-all"
                    :disabled="!$termsAccepted || !$privacyAccepted"
                />
            </div>
        </div>
    </div>
</div>
