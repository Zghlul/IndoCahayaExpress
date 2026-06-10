<?php

namespace App\Services;

use SoapClient;
use SoapFault;
use Illuminate\Support\Facades\Log;

class AramexService
{
    protected $wsdl;
    protected $credentials;

    public function __construct()
    {
        $env = env('ARAMEX_ENV', 'test');
        
        if ($env == 'test') {
            $this->wsdl = 'https://ws.dev.aramex.net/ShippingAPI.V2/Tracking/Service_1_0.svc?wsdl';
            $this->credentials = [
                'UserName' => env('ARAMEX_TEST_USERNAME', 'testingapi@aramex.com'),
                'Password' => env('ARAMEX_TEST_PASSWORD', 'R123456789$r'),
                'Version'  => 'v1.0',
                'AccountNumber' => env('ARAMEX_TEST_ACCOUNT_NUMBER', '20016'),
                'AccountPin'    => env('ARAMEX_TEST_ACCOUNT_PIN', '331421'),
                'AccountEntity' => env('ARAMEX_TEST_ACCOUNT_ENTITY', 'AMM'),
                'AccountCountryCode' => env('ARAMEX_TEST_ACCOUNT_COUNTRY', 'JO'),
            ];
        } else {
            $this->wsdl = 'https://ws.aramex.net/ShippingAPI.V2/Tracking/Service_1_0.svc?wsdl';
            $this->credentials = [
                'UserName' => env('ARAMEX_LIVE_USERNAME', ''),
                'Password' => env('ARAMEX_LIVE_PASSWORD', ''),
                'Version'  => 'v1.0',
                'AccountNumber' => env('ARAMEX_LIVE_ACCOUNT_NUMBER', ''),
                'AccountPin'    => env('ARAMEX_LIVE_ACCOUNT_PIN', ''),
                'AccountEntity' => env('ARAMEX_LIVE_ACCOUNT_ENTITY', ''),
                'AccountCountryCode' => env('ARAMEX_LIVE_ACCOUNT_COUNTRY', ''),
            ];
        }

        // Log credentials for debugging (remove in production)
        Log::info('Aramex Credentials loaded', [
            'env' => $env,
            'username' => $this->credentials['UserName'],
            'account_number' => $this->credentials['AccountNumber'],
            'entity' => $this->credentials['AccountEntity'],
            'country' => $this->credentials['AccountCountryCode'],
        ]);
    }

    public function track($trackingNumber)
    {
        try {
            if (empty($this->credentials['UserName']) || empty($this->credentials['Password'])) {
                Log::error('Kredensial Aramex kosong');
                return ['error' => 'Kredensial kosong'];
            }

            $options = [
                'trace' => true,
                'exceptions' => true,
                'cache_wsdl' => WSDL_CACHE_NONE,
                'soap_version' => SOAP_1_1,
                'stream_context' => stream_context_create([
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    ]
                ])
            ];

            $client = new SoapClient($this->wsdl, $options);

            $request = [
                'ClientInfo' => $this->credentials,
                'Transaction' => ['Reference1' => 'Track Shipment'],
                'TrackingNumbers' => [$trackingNumber]
            ];

            $response = $client->TrackShipments($request);
            Log::info('Aramex response', ['response' => json_encode($response)]);

            if (isset($response->HasErrors) && $response->HasErrors == true) {
                $errorMsg = $response->Notifications->Notification->Message ?? 'Unknown error';
                Log::error('Aramex error: ' . $errorMsg);
                return ['error' => $errorMsg];
            }

            // Parse tracking results
            if (isset($response->TrackingResults)) {
                $results = $response->TrackingResults;
                $trackResult = null;
                if (isset($results->KeyValueOfstringArrayOfTrackingResultmEpkDpzF->Value->TrackingResult)) {
                    $trackResult = $results->KeyValueOfstringArrayOfTrackingResultmEpkDpzF->Value->TrackingResult[0];
                } elseif (isset($results->TrackingResult)) {
                    $trackResult = $results->TrackingResult[0];
                }
                if ($trackResult) {
                    return [
                        'found' => true,
                        'tracking_number' => $trackingNumber,
                        'status' => $this->mapStatus($trackResult->UpdateDescription ?? 'Pending'),
                        'location' => $trackResult->UpdateLocation ?? 'Unknown',
                        'service' => $trackResult->WaybillType ?? '-',
                        'weight' => $trackResult->ActualWeight ?? 0,
                    ];
                }
            }
            return ['found' => false];
        } catch (SoapFault $e) {
            Log::error('SOAP Fault: ' . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

    private function mapStatus($status)
    {
        $map = [
            'Pending' => 'pending',
            'In Transit' => 'processing',
            'Shipped' => 'shipped',
            'Delivered' => 'done',
            'Cancelled' => 'cancelled'
        ];
        return $map[$status] ?? 'pending';
    }
}