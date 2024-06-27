<?php
require_once 'models/Libro.php';
require_once 'views/jsonview.php';
/**
 * Clase LibrosController para manejar las acciones relacionadas con libros.
 */
class LibrosController {
    private $libroModel;

    /**
     * Constructor de la clase LibrosController.
     * Inicializa el modelo de libros.
     */
    public function __construct() {
        $this->libroModel = new Libro();
    }

    /**
     * Acción para listar libros o obtener un libro por su ID.
     * Si se proporciona un parámetro 'id', devuelve ese libro específico.
     * Si no se proporciona 'id', devuelve todos los libros.
     */
    public function index() {
        if (isset($_GET['id'])) {
            // Si se proporciona un parámetro 'id', obtener el libro por su ID
            $idLibro = $_GET['id'];
            $libro = $this->libroModel->obtenerLibroPorId($idLibro);

            if ($libro) {
                JsonView::render($libro);
            } else {
                JsonView::render(array('error' => 'Libro no encontrado'), 404);
            }
        } else {
            // Si no se proporciona 'id', listar todos los libros
            $libros = $this->libroModel->listarLibros();
            JsonView::render($libros);
        }
    }

    /**
     * Acción para crear un nuevo libro.
     * Se espera recibir datos JSON en el cuerpo de la solicitud POST.
     */
    public function crearLibro() {
        // Verificar que se esté realizando una solicitud POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            JsonView::render(array('error' => 'Método no permitido'), 405);
            return;
        }

        // Obtener datos del cuerpo de la solicitud
        $datos = json_decode(file_get_contents('php://input'), true);

        // Insertar el nuevo libro en la base de datos
        $resultado = $this->libroModel->crearLibro($datos);

        if ($resultado) {
            JsonView::render(array('mensaje' => 'Libro creado correctamente'), 201);
        } else {
            JsonView::render(array('error' => 'Error al crear el libro'), 500);
        }
    }

    /**
     * Acción para actualizar un libro existente por su ID.
     * Se espera recibir datos JSON en el cuerpo de la solicitud PATCH.
     *
     * @param int $id El ID del libro que se va a actualizar.
     */
    public function actualizarLibro($id) {
        // Verificar que se esté realizando una solicitud PATCH
        if ($_SERVER['REQUEST_METHOD'] !== 'PATCH') {
            JsonView::render(array('error' => 'Método no permitido'), 405);
            return;
        }

        // Obtener datos del cuerpo de la solicitud
        $datos = json_decode(file_get_contents('php://input'), true);

        // Actualizar el libro en la base de datos
        $resultado = $this->libroModel->actualizarLibro($id, $datos);

        if ($resultado) {
            JsonView::render(array('mensaje' => 'Libro actualizado correctamente'));
        } else {
            JsonView::render(array('error' => 'Error al actualizar el libro'), 500);
        }
    }

    /**
     * Acción para eliminar un libro por su ID.
     * Se espera realizar una solicitud DELETE.
     *
     * @param int $id El ID del libro que se va a eliminar.
     */
    public function eliminarLibro($id) {
        // Verificar que se esté realizando una solicitud DELETE
        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
            JsonView::render(array('error' => 'Método no permitido'), 405);
            return;
        }

        // Eliminar el libro de la base de datos
        $resultado = $this->libroModel->eliminarLibro($id);

        if ($resultado) {
            JsonView::render(array('mensaje' => 'Libro eliminado correctamente'));
        } else {
            JsonView::render(array('error' => 'Error al eliminar el libro'), 500);
        }
    }
}
?>
