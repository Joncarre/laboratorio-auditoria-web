<?php
require_once 'config/database.php';
require_once 'includes/header.php';

// CÓDIGO VULNERABLE A SQL INJECTION CLÁSICO
// Muestra todos los resultados de la consulta

$articles = [];
$error = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    try {
        // VULNERABILIDAD: Concatenación directa sin escape
        $query = "SELECT id, title, body, datetime FROM blog WHERE id = " . $id;
        
        $result = $pdo->query($query);
        
        // Obtener TODOS los resultados (permite ver inyecciones exitosas)
        $articles = $result->fetchAll(PDO::FETCH_ASSOC);
        
    } catch(PDOException $e) {
        $error = "Error SQL: " . $e->getMessage();
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
<?php elseif (empty($articles)): ?>
    <div class="blog-card">
        <h1 class="blog-title">Artículo No Encontrado</h1>
        <div class="blog-excerpt">
            <p>No se encontraron artículos con el ID especificado.</p>
            <p>Verifica que el ID del artículo sea correcto (1, 2, o 3).</p>
        </div>
        <div class="blog-meta">
            Consulta ejecutada - Sin resultados
        </div>
    </div>
    <div class="blog-card">
        <a href="index.php" class="read-more">← Volver al inicio</a>
    </div>
<?php else: ?>
    <?php foreach ($articles as $article): ?>
        <div class="blog-card">
            <h1 class="blog-title"><?php echo htmlspecialchars($article['title']); ?></h1>
            <div class="blog-excerpt">
                <?php echo nl2br(htmlspecialchars($article['body'])); ?>
            </div>
            <div class="blog-meta">
                <strong>ID:</strong> <?php echo htmlspecialchars($article['id']); ?> | 
                <strong>Fecha:</strong> <?php echo htmlspecialchars($article['datetime']); ?>
            </div>
        </div>    <?php endforeach; ?>
    <div class="blog-card">
        <a href="index.php" class="read-more">← Volver al inicio</a>
    </div>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>
