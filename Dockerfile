FROM golang:latest
MAINTAINER whiteblue0616@gmail.com

ADD . $GOPATH/src/github/src/github.com/whiteblue/bilibili-html5
COPY run.sh /etc/bh5/run.sh

RUN go get -u github.com/tools/godep \
    && rm -rf $GOPATH/src/* \
    && rm -rf $GOPATH/pkg/*

EXPOSE 8000

ENTRYPOINT ["/etc/bh5/run.sh"]

