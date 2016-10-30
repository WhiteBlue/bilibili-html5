var CommentObject = require('./CommentObject');


class StaticComment extends CommentObject {
  constructor(manager, init) {
    super(manager, init);
    this.align = (this.mode == 4) ? 3 : 0;
  }

  _findOffsetY(index, channel, offset) {
    //取得起始位置(区别对齐方式)
    var preY = offset;
    for (var i in this.manager.nowLine) {
      var cmObj = this.manager.nowLine[i];
      //弹幕同类型同层
      if (cmObj.mode === this.mode && cmObj.index === index) {
        if (cmObj.offsetY() - preY >= channel) {
          return preY;
        } else {
          preY = cmObj.offsetY() + cmObj.Height();
        }
      }
    }
    if (preY + channel <= this.manager.stage.offsetHeight) {
      return preY;
    }
    return -1;
  };

  layout() {
    var index = 0;
    var channel = this.Height() + 2 * this.manager.options.margin;
    var offset = 0;
    var insertY = -1;

    while (insertY < 0) {
      insertY = this._findOffsetY(index, channel, offset);
      index++;
      offset += this.manager.options.indexOffset;
    }

    this.index = index - 1;
    this.offsetX(this.manager.stage.offsetLeft + (this.manager.stage.offsetWidth - this.Width()) / 2);
    this.offsetY(insertY);
  };
}


module.exports = StaticComment;

