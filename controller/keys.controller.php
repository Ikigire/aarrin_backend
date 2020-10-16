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
                $message = "<html style='width:100%;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0;'><head><meta charset='UTF-8'><meta content='width=device-width, initial-scale=1' name='viewport'><meta name='x-apple-disable-message-reformatting'><meta http-equiv='X-UA-Compatible' content='IE=edge'><meta content='telephone=no' name='format-detection'><title>Validating your contact email</title> <!--[if (mso 16)]><style type='text/css'>     a {text-decoration: none;}     </style><![endif]--> <!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]--> <!--[if !mso]><!-- --><link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i' rel='stylesheet'> <!--<![endif]-->
                            <style type='text/css'>@media only screen and (max-width:600px) {p, ul li, ol li, a { font-size:16px!important; line-height:150%!important } h1 { font-size:30px!important; text-align:center; line-height:120%!important } h2 { font-size:26px!important; text-align:center; line-height:120%!important } h3 { font-size:20px!important; text-align:center; line-height:120%!important } h1 a { font-size:30px!important } h2 a { font-size:26px!important } h3 a { font-size:20px!important } .es-menu td a { font-size:16px!important } .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a { font-size:16px!important } .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a { font-size:16px!important } .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a { font-size:12px!important } *[class='gmail-fix'] { display:none!important } .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3 { 
                            text-align:center!important } .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3 { text-align:right!important } .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3 { text-align:left!important } .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img { display:inline!important } .es-button-border { display:block!important } a.es-button { font-size:20px!important; display:block!important; border-width:15px 25px 15px 25px!important } .es-btn-fw { border-width:10px 0px!important; text-align:center!important } .es-adaptive table, .es-btn-fw, .es-btn-fw-brdr, .es-left, .es-right { width:100%!important } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%!important; max-width:600px!important } .es-adapt-td { display:block!important; width:100%!important } .adapt-img { width:100%!important; height:auto!important } .es-m-p0 { padding:0px!important } .es-m-p0r { 
                            padding-right:0px!important } .es-m-p0l { padding-left:0px!important } .es-m-p0t { padding-top:0px!important } .es-m-p0b { padding-bottom:0!important } .es-m-p20b { padding-bottom:20px!important } .es-mobile-hidden, .es-hidden { display:none!important } .es-desk-hidden { display:table-row!important; width:auto!important; overflow:visible!important; float:none!important; max-height:inherit!important; line-height:inherit!important } .es-desk-menu-hidden { display:table-cell!important } table.es-table-not-adapt, .esd-block-html table { width:auto!important } table.es-social { display:inline-block!important } table.es-social td { display:inline-block!important } }#outlook a {	padding:0;}.ExternalClass {	width:100%;}.ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div {	line-height:100%;}.es-button 
                            {	mso-style-priority:100!important;	text-decoration:none!important;}a[x-apple-data-detectors] {	color:inherit!important;	text-decoration:none!important;	font-size:inherit!important;	font-family:inherit!important;	font-weight:inherit!important;	line-height:inherit!important;}.es-desk-hidden {	display:none;	float:left;	overflow:hidden;	width:0;	max-height:0;	line-height:0;	mso-hide:all;}</style></head><body style='width:100%;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0;'><div class='es-wrapper-color' style='background-color:#F6F6F6;'> <!--[if gte mso 9]><v:background xmlns:v='urn:schemas-microsoft-com:vml' fill='t'> <v:fill type='tile' color='#f6f6f6'></v:fill> </v:background><![endif]-->
                            <table class='es-wrapper' width='100%' cellspacing='0' cellpadding='0' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top;'><tr style='border-collapse:collapse;'><td valign='top' style='padding:0;Margin:0;'><table class='es-content' cellspacing='0' cellpadding='0' align='center' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;'><tr style='border-collapse:collapse;'><td align='center' style='padding:0;Margin:0;'><table class='es-content-body' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;' width='640' cellspacing='0' cellpadding='0' align='center'><tr style='border-collapse:collapse;'>
                            <td align='left' style='Margin:0;padding-top:15px;padding-bottom:15px;padding-left:20px;padding-right:20px;'> <!--[if mso]><table width='600' cellpadding='0' cellspacing='0'><tr><td width='290' valign='top'><![endif]--><table class='es-left' cellspacing='0' cellpadding='0' align='left' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left;'><tr style='border-collapse:collapse;'><td width='290' align='left' style='padding:0;Margin:0;'><table width='100%' cellspacing='0' cellpadding='0' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td class='es-infoblock es-m-txt-c' align='left' style='padding:0;Margin:0;line-height:14px;font-size:12px;color:#CCCCCC;'>
                            <p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:12px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:14px;color:#CCCCCC;'>This is an auto-generated mail, please don't respond it<br></p></td></tr></table></td></tr></table> <!--[if mso]></td><td width='20'></td><td width='290' valign='top'><![endif]--><table class='es-right' cellspacing='0' cellpadding='0' align='right' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right;'><tr style='border-collapse:collapse;'><td width='290' align='left' style='padding:0;Margin:0;'><table width='100%' cellspacing='0' cellpadding='0' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'>
                            <td class='es-infoblock es-m-txt-c' align='right' style='padding:0;Margin:0;line-height:14px;font-size:12px;color:#CCCCCC;'><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:12px;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;line-height:14px;color:#CCCCCC;'></p></td></tr></table></td></tr></table> <!--[if mso]></td></tr></table><![endif]--></td></tr></table></td></tr></table>
                            <table class='es-header' cellspacing='0' cellpadding='0' align='center' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top;'><tr style='border-collapse:collapse;'><td style='padding:0;Margin:0;background-size:cover;background-color:#3D5E6A;' bgcolor='#3D5E6A' align='center'>
                            <table class='es-header-body' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;background-image:url(https://fqehjo.stripocdn.email/content/guids/95820a7c-b5c9-40db-b28f-2db8ff838956/images/66451586029405480.png);background-repeat:no-repeat;background-position:center top;' width='640' cellspacing='0' cellpadding='0' background='https://fqehjo.stripocdn.email/content/guids/95820a7c-b5c9-40db-b28f-2db8ff838956/images/66451586029405480.png' align='center'><tr style='border-collapse:collapse;'><td align='left' style='Margin:0;padding-top:10px;padding-left:20px;padding-right:20px;padding-bottom:25px;'><table width='100%' cellspacing='0' cellpadding='0' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td width='600' valign='top' align='center' style='padding:0;Margin:0;'>
                            <table width='100%' cellspacing='0' cellpadding='0' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td style='padding:0;Margin:0;padding-bottom:25px;padding-top:40px;font-size:0px;' align='center'><a href='https://viewstripo.email' target='_blank' style='-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;font-size:20px;text-decoration:none;color:#B7BDC9;'><img src='https://fqehjo.stripocdn.email/content/guids/95820a7c-b5c9-40db-b28f-2db8ff838956/images/66451586029405480.png' style='display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;' alt='Logo' title='Logo' width='220' height='157'></a></td></tr><tr style='border-collapse:collapse;'>
                            <td align='center' style='padding:0;Margin:0;padding-bottom:20px;padding-top:25px;'><h1 style='Margin:0;line-height:48px;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;font-size:40px;font-style:normal;font-weight:bold;color:#FFFFFF;'>Welcome to aarrin.com</h1></td></tr><tr style='border-collapse:collapse;'><td esdev-links-color='#b7bdc9' align='center' style='padding:0;Margin:0;padding-top:10px;padding-bottom:25px;'><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:20px;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;line-height:30px;color:#B7BDC9;'><br></p></td></tr></table></td></tr></table></td></tr></table></td></tr></table>
                            <table class='es-content' cellspacing='0' cellpadding='0' align='center' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;'><tr style='border-collapse:collapse;'><td align='center' style='padding:0;Margin:0;'><table class='es-content-body' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#F6F6F6;' width='640' cellspacing='0' cellpadding='0' bgcolor='#f6f6f6' align='center'><tr style='border-collapse:collapse;'><td align='left' style='padding:0;Margin:0;padding-top:10px;padding-left:20px;padding-right:20px;'><table width='100%' cellspacing='0' cellpadding='0' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td width='600' valign='top' align='center' style='padding:0;Margin:0;'>
                            <table width='100%' cellspacing='0' cellpadding='0' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td style='padding:0;Margin:0;padding-top:20px;padding-bottom:20px;font-size:0;' align='center'><table width='100%' height='100%' cellspacing='0' cellpadding='0' border='0' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td style='padding:0;Margin:0px;border-bottom:1px solid #F6F6F6;background:rgba(0, 0, 0, 0) none repeat scroll 0% 0%;height:1px;width:100%;margin:0px;'></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table>
                            <table class='es-content' cellspacing='0' cellpadding='0' align='center' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;'><tr style='border-collapse:collapse;'><td align='center' style='padding:0;Margin:0;'><table class='es-content-body' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#F6F6F6;' width='640' cellspacing='0' cellpadding='0' bgcolor='#f6f6f6' align='center'><tr style='border-collapse:collapse;'><td align='left' style='padding:0;Margin:0;padding-top:10px;padding-left:20px;padding-right:20px;'><table width='100%' cellspacing='0' cellpadding='0' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td width='600' valign='top' align='center' style='padding:0;Margin:0;'>
                            <table width='100%' cellspacing='0' cellpadding='0' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td style='padding:0;Margin:0;padding-bottom:15px;padding-top:20px;font-size:0;' align='center'><table width='100%' height='100%' cellspacing='0' cellpadding='0' border='0' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td style='padding:0;Margin:0px;border-bottom:1px solid #F6F6F6;background:rgba(0, 0, 0, 0) none repeat scroll 0% 0%;height:1px;width:100%;margin:0px;'></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table>
                            <table class='es-content' cellspacing='0' cellpadding='0' align='center' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;'><tr style='border-collapse:collapse;'><td align='center' style='padding:0;Margin:0;'><table class='es-content-body' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;' width='640' cellspacing='0' cellpadding='0' align='center'><tr style='border-collapse:collapse;'><td align='left' style='padding:0;Margin:0;padding-left:20px;padding-right:20px;'><table width='100%' cellspacing='0' cellpadding='0' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td width='600' valign='top' align='center' style='padding:0;Margin:0;'>
                            <table style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:separate;border-spacing:0px;border-radius:3px;background-color:#FFFFFF;' width='100%' cellspacing='0' cellpadding='0' bgcolor='#ffffff' role='presentation'><tr style='border-collapse:collapse;'><td align='center' style='Margin:0;padding-bottom:5px;padding-left:20px;padding-right:20px;padding-top:25px;'><h2 style='Margin:0;line-height:24px;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;font-size:20px;font-style:normal;font-weight:bold;color:#444444;'>Please enter this code in the website<br></h2></td></tr><tr style='border-collapse:collapse;'><td align='center' style='Margin:0;padding-top:10px;padding-bottom:15px;padding-left:20px;padding-right:20px;'>
                            <p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;line-height:24px;color:#999999;'><span class='product-description'>This code is functional just for 5 minutes<br></span></p></td></tr><tr style='border-collapse:collapse;'><td style='padding:0;Margin:0;'><center><h2 style='Margin:0;line-height:24px;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;font-size:20px;font-style:normal;font-weight:bold;color:#444444;'>$code</h2></center></td></tr></table></td></tr></table></td></tr></table></td></tr></table><table class='es-content' cellspacing='0' cellpadding='0' align='center' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;'>
                            <tr style='border-collapse:collapse;'><td align='center' style='padding:0;Margin:0;'><table class='es-content-body' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#F6F6F6;' width='640' cellspacing='0' cellpadding='0' bgcolor='#f6f6f6' align='center'><tr style='border-collapse:collapse;'><td align='left' style='padding:0;Margin:0;padding-top:10px;padding-left:20px;padding-right:20px;'><table width='100%' cellspacing='0' cellpadding='0' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td width='600' valign='top' align='center' style='padding:0;Margin:0;'><table width='100%' cellspacing='0' cellpadding='0' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'>
                            <td style='padding:0;Margin:0;padding-top:10px;padding-bottom:10px;font-size:0;' align='center'><table width='100%' height='100%' cellspacing='0' cellpadding='0' border='0' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td style='padding:0;Margin:0px;border-bottom:1px solid #F6F6F6;background:rgba(0, 0, 0, 0) none repeat scroll 0% 0%;height:1px;width:100%;margin:0px;'></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table><table class='es-footer' cellspacing='0' cellpadding='0' align='center' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top;'><tr style='border-collapse:collapse;'><td align='center' style='padding:0;Margin:0;'>
                            <table class='es-footer-body' width='640' cellspacing='0' cellpadding='0' align='center' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#F6F6F6;'><tr style='border-collapse:collapse;'><td align='left' style='Margin:0;padding-left:20px;padding-right:20px;padding-top:40px;padding-bottom:40px;'><table width='100%' cellspacing='0' cellpadding='0' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td width='600' valign='top' align='center' style='padding:0;Margin:0;'><table width='100%' cellspacing='0' cellpadding='0' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td style='padding:0;Margin:0;padding-bottom:5px;font-size:0;' align='center'>
                            <a target='_blank' href='https://viewstripo.email' style='-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;font-size:14px;text-decoration:none;color:#999999;'><img src='https://fqehjo.stripocdn.email/content/guids/CABINET_729b6a94015d410538fa6f6810b21b85/images/55891519718168286.png' alt='Logo' style='display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;' title='Logo' width='35' height='35'></a></td></tr><tr style='border-collapse:collapse;'><td align='center' style='padding:0;Margin:0;padding-top:15px;padding-bottom:15px;'><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;line-height:21px;color:#999999;'>
                            Av Guadalupe N 9501, El Colli, 45070 Zapopan, Jal, México<br></p></td></tr></table></td></tr></table></td></tr></table></td></tr></table><table class='es-content' cellspacing='0' cellpadding='0' align='center' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;'><tr style='border-collapse:collapse;'><td style='padding:0;Margin:0;background-color:#F6F6F6;' bgcolor='#f6f6f6' align='center'><table class='es-content-body' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;' width='640' cellspacing='0' cellpadding='0' align='center'><tr style='border-collapse:collapse;'><td align='left' style='Margin:0;padding-left:20px;padding-right:20px;padding-top:30px;padding-bottom:30px;'>
                            <table width='100%' cellspacing='0' cellpadding='0' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td width='600' valign='top' align='center' style='padding:0;Margin:0;'><table width='100%' cellspacing='0' cellpadding='0' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td class='es-infoblock made_with' style='padding:0;Margin:0;line-height:0px;font-size:0px;color:#CCCCCC;' align='center'><a target='_blank' href='https://viewstripo.email/?utm_source=templates&utm_medium=email&utm_campaign=technology&utm_content=trigger_newsletter' style='-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;font-size:12px;text-decoration:none;color:#CCCCCC;'>
                            <img src='https://fqehjo.stripocdn.email/content/guids/95820a7c-b5c9-40db-b28f-2db8ff838956/images/66451586029405480.png' alt style='display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;' width='125' height='89'></a></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table></div></body>
                            </html>";
                mail($email, $subject, $message, $headers);
                echo json_encode(array (
                    'answer' => 'OK',
                    'status' => 'The email message was sent'
                ));
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
                $message = "<html style='width:100%;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0;'><head><meta charset='UTF-8'><meta content='width=device-width, initial-scale=1' name='viewport'><meta name='x-apple-disable-message-reformatting'><meta http-equiv='X-UA-Compatible' content='IE=edge'><meta content='telephone=no' name='format-detection'><title>Validating your contact email</title> <!--[if (mso 16)]><style type='text/css'>     a {text-decoration: none;}     </style><![endif]--> <!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]--> <!--[if !mso]><!-- --><link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i' rel='stylesheet'> <!--<![endif]-->
                            <style type='text/css'>@media only screen and (max-width:600px) {p, ul li, ol li, a { font-size:16px!important; line-height:150%!important } h1 { font-size:30px!important; text-align:center; line-height:120%!important } h2 { font-size:26px!important; text-align:center; line-height:120%!important } h3 { font-size:20px!important; text-align:center; line-height:120%!important } h1 a { font-size:30px!important } h2 a { font-size:26px!important } h3 a { font-size:20px!important } .es-menu td a { font-size:16px!important } .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a { font-size:16px!important } .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a { font-size:16px!important } .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a { font-size:12px!important } *[class='gmail-fix'] { display:none!important } .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3 { 
                            text-align:center!important } .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3 { text-align:right!important } .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3 { text-align:left!important } .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img { display:inline!important } .es-button-border { display:block!important } a.es-button { font-size:20px!important; display:block!important; border-width:15px 25px 15px 25px!important } .es-btn-fw { border-width:10px 0px!important; text-align:center!important } .es-adaptive table, .es-btn-fw, .es-btn-fw-brdr, .es-left, .es-right { width:100%!important } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%!important; max-width:600px!important } .es-adapt-td { display:block!important; width:100%!important } .adapt-img { width:100%!important; height:auto!important } .es-m-p0 { padding:0px!important } .es-m-p0r { 
                            padding-right:0px!important } .es-m-p0l { padding-left:0px!important } .es-m-p0t { padding-top:0px!important } .es-m-p0b { padding-bottom:0!important } .es-m-p20b { padding-bottom:20px!important } .es-mobile-hidden, .es-hidden { display:none!important } .es-desk-hidden { display:table-row!important; width:auto!important; overflow:visible!important; float:none!important; max-height:inherit!important; line-height:inherit!important } .es-desk-menu-hidden { display:table-cell!important } table.es-table-not-adapt, .esd-block-html table { width:auto!important } table.es-social { display:inline-block!important } table.es-social td { display:inline-block!important } }#outlook a {	padding:0;}.ExternalClass {	width:100%;}.ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div {	line-height:100%;}.es-button 
                            {	mso-style-priority:100!important;	text-decoration:none!important;}a[x-apple-data-detectors] {	color:inherit!important;	text-decoration:none!important;	font-size:inherit!important;	font-family:inherit!important;	font-weight:inherit!important;	line-height:inherit!important;}.es-desk-hidden {	display:none;	float:left;	overflow:hidden;	width:0;	max-height:0;	line-height:0;	mso-hide:all;}</style></head><body style='width:100%;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0;'><div class='es-wrapper-color' style='background-color:#F6F6F6;'> <!--[if gte mso 9]><v:background xmlns:v='urn:schemas-microsoft-com:vml' fill='t'> <v:fill type='tile' color='#f6f6f6'></v:fill> </v:background><![endif]-->
                            <table class='es-wrapper' width='100%' cellspacing='0' cellpadding='0' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top;'><tr style='border-collapse:collapse;'><td valign='top' style='padding:0;Margin:0;'><table class='es-content' cellspacing='0' cellpadding='0' align='center' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;'><tr style='border-collapse:collapse;'><td align='center' style='padding:0;Margin:0;'><table class='es-content-body' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;' width='640' cellspacing='0' cellpadding='0' align='center'><tr style='border-collapse:collapse;'>
                            <td align='left' style='Margin:0;padding-top:15px;padding-bottom:15px;padding-left:20px;padding-right:20px;'> <!--[if mso]><table width='600' cellpadding='0' cellspacing='0'><tr><td width='290' valign='top'><![endif]--><table class='es-left' cellspacing='0' cellpadding='0' align='left' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left;'><tr style='border-collapse:collapse;'><td width='290' align='left' style='padding:0;Margin:0;'><table width='100%' cellspacing='0' cellpadding='0' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td class='es-infoblock es-m-txt-c' align='left' style='padding:0;Margin:0;line-height:14px;font-size:12px;color:#CCCCCC;'>
                            <p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:12px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:14px;color:#CCCCCC;'>This is an auto-generated mail, please don't respond it<br></p></td></tr></table></td></tr></table> <!--[if mso]></td><td width='20'></td><td width='290' valign='top'><![endif]--><table class='es-right' cellspacing='0' cellpadding='0' align='right' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right;'><tr style='border-collapse:collapse;'><td width='290' align='left' style='padding:0;Margin:0;'><table width='100%' cellspacing='0' cellpadding='0' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'>
                            <td class='es-infoblock es-m-txt-c' align='right' style='padding:0;Margin:0;line-height:14px;font-size:12px;color:#CCCCCC;'><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:12px;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;line-height:14px;color:#CCCCCC;'></p></td></tr></table></td></tr></table> <!--[if mso]></td></tr></table><![endif]--></td></tr></table></td></tr></table>
                            <table class='es-header' cellspacing='0' cellpadding='0' align='center' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top;'><tr style='border-collapse:collapse;'><td style='padding:0;Margin:0;background-size:cover;background-color:#3D5E6A;' bgcolor='#3D5E6A' align='center'>
                            <table class='es-header-body' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;background-image:url(https://fqehjo.stripocdn.email/content/guids/95820a7c-b5c9-40db-b28f-2db8ff838956/images/66451586029405480.png);background-repeat:no-repeat;background-position:center top;' width='640' cellspacing='0' cellpadding='0' background='https://fqehjo.stripocdn.email/content/guids/95820a7c-b5c9-40db-b28f-2db8ff838956/images/66451586029405480.png' align='center'><tr style='border-collapse:collapse;'><td align='left' style='Margin:0;padding-top:10px;padding-left:20px;padding-right:20px;padding-bottom:25px;'><table width='100%' cellspacing='0' cellpadding='0' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td width='600' valign='top' align='center' style='padding:0;Margin:0;'>
                            <table width='100%' cellspacing='0' cellpadding='0' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td style='padding:0;Margin:0;padding-bottom:25px;padding-top:40px;font-size:0px;' align='center'><a href='https://viewstripo.email' target='_blank' style='-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;font-size:20px;text-decoration:none;color:#B7BDC9;'><img src='https://fqehjo.stripocdn.email/content/guids/95820a7c-b5c9-40db-b28f-2db8ff838956/images/66451586029405480.png' style='display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;' alt='Logo' title='Logo' width='220' height='157'></a></td></tr><tr style='border-collapse:collapse;'>
                            <td align='center' style='padding:0;Margin:0;padding-bottom:20px;padding-top:25px;'><h1 style='Margin:0;line-height:48px;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;font-size:40px;font-style:normal;font-weight:bold;color:#FFFFFF;'>Welcome to aarrin.com</h1></td></tr><tr style='border-collapse:collapse;'><td esdev-links-color='#b7bdc9' align='center' style='padding:0;Margin:0;padding-top:10px;padding-bottom:25px;'><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:20px;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;line-height:30px;color:#B7BDC9;'><br></p></td></tr></table></td></tr></table></td></tr></table></td></tr></table>
                            <table class='es-content' cellspacing='0' cellpadding='0' align='center' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;'><tr style='border-collapse:collapse;'><td align='center' style='padding:0;Margin:0;'><table class='es-content-body' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#F6F6F6;' width='640' cellspacing='0' cellpadding='0' bgcolor='#f6f6f6' align='center'><tr style='border-collapse:collapse;'><td align='left' style='padding:0;Margin:0;padding-top:10px;padding-left:20px;padding-right:20px;'><table width='100%' cellspacing='0' cellpadding='0' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td width='600' valign='top' align='center' style='padding:0;Margin:0;'>
                            <table width='100%' cellspacing='0' cellpadding='0' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td style='padding:0;Margin:0;padding-top:20px;padding-bottom:20px;font-size:0;' align='center'><table width='100%' height='100%' cellspacing='0' cellpadding='0' border='0' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td style='padding:0;Margin:0px;border-bottom:1px solid #F6F6F6;background:rgba(0, 0, 0, 0) none repeat scroll 0% 0%;height:1px;width:100%;margin:0px;'></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table>
                            <table class='es-content' cellspacing='0' cellpadding='0' align='center' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;'><tr style='border-collapse:collapse;'><td align='center' style='padding:0;Margin:0;'><table class='es-content-body' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#F6F6F6;' width='640' cellspacing='0' cellpadding='0' bgcolor='#f6f6f6' align='center'><tr style='border-collapse:collapse;'><td align='left' style='padding:0;Margin:0;padding-top:10px;padding-left:20px;padding-right:20px;'><table width='100%' cellspacing='0' cellpadding='0' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td width='600' valign='top' align='center' style='padding:0;Margin:0;'>
                            <table width='100%' cellspacing='0' cellpadding='0' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td style='padding:0;Margin:0;padding-bottom:15px;padding-top:20px;font-size:0;' align='center'><table width='100%' height='100%' cellspacing='0' cellpadding='0' border='0' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td style='padding:0;Margin:0px;border-bottom:1px solid #F6F6F6;background:rgba(0, 0, 0, 0) none repeat scroll 0% 0%;height:1px;width:100%;margin:0px;'></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table>
                            <table class='es-content' cellspacing='0' cellpadding='0' align='center' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;'><tr style='border-collapse:collapse;'><td align='center' style='padding:0;Margin:0;'><table class='es-content-body' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;' width='640' cellspacing='0' cellpadding='0' align='center'><tr style='border-collapse:collapse;'><td align='left' style='padding:0;Margin:0;padding-left:20px;padding-right:20px;'><table width='100%' cellspacing='0' cellpadding='0' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td width='600' valign='top' align='center' style='padding:0;Margin:0;'>
                            <table style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:separate;border-spacing:0px;border-radius:3px;background-color:#FFFFFF;' width='100%' cellspacing='0' cellpadding='0' bgcolor='#ffffff' role='presentation'><tr style='border-collapse:collapse;'><td align='center' style='Margin:0;padding-bottom:5px;padding-left:20px;padding-right:20px;padding-top:25px;'><h2 style='Margin:0;line-height:24px;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;font-size:20px;font-style:normal;font-weight:bold;color:#444444;'>Please enter this code in the website<br></h2></td></tr><tr style='border-collapse:collapse;'><td align='center' style='Margin:0;padding-top:10px;padding-bottom:15px;padding-left:20px;padding-right:20px;'>
                            <p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;line-height:24px;color:#999999;'><span class='product-description'>This code is functional just for 5 minutes<br></span></p></td></tr><tr style='border-collapse:collapse;'><td style='padding:0;Margin:0;'><center><h2 style='Margin:0;line-height:24px;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;font-size:20px;font-style:normal;font-weight:bold;color:#444444;'>$code</h2></center></td></tr></table></td></tr></table></td></tr></table></td></tr></table><table class='es-content' cellspacing='0' cellpadding='0' align='center' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;'>
                            <tr style='border-collapse:collapse;'><td align='center' style='padding:0;Margin:0;'><table class='es-content-body' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#F6F6F6;' width='640' cellspacing='0' cellpadding='0' bgcolor='#f6f6f6' align='center'><tr style='border-collapse:collapse;'><td align='left' style='padding:0;Margin:0;padding-top:10px;padding-left:20px;padding-right:20px;'><table width='100%' cellspacing='0' cellpadding='0' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td width='600' valign='top' align='center' style='padding:0;Margin:0;'><table width='100%' cellspacing='0' cellpadding='0' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'>
                            <td style='padding:0;Margin:0;padding-top:10px;padding-bottom:10px;font-size:0;' align='center'><table width='100%' height='100%' cellspacing='0' cellpadding='0' border='0' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td style='padding:0;Margin:0px;border-bottom:1px solid #F6F6F6;background:rgba(0, 0, 0, 0) none repeat scroll 0% 0%;height:1px;width:100%;margin:0px;'></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table><table class='es-footer' cellspacing='0' cellpadding='0' align='center' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top;'><tr style='border-collapse:collapse;'><td align='center' style='padding:0;Margin:0;'>
                            <table class='es-footer-body' width='640' cellspacing='0' cellpadding='0' align='center' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#F6F6F6;'><tr style='border-collapse:collapse;'><td align='left' style='Margin:0;padding-left:20px;padding-right:20px;padding-top:40px;padding-bottom:40px;'><table width='100%' cellspacing='0' cellpadding='0' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td width='600' valign='top' align='center' style='padding:0;Margin:0;'><table width='100%' cellspacing='0' cellpadding='0' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td style='padding:0;Margin:0;padding-bottom:5px;font-size:0;' align='center'>
                            <a target='_blank' href='https://viewstripo.email' style='-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;font-size:14px;text-decoration:none;color:#999999;'><img src='https://fqehjo.stripocdn.email/content/guids/CABINET_729b6a94015d410538fa6f6810b21b85/images/55891519718168286.png' alt='Logo' style='display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;' title='Logo' width='35' height='35'></a></td></tr><tr style='border-collapse:collapse;'><td align='center' style='padding:0;Margin:0;padding-top:15px;padding-bottom:15px;'><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;line-height:21px;color:#999999;'>
                            Av Guadalupe N 9501, El Colli, 45070 Zapopan, Jal, México<br></p></td></tr></table></td></tr></table></td></tr></table></td></tr></table><table class='es-content' cellspacing='0' cellpadding='0' align='center' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;'><tr style='border-collapse:collapse;'><td style='padding:0;Margin:0;background-color:#F6F6F6;' bgcolor='#f6f6f6' align='center'><table class='es-content-body' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;' width='640' cellspacing='0' cellpadding='0' align='center'><tr style='border-collapse:collapse;'><td align='left' style='Margin:0;padding-left:20px;padding-right:20px;padding-top:30px;padding-bottom:30px;'>
                            <table width='100%' cellspacing='0' cellpadding='0' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td width='600' valign='top' align='center' style='padding:0;Margin:0;'><table width='100%' cellspacing='0' cellpadding='0' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td class='es-infoblock made_with' style='padding:0;Margin:0;line-height:0px;font-size:0px;color:#CCCCCC;' align='center'><a target='_blank' href='https://viewstripo.email/?utm_source=templates&utm_medium=email&utm_campaign=technology&utm_content=trigger_newsletter' style='-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;font-size:12px;text-decoration:none;color:#CCCCCC;'>
                            <img src='https://fqehjo.stripocdn.email/content/guids/95820a7c-b5c9-40db-b28f-2db8ff838956/images/66451586029405480.png' alt style='display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;' width='125' height='89'></a></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table></div></body>
                            </html>";
                mail($email, $subject, $message, $headers);
                header(HTTP_CODE_201);
                echo json_encode(array(
                    'data' => $data,
                    'token' => TokenTool::createToken($data, 0.1)
                ));
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
                        'token' => TokenTool::createToken($answer, 0.1)
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