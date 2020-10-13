<?php
/**
* Controlador de funciones para tabla personal
*
* Manejo de acciones sobre la tabla personal
* Operaciones a utilizar y descripción a utilizar:

* Solicitar todos los datos en modo lista-> url: .../api/v1-2/personal/all, metodo: GET, datos-solicitados: {}

* Solicitar datos completos de un empleado-> url: .../api/v1-2/personal/get/:idEmployee, metodo: GET, datos-solicitados: {}

* Solicitar login de un empleado-> url: .../api/v1-2/personal/login (Este caso no necesitará de un token), metodo: GET, datos-solicitados: {email: string, password: string}

* Registrar un nuevo empleado-> url: .../api/v1-2/personal/add, metodo: POST, datos-solicitados: {name:string, lastname: string, contract: int, charge: string, email: string, rfc: string}

* Cambiar la foto de perfil del empleado-> url: .../api/v1-2/personal/edit-photo/:idEmployee, metodo: POST, datos-solicitado:. {image: File}

* Editar los datos de un empleado-> url: .../api/v1-2/personal/edit/:idEmployee, metodo: PUT, datos-solicitados: {data: jsonString}
*
* @author Yael Alejandro Santana Michel
* @author ya_el1995@hotmail.com
*
* @package ari-mobile-api
*/

/**
 * @var int $idEmployee ID del empleado a solicitar datos
 */
$idEmployee = null;
/**
 * @var string $employeeName Nombre del empleado
 */
$employeeName = null;

/**
 * @var string $employeeLastName Apellidos del empleado
 */
$employeeLastName = null;

/**
 * @var int $employeeContractYear Año en el que fue contratado el empleado
 */
$employeeContractYear = null;

/**
 * @var string $employeeCharge Puesto que ocupa el empleado
 */
$employeeCharge = null;

/**
 * @var string $employeeEmail Email del empleado y que será parte de sus credenciales de acceso
 */
$employeeEmail = null;

/**
 * @var string $employeeRFC Código de Registro Federal de Contribuyentes (RFC)
 */
$employeeRFC = null;

/**
 * @var string $employeePassword Contraseña de acceso a la plataforma
 */
$employeePassword = null;

/**
 * @var string $employeeDegree Titulo de licenciatura del empleado
 */
$employeeDegree = null;

/**
 * @var string|date $employeeBirth Fecha de nacimiento del empleado
 */
$employeeBirth = null;

/**
 * @var string $employeeAddress Domicilio de residencia del empleado
 */
$employeeAddress = null;

/**
 * @var string $employeePhone Número telefónico del empleado
 */
$employeePhone  = null;

/**
 * @var string $employeeInsurance Numero de Seguro Social del empleado
 */
$employeeInsurance = null;



