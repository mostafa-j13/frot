<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DashboardTemplateService
 *
 * @author mostafa
 */
class DashboardTemplateService extends Service
{

    //put your code here
    public function show()
    {
        Factory::getUser()->authorise( "template", ResponseRegistery::getInstance()->site_id );
        $sql = 'SELECT
                    template.*
                  FROM ge_templates as template
                  JOIN ge_sites  as site
                    ON(site.template_id=template.id)
                  WHERE site.id=' . intval( Session::getInstance()->site_id );
        $template = $this->db->query( $sql )->fetch();
        $tmpl = Template::getInstance( 'userDashboard.tpl' );
        $tmpl->loadPage( 'edit_template' );
        $tmpl->assign( 'template', $template );
        $this->reponse->setTitle( 'ویرایش قالب' );
        $this->reponse->setTemplate( $tmpl );
    }

    public function showList()
    {
        Factory::getUser()->authorise( "template", ResponseRegistery::getInstance()->site_id );
        $db = Factory::getDBO();
        $list = $db->SimpleSelect( "ge_default_templates", "id,image,name" )->fetchAll();
        $tmpl = Template::getInstance( 'userDashboard.tpl' );
        $tmpl->loadPage( 'list_template' );
        $tmpl->assign( 'list', $list );
        $this->reponse->setTitle( 'لیست قالب ها' );
        $this->reponse->setTemplate( $tmpl );
    }

    public function save()
    {
        Factory::getUser()->authorise( "template", ResponseRegistery::getInstance()->site_id );
        $db = Factory::getDBO();
        $def = $db->SimpleSelect( "ge_default_templates", "*", array( 'id' => $this->input->getInt( 'id' ) ) )->fetch();
        $data->main = $def->main;
        $data->id = $this->getWebLogTemplateId();
        $db->StoreObject( "ge_templates", $data );
        //Messages::getInstance()->logSuccess('قالب با موفقیت ذخیره و اعمال شد');
        $msg = Messages::getInstance();
        $msg->logSuccess( 'قالب با موفقیت ذخیره شد' );

        if( $this->compile( $data->main, $data->id ) )
        {
            $msg->logSuccess( 'قالب با موفقیت اعمال شد' );
        } else
        {
            $msg->logError( 'در ساختار قالب خطا وجود دارد لطفا قبل از نمایش وبلاگ این خطاها را بررسی کنید' );
        }

        $this->reponse->redirect( ResponseRegistery::getInstance()->baseURL . "/dashboard/template/show" );
    }

    private function getWebLogTemplateId()
    {
        return intval( $this->db->SimpleSelect( 'ge_sites', 'template_id',
                        array( 'id' => Session::getInstance()->site_id ) )->fetch()->template_id );
    }

    public function saveCode()
    {
        Factory::getUser()->authorise( "template", ResponseRegistery::getInstance()->site_id );

        $db = Factory::getDBO();
        $data->main = $this->input->getString( 'main' );
        $data->id = $this->getWebLogTemplateId();
        $db->StoreObject( "ge_templates", $data );
        //Messages::getInstance()->logSuccess('قالب با موفقیت ذخیره و اعمال شد');
        $msg = Messages::getInstance();
        $msg->logSuccess( 'قالب با موفقیت ذخیره شد' );

        if( $this->compile( $data->main, $data->id ) )
        {
            $msg->logSuccess( 'قالب با موفقیت اعمال شد' );
        } else
        {
            $msg->logError( 'در ساختار قالب خطا وجود دارد لطفا قبل از نمایش وبلاگ این خطاها را بررسی کنید' );
        }

        $this->reponse->redirect( ResponseRegistery::getInstance()->baseURL . "/dashboard/template/show" );
    }

    private function compile( $code, $template_id )
    {
        $str = $code;

        $ptr = array( "#<-(BlogId|BlogUrl|BlogXmlLink|BlogAuthor|BlogEmail|BlogDescription|BlogTitle|BlogArchiveLink|BlogTimeZone|BlogCustomHtml|BlogAndPostTitle|BlogPreviousPageLink|BlogNextPageLink|BlogAbout|BlogProfileLink|BlogPhotoLink|BaseURL)->#" );
        $rep = array( '<?php echo $tmp->\\1; ?>' );
        $str = preg_replace( $ptr, $rep, $str );

        $ptr = array( '#<(BlogProfileLinkBlock|BlogProfile|BlogPhoto|BlogLinksBlock|BlogLinkDumpBlock|BlogCategoriesBlock|BlogAuthorsBlock|BlogPreviousItemsBlock|BlogNextAndPreviousBlock|BlogPreviousPageBlock|BlogNextPageBlock)>(.*?)</\\1>#ims' );
        $rep = array( '<?php if($tmp->\\1):?>\\2<?php endif;?>' );

        $cnt = 0;
        do
        {
            $str = preg_replace( $ptr, $rep, $str, -1, $cnt );
        } while( $cnt != 0 );

        $ptr = array( '#<-(PostTitle|BlogExtendedPost|BlogComment|PostContent|PostDate|PostTime|PostId|PostLink|PostCategoryId|PostCategory|PostAuthorId|PostAuthor|PostAuthorEmail|PostAuthorLink|ArchiveTitle|ArchiveLink|LinkTitle|LinkUrl|LinkDescription|CategoryName|CategoryLink|AuthorName|AuthorLink|)->#' );
        $rep = array( '<?php echo $iterator->\\1; ?>' );
        $str = preg_replace( $ptr, $rep, $str );

        $ptr = array( '#<(BLOG|BlogArchive|BlogLinks|BlogLinkDump|BlogCategories|BlogAuthors|BlogPreviousItems)>(.*?)</\\1>#ims' );
        $rep = array( '<?php foreach($tmp->\\1 as $iterator):?>\\2 <?php endforeach; ?>' );
        $str = preg_replace( $ptr, $rep, $str );

        $str = "<?php if(!defined('__IN_LOADTEMPLATE')) die('illigal access');?>\n\n" . $str;
        file_put_contents( dirname( __FILE__ ) . "/../blogStorage/templates/{$template_id}.php", $str );
        //echo $str;
        return true;
    }

}

?>
