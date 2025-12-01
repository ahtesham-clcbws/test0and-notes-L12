<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Count;
use App\Models\DefautlOtpNumber;
use App\Models\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
class SettingsController extends Controller
{
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

    public function manage_home(){
        $data = DB::table('landing_page')->where('id','1')->first();
        // return $data->id;
        $result['id'] = $data->id;
        $result['banner_title_first'] = $data->banner_title_first;
        $result['banner_title_second'] = $data->banner_title_second;
        $result['banner_title_third'] = $data->banner_title_third;
        $result['banner_content'] = $data->banner_content;
        $result['competitive_courses_status'] = $data->competitive_courses_status;
        $result['range_of_courses_status'] = $data->range_of_courses_status;
        $result['slider_footer_image'] = $data->slider_footer_image;

        $data = DB::table('landing_page')->where('id','2')->first();
        $result['subtitle1_first'] = $data->banner_title_first;
        $result['subtitle1_second'] = $data->banner_title_second;
        $result['subtitle1_third'] = $data->banner_title_third;
        $result['subtitle1_content'] = $data->banner_content;

        $data = DB::table('landing_page')->where('id','3')->first();
        $result['subtitle2_first'] = $data->banner_title_first;
        $result['subtitle2_second'] = $data->banner_title_second;
        $result['subtitle2_third'] = $data->banner_title_third;
        $result['subtitle2_content'] = $data->banner_content;

        $data = DB::table('landing_page')->where('id','4')->first();
        $result['subtitle3_first'] = $data->banner_title_first;
        $result['subtitle3_second'] = $data->banner_title_second;
        $result['subtitle3_third'] = $data->banner_title_third;
        $result['subtitle3_content'] = $data->banner_content;

        $data = DB::table('landing_page')->where('id','5')->first();
        $result['subtitle4_first'] = $data->banner_title_first;
        $result['subtitle4_second'] = $data->banner_title_second;
        $result['subtitle4_third'] = $data->banner_title_third;
        $result['subtitle4_content'] = $data->banner_content;

        $data = DB::table('landing_page')->where('id','6')->first();
        $result['subtitle5_first'] = $data->banner_title_first;
        $result['subtitle5_second'] = $data->banner_title_second;
        $result['subtitle5_third'] = $data->banner_title_third;
        $result['subtitle5_content'] = $data->banner_content;

        $data = DB::table('landing_page')->where('id','7')->first();
        $result['subtitle6_first'] = $data->banner_title_first;
        $result['subtitle6_second'] = $data->banner_title_second;
        $result['subtitle6_third'] = $data->banner_title_third;
        $result['subtitle6_content'] = $data->banner_content;

        $data = DB::table('landing_page')->where('id','8')->first();
        $result['subtitle7_first'] = $data->banner_title_first;
        $result['subtitle7_second'] = $data->banner_title_second;
        $result['subtitle7_third'] = $data->banner_title_third;
        $result['subtitle7_content'] = $data->banner_content;

        $data = DB::table('landing_page')->where('id','9')->first();
        $result['subtitle8_first'] = $data->banner_title_first;
        $result['subtitle8_second'] = $data->banner_title_second;
        $result['subtitle8_third'] = $data->banner_title_third;
        $result['subtitle8_content'] = $data->banner_content;

        return view('Dashboard/Admin/Settings/manage_home', $result);
    }

