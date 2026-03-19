<div>
    <div class="row mb-3">
        <div class="col-md-6 pb-2 border-bottom">
            <h1 class="page-title text-uppercase font-weight-bold">
                <i class="fa fa-key mr-2"></i>OTP Management
            </h1>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card card-custom">
        <div class="card-header border-0 pb-0">
            <div class="row align-items-center w-100">
                <div class="col-lg-4 col-xl-4">
                    <div class="input-icon">
                        <input type="text" 
                               class="form-control" 
                               placeholder="Search Credential or OTP..." 
                               wire:model.live.debounce.300ms="search">
                        <span><i class="flaticon2-search-1 text-muted"></i></span>
                    </div>
                </div>
                <div class="col-lg-8 col-xl-8 text-right">
                    <button wire:click="clearExpired" class="btn btn-warning font-weight-bold">
                        <i class="fa fa-trash"></i> Clear Expired OTPs
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-head-custom table-vertical-center">
                    <thead>
                        <tr class="text-uppercase">
                            <th>Type</th>
                            <th>Mobile / Email</th>
                            <th>OTP Code</th>
                            <th>Generated At</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($otps as $otp)
                            <tr>
                                <td>
                                    <span class="label label-lg label-light-primary label-inline font-weight-bold">
                                        {{ ucfirst($otp->type) }}
                                    </span>
                                </td>
                                <td><strong>{{ $otp->credential }}</strong></td>
                                <td><span class="text-danger font-weight-bolder">{{ $otp->otp }}</span></td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="text-dark-75 font-weight-bolder">{{ $otp->created_at->format('d M, Y') }}</span>
                                        <span class="text-muted font-weight-bold">{{ $otp->created_at->format('h:i A') }}</span>
                                    </div>
                                </td>
                                <td class="text-right">
                                    <button wire:click="deleteOtp({{ $otp->id }})" 
                                            wire:confirm="Are you sure you want to delete this OTP?"
                                            class="btn btn-icon btn-light btn-hover-danger btn-sm">
                                        <span class="svg-icon svg-icon-md svg-icon-danger">
                                            <!-- SVG Trash Icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"/>
                                                    <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"/>
                                                    <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"/>
                                                </g>
                                            </svg>
                                        </span>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted font-weight-bolder py-5">
                                    No OTP records found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $otps->links() }}
            </div>
        </div>
    </div>
</div>
