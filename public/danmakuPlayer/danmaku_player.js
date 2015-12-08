/**
 * Created by WhiteBlue on 15/12/7.
 */


function loadPlayer(element_id, loading_element) {

    var videoPlayer = {
        videoJs: videojs(element_id),
        videoElement: null,
        data_insert: [
            '插入栓 插入',
            '播放传导系统 准备接触',
            '探针插入 完毕',
            '神经同调装置在基准范围内',
            '插入栓注水',
            '播放器界面连接',
            '同步率为100%',
            '第一锁定器解除',
            '第二锁定器解除'
        ],
        data_i: 0,
        loadingDialog: $(loading_element)
    };
    /**
     * 视频加载
     * @param source 视频源地址
     */
    videoPlayer.loadVideo = function (source) {

        this.videoJs.src(source);
    };
    /**
     * 弹幕加载
     *
     * @param source 弹幕文件地址
     */
    videoPlayer.loadDanmaku = function (source) {
        this.videoJs.ABP();
        this.videoJs.danmu.load(source);
    };

    /**
     * 提示信息
     */
    videoPlayer.addLoadingText = function (text) {
        this.loadingDialog.append("<p class='loading_text_hidden' style='display: none'>" + text + "</p>");
        $('.loading_text_hidden').fadeIn();
    };

    /**
     * 事件绑定
     *
     * @param funcLoad 加载事件
     * @param funcClear 加载完成事件
     */
    videoPlayer.bindFunction = function (funcLoad, funcClear) {
        this.videoJs.on("progress", funcLoad);
        this.videoJs.on("canplay", funcClear);
    };

    /**
     * 事件解绑
     *
     * @param funcLoad 加载事件
     * @param funcClear 加载完成事件
     */
    videoPlayer.offFunction = function (funcLoad, funcClear) {
        this.videoJs.off("progress", funcLoad);
        this.videoJs.off("canplay", funcClear);
    };


    videoPlayer.loadStart = function () {
        videoPlayer.addLoadingText('加载开始');

        var load = function () {
            if (videoPlayer.data_i < videoPlayer.data_insert.length) {
                videoPlayer.addLoadingText(videoPlayer.data_insert[videoPlayer.data_i]);
                videoPlayer.data_i++;
            }
        };

        var clear = function () {
            videoPlayer.addLoadingText('加载完成!');
            videoPlayer.offFunction(load, clear);
            videoPlayer.loadingDialog.fadeOut();
        };

        this.bindFunction(load, clear);
    };

    return videoPlayer;
}
