<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TemplateData
 *
 * @author MIX
 */
class TemplateData
{

    private $data;
    /**
     *
     * @var DataBaseAdapter
     */
    private $db;
    private $task;

    public function __construct( $task )
    {

        $this->db = Factory::getDBO();
        $this->task = $task;
    }

    public function __get( $name )
    {
        $name = strtolower( $name );

        if( !isset( $this->data[ $name ] ) )
        {
            $old = QueryResult::$returnClass;
            QueryResult::$returnClass = 'istdClass';
            switch( $name )
            {
                case 'blogtimezone':
                    $this->data[ $name ] = 12600;
                    break;
                case 'blogprofile':
                    $this->data[ $name ] = false;
                    break;
                case'baseurl':
                    $this->data[ $name ] = ResponseRegistery::getInstance()->baseURL;
                    break;
                case 'blogid':
                case 'blogurl':
		case 'shopurl':
                case 'blogxmllink':
                case 'blogauthor':
                case 'blogemail':
                case 'blogdescription':
                case 'blogtitle':
                case 'blogarchivelink':
                case 'blogcustomhtml':
                case 'blogandposttitle':
                case 'blogphoto':
                case 'blogphotolink':
                case 'blogabout':
                    $this->loadBlogInfo();
                    break;
                case 'blog':
                    $this->loadPost();
                    break;
                case 'blogarchive':
                    $this->loadArchive();
                    break;
                case 'bloglinks':
                case 'bloglinksblock':
                    $this->loadLink();
                    break;
                case 'bloglinkdumpblock':
                case 'bloglinkdump':
                    $this->loadLinkDump();
                    break;
                case 'blogcategoriesblock':
                case 'blogcategories':
                    $this->loadCategory();
                    break;
                case 'blogauthorsblock':
                case 'blogauthors':
                    $this->loadAuthor();
                    break;
                case 'blogpreviousitemsblock':
                case 'blogpreviousitems':
                    $this->loadPreviousItem();
                    break;
                case 'blognextandpreviousblock':
                case 'blogpreviouspageblock':
                case 'blognextpageblock':

                    $this->loadNextAndPrevious();
                    break;
                case 'blogprofilelinkblock':
                    $this->data[ $name ] = false;
                    break;
                case 'item':
                    $this->loadItem();
                    break;
                case 'frotelitem':
                    $this->loadFrotelItem();
                    break;
                case 'item_full':
                    $this->showItem();
                    break;
                case 'shopcard':
                    $this->shopCard();
                    break;
                default:
                    throw new Exception( "code not found {$name}" );
            }
            QueryResult::$returnClass = $old;
        }

        return $this->data[ $name ];
    }

    private function showItem()
    {
        $sql = 'SELECT
			item.*,
			sub.title as subgroup,
			groups.title as `group`,
                        img.url as imgURL
		    FROM sh_items as item
		    JOIN sh_subgroups_items as si
			ON(si.item_id=item.id)
		    JOIN sh_subgroups as sub
			On(sub.id=si.subgroup_id)
		    JOIN sh_groups as groups
			ON(groups.id=sub.group_id)
                    JOIN sh_images as img
                        ON(img.item_id=item.id)
		    WHERE
			groups.site_id=' . $this->getSiteId() . ' group by item.id';

        $row = $this->db->query( $sql )->fetch();

        $this->data[ 'item' ] = array( );
        $tmp = new stdClass();
        $tmp->item_id = $row->id;
        $baseURL = ResponseRegistery::getInstance()->baseURL;
        $tmp->item = <<<MJ
<div class="item-show-box">
    <div class="title">$row->title</div>
    <div class="main-box">
        <div class="right">
            <div class="desc">
                $row->full_description
            </div>
        </div>
        <div class="left">
            <div class="pic">
                <img src="{$baseURL}/{$row->imgURL}">
            </div>
            <div class="price">
قیمت:                $row->price ریال
            </div>
            <a class="add-card" href="{$baseURL}/shop/card/add/{$row->id}" ><span>افزودن به سبد خرید</span></a>
        </div>
        
    </div>
    <div class="footer">
        
    </div>
</div>
MJ;
        $this->data[ 'item_full' ] = $tmp->item;
    }

