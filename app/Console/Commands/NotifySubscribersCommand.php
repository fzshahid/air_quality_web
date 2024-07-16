<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AirQualityReading;
use App\Models\Subscriber;
use App\Http\Services\AirQualityReadingsService;
use App\Notifications\AqiAlertNotification;
use Illuminate\Support\Facades\Mail;

class NotifySubscribersCommand extends Command
{
    protected $signature = 'notify:subscribers';
    protected $description = 'Notify subscribers about the air quality every 5 minutes';

    protected $airQualityReadingsService;

    public function __construct(AirQualityReadingsService $airQualityReadingsService)
    {
        parent::__construct();
        $this->airQualityReadingsService = $airQualityReadingsService;
    }

    public function handle()
    {
        // Get the latest air quality reading
        $latestReading = AirQualityReading::latest()->first();

        if (!$latestReading) {
            $this->info('No air quality readings found.');
            return;
        }

        // Check ventilation need
        $ventilationData = $this->airQualityReadingsService->checkVentilationNeed($latestReading);

        if ($ventilationData['ventilation_needed']) {
            $messages = $ventilationData['messages'];
            $this->notifySubscribers($messages);
        } else {
            $this->info('No ventilation needed.');
        }
    }

    protected function notifySubscribers($messages)
    {
        // Get all subscribers
        $subscribers = Subscriber::all();

        $subject = 'Air Quality Alert';
        foreach ($subscribers as $subscriber) {
            $subscriber->notify(new AqiAlertNotification($subject, $messages));
        }

        $this->info('Subscribers notified successfully.');
    }

    protected function formatMessages($messages)
    {
        $formattedMessages = "Air Quality Alert:\n\n";
        foreach ($messages as $category => $message) {
            $formattedMessages .= $message . "\n";
        }
        return $formattedMessages;
    }
}
