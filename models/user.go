package models

//微博User
type WeiboUser struct {
	Token      string
	ExpireTime int64
	Uid        string
	Name       string
	Icon       string
	Info       string
}
