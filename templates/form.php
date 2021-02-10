<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/templates/logo.ico">

    <title>Registre-se no S-trat</title>

    <!-- Bootstrap core CSS -->
    <link href="../templates/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../templates/css/form-validation.css" rel="stylesheet">
    <style type="text/css">
      .logo{
        width: 40%;
      }
      @media(max-width: 768px) {
        .logo{
          width: 80% !important;
        }
      }
    </style>
  </head>

  <body class="bg-light">

    <div class="container">
      <div class="py-5 text-center">
        <a href="/">
          <img class="d-block mx-auto logo" src="/templates/logo2.svg" alt="">
        </a>
        <!-- <h2>Informe seus dados</h2>
        <p class="lead">Preencha esta ficha cadastral com o mínimo dos dados necessários para utilizar os serviços oferecidos pelo S-trat: tratamentos de saúde.</p> -->
      </div>

      <div class="row">
        
        <div class="col-md-6 offset-md-3 order-md-1">
          <div class="alert mt-2" id="response" role="alert" hidden></div>
          <h4 class="mb-3">Cadastro de Profissionais de Saúde</h4>
          <form class="needs-validation" action="../docs/" method="POST" novalidate>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" placeholder="" required>
                <div class="invalid-feedback">
                  É obrigatório preencher o campo nome.
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="sobrenome">Sobrenome</label>
                <input type="text" class="form-control" id="sobrenome" name="sobrenome" placeholder="" required>
                <div class="invalid-feedback">
                  É obrigatório preencher o campo sobrenome.
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label for="telefone">Telefone</label>
              <input type="tel" class="form-control phone" id="telefone" name="telefone" placeholder="(00) 00000-0000" required>
              <div class="invalid-feedback">
                Por favor, informe um telefone válido para o seu cadastro.
              </div>
            </div>            
            <div class="mb-3">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="voce@exemplo.com" required>
              <div class="invalid-feedback">
                Por favor, informe um email válido para o seu cadastro.
              </div>
            </div>
            <div class="mb-3">
              <label for="senha">Senha</label>
              <input type="password" class="form-control" id="senha" name="senha" placeholder="********" maxlength="12" required>
              <div class="invalid-feedback">
                Por favor, informe uma senha válida para o seu cadastro.
              </div>
            </div>
            <div class="mb-3">
              <button class="btn btn-outline-secondary btn-sm" data-toggle="modal" data-target="#text" data-backdrop="static" 
              data-keyboard="false">Ler Termos de uso</button>
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="terms" required>
                <label class="custom-control-label" for="terms">Eu li e aceito os termos de uso do S-trat</label>
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
                    <a href="/termo_de_uso.pdf" role="button" class="btn btn-outline-success">Baixar</a>
                    <button type="button" class="btn btn-outline-primary" id="print">Imprimir</button>
                  </div>
                </div>
              </div>
            </div>

            <!--div class="mb-3">
              <label for="crm">CRM</label>
              <input type="text" class="form-control" id="crm" name="crm" placeholder="0000000000/RS">
              <div class="invalid-feedback">
                Por favor, informe um CRM válido para o seu cadastro.
              </div>
            </div-->
            <div class="text-center">
            <button class="btn btn-outline-primary btn-lg" type="submit">Registrar-se</button>
            <button class="btn btn-outline-danger btn-lg" type="reset">Limpar</button>
            </div>
          </form>
        </div>
      </div>
      <div class="text-center mt-3">
        <a href="/prof/login" role="button" class="btn btn-outline-secondary btn-sm">Já tem cadastro?</a>
      </div>
      <footer class="pt-5 text-muted text-center text-small">
        <p class="mt-5 mb-3 text-muted"><img src="/templates/logo-muted.svg" width="30px">-TRAT: Tratamentos de Saúde<br> &copy; 2017-2019</p>
      </footer>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster 
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../templates/js/jquery-slim.min.js"><\/script>')</script>-->
    
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="/templates/js/popper.min.js"></script>
    <script src="/templates/js/bootstrap.min.js"></script>
    <script src="/templates/js/holder.min.js"></script>
    <!-- mask -->
    <script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    
    <script>
      $(document).ready(function() {
        $('.phone').mask('(00) 00000-0000');
        $('#telefone').mask('(00) 00000-0000');
        $('.close-modal').click(function(){
          $('.modal-backdrop').remove();
        });
        $('#print').click(function(){
          tela_impressao = window.open('about:blank');
          tela_impressao.document.write($('#terms_of_use').html());
          tela_impressao.window.print();
          tela_impressao.window.close();
        });
        <?php
          if(isset($_SESSION['status'])){
            if ($_SESSION['status'] == 'true'){
              $msg = $_SESSION['msg'];
              echo "$('#response').toggleClass('alert-success').html('$msg'+'<a class=\'btn btn-block btn-success\' href=\'../prof/login\'> Entrar</a>').fadeIn().attr('hidden', false);";
              echo "setTimeout(function(){";
                echo "window.location.href = '../prof/login';";
              echo "},5000);";
            }else{
              $msg = $_SESSION['msg'] . $_SESSION['erro'];
              echo "$('#response').toggleClass('alert-danger').html('$msg').fadeIn().attr('hidden', false);";
            }
          }
        ?>
      });
      

      // Example starter JavaScript for disabling form submissions if there are invalid fields
      (function() {
        'use strict';

        window.addEventListener('load', function() {
          // Fetch all the forms we want to apply custom Bootstrap validation styles to
          var forms = document.getElementsByClassName('needs-validation');

          // Loop over them and prevent submission
          var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
              if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
              }
              form.classList.add('was-validated');
            }, false);
          });
        }, false);
      })();
    </script>
  </body>
</html>
