package utils

import (
	"github.com/astaxie/beego"
	"github.com/qiniu/api.v7/kodo"
	"golang.org/x/net/context"
	"time"
)

const (
	//上传超时(秒)
	UPLOAD_TIMEOUT = 7200
)

var (
	Upload = &Uploader{}
	//默认所在区
	zone = 0
)

type PutReturn struct {
	Hash string `json:"hash"`
	Key  string `json:"key"`
}

type Uploader struct{}

//上传文件(block)
func (this *Uploader) UploadFile(sourcePath string) (string, error) {
	c := kodo.New(zone, nil)

	//超时context
	ctx, cancel := context.WithTimeout(context.Background(), UPLOAD_TIMEOUT * time.Second)
	defer cancel()

	bucket := c.Bucket(Conf.QiniuAPI.VideoBucket)

	ret := &PutReturn{}

	beego.Debug("upload start, fileName:", sourcePath)

	err := bucket.PutFileWithoutKey(ctx, ret, sourcePath, nil)
	if err != nil {
		beego.Error("upload failed, fileName:", err)
		return "", err
	}

	beego.Debug("upload success, fileName:", sourcePath)

	return ret.Key, nil
}

func (this *Uploader) DeleteFile(key string) error {
	c := kodo.New(zone, nil)

	ctx, cancel := context.WithTimeout(context.Background(), UPLOAD_TIMEOUT * time.Second)
	defer cancel()

	bucket := c.Bucket(Conf.QiniuAPI.VideoBucket)

	err := bucket.Delete(ctx, key)

	return err
}

func (this *Uploader) GetFileUrl(key string) string {
	c := kodo.New(zone, nil)

	policy := &kodo.GetPolicy{}

	baseUrl := kodo.MakeBaseUrl(Conf.QiniuAPI.VideoDomain, key)

	privateUrl := c.MakePrivateUrl(baseUrl, policy)

	return privateUrl
}

