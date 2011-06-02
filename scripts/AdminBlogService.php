<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdminBlogService
 *
 * @author mostafa
 */
class AdminBlogService extends Service {

    public function show() {
        $tmpl = Template::getInstance('adminDashboard.tpl');
        $pg = $tmpl->initPagination();
        $start = $pg->getCurrentIndex();
        $limit = $pg->getLimit();

        Factory::getUser()->authorise("admin", ResponseRegistery::getInstance()->site_id);

        $db = Factory::getDBO();
        if ($this->input->getString('search'))
        {
            $search = $db->getEscaped($this->input->getString('search'));
            $where = " WHERE blog.title LIKE '%{$search}%' or sub.sub_domain='{$search}' ";
        }


        $sql = 'SELECT
		    blog.title as title,
		    sub.sub_domain,
		    blog.site_id,
		    max(post.`date`)as lastpost,
		    site.active as active,
                    (case site.active
                        when 1 then
                            "ban"
                        else
                            "disban"
                        end ) as action
		  FROM wb_weblogs as blog
		  JOIN ge_sites as site
		    ON(blog.site_id=site.id)
		  JOIN ge_subdomains as sub
		    ON(sub.site_id=site.id)
		  left JOIN wb_articles as post
		    ON(post.weblog_id=blog.id)
		  ' . $where . '
		  group by blog.site_id
                  ';
        $lsql="LIMIT {$start},{$limit}";
        $pg->setTotal($db->query($sql)->count());

        $list = $db->query($sql.$lsql)->fetchAll();


        $tmpl->loadPage('listblog');
        $tmpl->assign('list', $list);
        $this->reponse->setTitle('لیست وبلاگ‌ها');
        $this->reponse->setTemplate($tmpl);
    }

    public function showBan() {
        Factory::getUser()->authorise("admin", ResponseRegistery::getInstance()->site_id);

        $db = Factory::getDBO();
        if ($search)
            $where = " AND  blog.title LIKE '%{$search}%' or sub.sub_domain='{$search}' ";

        $tmpl = Template::getInstance('adminDashboard.tpl');
        $pg = $tmpl->initPagination();
        $start = $pg->getCurrentIndex();
        $limit = $pg->getLimit();

        $sql = 'SELECT
		    blog.title as title,
		    sub.sub_domain,
		    blog.site_id,
		    max(post.`date`)as lastpost,
		    site.active as active
		  FROM wb_weblogs as blog
		  JOIN ge_sites as site
		    ON(blog.site_id=site.id)
		  JOIN ge_subdomains as sub
		    ON(sub.site_id=sub.site_id)
		  left JOIN wb_articles as post
		    ON(post.weblog_id=blog.id)
		  WHERE site.active=0
		  ' . $where . '
		  group by blog.site_id
		  LIMIT ' . "{$start},{$limit}";

        $list = $db->query($sql)->fetchAll();

        $tmpl->loadPage('listblog');
        $tmpl->assign('list', $list);
        $this->reponse->setTitle('لیست وبلاگ‌ها');
        $this->reponse->setTemplate($tmpl);
    }

    public function ban() {
        Factory::getUser()->authorise("admin", ResponseRegistery::getInstance()->site_id);

        $site_id = $this->input->getInt('id');
        $tmp->id = $site_id;
        $tmp->active = 0;
        Factory::getDBO()->StoreObject("ge_sites", $tmp);
        Messages::getInstance()->logSuccess('سایت مورد نظر با موفقیت مسدود شد');
        $this->reponse->redirect(ResponseRegistery::getInstance()->baseURL . "/admin/blog/show");
    }

    public function disban() {
        Factory::getUser()->authorise("admin", ResponseRegistery::getInstance()->site_id);

        $site_id = $this->input->getInt('id');
        $tmp->id = $site_id;
        $tmp->active = 1;
        Factory::getDBO()->StoreObject("ge_sites", $tmp);
        Messages::getInstance()->logSuccess('سایت مورد نظر با موفقیت فعال شد');
        $this->reponse->redirect(ResponseRegistery::getInstance()->baseURL . "/admin/blog/show");
    }

}

?>
