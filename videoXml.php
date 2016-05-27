<?php


try {
    while (true) {
        sleep(10);
        $conn = new MongoClient();
        $db = $conn->selectDB('bilibili');
        $collection = new MongoCollection($db, 'videos');
        $cursor = $collection->find()->sort(array('aid' => -1))->limit(500);
        $arr=$cursor;
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><document />');
        $xml->addchild("webSite", "v.dingxiaoyue.com");
        $xml->addchild("webMaster", "wsc449@qq.com");
        $xml->addchild("updatePeri", "60");
        foreach ($cursor as $doc) {
            $item = $xml->addchild("item");
            $item->addchild("op", "add");
            $item->addchild("title", $doc["title"]);
            $item->addchild("category", $doc["typename"]);
            $item->addchild("playLink", 'http://v.dingxiaoyue.com/view/' . $doc["aid"]);
            $item->addchild("imageLink", $doc["pic"]);
            $item->addchild("comment", addslashes($doc["description"]));
            $item->addchild("pubDate", $doc["created_at"]);
        }
        $xml->asXml("public/video.xml");

        $content='<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">';
        foreach ($arr as $doc) {
            $content.="<url>\n";
            $content.="<loc>".'http://v.dingxiaoyue.com/view/' . $doc["aid"]."</loc>\n";
            $content.="<video:video>";
            $content.="<video:thumbnail_loc>". $doc["pic"]."</video:thumbnail_loc>\n";
            $content.="<video:title>". $doc["title"]."</video:title>\n";
            $content.="<video:description>". addslashes($doc["description"])."</video:description>\n";
            $content.="<video:player_loc>". 'http://static.hdslb.com/play.swf?aid=' . $doc["aid"]."</video:player_loc>\n";
            $content.="<video:publication_date>".date(DATE_ATOM,intval($doc["created"]))."</video:publication_date>\n";
            $content.="<video:category>". $doc["typename"]."</video:category>\n";
            $content.="</video:video>\n</url>\n";
        }
        $content.='</urlset>';
        $fp=fopen('public/googleVideo.xml','w+');
        fwrite($fp,$content);
        fclose($fp);

        echo 'ok';
        sleep(1200);
    }
} catch (\Exception $e) {
    dd($e);
}

