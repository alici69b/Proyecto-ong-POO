# GUÍA DEL PROYECTO INTERDISCIPLINAR – 1º DAW

## Título del Proyecto: "Creamos una ONG desde cero"

---

## 1. Portada

| | |
|---|---|
| **Título del proyecto** | Creamos una ONG desde cero |
| **Nombre de la ONG** | RESET |
| **Curso y grupo** | 1º DAW |
| **Módulos implicados** | Programación, Bases de Datos, Lenguaje de Marcas |
| **Autor** | [Nombre del alumno/a o equipo] |
| **Fecha de entrega** | [Fecha] |

---

## 2. Introducción

El proyecto consiste en el desarrollo completo de una aplicación web para una ONG ficticia llamada **RESET**, cuya finalidad es conectar a personas que necesitan ayuda con voluntarios dispuestos a brindarla. La plataforma permite registrarse como usuario o voluntario, crear y gestionar solicitudes de ayuda ("resets"), comunicarse a través de un sistema de comentarios, y generar historias de éxito cuando una ayuda se completa.

En este proyecto se trabajan de forma integrada tres módulos del ciclo: **Lenguaje de Marcas** (estructura HTML, maquetación CSS, formularios), **Bases de Datos** (diseño del modelo relacional, creación de tablas y consultas SQL), y **Programación** (lógica en PHP, procesamiento de formularios, conexión a base de datos, gestión de sesiones y seguridad). Cada módulo aporta una capa esencial que, al combinarse, da lugar a una aplicación web completa y funcional.

---

## 3. Descripción de la ONG

- **Nombre:** RESET
- **Temática:** Ayuda humanitaria y apoyo comunitario
- **Misión:** RESET nace con la misión de ofrecer una segunda oportunidad a personas que enfrentan dificultades —ya sean económicas, emocionales o sociales— conectándolas con voluntarios capacitados que puedan brindarles apoyo. El objetivo es construir una red solidaria donde cada persona pueda pedir ayuda y cada voluntario pueda aportar su tiempo y habilidades.
- **Público objetivo:** Personas en situación de vulnerabilidad que requieren algún tipo de asistencia (compañía, orientación, ayuda con trámites, apoyo emocional, etc.) y personas con disponibilidad y ganas de ayudar como voluntarios.

---

## 4. Análisis y planificación del proyecto

### 4.1 Objetivos del proyecto

**Objetivos funcionales:**
- Mostrar información institucional de la ONG (misión, impacto, transparencia).
- Permitir el registro de usuarios con dos roles diferenciados: usuario normal y voluntario.
- Permitir el inicio y cierre de sesión de forma segura.
- Permitir a los usuarios crear solicitudes de ayuda (resets) con categoría y descripción.
- Permitir a los voluntarios ver los resets disponibles y asignarse a ellos.
- Incorporar un sistema de comentarios para la comunicación entre usuario y voluntario.
- Gestionar el ciclo de vida de un reset: pendiente → en progreso → completado/cancelado.
- Generar automáticamente historias de éxito al completar un reset.
- Proporcionar un panel de administración con estadísticas y CRUD completo de usuarios, resets, historias y mensajes.
- Incluir un formulario de contacto público.

**Objetivos técnicos:**
- Utilizar HTML semántico para la estructura de las páginas.
- Aplicar estilos CSS mediante Tailwind CSS para un diseño moderno y responsive.
- Implementar la lógica de negocio en PHP con arquitectura MVC.
- Diseñar una base de datos MySQL normalizada con relaciones entre tablas.
- Garantizar la seguridad mediante prepared statements, CSRF y control de acceso por roles.

### 4.2 Tecnologías utilizadas

| Tecnología | Uso en el proyecto |
|---|---|
| **HTML5** | Estructura semántica de todas las páginas y vistas del sitio (header, main, footer, article, section, form, nav). |
| **CSS3 (Tailwind CSS v4 CDN)** | Maquetación responsive, diseño visual, colores, tipografía y componentes modernos sin necesidad de build step. |
| **PHP 8+** | Lógica del servidor: controladores que procesan formularios, gestionan sesiones, validan datos, se conectan a la base de datos y renderizan vistas. |
| **MySQL 8+** | Almacenamiento persistente de usuarios, resets, comentarios, historias y mensajes. |
| **XAMPP** | Entorno de desarrollo local que integra Apache, PHP y MySQL. |
| **VS Code** | Editor de código para el desarrollo de todos los archivos del proyecto. |

