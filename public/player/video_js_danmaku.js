/**
 * Created by WhiteBlue on 15/9/14.
 */

function loadPlayer(player_id, load_function, ready_function) {
    var video_element = document.getElementById(player_id);

    if (video_element) {
        try {
            var myPlayer = videojs('player');

            //播放器隐藏
            //myPlayer.hide();

            //videoJs按钮加载
            var myButton = myPlayer.controlBar.addChild('button');
            myButton.addClass("vjs-menu-button danmaku_btn");

            var player_unit = {
                //base element
                player_element: document.getElementById(player_id),
                //video.js 核心
                player_core: myPlayer,
                //总时间初始化
                all_time: myPlayer.duration(),
                //播放列表
                play_list: [],
                //加载标签
                video_load: false,
                //CCL核心
                CM_core: null,
                //弹幕库加载
                danmaku_flag: true,
                /**
                 * load a video poster
                 *
                 * @param poster_src
                 */
                loadPoster: function (poster_src) {
                    this.player_core.poster(poster_src);
                },
                /**
                 * load a video source file(mp4)
                 *
                 * @param source_src
                 */
                loadSrc: function (source_src) {
                    if (this.CM_core) {
                        this.CM_core.clear();
                        this.CM_core.stop();
                    }
                    this.player_core.src(source_src);
                },
                /**
                 * load a danmaku xml file...
                 *
                 * @param danmaku_src
                 */
                loadDanmaku: function (danmaku_src) {
                    if (!this.CM_core) {
                        load_danmaku(this);
                    }
                    CommentLoader(danmaku_src, this.CM_core);
                },
                /**
                 *
                 * loading function
                 *
                 */
                loadingFunction: function () {
                    load_function();
                },
                /**
                 * loading ready function
                 */
                readyFunction: function () {
                    ready_function();
                }
            };

            //load process event
            player_unit.player_core.on('progress', function () {
                player_unit.loadingFunction();
            });

            //load process event
            player_unit.player_core.on('loadedmetadata', function () {
                player_unit.video_load = true;
                player_unit.readyFunction();
            });

            //show player
            player_unit.player_core.show();

            return player_unit;

        } catch (e) {
            alert('Error found when init:' + e);
        }

    } else {
        alert('Whoops!! Element not found....');
    }
}

function load_danmaku(player_unit) {
    //ccl init
    player_unit.CM_core = new CommentManager(player_unit.player_element);
    player_unit.CM_core.init();

    //play event
    player_unit.player_core.on('play', function () {
        if (player_unit.danmaku_flag) {
            player_unit.CM_core.start();
        }
    });
    player_unit.player_core.on('pause', function () {
        if (player_unit.danmaku_flag) {
            player_unit.CM_core.stop();
        }
    });

    //time update(important!!!)
    player_unit.player_core.on('timeupdate', function () {
        if (player_unit.danmaku_flag) {
            player_unit.CM_core.time(Math.floor(this.currentTime() * 1000));
        }
    });

    //time seeked(clear damaku)
    player_unit.player_core.on('seeked', function () {
        if (player_unit.danmaku_flag) {
            player_unit.CM_core.clear();
        }
    });


    player_unit.player_core.on('ended', function () {
        if (player_unit.CM_core) {
            player_unit.CM_core.clear();
            player_unit.CM_core.finish();
        }
    });

    //danmaku_button bind
    document.getElementsByClassName('danmaku_btn')[0].addEventListener('click', function () {
        if (player_unit.danmaku_flag) {
            player_unit.CM_core.stop();
            player_unit.CM_core.clear();
            player_unit.danmaku_flag = false;
        } else {
            player_unit.CM_core.start();
            player_unit.danmaku_flag = true;
        }
    });

}
