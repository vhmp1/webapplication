<?php
require_once("../bd/Database.php");
require_once("../util/Response.php");

class SessaoDAO{

    public function __construct(){}

    static public function efetuarLogin($login, $senha) {
        $senha = md5($senha);

        $query = <<<SQL
                SELECT *
                FROM User
                WHERE username = :username AND
                password = :password AND
                confirm = 1
SQL;

        $database = new Database();
        $database = $database->getConn();
        $statement = $database->prepare($query);
        $statement->bindValue(':username', $login, PDO::PARAM_INT);
        $statement->bindValue(':password', $senha, PDO::PARAM_STR);
        $statement->execute();
        $database = null;

        return ($statement->rowCount() > 0);
    }

     static public function efetuarCadastro($name, $login, $pass, $email) {
        $pass = md5($pass);

        $query = <<<SQL
                INSERT INTO User (name, username, password, email)
                VALUES (:name, :username, :password, :email)
SQL;

        $database = new Database();
        $database = $database->getConn();
        $statement = $database->prepare($query);
        $statement->bindValue(':username', $login, PDO::PARAM_STR);
        $statement->bindValue(':password', $pass, PDO::PARAM_STR);
        $statement->bindValue(':name', $name, PDO::PARAM_STR);
        $statement->bindValue(':email', $email, PDO::PARAM_STR);
        $statement->execute();
        $database = null;

        if($statement->rowCount() == 0)
            return false;

        $key = md5(date('Y-m-d H:i'));
        $link = "localhost/webapplication/index.html?chave=" . $key;

        $corpo = "  <html lang=pt-br>
                        <head>
                            <meta charset=\"utf-8\">
                            <link rel=\"stylesheet\" type=\"text/css\" href=\"//fonts.googleapis.com/css?family=Comfortaa\" />
                            <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\" integrity=\"sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u\" crossorigin=\"anonymous\">
                            <!-- Optional theme -->
                            <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css\" integrity=\"  sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp\" crossorigin=\"anonymous\">
                    
                            <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
                        </head>
                        <body>
                            <div align=\"center\">
                                <img src=cid:logo_flisol>
                                <p style=\"font-family: Comfortaa;\">$name,\n</p>
                            </div>
                            <br/>
                            <div align=\"center\">
                                <p style=\"font-family: Comfortaa;\">Obrigado por se inscrever na XIV FLISoL!</p>
                                <p style=\"font-family: Comfortaa;\">Ficaremos felizes por te receber em <b>28 de abril</b> no <i>campus</i> da Universidade Federal de Viçosa em Florestal!</p>
                            </div>
                            <div align=\"center\">
                                <p style=\"font-family: Comfortaa;\">Para confirmar sua inscrição clique no link destacado abaixo.</p>
                            </div>
                            <br />
                            <div align=\"center\">
                                <p style=\"font-family: Comfortaa;\">Clique <a href=$link>aqui</a> para confirmar sua inscrição e aproveite para conferir nossas atividades e salvá-las em sua agenda!</p>
                            </div>
                            <br />
                            <div align=\"center\">
                                <p style=\"font-family: Comfortaa;\">Se você não é $name, por favor desconsidere este e-mail.</p>
                            </div>
                        </body>
                    </html>" ;

        require "../util/PHPMailer/src/PHPMailer.php";
       
        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->SMTPDebug = 1;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->Username = 'noreply.beer@gmail.com';
        $mail->Password = 'socialbeer';
        $mail->SetFrom('noreply.beer@gmail.com', 'Equipe Beer!', 0);
        $mail->Priority = 1;
        $mail->IsHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Cadastro Beer!';
        $mail->Body = $corpo;
        $mail->AddAddress($email);
        $mail->AddEmbeddedImage('../_image/logo_flisol.png', 'logo_flisol');
   
        if(!$mail->Send()){
            echo 'Mail error: '.$mail->ErrorInfo;
            return false;
        } else{
            return true;
        }

    }

}