---

## 5. Diseño del sitio web (Lenguaje de Marcas)

### 5.1 Estructura general del sitio (Mapa web)

```
Inicio (/index.php)
├── Impacto (/pages/Impact.php)
├── Historias (/pages/Historys.php)
├── Contacto (/pages/Contact.php)
├── Transparencia (/pages/Transparencia.php)
├── Login (/app/views/auth/Login.php)
│   └── Registro (/app/views/auth/Register.php)
│
├── [Usuario] Dashboard (/app/views/user/dashboard.php)
│   ├── Crear Reset
│   ├── Mis Resets
│   └── Detalle Reset (/app/views/user/detalle.php)
│       └── Comentarios
│
├── [Voluntario] Dashboard (/app/views/volunteer/dashboard.php)
│   ├── Resets Disponibles
│   ├── Mis Resets
│   └── Detalle Reset (/app/views/volunteer/Detalle.php)
│       └── Comentarios
│
└── [Admin] Dashboard (/app/views/admin/dashboard.php)
    ├── Gestionar Resets
    ├── Gestionar Usuarios
    ├── Gestionar Historias
    └── Gestionar Contacto
```

### 5.2 Wireframes

**Wireframe – Página principal (Inicio)**

```
┌──────────────────────────────────────────────┐
│  Logo        Inicio  Impacto  Historias  Login │
├──────────────────────────────────────────────┤
│                                                │
│   ████████████████████████████████████████    │
│   ██           HERO IMAGE/BANNER          ██   │
│   ██  "Conectamos personas que ayudan"    ██   │
│   ██        [Quiero Ayudar] [Busco Ayuda] ██   │
│   ████████████████████████████████████████    │
│                                                │
│   ┌──────┐  ┌──────┐  ┌──────┐               │
│   │ 100+ │  │  50  │  │  90% │               │
│   │Resets│  │Volunt│  │Éxito │               │
│   └──────┘  └──────┘  └──────┘               │
│                                                │
│   "Cómo funciona"                             │
│   1. Pide ayuda  2. Te asignan  3. Lo logras │
│                                                │
├──────────────────────────────────────────────┤
│  Footer: © RESET - Todos los derechos         │
└──────────────────────────────────────────────┘
```

**Wireframe – Página secundaria (Detalle de Reset)**

```
┌──────────────────────────────────────────────┐
│  Header común                               │
├──────────────────────────────────────────────┤
│                                                │
│  ← Volver al dashboard                        │
│                                                │
│  ┌──────────────────────────────────────┐     │
│  │  Título del Reset                     │     │
│  │  Estado: [En progreso]               │     │
│  │  Categoría: Acompañamiento           │     │
│  │  Descripción: ...                    │     │
│  │  [Finalizar] [Cancelar]              │     │
│  └──────────────────────────────────────┘     │
│                                                │
│  Comentarios:                                  │
│  ┌──────────────────────────────────────┐     │
│  │ Voluntario: ¡Hola! ¿Cómo estás?      │     │
│  │ ─── hace 2 horas                     │     │
│  └──────────────────────────────────────┘     │
│  ┌──────────────────────────────────────┐     │
│  │ Usuario: Bien, gracias por preguntar │     │
│  │ ─── hace 1 hora                      │     │
│  └──────────────────────────────────────┘     │
│                                                │
│  [Escribe un mensaje...] [Enviar]              │
│                                                │
├──────────────────────────────────────────────┤
│  Footer                                       │
└──────────────────────────────────────────────┘
```

**Wireframe – Formulario (Registro)**

