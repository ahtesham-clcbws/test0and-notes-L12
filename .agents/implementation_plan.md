# Mobile Package Details & Enrollment Flow

Implement a premium package details view in the mobile app. When a student clicks a package, it shows detailed information with admin-selected counts first. If they are not enrolled, a checkout/enrollment button is shown. Once they pay or enroll, the actual package contents (Tests, Videos, Notes, GK) are loaded and displayed.

## User Review Required
> [!IMPORTANT]
> - **Razorpay Checkout Integration**: The checkout logic will be ported from `packages.tsx` directly into `package-view.tsx`.
> - **Enrollment Checks**: The backend API `getPackageDetails` will be updated to check `Gn_PackageTransaction` for active subscriptions.

## Proposed Changes

### Backend API Component

#### [MODIFY] [APIController.php](file:///mnt/WebliesNew/test-and-notes-upgrading/app/Http/Controllers/API/APIController.php)
- Update `getPackageDetails` method:
  - Check if the currently authenticated user (`Auth::id()`) has an active transaction in `Gn_PackageTransaction` for the requested package plan ID (`plan_status = 1` and `plan_end_date >= current_timestamp`).
  - Include the boolean `is_enrolled` in the returned JSON.

---

### Mobile App Component

#### [MODIFY] [packages.tsx](file:///mnt/WebliesNew/test-and-notes-mobile-app/app/(student)/packages.tsx)
- Update `renderExploreItem` to navigate directly to `package-view` with `packageId` parameter instead of initiating Razorpay checkout directly on the list page. This ensures the user sees the information page first as requested.

#### [MODIFY] [package-view.tsx](file:///mnt/WebliesNew/test-and-notes-mobile-app/app/(student)/package-view.tsx)
- Add State variables for purchase/enrollment handling: `purchaseLoading`, `razorpayKey`, `isEnrolled`.
- In `fetchPackageDetails`, store the `is_enrolled` state returned by the updated API.
- Create an info view for non-enrolled users:
  - Display plan name and banner.
  - Display stats grid showing counts selected from the admin panel: `total_test` Tests, `total_video` Videos, `total_notes` Notes, `total_gk` GK.
  - Display description, validity period, and price.
  - Add an enrollment button: "UNLOCK NOW for ₹{final_fees}" or "ENROLL FOR FREE".
  - Implement the Razorpay checkout and free enrollment API integration.
- If the user is enrolled, render the existing full tab navigation and list views of the actual content.

## Verification Plan

### Automated Tests
- Run backend tests to verify package APIs:
  `php artisan test --filter=APIControllerTest`

### Manual Verification
- Launch Expo app and navigate to "Buy Premium Plans".
- Click a package. Confirm it shows the details screen with counts and purchase options instead of actual content.
- Click "Enroll" or "Unlock". Verify the payment/enrollment flow and check that it immediately transitions the page to show the full tabbed content upon success.
