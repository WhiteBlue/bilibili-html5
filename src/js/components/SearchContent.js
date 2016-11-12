var React = require('react');
var reqwest = require('reqwest');

var Config = require('../Config');
var Pager = require('./Pager');
var Loading = require('./Loading');


const videoHrefStr = "#/view/";
const bangumiHrefStr = "#/bangumi/";

const VideoItem = React.createClass({
  getDefaultProps(){
    return {
      data: {
        title: "",
        cover: "",
        param: "",
        desc: "",
        author: "",
        duration: "",
        play: 0,
        danmaku: 0
      }
    };
  },
  render() {
    var date = new Date();
    date.setTime(this.props.data.pubdate * 1000);

    var linkUrl = videoHrefStr + this.props.data.param;
    return <div className="search-video-block floatleft">
      <a href={linkUrl} target="_blank">
        <div className="img">
          <img src={this.props.data.cover}/>
          <span className="time">{this.props.data.duration}</span>
        </div>
      </a>
      <div className="other-info">
        <a href={linkUrl} target="_blank" className="title">{this.props.data.title}</a>
        <div className="info floatleft">
          <div className="info-text floatleft">播放: {this.props.data.play}</div>
          <div className="info-text floatleft"> 弹幕：{this.props.data.danmaku}</div>
          <div className="info-text floatleft">Up: {this.props.data.author}</div>
        </div>
      </div>
    </div>;
  }
});


const UserItem = React.createClass({
  getDefaultProps(){
    return {
      data: {
        title: "",
        cover: "",
        param: "",
        fans: "",
        sign: ""
      }
    };
  },
  render() {
    var date = new Date();
    date.setTime(this.props.data.pubdate * 1000);

    var linkUrl = videoHrefStr + this.props.data.param;
    return <div className="search-video-block floatleft">
      <a href={linkUrl} target="_blank">
        <div className="img">
          <img src={this.props.data.cover}/>
        </div>
      </a>
      <div className="other-info">
        <a href={linkUrl} target="_blank" className="title">{this.props.data.title}</a>
        <div className="info floatleft">
          <div className="info-text floatleft">粉丝: {this.props.data.fans}</div>
          <div className="info-text floatleft">{this.props.data.sign}</div>
        </div>
      </div>
    </div>;
  }
});


const BangumiItem = React.createClass({
  getDefaultProps(){
    return {
      data: {
        title: "",
        cover: "",
        param: "",
        cat_desc: "",
        total_count: 0
      }
    }
  },
  render(){
    return <div className="special-li floatleft">
      <div className="img floatleft">
        <img src={this.props.data.cover}/>
      </div>
      <div className="info floatleft">
        <a href={bangumiHrefStr+this.props.data.param} target="_blank" className="title">{this.props.data.title}</a>
        <p className="desc">{this.props.data.cat_desc}</p>
        <div className="info">
          <div className="info-text floatleft">集数: {this.props.data.total_count}</div>
        </div>
      </div>
    </div>;
  }
});


const Topic = React.createClass({
  getDefaultProps(){
    return {
      data: {
        arcurl: "",
        author: "",
        click: 0,
        cover: "",
        description: "",
        favourite: 0,
        keyword: "",
        mid: 0,
        pubdate: 0,
        review: 0,
        title: "",
        tp_id: 0,
        tp_type: 0,
        update: 0
      }
    }
  },
  render(){
    return <div></div>;
  }
});

const SearchBlock = React.createClass({
  _handleClick(){
    var value = this.refs.search_content.value;
    this.props.searchCallBack(value);
  },
  componentDidUpdate(prevProps, prevState){
    //input value
    this.refs.search_content.setAttribute('value', this.props.keyword);
  },
  getDefaultProps(){
    return {
      keyword: "",
      searchCallBack: function (keyword) {
        console.log(keyword);
      }
    }
  },
  render(){
    return <div className="search-block">
      <div className="input-wrap floatleft">
        <input name="content" ref="search_content" className="search-content" placeholder="这里搜索"/>
      </div>
      <div className="search-btn floatleft" onClick={this._handleClick}><span>搜索</span>
      </div>
      <div className="clear"></div>
    </div>;
  }
});


