<div class="py-6 px-4 md:px-8 max-w-2xl mx-auto">
    <x-header title="Your Feedback" subtitle="Help us improve your learning experience" separator shadow />

    @if (session()->has('success'))
        <x-alert icon="o-check-circle" class="bg-primary-50 border-primary-100 text-primary-700 mb-6 font-bold">
            {{ session('success') }}
        </x-alert>
    @endif

    <x-card class="shadow-sm border-gray-100">
        <x-form wire:submit="submit">
            <x-textarea 
                label="Share your thoughts" 
                wire:model="review_text" 
                placeholder="How was your experience using our platform? What can we do better?" 
                rows="6"
                hint="Maximum 1000 characters"
                class="font-medium bg-gray-50/50"
            />

            <div class="flex items-center justify-between mt-6">
                @if($review && $review->is_approved)
                    <x-badge value="Currently Approved" class="badge-success badge-sm font-bold opacity-80" />
                @elseif($review)
                    <x-badge value="Pending Approval" class="badge-warning badge-sm font-bold opacity-80" />
                @endif

                <x-button 
                    label="Submit Feedback" 
                    icon="o-paper-airplane" 
                    type="submit" 
                    class="btn-primary rounded-xl font-bold shadow-lg shadow-primary-100" 
                    wire:loading.attr="disabled"
                />
            </div>
        </x-form>
    </x-card>

    <div class="mt-8">
        <x-alert icon="o-light-bulb" class="bg-blue-50 border-blue-100 text-blue-700 text-xs font-bold leading-relaxed">
            Your feedback will be reviewed by our team before being featured on the dashboard or homepage.
        </x-alert>
    </div>
</div>
