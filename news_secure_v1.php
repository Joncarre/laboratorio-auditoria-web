<?php
// Creado por Jonathan Carrero (jonathan.carrero@alumnos.ui1.es)
require_once 'config/database.php';
require_once 'includes/header.php';

// SOLUCIÓN 1: Uso de Prepared Statements con parámetros vinculados
$article_exists = false;
$error = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    try {

        $query = "SELECT id FROM blog WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id]);
        
        // Verificar si existe resultado
        if ($stmt->rowCount() > 0) {
            $article_exists = true;
        } else {
            $article_exists = false;
        }
        
    } catch(PDOException $e) {
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
            <p><strong>✅ SEGURO:</strong> Esta aplicación ha sido protegida contra SQL Injection usando Prepared Statements.</p>
        </div>
        <div class="blog-meta">
            Consulta ejecutada de forma segura
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
            Consulta ejecutada de forma segura
        </div>
    </div>
    <div class="blog-card">
        <a href="index.php" class="read-more">← Volver al inicio</a>
    </div>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>
