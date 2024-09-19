<?php
    // Traigo todos los valores del archivo .env
    if ( ($env = parse_ini_file('.env')) === false )
        die('Por favor, configure el servidor');
?>
<html lang="es">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Acceso a WiFi de MVL</title>
  </head>
  <body>
    <h2>Redirigiendo al portal de acceso ...</h2>
    <script src="node_modules/js-cookie/dist/js.cookie.min.js"></script>
    <script src="node_modules/keycloak-js/dist/keycloak.min.js"></script>
    <script>
      function saveRedirectUri() {

      }

      function saveRedirectUri() {
        
      }
      // El acceso al OIDC de MVL
      async function initKeycloak() {
        debugger;
        keycloak = new Keycloak({
            url: "<?=$env['KEYCLOAK_SERVER']?>",
            realm: "<?=$env['KEYCLOAK_REALM']?>",
            clientId: "<?=$env['KEYCLOAK_CLIENT']?>",
            cors: true,
        });

        keycloak.onAuthSuccess = () => console.log('Authenticated!');

        isAuthenticated = await keycloak.init({
          checkLoginIframe: false,
        });
        <?php
        if( $env['MODE'] === 'development' ) {
        ?>
        //keycloak.logout();
        <?php
        }
        ?>
        if ( !isAuthenticated )
          keycloak.login();
        else {
          debugger;
          const urlParams = new URLSearchParams(window.location.search);
          const baseGrantURL = urlParams.get('base_grant_url');
          window.location.href = baseGrantURL ?? "<?=$env['OK_REDIRECT_URI']?>"
        }
      }
      // El disparador principal
      document.addEventListener("DOMContentLoaded", function(event) { 
        initKeycloak();
      });
    </script>
  </body>
</html>