<?php
require_once '../../models/conexion.php';


$stmt = $pdo->query("SELECT id, name, image_url FROM countries ORDER BY id ASC");
$countries = $stmt->fetchAll(PDO::FETCH_ASSOC);


$descriptions = [
  'japan' => 'エンジニアリングとエンジンにおける革新と精度。',
  'united-states' => 'A global leader in technology and development.',
  'china' => '產品種類豐富，生產規模龐大。',
  'argentina' => 'Calidad y tradición en agronomía y alimentos, no seas boludo.'
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Choose your country</title>
  <link href="../../assets/bootstrap.min.css" rel="stylesheet">
  <link href="../../assets/store.css" rel="stylesheet">
</head>
<body class="bg-dark text-light d-flex flex-column justify-content-center align-items-center min-vh-100">

  <div class="text-center mb-5">
    <h1 class="fw-bold display-5 text-gradient">Choose the country from which you would like to import</h1>
    <p class="text-muted">Explore unique products from every corner of the world</p>
  </div>

  <div class="country-grid">
    <?php foreach ($countries as $country):
          $img = htmlspecialchars($country['image_url']);
          $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9]+/', '-', $country['name']), '-'));
          $desc = $descriptions[$slug] ?? 'Explorá nuestros productos destacados.';
    ?>
      <a href="/ecom/views/frontend/countries/<?= $slug ?>.php" class="country-card" title="<?= htmlspecialchars($country['name']) ?>">
        <div class="flag-wrapper">
          <img src="../../<?= $img ?>" alt="<?= htmlspecialchars($country['name']) ?>" class="country-img">
        </div>
        <span class="country-name"><?= htmlspecialchars($country['name']) ?></span>
        <p class="country-desc"><?= htmlspecialchars($desc) ?></p>
      </a>
    <?php endforeach; ?>
  </div>

</body>
</html>
