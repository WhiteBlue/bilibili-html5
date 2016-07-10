package service

import (
	"github.com/astaxie/beego"
	"github.com/whiteblue/bilibili-html5/utils"
)

type DownloadFuture struct {
	Task     *TaskApplication
	FilePath string
}

func (this *DownloadFuture) Run() error {
	this.Task.Status = STATUS_DOWNLOAD
	beego.Debug("start download, taskName: ", this.Task.Title)
	path, err := Torrent.RunTask(this.Task.Magnet, this.Task.FileName)

	this.FilePath = path

	return err
}

func (this *DownloadFuture) Success() {
	beego.Debug("download success, taskName: ", this.Task.Title)

	utils.Exec.Submit(NewUploadFuture(this.FilePath, this.Task))
}

func (this *DownloadFuture) Failure(error) {
	Update.ClearTask()
}

func NewDownloadFuture(application *TaskApplication) *DownloadFuture {
	return &DownloadFuture{
		Task:application,
	}
}
