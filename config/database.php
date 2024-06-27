
<?php
/**
 * Clase Database para manejar la conexión a la base de datos utilizando PDO.
 */
class Database {
    /** @var string Dirección del servidor de la base de datos */
    private static $host = 'localhost';

    /** @var string Nombre de la base de datos */
    private static $dbname = 'biblioteca';

    /** @var string Nombre de usuario de la base de datos */
    private static $username = 'postgres';

    /** @var string Contraseña de la base de datos */
    private static $password = 'solati';

    /** @var PDO|null Instancia única de la conexión PDO */
    private static $db = null;

    /**
     * Método estático para obtener una única instancia de la conexión a la base de datos.
     *
     * @return PDO Instancia de la conexión PDO
     * @throws PDOException Si hay un error al conectar con la base de datos
     */
    public static function getInstance() {
        if (!self::$db) {
            try {
                // Establecer la conexión PDO si aún no está establecida
                self::$db = new PDO("pgsql:host=".self::$host.";dbname=".self::$dbname, self::$username, self::$password);

                // Configurar PDO para lanzar excepciones en caso de errores
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                // Capturar y mostrar el mensaje de error en caso de falla en la conexión
                echo "Error de conexión: " . $e->getMessage();
                die(); // Terminar la ejecución del script si hay un error de conexión
            }
        }
        return self::$db;
    }
}
?>
