<?php if(!defined('__IN_LOADTEMPLATE')) die('illigal access');?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<META NAME="description" CONTENT="<?php echo $tmp->BlogAndPostTitle; ?> - <?php echo $tmp->BlogDescription; ?>">
<META NAME="keywords" CONTENT="<?php echo $tmp->BlogAndPostTitle; ?>,<?php echo $tmp->BlogId; ?>, Blog, Weblog, Persian,Iran, Iranian, Farsi, Weblogs, Blogs">
<link rel="alternate" type="application/rss+xml" title="<?php echo $tmp->BlogTitle; ?>" href="<?php echo $tmp->BlogXmlLink; ?>" />
<meta name="GENERATOR" content="AirHost-BlogSystem">
<title><?php echo $tmp->BlogAndPostTitle; ?></title>
<base HREF="<?php echo $tmp->BaseURL; ?>/blog/" />
<style>
BODY {font-family: Tahoma; font-size: 8pt;color: #000000; background-color: #f8fafb;	text-align: center;}
.Center{width:740px;text-align: center;}

.HeaderBox{direction: rtl;width:100%;height:100px;background-image: url('http://www.blogfa.com/Layouts/silver/bgr.jpg'); background-repeat: repeat-x; background-position-y: top}
.BlogTitle{color:black;font-family: Arial; font-size: 18pt; font-weight: bold;padding-top: 22px;padding-bottom: 20px}
.BlogTitle A:link {color:black;text-decoration: none;}
.BlogTitle A:visited {color:black;text-decoration: none;}
.BlogTitle A:hover {color:black;text-decoration: none;}

.BlogSubTitle{color:black ;font-family: Tahoma;font-size: 9pt;padding-bottom: 6px}
.Container{padding:0px; border:1px solid #d9dee1; color: #000000; background-color: #FFFFFF;text-align=right;direction: rtl;}

.Content{padding-left:3px;padding-right:3px;width: 569px;float: right;text-align: right;direction: rtl;}
.Sidebar{font-family: Tahoma;line-height: 150%;width: 159px;float: left;padding:0px;padding-left:3px;padding-right:1px;;text-align: right;direction: rtl;}

.PostTitle{font-size: 9pt;font-family: Tahoma;color:black;padding-top: 6px; padding-bottom: 2px;padding-top: 3px;padding-right: 3px;}
.PostTitle A:link {color:black;text-decoration: none;}
.PostTitle A:visited {color:black;text-decoration: none;}
.PostTitle A:hover {color:blue;text-decoration: none;}


.PostBody {padding-right: 5px ;font-size: 9pt;font-family: Tahoma;color:black;padding-top: 1px; padding-bottom: 2px;line-height:1.5em;}
.PostBody A:link{color:#258CF3;text-decoration: none;}
.PostBody A:visited {color:#258CF3;text-decoration: none;}
.PostBody A:hover{color:red;text-decoration: none;}
.postdesc {font-size: 7pt;font-family: Tahoma;color:gray;padding-bottom: 10px}
.postdesc A{font-size: 8pt;font-family: Tahoma;}


A:link {color:blue;text-decoration: none;}
A:visited {color:blue;text-decoration: none;}
A:hover {color:red;text-decoration: none;}


</style> 

<script  language="javascript">
  function GetBC(lngPostid)
   {
       intTimeZone=<?php echo $tmp->BlogTimeZone; ?>;
       strBlogId="<?php echo $tmp->BlogId; ?>";
       intCount=-1;
       strResult="";
       try {
	  for (i=0;i<BlogComments.length;i+=2)
	  {
	       if (BlogComments[i]==lngPostid)
	       intCount=BlogComments[i+1] ;
	  }
           }  catch( e) {
           }
    if ( intCount==-1)  strResult="آرشیو نظرات";
    if ( intCount==0)  strResult="نظر بدهید";
    if ( intCount==1)  strResult="یک نظر";
    if ( intCount>1)  strResult=intCount + " نظر" ;
  
  strUrl="<?php echo $tmp->BlogUrl; ?>/comment/" + lngPostid ;
  strResult ="<a href=\"javascript:void(0)\" onclick=\"javascript:window.open('" + strUrl + "','comments','status=yes,scrollbars=yes,toolbar=no,menubar=no,location=no ,width=500px,height=500px')\" >" +  strResult + " </a>" ;

  document.write ( strResult ) ;
 }
 function OpenLD()
{
  window.open('LinkDump.aspx','blog_ld','status=yes,scrollbars=yes,toolbar=no,menubar=no,location=no ,width=500px,height=500px');
  return true;
}

</script>


</head>

<body>
<div align =center>
<div class ="Center">
<div class="Container">
<div class="HeaderBox" align=center >
<div class="BlogTitle" dir="rtl"><a href="<?php echo $tmp->BlogUrl; ?>"><?php echo $tmp->BlogTitle; ?></a></div>
<div class="BlogSubTitle" dir="rtl"><?php echo $tmp->BlogDescription; ?></div>
</div>
<div style="padding:5px"></div> 

<div>
	<div class="Content">
	<?php foreach($tmp->BLOG as $iterator):?>
	  <a name="<?php echo $iterator->PostId; ?>"></a>
   <div style="width:100%;border: 1px solid #d9dee1;">
        <div style="border-bottom:1px solid #d9dee1;width:100%;height:24px;background-image: url('http://www.blogfa.com/layouts/silver/Nvbg.gif'); background-repeat: repeat-x; background-position-y: top">
        <div class="posttitle"><a href="<?php echo $iterator->PostLink; ?>"><?php echo $iterator->PostTitle; ?></a></div>
        </div>
		<div class="postbody" ><?php echo $iterator->PostContent; ?><BlogExtendedPost><br><a href="<?php echo $iterator->PostLink; ?>">ادامه مطلب</a></BlogExtendedPost></div>
			<div class="postdesc">
		<a  href="<?php echo $iterator->PostLink; ?>" >+</a>
		نوشته شده در  <?php echo $iterator->PostDate; ?>ساعت <?php echo $iterator->PostTime; ?>  توسط <?php echo $iterator->PostAuthor; ?>  
		<BlogComment>
		  | 
		  <span dir="rtl" >
	      <script type="text/javascript">GetBC(<?php echo $iterator->PostId; ?>);</script>
	      </span>
        </BlogComment>
     </div>

   </div>
    <div style="padding-top:5px"></div>  
	 <?php endforeach; ?>

<?php if($tmp->BlogNextAndPreviousBlock):?>
<div style="width:100%;padding-top:10px">
<?php if($tmp->BlogPreviousPageBlock):?>
<div style="width:49%;float:right"><a href="<?php echo $tmp->BlogPreviousPageLink; ?>">مطالب جدیدتر</a></div>
<?php endif;?>
<?php if($tmp->BlogNextPageBlock):?>
<div style="width:49%;float:left;text-align:left"><a href="<?php echo $tmp->BlogNextPageLink; ?>">مطالب قدیمی‌تر</a></div>
<?php endif;?>
</div>
<?php endif;?>

	</div>
	
	<div class="Sidebar">
	
  <?php if($tmp->BlogProfile):?>
    <div style="width:100%;border: 1px solid #d9dee1;">
        <div style="border-bottom:1px solid #d9dee1;width:100%;height:24px;background-image: url('http://www.blogfa.com/Layouts/silver/Nvbg.gif'); background-repeat: repeat-x; background-position-y: top">
        <div class="posttitle" align=center  >درباره</div>
        </div>
			<div style="padding-top:3px;padding-right:2px;padding-left:2px;; padding-bottom:7px;text-align: justify"  >
		    <?php if($tmp->BlogPhoto):?>
		    	<div style="padding-bottom:7px;text-align:center" >
		        <img src="<?php echo $tmp->BlogPhotoLink; ?>" >
		        </div>
		    <?php endif;?>
		   <?php echo $tmp->BlogAbout; ?>
     </div>
     </div>
     <div style="padding-top:5px"></div> 
<?php endif;?>

    <div style="width:100%;border: 1px solid #d9dee1;">
        <div style="border-bottom:1px solid #d9dee1;width:100%;height:24px;background-image: url('http://www.blogfa.com/Layouts/silver/Nvbg.gif'); background-repeat: repeat-x; background-position-y: top">
        <div class="posttitle"></div>
        </div>
			<div style="padding-top:3px;padding-right:3px"  >
		<a href="<?php echo $tmp->BlogUrl; ?>">صفحه نخست</a><br>
		<?php if($tmp->BlogProfileLinkBlock):?><a href="<?php echo $tmp->BlogProfileLink; ?>">پروفایل مدیر وبلاگ</a><br><?php endif;?>
		<a href="mailto:<?php echo $tmp->BlogEmail; ?>">پست الکترونیک</a><br>
		<a href="<?php echo $tmp->BlogArchiveLink; ?>">آرشیو وبلاگ</a><br>
		<a href="/posts/">عناوین مطالب وبلاگ</a><br>
     </div>
     </div>	
     <div style="padding-top:5px"></div> 

     <?php if($tmp->BlogLinkDumpBlock):?>
    <div style="width:100%;border: 1px solid #d9dee1;">
        <div style="border-bottom:1px solid #d9dee1;width:100%;height:24px;background-image: url('http://www.blogfa.com/Layouts/silver/Nvbg.gif'); background-repeat: repeat-x; background-position-y: top">
        <div class="posttitle" align=center >پیوندهای روزانه</div>
        </div>
		<div style="padding-top:3px;;padding-right:3px;direction:rtl"  >
	 <?php foreach($tmp->BlogLinkDump as $iterator):?>
			<a href="<?php echo $iterator->LinkUrl; ?>" target="_blank" title="<?php echo $iterator->LinkDescription; ?>" ><?php echo $iterator->LinkTitle; ?></a><br>
	  <?php endforeach; ?>
	 <a href="javascript:void(0)" onclick ="OpenLD();">آرشیو پیوندهای روزانه</a><br>

      </div>
     </div>	
     <div style="padding-top:5px"></div> 
     <?php endif;?>
     
     

    <div style="width:100%;border: 1px solid #d9dee1;">
        <div style="border-bottom:1px solid #d9dee1;width:100%;height:24px;background-image: url('http://www.blogfa.com/Layouts/silver/Nvbg.gif'); background-repeat: repeat-x; background-position-y: top">
        <div class="posttitle" align=center >نوشته های پیشین</div>
        </div>
		<div style="padding-top:3px;;padding-right:3px"  >

		<span dir="ltr">
		<?php foreach($tmp->BlogArchive as $iterator):?>
			<a href="<?php echo $iterator->ArchiveLink; ?>"><?php echo $iterator->ArchiveTitle; ?></a><br>
		 <?php endforeach; ?>
	
     </div>
     </div>	
     <div style="padding-top:5px"></div> 
     
     
 <?php if($tmp->BlogCategoriesBlock):?>
    <div style="width:100%;border: 1px solid #d9dee1;">
        <div style="border-bottom:1px solid #d9dee1;width:100%;height:24px;background-image: url('http://www.blogfa.com/Layouts/silver/Nvbg.gif'); background-repeat: repeat-x; background-position-y: top">
        <div class="posttitle" align=center >آرشیو موضوعی</div>
        </div>
		<div style="padding-top:3px;;padding-right:3px;direction:rtl"  >
	 <?php foreach($tmp->BlogCategories as $iterator):?>
			<a href="<?php echo $iterator->CategoryLink; ?>"   ><?php echo $iterator->CategoryName; ?></a><br>
	 <?php endforeach; ?>
      </div>
     </div>	
     <div style="padding-top:5px"></div> 
<?php endif;?>
     


 <?php if($tmp->BlogAuthorsBlock):?>
    <div style="width:100%;border: 1px solid #d9dee1;">
        <div style="border-bottom:1px solid #d9dee1;width:100%;height:24px;background-image: url('http://www.blogfa.com/Layouts/silver/Nvbg.gif'); background-repeat: repeat-x; background-position-y: top">
        <div class="posttitle" align=center >نویسندگان</div>
        </div>
		<div style="padding-top:3px;;padding-right:3px;direction:rtl"  >
	  <?php foreach($tmp->BlogAuthors as $iterator):?>
			<a href="<?php echo $iterator->AuthorLink; ?>"   ><?php echo $iterator->AuthorName; ?></a><br>
	   <?php endforeach; ?>
      </div>
     </div>	
     <div style="padding-top:5px"></div> 
<?php endif;?>
          
     
    <?php if($tmp->BlogLinksBlock):?> 
    <div style="width:100%;border: 1px solid #d9dee1;">
        <div style="border-bottom:1px solid #d9dee1;width:100%;height:24px;background-image: url('http://www.blogfa.com/Layouts/silver/Nvbg.gif'); background-repeat: repeat-x; background-position-y: top">
        <div class="posttitle" align=center >پیوندها</div>
        </div>
		<div style="padding-top:3px;;padding-right:3px;direction:rtl"  >
		<?php foreach($tmp->BlogLinks as $iterator):?>
			<a href="<?php echo $iterator->LinkUrl; ?>" target="_blank" ><?php echo $iterator->LinkTitle; ?></a><br>
		 <?php endforeach; ?>
      </div>
     </div>	
     <div style="padding-top:5px"></div> 
     <?php endif;?>
     

    	<p style="text-align:center"> <a style="color: #FFFFFF; text-decoration: none; font-family: Arial; font-size: 8pt; border: 1px solid #FF9955;  background-color: #FF6600" href="<?php echo $tmp->BlogXmlLink; ?>"> RSS </a>
		</p>
        <div align=center >
		
<div align="center"><br><?php echo $tmp->BlogCustomHtml; ?></div>

		    
	</div>
   </div>	
    <div style="clear: both;"> </div>
</div>

</div>
</div>
</body>

</html>