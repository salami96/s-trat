<?php
session_start();

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpNotFoundException;

require 'vendor/autoload.php';
use \Mailjet\Resources;

$config['displayErrorDetails'] = true;

$app = new \Slim\App(['settings' => $config]);
// Get container
$container = $app->getContainer();


// Register component on container
$container['view'] = function ($container) {
  return new \Slim\Views\PhpRenderer('./templates/');
};

$app->get('/time', function (Request $req, Response $resp, array $args){
  $format = 'Y-m-d H:i';
  $date = new DateTime();
  $date->setTimezone(new DateTimeZone('America/Sao_paulo'));
  echo $date->format($format);
});
$app->get('/', function (Request $req, Response $resp, array $args){  
  return $this->view->render($resp,'home.html');
    /*$resp->getBody()->write("Bem vind@ ao S-trat, escolha a opção desejada:
      </br><a href='prof/login'><button>Acessar sua Página</button></a>
      </br><a href='pacientes'><button>Listar Pacientes</button></a>
      </br><a href='docs'><button>Listar Profissionais de Saúde</button></a>
      </br><a href='medicamentos'><button>Listar medicamentos</button></a>
      </br><a href='message'><button>Enviar Notificação</button></a>
      </br><a href='app-debug.apk'><button>Baixar App</button></a>");*/
});
$app->post('/send-sms[/]', function (Request $req, Response $resp, array $args){
    $obj = $req->getParsedBody();
    $number = $obj["telefone"];
    $number = preg_replace('/\D/', '', $number);
    $number = '55' . $number;
    $basic  = new \Nexmo\Client\Credentials\Basic('****', '****');
    $client = new \Nexmo\Client($basic);

    $message = $client->message()->send([
        'to' => $number,
        'from' => 'S-trat',
        'text' => 'Bem-vindo ao S-trat, baixe o app em s-trat.tk/download'
    ]);
    if($message['status'] == 0){
      $new = $resp->withJson(array("status" => 'true', "msg" => 'Mensagem enviada com sucesso para ' . $message['to']));
    } else{
      $new = $resp->withJson(array("status" => 'false', "msg" => 'Erro ao enviar a mensagem'));
    }
    return $new;
});
$app->get('/download[/]', function (Request $req, Response $resp, array $args){
    return $this->view->render($resp,'download.php');
});
$app->get('/pacientes[/]', function (Request $req, Response $resp, array $args){
    $stmt = getConn()->query("SELECT nome FROM Paciente;");
    $paciente = $stmt->fetchAll(PDO::FETCH_OBJ);
    $new = $resp->withJson($paciente);
    return $new;
});
$app->get('/pacientes/{id}[/]', function (Request $req, Response $resp, array $args){
    $id = $args['id'];
    $stmt = getConn()->query("SELECT nome FROM Paciente WHERE idPac = $id;");
    $paciente = $stmt->fetchAll(PDO::FETCH_OBJ);
    $new = $resp->withJson($paciente);
    return $new;
});
$app->post('/pacientes[/]', function (Request $req, Response $resp, array $args) {
    $obj = $req->getParsedBody();
    $email = $obj["email"];
    $senha = $obj["senha"];
    if(empty($senha)){
      $senha = "12345";
    }
    if(empty($email)){
      $data = array("status" => "false","msg" => "Problema na passagem de parametros! Informe um e-mail válido!");
    }else{
      $pdo = getConn();
      if($obj){
        $stmt = $pdo->prepare("INSERT INTO Paciente VALUES (NULL, ?, ?, ?, ?, ?);");
        $stmt->bindParam(1,$obj["nome"],PDO::PARAM_STR);
        $stmt->bindParam(2,$obj["sobrenome"],PDO::PARAM_STR);
        $stmt->bindParam(3,$obj["telefone"],PDO::PARAM_STR);
        $stmt->bindParam(4,$email,PDO::PARAM_STR);
        $stmt->bindParam(5,$senha,PDO::PARAM_STR);
        $data = getMsg($stmt);
      }
    }
    $new = $resp->withJson($data);
    return $new;
});
$app->put('/pacientes/{id}[/]', function (Request $req, Response $resp, array $args) {
    $obj = $req->getParsedBody();
    $pdo = getConn();
    if($obj){
      $stmt = $pdo->prepare("UPDATE Paciente SET nome = ?, sobrenome = ?, telefone = ?, email = ?, senha = ? WHERE idPac = ?;");
      $stmt->bindParam(1,$obj["nome"],PDO::PARAM_STR);
      $stmt->bindParam(2,$obj["sobrenome"],PDO::PARAM_STR);
      $stmt->bindParam(3,$obj["telefone"],PDO::PARAM_STR);
      $stmt->bindParam(4,$obj["email"],PDO::PARAM_STR);
      $stmt->bindParam(5,$obj["senha"],PDO::PARAM_STR);
      $stmt->bindParam(6,$args['id'],PDO::PARAM_INT);
      $data = getMsg($stmt);
    }
    $new = $resp->withJson($data);
    return $new;
});
$app->delete('/pacientes/{id}[/]', function (Request $req, Response $resp, array $args) {
    $id = $args['id'];
    $pdo = getConn();
    if($id){
      $stmt = $pdo->prepare("DELETE FROM Paciente WHERE idPac = ?;");
      $stmt->bindParam(1,$id,PDO::PARAM_INT);
      $data = getMsg($stmt);
    }
    $new = $resp->withJson($data);
    return $new;
});
$app->get('/prof/pac-form[/]', function (Request $req, Response $resp, array $args){
    return $this->view->render($resp,'form_to_paciente.php');
});
$app->get('/pac/historico/{id}/{key}', function (Request $req, Response $resp, array $args){
  $id = $args['id'];
  $key = $args['key'];
  $stmt = getConn()->query("SELECT * FROM Paciente WHERE idPac = '".$id."';");
  if($stmt->rowCount()){
    $row = $stmt->fetch(PDO::FETCH_OBJ);
    $format = 'Y-m-d';
    $datetime = new DateTime();
    $pacienteKey = md5($datetime->format($format) . $row->senha);
    if ($key == $pacienteKey){
      $_SESSION["idPac"] = $id;
      $_SESSION["nomePac"] = $row->nome . ' ' . $row->sobrenome;
    } else {
      unset($_SESSION["idPac"]);
      unset($_SESSION["nomePac"]);
      $_SESSION["msg"] = "Seu link de acesso expirou, ou é inválido, gere outro no App!";
    } 
  } else {
    unset($_SESSION["idPac"]);
    unset($_SESSION["nomePac"]);
    $_SESSION["msg"] = "Seu link de acesso está com problema, gere outro no App!";
  }
  return $this->view->render($resp,'hist_familiar.php');
});
$app->get('/parcial/{nome}[/]', function (Request $req, Response $resp, array $args){
    $nome = $args['nome'];
    $stmt = getConn()->query("SELECT idPac as 'id',CONCAT(nome,' ',sobrenome) as 'text' FROM Paciente WHERE ((nome LIKE '%".$nome."%')||(sobrenome LIKE '%".$nome."%')) LIMIT 0,10;");
    $pacientes = $stmt->fetchAll(PDO::FETCH_OBJ);
    $new = $resp->withJson(array("results" => $pacientes));
    return $new;
});
$app->post('/pacientes/login[/]', function (Request $req, Response $resp, array $args){
    $obj = $req->getParsedBody();
    $email = $obj["email"];
    $senha = $obj["senha"];
    if(empty($email)||(empty($senha))){
      $data = array("status" => "false","msg" => "Problema na passagem de parametros!");
    }
    else {
      $stmt = getConn()->query("SELECT * FROM Paciente WHERE email = '".$email."';");
      if($stmt->rowCount()){
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        if ($row->senha == $senha) {
          $format = 'Y-m-d';
          $datetime = new DateTime();
          $key = md5($datetime->format($format) . $row->senha);
          $data = array("status" => "true","msg" => "Logado com sucesso!", "id" => $row->idPac, "access_key" => $key);
        } else {
          $data = array("status" => "false","msg" => "Senha incorreta!");
        }
      } else {
	  $data = array("status" => "false","msg" => "Email nao cadastrado em nosso sistema");
      }
    }
    $email = "";
    $senha = "";
    $new = $resp->withJson($data);
    return $new;
});
########################################################################################################
########################################################################################################
############################## Profissionais de Saúde ##################################################
########################################################################################################
########################################################################################################
$app->get('/docs[/]', function (Request $req, Response $resp, array $args){
    $stmt = getConn()->query("SELECT CONCAT(nome,' ',sobrenome) FROM Profissional;");
    $profissional = $stmt->fetchAll(PDO::FETCH_OBJ);
    $new = $resp->withJson($profissional);
    return $new;
});
$app->get('/docs/{id}[/]', function (Request $req, Response $resp, array $args){
    $id = $args['id'];
    $stmt = getConn()->query("SELECT CONCAT(nome,' ',sobrenome) FROM Profissional WHERE idProf = $id;");
    $profissional = $stmt->fetchAll(PDO::FETCH_OBJ);
    $new = $resp->withJson($profissional);
    return $new;
});
$app->post('/docs[/]', function (Request $req, Response $resp, array $args) {
    $obj = $req->getParsedBody();
    $pdo = getConn();
    if($obj){
      $stmt = $pdo->prepare("INSERT INTO Profissional VALUES (NULL, ?, ?, ?, 0, ?, ?, 0);");
      $stmt->bindParam(1,$obj["nome"],PDO::PARAM_STR);
      $stmt->bindParam(2,$obj["sobrenome"],PDO::PARAM_STR);
      $stmt->bindParam(3,$obj["telefone"],PDO::PARAM_STR);
      $stmt->bindParam(4,$obj["email"],PDO::PARAM_STR);
      $stmt->bindParam(5,$obj["senha"],PDO::PARAM_STR);
      $data = getMsg($stmt);

      $_SESSION['msg'] = $data['msg'];
      $_SESSION['status'] = $data['status'];
      
      if($data['status'] == 'true'){
        $result = email($obj["email"], $obj["nome"]);
        if($result["Messages"][0]["Status"] == "success"){
          $_SESSION['msg'] .= " Verifique seu e-mail e confirme seu cadastro!";
        }
      }
      
      return $this->view->render($resp,'form.php');
    }
    $new = $resp->withJson($data);
    return $new;
});
$app->get('/resend/{email}[/]', function (Request $req, Response $resp, array $args) {
  email($args["email"], "new user");
  $_SESSION['msg'] = " Verifique seu e-mail e confirme seu cadastro!";
  return $this->view->render($resp,'login.php');
});
$app->get('/activation-doc/{email}/{key}[/]', function (Request $req, Response $resp, array $args) {
  $email = $args["email"];
  $key = $args["key"];
  if($key == md5('****')){
    $pdo = getConn();
    $stmt = $pdo->prepare("UPDATE Profissional SET level = 1 WHERE email = ?;");
    $stmt->bindParam(1,$email,PDO::PARAM_STR);
    $data = getMsg($stmt);
  } else {
    $data = array("status" => "false","msg" => "Falha ao ativar! Tente novamente mais tarde.");
  }
  $new = $resp->withJson($data);
  return $new;
});
$app->put('/docs/{id}[/]', function (Request $req, Response $resp, array $args) {
    $obj = $req->getParsedBody();
    $pdo = getConn();
    if($obj){
      $stmt = $pdo->prepare("UPDATE Profissional SET nome = ?, sobrenome = ?, telefone = ?, crm = ? WHERE idProf = ?;");
      $stmt->bindParam(1,$obj["nome"],PDO::PARAM_STR);
      $stmt->bindParam(2,$obj["sobrenome"],PDO::PARAM_STR);
      $stmt->bindParam(3,$obj["telefone"],PDO::PARAM_STR);
      $stmt->bindParam(4,$obj["crm"],PDO::PARAM_STR);
      $stmt->bindParam(5,$args['id'],PDO::PARAM_INT);
      $data = getMsg($stmt);
    }
    $new = $resp->withJson($data);
    return $new;
});
$app->delete('/docs/{id}[/]', function (Request $req, Response $resp, array $args) {
    $id = $args['id'];
    $pdo = getConn();
    if($id){
      $stmt = $pdo->prepare("DELETE FROM Profissional WHERE idProf = ?;");
      $stmt->bindParam(1,$id,PDO::PARAM_INT);
      $data = getMsg($stmt);
    }
    $new = $resp->withJson($data);
    return $new;
});
$app->get('/prof/login[/]', function (Request $req, Response $resp, array $args){
    return $this->view->render($resp,'login.php');
});
$app->get('/prof/logout[/]', function (Request $req, Response $resp, array $args){
    session_destroy();
    return $this->view->render($resp,'login.php');
});
$app->get('/prof/form[/]', function (Request $req, Response $resp, array $args){
    return $this->view->render($resp,'form.php');
});
$app->get('/prof/home[/]', function (Request $req, Response $resp, array $args){
    return $this->view->render($resp,'dash.php');
});
$app->get('/prof/receitas[/]', function (Request $req, Response $resp, array $args){
    return $this->view->render($resp,'add_receita.php');
});
$app->get('/prof/proceds[/]', function (Request $req, Response $resp, array $args){
    return $this->view->render($resp,'add_procedimento.php');
});
$app->get('/prof/medicao[/]', function (Request $req, Response $resp, array $args){
    return $this->view->render($resp,'add_medicao.php');
});
$app->post('/prof/receitas', function (Request $req, Response $resp, array $args){
    $obj = $req->getParsedBody();
    $id = $obj['idPac'];
    $stmt = getConn()->query("SELECT CONCAT(nome,' ',sobrenome) as nomePac FROM Paciente WHERE idPac = $id;");
    $paciente = $stmt->fetchAll(PDO::FETCH_OBJ);
    $_SESSION['idPac'] = $id;
    $_SESSION['nomePac'] = $paciente[0]->nomePac;
    return $this->view->render($resp,'add_receita.php');
});
$app->get('/prof/historico[/]', function (Request $req, Response $resp, array $args){
    return $this->view->render($resp,'historico_pac.php');
});
$app->get('/prof/pacientes[/]', function (Request $req, Response $resp, array $args){
    return $this->view->render($resp,'pacientes.php');
});
$app->post('/docs/login[/]', function (Request $req, Response $resp, array $args){
    $obj = $req->getParsedBody();
    $email = $obj["email"];
    $senha = $obj["senha"];
    if(empty($email)||(empty($senha))){
      $data = array("status" => "false","msg" => "Problema na passagem de parametros!");
    }
    else {
      $stmt = getConn()->query("SELECT * FROM Profissional WHERE email = '".$email."';");
      if($stmt->rowCount()){
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        if ($row->senha == $senha) {
          if ($row->level > 0) {
            $data  = array('status' => true);
            $_SESSION['idProf'] = $row->idProf;
            $_SESSION['nomeProf'] = $row->nome.' '.$row->sobrenome;
          } else {
            $data = array("status" => "false","msg" => "Conta ainda não foi verficada! <a href='****" . $email . "'>Reenviar e-mail</a>");
          }
        } else {
          $data = array("status" => "false","msg" => "Senha incorreta!");
        }
      }
      else{
        $data = array("status" => "false","msg" => "Email não consta em nosso banco de dados!");
      }

    }
    $email = "";
    $senha = "";
    $new = $resp->withJson($data);
    return $new;
});
########################################################################################################
########################################################################################################
##############################      MEDICAMENTOS      ##################################################
########################################################################################################
########################################################################################################

