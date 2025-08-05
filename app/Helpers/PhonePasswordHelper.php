<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Crypt;

class PhonePasswordHelper
{
    /**
     * Encrypt the phone number
     * 
     * @param string $phoneNumber
     * @return string
     */
    public static function encryptPhoneNumber(string $phoneNumber): string
    {
        return Crypt::encryptString($phoneNumber);
    }

    /**
     * Decrypt the encrypted data to get the original phone number
     * 
     * @param string $encryptedPassword
     * @return string
     */
    public static function decryptPhoneNumber(string $encryptedPassword): ?string
    {
        try {
            return Crypt::decryptString($encryptedPassword);
        } catch (\Exception $e) {
            return null;
        }
    }
}
