var React = require('react');
var Config = require('../Config');
var reqwest = require('reqwest');

module.exports = React.createClass({
  _vjs: null,
  //初始化播放器
  _loadVideoJs(){
    if (this._vjs === null) {
      this._vjs = videojs('danmu_player');
    }
    console.log("target:" + this.props.videoUrl);
    this._vjs.src(this.props.videoUrl);
  },
  getDefaultProps(){
    return {
      videoUrl: "",
      pic: ""
    }
  },
  componentDidMount(){
    this._loadVideoJs();
  },
  render(){
    return <div className="area area-player">
      <div className="area-inner">
        <div className="clear"></div>
        <video id="danmu_player"
               className="video-js vjs-default-skin"
               controls="true"
               preload="auto"
               width="980"
               height="614"
               poster={this.props.pic}>
          <p className="vjs-no-js">换换浏览器吧</p>
        </video>
      </div>
    </div>;
  }
});