```
┌──────────────────────────────────────────────┐
│  Header común                               │
├──────────────────────────────────────────────┤
│                                                │
│   Crear cuenta                                 │
│                                                │
│   Nombre:    [________________]               │
│   Apellidos: [________________]               │
│   Email:     [________________]               │
│   Teléfono:  [________________]               │
│   Contraseña:[________________]               │
│   Repetir:   [________________]               │
│                                                │
│   Tipo de cuenta:                              │
│   ○ Usuario (busco ayuda)                     │
│   ○ Voluntario (quiero ayudar)                │
│                                                │
│   [Crear cuenta]                               │
│                                                │
│   ¿Ya tienes cuenta? Inicia sesión            │
│                                                │
├──────────────────────────────────────────────┤
│  Footer                                       │
└──────────────────────────────────────────────┘
```

### 5.3 Criterios de diseño y accesibilidad

- **Organización del contenido:** Se ha estructurado siguiendo el patrón de diseño web convencional: header con navegación en la parte superior, contenido principal en el centro y footer informativo al final. Cada sección está claramente delimitada con fondos alternados y espaciado generoso.
- **Colores y tipografía:** Se ha utilizado Tailwind CSS con una paleta basada en colores neutros (gray, slate) para el fondo y texto, y colores de acento (indigo/blue) para elementos interactivos como botones y enlaces. La tipografía por defecto del sistema (Inter/sans-serif) garantiza legibilidad en todos los dispositivos.
- **Medidas de accesibilidad:** Se ha procurado un contraste suficiente entre texto y fondo, etiquetas semánticas (header, nav, main, section, article, footer) para facilitar la navegación con lectores de pantalla, placeholders descriptivos en formularios, y estructura responsive que se adapta a dispositivos móviles.

---

## 6. Maquetación web

### 6.1 Estructura HTML

Las páginas del sitio siguen una estructura semántica clara:

- **`<header>`:** Contiene el menú de navegación principal (logo + enlaces) implementado como componente reutilizable (`src/components/Header.php`).
- **`<nav>`:** Lista de enlaces dentro del header que cambian según si el usuario está autenticado o no.
- **`<main>`:** Contiene el contenido específico de cada página (secciones, artículos, formularios, tablas).
- **`<section>`:** Divide el contenido en bloques temáticos (ej: hero, stats, cómo funciona, etc.).
- **`<article>`:** Usado en listados de historias y resets.
- **`<form>`:** Todos los formularios incluyen `method="POST"`, campos con `name` descriptivo y validación tanto HTML como del lado del servidor.
- **`<footer>`:** Componente reutilizable con información de contacto, enlaces legales y copyright.

### 6.2 Estilos CSS

Se ha utilizado **Tailwind CSS v4** cargado desde CDN (`@tailwindcss/browser@4`), lo que permite aplicar estilos directamente desde las clases HTML sin necesidad de un archivo CSS separado ni build step.

Principales estilos aplicados:
- **Diseño responsive:** Las páginas se adaptan a diferentes tamaños de pantalla mediante clases como `flex`, `grid`, `md:`, `lg:`.
- **Tarjetas (cards):** Uso de `bg-white rounded-lg shadow-md p-6` para presentar información en bloques visualmente separados.
- **Botones:** Estilos coherentes con `bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition` para acciones principales.
- **Tablas:** `w-full border-collapse bg-white rounded-lg shadow` con celdas alternadas y hover para administración de datos.
- **Formularios:** Campos con `w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500` para una experiencia visual clara.
- **El diseño es responsive** y funciona correctamente en móviles, tablets y escritorio.

### 6.3 Formularios web

| Formulario | Datos que recoge | Validaciones |
|---|---|---|
| **Registro** | nombre, apellidos, email, teléfono, contraseña, rol | HTML required, pattern email, minlength; PHP: validación de formato y unicidad de email |
| **Login** | email, contraseña | HTML required; PHP: verificación con password_verify |
| **Crear Reset** | título, descripción, categoría | HTML required; PHP: campos obligatorios |
| **Comentario** | texto del mensaje | HTML required; PHP: escape con htmlspecialchars |
| **Perfil (editar)** | nombre, apellidos, foto de perfil | PHP: validación de nombre; tipo MIME en imagen |
| **Perfil (password)** | password actual, nueva password, confirmación | PHP: verificación con password_verify, coincidencia |
| **Contacto** | nombre, email, asunto, mensaje | HTML required + email; PHP: validación de formato |
| **Admin: Gestionar Reset** | estado, id_voluntario | PHP: valores enteros por seguridad |
| **Admin: Gestionar Usuario** | rol, nombre, email, etc. | PHP: validación de campos |
| **Admin: Gestionar Historias** | título, contenido, foto, visible | PHP: validación y subida de archivos |

