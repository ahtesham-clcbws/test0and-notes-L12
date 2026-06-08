<?php

// Boot Laravel application
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Http;

echo "=== Fetching 10 Active Students with password 'Aa123456' ===\n";

$allStudents = User::where('roles', 'student')
    ->where('status', 'active')
    ->whereNotNull('email')
    ->whereNotNull('mobile')
    ->get();

$students = collect();
foreach ($allStudents as $student) {
    if (Hash::check('Aa123456', $student->password)) {
        $students->push($student);
        if ($students->count() >= 10) {
            break;
        }
    }
}

echo 'Found '.$students->count()." active students with password 'Aa123456'.\n";

$testPassword = 'Aa123456';
$baseUrl = 'http://192.168.0.15:8000/api';
$successCount = 0;

foreach ($students as $index => $student) {
    $i = $index + 1;
    echo "\n[{$i}/10] Testing Student: {$student->name} (ID: {$student->id})\n";
    echo "    Email:  {$student->email}\n";
    echo "    Mobile: {$student->mobile}\n";

    // 1. Test Login via Mobile Number
    $mobileResponse = Http::post("{$baseUrl}/studentLogin", [
        'mobile' => $student->mobile,
        'password' => $testPassword,
        'fcm_token' => 'dummy_fcm',
    ]);

    // 2. Test Login via exact Email
    $emailResponse = Http::post("{$baseUrl}/studentLogin", [
        'mobile' => $student->email,
        'password' => $testPassword,
        'fcm_token' => 'dummy_fcm',
    ]);

    // 3. Test Login via case-insensitive Email
    $mixedEmail = strtoupper($student->email);
    $mixedEmailResponse = Http::post("{$baseUrl}/studentLogin", [
        'mobile' => $mixedEmail,
        'password' => $testPassword,
        'fcm_token' => 'dummy_fcm',
    ]);

    // Verify responses
    $mobileOk = $mobileResponse->successful() && isset($mobileResponse->json()['status']) && $mobileResponse->json()['status'] === 1;
    $emailOk = $emailResponse->successful() && isset($emailResponse->json()['status']) && $emailResponse->json()['status'] === 1;
    $mixedEmailOk = $mixedEmailResponse->successful() && isset($mixedEmailResponse->json()['status']) && $mixedEmailResponse->json()['status'] === 1;

    if ($mobileOk && $emailOk && $mixedEmailOk) {
        echo "    ✅ Mobile Login: SUCCESS\n";
        echo "    ✅ Email Login (exact): SUCCESS\n";
        echo "    ✅ Email Login (case-insensitive): SUCCESS\n";
        $successCount++;
    } else {
        echo "    ❌ LOGIN FAILURES DETECTED:\n";
        if (! $mobileOk) {
            echo '       Mobile Login: '.$mobileResponse->body()."\n";
        }
        if (! $emailOk) {
            echo '       Email Login: '.$emailResponse->body()."\n";
        }
        if (! $mixedEmailOk) {
            echo '       Case-insensitive Login: '.$mixedEmailResponse->body()."\n";
        }
    }
}

echo "\n=== Verification Summary: {$successCount}/10 Students Checked Successfully ===\n";
if ($successCount === 10) {
    echo "🎉 All 10 students logged in successfully with all variations!\n";
    exit(0);
} else {
    echo "❌ Some student logins failed.\n";
    exit(1);
}
