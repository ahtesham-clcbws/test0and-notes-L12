<div>
    <x-header title="Reset Password" subtitle="Update your security credentials" separator progress-indicator />

    <div class="max-w-md mx-auto mt-10">
        <x-card shadow class="border-t-4 border-primary">
            <x-form wire:submit="resetPassword">
                <div class="space-y-4">
                    <x-input 
                        label="New Password" 
                        wire:model="new_password" 
                        type="password" 
                        icon="o-key" 
                        placeholder="Enter your new password" 
                        inline 
                    />

                    <x-input 
                        label="Confirm Password" 
                        wire:model="confirm_password" 
                        type="password" 
                        icon="o-check-badge" 
                        placeholder="Confirm your new password" 
                        inline 
                    />
                </div>

                <x-slot:actions>
                    <x-button label="Update Password" type="submit" icon="o-paper-airplane" class="btn-primary w-full" spinner="resetPassword" />
                </x-slot:actions>
            </x-form>
        </x-card>

        <div class="mt-8 text-center text-sm text-base-content/60">
            <p>Make sure your password is at least 6 characters long for better security.</p>
        </div>
    </div>
</div>