---

## 7. Diseño de la Base de Datos (Bases de Datos)

### 7.1 Análisis de datos

La aplicación necesita almacenar de forma persistente la siguiente información:

- **Usuarios:** datos personales (nombre, email, contraseña), rol (usuario/voluntario/admin), foto de perfil.
- **Resets:** solicitudes de ayuda con título, descripción, categoría, estado y referencias al usuario que la creó y al voluntario asignado.
- **Comentarios:** mensajes intercambiados entre usuario y voluntario dentro de un reset, con fecha y autor.
- **Historias de éxito:** generadas automática o manualmente al completar un reset, con título, contenido y foto.
- **Mensajes de contacto:** enviados desde el formulario público de contacto.
- **Categorías y estados:** catálogos para organizar resets.

Una base de datos relacional es necesaria para mantener la integridad de los datos, evitar duplicados (normalización), y permitir consultas complejas como "todos los resets de un usuario con su estado y voluntario asignado".

### 7.2 Modelo Entidad-Relación

```
┌──────────┐     ┌──────────────┐     ┌───────────┐
│  roles   │     │   usuario    │     │  admin    │
├──────────┤     ├──────────────┤     ├───────────┤
│ PK id_rol│◄────│ FK id_rol    │     │ PK id_admin│
│ nombre   │     │ PK id_usuario│◄───►│ FK id_user│
└──────────┘     │ nombre       │     │ nivel     │
                 │ apellidos    │     └───────────┘
                 │ email        │     
                 │ password     │     ┌──────────────┐
                 │ telefono     │◄───►│ usuario_normal│
                 │ foto_perfil  │     ├──────────────┤
                 └──────────────┘     │ PK id_normal │
                       │              │ FK id_user   │
                       │              │ tipo_ayuda   │
                       │              └──────────────┘
                       │              ┌──────────────┐
                       │◄────────────►│  voluntario  │
                       │              ├──────────────┤
                       │              │ PK id_vol    │
                       │              │ FK id_user   │
                       │              │ tipo_ayuda   │
                       │              │ disponibilidad│
                       │              └──────────────┘
                       │
              ┌────────┴────────┐       ┌──────────────────┐
              │     reset       │       │  categoria_reset │
              ├─────────────────┤       ├──────────────────┤
              │ PK id_reset     │       │ PK id_categoria  │
              │ FK id_usuario   │       │ nombre           │
              │ FK id_voluntario│       └──────────────────┘
              │ FK id_categoria │◄──────┘
              │ FK id_estado    │◄──────┐
              │ titulo          │       │ ┌──────────────────┐
              │ descripcion     │       │ │  estado_maestro  │
              │ fecha_creacion  │       │ ├──────────────────┤
              │ fecha_vencimiento│      │ │ PK id_estado     │
              └─────────────────┘       │ │ nombre           │
                       │                │ └──────────────────┘
                       │                │
              ┌────────┴────────┐       │
              │reset_comentario │       │
              ├─────────────────┤       │
              │ PK id_comentario│       │
              │ FK id_reset     │       │
              │ FK id_usuario   │ (opcional)
              │ FK id_voluntario│ (opcional)
              │ texto           │
              │ fecha_creacion  │
              └─────────────────┘

              ┌──────────────────┐
              │   historias      │
              ├──────────────────┤
              │ PK id_historia   │
              │ FK id_reset      │
              │ titulo           │
              │ contenido        │
              │ foto             │
              │ visible          │
              │ fecha_creacion   │
              └──────────────────┘

              ┌──────────────────┐
              │   mensaje        │
              ├──────────────────┤
              │ PK id_mensaje    │
              │ nombre           │
              │ email            │
              │ asunto           │
              │ mensaje          │
              │ leido            │
              │ fecha_envio      │
              └──────────────────┘
```