$app->get('/medicamentos[/]', function (Request $req, Response $resp, array $args){
    $stmt = getConn()->query("SELECT * FROM Medicamento LIMIT 500;");
    $medicamentos = $stmt->fetchAll(PDO::FETCH_OBJ);
    $new = $resp->withJson($medicamentos);
    return $new;
});
$app->get('/medicamentos/{id}[/]', function (Request $req, Response $resp, array $args){
    $id = $args['id'];
    $stmt = getConn()->query("SELECT * FROM Medicamento WHERE idMed = $id;");
    $medicamentos = $stmt->fetchAll(PDO::FETCH_OBJ);
    $new = $resp->withJson($medicamentos);
    return $new;
});
$app->get('/medicamentos/parcial/{nome}[/]', function (Request $req, Response $resp, array $args){
    $nome = $args['nome'];
    $stmt = getConn()->query("SELECT idMed,NO_PRODUTO,DS_APRESENTACAO FROM Medicamento WHERE NO_PRODUTO LIKE '%".$nome."%' LIMIT 0,5;");
    $medicamentos = $stmt->fetchAll(PDO::FETCH_OBJ);
    $new = $resp->withJson($medicamentos);
    return $new;
});
$app->get('/medicamentos/search/{nome}[/]', function (Request $req, Response $resp, array $args){
    $nome = $args['nome'];
    $stmt = getConn()->query("SELECT idMed as 'id',CONCAT(NO_PRODUTO,' ',DS_APRESENTACAO) as 'text' FROM Medicamento WHERE NO_PRODUTO LIKE '%".$nome."%' LIMIT 0,20;");
    $medicamentos = $stmt->fetchAll(PDO::FETCH_OBJ);
    $new = $resp->withJson(array("results" => $medicamentos));
    return $new;
});
########################################################################################################
########################################################################################################
##################################      RECEITAS      ##################################################
########################################################################################################
########################################################################################################
#######   PEGAR RECEITA POR PACIENTE ID
$app->get('/receitas/{id}[/{todos}]', function (Request $req, Response $resp, array $args){
    $date = new DateTime();
    $date->setTimezone(new DateTimeZone('America/Sao_paulo'));
    $id = $args['id'];
    if (isset($args['todos'])) {
      if ($args['todos']=='todos'){
        $date->modify('-3 month');
      }
    }
    $date = $date->format('Y-m-d');
    $stmt = getConn()->query("SELECT m.NO_PRODUTO as 'medicamento', m.idMed as 'id_med', p.idPac as 'id_pac', CONCAT(p.nome,' ',p.sobrenome) as 'paciente', r.horario as 'hora', r.horario_realiz as 'hora_real', r.realizado as 'realizado', r.dosagem as dosagem, r.importante as 'importante', r.latitude as 'latitude', r.longitude as 'longitude', r.raegendado as 'reagendado', r.editado as 'editado', r.Profissional_idProf as 'id_prof', CONCAT(pr.nome,' ',pr.sobrenome) as 'prof' FROM Medicamento as m, Paciente as p, Paciente_toma_Medicamento as r, Profissional as pr WHERE ((r.Paciente_idPac = $id)&&(p.idPac = $id)&&(r.Medicamento_idMed = m.idMed)&&(pr.idProf = r.Profissional_idProf)&&(r.horario >= '$date')) ORDER BY r.horario LIMIT 0,150;");
    $medicamentos = $stmt->fetchAll(PDO::FETCH_OBJ);
    $stmt = getConn()->query("SELECT rp.descProcedimento as 'proced', rp.idProcedimentos as 'id_proc', rp.obs as 'obs', rp.horario as 'horario', rp.realizado as 'realizado', p.idPac as 'id_pac', CONCAT(p.nome,' ',p.sobrenome) as 'paciente', rp.Profissional_id as 'id_prof', CONCAT(pr.nome,' ',pr.sobrenome) as 'prof' FROM RegistroProcedimentos as rp,Paciente as p, Profissional as pr WHERE((p.idPac = $id)&&(rp.Paciente_id = $id)&&(pr.idProf = rp.Profissional_id)&&(rp.horario >= '$date')) ORDER BY rp.horario LIMIT 0,100;");
    $procedimentos = $stmt->fetchAll(PDO::FETCH_OBJ);
    $stmt = getConn()->query("SELECT m.descricao as 'medicao', m.description as 'description', m.idMedicoes as 'id_medicao', p.idPac as 'id_pac',CONCAT(p.nome,' ',p.sobrenome) as 'paciente', pfm.horario as 'hora', pfm.horario_realiz as 'hora_real', pfm.realizado as 'realizado', pfm.obs as 'obs', pfm.resultado as 'resultado', pfm.Profissional_idProf as 'id_prof', CONCAT(pr.nome,' ',pr.sobrenome) as 'prof' FROM Medicoes as m, Paciente as p, Paciente_faz_Medicao as pfm, Profissional as pr WHERE ((pfm.Paciente_idPac = $id)&&(p.idPac = $id)&&(m.idMedicoes = pfm.Medicoes_idMedicoes)&&(pr.idProf = pfm.Profissional_idProf)&&(pfm.horario >= '$date')) ORDER BY pfm.horario LIMIT 0,100;");
    $medicoes = $stmt->fetchAll(PDO::FETCH_OBJ);
    $new = $resp->withJson(array("medicamentos" => $medicamentos,"procedimentos" => $procedimentos, "medicoes" => $medicoes));
    return $new;
});
#######  PEGAR RECITA POR PROF ID
$app->get('docs/receitas/{id}[/{todos}]', function (Request $req, Response $resp, array $args){
    $date = new DateTime();
    //$date->setTimezone(new DateTimeZone('America/Sao_paulo'));
    $id = $args['id'];
    if (isset($args['todos'])) {
      if ($args['todos']=='todos') {
        $date->setDate(2018,01,01);
      }
    }
    $date = $date->format('Y-m-d');
    $stmt = getConn()->query("SELECT m.NO_PRODUTO as 'medicamento', m.idMed as 'id_med', p.idPac as 'id_pac', CONCAT(p.nome,' ',p.sobrenome) as 'paciente', r.horario as 'hora', r.horario_realiz as 'hora_real', r.realizado as 'realizado', r.dosagem as dosagem, r.importante as 'importante', r.latitude as 'latitude', r.longitude as 'longitude', r.raegendado as 'reagendado', r.editado as 'editado', r.Profissional_idProf as 'id_prof', CONCAT(pr.nome,' ',pr.sobrenome) as 'prof' FROM Medicamento as m, Paciente as p, Paciente_toma_Medicamento as r, Profissional as pr WHERE ((r.Paciente_idPac = $id)&&(p.idPac = $id)&&(r.Medicamento_idMed = m.idMed)&&(pr.idProf = r.Profissional_idProf)&&(r.horario >= '$date')) ORDER BY r.horario LIMIT 0,200;");
    $medicamentos = $stmt->fetchAll(PDO::FETCH_OBJ);
    $stmt = getConn()->query("SELECT rp.descProcedimento as 'proced', rp.idProcedimentos as 'id_proc', rp.obs as 'obs', rp.horario as 'horario', rp.realizado as 'realizado', p.idPac as 'id_pac', CONCAT(p.nome,' ',p.sobrenome) as 'paciente', rp.Profissional_id as 'id_prof', CONCAT(pr.nome,' ',pr.sobrenome) as 'prof' FROM RegistroProcedimentos as rp,Paciente as p, Profissional as pr WHERE((p.idPac = $id)&&(rp.Paciente_id = $id)&&(pr.idProf = rp.Profissional_id)&&(rp.horario >= '$date')) ORDER BY rp.horario LIMIT 0,100;");
    $procedimentos = $stmt->fetchAll(PDO::FETCH_OBJ);
    $stmt = getConn()->query("SELECT m.descricao as 'medicao', m.idMedicoes as 'id_medicao', p.idPac as 'id_pac',CONCAT(p.nome,' ',p.sobrenome) as 'paciente', pfm.horario as 'hora', pfm.horario_realiz as 'hora_real', pfm.realizado as 'realizado', pfm.obs as 'obs', pfm.resultado as 'resultado', pfm.Profissional_idProf as 'id_prof', CONCAT(pr.nome,' ',pr.sobrenome) as 'prof' FROM Medicoes as m, Paciente as p, Paciente_faz_Medicao as pfm, Profissional as pr WHERE ((pfm.Paciente_idPac = $id)&&(p.idPac = $id)&&(m.idMedicoes = pfm.Medicoes_idMedicoes)&&(pr.idProf = pfm.Profissional_idProf)&&(pfm.horario >= '$date')) ORDER BY pfm.horario LIMIT 0,150;");
    $medicoes = $stmt->fetchAll(PDO::FETCH_OBJ);
    $new = $resp->withJson(array("medicamentos" => $medicamentos,"procedimentos" => $procedimentos, "medicoes" => $medicoes));
    return $new;
});

