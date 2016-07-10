var React = require('react');
var Config = require('../Config');
var reqwest = require('reqwest');

const VideoItem = React.createClass({
  getDefaultProps(){
    return {
      data: {
        aid: "",
        author: "",
        coins: 0,
        comment: 0,
        create: "",
        description: "",
        duration: "",
        favorites: 0,
        mid: 0,
        pic: "",
        play: 0,
        review: 0,
        title: "",
        typeid: 0,
        typename: "",
        video_review: 0
      }
    };
  },
  getInitialState(){
    return {
      hrefStr: "/view/"
    };
  },
  render() {
    var linkUrl = this.state.hrefStr + this.props.data.aid;
    return <div className="video-block-mask floatleft">
      <a href={linkUrl} target="_blank">
        <div className="video-block-mask-preview">
          <img src={this.props.data.pic}/>
        </div>
        <div className="video-block-mask-mask"></div>

        <div className="video-block-mask-info">
          <div className="title">{this.props.data.title}</div>
          <div className="up">up主：{this.props.data.author}</div>
          <div className="play">播放：{this.props.data.play}</div>
        </div>
      </a>
    </div>;
  }
});

module.exports = React.createClass({
  _loadData(){
    var _this = this;
    reqwest({
      url: Config.base_url + Config.routes.TOP_RANK
      , type: 'json'
      , method: 'get'
      , crossOrigin: true
      , error: function (err) {
        console.log('error');
      }
      , success: function (data) {
        _this.setState({
          top: data.list
        });
      }
    });
  },
  componentDidMount(){
    this._loadData();
  },
  getInitialState(){
    return {
      top: []
    }
  },
  render(){
    var renderVideos = [];
    var count = 0;
    for (var i in this.state.top) {
      if (count < 6) {
        if (i != 'num') {
          renderVideos.push(<VideoItem key={i} data={this.state.top[i]}/>);
        }
      } else {
        break;
      }
      count++;
    }
    return <div className="right-block floatleft">
      {renderVideos}
      <div className="clear"></div>
    </div>;
  }
});
