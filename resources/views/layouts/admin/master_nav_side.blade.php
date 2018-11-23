		<!-- begin #sidebar -->
		<div id="sidebar" class="sidebar">
			<!-- begin sidebar scrollbar -->
			<div data-scrollbar="true" data-height="100%">
				<!-- begin sidebar user -->
				<ul class="nav">
					<li class="nav-profile">
						<div class="info">
						</div>
					</li>
				</ul>
				<!-- end sidebar user -->
				<!-- begin sidebar nav -->
				<ul class="nav">
					<li class="nav-header">Opciones Administrativas</li>
					<li><a href="{{ url('Mr_Administrator') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
					@if(Auth::user()->level == 32)
					<li>
						<a href="{{ url('Mr_Administrator/sudo') }}">
						    <i class="fa fa-users"></i>
						    <span>SUDO</span>
					    </a>
					</li>
					@endif
					<li>
						<a href="{{ url('Mr_Administrator/users') }}">
						    <i class="fa fa-users"></i>
						    <span>Usuarios</span>
					    </a>
					</li>
					<li>
						<a href="{{ url('Mr_Administrator/proyectos') }}">
						    <i class="fa fa-users"></i>
						    <span>Proyectos</span>
					    </a>
					</li>
					<li>
						<a href="{{ url('Mr_Administrator/semilleros') }}">
						    <i class="fa fa-users"></i>
						    <span>Semilleros</span>
					    </a>
					</li>
					<li class="has-sub">
						<a href="javascript:;">
						    <b class="caret pull-right"></b>
						    <i class="fa fa-sitemap"></i>
						    <span>Páginas</span>
					    </a>
						<ul class="sub-menu">
						    <li><a href="{{ url('Mr_Administrator/site') }}">Administrar Paginas</a></li>
						    <li><a href="{{ url('Mr_Administrator/site/reports') }}">Reportes</a></li>
						</ul>
					</li>
			        <!-- begin sidebar minify button -->
					<li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
			        <!-- end sidebar minify button -->
				</ul>
				<!-- end sidebar nav -->
			</div>
			<!-- end sidebar scrollbar -->
		</div>
		<div class="sidebar-bg"></div>
		<!-- end #sidebar -->