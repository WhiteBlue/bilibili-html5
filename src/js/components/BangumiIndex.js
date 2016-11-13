var React = require('react');
var Config = require('../Config');
var reqwest = require('reqwest');

var Loading = require('./Loading');

const BangumiBanner = React.createClass({
  _loadBanner(){
    $('.block-banner').unslider({
      animation: 'horizontal',
      autoplay: true,
      arrows: false,
      keys: false
    });
  },
  getDefaultProps(){
    return {
      list: []
    }
  },
  componentDidMount(){
    this._loadBanner();
  },
  render(){
    var banners = [];

    for (var i = 0; i < this.props.list.length; i++) {
      banners.push(<li key={"banner-li-"+i}>
        <a href={this.props.list[i].link} target="_blank">
          <img alt={this.props.list[i].title} src={this.props.list[i].img}/>
        </a></li>
      );
    }

    return <div className="bangumi-banner-block">
      <div className="bangumi-banner block-banner">
        <ul>
          {banners}
        </ul>
      </div>
    </div>;
  }
});

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
      hrefStr: "#/view/"
    };
  },
  render() {
    var linkUrl = this.state.hrefStr + this.props.data.aid;
    return <div className="video-block floatleft">
      <a href={linkUrl} className="video-block-main">
        <img src={this.props.data.pic}/>
      </a>
      <div className="video-block-time">{this.props.data.duration}</div>
      <a href="#" className="video-block-info">
        标题: {this.props.data.title}
        UP主: {this.props.data.author}
      </a>
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


module.exports = React.createClass({
  _loadData(){
    var _this = this;
    reqwest({
      url: Config.base_url + Config.routes.BANGUMI_INDEX
      , type: 'json'
      , method: 'get'
      , data: {}
      , crossOrigin: true
      , error: function (err) {
        console.log('error:' + err);
      }
      , success: function (data) {
        _this.setState({
          indexData: data,
          loading: false
        });
      }
    });
  },
  getInitialState(){
    return {
      loading: true,
      indexData: null
    }
  },
  componentDidMount(){
    this._loadData();
  },
  render(){
    var recommend_videos = [];

    if (this.state.indexData != null) {

      for (var i = 0; i < this.state.indexData.recommends.length; i++) {
        recommend_videos.push(<VideoItem key={"video-li-"+i} data={this.state.indexData.recommends[i]}/>);
      }
    }

    return <div>
      <div className="area">
        {
          (this.state.loading) ? <Loading /> : <BangumiBanner list={this.state.indexData.banners}/>
        }
      </div>
      <div className="area">
        <div className="area-inner">
          <div className="area-banner">
            <h2>视频推荐</h2>
          </div>
          {
            (this.state.loading) ? <Loading /> :
              <div className="list-video-block">
                {recommend_videos}
                <div className="clear"></div>
              </div>
          }
        </div>
      </div>
    </div>
  }
});
