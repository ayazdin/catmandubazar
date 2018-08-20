@extends('frontend.layouts.app')

@section('title', app_name() . ' | Enqyiry - '.$logged_in_user->name )

@section('content')
    <section class="contactblock padding">
        <div class="container">
            <div class="row userform">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <h2 class="fa-4">Enquiry</h2>
                        <div class="panel-body">
                            <div class="row">
                                @forelse($enquiries as $enquiry)
                                    <div class="col-md-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4>{{$enquiry->productname}}</h4>
                                            </div><!--panel-heading-->

                                            <div class="panel-body">
                                                <ul class="media-list">
                                                    <li class="media">
                                                        <div class="media-left">
                                                            Full Name :
                                                        </div><!--media-left-->

                                                        <div class="media-body">
                                                            {{$enquiry->name}}
                                                        </div><!--media-body-->
                                                    </li><!--media-->
                                                    <li class="media">
                                                        <div class="media-left">
                                                            Email Address :
                                                        </div><!--media-left-->
                                                        <div class="media-body">
                                                            {{$enquiry->email}}
                                                        </div><!--media-body-->
                                                    </li><!--media-->
                                                    <li class="media">
                                                        <div class="media-left">
                                                            Phone number :
                                                        </div><!--media-left-->
                                                        <div class="media-body">
                                                            {{$enquiry->phone}}
                                                        </div><!--media-body-->
                                                    </li><!--media-->
                                                    <li class="media">
                                                        <div class="media-left">
                                                            Enquiry Date :
                                                        </div><!--media-left-->
                                                        <div class="media-body">
                                                            <?php
                                                            $date = strtotime($enquiry->created_at);
                                                            ?>
                                                            {{date('Y-m-d',$date)}}

                                                        </div><!--media-body-->
                                                    </li><!--media-->
                                                    <li class="media">
                                                        <div class="media-left">
                                                            Message :
                                                        </div><!--media-left-->
                                                        <div class="media-body">
                                                            {{$enquiry->message}}
                                                        </div><!--media-body-->
                                                    </li><!--media-->

                                                </ul>

                                            </div><!--panel-body-->
                                        </div><!--panel-->
                                    </div>
                                @empty
                                    No Order Made
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection