<div>
    {{-- HEADER --}}
    <x-header title="Welcome back, {{ Auth::user()->name }}!" subtitle="Here is what's happening with your studies today." separator progress-indicator />

    {{-- STATS --}}
    <div class="grid gap-5 mb-8 lg:grid-cols-3">
        <x-stat
            title="Tests Attempted"
            value="{{ $stats['attempts'] }}"
            icon="o-pencil-square"
            tooltip="Total tests you have finished" />

        <x-stat
            title="Total Available"
            value="{{ $stats['total_tests'] }}"
            icon="o-book-open"
            description="Tests matching your class" />

        <x-stat
            title="Overall Progress"
            value="{{ $stats['progress'] }}%"
            icon="o-academic-cap"
            class="text-primary"
        >
            <x-slot:actions>
                <x-progress value="{{ $stats['progress'] }}" max="100" class="progress-primary h-2 w-24" />
            </x-slot:actions>
        </x-stat>
    </div>

    <div class="grid gap-8 lg:grid-cols-2">
        {{-- ACTIVE PLANS --}}
        <x-card title="My Active Plans" icon="o-credit-card" separator shadow>
            @if($activePlans->count() > 0)
                <x-list-item :item="$activePlans" no-separator no-hover>
                    @foreach($activePlans as $plan)
                        <x-slot:avatar>
                            <x-badge value="Active" class="badge-success" />
                        </x-slot:avatar>
                        <x-slot:value>
                            {{ $plan->plan->plan_name ?? 'Standard Plan' }}
                        </x-slot:value>
                        <x-slot:sub-value>
                            Expires: {{ \Carbon\Carbon::parse($plan->plan_expire_date)->format('M d, Y') }}
                        </x-slot:sub-value>
                        <x-slot:actions>
                            <x-button icon="o-eye" link="/student/myplan" class="btn-ghost btn-sm" />
                        </x-slot:actions>
                    @endforeach
                </x-list-item>
            @else
                <div class="flex flex-col items-center justify-center py-10 text-center">
                    <x-icon name="o-shopping-cart" class="w-12 h-12 mb-4 text-base-300" />
                    <p class="text-base-content/60">You don't have any active plans yet.</p>
                    <x-button label="Browse Plans" link="/student/myplan" class="mt-4 btn-primary btn-outline" />
                </div>
            @endif
        </x-card>

        {{-- QUICK ACTIONS --}}
        <x-card title="Quick Actions" icon="o-bolt" separator shadow>
            <div class="grid grid-cols-2 gap-4">
                <x-button label="Resume Last Test" icon="o-play" class="btn-primary" link="/student/exams" />
                <x-button label="View Results" icon="o-chart-bar" class="btn-secondary" link="/student/review" />
                <x-button label="Study Materials" icon="o-book-open" class="btn-accent" link="/student/material" />
                <x-button label="Profile Settings" icon="o-cog-6-tooth" link="/student/profile" />
            </div>
        </x-card>
    </div>
</div>