    private function shopCard()
    {

        $card = Session::getInstance()->card;
        fb( $card );
        $baseURL = ResponseRegistery::getInstance()->baseURL;
        $site_id = intval( ResponseRegistery::getInstance()->site_id );
        if( !$card[ $site_id ] )
            $card[ $site_id ]->items = array( );

        fb( $site_id, 'site_id' );
        $str = '<div id="cards"><div class="card"><ul ><li><span>سبد خرید فروشگاه</span></li>';
        foreach( $card[ $site_id ]->items as $item )
        {
            fb( $item );
            $str.=
                    <<<MJ
	<li><span class="title">$item->title</span> <a class="remove" href="{$baseURL}/shop/card/remove/{$item->id}"></a></li>
MJ;
        }
        
        //if card is empty
        if( count( $card[ $site_id ]->items ) == 0 )
                $str .= '<li><span class="no-item">سبد خرید شما خالی می باشد</span></li>';
        $str.='</ul><div style="clear:both"></div>';
        if( count( $card[ $site_id ]->items ) > 0 )
            $str.='<a class="checkout" href="' . $baseURL . '/shop/card/checkout/0">تکمیل خرید</a>';
        
        $str.='</div><div class="card"><ul ><li><span>سبد خرید فروشگاه مشارکتی</span></li>';

        $card = Session::getInstance()->frotelCard;
        if( !$card[ $site_id ] )
        {
            $card[ $site_id ]->items = array( );
        }

        foreach( $card[ $site_id ]->items as $item )
        {
            fb( $item );
            $str.=
                    <<<MJ
	<li><span class="title">$item->title</span><a class="remove" href="{$baseURL}/shop/card/Frotelremove/{$item->id}"></a></li>
MJ;
        }
        
        //if card is empty
        if( count( $card[ $site_id ]->items ) == 0 )
                $str .= '<li><span class="no-item">سبد خرید شما خالی می باشد</span></li>';
        $str.="</ul>";
        if( count( $card[ $site_id ]->items ) > 0 )
            $str.='<a href="' . $baseURL . '/shop/card/FrotelCheckout/0">تکمیل خرید</a></div></div>';
        fb( $str );
        $this->data[ 'shopcard' ] = $str;
    }

    private function loadBlogInfo()
    {
        $sql = "SELECT
                        weblog.id as blogid,
                        weblog.desc as blogdescription,
                        weblog.title as blogtitle,
                        weblog.custom_html as blogcustomhtml,
                        weblog.logo as blogphotolink,
                        weblog.about as blogabout,
                        subdomain.sub_domain as subdomain,
                        user.name as blogauthor,
                        user.email as blogemail
                   FROM ge_sites as site
                   JOIN wb_weblogs as weblog
                        ON(weblog.site_id=site.id)
                   JOIN ge_subdomains as subdomain
                        ON(site.id=subdomain.site_id)
				   JOIN ge_users_sites as user_site
						ON(site.id=user_site.site_id)
				   JOIN ge_users as user
						ON(user.id	= user_site.user_id)
				   WHERE 
						user_site.type='admin' AND
						weblog.id=" . ResponseRegistery::getInstance()->weblog_id;

        $tmp = $this->db->query( $sql )->fetch();
        $this->data[ 'blogid' ] = $tmp->blogid;
        $this->data[ 'blogdescription' ] = $tmp->blogdescription;
        $this->data[ 'blogtitle' ] = $tmp->blogtitle;
        $this->data[ 'blogandposttitle' ] = $tmp->blogtitle;
        $this->data[ 'blogcustomhtml' ] = $tmp->blogcustomhtml;
        $this->data[ 'blogurl' ] = $tmp->subdomain . ResponseRegistery::getInstance()->domin . '/blog';
	$this->data[ 'shopurl' ] = $tmp->subdomain . ResponseRegistery::getInstance()->domin . '/shop';
        $this->data[ 'blogxmllink' ] = $this->data[ 'blogurl' ] . '/xml';
        $this->data[ 'blogarchivelink' ] = $this->data[ 'blogurl' ] . '/archive';
        $this->data[ 'blogauthor' ] = $tmp->blogauthor;
        $this->data[ 'blogemail' ] = $tmp->blogemail;
        $this->data[ 'blogabout' ] = $tmp->blogabout;
        $this->data[ 'blogaphotolink' ] = $tmp->blogphotolink;
        $this->data[ 'blogaphoto' ] = !empty( $tmp->blogphoto );
    }

