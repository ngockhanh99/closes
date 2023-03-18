<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{--<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">--}}
    {{--<link rel="stylesheet" type="text/css" href="<?php echo url('') ?>/css/bootstrap-notifications.min.css">--}}
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">



    <!-- jQuery 2.2.3 -->
    <script src="<?php echo url('theme') ?>/plugins/jQuery/jquery-2.2.3.min.js"></script>
    {{--<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>--}}
    <script src="//js.pusher.com/3.1/pusher.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .chat {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .chat li {
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px dotted #B3A9A9;
        }

        .chat li .chat-body p {
            margin: 0;
            color: #777777;
        }

        .panel-body {
            overflow-y: scroll;
            height: 350px;
        }

        ::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
            background-color: #F5F5F5;
        }

        ::-webkit-scrollbar {
            width: 12px;
            background-color: #F5F5F5;
        }

        ::-webkit-scrollbar-thumb {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
            background-color: #555;
        }
    </style>
    <script type="text/javascript">
        $( document ).ready(function() {
            var dataMessages = [];
            $.get("/par_index_v2/messages", function(data, status){
                dataMessages = data;
                for (var i in dataMessages) {
                    var html ="<li class=\"left clearfix\" >" +
                        "                                    <div class=\"chat-body clearfix\">\n" +
                        "                                        <div class=\"header\">\n" +
                        "                                            <strong class=\"primary-font\">\n" +
                        "\n" + dataMessages[i].user.user_name +
                        "                                            </strong>\n" +
                        "                                        </div>\n" +
                        "                                        <p>\n" +
                        "\n" + dataMessages[i].message +
                        "                                        </p>\n" +
                        "                                    </div>\n" +
                        "                                </li>";
                    $('#chat').append(html);
                }

            });

            // Subscribe to the channel we specified in our Laravel Event
            var pusher_a = new Pusher('3ba6cdaed87af67b876d', {
                cluster: 'ap1',
                forceTLS: true,
                encrypted: true
            });
            var channel_a = pusher_a.subscribe('chat');
            // Bind a function to a Event (the full Laravel class)
            channel_a.bind('App\\Events\\MessageSent', function(data) {
                console.log(data);
                var html ="<li class=\"left clearfix\" >" +
                    "                                    <div class=\"chat-body clearfix\">\n" +
                    "                                        <div class=\"header\">\n" +
                    "                                            <strong class=\"primary-font\">\n" +
                    "\n" + data.user.user_name +
                    "                                            </strong>\n" +
                    "                                        </div>\n" +
                    "                                        <p>\n" +
                    "\n" + data.message.message +
                    "                                        </p>\n" +
                    "                                    </div>\n" +
                    "                                </li>";
                $('#chat').append(html);
            });

            $('#btn-chat').click(function(){
                var message = $('#btn-input').val();
                $('#btn-input').val('');
                $.post("/par_index_v2/messages", {'message' : message}, function(data, status){


                });
            });
        });

    </script>
</head>
<body>
<div id="app">


    <main class="py-4">


        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Chats</div>

                        <div class="panel-body">
                            <ul id="chat" class="chat">

                            </ul>
                        </div>
                        <div class="panel-footer">
                            <div class="input-group">
                                <input id="btn-input" type="text" name="message" class="form-control input-sm"
                                       placeholder="Type your message here..." >
                                <span class="input-group-btn">
                                    <button class="btn btn-primary btn-sm" id="btn-chat">
                                        Send
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
</body>
</html>
