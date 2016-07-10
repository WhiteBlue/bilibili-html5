FROM golang:latest
MAINTAINER whiteblue0616@gmail.com

ADD . $GOPATH/src/github/src/github.com/whiteblue/bilibili-html5

COPY /etc/bh5/config.json $GOPATH/src/github/src/github.com/whiteblue/bilibili-html5/conf/config.json
COPY /etc/bh5/app.conf $GOPATH/src/github/src/github.com/whiteblue/bilibili-html5/conf/app.conf

RUN go get -u github.com/tools/godep \
    && rm -rf $GOPATH/src/* \
    && rm -rf $GOPATH/pkg/*

EXPOSE 8000


ENTRYPOINT ["$GOPATH/src/github/src/github.com/whiteblue/bilibili-html5/run.sh"]

