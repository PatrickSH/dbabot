<?php 
$con = mysqli_connect("","","","");

$url = file_get_contents('https://www.dba.dk/boliger/andelsbolig/andelslejligheder/vaerelser-3/?vaerelser=4&vaerelser=6&boligarealkvm=(75-)&maanedligydelse=(5001-7000)&maanedligydelse=(3001-5000)&maanedligydelse=(1000-3000)&fra=privat&sort=listingdate-desc&pris=(0-2300000)&soegfra=1366&radius=4&long=12-5503&lat=55-6659');

$regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>";

if(preg_match_all('/<a class="listingLink" href="(.+)">/', $url, $matches)) {
   $urls = [];
   foreach($matches[1] as $match)
   {
       if(!in_array($match,$urls))
       {
           $urls[] = $match;
       }
   }
  }

foreach($urls as $url)
{
    $count = $con->query("SELECT * FROM known_links WHERE link='{$url}'")->num_rows;
    if($count == 0)
    {
        $sql = "INSERT INTO known_links (link) VALUES ('{$url}')";
        $con->query($sql);
        mail("patrickh@pandiweb.dk","Text here");
    }
}