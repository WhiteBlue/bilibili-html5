package utils

import (
	"crypto/md5"
	"fmt"
	"github.com/astaxie/beego"
	"io"
	"math/rand"
	"strconv"
	"time"
)

const (
	QUEUE_LEN = 10
)

var (
	Exec = &Executor{
		queue: make(chan Future, QUEUE_LEN),
	}
)

/*
   异步任务队列
*/

//异步任务
type Future interface {
	Run() error
	Success()
	Failure(error)
}

type Executor struct {
	//任务队列
	queue chan Future
}

//提交任务
func (this *Executor) Submit(f Future) {
	this.queue <- f
}

//开始处理
func (this *Executor) Start() {
	go func() {
		for {
			if f, ok := <-this.queue; ok {
				//执行任务
				go this.exec(f)
			} else {
				//channel已关闭
				break
			}
		}
	}()
}

//关闭
func (this *Executor) Shutdown() {
	close(this.queue)
}

func (this *Executor) exec(f Future) {
	//异常处理
	defer func() {
		if r := recover(); r != nil {
			beego.Error("executor runtime error...", r)
		}
	}()

	if err := f.Run(); err != nil {
		f.Failure(err)
	} else {
		f.Success()
	}
}

//md5加密
func Md5(text string) string {
	hashMd5 := md5.New()
	io.WriteString(hashMd5, text)
	return fmt.Sprintf("%x", hashMd5.Sum(nil))
}

//唯一ID生成
func GenerateFutureId() string {
	nano := time.Now().UnixNano()
	rand.Seed(nano)
	rndNum := rand.Int63()
	sessionId := Md5(Md5(strconv.FormatInt(nano, 10)) + Md5(strconv.FormatInt(rndNum, 10)))
	return sessionId
}
