<?php
require_once 'config/database.php';
require_once 'includes/header.php';

// CÓDIGO INTENCIONALMENTE VULNERABLE A SQL INJECTION
// Este código es vulnerable para fines educativos - NO usar en producción

$article = null;
$error = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    try {
        // VULNERABILIDAD: Concatenación directa sin sanitización
        // Esto permite inyección SQL maliciosa
        $query = "SELECT id, title, body, datetime FROM blog WHERE id = " . $id;
        
        $result = $pdo->query($query);
        $article = $result->fetch(PDO::FETCH_ASSOC);
        
        if (!$article) {
            $error = "Artículo no encontrado.";
        }
    } catch(PDOException $e) {
        $error = "Error en la consulta SQL.";
        // En un entorno real, no se debería mostrar el error específico
        // pero para fines educativos, lo comentamos:
        // $error .= " Detalles: " . $e->getMessage();
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
<?php elseif ($article): ?>    <div class="blog-card">
        <h1 class="blog-title"><?php echo htmlspecialchars($article['title']); ?></h1>
        <div class="blog-meta" style="margin-bottom: 20px;">
            <span>Publicado: <?php echo date('d/m/Y H:i', strtotime($article['datetime'])); ?></span>
            <span>ID: <?php echo htmlspecialchars($article['id']); ?></span>
        </div>
        <div class="blog-excerpt" style="white-space: pre-line; line-height: 1.8;">
            <?php echo htmlspecialchars($article['body']); ?>
        </div>
        <div style="margin-top: 30px;">
            <a href="index.php" class="read-more">← Volver al inicio</a>
        </div>
    </div>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>
