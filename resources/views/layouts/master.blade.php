
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>USB Media Lab</title>

    <!-- Bootstrap core CSS -->
    <link href="http://localhost/usbmedialab/resources/assets/css/bootstrap.min.css" rel="stylesheet">

    <!--Icono title-->
    <link rel="shortcut icon" type="image/x-icon" href="http://localhost/usbmedialab/resources/assets/img/icontitle.png" />

<!--Iconos personalizados-->
<link href="http://localhost/usbmedialab/resources/assets/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="http://localhost/usbmedialab/resources/assets/css/estilo_home.css" rel="stylesheet">

  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" >
      <div class="container-fluid ">
        <!--Icono navbar-->
      <a class="navbar-brand" href="#inicio">
      <img src="http://localhost/usbmedialab/resources/assets/img/logom.png" alt="minilogo" width="80" height="auto">
      </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Investigación
            </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item text-primary disabled" href="#investigacion" >Semilleros</a>
          <a class="dropdown-item" href="animov"> Animov</a>
          <a class="dropdown-item" href="gamedev"> Gamedev</a>
          <a class="dropdown-item" href="cabalas">Cábalas de software</a>
          <a class="dropdown-item" href="tecnosoft">Tecnosoft</a>
               <div class="dropdown-divider"></div>
          <a class="dropdown-item text-primary disabled" href="#grupos_inv">Grupos</a>
          <a class="dropdown-item" href="solsytec">Solsytec</a>
        </div>
      </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Difusión
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item text-primary disabled" href="#medios" >Medios</a>
            <a class="dropdown-item" href="tv">Medialab TV</a>
            <a class="dropdown-item" href="emisora">Emisora USB</a>
          </div>
        </li>
            <li class="nav-item">
              <a class="nav-link " href="#eventos">Eventos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="#servicios">Servicios</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="#categorias">Galería</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="#">Quienes somos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="#miembros">Miembros</a>
            </li>

            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                    <li class="nav-item">
                      <a class="nav-link " href="/perfil"><span class="glyphicon glyphicon-user"></span>{{ Auth::user()->name }}</a>
                    </li>
                    <li class="nav-item">
      								<a class="nav-link" href="{{ url('/logout') }}"
      								    onclick="event.preventDefault();
      								             document.getElementById('logout-form').submit();" class="nav-link"> Cerrar Sesión
      								</a>
      								<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
      								    {{ csrf_field() }}
      								</form>
                    </li>
                    <li class="nav-item">
                      @if(Auth::check())
                      @if(Auth::user()->level >= 16)
                        <a class="nav-link" href="/Mr_Administrator" >Administrador</a>
                      @endif
                      @endif
                   </li>
                    @else
                    <li class="nav-item">
                      <a class="nav-link " href="{{ route('login') }}"></span>Iniciar sesión</a>
                    </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                          <a class="nav-link " href="{{ route('register') }}"><span class="glyphicon glyphicon-log-in"></span>Registrate</a>
                        </li>
                        @endif
                    @endauth
                </div>
            @endif
            
          </ul>
        </div>
      </div>
    </nav>

    <header>
      @yield('slider')
    </header>
    <!-- Page Content -->
    @yield('content')

        <!-- CONTACTO -->
        <section class="py-5" id="contacto">
      <div class="container">
        <h1>Contacto</h1>
        <p>Envíanos tu mensaje para recibir más información.</p>
      </div>
      <div class="container ">
    <div class="row">
        <div class="col-md-10">
            <div class="well well-sm">
                <form>
                <div class="row">
                    <div class="col-md-6">  
                        {!! Form::open(['route' => 'mail.store', 'method' => 'POST'])!!}
                         <div class="form-group">
                             {!! Form::label('Nombre') !!}
                            {!! Form::text('name',null,['class' => 'form-control', 'placeholder' => 'Ingrese su nombre']) !!}
                         </div>
                         <div class="form-group">
                             {!! Form::label('Email') !!}
                            {!! Form::email('email',null,['class' => 'form-control','placeholder' => 'Ingrese su email']) !!}
                         </div>
                         <div class="form-group">
                             {!! Form::label('Asunto') !!}
                             {!! Form::text('subject',null,['class' => 'form-control', 'placeholder' => 'Ingrese Asunto']) !!}
                         </div>
                        </div>
                         <div class="col-md-6">
                        <div class="form-group">
                        {!! Form::label('Mensaje') !!}
                        {!! Form::textarea('message',null,['class' => 'form-control', 'placeholder' =>'Escribe tu mensaje']) !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        {!! Form::submit('Enviar',['class' => 'btn btn-info btn-lg']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
    </section>

     <!-- Redes -->
     <section class="py-3" id="redes">
<div class = "container text-center my-3 " id="redes">
  <li class="list-inline-item">
            <a class="social-link rounded-circle text-white mr-3" href="https://www.facebook.com/groups/MultimediaUSB/" target="_blank">
              <i class="icon-social-facebook"></i>
            </a>
          </li>
          <li class="list-inline-item">
            <a class="social-link rounded-circle text-white mr-3" href="https://twitter.com/usbmedialab" target="_blank">
              <i class="icon-social-twitter"></i>
            </a>
          </li>
           <li class="list-inline-item">
            <a class="social-link  rounded-circle text-white mr-3" href="https://www.youtube.com/channel/UCd1kzS__MTwMjm6X71u32Ew" target="_blank" >
              <i class="icon-social-youtube"></i>
            </a>
          </li>
        </div>
      </section>

    <!-- Footer -->
    <footer class="py-3">
      <div class="container">

     <img src="http://localhost/usbmedialab/resources/assets/img/logom.png" alt="minilogo" width="70" class="mx-auto d-block mt-3">
     <h6 class="text-center text-white my-1">&copy; 2018</h6>
      </div>
      <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="http://localhost/usbmedialab/resources/assets/js/jquery.min.js"></script>
    <script src="http://localhost/usbmedialab/resources/assets/js/bootstrap.bundle.min.js"></script>

  </body>

<script type="text/javascript">

// Links con redireccion
$('a[href*="#"]')
  // Retirar links que no redireccionen a nada
  .not('[href="#"]')
  .not('[href="#0"]')
  .click(function(event) {
    // On-page links
    if (
      location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '')
      &&
      location.hostname == this.hostname
    ) {
      // Figure out element to scroll to
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      // Does a scroll target exist?
      if (target.length) {
        // Only prevent default if animation is actually gonna happen
        event.preventDefault();
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 1500, function() {
          // Callback after animation
          // Must change focus!
          var $target = $(target);
          $target.focus();
          if ($target.is(":focus")) { // Checking if the target was focused
            return false;
          } else {
            $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
            $target.focus(); // Set focus again
          };
        });
      }
    }
  });
</script>

</html>
