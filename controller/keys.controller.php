<?php
/**
* Controlador de funciones para tabla validation_keys
*
* Manejo de acciones sobre la tabla validation_keys (El manejo sobre de esta tabla no necesitará de token en ninguno de los casos)
* Operaciones a utilizar y descripción a utilizar:

* Solicitar un código para un nuevo registro de usuario-> url: .../api/v1-2/keys/create, metodo: POST, datos-solicitados: {email: string, phone: string, method: string}

* Solicitud de validar un código ingresado-> url: .../api/v1-2/keys/validate/:email/:code, metodo: POST, datos-solicitados. {}

* Solicitar un código para recuperación de contraseña-> url: .../api/v1-2/keys/recover, metodo: POST, datos-solicitados. {email: string, method: string}
*
* @author Yael Alejandro Santana Michel
* @author ya_el1995@hotmail.com
*
* @package ari-mobile-api
*/


/**
 * @var int $email Email al que serán creados y validados lo códigos generados
 */
$email = '';
/**
 * @var int $phone Número de contacto
 */
$phone = '';
/**
 * @var string $code Código para las operaciones pertinentes
 */
$code = '';

/**
 * Función para creación de códigos
 * 
 * Esta función se encarga de crear códigos de 6 digitos
 * que sirven para hacer validaciones de correo
 * @return string Código de validación generado
 */
function create_code(){
    $STR = 'QWERTYUIOPASDFGHJKLZXCVBNM0123456789';
        $code = '';

    for ($i=0; $i < 6; $i++) {
        $code .= substr($STR, rand(0,35),1);
    }

    return $code;
}

/**
 * Función para eliminar códigos ya utilizados y evitar duplicidad
 * @param string $email Email al cual se le va a remover el código
 */
function eraseCode(string $email){
    $query = "DELETE FROM validation_keys WHERE ValidationEmail = :email";
    DBManager::query($query, array(':email' => $email));
}

/** 
 * Función para crear repuestas hacia el cliente
 * @param bool $status Estatus a partir del cual se creará la respuesta
 * @return array Array con la respuesta lista a ser formateada a objeto json
*/
function createAnswer(bool $status){
    $answer = array();
    ($status)? $answer['keyStatus'] = "Active": $answer['keyStatus'] = "Inactive";
    return $answer;
}

