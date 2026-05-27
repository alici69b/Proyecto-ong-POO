# RESUMEN COMPLETO DE CAMBIOS REALIZADOS EN EL PROYECTO

## Ficheros nuevos creados (3)

| # | Fichero | Descripción |
|---|---------|-------------|
| 1 | `public/data/erp_financiero.json` | Datos financieros externos (ERP simulado) con 3 ejercicios: 2024, 2025, 2026. Incluye ingresos, gastos, evolución mensual y desglose por categorías. |
| 2 | `app/controllers/controller_transparencia.php` | Controlador que carga el JSON del ERP, consulta estadísticas reales de la BD (Impacto model: resets, completados, voluntarios, tasa de éxito) y calcula coste por reset. |
| 3 | `pages/Transparencia.php` | Página de transparencia con 4 gráficos Chart.js (barra anual, línea mensual, 2 doughnuts), storytelling y tabla detallada. |

---

## Ficheros modificados (12)

### 1. `src/components/footer.php`
- ✉ → **SVG mail icon** (sobre) en el enlace "¿Quieres ayudarnos? ¡Regístrate aquí!"
- Añadido enlace **"Transparencia"** en el footer
- Corregidas rutas relativas → absolutas `/Proyecto-ong-POO/` para evitar 404

### 2. `src/components/Header.php`
- *(Sin cambios de iconos)*

### 3. `src/components/Header_documentation.php`
- ← → **SVG arrow-left** (chevron-left) en el botón "Volver al inicio"

### 4. `pages/Inicio.php`
- 3× → → **SVG arrow-right** en "Ver perfil →" de las cards Voluntario, Usuario Reset y Administrador

### 5. `pages/Contact.php`
- 3× ⌄ → **SVG chevron-down** en los FAQ (Preguntas Frecuentes)

### 6. `pages/Transparencia.php` (nuevo)
- ~30 emojis reemplazados por SVGs Heroicons-style:
  - 🔄 → SVG arrow-path (icono refresh)
  - ✨ → SVG sparkles
  - 🤝 → SVG handshake / users
  - ❤️ → SVG heart
  - 💶 → SVG euro / banknotes
  - 📈 → SVG arrow-trending-up
  - 🎯 → SVG crosshairs / target
  - 📊 → SVG chart-bar
  - 💰 → SVG banknotes
  - 💚/🔴 → colores de Chart.js (sin emoji)
  - 💪 → SVG shield-check
  - 📅 → SVG calendar
  - 📁 → SVG folder
  - 📄 → SVG document-text
  - 🔍 → SVG magnifying-glass
  - 💬 → SVG chat-bubble
  - 💳 → SVG credit-card
  - 📋 → SVG clipboard-document-list
  - Y otros más
- Limpiados labels de Chart.js: `'💚 Ingresos'` → `'Ingresos'`, `'🔴 Gastos'` → `'Gastos'`

### 7. `app/views/auth/Login.php`
- ← → **SVG arrow-left** (chevron-left) en "Volver al inicio"

### 8. `app/views/auth/Register.php`
- ← → **SVG arrow-left** (chevron-left) en "Volver al inicio"

### 9. `app/views/auth/Reset_password.php`
- ← → **SVG arrow-left** (chevron-left) en "Volver al inicio"

### 10. `app/views/volunteer/dashboard.php`
- ✕ → **SVG X icon** (x-mark) en el botón "✕ Limpiar" del filtro de búsqueda

### 11. `app/views/admin/gestionarhistorias.php`
- 📖 (emoji libro) → **SVG document-text** como icono por defecto al mostrar historias
- 📖 (default en formulario crear) → campo vacío con placeholder
- 📖 (default en JavaScript editar) → campo vacío
- Etiqueta "Icono (emoji)" → "Icono"
- *(Las estrellas ⭐ en selects de valoración se mantienen por ser contenido de `<option>`)*

### 12. `app/models/Historia.php`
- `'icono' => '📖'` → `'icono' => ''` (default vacío en crear historia manual)
- `'icono' => '🔄'` → `'icono' => ''` (default vacío en historia automática)

---

## Ficheros eliminados (P2 - por solicitud del usuario)

| # | Fichero | Motivo |
|---|---------|--------|
| 1 | `app/controllers/controller_datos_externos.php` | Eliminado P2 |
| 2 | `pages/DatosExternos.php` | Eliminado P2 |
| 3 | `public/data/reset_data.xml` | Eliminado P2 |
| 4 | `public/data/reset_data.dtd` | Eliminado P2 |
| 5 | `public/data/reset_data.xsd` | Eliminado P2 |
| 6 | `public/data/reset_data.xslt` | Eliminado P2 |
| 7 | Enlace "Datos Externos" en footer | Eliminado P2 |

---

## Resumen de tecnologías usadas

| Tecnología | Uso |
|------------|-----|
| **Tailwind CSS v4** (CDN) | Framework de diseño responsive |
| **Chart.js v4** (CDN) | Gráficos financieros en Transparencia |
| **Inline SVGs** (Heroicons-style) | Todos los iconos del proyecto |
| **PHP 8+** | Backend MVC |
| **MySQL/PDO** | Base de datos |
| **PHPMailer** | Envío de emails |
| **RSS 2.0** | Canal de sindicación (P1) |

---

## Evaluación contra requisitos

| # | Requisito | Puntos | Estado |
|---|-----------|:------:|:------:|
| 1 | Navegación y Header | 1.0 | ✅ Completado |
| 2 | Footer Modular | 1.0 | ✅ Completado |
| 3 | Sindicación P1 (RSS) | 1.0 | ✅ Completado |
| 4 | Gestión de Proyectos P2 | 1.5 | ❌ Eliminado |
| 5 | Acceso y Perfiles P3 | 1.0 | ✅ Completado |
| 6 | Interactividad y DOM P4 | 1.5 | ✅ Completado |
| 7 | Transparencia P5 (ERP) | 1.0 | ✅ Completado |
| 8 | Framework y Diseño | 1.0 | ✅ Completado |
| 9 | Estándares W3C | 1.0 | ✅ ~90% |
| 10 | Calidad del Código | 1.0 | ✅ ~90% |
| | **TOTAL** | **10.0** | **8.3/10** |

---

## Estado actual del proyecto

- **Puntuación**: 8.3 / 10 (faltan 1.5pt de P2 eliminado + ~0.2pt de detalles menores)
- **Iconos**: 100% SVGs inline en todas las páginas (excepto ⭐ en selects de valoración, que no pueden ser SVG)
- **Enlaces**: Todas las rutas usan paths absolutos `/Proyecto-ong-POO/`
- **Consola navegador**: Sin errores en ninguna página
- **Gráficos**: 4 gráficos Chart.js funcionales en Transparencia
- **Datos externos**: `erp_financiero.json` cargado y combinado con datos reales de BD
