<div>
    <!-- ============================ Page Title Start================================== -->
    <section class="page-title gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="breadcrumbs-wrap">
                        <h1 class="breadcrumb-title">Request Account Deletion</h1>
                        <nav class="transparent">
                            <ol class="breadcrumb p-0">
                                <li class="breadcrumb-item"><a href="/">Home</a></li>
                                <li class="breadcrumb-item active theme-cl" aria-current="page">Account Deletion</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ============================ Page Title End ================================== -->

    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-8 col-md-12">
                    <div class="border p-4 rounded bg-white shadow-sm">
                        <div class="form-group mb-4">
                            <h4>Request Deletion of Your Account</h4>
                            <span class="text-muted">Enter your email or phone number to verify your account and submit a deletion request. You will be able to cancel this request from your dashboard within 72 hours.</span>
                        </div>

                        @error('verification')
                            <div class="alert alert-danger mb-4" role="alert">
                                {{ $message }}
                            </div>
                        @enderror

                        <div class="form-group mb-3">
                            <label class="form-label font-weight-bold">Email Address</label>
                            <input type="email" class="form-control" placeholder="Enter your email address" wire:model.defer="email" {{ $isVerified ? 'disabled' : '' }} />
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold">Mobile/Phone Number</label>
                            <input type="text" class="form-control" placeholder="Enter your mobile number" wire:model.defer="mobile" {{ $isVerified ? 'disabled' : '' }} />
                        </div>

                        @if(!$isVerified)
                            <div class="form-group">
                                <button type="button" class="btn btn-theme btn-md w-100" style="background-color: var(--primary-color, #da0b0b); color: white;" wire:click="verifyUser">
                                    Verify Student Account
                                </button>
                            </div>
                        @else
                            <div class="alert alert-success mb-4">
                                <i class="ti-check-box mr-2"></i> Account Verified! Please select deletion options below.
                            </div>

                            <div class="form-group mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="deleteAllData" wire:model="delete_all_data">
                                    <label class="form-check-label font-weight-bold text-danger" for="deleteAllData">
                                        Delete all my data (Completely delete and erase all test attempts, profile records, and details permanently instead of soft-deleting).
                                    </label>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="backupData" wire:model="backup_data">
                                    <label class="form-check-label font-weight-bold" for="backupData">
                                        Backup my data and send to my email before deletion (if email address is linked).
                                    </label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <button type="button" class="btn btn-outline-secondary w-100" wire:click="$set('isVerified', false)">
                                        Reset Credentials
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button type="button" class="btn btn-danger w-100" wire:click="submitRequest">
                                        Submit Deletion Request
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
