function BilibiliParser(xmlDoc) {
  var elements = xmlDoc.getElementsByTagName('d');

  var danmakuList = [];
  for (var i = 0; i < elements.length; i++) {
    if (elements[i].getAttribute('p') != null) {
      var opt = elements[i].getAttribute('p').split(',');
      if (!elements[i].childNodes[0])
        continue;
      var text = elements[i].childNodes[0].nodeValue;
      var obj = {};
      obj.stime = Math.round(parseFloat(opt[0]) * 1000);
      obj.mode = parseInt(opt[1]);
      obj.size = parseInt(opt[2]);
      obj.color = parseInt(opt[3]);
      obj.date = parseInt(opt[4]);
      obj.pool = parseInt(opt[5]);
      obj.position = "absolute";
      if (opt[7] != null)
        obj.dbid = parseInt(opt[7]);
      obj.hash = opt[6];
      obj.border = false;
      if (obj.mode < 7) {
        obj.text = text.replace(/(\/n|\\n|\n|\r\n)/g, "\n");
      }
      if (obj.text != null)
        obj.text = obj.text.replace(/\u25a0/g, "\u2588");
      danmakuList.push(obj);
    }
  }
  return danmakuList;
}

module.exports = BilibiliParser;

