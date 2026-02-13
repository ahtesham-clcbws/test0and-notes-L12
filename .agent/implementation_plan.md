# Review System Implementation Plan

Implement a review and testimonial system where students/institutes can submit reviews, and admins can moderate and feature them.

## Proposed Changes

### Database
#### [NEW] [2024_xx_xx_xxxxxx_create_reviews_table.php](file:///i:/test-and-notes-upgrading/database/migrations/create_reviews_table.php)
- Create `reviews` table with:
    - `user_id`: Foreign key to `users`
    - `user_type`: Enum or String (student/institute)
    - `review_text`: Text
    - `is_approved`: Boolean (default: false)
    - `is_featured`: Boolean (default: false)

### Models
#### [NEW] [Review.php](file:///i:/test-and-notes-upgrading/app/Models/Review.php)
- Define `Review` model with `belongsTo` relationship to `User`.

### Student Portal
#### [NEW] [ReviewController.php](file:///i:/test-and-notes-upgrading/app/Http/Controllers/Student/ReviewController.php)
- Controller to handle review submission.
#### [NEW] [reviews/index.blade.php](file:///i:/test-and-notes-upgrading/resources/views/student/reviews/index.blade.php)
- Page for students to see their reviews and submit a new one.
#### [MODIFY] [student.php](file:///i:/test-and-notes-upgrading/routes/student.php)
- Register routes for reviews.

### Admin Panel
#### [NEW] [ManageReviews.php](file:///i:/test-and-notes-upgrading/app/Livewire/Admin/ManageReviews.php)
- Livewire component to list, approve, and feature reviews.
#### [NEW] [manage-reviews.blade.php](file:///i:/test-and-notes-upgrading/resources/views/livewire/admin/manage-reviews.blade.php)
- View for the admin moderation panel.
#### [MODIFY] [administrator.php](file:///i:/test-and-notes-upgrading/routes/administrator.php)
- Register admin routes for review management.

## Verification Plan

### Automated Tests
- N/A (Mostly UI/Integration focused)

### Manual Verification
1. **Student Submission**:
   - Log in as a student.
   - Navigate to `/student/review`.
   - Submit a review.
   - Verify it appears in the database as `is_approved = false`.
2. **Admin Moderation**:
   - Log in as an admin.
   - Navigate to `/administrator/settings/reviews`.
   - Click "Approve" on the student's review.
   - Click "Feature" on the review.
   - Verify changes in the database.
3. **Institute Review (Optional/Future)**:
   - Ensure the `user_type` logic works for institutes if they submit via their panel.
