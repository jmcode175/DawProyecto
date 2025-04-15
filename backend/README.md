# 🏗️ Backend - Plataforma de Contratación de Servicios

Este backend forma parte del proyecto de DAW que consiste en el desarrollo de una plataforma web para la contratación de servicios diversos (limpieza, mantenimiento, fotografía, etc.), orientado tanto a personas físicas como a empresas.

## 🎯 Objetivo

Crear un sistema funcional que permita:

- Registrar usuarios (clientes, profesionales y administradores)
- Asociar servicios ofrecidos por los profesionales
- Gestionar contrataciones entre usuarios
- Aplicar comisiones automáticas
- Preparar la base para un sistema de pagos simulados o reales

## 🗄️ Estructura de la base de datos

La base de datos se llama `servicios_pro` y contiene las siguientes tablas:

### 🔹 `usuarios`

Contiene los datos de todas las personas registradas en la plataforma.

| Campo          | Tipo         | Descripción                         |
|----------------|--------------|-------------------------------------|
| id             | INT, PK      | Identificador único                 |
| nombre         | VARCHAR(100) | Nombre del usuario                  |
| email          | VARCHAR(100) | Correo electrónico (único)          |
| password       | VARCHAR(255) | Contraseña encriptada               |
| rol            | ENUM         | cliente, profesional, admin         |
| tipo_cliente   | ENUM         | persona_fisica, empresa             |
| creado_en      | TIMESTAMP    | Fecha de alta del usuario           |

---

### 🔹 `servicios`

Cada servicio está asociado a un profesional.

| Campo           | Tipo          | Descripción                              |
|------------------|---------------|------------------------------------------|
| id               | INT, PK       | Identificador único del servicio         |
| nombre           | VARCHAR(100)  | Nombre del servicio                      |
| descripcion      | TEXT          | Descripción detallada                    |
| precio           | DECIMAL(10,2) | Precio base del servicio                 |
| profesional_id   | INT, FK       | ID del profesional que lo ofrece         |
| creado_en        | TIMESTAMP     | Fecha de publicación del servicio        |

---
### 🔹 `contrataciones`

Registra las contrataciones entre clientes y servicios, incluyendo comisiones y evaluación.

| Campo               | Tipo          | Descripción                                            |
|--------------------|---------------|--------------------------------------------------------|
| id                 | INT, PK       | Identificador único de la contratación                |
| cliente_id         | INT, FK       | ID del cliente que contrata el servicio               |
| servicio_id        | INT, FK       | ID del servicio contratado                            |
| fecha              | DATETIME      | Fecha y hora de la contratación                       |
| estado             | ENUM          | pendiente, en_proceso, completado                     |
| comision           | DECIMAL(10,2) | Comisión aplicada automáticamente (ej: 10%)           |
| precio_total       | DECIMAL(10,2) | Precio total del servicio contratado                  |
| evaluacion_cliente | TEXT          | Comentarios o evaluación del cliente tras el servicio |

---

## 🔗 Esquema relacional

![Esquema Relacional](./ImagenesReadme/esquema-relacional.png)

## 📅 Pasos realizados

### 🔸 Creación de la estructura de carpetas

- Se organizó el backend en subcarpetas según la funcionalidad:
  - `auth/`: para autenticación (`registro.php`, `login.php`, etc.)
  - `db/`: para la conexión y scripts SQL (`conexion.php`, `crear_tablas.sql`)
  - `paneles/`: vistas separadas por rol de usuario (cliente, profesional, admin)
  - `ImagenesReadme/`: contiene las imágenes utilizadas en el README

- Esta estructura se integró en el repositorio compartido [DawProyecto]

---

### 🔸 Archivo `conexion.php`

- Conecta a la base de datos MySQL usando la extensión `MySQLi`.
- Permite comprobar si la conexión es correcta y muestra un mensaje.
- Está situado en:  
  `backend/db/conexion.php`
- Se probó desde el navegador accediendo a:  
  `http://localhost/serviciospro/backend/db/conexion.php`
- Resultado esperado:  
  `✅ Conexión exitosa a la base de datos.`

  ![Confirmación de conexion exitosa a la base de datos](ImagenesReadme/conexion-exitosa-bd.jpg)

---

### 🔸 Archivo `registro.php`

- Recibe datos desde un formulario mediante `POST`.
- Valida los campos requeridos (`nombre`, `email`, `password`).
- Encripta la contraseña con `password_hash()` antes de guardarla.
- Inserta el nuevo usuario en la tabla `usuarios`.
- Está situado en:  
  `backend/auth/registro.php`

---

### 🔸 Formulario HTML de prueba

- Se creó una página HTML simple para probar el registro.
- Está situada en:  
  `backend/auth/formulario_registro.html`
- Permite enviar los datos al script `registro.php` mediante un formulario `<form>`.

![Formulario de login en el navegador](ImagenesReadme/formulario-registro.jpg)
---

### 🔸 Verificación en phpMyAdmin

- Se verificó desde `phpMyAdmin` que los datos se insertaron correctamente en la tabla `usuarios`.
- El campo `creado_en` aparece con la fecha y hora del registro, gracias al valor predeterminado `CURRENT_TIMESTAMP`.

![Visualización de los usuarios registrados en phpMyAdmin](ImagenesReadme/tabla-usuarios.jpg)

### 🔸 Archivo `login.php`

### 🧪 Formulario de prueba

Se creó un formulario HTML muy simple para probar `login.php` desde el navegador:

📁 Ubicación:
backend/auth/formulario_login.html
🌐 Se accede desde: http://localhost/serviciospro/backend/auth/formulario_login.html

![Formulario de inicio de sesión donde el usuario introduce su email y contraseña para acceder a la plataforma.](ImagenesReadme/formulario-login.jpg)

- Permite iniciar sesión con email y contraseña desde un formulario HTML.
- Recupera los datos del formulario mediante el método `POST`.
- Verifica si el email existe en la base de datos (`usuarios`).
- Comprueba que la contraseña ingresada coincide con la almacenada (encriptada) usando `password_verify()`.
- Si las credenciales son correctas:
  - Inicia una sesión con `session_start()`.
  - Guarda en `$_SESSION` el `id`, `nombre` y `rol` del usuario.

  ![Resultado exitoso del login con mensaje de bienvenida](ImagenesReadme/funcionamiento-correcto-login.jpg)

- En caso de error, muestra mensajes como:
  - “Contraseña incorrecta.”
  - “No se encontró ningún usuario con ese email.”

  ![Error al intentar iniciar sesión con usuario no registrado](ImagenesReadme/funcionamiento-usuario-no-existe-login.jpg)

📁 Ubicación del archivo:backend/auth/login.php
---