$app->post('/receitas[/]', function (Request $req, Response $resp, array $args) {
    $obj = $req->getParsedBody();
    $pac = $obj["pac"];
    $idMed = $obj["idMed"];
    $dose = $obj["dose"];
    $hora = $obj["hora"];
    $date = $obj["data"];
    $vezes = $obj["vezes"];
    $tratContinuo = $obj["tratContinuo"];
    $duracao = $obj["duracao"];
    $dias = $obj["dias"];
    $prof = $obj["idProf"];
    $importante = $obj["importante"];
    $date = explode("/", $date);
    $hora = explode(":", $hora);
    $format = 'Y-m-d H:i';
    $datetime = new DateTime();
    $dateNow = new DateTime();
    $dateFinal = new DateTime();
    $datetime->setTimezone(new DateTimeZone('America/Sao_paulo'));
    $dateNow->setTimezone(new DateTimeZone('America/Sao_paulo'));
    $dateFinal->setTimezone(new DateTimeZone('America/Sao_paulo'));
    $datetime->SetDate($date[2],$date[1],$date[0]);
    $datetime->SetTime(23,59,59);
    $dateFinal->SetDate($date[2],$date[1],$date[0]);
    $dateFinal->SetTime($hora[0],$hora[1],0);

    //echo $datetime->format('Y-m-d H:i');
    //echo $dateNow->format('Y-m-d H:i');
    if ($datetime >= $dateNow){
      $datetime->SetTime($hora[0],$hora[1],0);
      if ($tratContinuo == "1") {
        $dateFinal->setDate(2020,12,31);
        $dateFinal->SetTime(0,0,0);
      }else{
        if(($dias == "Dias")||($dias == "Days")){
          $dateFinal->modify('+'.$duracao.' day');
        }
        if(($dias == "Semanas")||($dias == "Weeks")){
          $dateFinal->modify('+'.$duracao.' week');
        }
        if(($dias == "Mêses")||($dias == "Months")){
          $dateFinal->modify('+'.$duracao.' month');
        }
        if(($dias == "Anos")||($dias == "Years")){
          $dateFinal->modify('+'.$duracao.' year'); 
        }
      }
      $pdo = getConn();

      $cont = 0;
      $horas = 24/$vezes;
      if (($horas == 24)||($horas == 12)||($horas == 8)||($horas == 6)||($horas == 4)){
        while ($datetime<$dateFinal) {
          $aux = $datetime->format($format);
          $stmt = $pdo->prepare("INSERT INTO Paciente_toma_Medicamento VALUES (?, ?, ?, ?, 0, ?, ?, ?, NULL, NULL, NULL, NULL);");
          $stmt->bindParam(1,$pac,PDO::PARAM_STR);
          $stmt->bindParam(2,$idMed,PDO::PARAM_STR);
          $stmt->bindParam(3,$aux,PDO::PARAM_STR);
          $stmt->bindParam(4,$aux,PDO::PARAM_STR);
          $stmt->bindParam(5,$dose,PDO::PARAM_STR);
          $stmt->bindParam(6,$prof,PDO::PARAM_STR);
          $stmt->bindParam(7,$importante,PDO::PARAM_INT);

          $data = getMsg($stmt);

          $datetime->modify("+$horas hour");
          $cont++;
        }
      }else{
        $new = $resp->withJson(
          array("status" => "false","msg" => "Houve um problema, tente novamente mais tarde!","erro" => "Informe um valor entre 1,2,3,4 ou 6 para o campo Vezes $pac"));
          return $new;
      }
    }else{
      $data = array("status" => "false","msg" => "Houve um problema, tente novamente mais tarde!","erro" => "Data informada ja passou!");
    }
    $new = $resp->withJson($data);
    return $new;
});
$app->put('/receitas/{id}[/]', function (Request $req, Response $resp, array $args) {
    $obj = $req->getParsedBody();
    $pdo = getConn();
    if($obj){
      if($obj['type']==0){
        $stmt = $pdo->prepare("UPDATE Paciente_toma_Medicamento SET horario_realiz = ?, realizado = ? WHERE ((Medicamento_idMed = ?)&&(horario = ?)&&(Paciente_idPac = ?));");
        $stmt->bindParam(1,$obj["hora_real"],PDO::PARAM_STR);
        $stmt->bindParam(2,$obj["realizado"],PDO::PARAM_INT);
        $stmt->bindParam(3,$obj["idObj"],PDO::PARAM_INT);
        $stmt->bindParam(4,$obj["hora"],PDO::PARAM_STR);
        $stmt->bindParam(5,$args['id'],PDO::PARAM_INT);
        $data = getMsg($stmt);
      }
      else if($obj['type']==1){
        $stmt = $pdo->prepare("UPDATE RegistroProcedimentos SET realizado = ? WHERE (idProcedimentos = ?);");
        $stmt->bindParam(1,$obj["realizado"],PDO::PARAM_INT);
        $stmt->bindParam(2,$obj["idObj"],PDO::PARAM_INT);
        $data = getMsg($stmt);
      }
    }
    $new = $resp->withJson($data);
    return $new;
});
########################################################################################################
########################################################################################################
##################################      MEDIÇÕES      ##################################################
########################################################################################################
########################################################################################################
$app->get('/medicoes[/{lang}]', function (Request $req, Response $resp, array $args){
    if(!isset($args['lang'])){
      $stmt = getConn()->query("SELECT * FROM Medicoes;");
      $medicoes = $stmt->fetchAll(PDO::FETCH_OBJ);
      $new = $resp->withJson($medicoes);
      return $new;
    } else {
      if($args['lang']=='en'){
        $stmt = getConn()->query("SELECT idMedicoes, description as descricao FROM Medicoes;");
        $medicoes = $stmt->fetchAll(PDO::FETCH_OBJ);
        $new = $resp->withJson($medicoes);
        return $new;
      }
    }
});
$app->post('/medicoes[/]', function (Request $req, Response $resp, array $args) {
    $obj = $req->getParsedBody();
    $pac = $obj["pac"];
    $medicao = $obj["medicao"];
    $obs = $obj["obs"];
    $hora = $obj["hora"];
    $date = $obj["data"];
    $vezes = $obj["vezes"];
    $tratContinuo = $obj["tratContinuo"];
    $duracao = $obj["duracao"];
    $dias = $obj["dias"];
    $prof = $obj["idProf"];
    $date = explode("/", $date);
    $hora = explode(":", $hora);
    $format = 'Y-m-d H:i';
    $datetime = new DateTime();
    $dateNow = new DateTime();
    $dateFinal = new DateTime();
    $datetime->setTimezone(new DateTimeZone('America/Sao_paulo'));
    $dateNow->setTimezone(new DateTimeZone('America/Sao_paulo'));
    $dateFinal->setTimezone(new DateTimeZone('America/Sao_paulo'));
    $datetime->SetDate($date[2],$date[1],$date[0]);
    $datetime->SetTime(23,59,59);
    $dateFinal->SetDate($date[2],$date[1],$date[0]);
    $dateFinal->SetTime($hora[0],$hora[1],0);
    //echo $datetime->format('Y-m-d H:i');
    //echo $dateNow->format('Y-m-d H:i');
    if ($datetime >= $dateNow){
      $datetime->SetTime($hora[0],$hora[1],0);
      if ($tratContinuo == "1") {
        $dateFinal->setDate(2020,12,31);
        $dateFinal->SetTime(0,0,0);
      }else{
        if(($dias == "Dias")||($dias == "Days")){
          $dateFinal->modify('+'.$duracao.' day');
        }
        if(($dias == "Semanas")||($dias == "Weeks")){
          $dateFinal->modify('+'.$duracao.' week');
        }
        if(($dias == "Mêses")||($dias == "Months")){
          $dateFinal->modify('+'.$duracao.' month');
        }
        if(($dias == "Anos")||($dias == "Years")){
          $dateFinal->modify('+'.$duracao.' year'); 
        }
      }
      $pdo = getConn();
      $cont = 0;
      $horas = 24/$vezes;
      if (($horas == 24)||($horas == 12)||($horas == 8)||($horas == 6)||($horas == 4)){
        while ($datetime<$dateFinal) {
          $aux = $datetime->format($format);
          $stmt = $pdo->prepare("INSERT INTO Paciente_faz_Medicao VALUES (?, ?, ?, ?, ?, 0, NULL, ?);");
          $stmt->bindParam(1,$pac,PDO::PARAM_INT);
          $stmt->bindParam(2,$medicao,PDO::PARAM_INT);
          $stmt->bindParam(3,$obs,PDO::PARAM_STR);
          $stmt->bindParam(4,$aux,PDO::PARAM_STR);
          $stmt->bindParam(5,$aux,PDO::PARAM_STR);
          $stmt->bindParam(6,$prof,PDO::PARAM_INT);

          $data = getMsg($stmt);

          $datetime->modify("+$horas hour");
          $cont++;
        }
      }else{
        $new = $resp->withJson(
          array("status" => "false","msg" => "Houve um problema, tente novamente mais tarde!","erro" => "Informe um valor entre 1,2,3,4 ou 6 para o campo Vezes"));
          return $new;
      }
    }else{
      $data = array("status" => "false","msg" => "Houve um problema, tente novamente mais tarde!","erro" => "Data informada ja passou!");
    }
    $new = $resp->withJson($data);
    return $new;
});
$app->put('/medicoes/{id}[/]', function (Request $req, Response $resp, array $args) {
    $obj = $req->getParsedBody();
    $pdo = getConn();
    if($obj){
      $stmt = $pdo->prepare("UPDATE Paciente_faz_Medicao SET resultado = ?, horario_realiz = ?, realizado = ? WHERE ((Medicoes_idMedicoes = ?)&&(horario = ?)&&(Paciente_idPac = ?));");
      $stmt->bindParam(1,$obj["res"],PDO::PARAM_STR);
      $stmt->bindParam(2,$obj["hora_real"],PDO::PARAM_STR);
      $stmt->bindParam(3,$obj["realizado"],PDO::PARAM_INT);
      $stmt->bindParam(4,$obj["medicao"],PDO::PARAM_INT);
      $stmt->bindParam(5,$obj["hora"],PDO::PARAM_STR);
      $stmt->bindParam(6,$args['id'],PDO::PARAM_INT);
      $data = getMsg($stmt);
    }
    $new = $resp->withJson($data);
    return $new;
});
########################################################################################################
########################################################################################################
##################################      SINTOMAS      ##################################################
########################################################################################################
########################################################################################################
$app->get('/sintomas/{id}[/]', function (Request $req, Response $resp, array $args){
    $id = $args['id'];
    $stmt = getConn()->query("SELECT s.descSintoma as 'desc', s.idSintomas as 'id_sint', s.nivelDor as 'n_dor', s.nivelHumor as 'n_humor', s.temperatura as 'temperatura', s.horario as 'horario', p.idPac as 'id_pac', CONCAT(p.nome,' ',p.sobrenome) as 'paciente' FROM RegistroSintomas as s,Paciente as p WHERE ((p.idPac = $id)&&(s.Paciente_id = $id)) ORDER BY s.horario LIMIT 0,100;");
    $sintomas = $stmt->fetchAll(PDO::FETCH_OBJ);
    $new = $resp->withJson($sintomas);
    return $new;
});
$app->post('/sintomas[/]', function (Request $req, Response $resp, array $args) {
    $obj = $req->getParsedBody();
    $pdo = getConn();
    if($obj){
      $stmt = $pdo->prepare("INSERT INTO RegistroSintomas VALUES (NULL, ?, ?, ?, ?, ?, ?);");
      $stmt->bindParam(1,$obj["pac"],PDO::PARAM_STR);
      $stmt->bindParam(2,$obj["sintoma"],PDO::PARAM_STR);
      $stmt->bindParam(3,$obj["dor"],PDO::PARAM_STR);
      $stmt->bindParam(4,$obj["humor"],PDO::PARAM_STR);
      $stmt->bindParam(5,$obj["temp"],PDO::PARAM_STR);
      $stmt->bindParam(6,$obj["hora"],PDO::PARAM_STR);
      $data = getMsg($stmt);
    }
    $new = $resp->withJson($data);
    return $new;
});
########################################################################################################
########################################################################################################
#################################     PROCEDIMENTOS     ################################################
########################################################################################################
########################################################################################################
$app->post('/procedimentos[/]', function (Request $req, Response $resp, array $args) {
    $obj = $req->getParsedBody();
    $pac = $obj["pac"];
    $desc = $obj["procedimento"];
    $obs = $obj["obs"];
    $hora = $obj["hora"];
    $date = $obj["data"];
    $vezes = $obj["vezes"];
    $tratContinuo = $obj["tratContinuo"];
    $duracao = $obj["duracao"];
    $dias = $obj["dias"];
    $prof = $obj["idProf"];
    $date = explode("/", $date);
    $hora = explode(":", $hora);
    $format = 'Y-m-d H:i';
    $datetime = new DateTime();
    $dateNow = new DateTime();
    $dateFinal = new DateTime();
    $datetime->setTimezone(new DateTimeZone('America/Sao_paulo'));
    $dateNow->setTimezone(new DateTimeZone('America/Sao_paulo'));
    $dateFinal->setTimezone(new DateTimeZone('America/Sao_paulo'));
    $datetime->SetDate($date[2],$date[1],$date[0]);
    $datetime->SetTime(23,59,59);
    $dateFinal->SetDate($date[2],$date[1],$date[0]);
    $dateFinal->SetTime($hora[0],$hora[1],0);
    //echo $datetime->format('Y-m-d H:i');
    //echo $dateNow->format('Y-m-d H:i');
    if ($datetime >= $dateNow){
      $datetime->SetTime($hora[0],$hora[1],0);
      if ($tratContinuo == "1") {
        $dateFinal->setDate(2020,12,31);
        $dateFinal->SetTime(0,0,0);
      }else{
        if(($dias == "Dias")||($dias == "Days")){
          $dateFinal->modify('+'.$duracao.' day');
        }
        if(($dias == "Semanas")||($dias == "Weeks")){
          $dateFinal->modify('+'.$duracao.' week');
        }
        if(($dias == "Mêses")||($dias == "Months")){
          $dateFinal->modify('+'.$duracao.' month');
        }
        if(($dias == "Anos")||($dias == "Years")){
          $dateFinal->modify('+'.$duracao.' year'); 
        }
      }
      $pdo = getConn();
      $cont = 0;
      $horas = 24/$vezes;
      if (($horas == 24)||($horas == 12)||($horas == 8)||($horas == 6)||($horas == 4)){
        while ($datetime<$dateFinal) {
          $aux = $datetime->format($format);
          $stmt = $pdo->prepare("INSERT INTO RegistroProcedimentos VALUES (NULL, ?, ?, ?, ?, ?, 0);");
          $stmt->bindParam(1,$pac,PDO::PARAM_STR);
          $stmt->bindParam(2,$desc,PDO::PARAM_STR);
          $stmt->bindParam(3,$obs,PDO::PARAM_STR);
          $stmt->bindParam(4,$aux,PDO::PARAM_STR);
          $stmt->bindParam(5,$prof,PDO::PARAM_STR);

          $data = getMsg($stmt);

          $datetime->modify("+$horas hour");
          $cont++;
        }
      }else{
        $new = $resp->withJson(
          array("status" => "false","msg" => "Houve um problema, tente novamente mais tarde!","erro" => "Informe um valor entre 1,2,3,4 ou 6 para o campo Vezes"));
          return $new;
      }
    }else{
      $data = array("status" => "false","msg" => "Houve um problema, tente novamente mais tarde!","erro" => "Data informada ja passou!");
    }
    $new = $resp->withJson($data);
    return $new;
});
########################################################################################################
########################################################################################################
##################################      CONSULTAS      #################################################
########################################################################################################
########################################################################################################
$app->get('/consultas/{id}[/]', function (Request $req, Response $resp, array $args){
    $id = $args['id'];
    $stmt = getConn()->query("SELECT Concat(p.nome,' ',p.sobrenome) as paciente, c.data_consulta as consulta FROM Paciente as p, Profissional_atende_Paciente as c WHERE ((p.idPac = c.Paciente_idPac)&&(c.Profissional_idProf = $id));");
    $consultas = $stmt->fetchAll(PDO::FETCH_OBJ);
    $new = $resp->withJson($consultas);
    return $new;
});
########################################################################################################
########################################################################################################
################################      USO PRÓPRIO      #################################################
########################################################################################################
########################################################################################################
// Eabling CORS
$app->options('/send-email/for-me[/]', function ($request, $response, $args) {
  return $response->withHeader('Access-Control-Allow-Origin', '*')
    ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});
