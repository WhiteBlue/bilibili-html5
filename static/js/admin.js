function initAdminContainer() {
    var _content = {};

    var _frame = $("#admin_content");
    if (typeof(_frame) == "undefined") {
        console.log("error: #admin_content ot found...");
        return;
    }
    _content._frame = _frame;
    _content._info_contianer = $("#info_content");

    _content.showError = function (msg) {
        this._info_contianer.append('<div class="alert alert-danger alert-dismissible">' +
            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' +
            '<h4><i class="icon fa fa-ban"></i> Alert!</h4>' + msg + '</div>');
    };

    _content.showInfo = function (msg) {
        this._info_contianer.append('<div class="alert alert-info alert-dismissible">' +
            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' +
            '<h4><i class="icon fa fa-ban"></i> Info!</h4>' + msg + '</div>');
    };

    return _content;
}


function loadVideoSubmitDialog(submitFunc) {
    var _data = {
        frame: $('#submitDialog'),
        submitBtn: $('#submitBtn'),
        _bangumiId: "",
        _titleInput: $('#videoTitle'),
        _contentInput: $('#videoContent'),
        _magnetInput: $('#videoMagnet'),
        _filenameInput: $('#videoFilename')
    };

    _data.submit = function () {
        var title = _data._titleInput.val();
        var content = _data._contentInput.val();
        var magnet = _data._magnetInput.val();
        var filename = _data._filenameInput.val();

        this.clear();

        submitFunc(this._bangumiId, title, content, magnet, filename);
    };

    _data.clear = function () {
        this._titleInput.val("");
        this._contentInput.val("");
        this._magnetInput.val("");
    };

    _data.bind = function (bangumiId) {
        this._bangumiId = bangumiId;
    };

    _data.submitBtn.on('click', function () {
        _data.submit();
    });

    $('.btn-newtask').on('click', function () {
        var bangumiId = $(this).attr("bangumi-id");
        _data.bind(bangumiId);
    });

    return _data;
}

function initVideoList() {
    $('.btn-bangumi').on('click', function (event) {
        event.preventDefault();
        var url = $(this).attr("href");
        $.ajax({
            type: 'POST',
            url: url,
            data: {},
            success: function (resp) {
                if (resp.code == 0) {
                    _content.container.showInfo("更改成功");
                    location.reload();
                } else {
                    _content.container.showError(resp.msg)
                }
            },
            error: function (err) {
                _content.container.showError(err);
            }
        });
    });
}

function initBangumiList() {
    var _content = {
        container: initAdminContainer(),
        dialog: null
    };

    var submitFunc = function (bangumiId, title, content, magnet, filename) {
        $.ajax({
            type: 'POST',
            url: "/admin/addtask",
            data: {
                "bangumi_id": bangumiId,
                "title": title,
                "description": content,
                "magnet": magnet,
                "filename": filename
            },
            success: function (resp) {
                if (resp.code == 0) {
                    _content.container.showInfo("提交成功...");
                    location.reload();
                } else {
                    _content.container.showError(resp.msg);
                }
            },
            error: function (err) {
                _content.container.showError(err);
            }
        });
    };

    _content.dialog = loadVideoSubmitDialog(submitFunc);

    $('.btn-bangumi').on('click', function (event) {
        event.preventDefault();
        var url = $(this).attr("href");
        $.ajax({
            type: 'POST',
            url: url,
            data: {},
            success: function (resp) {
                if (resp.code == 0) {
                    _content.container.showInfo("更改成功");
                    location.reload();
                } else {
                    _content.container.showError(resp.msg)
                }
            },
            error: function (err) {
                _content.container.showError(err);
            }
        });
    });

    $('#update_btn').on('click', function () {
        $(this).toggleClass("disabled");

        var _this = $(this);
        $.ajax({
            type: 'GET',
            url: "/admin/update_bangumi",
            data: {},
            success: function (resp) {
                _this.toggleClass("disabled");
                if (resp.code == 0) {
                    _content.container.showInfo("更新成功");
                    location.reload();
                } else {
                    _content.container.showError(resp.msg)
                }
            },
            error: function (err) {
                _this.toggleClass("disabled");
                _content.container.showError(err);
            }
        });
    });
}
