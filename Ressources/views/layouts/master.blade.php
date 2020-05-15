<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}">
    <head>

        <title>{{env('APP_NAME')}}</title>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="robots" content="noindex,nofollow">

        <!-- Global style -->
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">

        <!-- Fonts -->
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" crossorigin="anonymous">

        <!-- Jquery -->
        <script src="{{ asset('backender/contents/plugins/jquery/jquery-3.2.1.min.js') }}"></script>

        <!-- Toastr -->
        <script src="{{ asset('backender/contents/plugins/toastr/toastr.min.js') }}"></script>
        <link href="{{ asset('backender/contents/plugins/toastr/toastr.min.css')}}" rel="stylesheet" media="all"  />

        <!-- Bootbox -->
        <script src="{{ asset('backender/contents/plugins/bootbox/bootbox.min.js') }}"></script>

        @include('backender:ui::layouts.jsconst')

        <!-- Language -->
        <script src="{{ asset('backender/contents/js/lang.dist.js') }}"></script>

        <script>
            Lang.setLocale('{{App::getLocale()}}');
        </script>

        <!-- code to fix jquery slowing down the browser -->
        <script>
          $(function(){
            jQuery.event.special.touchstart = {
              setup: function( _, ns, handle ){
                if ( ns.includes("noPreventDefault") ) {
                  this.addEventListener("touchstart", handle, { passive: false });
                } else {
                  this.addEventListener("touchstart", handle, { passive: true });
                }
              }
            };

            var error = "";

            @if(isset($errors))
                @if (count($errors) > 0)
                    @foreach ($errors->all() as $error)
                        error += "- {{$error}}<br/>";
                    @endforeach
                @endif
            @endif

            @if(Session::has('notify_error'))
                error += "- {{ Session::get('notify_error') }}<br/>";
            @endif

            if(error != '')
              toastr.error(error, 'Error', {timeOut: 10000});

            @if(Session::has('notify_success'))
              toastr.success("{{ Session::get('notify_success') }}", 'Success', {timeOut: 3000});
            @endif
          });
        </script>

        <!-- App -->
        <link rel="stylesheet" media="all" href="{{ asset('/backender/contents/css/app.css')}}" />
        <script src="{{ asset('backender/contents/js/app.js') }}" defer></script>

        @stack('stylesheets')

        @stack('plugins')
    </head>

    <body>

        <div id="app">

            @yield('modal')

            <section id="wrapper">
                <section id="main">
                    @if(Auth::user())
                        @if(!isset($hideTopbar) || (isset($hideTopbar) && $hideTopbar === false))
        	        	      @include('backender:ui::layouts.topbar')
                        @endif
                    @endif

    	        	<section id="content">
    	        		@yield('content')
    	        	</section>
    	        </section>
            </section>

        </div>

        @include('backender:ui::partials.styles.back')

        @stack('javascripts-libs')

        @stack('javascripts')

    </body>

</html>
