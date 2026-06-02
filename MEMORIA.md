# MEMORIA DEL PROYECTO — RESET ONG

## 1. Resumen del Proyecto

**RESET** es una plataforma web desarrollada en PHP con arquitectura MVC que conecta a **personas que necesitan ayuda** (usuarios) con **voluntarios dispuestos a ayudar**. La plataforma permite:

- Registro de usuarios y voluntarios con distintos roles
- Creación y gestión de solicitudes de ayuda (llamadas "resets")
- Asignación de voluntarios a resets
- Sistema de mensajería entre voluntario y usuario (comentarios por reset)
- Seguimiento del progreso con estados: Pendiente → En progreso → Completado / Cancelado
- Generación automática de historias de éxito al completar un reset
- Panel de administración con estadísticas y gestión completa

---

## 2. Arquitectura del Sistema

Patrón **MVC (Modelo-Vista-Controlador)** implementado en PHP 8+ con PDO para acceso a base de datos MySQL.

```
Proyecto-ong-POO/
├── index.php               ← Punto de entrada (carga la página de inicio)
├── config.php              ← Configuración global (BASE_URL, sesiones, CSRF)
├── .env                    ← Variables de entorno (DB_HOST, DB_USER, DB_PWD, DB_NAME)
├── .gitignore
├── MEMORIA.md              ← Este documento
│
├── app/
│   ├── controllers/        ← Lógica de negocio (22 controladores)
│   ├── models/             ← Capa de datos (9 modelos)
│   ├── views/              ← Vistas organizadas por rol (auth/, admin/, user/, volunteer/)
│   ├── config/             ← Configuración (db.php, mail.php)
│   └── Helpers/            ← Clases auxiliares (Validaciones.php)
│
├── pages/                  ← Páginas públicas del frontend
│   ├── Inicio.php          ← Landing page principal
│   ├── Impact.php          ← Página de impacto
│   ├── Historys.php        ← Historias de éxito publicadas
│   ├── Contact.php         ← Formulario de contacto
│   └── Transparencia.php   ← Página de transparencia
│
├── public/
│   └── img/                ← Imágenes subidas (fotos de perfil, historias)
│
└── src/
    └── components/         ← Componentes reutilizables
        ├── Header.php      ← Header principal (navegación pública)
        ├── Header_documentation.php
        └── footer.php      ← Footer global
```

---

## 3. Base de Datos

**Motor:** MySQL 8+ con charset `utf8mb4`
**Conexión:** PDO con prepared statements (sin emulación)

### Tablas del Sistema

| Tabla | Propósito |
|-------|-----------|
| `usuario` | Usuarios del sistema (todos los roles) con `id_rol` FK |
| `roles` | Catálogo de roles: 1=usuario, 2=voluntario, 3=admin |
| `usuario_normal` | Datos extra de usuarios normales (tipo_ayuda) |
| `voluntario` | Datos extra de voluntarios (tipo_ayuda, disponibilidad) |
| `admin` | Datos extra de administradores (nivel_permiso) |
| `reset` | Solicitudes de ayuda (titulo, descripcion, estado, id_voluntario, etc.) |
| `estado_maestro` | Catálogo de estados: Nuevo, En progreso, Completado, Cancelado |
| `categoria_reset` | Catálogo de categorías de reset |
| `reset_comentario` | Mensajes del hilo de seguimiento de cada reset |
| `historias` | Historias de éxito generadas al completar resets |
| `mensaje` | Mensajes del formulario de contacto público |

### Relaciones Clave

- `usuario(1) ── usuario_normal(1)` — Un usuario normal tiene un registro extra
- `usuario(1) ── voluntario(1)` — Un voluntario tiene un registro extra
- `usuario(1) ── admin(1)` — Un admin tiene un registro extra
- `reset(*) ── categoria_reset(1)` — Cada reset pertenece a una categoría
- `reset(*) ── estado_maestro(1)` — Cada reset tiene un estado
- `reset(1) ── reset_comentario(*)` — Un reset tiene muchos comentarios
- `reset(1) ── historias(1)` — Un reset completado genera una historia

### Estados de un Reset

1. **Pendiente** — Creado, esperando voluntario
2. **En progreso** — Voluntario asignado, trabajando en ello
3. **Completado** — Finalizado con éxito
4. **Cancelado** — Cancelado por el usuario o voluntario

