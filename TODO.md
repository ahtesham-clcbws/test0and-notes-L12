cd public;
ln -s ../storage/app/public storage

## email issue resolution maybe
php artisan queue:restart
php artisan clear-compiled
php artisan cache:clear
php artisan config:clear

MyT&N@2024#!
UPDATE `student_codes` SET `exam_center` = NULL,`exam_at` = NULL,`admitcard_before` = NULL,`exam_mins` = NULL, `roll_no` = NULL, `issued_admitcard` = 1;

UPDATE `student_codes` 
SET `roll_no` = NULL,
`exam_center` = NULL,
`exam_at` = NULL,
`admitcard_before` = NULL,
`issued_admitcard` = 0,
`exam_mins` = NULL;

## TODO after push
SSH
1988DEC7@htesham
ssh -p 65002 u829699752@82.25.120.120
cd domains/careerwithoutbarrier.com/public_html
php artisan optimize:clear; php artisan clear-compiled; php artisan cache:clear; php artisan config:clear;php artisan optimize;
# check for migration
php artisan migrate;
# for storage:link
cd public; rm -rf storage;ln -s ../storage/app/public storage;cd ../;

## main path of domains
u482032683 = ~
/home/u482032683/domains/careerwithoutbarrier.com/public_html
/home/u482032683/domains/develop.testandnotes.com/public_html
/home/u482032683/domains/testandnotes.com/public_html

cp -r -a . /path/to/destination/directory

## NOV-20
https://careerwithoutbarrier.com/administrator/student_list
Centr Column remove -> [DONE]
App Code= Appl No -> [DONE]
District+Centre -> [DONE]
Payment Rs 0 -> [DONE]
Print PDF -> [DONE]

https://careerwithoutbarrier.com/administrator/studentRollList
Roll no generation -> [DONE]

https://careerwithoutbarrier.com/administrator/student_result
Student Dashboard Result -> [DONE]

If discount is above 60% then discount line is removed, Final online Paid Amount, Text Letter Capitalize -> [DONE]

## DEC-18
in website -> register student -> Institute code live verify -> [SKIP]
New corporate enquiry (interested for more than one) -> [DONE]
In Admin -> New corporate inquiry -> photo issuep -> [DONE]
In admin -> institute list last top -> [DONE]
In admin -> dashboard card -> fully clickable -> [DONE]
In admin -> new institute sign-up card link not proper -> [DONE]
in admin -> all institute lists -> photo issue -> [DONE]
in website -> free-form -> table city issue -> [DONE]
New institute city not showimg in free form provider list  link in footer get 100 -> [DONE]
http://careerwithoutbarrier.test/free-form -> [DONE]
Father/Mother labels in apply form in students -> [DONE]
In admin -> issue = Automatically issued coupons -> [DONE] [Database-Issue-Resolved]
In student dashboard -> roll number not showing -> [DONE]
kindly check photo display issue in student form / institute form and also  upload issue in everywhere

## DEC31: Start 5000 form will be free
Coupon list will be create properly -> [DONE]
Coupon description (new property) -> [DONE]
Coupon description (Registration & Payment)
Popup message - dynamic - image only -> [DONE]
Student payment page content -> ## from WhatsApp
Contact list, all details needed to be checked -> [DONE]
Contact list, when reply, details needed to show in the modal -> [DONE]
Create new contact list page -> [DONE]
Create new contact reply page -> [DONE]
Add Cloudflare

Voucher Discount Display when Applied
Provided By
Issued By
Discount Value as working

## Jan3
Popup only on homepage -> [DONE]
Logo link to homepage -> [DONE]
homepage apply now to registration form -> [DONE]
Contact details on reply contact info with signature -> [DONE]

admin -> New istitute signup (header) -> wrong link -> [DONE]
admin -> New Student signup (header) -> wrong link (same as new students box) -> [DONE]

Student dashboard -> homepage button -> [DONE]

Referall code or coupon working if disabled -> [DONE]
Registration -> if 300 & above forms are available, referall code is not there only on payment page (reference code box visible only when remaining forms are visible) (27 NOV) -> [DONE]

Student delete feature
Student reset feature (registration will be there)
Institute delete feature

Student, Institutes, mobile number otp needed to be delete all data

Reset feature TBD

## message on payment page
This Discount Voucher was Provided By
SQS Foundation, Kanpur
Issued/Distributed BY 
Educraft Educations

## Jan9-full reset
DiscountVoucher
SholarhipExam -> Sholarship Opted
StudentCodes
Student table also reset
student test truncate

## Jan17
Registration -> referral code issue by institute & District, Registration error on OTP (error: Code is not valid)
Institute dashboard -> coupon list same as admin
Institute dashboard -> student list columns merge & add qualification
Institute dashboard -> coupon list same as admin


## Jan25
Enquiry form redirect to homepage - [DONE]
Contact from rediract to homepage - [DONE]
Free form -> change search + all cities + default 25 results - [DONE]

New Student Signup -> topbar notification (Replied) -> new coupon requests - [DONE]

Dashboard boxes:
1- New Student(s) -> if there is new student it will be old - [DONE]
2- Total Students -> from student list - [DONE]
3- New Institute Enquiry - [DONE]
4- New Institute Sign-up - [DONE]
5- Approved Institute - [DONE]
6- New/All Feedback - [DONE]
7- New Contact Enquiry  - [DONE]
8- Request New Coupon - [DONE]

Contact replied lists & other enhancements - [DONE]

Contact lists -> delete single confirmation - [DONE]

coupon request -> on delete confirm first - [DONE]

Institute coupon list - [DONE]

Coupon request -> institute coupons list link - [DONE]

New institute -> approve enquiry -> autoclose the approval box - [DONE]

student dashboard -> mobile/email changeable - [DONE]
student dashboard -> student name topbar, career logo, remove search - [DONE]
student dashboard -> add testimonial -> livewire - [DONE]
student dashboard -> add screenshot/image -> optional - [DONE]

institute dashboard -> add new coupon request -> refresh the page - [DONE]
institute dashboard -> institute name topbar, career logo, remove search - [DONE]
institute dashboard -> add testimonial -> livewire - [DONE]
institute dashboard -> add screenshot/image -> optional - [DONE]

Testimonials cleanup at website - [DONE]
Other cleanups at website - [DONE]

Institute signup -> livewire form - [DONE]

Registration or Enquiry form -> OTP in form verification - [DONE]

Roll no generation testing

Email templates
