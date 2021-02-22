<?php
/**
* Controlador de funciones para tabla sectors
*
* Manejo de acciones sobre la tabla sectors
* Operaciones a utilizar y descripción a utilizar:

* Solicitar todos los sectores-> url: .../api/v1-2/sectors/all, metodo: GET, datos-solicitados: {}

* Solicitar todos los sectores para un cierto ISO-> url: .../api/v1-2/sectors/iso/:sectorISO, metodo: GET, datos-solicitados: {}

* Solicitar datos completos de un sector-> url: .../api/v1-2/sectors/get/:idSector, metodo: GET, datos-solicitados: {}

* Crear un nuevo sector-> url: .../api/v1-2/sectors/add, metodo: POST, datos-solicitados: {category: string, iso: string, iaf?: int, cluster?: string, subcategory?: string, risklevel?; string} (? es opcional)

* Editar los datos de un sector-> url: .../api/v1-2/sectors/edit/:idService, metodo: PUT, datos-solicitados: {data: jsonString}
*
* @author Yael Alejandro Santana Michel
* @author ya_el1995@hotmail.com
*
* @package ari-mobile-api
*/

/**
 * @var int $idSector ID del sector
 */
$idSector = -1;

/**
 * @var string $sectorCategory La categoría del sector
 */
$sectorCategory = '';

/**
 * @var string $sectorISO ISO shortname al que corresponde
 */
$sectorISO = '';

/**
 * @var int $IAF_MD5 Número de seguimiento
 */
$IAF_MD5 = -1;

/**
 * @var string $sectorCluster Nombre del Cluster del sector
 */
$sectorCluster = '';

/**
 * @var string $sectorSubcategory Nombre de la subcategoría del sector
 */
$sectorSubcategory = '';

/**
 * @var string $sectorRiskLevel Nivel de riesgo del sector
 */
$sectorRiskLevel = '';


