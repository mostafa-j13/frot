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
class UserService extends Service
{

    function Login()
    {
        $tmpl = new Template( 'empty.tpl' );
        $this->reponse->setTitle( 'ورود کاربران' );

        $tmpl->loadPage( 'login' );
        $ret = base64_decode( $this->input->getString( 'ret' ) );
        if( !$ret )
        {
            $ret = ResponseRegistery::getInstance()->baseURL . "/dashboard/template/show";
        }
        $tmpl->assign( "ret", $ret );
        $this->reponse->setTemplate( $tmpl );
    }

    function newUser()
    {
        $tmp = Template::getInstance( 'frontPage.tpl' );
        $tmp->loadPage( 'signup' );
        Response::getInstance()->setTemplate( $tmp );
    }

    function signup()
    {
        $require_field = array( 'username', 'blogTitle', 'name', 'desc', 'email', 'post_in_page' );
        foreach( $require_field as $field )
        {
            if( !trim( $this->input->getString( $field ) ) )
            {
                fb( $field, 'invalid' );
                Messages::getInstance()->logWarning( 'تمام فیلد‌ها را پرکنید' );
                $this->reponse->redirect( 'newuser' );
                return false;
            }
        }



        if( $this->input->getString( 'password' ) != $this->input->getString( 'password2' ) || !$this->input->getString( 'password' ) )
        {

            fb( 'password invalid' );
            Messages::getInstance()->logWarning( 'پسورد درست نیست' );
            $this->reponse->redirect( 'newuser' );
            return false;
        }

        if( count( $this->db->SimpleSelect( "ge_users", "*", array( 'username' => $this->input->getString( 'username' ) ) ) ) != 0 )
        {
            Messages::getInstance()->logWarning( 'قبلا این نام کاربری ثبت شده است' );
            $this->reponse->redirect( 'newuser' );

            return false;
        }

        //FIXME check subdomain ot exists this one


        $site = new stdClass;
        $site->id = null;
        $site->active = 1;
        $site->template_id = 1;

        $this->db->StoreObject( "ge_sites", $site );
        $site->id = $this->db->insert_id();

        $sub = new stdClass;
        $sub->site_id = $site->id;
        $sub->active = 1;
        $sub->sub_domain = $this->input->getString( 'username' );

        $this->db->StoreObject( "ge_subdomains", $sub );


        $user = new stdClass;
        $user->username = $this->input->getString( 'username' );
        $user->password = Users::hash( $this->input->getString( 'password' ) );
        $user->name = $this->input->getString( 'name' );
        $user->email = $this->input->getString( 'email' );

        $this->db->StoreObject( "ge_users", $user );
        $user->id = $this->db->insert_id();

        $user_site->user_id = $user->id;
        $user_site->site_id = $site->id;

        $this->db->StoreObject( "ge_users_sites", $user_site );

        $blog = new stdClass;
        $blog->site_id = $site->id;
        //  $blog->subject_id=$this->input->getInt('subject_id');
        $blog->subject_id = 1; //FIXME change this
        $blog->title = $this->input->getString( 'blogTitle' );
        $blog->email = $this->input->getString( 'blogEmail' );
        $blog->desc = $this->input->getString( 'desc' );
        $blog->post_in_page = max( $this->input->getInt( 'post_in_page' ), 1 );

        $this->db->StoreObject( "wb_weblogs", $blog );
        $blog->id = $this->db->insert_id();
        $bloger_id = $this->db->SimpleSelect( "ge_rules", "id", array( "title" => 'blogger' ) )->fetch()->id;
        //inja bayad weblo ro query begir ba permission insert konam

        $user_rule = new stdClass;
        $user_rule->user_id = $user->id;
        $user_rule->rule_id = $bloger_id;
        $user_rule->param = $blog->id;
        if( $user_rule->param == 0 )
            throw new EAuthorisation ();
        $this->db->StoreObject( "ge_users_rules", $user_rule );
        Messages::getInstance()->logSuccess( 'وبلاگ شما با موفقیت ثبت شد' );
        $this->reponse->redirect( '../' );
    }

    public function changePassword()
    {
        Factory::getUser()->authorise( 'edituser', Session::getInstance()->weblog_id );
        $tmp = Template::getInstance( 'userDashboard.tpl' );
        $tmp->loadPage( 'changePassword' );
        $this->reponse->setTitle( 'تعویض کلمه عبور' );
        Response::getInstance()->setTemplate( $tmp );
    }

    public function savePassword()
    {
        $user = Factory::getUser();
        $user->authorise( 'edituser', Session::getInstance()->weblog_id );
        $message = Messages::getInstance();
        if( $this->input->getString( 'newpass' ) == $this->input->getString( 'newpass2' ) && $this->input->getString( 'newpass' ) )
        {
            if( $user->changePassword( $this->input->getString( 'oldpass' ), $this->input->getString( 'newpass' ) ) )
            {
                $message->logSuccess( 'پسورد با موفقیت عوض شد' );
            } else
            {
                $message->logWarning( 'کلمه عبور قدیمی اشتباه است' );
            }
        } else
        {
            $message->logWarning( 'کلمه عبور و تکرار آن برابر نیست' );
        }

        $this->reponse->redirect( ResponseRegistery::getInstance()->baseURL . '/user/changePassword' );
    }

    public function logout()
    {
        Factory::getUser()->logout();
        $this->reponse->redirect( ResponseRegistery::getInstance()->baseURL );
    }

}

?>
