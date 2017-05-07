@extends(config('userization.master_template'))
@section(config('userization.content_area'))
    <!-- SELECT2 EXAMPLE -->
    <div class="panel panel-info">
        <div class="panel-header">
            @if(isset($routes))
                <div class="col-xs-6">
                    <div class="btn check hiddenbutton">
                        <input type="checkpanel" id="checkAll" style="display: none;"/>
                        <label for="checkAll" style="color:#00bf00;">
                            <img src="https://img.clipartfest.com/fa7bcce74062b922d48c582907f428fa_green-check-clipart-clipart-green-check_582-596.png" style="height:40px; width:40px;">Check All
                            Check All
                        </label>
                    </div>
                    <div class="btn uncheck hiddenbutton"style="display:none;">
                        <input type="checkpanel" id="uncheckAll" style="display: none;"/>
                        <label for="uncheckAll" style="color:#9f191f;">
                            <img src="http://www.myiconfinder.com/uploads/iconsets/256-256-4c515d45f6a8c4fe16e448a692a9370d.png" style="height:40px; width:40px;">
                            Uncheck
                        </label>
                    </div>
                </div>
                <div class="col-xs-6">
                    <form id="live-search" action="" class="styled" method="post">
                        <fieldset>
                            <input type="text" class="form-control text-input" placeholder="Please Enter Keyword" id="filter" value="" />
                        </fieldset>
                    </form>
                </div>
            @endif
        </div>
        <!-- /.panel-header -->
        {!! Form::open(['route'=>'role_permission.store','method'=>'post']) !!}
        <div class="col-xs-12">
            {!! Form::submit('Save',['class'=>'btn btn-success pull-right']) !!}
        </div>
        <div class="panel-body">
            <div class="row">
                <?php $div=0; ?>
                <div class="col-md-3 search">
                    @if(isset($routes))
                        @foreach($routes as $id=>$route)
                            <input type="hidden" name="role_id" value="{!! $role_id !!}">
                            <label for="{!! $route->id !!}">
                                <input type="checkpanel" id="{!! $route->id !!}"  name="routes[{!! $route->id !!}]" class="checksearch">
                                @if(config('authorization.route_index')=='uri')
                                    {!! $route->route_uri !!}
                                @endif
                                @if(isset($route->title))
                                    @if(config('userization')=='title')
                                        <b>{!! $route->title !!}</b>
                                    @endif
                                @endif
                                @if(isset($route->route_name))
                                    @if(config('authorization.route_index')=='as')
                                        <b>({!! $route->route_name !!})</b>
                                    @endif
                                @endif
                            </label>
                </div><div class="col-md-3 search">
                    @endforeach
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    {!! Form::submit('Save',['class'=>'btn btn-success pull-right']) !!}
                </div>
                @else
                    <b>Route Dose not exist.</b>
                @endif

                <div class="col-xs-6">
                    <a href="{!! route('role_permission.index',$role_id) !!}" class="btn btn-danger">Cancel</a>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
        <!-- /.panel-body -->
        <div class="panel-footer">
            {{--Visit <a href="https://select2.github.io/">Select2 documentation</a> for more examples and information about--}}
            {{--the plugin.--}}
        </div>
    </div>

    // script here
    <script>
        $(function(){
            $("#checkAll").change(function () {

                $("input:checkpanel:visible").prop('checked',$(this).prop("checked"));
                $(".check").hide();
                $(".uncheck").show();
            });

            $("#uncheckAll").change(function () {
                $("input:checkpanel:visible").prop('checked',$(this).prop("checked"));
                $(".uncheck").hide();
                $(".check").show();
            });
        });


        ///search
        $(document).ready(function(){
            $("#filter").keyup(function(){


                // Retrieve the input field text and reset the count to zero
                var filter = $(this).val(), count = 0;
                // Loop through the comment list
                $(".search").each(function(){
                    // If the list item does not contain the text phrase fade it out
                    if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                        $(this).fadeOut();
                        // Show the list item if the phrase matches and increase the count by 1
                    }
                    else {
                        $(this).show();
                        count++;
                    }
                });
                var numberItems = count;
                $("#filter-count").text("Number of Comments = "+count);
            });
        });
    </script>
@endsection