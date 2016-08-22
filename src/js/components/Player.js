var React = require('react');
var Config = require('../Config');
var reqwest = require('reqwest');


const VideoBlock = React.createClass({
  _vjs: null,
  //初始化播放器
  _loadVideoJs(){
    var _this = this;
    if (this._vjs === null) {
      var vjs = videojs('danmu_player', {
          controls: true,
          plugins: {
            videoJsResolutionSwitcher: {
              default: 'high',
              dynamicLabel: true
            }
          }
        }, function () {
          var player = this;
          var videoList = [
            {
              src: _this.props.urlList.url,
              type: 'video/mp4',
              label: 'source'
            }
          ];
          for (var i in _this.props.urlList.backup_url) {
            videoList.push({
              src: _this.props.urlList.backup_url[i],
              type: 'video/mp4',
              label: 'backup:' + i
            });
          }
          player.updateSrc(videoList);
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
      this._vjs = vjs;
    }
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
      <source src="{this.props.url}" type='video/mp4'/>
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
          <VideoBlock urlList={this.state.data.durl[0]} commentUrl={"http://comment.bilibili.cn/"+this._cid+".xml"}
                      pic={this.props.pic}/>}
      </div>
    </div>;
  }
});