switch ($url[5]) {
    /**
     * Solicitar un código para un nuevo registro de usuario-> 
     * url: .../api/v1-2/keys/create, 
     * metodo: POST, 
     * datos-solicitados: {email: string, phone: string, method: string}
     * @return JsonString respuesta de resultado de la acción
     */
    case 'create':
        if ($method !== 'POST') {
            header('HTTP/1.1 405 Allow; POST');
            exit();
        }
        if (isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['method'])) {
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $method = $_POST['method'];

            $query = "SELECT * FROM contacts WHERE ContactEmail = :email";
            $data = DBManager::query($query, array(':email' => $email));

            if($data){
                echo json_encode(array (
                    'answer' => 'Error',
                    'status' => 'That email has already been registered'
                ));
                exit();
            }

            $date = new DateTime("now");
            $currentDate = $date->format('Y-m-d H:i:s');
            
            $code = create_code();
            
            $query = "INSERT INTO validation_keys(ValidationCode, ValidationDate, ValidationEmail) VALUES(:code, :currentDate, :email)";
            if (DBManager::query($query, array(':code' => $code, 'currentDate' => $currentDate, ':email' => $email))) {
                header(HTTP_CODE_201);
            } else {
                header(HTTP_CODE_409);
                exit();
            }

            if ($method === 'email'){
                
                //Configuring the email to be sended
                $subject = "Validation code for ARI website";
                $headers = "MIME-Version: 1.0 \r\nContent-type: text/html; charset-utf-8\r\n From: no-reply@aarrin.com";
                $message = "<!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>Document</title>
                </head>
                <body style='width:100%;font-family: open sans, helvetica neue, helvetica, arial, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:15;Margin:15;'>
                    <div>
                        <div>
                            <div class='rps_98b8'>
                                <div style='margin:0px; background-color:rgb(249,249,249)'>
                                    <div style='table-layout:fixed; text-align:center; margin-bottom:15px'>
                                        <div style='width:100%; background-color:rgb(239,239,239); padding:5px 0px; font-size:0px'>
                                            <div style='text-align:center; width:100%; max-width:324px; vertical-align:top; display:inline-block'>
                                                <p style='font:10px verdana,Helvetica,arial,sans-serif; color:rgb(0,0,0); margin:0px 0px 2px'>Este es un correo generado automáticamente, <strong style='color: red;'>no lo responda</strong></p>
                                            </div>
                                            <div style='text-align:center; width:100%; max-width:324px; vertical-align:top; display:inline-block'>
                                                <p style='font:10px verdana,Helvetica,arial,sans-serif; color:rgb(0,0,0); margin:0px'>Agrega <a href='mailto:web_app@aarrin.com' target='_blank' rel='noopener noreferrer' data-auth='NotApplicable' style='color:rgb(68,68,68)'>web_app@aarrin.com</a> a tus contactos </p>
                                            </div>
                                        </div>
                                        <div style='margin:18px auto 14px'>
                                            <a href='https://aarrin.com/home' target='_blank' rel='noopener noreferrer' data-auth='NotApplicable' style='text-decoration:none'>
                                                <img data-imagetype='External' src='https://fqehjo.stripocdn.email/content/guids/95820a7c-b5c9-40db-b28f-2db8ff838956/images/66451586029405480.png' data-connectorsauthtoken='1' data-imageproxyendpoint='/actions/ei' data-imageproxyid='' width='180' alt='Has clic para visitar aarrin.com'>
                                            </a>
                                        </div>
                                        <p style='margin:0px; padding:0px; font:14px /1.4em Helvetica,Arial,Verdana,sans-serif'>
                                            <a href='https://aarrin.com/home' target='_blank' rel='noopener noreferrer' data-auth='NotApplicable' style='color:rgb(102,102,102); text-decoration:none; border-right:1px solid rgb(153,153,153); padding-right:7px'>Home </a>
                                            <a href='https://aarrin.com/about-ari' target='_blank' rel='noopener noreferrer' data-auth='NotApplicable' style='color:rgb(102,102,102); text-decoration:none; border-right:1px solid rgb(153,153,153); padding:0px 8px 0px 10px'>About us</a>
                                            <a href='https://aarrin.com/certification-services' target='_blank' rel='noopener noreferrer' data-auth='NotApplicable' style='color:rgb(102,102,102); text-decoration:none; border-right:1px solid rgb(153,153,153); padding:0px 8px 0px 10px'>Services</a>
                                            <a href='https://aarrin.com/news' target='_blank' rel='noopener noreferrer' data-auth='NotApplicable' style='color:rgb(102,102,102); text-decoration:none; border-right:1px solid rgb(153,153,153); padding:0px 8px 0px 10px'>New</a>
                                            <a href='https://aarrin.com/contact' target='_blank' rel='noopener noreferrer' data-auth='NotApplicable' style='color:rgb(102,102,102); text-decoration:none; border-right:1px solid rgb(153,153,153); padding:0px 8px 0px 10px'>Contact us</a>
                                            <a href='https://aarrin.com/login' target='_blank' rel='noopener noreferrer' data-auth='NotApplicable' style='color:rgb(255,0,0); text-decoration:none; padding-left:10px'><strong>Login</strong> </a>
                                        </p>
                                        <hr style='background-color: #3D5E6A; padding: 10px;'>
                                    </div>
                                    <div style='table-layout:fixed; text-align:center'>
                                        <div style='table-layout:fixed; text-align:center'>
                                            <div style='width:100%; font-size:0px; margin:20px auto'>
                                                <div style='width:100%; max-width:642px; margin:40px auto; display:block'>
                                                    <h1 style='font:24px arial,helvetica,sans-serif; color:rgb(68,68,67); margin:0px; padding:1px 0px 5px'>Welcome to</h1>
                                                    <h1 style='font:bold 32px arial,helvetica,sans-serif; color: #3D5E6A; margin:0px; padding:0px'>American Registration Inc.</h1>
                                                    <h1 style='font:12px arial,helvetica,sans-serif; color:rgb(85,85,85); margin:0px; padding:5px 0px 0px'>by American Registration Institute</h1>
                                                </div>
                                            </div>
                                            <div style='margin:40px auto; width:100%; max-width:648px; font-size:0px; display:block; text-align:center'>
                                                <div style='display:inline-block; width:100%; max-width:624px; height:300px; vertical-align:top; background-color:rgb(224,228,237)'>
                                                    <table align='center' width='100%' cellspacing='0' cellpadding='0' border='0'>
                                                        <tbody>
                                                            <tr>
                                                                <td height='300' align='center' bgcolor='#e0e4ed'>
                                                                    <p style='font:bold 30px arial,sans-serif; color:rgb(76, 76, 77); margin:0px 0px 15px'>Please enter this code in the website</p>
                                                                    <p style='font:bold 19px arial,sans-serif; color:rgb(15, 36, 71); margin:10px 0px 15px'>This code is functional just for 5 minutes</p>
                                                                    <p rel='noopener noreferrer' style='background-color:rgb(255, 255, 255); color:rgb(46, 46, 46); text-transform:uppercase; font:bold 19px arial,sans-serif; padding:10px 35px; text-decoration:none; display:inline-block'>$code</p>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div style='table-layout:fixed; text-align:center; margin-top:60px'>
                                        <div style='width:100%; max-width:648px; margin:0px auto; font-size:0px'>
                                            <div style='display:block; margin-bottom:15px'>
                                                <h3 style='margin:10px 0px; font:bold 16px /1em Arial,Helvetica,sans-serif; color:rgb(51,51,51)'>AMERICAN REGISTRATION INC. </h3>
                                                <a href='https://aarrin.com/home' target='_blank' rel='noopener noreferrer' data-auth='NotApplicable' style='text-decoration:none'><img data-imagetype='External' src='https://fqehjo.stripocdn.email/content/guids/95820a7c-b5c9-40db-b28f-2db8ff838956/images/66451586029405480.png' data-connectorsauthtoken='1' data-imageproxyendpoint='/actions/ei' data-imageproxyid=''
                                                        width='152' alt='click para ir a aarrin.com' style='display:inline-block; vertical-align:middle'> </a>
                                            </div>
                                            <div style='font:11px /1.4em Arial,Helvetica,sans-serif; color:rgb(155,155,159); text-align:justify'>
                                                <p style='margin:20px 12px 8px; font:bold 26px /1em;'>Web_app@aarrin.com</p>
                                                <p style='margin:20px 12px 8px;'>AMERICAN REGISTRATION INC & AMERICAN REGISTRATION INSTITUTE S.C., es responsable de recabar sus datos personales, del uso que se le dé a los mismos y de su protección. Usted puede conocer nuestro Aviso de Privacidad Integral
                                                    solicitándolo a nuestro Departamento de Protección de Datos en: <a href='mailto:'>contact@aarrin.com</a> o en nuestras líneas telefónicas <a href='tel:+52 33-1524-5253'>33-1524-5253</a> , y en Sitio de Internet:
                                                    <a href='https://aarrin.com/home' target='_blank' rel='noopener noreferrer'>aarrin.com</a>
                                                </p>
                                                <p style='margin:8px 12px;'>Este mensaje electrónico, incluyendo cualquier anexo, están dirigidos exclusivamente para el uso del cliente y/o la persona física a la cual está dirigido la información. Los datos utilizados para el envío de este mensaje
                                                    proceden de nuestra base de datos. Para ejercitar sus derechos de acceso, rectificación, cancelación u oposición, usted puede acceder en los términos establecidos en nuestro <a href='https://aarrin.com/PrivacyPolicies'
                                                        target='_blank' rel='noopener noreferrer' data-auth='NotApplicable' style='color:rgb(0,86,148); font-weight:bold'>*aviso de privacidad*</a> contenido en el portal de internet antes indicado. La información que se llegara
                                                    a obtener por este medio, será tratada conforme a los principios establecidos en la Ley Federal de Protección de Datos Personales en Posesión de los Particulares. </p>
                
                                            </div>
                                        </div>
                                        <div style='width:100%; max-width:648px; margin:0px auto; font-size:0px'>
                                            <div style='font:11px /1.4em Arial,Helvetica,sans-serif; color:rgb(155,155,159); text-align:justify'>
                                                <p style='margin:20px 12px 8px;'>AMERICAN REGISTRATION INC & AMERICAN REGISTRATION INSTITUTE S.C., is responsible for collecting your personal data, the use that is given and its protection. You can find out about our Comprehensive Privacy Notice by requesting
                                                    it from our Data Protection Department at: <a href='mailto:'>contact@aarrin.com</a> or on our phone lines <a href='tel:+52 33-1524-5253'>33-1524-5253</a> , and on the Internet Site:
                                                    <a href='https://aarrin.com/home' target='_blank' rel='noopener noreferrer'>aarrin.com</a>
                                                </p>
                                                <p style='margin:8px 12px;'>This electronic message, including any annex, is intended exclusively for the use of the client and / or the natural person to whom the information is directed. The data used to send this message comes from our database.
                                                    To exercise your rights of access, rectification, cancellation or opposition, you can access the terms established in our <a href='https://aarrin.com/PrivacyPolicies' target='_blank' rel='noopener noreferrer' data-auth='NotApplicable'
                                                        style='color:rgb(0,86,148); font-weight:bold'> *privacy notice*</a> contained in the internet portal indicated above. The information obtained by this means will be treated in accordance with the principles established
                                                    in the Federal Law on Protection of Personal Data Held by Individuals.</p>
                                                <p style='margin:8px 12px;'>Av Guadalupe N 9501, El Colli, 45070 Zapopan, Jal, México</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                </body>
                </html>";
                $altbody = "Please insert this code on ARI website \n\n CODE: $code \n\n Visit https://aarrin.com";
                if(Mailer::sendMail($email, $subject, $message, $altbody)){
                    echo json_encode(array (
                        'answer' => 'OK',
                        'status' => 'The email message was sent'
                    ));
                } else {
                    header(HTTP_CODE_409);
                    echo json_encode(array (
                        'answer' => 'ERROR',
                        'status' => 'The email message wasn\'t sent'
                    ));
                }
            } else {

                include('../classes/httpPHPAltiria.php');

                $altiriaSMS = new AltiriaSMS();
                $altiriaSMS->setUrl("http://www.altiria.net/api/http");
                // domainId solo es necesario si el login no es un email
                // Linea para cuando es necesario indicar un dominio: $altiriaSMS->setDomainId('XX')
                $altiriaSMS->setLogin('asm_1995@outlook.com');
                $altiriaSMS->setPassword('tyu4u52f');
                // $altiriaSMS->setDomainId('test')

                $altiriaSMS->setDebug(true);

                $message = "Verification code for ARI (American Registration Institute) website: $code \n\n Please enter this code on the website\n More info on https://aarrin.com";

                //No es posible utilizar el remitente en Am�rica pero s� en Espa�a y Europa
                $response = $altiriaSMS->sendSMS('52'. $phone, $message);
                //Utilizar esta llamada solo si se cuenta con un remitente autorizado por Altiria
                //$response = $altiriaSMS->sendSMS($sDestination, "Mensaje de prueba", "remitente")

                if (!$response){
                    echo json_encode(array (
                        'answer' => 'Error',
                        'status' => 'The sms message wasn\'t sent'
                    ));
                } else {
                    echo json_encode(array (
                        'answer' => 'OK',
                        'status' => 'The sms message was sent'
                    ));
                }
                
            }
        }
        else{
            header(HTTP_CODE_412);
            exit();
        }
        break;


    /**
     * Solicitud de validar un código ingresado-> 
     * url: .../api/v1-2/keys/validate/:email/:code, 
     * metodo: POST, 
     * datos-solicitados. {}
     * @param string email El email al cual se le adjudica el código
     * @param string code El código de 6 digitos que se validará
     * @return JsonString respuesta de resultado de la acción
     */
    case 'validate':
        if ($method !== 'POST') {
            header('HTTP/1.1 405 Allow; POST');
            exit();
        }
        

        if (!isset($url[6])) {
            header(HTTP_CODE_412);
            exit();
        }
        $email = (string) $url[6];

        if (!isset($url[7])) {
            header(HTTP_CODE_412);
            exit();
        }
        $code = (string) $url[7];

        $query = "SELECT * FROM validation_keys WHERE ValidationCode = '$code' AND ValidationEmail = '$email'";
        $data = DBManager::query($query);
        
        if ($data) {
            $validationKey = $data[0];
            $dateKey = new DateTime($validationKey['ValidationDate']);
            $today = new DateTime("now");
            $dif = $today->diff($dateKey);
            if ($dif->days || $dif->h || $dif->i > 10){
                eraseCode($email);
                echo json_encode(createAnswer(false));
            }else {
                eraseCode($email);
                echo json_encode(createAnswer(true));
            }
        }
        else {
            header(HTTP_CODE_404);
            exit();
        }
        break;


    /**
     * Solicitar un código para recuperación de contraseña-> 
     * url: .../api/v1-2/keys/recover, 
     * metodo: POST, 
     * datos-solicitados. {email: string, method: string}
     * @return JsonString respuesta de resultado de la acción que incluye los datos del usuario y un token válido
     */
    case 'recover':
        if ($method !== 'POST') {
            header('HTTP/1.1 405 Allow: POST');
            exit();
        }
        if (isset($_POST['email']) && isset($_POST['method'])) {
            $email = $_POST['email'];
            $method = $_POST['method'];

            $query = "SELECT * FROM contacts WHERE ContactEmail = :email";
            $contactSearch = DBManager::query($query, array(':email' => $email));

            $query = "SELECT * FROM personal WHERE EmployeeEmail = :email";
            $personalSearch = DBManager::query($query, array(':email' => $email));
            $data = array('Hola' => 'Cómo estás?');
            if($contactSearch){
                $data = $contactSearch[0];
                $data['ContactPassword'] = '';
            }elseif($personalSearch){
                $data = $personalSearch[0];
                $data['EmployeePassword'] = '';
            }else{
                echo json_encode(array (
                    'answer' => 'Error',
                    'message' => 'That email has NOT been registered'
                ));
                exit();
            }

            $date = new DateTime("now");
            $currentDate = $date->format('Y-m-d H:i:s');
            
            $code = create_code();
            
            $query = "INSERT INTO validation_keys(ValidationCode, ValidationDate, ValidationEmail) VALUES(:code, :currentDate, :email)";
            if (!DBManager::query($query, array(':code' => $code, 'currentDate' => $currentDate, ':email' => $email))) {
                header(HTTP_CODE_409);
                exit();
            }

            if ($method === 'email'){
                
                //Configuring the email to be sended
                $subject = "Validation code for ARI website";
                $headers = "MIME-Version: 1.0 \r\nContent-type: text/html; charset-utf-8\r\n From: no-reply@aarrin.com";
                $message = "<!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>Document</title>
                </head>
                <body style='width:100%;font-family: open sans, helvetica neue, helvetica, arial, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:15;Margin:15;'>
                    <div>
                        <div>
                            <div class='rps_98b8'>
                                <div style='margin:0px; background-color:rgb(249,249,249)'>
                                    <div style='table-layout:fixed; text-align:center; margin-bottom:15px'>
                                        <div style='width:100%; background-color:rgb(239,239,239); padding:5px 0px; font-size:0px'>
                                            <div style='text-align:center; width:100%; max-width:324px; vertical-align:top; display:inline-block'>
                                                <p style='font:10px verdana,Helvetica,arial,sans-serif; color:rgb(0,0,0); margin:0px 0px 2px'>Este es un correo generado automáticamente, <strong style='color: red;'>no lo responda</strong></p>
                                            </div>
                                            <div style='text-align:center; width:100%; max-width:324px; vertical-align:top; display:inline-block'>
                                                <p style='font:10px verdana,Helvetica,arial,sans-serif; color:rgb(0,0,0); margin:0px'>Agrega <a href='mailto:web_app@aarrin.com' target='_blank' rel='noopener noreferrer' data-auth='NotApplicable' style='color:rgb(68,68,68)'>web_app@aarrin.com</a> a tus contactos </p>
                                            </div>
                                        </div>
                                        <div style='margin:18px auto 14px'>
                                            <a href='https://aarrin.com/home' target='_blank' rel='noopener noreferrer' data-auth='NotApplicable' style='text-decoration:none'>
                                                <img data-imagetype='External' src='https://fqehjo.stripocdn.email/content/guids/95820a7c-b5c9-40db-b28f-2db8ff838956/images/66451586029405480.png' data-connectorsauthtoken='1' data-imageproxyendpoint='/actions/ei' data-imageproxyid='' width='180' alt='Has clic para visitar aarrin.com'>
                                            </a>
                                        </div>
                                        <p style='margin:0px; padding:0px; font:14px /1.4em Helvetica,Arial,Verdana,sans-serif'>
                                            <a href='https://aarrin.com/home' target='_blank' rel='noopener noreferrer' data-auth='NotApplicable' style='color:rgb(102,102,102); text-decoration:none; border-right:1px solid rgb(153,153,153); padding-right:7px'>Home </a>
                                            <a href='https://aarrin.com/about-ari' target='_blank' rel='noopener noreferrer' data-auth='NotApplicable' style='color:rgb(102,102,102); text-decoration:none; border-right:1px solid rgb(153,153,153); padding:0px 8px 0px 10px'>About us</a>
                                            <a href='https://aarrin.com/certification-services' target='_blank' rel='noopener noreferrer' data-auth='NotApplicable' style='color:rgb(102,102,102); text-decoration:none; border-right:1px solid rgb(153,153,153); padding:0px 8px 0px 10px'>Services</a>
                                            <a href='https://aarrin.com/news' target='_blank' rel='noopener noreferrer' data-auth='NotApplicable' style='color:rgb(102,102,102); text-decoration:none; border-right:1px solid rgb(153,153,153); padding:0px 8px 0px 10px'>New</a>
                                            <a href='https://aarrin.com/contact' target='_blank' rel='noopener noreferrer' data-auth='NotApplicable' style='color:rgb(102,102,102); text-decoration:none; border-right:1px solid rgb(153,153,153); padding:0px 8px 0px 10px'>Contact us</a>
                                            <a href='https://aarrin.com/login' target='_blank' rel='noopener noreferrer' data-auth='NotApplicable' style='color:rgb(255,0,0); text-decoration:none; padding-left:10px'><strong>Login</strong> </a>
                                        </p>
                                        <hr style='background-color: #3D5E6A; padding: 10px;'>
                                    </div>
                                    <div style='table-layout:fixed; text-align:center'>
                                        <div style='table-layout:fixed; text-align:center'>
                                            <div style='width:100%; font-size:0px; margin:20px auto'>
                                                <div style='width:100%; max-width:642px; margin:40px auto; display:block'>
                                                    <h1 style='font:24px arial,helvetica,sans-serif; color:rgb(68,68,67); margin:0px; padding:1px 0px 5px'>Welcome to</h1>
                                                    <h1 style='font:bold 32px arial,helvetica,sans-serif; color: #3D5E6A; margin:0px; padding:0px'>American Registration Inc.</h1>
                                                    <h1 style='font:12px arial,helvetica,sans-serif; color:rgb(85,85,85); margin:0px; padding:5px 0px 0px'>by American Registration Institute</h1>
                                                </div>
                                            </div>
                                            <div style='margin:40px auto; width:100%; max-width:648px; font-size:0px; display:block; text-align:center'>
                                                <div style='display:inline-block; width:100%; max-width:624px; height:300px; vertical-align:top; background-color:rgb(224,228,237)'>
                                                    <table align='center' width='100%' cellspacing='0' cellpadding='0' border='0'>
                                                        <tbody>
                                                            <tr>
                                                                <td height='300' align='center' bgcolor='#e0e4ed'>
                                                                    <p style='font:bold 30px arial,sans-serif; color:rgb(76, 76, 77); margin:0px 0px 15px'>Please enter this code in the website</p>
                                                                    <p style='font:bold 19px arial,sans-serif; color:rgb(15, 36, 71); margin:10px 0px 15px'>This code is functional just for 5 minutes</p>
                                                                    <p rel='noopener noreferrer' style='background-color:rgb(255, 255, 255); color:rgb(46, 46, 46); text-transform:uppercase; font:bold 19px arial,sans-serif; padding:10px 35px; text-decoration:none; display:inline-block'>$code</p>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div style='table-layout:fixed; text-align:center; margin-top:60px'>
                                        <div style='width:100%; max-width:648px; margin:0px auto; font-size:0px'>
                                            <div style='display:block; margin-bottom:15px'>
                                                <h3 style='margin:10px 0px; font:bold 16px /1em Arial,Helvetica,sans-serif; color:rgb(51,51,51)'>AMERICAN REGISTRATION INC. </h3>
                                                <a href='https://aarrin.com/home' target='_blank' rel='noopener noreferrer' data-auth='NotApplicable' style='text-decoration:none'><img data-imagetype='External' src='https://fqehjo.stripocdn.email/content/guids/95820a7c-b5c9-40db-b28f-2db8ff838956/images/66451586029405480.png' data-connectorsauthtoken='1' data-imageproxyendpoint='/actions/ei' data-imageproxyid=''
                                                        width='152' alt='click para ir a aarrin.com' style='display:inline-block; vertical-align:middle'> </a>
                                            </div>
                                            <div style='font:11px /1.4em Arial,Helvetica,sans-serif; color:rgb(155,155,159); text-align:justify'>
                                                <p style='margin:20px 12px 8px; font:bold 26px /1em;'>Web_app@aarrin.com</p>
                                                <p style='margin:20px 12px 8px;'>AMERICAN REGISTRATION INC & AMERICAN REGISTRATION INSTITUTE S.C., es responsable de recabar sus datos personales, del uso que se le dé a los mismos y de su protección. Usted puede conocer nuestro Aviso de Privacidad Integral
                                                    solicitándolo a nuestro Departamento de Protección de Datos en: <a href='mailto:'>contact@aarrin.com</a> o en nuestras líneas telefónicas <a href='tel:+52 33-1524-5253'>33-1524-5253</a> , y en Sitio de Internet:
                                                    <a href='https://aarrin.com/home' target='_blank' rel='noopener noreferrer'>aarrin.com</a>
                                                </p>
                                                <p style='margin:8px 12px;'>Este mensaje electrónico, incluyendo cualquier anexo, están dirigidos exclusivamente para el uso del cliente y/o la persona física a la cual está dirigido la información. Los datos utilizados para el envío de este mensaje
                                                    proceden de nuestra base de datos. Para ejercitar sus derechos de acceso, rectificación, cancelación u oposición, usted puede acceder en los términos establecidos en nuestro <a href='https://aarrin.com/PrivacyPolicies'
                                                        target='_blank' rel='noopener noreferrer' data-auth='NotApplicable' style='color:rgb(0,86,148); font-weight:bold'>*aviso de privacidad*</a> contenido en el portal de internet antes indicado. La información que se llegara
                                                    a obtener por este medio, será tratada conforme a los principios establecidos en la Ley Federal de Protección de Datos Personales en Posesión de los Particulares. </p>
                                            </div>
                                        </div>
                                        <div style='width:100%; max-width:648px; margin:0px auto; font-size:0px'>
                                            <div style='font:11px /1.4em Arial,Helvetica,sans-serif; color:rgb(155,155,159); text-align:justify'>
                                                <p style='margin:20px 12px 8px;'>AMERICAN REGISTRATION INC & AMERICAN REGISTRATION INSTITUTE S.C., is responsible for collecting your personal data, the use that is given and its protection. You can find out about our Comprehensive Privacy Notice by requesting
                                                    it from our Data Protection Department at: <a href='mailto:'>contact@aarrin.com</a> or on our phone lines <a href='tel:+52 33-1524-5253'>33-1524-5253</a> , and on the Internet Site:
                                                    <a href='https://aarrin.com/home' target='_blank' rel='noopener noreferrer'>aarrin.com</a>
                                                </p>
                                                <p style='margin:8px 12px;'>This electronic message, including any annex, is intended exclusively for the use of the client and / or the natural person to whom the information is directed. The data used to send this message comes from our database.
                                                    To exercise your rights of access, rectification, cancellation or opposition, you can access the terms established in our <a href='https://aarrin.com/PrivacyPolicies' target='_blank' rel='noopener noreferrer' data-auth='NotApplicable'
                                                        style='color:rgb(0,86,148); font-weight:bold'> *privacy notice*</a> contained in the internet portal indicated above. The information obtained by this means will be treated in accordance with the principles established
                                                    in the Federal Law on Protection of Personal Data Held by Individuals.</p>
                                                <p style='margin:8px 12px;'>Av Guadalupe N 9501, El Colli, 45070 Zapopan, Jal, México</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                </body>
                </html>";
                $altbody = "Please insert this code on ARI website \n\n CODE: $code \n\n Visit https://aarrin.com";
                
                //mail($email, $subject, $message, $headers);
                if (Mailer::sendMail($email, $subject, $message, $altbody)){
                    header(HTTP_CODE_201);
                    echo json_encode(array(
                        'data' => $data,
                        'token' => TokenTool::createToken($data)
                    ));
                } else {
                    header(HTTP_CODE_409);
                    echo json_encode(array (
                        'answer' => 'ERROR',
                        'status' => 'The email message wasn\'t sent'
                    ));
                }
            } else {

                include(__DIR__.'/../classes/httpPHPAltiria.php');

                $altiriaSMS = new AltiriaSMS();
                $altiriaSMS->setUrl("http://www.altiria.net/api/http");
                // domainId solo es necesario si el login no es un email
                // Linea para cuando es necesario indicar un dominio: $altiriaSMS->setDomainId('XX')
                $altiriaSMS->setLogin('asm_1995@outlook.com');
                $altiriaSMS->setPassword('tyu4u52f');
                // $altiriaSMS->setDomainId('test')

                $altiriaSMS->setDebug(true);

                $message = "Verification code for ARI (American Registration Institute) website: $code \n\n Please enter this code on the website\n More info on https://aarrin.com";

                //No es posible utilizar el remitente en Am�rica pero s� en Espa�a y Europa
                $response = $altiriaSMS->sendSMS('52'. $phone, $message);
                //Utilizar esta llamada solo si se cuenta con un remitente autorizado por Altiria
                //$response = $altiriaSMS->sendSMS($sDestination, "Mensaje de prueba", "remitente")
                header(HTTP_CODE_201);
                if (!$response){
                    echo json_encode(array (
                        'answer' => 'Error',
                        'status' => 'The sms message wasn\'t sent'
                    ));
                } else {
                    echo json_encode(array(
                        'data' => json_encode($answer), 
                        'token' => TokenTool::createToken($answer)
                    ));
                }
                
            }
        }
        else{
            header(HTTP_CODE_412);
            exit();
        }
        break;

    default:
        header(HTTP_CODE_404);
        break;
}