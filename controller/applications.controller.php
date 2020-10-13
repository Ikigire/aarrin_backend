<?php
/**
* Controlador de funciones para tabla applications
*
* Manejo de acciones sobre la tabla applications
* Operaciones a utilizar y descripción a utilizar:

* Solicitar todas las aplicaciones en modo lista-> url: .../api/v1-2/applications/listview, metodo: GET, datos-solicitados: {}

* Solicitar las aplicaciones de una compañía-> url: .../api/v1-2/applications/company/:idCompany, metodo: GET, datos-solicitados: {}

* Solicitar la información de una aplicación-> url: .../api/v1-2/applications/get/:idApplication, metodo: GET, datos-solicitados: {}

* Crear una nueva aplicación-> url: .../api/v1-2/applications/add, metodo: POST, datos-solicitados: {IdCompany: int, IdContact: int, IdService: int, IdSector: int, AppLanguage: string, NumberEmployees: int, AppDetail: jsonString, AppComplement: jsonString}

* Editar la información de una aplicación-> url: .../api/v1-2/applications/edit/:idApplication, metodo: PUT, datos-solicitados: {data: jsonString}
*
* @author Yael Alejandro Santana Michel
* @author ya_el1995@hotmail.com
*
* @package ari-mobile-api
*/

/**
 * @var int $idApplication ID de la aplicación
 */
$idApplication = -1;

/**
 * @var int $idCompany ID de la compañia
 */
$idCompany = -1;

/**
 * @var int $idContact ID del contacto
 */
$idContact = -1;

/**
 * @var int $idService ID del servicio solicitado
 */
$idService = -1;

/**
 * @var int $idSector ID del sector al que pertenece la empresa
 */
$idSector = -1;

/**
 * @var string $appLanguage Lenguaje en la que será la auditoría
 */
$appLanguage = '';

/**
 * @var int $numberEmployees Número de empleados que tiene la empresa
 */
$numberEmployees = -1;

/**
 * @var array $appDetail Detalle de la aplicación
 */
$appDetail = array();

/**
 * @var array $appComplement Complemento de la aplicación
 */
$appComplement = array();

/**
 * @var string $lastCertificationStandard Estandar de la última certificación
 */
$lastCertificationStandard = '';

/**
 * @var string $lastCertificationExpire Fecha de la expiración de la última certificación
 */
$lastCertificationExpire = '';

/**
 * @var string $lastCertificationCertifier Nombre de la casa certificadora de la última certificación
 */
$lastCertificationCertifier = '';

/**
 * @var string $lastCertificationResults Resultados de la última certificación
 */
$lastCertificationResults = '';

/**
 * @var string $externalServicesProvider Proveedor de servicios externos
 */
$externalServicesProvider = '';

/**
 * @var string $receiveConsultancy Recibe consultoría
 */
$receiveConsultancy = '';

