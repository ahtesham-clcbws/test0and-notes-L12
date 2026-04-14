<div>
    {{-- Header Section --}}
    @if($package_plan)
        <div class="mb-8 p-6 rounded-2xl bg-linear-to-br from-indigo-900 via-indigo-700 to-indigo-600 text-white shadow-lg">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <span class="badge badge-outline border-white/30 text-white font-medium px-3 py-2 text-xs">
                            {{ $package_plan->educationType?->name ?? 'Package' }} • {{ $package_plan->classType?->name ?? 'General' }}
                        </span>
                    </div>
                    <h1 class="text-3xl font-black tracking-tight">{{ $package_plan->plan_name }}</h1>
                    <div class="flex flex-wrap gap-3 text-xs font-medium text-indigo-50">
                        <span class="flex items-center gap-1.5 bg-white/10 px-2.5 py-1 rounded-lg border border-white/10">
                            <x-icon name="o-clipboard-document-list" class="w-3.5 h-3.5" /> {{ count($test) }} Tests
                        </span>
                        <span class="flex items-center gap-1.5 bg-white/10 px-2.5 py-1 rounded-lg border border-white/10">
                            <x-icon name="o-video-camera" class="w-3.5 h-3.5" /> {{ count($live_video) }} Videos
                        </span>
                        <span class="flex items-center gap-1.5 bg-white/10 px-2.5 py-1 rounded-lg border border-white/10">
                            <x-icon name="o-document-duplicate" class="w-3.5 h-3.5" /> {{ count($study_material) }} Notes
                        </span>
                        <span class="flex items-center gap-1.5 bg-white/10 px-2.5 py-1 rounded-lg border border-white/10">
                            <x-icon name="o-globe-alt" class="w-3.5 h-3.5" /> {{ count($onegk) }} GK
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Tests Section --}}
    <div class="mb-12">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shadow-sm">
                <x-icon name="o-beaker" class="w-6 h-6" />
            </div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Tests & Assessments</h2>
        </div>

        @if(count($test) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($test as $onetest)
                    <x-card class="hover:shadow-lg transition-all duration-300 border-gray-100" shadow>
                        <div class="flex flex-col h-full gap-4">
                            <div class="space-y-1">
                                <h4 class="font-bold text-lg text-gray-800 line-clamp-2 leading-snug">{{ $onetest->title }}</h4>
                                <div class="flex items-center gap-3 text-sm text-gray-500 font-medium">
                                    <span class="flex items-center gap-1.5"><x-icon name="o-tag" class="w-3.5 h-3.5" /> {{ $onetest->class_name }}</span>
                                    <span class="flex items-center gap-1.5"><x-icon name="o-question-mark-circle" class="w-3.5 h-3.5" /> {{ $onetest->total_questions }} Qs</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between pt-4 mt-auto border-t border-gray-50">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ date('d M Y', strtotime($onetest->created_at)) }}</span>
                                <x-button 
                                    label="Start Test" 
                                    icon="o-play" 
                                    link="{{ route('student.start-test', [$onetest->id]) }}" 
                                    class="btn-primary btn-sm rounded-xl font-bold" 
                                />
                            </div>
                        </div>
                    </x-card>
                @endforeach
            </div>
        @else
            <x-alert icon="o-information-circle" class="bg-gray-50 border-gray-200 text-gray-500">
                No tests available in this package.
            </x-alert>
        @endif
    </div>

    {{-- Study materials Section --}}
    <div class="mb-12">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center shadow-sm">
                <x-icon name="o-document-text" class="w-6 h-6" />
            </div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Study Notes & E-Books</h2>
        </div>

        @if(count($study_material) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($study_material as $onematerial)
                    <x-card class="hover:shadow-lg transition-all duration-300 border-gray-100" shadow>
                        <div class="flex flex-col h-full gap-4">
                            <div class="space-y-1">
                                <h4 class="font-bold text-lg text-gray-800 line-clamp-2 leading-snug">{{ $onematerial->title }}</h4>
                                <p class="text-sm text-gray-500 line-clamp-1 italic font-medium opacity-75">{{ $onematerial->sub_title }}</p>
                            </div>
                            <div class="flex items-center justify-between pt-4 mt-auto border-t border-gray-50">
                                <div class="flex gap-2">
                                    <x-button icon="o-eye" link="{{ url('storage/' . $onematerial->file) }}" target="_blank" class="btn-ghost btn-sm btn-square rounded-lg" />
                                    <x-button icon="o-cloud-arrow-down" link="{{ url('storage/' . $onematerial->file) }}" download class="btn-ghost btn-sm btn-square rounded-lg" />
                                </div>
                                <x-badge :value="$onematerial->publish_status" class="badge-success badge-sm font-bold opacity-80" />
                            </div>
                        </div>
                    </x-card>
                @endforeach
            </div>
        @else
            <x-alert icon="o-information-circle" class="bg-gray-50 border-gray-200 text-gray-500">
                No study materials available.
            </x-alert>
        @endif
    </div>

    {{-- Videos Section --}}
    <div class="mb-12">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-12 h-12 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center shadow-sm">
                <x-icon name="o-video-camera" class="w-6 h-6" />
            </div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Live & Video Classes</h2>
        </div>

        @if(count($live_video) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($live_video as $onevideo)
                    <x-card class="hover:shadow-lg transition-all duration-300 border-gray-100" shadow>
                        <div class="flex flex-col h-full gap-4">
                            <div class="space-y-1">
                                <h4 class="font-bold text-lg text-gray-800 line-clamp-2 leading-snug">{{ $onevideo->title ?? 'Untitled Video' }}</h4>
                                <p class="text-sm text-gray-500 line-clamp-1 italic font-medium opacity-75">{{ $onevideo->sub_title ?? '' }}</p>
                            </div>
                            <div class="pt-4 mt-auto border-t border-gray-50">
                                @if($onevideo->file == 'NA')
                                    <x-button label="Watch Video" icon="o-play-circle" link="{{ $onevideo->video_link }}" target="_blank" class="btn-primary btn-sm btn-block font-bold rounded-xl" />
                                @else
                                    <div class="flex gap-2">
                                        <x-button label="View" icon="o-eye" link="{{ url('storage/' . $onevideo->file) }}" target="_blank" class="btn-outline btn-sm grow font-bold rounded-xl" />
                                        <x-button icon="o-cloud-arrow-down" link="{{ url('storage/' . $onevideo->file) }}" download class="btn-outline btn-sm btn-square rounded-xl" />
                                    </div>
                                @endif
                            </div>
                        </div>
                    </x-card>
                @endforeach
            </div>
        @else
            <x-alert icon="o-information-circle" class="bg-gray-50 border-gray-200 text-gray-500">
                No video classes available.
            </x-alert>
        @endif
    </div>

    {{-- GK Section --}}
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shadow-sm">
                <x-icon name="o-globe-alt" class="w-6 h-6" />
            </div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Static GK & Current Affairs</h2>
        </div>

        @if(count($onegk) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($onegk as $one_gk)
                    <x-card class="hover:shadow-lg transition-all duration-300 border-gray-100" shadow>
                        <div class="flex flex-col h-full gap-4">
                            <div class="space-y-1">
                                <h4 class="font-bold text-lg text-gray-800 line-clamp-2 leading-snug">{{ $one_gk->title }}</h4>
                                <p class="text-sm text-gray-500 line-clamp-1 italic font-medium opacity-75">{{ $one_gk->sub_title }}</p>
                            </div>
                            <div class="pt-4 mt-auto border-t border-gray-50">
                                @if($one_gk->file == 'NA')
                                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest block text-center">Content not available</span>
                                @else
                                    <div class="flex gap-2">
                                        <x-button label="View Content" icon="o-eye" link="{{ url('storage/' . $one_gk->file) }}" target="_blank" class="btn-outline btn-sm grow font-bold rounded-xl" />
                                        <x-button icon="o-cloud-arrow-down" link="{{ url('storage/' . $one_gk->file) }}" download class="btn-outline btn-sm btn-square rounded-xl" />
                                    </div>
                                @endif
                            </div>
                        </div>
                    </x-card>
                @endforeach
            </div>
        @else
            <x-alert icon="o-information-circle" class="bg-gray-50 border-gray-200 text-gray-500">
                No GK content available.
            </x-alert>
        @endif
    </div>
</div>
