var React = require('react');
var Config = require('../Config');
var Pager = require('./Pager');
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
      hrefStr: "#/view/"
    };
  },
  render() {
    var linkUrl = this.state.hrefStr + this.props.data.aid;
    return <div className="video-item floatleft">
      <div className="video-block-small">
        <div className="left floatleft">
          <a href={linkUrl} target="_blank">
            <div className="thumb">
              <img className="lazy" src={this.props.data.pic}/>
            </div>
          </a>
          <div className="info floatleft">
            <div className="info-text floatleft">播放: {this.props.data.play}</div>
            <div className="info-text floatright">弹幕: {this.props.data.video_review}</div>
          </div>
        </div>
        <div className="right floatleft">
          <a href={linkUrl} target="_blank" className="title floatleft">{this.props.data.title}</a>

          <a href={linkUrl} target="_blank" className="up floatleft">up: {this.props.data.author}</a>
          <p className="desc">{this.props.data.description}</p>
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
        renderList.push(<VideoItem key={"video-"+i} data={this.props.videoList[i]}/>);
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
  _order: 'hot',
  //排序方式
  _changeSort(sort){
    this._order = sort;
    this._page = 1;
    this._loadData(this.props.tid);
  },
  //分页
  _changePage(page){
    this._page = page;
    this._loadData(this.props.tid);
    //翻页后大传送术
    $('body,html').animate({scrollTop: 0}, 700);
  },
  _loadData(tid){
    var _this = this;
    reqwest({
      url: Config.base_url + Config.routes.SORT_VIDEOS + tid + "?page=" + _this._page + "&order=" + this._order
      , type: 'json'
      , method: 'get'
      , crossOrigin: true
      , error: function (err) {
        console.log('error:' + err);
      }
      , success: function (data) {
        _this.props.cb(data.name);
        _this.setState({
          videoList: data.list,
          allPage: data.pages,
          title: data.name,
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
    this.setState({
      loading: true
    });
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
        <a onClick={_this._changeSort.bind(null,"hot")}
           className={(this._order=="hot"?"active":"")+" btn floatleft"}>点击数</a>

        <a onClick={_this._changeSort.bind(null,"default")}
           className={(this._order=="default"?"active":"")+" btn floatleft"}>发布时间</a>

        <a onClick={_this._changeSort.bind(null,"damku")}
           className={(this._order=="damku"?"active":"")+" btn floatleft"}>弹幕数</a>
      </div>

      {(this.state.loading) ? <div></div> :
        <div>
          <VideoBlock videoList={this.state.videoList}/>
          <div className="clear"></div>

          <Pager allPage={this.state.allPage} nowPage={this._page} pageCallBack={this._changePage}/>
        </div>
      }
    </div>;
  }
});
