package models

import "time"

type Video struct {
	Id          int64
	Bangumi     *Bangumi `orm:"null;rel(one);on_delete(cascade)"`
	Title       string
	Description string //描述
	VideoKey    string //七牛key
	CreateTime  time.Time `orm:"auto_now;type(datetime)"`
	UpdateTime  time.Time `orm:"auto_now_add;type(datetime)"`
	Author      string
	AuthorFace  string
}
