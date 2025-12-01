<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CorporateEnquiry extends Model
{
    use HasFactory, SoftDeletes;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function state()
    {
        return $this->belongsTo(State::class);
    }
    protected $fillable = [
        'name',
        'institute_name',
        'type_of_institution',
        'interested_for',
        'established_year',
        'email',
        'mobile',
        'otp',
        'address',
        'address',
        'city_id',
        'state_id',
        'pincode',
        'image',
        'status',
        'branch_code',
        'photoUrl'
    ];
    public static function generateCounts()
    {
        $data = array(
            [
                'namekey' => 'new_enquiry',
                // 'box_index' => 0,
                // 'box_color' => 'warning',
                'count' => CorporateEnquiry::where('status', 'new')->count(),
                // 'count_color' => 'danger',
                // 'title' => 'New business Enquiry',
                'page_url' => route('administrator.corporate_enquiry_type', 'new'),
                // 'category' => 'corporate'
            ],
            [
                'namekey' => 'approved_enquiry',
                // 'box_index' => 1,
                // 'box_color' => 'warning',
                'count' => CorporateEnquiry::where('status', 'approved')->count(),
                // 'count_color' => 'danger',
                // 'title' => 'Approved business Enquiry',
                'page_url' => route('administrator.corporate_enquiry_type', 'approved'),
                // 'category' => 'corporate'
            ],
            [
                'namekey' => 'rejected_enquiry',
                // 'box_index' => 2,
                // 'box_color' => 'warning',
                'count' => CorporateEnquiry::where('status', 'rejected')->count(),
                // 'count_color' => 'danger',
                // 'title' => 'Rejected business Enquiry',
                'page_url' => route('administrator.corporate_enquiry_type', 'rejected'),
                // 'category' => 'corporate'
            ],
            [
                'namekey' => 'new_corporate_sign_up',
                // 'box_index' => 3,
                // 'box_color' => 'warning',
                'count' => CorporateEnquiry::where('status', 'converted')->count(),
                // 'count_color' => 'danger',
                // 'title' => 'New Corporate Sign Up',
                'page_url' => route('administrator.corporate_enquiry_type', 'converted'),
                // 'category' => 'corporate'
            ]
        );
        foreach ($data as $value) {
            $nameKey = $value['namekey'];
            $enquiryUpdate = Count::where('namekey', $nameKey)->first();
            // if(!$enquiryUpdate) {
            //     $enquiryUpdate = new Count;
            //     $enquiryUpdate->namekey = $value['namekey'];
            // }
            // $enquiryUpdate->box_index = $value['box_index'];
            // $enquiryUpdate->box_color = $value['box_color'];
            $enquiryUpdate->count = $value['count'];
            // $enquiryUpdate->count_color = $value['count_color'];
            // $enquiryUpdate->title = $value['title'];
            // $enquiryUpdate->page_url = $value['page_url'];
            $enquiryUpdate->save();
        }
        return true;
    }
}
