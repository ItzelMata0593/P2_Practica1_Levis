<?php
session_start();#Permite iniciar sesion o reanudar una sesion que ya se habia abierto
include("conexion.php");#Llama a la conexion con la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {#Compruba si los datos fueron enviados
    $correo = trim($_POST['correo']);#Guarda el valor que recibe "correo", trim quita los espacios
    $password = trim($_POST['password']);#Guarda el valor que se recibe de contraseña, trim quita los espacios

    if (!empty($correo) && !empty($password)) {#Evalua que si algun campo esta vacio
        // Consultar el usuario
        $stmt = $conexion->prepare("SELECT id, password FROM usuarios WHERE correo = ?");#sirve para preparar una consulta SQL segura en PHP
        $stmt->bind_param("s", $correo);#Vitulación de parámetros. Asigna la variable $correo (de tipo texto/string "s") al marcador ? de la consulta.
        $stmt->execute();#Ejecución de la consulta
        $resultado = $stmt->get_result();#Obtención de resultados

        if ($usuario = $resultado->fetch_assoc()) {#Convierte la respuesta en un arreglo asociativa con la información del usuario
            // Verificar la contraseña encriptada
            if (password_verify($password, $usuario['password'])) {#Compara la contraseña ingresada en texto plano con la versión cifrada guardada en la base de datos
                $_SESSION['usuario_id'] = $usuario['id'];#Guarda el ID único dentro de la memoria activa del servidor
                $_SESSION['correo'] = $correo;#Guarda el correo dentro de la memoria activa

                #Envía código JavaScript desde PHP hacia el navegador web. si ambos datos son correctos/contaseña incorrecta/correo no registrado
                // Redirige al usuario al index
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
        $stmt->close(); //Libera la memoria utilizada por la sentencia preparada
    } else {#Avisa que los datos son obligatorios
        echo "<script>
                alert('Por favor ingresa correo y contraseña.');
                window.location.href = 'iniciarSesion.html';
              </script>";
    }
}
$conexion->close();#Desconecta el script de la base de datos para liberar recursos del servidor
?>
