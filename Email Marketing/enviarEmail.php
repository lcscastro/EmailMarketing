<html>
<head>
    <meta charset="UTF-8">

<h1>
    Teste de Email Marketing
</h1>

  
  <form id="form1" name="form1" action="enviarEmail.php" method="post">
    <!-- seus campos e o botão submit aqui 

    UTILIZAR DEPOIS

    -->
    <!-- <div>
        <label for="name">Nome:</label>
        <input type="text" id="name" />
    </div>
    
    <div>
        <label for="mail">E-mail:</label>
        <input type="email" id="mail" />
    </div> -->
    
    <div> 

        <label for="msg">Mensagem:</label>
        <textarea id="msg"></textarea>

    </div>
    <div class="button">
        <button type="submit">Enviar sua mensagem</button>
    </div>


</form>

</head>
<body>

</body>
</html>


<?php

ini_set('max_execution_time', '-1');
require 'PHPMailerAutoload.php';
require 'class.phpmailer.php';
require_once "SimpleXLSX.class.php";


class ImportaPlanilha
{

    // Atributo recebe uma instância da classe SimpleXLSX
    private $planilha = null;

    // Atributo recebe a quantidade de linhas da planilha
    private $linhas = null;

    // Atributo recebe a quantidade de colunas da planilha
    private $colunas = null;

    /*
     * Método Construtor da classe
     * @param $path - Caminho e nome da planilha do Excel xlsx
     */
    public function __construct($path = null)
    {

        if (!empty($path) && file_exists($path)):
            $this->planilha = new SimpleXLSX($path);
            list($this->colunas, $this->linhas) = $this->planilha->dimension();
        else:
            echo 'Arquivo não encontrado!';
            exit();
        endif;

    }

    /*
     * Método que retorna o valor do atributo $linhas
     * @return Valor inteiro contendo a quantidade de linhas na planilha
     */
    public function getQtdeLinhas()
    {
        return $this->linhas;
    }

    /*
     * Método que retorna o valor do atributo $colunas
     * @return Valor inteiro contendo a quantidade de colunas na planilha
     */
    public function getQtdeColunas()
    {
        return $this->colunas;
    }


    /*
     * Método para ler os dados da planilha e inserir no banco de dados
     * @return Valor Inteiro contendo a quantidade de linhas importadas
     */
    public function listaEmail()
    {

        try {

            $email = array();
            $i = 0;
            foreach ($this->planilha->rows() as $chave => $valor):

                $email[$i++] = trim($valor[0]);


            endforeach;

            return $email;


        } catch (Exception $erro) {
            echo 'Erro: ' . $erro->getMessage();
        }

    }


}

function configurarEmail($mailer)
{
    $mailer->isSMTP();                                      // funcao mailer para usar SMTP

    $mailer->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    $mailer->Host = 'pleskw0012.hospedagemdesites.ws';


    $mailer->SMTPAuth = true;                                   // Habilita a autenticação do form
    $mailer->IsSMTP();
    $mailer->isHTML(true);                                      // Formato de email HTML
    $mailer->Port = 587;                                        // Porta de conexão

    $mailer->Username = 'suporte@comti.com.br';                  // Conta de e-mail que realizará o envio
    $mailer->Password = 'Com@ti0118';                                   // Senha da conta de e-mail
}

function enviarEmail($mailer, $email)
{

    //$corpoMSG = "Email de marketing teste";


    $corpoMSG = file_get_contents ("arq1.htm"); // anexar arquivo HTM

    //$corpoMSG= "<iframe src='http://comti.com.br/' width='600' height='600'></iframe>";
    $mailer->AddAddress($email, "destinatario");        // email do destinatario

    $mailer->From = 'suporte@comti.com.br';             //Obrigatório ser a mesma caixa postal indicada em "username"
    $mailer->FromName = "EmailMarketing";          // seu nome
    $mailer->Subject = "Teste de Email Marketing Versão 1.0 ";             // assunto da mensagem
    $mailer->MsgHTML(utf8_decode($corpoMSG));
          // get arquivo   -   "caso não queira essa opção basta comentar"

    if (!$mailer->Send())
        echo "<BR><BR>Erro no email $email: " . $mailer->ErrorInfo . "<BR><BR>";
    else
        echo "$email : Mensagem enviada com sucesso! <Br>";


}

$planilha = new ImportaPlanilha($_FILES['arq']['tmp_name']);

$listaEmail = $planilha->listaEmail();

foreach ($listaEmail as $email):

    $mailer = new PHPMailer();
    configurarEmail($mailer);
    enviarEmail($mailer, $email);

endforeach;
