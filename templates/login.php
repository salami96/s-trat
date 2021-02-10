<?php
  // session_start();
?>
<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../templates/logo.ico">

    <title>Login no S-trat</title>

    <!-- Bootstrap core CSS -->
    <link href="/templates/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/templates/css/signin.css" rel="stylesheet">
  </head>

  <body class="text-center">
    <form class="form-signin" action="#void" method="POST">
      <a href="/"><img class="mb-4" src="/templates/logo2.svg" alt=""></a>
      <label for="inputEmail" class="sr-only">Email</label>
      <input type="email" id="email" name="email" class="form-control" placeholder="Email" required autofocus>
      <label for="inputPassword" class="sr-only">Senha</label>
      <input type="password" id="senha" name="senha" class="form-control" placeholder="Senha" required>
      <!--<div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Lembrar-me
        </label>
      </div>-->
      <button class="btn btn-lg btn-outline-primary" id="logar" type="button">Entrar</button>
      <a class="btn btn-lg btn-outline-secondary" href="../prof/form">Registrar-se</a>
      <div class="alert alert-danger mt-2" id="erro" role="alert" hidden></div>
      <p class="mt-5 mb-3 text-muted"><img src="../templates/logo-muted.svg" width="30px">-TRAT: Tratamentos de Saúde<br> &copy; 2017-2019</p>
    </form>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../templates/js/jquery-slim.min.js"><\/script>')</script>-->
    <script src="../templates/js/popper.min.js"></script>
    <script src="../templates/js/bootstrap.min.js"></script>
    <script src="../templates/js/holder.min.js"></script>
    <script>
      <?php
        if(isset($_SESSION['msg'])){
          $msg = $_SESSION['msg'];
          echo "$('#erro').html('$msg').fadeIn().attr('hidden', false);";
        }
      ?>
      $('#email').keypress(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
          $('#senha').focus(); 
        }
      });
      $('#senha').keypress(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
          $('#logar').click(); 
        }
      });
      $('#logar').click(function() {
        var data = {'email':$('#email').val(), 'senha':$('#senha').val()};
        $.post("../docs/login/",data,function(resp){
            if (resp['status'] == 'false') {
              $('#erro').html(resp['msg']).fadeIn().attr('hidden', false);
            }
            else{
              window.location.replace('../prof/home');
            }
          }
        );
      })
    </script>
  </body>
</html>
