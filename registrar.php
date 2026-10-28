<?php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = trim($_POST['correo']);
    $password = trim($_POST['password']);

    if (!empty($correo) && !empty($password)) {
        // Encriptar contraseña
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        // Insertar en la base de datos
        $stmt = $conexion->prepare("INSERT INTO usuarios (correo, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $correo, $passwordHash);

        if ($stmt->execute()) {
            echo "<script>
                    alert('¡Cuenta creada con éxito! Ahora puedes iniciar sesión.');
                    window.location.href = 'iniciarSesion.html';
                  </script>";
        } else {
            echo "<script>
                    alert('Error: El correo ya está registrado o hubo un problema.');
                    window.location.href = 'crearCuenta.html';
                  </script>";
        }
        $stmt->close();
    } else {
        echo "<script>
                alert('Por favor completa todos los campos.');
                window.location.href = 'crearCuenta.html';
              </script>";
    }
}
$conexion->close();
?>