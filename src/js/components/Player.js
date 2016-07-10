var React = require('react');
var Config = require('../Config');
var reqwest = require('reqwest');

function loadVideoJsPlugin(loadVideoFunc) {
  videojs.plugin('ABP', function () {
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

      this.videoQualityControl = document.createElement('div');
      this.videoQualityControl.className = 'vjs-danmu-control vjs-menu-button vjs-control';
      this.videoQualityControlContent = document.createElement('span');
      this.videoQualityControlContent.className = 'vjs-danmu-switch';
      this.videoQualityControlContent.innerHTML = '高清';
      this.videoQualityControl.appendChild(this.videoQualityControlContent);

      //清晰度
      this._quality = 2;

      ele.el().getElementsByClassName('vjs-control-bar')[0].appendChild(this.videoQualityControl);

      if (typeof CommentManager !== "undefined") {
        //CCL init
        this.cmManager = new CommentManager(this.danmuDiv);
        //弹幕播放时间
        this.cmManager.options.global.scale = 1.7;
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

        this.videoQualityControl.addEventListener("click", function () {
          switch (_this._quality) {
            case 1:
            {
              _this._quality = 2;
              _this.videoQualityControlContent.innerHTML = "高清";
              break;
            }
            default:
            {
              _this._quality = 1;
              _this.videoQualityControlContent.innerHTML = "低清";
            }
          }
          loadVideoFunc(_this._quality);
          _this.cmManager.clear();
        });

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
}


//加载视频弹幕
function loadVideo(vjs, videoUrl, danmuUrl, loadQualityFunc) {
  vjs.src(videoUrl);
  if (!vjs.danmu) {
    loadVideoJsPlugin(loadQualityFunc);
    vjs.ABP();
  }
  vjs.danmu.load(danmuUrl);
}

const VideoBlock = React.createClass({
  _vjs: null,
  //初始化播放器
  _loadVideoJs(){
    if (this._vjs === null) {
      this._vjs = videojs('danmu_player');
    }
    loadVideo(this._vjs, this.props.url, this.props.commentUrl, this.props.loadQualityFunc);
  },
  getDefaultProps(){
    return {
      url: "",
      pic: "",
      commentUrl: ""
    };
  },
  componentDidUpdate(prevProps, prevState){
    this._loadVideoJs();
  },
  componentDidMount(){
    this._loadVideoJs();
  },
  render(){
    return <video id="danmu_player"
                  className="video-js vjs-default-skin"
                  controls="true"
                  preload="auto"
                  width="980"
                  height="614"
                  poster={this.props.pic}>
      <p className="vjs-no-js">换换浏览器吧</p>
    </video>;
  }
});


module.exports = React.createClass({
  _cid: null,
  _quality: 2,
  _selectParts(partStr){
    var cid = null;
    if (this.props.parts.length !== 0) {
      cid = this.props.parts[partStr].cid;
    }
    this._cid = cid;
    this._loadVideoData();
    this.setState({
      nowPlay: partStr
    });
  },
  _selectQuality(quality){
    this._quality = quality;
    this._loadVideoData();
  },
  _loadVideoData(){
    if (this._cid !== null) {
      var _this = this;
      reqwest({
        url: Config.base_url + Config.routes.VIDEO_URL + this._cid + "?quality=" + this._quality
        , type: 'json'
        , method: 'get'
        , crossOrigin: true
        , error: function (err) {
          console.log('error');
        }
        , success: function (data) {
          _this.setState({
            data: data
          });
        }
      });
    }
  },
  componentDidMount(){
    //初始化cid
    this._selectParts("0");
    this._loadVideoData();
  },
  getDefaultProps(){
    return {
      parts: [],
      pic: ""
    }
  },
  getInitialState(){
    return {
      data: null,
      nowPlay: "0"
    }
  },
  render(){
    var partList = [];
    var display = "none";
    if (this.props.parts.hasOwnProperty("1")) {
      for (var i in this.props.parts) {
        if (this.props.parts.hasOwnProperty(i)) {
          var active = "";
          if (i === this.state.nowPlay) {
            active = "active";
          }
          partList.push(<span key={"parts-"+i} onClick={this._selectParts.bind(null,i)}
                              className={active+" floatleft"}>{this.props.parts[i].part}</span>);
        }
      }
      display = "block";
    }

    return <div className="area area-player">
      <div className="area-inner">
        <div className="video-part-select floatleft" style={{display:display}}>
          {partList}
        </div>
        <div className="clear"></div>
        {this.state.data === null ? <div></div> :
          <VideoBlock url={this.state.data.url} commentUrl={"http://comment.bilibili.cn/"+this._cid+".xml"}
                      pic={this.props.pic} loadQualityFunc={this._selectQuality}/>}
      </div>
    </div>;
  }
});
