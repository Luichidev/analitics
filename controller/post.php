<?php 
  if($_SERVER['REQUEST_METHOD'] === "POST"){
    $uploadFileDir  = "resources/";
    $download = "";
    
    if(isset($_POST['btn_user'])){
      if (isset($_FILES['user_upload']) && $_FILES['user_upload']['error'] === UPLOAD_ERR_OK) {
        $fileName = $_FILES['user_upload']['name'];
        $dest_path = $uploadFileDir  . basename($fileName);
        if(move_uploaded_file($_FILES['user_upload']['tmp_name'], $dest_path)){
          $_SESSION['user_msg'] = "<p class=\"alert success\">Archivo subido correctamente 👌<p>";
          $_SESSION['userFileName'] = $fileName;
          Table::format($dest_path);
        } else 
          $_SESSION['user_msg'] = "<p>Fallo al subir el archivo ⛔<p>";
      } else 
        $_SESSION['user_msg'] = "<p class=\"error\">*Selecciona un archivo</p>";
    }
    if(isset($_POST['btn_npages'])){
      if (isset($_FILES['npages_upload']) && $_FILES['npages_upload']['error'] === UPLOAD_ERR_OK) {
        $fileName = $_FILES['npages_upload']['name'];
        $dest_path = $uploadFileDir  . basename($fileName);
        if(move_uploaded_file($_FILES['npages_upload']['tmp_name'], $dest_path)){
          $_SESSION['npages_msg'] = "<p class=\"alert success\">Archivo subido correctamente 👌<p>";
          $_SESSION['npagesFileName'] = $fileName;
          Table::format($dest_path);
        } else 
          $_SESSION['npages_msg'] = "<p>Fallo al subir el archivo ⛔<p>";
      } else 
        $_SESSION['npages_msg'] = "<p class=\"error\">*Selecciona un archivo</p>";
    }
    
    if(isset($_POST['btn_lastUrl'])){
      if (isset($_FILES['lastUrl_upload']) && $_FILES['lastUrl_upload']['error'] === UPLOAD_ERR_OK) {
        $fileName = $_FILES['lastUrl_upload']['name'];
        $dest_path = $uploadFileDir  . basename($fileName);
        if(move_uploaded_file($_FILES['lastUrl_upload']['tmp_name'], $dest_path)){
          $_SESSION['lastUrl_msg'] = "<p class=\"alert success\">Archivo subido correctamente 👌<p>";
          $_SESSION['lastUrlFileName'] = $fileName;
          Table::format($dest_path);
        } else 
          $_SESSION['lastUrl_msg'] = "<p>Fallo al subir el archivo ⛔<p>";
      } else 
        $_SESSION['lastUrl_msg'] = "<p class=\"error\">*Selecciona un archivo</p>";
    }
    
    if(isset($_POST['btn_mostUrl'])){
      if (isset($_FILES['mostUrl_upload']) && $_FILES['mostUrl_upload']['error'] === UPLOAD_ERR_OK) {
        $fileName = $_FILES['mostUrl_upload']['name'];
        $dest_path = $uploadFileDir  . basename($fileName);
        if(move_uploaded_file($_FILES['mostUrl_upload']['tmp_name'], $dest_path)){
          $_SESSION['mostUrl_msg'] = "<p class=\"alert success\">Archivo subido correctamente 👌<p>";
          $_SESSION['mostUrlFileName'] = $fileName;
          Table::format($dest_path);
        } else 
        $_SESSION['mostUrl_msg'] = "<p>Fallo al subir el archivo ⛔<p>";
      } else 
      $_SESSION['mostUrl_msg'] = "<p class=\"error\">*Selecciona un archivo</p>";
    }

    if(isset($_POST['btn_download'])){
      Table::array_to_csv();
      $download = "<a href=\"public/analitics.csv\" class=\"btn success\" download>Descargar 🔽</a>";
    }
  }

?>