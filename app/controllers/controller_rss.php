<?php
// Cargamos el modelo de Historia para poder sacar los datos de la base de datos
require_once __DIR__ . '/../models/Historia.php';
// Cargamos la conexión a la base de datos
require_once __DIR__ . '/../config/db.php';

// Intentamos obtener todas las historias publicadas
try {
    // Creamos un objeto de la clase Historia para poder usar sus funciones
    $historiaModel = new Historia();
    // Llamamos a la función obtenerPublicadas() que devuelve las historias
    // que tienen estado = 'Publicada' ordenadas de la más nueva a la más antigua
    $historias = $historiaModel->obtenerPublicadas();
} catch (Exception $e) {
    // Si algo falla (base de datos caída, etc.), dejamos el array vacío
    // para que el RSS se genere aunque no haya historias
    $historias = [];
}

// Le decimos al navegador que esto NO es HTML, sino un archivo XML de tipo RSS
header('Content-Type: application/rss+xml; charset=utf-8');

// Primera línea del XML: la declaración con la versión y la codificación
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<!--
  RSS 2.0 es la versión más usada de RSS.
  Los xmlns (namespaces) son como "extensiones" que añaden más etiquetas:
  - atom: para enlaces al propio feed
  - content: para meter HTML dentro del XML
  - dc: para metadatos como el autor (creator)
-->
<rss version="2.0"
     xmlns:atom="http://www.w3.org/2005/Atom"
     xmlns:content="http://purl.org/rss/1.0/modules/content/"
     xmlns:dc="http://purl.org/dc/elements/1.1/">
<!-- <channel> es el contenedor principal del feed -->
<channel>
    <!-- Nombre de nuestro canal RSS -->
    <title>RESET ONG - Historias de éxito</title>
    <!-- Enlace a la web principal -->
    <link>https://proyectoreset.infinityfree.me/?i=1</link>
    <!-- Descripción de qué va este canal -->
    <description>Historias de segundas oportunidades: personas reales que decidieron reiniciar sus vidas con el apoyo de RESET.</description>
    <!-- El idioma del contenido (es = español) -->
    <language>es</language>
    <!-- Fecha de la última vez que se actualizó el feed -->
    <lastBuildDate><?= date('r', time()) ?></lastBuildDate>
    <!-- Enlace a sí mismo (para que los lectores RSS sepan dónde está el feed) -->
    <atom:link href="https://proyectoreset.infinityfree.me/app/controllers/controller_rss.php" rel="self" type="application/rss+xml"/>
    <!-- Imagen del logo que aparece en los lectores RSS -->
    <image>
        <url>https://proyectoreset.infinityfree.me/public/img/Logo_RESET.svg</url>
        <title>RESET ONG</title>
        <link>https://proyectoreset.infinityfree.me/index.php</link>
    </image>

    <!-- Recorremos todas las historias y creamos un <item> por cada una -->
    <?php foreach ($historias as $h):
        // Preparar los datos de cada historia para el XML
        // date('r') convierte la fecha al formato RSS (ej: Wed, 27 May 2026)
        $fecha = !empty($h['created_at']) ? date('r', strtotime($h['created_at'])) : date('r', time());
        // htmlspecialchars evita que caracteres raros rompan el XML
        $desc = htmlspecialchars($h['descripcion'] ?? '');
        $titulo = htmlspecialchars($h['titulo'] ?? '');
        $solicitante = htmlspecialchars($h['solicitante'] ?? 'Anónimo');
        $categoria = htmlspecialchars($h['nombre_categoria'] ?? 'general');
        $id = (int)($h['id'] ?? 0);
        // Creamos un identificador único para cada historia
        $guid = "reset-historia-$id";
        // Montamos la URL completa de la foto
        $fotoUrl = 'https://proyectoreset.infinityfree.me/public/img/' . htmlspecialchars($h['foto'] ?? 'foto_defecto.webp');
    ?>
    <!-- Cada <item> es una noticia / historia individual -->
    <item>
        <!-- Título de la historia -->
        <title><?= $titulo ?></title>
        <!-- Enlace a la página donde se lee la historia completa -->
        <link>https://proyectoreset.infinityfree.me/app/controllers/controller_historias.php</link>
        <!-- GUID: identificador único del artículo (isPermaLink=false porque no es una URL) -->
        <guid isPermaLink="false"><?= $guid ?></guid>
        <!-- Fecha de publicación -->
        <pubDate><?= $fecha ?></pubDate>
        <!-- Autor de la historia (la persona que la vivió) -->
        <dc:creator><?= $solicitante ?></dc:creator>
        <!-- Categoría / tema de la historia -->
        <category><?= $categoria ?></category>
        <!-- Descripción corta (los lectores RSS muestran esto) -->
        <description><?= $desc ?></description>
        <!--
          Contenido enriquecido con HTML.
          Usamos CDATA para poder meter etiquetas HTML dentro del XML sin que den error.
        -->
        <content:encoded><![CDATA[
            <div style="font-family:sans-serif;max-width:600px">
                <p><?= nl2br($desc) ?></p>
                <p><strong>Solicitante:</strong> <?= $solicitante ?></p>
                <p><strong>Categoría:</strong> <?= $categoria ?></p>
                <img src="<?= $fotoUrl ?>" alt="<?= $titulo ?>" style="max-width:100%;border-radius:12px;margin-top:12px"/>
            </div>
        ]]></content:encoded>
    </item>
    <?php endforeach; ?>
</channel>
</rss>
