<nav class="navbar navbar-default" id="table_nav">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs_table" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand visible-xs" href="#">Menu</a>
    </div>

    <div class="collapse navbar-collapse" id="bs_table">
        <ul class="nav navbar-nav">
            @yield('options')
        </ul>
        @yield('actions')
        <form class="navbar-form navbar-right" method="get" action="{{request()->url()}}">
            <div class="form-group">
                <input type="text" name="key" value="{{request()->get('key')}}" class="form-control" placeholder="{{trans('search')}}">
            </div>
            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
        </form>
    </div><!-- /.navbar-collapse -->
</nav>