switch ($url[5]) {
    /**
     * Solicitar todos los datos en modo lista-> 
     * url: .../api/v1-2/personal/all, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @return jsonString Todos los registros en modo vista de lista
     */
    case 'all':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }
        
        if (TokenTool::isValid($token)){
            $query = "SELECT IdEmployee, EmployeeName, EmployeeLastName, EmployeeDegree, EmployeeBirth, EmployeeContractYear, EmployeeCharge, EmployeeAddress, EmployeePhone, EmployeeEmail, EmployeeInsurance, EmployeeRFC, EmployeePhoto, EmployeeStatus FROM personal ORDER BY EmployeeLastName, EmployeeName;";
            $data = DBManager::query($query);
            if ($data) {
                header(HTTP_CODE_200);
                echo json_encode($data);
            }else{
                header(HTTP_CODE_204);
            }
        }
        else {
            header(HTTP_CODE_401);
        }
        break;


    /**
     * Solicitar datos completos de un empleado-> 
     * url: .../api/v1-2/personal/get/:idEmployee, 
     * metodo: GET, 
     * datos-solicitados. {}
     * @param int idEmployee- ID del empleado, deberá ir al final de la url
     * @return JsonString|null Datos del empleado con el ID correspondiente 
     */
    case 'get':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }

        if (!isset($url[6])) {
            header(HTTP_CODE_412);
            exit();
        }
        $idEmployee = (int) $url[6];

        if (TokenTool::isValid($token)){
            $query = "SELECT IdEmployee, EmployeeName, EmployeeLastName, EmployeeDegree, EmployeeBirth, EmployeeContractYear, EmployeeCharge, EmployeeAddress, EmployeePhone, EmployeeEmail, EmployeeInsurance, EmployeeRFC, AES_DECRYPT(EmployeePassword, '@Empleado') AS 'EmployeePassword', EmployeePhoto, EmployeeStatus FROM personal WHERE IdEmployee = :idEmployee";
            $data = DBManager::query($query, array(':idEmployee' => $idEmployee));
            if ($data) {
                header(HTTP_CODE_200);
                echo json_encode($data[0]);
            } else {
                header(HTTP_CODE_204);
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;


    /**
     * Solicitar login de un empleado-> 
     * url: .../api/v1-2/personal/login (Este caso no necesitará de un token), 
     * metodo: GET, 
     * datos-solicitados. {email: string, password: string}
     * @return jsonString|null Datos y token de sesión para el empleado
     */
    case 'login':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow: GET');
            exit();
        }

        if(isset($_GET['email']) && isset($_GET['password'])){
            $employeeEmail      = $_GET['email'];
            $employeePassword   = $_GET['password'];

            $query = "SELECT IdEmployee, EmployeeName, EmployeeLastName, EmployeeDegree, EmployeeBirth, EmployeeContractYear, EmployeeCharge, EmployeeAddress, EmployeePhone, EmployeeEmail, EmployeeInsurance, EmployeeRFC, AES_DECRYPT(EmployeePassword, '@Empleado') AS 'EmployeePassword', EmployeePhoto, EmployeeStatus FROM personal WHERE EmployeeEmail = :employeeEmail AND EmployeePassword = AES_ENCRYPT(:employeePassword,'@Empleado');";
            $data = DBManager::query($query, array(':employeeEmail' => $employeeEmail, ':employeePassword' => $employeePassword));

            if($data){
                $employeeData = $data[0];

                $dataForToken = array(
                    'IdEmployee'    => $employeeData['IdEmployee'],
                    'EmployeeName'  => $employeeData['EmployeeName'].' '.$employeeData['EmployeeLastName'],
                    'EmployeeRFC'   => $employeeData['EmployeeRFC'],
                    'EmployeeEmail' => $employeeData['EmployeeEmail']
                );
                $employeeData['Token'] = TokenTool::createToken($dataForToken);
                if ($employeeData['EmployeeStatus'] == 'Active'){
                    header(HTTP_CODE_200);
                    echo json_encode($employeeData);
                } else {
                    header(HTTP_CODE_403);
                }
                exit();
            }else{
                header(HTTP_CODE_204);
                exit();
            }
        }
        
        break;


    /**
     * Registrar un nuevo empleado-> 
     * url: .../api/v1-2/personal/add, 
     * metodo: POST, 
     * datos-solicitados. {name:string, lastname: string, contract: int, charge: string, email: string, rfc: string}
     */
    case 'add':
        if ($method !== 'POST') {
            header('HTTP/1.1 405 Allow: POST');
            exit();
        }

        if(isset($_POST['name']) && isset($_POST['lastname']) && isset($_POST['contract']) && isset($_POST['charge']) && isset($_POST['email']) && isset($_POST['rfc'])){
            if (TokenTool::isValid($token)){
                $employeeName           = $_POST['name'];
                $employeeLastName       = $_POST['lastname'];
                $employeeContractYear   = $_POST['contract'];
                $employeeCharge         = $_POST['charge'];
                $employeeEmail          = $_POST['email'];
                $employeeRFC            = $_POST['rfc'];
                $employeePassword       = '';

                $STR = 'QWERTYUIOPASDFGHJKLZXCVBNM0123456789/*-+.$?';
                

                for ($i=0; $i < 8; $i++) {
                    $employeePassword .= substr($STR, rand(0,42),1);
                }

                $params = array(
                    ':employeeName'         => $employeeName,
                    ':employeeLastName'     => $employeeLastName,
                    ':employeeContractYear' => $employeeContractYear,
                    ':employeeCharge'       => $employeeCharge,
                    ':employeeEmail'        => $employeeEmail,
                    ':employeeRFC'          => $employeeRFC,
                    ':employeePassword'     => $employeePassword
                );

                $query = "INSERT INTO personal(EmployeeName, EmployeeLastName, EmployeeDegree, EmployeeBirth, EmployeeContractYear, EmployeeCharge, EmployeeAddress, EmployeePhone, EmployeeEmail, EmployeeInsurance, EmployeeRFC, EmployeePassword) VALUES (:employeeName, :employeeLastName, '', '0000-00-00', :employeeContractYear, :employeeCharge, '', '', :employeeEmail, '', :employeeRFC, AES_ENCRYPT(:employeePassword,'@Empleado'));";
                $response =DBManager::query($query, $params);

                if ($response){
                    $subject = "Now you are a part of us";
                    $headers = "MIME-Version: 1.0 \r\nContent-type: text/html; charset-utf-8\r\n From: no-reply@aarrin.com";
                    $message = "<html style='width:100%;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0;'><head><meta charset='UTF-8'><meta content='width=device-width, initial-scale=1' name='viewport'><meta name='x-apple-disable-message-reformatting'><meta http-equiv='X-UA-Compatible' content='IE=edge'><meta content='telephone=no' name='format-detection'><title>New access allowed to you</title> <!--[if (mso 16)]><style type='text/css'>     a {text-decoration: none;}     </style><![endif]--> <!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]--> <!--[if !mso]><!-- --><link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i' rel='stylesheet'> <!--<![endif]-->
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
                    <td align='center' style='padding:0;Margin:0;padding-bottom:20px;padding-top:25px;'><h1 style='Margin:0;line-height:48px;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;font-size:40px;font-style:normal;font-weight:bold;color:#FFFFFF;'>Welcome to <a href='https://aarrin.com/login'>aarrin.com</a></h1></td></tr><tr style='border-collapse:collapse;'><td esdev-links-color='#b7bdc9' align='center' style='padding:0;Margin:0;padding-top:10px;padding-bottom:25px;'><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:20px;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;line-height:30px;color:#B7BDC9;'><br></p></td></tr></table></td></tr></table></td></tr></table></td></tr></table>
                    <table class='es-content' cellspacing='0' cellpadding='0' align='center' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;'><tr style='border-collapse:collapse;'><td align='center' style='padding:0;Margin:0;'><table class='es-content-body' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#F6F6F6;' width='640' cellspacing='0' cellpadding='0' bgcolor='#f6f6f6' align='center'><tr style='border-collapse:collapse;'><td align='left' style='padding:0;Margin:0;padding-top:10px;padding-left:20px;padding-right:20px;'><table width='100%' cellspacing='0' cellpadding='0' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td width='600' valign='top' align='center' style='padding:0;Margin:0;'>
                    <table width='100%' cellspacing='0' cellpadding='0' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td style='padding:0;Margin:0;padding-top:20px;padding-bottom:20px;font-size:0;' align='center'><table width='100%' height='100%' cellspacing='0' cellpadding='0' border='0' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td style='padding:0;Margin:0px;border-bottom:1px solid #F6F6F6;background:rgba(0, 0, 0, 0) none repeat scroll 0% 0%;height:1px;width:100%;margin:0px;'></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table>
                    <table class='es-content' cellspacing='0' cellpadding='0' align='center' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;'><tr style='border-collapse:collapse;'><td align='center' style='padding:0;Margin:0;'><table class='es-content-body' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#F6F6F6;' width='640' cellspacing='0' cellpadding='0' bgcolor='#f6f6f6' align='center'><tr style='border-collapse:collapse;'><td align='left' style='padding:0;Margin:0;padding-top:10px;padding-left:20px;padding-right:20px;'><table width='100%' cellspacing='0' cellpadding='0' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td width='600' valign='top' align='center' style='padding:0;Margin:0;'>
                    <table width='100%' cellspacing='0' cellpadding='0' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td style='padding:0;Margin:0;padding-bottom:15px;padding-top:20px;font-size:0;' align='center'><table width='100%' height='100%' cellspacing='0' cellpadding='0' border='0' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td style='padding:0;Margin:0px;border-bottom:1px solid #F6F6F6;background:rgba(0, 0, 0, 0) none repeat scroll 0% 0%;height:1px;width:100%;margin:0px;'></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table>
                    <table class='es-content' cellspacing='0' cellpadding='0' align='center' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;'><tr style='border-collapse:collapse;'><td align='center' style='padding:0;Margin:0;'><table class='es-content-body' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;' width='640' cellspacing='0' cellpadding='0' align='center'><tr style='border-collapse:collapse;'><td align='left' style='padding:0;Margin:0;padding-left:20px;padding-right:20px;'><table width='100%' cellspacing='0' cellpadding='0' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td width='600' valign='top' align='center' style='padding:0;Margin:0;'>
                    <table style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:separate;border-spacing:0px;border-radius:3px;background-color:#FFFFFF;' width='100%' cellspacing='0' cellpadding='0' bgcolor='#ffffff' role='presentation'><tr style='border-collapse:collapse;'><td align='center' style='Margin:0;padding-bottom:5px;padding-left:20px;padding-right:20px;padding-top:25px;'><h2 style='Margin:0;line-height:24px;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;font-size:20px;font-style:normal;font-weight:bold;color:#444444;'>Use your email and the next password to enter to control panel of <a href='https://aarrin.com/login'>aarrin.com</a> website<br></h2></td></tr><tr style='border-collapse:collapse;'><td align='center' style='Margin:0;padding-top:10px;padding-bottom:15px;padding-left:20px;padding-right:20px;'>
                    <p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;line-height:24px;color:#999999;'><span class='product-description'>This password was autogenerated and will be changed by you<br></span></p></td></tr><tr style='border-collapse:collapse;'><td style='padding:0;Margin:0;'><center><h2 style='Margin:0;line-height:24px;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;font-size:20px;font-style:normal;font-weight:bold;color:#444444;'>$employeePassword</h2></center></td></tr></table></td></tr></table></td></tr></table></td></tr></table><table class='es-content' cellspacing='0' cellpadding='0' align='center' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;'>
                    <tr style='border-collapse:collapse;'><td align='center' style='padding:0;Margin:0;'><table class='es-content-body' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#F6F6F6;' width='640' cellspacing='0' cellpadding='0' bgcolor='#f6f6f6' align='center'><tr style='border-collapse:collapse;'><td align='left' style='padding:0;Margin:0;padding-top:10px;padding-left:20px;padding-right:20px;'><table width='100%' cellspacing='0' cellpadding='0' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td width='600' valign='top' align='center' style='padding:0;Margin:0;'><table width='100%' cellspacing='0' cellpadding='0' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'>
                    <td style='padding:0;Margin:0;padding-top:10px;padding-bottom:10px;font-size:0;' align='center'><table width='100%' height='100%' cellspacing='0' cellpadding='0' border='0' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td style='padding:0;Margin:0px;border-bottom:1px solid #F6F6F6;background:rgba(0, 0, 0, 0) none repeat scroll 0% 0%;height:1px;width:100%;margin:0px;'></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table><table class='es-footer' cellspacing='0' cellpadding='0' align='center' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top;'><tr style='border-collapse:collapse;'><td align='center' style='padding:0;Margin:0;'>
                    <table class='es-footer-body' width='640' cellspacing='0' cellpadding='0' align='center' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#F6F6F6;'><tr style='border-collapse:collapse;'><td align='left' style='Margin:0;padding-left:20px;padding-right:20px;padding-top:40px;padding-bottom:40px;'><table width='100%' cellspacing='0' cellpadding='0' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td width='600' valign='top' align='center' style='padding:0;Margin:0;'><table width='100%' cellspacing='0' cellpadding='0' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td style='padding:0;Margin:0;padding-bottom:5px;font-size:0;' align='center'>
                    <a target='_blank' href='https://viewstripo.email' style='-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;font-size:14px;text-decoration:none;color:#999999;'><img src='https://fqehjo.stripocdn.email/content/guids/CABINET_729b6a94015d410538fa6f6810b21b85/images/55891519718168286.png' alt='Logo' style='display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;' title='Logo' width='35' height='35'></a></td></tr><tr style='border-collapse:collapse;'><td align='center' style='padding:0;Margin:0;padding-top:15px;padding-bottom:15px;'><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;line-height:21px;color:#999999;'>
                    Av Guadalupe N 9501, El Colli, 45070 Zapopan, Jal, México<br></p></td></tr></table></td></tr></table></td></tr></table></td></tr></table><table class='es-content' cellspacing='0' cellpadding='0' align='center' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;'><tr style='border-collapse:collapse;'><td style='padding:0;Margin:0;background-color:#F6F6F6;' bgcolor='#f6f6f6' align='center'><table class='es-content-body' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;' width='640' cellspacing='0' cellpadding='0' align='center'><tr style='border-collapse:collapse;'><td align='left' style='Margin:0;padding-left:20px;padding-right:20px;padding-top:30px;padding-bottom:30px;'>
                    <table width='100%' cellspacing='0' cellpadding='0' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td width='600' valign='top' align='center' style='padding:0;Margin:0;'><table width='100%' cellspacing='0' cellpadding='0' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'><tr style='border-collapse:collapse;'><td class='es-infoblock made_with' style='padding:0;Margin:0;line-height:0px;font-size:0px;color:#CCCCCC;' align='center'><a target='_blank' href='https://viewstripo.email/?utm_source=templates&utm_medium=email&utm_campaign=technology&utm_content=trigger_newsletter' style='-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;font-size:12px;text-decoration:none;color:#CCCCCC;'>
                    <img src='https://fqehjo.stripocdn.email/content/guids/95820a7c-b5c9-40db-b28f-2db8ff838956/images/66451586029405480.png' alt style='display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;' width='125' height='89'></a></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table></div></body>
                    </html>";
                    mail($employeeEmail, $subject, $message, $headers);
                    header(HTTP_CODE_201);
                    echo json_encode($array);
                } else {
                    header(HTTP_CODE_409);
                }
            }
            else{
                header(HTTP_CODE_401);
            }
            exit();
        }else{
            header(HTTP_CODE_412);
            exit();
        }
        break;


    /**
     * Cambiar la foto de perfil del empleado-> 
     * url: .../api/v1-2/personal/edit-photo/:idEmployee, 
     * metodo: POST, 
     * datos-solicitados. {image: File}
     * @param int idEmployee- ID del empleado a editar, deberá ir al final de la url
     * @return jsonString Datos actualizados del empleado
     */
    case 'edit-photo':
        if ($method !== 'POST') {
            header('HTTP/1.1 405 Allow: POST');
            exit();
        }

        if (!isset($url[6])) {
            header(HTTP_CODE_412);
            exit();
        }
        $idEmployee = (int) $url[6];

        if(isset($_FILES['image'])){
            if (TokenTool::isValid($token)){

                $f = $_FILES['image'];
                $name = "profile_$idEmployee.Image-pqwe82354daloihd.png";
                $path = "https://aarrin.com/mobile/app_resources/personal/$name";
                
                if (move_uploaded_file($f['tmp_name'], __DIR__. "/../../../../app_resources/personal/$name")){
                    $query = "UPDATE personal SET EmployeePhoto = :path WHERE IdEmployee = :idEmployee";
                    $response = DBManager::query($query, array(':path' => $path, ':idEmployee' => $idEmployee));

                    if ($response) {
                        $query = "SELECT IdEmployee, EmployeeName, EmployeeLastName, EmployeeDegree, EmployeeBirth, EmployeeContractYear, EmployeeCharge, EmployeeAddress, EmployeePhone, EmployeeEmail, EmployeeInsurance, EmployeeRFC, AES_DECRYPT(EmployeePassword, '@Empleado') AS 'EmployeePassword', EmployeePhoto FROM personal WHERE IdEmployee = :idEmployee";
                        $data = DBManager::query($query, array('idEmployee' => $idEmployee));

                        $employeeData = $data[0];

                        $dataForToken = array(
                            'IdEmployee'    => $employeeData['IdEmployee'],
                            'EmployeeName'  => $employeeData['EmployeeName'].' '.$employeeData['EmployeeLastName'],
                            'EmployeeRFC'   => $employeeData['EmployeeRFC'],
                            'EmployeeEmail' => $employeeData['EmployeeEmail']
                        );
                        $employeeData['Token'] = TokenTool::createToken($dataForToken);
                        echo json_encode($employeeData);
                    } else {
                        echo json_encode(array('error' => 'Can\'t change the data', 'place' => 'At moment to register the new path'));
                        header(HTTP_CODE_409);
                    }
                } else {
                    echo json_encode(array('error' => 'Can\'t move the file', 'place' => 'At moment to move the file'));
                    header(HTTP_CODE_409);
                }
            }
            else{
                header(HTTP_CODE_401);
            }
            exit();
        }else{
            header(HTTP_CODE_412);
            exit();
        }
        break;

    /**
     * Editar los datos de un empleado-> 
     * url: .../api/v1-2/personal/edit/:idEmployee, 
     * metodo: PUT, 
     * datos-solicitados. {data: jsonString}
     * @param int idEmployee ID del empleado, deberá ir al final de la url
     * @return jsonString Datos actualizados del empleado
     */
    case 'edit':
        if ($method !== 'PUT'){
            header('HTTP/1.1 405 Allow: PUT');
            exit();
        }

        if (!isset($url[6])) {
            header(HTTP_CODE_412);
            exit();
        }
        $idEmployee = (int) $url[6];

        $data = null;

        if (!isset($_GET['data'])) {
            header(HTTP_CODE_412);
            exit();
        }
        $data = json_decode($_GET['data'], true);

        if (TokenTool::isValid($token)){
            $employeeName           = $data['EmployeeName'];
            $employeeLastName       = $data['EmployeeLastName'];
            $employeeContractYear   = $data['EmployeeContractYear'];
            $employeeCharge         = $data['EmployeeCharge'];
            $employeeEmail          = $data['EmployeeEmail'];
            $employeeRFC            = $data['EmployeeRFC'];

            $params = array(
                ':employeeName'         => $employeeName,
                ':employeeLastName'     => $employeeLastName,
                ':employeeContractYear' => $employeeContractYear,
                ':employeeCharge'       => $employeeCharge,
                ':employeeEmail'        => $employeeEmail,
                ':employeeRFC'          =>$employeeRFC,
            );

            $query = "UPDATE personal SET EmployeeName = :employeeName, EmployeeLastName = :employeeLastName, EmployeeContractYear = :employeeContractYear, EmployeeCharge = :employeeCharge, EmployeeEmail = :employeeEmail, EmployeeRFC = :employeeRFC";
            if (isset($data['EmployeeDegree']) && trim($data['EmployeeDegree']) !== '') {
                $employeeDegree = $data['EmployeeDegree'];
                $query          .= ", EmployeeDegree = :employeeDegree";
                $params[':employeeDegree'] = $employeeDegree;
            }
            if (isset($data['EmployeeBirth']) && trim($data['EmployeeBirth']) !== '') {
                $employeeBirth = $data['EmployeeBirth'];
                $query         .= ", EmployeeBirth = :employeeBirth";
                $params[':employeeBirth'] = $employeeBirth;
            }
            if (isset($data['EmployeeAddress']) && trim($data['EmployeeAddress']) !== '') {
                $employeeAddress = $data['EmployeeAddress'];
                $query           .= ", EmployeeAddress = :employeeAddress";
                $params[':employeeAddress'] = $employeeAddress;
            }
            if (isset($data['EmployeePhone']) && trim($data['EmployeePhone']) !== '') {
                $employeePhone  = $data['EmployeePhone'];
                $query          .= ", EmployeePhone = :employeePhone";
                $params[':employeePhone'] = $employeePhone;
            }
            if (isset($data['EmployeePassword']) && trim($data['EmployeePassword']) !== '') {
                $employeePassword = $data['EmployeePassword'];
                $query            .= ", EmployeePassword = AES_ENCRYPT(:employeePassword,'@Empleado')";
                $params[':employeePassword'] = $employeePassword;
            }
            if (isset($data['EmployeeInsurance']) && trim($data['EmployeeInsurance']) !== '') {
                $employeeInsurance = $data['EmployeeInsurance'];
                $query             .= ", EmployeeInsurance = :employeeInsurance";
                $params[':employeeInsurance'] = $employeeInsurance;
            }
            $query .= " WHERE IdEmployee = :idEmployee";
            $params[':idEmployee'] = $idEmployee;
            
            $response = DBManager::query($query, $params);
            if ($response) {
                $query = "SELECT IdEmployee, EmployeeName, EmployeeLastName, EmployeeDegree, EmployeeBirth, EmployeeContractYear, EmployeeCharge, EmployeeAddress, EmployeePhone, EmployeeEmail, EmployeeInsurance, EmployeeRFC, AES_DECRYPT(EmployeePassword, '@Empleado') AS 'EmployeePassword', EmployeePhoto FROM personal WHERE IdEmployee = :idEmployee";
                $data = DBManager::query($query, array(':idEmployee' => $idEmployee));

                if ($data) {
                    $employeeData = $data[0];
                    $dataForToken = array(
                        'IdEmployee'    => $employeeData['IdEmployee'],
                        'EmployeeName'  => $employeeData['EmployeeName'].' '.$employeeData['EmployeeLastName'],
                        'EmployeeRFC'   => $employeeData['EmployeeRFC'],
                        'EmployeeEmail' => $employeeData['EmployeeEmail']
                    );
                    $employeeData['Token'] = TokenTool::createToken($dataForToken);
                    header(HTTP_CODE_205);
                    echo json_encode($employeeData);
                }
            } else {
                $connection->rollBack();
                header(HTTP_CODE_409);
            }
        } else {
            header(HTTP_CODE_401);
        }        

        break;

    default:
        header(HTTP_CODE_404);
        break;
}