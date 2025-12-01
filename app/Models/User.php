<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'username',
        'isOtpRequired',
        'isPasswordRequired',
        'isAdminAllowed',
        'is_franchise',
        'is_staff',
        'in_franchise',
        'roles',
        'franchise_roles',
        'email',
        'mobile',
        'mobile_verified',
        'email_verified_at',
        'password',
        'status',
        'franchise_code',
        'device',
        'device_type',
        'device_id',
        'selectedDays'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user_details()
    {
        return $this->hasOne(UserDetails::class);
    }

    public function institute()
    {
        return $this->hasOne(FranchiseDetails::class, 'user_id', 'id');
    }

    public function myInstitute()
    {
        return $this->hasOne(FranchiseDetails::class, 'branch_code', 'franchise_code');
    }

    public function testAttempt()
    {
        return $this->hasMany(Gn_StudentTestAttempt::class, 'student_id', 'id');
    }

    public function role()
    {
        return $this->hasMany(RoleAssign::class,'user_id','id');
    }
    public static function generateCounts()
    {
        $data = array(
            [
                'namekey' => 'new_user',
                // 'box_index' => 0,
                // 'box_color' => 'info',
                'count' => User::where('roles', 'student')->where('status', 'inactive')->where('is_franchise', 0)->where('in_franchise', 0)->count(),
                // 'count_color' => 'dark',
                // 'title' => 'New User Sign Up (Direct)',
                'page_url' => route('administrator.admin_users_list', 'new'),
                // 'category' => 'direct_user',
                // 'action_required' => true
            ],
            [
                'namekey' => 'students_user',
                // 'box_index' => 1,
                // 'box_color' => 'info',
                'count' => User::where('roles', 'student')->where('is_franchise', 0)->where('is_staff', 0)->where('in_franchise', 0)->count(),
                // 'count' => User::where(['roles' => 'student', 'in_franchise' => '0', 'isAdminAllowed' => '0', 'is_staff' => '0', 'status' => 'active'])->count(),
                // 'count_color' => 'dark',
                // 'title' => 'Students (Direct)',
                'page_url' => route('administrator.admin_users_list', 'students'),
                // 'category' => 'direct_user'
            ],
            [
                'namekey' => 'creators_user',
                // 'box_index' => 2,
                // 'box_color' => 'info',
                'count' => User::where('roles', 'creator')->where('is_franchise', 0)->where('is_staff', 1)->where('in_franchise', 0)->count(),
                // 'count_color' => 'dark',
                // 'title' => 'Creators (Direct)',
                'page_url' => route('administrator.admin_users_list', 'creators'),
                // 'category' => 'direct_user'
            ],
            [
                'namekey' => 'publishers_user',
                // 'box_index' => 3,
                // 'box_color' => 'info',
                'count' => User::where('roles', 'publisher')->where('is_franchise', 0)->where('is_staff', 1)->where('in_franchise', 0)->count(),
                // 'count_color' => 'dark',
                // 'title' => 'Publilshers (Direct)',
                'page_url' => route('administrator.admin_users_list', 'publishers'),
                // 'category' => 'direct_user'
            ],
            [
                'namekey' => 'managers_user',
                // 'box_index' => 4,
                // 'box_color' => 'info',
                'count' => User::where('roles', 'manager')->where('is_franchise', 0)->where('is_staff', 1)->where('in_franchise', 0)->count(),
                // 'count_color' => 'dark',
                // 'title' => 'Managers (Direct)',
                'page_url' => route('administrator.admin_users_list', 'managers'),
                // 'category' => 'direct_user'
            ],
            [
                'namekey' => 'multirole_user',
                // 'box_index' => 4,
                // 'box_color' => 'success',
                'count' => User::where('roles', 'like', '%,%')->where('is_staff', 1)->where('in_franchise', 0)->count(),
                // 'count_color' => 'dark',
                // 'title' => 'Multi Franchise',
                'page_url' => route('administrator.franchise_type', 'other'),
                // 'category' => 'franchise'
            ],
            [
                'namekey' => 'franchise_new_user',
                // 'box_index' => 0,
                // 'box_color' => 'success',
                'count' => User::where(['roles' => 'student', 'in_franchise' => 1, 'isAdminAllowed' => 0, 'is_staff' => 0, 'is_franchise' => 0, 'status' => 'inactive'])->count() + User::where(['roles' => 'student', 'in_franchise' => 1, 'isAdminAllowed' => 0, 'is_staff' => 0, 'is_franchise' => 0, 'status' => 'unread'])->count(),
                // 'count_color' => 'dark',
                // 'title' => 'New User Sign Up (Franchise)',
                'page_url' => route('administrator.admin_users_list', 'new/franchise'),
                // 'category' => 'franchise_user',
                // 'action_required' => true
            ],
            [
                'namekey' => 'franchise_students',
                // 'box_index' => 1,
                // 'box_color' => 'success',
                // 'count' => User::where('roles', 'student')->where('is_franchise', 0)->where('is_staff', 0)->where('in_franchise', 1)->where('status', 'active')->count(),
                'count' => User::where('roles', 'student')->where('is_franchise', 0)->where('is_staff', 0)->where('in_franchise', 1)->count(),
                // 'count_color' => 'dark',
                // 'title' => 'Students (Franchise)',
                'page_url' => route('administrator.admin_users_list', 'students/franchise'),
                // 'category' => 'franchise_user'
            ],
            [
                'namekey' => 'franchise_creators',
                // 'box_index' => 2,
                // 'box_color' => 'success',
                'count' => User::where('roles', 'creator')->where('is_franchise', 0)->where('is_staff', 1)->where('in_franchise', 1)->count(),
                // 'count_color' => 'dark',
                // 'title' => 'Creators (Franchise)',
                'page_url' => route('administrator.admin_users_list', 'creators/franchise'),
                // 'category' => 'franchise_user'
            ],
            [
                'namekey' => 'franchise_publishers',
                // 'box_index' => 3,
                // 'box_color' => 'success',
                'count' => User::where('roles', 'publisher')->where('is_franchise', 0)->where('is_staff', 1)->where('in_franchise', 1)->count(),
                // 'count_color' => 'dark',
                // 'title' => 'Publilshers (Franchise)',
                'page_url' => route('administrator.admin_users_list', 'publishers/franchise'),
                // 'category' => 'franchise_user'
            ],
            [
                'namekey' => 'franchise_managers',
                // 'box_index' => 4,
                // 'box_color' => 'success',
                'count' => User::where('roles', 'manager')->where('is_franchise', 0)->where('is_staff', 1)->where('in_franchise', 1)->count(),
                // 'count_color' => 'dark',
                // 'title' => 'Managers (Franchise)',
                'page_url' => route('administrator.admin_users_list', 'managers/franchise'),
                // 'category' => 'franchise_user'
            ],
            [
                'namekey' => 'franchise_multirole',
                // 'box_index' => 4,
                // 'box_color' => 'success',
                'count' => User::where('roles', 'like', '%,%')->where('is_franchise', 0)->where('is_staff', 1)->where('in_franchise', 1)->count(),
                // 'count_color' => 'dark',
                // 'title' => 'Managers (Franchise)',
                'page_url' => route('administrator.admin_users_list', 'multi/franchise'),
                // 'category' => 'franchise_user'
            ],
            [
                'namekey' => 'compitition_franchise',
                // 'box_index' => 0,
                // 'box_color' => 'success',
                'count' => FranchiseDetails::where('franchise_types', 'compitition_franchise')->where('is_multiple', 0)->count(),
                // 'count_color' => 'dark',
                // 'title' => 'Compitition Franchise',
                'page_url' => route('administrator.franchise_type', 'compitition'),
                // 'category' => 'franchise'
            ],
            [
                'namekey' => 'academics_franchise',
                // 'box_index' => 1,
                // 'box_color' => 'success',
                'count' => FranchiseDetails::where('franchise_types', 'academics_franchise')->where('is_multiple', 0)->count(),
                // 'count_color' => 'dark',
                // 'title' => 'Academics Franchise',
                'page_url' => route('administrator.franchise_type', 'academics'),
                // 'category' => 'franchise'
            ],
            [
                'namekey' => 'school_franchise',
                // 'box_index' => 2,
                // 'box_color' => 'success',
                'count' => FranchiseDetails::where('franchise_types', 'school_franchise')->where('is_multiple', 0)->count(),
                // 'count_color' => 'dark',
                // 'title' => 'School Franchise',
                'page_url' => route('administrator.franchise_type', 'school'),
                // 'category' => 'franchise',
            ],
            [
                'namekey' => 'other_franchise',
                // 'box_index' => 3,
                // 'box_color' => 'success',
                'count' => FranchiseDetails::where('franchise_types', 'other_franchise')->where('is_multiple', 0)->count(),
                // 'count_color' => 'dark',
                // 'title' => 'Other Franchise',
                'page_url' => route('administrator.franchise_type', 'other'),
                // 'category' => 'franchise'
            ],
            [
                'namekey' => 'multi_franchise',
                // 'box_index' => 4,
                // 'box_color' => 'success',
                'count' => FranchiseDetails::where('is_multiple', 1)->count(),
                // 'count_color' => 'dark',
                // 'title' => 'Multi Franchise',
                'page_url' => route('administrator.franchise_type', 'other'),
                // 'category' => 'franchise'
            ]
        );
        foreach ($data as $value) {
            $nameKey = $value['namekey'];
            // $action_required = false;
            // if (isset($value['action_required'])) {
            //     $action_required = $value['action_required'];
            // }
            $enquiryUpdate = Count::where('namekey', $nameKey)->first();
            // if (!$enquiryUpdate) {
            //     $enquiryUpdate = new Count;
            //     $enquiryUpdate->namekey = $value['namekey'];
            // }
            // $enquiryUpdate->box_index = $value['box_index'];
            // $enquiryUpdate->box_color = $value['box_color'];
            $enquiryUpdate->count = $value['count'];
            // $enquiryUpdate->page_url = $value['page_url'];
            // $enquiryUpdate->count_color = $value['count_color'];
            // $enquiryUpdate->title = $value['title'];
            // $enquiryUpdate->page_url = $value['page_url'];
            // $enquiryUpdate->category = $value['category'];
            // $enquiryUpdate->action_required = $action_required;
            $enquiryUpdate->save();
        }
        return true;
    }
}