    private function loadItem()
    {
        $sql = 'SELECT
			item.*,
			sub.title as subgroup,
			groups.title as `group`,
                        img.url as imgURL
		    FROM sh_items as item
		    JOIN sh_subgroups_items as si
			ON(si.item_id=item.id)
		    JOIN sh_subgroups as sub
			On(sub.id=si.subgroup_id)
		    JOIN sh_groups as groups
			ON(groups.id=sub.group_id)
                    JOIN sh_images as img
                        ON(img.item_id=item.id)
		    WHERE
			groups.site_id=' . $this->getSiteId() . ' group by item.id';

        $list = $this->db->query( $sql )->fetchAll();

        fb( $list, 'list' );
        $this->data[ 'item' ] = array( );
        foreach( $list as $row )
        {
            $tmp = new stdClass();
            $tmp->item_id = $row->id;
            $baseURL = ResponseRegistery::getInstance()->baseURL;
            $tmp->item = <<<MJ
<div class="item-show-box">
    <div class="title"><a href="{$baseURL}/shop/item/{$row->id}">$row->title</a></div>
    <div class="main-box">
        <div class="pic">
        <a href="{$baseURL}/shop/item/{$row->id}"><img src="{$baseURL}/{$row->imgURL}"></a>
        </div>
        <div class="desc">
            $row->description
        </div>
    </div>
    <div class="footer">
        <div class="price">
            قیمت: $row->price تومان
        </div>
        <a class="add-card" href="{$baseURL}/shop/card/add/{$row->id}" ><span>افزودن به سبد خرید</span></a>
    </div>
</div>
MJ;
            $this->data[ 'item' ][ ] = $tmp;
        }
        fb( $this->data[ 'item' ] );
    }

    private function loadFrotelItem()
    {
        $sql = 'SELECT
			item.*,
			sub.title as subgroup,
			groups.title as `group`,
                        img.url as imgURL
		    FROM fr_items as item
		    JOIN fr_subgroups_items as si
			ON(si.item_id=item.id)
		    JOIN fr_subgroups as sub
			On(sub.id=si.subgroup_id)
		    JOIN fr_groups as groups
			ON(groups.id=sub.group_id)
                    JOIN fr_images as img
                        ON(img.item_id=item.id)
		    #WHERE
		#	groups.site_id=' . $this->getSiteId() . '
		    group by item.id';

        $list = $this->db->query( $sql )->fetchAll();

        fb( $list );
        $this->data[ 'item' ] = array( );
        foreach( $list as $row )
        {
            $tmp = new stdClass();
            $tmp->item_id = $row->id;
            $baseURL = ResponseRegistery::getInstance()->baseURL;
            $tmp->item = <<<MJ
<div class="item-show-box">
    <div class="title"><a href="{$baseURL}/shop/item/{$row->id}">$row->title</a></div>
    <div class="main-box">
        <div class="pic">
        <a href="{$baseURL}/shop/item/{$row->id}"><img src="{$baseURL}/{$row->imgURL}"></a>
        </div>
        <div class="desc">
            $row->description
        </div>
    </div>
    <div class="footer">
        <div class="price">
            قیمت: $row->price تومان
        </div>
        <a class="add-card" href="{$baseURL}/shop/card/froteladd/{$row->id}" ><span>افزودن به سبد خرید</span></a>
    </div>
</div>
MJ;
            $this->data[ 'frotelitem' ][ ] = $tmp;
        }
        fb( $this->data[ 'frotelitem' ] );
    }

    private function getSiteId()
    {
        return ResponseRegistery::getInstance()->site_id;
    }

    private function loadPost()
    {
        $respond = ResponseRegistery::getInstance();


        $where = $limit = '';
        switch( $this->task )
        {
            case 'post':
                $where = "AND article.id=" . intval( $respond->article_id );
                break;
            case 'page':
                $where = '';
                $limit = "limit {$respond->limitStart},{$respond->limit}";
                break;
            case 'archive':
                $where = "AND date BETWEEN '{$respond->archiveStart}' AND '{$respond->archiveEnd}'";
                break;
            case 'tag':
                $where = "AND tag.title=" . $this->db->valueQuote( $this->db->getEscaped( $respond->tag ) );
                break;
            case 'author':
                $where = "AND user.username=" . $this->db->valueQuote( $this->db->getEscaped( $respond->userName ) );
                break;
        }

        $sql = "SELECT
                                    article.title as posttitle,
                                    article.id as postid,
                                    article.content as postcontent,
                                    article.date as date,
                                    tag.id as postcategoryid,
                                    tag.title as postcategory,
                                    user.id as postauthorid,
                                    user.name as postauthor,
                                    user.email as postauthoremail,
                                    user.username,
                                    article.password,
                                    article.more_content,
                                    article.more_content <> null as blogextendedpost,
                                    article.comment_exp <=> NULL or article.comment_exp > NOW() as blogcomment,
                                    article.alias

                            from wb_articles as article
                            JOIN wb_subjects as subject
                                    ON (article.subject_id=subject.id)
                            JOIN wb_tags as tag
                                    ON(tag.id = article.tag_id)
                            JOIN ge_users as user
                                    ON (user.id = article.user_id)
                            
                            WHERE article.status = 'published'
                                    AND article.weblog_id ={$respond->weblog_id} {$where}
                            ORDER BY
                                    date DESC
                            {$limit}
                            ";
        $tmp = $this->db->query( $sql )->fetchAll();
        $this->data[ "blog" ] = array( );
        foreach( $tmp as $record )
        {
            if( !empty( $record->password ) && $record->password != $respond->postPassword )
            {
                $record->postcontent = Module::load( "postPassword" );
            }
            $record->postlink = "/post/{$record->postid}/{$record->alias}.html";
            $record->postauthorlink = "/author/{$record->username}";
            $date = Factory::getDate( $record->date );
            $record->postdate = $date->format( 'l j F Y', true );
            $record->posttime = $date->format( 'H:i', true );
            $this->data[ "blog" ][ ] = $record;
        }
    }

