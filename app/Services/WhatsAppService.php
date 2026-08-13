<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected string $apiKey;
    protected string $apiUrl;
    protected string $userName;

    public function __construct()
    {
        $this->apiKey = config('services.whatsapp.api_key', env('WHATSAPP_API_KEY', '<YOUR_API_KEY>'));
        $this->apiUrl = config('services.whatsapp.api_url', 'https://backend.api-wa.co/campaign/mcware/api/v2');
        $this->userName = config('services.whatsapp.user_name', 'BSWML - BENGALURU SOLID WASTE MANAGEMENT LIMITED');
    }

    /**
     * Send generic WhatsApp campaign message using HTTP client.
     */
    public function sendCampaign(string $campaignName, string $destination, array $templateParams): bool
    {
        // Sanitize destination phone number (remove +, spaces, dashes)
        $cleanDestination = preg_replace('/[^0-9]/', '', $destination);
        if (strlen($cleanDestination) === 10) {
            $cleanDestination = '91' . $cleanDestination; // Add 91 country code if 10 digits
        }

        $payload = [
            'apiKey' => $this->apiKey,
            'campaignName' => $campaignName,
            'destination' => $cleanDestination,
            'userName' => $this->userName,
            'templateParams' => array_map('strval', $templateParams),
            'source' => 'new-landing-page form',
            'media' => (object) [],
            'buttons' => [],
            'carouselCards' => [],
            'location' => (object) [],
            'attributes' => (object) [],
            'paramsFallbackValue' => [
                'FirstName' => 'user'
            ]
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl, $payload);

            if ($response->successful()) {
                Log::info("WhatsApp message sent successfully to {$cleanDestination} [Campaign: {$campaignName}]");
                return true;
            }

            Log::error("WhatsApp API Error [Campaign: {$campaignName}]: " . $response->body());
            return false;
        } catch (\Throwable $e) {
            Log::error("WhatsApp Exception [Campaign: {$campaignName}]: " . $e->getMessage());
            return false;
        }
    }

    /**
     * 1. Send Request Registration Confirmation to Citizen
     */
    public function sendRegistrationConfirmation(string $destination, string $userName, string $requestId): bool
    {
        return $this->sendCampaign(
            'Dclutter registration confirmation',
            $destination,
            [$userName, $requestId]
        );
    }

    /**
     * 2. Send Vehicle Assignment Notification to Driver / Vehicle Owner
     */
    public function sendVehicleAssignmentToDriver(string $destination, string $driverName, string $vehicleNo, string $requestId, string $location): bool
    {
        return $this->sendCampaign(
            'vehicle asignment',
            $destination,
            [$driverName, $vehicleNo, $requestId, $location]
        );
    }

    /**
     * 3. Send Vehicle & Driver Assignment Confirmation to Citizen User
     */
    public function sendVehicleAssignmentToUser(string $destination, string $userName, string $requestId, string $vehicleNo, string $driverName, string $phoneNumber): bool
    {
        return $this->sendCampaign(
            'vehicle assignment confirmation to user',
            $destination,
            [$userName, $requestId, $vehicleNo, $driverName, $phoneNumber]
        );
    }

    /**
     * 4. Send Waste Collection Completed Notification to Citizen User
     */
    public function sendCollectionCompletedToUser(string $destination, string $userName, string $requestId): bool
    {
        return $this->sendCampaign(
            'user pickedup message',
            $destination,
            [$userName, $requestId]
        );
    }

    /**
     * 5. Send AAWMS Daily Waste Collection Status Report
     */
    public function sendDailyStatusReport(string $destination, array $reportParams): bool
    {
        return $this->sendCampaign(
            'AAWMS daily report',
            $destination,
            $reportParams
        );
    }
}
