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
ssh -p 65002 u482032683@89.116.133.61
cd domains/testandnotes.com/public_html
php artisan optimize:clear; php artisan clear-compiled; php artisan cache:clear; php artisan config:clear
# check for migration
php artisan migrate;
# for storage:link
cd public;ln -s ../storage/app/public storage;cd ../;

### main path of domains
u482032683 = ~
/home/u482032683/domains/testandnotes.com/public_html
/home/u482032683/domains/develop.testandnotes.com/public_html
/home/u482032683/domains/testandnotes.com/public_html

cp -r -a . /path/to/destination/directory
