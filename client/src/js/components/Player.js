var React = require('react');
var Config = require('../Config');

//加载视频弹幕
function loadVideo(vjs, videoUrl, danmuUrl) {
  vjs.src(videoUrl);
  if (!vjs.danmu) {
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
    loadVideo(this._vjs, this.props.url, this.props.commentUrl);
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
  _loadVideoData(){
    if (this._cid !== null) {
      $.ajax({
        type: 'GET',
        url: Config.base_url + Config.routes.VIDEO_URL + this._cid + "?quality=" + this._quality,
        context: this,
        success: function (data) {
          this.setState({
            data: data
          });
        },
        error: function () {
          console.log('error');
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
                      pic={this.props.pic}/>}
      </div>
    </div>;
  }
});
