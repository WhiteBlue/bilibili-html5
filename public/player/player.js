/**
 * Created by WhiteBlue on 15/9/14.
 */

$(document).ready(function () {
        load_object = {
            data_insert: [
                '插入栓 插入',
                '播放传导系统 准备接触',
                '探针插入 完毕',
                '神经同调装置在基准范围内',
                '插入栓注水',
                '播放器界面连接',
                '同步率为100%'
            ],
            insert_i: 0,
            main_container: $('#video_container'),
            loading_element: $('#loading'),
            player: null
        };

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

        var id_container = $('#video_info');
        var aid = id_container.attr('aid');
        var cid = id_container.attr('cid');

        $('#btn_launch_low').click(function () {
            $.get("/video/0?aid=" + aid + "&cid=" + cid,
                function (data, status) {
                    if (data.code == 'success') {
                        launchPlayer();
                        load_object.player.loadSrc(data.content);
                        load_object.player.loadDanmaku('http://comment.bilibili.cn/' + cid + '.xml');
                        //load_object.player.loadPoster(data.content.img);
                    } else {
                        printLoadingMessage('<p class="alert_content">出现未知异常,同步率下降,请尝试刷新页面</p>');
                    }
                }
            );
        });

        $('#btn_launch_mid').click(function () {


            $.get("/video/1?aid=" + aid + "&cid=" + cid,
                function (data, status) {
                    if (data.code == 'success') {
                        launchPlayer();
                        load_object.player.loadSrc(data.content);
                        load_object.player.loadDanmaku('http://comment.bilibili.cn/' + cid + '.xml');
                        //load_object.player.loadPoster(data.content.img);
                    } else {
                        printLoadingMessage('<p class="alert_content">出现未知异常,同步率下降,请尝试刷新页面</p>');
                    }
                }
            );
        });

        $('#btn_launch_high').click(function () {
            $.get("/video/3?aid=" + aid + "&cid=" + cid,
                function (data, status) {
                    if (data.code == 'success') {
                        launchPlayer();
                        load_object.player.loadSrc(data.content);
                        load_object.player.loadDanmaku('http://comment.bilibili.cn/' + cid + '.xml');
                        //load_object.player.loadPoster(data.content.img);
                    } else {
                        printLoadingMessage('<p class="alert_content">出现未知异常,同步率下降,请尝试刷新页面</p>');
                    }
                }
            );
        });


    }
);