    private function loadArchive()
    {

        $mname = array( "", "فروردین", "اردیبهشت", "خرداد", "تیر", "مرداد", "شهریور", "مهر", "آبان", "آذر", "دی", "بهمن", "اسفند" );
        $sql = 'SELECT
					date
				FROM wb_articles
				WHERE
					weblog_id=' . ResponseRegistery::getInstance()->weblog_id . '
				ORDER BY
					date ASC
				LIMIT 1';
        $date = Factory::getDate( $this->db->query( $sql )->fetch()->date );
        $mm = intval( $date->format( "m" ) );
        $yy = intval( $date->format( "y" ) );

	
        $now = Factory::getDate();
        $em = intval( $now->format( "m" ) );
        $ey = intval( $now->format( "y" ) );

	//fb(array($em,$ey));
        for(;; )
        {
            $ob = new istdClass();
            $ob->archivetitle = $mname[ $mm ];
            $ob->archivelink = "archive/{$yy}/{$mm}";
            $this->data[ 'blogarchive' ][ ] = $ob;

	    if( $mm == $em && $yy = $ey )
            {
                break;
            }

            if( ++$mm == 13 )
            {
                $mm = 1;
                $yy++;
            }
            
        }
    }

    private function loadLink()
    {
        $sql = "SELECT
					title as linktitle,
					url as linkurl
				 FROM wb_links as link
				 WHERE
					 type='static' AND
					 active=1 AND
					 weblog_id=" . ResponseRegistery::getInstance()->weblog_id;
        $this->data[ 'bloglinks' ] = $this->db->query( $sql )->fetchAll();
        $this->data[ 'bloglinksblock' ] = count( $this->data[ 'bloglinks' ] ) != 0;
    }

    private function loadLinkDump()
    {
        $sql = "SELECT
					title as linktitle,
					url as linkurl
				 FROM wb_links as link
				 WHERE
					type='daily' AND
					active=1 AND
					weblog_id=" . ResponseRegistery::getInstance()->weblog_id;
        $this->data[ 'bloglinkdump' ] = $this->db->query( $sql )->fetchAll();
        $this->data[ 'bloglinkdumpblock' ] = count( $this->data[ 'bloglinkdump' ] ) != 0;
    }

    private function loadCategory()
    {
        $sql = "SELECT
					title as categorytitle,
					concat('tag/',title) as categorylink
				 FROM wb_tags as tag
				 WHERE
					weblog_id=" . ResponseRegistery::getInstance()->weblog_id;
        $this->data[ 'blogcategories' ] = $this->db->query( $sql )->fetchAll();
        $this->data[ 'blogcategoriesblock' ] = count( $this->data[ 'blogcategories' ] ) != 0;
    }

    private function loadAuthor()
    {
        $sql = "SELECT
					user.name as authorname,
					concat('author/',user.username) as authorlink
				 FROM ge_users as user
				 JOIN ge_users_sites as user_site
					ON(user_site.user_id=user.id)
				 WHERE
					site_id=" . ResponseRegistery::getInstance()->site_id;
        $this->data[ 'blogauthors' ] = $this->db->query( $sql )->fetchAll();
        $this->data[ 'blogauthorsblock' ] = count( $this->data[ 'blogauthors' ] ) != 0;
    }

    private function loadPreviousItem()
    {
        $sql = "SELECT
					article.title as posttitle,
					article.id as postid,
					concat('post/',article.id,'/',article.alias,'.html') as postlink
				 FROM wb_article as article
				 WHERE
					status='published' and 
					weblog_id=" . ResponseRegistery::getInstance()->weblog_id;
        $this->data[ 'blogpreviousitems' ] = $this->db->query( $sql )->fetchAll();
        $this->data[ 'blogpreviousitemsblock' ] = count( $this->data[ 'blogpreviousitems' ] ) != 0;
    }

    private function loadNextAndPrevious()
    {
        
    }

}

?>
