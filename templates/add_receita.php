<?php 
  if (!isset($_SESSION['nomeProf'])) {
    $_SESSION['msg'] = "Você precisa estar logado para acessar essa Página!";
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

    <title>Adicionar Receitas</title>

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
      .select{
        width:100%!important;
      }
      .btn-outline-clear {
        color: #dc3545;
        background-color: transparent;
        background-image: none;
        border-color: #dc3545;
      }
      .btn-outline-clear:hover {
        color: #fff;
        background-color: red;
        border-color: red;
      }
      .btn-outline-blue {
        color: #2672af;
        background-color: transparent;
        background-image: none;
        border-color: #2672af;
      }
      .btn-outline-blue:hover {
        color: #fff;
        background-color: #2672af;
        border-color: #2672af;
      }
      .btn .feather{
        height: 24px !important;
        width: 24px !important;
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
        <nav class="collapse show col-md-2 d-none d-sm-block bg-light sidebar unCollapsed">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link" href="../prof/home">
                  <span data-feather="plus"></span>
                  <span class="collapse show">Nova Consulta</span>
                </a>
              </li>
<!--              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="file"></span>
                  <span class="collapse show">Receitas</span>
                </a>
              </li>
-->              <li class="nav-item">
                <a class="nav-link active" href="../prof/receitas">
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
<!--              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="users"></span>
                  <span class="collapse show">Pacientes</span>
                </a>
              </li>
-->              <li class="nav-item">
                <a class="nav-link" href="../prof/historico">
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
            <h1 class="h2">Adicionar Receitas</h1>
          </div>
          <form class="needs-validation" action="../receitas/" method="POST" novalidate>
            <label class="h5" for="nome">Nome do Paciente</label>
            <input type="text" readonly class="form-control" value="<?php echo $_SESSION['nomePac'];?>">
            <input type="text" id="pac" value="<?php echo $_SESSION['idPac'];?>" hidden>
            <div class="invalid-feedback">
              É obrigatório preencher o campo nome.
            </div>
            <label  class="h5" for="medicamento">Medicamento *</label>
            <select class="clear js-example-responsive form-control select" id="medicamento" required></select>
            <div class="alert alert-danger mt-2" id="erroMed" role="alert" hidden>O campo medicamento é obrigatório!</div>
            <label class="h5" for="dose">Dose e Observações</label>
            <input type="text" class="clear form-control" id="dose" name="dose" placeholder="Meio comprimido / Tomar em jejum...">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="importante">
              <label class="custom-control-label" for="importante">Marcar Medicamento como importante</label>
            </div>
            <div class="alert alert-info" id="alert_imp" role="alert" hidden>
              Isso irá criar um alarme no smartphone do paciente, use somente se necessário, pois essa funcionalidade serve para destacar um numero limitado de medicamentos!
            </div>
            <div class="row">
              <div id="datapicker" class="col-md-6 mb-3">
                <label  class="h5" for="date">Data Inicial *</label>
                <div class="input-append date input-group">
                  <input type="text" name="data" class="clear form-control" id="dataIni" placeholder="00/00/0000" required/> 
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary add-on" type="button">
                      <span data-feather="calendar"></span>
                    </button>
                  </div>
                </div>
                <div class="alert alert-danger mt-2" id="erroData" role="alert" hidden>O campo data é obrigatório!</div>
              </div>
              <div id="horapicker" class="col-md-6 mb-3">
                <label class="h5" for="hora">Hora Inicial *</label>
                <div class="input-append date input-group">
                  <input type="text" name="hora" class="clear form-control" id="horaIni" placeholder="00:00" required/> 
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary add-on" type="button">
                      <span id="clock" data-feather="clock"></span>
                    </button>
                  </div>
                </div>
                <div class="alert alert-danger mt-2" id="erroHora" role="alert" hidden>O campo hora é obrigatório!</div>
              </div>
            </div>
            <label class="h5" for="rd1">Vezes por dia</label>
            <div class="form-control">
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="rd1" name="vezes" class="custom-control-input" value="1" checked>
                <label class="custom-control-label" for="rd1">1</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="rd2" name="vezes" class="custom-control-input" value="2">
                <label class="custom-control-label" for="rd2">2</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="rd3" name="vezes" class="custom-control-input" value="3">
                <label class="custom-control-label" for="rd3">3</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="rd4" name="vezes" class="custom-control-input" value="4">
                <label class="custom-control-label" for="rd4">4</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="rd6" name="vezes" class="custom-control-input" value="6">
                <label class="custom-control-label" for="rd6">6</label>
              </div>
            </div>
            <label class="h5">Duração</label>
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="continuo">
              <label class="custom-control-label" for="continuo">Tratamento Contínuo</label>
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <input class="form-control duracao" type="number" name="duracao" value="15" maxlength="2" min="1">
              </div>
              <div class="col-md-6 mb-3">
                <select id="duracao" class="duracao form-control">
                  <option id="durHome" value="Dias" selected>Dia(s)</option>
                  <option value="Semanas">Semana(s)</option>
                  <option value="Mêses">Mês(es)</option>
                  <option value="Anos">Ano(s)</option>
                </select>
              </div>
            </div>
            <div>
              <button class="btn btn-outline-blue btn-lg btn-block" type="button" id="add">
              <span data-feather="corner-left-down"></span>
               Adicionar à receita
              </button>
              <button class="btn btn-outline-clear btn-lg btn-block" type="button" id="clear">
              <span data-feather="delete"></span> 
               Limpar
              </button>
            </div>

          </form>
          <div class="table-responsive col mt-2">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Medicamento</th>
                  <th scope="col">Vezes por dia</th>
                  <th scope="col">Duração</th>
                  <th scope="col">Excluir</th>
                  <!--th scope="col">Status</th-->
                </tr>
              </thead>
              <tbody id="receitas">
              </tbody>
            </table>
          </div>
          <div class="mt-2" id="post"></div>
          <div class="text-center">
            <button class="btn btn-outline-blue btn-lg btn-block" id="send"><span data-feather="send"></span> Enviar ao Usuário</button>
            <button class="btn btn-outline-secondary btn-lg btn-block" data-toggle="modal" data-target="#exampleModal" data-backdrop="static" data-keyboard="false"><span data-feather="printer"></span> Imprimir</button>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Impressão de Receita</h5>
                    <button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body" id="modal-body">
                    <h4><?php echo 'Dr. '. $_SESSION['nomeProf']; ?></h4>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary close-modal" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-outline-blue" id="print">Imprimir</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
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
      var id = 1;
      var duracao, nomeMed, nomeComp, dias, nDias, tratC;
      var idMed = 1;
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
      //$('#medicamentos').change(
      function setNomeMed(id){
        $.getJSON("../medicamentos/"+id, function(result){
          for (index in result) {
            index = result[index];
            for (propriedade in index){
              if(propriedade == "NO_PRODUTO"){
                nomeMed = index[propriedade];
                idMed = id;
              }
            }
          };
        });
      };
      $('#medicamento').select2({
        placeholder: 'Digite o nome do medicamento...',
        minimumInputLength: 2,
        ajax: {
          url: function (params) {
            return '../medicamentos/search/' + params.term;
          }
        }
      });
      $('#medicamento').on('select2:select', function (e) {
        var data = e.params.data;
        setNomeMed(data['id']);
        nomeComp = data['text'];
        $('#erroMed').fadeOut();
      });
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
      $('#continuo').change(function(){
        if($(this).is(":checked")) {
          $('.duracao').attr('disabled', true);
        }else{
          $('.duracao').attr('disabled', false);
        }
      });
      $('#importante').change(function(){
        if($(this).is(":checked")) {
          $('#alert_imp').fadeIn().attr('hidden', false);
        }else{
          $('#alert_imp').fadeOut();
        }
      });
      var btn = "<button type='button' class='btn btn-outline-";
      function validate(){
        var valid = false;
        if($('#medicamento').val() != null){
          valid = true;
        }else{
          var valid = false;
          $('#erroMed').fadeIn().attr('hidden', false);
        }
        //(    ^(0?[1-9]|[12][0-9]|3[01])[\/](0?[1-9]|1[012])[\/]\d{4}$   );
        if($('#dataIni').val() != ""){
          valid = true;
        }else{
          var valid = false;
          $('#erroData').fadeIn().attr('hidden', false);
        }
        if($('#horaIni').val() != ""){
          valid = true;
        }else{
          var valid = false;
          $('#erroHora').fadeIn().attr('hidden', false);
        }
        return valid;
      }
      var json = [""];
      $('#add').click(function(){
        if(validate()){
          if($('#continuo').is(':checked')){
            duracao = "Contínuo";
            tratC = 1;
            dias = 0;
            nDias = 0;
          }
          else{
            tratC = 0;
            nDias = $("input[type='number']").val();
            dias = $("#duracao option:selected").val();
            duracao = nDias+" "+dias;
          }
          var vezes = $("input[name='vezes']:checked").val();
          $('#receitas').append(
              "<tr id='"+id+"'>"+
                "<th scope='row'>"+id+"</th>"+
                "<td>"+nomeMed+"</td>"+
                "<td>"+vezes+"</td>"+
                "<td>"+duracao+"</td>"+
                "<td>"+btn+"clear trash'><span data-feather='trash-2'></span></button></td>"+
              "</tr>"
            );
          feather.replace();
          var dose = "";
          if ($('#dose').val() != "") {
            dose = "Obs: "+$('#dose').val();
          }
          $('#modal-body').append(
            "<p id='p_"+id+"'>Med: "+nomeComp+"</br>Dur: "+duracao+", "+vezes+" vez(es) por dia. "+dose+"</p>"
            );
          var imp;
          if($('#importante').is(":checked")){
            imp = 1;
          }else{
            imp = 0;
          }
          json[id] = {"pac":$("#pac").val(),"idMed":idMed,"dose":$("#dose").val(),"hora":$("#horaIni").val()+':00',"data":$("#dataIni").val(),"vezes":vezes,"tratContinuo":tratC,"duracao":nDias,"dias":dias,"idProf":<?php echo $_SESSION["idProf"]?>,"importante":imp};
          $('.trash').click(function(){
            var rm = $(this).parent().parent().attr('id')
            json[rm] = "";
            $('#'+rm).remove();
            $('#p_'+rm).remove();
          });
          id++;
          clear();
        }
      });
      $('#clear').click(function(){
        clear();
      });
      $('#print').click(function(){
        tela_impressao = window.open('about:blank');
        tela_impressao.document.write($('#modal-body').html());
        tela_impressao.window.print();
        tela_impressao.window.close();
      });
      $('#send').click(function(){
        for(i in json){
          if((i != 0)&&(json[i] != "")){
            $.post("../receitas",json[i],function(result){
              if(result['status'] == 'true'){
                $('#post').html("<div role='alert' class='alert alert-success'>"+result['msg']+"</div>");
              }else{
                $('#post').html("<div role='alert' class='alert alert-danger'>"+result['msg']+" "+result['erro']+"</div>");
              }
              feather.replace();
            });
          }
        }
        json[i] = "";
      });
      function clear(){
        $('.clear').val("");
        $('#importante').attr("checked",false);
        $('#continuo').attr("checked",false);
        $('#rd1').attr("checked",true);
        $('#durHome').attr("selected",true);
        $("input[type='number']").val("15");
        $('.duracao').attr('disabled', false);
        $('#alert_imp').fadeOut();
        $("#medicamento").empty().trigger('change');
        $('#erroData').fadeOut();
        $('#erroHora').fadeOut();
        $('#erroMed').fadeOut();
      }
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
