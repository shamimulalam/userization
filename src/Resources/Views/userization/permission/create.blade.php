@extends(config('userization.master_template'))
@section(config('userization.content_area'))

    <!-- SELECT2 EXAMPLE -->
    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-8">
                    <h4>Add new permissions</h4>
                </div>
                <div class="col-xs-4">
                    <form id="live-search" action="" class="styled" method="post">
                        <fieldset>
                            <input type="text" class="form-control text-input" placeholder="Please Enter Keyword"
                                   id="filter" value=""/>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.panel-heading -->
        {!! Form::open(['route'=>'permission.store','method'=>'post','files'=> true]) !!}
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-8">
                    <div class="btn check hiddenbutton">
                        <input type="checkbox" id="checkAll" style="display: none;"/>
                        <label for="checkAll" style="color:#00bf00;">
                            <img src="https://img.clipartfest.com/fa7bcce74062b922d48c582907f428fa_green-check-clipart-clipart-green-check_582-596.png"
                                 style="height:40px; width:40px;">
                            Check All
                        </label>
                    </div>
                    <div class="btn uncheck hiddenbutton" style="display:none;">
                        <input type="checkbox" id="uncheckAll" style="display: none;"/>
                        <label for="uncheckAll" style="color:#9f191f;">
                            <img src="http://www.myiconfinder.com/uploads/iconsets/256-256-4c515d45f6a8c4fe16e448a692a9370d.png"
                                 style="height:40px; width:40px;">
                            Uncheck
                        </label>
                    </div>
                </div>
                <div class="col-xs-4">
                    {!! Form::submit('Save',['class'=>'btn btn-success pull-right']) !!}
                </div>

            </div>
            <div class="row">
                @foreach($routes as $id=>$route)
                    <div class="col-md-3 search">
                        <label for="{!! $id !!}">
                            <input type="checkbox" id="{!! $id !!}" name="routes[{!! $route->uri() !!}]">
                            @if(config('userization.route_index')=='uri')
                                {!! $route->uri() !!}
                            @endif
                            @if(isset($route->action['title']))
                                @if(config('userization.route_index')=='title')
                                    <b>{!! $route->action['title'] !!}</b>
                                @endif
                                <input type="hidden" name="route_titles[{!! $route->uri() !!}]"
                                       value="{!! $route->action['title'] !!}">
                            @endif
                            @if(isset($route->action['as']))
                                @if(config('userization.route_index')=='as')
                                    <b>{!! $route->action['as'] !!}</b>
                                @endif
                                <input type="hidden" name="route_names[{!! $route->uri() !!}]"
                                       value="{!! $route->action['as'] !!}">
                            @endif
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    <!-- /.panel-body -->
        <div class="panel-footer">
            <div class="row">
                <div class="col-xs-6">
                    {!! Form::submit('Save',['class'=>'btn btn-success pull-right']) !!}

                </div>
                <div class="col-xs-6">
                    <a href="{!! route('permission.index') !!}" class="btn btn-danger"
                       onclick="return confirm('Are you confirm to cancel !')">Cancel</a>
                </div>
            </div>
            {{--Visit <a href="https://select2.github.io/">Select2 documentation</a> for more examples and information about--}}
            {{--the plugin.--}}
        </div>

        {!! Form::close() !!}
    </div>
    {{-- Scripts --}}
    <script>
        $(function () {
            $("#checkAll").change(function () {
                $("input:checkbox:visible").prop('checked', true);
                $(".check").hide();
                $(".uncheck").show();
            });
            $("#uncheckAll").change(function () {
                $("input:checkbox:visible").prop('checked', false);
                $(".uncheck").hide();
                $(".check").show();
            });

        });

        ///search
        $(document).ready(function () {
            $("#filter").keyup(function () {
//                $('.hiddenbutton').hide();
                // Retrieve the input field text and reset the count to zero
                var filter = $(this).val(), count = 0;
                // Loop through the comment list
                $(".search").each(function () {

                    // If the list item does not contain the text phrase fade it out
                    if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                        $(this).fadeOut();
//                        $('.permissions').removeClass('hiddenPermission');

                        // Show the list item if the phrase matches and increase the count by 1
                    } else {
                        $(this).addClass('hiddenPermission');
                        $(this).show();
                        count++;
                    }
                });

                // Update the count
                var numberItems = count;
                $("#filter-count").text("Number of Comments = " + count);
            });
        });
    </script>
@endsection
