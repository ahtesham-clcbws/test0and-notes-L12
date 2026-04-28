---
description: Prepare for git push (auto-increment version, build, and lint)
---

This workflow automates the versioning and build process before pushing to the repository.

// turbo-all
1. Increment the version (default: patch)
   ```bash
   php .agent/scripts/increment-version.php patch
   ```

2. Run the frontend build
   ```bash
   npm run build
   ```

3. Run code formatting
   ```bash
   vendor/bin/pint --dirty
   ```

4. **Verify**: Check the footer version in your browser.
5. **Git Push**: When you are ready, run your git push command manually.
