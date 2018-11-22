@extends('layouts.master')
@section('slider')
      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">

        <div class="carousel-inner" role="listbox" id="inicio">
          <!-- Slide One - Set the background image for this slide in the line below -->
          <div class="carousel-item active" style="background-image: url('http://localhost/usbmedialab/resources/assets/img/bannerhome_cc.jpg')">
            <div class="carousel-caption d-none d-md-block">
              <h3 style="">Creación Colectiva 2 Ya disponible</h3>
              <a href="tv"><p class="text-info">En nuestro canal de televisión</p></a>
            </div>
          </div>
          <!-- Slide Two - Set the background image for this slide in the line below -->
          <div class="carousel-item" style="background-image: url('http://localhost/usbmedialab/resources/assets/img/bannerhome_ms.jpg')">
            <div class="carousel-caption d-none d-md-block">
              <h3>Día de la ingeniería USBBOG</h3>
              <a href="tv"><p class="text-info">Revive los mejores momentos en el Mediashow</p></a>
            </div>
          </div>
          <!-- Slide Three - Set the background image for this slide in the line below -->
          <div class="carousel-item" style="background-image: url('http://localhost/usbmedialab/resources/assets/img/bannerhome_qs.jpg')">
            <div class="carousel-caption d-none d-md-block">
              <h3>UsbMedia Lab una comunidad de innovación en soluciones multimedia. </h3>
              <a href="tv"><p class="text-info">Acerca de nosotros</p></a>
            </div>
          </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
@endsection

@section('content')
    <!-- Page Content -->
    <section class="py-5" >
      <div class="container ">
        <div class="mb-5">
        <h1>Investigación</h1>
        <p>USB Media Lab permite el desarrollo y financiamiento externo contínuo de proyectos de semilleros y grupos de investigación.</p>
          </div>
          <div class="mb-5" id="investigacion">
        <h2>Semilleros</h2>
        <p>Una de las líneas de Profundización de los Ingenieros Multimedia de la Universidad de San
