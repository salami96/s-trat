<?php 
  if (!isset($_SESSION['nomeProf'])) {
    $_SESSION['msg'] = "Você precisa estar logado para acessar essa Página";
    unset($_SESSION['nomeProf']);
    unset($_SESSION['idProf']);
    unset($_SESSION['idPac']);
    unset($_SESSION['nomePac']);
    echo "<script>window.location.replace('../prof/login');</script>";
  }
  if (!isset($_SESSION['nomePac'])) {
    $_SESSION['msgNomePac'] = false;
    echo "<script>window.location.replace('../prof/home');</script>";
  }
?>
<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../templates/logo.ico">

    <title>Histórico do paciente</title>

    <!-- Bootstrap core CSS -->
    <link href="../templates/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../templates/css/dashboard.css" rel="stylesheet">
    <!--link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet"-->
    <link rel="stylesheet" type="text/css" media="screen"
     href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">
    <!--link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" /-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <style type="text/css">
      .blue, .blue th{
        background-color: #2672af !important;
        border-color: #2672af !important;
      }
      .collapsed{
        display: none !important;
      }
      .unCollapsed{
        display: block !important;
      }
      .main{
        margin-top: 50px !important;
      }
    </style>
  </head>
  <body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 blue shadow" >
      <div class="navbar-brand col-md-2 mr-0" >
        <a class="collapsar" href="#void" data-toggle="tooltip" data-placement="right" title="Menu Principal">
          <span data-feather="menu" style="color: white"></span>
        </a>
        <a href="../" data-toggle="tooltip" data-placement="right" title="Página Inicial">
          <span style="color: white">S-trat</span>
        </a>
      </div>
      <h6 class="navbar-text ml-1">Olá Dr. <?php echo $_SESSION['nomeProf']; ?></h6>
      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
          <a class="nav-link" href="../prof/logout">
            <span data-feather="log-out"></span>
            Sair
          </a>
        </li>
      </ul>
    </nav>
    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link" href="../prof/home">
                  <span data-feather="plus"></span>
                  <span class="collapse show">Nova Consulta</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="file"></span>
                  <span class="collapse show">Receitas</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../prof/receitas">
                  <span data-feather="file-plus"></span>
                  <span class="collapse show">Adicionar nova receita</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="users"></span>
                  <span class="collapse show">Pacientes</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="../prof/historico">
                  <span data-feather="file-text"></span>
                  <span class="collapse show">Histórico do Paciente</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="layers"></span>
                  <span class="collapse show">Integrations</span>
                </a>
              </li>
            </ul>
          </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Histórico do paciente</h1>
          </div>
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
        </main>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="../templates/js/popper.min.js"></script>
    <script src="../templates/js/bootstrap.min.js"></script>

    <!-- Icons -->
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
      feather.replace()
    </script>

    <!-- Graphs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <!--script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script-->
    <!-- Date and Time Picker's-->
    <script type="text/javascript"
     src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js">
    </script> 
    <script type="text/javascript"
     src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js">
    </script>
    <script type="text/javascript"
     src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js">
    </script>
    <script type="text/javascript"
     src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.pt-BR.js">
    </script>
    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.full.min.js" type="text/javascript"></script>
    <script type="text/javascript">

    $(document).ready(function() {
      if($(window).width()<=768){
        collapsar();
        $('main').addClass('main');
        $('.sidebar').addClass('main');
      }else{
        unCollapsar();
        $('main').removeClass('main');
        $('.sidebar').removeClass('main');
      }
      $(window).resize(function(){
        $('.select2').addClass('select');
        if($(window).width()>768){
          $('main').removeClass('main');
          $('.sidebar').removeClass('main');
          unCollapsar();
        }
        else{
          $('main').addClass('main');
          $('.sidebar').addClass('main');
          collapsar();
        }
      });
      $('.collapsar').click(function(){
        if($('.sidebar').hasClass('collapsed')){
          unCollapsar();
        }
        else{
          collapsar();
        }
      });
      function collapsar(){
        $('.sidebar').removeClass('unCollapsed').addClass('collapsed');
      }
      function unCollapsar(){
        $('.sidebar').removeClass('collapsed').addClass('unCollapsed');
      }      
      var id = <?php echo $_SESSION['idPac'];?>;
      $.getJSON("../receitas/"+id+"/todos", function(result){
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
      $('.collapseToggle').on('click',collapseToggle);
      function collapseToggle(){
        $('.collapse').toggleClass('show');
        $('.sidebar').toggleClass('col-md-2 col-sm-auto');
        $('.navbar-brand').toggleClass('col-md-2 col-sm-auto');
        $('main').toggleClass('col-md-9 col-lg-10 col-md-auto col-lg-11')
      };
      function format(data) {
        var arr = data.split(" ");
        var data = arr[0].split("-");
        var res = arr[1]+" "+data[2]+"/"+data[1]+"/"+data[0];
        return res;
      }

      $('#datapicker').datetimepicker({
        format: 'dd/MM/yyyy',
        language: 'pt-BR',
        pickTime: false
      });
      $('#horapicker').datetimepicker({
        format: 'hh:mm',
        language: 'pt-BR',
        pickDate: false
      });
      $('.icon-chevron-up').attr("data-feather","chevron-up");
      $('.icon-chevron-down').attr("data-feather","chevron-down");
      feather.replace();
    });    
    </script>
    <footer class="my-5 pt-5 text-muted text-center text-small">
      <p class="mt-5 mb-3 text-muted">S-trat: Tratamentos de Saúde<br> &copy; 2017-2018</p>
    </footer>
  </body>
</html>