---

## 4. Modelos (app/models/)

### `Usuario.php` (Clase abstracta)
- `buscarPorEmail(string $email): ?array`
- `buscarPorId(int $id): ?array`
- `verificarPassword(string $email, string $password): bool`
- `cambiarPassword(int $id, string $nueva_password): bool`
- `eliminar(int $id): bool`
- `actualizar(int $id, ...): bool`
- `abstract insertarUsuario(array $datos)` — Implementado por las hijas

### `UsuarioNormal.php` (extends Usuario)
- `insertarUsuario(array $datos): bool` — Inserta en `usuario` + `usuario_normal`
- `obtenerPerfil(int $id_usuario): array|false`
- `actualizarDatos(int $id_usuario, array $datos): bool`
- `actualizarFoto(int $id_usuario, string $nombre_archivo): bool`
- `cambiarPassword(int $id, string $nueva_password): bool`

### `Voluntario.php` (extends Usuario)
- `insertarUsuario(array $datos): bool` — Inserta en `usuario` + `voluntario`
- `obtenerPerfil(int $id_usuario): array|false`
- `actualizarDatos(int $id_usuario, array $datos): bool`
- `actualizarFoto(int $id_usuario, string $nombre_archivo): bool`
- `cambiarPassword(int $id, string $nueva_password): bool`

### `Admin.php` (extends Usuario)
- `insertarUsuario(array $datos): bool` — Inserta en `usuario` + `admin`
- `buscarDatosAdmin(int $id_usuario): ?array`
- `listarTodosAdmin(): array`

### `Reset.php`
- `obtenerDisponibles(?int $id_categoria): array`
- `asignarVoluntario(int $id_reset, int $id_voluntario): bool`
- `obtenerStatsVoluntario(int $id_voluntario): array`
- `obtenerMisResets(int $id_voluntario): array`
- `obtenerPorId(int $id_reset, int $id_voluntario): array|false`
- `cambiarEstado(int $id_reset, int $id_voluntario, int $nuevo_estado): bool`
- `reactivar(int $id_reset, int $id_voluntario): bool`
- `obtenerPorUsuario(int $id_usuario, ?int $id_categoria): array`
- `obtenerPorIdUsuario(int $id_reset, int $id_usuario): array|false`
- `cambiarEstadoUsuario(int $id_reset, int $id_usuario, int $nuevo_estado): bool`
- `crear(...): bool`
- `actualizarVisitaUsuario(int $id_reset): void`
- `actualizarVisitaVoluntario(int $id_reset): void`
- `tieneNotificacionUsuario(int $id_reset): bool`
- `tieneNotificacionVoluntario(int $id_reset): bool`

### `ResetComentario.php`
- `obtenerPorReset(int $id_reset): array`
- `insertar(int $id_reset, ?int $id_usuario, ?int $id_voluntario, string $texto): bool`

### `Historia.php`
- `obtenerPublicadas(): array`
- `obtenerTodas(): array`
- `insertar(array $datos): int`
- `actualizar(int $id, array $datos): bool`
- `eliminar(int $id): bool`
- `obtenerPorId(int $id): ?array`
- `crearAutomaticaDesdeReset(int $id_reset): bool`
- `crearDesdeResetConDatos(int $id_reset, array $datos_voluntario): bool`

### `Mensaje.php`
- `obtenerTodos(): array`
- `contarTodos(): int`
- `marcarComoLeido(int $id): bool`
- `contarNoLeidos(): int`
- `insertar(array $datos): bool`
- `eliminar(int $id): bool`

### `Impacto.php`
- `contarResets(): int`
- `contarCompletados(): int`
- `contarVoluntarios(): int`
- `obtenerCategorias(): array`
- `obtenerEvolucionMensual(): array`
- `tasaExito(): int`

---

## 5. Controladores (app/controllers/)

### Autenticación

| Controlador | Propósito |
|---|---|
| `controller_login.php` | Procesa login, verifica credenciales, inicia sesión |
| `controller_register.php` | Procesa registro de usuarios/voluntarios |
| `controller_logout.php` | Destruye sesión y redirige al login |
| `controller_resetPassword.php` | **(Stub)** Recuperación de contraseña (sin implementar) |

### Admin

