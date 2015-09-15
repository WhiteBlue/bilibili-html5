/**
 * Created by WhiteBlue on 15/9/14.
 */

function loadPlayer(player_id, source_file, xml_file) {
    var video_element = document.getElementById(player_id);

    if (video_element) {
        try {
            //set size
            var width = video_element.clientWidth;
            var height = (width / 16) * 10;
            video_element.setAttribute('height', height);

            var myPlayer = videojs('player');

            //player hide
            myPlayer.hide();

            myPlayer.src({type: "video/mp4", src: source_file});

            //button load
            var myButton = myPlayer.controlBar.addChild('button');
            myButton.addClass("vjs-menu-button danmaku_btn");

            var player_unit = {
                //danmaku_xml_file
                danmaku_xml: xml_file,
                //video source
                source: source_file,
                //base element
                player_element: document.getElementById(player_id),
                //video.js core
                player_core: myPlayer,
                //all time
                all_time: myPlayer.duration(),
                //play video list
                play_list: [],
                //player load flag
                is_load: false,
                //CCL core
                CM_core: null,
                //danmaku_running
                danmaku_flag: true,
                //element core size
                size: {
                    width: width,
                    hetght: height
                },
                //Function : load an poster
                loadPoster: function (poster_src) {
                    this.player_core.poster(poster_src);
                },
                //Function : load an source
                loadSrc: function (source_src) {
                    this.player_core.src(source_src);
                },
                loadDanmaku: function (danmaku_src) {
                    CommentLoader(danmaku_src, this.CM_core);
                    this.CM_core.clear();
                },
                //loading function
                loadingFunction: function () {
                    if (i < data_insert.length) {
                        $('#loading').append('<p>' + data_insert[i] + '</p>');
                        i++;
                    }
                },
                readyFunction: function () {
                    $('#loading').fadeOut('fast');
                }
            };

            //load process event
            player_unit.player_core.on('progress', function () {
                if (!player_unit.is_load && player_unit.loadingFunction) {
                    player_unit.loadingFunction();
                }
            });

            load_danmaku(player_unit);

            return player_unit;

        } catch (e) {
            alert('Error found when init:' + e);
        }

    } else {
        alert('Whoops!! Element not found....');
    }
}

function load_danmaku(player_unit) {
    if (player_unit.is_load) {
        //ccl init
        player_unit.CM_core = new CommentManager(document.getElementById('player'));
        player_unit.CM_core.init();

        CommentLoader(player_unit.danmaku_xml, player_unit.CM_core);

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
    } else {
        //load ready
        player_unit.player_core.on('loadedmetadata', function () {
            if (player_unit.readyFunction) {
                player_unit.readyFunction();
            }
            player_unit.is_load = true;
            this.show();
            load_danmaku(player_unit);
        });
    }
}
