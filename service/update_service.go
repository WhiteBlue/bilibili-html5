package service

import (
	"github.com/anacrolix/sync"
	"github.com/whiteblue/bilibili-html5/models"
	"github.com/astaxie/beego/orm"
	"qiniupkg.com/x/errors.v7"
	"github.com/whiteblue/bilibili-html5/utils"
)

const (
	STATUS_NEWTASK = iota
	STATUS_DOWNLOAD
	STATUS_UPLOAD
	STATUS_SUCCESS
	STATUS_FAILED
)

var (
	Update = &UpdateService{
		lock: &sync.RWMutex{},
	}
)

type TaskInfo struct {
	TaskName   string `json:"task_name"`
	Status     int  `json:"status"`
	StatusStr  string       `json:"status_str"`
	Percentage float32  `json:"percentage"`
}

type TaskApplication struct {
	Video       *models.Video
	BangumiId   int64
	Title       string
	Description string
	Magnet      string
	FileName    string
	UserName    string
	UserFace    string
	Status      int
}

type UpdateService struct {
	task *TaskApplication
	lock *sync.RWMutex
}

//run new task
func (this *UpdateService) NewTask(task *TaskApplication) error {
	o := orm.NewOrm()

	c, err := o.QueryTable("video").Filter("title", task.Title).Count()
	if err != nil {
		return err
	}
	if c > 0 {
		return errors.New("video has already exist...")
	}

	if !this.SetTask(task) {
		return errors.New("task alreay in use...")
	}

	utils.Exec.Submit(NewDownloadFuture(task))

	return nil
}

//remove task when upload success
func (this *UpdateService) ClearTask() {
	this.lock.Lock()
	defer this.lock.Unlock()
	this.task = nil
}

//update background task
func (this *UpdateService) SetTask(application *TaskApplication) bool {
	this.lock.Lock()
	defer this.lock.Unlock()

	if this.task != nil {
		return false
	}
	this.task = application
	return true
}


//get download && upload task info
func (this *UpdateService) GetInfo() *TaskInfo {
	this.lock.RLock()
	defer this.lock.RUnlock()

	if this.task == nil {
		return nil
	}

	var status string = ""

	switch this.task.Status {
	case STATUS_NEWTASK:
		status = "新任务"
	case STATUS_DOWNLOAD:
		status = "下载中"
	case STATUS_UPLOAD:
		status = "上传中"
	}

	var percentage float32 = 0
	if this.task.Status == STATUS_DOWNLOAD {
		task := Torrent.GetTask()
		if task != nil {
			mid := int(float32(Torrent.GetTask().Downloaded) / float32(Torrent.GetTask().All) * 1000)
			percentage = float32(mid) / 1000
		}
	} else if this.task.Status == STATUS_UPLOAD {
		percentage = 0.5
	}
	percentage *= 100

	return &TaskInfo{
		TaskName:this.task.Title,
		Status:this.task.Status,
		StatusStr:status,
		Percentage:percentage,
	}
}



