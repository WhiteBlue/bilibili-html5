var videojs = require("video.js");
var reqwest = require('reqwest');

var CommentManager = require("./CommentManager");
var BilibiliParser = require("./BilibiliParser");

videojs.plugin('initDanmaku', function () {
  function Danmu(ele) {
    var _this = this;
    this.danmuDiv = document.createElement('div');
    this.danmuDiv.className = 'vjs-danmu';
    ele.el().insertBefore(this.danmuDiv, ele.el().getElementsByClassName('vjs-poster')[0]);

    this.danmuShowControl = document.createElement('div');
    this.danmuShowControl.className = 'vjs-danmu-control vjs-menu-button vjs-control';
    this.danmuShowControlContent = document.createElement('span');
    this.danmuShowControlContent.className = 'vjs-danmu-switch';
    this.danmuShowControlContent.innerHTML = '弹幕';
    this.danmuShowControl.appendChild(this.danmuShowControlContent);
    ele.el().getElementsByClassName('vjs-control-bar')[0].appendChild(this.danmuShowControl);

    //CCL init
    this.cmManager = new CommentManager(this.danmuDiv);
    //弹幕播放时间
    this.cmManager.options.scroll.scale = 3;
    this.cmManager.init();
    this.cmManager.clear();

    this.cmManager.display = true;

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
      _this.cmManager.seek(Math.floor(video.currentTime * 1000));
      _this.cmManager.clear();
    });

    if (window) {
      window.addEventListener("resize", function () {
        _this.cmManager.setBounds();
      });
    }
    this.danmuShowControl.addEventListener("click", function () {
      if (_this.cmManager.display === true) {
        _this.cmManager.clear();
        _this.cmManager.display = false;
        _this.danmuShowControlContent.innerHTML = "无";
      } else {
        _this.cmManager.display = true;
        _this.danmuShowControlContent.innerHTML = "弹幕";
      }
    });


    this.load = function (url) {
      reqwest({
        url: url
        , type: 'xml'
        , method: 'get'
        , crossOrigin: true
        , error: function (err) {
          console.log('error:', err);
        }
        , success: function (data) {
          if (data != null) {
            _this.cmManager.load(BilibiliParser(data));
          }
        }
      });
    };

    return this;
  }

  this.danmu = new Danmu(this);
});

