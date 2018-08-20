<header>
    <nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse">
        <div class="container">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- <a class="navbar-brand" href="#">Navbar</a> -->

            <div class="collapse navbar-collapse" id="navbarsExampleDefault">

                <a class="hed-logo" href="{{ url('/') }}" title="{{config('app.name')}}" rel="home">
                    {{config('app.name')}}
                    {{--<img src="http://nepalauto.com/wp-content/uploads/2017/05/logo.png" alt="Catmandu Bazar" class="img-responsive">--}}
                </a>


                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ url('/') }}">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                    @if (! $logged_in_user)

                        <li class="nav-item">
                            <a class="nav-link" href="{{route('frontend.auth.login')}}">Login</a>
                        </li>
                        @if (config('access.users.registration'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('frontend.auth.register')}}">Register</a>
                            </li>
                        @endif
                    @endif

                    @if ($logged_in_user)
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('frontend.user.dashboard')}}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('frontend.auth.logout')}}">Logout</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{route('frontend.enquiryList')}}">My Enquiries</a>
                        </li>

                    @endif

                </ul>

            </div>
        </div>
    </nav>
</header>

@if(session()->has('enquirysuccess'))

    <div class="modal fade bd-example-modal-lg" id="enquiryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Enquiry</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    {{ session()->get('enquirysuccess') }}

                </div>
                <div class="modal-footer">
                    {{--<input type="submit" name="submit" class="btn btn-primary" value="Send Enquiry">--}}
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
                </div>
            </div>
        </div>
    </div>

@endif
