<?php session_start(); ?>
<html>
    <head>
        <script src="https://statics.teams.microsoft.com/sdk/v1.0/js/MicrosoftTeams.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>

        <link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">

        <script type='text/javascript'>
            var userId = "{{ $id }}";

            $(document).ready(function() {
                $("#slides").bxSlider({
                    infiniteLoop: false,
                    controls: false,
                    pager: false,
                    auto: true,
                    pause: 3000,
                    speed: 1000,
                    slideWidth: 400
                });


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
                            // $('#loading').hide();
                            $('#success').show();

                            // setTimeout(function() {
                            //     microsoftTeams.authentication.notifySuccess();
                            // }, 2000);
                        });
                });

                $('.css_btn_class').click(function() {
                    microsoftTeams.authentication.notifySuccess();
                })
            });
        </script>

        <style>
            body {
                background-color: #3c98ff;
            }

            p {
                color: white;
                font-size: 30px;
                font-family: 'PT Sans', sans-serif;
                position: relative;
                left: 35%;
            }

            #success {
                margin-top: 400px;
                left: 48%;
                position: relative;
                display: none;
            }

            .bx-wrapper {
                border: 1px solid white;
                position: absolute;
                left: 35%;
            }

.css_btn_class {
    font-size:16px;
    font-family:Arial;
    font-weight:normal;
    -moz-border-radius:8px;
    -webkit-border-radius:8px;
    border-radius:8px;
    border:1px solid #dcdcdc;
    padding:9px 18px;
    text-decoration:none;
    background:-moz-linear-gradient( center top, #ededed 5%, #dfdfdf 100% );
    background:-ms-linear-gradient( top, #ededed 5%, #dfdfdf 100% );
    filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ededed', endColorstr='#dfdfdf');
    background:-webkit-gradient( linear, left top, left bottom, color-stop(5%, #ededed), color-stop(100%, #dfdfdf) );
    background-color:#ededed;
    color:#777777;
    display:inline-block;
    text-shadow:1px 1px 0px #ffffff;
    -webkit-box-shadow:inset 1px 1px 0px 0px #ffffff;
    -moz-box-shadow:inset 1px 1px 0px 0px #ffffff;
    box-shadow:inset 1px 1px 0px 0px #ffffff;
}.css_btn_class:hover {
    background:-moz-linear-gradient( center top, #dfdfdf 5%, #ededed 100% );
    background:-ms-linear-gradient( top, #dfdfdf 5%, #ededed 100% );
    filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#dfdfdf', endColorstr='#ededed');
    background:-webkit-gradient( linear, left top, left bottom, color-stop(5%, #dfdfdf), color-stop(100%, #ededed) );
    background-color:#dfdfdf;
}.css_btn_class:active {
    position:relative;
    top:1px;
}
        </style>
    </head>

    <body>
        <div id='loading' style='font-size: 20px; margin-top: 100px'>
            <p>Setting up your GoodTalk Team</p>
            <div id='slides'>
                <img src="{{ asset('images/onboard/1.png') }}"/>
                <img src="{{ asset('images/onboard/2.png') }}"/>
                <img src="{{ asset('images/onboard/3.png') }}"/>
                <img src="{{ asset('images/onboard/4.png') }}"/>
            </div>
        </div>
        <div id='success'><a href="#" class="css_btn_class">Finished</a></div>
    </body>
</html>