| Controlador | Propósito |
|---|---|
| `controller_admin_dashboard.php` | Panel principal con estadísticas globales |
| `controller_admin_gestionarreset.php` | CRUD de resets, asigna voluntarios y estados |
| `controller_admin_gestionusuarios.php` | CRUD de usuarios, búsqueda, paginación |
| `controller_admin_gestionarhistorias.php` | CRUD de historias de éxito, subida de fotos |
| `controller_admin_gestionarcontacto.php` | Gestión de mensajes de contacto |

### Voluntario

| Controlador | Propósito |
|---|---|
| `controller_volunteer_dashboard.php` | Resets disponibles y mis resets asignados |
| `controller_volunteer_perfil.php` | Gestión del perfil del voluntario |
| `controller_reset_detalle.php` | Detalle del reset (comentarios, finalizar, cancelar) |

### Usuario

| Controlador | Propósito |
|---|---|
| `controller_user_dashboard.php` | Panel del usuario (resets creados, crear nuevo reset) |
| `controller_user_perfil.php` | Gestión del perfil del usuario |
| `controller_user_reset_detalle.php` | Detalle del reset (comentarios, cancelar) |
| `controller_profile.php` | Perfil alternativo del usuario (coexiste con user_perfil) |

### Frontend Público

| Controlador | Propósito |
|---|---|
| `controller_inicio.php` | Landing page con indicadores de impacto |
| `controller_contact.php` | Procesa el formulario de contacto |

---

## 6. Vistas (app/views/)

### `auth/`
| Vista | Propósito |
|---|---|
| `Login.php` | Formulario de inicio de sesión |
| `Register.php` | Formulario de registro con selector de rol |

### `admin/`
| Vista | Propósito |
|---|---|
| `dashboard.php` | Panel con gráficos y estadísticas |
| `gestionarreset.php` | Gestión de resets con asignación |
| `gestionusuarios.php` | Tabla de usuarios con búsqueda y paginación |
| `gestionarhistorias.php` | CRUD de historias de éxito |
| `gestionarcontacto.php` | Bandeja de mensajes de contacto |

### `user/`
| Vista | Propósito |
|---|---|
| `dashboard.php` | Panel del usuario con resets creados y formulario crear |
| `detalle.php` | Detalle del reset + hilo de comentarios |
| `perfil.php` | Edición de perfil del usuario |
| `profile.php` | Perfil alternativo |

### `volunteer/`
| Vista | Propósito |
|---|---|
| `dashboard.php` | Panel del voluntario con resets disponibles/asignados |
| `Detalle.php` | Detalle del reset + comentarios + finalizar/cancelar |
| `perfil.php` | Edición de perfil del voluntario |

---

## 7. Páginas Públicas (pages/)

| Página | Ruta | Propósito |
|---|---|---|
| `Inicio.php` | `/index.php` | Landing page con hero, stats, CTA |
| `Impact.php` | `/pages/Impact.php` | Estadísticas y evolución mensual |
| `Historys.php` | `/pages/Historys.php` | Historias de éxito publicadas |
| `Contact.php` | `/pages/Contact.php` | Formulario de contacto público |
| `Transparencia.php` | `/pages/Transparencia.php` | Información de transparencia |

### Componentes Reutilizables (src/components/)

| Componente | Propósito |
|---|---|
| `Header.php` | Barra de navegación principal (logo, enlaces, login/register) |
| `Header_documentation.php` | Header alternativo para documentación |
| `footer.php` | Footer global con enlaces y redes sociales |

---

## 8. Seguridad Aplicada

Como resultado de una auditoría de seguridad completa, se implementaron las siguientes medidas:

### 8.1 Protección CSRF
Todos los formularios del sistema incluyen un token CSRF único por sesión:
- `generarTokenCSRF(): string` — Genera/recupera token de 32 bytes
- `validarTokenCSRF(string $token): bool` — Valida usando `hash_equals()`

Aplicado en: login, registro, perfil (voluntario y usuario), detalle reset (voluntario y usuario), dashboard (usuario y voluntario), admin (resets, usuarios, historias), formulario de contacto.

### 8.2 Sesiones Seguras
- Cookies de sesión con `httponly=true` (no accesibles desde JavaScript)
- `samesite=Strict` (no se envían en peticiones跨 sitio)
- `secure=true` en producción (solo HTTPS)
- `session_regenerate_id(true)` después del login (previene session fixation)

