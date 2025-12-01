<?php

use App\Models\Appointment;
use App\Models\Queue;

require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$appointment = Appointment::find(13); // The one from previous debug
if ($appointment) {
    echo "Current Appt Status: " . $appointment->status . "\n";
    if ($appointment->queue) {
        echo "Current Queue Status: " . $appointment->queue->status . "\n";
        
        echo "Attempting update to 'waiting_screening'...\n";
        $appointment->queue->update(['status' => 'waiting_screening']);
        
        // Reload
        $queue = Queue::find($appointment->queue->id);
        echo "New Queue Status: " . $queue->status . "\n";
    }
}
