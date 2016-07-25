<?php
if (Auth::check())
{
    $role_id = Auth::user()->user_role;
    $getfrom_roletb = DB::table('ec_user_role')->where('id',$role_id)->first();
    $log_id = explode(',',$getfrom_roletb->credential_list);
    Session::put('log_id', $log_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Everest Cleaning</title>
    <link rel="icon" href="{!! asset('images/favicon.png') !!}">
    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
     <link href="{!! asset('css/everest_style.css') !!}" media="all" rel="stylesheet" type="text/css" />
     <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
   
</head>
<body id="app-layout">
    <nav class="navbar navbar-default navbar-static-top">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/home') }}"><img src="{!! asset('images/everest-logo.png') !!}" style="width:200px;"/></a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right" style="margin-right:50px;padding-top:20px;">
                   
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->full_name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>                   
                </ul>
            </div>
    </nav>    
 <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 left-menu-wrapper">
          <ul class="nav nav-sidebar">
            <li class="active"><a href="{{ url('/home') }}"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard <span class="sr-only">(current)</span></a></li>
	    <li>
		@if(in_array(5,$log_id))
		<a href="{{ url('/user/'.Auth::user()->id) }}"><i class="fa fa-user" aria-hidden="true"></i>My Profile</a>
		@endif
		@if(in_array(13,$log_id))
		<a href="{{ url('/user') }}"><i class="fa fa-users" aria-hidden="true"></i> User List</a>
		@endif
	    </li>
            <li>
		@if(in_array(6,$log_id))
		<a href="{{ url('/payroll/'.Auth::user()->id) }}" class><i class="fa fa-money" aria-hidden="true"></i> View My Payroll</a>
		@endif
		@if(in_array(12,$log_id))
                <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-money" aria-hidden="true"></i> Payroll <i class="fa fa-angle-down place_right"></i></a>
                        <ul id="demo" class="collapse">
                            <li>
                                <a href="{{ url('/payroll/create') }}" class>Generate Payroll</a>
                            </li>
                            <li>
                                <a href="{{ url('/payroll/list') }}">View</a>
                            </li>
			    <li>
				<a href="{{ url('/payroll/search') }}">Search payroll</a>
			    </li>
                        </ul>
	        @endif
             </li>
	     <li>
		@if(in_array(11,$log_id))
                <a href="javascript:;" data-toggle="collapse" data-target="#demo1"><i class="fa fa-cog" aria-hidden="true"></i> Setting <i class="fa fa-angle-down place_right"></i></a>
		    <ul id="demo1" class="collapse">
			<li>
			    <a href="{{ url('/cpf') }}" class>CPF</a>
			</li>
			 <li>
			    <a href="{{ url('/agency') }}">Agency</a>
			</li>
			<li>
			    <a href="{{ url('/country') }}">Country</a>
			</li>
			<li>
			    <a href="{{ url('/nationality') }}">Nationality</a>
			</li>
			  <li>
			    <a href="{{ url('/race') }}">Race</a>
			</li>
			</li>
			  <li>
			    <a href="{{ url('/workshift') }}">Work shift</a>
			</li>
			 <li>
			    <a href="{{ url('/passstatus') }}">Pass Status</a>
			</li>
		    </ul>
		    @endif
             </li>
            <li>
		@if(in_array(9,$log_id))
		<a href="{{ url('/userrole')}}"><i class="fa fa-user" aria-hidden="true"></i> User Role</a>
		@endif
        @if(in_array(9,$log_id))
        <a href="{{ url('/client')}}"><i class="fa fa-user" aria-hidden="true"></i> Client</a>
        <a href="{{ url('/project')}}"><i class="fa fa-file" aria-hidden="true"></i> Project</a>
        <a href="{{ url('/invoice')}}"><i class="fa fa-file" aria-hidden="true"></i> Invoice</a>
        @endif
		</li>
          </ul>
        </div>   
	@yield('content')   
      </div>
 </div>
   
    <footer class="footer">
	&copy; <?php echo date('Y'); ?>	
    </footer>
    
    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
    <script src="{!! asset('js/custom.js') !!}"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.js"></script>
     <!-- include summernote css/js-->
    
     <script>
        $(document).ready(function() {
            $('.summernote').summernote({
               height: 200,             
              minHeight: null,      
              maxHeight: null,       
              focus: true,
               toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
              ]                
            });
        });
     </script>
</body>
</html>
<?php
}
else{
    return Redirect::guest('users/login');
}