switch ($url[5]) {
    /**
     * Solicitar todas las aplicaciones en modo lista-> 
     * url: .../api/v1-2/applications/listview, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @return jsonString|null Todas las aplicaciones registradas
     */
    case 'listview':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }

        if (TokenTool::isValid($token)){
            $query = "SELECT app.IdApp, c.CompanyName, c.CompanyLogo, co.ContactName, co.ContactPhone, co.ContactEmail, co.ContactCharge, co.ContactPhoto, s.ServiceShortName, sec.IAF_MD5, sec.SectorCluster, sec.SectorCategory, sec.SectorSubcategory, sec.SectorRiskLevel, app.AppLanguage, app.LastCertificateStandard, app.LastCertificateExpiration, app.LastCertificateCertifier, app.LastCertificateResults, app.NumberEmployees, app.ExternalServicesProvider, app.ReceiveConsultancy, app.ConsultantName, app.AppDate, app.AppStatus FROM applications AS app JOIN companies AS c ON app.IdCompany = c.IdCompany JOIN contacts AS co on app.IdContact = co.IdContact JOIN services as s ON app.IdService = s.IdService JOIN sectors As sec ON app.IdSector = sec.IdSector ORDER BY app.AppDate DESC;";

            $data = DBManager::query($query);
            if ($data) {
                header(HTTP_CODE_200);
                echo json_encode($data);
            } else {
                header(HTTP_CODE_204);
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;

    /**
     * * Solicitar las aplicaciones de una compañía-> 
     * url: .../api/v1-2/applications/company/:idCompany, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @param int idCompany Id de la compañía
     * @return jsonString Todas las applicaciones de la compañía
     */
    case 'company':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }

        if (!isset($url[6])) {
            header(HTTP_CODE_412);
            exit();
        }
        $idCompany = (int) $url[6];

        if (TokenTool::isValid($token)){
            $query = "SELECT app.IdApp, c.CompanyName, c.CompanyLogo, co.ContactName, co.ContactPhone, co.ContactEmail, co.ContactCharge, co.ContactPhoto, s.ServiceShortName, sec.IAF_MD5, sec.SectorCluster, sec.SectorCategory, sec.SectorSubcategory, sec.SectorRiskLevel, app.AppLanguage, app.LastCertificateStandard, app.LastCertificateExpiration, app.LastCertificateCertifier, app.LastCertificateResults, app.NumberEmployees, app.ExternalServicesProvider, app.ReceiveConsultancy, app.ConsultantName, app.AppDate, app.AppStatus FROM applications AS app JOIN companies AS c ON app.IdCompany = c.IdCompany JOIN contacts AS co on app.IdContact = co.IdContact JOIN services as s ON app.IdService = s.IdService JOIN sectors As sec ON app.IdSector = sec.IdSector WHERE app.IdCompany = :idCompany ORDER BY app.AppDate DESC;";

            $params = array(':idCompany' => $idCompany);

            $data = DBManager::query($query, $params);

            if ($data) {
                header(HTTP_CODE_200);
                echo json_encode($data);
            } else {
                header(HTTP_CODE_204);
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;

    /**
     * Solicitar la información de una aplicación-> 
     * url: .../api/v1-2/applications/get/:idApplication, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @param int IdApplication ID de la aplicación solicitada, deberá ir al final de la url
     * @return jsonString|null La applicación con ese ID, 
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
        $idApplication = (int) $url[6];

        if (TokenTool::isValid($token)){
            $query ="SELECT IdApp, IdCompany, IdContact, IdService, IdSector, AppLanguage, LastCertificateStandard, LastCertificateExpiration, LastCertificateCertifier, LastCertificateResults, NumberEmployees, ExternalServicesProvider, ReceiveConsultancy, ConsultantName, AppComplement, AppDetail, AppDate, AppStatus FROM applications WHERE IdApp = :idApplication;";

            $params = array(':idApplication' => $idApplication);

            $data = DBManager::query($query, $params);
            if ($data) {
                $appData = $data[0];
                $appData['AppDetail'] = json_decode($appData['AppDetail']);
                $appData['AppComplement'] = json_decode($appData['AppComplement']);
                header(HTTP_CODE_200);
                echo json_encode($appData);
            } else {
                header(HTTP_CODE_204);
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;

    /**
     * Crear una nueva aplicación-> 
     * url: .../api/v1-2/applications/add, 
     * metodo: POST, 
     * datos-solicitados: {IdCompany: int, IdContact: int, IdService: int, IdSector: int, AppLanguage: string, NumberEmployees: int, AppDetail: jsonString, AppComplement: jsonString}
     */
    case 'add':
        if ($method !== 'POST') {
            header('HTTP/1.1 405 Allow: POST');
            exit();
        }

        if (TokenTool::isValid($token)){
            if (isset($_POST['IdCompany']) && isset($_POST['IdContact']) && isset($_POST['IdService']) && isset($_POST['IdSector']) && isset($_POST['AppLanguage']) && isset($_POST['NumberEmployees']) && isset($_POST['AppDetail']) && isset($_POST['AppComplement'])) {
                $idCompany = $_POST['IdCompany'];
                $idContact = $_POST['IdContact'];
                $idService = $_POST['IdService'];
                $idSector = $_POST['IdSector'];
                $appLanguage = $_POST['AppLanguage'];
                $numberEmployees = $_POST['NumberEmployees'];
                $date = new DateTime("now");
                $currentDate = $date->format('Y-m-d H:i:s');

                $appDetail = $_POST['AppDetail'];
                $appComplement = $_POST['AppComplement'];

                $params = array(
                    ':idCompany' => $idCompany,
                    ':idContact' => $idContact,
                    ':idService' => $idService,
                    ':idSector' => $idSector,
                    ':appLanguage' => $appLanguage,
                    ':numberEmployees' => $numberEmployees,
                    ':currentDate' => $currentDate,
                    ':appDetail' => $appDetail,
                    ':appComplement' => $appComplement
                );

                $initialPart = "INSERT INTO applications (IdCompany, IdContact, IdService, IdSector, AppLanguage, NumberEmployees, AppDate, AppDetail, AppComplement";
                $values = "VALUES (:idCompany, :idContact, :idService, :idSector, :appLanguage, :numberEmployees, :currentDate, :appDetail, :appComplement";
                if (isset($_POST['LastCertificateStandard'])) {
                    $params[':lastCertificateStandard'] = $_POST['LastCertificateStandard'];
                    $initialPart .= ", LastCertificateStandard";
                    $values .= ", :lastCertificateStandard";
                }
                
                if (isset($_POST['LastCertificateExpiration'])) {
                    $params[':lastCertificateExpiration'] = $_POST['LastCertificateExpiration'];
                    $initialPart .= ", LastCertificateExpiration";
                    $values .= ", :lastCertificateExpiration";
                }
                
                if (isset($_POST['LastCertificateCertifier'])) {
                    $params[':lastCertificateCertifier'] = $_POST['LastCertificateCertifier'];
                    $initialPart .= ",LastCertificateCertifier";
                    $values .= ", :lastCertificateCertifier";
                }
                
                if (isset($_POST['LastCertificateResults'])) {
                    $params[':lastCertificateResults'] = $_POST['LastCertificateResults'];
                    $initialPart .= ", LastCertificateResults";
                    $values .= ", :lastCertificateResults";
                }
                
                if (isset($_POST['ExternalServicesProvider'])) {
                    $params[':externalServicesProvider'] = $_POST['ExternalServicesProvider'];
                    $initialPart .= ", ExternalServicesProvider";
                    $values .= ", :externalServicesProvider";
                }
                
                if (isset($_POST['ReceiveConsultancy'])) {
                    $params[':receiveConsultancy'] = '1';
                    $params[':consultantName'] = $_POST['ConsultantName'];
                    $initialPart .= ", ReceiveConsultancy, ConsultantName";
                    $values .= ", :receiveConsultancy, :consultantName";
                }

                $query = $initialPart . ") " . $values . ");";

                $response = DBManager::query($query, $params);
                if ($response) {
                    header(HTTP_CODE_201);
                    echo json_encode(array('IdApplication' => $response));
                }else {
                    header(HTTP_CODE_409);
                }
            } else {
                header(HTTP_CODE_412);
            }
            exit();
        } else {
            header(HTTP_CODE_401);
        }
        break;


    /**
     * Editar la información de una aplicación-> 
     * url: .../api/v1-2/applications/edit/:idApplication, 
     * metodo: PUT, 
     * datos-solicitados: {data: jsonString}
     * @param int idAplication ID de la aplicación a editar
     * @return jsonString resultado de la operación
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
        $idApplication = (int) $url[6];

        if (!isset($_GET['data'])) {
            header(HTTP_CODE_412);
            exit();
        }

        $data = json_decode($_GET['data'], true);

        if (TokenTool::isValid($token)){
            $idContact = $data['IdContact'];
            $idService = $data['IdService'];
            $idSector = $data['IdSector'];
            $appLanguage = $data['AppLanguage'];
            $numberEmployees = $data['NumberEmployees'];

            $appDetail = $data['AppDetail'];
            $appComplement = $data['AppComplement'];

            $params = array(
                ':idApplication' => $idApplication,
                ':idCompany' => $idCompany,
                ':idContact' => $idContact,
                ':idService' => $idService,
                ':idSector' => $idSector,
                ':appLanguage' => $appLanguage,
                ':numberEmployees' => $numberEmployees,
                ':currentDate' => $currentDate,
                ':appDetail' => json_encode($appDetail),
                ':appComplement' => json_encode($appComplement)
            );

            $query = "UPDATE applications SET IdSector = :idSector, AppLanguage = :appLanguage, NumberEmployees = :numberEmployees";

            if (isset($data['LastCertificateStandard'])) {
                $params[':lastCertificateStandard'] = $data['LastCertificateStandard'];
                $query .= ", LastCertificateStandard = :lastCertificateStandard";
            }
            
            if (isset($data['LastCertificateExpiration'])) {
                $params[':lastCertificateExpiration'] = $data['LastCertificateExpiration'];
                $query .= ", LastCertificateExpiration = :lastCertificateExpiration";
            }
            
            if (isset($data['LastCertificateCertifier'])) {
                $params[':lastCertificateCertifier'] = $data['LastCertificateCertifier'];
                $query .= ",LastCertificateCertifier = :lastCertificateCertifier";
            }
            
            if (isset($data['LastCertificateResults'])) {
                $params[':lastCertificateResults'] = $data['LastCertificateResults'];
                $query .= ", LastCertificateResults = :lastCertificateResults";
            }
            
            if (isset($data['ExternalServicesProvider'])) {
                $params[':externalServicesProvider'] = $data['ExternalServicesProvider'];
                $query .= ", ExternalServicesProvider = :externalServicesProvider";
            }
            
            if (isset($data['ReceiveConsultancy'])) {
                $params[':receiveConsultancy'] = $data['ReceiveConsultancy'];
                $params[':consultantName'] = $data['ConsultantName'];
                $query .= ", ReceiveConsultancy = :receiveConsultancy, ConsultantName = :consultantName";
            }

            if (isset($data['AppStatus'])) {
                $params[':appStatus'] = $data['AppStatus'];
                $query .= ", AppStatus = :appStatus";
            }

            $query .= " WHERE IdApp = :idApplication;";
            if (DBManager::query($query, $params)){
                header(HTTP_CODE_205);
                echo json_encode(array('result' => 'Updated'));
            }else {
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