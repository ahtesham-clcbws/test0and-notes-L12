# Laravel Backlog

## Pending Tasks
- [ ] UI Audit: Finalize parity for all student profile/settings screens.
- [ ] End-to-End Testing on physical device.

## Completed Tasks
- [x] Implement Assessment Engine APIs (`getTests`, `getTestDetails`, `endTest`)
- [x] Implement Razorpay Order & Verification APIs
- [x] Restore Instructions page in Test Conduct flow
- [x] Fix Test Runner Timer flickering
- [x] Added `getHomepageData` endpoint
- [x] Fixed API route syntax
- [x] Refine `studentLogin` for mobile compatibility
- [x] Implement `studentSignup` for mobile
- [x] Implement Forgot Password / OTP APIs

# Session Sync - Momin Scholar Program

## Session Handoff - 2026-03-25 (Assessment Engine & Razorpay Integration)
- **Current State:** Successfully implemented live assessment APIs and Razorpay payment flow for Mobile.
- **Key Achievements:**
  - **Assessment APIs:** Built `getTests`, `getTestDetails`, and `endTest` endpoints in `APIController.php` to serve dynamic test data and process mobile submissions.
  - **Razorpay Integration:** Stabilized `createRazorpayOrder` and `verifyRazorpayPayment` with signature validation.
  - **Test Conduct UI Fix:** Restored Instructions page and resolved timer flicker issues in the Laravel side (previous request).
- **Next Steps:**
  - Audit UI parity for any remaining student screens.
  - Perform end-to-end user flow testing (Auth -> Premium -> Test).

## Session Handoff - 2026-03-18 (Mobile API & Admin OTP Feature Complete)
- **Current State:** Successfully built the foundational Auth API connections for the Mobile App.
- **Key Agreements & Achievements:**
  - **Admin OTP Manager:** Created `App\Livewire\Admin\Settings\OtpManager` and wired it into `routes/administrator.php` and the sidebar. Admins can now manage generated `otp_verifications`.
  - **Mobile Auth Store:** Integrated `zustand`, `axios`, and `expo-secure-store` for the React Native app.
  - **API Connections:** Bootstrapped the `login.tsx` and `signup.tsx` flows in the Mobile App to successfully request and verify OTPs against the Laravel API endpoints.
  - **Protected Routing:** Built a Guardian layout `app/(student)/_layout.tsx` to trap unauthorized users and implemented the `profile.tsx` skeleton hitting `/updateProfile`.
- **Next Steps:** 
  1. Complete mapping local UI forms in the app to real portal endpoints (specifically fetching user Packages and Tests).
  2. Map out and build `ApiController` endpoints for fetching user study materials and test results if they don't already exist.

## Session Handoff - 2026-03-17 (Mobile App Integration & OTP Planning)
- **Current State:** Designed an implementation plan for integrating the mobile app with the portal. The backend `otp_verifications` table and model were verified and confirmed for reuse.
- **Key Agreements:**
  - **OTP Management:** No new migrations. We will create a Livewire `OtpManager` connected to the sidebar Settings menu to read/delete from the `otp_verifications` table.
  - **API Development:** `AuthController` and `StudentController` endpoints have been mapped out for OTP login and data synchronization.
  - **Next Steps:** Proceed directly to mapping the API endpoints or creating the Livewire OTP manager. Plan is stored in `.agent/backlog.md` and central brain `implementation_plan.md`.

## Session Handoff - 2026-03-17 (Mobile App Integration & OTP Planning)
- **Current State:** Designed an implementation plan for integrating the mobile app with the portal. The backend `otp_verifications` table and model were verified and confirmed for reuse.
- **Key Agreements:**
  - **OTP Management:** No new migrations. We will create a Livewire `OtpManager` connected to the sidebar Settings menu to read/delete from the `otp_verifications` table.
  - **API Development:** `AuthController` and `StudentController` endpoints have been mapped out for OTP login and data synchronization.
  - **Next Steps:** Proceed directly to mapping the API endpoints or creating the Livewire OTP manager. Plan is stored in `.agent/backlog.md` and central brain `implementation_plan.md`.

## Session Handoff - 2026-03-17 (Student Dashboard Filtering)
- **Current State:** Fully implemented strict dashboard filtering based on Class/Group/Exam context with performance indexing.
- **Key Achievements:**
  - **Performance Optimization**: Created safe composite indexes for heavy lookup tables.
  - **Context Overrides**: Updated `StudymaterialController` and `StudentPlanController` to respect requested course parameters.
  - **Card Harmonization**: Fixed Dashboard counts to strictly match item lists inside categories.

## Session Handoff - 2026-03-17 (Livewire Test Module Overhaul)
- **Current State:** Fully implemented structural fix layout overlays for smooth assessment testing without crashes.
- **Key Achievements:**
  - **Distraction-Free Architecture**: Created dedicated `Layouts.exam` discarding global loaders to preserve responsive viewport dimensions cleanly.
  - **Navigation Skips**: Solved continuous-jump lockouts traversing empty loops by placing recursive incremental conditions inside saveAndNext securely.
  - **Livewire Results**: Built fully isolated computation algorithm dictionary bundles rendering transparent layout yields within student sub frames.
  - **Timer Guard**: Upgraded fallback intervals relative to absolute timestamps safeguarding accidental closure locks reliably.

## Session Handoff - 2026-03-15 (Livewire Online Test Module)
- **Current State:** Fully implemented bulletproof online test runner solving single-attempt state locks using Livewire 3 framing triggers.
- **Key Achievements:**
  - **Database Guardrails:** Added `status` and `draft_state` tracking columns enabling robust answer saves and reloads safely.
  - **Anticheet Guards:** Integrated Javascript history push locks to disable browser back backtracking navigation cheat attempts.
  - **Server-Driven Timers:** Setup continuous Livewire Polling heartbeats maintaining absolute timeout countdown integrity securely.
  - **Component routing swaps:** Overrode absolute `start-test` references direct to stateful Livewire components cleanly.

## Previous Sessions
- **Current State:** Implemented distinct rules for Premium vs Free package lifecycles.
- **Key Achievements:**
  - **Premium Protection:** Purchased premium packages remain accessible to students even if deactivated by an admin, until their transaction expires.
  - **Free Package Lifecycle:** Free packages are automatically hidden from the "Free" list once started. If an admin deactivates a free package, it is immediately hidden from "My Packages" and access is blocked.
  - **Discovery Optimization:** Updated both the dashboard and homepage to properly transition free packages from discovery to ownership.
  - **Homepage UX:** Synchronized homepage buttons to follow the same transaction/access flow as the dashboard.

## Previous Sessions
- **Sidebar Update:** Added Education Type and Class info to the student sidebar.
- **Relationship Fix:** Added necessary relationships to `UserDetails` model.
