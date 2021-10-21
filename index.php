<?php 
  include_once("controller/index.php");
?>

<!DOCTYPE html>
<html lang="es-ES">

<head>
  <meta charset="UTF-8">
  <meta name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="css/style.css">
  <script src="js/main.js" defer></script>
  <title>Gestor de Analiticas</title>
</head>

<body>
  <main class="container">
    <h1>Analiticas</h1>
    <section>
      <article>
        <h2>Usuarios</h2>
        <?= form("user", "1") ?>
      </article>
      <article>
        <h2>Número de páginas visitadas</h2>
        <?= form("npages", "2") ?>
      </article>
      <article>
        <h2>Últimas urls visitadas</h2>
        <?= form("lastUrl", "3") ?>
      </article>
      <article>
        <h2>Urls más visitadas</h2>
        <?= form("mostUrl", "4") ?>
      </article>
      <article class="download-container">
        <?php 
          if(empty($download)){
        ?>
        <h2>Generar Informe</h2>
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
          <button class="btn success" name="btn_download">Generar</button>
        </form>
        <?php 
          } else 
            echo "<h2>Descargar Informe</h2>";
            echo !empty($download)? $download : "";
            $download="";
        ?>
      </article>
    </section>
  </main>
</body>

</html>