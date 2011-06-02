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

.Content{padding-left:3px;padding-right:3px;width: 569px;float: right;text-align: right;direction: rtl;text-align: center;}
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

.Item-Container
{
    
}

.main-item
{
    width: 100%;
}

.main-item h1
{
    background: #D9DEE1; /* old browsers */
    background: -moz-linear-gradient(top, #D9DEE1 0%, #feffff 53%); /* firefox */
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#D9DEE1), color-stop(53%,#feffff)); /* webkit */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#D9DEE1', endColorstr='#feffff',GradientType=0 ); /* ie */

    padding:10px 15px 10px 0;
    font-size: 8pt;
    margin: 0;
}

.item-show-box
{
    margin: 0px;
    width: 564px;
    min-height: 400px;
    text-align: center;
    background: #d9dee1;
    border: 1px #d9dee1 solid;
}

.item-show-box .title
{
    background: #f6f8f9; /* old browsers */
background: -moz-linear-gradient(top, #f6f8f9 0%, #e5ebee 50%, #d7dee3 51%, #f5f7f9 100%); /* firefox */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#f6f8f9), color-stop(50%,#e5ebee), color-stop(51%,#d7dee3), color-stop(100%,#f5f7f9)); /* webkit */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f6f8f9', endColorstr='#f5f7f9',GradientType=0 ); /* ie */

    height: 25px;
    padding: 10px 0 0 0;
    width: 100%;
    overflow: hidden;
}
.item-show-box .title a
{
        color: #006699;
}
.item-show-box .main-box
{
    padding: 5px;
}

.item-show-box .main-box .right,
    .item-show-box .main-box .left
{
    float: right;
    min-height: 318px;
}

.item-show-box .main-box .left
{
    width: 154px;
}

.item-show-box .main-box .left .price
{
    padding: 10px 0;
}

.item-show-box .main-box .right
{
    width: 400px;
}
.item-show-box .main-box .pic img
{
    height: 200px;
    width: 140px;
    border:none;
}

.item-show-box .main-box .right .desc
{
    height: 225px;
    padding: 5px 2px;
    overflow: hidden;
    text-align: right;
}
.item-show-box .footer
{
    clear:both;
    text-align: center;
}

.item-show-box .main-box .left .add-card
{
    background: transparent url('../ui/images/add-card.png') top center no-repeat;
    padding: 10px 0 0 0;
    margin:10px 0 0 0;
    height: 32px;
    display: inline-block;
}
.item-show-box .main-box .left .add-card span
{
        color: #006699;
        padding: 23px 0 0 0;
        display: block;
}


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

<div style="height:100%">
	<div class="Content">
	    <?php echo $tmp->Item_full?>
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