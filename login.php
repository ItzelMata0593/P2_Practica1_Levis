<?php
session_start();
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = trim($_POST['correo']);
    $password = trim($_POST['password']);

    if (!empty($correo) && !empty($password)) {
        // Consultar el usuario
        $stmt = $conexion->prepare("SELECT id, password FROM usuarios WHERE correo = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($usuario = $resultado->fetch_assoc()) {
            // Verificar la contraseña encriptada
            if (password_verify($password, $usuario['password'])) {
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['correo'] = $correo;

                echo "<script>
                        alert('¡Bienvenido a Levi\'s!');
                        window.location.href = 'index.html';
                      </script>";
            } else {
                echo "<script>
                        alert('Contraseña incorrecta.');
                        window.location.href = 'iniciarSesion.html';
                      </script>";
            }
        } else {
            echo "<script>
                    alert('El correo no está registrado.');
                    window.location.href = 'iniciarSesion.html';
                  </script>";
        }
        $stmt->close();
    } else {
        echo "<script>
                alert('Por favor ingresa correo y contraseña.');
                window.location.href = 'iniciarSesion.html';
              </script>";
    }
}
$conexion->close();
?>