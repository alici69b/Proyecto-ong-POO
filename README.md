# ONG RESET
**Reiniciando vidas, ideas y proyectos**

## - Descripción
RESET es una ONG digital que da **segundas oportunidades** a proyectos, estudios, hábitos, ideas o pequeños sueños que las personas han abandonado. 
No se centra solo en ayudar a personas, sino en **reactivar lo que quedó incompleto** mediante apoyo emocional y técnico.

## - Tecnologías utilizadas
- HTML5 – Estructura de la aplicación
- CSS3 y Tailwind – Diseño responsive y adaptable a dispositivos móviles
- PHP – Lógica del servidor siguiendo el patrón MVC
- MySQL – Gestión de la base de datos

##  Funcionalidades
1. **Solicitar un RESET**  
   Formulario donde los usuarios explican qué abandonaron, por qué y qué necesitan.
2. **Casos en proceso/Historias de extito**  
   Listado dinámico con tarjetas que muestran el estado, categoría y fecha de cada RESET.
3. **Voluntarios RESET**  
   Formulario para que los voluntarios ofrezcan ayuda.
4. **Impacto**  
   Contadores dinámicos de RESET iniciados, completados y voluntarios activos.
5. **Panel de Administración**
   Gestionan los usuarios, las solicitudes de los RESETs, los cambios de estado
6. **Sistema de autenticación**
   REgistro de los usuarios, el inicio de sesión

## - Estructura de carpetas (ejemplo)
```text
RESET-ONG/
│
├── app/                               # Lógica principal de la aplicación (patrón MVC)
│   ├── config/                        # Configuración global del sistema
│   │   └── db.php                     # Conexión a la base de datos
│   │
│   ├── controlador/                   # El "cerebro": procesa datos y decide qué vista mostrar
│   │   ├── ContactController.php      # Gestiona el formulario de contacto
│   │   ├── LoginController.php        # Controla el inicio de sesión
│   │   ├── RegisterController.php     # Controla el registro de usuarios
│   │   ├── ResetControlador.php       # Controla la lógica de las actividades RESET
│   │   ├── VoluntarioControlador.php  # Gestiona acciones del voluntario (inscripciones, panel)
│   │   └── AdminControlador.php       # Gestiona el panel de administración
│   │
│   ├── modelo/                        # El "almacén": realiza consultas directas a la base de datos
│   │   ├── RegisterModel.php          # Inserta nuevos usuarios en la base de datos
│   │   ├── Reset.php                  # Modelo relacionado con actividades RESET
│   │   ├── Voluntario.php             # Modelo para datos y acciones del voluntario
│   │   └── Admin.php                  # Modelo para gestión de usuarios y actividades (admin)
│   │
│   └── vista/                         # Vistas que necesitan lógica PHP
│       ├── auth/                      # Vistas relacionadas con autenticación
│       │   ├── Login.php              # Formulario de inicio de sesión
│       │   └── Register.php           # Formulario de registro
│       │
│       ├── voluntario/                # Panel privado del voluntario
│       │   ├── panel.php              # Página principal del voluntario
│       │   └── misSolicitudes.php     # Actividades en las que está inscrito
│       │
│       └── admin/                     # Panel privado de administración
│           ├── dashboard.php          # Página principal del administrador
│           ├── gestionarUsuarios.php  # Gestión de usuarios registrados
│           └── gestionarActividades.php # Gestión de actividades RESET
│
├── pages/                             # Páginas públicas informativas (sin lógica compleja)
│   └── public/                        # Parte visible para cualquier usuario
│       ├── Contact.php                # Información y formulario de contacto
│       ├── Historys.php               # Historia de la ONG
│       ├── Impact.php                 # Impacto y resultados del proyecto
│       ├── Resets.php                 # Información sobre actividades RESET
│       └── Volunteers.php             # Información sobre voluntariado
│
├── public/                            # Archivos accesibles directamente desde el navegador
│   └── assets/                        # Recursos estáticos
│       └── img/                       # Imágenes del proyecto (perfiles, recursos visuales)
│
├── src/                               # Recursos reutilizables en toda la web
│   └── components/                    # Componentes que se repiten en varias páginas
│       ├── Header.php                 # Cabecera común de la web
│       └── footer.php                 # Pie de página común
│
├── .htaccess                          # Configuración de rutas amigables y control de acceso
├── 404.php                            # Página personalizada de error
└── index.php                          # Punto de entrada principal de la aplicación
```



