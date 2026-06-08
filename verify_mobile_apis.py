#!/usr/bin/env python3
import json
import urllib.request
import urllib.error
import sys
import argparse

def make_request(url, method="GET", data=None, headers=None):
    if headers is None:
        headers = {}
    
    req_data = None
    if data is not None:
        req_data = json.dumps(data).encode("utf-8")
        headers["Content-Type"] = "application/json"
    
    headers["Accept"] = "application/json"
    
    req = urllib.request.Request(url, data=req_data, headers=headers, method=method)
    
    try:
        with urllib.request.urlopen(req) as response:
            res_data = response.read().decode("utf-8")
            return response.status, json.loads(res_data)
    except urllib.error.HTTPError as e:
        try:
            err_data = e.read().decode("utf-8")
            return e.code, json.loads(err_data)
        except Exception:
            return e.code, {"message": str(e)}
    except Exception as e:
        return 500, {"message": str(e)}

def run_tests():
    parser = argparse.ArgumentParser(description="Test mobile APIs.")
    parser.add_argument("--url", default="http://192.168.0.15:8000", help="Base URL of the Laravel app")
    parser.add_argument("--identifier", default="sahil@siddiqui.com", help="Email or Mobile for login")
    parser.add_argument("--password", default="password", help="Password for login")
    args = parser.parse_args()

    base_url = args.url.rstrip('/')
    print(f"=== Starting Mobile API Verification ===")
    print(f"Target URL: {base_url}")
    print(f"Login Identifier: {args.identifier}")

    # 1. Test Login (both exact email/mobile and case-insensitive email)
    login_url = f"{base_url}/api/studentLogin"
    login_payload = {
        "mobile": args.identifier,
        "password": args.password,
        "fcm_token": "test_fcm_token"
    }

    print("\n[1] Testing Student Login API...")
    status, res = make_request(login_url, method="POST", data=login_payload)
    if status != 200 or res.get("status") != 1:
        print(f"❌ Login Failed (Status: {status}, Response: {res})")
        sys.exit(1)
    
    print("✅ Login Successful!")
    token = res["data"]["token"]
    user = res["data"]["user_details"]
    print(f"   Name: {user.get('name')}")
    print(f"   Role: {user.get('roles')}")
    print(f"   Franchise Code: {user.get('franchise_code')}")
    print(f"   Institute Name: {user.get('institute_name')}")
    print(f"   Token: {token[:15]}...")

    # Test Case Insensitivity if identifier is email
    if "@" in args.identifier:
        print("\n[1b] Testing Email Login Case-Insensitivity...")
        mixed_email = args.identifier.upper() if args.identifier.islower() else args.identifier.lower()
        print(f"   Attempting with mixed-case email: {mixed_email}")
        status_ci, res_ci = make_request(login_url, method="POST", data={
            "mobile": mixed_email,
            "password": args.password,
            "fcm_token": "test_fcm_token"
        })
        if status_ci == 200 and res_ci.get("status") == 1:
            print("✅ Email Login Case-Insensitivity Works!")
        else:
            print(f"❌ Email Login Case-Insensitivity Failed! (Status: {status_ci}, Response: {res_ci})")

    headers = {"Authorization": f"Bearer {token}"}

    # 2. Get Homepage Data
    print("\n[2] Testing GET /api/gethomepagedata...")
    status, res = make_request(f"{base_url}/api/gethomepagedata", headers=headers)
    if status == 200 and res.get("status") == 1:
        data = res.get("data", {})
        print("✅ Homepage Data Loaded Successfully!")
        print(f"   Slider Packages Count: {len(data.get('slider_packages', []))}")
        print(f"   Banner Packages Count: {len(data.get('banner_packages', []))}")
        print(f"   Test Categories Count: {len(data.get('test_categories', []))}")
    else:
        print(f"❌ Homepage Data Load Failed (Status: {status}, Response: {res})")

    # 3. Get My Packages
    print("\n[3] Testing GET /api/getMyPackages...")
    status, res = make_request(f"{base_url}/api/getMyPackages", headers=headers)
    package_id = None
    if status == 200 and res.get("status") == 1:
        packages = res.get("data", [])
        print(f"✅ My Packages Loaded Successfully! Count: {len(packages)}")
        if packages:
            package_id = packages[0].get("id")
            print(f"   First Package ID: {package_id} ({packages[0].get('plan_name')})")
    else:
        print(f"❌ My Packages Load Failed (Status: {status}, Response: {res})")

    # 4. Get Package Details
    if package_id:
        print(f"\n[4] Testing GET /api/getPackageDetails?id={package_id}...")
        status, res = make_request(f"{base_url}/api/getPackageDetails?id={package_id}", headers=headers)
        if status == 200 and res.get("status") == 1:
            data = res.get("data", {})
            print("✅ Package Details Loaded Successfully!")
            print(f"   Tests Count: {len(data.get('tests', []))}")
            print(f"   Notes Count: {len(data.get('notes', []))}")
            print(f"   Videos Count: {len(data.get('videos', []))}")
            print(f"   GK Count: {len(data.get('gk', []))}")
        else:
            print(f"❌ Package Details Load Failed (Status: {status}, Response: {res})")
    else:
        print("\n[4] Skipping Package Details Test (No Package enrolled for this student)")

    # 5. Get Tests List
    print("\n[5] Testing GET /api/getTests...")
    status, res = make_request(f"{base_url}/api/getTests", headers=headers)
    test_id = None
    if status == 200 and res.get("status") == 1:
        tests = res.get("data", {}).get("data", [])
        print(f"✅ Tests List Loaded Successfully! Count: {len(tests)}")
        if tests:
            test_id = tests[0].get("id")
            print(f"   First Test ID: {test_id} ({tests[0].get('title')}) - Attempt Status: {tests[0].get('attempt_status')}")
    else:
        print(f"❌ Tests List Load Failed (Status: {status}, Response: {res})")

    # 6. Get Test Details
    if test_id:
        print(f"\n[6] Testing GET /api/getTestDetails?test_id={test_id}...")
        status, res = make_request(f"{base_url}/api/getTestDetails?test_id={test_id}", headers=headers)
        if status == 200 and res.get("status") == 1:
            data = res.get("data", {})
            print("✅ Test Details Loaded Successfully!")
            print(f"   Questions Count: {len(data.get('questions', []))}")
            print(f"   Sections Count: {len(data.get('sections', []))}")
            print(f"   Status: {data.get('status')}")
        else:
            print(f"❌ Test Details Load Failed (Status: {status}, Response: {res})")
    else:
        print("\n[6] Skipping Test Details Test (No tests found)")

    # 7. Get Premium Data
    print("\n[7] Testing GET /api/getPremiumData...")
    status, res = make_request(f"{base_url}/api/getPremiumData", headers=headers)
    if status == 200 and res.get("status") == 1:
        plans = res.get("data", [])
        print(f"✅ Premium Plans Loaded Successfully! Count: {len(plans)}")
    else:
        print(f"❌ Premium Plans Load Failed (Status: {status}, Response: {res})")

    # 8. Get Attempted Tests
    print("\n[8] Testing GET /api/getAttemptedTests...")
    status, res = make_request(f"{base_url}/api/getAttemptedTests", headers=headers)
    if status == 200 and res.get("status") == 1:
        att = res.get("data", [])
        print(f"✅ Attempted Tests Loaded Successfully! Count: {len(att)}")
    else:
        print(f"❌ Attempted Tests Load Failed (Status: {status}, Response: {res})")

    # 9. Get General States/Cities (Auth not required typically, but good to check)
    print("\n[9] Testing General Data APIs (states)...")
    status, res = make_request(f"{base_url}/api/states")
    if status == 200 and res.get("status") == 1:
        print(f"✅ States Loaded. Count: {len(res.get('data', []))}")
    else:
        print(f"❌ States Load Failed (Status: {status}, Response: {res})")

    print("\n=== API Verification Complete ===")

if __name__ == "__main__":
    run_tests()
