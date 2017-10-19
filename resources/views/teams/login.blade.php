<html>
    <head>
        <script src="https://statics.teams.microsoft.com/sdk/v1.0/js/MicrosoftTeams.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">

        <script type='text/javascript'>
            const WIDTH = 1150;
            const HEIGHT = 650;

            $(document).ready(function() {
                microsoftTeams.initialize();

                microsoftTeams.settings.registerOnSaveHandler(function(saveEvent){
                    microsoftTeams.settings.setSettings({
                        entityId: "goodtalk",
                        contentUrl: "https://obiwong.ngrok.io/teams",
                        suggestedDisplayName: "GoodTalk",
                        websiteUrl: "https://obiwong.ngrok.io/teams"
                    });

                    saveEvent.notifySuccess();
                });

                $('#signin').on('click', function() {
                    microsoftTeams.authentication.authenticate({
                        url: getAuthUrl(),
                        width: WIDTH,
                        height: HEIGHT,
                        successCallback: function(token) {
                            // $('#container').hide();
                            $('#container').addClass('animated hinge');
                            $('#success').show();
                            microsoftTeams.settings.setValidityState(true);
                        },
                        failureCallback: function() {
                            microsoftTeams.settings.setValidityState(false);
                        }
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
                width: 300px;
                height: 50px;
                cursor: pointer;
            }

            #success {
                display: none;
                text-align: center;
                font-size: 20px;
            }
        </style>
    </head>

    <body>
        <div id='container'>
            <p>You'll need to sign in with Microsoft to validate your identity and say things with GreatTalk!</p>
            <img id='signin' src='https://developer.microsoft.com/en-us/graph/vendor/bower_components/explorer/assets/images/MSSignInButton.svg'/>
        </div>
        <div id='success'>
            You did it! Click save to go to your GoodTalk tab!
        </div>
    </body>
</html>
