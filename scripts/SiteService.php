<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author mostafa
 */
class SiteService extends Service
{

    private $newsBlogName = "اخبار";
    private $newsSub = "news";

    function FirstPage()
    {
        $query = "SELECT arts.id,arts.title FROM wb_articles AS arts
                       JOIN wb_weblogs AS blogs ON(arts.weblog_id= blogs.id)
		       JOIN ge_subdomains as sub
			    ON(sub.site_id=blogs.site_id)
                       WHERE sub.sub_domain='{$this->newsSub}'
                       LIMIT 0,10";
                       
        $newsPosts = $this->db->query( $query )->fetchAll();
        
        $tmpl = new Template( 'frontPage.tpl' );

	$query="SELECT
		        blogs.title,
			sub.sub_domain
		    FROM wb_articles AS arts
                    JOIN wb_weblogs AS blogs
			ON(arts.weblog_id= blogs.id)
		    JOIN ge_subdomains as sub
			ON(sub.site_id=blogs.site_id)
		    GROUP BY
			blogs.id
		    ORDER BY
			arts.`date` DESC
		    LIMIT 0,10";
	$newArt=$this->db->query($query)->fetchAll();
        $tmpl->assign('news', $newsPosts);
	$tmpl->assign('updates', $newArt);
        $tmpl->assign('subdomain', $this->newsSub);
        
        $tmpl->loadPage( 'firstPage' );
        $this->reponse->setTemplate( $tmpl );
    }

}

?>
