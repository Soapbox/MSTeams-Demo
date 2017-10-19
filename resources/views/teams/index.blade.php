<?php session_start(); ?>
<html>
    <head>
        <script src="https://statics.teams.microsoft.com/sdk/v1.0/js/MicrosoftTeams.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <script type='text/javascript'>
            var channelId;

            $(document).ready(function() {
                microsoftTeams.initialize();

                microsoftTeams.getContext(function(context) {
                    // for (key in context) {
                    //     var field = context[key];

                    //     $('#blarg').append('<p>' + key + ': ' + field + '</p>');
                    // }

                    $.get('https://obiwong.ngrok.io/api/channels?id=' + context.channelId, function(r) {
                        channelId = r.channel.soapbox_channel_id;
                    });
                });
            });

            function getAuthUrl()
            {
                var credentials = {
                    authority: 'https://login.microsoftonline.com/common',
                    authorize_endpoint: '/oauth2/v2.0/authorize',
                    token_endpoint: '/oauth2/v2.0/token',
                    client_id: 'b49e7913-3b3f-4125-adde-2b698fc12c8b',
                    scope: 'User.Read'
                };

                var authUrl = credentials.authority + credentials.authorize_endpoint +
                    '?client_id=' + credentials.client_id +
                    '&response_type=code' +
                    '&scope=' + credentials.scope +
                    '&redirect_uri=https://obiwong.ngrok.io/teams/auth';

                return authUrl;
            }
        </script>

        <style>
            #signin {
                border: 1px solid black;
                width: 265px;
                height: 50px;
                cursor: pointer;
            }
        </style>
    </head>

    <body>
        <div id='blarg'>
        </div>
        <div>
            <?php
                if (isset($_COOKIE['msteams-id']) && isset($_COOKIE['msteams-token'])) {
                    echo "
                        <div style='text-align: center; font-size: 20px;'>
                            <img src='https://media.giphy.com/media/lf9PrYyjFOQta/giphy.gif'/>
                        </div>

                    ";

                    $user = App\Users\User::findByMicrosoftId($_COOKIE['msteams-id']);
                    $res = $api->userJwt($user);
                    $jwt = $res->getDecodedContents()->get('token');
                    $user->setToken($jwt)
                        ->save();
                    $res = $api->generateAutoLogin($user);
                    $data = $res->getDecodedContents();
                    $token = $data->get('token');

                    echo "
                        <script type='text/javascript'>
                            setTimeout(function() {
                                var baseUrl = 'https://obitest.ngrok.io';

                                if (channelId) {
                                    var url = baseUrl + '/channels/' + channelId + '/inbox';
                                } else {
                                    var url = baseUrl;
                                }

                                url += '?autoLogin={$token}';

                                console.log(url);

                                microsoftTeams.navigateCrossDomain(url);
                            }, 2000);
                        </script>
                    ";
                } else {
                    echo "You're not logged in. Do the log in thing please.<br/><br/>";
                    echo "<img id='signin' src='https://developer.microsoft.com/en-us/graph/vendor/bower_components/explorer/assets/images/MSSignInButton.svg'/>";

                    echo "
                        <script type='text/javascript'>
                            $('#signin').on('click', function() {
                                microsoftTeams.authentication.authenticate({
                                    url: getAuthUrl(),
                                    width: 1150,
                                    height: 650,
                                    successCallback: function(token) {
                                        setTimeout(function() {
                                            microsoftTeams.navigateCrossDomain('https://obiwong.ngrok.io/teams');
                                        }, 2000);
                                    },
                                    failureCallback: function() {
                                        console.log('FAILURE');
                                    }
                                });
                            });
                        </script>
                    ";
                }
            ?>
        </div>
    </body>
</html>
