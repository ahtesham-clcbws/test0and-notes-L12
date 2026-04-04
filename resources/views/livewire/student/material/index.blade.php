<div>
    <x-header :title="$category" subtitle="Educational resources for your studies" separator progress-indicator>
        <x-slot:actions>
            <x-input placeholder="Search title..." wire:model.live.debounce="search" icon="o-magnifying-glass" clearable />
        </x-slot:actions>
    </x-header>

    <x-card shadow separator>
        <x-table :headers="$headers" :rows="$materials" :sort-by="$sortBy" with-pagination>
            @scope('cell_title', $item)
                <div>
                    <div class="font-bold">{{ $item->title }}</div>
                    <div class="text-xs opacity-50">{{ $item->sub_title }}</div>
                </div>
            @endscope

            @scope('cell_document_type', $item)
                <div class="flex items-center gap-2">
                    @php
                        $icon = match($item->document_type) {
                            'PDF' => 'o-document-text',
                            'VIDEO', 'YOUTUBE' => 'o-video-camera',
                            'WORD' => 'o-document',
                            'EXCEL' => 'o-table-cells',
                            'AUDIO' => 'o-speaker-wave',
                            default => 'o-document'
                        };
                        $color = match($item->document_type) {
                            'PDF' => 'text-error',
                            'VIDEO', 'YOUTUBE' => 'text-primary',
                            'EXCEL' => 'text-success',
                            default => 'text-neutral'
                        };
                    @endphp
                    <x-icon :name="$icon" :class="'w-5 h-5 ' . $color" />
                    <span class="text-xs font-semibold">{{ $item->document_type }}</span>
                </div>
            @endscope

            @scope('cell_publish_date', $item)
                {{ \Carbon\Carbon::parse($item->publish_date)->format('d M, Y') }}
            @endscope

            @scope('cell_actions', $item)
                <div class="flex justify-end gap-2">
                    @php
                        $isPaid = in_array($item->permission_to_download, ['Paid View', 'Paid View & Download', 'Premium View', 'Premium View & Download']);
                        $canView = $item->publish_status == 'Published' && !$isPaid;
                    @endphp

                    @if($item->document_type == 'YOUTUBE')
                        <x-button 
                            icon="o-play" 
                            label="Watch"
                            link="{{ $item->video_link }}" 
                            class="btn-sm btn-primary" 
                            external />
                    @elseif($item->file != 'NA')
                        <x-button 
                            icon="o-eye" 
                            link="{{ url('storage/'.$item->file) }}" 
                            class="btn-sm btn-ghost" 
                            external
                            tooltip="View" />
                        
                        @if($item->permission_to_download == 'Free View & Download' || $item->permission_to_download == 'Paid View & Download' || $item->permission_to_download == 'Premium View & Download')
                            <x-button 
                                icon="o-arrow-down-tray" 
                                link="{{ url('storage/'.$item->file) }}" 
                                class="btn-sm btn-ghost text-primary" 
                                external 
                                download 
                                tooltip="Download" />
                        @endif
                    @endif

                    @if($isPaid)
                        <x-badge value="Premium" class="badge-warning" />
                    @endif
                </div>
            @endscope
        </x-table>

        @if($materials->isEmpty())
             <div class="py-20 text-center">
                <x-icon name="o-archive-box-x-mark" class="w-16 h-16 mx-auto mb-4 opacity-20" />
                <h3 class="text-xl font-bold opacity-50">No study material found</h3>
                <p class="mt-2 opacity-50">Try searching for a different topic or check back later.</p>
            </div>
        @endif
    </x-card>
</div>
