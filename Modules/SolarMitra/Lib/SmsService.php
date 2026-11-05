<?php

namespace Modules\SolarMitra\Lib;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    public function send(string $mobile, string $message): bool
    {
        try {
            $params = $this->getSmsParams();

            $apiUrl = $params['api_url'] ?? '';
            unset($params['api_url']);

            $params['to'] = $mobile;
            $params['text'] = $message;

            if (empty($apiUrl)) {
                Log::error('SMS API URL is not configured');
                return false;
            }

            $response = Http::get($apiUrl, $params);
            $result = $response->json();

            if (isset($result['statusCode']) && $result['statusCode'] !== 200) {
                Log::error('SMS send error: ' . json_encode($result));
                return false;
            }

            return true;

        } catch (\Exception $e) {
            Log::error('SMS send failed: ' . $e->getMessage());
            return false;
        }
    }

    private function getSmsParams(): array
    {
        $params = [];
        $defaultFields = ['SMS_PARAM_API_URL', 'SMS_PARAM_USERNAME', 'SMS_PARAM_PASSWORD', 'SMS_PARAM_FROM'];

        foreach ($_ENV as $key => $value) {
            if (strpos($key, 'SMS_PARAM_') === 0) {
                $paramKey = in_array($key, $defaultFields) ? strtolower(str_replace('SMS_PARAM_', '', $key)) : substr($key, 10);
                $params[$paramKey] = $value;
            }
        }

        return $params;
    }
}