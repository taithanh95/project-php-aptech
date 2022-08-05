<?php

$connect = @mysql_connect("localhost","root","") or die("Khong ket noi duoc host");
@mysql_select_db("tmdt",$connect);
@mysql_query("SET NAMES 'UTF8'",$connect);
$set = @mysql_fetch_array(@mysql_query("SELECT * FROM `settings`"));
header("Content-Type: text/xml;charset=UTF-8");
echo '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="'.$set['home'].'/sitemap.xsl"?>';
echo '
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

$sql = "SELECT * FROM `products` WHERE `show` = 'true'";
$result = @mysql_query($sql);
if(@mysql_num_rows($result) == 0)
    echo 'Chua c� b�i vi?t n�o';
else {
    $date = date("Y-m-d H:i:s");
    echo '
<url>
    <loc>'.$set['home'].'</loc>
    <lastmod>'.$date.'</lastmod>
    <changefreq>always</changefreq>
    <priority>1.0</priority>
</url>
';
    while($row = @mysql_fetch_array($result)) {
        echo '<url>
    <loc>'.$set['home'].'/products.php?id='.$row['id'].'</loc>
    <lastmod>'.$row['created'].'</lastmod>
    <changefreq>always</changefreq>
    <priority>0.2</priority>
</url>
';
    }
}
echo '</urlset>';

?>