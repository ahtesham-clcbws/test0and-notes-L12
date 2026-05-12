<div class="max-w-7xl mx-auto py-4 px-4 min-h-screen">
    <div class="flex flex-col lg:flex-row bg-white rounded-md shadow-sm border border-gray-200 overflow-hidden min-h-150">
        
        {{-- LEFT PANEL: INSTRUCTIONS --}}
        <div class="flex-1 p-8 md:p-10 bg-white">
            <div class="mb-8">
                <h1 class="text-3xl font-extrabold text-gray-900 uppercase tracking-tighter mb-2">{{ $test->title }}</h1>
                <div class="text-sm font-medium text-gray-500 flex items-center gap-2">
                    <span>({{ $test->sections ?? 1 }} Sections)</span>
                    <span>•</span>
                    <span>Duration: {{ $test_duration }} Minutes</span>
                    <span>•</span>
                    <span>Questions: {{ $test->total_questions }}</span>
                </div>
                <div class="text-xs font-bold text-gray-400 mt-2">
                    {{ date('d M Y', strtotime($test->created_at)) }} <br>
                    <span class="text-error uppercase tracking-widest font-black text-[10px]">Live Test</span>
                </div>
            </div>

            <div class="mb-10">
                <h3 class="text-sm font-black text-gray-900 border-b-2 border-gray-900 inline-block pb-1 mb-6 uppercase tracking-wider">Instruction</h3>
                
                {{-- LEGEND BOX (Screenshot Match) --}}
                <div class="p-6 bg-gray-50 rounded-2xl shadow-inner border border-gray-100 flex flex-row items-center justify-around mb-10 max-w-2xl">
                    <div class="flex items-center gap-3">
                        <span class="w-7 h-7 rounded-full bg-success shadow-sm"></span>
                        <span class="font-bold text-gray-800 text-xs">Attempted</span>
                    </div>
                    
                    <div class="w-px h-8 bg-gray-200"></div>
                    
                    <div class="flex items-center gap-3">
                        <span class="w-7 h-7 rounded-full bg-gray-300 shadow-sm"></span>
                        <span class="font-bold text-gray-800 text-xs">Not Attempted</span>
                    </div>
                    
                    <div class="w-px h-8 bg-gray-200"></div>
                    
                    <div class="flex items-center gap-4">
                        <div class="flex items-center -space-x-2">
                            <div class="relative">
                                <x-icon name="s-star" class="w-5 h-5 text-warning absolute -top-2 -left-1 z-10" />
                                <span class="w-7 h-7 rounded-full bg-success block shadow-sm"></span>
                            </div>
                            <div class="relative">
                                <x-icon name="s-star" class="w-5 h-5 text-warning absolute -top-2 right-0 z-10" />
                                <span class="w-7 h-7 rounded-full bg-gray-300 block shadow-sm"></span>
                            </div>
                        </div>
                        <span class="font-bold text-gray-800 text-xs">Mark for Review</span>
                    </div>
                </div>

                <div class="space-y-3 text-gray-700 font-semibold text-xs leading-relaxed max-w-3xl">
                    <p>0.25% marks will be deducted for each wrong answer</p>
                    <p>2 marks will be provided for each correct answer.</p>
                    <p>Total time will be allotted / count for whole test, time will not be calculated for each question</p>
                    <p>Time for test is set to according to the server.</p>
                </div>
            </div>

            {{-- ACCEPTANCE --}}
            <div class="space-y-4 pt-10 border-t border-gray-50">
                <div class="text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Declaration</div>
                <label class="flex items-start gap-3 cursor-pointer group">
                    <input type="checkbox" wire:model.live="termsAccepted" class="mt-1 w-4 h-4 text-success border-gray-300 rounded focus:ring-success" />
                    <span class="font-bold text-gray-600 text-xs group-hover:text-gray-900 transition-colors">I have read and understood all instructions provided above and agree to follow them.</span>
                </label>
                <label class="flex items-start gap-3 cursor-pointer group">
                    <input type="checkbox" wire:model.live="privacyAccepted" class="mt-1 w-4 h-4 text-success border-gray-300 rounded focus:ring-success" />
                    <span class="font-bold text-gray-600 text-xs group-hover:text-gray-900 transition-colors">I understand that any attempt to use unfair means will lead to disqualification and further action.</span>
                </label>
            </div>
        </div>

        {{-- RIGHT PANEL (Blue Sidebar from Screenshot) --}}
        <div class="w-full lg:w-96 bg-[#00AEEF] flex flex-col p-6 items-center shadow-2xl relative">
            <div class="w-full pt-10">
                <div class="bg-white rounded-md p-8 w-full flex flex-col items-center text-center shadow-2xl">
                    <div class="relative mb-4">
                        <x-avatar image="{{ '/storage/'.$user_data->photo_url }}" class="w-20! h-20! rounded-full border-4 border-white shadow-xl" />
                    </div>
                    
                    <h2 class="text-lg font-black text-gray-900 mb-1 uppercase tracking-tight">{{ auth()->user()->name }}</h2>
                    <div class="font-bold text-gray-400 text-xs uppercase tracking-widest">
                         {{ $user_data->education_type_data?->name ?? 'SSC-CGL' }} / {{ $user_data->class_data?->name ?? 'SSC' }}
                    </div>
                </div>
            </div>

            <div class="w-full mt-auto flex justify-center pb-10">
                <button 
                    wire:click="startTest" 
                    @if(!$termsAccepted || !$privacyAccepted) disabled @endif
                    class="bg-[#4CAF50] hover:bg-[#45a049] disabled:bg-gray-400 disabled:opacity-50 text-white font-black text-xl py-4 px-12 rounded-lg shadow-2xl transition-all active:scale-95 transform {{ (!$termsAccepted || !$privacyAccepted) ? 'cursor-not-allowed' : 'cursor-pointer hover:-translate-y-1' }}"
                >
                    Start Test
                </button>
            </div>
            
            {{-- Activate Windows Mock (Just for 100% parity visual check) --}}
            <div class="absolute bottom-4 right-4 text-white/30 text-[10px] text-right pointer-events-none font-mono">
                Activate Windows <br>
                Go to Settings to activate Windows.
            </div>
        </div>
    </div>
</div>