$app->post('/send-email/for-me[/]', function (Request $req, Response $resp, array $args){
  $obj = $req->getParsedBody();
  $number = $obj["phone"];
  $number = preg_replace('/\D/', '', $number);
  $number = '55' . $number;

  $mj = new \Mailjet\Client('****', '****',
                true,['version' => 'v3.1']);
  $body = [
      'Messages' => [
          [
              'From' => [
                  'Email' => "gabriel@s-trat.tk",
                  'Name' => $obj["name"]
              ],
              'To' => [
                  [
                      'Email' => 'gabriel.zanatto2@gmail.com',
                      'Name' => 'Gabriel Zanatto Salami'
                  ]
              ],
              'Subject' => $obj["subject"],
              'HTMLPart' => "<h3>" . $obj["email"] . "</h3><br /><a href='http://wa.me/" . $number . "'>chamar no whats!</a><p>" . $obj["message"] . "</p>"
          ]
      ]
  ];
  $response = $mj->post(Resources::$Email, ['body' => $body]);
  $response->success();
  $aux = $response->getData();

  $new = $resp->withJson($aux["Messages"][0]);

  return $new->withHeader('Access-Control-Allow-Origin', '*')
    ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

########################################################################################################
########################################################################################################
##################################      FUNÇOES       ##################################################
########################################################################################################
########################################################################################################
$app->run();
function getConn(){
    return new PDO('****',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}
function getMsg($stmt){
    $result = $stmt->execute();
    if(!$result){
      $data = array("status" => "false","msg" => "Houve um problema, tente novamente mais tarde!","erro" => $stmt->errorInfo()[2] );
    } else if ($stmt->rowCount()) {
      $data = array("status" => "true","msg" => "Procedimento realizado com sucesso!");
    } else {
      $data = array("status" => "false","msg" => "Dados Incorretos!");
    }
    return $data;
}
function encrypt($mail){
  return '****' . $mail . '/' . md5('****');
}
function email($mail, $name){
  $link = encrypt($mail);
  $mj = new \Mailjet\Client('****', '****',
                true,['version' => 'v3.1']);
  $body = [
      'Messages' => [
          [
              'From' => [
                  'Email' => "gabriel@s-trat.tk",
                  'Name' => "S-trat"
              ],
              'To' => [
                  [
                      'Email' => $mail,
                      'Name' => $name
                  ]
              ],
              'Subject' => "Ativação de conta S-trat",
              'HTMLPart' => "<h3>Olá, bem vind@ ao S-trat! Para ativar sua conta, siga o link abaixo:</h3><br /><a href='" . $link . "'>Ativar!</a>"
          ]
      ]
  ];
  $response = $mj->post(Resources::$Email, ['body' => $body]);
  $response->success();
  return $response->getData();
  }
?>
