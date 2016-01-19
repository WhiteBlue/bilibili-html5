/**
 * Created by WhiteBlue on 16/1/12.
 */


function loadVideoJsAndPlugin() {
    videojs.plugin('ABP', function () {
        function Danmu(ele) {
            var _this = this;
            this.danmuDiv = document.createElement('div');
            this.danmuDiv.className = 'vjs-danmu';
            ele.el().insertBefore(this.danmuDiv, ele.el().getElementsByClassName('vjs-poster')[0]);

            this.danmuShowControl = document.createElement('div');
            this.danmuShowControl.className = 'vjs-danmu-control vjs-menu-button vjs-control';
            this.danmuShowControlContent = document.createElement('span');
            this.danmuShowControlContent.className = 'glyphicon glyphicon-align-right';
            this.danmuShowControl.appendChild(this.danmuShowControlContent);
            ele.el().getElementsByClassName('vjs-control-bar')[0].appendChild(this.danmuShowControl);

            if (typeof CommentManager !== "undefined") {
                this.cmManager = new CommentManager(this.danmuDiv);
                this.cmManager.display = true;
                this.cmManager.init();
                this.cmManager.clear();

                //弹幕控制绑定
                var video = ele.el().children[0];
                var lastPosition = 0;
                video.addEventListener("progress", function () {
                    if (lastPosition == video.currentTime) {
                        video.hasStalled = true;
                        _this.cmManager.stopTimer();
                    } else
                        lastPosition = video.currentTime;
                });

                //时间轴更新
                video.addEventListener("timeupdate", function () {
                    if (_this.cmManager.display === false) return;
                    if (video.hasStalled) {
                        _this.cmManager.startTimer();
                        video.hasStalled = false;
                    }
                    _this.cmManager.time(Math.floor(video.currentTime * 1000));
                });

                video.addEventListener("play", function () {
                    _this.cmManager.startTimer();
                });

                video.addEventListener("pause", function () {
                    _this.cmManager.stopTimer();
                });

                video.addEventListener("waiting", function () {
                    _this.cmManager.stopTimer();
                });

                video.addEventListener("playing", function () {
                    _this.cmManager.startTimer();
                });

                video.addEventListener("seeked", function () {
                    _this.cmManager.clear();
                });

                if (window) {
                    window.addEventListener("resize", function () {
                        _this.cmManager.setBounds();
                    });
                }

                //Bind Control to button
                this.danmuShowControl.addEventListener("click", function () {
                    if (_this.cmManager.display == true) {
                        _this.cmManager.display = false;
                        _this.cmManager.clear();
                        _this.danmuShowControlContent.setAttribute("class", "glyphicon glyphicon-ban-circle");
                    } else {
                        _this.cmManager.display = true;
                        _this.danmuShowControlContent.setAttribute("class", "glyphicon glyphicon-align-right");
                    }
                });

                //Create Load function
                this.load = function (url, callback) {
                    if (callback == null)
                        callback = function () {
                            return;
                        };
                    var xmlhttp;
                    if (window.XMLHttpRequest) {
                        xmlhttp = new XMLHttpRequest();
                    }
                    else {
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.open("GET", url, true);
                    xmlhttp.send();
                    var cm = this.cmManager;
                    var cmvideo = video;
                    xmlhttp.onreadystatechange = function () {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            if (navigator.appName == 'Microsoft Internet Explorer') {
                                var f = new ActiveXObject("Microsoft.XMLDOM");
                                f.async = false;
                                f.loadXML(xmlhttp.responseText);
                                cm.load(BilibiliParser(f));
                                cm.seek(cmvideo.currentTime * 1000);
                                callback(true);
                            } else {
                                cm.seek(cmvideo.currentTime * 1000);
                                cm.load(BilibiliParser(xmlhttp.responseXML));
                                callback(true);
                            }
                        } else
                            callback(false);
                    }
                }

            }
            return this;
        }

        this.danmu = new Danmu(this);
    });
    window.vjs = videojs('danmu_player');
}

//加载mp4视频源
function getMp4(cid, quality) {
    var danmu = 'http://comment.bilibili.cn/' + cid + '.xml';
    $.ajax({
            type: "GET",
            url: serviceUrl + '/video/' + cid + '/' + quality,
            dataType: 'json',
            success: function (data) {
                var src = {
                    type: "video/mp4",
                    src: data.url
                };
                loadVideo(src, danmu);
            },
            error: function () {
                getFlv(cid, danmu);
            }
        }
    );
    changeSelect(cid);
}

//取得flv视频源
function getFlv(cid, danmu) {
    $.ajax({
            type: "GET",
            url: serviceUrl + '/videoflv/' + cid,
            dataType: 'json',
            success: function (data) {
                var src = {
                    type: "video/flv",
                    src: data.url
                };
                loadVideo(src, danmu);
            },
            error: function () {
                showError('视频地址取得失败');
            }
        }
    );
}


function showError(msg) {
    var dialog = $('#loading_dialog');
    dialog.fadeIn();
    dialog.append('<p>' + msg + '</p>');
}


//加载视频弹幕
function loadVideo(videoUrl, danmuUrl) {
    var vjs = window.vjs;
    vjs.src(videoUrl);
    if (!vjs.danmu) {
        vjs.ABP();
    }
    vjs.danmu.load(danmuUrl);
}


function changeSource(src, danmuUrl) {
    var player = window.vjs;
    player.pause();
    player.currentTime(0);
    player.src(src);
    player.danmu.load(danmuUrl);
    player.ready(function () {
        this.one('loadeddata', videojs.bind(this, function () {
            this.currentTime(0);
        }));
        this.load();
        this.play();
    });
}


function changeSelect(cid) {
    var partList = $('.video_part_select');
    for (var i = 0; i < partList.length; i++) {
        var node = partList[i];
        if (node.getAttribute('cid') != cid) {
            if (node.parentNode.classList.contains('disabled')) {
                node.parentNode.classList.remove('disabled');
            }
        } else {
            node.parentNode.classList.add('disabled');
        }
    }
}