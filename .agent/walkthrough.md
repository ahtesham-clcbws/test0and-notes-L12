# Walkthrough - Resolve Franchise Dashboard Count Discrepancy

I have resolved the discrepancy between the "New User Signup" count on the franchise dashboard and the actual list of users displayed when clicking the card.

## Changes Made

### 1. Dashboard Count Logic Update
- **File**: [DashboardController.php](file:///i:/test-and-notes-upgrading/app/Http/Controllers/Frontend/Franchise/DashboardController.php)
- **Change**: Removed the `'is_staff' => '0'` filter from the `$matchNew` array in the `index()` method.
- **Effect**: The dashboard card now counts all newly registered users (students and contributors) who are either 'unread' or 'inactive', aligning perfectly with the filter used in the `UserController`.

## Verification Results

### Manual Verification
- Navigated to the franchise dashboard and compared the "New User Signup" count with the actual user list.
- Confirmed that the count now includes all users regardless of their `is_staff` status, provided they match the other criteria (unread/inactive status, belongs to the correct franchise).
