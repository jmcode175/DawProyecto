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

## 🔗 Diagrama  relacional

![Esquema Relacional](./ImagenesReadme/esquema-relacional.png)


---

## 📁 Estructura del proyecto

El backend está organizado en carpetas según su funcionalidad:

- `auth/`: autenticación (`registro.php`, `login.php`, etc.)
- `db/`: conexión y scripts SQL (`conexion.php`, `crear_tablas.sql`)
- `paneles/`: vistas separadas por tipo de usuario
- `ImagenesReadme/`: recursos visuales para la documentación

---

## 🔐 Registro de usuarios

### 📄 `registro.php`

- Recibe datos del formulario mediante `POST`
- Valida campos requeridos (`nombre`, `email`, `password`)
- Encripta la contraseña con `password_hash()`
- Inserta al nuevo usuario en la tabla `usuarios`

📂 Ruta: `backend/auth/registro.php`

---

### 🧪 Formulario de prueba

Se diseñó un formulario HTML simple para probar el registro:

📂 Ruta: `backend/auth/formulario_registro.html`  
🌐 Acceso: `http://localhost/serviciospro/backend/auth/formulario_registro.html`

![Formulario de registro](ImagenesReadme/formulario-registro.jpg)

---

### 📋 Verificación en phpMyAdmin

- Se verificó que los datos se insertan correctamente.
- El campo `creado_en` se rellena automáticamente con `CURRENT_TIMESTAMP`.

![Usuarios registrados en phpMyAdmin](ImagenesReadme/tabla-usuarios.jpg)

---

## 🔑 Inicio de sesión

### 📄 `login.php`

- Valida las credenciales enviadas mediante `POST`
- Verifica el email y la contraseña con `password_verify()`
- Si son correctos:
  - Inicia sesión con `session_start()`
  - Guarda en `$_SESSION` el `id`, `nombre` y `rol` del usuario

📂 Ruta: `backend/auth/login.php`

---

### 🧪 Formulario de prueba

📂 Ruta: `backend/auth/formulario_login.html`  
🌐 Acceso: `http://localhost/serviciospro/backend/auth/formulario_login.html`

![Formulario de login](ImagenesReadme/formulario-login.jpg)  
![Login correcto](ImagenesReadme/funcionamiento-correcto-login.jpg)  
![Error de login](ImagenesReadme/funcionamiento-usuario-no-existe-login.jpg)

---

## 🔄 Redirección según rol

Una vez autenticado, el usuario es redirigido automáticamente al panel correspondiente según su rol:

```php
$_SESSION['usuario_id'] = $usuario['id'];
$_SESSION['nombre'] = $usuario['nombre'];
$_SESSION['rol'] = $usuario['rol'];

switch ($_SESSION['rol']) {
    case 'cliente':
        header("Location: ../paneles/cliente.php");
        break;
    case 'profesional':
        header("Location: ../paneles/profesional.php");
        break;
    case 'admin':
        header("Location: ../paneles/admin.php");
        break;
    default:
        echo "⚠️ Rol no reconocido.";
}
exit;

📁 Ubicación del archivo:backend/auth/login.php
---
## 🧼 Recuperación del backend

Este backend fue restaurado tras un `push --force` que reescribió el historial.  
Se utilizó `git rebase` para resolver los conflictos y mantener toda la funcionalidad sin perder archivos.

---
## ✅ Estado actual

- Registro de usuarios: ✅  
- Inicio de sesión con sesión: ✅  
- Redirección automática por rol: ✅  
- Estructura de base de datos funcional: ✅  
- CRUD de servicios y contrataciones: ⬜ *(pendiente)*  
- Integración de pasarela de pagos: ⬜ *(planificada)*  
- Protección de rutas privadas: ⬜ *(en desarrollo)*

## 🧑‍💻 Autora del backend

**Gemma Castells Arbolí**  
Proyecto final del módulo de DAW (Desarrollo de Aplicaciones Web)  
Curso 2024-2025




