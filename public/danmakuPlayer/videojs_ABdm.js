videojs.plugin('ABP', ABPinit);
function ABPinit(){
	function Danmu(ele){
		///////////////////////////////////////////
		///Prepare the html element for the plugin.
		///////////////////////////////////////////
		_this=this;
		this.danmuDiv = document.createElement('div');
		this.danmuDiv.className = 'vjs-danmu';
		ele.el().insertBefore(this.danmuDiv,ele.el().getElementsByClassName('vjs-poster')[0]);

		this.danmuShowControl = document.createElement('div');
		this.danmuShowControl.className = 'vjs-danmu-control vjs-menu-button vjs-control';
		this.danmuShowControlContent = document.createElement('span');
		this.danmuShowControlContent.className = 'player_glyphicon glyphicon glyphicon-eye-open';
		this.danmuShowControl.appendChild(this.danmuShowControlContent);
		ele.el().getElementsByClassName('vjs-control-bar')[0].appendChild(this.danmuShowControl);

		///////////////////////////////////////////
		//Bind CommentManager.
		///////////////////////////////////////////
		if(typeof CommentManager !== "undefined"){
			this.cmManager = new CommentManager(this.danmuDiv);
			this.cmManager.display = true;
			this.cmManager.init();
			this.cmManager.clear();

			//Bind control to video.
			var video=ele.el().children[0];
			var lastPosition = 0;
			video.addEventListener("progress", function(){
				if(lastPosition == video.currentTime){
					video.hasStalled = true;
					_this.cmManager.stopTimer();
				}else
				lastPosition = video.currentTime;
			});

			video.addEventListener("timeupdate", function(){
				if(_this.cmManager.display === false) return;
				if(video.hasStalled){
					_this.cmManager.startTimer();
					video.hasStalled = false;
				}
				_this.cmManager.time(Math.floor(video.currentTime * 1000));
			});

			video.addEventListener("play", function(){
				_this.cmManager.startTimer();
			});

			video.addEventListener("pause", function(){
				_this.cmManager.stopTimer();
			});

			video.addEventListener("waiting", function(){
				_this.cmManager.stopTimer();
			});

			video.addEventListener("playing",function(){
				_this.cmManager.startTimer();
			});

			video.addEventListener("seeked",function(){
				_this.cmManager.clear();
			});

			if(window){
				window.addEventListener("resize", function(){
					_this.cmManager.setBounds();
				});
			}

			//Bind Control to button
			this.danmuShowControl.addEventListener("click", function(){
				if(_this.cmManager.display==true){
					_this.cmManager.display=false;
					_this.cmManager.clear();
					_this.danmuShowControlContent.setAttribute("class","player_glyphicon glyphicon glyphicon-eye-close");
				}else{
					_this.cmManager.display=true;
					_this.danmuShowControlContent.setAttribute("class","player_glyphicon glyphicon glyphicon-eye-open");
				}
			});

			//Create Load function
			this.load = function(url,callback){
				if(callback == null)
				  callback = function(){return;};
				if (window.XMLHttpRequest){
					xmlhttp=new XMLHttpRequest();
				}
				else{
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.open("GET",url,true);
				xmlhttp.send();
				var cm = this.cmManager;
				var cmvideo = video;
				xmlhttp.onreadystatechange = function(){
					if (xmlhttp.readyState==4 && xmlhttp.status==200){
						if(navigator.appName == 'Microsoft Internet Explorer'){
							var f = new ActiveXObject("Microsoft.XMLDOM");
							f.async = false;
							f.loadXML(xmlhttp.responseText);
							cm.load(BilibiliParser(f));
							cm.seek(cmvideo.currentTime*1000);
							callback(true);
						}else{
							cm.seek(cmvideo.currentTime*1000);
							cm.load(BilibiliParser(xmlhttp.responseXML));
							callback(true);
						}
					}else
					  callback(false);
				}
			}

		}
		return this;
	}
	this.danmu = new Danmu(this);
}

