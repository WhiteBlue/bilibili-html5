var React = require('react');
var reqwest = require('reqwest');

var Config = require('../Config');
var Pager = require('./Pager');
var Loading = require('./Loading');

const VideoItem = React.createClass({
  getDefaultProps(){
    return {
      data: {
        title: "",
        cover: "",
        param: "",
        name: "",
        play: "",
        reply: "",
        danmaku: "",
        favourite: ""
      }
    };
  },
  getInitialState(){
    return {
      hrefStr: "#/view/"
    };
  },
  render() {
    var linkUrl = this.state.hrefStr + this.props.data.param;
    return <div className="video-item floatleft">
      <div className="video-block-small">
        <div className="left floatleft">
          <a href={linkUrl} target="_blank">
            <div className="thumb">
              <img className="lazy" src={this.props.data.cover}/>
            </div>
          </a>
          <div className="info floatleft">
            <div className="info-text floatleft">播放: {this.props.data.play}</div>
            <div className="info-text floatright">弹幕: {this.props.data.danmaku}</div>
          </div>
        </div>
        <div className="right floatleft">
          <a href={linkUrl} target="_blank" className="title floatleft">{this.props.data.title}</a>

          <a href={linkUrl} target="_blank" className="up floatleft">up主: {this.props.data.name}</a>
        </div>
      </div>
    </div>;
  }
});

const VideoBlock = React.createClass({
  getDefaultProps(){
    return {
      videoList: []
    }
  },
  render(){
    var renderList = [];

    for (var i in this.props.videoList) {
      if (i != "num") {
        renderList.push(<VideoItem key={"video-" + i} data={this.props.videoList[i]}/>);
      }
    }

    return <div className="list-sort-block floatleft">
      {renderList}
      <div className="clear"></div>
    </div>;
  }
});


module.exports = React.createClass({
  _page: 1,
  _order: 'view',
  //排序方式
  _changeSort(sort){
    this._order = sort;
    this._page = 1;
    this._loadData(this.props.tid);
  },
  //分页
  _changePage(page){
    //翻页后大传送术
    $('body,html').animate({scrollTop: 0}, 700);
    this._page = page;
    this._loadData(this.props.tid);
  },
  _loadData(tid){
    this.setState({
      loading: true
    });
    let _this = this;
    let labelName = Config.sort_tags[tid];

    reqwest({
      url: Config.base_url + Config.routes.SORT_VIDEOS + tid + "?page=" + _this._page + "&order=" + this._order
      , type: 'json'
      , method: 'get'
      , crossOrigin: true
      , error: function (err) {
        console.log('error:' + err);
      }
      , success: function (data) {
        _this.props.cb(labelName);
        _this.setState({
          videoList: data,
          allPage: 999,
          title: labelName,
          loading: false
        });
      }
    });
  },
  getDefaultProps(){
    return {
      tid: 0,
      cb: function (content) {
      }
    }
  },
  getInitialState(){
    return {
      videoList: [],
      allPage: 0,
      title: "",
      loading: true
    }
  },
  componentWillReceiveProps(nextProps){
    this._loadData(nextProps.tid);
  },
  componentDidMount(){
    this._loadData(this.props.tid);
  },
  render(){
    var _this = this;

    return <div className="sort-left floatleft">
      <div className="banner">
        <p>{this.state.title}</p>
      </div>

      <div className="sort-tool-box floatleft">
        <a onClick={_this._changeSort.bind(null, "view")}
           className={(this._order == "hot" ? "active" : "") + " btn floatleft"}>点击数</a>

        <a onClick={_this._changeSort.bind(null, "senddate")}
           className={(this._order == "default" ? "active" : "") + " btn floatleft"}>发布时间</a>

        <a onClick={_this._changeSort.bind(null, "danmaku")}
           className={(this._order == "damku" ? "active" : "") + " btn floatleft"}>弹幕数</a>
      </div>

      {(this.state.loading) ? <Loading /> :
        <div>
          <VideoBlock videoList={this.state.videoList}/>
          <div className="clear"></div>

          <Pager allPage={this.state.allPage} nowPage={this._page} pageCallBack={this._changePage}/>
        </div>
      }
    </div>;
  }
});
