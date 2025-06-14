<?php
require_once 'config/database.php';
require_once 'includes/header.php';

// CÓDIGO VULNERABLE A BLIND SQL INJECTION
// No muestra datos específicos, solo confirmación de existencia

$article_exists = false;
$error = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    try {
        // VULNERABILIDAD: Concatenación directa (mantiene la vulnerabilidad)
        // Pero solo verificamos existencia, no mostramos datos
        $query = "SELECT id FROM blog WHERE id = " . $id;
        
        $result = $pdo->query($query);
        
        // BLIND: Solo confirmamos si existe al menos un resultado
        if ($result && $result->rowCount() > 0) {
            $article_exists = true;
        } else {
            $article_exists = false;
        }
        
    } catch(PDOException $e) {
        // BLIND: No mostramos errores específicos de SQL
        $article_exists = false;
        $error = "Error al procesar la consulta.";
    }
} else {
    $error = "ID de artículo no especificado.";
}
?>

<?php if ($error): ?>
    <div class="alert">
        <?php echo htmlspecialchars($error); ?>
    </div>
    <div class="blog-card">
        <a href="index.php" class="read-more">← Volver al inicio</a>
    </div>
<?php elseif ($article_exists): ?>
    <div class="blog-card">
        <h1 class="blog-title">✅ Artículo Encontrado</h1>
        <div class="blog-excerpt">
            <p>La consulta ha encontrado al menos un artículo que coincide con los criterios especificados.</p>
            <p><strong>Nota:</strong> Esta aplicación solo confirma la existencia de artículos, no muestra su contenido por razones de seguridad.</p>
        </div>
        <div class="blog-meta">
            Consulta ejecutada exitosamente
        </div>
    </div>
    <div class="blog-card">
        <a href="index.php" class="read-more">← Volver al inicio</a>
    </div>
<?php else: ?>
    <div class="blog-card">
        <h1 class="blog-title">❌ Artículo No Encontrado</h1>
        <div class="blog-excerpt">
            <p>No se encontraron artículos que coincidan con los criterios especificados.</p>
            <p>Verifica que el ID del artículo sea correcto (1, 2, o 3).</p>
        </div>
        <div class="blog-meta">
            Consulta ejecutada - Sin resultados
        </div>
    </div>
    <div class="blog-card">
        <a href="index.php" class="read-more">← Volver al inicio</a>
    </div>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>
