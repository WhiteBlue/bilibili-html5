package service

import (
	"github.com/astaxie/beego"
	"github.com/whiteblue/bilibili-html5/utils"
	"os"
)


/*
Upload video file to CDN
 */

type UploadFuture struct {
	Task     *TaskApplication
	FilePath string
}

func NewUploadFuture(filePath string, task *TaskApplication) *UploadFuture {
	return &UploadFuture{
		Task:     task,
		FilePath: filePath,
	}
}

func (this *UploadFuture) Run() error {
	this.Task.Status = STATUS_UPLOAD

	beego.Debug("start upload, task:", this.Task.Video.Title)

	key, err := utils.Upload.UploadFile(this.FilePath)
	if err != nil {
		return err
	}
	this.Task.Video.VideoKey = key

	err = Video.Insert(this.Task.Video)

	//delete file when success..
	os.Remove(this.FilePath)

	return err
}

func (this *UploadFuture) Success() {
	beego.Debug("upload success, task:", this.Task.Video.Title)

	Update.ClearTask()
}

func (this *UploadFuture) Failure(err error) {
	beego.Error("upload error, task:", this.Task.Video.Title)

	Update.ClearTask()
}
