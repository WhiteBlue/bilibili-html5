var StaticComment = require('./StaticComment');
var ScrollComment = require('./ScrollComment');


class CommentManager {
  constructor(stage) {
    this.commentLine = [];
    this.nowLine = [];
    this.position = 0;
    this.options = {
      indexOffset: 0,
      className: "cmt",
      margin: 1,
      global: {
        opacity: 1,
        scale: 1
      },
      scroll: {
        opacity: 1,
        scale: 1
      },
      limit: 0
    };
    this.stage = stage;
    this.width = stage.offsetWidth;
    this.height = stage.offsetHeight;
  }

  startTimer() {
    for (var i = 0; i < this.nowLine.length; i++) {
      if (this.nowLine[i].control) {
        this.nowLine[i].start();
      }
    }
  }

  stopTimer() {
    for (var i = 0; i < this.nowLine.length; i++) {
      if (this.nowLine[i].control) {
        this.nowLine[i].stop();
      }
    }
  }

  nowLinePush(pushCmt) {
    if (this.nowLine.length === 0) {
      this.nowLine.push(pushCmt);
      return;
    }
    if (this.nowLine[this.nowLine.length - 1].offsetY() <= pushCmt.offsetY()) {
      this.nowLine.push(pushCmt);
      return;
    }
    if (this.nowLine[0].offsetY() >= pushCmt.offsetY()) {
      this.nowLine.unshift(pushCmt);
      return;
    }
    var low = 0;
    var high = this.nowLine.length - 1;

    var i = 0;
    var insertIndex = 0;
    while (low < high) {
      i = Math.floor((high + low + 1) / 2);
      if (this.nowLine[i - 1].offsetY() <= pushCmt.offsetY() && this.nowLine[i].offsetY() >= pushCmt.offsetY()) {
        insertIndex = i;
        break;
      }
      if (this.nowLine[i - 1].offsetY() > pushCmt.offsetY()) {
        high = i - 1;
      } else {
        low = i;
      }
    }
    this.nowLine.splice(insertIndex, 0, pushCmt);
  }

  nowLineRemove(removeCmt) {
    var index = this.nowLine.indexOf(removeCmt);
    if (index >= 0) {
      this.nowLine.splice(index, 1);
    }
  }

  setBounds() {
    this.width = this.stage.offsetWidth;
    this.height = this.stage.offsetHeight;
  };

  init() {
    this.setBounds();
    this.position = 0;
  };


  //插入弹幕
  send(data) {
    var cmt;
    if (data.mode === 5 || data.mode === 4) {
      cmt = new StaticComment(this, data);
    } else if (data.mode === 1 || data.mode === 2 || data.mode == 6) {
      cmt = new ScrollComment(this, data);
    } else {
      console.log('不支持的弹幕');
      return;
    }
    cmt.init();
    this.stage.appendChild(cmt.dom);
    cmt.layout();
    this.nowLinePush(cmt);
  };

  seek(locateTime) {
    this.position = 0;
    this.position = this.locate(locateTime);
  };

  locate(time) {
    for (var i = this.position; i < this.commentLine.length; i++) {
      var cm = this.commentLine[i];
      if (cm.stime >= time) {
        return i;
      }
    }
    return this.commentLine.length;
  };

  time(nowTime) {
    if (this.nowLine.length === 0 && this.position === this.commentLine.length) {
      return;
    }

    nowTime -= 1;

    if (this.position < this.commentLine.length) {
      var end = this.locate(nowTime);

      for (; this.position < end; this.position++) {
        this.send(this.commentLine[this.position]);
      }
      this.position = end;
    }

    var length = this.nowLine.length;
    for (var i = 0; i < length; i++) {
      var cmt = this.nowLine[i];
      if (!cmt.checkTime(nowTime)) {
        this.remove(cmt);
        length--;
      }
    }
  };

  load(timeLine) {
    this.commentLine = timeLine;
    this.position = 0;
    this.commentLine.sort(function (a, b) {
      if (a.stime >= b.stime) {
        return 1;
      } else {
        return -1;
      }
    });
  };

  remove(rmObj) {
    this.nowLineRemove(rmObj);
    this.stage.removeChild(rmObj.dom);
  };

  clear() {
    while (this.nowLine.length > 0) {
      this.remove(this.nowLine[0]);
    }
  };
}

module.exports = CommentManager;
