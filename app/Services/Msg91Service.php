<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class Msg91Service
{
    protected $authKey;

    protected $senderId;

    protected $templateId;

    protected $dltTemplateId;

    /**
     * TRAI Approved Template for Test & Notes
     */
    const OTP_TEMPLATE = 'Dear user OTP for login/ signup to www.testandnotes.com portal is ##var## Valid for 10 minutes Do not share this OTP. Regards Test & Notes Management';

    public function __construct($authKey = null, $senderId = null, $templateId = null, $dltTemplateId = null)
    {
        $this->authKey = $authKey ?: config('services.msg91.auth_key');
        $this->senderId = $senderId ?: config('services.msg91.sender_id', 'TSTNTS');
        $this->templateId = $templateId ?: config('services.msg91.template_id');
        $this->dltTemplateId = $dltTemplateId ?: config('services.msg91.dlt_template_id', '1707177540051977802');
    }

    /**
     * Get the formatted OTP message based on the approved TRAI template.
     */
    public function getFormattedMessage($otp)
    {
        return str_replace('##var##', $otp, self::OTP_TEMPLATE);
    }

    /**
     * Send OTP via MSG91 Flow API
     */
    public function sendSms($numbers, $otp, $templateId = null)
    {
        if (empty($this->authKey)) {
            Log::error('MSG91 Auth Key is missing in config/services.php or .env');

            return false;
        }

        $activeTemplateId = $templateId ?: $this->templateId;
        $numberList = is_array($numbers) ? $numbers : explode(',', $numbers);

        foreach ($numberList as $number) {
            // Clean number to exactly 10 digits
            $rawNumber = preg_replace('/[^0-9]/', '', $number);
            $tenDigitNumber = (strlen($rawNumber) > 10) ? substr($rawNumber, -10) : $rawNumber;

            // Add country code for MSG91 API call
            $apiNumber = '91'.$tenDigitNumber;

            $payload = json_encode([
                'template_id' => (string) $activeTemplateId,
                'short_url' => '0',
                'realTimeResponse' => '1',
                'recipients' => [
                    [
                        'mobiles' => (string) $apiNumber,
                        'var' => (string) $otp,
                        'DLT_TE_ID' => (string) $this->dltTemplateId,
                    ],
                ],
            ]);

            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => 'https://control.msg91.com/api/v5/flow',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $payload,
                CURLOPT_HTTPHEADER => [
                    'accept: application/json',
                    'authkey: '.$this->authKey,
                    'content-type: application/json',
                ],
            ]);

            $responseBody = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($curlError) {
                Log::error('MSG91 cURL Error', ['error' => $curlError, 'number' => $apiNumber]);

                return false;
            }

            $body = json_decode($responseBody, true);
            $isError = ($httpCode >= 400) ||
                       (isset($body['type']) && $body['type'] === 'error') ||
                       (isset($body['status']) && $body['status'] === 'fail');

            echo "\n--- MSG91 DEBUG INFO ---\n";
            echo 'HTTP Status: '.$httpCode."\n";
            echo 'Response Body: '.$responseBody."\n";
            echo "------------------------\n";

            if ($isError) {
                Log::error('MSG91 API Error', [
                    'status' => $httpCode,
                    'body' => $responseBody,
                    'number' => $apiNumber,
                ]);

                return false;
            }
        }

        return true;
    }
}