### 7.3 Esquema de la base de datos

**Tablas creadas:**

| Tabla | Clave primaria | Claves foráneas |
|---|---|---|
| `roles` | `id_rol (INT AUTO_INCREMENT)` | — |
| `usuario` | `id_usuario (INT AUTO_INCREMENT)` | `id_rol → roles(id_rol)` |
| `usuario_normal` | `id_normal (INT AUTO_INCREMENT)` | `id_usuario → usuario(id_usuario)` |
| `voluntario` | `id_vol (INT AUTO_INCREMENT)` | `id_usuario → usuario(id_usuario)` |
| `admin` | `id_admin (INT AUTO_INCREMENT)` | `id_usuario → usuario(id_usuario)` |
| `estado_maestro` | `id_estado (INT AUTO_INCREMENT)` | — |
| `categoria_reset` | `id_categoria (INT AUTO_INCREMENT)` | — |
| `reset` | `id_reset (INT AUTO_INCREMENT)` | `id_usuario → usuario(id_usuario)`, `id_voluntario → usuario(id_usuario)`, `id_categoria → categoria_reset(id_categoria)`, `id_estado → estado_maestro(id_estado)` |
| `reset_comentario` | `id_comentario (INT AUTO_INCREMENT)` | `id_reset → reset(id_reset)`, `id_usuario → usuario(id_usuario)`, `id_voluntario → usuario(id_usuario)` |
| `historias` | `id_historia (INT AUTO_INCREMENT)` | `id_reset → reset(id_reset)` |
| `mensaje` | `id_mensaje (INT AUTO_INCREMENT)` | — |

---

## 8. Desarrollo dinámico (Programación)

### 8.1 Procesamiento de formularios

Cada formulario del sitio es procesado por su controlador correspondiente siguiendo este patrón:

1. Se verifica que la petición sea `POST` (`$_SERVER['REQUEST_METHOD'] === 'POST'`).
2. Se valida el token CSRF mediante `validarTokenCSRF($_POST['_csrf'])`.
3. Se obtienen los datos del formulario con `trim($_POST['campo'] ?? '')`.
4. Se aplican validaciones del lado del servidor (longitud, formato, unicidad, etc.) usando la clase `Validaciones`.
5. Si hay errores, se almacenan en sesión y se redirige de vuelta al formulario.
6. Si no hay errores, se ejecuta la operación correspondiente (insertar, actualizar) y se redirige con mensaje de éxito.

### 8.2 Conexión con la base de datos

La conexión se realiza a través de la clase `Database` en `app/config/db.php`, que utiliza **PDO** con las siguientes características:

```php
$this->conexion = new PDO(
    "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
    DB_USER,
    DB_PWD,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]
);
```

Los parámetros de conexión se cargan desde el archivo `.env` mediante `getenv()`, con valores por defecto para el entorno local (`root` sin contraseña).

La gestión de errores se realiza con bloques `try/catch` que capturan `PDOException` y muestran un mensaje genérico al usuario mientras registran el detalle técnico.

### 8.3 Operaciones con la base de datos

**Inserción de datos** (ej: registro de usuario):
```php
$stmt = $this->conexion->prepare(
    "INSERT INTO usuario (nombre, apellidos, email, password, telefono, foto_perfil, id_rol) 
     VALUES (:nombre, :apellidos, :email, :password, :telefono, :foto_perfil, :id_rol)"
);
$stmt->execute([
    ':nombre' => $nombre,
    ':email' => $email,
    ':password' => password_hash($password, PASSWORD_BCRYPT),
    // ...
]);
```

**Consulta de datos** (ej: obtener resets disponibles):
```php
$stmt = $this->conexion->prepare(
    "SELECT r.*, c.nombre AS categoria, 
            u.nombre AS usuario_nombre, u.apellidos AS usuario_apellidos
     FROM reset r
     JOIN categoria_reset c ON r.id_categoria = c.id_categoria
     JOIN usuario u ON r.id_usuario = u.id_usuario
     WHERE r.id_estado = 1 AND r.id_voluntario IS NULL
     ORDER BY r.fecha_creacion DESC"
);
$stmt->execute();
return $stmt->fetchAll();
```

