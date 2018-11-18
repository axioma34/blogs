<!doctype html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>Laravel</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <label for="response" class="control-label">Api response:</label>
            <textarea  style="height: 180px" id="response" name="token" type="text" class="col-md-12"></textarea>
            <button id="logout" class="btn btn-danger col-md-5" style="margin-top: 10px">Выйти (Logout) </button>
        </div>
        <div class="col-md-6" style="margin-top: 30px">
            <div class="row" style="margin-bottom: 10px">
                <button id="auth" class="btn btn-primary col-md-5" style="margin-right: 10px">Авторизоваться</button>
                <button id="posts" class="btn btn-primary col-md-5">Список постов</button>
            </div>
            <div class="row" style="margin-bottom: 10px">
                <button id="get_post" class="btn btn-primary col-md-5" style="margin-right: 10px">Просмотр поста
                </button>
                <button id="create_post" class="btn btn-primary col-md-5">Создание поста</button>
            </div>
            <div class="row" style="margin-bottom: 10px">
                <button id="delete_post" class="btn btn-primary col-md-5" style="margin-right: 10px">Удаление поста
                </button>
                <button id="get_comments" class="btn btn-primary col-md-5">Список комментариев</button>
            </div>
            <div class="row" style="margin-bottom: 10px">
                <button id="create_comment" class="btn btn-primary col-md-5" style="margin-right: 10px">Добавить
                    комментарий
                </button>
                <button id="delete_comment" class="btn btn-primary col-md-5">Удаление комментария</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>

