<footer class="footer">
    <div class=" container-fluid ">
        @auth
        <nav>
            <ul>
                <li>
                    <a href="{{config('techbros.docs.url')}}" target="_blank">
                        {{__(" Documentation")}}
                    </a>
                </li>
                <li>
                    <a href="{{config('techbros.support.url')}}" target="_blank">
                        {{__(" Support")}}
                    </a>
                </li>
                <li>
                    <a href="#" data-toggle="modal" data-target="#feedbackModal">
                        {{__(" Feedback")}}
                    </a>
                </li>
                <li>
                    <a href="#" data-toggle="modal" data-target="#helpModal">
                        {{__(" Help")}}
                    </a>
                </li>
            </ul>
        </nav>
        @else
        @if (config('techbros.recaptcha'))
        <small class="text-muted">
            This site uses reCAPTCHA and the Google
            <a href="https://policies.google.com/privacy">Privacy Policy</a> and
            <a href="https://policies.google.com/terms">Terms of Service</a> apply.
        </small>
        @endif
        @endauth

        <div class="copyright" id="copyright">
            &copy; {{date("Y")}} <a href="{{config('techbros.company.url')}}"
                target="_blank">{{config('techbros.company.name')}}</a>. {{__("All Rights Reserved By")}}
            <a href="{{config('techbros.author.url')}}" target="_blank">{{config('techbros.author.name')}}</a>
        </div>
    </div>
</footer>
