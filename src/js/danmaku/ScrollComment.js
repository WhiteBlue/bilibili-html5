var CommentObject = require('./CommentObject');

class ScrollComment extends CommentObject {
  constructor(manager, init) {
    super(manager, init);
    switch (this.mode) {
      case 1:
        this.align = 0;
        break;
      case 2:
        this.align = 2;
        break;
      case 6:
        this.align = 1;
    }
    this.follow = false;
    this.control = true;
    this.lifeTime *= manager.options.scroll.scale;
    this.moving = false;

    //容差
    this.timeOffset = 700;
  }

  layout() {
    var index = 0;
    var channel = this.Size() + 2 * this.manager.options.margin;
    var offset = 0;
    var insertY = -1;
    var width = this.Width();

    while (insertY < 0) {
      if (index > 1000) {
        return;
      }
      insertY = this._findOffsetY(index, channel, offset);
      index++;
      offset += this.manager.options.indexOffset;
    }
    this.index = index - 1;
    this.offsetY(insertY);
    this.dom.style.right = "-" + width + "px";
    this.dom.style.left = "-" + width + "px";

    this.moveAnimation();
  };

  _findOffsetY(index, channel, offset) {
    var cmObj;
    var preY = offset;
    for (var i = 0; i < this.manager.nowLine.length; i++) {
      cmObj = this.manager.nowLine[i];
      if (cmObj.mode === this.mode && cmObj.index === index) {
        if (cmObj.offsetY() - preY >= channel) {
          return preY;
        }
        if ((!cmObj.follow) && (cmObj.timeLeft <= (cmObj.lifeTime * 0.5))) {
          cmObj.follow = true;
          return cmObj.offsetY();
        }
        preY = cmObj.offsetY() + cmObj.Height();
      }
    }
    if (preY + channel <= this.manager.stage.offsetHeight) {
      return preY;
    }
    return -1;
  };


  transform(trans) {
    this.dom.style.transform = trans;
    this.dom.style["webkitTransform"] = trans;
    this.dom.style["msTransform"] = trans;
    this.dom.style["oTransform"] = trans;
  };

  moveTransform() {
    if (!this.moving) {
      var dx = -(this.manager.width + this.Width());
      this.transform("translateX(" + dx + "px)");
      this.dom.style.transition = "transform " + this.lifeTime + "ms linear";
      this.moving = true;
    }
  };

  moveAnimation() {
    var locate = this.align % 2 == 0 ? '-left ' : '-right ';
    var animation = "cmt-move" + locate + this.lifeTime / 1000 + "s linear";
    this.dom.style.animation = animation;
    this.dom.style["-webkit-animation"] = animation;
    this.dom.style["-moz-animation"] = animation;
    this.dom.style["-o-animation"] = animation;
  };

  start() {
    this.dom.style["animation-play-state"] = "running";
  };

  stop() {
    this.dom.style["animation-play-state"] = "paused";
  };


  checkTime(nowTime) {
    return this.stime + this.lifeTime + this.timeOffset >= nowTime;
  };

}

module.exports = ScrollComment;

