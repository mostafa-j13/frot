<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DashboardPostService
 *
 * @author mostafa
 */
class DashboardPostService extends Service
{

    //put your code here
    private $tmpl;
    private $pagenumber = 1;

    public function __construct()
    {
        parent::__construct();
        $this->tmpl = Template::getInstance('userDashboard.tpl');
    }

    private function GetTags()
    {
        $weblog_id = Session::getInstance()->weblog_id;
        //get user's tags from db
        $tags = $this->db->SimpleSelect("wb_tags", "id,title", "weblog_id={$weblog_id}")->fetchAll();

        $tags_list = Array();

        foreach ($tags as $tag)
        {
            $tags_list[$tag->id] = $tag->title;
        }

        return $tags_list;
    }

    private function GetSubjects()
    {
        //get subjects from db
        $subjects = $this->db->SimpleSelect("wb_subjects", "id,title")->fetchAll();

        $subjects_list = Array();
        foreach ($subjects as $subject)
        {
            $subjects_list[$subject->id] = $subject->title;
        }

        return $subjects_list;
    }

    public function NewPost()
    {


        Factory::getUser()->authorise("post", ResponseRegistery::getInstance()->site_id);
        $weblog_id = Session::getInstance()->weblog_id;

        // edit old post
        $old_post = $this->db->SimpleSelect("wb_articles", "*", array('id' => $this->input->getInt('id'), 'weblog_id' => $weblog_id))->fetch();
        if (!$old_post)
        {
            $old_post = new istdClass();
        }
        $this->tmpl->assign('post', $old_post);


        $comment_opt = array(
            '1' => 'نظرخواهی برای این پست فعال باشد',
            '2' => 'نظرخواهی غیر فعال باشد',
            '3' => 'امکان درج نظر جدید وجود نداشته باشد',
            '4' => 'درج نظر تنها یک هفته پس از ارسال مطلب مجاز باشد',
            '5' => 'درج نظر تنها پانزده روز پس از ارسال مطلب مجاز باشد',
            '6' => 'درج نظر تنها یک ماه   پس از ارسال مطلب مجاز باشد'
        );
        $this->tmpl->assign('comment_options', $comment_opt);

        //create date
        $day_opt = Array();
        for ($d = 1; $d < 32; ++$d)
            $day_opt[$d] = $d;

        $month_opt = Array();
        for ($m = 1; $m < 13; ++$m)
            $month_opt[$m] = $m;

        $year_opt = Array();
        for ($y = 1389; $y < 1400; ++$y)
            $year_opt[$y] = $y;

        $post_date = Factory::getDate($old_post->date ? $old_post->date : 'now');

        $day = $post_date->format("d");
        $month = $post_date->format("m");
        $year = $post_date->format("Y");
        $minute = $post_date->format("i");
        $hour = $post_date->format("h");

        $this->tmpl->loadPage('newPost');

        $this->tmpl->assign("subjects_title", $this->GetSubjects());
        fb($tt = $this->GetTags(), 'tag');
        $this->tmpl->assign("tags_title", $tt);

        $this->tmpl->assign("day_opt", $day_opt);
        $this->tmpl->assign("day", $day);

        $this->tmpl->assign("month_opt", $month_opt);
        $this->tmpl->assign("month", $month);

        $this->tmpl->assign("year_opt", $year_opt);
        $this->tmpl->assign("year", $year);

        $this->tmpl->assign("hour", $hour);
        $this->tmpl->assign("minute", $minute);

        $this->tmpl->assign("blogname", $blogname);

        //FIXME restore comment status when save
        $this->reponse->setTitle('پست مطلب جدید');

        $this->reponse->setTemplate($this->tmpl);
    }

