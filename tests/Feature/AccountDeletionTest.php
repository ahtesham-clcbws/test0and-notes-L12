<?php

namespace Tests\Feature;

use App\Livewire\Admin\Settings\AccountDeletionRequests;
use App\Livewire\Frontend\AccountDeletePage;
use App\Livewire\Student\Components\DeletionAlertTopbar;
use App\Models\AccountDeletionRequest;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class AccountDeletionTest extends TestCase
{
    protected $createdUsers = [];

    protected $createdRequests = [];

    protected function setUp(): void
    {
        parent::setUp();
        $this->createdUsers = [];
        $this->createdRequests = [];
    }

    protected function tearDown(): void
    {
        // Clean up created models
        foreach ($this->createdRequests as $reqId) {
            AccountDeletionRequest::where('id', $reqId)->delete();
        }
        foreach ($this->createdUsers as $userId) {
            User::where('id', $userId)->forceDelete();
        }
        parent::tearDown();
    }

    protected function createTestStudent(array $attributes = [])
    {
        $student = User::create(array_merge([
            'name' => 'John Doe',
            'username' => 'john_'.uniqid(),
            'email' => 'john_'.uniqid().'@example.com',
            'mobile' => '9876'.rand(100000, 999999),
            'roles' => 'student',
            'password' => bcrypt('password'),
        ], $attributes));

        $this->createdUsers[] = $student->id;

        return $student;
    }

    protected function createDeletionRequestForTest(array $attributes = [])
    {
        $request = AccountDeletionRequest::create(array_merge([
            'email' => 'john@example.com',
            'mobile' => '9876543210',
            'delete_all_data' => false,
            'backup_data' => false,
            'status' => 'pending',
        ], $attributes));

        $this->createdRequests[] = $request->id;

        return $request;
    }

    public function test_student_verification_succeeds_and_auto_populates()
    {
        $student = $this->createTestStudent([
            'email' => 'john_verify@example.com',
            'mobile' => '9876543210',
        ]);

        Livewire::test(AccountDeletePage::class)
            ->set('email', 'john_verify@example.com')
            ->call('verifyUser')
            ->assertSet('mobile', '9876543210')
            ->assertSet('isVerified', true);
    }

    public function test_student_verification_fails_if_not_found()
    {
        Livewire::test(AccountDeletePage::class)
            ->set('email', 'nonexistent_'.uniqid().'@example.com')
            ->call('verifyUser')
            ->assertHasErrors(['verification'])
            ->assertSet('isVerified', false);
    }

    public function test_submit_deletion_request_creates_db_record()
    {
        $student = $this->createTestStudent([
            'email' => 'john_submit@example.com',
            'mobile' => '9876543211',
        ]);

        $component = Livewire::test(AccountDeletePage::class)
            ->set('email', 'john_submit@example.com')
            ->call('verifyUser')
            ->set('delete_all_data', true)
            ->set('backup_data', true)
            ->call('submitRequest');

        $req = AccountDeletionRequest::where('email', 'john_submit@example.com')->first();
        if ($req) {
            $this->createdRequests[] = $req->id;
        }

        $this->assertNotNull($req);
        $this->assertTrue($req->delete_all_data);
        $this->assertTrue($req->backup_data);
        $this->assertEquals('pending', $req->status);
    }

    public function test_student_dashboard_topbar_shows_and_can_cancel_within_72_hours()
    {
        $student = $this->createTestStudent();
        $this->actingAs($student);

        $request = $this->createDeletionRequestForTest([
            'email' => $student->email,
            'mobile' => $student->mobile,
        ]);

        Livewire::test(DeletionAlertTopbar::class)
            ->assertSet('hasPendingRequest', true)
            ->call('cancelRequest');

        $this->assertEquals('cancelled', $request->fresh()->status);
    }

    public function test_admin_blocked_from_completing_request_before_73_hours()
    {
        $student = $this->createTestStudent();
        $request = $this->createDeletionRequestForTest([
            'email' => $student->email,
            'mobile' => $student->mobile,
        ]);

        Livewire::test(AccountDeletionRequests::class)
            ->call('completeRequest', $request->id);

        $this->assertEquals('pending', $request->fresh()->status);
    }

    public function test_admin_can_complete_request_after_73_hours()
    {
        $student = $this->createTestStudent();
        $request = $this->createDeletionRequestForTest([
            'email' => $student->email,
            'mobile' => $student->mobile,
        ]);

        // Travel back in time
        $request->created_at = now()->subHours(74);
        $request->save();

        Livewire::test(AccountDeletionRequests::class)
            ->call('completeRequest', $request->id);

        $this->assertEquals('completed', $request->fresh()->status);
        $this->assertSoftDeleted('users', ['id' => $student->id]);
    }
}
