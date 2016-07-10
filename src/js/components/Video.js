var React = require('react');
var Config = require('../Config');
var _ = require('lodash');

var Player = require('./Player');
var reqwest = require('reqwest');

const Tags = React.createClass({
  getDefaltProps(){
    return {
      str: ""
    };
  },
  render(){
    var tags = _.split(this.props.str, ",");
    var renderTags = [];
    for (var i in tags) {
      renderTags.push(<li key={i} className="floatleft">{tags[i]}</li>)
    }
    return <ul className="tags floatleft">
      {renderTags}
      <div className="clear"></div>
    </ul>;
  }
});

const VideoInfo = React.createClass({
  getDefaltProps(){
    return {
      data: {
        author: "",
        coins: "",
        created_at: "",
        description: "",
        face: "",
        favorites: "",
        list: {},
        mid: "",
        pages: 1,
        pic: "",
        play: "",
        review: "",
        tag: "",
        tid: 0,
        title: "",
        typename: "",
        video_review: ""
      }
    };
  },
  render(){
    return <div>
      <div className="area">
        <div className="video-info">
          <div className="area-inner">
            <div className="left floatleft">
              <div className="title">
                <h1>{this.props.data.title}</h1>
              </div>
              <div className="info floatleft">
                <div className="info-text floatleft">分类: {this.props.data.typename}</div>
                <div className="info-text floatright">时间: {this.props.data.created_at}</div>
              </div>
              <div className="clear"></div>
              <div className="play-info floatleft">
                <div className="info-text floatleft">播放: {this.props.data.play}</div>
                <div className="info-text floatleft">弹幕: {this.props.data.video_review}</div>
                <div className="info-text floatleft">硬币: {this.props.data.coins}</div>
              </div>
              <div className="clear"></div>
            </div>
            <div className="right floatleft">
              <div className="up-face floatleft">
                <a href="#">
                  <img src={this.props.data.face}/></a>
              </div>
              <div className="up-info floatleft">
                <a href="#" className="title">{this.props.data.author}</a>
                <div className="brief">收藏: {this.props.data.favorites}</div>
              </div>
            </div>
            <div className="clear"></div>
          </div>
        </div>
      </div>

      {this.props.data.list ? <Player parts={this.props.data.list} pic={this.props.data.pic}/> : <div></div>}

      <div className="area">
        <div className="area-inner">
          <div className="video-brief">

            <Tags str={this.props.data.tag}/>

            <div className="clear"></div>
            <div className="desc">{this.props.data.description}</div>

            <div className="comments">
              <span className="label">评论</span>
              <p>(施工中)</p>
            </div>
          </div>
        </div>
      </div>
    </div>;
  }
});

module.exports = React.createClass({
  _loadData(){
    if (this.props.aid !== null) {
      var _this = this;
      reqwest({
        url: Config.base_url + Config.routes.VIDEO_INFO + this.props.aid
        , type: 'json'
        , method: 'get'
        , crossOrigin: true
        , error: function (err) {
          console.log('error');
        }
        , success: function (data) {
          _this.props.cb(data.title);
          _this.setState({
            videoInfo: data
          });
        }
      });
    }
  },
  componentDidMount(){
    this._loadData();
  },
  getDefaltProps(){
    return {
      aid: null,
      cb: function (content) {
      }
    }
  },
  getInitialState(){
    return {
      videoInfo: {}
    }
  },
  render(){
    return <VideoInfo data={this.state.videoInfo}/>;
  }
});