    public function manage_home_process(Request $request){

        // return $request->post();
        if($request->post('competitive_courses_status') != null){
            $competitive_courses_status = '1';
        }else{
            $competitive_courses_status = '0';
        }
        if($request->post('range_of_courses_status') != null){
            $range_of_courses_status = '1';
        }else{
            $range_of_courses_status = '0';
        }
         $query = DB::table('landing_page')
        ->where('id', $request->id);
        $banner_photo = '';
       if($request->hasfile('banner_photo')){

            if($request->post('id')>0){
                $arrImage=DB::table('landing_page')->where('id',$request->post('id'))->first();
                $old_profile = 'home/' .$arrImage->banner_photo;
                if(file_exists($old_profile)) {

                    File::delete($old_profile);
                }
            }

            $file=$request->file('banner_photo');
            $name = microtime(true) . time() . rand(1, 100) . '.' . $file->getClientOriginalExtension();
            $upload_path = 'home/';
            $file->move($upload_path, $name);
            $banner_photo = $name;
            // $model->banner_photo=$name == null ? $request->post('banner_photo') : $name;
            $query->update([
           'banner_photo' => $banner_photo,
        ]);
        }


        if($request->hasfile('slider_footer_image')){
        $images = [];
        foreach($request->file('slider_footer_image') as $image) {
            $name = microtime(true) . time() . rand(1, 100) . '.' . $image->getClientOriginalExtension();
            $path ='home/slider/';
            $image->move($path, $name);
            $images[] = $name;
        }
        $firstArray = DB::table('landing_page')->find('1')->slider_footer_image;
         $thirdArray = array_merge(json_decode($firstArray), $images);

         $query->update([
            'slider_footer_image' => $thirdArray,
        ]);
        }


        $banner_attr_image_1 = '';
       if($request->hasfile('banner_attr_image_1')){

            if($request->post('id')>0){
                $arrImage=DB::table('landing_page')->where('id',$request->post('id'))->first();
                $old_profile = 'home/' .$arrImage->banner_attr_image_1;
                if(file_exists($old_profile)) {

                    File::delete($old_profile);
                }
            }

            $file=$request->file('banner_attr_image_1');
            $name = microtime(true) . time() . rand(1, 100) . '.' . $file->getClientOriginalExtension();
            $upload_path = 'home/';
            $file->move($upload_path, $name);
            $banner_attr_image_1 = $name;
            // $model->banner_photo=$name == null ? $request->post('banner_photo') : $name;
            $query->update([
           'banner_attr_image_1' => $banner_attr_image_1,
        ]);
        }

        $banner_attr_image_2 = '';
       if($request->hasfile('banner_attr_image_2')){

            if($request->post('id')>0){
                $arrImage=DB::table('landing_page')->where('id',$request->post('id'))->first();
                $old_profile = 'home/' .$arrImage->banner_attr_image_2;
                if(file_exists($old_profile)) {

                    File::delete($old_profile);
                }
            }

            $file=$request->file('banner_attr_image_2');
            $name = microtime(true) . time() . rand(1, 100) . '.' . $file->getClientOriginalExtension();
            $upload_path = 'home/';
            $file->move($upload_path, $name);
            $banner_attr_image_2 = $name;
            // $model->banner_photo=$name == null ? $request->post('banner_photo') : $name;
            $query->update([
           'banner_attr_image_2' => $banner_attr_image_2,
        ]);
        }

        $banner_attr_image_3 = '';
       if($request->hasfile('banner_attr_image_3')){

            if($request->post('id')>0){
                $arrImage=DB::table('landing_page')->where('id',$request->post('id'))->first();
                $old_profile = 'home/' .$arrImage->banner_attr_image_3;
                if(file_exists($old_profile)) {

                    File::delete($old_profile);
                }
            }

            $file=$request->file('banner_attr_image_3');
            $name = microtime(true) . time() . rand(1, 100) . '.' . $file->getClientOriginalExtension();
            $upload_path = 'home/';
            $file->move($upload_path, $name);
            $banner_attr_image_3 = $name;
            // $model->banner_photo=$name == null ? $request->post('banner_photo') : $name;
            $query->update([
           'banner_attr_image_3' => $banner_attr_image_3,
        ]);
        }
        $query->where('id','1')->update([
            'banner_title_first' => $request->banner_title_first,
            'banner_title_second' => $request->banner_title_second,
            'banner_title_third' => $request->banner_title_third,
            'banner_content' => $request->banner_content,
            'competitive_courses_status' => $competitive_courses_status,
            'range_of_courses_status' => $range_of_courses_status,
        ]);
        // return $request->subtitle1_first;
        DB::table('landing_page')->where('id','2')->update([
            'banner_title_first' => $request->subtitle1_first,
            'banner_title_second' => $request->subtitle1_second,
            'banner_title_third' => $request->subtitle1_third,
            'banner_content' => $request->subtitle1_content
        ]);

         DB::table('landing_page')->where('id','3')->update([
            'banner_title_first' => $request->subtitle2_first,
            'banner_title_second' => $request->subtitle2_second,
            'banner_title_third' => $request->subtitle2_third,
            'banner_content' => $request->subtitle2_content
        ]);

         DB::table('landing_page')->where('id','4')->update([
            'banner_title_first' => $request->subtitle3_first,
            'banner_title_second' => $request->subtitle3_second,
            'banner_title_third' => $request->subtitle3_third,
            'banner_content' => $request->subtitle3_content
        ]);

         DB::table('landing_page')->where('id','5')->update([
            'banner_title_first' => $request->subtitle4_first,
            'banner_title_second' => $request->subtitle4_second,
            'banner_title_third' => $request->subtitle4_third,
            'banner_content' => $request->subtitle4_content
        ]);

         DB::table('landing_page')->where('id','6')->update([
            'banner_title_first' => $request->subtitle5_first,
            'banner_title_second' => $request->subtitle5_second,
            'banner_title_third' => $request->subtitle5_third,
            'banner_content' => $request->subtitle5_content
        ]);

         DB::table('landing_page')->where('id','7')->update([
            'banner_title_first' => $request->subtitle6_first,
            'banner_title_second' => $request->subtitle6_second,
            'banner_title_third' => $request->subtitle6_third,
            'banner_content' => $request->subtitle6_content
        ]);

         DB::table('landing_page')->where('id','8')->update([
            'banner_title_first' => $request->subtitle7_first,
            'banner_title_second' => $request->subtitle7_second,
            'banner_title_third' => $request->subtitle7_third,
            'banner_content' => $request->subtitle7_content
        ]);

        DB::table('landing_page')->where('id','9')->update([
            'banner_title_first' => $request->subtitle8_first,
            'banner_title_second' => $request->subtitle8_second,
            'banner_title_third' => $request->subtitle8_third,
            'banner_content' => $request->subtitle8_content
        ]);

         return redirect()->back();
    }

