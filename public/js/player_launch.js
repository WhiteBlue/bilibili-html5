/**
 * Created by WhiteBlue on 15/9/14.
 */

$(document).ready(function () {
        load_object.main_container = $('.jumbotron');
        load_object.loading_element = $('#loading');

        function printLoadingMessage(message) {
            if (load_object.loading_element) {
                load_object.loading_element.append(message);
            }
        }

        //===========加载相关调用==========
        var loading_function = function () {
            if (!load_object.player.video_load) {
                if (load_object.insert_i < load_object.data_insert.length) {
                    printLoadingMessage('<p>' + load_object.data_insert[load_object.insert_i] + '</p>');
                    load_object.insert_i++;
                }
            }
        };
        var ready_function = function () {
            load_object.loading_element.fadeOut();
        };
        //===============end==============

        function launchPlayer() {
            if (!load_object.player) {
                printLoadingMessage('<p>正在准备播放</p>');
                load_object.player = loadPlayer('player', loading_function, ready_function);
                printLoadingMessage('<p>播放器稳定,视频源装填</p>');
                $('#player_content').show();
            }
        }

        $('#play_1').on('click', function () {
            launchPlayer();
            $.get("/playNormal/" + load_object.aid + "/" + load_object.page,
                function (data, status) {
                    if (data.code == 'success') {
                        load_object.player.loadSrc(data.content.src);
                        load_object.player.loadDanmaku(data.content.cid);
                        load_object.player.loadPoster(data.content.img);
                    } else {
                        printLoadingMessage('<p class="alert_content">出现未知异常,同步率下降,请尝试刷新页面</p>');
                    }
                }
            );
        });

        $('#play_2').on('click', function () {
            launchPlayer();
            $.get("/playHD/" + load_object.cid, function (data, status) {
                if (data.code == 'success') {
                    load_object.player.loadSrc(data.content.url);
                    load_object.player.loadDanmaku(load_object.danmaku_xml);
                    load_object.player.loadPoster(load_object.pic);
                } else {
                    printLoadingMessage('<p class="alert_content">高清源不存在,请尝试低清源</p>');
                }
            });
        });
    }
);