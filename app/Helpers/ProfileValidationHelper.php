<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\CorporateEnquiry;

class ProfileValidationHelper
{
    /**
     * Check if email is unique across users and valid corporate enquiries.
     *
     * @param string $email
     * @param int|null $excludeUserId
     * @return bool
     */
    public static function isEmailUnique($email, $excludeUserId = null)
    {
        // Check in Users table
        $userQuery = User::where('email', $email);
        if ($excludeUserId) {
            $userQuery->where('id', '!=', $excludeUserId);
        }
        if ($userQuery->exists()) {
            return false;
        }

        // Check in CorporateEnquiry table (excluding rejected)
        $enquiryExists = CorporateEnquiry::where('email', $email)
            ->where('status', '!=', 'rejected')
            ->exists();

        if ($enquiryExists) {
            return false;
        }

        return true;
    }

    /**
     * Check if mobile is unique across users and valid corporate enquiries.
     *
     * @param string $mobile
     * @param int|null $excludeUserId
     * @return bool
     */
    public static function isMobileUnique($mobile, $excludeUserId = null)
    {
        // Check in Users table
        $userQuery = User::where('mobile', $mobile);
        if ($excludeUserId) {
            $userQuery->where('id', '!=', $excludeUserId);
        }
        if ($userQuery->exists()) {
            return false;
        }

        // Check in CorporateEnquiry table (excluding rejected)
        $enquiryExists = CorporateEnquiry::where('mobile', $mobile)
            ->where('status', '!=', 'rejected')
            ->exists();

        if ($enquiryExists) {
            return false;
        }

        return true;
    }
}
