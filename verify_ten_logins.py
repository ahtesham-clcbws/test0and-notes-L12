#!/usr/bin/env python3
import json
import urllib.request
import urllib.error
import sys
import subprocess

def make_request(url, method="POST", data=None):
    headers = {
        "Content-Type": "application/json",
        "Accept": "application/json"
    }
    req_data = json.dumps(data).encode("utf-8")
    req = urllib.request.Request(url, data=req_data, headers=headers, method=method)
    try:
        with urllib.request.urlopen(req) as response:
            return response.status, json.loads(response.read().decode("utf-8"))
    except urllib.error.HTTPError as e:
        try:
            return e.code, json.loads(e.read().decode("utf-8"))
        except Exception:
            return e.code, {"message": str(e)}
    except Exception as e:
        return 500, {"message": str(e)}

def get_ten_students():
    # Call php artisan tinker to get 10 students in JSON format
    tinker_cmd = [
        "php", "artisan", "tinker", "--execute",
        "echo json_encode(App\\Models\\User::where('roles', 'student')->where('status', 'active')->whereNotNull('email')->whereNotNull('mobile')->take(10)->get(['id', 'name', 'email', 'mobile'])->toArray());"
    ]
    result = subprocess.run(tinker_cmd, capture_output=True, text=True)
    if result.returncode != 0:
        print("❌ Failed to fetch students from database via tinker:")
        print(result.stderr)
        sys.exit(1)
    
    # Strip any potential warning/header output and find JSON array start
    raw_output = result.stdout.strip()
    json_start = raw_output.find("[")
    if json_start == -1:
        print("❌ Could not parse JSON array from tinker output:")
        print(raw_output)
        sys.exit(1)
    
    clean_json = raw_output[json_start:]
    return json.loads(clean_json)

def set_password_for_user(user_id, password="testpassword123"):
    tinker_cmd = [
        "php", "artisan", "tinker", "--execute",
        f"$user = App\\\\Models\\\\User::find({user_id}); $user->password = Hash::make('{password}'); $user->save();"
    ]
    subprocess.run(tinker_cmd, capture_output=True)

def main():
    base_url = "http://192.168.0.15:8000"
    login_url = f"{base_url}/api/studentLogin"
    
    print("=== Fetching 10 Active Students ===")
    students = get_ten_students()
    print(f"Loaded {len(students)} students from database.")
    
    test_password = "testpassword123"
    success_count = 0
    
    for i, student in enumerate(students, 1):
        print(f"\n[{i}/10] Testing Student: {student['name']} (ID: {student['id']})")
        print(f"    Email:  {student['email']}")
        print(f"    Mobile: {student['mobile']}")
        
        # Reset password to a known value for testing
        set_password_for_user(student['id'], test_password)
        
        # Test 1: Login using mobile number
        mobile_payload = {
            "mobile": student['mobile'],
            "password": test_password,
            "fcm_token": "test_fcm"
        }
        status_m, res_m = make_request(login_url, data=mobile_payload)
        
        # Test 2: Login using exact email
        email_payload = {
            "mobile": student['email'],
            "password": test_password,
            "fcm_token": "test_fcm"
        }
        status_e, res_e = make_request(login_url, data=email_payload)
        
        # Test 3: Login using case-insensitive email (UPPERCASE)
        mixed_email = student['email'].upper()
        ci_email_payload = {
            "mobile": mixed_email,
            "password": test_password,
            "fcm_token": "test_fcm"
        }
        status_ci, res_ci = make_request(login_url, data=ci_email_payload)
        
        # Verifications
        mobile_ok = (status_m == 200 and res_m.get("status") == 1)
        email_ok = (status_e == 200 and res_e.get("status") == 1)
        ci_email_ok = (status_ci == 200 and res_ci.get("status") == 1)
        
        if mobile_ok and email_ok and ci_email_ok:
            print("    ✅ Mobile Login: SUCCESS")
            print("    ✅ Email Login (exact): SUCCESS")
            print("    ✅ Email Login (case-insensitive): SUCCESS")
            success_count += 1
        else:
            print("    ❌ LOGIN FAILURES DETECTED:")
            if not mobile_ok:
                print(f"       Mobile Login status: {status_m}, response: {res_m}")
            if not email_ok:
                print(f"       Email Login status: {status_e}, response: {res_e}")
            if not ci_email_ok:
                print(f"       Case-insensitive Login status: {status_ci}, response: {res_ci}")
                
    print(f"\n=== Verification Summary: {success_count}/10 Students Checked Successfully ===")
    if success_count == 10:
        print("🎉 All 10 students logged in successfully with all variations!")
    else:
        sys.exit(1)

if __name__ == "__main__":
    main()
