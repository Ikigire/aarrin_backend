<?php
    class DBManager 
    {
        /**
         * @var string dirección del host a conectarse
         */
        private const HOST       = 'localhost';

        /**
         * @var string Nombre de la base de datos a conectarse
         */
        private const DBNAME     = 'aarrindb';
        
        /**
         * @var string Nombre de usuario para acceso a la BD
         */
        private const USER       = 'root';

        /**
         * @var string Contraseña de acceso a la BD
         */
        private const PASSWORD   = '';

        /**
         * Función que establece la conexión con la base de datos y retorna dicha conexión
         * @return PDO Conexión con a base de datos
         */
        private static function connect() {
            $host = self::HOST;
            $dataBase = self::DBNAME;
            $userName = self::USER;
            $password = self::PASSWORD;
            //creating the dsn
            $dsn = "mysql:dbname=$dataBase;host=$host";
            try{
            $dbConnection = new PDO($dsn, $userName, $password);
            $dbConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $dbConnection->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
            $dbConnection->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
            $dbConnection->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, false);
            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $dbConnection->query("SET NAMES 'utf8'");//formating data to utf-8
            } catch (PDOException $e){
                echo "Connection Fails, check the connection config";
            }

            return $dbConnection;
        }

        /**
         * Función que ejecutará acciones simples sobre la base de datos.
         * 
         * En caso de ser una sentencia SELECT retornará un arreglo con el resultado,
         * En caso de ser una sentencia INSERT retornará el ID de la inserción,
         * En caso de ser una sentencia UPDATE retornara un true indicando que la acción se completó correctamente,
         * Y en caso de fallar en la ejecución o no encontrar resultados devolverá un false como resultado
         * @param string $query Sentencia SQL(query) a ejecutar
         * @param array $params (Opcional) Parámetros a utilizar en la sentencia SQL
         * @return array|int|bool
         */      
        public static function query(string $query, array $params = array()) {
            $response = null;

            $connection = self::connect();
            $connection->beginTransaction();

            try {
                $stmt = $connection->prepare($query);
                $stmt->execute($params);
                if (explode(' ', $query)[0] === 'SELECT'){
                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    if ($stmt->rowCount()){
                        $response = $stmt->fetchAll();
                    }
                    else{
                        $response = false;
                    }
                } elseif(explode(' ', $query)[0] === 'UPDATE' || explode(' ', $query)[0] === 'DELETE'){
                    $response = true;
                } else{
                    $response = $connection->lastInsertId();
                }
                $connection->commit();
            } catch (\Throwable $th) {
                $connection->rollBack();
                return false;
            }
            return $response;
        }
        
        /**
         * Función que permite querys recursivos
         * 
         * Esta función permite ejecutar sentencias INSERT y UPDATE de tablas principales y secundarias
         * (detalles) de manera que retornará un True encaso de lograrlo de maner correcta y un False
         * en caso contrario.
         * @param string $primary_query Sentencia sobre la tabla principal o padre
         * @param array $primary_params Parámetros a utilizar en la sentencia primaria
         * @param string $secondary_query (Opcional) Sentencia sobre la tabla detalle
         * @param array $secondary_params (Opcional) Parámetros a utilizar en la sentencia secundaria
         * @return bool Resultado de la ejecución de las sentencias True=Transacción exitosa; False=Transacción fallida
         */
        public static function advanced_query(string $primary_query, array $primary_params, string $secondary_query = '', array $secondary_params = array()){
            $connection = self::connect();
            $connection->beginTransaction();
            $stmt = $connection->prepare($primary_query);

            try {
                $stmt->execute($primary_params);
                $id = $connection->lastInsertId();

                for ($i=0; $i < count($secondary_params); $i++) { 
                    $params = $secondary_params[$i];
                    array_push($params, array(':id' => $id));

                    $stmt = $connection->prepare($secondary_query);
                    $stmt->execute($params);
                }
                $connection->commit();
            } catch (\Throwable $th) {
                $connection->rollBack();
                return false;
            }

            return true;
        }
    }
?>