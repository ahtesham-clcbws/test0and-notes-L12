<div class="p-0">
    <div class="dashboard-container mb-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3" style="background: none; border-bottom: none; padding-top: 20px;">
                <div class="d-flex align-items-center gap-3">
                    <input type="text" class="form-control form-control-sm" placeholder="Search package..." wire:model.live.debounce.300ms="search" style="width: 250px;">
                    <span class="text-muted" style="font-size: 13px; font-weight: 500;">
                        Showing {{ $plans->firstItem() ?? 0 }} to {{ $plans->lastItem() ?? 0 }} of {{ $plans->total() }} records
                    </span>
                </div>
                <div>
                    <a href="{{ route('administrator.plan_add') }}" class="btn btn-success">Add Package</a>
                </div>
            </div>

            <!-- Flash alerts -->
            <div class="px-4 mt-2">
                @if (session()->has('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>

            <div class="card-body table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th style="cursor: pointer;" wire:click="sort('plan_name')">
                                Name & Class {!! $sortBy === 'plan_name' ? ($sortDirection === 'asc' ? '▲' : '▼') : '' !!}
                            </th>
                            <th style="cursor: pointer;" wire:click="sort('is_featured')">
                                Featured {!! $sortBy === 'is_featured' ? ($sortDirection === 'asc' ? '▲' : '▼') : '' !!}
                            </th>
                            <th>Created For</th>
                            <th>Detail</th>
                            <th style="cursor: pointer;" wire:click="sort('duration')">
                                Duration {!! $sortBy === 'duration' ? ($sortDirection === 'asc' ? '▲' : '▼') : '' !!}
                            </th>
                            <th style="cursor: pointer;" wire:click="sort('final_fees')">
                                Type & Fee {!! $sortBy === 'final_fees' ? ($sortDirection === 'asc' ? '▲' : '▼') : '' !!}
                            </th>
                            <th style="cursor: pointer;" wire:click="sort('status')">
                                Status {!! $sortBy === 'status' ? ($sortDirection === 'asc' ? '▲' : '▼') : '' !!}
                            </th>
                            <th style="cursor: pointer;" wire:click="sort('is_mobile')">
                                isMobile {!! $sortBy === 'is_mobile' ? ($sortDirection === 'asc' ? '▲' : '▼') : '' !!}
                            </th>
                            <th style="cursor: pointer;" wire:click="sort('expire_date')">
                                Expiry {!! $sortBy === 'expire_date' ? ($sortDirection === 'asc' ? '▲' : '▼') : '' !!}
                            </th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($plans as $index => $plan)
                            <tr wire:key="plan-row-{{ $plan->id }}">
                                <td>
                                    @if ($plan->package_image)
                                        <img src="/storage/{{ $plan->package_image }}" style="width: 50px; height: 50px; border: 1px solid #c2c2c2; border-radius: 50%;">
                                    @else
                                        <img src="{{ asset('noimg.png') }}" style="width: 50px; height: 50px; border: 1px solid #c2c2c2; border-radius: 50%;">
                                    @endif
                                </td>
                                <td>
                                    <p class="m-0 font-weight-bold">{{ $plan->plan_name }}</p>
                                    <small class="text-muted">{{ $plan->class_name }}</small>
                                </td>
                                <td>
                                    @if($plan->is_featured)
                                        <button wire:click="toggleFeatured({{ $plan->id }})" class="btn btn-sm btn-warning">UnFeatured</button>
                                    @else
                                        <button wire:click="toggleFeatured({{ $plan->id }})" class="btn btn-sm btn-primary">Featured</button>
                                    @endif
                                </td>
                                <td>
                                    {{ $plan->my_institute_name ?? 'Test and Notes' }}
                                </td>
                                <td>
                                    <button wire:click="showDetails({{ $plan->id }})" class="btn btn-sm btn-primary">View</button>
                                </td>
                                <td>
                                    {{ $plan->duration + $plan->free_duration }} days
                                </td>
                                <td>
                                    @if($plan->package_category === 'Free')
                                        <span class="text-success font-weight-bold">Free</span>
                                    @else
                                        <span class="text-purple font-weight-bold" style="color: #A020F0;">Paid<br>{{ $plan->final_fees }} &#8377;</span>
                                    @endif
                                </td>
                                <td>
                                    @if($plan->status == 1)
                                        <span class="text-success font-weight-bold" style="cursor: pointer;" wire:click="toggleStatus({{ $plan->id }})">Active</span>
                                    @else
                                        <span class="text-danger font-weight-bold" style="cursor: pointer;" wire:click="toggleStatus({{ $plan->id }})">Deactive</span>
                                    @endif
                                </td>
                                <td>
                                    @if($plan->is_mobile == 1)
                                        <button wire:click="toggleMobile({{ $plan->id }})" class="btn btn-sm btn-warning">Yes</button>
                                    @else
                                        <button wire:click="toggleMobile({{ $plan->id }})" class="btn btn-sm btn-primary">No</button>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $expire_date = $plan->expire_date;
                                        $current_date = date('Y-m-d');
                                    @endphp
                                    @if($expire_date)
                                        @php
                                            $is_expired = $expire_date < $current_date;
                                            $color = $is_expired ? '#FF0000' : '#198754';
                                            $date_text = date('d-M-Y', strtotime($expire_date));
                                        @endphp
                                        <p style="color: {{ $color }}; font-weight: bold; font-size: 11px; margin: 0 0 4px 0; text-align: left;">
                                            {{ $date_text }}
                                        </p>
                                    @else
                                        <p style="color: #6c757d; font-weight: bold; font-size: 11px; margin: 0 0 4px 0; text-align: left;">
                                            N/A
                                        </p>
                                    @endif

                                    <div class="d-flex align-items-center justify-content-start gap-1" style="margin-top: 4px;">
                                        <select class="form-select form-select-sm" style="width: 45px; height: 22px; font-size: 10px; padding: 0 2px;" wire:model="extensionAmounts.{{ $plan->id }}">
                                            @for($i = 1; $i <= 30; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                        <button wire:click="extendExpiry({{ $plan->id }}, 'W')" class="btn btn-xs btn-outline-danger" style="padding: 1px 3px; font-size: 9px; height: 22px; line-height: 1; font-weight: bold;">W</button>
                                        <button wire:click="extendExpiry({{ $plan->id }}, 'M')" class="btn btn-xs btn-outline-danger" style="padding: 1px 3px; font-size: 9px; height: 22px; line-height: 1; font-weight: bold;">M</button>
                                        <button wire:click="extendExpiry({{ $plan->id }}, 'Y')" class="btn btn-xs btn-outline-danger" style="padding: 1px 3px; font-size: 9px; height: 22px; line-height: 1; font-weight: bold;">Y</button>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('administrator.plan_view', [$plan->id]) }}" title="Edit Package" class="me-2"><i class="bi bi-pencil-square text-success fs-5"></i></a>
                                    <a href="javascript:void(0);" wire:click="toggleStatus({{ $plan->id }})" title="Active/Deactive Package"><i class="bi bi-trash2-fill text-danger fs-5"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center py-4">No packages found matching search criteria.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer d-flex justify-content-center">
                {{ $plans->links() }}
            </div>
        </div>
    </div>

    <!-- Package Details Modal (Reactive Pure Livewire) -->
    @if($showDetailsModal)
        <div class="modal show d-block" style="background: rgba(0, 0, 0, 0.5);" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">Package Details: {{ $selectedPlanName }}</h4>
                        <button type="button" class="btn-close" wire:click="closeDetailsModal"></button>
                    </div>
                    <div class="modal-body" style="max-height: 60vh; overflow-y: auto;">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Test Name</th>
                                    <th>Study Notes</th>
                                    <th>Video/ Youtube Class</th>
                                    <th>Current Affairs</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $maxCount = max(count($selectedTests), count($selectedNotes), count($selectedVideos), count($selectedGK));
                                @endphp
                                @if($maxCount > 0)
                                    @for($i = 0; $i < $maxCount; $i++)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $selectedTests[$i] ?? 'comingsoon' }}</td>
                                            <td>{{ $selectedNotes[$i] ?? 'comingsoon' }}</td>
                                            <td>{{ $selectedVideos[$i] ?? 'comingsoon' }}</td>
                                            <td>{{ $selectedGK[$i] ?? 'comingsoon' }}</td>
                                        </tr>
                                    @endfor
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">This package does not contain any resources yet.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeDetailsModal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Banner Upload Modal -->
    @if($showUploadModal)
        <div class="modal show d-block" style="background: rgba(0, 0, 0, 0.5);" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form wire:submit.prevent="uploadBanner">
                        <div class="modal-header">
                            <h5 class="modal-title font-weight-bold">Upload Banner for: {{ $selectedPlanName }}</h5>
                            <button type="button" class="btn-close" wire:click="closeUploadModal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-warning mb-3">
                                <i class="bi bi-exclamation-triangle-fill"></i> This package cannot be enabled for mobile without a banner. Please upload one below.
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Select Banner Image</label>
                                <input type="file" class="form-control" wire:model="bannerFile" accept="image/*">
                                @error('bannerFile') <span class="text-danger small d-block mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div wire:loading wire:target="bannerFile" class="text-info small mb-2">
                                <div class="spinner-border spinner-border-sm" role="status"></div> Uploading temporary file...
                            </div>

                            @if ($bannerFile)
                                <div class="mt-2 text-center">
                                    <p class="small text-muted mb-1">Preview:</p>
                                    <img src="{{ $bannerFile->temporaryUrl() }}" style="max-width: 100%; max-height: 200px; border: 1px solid #ccc; border-radius: 4px;">
                                </div>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeUploadModal">Cancel</button>
                            <button type="submit" class="btn btn-success" wire:loading.attr="disabled" wire:target="bannerFile">
                                <span wire:loading wire:target="uploadBanner" class="spinner-border spinner-border-sm" role="status"></span>
                                Upload & Enable
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
