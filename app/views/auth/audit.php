<?php if (!defined('BASE_URL')) require_once __DIR__ . '/../../config.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Auditoría - Auditoria</title>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/styleLogin.css?v=1.0.3">
  <style>
    table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 14px; }
    th, td { padding: 12px; border: 1px solid #334155; text-align: left; }
    th { background: #1e40af; color: white; }
    tr:nth-child(even) { background: #151c26; }
    tr:hover { background: #1e293b; }
  </style>
</head>
<body>
  <div class="bg-grid"></div>
  <div class="glow-orb orb1"></div>

  <div class="container">
    <div class="card">
      <h1>Auditoría del Sistema</h1>

      <?php if (empty($logs)): ?>
        <p style="text-align: center; color: #94a3b8;">No hay registros de auditoría aún.</p>
      <?php else: ?>
        <table>
          <thead>
            <tr>
              <th>Evento</th>
              <th>Email</th>
              <th>IP</th>
              <th>Fecha</th>
              <th>Detalles</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($logs as $log): ?>
            <tr>
              <td><?= htmlspecialchars($log['event'] ?? '—') ?></td>
              <td><?= htmlspecialchars($log['email'] ?? '—') ?></td>
              <td><?= htmlspecialchars($log['ip'] ?? '—') ?></td>
              <td><?= htmlspecialchars($log['created_at'] ?? '—') ?></td>
              <td><?= htmlspecialchars($log['details'] ?? 'Sin detalles') ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>

      <p style="text-align: center; margin-top: 30px;">
        <a href="<?= BASE_URL ?>/index.php?controller=dashboard&action=index" style="color: #60A5FA; margin-right: 20px;">Volver al Dashboard</a>
        <a href="<?= BASE_URL ?>/index.php?controller=dashboard&action=logout" style="color: #ef4444;">Cerrar sesión</a>
      </p>
    </div>
  </div>
</body>
</html>