<!-- Boobox.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>
<script>


    $("#auth").on('click', function () {
        $("#response").empty();
        $.ajax({
            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            },
            type: "POST",
            url: '{!! route('auth') !!}',
            data: {},
            success: function (data) {
                var token = jQuery.parseJSON(data).access_token;
                $.cookie('token', token);
                $("#response").append(data)
            }
        });
    });
    $("#posts").on('click', function () {
        var dialog = bootbox.dialog({
            title: "Choose limit and offset",
            message: '<div class="row"><div class="col-md-6"><label for="limit" class="control-label col-md-3">Limit:</label><input type="number" id="limit" class="text-center"></div>' +
            '<div class="col-md-6"><label for="offset" class="control-label col-md-3">Offset:</label><input type="number" id="offset" class="text-center"></div></div>',
            closeButton: true,
            buttons: {
                ok: {
                    label: "Accept",
                    className: 'btn-success',
                    callback: function (result) {
                        $.ajax({
                            headers: {

                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                            },
                            type: "POST",
                            url: '{!! route('posts') !!}',
                                data: {
                                    limit: $("#limit").val(),
                                    offset: $("#offset").val()
                                },
                            success: function (data) {
                                jsonobj = JSON.parse(data);
                                $("#response").empty();
                                $("#response").append(JSON.stringify(jsonobj,null,'\t'))
                            }
                        });
                    }
                },
                cancel: {
                    label: "Cancel",
                    className: 'btn-danger',
                    callback: function () {
                        dialog.modal('hide');                    }
                }
            }

        })
    });
    $("#get_post").on('click', function () {
        var dialog = bootbox.dialog({
            title: "Enter post id",
            size: 'small',
            message: '<textarea id="post_id" class="col-md-12" style="margin-bottom: 10px"></textarea>',
            closeButton: true,
            buttons: {
                ok: {
                    label: "Accept",
                    className: 'btn-success',
                    callback: function (result) {
                        $.ajax({
                            headers: {

                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                            },
                            type: "POST",
                            url: '{!! route('show_post') !!}',
                            data: {
                                post_id: $("#post_id").val()
                            },
                            success: function (data) {
                                try {
                                    jsonobj = JSON.parse(data);
                                } catch(e) {
                                    alert('Wrong Post ID!');
                                }
                                $("#response").empty();
                                $("#response").append(JSON.stringify(jsonobj,null,'\t'))
                            }
                        });
                    }
                },
                cancel: {
                    label: "Cancel",
                    className: 'btn-danger',
                    callback: function () {
                        dialog.modal('hide');                    }
                }
            }

        })
    });
    $("#create_post").on('click', function () {
        $("#response").empty();
        $.ajax({
            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            },
            type: "POST",
            url: '{!! route('create_post') !!}',
            data: {},
            success: function (data) {
                jsonobj = JSON.parse(data);
                $("#response").append(JSON.stringify(jsonobj,null,'\t'))            }
        });
    });

    $("#delete_post").on('click', function () {
        var dialog = bootbox.dialog({
            title: "Enter post id",
            size: 'small',
            message: '<textarea id="delete_post_id" class="col-md-12" style="margin-bottom: 10px"></textarea>',
            closeButton: true,
            buttons: {
                ok: {
                    label: "Delete",
                    className: 'btn-success',
                    callback: function (result) {
                        $.ajax({
                            headers: {

                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                            },
                            type: "POST",
                            url: '{!! route('delete_post') !!}',
                            data: {
                                post_id: $("#delete_post_id").val()
                            },
                            success: function (data) {
                                try {
                                    jsonobj = JSON.parse(data);
                                } catch(e) {
                                    alert('Wrong Post ID!');
                                }
                                $("#response").empty();
                                $("#response").append(JSON.stringify(jsonobj,null,'\t'))
                            }
                        });
                    }
                },
                cancel: {
                    label: "Cancel",
                    className: 'btn-danger',
                    callback: function () {
                        dialog.modal('hide');                    }
                }
            }

        })
    });


    $("#get_comments").on('click', function () {
        var dialog = bootbox.dialog({
            title: "Enter post id",
            size: 'small',
            message: '<textarea id="comments_post_id" class="col-md-12" style="margin-bottom: 10px"></textarea>',
            closeButton: true,
            buttons: {
                ok: {
                    label: "Accept",
                    className: 'btn-success',
                    callback: function (result) {
                        $.ajax({
                            headers: {

                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                            },
                            type: "POST",
                            url: '{!! route('comments') !!}',
                            data: {
                                post_id: $("#comments_post_id").val()
                            },
                            success: function (data) {
                                try {
                                    jsonobj = JSON.parse(data);
                                } catch(e) {
                                    alert('Wrong Post ID!');
                                }
                                $("#response").empty();
                                $("#response").append(JSON.stringify(jsonobj,null,'\t'))
                            }
                        });
                    }
                },
                cancel: {
                    label: "Cancel",
                    className: 'btn-danger',
                    callback: function () {
                        dialog.modal('hide');                    }
                }
            }

        })
    });

    $("#create_comment").on('click', function () {
        var dialog = bootbox.dialog({
            title: "Enter post id",
            size: 'small',
            message: '<textarea id="create_comment_post_id" class="col-md-12" style="margin-bottom: 10px"></textarea>',
            closeButton: true,
            buttons: {
                ok: {
                    label: "Accept",
                    className: 'btn-success',
                    callback: function (result) {
                        $.ajax({
                            headers: {

                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                            },
                            type: "POST",
                            url: '{!! route('create_comment') !!}',
                            data: {
                                post_id: $("#create_comment_post_id").val()
                            },
                            success: function (data) {
                                try {
                                    jsonobj = JSON.parse(data);
                                } catch(e) {
                                    alert('Wrong Post ID!');
                                }
                                $("#response").empty();
                                $("#response").append(JSON.stringify(jsonobj,null,'\t'))
                            }
                        });
                    }
                },
                cancel: {
                    label: "Cancel",
                    className: 'btn-danger',
                    callback: function () {
                        dialog.modal('hide');                    }
                }
            }

        })
    });
    $("#delete_comment").on('click', function () {
        var dialog = bootbox.dialog({
            title: "Enter comment id",
            size: 'small',
            message: '<textarea id="delete_comment_id" class="col-md-12" style="margin-bottom: 10px"></textarea>',
            closeButton: true,
            buttons: {
                ok: {
                    label: "Delete",
                    className: 'btn-success',
                    callback: function (result) {
                        $.ajax({
                            headers: {

                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                            },
                            type: "POST",
                            url: '{!! route('delete_comment') !!}',
                            data: {
                                comment_id: $("#delete_comment_id").val()
                            },
                            success: function (data) {
                                try {
                                    jsonobj = JSON.parse(data);
                                } catch(e) {
                                    alert('Wrong Comment ID!');
                                }
                                $("#response").empty();
                                $("#response").append(JSON.stringify(jsonobj,null,'\t'))
                            }
                        });
                    }
                },
                cancel: {
                    label: "Cancel",
                    className: 'btn-danger',
                    callback: function () {
                        dialog.modal('hide');                    }
                }
            }

        })
    });

    $("#logout").on('click', function () {
        $("#response").empty();
        $.ajax({
            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            },
            type: "POST",
            url: '{!! route('logout') !!}',
            data: {},
            success: function (data) {
                $("#response").append(data)
            }
        });
    });
</script>