**Actualización de datos** (ej: cambiar estado de reset):
```php
$stmt = $this->conexion->prepare(
    "UPDATE reset SET id_estado = :nuevo_estado WHERE id_reset = :id_reset AND id_voluntario = :id_voluntario"
);
$stmt->execute([
    ':nuevo_estado' => $nuevo_estado,
    ':id_reset' => $id_reset,
    ':id_voluntario' => $id_voluntario,
]);
```

### 8.4 Reutilización de código

El proyecto organiza el código PHP siguiendo el patrón **MVC**, lo que permite una clara separación de responsabilidades y máxima reutilización:

- **`config.php`:** Incluido desde todos los controladores. Define constantes globales (`BASE_URL`), configura las cookies de sesión, e incluye funciones auxiliares (`generarTokenCSRF`, `validarTokenCSRF`).
- **Modelos (`app/models/`):** Clases PHP que encapsulan todas las operaciones con la base de datos. Cada modelo se instancia desde los controladores mediante `require_once` + `new`.
- **Controladores (`app/controllers/`):** Archivos que contienen la lógica de negocio. Incluyen mediante `require_once` los modelos y la configuración necesaria. Al final, cargan la vista correspondiente con `require_once`.
- **Componentes (`src/components/`):** `Header.php` y `footer.php` se incluyen desde las vistas de páginas públicas mediante `require_once`, evitando duplicar código de navegación en cada página.
- **Helpers (`app/Helpers/Validaciones.php`):** Clase con métodos estáticos (`validarNombre`, `validarEmail`, `validarContrasena`) llamados desde cualquier controlador.

```php
// Ejemplo de flujo completo en un controlador:
require_once __DIR__ . '/../../config.php';           // Configuración global
require_once __DIR__ . '/../../models/Reset.php';      // Modelo
require_once __DIR__ . '/../../Helpers/Validaciones.php'; // Validaciones
// ... lógica del controlador ...
require_once __DIR__ . '/../views/volunteer/dashboard.php'; // Vista
```

---

## 9. Pruebas y funcionamiento

### Pruebas realizadas

| Tipo de prueba | Descripción | Resultado |
|---|---|---|
| Registro de usuario | Crear cuenta como usuario normal y como voluntario | ✅ Funciona correctamente |
| Inicio de sesión | Login con credenciales válidas e inválidas | ✅ Funciona correctamente |
| Creación de reset | Usuario crea una solicitud de ayuda | ✅ Funciona correctamente |
| Asignación de reset | Voluntario se asigna a un reset disponible | ✅ Funciona correctamente |
| Sistema de comentarios | Envío y visualización de mensajes en el hilo | ✅ Funciona correctamente |
| Cambio de estado | Transición Pendiente → Progreso → Completado/Cancelado | ✅ Funciona correctamente |
| Generación de historia | Al completar un reset, se crea la historia automáticamente | ✅ Funciona correctamente |
| Subida de foto de perfil | Usuario/voluntario sube una imagen | ✅ Funciona correctamente |
| Cambio de contraseña | Usuario cambia su contraseña desde el perfil | ✅ Funciona correctamente |
| CSRF | Envío de formulario con token inválido | ✅ Rechazado correctamente |
| XSS | Inyección de HTML/JS en campos de texto | ✅ Escape correcto con htmlspecialchars |
| Control de acceso | Usuario normal intenta acceder a ruta de admin | ✅ Redirige al login |
| Sintaxis PHP | `php -l` en todos los archivos modificados | ✅ Sin errores |

### Errores encontrados y soluciones

| Error | Causa | Solución |
|---|---|---|
| `display_errors` activado en producción | Código legacy con `ini_set` | Eliminada la línea en controladores de registro y contacto |
| Posible XSS en Login y Register | Parámetros URL impresos sin escapar | Agregado `htmlspecialchars()` |
| Sin protección CSRF | Formularios sin token de verificación | Agregado `generarTokenCSRF()` + `validarTokenCSRF()` en todos los formularios |
| Sesión sin regenerar tras login | Vulnerabilidad a session fixation | Agregado `session_regenerate_id(true)` en controller_login |
| Cookies de sesión inseguras | Sin httponly, samesite ni secure | Configurado `session_set_cookie_params()` en config.php |
| Credenciales de producción expuestas | Comentadas en `.env` | Eliminadas del repositorio |

