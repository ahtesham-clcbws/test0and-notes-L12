<div>
    <div class="row mb-3">
        <div class="col-md-6 pb-2 border-bottom">
            <h1 class="page-title text-uppercase font-weight-bold">
                <i class="fa fa-user-slash mr-2"></i>Account Deletions
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
                               placeholder="Search Email/Mobile..." 
                               wire:model.live.debounce.300ms="search">
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-head-custom table-vertical-center">
                    <thead>
                        <tr class="text-uppercase">
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Delete All Data?</th>
                            <th>Backup Requested?</th>
                            <th>Requested At</th>
                            <th>Status</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($requests as $req)
                            <tr>
                                <td><strong>{{ $req->email ?? '-' }}</strong></td>
                                <td><strong>{{ $req->mobile ?? '-' }}</strong></td>
                                <td>
                                    @if($req->delete_all_data)
                                        <span class="label label-lg label-light-danger label-inline font-weight-bold">Force Delete</span>
                                    @else
                                        <span class="label label-lg label-light-warning label-inline font-weight-bold">Soft Delete</span>
                                    @endif
                                </td>
                                <td>
                                    @if($req->backup_data)
                                        <span class="label label-lg label-light-info label-inline font-weight-bold">Yes</span>
                                    @else
                                        <span class="label label-lg label-light-dark label-inline font-weight-bold">No</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="text-dark-75 font-weight-bolder">{{ $req->created_at->format('d M, Y') }}</span>
                                        <span class="text-muted font-weight-bold">{{ $req->created_at->format('h:i A') }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($req->status === 'pending')
                                        <span class="label label-lg label-light-warning label-inline font-weight-bold">Pending</span>
                                    @elseif($req->status === 'cancelled')
                                        <span class="label label-lg label-light-danger label-inline font-weight-bold">Cancelled</span>
                                    @else
                                        <span class="label label-lg label-light-success label-inline font-weight-bold">Completed</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    @if($req->status === 'pending')
                                        @php
                                            $canExecute = $req->created_at->addHours(73)->isPast();
                                            $timeLeft = now()->diff($req->created_at->addHours(73));
                                            $hoursLeft = ($timeLeft->days * 24) + $timeLeft->h;
                                        @endphp

                                        @if($canExecute)
                                            <button wire:click="completeRequest({{ $req->id }})" 
                                                    wire:confirm="Are you sure you want to proceed with account deletion? This action is irreversible."
                                                    class="btn btn-danger btn-sm font-weight-bold">
                                                Delete Account Now
                                            </button>
                                        @else
                                            <button class="btn btn-secondary btn-sm font-weight-bold" disabled>
                                                Locked ({{ $hoursLeft }}h {{ $timeLeft->i }}m left)
                                            </button>
                                        @endif
                                    @elseif($req->status === 'cancelled')
                                        <span class="text-muted">Cancelled</span>
                                    @else
                                        <span class="text-success font-weight-bold">Completed</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted font-weight-bolder py-5">
                                    No account deletion requests found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $requests->links() }}
            </div>
        </div>
    </div>
</div>