Buenaventura es la Dirección de Animación y el Desarrollo de Videojuegos</code>
          file.</p>
          </div>
          <!-- Circulos -->
      <div class="row">
        <div class="col-lg-4 col-sm-6 text-center mb-4">
          <a href="animov"><img class="rounded-circle img-fluid d-block mx-auto mb-4" src="http://localhost/usbmedialab/resources/assets/img/animov_logo.jpg" alt=""></a>
          <h3>Animov
          </h3>
          <p>Investigación en tecnicas de animación.</p>
        </div>
        <div class="col-lg-4 col-sm-6 text-center mb-4">
          <a href="gamedev"><img class="rounded-circle img-fluid d-block mx-auto mb-4" src="http://localhost/usbmedialab/resources/assets/img/gamedev_logo.jpg" alt=""></a>
          <h3>GameDev
          </h3>
          <p>Investigación en diseño y desarrollo de videojuegos.</p>
        </div>
        <div class="col-lg-4 col-sm-6 text-center mb-4">
          <a href="cabalas"><img class="rounded-circle img-fluid d-block mx-auto mb-4" src="http://localhost/usbmedialab/resources/assets/img/cabalas_logo.jpg" alt=""></a>
          <h3>Cábalas de software
          </h3>
          <p>Adopción de técnicas de programación segura para la protección de aplicaciones web.</p>
        </div>
         <div class="col-lg-4 col-sm-6 text-center mb-4 cont_center">
          <a href="tecnosoft"><img class="rounded-circle img-fluid d-block mx-auto mb-4" src="http://localhost/usbmedialab/resources/assets/img/tecnosoft_logo.jpg" alt=""></a>
          <h3>Tecnosoft
          </h3>
          <p>Grupo de investigación solsytec.</p>
        </div>
      </div>

      <div class="mb-5" id="grupos_inv">
        <h2>Grupos</h2>
          </div>

       <div class="row ">
        <div class="col-lg-4 col-sm-6 text-center mb-4 cont_center">
          <a href="solsytec"><img class="rounded-circle img-fluid d-block mx-auto mb-4" src="http://localhost/usbmedialab/resources/assets/img/solsytec_logo.jpg" alt=""></a>
          <h3>Solsytec
          </h3>
          <p>Grupo de investigación institucional enfocado a brindar soluciones ingenieriles a traves de desarrollo tecnológico. </p>
        </div>
      </div>
      </div>
    </section>

    <!-- Medios de difusión -->
    <section class="py-5" id="medios">
      <div class="container">
        <h1>Medios de difusión</h1>
        <p>The background images for the slider are set directly in the HTML using inline CSS. The rest of the styles for this template are contained within the
          <code>full-slider.css</code>
          file.</p>
      </div>

      <div class="container">
           <div class="row">
              <div class="col col-lg-7 col-sm-7">
             <a href="tv"><img class="card-img-top" src="http://localhost/usbmedialab/resources/assets/img/tv_mainhome.jpg" alt=""></a>
             <h3 class="mt-2">Canal de televisión</h3>
             </div>
              <div class="col col-lg-5 col-sm-5">
             <a href="emisora.html"><img class="card-img-top" src="http://localhost/usbmedialab/resources/assets/img/emisora_mainhome.jpg" alt=""></a>
              <h3 class="mt-2">Emisora USBRadio </h3>
             </div>
           </div>

      </div>
    </section>

    <!-- Page Content -->
    <section class="py-5" id="servicios">
      <div class="container">
        <h1>Servicios</h1>
        <p>USBMediaLab contribuye a innovar en soluciones para su comunidad.</p>
      </div>
      <div class="container pl-5">
              <div class="row serv1">
          <div class="col-lg-2 col-sm-2">
          <img class="rounded-circle img-fluid d-block my-5 mx-auto" src="http://placehold.it/100x100" alt="">
        </div>
        <div class="col-lg-8 col-sm-8 ">
          <h3 class="mt-5">Investigación

          </h3>
          <p>Creará un ambiente de intercambio Universidad – Empresa, que permitirá el desarrollo y financiamiento externo continuo de Proyectos de Investigación.</p>
          </div>
        </div>

         <div class="row serv2 justify-content-md-center">
         <div class="col-lg-8 col-sm-8 mx-0 ">
          <h3 class="mt-5 mx-auto">Docencia

          </h3>
          <p>Permitirá el contacto articulado de cursos relacionados con investigación con proyectos reales de la industria.</p>
          </div>
          <div class="col-lg-2 col-sm-2">
          <img class="rounded-circle img-fluid d-block my-5 mx-auto" src="http://placehold.it/100x100" alt="">
        </div>
       </div>

         <div class="row serv3">
          <div class="col-lg-2 col-sm-2">
          <img class="rounded-circle img-fluid d-block my-5 mx-auto" src="http://placehold.it/100x100" alt="">
        </div>
        <div class="col-lg-8 col-sm-8 ">
          <h3 class="mt-5">Proyección Social
          </h3>
          <p>Participación de la universidad en proyectos públicos y privados de impacto social, pues no sólo habrá contacto con empresas comerciales, sino con fundaciones, entes gubernamentales y organizaciones no gubernamentales que requieren esfuerzos de base tecnológica.</p>
          </div>
        </div>
        <div class="container text-center">
        <a href="servicios" class="btn btn-outline-info">Ver más</a>
        </div>
      </div>
    </section>

    <!-- Page Content -->
    <section class="py-5" id="eventos">
      <div class="container">
        <h1>Eventos</h1>
        <p>The background images for the slider are set directly in the HTML using inline CSS. The rest of the styles for this template are contained within the
          <code>full-slider.css</code>
          file.</p>

      <div class="row">

        <div class="col-lg-6 col-sm-6 mt-4">
          <ul>
      <li><a href="eventos">The background images for the slider are set directly in the HTML using inline CSS. The rest of the styles for this template are contained within the
          <code>full-slider.css</code>
          file.</a> </li>   </ul>

          <ul>
      <li><a href="eventos">The background images for the slider are set directly in the HTML using inline CSS. The rest of the styles for this template are contained within the
          <code>full-slider.css</code>
          file.</a> </li>   </ul>

          <ul>
      <li><a href="eventos">The background images for the slider are set directly in the HTML using inline CSS. The rest of the styles for this template are contained within the
          <code>full-slider.css</code>
          file.</a> </li>   </ul>

           <ul>
      <li><a href="eventos">The background images for the slider are set directly in the HTML using inline CSS. The rest of the styles for this template are contained within the
          <code>full-slider.css</code>
          file.</a> </li>   </ul>

      </div>
      <div class="col-lg-6 col-sm-6">
        <div class="card rounded-0 text-white  ">
         <img class="card-img "src="http://placehold.it/400x300" alt="Card image">
         <div class="card-img-overlay ">
           <h5 class="card-title ">Card title</h5>
           <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
           </div>
