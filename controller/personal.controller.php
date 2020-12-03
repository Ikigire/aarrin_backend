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
     * @return jsonString|null Token de sesión para el empleado en donde van incluidos sus datos
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

                $employeeData['Token'] = TokenTool::createToken($employeeData);
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
                                                <p style='font:10px verdana,Helvetica,arial,sans-serif; color:rgb(0,0,0); margin:0px 0px 2px'>This is an auto-generated mail, please don't <strong style='color: red;'>respond it.</strong></p>
                                                </div>
                                                <div style='text-align:center; width:100%; max-width:324px; vertical-align:top; display:inline-block'>
                                                <p style='font:10px verdana,Helvetica,arial,sans-serif; color:rgb(0,0,0); margin:0px'>Add <a href='mailto:web_app@aarrin.com' target='_blank' rel='noopener noreferrer' data-auth='NotApplicable' style='color:rgb(68,68,68)'>web_app@aarrin.com</a> to your contacts</p>
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
                    
                                                <div style='margin:20px 0px'>
                                                    <a href='https://aarrin.com/register' target='_blank' rel='noopener noreferrer' data-auth='NotApplicable' style='background-color: #3D5E6A; color:rgb(255,255,255); text-transform:uppercase; font:bold 16px arial,Helvetica,sans-serif; padding:12px 54px; text-decoration:none'>Finish your registration now!</a>
                                                </div>
                                                <div style='margin:40px auto; width:100%; max-width:648px; font-size:0px; display:block; text-align:center'>
                                                    <div style='display:inline-block; width:100%; max-width:624px; height:300px; vertical-align:top; background-color:rgb(224,228,237)'>
                                                        <table align='center' width='100%' cellspacing='0' cellpadding='0' border='0'>
                                                            <tbody>
                                                                <tr>
                                                                    <td height='300' align='center' bgcolor='#e0e4ed'>
                                                                        <p style='font:bold 30px arial,sans-serif; color:rgb(76, 76, 77); margin:0px 0px 15px'>Use your <span style='color:rgb(189,12,14)'>email</span> and the next <span style='color:rgb(189,12,14)'>password</span> to enter to control panel of <a href='http://' target='_blank' style='color: red;'
                                                                                rel='noopener noreferrer'>Aarrin.com</a> website. <br></p>
                                                                        <p style='font:bold 19px arial,sans-serif; color:rgb(15, 36, 71); margin:10px 0px 15px'>This password was autogenerated and will be changed by you</p>
                                                                        <p rel='noopener noreferrer' style='background-color:rgb(255, 255, 255); color:rgb(46, 46, 46); text-transform:uppercase; font:bold 19px arial,sans-serif; padding:10px 35px; text-decoration:none; display:inline-block'>$employeePassword</p>
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
                    mail($employeeEmail, $subject, $message, $headers);
                    header(HTTP_CODE_201);
                    echo json_encode(array('IdEmployee' => $response));
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
                
                if (move_uploaded_file($f['tmp_name'], __DIR__. "/../../app_resources/personal/$name")){
                    $query = "UPDATE personal SET EmployeePhoto = :path WHERE IdEmployee = :idEmployee";
                    $response = DBManager::query($query, array(':path' => $path, ':idEmployee' => $idEmployee));

                    if ($response) {
                        $query = "SELECT IdEmployee, EmployeeName, EmployeeLastName, EmployeeDegree, EmployeeBirth, EmployeeContractYear, EmployeeCharge, EmployeeAddress, EmployeePhone, EmployeeEmail, EmployeeInsurance, EmployeeRFC, AES_DECRYPT(EmployeePassword, '@Empleado') AS 'EmployeePassword', EmployeePhoto FROM personal WHERE IdEmployee = :idEmployee";
                        $data = DBManager::query($query, array('idEmployee' => $idEmployee));

                        $employeeData = $data[0];

                        $employeeData['Token'] = TokenTool::createToken($employeeData);
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
     * datos-solicitados. {data: jsonString} deberá ir en el cuerpo de la solicitud
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

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data)){
            header(HTTP_CODE_412);
            exit();
        }

        if (TokenTool::isValid($token)){
            $employeeName           = $data['EmployeeName'];
            $employeeLastName       = $data['EmployeeLastName'];
            $employeeContractYear   = $data['EmployeeContractYear'];
            $employeeCharge         = $data['EmployeeCharge'];
            $employeeEmail          = $data['EmployeeEmail'];
            $employeeRFC            = $data['EmployeeRFC'];
            $employeeStatus         = $data['EmployeeStatus'];

            $params = array(
                ':employeeName'         => $employeeName,
                ':employeeLastName'     => $employeeLastName,
                ':employeeContractYear' => $employeeContractYear,
                ':employeeCharge'       => $employeeCharge,
                ':employeeEmail'        => $employeeEmail,
                ':employeeRFC'          => $employeeRFC,
                ':employeeStatus'       => $employeeStatus
            );

            $query = "UPDATE personal SET EmployeeName = :employeeName, EmployeeLastName = :employeeLastName, EmployeeContractYear = :employeeContractYear, EmployeeCharge = :employeeCharge, EmployeeEmail = :employeeEmail, EmployeeRFC = :employeeRFC, EmployeeStatus = :employeeStatus";
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

                    $employeeData['Token'] = TokenTool::createToken($employeeData);
                    header(HTTP_CODE_200);
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