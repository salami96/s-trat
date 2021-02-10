<?php 
  if (!isset($_SESSION['nomeProf'])) {
    $_SESSION['msg'] = "Você precisa estar logado para acessar essa Página";
    unset($_SESSION['nomeProf']);
    unset($_SESSION['idProf']);
    unset($_SESSION['idPac']);
    unset($_SESSION['nomePac']);
    echo "<script>window.location.replace('../prof/login');</script>";
  }
?>
<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../templates/logo.ico">

    <title>Cadastro de Pacientes</title>

    <!-- Bootstrap core CSS -->
    <link href="../templates/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../templates/css/dashboard.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <style type="text/css">
      .blue, .blue th{
        background-color: #2672af !important;
        border-color: #2672af !important;
      }
      .btn .feather{
        width: 24px;
        height: 24px;
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
<!--              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="file"></span>
                  <span class="collapse show">Receitas</span>
                </a>
              </li>
-->              <li class="nav-item">
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
                <a class="nav-link active" href="../prof/pac-form">
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
            <h1 class="h2">Cadastro de Pacientes</h1>
          </div>
          <form class="needs-validation" novalidate>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" id="nome">
                <div class="alert alert-danger mt-2" id="nomeErro" hidden>
                  É obrigatório preencher o campo nome.
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="sobrenome">Sobrenome</label>
                <input type="text" class="form-control" id="sobrenome">
                <div class="alert alert-danger mt-2" id="sobrenomeErro" hidden>
                  É obrigatório preencher o campo sobrenome.
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label for="telefone">Telefone</label>
              <input type="tel" class="form-control phone" id="telefone" placeholder="(00) 00000-0000" maxlength="15" minlength="14">
              <div class="alert alert-danger mt-2" id="telefoneErro" hidden>
                Por favor, informe um telefone válido para o seu cadastro.
              </div>
            </div>            
            <div class="mb-3">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" placeholder="voce@exemplo.com">
              <div class="alert alert-danger mt-2" id="emailErro" hidden>
                Por favor, informe um email válido para o seu cadastro.
              </div>
            </div>
            <div class="mb-3">
              <label for="senha">Senha</label>
              <input type="password" class="form-control" id="senha" placeholder="********">
              <div class="alert alert-danger mt-2" id="senhaErro" hidden>
                Por favor, informe uma senha válida para o seu cadastro.
              </div>
            </div>
            <div class="mb-3">
              <button class="btn btn-outline-secondary btn-sm" data-toggle="modal" data-target="#text" data-backdrop="static" 
              data-keyboard="false">Ler Termos de uso</button>
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="terms" required>
                <label class="custom-control-label" for="terms">Paciente leu e aceita os termos de uso do S-trat</label>
                <div class="alert alert-danger mt-2" id="erroTerms" role="alert" hidden>É obrigatório ler os Termos de Uso.</div>
              </div>
            </div>
            <div class="modal fade" id="text" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Termos de Uso</h5>
                    <button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body" id="terms_of_use">
                    <h3>TERMOS DE USO</h3>
                    <p>Estes Termos de Uso regulamenta o uso do serviço oferecido aos USUÁRIOS pelo sistema S-trat: Tratamentos de 
                    Saúde (doravante, “S-TRAT”) desenvolvido por GABRIEL ZANATTO SALAMI, pessoa física, residente em Charqueadas - RS,
                     inscrita no CPF sob o nº 034.063.64080 (doravante, “DESENVOLVEDOR”).</p>
                    <p>1) Qualquer pessoa, PACIENTE ou PROFISSIONAL DE SAÚDE, doravante nominada USUÁRIO, que pretenda utilizar os 
                    serviços do S-TRAT, deverá aceitar as Cláusulas de Uso e todas as demais políticas e princípios que as regem. 
                    Todo USUÁRIO inscrito no sistema e fazendo uso do aplicativo aceita automaticamente os termos de uso presente 
                    neste documento.</p>
                    <p>2) A ACEITAÇÃO DESTES TERMOS E CONDIÇÕES GERAIS É INDISPENSÁVEL À UTILIZAÇÃO DOS SITES E APLICATIVOS E SERVIÇOS 
                    FORNECIDOS PELO S-TRAT. O USUÁRIO deverá ler, certificar-se de haver entendido e aceitar todas as disposições 
                    estabelecidas nos Termos e Condições e na Política de Privacidade, para que então seja efetuado com sucesso seu 
                    cadastro como USUÁRIO do S-TRAT.</p>
                    <p>3) Os serviços do S-TRAT somente estão disponíveis para as pessoas que tenham plena capacidade de fato para 
                    contratar. Dessa forma, não podem efetuar cadastro pessoas menores de 14 anos ou acometidas por outras 
                    incapacidades inscritas nos artigos 3º e 4º do Código Civil Brasileiro, salvo se devidamente representadas ou 
                    assistidas.</p>
                    <p>4) O USUÁRIO cadastrado aceita que seus dados de acesso aos sistema sejam monitorados e usados para fins 
                    acadêmicos e para fins de análise de negócio que tenha o sistema S-TRAT como base.</p>
                    <p>5) O USUÁRIO declara compreender que, enquanto estiver em fase experimental, o sistema S-TRAT não deve 
                    substituir o acompanhamento regular de medicamentos e demais eventos relacionados ao tratamento de saúde, e 
                    entende que o sistema deve ser usado em redundância ao acompanhamento tradicional a que está habituado.</p>
                    <p>6) O DESENVOLVEDOR do S-TRAT se compromete a manter anônimos os dados individuais do USUÁRIO, e divulgá-los 
                    somente mediante autorização expressa por escrito.</p>
                    <p>7) O DESENVOLVEDOR se reserva o direito de comercializar a terceiros o sistema S-TRAT bem como toda sua base 
                    de USUÁRIOS cadastrados sem prévio aviso, comprometendo-se apenas em alertar aos USUÁRIOS sobre realização da 
                    transação em um prazo máximo de 30 dias após assinatura do contrato, através de e-mail e/ou SMS para o telefone 
                    cadastrados.</p>
                    <p>7.1) Em caso de monetização do sistema, O DESENVOLVEDOR do sistema S-TRAT se compromete em garantir a 
                    priorização da oferta para adesão ao sistema pago com desconto para os USUÁRIOS inscritos até o momento, como 
                    bonificação pela contribuição com o uso do sistema quando ainda em fase experimental.</p>
                    <p>8) O USUÁRIO, ao aceitar o presente termos de uso, declara compreender que o sistema S-TRAT encontra-se em 
                    fase experimental e exime o DESENVOLVEDOR ou seus parceiros de qualquer responsabilidade legal pelo mau 
                    funcionamento de toda ou de qualquer parte que compõe o sistema, vazamento de dados, indisponibilidade de 
                    acesso, danos a eletrônicos, ou qualquer outro inconveniente decorrente registro no sistema.</p>
                    <p>9) O DESENVOLVEDOR se compromete a alertar previamente os usuários cadastrados com antecedência mínima de 7 
                    dias quaisquer mudanças no presente documento de termos de uso.</p>
                    <p>10) Os entes envolvidos no presente termo de uso elegem desde já o foro de Charqueadas para dirimir quaisquer 
                    divergências quanto ao ítens constantes no presente termos de uso.</p>
                    <p>Charqueadas, 06 de Fevereiro de 2019</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary close-modal" data-dismiss="modal">Fechar</button>
                    <a href="../termo_de_uso.pdf" role="button" class="btn btn-outline-success">Baixar</a>
                    <button type="button" class="btn btn-outline-primary" id="print">Imprimir</button>
                  </div>
                </div>
              </div>
            </div>
            <div>
              <button class="btn btn-outline-blue btn-lg btn-block" type="button" id="send">
              <span data-feather="save"></span>
               Salvar
              </button>
              <button class="btn btn-outline-clear btn-lg btn-block" type="reset" id="clear">
              <span data-feather="delete"></span> 
               Limpar
              </button>
              <div class="alert alert-danger mt-2" id="erro" role="alert" hidden></div>
            </div>
          </form>
        </main>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../templates/js/jquery-slim.min.js"><\/script>')</script>
    <script src="../templates/js/popper.min.js"></script>
    <script src="../templates/js/bootstrap.min.js"></script>

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
    <!-- mask -->
    <script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script type="text/javascript">

    $(document).ready(function() {
      $('.phone').mask('(00) 00000-0000');

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
      function validate(){
        var valid = true;
        function notNull(name){
          if(($(name).val() == '') || ($(name).val().length < 3)){
            $(name + 'Erro').fadeIn().attr('hidden', false);
            valid = false;
          } else {
            $(name + 'Erro').fadeOut().attr('hidden', true);
          }
        }
        function isEmail(email) { 
          var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
          if(!(regex.test(email))){
            valid = false;
            $('#emailErro').fadeIn().attr('hidden', false);
          }
        }
        function isNumber(number) { 
          var regex = /^\([1-9]{2}\) (?:[2-8]|9[1-9])[0-9]{3}\-[0-9]{4}$/;
          if(!(regex.test(number))){
            valid = false;
            $('#telefoneErro').fadeIn().attr('hidden', false);
          }
        }
        notNull('#nome');
        notNull('#sobrenome');
        notNull('#telefone');
        isNumber($('#telefone').val());
        notNull('#email');
        isEmail($('#email').val())
        notNull('#senha');
        if(!$('#terms').is(':checked')){
          $('#erroTerms').fadeIn().attr('hidden', false);
          valid = false;
        }
        return valid;
      }
      $('#send').click(function(){
        if(validate()){
          var data = {'email':$('#email').val(), 'senha':$('#senha').val(), 'nome':$('#nome').val(),
          'sobrenome':$('#sobrenome').val(), 'telefone':$('#telefone').val()};
          $.post("../pacientes/", data, function(resp){
              if (resp['status'] == 'false') {
                $('#erro').html('Mensagem: ' + resp['msg'] + ' ' + resp['erro']).fadeIn().attr('hidden', false);
              }
              else{
                $('#clear').click();
                window.location.replace('../prof/home');
              }
            }
          );
        }
      });
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
      $('#print').click(function(){
        tela_impressao = window.open('about:blank');
        tela_impressao.document.write($('#terms_of_use').html());
        tela_impressao.window.print();
        tela_impressao.window.close();
      });
    });     
    </script>
    <footer class="my-5 pt-5 text-muted text-center text-small">
      <p class="mt-5 mb-3 text-muted"><img src="../templates/logo-muted.svg" width="30px">-TRAT: Tratamentos de Saúde<br> &copy; 2017-2019</p>
    </footer>
  </body>
</html>
