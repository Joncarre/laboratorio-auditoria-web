<?php
// Creado por Jonathan Carrero (jonathan.carrero@alumnos.ui1.es)
require_once 'config/database.php';
require_once 'includes/header.php';


// SOLUCIÓN 2: Validación estricta del parámetro de entrada
$article_exists = false;
$error = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    if (!ctype_digit($id) || (int)$id <= 0) {
        $error = "ID de artículo inválido. Debe ser un número entero positivo.";
    } else {
        $id = (int)$id;
        
        try {
            $query = "SELECT id FROM blog WHERE id = " . $id;
            $result = $pdo->query($query);
            
            if ($result && $result->rowCount() > 0) {
                $article_exists = true;
            } else {
                $article_exists = false;
            }
            
        } catch(PDOException $e) {
            $article_exists = false;
            $error = "Error al procesar la consulta.";
        }
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
            <p><strong>✅ SEGURO:</strong> Esta aplicación ha sido protegida contra SQL Injection mediante validación de input.</p>
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
