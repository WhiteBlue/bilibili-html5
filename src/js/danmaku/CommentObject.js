class CommentObject {

  constructor(manager, init) {
    this.align = 0;
    this.index = 0;
    this.mode = 1;
    this.stime = 0;
    this.text = "";
    this._size = 20;
    this._color = 0xffffff;
    this.control = false;
    this._border = false;

    this.lifeTime = 4000 * manager.options.global.scale;
    this.manager = manager;

    if (init.hasOwnProperty("align")) {
      this.align = init["align"];
    }
    if (init.hasOwnProperty("stime")) {
      this.stime = init["stime"];
    }
    if (init.hasOwnProperty("text")) {
      this.text = init["text"];
    }
    if (init.hasOwnProperty("mode")) {
      this.mode = init["mode"];
    }
    if (init.hasOwnProperty("color")) {
      this._color = init["color"];
    }
    if (init.hasOwnProperty("size")) {
      this._size = init["size"];
    }
    if (init.hasOwnProperty("x")) {
      this._x = init["x"];
    }
    if (init.hasOwnProperty("y")) {
      this._y = init["y"];
    }
    if (init.hasOwnProperty("border")) {
      this._border = init["border"];
    }
  }

  offsetX(x) {
    if (x === null || x === undefined) {
      if (this._x === null || this._x === undefined) {
        if (this.align % 2 === 0) {
          this._x = this.dom.offsetLeft - this.manager.stage.offsetLeft;
        } else {
          this._x = this.manager.stage.offsetWidth - (this.dom.offsetLeft - this.manager.stage.offsetLeft + this.dom.offsetWidth);
        }
      }
      return this._x;
    } else {
      this._x = x;
      if (this.align % 2 === 0) {
        this.dom.style.right = this._x + "px";
      } else {
        this.dom.style.left = this._x + "px";
      }
    }
  };


  offsetY(y) {
    if (y === null || y === undefined) {
      if (this._y === null || this._y === undefined) {
        if (this.align < 2) {
          this._y = this.dom.offsetTop;
        } else {
          this._y = this.manager.stage.offsetHeight - (this.dom.offsetTop + this.dom.offsetHeight);
        }
      }
      return this._y;
    } else {
      this._y = y;
      if (this.align < 2) {
        this.dom.style.top = this._y + "px";
      } else {
        this.dom.style.top = (this.manager.stage.offsetHeight - y - this.dom.offsetHeight) + "px";
      }
    }
  };


  Color(c) {
    if (c === null || c === undefined) {
      return this._color;
    } else {
      this._color = c;
      var color = c.toString(16);
      color = color.length >= 6 ? color : new Array(6 - color.length + 1).join("0") + color;
      if (color.indexOf('#') !== 0) {
        color = '#'.concat(color);
      }
      this.dom.style.color = color;
      if (this._color === 0) {
        this.dom.className = this.manager.options.className + " rshadow";
      }
    }
  };


  Width(w) {
    if (w === null || w === undefined) {
      if (this._width === null || this._width === undefined) {
        this._width = this.dom.offsetWidth;
      }
      return this._width;
    } else {
      this._width = w;
      this.dom.style.width = this._width + "px";
    }
  };


  Height(h) {
    if (h === null || h === undefined) {
      if (this._height === null || this._height === undefined) {
        this._height = this.dom.offsetHeight;
      }
      return this._height;
    } else {
      this._height = h;
      this.dom.style.height = this._height + "px";
    }
  };


  Size(s) {
    if (s === null || s === undefined) {
      return this._size;
    } else {
      this._size = s;
      this.dom.style.fontSize = this._size + "px";
    }
  };


  Border(b) {
    if (b === null || b === undefined) {
      return this._border;
    } else {
      this._border = b;
      this.dom.style.border = b;
    }
  };


  init() {
    var dom = document.createElement("div");
    dom.className = this.manager.options.className;

    dom.appendChild(document.createTextNode(this.text));

    dom.textContent = this.text;
    dom.innerText = this.text;

    this.dom = dom;

    if (this._border) {
      dom.style.border = "2px solid red";
    }

    this.Color(this._color);
    this.Size(this._size);
  };

  checkTime(nowTime) {
    return (this.stime + this.lifeTime) >= nowTime;
  };


  layout() {
  };


  stop() {
  };

  start() {
  };

}


module.exports = CommentObject;