    function save()
    {
        Factory::getUser()->authorise("post", ResponseRegistery::getInstance()->site_id);

        $user_id = Factory::getUser()->id;
        $weblog_id = Session::getInstance()->weblog_id;
        $site_id = Session::getInstance()->site_id;

        if ($this->input->getInt("year") != '' &&
                $this->input->getInt("month") != '' &&
                $this->input->getInt("day") != '' &&
                $this->input->getInt("hour") != '' &&
                $this->input->getInt("minute") != '')
        {
            $date = Factory::getDate(
                            $this->input->getInt("year") . "-" . $this->input->getInt("month") .
                            "-" . $this->input->getInt("day") . " " . $this->input->getInt("hour") .
                            ":" . $this->input->getInt("minute") . ":00", Date::tyJalali)->toMySQL("y-m-d H:i:s");
        }
        else
        {
            $date = Factory::getDate()->toMySQL("y-m-d H:i:s");
        }

        //
        //FIXME password option NOT complete
        //FIXME alias generator NOT complete

        if ($this->input->getInt('id'))
        {
            $insert_obj->id = $this->input->getInt('id');
            ////FIXME here check this post is belong to current user
        }

        $insert_obj->weblog_id = $weblog_id;
        $insert_obj->subject_id = $this->input->getString("subject");
        $insert_obj->tag_id = $this->input->getInt("tag", 1);
        $insert_obj->user_id = $user_id;
        $insert_obj->title = $this->input->getString("title");
        $insert_obj->alias = $this->input->getString("title");
        $insert_obj->content = $this->input->getString("post_content");
        //FIXME more content not impliment
        $insert_obj->more_content = '';
        $insert_obj->date = $date;
        $insert_obj->status = $this->input->getInt("private") ? "draft" : "published";
        $insert_obj->password = $this->input->getString("password");
        $insert_obj->comment_approve = $this->input->getInt("comment_app") ? 1 : 0;
        $insert_obj->comment_status = $this->input->getInt("cboComment_options");
        switch ($this->input->getInt("cboComment_options"))
        {
            //comment inactive
            case "2":
                $insert_obj->comment_exp = Factory::getDate();
                break;
            //
            case "3":
                $insert_obj->comment_exp = Factory::getDate();
                break;
            case "4":
                $insert_obj->comment_exp = Factory::getDate()->change("+1 week")->toMySQL();
                break;
            case "5":
                $insert_obj->comment_exp = Factory::getDate()->change("+15 days")->toMySQL();
                break;
            case "6":
                $insert_obj->comment_exp = Factory::getDate()->change("+1 month")->toMySQL();
                break;
        }
        fb($insert_obj);
        $this->db->StoreObject("wb_articles", $insert_obj);

        /*
          $sql_query = "INSERT INTO wb_articles(weblog_id,subject_id,tag_id,user_id
          title,content,more_content,date,status,
          password,comment_approve,comment_exp,alias)
          VALUES(
          {$weblog_id},
          {$_POST["subject"]},
          {$_POST["tag"]},
          {$user_id},
          {$_POST["title"]},
          {$_POST["content"]},
          '',
          '{$date}',
          {$this->input->getInt('private')},
          {$_POST["password"]},
          {$_POST["cboComment_options"]},
          ''
          )";

         */
        //fb($sql_query);
        Messages::getInstance()->getInstance()->logSuccess('پست ذخیره شد ');
        $this->reponse->redirect(ResponseRegistery::getInstance()->baseURL . "/dashboard/post/oldPost");
    }

    public function oldpost()
    {
        Factory::getUser()->authorise("post", ResponseRegistery::getInstance()->site_id);
        $weblog_id = Session::getInstance()->weblog_id;

        $recordStartNumber = ($this->pagenumber - 1) * 20; //FIXME check here I remove  a "+1" that I don't khnow  why we write it
        //pagination vars
        $pg = $this->tmpl->initPagination();
        $start = $pg->getCurrentIndex();
        $limit = $pg->getLimit();

        if ($this->input->getString('search'))
        {
            $search = $this->db->getEscaped($this->input->getString('search'));
            $where = " and title LIKE '%{$search}%' ";
        }

        $query = "SELECT id, title, date, (SELECT COUNT(*)
    		FROM wb_comment WHERE wb_comment.article_id = 
    		wb_articles.id) AS NumberComment FROM wb_articles 
    		WHERE weblog_id ={$weblog_id} " . $where .
                "ORDER BY date DESC";
                
        $lsql = " LIMIT {$start}, {$limit}";
        $pg->setTotal($this->db->query($query)->count());
        $articles = $this->db->query($query.$lsql)->fetchAll();
        foreach ($articles as $article)
        {
            $article->date = Factory::getDate($article->date)->format("Y-m-d");
        }

        $archive_opt = Array();

