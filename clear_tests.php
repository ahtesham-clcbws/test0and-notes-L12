<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "Deleting all Test responses...\n";
    $responsesDeleted = \App\Models\Gn_Test_Response::query()->delete();
    echo "Deleted $responsesDeleted responses.\n";

    echo "Deleting all Student Test Attempts...\n";
    $attemptsDeleted = \App\Models\Gn_StudentTestAttempt::query()->delete();
    echo "Deleted $attemptsDeleted attempts.\n";

    echo "\nAll conduct tests cleared successfully.\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
