package models

import "time"

type Bangumi struct {
	Id     int64
	NameCn string //中文名
	NameJp string //日文名

	PicLarge  string
	PicMedium string
	PicCommon string
	PicSmall  string
	PicGrid   string

	BeginTime time.Time //开播时间
	Show      bool      `orm:"default(false)"` //是否展示
	End       bool      //是否完结
	Day       int
}
