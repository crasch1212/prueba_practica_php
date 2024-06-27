<?php
/**
 * Clase JsonView para manejar la representación de datos en formato JSON.
 */
class JsonView {
    
    /**
     * Método estático para renderizar datos como respuesta JSON.
     *
     * @param mixed $data Los datos a serializar como JSON.
     * @param int $statusCode (Opcional) Código de estado HTTP para la respuesta (predeterminado: 200).
     * @return void
     */
    public static function render($data, $statusCode = 200) {
        // Establecer el código de estado HTTP de la respuesta
        http_response_code($statusCode);

        // Establecer el encabezado Content-Type para JSON
        header('Content-Type: application/json');

        // Codificar los datos proporcionados como JSON y enviar la respuesta
        echo json_encode($data);

        // Terminar la ejecución del script para evitar salida adicional
        exit;
    }
}
?>
