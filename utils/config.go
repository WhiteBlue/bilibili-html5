package utils

import (
	"encoding/json"
	"errors"
	"io/ioutil"
	"os"
	"strings"
)

const (
	CONFIG_JSON = "/etc/bh5/config.json"
)

var (
	Conf Configuration
)

type Configuration struct {
	Db             Db
	Administrators []string
	Downloader     Downloader
	SinaAPI        SinaAPI
	QiniuAPI       QiniuAPI
}

type SinaAPI struct {
	APP_KEY      string
	APP_SECRET   string
	REDIRECT_URL string
}

type QiniuAPI struct {
	AccessKey   string
	SecretKey   string
	VideoDomain string
	VideoBucket string
}

type Db struct {
	User         string
	Pass         string
	Host         string
	Port         string
	Database     string
	MaxIdleConns int
	MaxOpenConns int
	Debug        bool
}

type Downloader struct {
	MaxTask int
}

//加载全局配置
func LoadConfiguration() error {
	if _, err := os.Stat(CONFIG_JSON); os.IsNotExist(err) {
		return errors.New("config file not found...")
	}

	file, err := os.Open(CONFIG_JSON)
	if err != nil {
		return err
	}
	defer file.Close()

	bytes, _ := ioutil.ReadAll(file)

	if err := json.Unmarshal(bytes, &Conf); err != nil {
		return err
	}
	return nil
}

func GetWeiboClient() *WeiboClient {
	return NewWeiboClient(Conf.SinaAPI.APP_KEY, Conf.SinaAPI.APP_SECRET, Conf.SinaAPI.REDIRECT_URL)
}

//权限检查
func CheckAdministrator(uid string) bool {
	for _, id := range Conf.Administrators {
		if strings.EqualFold(uid, id) {
			return true
		}
	}
	return false
}
