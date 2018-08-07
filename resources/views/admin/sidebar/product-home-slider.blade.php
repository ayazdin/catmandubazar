<div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Home Slider</h3>
    </div>
    <div class="box-body">
        <div class="form-group no-mar">
          <div class="col-sm-12">
            <div class="category-list">
              <ul>
                @if(!empty($sliders))
                  @foreach($sliders as $slide)
                  <?php  //$pArr= explode(",", $slide['prods']);?>
                    <li>
                      <label>
                        @if(!empty($slide['prods']) and is_array($slide['prods']))
                          @if(isset($post) and in_array($post->id, $slide['prods']))
                            <input type="checkbox" name="sliders[]" checked value="{{$slide['ID']}}">
                          @else
                            <input type="checkbox" name="sliders[]" value="{{$slide['ID']}}">
                          @endif
                        @else
                          @if(!empty($slide['prods']) and $post->id == $slide['prods'])
                            <input type="checkbox" name="sliders[]" checked value="{{$slide['ID']}}">
                          @else
                            <input type="checkbox" name="sliders[]" value="{{$slide['ID']}}">
                          @endif
                        @endif
                      </label> {{$slide['Title']}}
                    </li>
                  @endforeach
                @endif
              </ul>
            </div>
          </div>
        </div>
    </div>
</div>
