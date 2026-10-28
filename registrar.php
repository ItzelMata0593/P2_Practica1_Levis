<?php
include("conexion.php");#Llama al archivo de la conexion

if ($_SERVER["REQUEST_METHOD"] == "POST") {#Verifica que el usuario haya enviado el formulario mediante el método POST (al dar clic en registrarse)
    $correo = trim($_POST['correo']);#Guarda el correo ingresado en la variable $correo quitándole espacios innecesarios al inicio y al final.
    $password = trim($_POST['password']);#Guarda la contraseña ingresada en la variable $password quitándole espacios extras

    if (!empty($correo) && !empty($password)) {#Verifica que ambos campos tengan información antes de continuar
        // Encriptar contraseña
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);#Cifra la contraseña utilizando el algoritmo BCRYPT por seguridad antes de guardarla

        // Insertar en la base de datos
        $stmt = $conexion->prepare("INSERT INTO usuarios (correo, password) VALUES (?, ?)");#Prepara la instrucción SQL para insertar un nuevo registro de forma segura contra ataques de inyección SQL
        $stmt->bind_param("ss", $correo, $passwordHash);#Asigna las variables $correo y $passwordHash a los dos signos ? (ambas de tipo texto

        if ($stmt->execute()) {#Ejecuta la inserción en la base de datos y comprueba si se guardó correctamente
            //Mensaje si el registro fue exitoso y redirecciona a iniciar sesion
            echo "<script>
                    alert('¡Cuenta creada con éxito! Ahora puedes iniciar sesión.');
                    window.location.href = 'iniciarSesion.html';
                  </script>";
        } else {
            //Mensaje si ocurrio un error
            echo "<script>
                    alert('Error: El correo ya está registrado o hubo un problema.');
                    window.location.href = 'crearCuenta.html';
                  </script>";
        }
        $stmt->close();//Mensaje si algun dato esta vacio
    } else {
        echo "<script>
                alert('Por favor completa todos los campos.');
                window.location.href = 'crearCuenta.html';
              </script>";
    }
}
$conexion->close();#Cierra la conexión activa con la base de datos para liberar recursos del servidor
?>
