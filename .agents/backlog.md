# Laravel Backlog

## Pending Tasks
- [x] Refine `studentLogin` for mobile compatibility
- [x] Implement `studentSignup` for mobile
- [x] Implement Forgot Password / OTP APIs
- [x] Restore Instructions page in Test Conduct flow
- [ ] Create/Update Test Listing API
- [ ] Create/Update Test Detail/Conduct API
- [x] Legacy Routes: Mapped legacy student routes to `/old/student` via `student_old.php`.
- [x] Fix: `plan` relationship in `Gn_PackageTransaction`.
- [x] Fix: Tailwind V4 + MaryUI asset compilation in Vite.
- [ ] UI Audit: Finalize parity for all student profile/settings screens.
- [x] Resolve all IDE compile-time and static analysis type/warning issues in Index, OnlineTestRunner, ShowResult, and APIController.
- [x] Rename deprecated `.agent` folder to `.agents` folder in absolute compliance with workspace standards.

## Completed Tasks
- [x] Null-Safety Project-Wide Audit: Resolved `Attempt to read property "branch_code" on null` and similar null-pointer/institute relationship crashes across Creater, Publisher, Manager ExamsControllers, StudymaterialController, TestController, and mainheader view to prevent crashes for direct platform contributors/superadmins.
- [x] Fix Test Creator and Test Publisher dropdowns in test section manager by correcting the roles search pattern and including superadmins
- [x] Fix Start Test flow on Package Details to route through the Instructions and Agreement page
- [x] Fix Watch Video redirect to home issue by specifying 'external' attribute on Mary UI buttons linking to external URLs/files
- [x] Replace basic local debugger with clcbws/laravel-agents-debug package from /mnt/BWS/public_projects/Local_Debug_Activity/ (V3.1.0)
- [x] Role-Based Guest Routing Redirect Safeguards (V2.3.0)

- [x] Guest Signup/Login/Forgot-Password Middleware Protection
- [x] Student Profile Validation Exception Toasts Hook
- [x] Premium Interactive OTP Verification UI for Student & Contributor Registration
- [x] Toast Notification synchronization for validation exceptions
- [x] MSG91 DLT compliant SMS OTP Integration (V2.2.0)
- [x] Premium Review Screen and Secure URL Encryption for Test Attempts
- [x] Skip & Next Confirmation Modal & fully green/grey question circle styling
- [x] 3px custom yellow border for "Mark for Review" questions
- [x] Added `getHomepageData` endpoint
- [x] Fixed API route syntax