        $this->tmpl->loadPage("oldpost");
        $this->tmpl->assign("articles", $articles);
        $this->tmpl->assign("archive_opt", $archive_opt);
        $this->reponse->setTitle('مدیریت مطالب قبل');
        $this->reponse->setTemplate($this->tmpl);

    }

    public function edit()
    {
        Factory::getUser()->authorise("post",  ResponseRegistery::getInstance()->site_id);
        return $this->NewPost();
    }

    public function deletepost()
    {
        //delete script
        $sql = 'DELETE FROM  wb_articles WHERE id=' . $this->input->getInt('id') . ' and weblog_id=' . Session::getInstance()->weblog_id;
        $this->db->execute($sql);
        Response::getInstance()->redirect(ResponseRegistery::getInstance()->baseURL . "/dashboard/post/oldpost");
    }

    public function Tag()
    {
        Factory::getUser()->authorise("tag", ResponseRegistery::getInstance()->site_id);
        $weblog_id = Session::getInstance()->weblog_id;
        $tags = $this->db->SimpleSelect("wb_tags", "*", array('weblog_id' => $weblog_id))->fetchAll();

        $this->tmpl->loadPage("tags");

        $this->tmpl->assign("tags", $tags);

        $oldTag=$this->db->SimpleSelect("wb_tags","*",array('id'=>$this->input->getInt('id'),'weblog_id'=>$weblog_id))->fetch();
        $this->tmpl->assign('oldTag', $oldTag);
        $this->reponse->setTitle('مدیریت موضوعات');
        $this->reponse->setTemplate($this->tmpl);
    }

    public function tagDelete()
    {
        Factory::getUser()->authorise("tag", ResponseRegistery::getInstance()->site_id);
        try
        {
            $sql = 'DELETE FROM  wb_tags WHERE id=' . $this->input->getInt('id') . ' and weblog_id=' . Session::getInstance()->weblog_id;
            $this->db->execute($sql);
        }
        catch(MySQLException $e)
        {
            if($e->getCode()==1451)
            {
                fb($e);
                Messages::getInstance()->logWarning('یک یا چند پست با این موضع وجود دارد ابتدا انها را ویرایش کنید');
            }
            else
            {
                
                throw $e;
            }
            
        }

        $this->reponse->redirect(ResponseRegistery::getInstance()->baseURL."/dashboard/post/Tag");
    }

    public function TagEdit()
    {
        
        $this->tag();
    }

    public function saveTag()
    {
        Factory::getUser()->authorise("tag", ResponseRegistery::getInstance()->site_id);
        $ob = new stdClass;
        $ob->id=$this->input->getInt('id');
        $ob->weblog_id=Session::getInstance()->weblog_id;
        $ob->title=$this->input->getString('title');
	try
	{
	    $this->db->StoreObject("wb_tags", $ob);
	    $this->reponse->redirect(ResponseRegistery::getInstance()->baseURL."/dashboard/post/Tag");
	}
	catch(Exception $e)
	{
	    Messages::getInstance()->logError('پست ذخیره نشد');
	    $this->reponse->redirect(ResponseRegistery::getInstance()->baseURL."/dashboard/post/new");
	}
        
    }


    public function comment()
    {
	Factory::getUser()->authorise("comment", ResponseRegistery::getInstance()->site_id);
        $weblog_id = Session::getInstance()->weblog_id;
        //$tags = $this->db->SimpleSelect("wb_comment", "*", array('artii' => $weblog_id))->fetchAll();
	$sql='SELECT
			    com.*
			FROM wb_comment as com
			JOIN wb_articles as post
			    ON(post.id=com.article_id)
			WHERE post.weblog_id='.$weblog_id;/*.' and
				post.id='.intval($this->input->getInt('id'));*/
	fb($sql);
	$tags=$this->db->query($sql)->fetchAll();
        $this->tmpl->loadPage("comments");

        $this->tmpl->assign("comments", $tags);
        
        $this->reponse->setTitle('مدیریت نظرات');
        $this->reponse->setTemplate($this->tmpl);
    }

    public function commentDelete()
    {
        Factory::getUser()->authorise("comment", ResponseRegistery::getInstance()->site_id);
        try
        {
            $sql = 'DELETE FROM  wb_comment WHERE id=' . $this->input->getInt('id') ;//FIXME. ' and weblog_id=' . Session::getInstance()->weblog_id;
            $this->db->execute($sql);
        }
        catch(MySQLException $e)
        {
            if($e->getCode()==1451)
            {
                fb($e);
                Messages::getInstance()->logWarning('یک یا چند پست با این موضع وجود دارد ابتدا انها را ویرایش کنید');
            }
            else
            {

                throw $e;
            }

        }

        $this->reponse->redirect(ResponseRegistery::getInstance()->baseURL."/dashboard/post/comment");
    }
}
?>
