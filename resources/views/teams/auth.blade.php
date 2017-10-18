<?php session_start(); ?>
<html>
    <head>
        <script src="https://statics.teams.microsoft.com/sdk/v1.0/js/MicrosoftTeams.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <script type='text/javascript'>
            var token = "{{ $token }}";

            $(document).ready(function() {
                microsoftTeams.initialize();
                microsoftTeams.authentication.notifySuccess(token);
            });
        </script>
    </head>

    <body>
        <?php
            setcookie('msteams-token', $token);
            setcookie('msteams-id', $id);
        ?>
    </body>
</html>
