<?php

ini_set('max_execution_time', '-1');
require 'PHPMailerAutoload.php';
require 'class.phpmailer.php';
require_once "SimpleXLSX.class.php";




//if($_GET['acao'] == 'enviar'){
$EmailMk   = $_FILES["mailMK"];
$planilha   = $_FILES["excel"];






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


class EmailMk
{

    private $emailMk = null;

    /*
     * Método Construtor da classe
     * @param $path - Caminho e nome da planilha do Excel xlsx
     */
    public function __construct($path = null)
    {

        if (!empty($path) && file_exists($path)):
            echo ' OK - Arquivo '
            
        else:
            echo 'Arquivo não encontrado!';
            exit();
        endif;

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


   

    //$corpoMSG= "<iframe src='http://comti.com.br/' width='600' height='600'></iframe>";
    $mailer->AddAddress($email, "destinatario");        // email do destinatario

    $mailer->From = 'suporte@comti.com.br';             //Obrigatório ser a mesma caixa postal indicada em "username"
    $mailer->FromName = "EmailMarketing";          // seu nome
    $mailer->Subject = "Teste de Email Marketing Versão 1.0 ";             // assunto da mensagem


    $mailer->AddAttachment($EmailMk['tmp_name'], $EmailMk['name']  );      // anexar arquivo   -   "caso não queira essa opção basta comentar"
    $mailer->AddAttachment($Planilha['tmp_name'], $Planilha['name']  );


    $corpoMSG = file_get_contents ($EmailMK); // anexar arquivo HTM
    $mailer->MsgHTML(utf8_decode($corpoMSG));
    

          

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


$emailMk = new ImportaEmailMk($_FILES['mailMK']['tmp_name']);

$listaAnexo = $EmailMk->listaAnexo();
foreach ($listaAnexo as $EmailMk):

    $mailer = new PHPMailer();
    configurarEmail($mailer);
    enviarEmail($mailer, $email);

endforeach;


?>