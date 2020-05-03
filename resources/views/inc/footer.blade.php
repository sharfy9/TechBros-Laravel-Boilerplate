<footer class="footer">
    <div class=" container-fluid ">
        <nav>
            <ul>
                <li>
                    <a href="{{config('dev.docs.url')}}" target="_blank">
                        {{__(" Documentation")}}
                    </a>
                </li>
                <li>
                    <a href="{{config('dev.support.url')}}" target="_blank">
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
        <div class="copyright" id="copyright">
            &copy; {{date("Y")}} <a href="{{config('dev.company.url')}}"
                target="_blank">{{config('dev.company.name')}}</a>. {{__("All Rights Reserved By")}}
            <a href="{{config('dev.author.url')}}" target="_blank">{{config('dev.author.name')}}</a>
        </div>
    </div>
</footer>
