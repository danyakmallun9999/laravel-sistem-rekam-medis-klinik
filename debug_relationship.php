<?php

use App\Models\Appointment;
use App\Models\Queue;

require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Get the most recent appointment
$appointment = Appointment::latest()->first();

if ($appointment) {
    echo "Appointment ID: " . $appointment->id . "\n";
    echo "Status: " . $appointment->status . "\n";
    
    if ($appointment->queue) {
        echo "Queue Found!\n";
        echo "Queue ID: " . $appointment->queue->id . "\n";
        echo "Queue Status: " . $appointment->queue->status . "\n";
    } else {
        echo "Queue NOT Found via relationship.\n";
        // Try to find manually
        $queue = Queue::where('appointment_id', $appointment->id)->first();
        if ($queue) {
            echo "Queue Found manually (relationship broken?)\n";
        } else {
            echo "Queue record does not exist for this appointment.\n";
        }
    }
} else {
    echo "No appointments found.\n";
}
