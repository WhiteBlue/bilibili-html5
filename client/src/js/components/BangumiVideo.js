var React = require('react');
var Config = require('../Config');

var VideoPlayer = require('./VideoPlayer');
var reqwest = require('reqwest');


const BangumiVideoInfo = React.createClass({
  getDefaltProps(){
    return {
      data: {
        title: "",
        author: "",
        face: "",
        created_at: "",
        description: "",
        pic: "",
        bangumi_name: "",
        url: null
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
                <div className="info-text floatleft">番剧: {this.props.data.bangumi_name}</div>
                <div className="info-text floatright">时间: {this.props.data.created_at}</div>
              </div>
              <div className="clear"></div>
              <div className="play-info floatleft">
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
              </div>
            </div>
            <div className="clear"></div>
          </div>
        </div>
      </div>

      {this.props.data.url == null ? <div></div> :
        <VideoPlayer videoUrl={this.props.data.url} pic={this.props.data.pic}/>}

      <div className="area">
        <div className="area-inner">
          <div className="video-brief">

            <ul className="tags floatleft">
              <li className="floatleft">新番</li>
              <li className="floatleft">{this.props.data.title}</li>
              <div className="clear"></div>
            </ul>

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
    var _this = this;
    reqwest({
      url: "/api/video/" + this.props.vid
      , type: 'json'
      , method: 'get'
      , crossOrigin: true
      , error: function (err) {
        console.log('error:' + err);
      }
      , success: function (data) {
        if (data.code == 0) {
          _this.props.cb(data.content.bangumi_name);
          _this.setState({
            videoInfo: data.content
          });
        } else {
          console.log(data);
        }
      }
    });
  },
  componentDidMount(){
    this._loadData();
  },
  getDefaltProps(){
    return {
      vid: null,
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
    return <BangumiVideoInfo data={this.state.videoInfo}/>;
  }
});
