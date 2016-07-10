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
    return <div className="video-block floatleft">
      <a href={linkUrl} target="_blank" className="video-block-main">
        <img src={this.props.data.pic}/>
      </a>
      <div className="video-block-time">{this.props.data.duration}</div>
      <a href={linkUrl} target="_blank" className="video-block-info">{this.props.data.title}</a>
      <div className="video-block-info-hidden">
        <div className="left floatleft">
          播放: {this.props.data.play}
        </div>
        <div className="right floatright">
          弹幕: {this.props.data.video_review}
        </div>
      </div>
    </div>;
  }
});


const VideoBlock = React.createClass({
  getDefaultProps(){
    return {
      videoList: [],
      labelName: ''
    };
  },
  render(){
    var renderVideos = [];
    for (var i in this.props.videoList) {
      if (i != 'num') {
        renderVideos.push(<VideoItem key={i} data={this.props.videoList[i]}/>);
      }
    }
    return <div className="area">
      <div className="area-inner">
        <div className="area-banner">
          <a className="area-banner-ch">
            <h3>{this.props.labelName}</h3>
            <i className="area-banner-line-left"></i>
          </a>
          <i className="area-banner-line-right"></i>
          <i className="area-banner-line-circle"></i>
        </div>
        <div className="list-video-block floatleft">
          {renderVideos}
        </div>
        <div className="clear"></div>
      </div>
    </div>;
  }
});

module.exports = React.createClass({
  _loadData(){
    var _this = this;
    reqwest({
      url: Config.base_url + Config.routes.ALL_RANK
      , type: 'json'
      , method: 'get'
      , crossOrigin: true
      , error: function (err) {
        console.log('error');
      }
      , success: function (resp) {
        _this.setState({
          videoList: resp
        });
      }
    });
  },
  componentDidMount(){
    this._loadData();
  },
  getInitialState(){
    return {
      videoList: {}
    }
  },
  render(){
    var renderList = [];
    for (var i = 0; i < Config.index_order.length; i++) {
      var key = Config.index_order[i];
      renderList.push(<VideoBlock key={"list-"+key} videoList={this.state.videoList[key]}
                                  labelName={key}/>)
    }
    return <div>{renderList}</div>;
  }
});
