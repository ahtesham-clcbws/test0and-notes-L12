<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Count;
use App\Models\DefautlOtpNumber;
use App\Models\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\ImageService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }
    public function dashboardSettings()
    {
        $data = array();
        if (request()->isMethod('post')) {
            $data = request()->all();
            $countUpdate = Count::find($data['id']);
            $countUpdate->box_color = $data['box_color'];
            $countUpdate->count_color = $data['count_color'];
            $countUpdate->title = $data['title'];
            $countUpdate->save();
        }
        $countsData = Count::all();
        $countsDataGrouped = [];
        foreach ($countsData as $key => $value) {
            $category = $value['category'];
            $countsDataGrouped[$category][] = $value->toArray();
        }
        $countsDataGroupedSorted = [];
        foreach ($countsDataGrouped as $key => $countsArray) {
            array_multisort(array_column($countsArray, 'box_index'), SORT_ASC, $countsArray);
            $countsDataGroupedSorted[$key] = $countsArray;
            $data[$key . '_counts'] = $countsArray;
        }
        $boxes = $countsDataGroupedSorted;
        return view('Dashboard/Admin/Settings/dashboard')->with('boxes', $boxes);
    }

    public function noOtpNumbers(Request $request)
    {
        $numbers = DefautlOtpNumber::get();
        $data['numbers'] = $numbers;
        return view('Dashboard/Admin/Settings/defaultnumbers')->with('data', $data);
    }
    public function delete_number($id)
    {
        $number = DefautlOtpNumber::find($id);
        if ($number) {
            $number->delete();
        }
        return redirect()->back();
    }

    public function manage_home()
    {
        $data = DB::table('landing_page')->where('id', '1')->first();
        // return $data->id;
        $result['id'] = $data->id;
        $result['banner_title_first'] = $data->banner_title_first;
        $result['banner_title_second'] = $data->banner_title_second;
        $result['banner_title_third'] = $data->banner_title_third;
        $result['banner_content'] = $data->banner_content;
        $result['competitive_courses_status'] = $data->competitive_courses_status;
        $result['range_of_courses_status'] = $data->range_of_courses_status;
        $result['slider_footer_image'] = $data->slider_footer_image;

        $data = DB::table('landing_page')->where('id', '2')->first();
        $result['subtitle1_first'] = $data->banner_title_first;
        $result['subtitle1_second'] = $data->banner_title_second;
        $result['subtitle1_third'] = $data->banner_title_third;
        $result['subtitle1_content'] = $data->banner_content;

        $data = DB::table('landing_page')->where('id', '3')->first();
        $result['subtitle2_first'] = $data->banner_title_first;
        $result['subtitle2_second'] = $data->banner_title_second;
        $result['subtitle2_third'] = $data->banner_title_third;
        $result['subtitle2_content'] = $data->banner_content;

        $data = DB::table('landing_page')->where('id', '4')->first();
        $result['subtitle3_first'] = $data->banner_title_first;
        $result['subtitle3_second'] = $data->banner_title_second;
        $result['subtitle3_third'] = $data->banner_title_third;
        $result['subtitle3_content'] = $data->banner_content;

        $data = DB::table('landing_page')->where('id', '5')->first();
        $result['subtitle4_first'] = $data->banner_title_first;
        $result['subtitle4_second'] = $data->banner_title_second;
        $result['subtitle4_third'] = $data->banner_title_third;
        $result['subtitle4_content'] = $data->banner_content;

        $data = DB::table('landing_page')->where('id', '6')->first();
        $result['subtitle5_first'] = $data->banner_title_first;
        $result['subtitle5_second'] = $data->banner_title_second;
        $result['subtitle5_third'] = $data->banner_title_third;
        $result['subtitle5_content'] = $data->banner_content;

        $data = DB::table('landing_page')->where('id', '7')->first();
        $result['subtitle6_first'] = $data->banner_title_first;
        $result['subtitle6_second'] = $data->banner_title_second;
        $result['subtitle6_third'] = $data->banner_title_third;
        $result['subtitle6_content'] = $data->banner_content;

        $data = DB::table('landing_page')->where('id', '8')->first();
        $result['subtitle7_first'] = $data->banner_title_first;
        $result['subtitle7_second'] = $data->banner_title_second;
        $result['subtitle7_third'] = $data->banner_title_third;
        $result['subtitle7_content'] = $data->banner_content;

        $data = DB::table('landing_page')->where('id', '9')->first();
        $result['subtitle8_first'] = $data->banner_title_first;
        $result['subtitle8_second'] = $data->banner_title_second;
        $result['subtitle8_third'] = $data->banner_title_third;
        $result['subtitle8_content'] = $data->banner_content;

        return view('Dashboard/Admin/Settings/manage_home', $result);
    }

    public function manage_home_process(Request $request)
    {

        // return $request->post();
        if ($request->post('competitive_courses_status') != null) {
            $competitive_courses_status = '1';
        } else {
            $competitive_courses_status = '0';
        }
        if ($request->post('range_of_courses_status') != null) {
            $range_of_courses_status = '1';
        } else {
            $range_of_courses_status = '0';
        }
        $query = DB::table('landing_page')
            ->where('id', $request->id);
        $banner_photo = '';
        if ($request->hasfile('banner_photo')) {

            if ($request->post('id') > 0) {
                $arrImage = DB::table('landing_page')->where('id', $request->post('id'))->first();
                $old_profile = 'home/' . $arrImage->banner_photo;
                if (Storage::disk('public')->exists($old_profile)) {
                    Storage::disk('public')->delete($old_profile);
                }
            }

            // Use ImageService
            $fullPath = $this->imageService->handleUpload($request->file('banner_photo'), 'home', 2000); // 2000px for banner
            $banner_photo = basename($fullPath);

            $query->update([
                'banner_photo' => $banner_photo,
            ]);
        }




        $banner_attr_image_1 = '';
        if ($request->hasfile('banner_attr_image_1')) {

            if ($request->post('id') > 0) {
                $arrImage = DB::table('landing_page')->where('id', $request->post('id'))->first();
                $old_profile = 'home/' . $arrImage->banner_attr_image_1;
                if (Storage::disk('public')->exists($old_profile)) {
                    Storage::disk('public')->delete($old_profile);
                }
            }

            // Use ImageService
            $fullPath = $this->imageService->handleUpload($request->file('banner_attr_image_1'), 'home', 1024);
            $banner_attr_image_1 = basename($fullPath);

            $query->update([
                'banner_attr_image_1' => $banner_attr_image_1,
            ]);
        }

        $banner_attr_image_2 = '';
        if ($request->hasfile('banner_attr_image_2')) {

            if ($request->post('id') > 0) {
                $arrImage = DB::table('landing_page')->where('id', $request->post('id'))->first();
                $old_profile = 'home/' . $arrImage->banner_attr_image_2;
                if (Storage::disk('public')->exists($old_profile)) {
                    Storage::disk('public')->delete($old_profile);
                }
            }

            // Use ImageService
            $fullPath = $this->imageService->handleUpload($request->file('banner_attr_image_2'), 'home', 1024);
            $banner_attr_image_2 = basename($fullPath);

            $query->update([
                'banner_attr_image_2' => $banner_attr_image_2,
            ]);
        }

        $banner_attr_image_3 = '';
        if ($request->hasfile('banner_attr_image_3')) {

            if ($request->post('id') > 0) {
                $arrImage = DB::table('landing_page')->where('id', $request->post('id'))->first();
                $old_profile = 'home/' . $arrImage->banner_attr_image_3;
                if (Storage::disk('public')->exists($old_profile)) {
                    Storage::disk('public')->delete($old_profile);
                }
            }

            // Use ImageService
            $fullPath = $this->imageService->handleUpload($request->file('banner_attr_image_3'), 'home', 1024);
            $banner_attr_image_3 = basename($fullPath);

            $query->update([
                'banner_attr_image_3' => $banner_attr_image_3,
            ]);
        }
        $query->where('id', '1')->update([
            'banner_title_first' => $request->banner_title_first,
            'banner_title_second' => $request->banner_title_second,
            'banner_title_third' => $request->banner_title_third,
            'banner_content' => $request->banner_content,
            'competitive_courses_status' => $competitive_courses_status,
            'range_of_courses_status' => $range_of_courses_status,
        ]);
        // return $request->subtitle1_first;
        DB::table('landing_page')->where('id', '2')->update([
            'banner_title_first' => $request->subtitle1_first,
            'banner_title_second' => $request->subtitle1_second,
            'banner_title_third' => $request->subtitle1_third,
            'banner_content' => $request->subtitle1_content
        ]);

        DB::table('landing_page')->where('id', '3')->update([
            'banner_title_first' => $request->subtitle2_first,
            'banner_title_second' => $request->subtitle2_second,
            'banner_title_third' => $request->subtitle2_third,
            'banner_content' => $request->subtitle2_content
        ]);

        DB::table('landing_page')->where('id', '4')->update([
            'banner_title_first' => $request->subtitle3_first,
            'banner_title_second' => $request->subtitle3_second,
            'banner_title_third' => $request->subtitle3_third,
            'banner_content' => $request->subtitle3_content
        ]);

        DB::table('landing_page')->where('id', '5')->update([
            'banner_title_first' => $request->subtitle4_first,
            'banner_title_second' => $request->subtitle4_second,
            'banner_title_third' => $request->subtitle4_third,
            'banner_content' => $request->subtitle4_content
        ]);

        DB::table('landing_page')->where('id', '6')->update([
            'banner_title_first' => $request->subtitle5_first,
            'banner_title_second' => $request->subtitle5_second,
            'banner_title_third' => $request->subtitle5_third,
            'banner_content' => $request->subtitle5_content
        ]);

        DB::table('landing_page')->where('id', '7')->update([
            'banner_title_first' => $request->subtitle6_first,
            'banner_title_second' => $request->subtitle6_second,
            'banner_title_third' => $request->subtitle6_third,
            'banner_content' => $request->subtitle6_content
        ]);

        DB::table('landing_page')->where('id', '8')->update([
            'banner_title_first' => $request->subtitle7_first,
            'banner_title_second' => $request->subtitle7_second,
            'banner_title_third' => $request->subtitle7_third,
            'banner_content' => $request->subtitle7_content
        ]);

        DB::table('landing_page')->where('id', '9')->update([
            'banner_title_first' => $request->subtitle8_first,
            'banner_title_second' => $request->subtitle8_second,
            'banner_title_third' => $request->subtitle8_third,
            'banner_content' => $request->subtitle8_content
        ]);

        return redirect()->back();
    }

    public function slider_delete($image)
    {
        // 1. Fetch the record
        $landingPage = DB::table('landing_page')->where('id', '1')->first();

        if (!$landingPage) {
            return redirect()->back()->with('error', 'Landing page record not found.');
        }

        $sliderImages = json_decode($landingPage->slider_footer_image, true);
        $updatedImages = [];
        $found = false;

        foreach ($sliderImages as $key => $item) {
            $imgName = is_array($item) ? $item['image'] : $item;

            if ($imgName == $image) {
                $found = true;
                // Delete file
                if (Storage::disk('public')->exists('home/slider/' . $image)) {
                    Storage::disk('public')->delete('home/slider/' . $image);
                }
                continue; // Skip adding this to updated array
            }
            $updatedImages[] = $item;
        }

        if ($found) {
            DB::table('landing_page')
                ->where('id', '1')
                ->update([
                    'slider_footer_image' => json_encode(array_values($updatedImages)),
                ]);

            return redirect()->back()->with('success', 'Image deleted successfully.');
        }

        return redirect()->back()->with('error', 'Image not found in slider list.');
    }

    public function update_slider_url(Request $request)
    {
        $request->validate([
            'image' => 'required',
            'url' => 'nullable|url'
        ]);

        $landingPage = DB::table('landing_page')->find('1');
        if (!$landingPage) return redirect()->back();

        $sliderImages = json_decode($landingPage->slider_footer_image, true) ?? [];
        $updatedImages = [];

        foreach ($sliderImages as $item) {
            if (is_array($item) && $item['image'] == $request->image) {
                $item['url'] = $request->url;
            } elseif (!is_array($item) && $item == $request->image) {
                // Convert string to object if matching
                $item = ['image' => $item, 'url' => $request->url];
            }
            $updatedImages[] = $item;
        }

        DB::table('landing_page')->where('id', '1')->update([
            'slider_footer_image' => json_encode($updatedImages),
        ]);
        Cache::forget('home_landing_pages');
        return redirect()->back()->with('success', 'URL updated successfully.');
    }

    public function upload_partner_logos(Request $request)
    {
        if ($request->hasfile('slider_footer_image')) {
            $images = [];
            $url = $request->input('url', '');

            foreach ($request->file('slider_footer_image') as $image) {
                // Use ImageService for each logo
                $fullPath = $this->imageService->handleUpload($image, 'home/slider', 1024);

                // Store as object with provided URL
                $images[] = ['image' => basename($fullPath), 'url' => $url];
            }

            $currentData = DB::table('landing_page')->find('1')->slider_footer_image;
            $currentImages = $currentData ? json_decode($currentData, true) : [];

            // Ensure we have an array
            if (!is_array($currentImages)) {
                $currentImages = [];
            }

            $updatedImages = array_merge($currentImages, $images);

            DB::table('landing_page')->where('id', '1')->update([
                'slider_footer_image' => json_encode($updatedImages),
            ]);
            Cache::forget('home_landing_pages');
            return redirect()->back()->with('success', 'Partner logos uploaded successfully.');
        }

        return redirect()->back()->with('error', 'No images selected.');
    }

    public function pdfList()
    {
        $pdfList = Pdf::get();

        return view('Dashboard.Admin.Settings.pdf-list', compact('pdfList'));
    }
    public function pdfSubmit(request $request)
    {
        $validator = Validator::make($request->all(), [
            'pdf_file' => 'required|mimes:pdf|max:2048',
            'title' => 'required',
            'type' => 'required',
        ]);
        if ($validator->fails()) {
            // Return the first validation error message
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }
        $title = $request->title;
        $type = $request->type;
        $pdf = $request->pdf_file;

        if ($request->hasFile('pdf_file')) {
            $file = $request->file('pdf_file');
            $fileName = $title . rand(111, 999) . '-' . $file->getClientOriginalName();
            $path = $file->storeAs('settingPdf', $fileName, 'public');
        }
        $storePdf = new Pdf();
        $storePdf->title = $title ?? "";
        $storePdf->type = $type ?? "";
        $storePdf->url = $path ?? "";
        if ($storePdf->save()) {
            $assetPath = asset('storage/' . $path);
            return response()->json(['status' => true, 'message' => 'File uploaded successfully', 'path' => $assetPath ?? $path, 'data' => $storePdf]);
        } else {
            return response()->json(['status' => false, 'message' => 'something went wrong']);
        }
    }
    public function pdfDelete(Request $request)
    {

        if ($request->id) {
            $data =  Pdf::find($request->id);

            if ($data->delete()) {
                return response()->json(['status' => true, 'message' => 'file deleted success']);
            } else {
                return response()->json(['status' => false, 'message' => 'something went wrong']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'something went wrong']);
        }
    }
}
