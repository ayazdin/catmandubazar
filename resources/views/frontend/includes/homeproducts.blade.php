<div class="row mar-bot-30 featured">
    <div class="block-ttl auto-search col-sm-12">
        <h2><span>Our Products</span> <hr></h2>
    </div>
    @foreach($products as $product)
        <?php
        if(!empty($product->image))
            $prodImage = $product->image;
        else
            $prodImage = 'frontend/images/image-not-found.png';
        ?>
        <div class="col-sm-3">
            <div class="wrap ">
                <div class="f-top">
                    <a href="{{ URL::to('product/'.$product->clean_url) }}" title="{{ $product->title }}">
                        <div class="ima" style="background-image:url('{{ URL::to($prodImage) }}')"></div>
                    </a>
                    <div class="switch">
                        <a href="{{ URL::to('product/'.$product->clean_url) }}" title="{{ $product->title }}">
                        <div class="overlay"></div>
                            </a>

                        <div class="button-group">
                            {{--<a href="#" title="Add to Cart" class="addtocart" data-url="http://yala.dac.technocreates.net/product/ajax/add-product/195/1">
                                <i class="fa fa-cart-plus"></i>
                                add to cart
                            </a>--}}
                            <a href="javascript:void(0)" class="addtocart" data-toggle="modal" data-target="#exampleModal_{{$product->id}}">
                                Enquiry
                            </a>
                            <a class="wishlist" href="javascript:void(0)" title="Price">
                                <i class="fa fa-tag"></i>
                                {{ App\Http\Controllers\Frontend\FrontendController::getProductPrice($product->id) }}

                            </a>
                        </div>
                    </div>

                </div>
                <div class="f-right">
                    <h3>
                        <a href="{{ URL::to('product/'.$product->clean_url) }}" title="{{ $product->title }}">
                            {{$product->title}}
                        </a>
                    </h3>
                </div>

                <!-- Modal -->
                <div class="modal fade bd-example-modal-lg" id="exampleModal_{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <form method="post" action="{{route('frontend.productEnquiry')}}">
                                {!! csrf_field() !!}
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Enquiry For: {{$product->title}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                        <input type="hidden" class="form-control" name="productname" value="{{$product->title}}">
                                        {{--<div class="form-group">
                                            <label for="productname" class="col-form-label">Enquiry For:</label>
                                            <input type="text" class="form-control" name="productname" value="{{$product->title}}" disabled>
                                        </div>--}}
                                        <div class="form-group">
                                            <label for="fullname" class="col-form-label">Full Name:</label>
                                            <input type="text" class="form-control" name="fullname" value="">
                                        </div>
                                        <div class="form-group">
                                            <label for="emailid" class="col-form-label">Email Address *:</label>
                                            <input type="email" class="form-control" name="emailid" value="" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone" class="col-form-label">Phone Number:</label>
                                            <input type="text" class="form-control" name="phone" value="">
                                        </div>
                                        <div class="form-group">
                                            <label for="message" class="col-form-label">Message:</label>
                                            <textarea class="form-control" name="message"></textarea>
                                        </div>

                                </div>
                                <div class="modal-footer">
                                <input type="submit" name="submit" class="btn btn-primary" value="Send Enquiry">
                                {{--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
                                {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
                            </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="clear"></div>
            </div>
        </div>
    @endforeach

</div>