</div>
<!--<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active " id="minicarrusel">
      <img class="d-block w-100" src="http://placehold.it/400x300" alt="First slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="http://placehold.it/400x300" alt="Second slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="http://placehold.it/400x300" alt="Third slide">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>-->

                </div>
      </div>
</div>
    </section>
    <!-- Page Content -->
    <section class="py-5" id="categorias">
      <div class="container">
        <h1>Categorias</h1>
        <p>The background images for the slider are set directly in the HTML using inline CSS. The rest of the styles for this template are contained within the
          <code>full-slider.css</code>
          file.</p>
      </div>

<div class="container">

  <div class="row no-gutters">
    <div class=" col-lg-4 ">
      <a href="portafolio.html"><img class="card-img-top" src="http://placehold.it/380x300" alt=""></a>
    </div>
    <div class=" col-lg-4 ">
      <a href="portafolio.html"><img class="card-img-top" src="http://placehold.it/380x300" alt=""></a>
    </div>
    <div class=" col-lg-4 col-sm-4">
      <a href="portafolio.html"><img class="card-img-top" src="http://placehold.it/380x300" alt=""></a>
    </div>
  </div>
</div>

    </section>

    <!-- Page Content -->
    <section class="py-5" id="miembros">
      <div class="container">
        <h1>Miembros</h1>
        <p>La membresía en USB Media Lab consiste en una participación económica anual como patrocinante de alguna línea de investigación asociada a los Grupos de Investigación o Semilleros afiliados</p>
              <!-- Circulos -->
      <div class="row">
        <div class="col-lg-4 col-sm-6 text-center my-4">
          <img class="rounded-circle img-fluid d-block mx-auto mb-4" src="http://placehold.it/100x100" alt="">
          <h3>Estudiantes
          </h3>
          <p>What does this team member to? Keep it short! This is also a great spot for social links!</p>
        </div>
        <div class="col-lg-4 col-sm-6 text-center my-4">
          <img class="rounded-circle img-fluid d-block mx-auto mb-4" src="http://placehold.it/100x100" alt="">
          <h3>Docentes
          </h3>
          <p>What does this team member to? Keep it short! This is also a great spot for social links!</p>
        </div>
        <div class="col-lg-4 col-sm-6 text-center my-4">
          <img class="rounded-circle img-fluid d-block mx-auto mb-4" src="http://placehold.it/100x100" alt="">
          <h3>Empresas
          </h3>
          <p>What does this team member to? Keep it short! This is also a great spot for social links!</p>
        </div>
      </div>
      <div class="container text-center">
     <a href="miembros.html" class="btn btn-outline-info">Ver más</a>
   </div>
      </div>

    </section>
@endsection