---

## 10. Presentación final del proyecto

Se ha desarrollado una aplicación web completa para la ONG **RESET** que permite gestionar el ciclo completo de ayuda: desde que un usuario solicita asistencia hasta que un voluntario la completa, generando una historia de éxito. La aplicación cuenta con tres perfiles de usuario (usuario normal, voluntario y administrador), cada uno con sus funcionalidades específicas.

La parte más importante del proyecto es el **sistema de gestión de resets**, que constituye el núcleo de la aplicación: integra la creación de solicitudes, la asignación de voluntarios, el sistema de comunicación mediante comentarios, el cambio de estados y la generación automática de historias. Este flujo completo demuestra la integración exitosa de los tres módulos del ciclo.

---

## 11. Conclusiones

**¿Qué hemos aprendido?**
- A planificar y desarrollar una aplicación web completa desde cero siguiendo el patrón MVC.
- A diseñar una base de datos relacional normalizada y a realizar consultas SQL complejas con JOINs.
- A maquetar con HTML semántico y Tailwind CSS para un diseño responsive y accesible.
- A proteger una aplicación web frente a vulnerabilidades comunes (XSS, CSRF, SQLi, session fixation).
- A trabajar de forma integrada combinando conocimientos de Programación, Bases de Datos y Lenguaje de Marcas.

**Dificultades encontradas**
- La coordinación entre la lógica PHP y la visualización en las vistas requirió especial atención para mantener la separación MVC.
- La implementación de la seguridad (CSRF en todos los formularios, control de acceso por roles) fue tediosa pero necesaria.
- La gestión de archivos subidos (fotos de perfil e historias) requirió validación adicional de tipos MIME.

**Posibles mejoras**
- Implementar un sistema de recuperación de contraseña mediante email.
- Añadir notificaciones en tiempo real con WebSockets.
- Incorporar paginación en los listados largos (resets, historias, usuarios).
- Implementar un panel de gráficos más detallados para el administrador.
- Migrar las acciones de eliminación de GET a POST con CSRF para mayor seguridad.

---

## 12. Autoevaluación

A continuación se presenta una rúbrica de autoevaluación con los criterios trabajados en el proyecto:

| Criterio | Peso | Valoración (0-10) | Observaciones |
|---|---|---|---|
| **Lenguaje de Marcas** | 25% | | |
| Estructura HTML semántica | 10% | | |
| Diseño CSS / Maquetación responsive | 10% | | |
| Formularios correctamente estructurados | 5% | | |
| **Bases de Datos** | 25% | | |
| Diseño del modelo E-R | 10% | | |
| Creación de tablas y relaciones | 10% | | |
| Consultas SQL (inserciones, actualizaciones, consultas) | 5% | | |
| **Programación** | 40% | | |
| Procesamiento de formularios en PHP | 10% | | |
| Conexión y operaciones con base de datos | 10% | | |
| Gestión de sesiones y autenticación | 10% | | |
| Seguridad (XSS, CSRF, SQLi, passwords) | 10% | | |
| **Documentación y presentación** | 10% | | |
| Claridad y organización de la memoria | 5% | | |
| Entrega completa y ordenada | 5% | | |
| **Total** | **100%** | | |

**Valoración personal del trabajo realizado:**

[El alumno debe completar aquí una reflexión personal sobre su trabajo, destacando lo que considera que ha hecho bien, lo que le ha costado más esfuerzo, y qué nota cree que merece el proyecto.]

---

## 13. Anexos

### Anexo A: Script SQL completo

