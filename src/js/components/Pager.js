var React = require('react');

module.exports = React.createClass({
  _pageChange(page){
    if (page < 1) {
      page = 1;
    }
    if (page > this.props.allPage) {
      page = this.props.allPage;
    }
    this.props.pageCallBack(page);
  },
  getDefaultProps(){
    return {
      nowPage: 1,
      allPage: 0,
      showPageCount: 8,
      pageCallBack: function (page) {
      }
    };
  },
  render(){
    var start = this.props.nowPage - this.props.showPageCount / 2;
    if (start < 1) {
      start = 1;
    }
    var renderList = [];

    for (var i = 0; i < this.props.showPageCount; i++) {
      if (i >= this.props.allPage) {
        break;
      }
      var index = start + i;
      if (index === this.props.nowPage) {
        renderList.push(<span key={"pager-"+index} className="floatleft active">{index}</span>)
      } else {
        renderList.push(<span key={"pager-"+index} onClick={this._pageChange.bind(null,index)}
                              className="floatleft">{index}</span>)
      }
    }
    return (this.props.allPage <= 1 ? <div></div> : <div className="area-pager">
      <span onClick={this._pageChange.bind(null,1)} className="floatleft">首页</span>
      <span onClick={this._pageChange.bind(null,this.props.nowPage-1)} className="floatleft">上一页</span>
      {renderList}
      <span onClick={this._pageChange.bind(null,this.props.nowPage+1)} className="floatleft next">下一页</span>
    </div>);
  }
});