module.exports = React.createClass({
  _searchType: "video",
  _page: 1,
  _order: "totalrank",
  _keyword: "",
  _loadData(){
    this.setState({
      loading: true
    });
    var _this = this;
    if (this._searchType == "video") {
      reqwest({
        url: Config.base_url + Config.routes.SEARCH
        , type: 'json'
        , method: 'get'
        , data: {
          content: _this._keyword,
          page_size: 20,
          page: _this._page,
          order: _this._order
        }
        , crossOrigin: true
        , error: function (err) {
          console.log('error:' + err);
        }
        , success: function (data) {
          _this.props.cb(_this._keyword);
          _this.setState({
            list: data.items.archive,
            all_page: 500,
            loading: false
          });
        }
      });
    } else {
      reqwest({
        url: Config.base_url + Config.routes.SEARCH_BY_TYPE
        , type: 'json'
        , method: 'get'
        , data: {
          content: _this._keyword,
          page_size: 20,
          page: _this._page,
          type: _this._searchType
        }
        , crossOrigin: true
        , error: function (err) {
          console.log('error:' + err);
        }
        , success: function (data) {
          _this.props.cb(_this._keyword);
          _this.setState({
            list: data.items,
            all_page: data.pages,
            loading: false
          });
        }
      });
    }
  },
  _getSearch(content){
    this._keyword = content;
    this._loadData();
  },
  _changeOrder(order){
    this._order = order;
    this._loadData();
  },
  _changePage(page){
    this._page = page;
    this._loadData();
    $('body,html').animate({scrollTop: 0}, 700);
  },
  _changeType(type){
    this._searchType = type;
    this._page = 1;
    this._loadData();
  },
  getInitialState(){
    return {
      list: [],
      all_page: 0,
      loading: true
    }
  },
  getDefaultProps(){
    return {
      keyword: "",
      allPage: 20,
      cb: function (content) {
      }
    }
  },
  componentDidMount(){
    this._keyword = this.props.keyword;
    this._loadData();
  },
  componentWillReceiveProps(nextProps){
    this._keyword = nextProps.keyword;
    this._loadData();
    this.setState({
      loading: true
    });
  },
  render(){
    var renderArr = [];

    for (var i = 0; i < this.state.list.length; i++) {
      switch (this._searchType) {
        case "video":
        {
          renderArr.push(<VideoItem key={"video-"+i} data={this.state.list[i]}/>);
          break;
        }
        case "bangumi":
        {
          renderArr.push(<BangumiItem key={"bangumi-"+i} data={this.state.list[i]}/>);
          break;
        }
        case "user":
        {
          renderArr.push(<UserItem key={"user-"+i} data={this.state.list[i]}/>);
        }
      }
    }


    return <div>
      <div className="search-info">

        <div className="search-select-block">
          <ul className="wrap floatleft">
            <li className={(this._searchType=="video"?"active":"")+" sub floatleft"}
                onClick={this._changeType.bind(null, "video")}>视频
            </li>
            <li className={(this._searchType=="bangumi"?"active":"")+" sub floatleft"}
                onClick={this._changeType.bind(null, "bangumi")}>番剧
            </li>
            <li className={(this._searchType=="user"?"active":"")+" sub floatleft"}
                onClick={this._changeType.bind(null, "user")}>UP主
            </li>
          </ul>
          <div className="clear"></div>
        </div>

        {(this._searchType == "video") ? <div className="search-fliter-block">
          <ul className="wrap floatleft">
            <li onClick={this._changeOrder.bind(null,"totalrank")}
                className={(this._order=="totalrank"?"active":"")+" sub floatleft"}>综合排序
            </li>
            <li onClick={this._changeOrder.bind(null,"click")}
                className={(this._order=="click"?"active":"")+" sub floatleft"}>最多点击
            </li>
            <li onClick={this._changeOrder.bind(null,"pubdate")}
                className={(this._order=="pubdate"?"active":"")+" sub floatleft"}>最新发布
            </li>
            <li onClick={this._changeOrder.bind(null,"dm")}
                className={(this._order=="dm"?"active":"")+" sub floatleft"}>弹幕
            </li>
          </ul>
          <div className="clear"></div>
        </div> : <div></div>}
      </div>

      {(this.state.loading) ? <Loading /> :
        <div className="area">
          <div className="search-result-content">
            {renderArr}
            <div className="clear"></div>
            <div className="search-pager">
              <Pager allPage={this.state.all_page} nowPage={this._page} pageCallBack={this._changePage}/>
            </div>
          </div>
        </div>}
    </div>;
  }
});
