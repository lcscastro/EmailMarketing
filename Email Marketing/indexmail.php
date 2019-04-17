

<?php
require 'PHPMailerAutoload.php';
require 'class.phpmailer.php';

$mailer = new PHPMailer;

//$mailer->SMTPDebug = 2;                               

$mailer->isSMTP();                                      // funcao mailer para usar SMTP

$mailer->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);


//if($_GET['acao'] == 'enviar'){
$construtora = $_POST['construtora'];
$valor = $_POST['valor'];
$nome = $_POST['nome'];
$nome2 = $_POST['nome2'];
$cpf = $_POST['cpf'];
$cpf2 = $_POST['cpf2'];
$celular = $_POST['celular'];
$celular2 = $_POST['celular2'];
$email = $_POST['email'];

$comprovante   = $_FILES["comprovante"];
$comprovanteRenda   = $_FILES["comprovanteRenda"];
$carteira = (isset($_FILES["carteira"])) ? $_FILES["carteira"] : false;
$imposto = (isset($_FILES["imposto"])) ? $_FILES["imposto"] : false;
$outros = (isset($_FILES["outros"])) ? $_FILES["outros"] : false;

//$mailer->Host = 'localhost';
$mailer->Host = 'pleskw0012.hospedagemdesites.ws'; // Servidor smtp
//Para cPanel: 'mail.dominio.com.br' ou 'localhost';
//Para Plesk 7 / 8 : 'smtp.dominio.com.br';
//Para Plesk 11 / 12.5: 'smtp.dominio.com.br' ou host do servidor exemplo : 'pleskXXXX.hospedagemdesites.ws';

$mailer->SMTPAuth = true;                                   // Habilita a autenticação do form
$mailer->IsSMTP();
$mailer->isHTML(true);                                      // Formato de email HTML
$mailer->Port = 587;									    // Porta de conexão

$mailer->Username = 'suporte@comti.com.br';                  // Conta de e-mail que realizará o envio
$mailer->Password = 'Com@ti0118';                                   // Senha da conta de e-mail
// email do destinatario
$address = "suporte@comti.com.br";
//$address = "suporte@comti.com.br";
//

//$mailer->SMTPDebug = 1;
$corpoMSG = "Contrutora: $construtora <br>Valor: $valor <br>Nome 1° proponente: $nome <br>Nome 2° proponente: $nome2 <br>Cpf 1° proponente: $cpf <br>Cpf 2° proponente $cpf2 <br>Celular: $celular <br>2° Celular: $celular2 <br>Email: $email";

$mailer->AddAddress($address, "destinatario");        // email do destinatario
$mailer->From = 'suporte@comti.com.br';             //Obrigatório ser a mesma caixa postal indicada em "username"
$mailer->Sender = 'suporte@comti.com.br';
$mailer->FromName = "Teste";          // seu nome
$mailer->Subject = "Teste";             // assunto da mensagem
$mailer->MsgHTML(utf8_decode($corpoMSG));             // corpo da mensagem
$mailer->AddAttachment($comprovante['tmp_name'], $comprovante['name']  );      // anexar arquivo   -   "caso não queira essa opção basta comentar"
$mailer->AddAttachment($comprovanteRenda['tmp_name'], $comprovanteRenda['name']  );

if ($carteira!=false) $mailer->AddAttachment($carteira['tmp_name'], $carteira['name']  );
if ($imposto!=false) $mailer->AddAttachment($imposto['tmp_name'], $imposto['name']  );
if ($outros!=false) $mailer->AddAttachment($outros['tmp_name'], $outros['name']  );

if(!$mailer->Send()) {
   echo "Erro: " . $mailer->ErrorInfo; 
  } else {
   echo "Mensagem enviada com sucesso!";
   //header("Location: index.html");
  }
//}


?>

