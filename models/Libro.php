<?php
require_once 'config/database.php';
/**
 * Clase Libro para manejar operaciones relacionadas con libros en la base de datos.
 */
class Libro {
    /** @var PDO Instancia de la conexión PDO a la base de datos */
    private $db;

    /**
     * Constructor de la clase Libro. Inicializa la conexión a la base de datos.
     */
    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Lista todos los libros almacenados en la base de datos.
     *
     * @return array Arreglo asociativo con la información de todos los libros.
     */
    public function listarLibros() {
        $query = "SELECT * FROM libros";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene la información de un libro específico por su ID.
     *
     * @param int $id ID del libro que se desea obtener.
     * @return array|null Arreglo asociativo con la información del libro o null si no se encuentra.
     */
    public function obtenerLibroPorId($id) {
        $query = "SELECT * FROM libros WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crea un nuevo libro en la base de datos.
     *
     * @param array $datos Arreglo asociativo con los datos del libro a crear.
     * @return bool true si el libro se crea correctamente, false en caso contrario.
     */
    public function crearLibro($datos) {
        $query = "INSERT INTO libros (titulo, autor, editorial, ano_publicacion, isbn) VALUES (:titulo, :autor, :editorial, :ano_publicacion, :isbn)";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':titulo', $datos['titulo']);
        $stmt->bindParam(':autor', $datos['autor']);
        $stmt->bindParam(':editorial', $datos['editorial']);
        $stmt->bindParam(':ano_publicacion', $datos['ano_publicacion']);
        $stmt->bindParam(':isbn', $datos['isbn']);

        return $stmt->execute();
    }

    /**
     * Actualiza la información de un libro existente en la base de datos.
     *
     * @param int $id ID del libro que se desea actualizar.
     * @param array $datos Arreglo asociativo con los nuevos datos del libro.
     * @return bool true si la actualización se realiza correctamente, false en caso contrario.
     */
    public function actualizarLibro($id, $datos) {
        $query = "UPDATE libros SET titulo = :titulo, autor = :autor, editorial = :editorial, ano_publicacion = :ano_publicacion, isbn = :isbn WHERE id = :id";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':titulo', $datos['titulo']);
        $stmt->bindParam(':autor', $datos['autor']);
        $stmt->bindParam(':editorial', $datos['editorial']);
        $stmt->bindParam(':ano_publicacion', $datos['ano_publicacion']);
        $stmt->bindParam(':isbn', $datos['isbn']);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    /**
     * Elimina un libro de la base de datos por su ID.
     *
     * @param int $id ID del libro que se desea eliminar.
     * @return bool true si el libro se elimina correctamente, false en caso contrario.
     */
    public function eliminarLibro($id) {
        $query = "DELETE FROM libros WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
