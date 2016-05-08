var React = require('react');
var Config = require('../Config');


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
    return <div className="side-video-item">
      <div className="left floatleft">
        <img src={this.props.data.pic}/>
      </div>
      <div className="right floatleft">
        <a href={linkUrl} target="_blank" className="title">{this.props.data.title}</a>
        <a href={linkUrl} target="_blank" className="up">{this.props.data.author}</a>
        <div className="info">
          <div className="info-text floatleft">播放: {this.props.data.play}</div>
          <div className="info-text floatright">弹幕: {this.props.data.video_review}</div>
        </div>
      </div>
    </div>;
  }
});


module.exports = React.createClass({
  _order: 'hot',
  _loadData(){
    $.ajax({
      type: 'GET',
      url: Config.base_url + Config.routes.TOP_RANK,
      data: {},
      context: this,
      success: function (data) {
        this.setState({
          videoList: data.list
        });
      },
      error: function () {
        console.log('error');
      }
    });
  },
  getDefaultProps(){
    return {
      tid: 0
    }
  },
  getInitialState(){
    return {
      videoList: []
    }
  },
  componentDidMount(){
    this._loadData();
  },
  render(){
    var renderList = [];

    for (var i in this.state.videoList) {
      if (i != "num") {
        renderList.push(<VideoItem key={"hot-"+i} data={this.state.videoList[i]}/>);
      }
    }

    return <div className="sort-right floatleft">
      <div className="banner">
        <p>热门排行</p>
      </div>
      <div className="side-video-list">
        {renderList}
      </div>
    </div>;
  }
});
