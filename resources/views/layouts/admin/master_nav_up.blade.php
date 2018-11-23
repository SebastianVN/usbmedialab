		<!-- begin #header -->
		<div id="header" class="header navbar navbar-inverse navbar-fixed-top">
			<!-- begin container-fluid -->
			<div class="container-fluid">
				<!-- begin mobile sidebar expand / collapse button -->
				<div class="navbar-header">
					<a href="index.html" class="navbar-brand"><span class="navbar-logo"></span> USB MediaLab</a>
					<button type="button" class="navbar-toggle" data-click="sidebar-toggled">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<!-- end mobile sidebar expand / collapse button -->
				
				<!-- begin header navigation right -->
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown navbar-user">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							 <b class="caret"></b>
						</a>
						<ul class="dropdown-menu animated fadeInLeft">
							<li class="arrow"></li>
							<li><a href="{{ url('Mr_Administrator/messages') }}"> Inbox</a></li>
							<li class="divider"></li>
							<li>
								<a href="{{ url('/logout') }}"
								    onclick="event.preventDefault();
								             document.getElementById('logout-form').submit();">
								    <i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar Sesión
								</a>

								<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
								    {{ csrf_field() }}
								</form>
							</li>
						</ul>
					</li>
				</ul>
				<!-- end header navigation right -->
			</div>
			<!-- end container-fluid -->
		</div>
		<!-- end #header -->