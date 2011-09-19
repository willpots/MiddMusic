<?php

setrawcookie("mu_id", "blank", time()-3600);	
setrawcookie("mu_user", "blank", time()-3600);
setrawcookie("mu_admin", "true", time()-3600);

header("Location: http://middmusic.com");

?>