switch ($url[5]) {
    /**
     * Solicitar todos los sectores-> 
     * url: .../api/v1-2/sectors/all, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @return jsonString Todos los registros
     */
    case 'all':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }

        if (TokenTool::isValid($token)){
            $query = "SELECT IdSector, SectorISO, IAF_MD5, SectorCluster, SectorCategory, SectorSubcategory, SectorRiskLevel, SectorStatus FROM sectors ORDER BY SectorISO";
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
     * Solicitar todos los sectores para un cierto ISO-> 
     * url: .../api/v1-2/sectors/iso/:sectorISO, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @param string sectorISO ISO de los sectores a buscar, deberá ir al final de la url
     * @return jsonString Todos los registros
     */
    case 'iso':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }

        if (!isset($url[6])){
            header(HTTP_CODE_412);
            exit();
        }
        $sectorISO = $url[6];

        $query = "SELECT IdSector, IAF_MD5, SectorCluster, SectorCategory, SectorSubcategory, SectorRiskLevel FROM sectors WHERE SectorStatus = 'Active' AND SectorISO = :sectorISO ORDER BY IAF_MD5, SectorRiskLevel, SectorCategory, SectorSubcategory, SectorCluster";
        $data = DBManager::query($query, array(':sectorISO' => $sectorISO));

        if ($data) {
            header(HTTP_CODE_200);
            echo json_encode($data);
        }else{
            header(HTTP_CODE_204);
        }
        break;


    /**
     * * Solicitar datos completos de un sector-> 
     * url: .../api/v1-2/sectors/get/:idSector, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @param int IdSector- Id del sector, el cual deberá ir al final de la URL
     * @return jsonString|null Los datos del sector con ese ID, 
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
        $idSector = (int) $url[6];

        if (TokenTool::isValid($token)){
            $query = "SELECT IdSector, SectorISO, IAF_MD5, SectorCluster, SectorCategory, SectorSubcategory, SectorRiskLevel, SectorStatus FROM sectors  WHERE IdSector = :id";
            $data = DBManager::query($query, array(':id' => $idSector));

            if ($data) {
                header(HTTP_CODE_200);
                $sectorData = $data[0];
                echo json_encode($sectorData);
            } else {
                header(HTTP_CODE_204);
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;


    /**
     * Crear un nuevo sector-> 
     * url: .../api/v1-2/sectors/add, 
     * metodo: POST, 
     * datos-solicitados: {category: string, iso: string, iaf?: int, cluster?: string, subcategory?: string, risklevel?; string} (? es opcional)
     */
    case 'add':
        if ($method !== 'POST') {
            header('HTTP/1.1 405 Allow: POST');
            exit();
        }

        if (TokenTool::isValid($token)){
            if(isset($_POST['category']) && isset($_POST['iso'])){
                $sectorCategory = $_POST['category'];
                $sectorISO      = $_POST['iso'];

                $params = array(
                    ':sectorCategory' => $sectorCategory,
                    ':sectorISO'      => $sectorISO,
                );

                $init = "INSERT INTO sectors (SectorISO, SectorCategory";
                $values = "VALUES (:sectorISO, :sectorCategory";

                if (isset($_POST['iaf'])) {
                    $IAF_MD5        = $_POST['iaf'];
                    $init           .= ", IAF_MD5";
                    $values         .=", :iaf";
                    $params[':iaf'] = $IAF_MD5;
                }
                if (isset($_POST['cluster'])) {
                    $sectorCluster      = $_POST['cluster'];
                    $init               .= ", SectorCluster";
                    $values             .= ", :cluster";
                    $params[':cluster'] = $sectorCluster;
                }
                if (isset($_POST['subcategory'])) {
                    $sectorSubcategory      = $_POST['subcategory'];
                    $init                   .= ", SectorSubcategory";
                    $values                 .= ", :subcategory";
                    $params[':subcategory'] = $sectorSubcategory;
                }
                if (isset($_POST['risklevel'])) {
                    $sectorRiskLevel      = $_POST['risklevel'];
                    $init                 .= ", SectorRiskLevel";
                    $values               .= ", :riskLevel";
                    $params[':riskLevel'] = $sectorRiskLevel;
                }

                $query = $init. ") ". $values. ");";
                $response = DBManager::query($query, $params);
                if ($response) {
                    header(HTTP_CODE_201);
                    echo json_encode(array('IdSector' => $response));
                }else {
                    header(HTTP_CODE_409);
                }
                exit();
            }
            else{
                header(HTTP_CODE_412);
                exit();
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;


    /**
     * Editar los datos de un sector-> 
     * url: .../api/v1-2/sectors/edit/:idService, 
     * metodo: PUT, 
     * datos-solicitados: {data: jsonString}
     * @param int idsector Id del sector, deberá ir al final de url
     * @return jsonString Datos actualizados del sector ya actualizados
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
        $idSector = (int) $url[6];

        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data)) {
            header(HTTP_CODE_412);
            exit();
        }

        if (TokenTool::isValid($token)){
            $sectorCategory = $data['SectorCategory'];
            $sectorISO      = $data['SectorISO'];

            $params = array(
                ':idSector'       => $idSector,
                ':sectorCategory' => $sectorCategory,
                ':sectorISO'      => $sectorISO,
            );

            $query = "UPDATE sectors SET SectorISO = :sectorISO, SectorCategory = :sectorCategory";

            if (isset($data['IAF_MD5'])) {
                $IAF_MD5        = $data['IAF_MD5'];
                $query         .= ", IAF_MD5 = :iaf";
                $params[':iaf'] = $IAF_MD5;
            }
            if (isset($data['SectorCluster'])) {
                $sectorCluster            = $data['SectorCluster'];
                $query                   .= ", SectorCluster = :sectorCluster";
                $params[':sectorCluster'] = $sectorCluster;
            }
            if (isset($data['SectorSubcategory'])) {
                $sectorSubcategory            = $data['SectorSubcategory'];
                $query                       .= ", SectorSubcategory = :sectorSubcategory";
                $params[':sectorSubcategory'] = $sectorSubcategory;
            }
            if (isset($data['SectorRiskLevel'])) {
                $sectorRiskLevel            = $data['SectorRiskLevel'];
                $query                     .= ", SectorRiskLevel = :sectorRiskLevel";
                $params[':sectorRiskLevel'] = $sectorRiskLevel;
            }
            if (isset($data['SectorStatus'])) {
                $sectorStatus            = $data['SectorStatus'];
                $query                  .= ", SectorStatus = :sectorStatus";
                $params[':sectorStatus'] = $sectorStatus;
            }

            $query .= " WHERE IdSector = :idSector;";
            
            if (DBManager::query($query, $params)){
                $query = "SELECT IdSector, SectorISO, IAF_MD5, SectorCluster, SectorCategory, SectorSubcategory, SectorRiskLevel, SectorStatus FROM sectors ORDER BY SectorISO";
                $data = DBManager::query($query);
                header(HTTP_CODE_200);
                echo json_encode($data);
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