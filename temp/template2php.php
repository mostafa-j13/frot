<?php
$str=file_get_contents('blog.txt');

$ptr=array("#<-(BlogId|BlogUrl|BlogXmlLink|BlogAuthor|BlogEmail|BlogDescription|BlogTitle|BlogArchiveLink|BlogTimeZone|BlogCustomHtml|BlogAndPostTitle|BlogPreviousPageLink|BlogNextPageLink|BlogAbout|BlogProfileLink|BlogPhotoLink)->#");
$rep=array('<?php echo $tmp->\\1; ?>');
$str=preg_replace($ptr,$rep,$str);

$ptr=array('#<(BlogProfileLinkBlock|BlogProfile|BlogPhoto|BlogComment|BlogExtendedPost|BlogLinksBlock|BlogLinkDumpBlock|BlogCategoriesBlock|BlogAuthorsBlock|BlogPreviousItemsBlock|BlogNextAndPreviousBlock|BlogPreviousPageBlock|BlogNextPageBlock)>(.*?)</\\1>#ims');
$rep=array('<?php if($tmp->\\1):?>\\2<?php endif;?>');

$cnt=0;
do
{
$str=preg_replace($ptr,$rep,$str,-1,$cnt);
}
while($cnt!=0);

$ptr=array('#<-(PostTitle|PostContent|PostDate|PostTime|PostId|PostLink|PostCategoryId|PostCategory|PostAuthorId|PostAuthor|PostAuthorEmail|PostAuthorLink|ArchiveTitle|ArchiveLink|LinkTitle|LinkUrl|LinkDescription|CategoryName|CategoryLink|AuthorName|AuthorLink|)->#');
$rep=array('<?php echo $iterator->\\1; ?>');
$str=preg_replace($ptr,$rep,$str);

$ptr=array('#<(BLOGFA|BlogArchive|BlogLinks|BlogLinkDump|BlogCategories|BlogAuthors|BlogPreviousItems)>(.*?)</\\1>#ims');
$rep=array('<?php foreach($tmp->\\1 as $iterator):?>\\2 <?php endforeach; ?>');
$str=preg_replace($ptr,$rep,$str);



echo $str; 