### 8.3 XSS (Cross-Site Scripting)
- Todas las salidas de datos usan `htmlspecialchars()`
- Los comentarios en los hilos usan `nl2br(htmlspecialchars(...))`
- Los parámetros URL (`$_GET['rol']`) se escapan antes de imprimirse

### 8.4 Inyección SQL
- Todas las consultas usan **prepared statements** con PDO
- `PDO::ATTR_EMULATE_PREPARES => false` (consultas reales, no emuladas)
- Parámetros vinculados con nombres (`:param`) para claridad

### 8.5 Contraseñas
- Hash con `password_hash(PASSWORD_BCRYPT)` (coste por defecto: 10)
- Verificación con `password_verify()`

### 8.6 Control de Acceso
- Cada controlador verifica el rol del usuario (`$_SESSION['user_rol']`)
- Los voluntarios solo ven sus resets asignados
- Los usuarios solo ven sus propios resets
- Las vistas redirigen al login si no hay sesión

### 8.7 Otras Medidas
- Credenciales de producción eliminadas del `.env`
- `display_errors` desactivado en controladores de producción
- El `.env` está en `.gitignore`

---

## 9. Instalación

### Requisitos
- PHP 8.1+
- MySQL 8+
- Servidor web (Apache/XAMPP recomendado)
- Extensiones PHP: PDO, MySQL, GD, fileinfo

### Pasos

```bash
# 1. Clonar el repositorio
git clone <repo-url> Proyecto-ong-POO

# 2. Configurar la base de datos
# Crear la base de datos 'proyecto_ong_poo' en MySQL
# Ejecutar el script SQL (pendiente de crear)

# 3. Configurar conexión
# Editar app/config/db.php o .env con tus credenciales

# 4. Iniciar el servidor
# Con XAMPP: poner en htdocs/ y acceder via http://localhost/Proyecto-ong-POO

# 5. (Opcional) Configurar mail
# Editar app/config/mail.php con credenciales SMTP de Brevo
```

### Configuración de `.env`
```
DB_HOST=localhost
DB_USER=root
DB_PWD=
DB_NAME=proyecto_ong_poo
```

---

## 10. Flujo de Usuario Típico

### Usuario Normal
```
Registro → Login → Dashboard → Crear Reset → 
  Voluntario se asigna → Chat con voluntario → 
  Reset completado → Historia generada → Ver historias
```

### Voluntario
```
Registro → Login → Dashboard → Ver resets disponibles → 
  Asignarse un reset → Chat con usuario → 
  Finalizar/Cancelar reset → Historia creada automáticamente
```

### Administrador
```
Login → Dashboard con estadísticas → 
  Gestionar Resets (asignar voluntarios, cambiar estados) →
  Gestionar Usuarios (CRUD completo) →
  Gestionar Historias (revisar, publicar, editar) →
  Gestionar Mensajes (leer contactos)
```

---

## 11. Estados del Proyecto

### Funcionalidades Implementadas
- ✅ Registro y login con roles
- ✅ Dashboard administrador con estadísticas
- ✅ Dashboard voluntario (resets disponibles/asignados)
- ✅ Dashboard usuario (mis resets + crear nuevo)
- ✅ Sistema de comentarios por reset
- ✅ Cambio de estados (pendiente → progreso → completado/cancelado)
- ✅ Generación de historias de éxito (automática + manual)
- ✅ CRUD de usuarios, resets, historias (admin)
- ✅ Formulario de contacto público
- ✅ Página de historias públicas
- ✅ Página de impacto con estadísticas
- ✅ Subida de fotos de perfil
- ✅ Cambio de contraseña
- ✅ Protección CSRF en todos los formularios
- ✅ Sesiones seguras (httponly, samesite, regenerate_id)
- ✅ Prepared statements en todas las consultas
- ✅ Escape de XSS en todas las salidas

### Pendiente / Mejora Futura
- ⬜ Recuperación de contraseña funcional (controller_resetPassword.php)
- ⬜ Configuración SMTP real para envío de emails
- ⬜ Rate-limiting en login (prevenir fuerza bruta)
- ⬜ Validación MIME real en subida de archivos
- ⬜ Migrar acciones DELETE de GET a POST con CSRF
- ⬜ Exportar esquema SQL como archivo independiente
- ⬜ Implementar router frontal (index.php?route=...) para mayor seguridad
