<?php

namespace App\Livewire\Admin\Settings;

use App\Mail\AccountBackupMail;
use App\Models\AccountDeletionRequest;
use App\Models\TestAttempt;
use App\Models\TestAttemptAnswer;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('Layouts.admin')]
class AccountDeletionRequests extends Component
{
    use WithPagination;

    public $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function completeRequest($id)
    {
        $request = AccountDeletionRequest::find($id);

        if (! $request) {
            $this->js("error('Request not found.')");

            return;
        }

        if ($request->status !== 'pending') {
            $this->js("error('Request is already processed or cancelled.')");

            return;
        }

        // Verify 73 hours gate
        $earliestExecutionTime = $request->created_at->addHours(73);
        if (now()->lessThan($earliestExecutionTime)) {
            $diff = now()->diff($earliestExecutionTime);
            $remaining = sprintf('%02d hours and %02d minutes', ($diff->days * 24) + $diff->h, $diff->i);
            $this->js("error('Cannot proceed. The admin must wait at least 73 hours. Remaining: {$remaining}.')");

            return;
        }

        // Find user
        $query = User::query()->where('roles', 'student');
        if (! empty($request->email) && ! empty($request->mobile)) {
            $query->where(function ($q) use ($request) {
                $q->where('email', $request->email)
                    ->orWhere('mobile', $request->mobile);
            });
        } elseif (! empty($request->email)) {
            $query->where('email', $request->email);
        } else {
            $query->where('mobile', $request->mobile);
        }

        $user = $query->first();

        if ($user) {
            // Send backup if requested
            if ($request->backup_data && ! empty($user->email)) {
                $backupData = [
                    'profile' => [
                        'name' => $user->name,
                        'username' => $user->username,
                        'email' => $user->email,
                        'mobile' => $user->mobile,
                        'created_at' => $user->created_at?->toDateTimeString(),
                        'details' => $user->user_details ? [
                            'city' => $user->user_details->city,
                            'state' => $user->user_details->state,
                            'dob' => $user->user_details->dob,
                        ] : null,
                    ],
                    'test_attempts' => TestAttempt::where('student_id', $user->id)
                        ->with(['test', 'answers.question'])
                        ->get()
                        ->map(fn ($attempt) => [
                            'test_name' => $attempt->test?->name,
                            'attempt_number' => $attempt->test_attempt,
                            'status' => $attempt->status,
                            'submitted_at' => $attempt->submitted_at?->toDateTimeString(),
                            'answers' => $attempt->answers->map(fn ($ans) => [
                                'question' => $ans->question?->question,
                                'user_answer' => $ans->answer,
                            ])->all(),
                        ])->all(),
                ];

                try {
                    Mail::to($user->email)->send(new AccountBackupMail($backupData));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Error sending backup email: '.$e->getMessage());
                }
            }

            // Perform deletion
            if ($request->delete_all_data) {
                // Force delete
                $attempts = TestAttempt::where('student_id', $user->id)->get();
                foreach ($attempts as $attempt) {
                    TestAttemptAnswer::where('test_attempt_id', $attempt->id)->delete();
                    $attempt->forceDelete();
                }

                if ($user->user_details) {
                    $user->user_details->delete();
                }

                $user->forceDelete();
            } else {
                // Soft delete
                $user->delete();
            }
        }

        $request->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        $this->js("success('Account deletion request completed successfully.')");
    }

    public function render()
    {
        $requests = AccountDeletionRequest::query()
            ->when($this->search, function ($query) {
                $query->where('email', 'like', "%{$this->search}%")
                    ->orWhere('mobile', 'like', "%{$this->search}%")
                    ->orWhere('status', 'like', "%{$this->search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('livewire.admin.settings.account-deletion-requests', [
            'requests' => $requests,
        ]);
    }
}
