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
    $_SESSION['msgNomePac'] = true;
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
    <!-- EMOJI -->
    <link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
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
              <!--<li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="file"></span>
                  <span class="collapse show">Receitas</span>
                </a>
              </li>-->
              <li class="nav-item">
                <a class="nav-link" href="../prof/receitas">
                  <span data-feather="file-plus"></span>
                  <span class="collapse show">Adicionar nova receita</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../prof/proceds">
                  <span data-feather="sun"></span>
                  <span class="collapse show">Adicionar novo procedimento</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../prof/medicao">
                  <span data-feather="thermometer"></span>
                  <span class="collapse show">Adicionar nova medição</span>
                </a>
              </li>
              <!--<li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="users"></span>
                  <span class="collapse show">Pacientes</span>
                </a>
              </li>-->
              <li class="nav-item">
                <a class="nav-link active" href="../prof/historico">
                  <span data-feather="file-text"></span>
                  <span class="collapse show">Histórico do Paciente</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../prof/pac-form">
                  <span data-feather="user-plus"></span>
                  <span class="collapse show">Cadastrar novo Paciente</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="modal" data-target="#sendLink" data-backdrop="static" data-keyboard="false">
                  <span data-feather="send"></span>
                  <span class="collapse show">Enviar app ao Paciente</span>
                </a>
              </li>
            </ul>
          </div>
        </nav>
        <div class="modal fade" id="sendLink" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Enviar Link do App para o Paciente</h5>
                <button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <label for="telefone">Telefone</label>
                <input type="tel" class="form-control phone" id="sms_tel" placeholder="(00) 00000-0000" maxlength="15" minlength="14">
                <div class="alert alert-danger mt-2" id="smsErro" hidden>
                  Por favor, informe um telefone válido para enviar o link.
                </div>
                <div class="row">
                  <div class="col">
                    <button type="button" class="btn btn-outline-primary btn-lg btn-block mt-2" id="sms">Enviar</button>
                  </div>
                  <div class="col">
                    <button type="button" class="btn btn-outline-danger btn-lg btn-block mt-2 close-modal" data-dismiss="modal">Cancelar</button>
                  </div>
                </div>
                <div class="alert alert-success mt-2" id="success" hidden>
                  
                </div>
              </div>
            </div>
          </div>
        </div>

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
     <!-- mask -->
     <script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
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
      $.getJSON("../sintomas/"+id, function(result){
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
      $('.close-modal').click(function(){
        $('.modal-backdrop').remove();
      });
      $('.phone').mask('(00) 00000-0000');
      $('#sms_tel').keypress(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
          $('#sms').click(); 
        }
      });
      function isNumber(number) { 
        var regex = /^\([1-9]{2}\) (?:[2-8]|9[1-9])[0-9]{3}\-[0-9]{4}$/;
        if(!(regex.test(number))){
          $('#smsErro').fadeIn().attr('hidden', false);
          return false;
        } else {
          $('#smsErro').fadeOut().attr('hidden', true);
          return true;

        }
      }
      $('#sms').click(function(){
        if(isNumber($('#sms_tel').val())){
          var data = {'telefone':$('#sms_tel').val()};
          $.post("../send-sms/", data, function(resp){
              if (resp['status'] == 'false') {
                $('#erro').html(resp['msg']).fadeIn().attr('hidden', false);
              }
              else{
                $('#success').html(resp['msg']).fadeIn().attr('hidden', false);
                $('#sms_tel').val('');
                setTimeout(() => {
                  $('.close-modal').click();  
                }, 5000);
              }
            }
          );
        }
      });
    });    
    </script>
    <footer class="my-5 pt-5 text-muted text-center text-small">
      <p class="mt-5 mb-3 text-muted"><img src="../templates/logo-muted.svg" width="30px">-TRAT: Tratamentos de Saúde<br> &copy; 2017-2019</p>
    </footer>
  </body>
</html>
