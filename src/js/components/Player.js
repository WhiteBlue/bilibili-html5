var React = require('react');
var reqwest = require('reqwest');

var Config = require('../Config');
var Loading = require('./Loading');

var vjs_his = null;

const VideoBlock = React.createClass({
  //初始化播放器
  _loadVideoSrc(vjs){
    var videoList = [
      {
        src: this.props.urlList.url,
        type: 'video/mp4',
        label: 'source'
      }
    ];
    for (var i in this.props.urlList.backup_url) {
      videoList.push({
        src: this.props.urlList.backup_url[i],
        type: 'video/mp4',
        label: 'backup:' + i
      });
    }
    vjs.updateSrc(videoList);
  },
  _loadVideoJs(){
    if (vjs_his != null) {
      vjs_his.dispose();
      vjs_his = null;
    }
    var _this = this;
    var vjs = videojs('danmu_player', {
        controls: true,
        plugins: {
          videoJsResolutionSwitcher: {
            default: 'high',
            dynamicLabel: true
          }
        }
      }
    );

    vjs.ABP();
    vjs.ready(function () {
      if (_this.hotkeys) {
        _this.hotkeys({
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
      }
    });
    vjs.danmu.load(this.props.commentUrl);
    this._loadVideoSrc(vjs);
    vjs_his = vjs;
  },
  getDefaultProps(){
    return {
      url: "",
      pic: "",
      commentUrl: ""
    };
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

    return <div className="area area-player">
      <div className="area-inner">
        <div className="video-part-select floatleft" style={{display:display}}>
          {partList}
        </div>
        <div className="clear"></div>
        {this.state.loading ? <Loading /> :
          <VideoBlock urlList={this.state.data.durl[0]} commentUrl={"http://comment.bilibili.cn/"+this._cid+".xml"}
                      pic={this.props.pic}/>}
      </div>
    </div>;
  }
});
