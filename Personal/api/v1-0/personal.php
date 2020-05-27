<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Allow: GET, POST, OPTIONS, PUT, PATCH, DELETE");
    include("../../../Config/Connection.php");

    switch ($_SERVER['REQUEST_METHOD']) {
/**-----Get request (request of the whole information or just one of them; all data in the table) ----------------------------------------------------------------*/
        case 'GET':
            if(isset($_GET['email']) && isset($_GET['password'])){//If is a request to log-in
                $employeeEmail = $_GET['email'];
                $employeePassword = $_GET['password'];
                $query = "SELECT IdEmployee, EmployeeName, EmployeeLastName, EmployeeDegree, EmployeeBirth, EmployeeContractYear, EmployeeCharge, EmployeeAddress, EmployeePhone, EmployeeEmail, EmployeeInsurance, EmployeeRFC, AES_DECRYPT(EmployeePassword, '@Empleado') AS 'EmployeePassword', EmployeePhoto FROM personal WHERE EmployeeEmail = '$employeeEmail' AND EmployeePassword = AES_ENCRYPT('$employeePassword','@Empleado') AND EmployeeStatus = 'Active'";
                $consult = $dbConnection->prepare($query); //this line prepare the query for execute
                $consult->execute();
                if($consult->rowCount()){//if is there any result for the query then
                    $consult->setFetchMode(PDO::FETCH_ASSOC); //sets the fetch mode in association for the best way to put the data
                    $employeeData = $consult->fetchAll()[0];

                    $dataForToken = array(
                        'IdEmployee' => $employeeData['IdEmployee'],
                        'EmployeeName' => $employeeData['EmployeeName'].' '.$employeeData['EmployeeLastName'],
                        'EmployeeRFC' => $employeeData['EmployeeRFC'],
                        'EmployeeEmail' => $employeeData['EmployeeEmail']
                    );
                    $employeeData['Token'] = TokenTool::createToken($dataForToken);
                    header("HTTP/1.0 202 Accepted"); //this indicates to the client that the request was accepted
                    header('Content-Type: application/json'); //now define the content type to get back
                    echo json_encode($employeeData); //to finalize the server return the data
                    exit();
                }else{//if there isn't any result for the query
                    header("HTTP/1.0 404 Not found");//the server advice to not found result
                    exit();
                }
            }elseif(isset($_GET['idEmployee']) && isset($_GET['t'])){
                if (TokenTool::isValid($_GET['t'])) {
                    $idEmployee = $_GET['idEmployee'];
                    $query = "SELECT IdEmployee, EmployeeName, EmployeeLastName, EmployeeDegree, EmployeeBirth, EmployeeContractYear, EmployeeCharge, EmployeeAddress, EmployeePhone, EmployeeEmail, EmployeeInsurance, EmployeeRFC, AES_DECRYPT(EmployeePassword, '@Empleado') AS 'EmployeePassword', EmployeePhoto, EmployeeStatus FROM personal WHERE IdEmployee = $idEmployee";
                    $consult = $dbConnection->prepare($query); //this line prepare the query for execute
                    $consult->execute(); //execute the query
                    if ($consult->rowCount()) {
                        $consult->setFetchMode(PDO::FETCH_ASSOC); //sets the fetch mode in association for the best way to put the data
                        header("HTTP/1.0 202 Accepted"); //this indicates to the client that the request was accepted
                        header('Content-Type: application/json'); //now define the content type to get back
                        $employeeData = $consult->fetchAll()[0];
                        $dataForToken = array(
                            'IdEmployee' => $employeeData['IdEmployee'],
                            'EmployeeName' => $employeeData['EmployeeName'].' '.$employeeData['EmployeeLastName'],
                            'EmployeeRFC' => $employeeData['EmployeeRFC'],
                            'EmployeeEmail' => $employeeData['EmployeeEmail']
                        );
                        $employeeData['Token'] = TokenTool::createToken($dataForToken);
                        echo json_encode($employeeData); //to finalize the server return the data
                    } else {
                        header("HTTP/1.0 404 Not found");
                    }
                } else {
                    header("HTTP/1.0 401 Unauthorized");
                }
            }else{/**email doesn't exist, then it's a request for the whole information */
                if (isset($_GET['t']) && TokenTool::isValid($_GET['t'])){
                    $query = "SELECT IdEmployee, EmployeeName, EmployeeLastName, EmployeeDegree, EmployeeBirth, EmployeeContractYear, EmployeeCharge, EmployeeAddress, EmployeePhone, EmployeeEmail, EmployeeInsurance, EmployeeRFC, EmployeePhoto, EmployeeStatus FROM personal ORDER BY EmployeeLastName, EmployeeName;";
                    $consult = $dbConnection->prepare($query);//this line prepare the query for execute
                    $consult->execute();//execute the query
                    if ($consult->rowCount()) {
                        $consult->setFetchMode(PDO::FETCH_ASSOC); //sets the fetch mode in association for the best way to put the data
                        header("HTTP/1.0 202 Accepted"); //this indicates to the client that the request was accepted
                        header('Content-Type: application/json'); //now define the content type to get back
                        echo json_encode($consult->fetchAll()); //to finalize the server return the data
                    }else{
                        header("HTTP/1.0 409 Conflict with the Server");//the server advice to not found result
                    }
                }
                else {
                    header("HTTP/1.0 401 Unauthorized");
                }
                exit();
            }
            break;


/**-----Post request (request for create a new employee (Admin)) --------------------------------------------------------------------------------------------------------------------*/
        case 'POST':
            if(isset($_POST['name']) && isset($_POST['lastname']) && isset($_POST['contract']) && isset($_POST['charge']) && isset($_POST['email']) && isset($_POST['rfc']) && isset($_POST['t'])){
                if (TokenTool::isValid($_POST['t'])){
                    //get the sended data
                    $employeeName = $_POST['name'];
                    $employeeLastName = $_POST['lastname'];
                    $employeeContractYear = $_POST['contract'];
                    $employeeCharge = $_POST['charge'];
                    $employeeEmail = $_POST['email'];
                    $employeeRFC = $_POST['rfc'];
                    
                    $STR = 'QWERTYUIOPASDFGHJKLZXCVBNM0123456789/*-+.$?';
                    $employeePassword = '';

                    for ($i=0; $i < 8; $i++) {
                        $employeePassword .= substr($STR, rand(0,42),1);
                    }

                    $query = "INSERT INTO personal(EmployeeName, EmployeeLastName, EmployeeDegree, EmployeeBirth, EmployeeContractYear, EmployeeCharge, EmployeeAddress, EmployeePhone, EmployeeEmail, EmployeeInsurance, EmployeeRFC, EmployeePassword) VALUES ('$employeeName', '$employeeLastName', '', '0000-00-00', $employeeContractYear, '$employeeCharge', '', '', '$employeeEmail', '', '$employeeRFC', AES_ENCRYPT('$employeePassword','@Empleado'));";

                    $dbConnection->beginTransaction();//starts a transaction in the database
                    $insert = $dbConnection->prepare($query);//prepare the statement
                    try{//try to complete the insertion
                        $insert->execute();//execute the statement
                        $array = array('IdEmployee' => $dbConnection->lastInsertId());
                        $dbConnection->commit(); //it's everything ok
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
                        header("HTTP/1.0 200 Created"); //this indicates to the client that the new record
                        header('Content-Type: application/json');
                        echo json_encode($array);
                    }catch (Exception $e){//the insertion fails then
                        $dbConnection->rollBack();//get back the database
                        header("HTTP/1.0 409 Conflict with the Server");//info for the client
                    }
                }
                else{
                    header("HTTP/1.0 401 Unauthorized");
                }
                exit();
            }
            else{
                header("HTTP/1.0 412 Precondition Failed"); //the request don't complete the preconditions
                exit();
            }
            break;


/**-----Put request (request for change information in the table) -----------------------------------------------------------------------------------------------------------*/
        case 'PUT':
            if (isset($_GET['idEmployee']) && isset($_GET['name']) && isset($_GET['lastname']) && isset($_GET['contract']) && isset($_GET['charge']) && isset($_GET['email']) && isset($_GET['rfc']) && isset($_GET['t'])) {
                if (TokenTool::isValid($_GET['t'])){
                    //get the sended data
                    $idEmployee = $_GET['idEmployee'];
                    $employeeName = $_GET['name'];
                    $employeeLastName = $_GET['lastname'];
                    $employeeContractYear = $_GET['contract'];
                    $employeeCharge = $_GET['charge'];
                    $employeeEmail = $_GET['email'];
                    $employeeRFC = $_GET['rfc'];

                    $query = "UPDATE personal SET EmployeeName = '$employeeName', EmployeeLastName = '$employeeLastName', EmployeeContractYear = $employeeContractYear, EmployeeCharge = '$employeeCharge', EmployeeEmail = '$employeeEmail', EmployeeRFC = '$employeeRFC'";
                    if (isset($_GET['degree']) && trim($_GET['degree']) !== '') {
                        $employeeDegree = $_GET['degree'];
                        $query .= ", EmployeeDegree = '$employeeDegree'";
                    }
                    if (isset($_GET['birth']) && trim($_GET['birth']) !== '') {
                        $employeeBirth = $_GET['birth'];
                        $query .= ", EmployeeBirth = '$employeeBirth'";
                    }
                    if (isset($_GET['address']) && trim($_GET['address']) !== '') {
                        $employeeAddress = $_GET['address'];
                        $query .= ", EmployeeAddress = '$employeeAddress'";
                    }
                    if (isset($_GET['phone']) && trim($_GET['phone']) !== '') {
                        $employeePhone = $_GET['phone'];
                        $query .= ", EmployeePhone = '$employeePhone'";
                    }
                    if (isset($_GET['password']) && trim($_GET['password']) !== '') {
                        $employeePassword = $_GET['password'];
                        $query .= ", EmployeePassword = AES_ENCRYPT('$employeePassword','@Empleado')";
                    }
                    if (isset($_GET['insurance']) && trim($_GET['insurance']) !== '') {
                        $employeeInsurance = $_GET['insurance'];
                        $query .= ", EmployeeInsurance = '$employeeInsurance'";
                    }
                    $query .= " WHERE IdEmployee = $idEmployee";
                    $dbConnection->beginTransaction();//starts a transaction in the database
                    $update = $dbConnection->prepare($query);//prepare the statement
                    try {//try to complete the modification
                        $update->execute();//execute the statement
                        $dbConnection->commit();//it's everything ok
                        $query = "SELECT IdEmployee, EmployeeName, EmployeeLastName, EmployeeDegree, EmployeeBirth, EmployeeContractYear, EmployeeCharge, EmployeeAddress, EmployeePhone, EmployeeEmail, EmployeeInsurance, EmployeeRFC, AES_DECRYPT(EmployeePassword, '@Empleado') AS 'EmployeePassword', EmployeePhoto FROM personal WHERE IdEmployee = $idEmployee";
                        $consult = $dbConnection->prepare($query); //this line prepare the query for execute
                        $consult->execute(); //execute the query
                        $consult->setFetchMode(PDO::FETCH_ASSOC); //sets the fetch mode in association for the best way to put the data
                        header('Content-Type: application/json'); //now define the content type to get back
                        $employeeData = $consult->fetchAll()[0];
                        $dataForToken = array(
                            'IdEmployee' => $employeeData['IdEmployee'],
                            'EmployeeName' => $employeeData['EmployeeName'].' '.$employeeData['EmployeeLastName'],
                            'EmployeeRFC' => $employeeData['EmployeeRFC'],
                            'EmployeeEmail' => $employeeData['EmployeeEmail']
                        );
                        $employeeData['Token'] = TokenTool::createToken($dataForToken);
                        echo json_encode($employeeData);
                        header("HTTP/1.0 200 Modified"); //this indicates to the client that the reecord was modified
                    }catch (Exception $e) {//the modification fails then
                        $dbConnection->rollBack();//get back the database
                        header("HTTP/1.0 409 Conflict with the Server");//info for the client
                    }
                }else {
                    header("HTTP/1.0 401 Unauthorized");
                }
            }
            else{
                header("HTTP/1.0 412 Precondition Failed"); //the request don't complete the preconditions
            }
            exit();
            break;


/**-----Patch request (request for change employee status in the table) -----------------------------------------------------------------------------------------------------------*/
        case 'PATCH':
            if(isset($_GET['employee']) && isset($_GET['t'])){
                if (TokenTool::isValid($_GET['t'])){
                    header('Content-Type: application/json');
                    $idEmployee = $_GET['employee'];
                    
                    //Code for change the employee status
                    $query = "UPDATE personal SET EmployeeStatus = 'Inactive' WHERE IdEmployee = $idEmployee";
                    $dbConnection->beginTransaction();//starts a transaction in the database
                    $update = $dbConnection->prepare($query);//prepare the statement
                    try {//try to complete the modification
                        $update->execute();//execute the statement
                        $dbConnection->commit();//it's everything ok
                        header("HTTP/1.0 200 Modified"); //this indicates to the client that the reecord was modified
                        $query = "SELECT IdEmployee, EmployeeName, EmployeeLastName, EmployeeDegree, EmployeeBirth, EmployeeContractYear, EmployeeCharge, EmployeeAddress, EmployeePhone, EmployeeEmail, EmployeeInsurance, EmployeeRFC, AES_DECRYPT(EmployeePassword, '@Empleado') AS 'EmployeePassword', EmployeePhoto, EmployeeStatus FROM personal WHERE IdEmployee = $idEmployee";
                        $consult = $dbConnection->prepare($query); //this line prepare the query for execute
                        $consult->execute();
                        $consult->setFetchMode(PDO::FETCH_ASSOC); //sets the fetch mode in association for the best way to put the data
                        $employeeData = $consult->fetchAll()[0];
                        echo json_encode($employeeData);
                    }catch (Exception $e) {//the modification fails then
                        $dbConnection->rollBack();//get back the database
                        header("HTTP/1.0 409 Conflict with the Server");//info for the client
                    }
                }
                else{
                    header("HTTP/1.0 401 Unauthorized");
                }
                exit();
            }
            else{
                header("HTTP/1.0 412 Precondition Failed"); //the request don't complete the preconditions
                exit();
            }
            break;

        case 'OPTIONS':
            header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, PATCH, DELETE");
            header("Allow: GET, POST, OPTIONS, PUT, PATCH, DELETE");
            break;
        
        default:
            header("HTTP/1.0 405 Allow; GET, POST, PUT, PATCH");
            exit();
            break;
    }
