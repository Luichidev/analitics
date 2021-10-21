<?php 

  if($_SERVER['REQUEST_METHOD'] === "GET"){
    if(isset($_GET['rg'])){
      if($_GET['rg'] === "1" AND !empty($_SESSION['userFileName'])){
        $file = "resources/{$_SESSION['userFileName']}";
        $users = Table::insertUsers($file, "users", ['ID ', ' Email  ', 'OneKeyCode']); 
        unset($_SESSION['userFileName']);
        $users
          ? $_SESSION['user_msg'] = "<p>Se ha registrado los usuarios en la base de datos 👌<p>"
          : $_SESSION['user_msg'] = "<p>No hay usuarios nuevos ⛔<p>";
      } elseif ($_GET['rg'] === "2" AND !empty($_SESSION['npagesFileName'])) {
        $file = "resources/{$_SESSION['npagesFileName']}";
        $visits = Table::insertVisits($file, "visits"); 
        unset($_SESSION['npagesFileName']);
        $visits
          ? $_SESSION['npages_msg'] = "<p>Se ha registrado el archivo en la base de datos 👌<p>"
          : $_SESSION['npages_msg'] = "<p>No hay registros nuevos ⛔<p>";  
      } elseif ($_GET['rg'] === "3" AND !empty($_SESSION['lastUrlFileName'])) {
        $file = "resources/{$_SESSION['lastUrlFileName']}";
        $last_visits = Table::insertLastVisits($file, "lastvisits"); 
        unset($_SESSION['lastUrlFileName']);
        $last_visits
          ? $_SESSION['lastUrl_msg'] = "<p>Se ha registrado el archivo en la base de datos 👌<p>"
          : $_SESSION['lastUrl_msg'] = "<p>No hay registros nuevos ⛔<p>";  
      } elseif ($_GET['rg'] === "4" AND !empty($_SESSION['mostUrlFileName'])) {
        $file = "resources/{$_SESSION['mostUrlFileName']}";
        $most_visited = Table::insertMostVisits($file, "mostvisited"); 
        unset($_SESSION['mostUrlFileName']);
        $most_visited
          ? $_SESSION['mostUrl_msg'] = "<p>Se ha registrado el archivo en la base de datos 👌<p>"
          : $_SESSION['mostUrl_msg'] = "<p>No hay registros nuevos ⛔<p>";  
      }
      
      
    }
  }

?>