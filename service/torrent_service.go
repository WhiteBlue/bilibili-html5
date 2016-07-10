package service

import (
	"errors"
	"github.com/anacrolix/sync"
	"github.com/anacrolix/torrent"
	"github.com/astaxie/beego"
	"strings"
)

type TorrentClient struct {
	nowTorrent *torrent.Torrent
	fileIndex  int
	lock       *sync.RWMutex
}

type TorrentTask struct {
	FileIndex int
}

type TorrentTaskInfo struct {
	TorrentName string `json:"torrent_name"`
	FileName    string `json:"filename"`
	All         int64  `json:"all_length"`
	Downloaded  int64  `json:"recieve_length"`
	Status      int         `json:"status"`
}

var (
	Torrent = &TorrentClient{
		lock:&sync.RWMutex{},
	}

	config = &torrent.Config{
		//download dir
		DataDir:  "/tmp/",
		NoUpload: true,
		Debug:    false,
	}
)

func (this *TorrentClient) clear() {
	this.lock.Lock()
	defer this.lock.Unlock()

	this.fileIndex = 0
	this.nowTorrent = nil
}

func (this *TorrentClient) runDownloadTask(magnet, fileName string) (string, error) {
	client, err := torrent.NewClient(config)
	if err != nil {
		return "", err
	}

	//close client
	defer client.Close()

	t, err := client.AddMagnet(magnet)
	if err != nil {
		beego.Debug("add magnet error: ", err.Error(), ", magnet: ", magnet)
		return "", err
	}
	//drop torrent when download success
	defer t.Drop()

	//wait for torrent info
	beego.Debug("read torrent info...")
	c := t.GotInfo()
	<-c

	var fileTarget *torrent.File = nil
	var fileIndex int = 0

	//find target file
	if strings.TrimSpace(fileName) == "" {
		for index, file := range t.Files() {
			if strings.HasSuffix(file.DisplayPath(), ".mp4") {
				fileTarget = &file
				fileIndex = index
				break
			}
		}
	} else {
		for index, file := range t.Files() {
			if strings.EqualFold(file.DisplayPath(), fileName) {
				fileTarget = &file
				fileIndex = index
				break
			}
		}
	}

	//target file not found
	if fileTarget == nil {
		beego.Warn("file not found ...")
		return "", errors.New("file not found....")
	}

	this.fileIndex = fileIndex
	this.nowTorrent = t
	defer this.clear()

	beego.Debug("download start...")

	fileTarget.Download()

	client.WaitAll()

	beego.Debug("download success...")

	return config.DataDir + fileTarget.DisplayPath(), nil
}

func (this *TorrentClient) GetTask() *TorrentTaskInfo {
	this.lock.RLock()
	defer this.lock.RUnlock()

	if this.nowTorrent == nil {
		return nil
	}
	t := this.nowTorrent
	f := t.Files()[this.fileIndex]

	return &TorrentTaskInfo{
		TorrentName:t.Name(),
		FileName:f.DisplayPath(),
		All:         f.FileInfo().Length,
		Downloaded:  t.BytesCompleted(),
	}
}

func (this *TorrentClient) RunTask(magnet, fileName string) (string, error) {
	return this.runDownloadTask(magnet, fileName)
}
