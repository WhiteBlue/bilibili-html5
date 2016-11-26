var React = require('react');
var reqwest = require('reqwest');

var Config = require('../Config');
var Loading = require('./Loading');

var videojs = require("video.js");

require("../danmaku/VideojsPlugin");
require("../utils/VideojsHotKeys");

var _oldPlayer = null; //Video.js的dispose()不能放在componentWillUnmount事件之前(和React.js自身清理相冲突)

const VideoBlock = React.createClass({
  _player: null,
  _loadVideoJs(commentUrl, videoUrl){
    if (_oldPlayer != null) {
      _oldPlayer.dispose();
      _oldPlayer = null;
    }
    if (this._player == null) {
      this._player = videojs('danmu_player', {
        controls: true
      }, function () {
        this.initDanmaku();
        this.hotkeys({
          volumeStep: 0.1,
          seekStep: 5,
          //音量键(M)
          enableMute: true,
          //滚轮调节音量
          enableVolumeScroll: false,
          //全屏(F)
          enableFullscreen: true,
          //数字选择分P
          enableNumbers: false,
          alwaysCaptureHotkeys: false
        });
        this.danmu.load(commentUrl);
        this.src(videoUrl);
      });
    } else {
      this._player.src(videoUrl);
      this._player.danmu.load(commentUrl);
    }

  },
  getDefaultProps(){
    return {
      url: "",
      pic: "",
      commentUrl: ""
    };
  },
  componentDidMount(){
    this._loadVideoJs(this.props.commentUrl, this.props.urlList.url);
  },
  componentWillReceiveProps(nextProps){
    if (this._player != null) {
      //避免初次加载调用
      this._loadVideoJs(nextProps.commentUrl, nextProps.urlList.url);
    }
  },
  componentWillUnmount(){
    _oldPlayer = this._player;
    this.player = null;
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
  _loadVideoData(){
    this.setState({
      loading: true
    });
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
            loading: false,
            data: data
          });
        }
      });
    }
  },
  componentDidMount(){
    //初始化cid
    this._selectParts("0");
  },
  getDefaultProps(){
    return {
      parts: [],
      pic: ""
    }
  },
  getInitialState(){
    return {
      loading: true,
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

    var commentUrl = Config.routes.GET_COMMENT + this._cid + ".xml";

    return <div className="area area-player">
      <div className="area-inner">
        <div className="video-part-select floatleft" style={{display:display}}>
          {partList}
        </div>
        <div className="clear"></div>
        {this.state.loading ? <Loading /> :
          <VideoBlock urlList={this.state.data.durl[0]} commentUrl={commentUrl}
                      pic={this.props.pic}/>}
      </div>
    </div>;
  }
});