```sql
-- Creación de la base de datos
CREATE DATABASE IF NOT EXISTS proyecto_ong_poo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE proyecto_ong_poo;

-- Tabla de roles
CREATE TABLE roles (
    id_rol INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);

-- Tabla de usuarios
CREATE TABLE usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    id_rol INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    telefono VARCHAR(20),
    foto_perfil VARCHAR(255) DEFAULT 'default.png',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ultima_visita TIMESTAMP NULL,
    FOREIGN KEY (id_rol) REFERENCES roles(id_rol)
);

-- Tablas de perfiles específicos
CREATE TABLE usuario_normal (
    id_normal INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL UNIQUE,
    tipo_ayuda VARCHAR(100),
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario) ON DELETE CASCADE
);

CREATE TABLE voluntario (
    id_vol INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL UNIQUE,
    tipo_ayuda VARCHAR(100),
    disponibilidad VARCHAR(100),
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario) ON DELETE CASCADE
);

CREATE TABLE admin (
    id_admin INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL UNIQUE,
    nivel_permiso INT DEFAULT 1,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario) ON DELETE CASCADE
);

-- Catálogos
CREATE TABLE estado_maestro (
    id_estado INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);

CREATE TABLE categoria_reset (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

-- Tabla principal de resets
CREATE TABLE reset (
    id_reset INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_voluntario INT NULL,
    id_categoria INT NOT NULL,
    id_estado INT NOT NULL DEFAULT 1,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_vencimiento DATE NULL,
    visitas_voluntario TINYINT(1) DEFAULT 0,
    visitas_usuario TINYINT(1) DEFAULT 0,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario),
    FOREIGN KEY (id_voluntario) REFERENCES usuario(id_usuario),
    FOREIGN KEY (id_categoria) REFERENCES categoria_reset(id_categoria),
    FOREIGN KEY (id_estado) REFERENCES estado_maestro(id_estado)
);

-- Comentarios del hilo de cada reset
CREATE TABLE reset_comentario (
    id_comentario INT AUTO_INCREMENT PRIMARY KEY,
    id_reset INT NOT NULL,
    id_usuario INT NULL,
    id_voluntario INT NULL,
    texto TEXT NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_reset) REFERENCES reset(id_reset) ON DELETE CASCADE,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario),
    FOREIGN KEY (id_voluntario) REFERENCES usuario(id_usuario)
);

-- Historias de éxito
CREATE TABLE historias (
    id_historia INT AUTO_INCREMENT PRIMARY KEY,
    id_reset INT NULL,
    titulo VARCHAR(255) NOT NULL,
    contenido TEXT,
    foto VARCHAR(255),
    visible TINYINT(1) DEFAULT 0,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_reset) REFERENCES reset(id_reset)
);

-- Mensajes de contacto
CREATE TABLE mensaje (
    id_mensaje INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    asunto VARCHAR(255),
    mensaje TEXT NOT NULL,
    leido TINYINT(1) DEFAULT 0,
    fecha_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Datos iniciales
INSERT INTO roles (id_rol, nombre) VALUES (1, 'usuario'), (2, 'voluntario'), (3, 'admin');
INSERT INTO estado_maestro (id_estado, nombre) VALUES (1, 'Pendiente'), (2, 'En progreso'), (3, 'Completado'), (4, 'Cancelado');
INSERT INTO categoria_reset (id_categoria, nombre) VALUES (1, 'Acompañamiento'), (2, 'Ayuda con trámites'), (3, 'Apoyo emocional'), (4, 'Orientación laboral'), (5, 'Otros');
```

### Anexo B: Capturas de pantalla

[Insertar aquí capturas de pantalla de la aplicación funcionando: página de inicio, dashboard de usuario, detalle de reset con comentarios, panel de administración, etc.]

### Anexo C: Recursos utilizados

| Recurso | Uso |
|---|---|
| [Tailwind CSS v4](https://tailwindcss.com/) | Framework CSS para maquetación responsive |
| [PHP.net](https://php.net/) | Documentación oficial de PHP |
| [MySQL](https://dev.mysql.com/doc/) | Documentación oficial de MySQL |
| [XAMPP](https://www.apachefriends.org/) | Entorno de desarrollo local |
| [VS Code](https://code.visualstudio.com/) | Editor de código |
| [Draw.io](https://draw.io/) | Elaboración del diagrama E-R |
| [Font Awesome](https://fontawesome.com/) | Iconos utilizados en la interfaz |
