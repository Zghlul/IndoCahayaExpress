<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class AramexTrackingService
{
    protected $client;
    protected $accountNumber;
    protected $userName;
    protected $password;
    protected $pin;
    protected $version;
    protected $baseUrl;

    public function __construct()
    {
        $this->accountNumber = config('services.aramex.account_number');
        $this->userName      = config('services.aramex.username');
        $this->password      = config('services.aramex.password');
        $this->pin           = config('services.aramex.pin');
        $this->version       = config('services.aramex.version', 'v1.0');
        $this->baseUrl       = config('services.aramex.base_url', 'https://sandbox.aramex.com/api/');

        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers'  => [
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
            ],
            'timeout'  => 30,
        ]);
    }

    /**
     * Lacak resi ke API Aramex (Track Shipments)
     *
     * @param string $trackingNumber
     * @return object|null Data tracking dalam bentuk object atau null jika tidak ditemukan
     */
    public function track($trackingNumber)
    {
        try {
            $payload = [
                'ClientInfo' => [
                    'UserName'       => $this->userName,
                    'Password'       => $this->password,
                    'Version'        => $this->version,
                    'AccountNumber'  => $this->accountNumber,
                    'Pin'            => $this->pin,
                ],
                'Shipments' => [
                    [
                        'TrackingNumber' => $trackingNumber,
                    ],
                ],
            ];

            $response = $this->client->post('tracking/rest/tracking', [
                'json' => $payload,
            ]);

            $body = json_decode($response->getBody(), true);

            if (isset($body['TrackingResults'][0]['TrackingNumber'])) {
                $trackResult = $body['TrackingResults'][0];
                return $this->mapToShipmentFormat($trackResult, $trackingNumber);
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Aramex API Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Mapping response API ke format yang sama dengan model Shipment Anda
     *
     * @param array $trackResult
     * @param string $trackingNumber
     * @return object
     */
    private function mapToShipmentFormat($trackResult, $trackingNumber)
    {
        $status = $this->mapAramexStatus($trackResult['CurrentStatus']['Code'] ?? '');
        $service = $trackResult['Service'] ?? 'Aramex';
        $country = $trackResult['DestinationCountry'] ?? 'Indonesia';
        $weight = $trackResult['Weight'] ?? 0;
        $charge = $trackResult['TotalAmount'] ?? 0;
        $trackingDetails = $trackResult['TrackingDetails'] ?? [];

        return (object) [
            'tracking_number'   => $trackingNumber,
            'status_pengerjaan' => $status,
            'negara'            => $country,
            'country_name'      => $country,
            'service'           => $service,
            'berat_dibebankan'  => $weight,
            'charge_idr'        => $charge,
            'tracking_history'  => $trackingDetails,
        ];
    }

    /**
     * Mapping kode status Aramex ke status internal
     *
     * @param string $code
     * @return string
     */
    private function mapAramexStatus($code)
    {
        $map = [
            'DELIVERED'    => 'done',
            'SHIPPED'      => 'shipped',
            'IN_TRANSIT'   => 'processing',
            'CANCELLED'    => 'cancelled',
            'PENDING'      => 'pending',
            'ON_HOLD'      => 'pending',
            'RECEIVED'     => 'processing',
        ];
        return $map[$code] ?? 'pending';
    }
}