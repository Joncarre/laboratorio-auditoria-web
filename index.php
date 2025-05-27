<?php
require_once 'config/database.php';
require_once 'includes/header.php';

try {
    // Obtener todos los artículos del blog
    $stmt = $pdo->prepare("SELECT id, title, body, datetime FROM blog ORDER BY datetime DESC");
    $stmt->execute();
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo '<div class="alert">Error al cargar los artículos: ' . $e->getMessage() . '</div>';
    $articles = [];
}
?>

<div class="blog-grid">
    <?php if (!empty($articles)): ?>
        <?php foreach ($articles as $article): ?>
            <div class="blog-card">
                <h2 class="blog-title">
                    <a href="news.php?id=<?php echo htmlspecialchars($article['id']); ?>">
                        <?php echo htmlspecialchars($article['title']); ?>
                    </a>
                </h2>
                <div class="blog-excerpt">
                    <?php echo htmlspecialchars(substr($article['body'], 0, 200)) . '...'; ?>
                </div>
                <div class="blog-meta">
                    <span><?php echo date('d/m/Y H:i', strtotime($article['datetime'])); ?></span>
                    <a href="news.php?id=<?php echo htmlspecialchars($article['id']); ?>" class="read-more">
                        Leer más
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert">
            No hay artículos disponibles en este momento.
        </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>