    public function slider_delete(Request $request,$image){

        $old_profile = 'home/slider/' .$image;
        if(file_exists($old_profile)) {

            File::delete($old_profile);
        }
        $arrImage=DB::table('landing_page')->where('id','1')->first();

        $array = json_decode($arrImage->slider_footer_image);
        // foreach($array as $key => $list){

        //     if($list == $image){
        //         // unset($array[$key]);
        //         \array_diff($array, [$image]);
        //     }
        // }
        $key = array_search($image, $array);
        if ($key !== false) {
            unset($array[$key]);
        }
        // return $array;
        $query = DB::table('landing_page')
        ->where('id', '1')
        ->update([
            'slider_footer_image' => array_values($array),
        ]);
        return redirect()->back();
    }
    public function pdfList()
    {
        $pdfList = Pdf::get();

        return view('Dashboard.Admin.Settings.pdf-list',compact('pdfList'));
    }
     public function pdfSubmit(request $request)
    {
        $validator = Validator::make($request->all(), [
            'pdf_file' => 'required|mimes:pdf|max:2048',
            'title'=>'required',
            'type'=>'required',
        ]);
        if ($validator->fails()) {
            // Return the first validation error message
            return response()->json([
                'status'=>false,
                'message' => $validator->errors()->first()
            ], 400);
        }
        $title = $request->title;
        $type = $request->type;
        $pdf = $request->pdf_file;

        if ($request->hasFile('pdf_file')) {
            // $file = $request->file('pdf_file');
            // $fileName = $title.rand(111,999). '-' . $file->getClientOriginalName();
            // $path = $file->storeAs('settingPdf', $fileName, 'public');
            $file = $request->file('pdf_file');

        $fileName = $title . rand(111, 999) . '-' . $file->getClientOriginalName();

        // Define the path where you want to store the file within the public directory
        $path = public_path('settingPdf'); // Define the destination directory
        $file->move($path, $fileName);
        }
        $storePdf = new Pdf();
        $storePdf->title = $title ??"";
        $storePdf->type = $type ??"";
        $storePdf->url= 'settingPdf/'.$fileName ?? "";
        if($storePdf->save())
        {
            return response()->json(['status'=>true,'message' => 'File uploaded successfully', 'path' => $path,'data'=>$storePdf]);
        }else{
            return response()->json(['status'=>false,'message'=>'something went wrong']);
        }
    }
    public function pdfDelete(Request $request)
    {

        if($request->id)
        {
           $data =  Pdf::find($request->id);

           if($data->delete())
           {
              return response()->json(['status'=>true,'message'=>'file deleted success']);
           }
           else{
              return response()->json(['status'=>false,'message'=>'something went wrong']);
           }
        }
        else{
            return response()->json(['status'=>false,'message'=>'something went wrong']);
        }
    }
}
