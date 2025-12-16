<footer class="footer bg-dark mt-auto py-3 text-white">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="logo">
                    <img class="img-fluid" src="{{ asset('logos/logo-transparent.png') }}"
                        alt="Test & Notes Logo" style="max-width:214px">
                </div>
                <p class="mt-2" style="font-family: 'Cookie', cursive;">Dedicated Online Test Platform
                    For Institutions</p>
                <h6 style="color:#ff6600">Weblies Equations Pvt. Ltd.</h6>
                <address>
                    Green Boulevard, 5th Floor, Tower C <br>
                    Block B, Sector 62, Noida <br>
                    Uttar Pradesh, 201301
                </address>
                <p>Email: <a class="text-white"
                        href="mailto:support@testandnotes.com">support@testandnotes.com</a></p>
                <p>Mobile: 9335334045 (Monday to Friday)<br>
                    10:30 AM - 6:30 PM</p>
            </div>
            <div class="col-md-3">
                <h5 class="text-uppercase text-white" style="font-family:Sansita">Our Terms & Policies
                </h5>
                <ul class="list-unstyled">
                    <li><a class="text-white" href="{{ route('about_us') }}">About Us</a></li>
                    <li><a class="text-white" href="#">Free for You</a></li>
                    <li><a class="text-white" href="#">Compitition</a></li>
                    <li><a class="text-white" href="#">Academics</a></li>
                    <li><a class="text-white" href="#">Govt Jobs</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h5 class="text-uppercase text-white" style="font-family:Sansita">FAQ’s & Policies</h5>
                <ul class="list-unstyled">
                    <li><a class="text-white" href="{{ route('faqs') }}">FAQ’s</a></li>
                    <li><a class="text-white" href="{{ route('important_links') }}">Important Links</a></li>
                    <li><a class="text-white" href="{{ route('policy-page', ['policy-and-terms']) }}">User
                            Policy &
                            Terms</a></li>
                    <li><a class="text-white" href="{{ route('policy-page', ['privacy-policy']) }}">Website
                            Privacy
                            Policy</a></li>
                    <li><a class="text-white"
                            href="{{ route('policy-page', ['terms-and-conditions']) }}">Website Terms &
                            Conditions</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h5 class="text-uppercase text-white" style="font-family:Sansita">Important Links</h5>
                <ul class="list-unstyled">
                    <li><a class="text-white" href="{{ route('bussines_enquiry') }}">Become Our Education
                            Partner</a></li>
                    <li><a class="text-white" href="{{ route('franchise.login') }}">Corporate Login</a>
                    </li>
                    {{-- <li><a class="text-white" href="#">Student Sign up</a></li>
                    <li><a class="text-white" href="#">Student Login</a></li> --}}
                    <li><a class="text-white" href="#">Contributor Sign up</a></li>
                    <li><a class="text-white" href="#">Contributor Login</a></li>
                    <li><a class="text-white" href="{{ route('contact_us') }}">Contact Us For Any
                            Query</a></li>
                </ul>
            </div>
        </div>
        <hr>
        <div class="text-center">
            <p>Copyright &copy; 2024 SQS Foundation. All rights reserved.</p>
        </div>
    </div>
</footer>
