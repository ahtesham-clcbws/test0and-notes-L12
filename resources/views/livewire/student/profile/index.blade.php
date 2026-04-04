<div>
    <x-header title="Profile Settings" subtitle="Manage your account information and security." separator progress-indicator />

    <x-tabs selected="profile">
        {{-- PROFILE TAB --}}
        <x-tab name="profile" label="My Profile" icon="o-user">
            <x-form wire:submit="save">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-4">
                    {{-- LEFT COLUMN: Basic Info --}}
                    <div class="space-y-4">
                        <x-input label="Full Name" wire:model="name" icon="o-user-circle" />
                        
                        <x-select 
                            label="State" 
                            wire:model.live="state_id" 
                            :options="$states" 
                            placeholder="Select State" 
                            icon="o-map-pin" 
                        />
                        
                        <x-select 
                            label="City" 
                            wire:model="city_id" 
                            :options="$cities" 
                            placeholder="Select City" 
                            icon="o-map" 
                            :disabled="!$state_id"
                        />
                    </div>

                    {{-- RIGHT COLUMN: Photo Upload --}}
                    <div class="flex flex-col items-center justify-center p-6 border-2 border-dashed rounded-2xl bg-base-200/50">
                        <x-file wire:model="photo" accept="image/*" label="Update Photo" icon="o-camera">
                            <img src="{{ $photo ? $photo->temporaryUrl() : ($photo_url ? '/storage/'.$photo_url : asset('super/images/default-avatar.jpg')) }}" 
                                 class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg mb-4" />
                        </x-file>
                        <p class="text-xs text-base-content/60 mt-2">Optimal size: 400x400px (Max 1MB)</p>
                    </div>
                </div>

                <x-slot:actions>
                    <x-button label="Save Changes" type="submit" class="btn-primary" spinner="save" />
                </x-slot:actions>
            </x-form>
        </x-tab>

        {{-- CONTACT TAB --}}
        <x-tab name="contact" label="Contact Info" icon="o-envelope">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mt-4">
                {{-- EMAIL SECTION --}}
                <div class="space-y-4">
                    <h3 class="font-bold text-lg flex items-center gap-2">
                        <x-icon name="o-envelope" class="w-5 h-5" /> Change Email
                    </h3>
                    
                    <div class="flex gap-2 items-end">
                        <x-input label="New Email" wire:model="email" icon="o-at-symbol" class="flex-1" :disabled="$email_otp_sent" />
                        @if(!$email_otp_sent)
                            <x-button label="Get OTP" wire:click="sendEmailOtp" class="btn-primary" spinner="sendEmailOtp" />
                        @endif
                    </div>

                    @if($email_otp_sent)
                        <div class="p-4 bg-primary/5 rounded-xl border border-primary/20 space-y-4">
                            <x-input label="Enter Email OTP" wire:model="email_otp" placeholder="6-digit code" />
                            <div class="flex justify-between">
                                <x-button label="Cancel" wire:click="$set('email_otp_sent', false)" size="sm" variant="ghost" />
                                <x-button label="Verify & Update" wire:click="verifyEmail" class="btn-primary" size="sm" spinner="verifyEmail" />
                            </div>
                        </div>
                    @endif
                </div>

                {{-- MOBILE SECTION --}}
                <div class="space-y-4">
                    <h3 class="font-bold text-lg flex items-center gap-2">
                        <x-icon name="o-phone" class="w-5 h-5" /> Change Mobile
                    </h3>
                    
                    <div class="flex gap-2 items-end">
                        <x-input label="New Mobile" wire:model="mobile" icon="o-phone" class="flex-1" :disabled="$mobile_otp_sent" />
                        @if(!$mobile_otp_sent)
                            <x-button label="Get OTP" wire:click="sendMobileOtp" class="btn-primary" spinner="sendMobileOtp" />
                        @endif
                    </div>

                    @if($mobile_otp_sent)
                        <div class="p-4 bg-primary/5 rounded-xl border border-primary/20 space-y-4">
                            <x-input label="Enter Mobile OTP" wire:model="mobile_otp" placeholder="6-digit code" />
                            <div class="flex justify-between">
                                <x-button label="Cancel" wire:click="$set('mobile_otp_sent', false)" size="sm" variant="ghost" />
                                <x-button label="Verify & Update" wire:click="verifyMobile" class="btn-primary" size="sm" spinner="verifyMobile" />
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </x-tab>

        {{-- SECURITY TAB --}}
        <x-tab name="security" label="Security" icon="o-shield-check">
            <x-form wire:submit="updatePassword">
                <div class="max-w-xl space-y-4 mt-4">
                    <x-input label="Current Password" type="password" wire:model="current_password" icon="o-key" />
                    <x-input label="New Password" type="password" wire:model="password" icon="o-lock-closed" />
                    <x-input label="Confirm New Password" type="password" wire:model="password_confirmation" icon="o-check-circle" />
                </div>

                <x-slot:actions>
                    <x-button label="Change Password" type="submit" class="btn-primary" spinner="updatePassword" />
                </x-slot:actions>
            </x-form>
        </x-tab>
    </x-tabs>
</div>
