<?php
// Creado por Jonathan Carrero (jonathan.carrero@alumnos.ui1.es)
require_once 'config/database.php';
require_once 'includes/header.php';

// Página simple para mostrar usuarios (para ejercicios futuros)
try {
    $stmt = $pdo->prepare("SELECT id, name, email FROM users ORDER BY name");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo '<div class="alert">Error al cargar los usuarios: ' . $e->getMessage() . '</div>';
    $users = [];
}
?>

<div class="blog-card">
    <h2 class="blog-title">👥 Lista de Usuarios</h2>
    <div class="blog-excerpt">
        Esta sección muestra la lista de usuarios registrados en el sistema.
    </div>
</div>

<div class="blog-grid">
    <?php if (!empty($users)): ?>
        <?php foreach ($users as $user): ?>
            <div class="blog-card">
                <h3 class="blog-title"><?php echo htmlspecialchars($user['name']); ?></h3>
                <div class="blog-excerpt">
                    <strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?><br>
                    <strong>ID:</strong> <?php echo htmlspecialchars($user['id']); ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert">
            No hay usuarios registrados en este momento.
        </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>
