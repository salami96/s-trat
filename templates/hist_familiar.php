<?php 
    $erro = false;
    if(!isset($_SESSION['idPac'])){
        $erro = true;
    }
?>
<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/templates/logo.ico">

    <title>Histórico do paciente</title>

    <!-- Bootstrap core CSS -->
    <link href="/templates/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/templates/css/dashboard.css" rel="stylesheet">
    <!--link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet"-->
    <!--link rel="stylesheet" type="text/css" media="screen"
     href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" /-->
    <!-- EMOJI -->
    <link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
    <style type="text/css">
      .blue, .blue th{
        background-color: #2672af !important;
        border-color: #2672af !important;
      }
      .main{
        margin-top: 50px !important;
      }
    </style>
  </head>
  <body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 blue shadow" >
      <div class="navbar-brand col-md-2 mr-0">
        <img src="/templates/logo-white.svg" width="30px">
        <span style="color: white">S-trat</span>
      </div>
      <h6 class="navbar-text mx-auto">Paciente: <?php if(!$erro){ echo $_SESSION['nomePac']; } ?></h6>
    </nav>
    <div class="container-fluid">
      <div class="row">
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Histórico do paciente</h1>
          </div>
          <div role="alert" class="alert alert-danger" id="erro" hidden><?php $_SESSION['msg'] ?></div>
          <table class="table table-sm table-hover table-bordered text-center table-responsive-sm">
            <thead class="thead-dark blue">
              <tr>
                <th scope="col">Medicamento</th>
                <th scope="col">Horario do Lembrete</th>
                <th scope="col">Horario de Realização</th>
                <th scope="col">Realizado</th>
                <th scope="col">Indicação</th>
              </tr>
            </thead>
            <tbody id="medicamento">
            </tbody>
          </table>
          <table class="table table-sm table-hover table-bordered text-center table-responsive-sm">
            <thead class="thead-dark blue">
              <tr>
                <th scope="col">Procedimento</th>
                <th scope="col">Horario do Lembrete</th>
                <th scope="col">Observações</th>
                <th scope="col">Realizado</th>
                <th scope="col">Indicação</th>
              </tr>
            </thead>
            <tbody id="procedimento">
            </tbody>
          </table>
          <table class="table table-sm table-hover table-bordered text-center table-responsive-sm">
            <thead class="thead-dark blue">
              <tr>
                <th scope="col">Medição</th>
                <th scope="col">Horario do Lembrete</th>
                <th scope="col">Horario de Realização</th>
                <th scope="col">Resultado</th>
                <th scope="col">Realizado</th>
                <th scope="col">Indicação</th>
              </tr>
            </thead>
            <tbody id="medicao">
            </tbody>
          </table>
          <table class="table table-sm table-hover table-bordered text-center table-responsive-sm">
            <thead class="thead-dark blue">
              <tr>
                <th scope="col">Sintoma</th>
                <th scope="col">Horario</th>
                <th scope="col">Nível de Dor</th>
                <th scope="col">Nível de Humor</th>
                <th scope="col">Temperatura</th>
              </tr>
            </thead>
            <tbody id="sintomas">
            </tbody>
          </table>          
        </main>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="/templates/js/popper.min.js"></script>
    <script src="/templates/js/bootstrap.min.js"></script>

    <!-- Icons -->
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
      feather.replace()
    </script>

    <script type="text/javascript"
     src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js">
    </script> 
    <script type="text/javascript"
     src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js">
    </script>
    <script type="text/javascript">

    $(document).ready(function() {
      if($(window).width()<=768){
        $('main').addClass('main');
      }else{
        $('main').removeClass('main');
      }
      $(window).resize(function(){
        if($(window).width()>768){
          $('main').removeClass('main');
        }
        else{
          $('main').addClass('main');
        }
      });
      var id = 0;
      <?php
        if($erro){
            echo '$("#erro").fadeIn().attr("hidden",false).html("' . $_SESSION["msg"] . '");';
        } else {
            echo "id = " . $_SESSION['idPac'] . ";";
        }
      ?>
      $.getJSON("/receitas/"+id+"/todos", function(result){
        for (tipo in result) {
          switch(tipo){
            case 'medicamentos':
              var itens = result[tipo];
              for(campos in itens){
                var realizado = "<span data-feather='x-circle'>";
                if (itens[campos]['realizado'] == '1')
                  realizado = "<span data-feather='check-circle'>";
                var hora_real = "<span data-feather='minus'>";
                if(itens[campos]['hora_real'] != null)
                  hora_real = format(itens[campos]['hora_real']);
                var prof = "<span data-feather='minus'>";
                if(itens[campos]['prof'] != null)
                  prof = itens[campos]['prof'];
                $('#medicamento').append("<tr><td>"+itens[campos]['medicamento']+"</td>"+
                  "<td>"+format(itens[campos]['hora'])+"</td>"+
                  "<td>"+hora_real+"</td>"+
                  "<td>"+realizado+"</td>"+
                  "<td>"+prof+"</td></tr>");
              }
              break;
            case 'procedimentos':
              var itens = result[tipo];
              for(campos in itens){
                var realizado = "<span data-feather='x-circle'>";
                if (itens[campos]['realizado'] == '1')
                  realizado = "<span data-feather='check-circle'>";
                var prof = "<span data-feather='minus'>";
                if(typeof itens[campos]['prof'] !== 'undefined')
                  prof = itens[campos]['prof'];
                $('#procedimento').append("<tr><td>"+itens[campos]['proced']+"</td>"+
                  "<td>"+format(itens[campos]['horario'])+"</td>"+
                  "<td>"+itens[campos]['obs']+"</td>"+
                  "<td>"+realizado+"</td>"+
                  "<td>"+prof+"</td></tr>");
              }
              break;
            case 'medicoes':
              var itens = result[tipo];
              for(campos in itens){
                var realizado = "<span data-feather='x-circle'>";
                if (itens[campos]['realizado'] == '1')
                  realizado = "<span data-feather='check-circle'>";
                var hora_real = "<span data-feather='minus'>";
                if(itens[campos]['hora_real'] != null)
                  hora_real = format(itens[campos]['hora_real']);
                var prof = "<span data-feather='minus'>";
                if(itens[campos]['prof'] != null)
                  prof = itens[campos]['prof'];
                var resultado = "<span data-feather='minus'>";
                if(itens[campos]['resultado'] != null)
                  resultado = itens[campos]['resultado'];
                $('#medicao').append("<tr><td>"+itens[campos]['medicao']+"</td>"+
                  "<td>"+format(itens[campos]['hora'])+"</td>"+
                  "<td>"+hora_real+"</td>"+
                  "<td>"+resultado+"</td>"+
                  "<td>"+realizado+"</td>"+
                  "<td>"+prof+"</td></tr>");
              }
              break;
          }
        };
        feather.replace();
        $('.feather-check-circle').attr('stroke','green');
        $('.feather-x-circle').attr('stroke','red');
      });
      $.getJSON("/sintomas/"+id, function(result){
        for(campos in result){
          $('#sintomas').append("<tr><td>"+result[campos]['desc']+"</td>"+
            "<td>"+format(result[campos]['horario'])+"</td>"+
            "<td>"+setDor(result[campos]['n_dor'])+"</td>"+
            "<td>"+humor(result[campos]['n_humor'])+"</td>"+
            "<td>"+result[campos]['temperatura']+" ºC</td></tr>");
        }
      });
      $('.collapseToggle').on('click',collapseToggle);
      function collapseToggle(){
        $('.collapse').toggleClass('show');
        $('.sidebar').toggleClass('col-md-2 col-sm-auto');
        $('.navbar-brand').toggleClass('col-md-2 col-sm-auto');
        $('main').toggleClass('col-md-9 col-lg-10 col-md-auto col-lg-11')
      };
      function setDor(n){
        if (n == 0) {
          return "<div class='progress-bar bg-success' role='progressbar' min='0' max='10' style='width:6%'>"+n+"</div>";
        }
        if ((n >= 1)&&(n < 3)){
          return "<div class='progress-bar bg-success' role='progressbar' min='0' max='10' style='width:"+n+"0%'>"+n+"</div>";
        }
        if ((n >= 3)&&(n < 8)){
          return "<div class='progress-bar bg-warning' role='progressbar' min='0' max='10' style='width:"+n+"0%'>"+n+"</div>";
        }
        if (n >= 8){
          return "<div class='progress-bar bg-danger' role='progressbar' min='0' max='10' style='width:"+n+"0%'>"+n+"</div>";
        }
      }
      function humor(n){
        switch(n){
          case '0':
              return "<i class='em em-face_vomiting'></i>";
              break;
          case '1':
              return "<i class='em em-sleepy'></i>";
              break;
          case '2':
              return "<i class='em em-face_with_thermometer'></i>";
              break;
          case '3':
              return "<i class='em em-sneezing_face'></i>";
              break;
          case '4':
              return "<i class='em em-slightly_frowning_face'></i>";
              break;
          case '5':
              return "<i class='em em-confused'></i>";
              break;
          case '6':
              return "<i class='em em-neutral_face'></i>";
              break;
          case '7':
              return "<i class='em em-slightly_smiling_face'></i>";
              break;
          case '8':
              return "<i class='em em-grinning'></i>";
              break;
        }
      }
      function format(data) {
        var arr = data.split(" ");
        var data = arr[0].split("-");
        var res = arr[1]+" "+data[2]+"/"+data[1]+"/"+data[0];
        return res;
      }
    });    
    </script>
    <footer class="my-5 pt-5 text-muted text-center text-small">
      <p class="mt-5 mb-3 text-muted"><img src="/templates/logo-muted.svg" width="30px">-TRAT: Tratamentos de Saúde<br> &copy; 2017-2019</p>
    </footer>
  </body>
</html>
