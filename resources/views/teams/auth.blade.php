<?php session_start(); ?>
<html>
    <head>
        <script src="https://statics.teams.microsoft.com/sdk/v1.0/js/MicrosoftTeams.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <script type='text/javascript'>
            var userId = "{{ $id }}";

            $(document).ready(function() {
                microsoftTeams.initialize();

                microsoftTeams.getContext(function(context) {
                    var url = 'https://obibot.ngrok.io/channel/hack';
                    var data = {
                        channel_id: context.channelId,
                        user_id: userId,
                        tenant_id: context.tid
                    };

                    $.post(url, data)
                        .always(function(data) {
                            $('#loading').hide();
                            $('#success').show();

                            setTimeout(function() {
                                microsoftTeams.authentication.notifySuccess();
                            }, 2000);
                        });
                });
            });
        </script>

        <style>
            body {
                /*background-image: linear-gradient(to right,#9DA7E0 0,#69D5C3 100%);*/
            }

            #success {
                display: none;
            }
        </style>
    </head>

    <body>
        <div id='loading' style='text-align: center; font-size: 20px; margin-top: 200px'>
            Setting up your GoodTalk team!<br/>
            <img src='https://media.giphy.com/media/UnwFs36CPo29q/giphy.gif'/>
        </div>
        <div id='success' style='text-align: center; font-size: 20px; margin-top: 15px'>
            <img src='https://cdn.dribbble.com/users/159981/screenshots/2112264/checkmark.gif'/>
        </div>
    </body>
</html>
