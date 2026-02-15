<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ImageService;
use App\Models\Gn_PackagePlan;
use App\Models\Studymaterial;
use App\Models\UserDetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OptimizeExistingImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'image:optimize-existing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimizes existing images in storage and updates database records';

    protected $imageService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ImageService $imageService)
    {
        parent::__construct();
        $this->imageService = $imageService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting image optimization...');

        // 1. Optimize Landing Page Images
        $this->optimizeLandingPage();

        // 2. Optimize Study Materials
        $this->optimizeStudyMaterials();

        // 3. Optimize Package Plans
        $this->optimizePackagePlans();

        // 4. Optimize User Details (Profile Photos)
        $this->optimizeUserDetails();

        $this->info('Image optimization completed!');
        return 0;
    }

    private function optimizeLandingPage()
    {
        $this->info('Optimizing Landing Page Images...');
        $landingPages = DB::table('landing_page')->get();

        foreach ($landingPages as $page) {
            $updates = [];

            // Banner Photo
            if ($page->banner_photo && $this->shouldOptimize($page->banner_photo)) {
                $newPath = $this->processImage('home/' . $page->banner_photo, 2000);
                if ($newPath) {
                    $updates['banner_photo'] = basename($newPath); // Stores filename only
                }
            }

            // Slider Footer Images (JSON)
            if ($page->slider_footer_image) {
                $sliderImages = json_decode($page->slider_footer_image, true);
                if (is_array($sliderImages)) {
                    $newSliderImages = [];
                    $changed = false;
                    foreach ($sliderImages as $item) {
                        $imageName = is_array($item) ? $item['image'] : $item;
                        $url = is_array($item) ? ($item['url'] ?? '') : '';

                        if ($this->shouldOptimize($imageName)) {
                            $newPath = $this->processImage('home/slider/' . $imageName, 1024);
                            if ($newPath) {
                                $newSliderImages[] = ['image' => basename($newPath), 'url' => $url];
                                $changed = true;
                            } else {
                                $newSliderImages[] = $item;
                            }
                        } else {
                            $newSliderImages[] = $item;
                        }
                    }
                    if ($changed) {
                        $updates['slider_footer_image'] = json_encode($newSliderImages);
                    }
                }
            }

            if (!empty($updates)) {
                DB::table('landing_page')->where('id', $page->id)->update($updates);
                $this->info("Updated Landing Page ID: {$page->id}");
            }
        }
    }

    private function optimizeStudyMaterials()
    {
        $this->info('Optimizing Study Materials...');
        // Chunking to handle large datasets
        Studymaterial::chunk(100, function ($materials) {
            foreach ($materials as $material) {
                if ($material->study_material_image && $material->study_material_image != 'NA' && $this->shouldOptimize($material->study_material_image)) {
                     // Assuming path is relative to public disk root or 'study_material_image/' prefix is needed?
                     // Based on controller, it uses store('study_material_image', 'public'), so path in DB is likely 'study_material_image/filename.jpg'
                    $newPath = $this->processImage($material->study_material_image, 1024);
                    if ($newPath) {
                        $material->study_material_image = $newPath;
                        $material->save();
                        $this->line("Updated Study Material ID: {$material->id}");
                    }
                }
            }
        });
    }

    private function optimizePackagePlans()
    {
        $this->info('Optimizing Package Plans...');
        // Check column name - migration says 'package_image' isn't in create table, but PlanController usage suggests it exists or is added later.
        // Checking Controller: $package_plan->package_image = ... store('package_image', 'public')
        // Let's assume the model has access to it.

        // If the column doesn't exist in migration 2022_03_28_194115_create_gn__package_plans_table.php, I should check if it was added later or if I missed it.
        // Quick check: PlanController uses it.

        Gn_PackagePlan::chunk(100, function ($plans) {
             foreach ($plans as $plan) {
                 // Check if attribute exists to avoid errors if column missing
                 if (isset($plan->package_image) && $plan->package_image != 'NA' && $this->shouldOptimize($plan->package_image)) {
                     $newPath = $this->processImage($plan->package_image, 1024);
                     if ($newPath) {
                         $plan->package_image = $newPath;
                         $plan->save();
                         $this->line("Updated Package Plan ID: {$plan->id}");
                     }
                 }
             }
        });
    }

    private function optimizeUserDetails() {
        $this->info('Optimizing User Details...');
        UserDetails::chunk(100, function ($users) {
            foreach ($users as $user) {
                if ($user->photo_url && $this->shouldOptimize($user->photo_url)) {
                     $newPath = $this->processImage($user->photo_url, 500); // Profile pics can be smaller
                     if ($newPath) {
                         $user->photo_url = $newPath;
                         $user->save();
                         $this->line("Updated UserDetails ID: {$user->id}");
                     }
                }
            }
        });
    }

    private function shouldOptimize($filename)
    {
        if (empty($filename)) return false;
        // Skip if already webp
        return strtolower(pathinfo($filename, PATHINFO_EXTENSION)) !== 'webp';
    }

    private function processImage($relativePath, $maxWidth)
    {
        try {
            // $relativePath is what's stored in DB.
            // Storage::disk('public') root is storage/app/public.

            // Check if file exists
            if (!Storage::disk('public')->exists($relativePath)) {
                // Try finding it in 'public/' directly if migration hasn't moved them yet?
                // The prompt implies "if available in the storage".
                // If not found in storage disk, we might skip.
                $this->warn("File not found: {$relativePath}");
                return null;
            }

            // Optimize
            $newPath = $this->imageService->optimizeExisting($relativePath, $maxWidth);

            // Delete old file if successful and different
            if ($newPath && $newPath !== $relativePath) {
                Storage::disk('public')->delete($relativePath);
            }

            return $newPath;

        } catch (\Exception $e) {
            $this->error("Failed to optimize {$relativePath}: " . $e->getMessage());
            return null;
        }
    }
}
